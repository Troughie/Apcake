<?php

namespace App\Http\Controllers;

use App\Mail\OrderMail;
use App\Models\Cart;
use App\Models\DeliveryAddress;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Product;
use App\Models\Promotion;
use App\Models\Province;
use App\Models\Size;
use App\Models\User;
use App\Models\Vnpay;
use DateTime;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class OrderController extends Controller
{
    public function totalPrice()
    {
        $cart = Cart::with('cart_pro')->where('user_id', Auth::id())->get();
        $totalPrice = 0;
        $count = 0;
        foreach ($cart as $key => $value) {
            $pro_size = Size::where('product_id', $value->cart_pro->product_id)->where('size', $value->size)->first();
            $count++;
            $totalPrice += $pro_size->price * $value->quantity;
        }
        return ['totalPrice' => $totalPrice, 'count' => $count];
    }


    public function removeCoup(Request $req)
    {

        $cart_totalprices = $this->totalPrice();

        $cart_totalprice = $cart_totalprices['totalPrice'];
        $req->session()->put('new_total_price', $cart_totalprice);
        return response()->json(['counpon_code' => 'Đã xoá mã giảm giá thành công', 'cart_total' => $cart_totalprice]);
    }

    public function addCoupon(Request $req)
    {
        $user = auth()->user();
        $cart = Cart::where('user_id', $user->id)->get();

        // Tính tổng tiền của giỏ hàng
        $cart_totalprices = $this->totalPrice();
        $cart_totalprice = $cart_totalprices['totalPrice'];
        $myCoup = Promotion::where('code', $req->input('coupon'))->first();
        //Kiểm tra mã giảm giá có tồn tại không
        if (!$myCoup) {
            return response()->json(['coupon_code' => 'Mã giảm giá không hợp lệ']);
        }
        $orderCoup = Order::where('promotion_id', $myCoup->promotion_id)->where('user_id', Auth::id())->first();

        // Kiểm tra xem mã giảm giá đã hết hạn chưa
        if ($myCoup->endDate < now() || $myCoup->discountQuantity < 1) {
            return response()->json(['coupon_code' => 'Mã giảm giá đã hết ,hãy điền mã giảm giá khác']);
        }

        // Kiểm tra điều kiện áp dụng mã giảm giá
        if ($cart_totalprice < $myCoup->minprice) {
            return response()->json(['coupon_code' => 'Đơn hàng của bạn chưa đạt yêu cầu tối thiểu để áp dụng mã giảm giá là' . ' ' . $myCoup->minprice . ' ' . 'VND']);
        }



        if ($orderCoup && $myCoup->status == 'one') {
            return response()->json(['coupon_code' => 'Bạn đã sử dụng mã giảm giá này rồi']);
        } else if ($orderCoup && $myCoup->status == 'many') {
            $discount = $myCoup->discountAmount;
            $discount1 =  ($cart_totalprice * $discount) / 100;
            $new_total_price = $cart_totalprice - $discount1;
            $req->session()->put('new_total_price', $new_total_price);
            return response()->json([
                'status' => true, 'data' => $new_total_price,
                'coupon_code' => 'Bạn đã áp dụng mã giảm giá thành công',
                'discount' => $discount1,
                'orderCoup' => $orderCoup,
                'promotion_id' => $myCoup->promotion_id,
                'coupon' => $req->input('coupon'),
            ]);
        }

        // Tính giá tiền mới sau khi áp dụng mã giảm giá
        $discount = $myCoup->discountAmount;
        $discount1 =  ($cart_totalprice * $discount) / 100;
        $new_total_price = $cart_totalprice - $discount1;
        $req->session()->put('new_total_price', $new_total_price);
        return response()->json([
            'status' => true, 'data' => $new_total_price,
            'coupon_code' => 'Bạn đã áp dụng mã giảm giá thành công',
            'discount' => $discount1,
            'orderCoup' => $orderCoup,
            'promotion_id' => $myCoup->promotion_id,
            'coupon' => $req->input('coupon'),
        ]);
    }



    public function updateQty(Request $req)
    {
        $item_qty = $req->input('item_qty');
        $pro_id = $req->input('pro_id');
        $item = Cart::with('cart_pro')
            ->where('product_id', $pro_id)
            ->where('user_id', Auth::id())
            ->first();
        $pro_size = Size::where('product_id', $pro_id)->where('size', $item->size)->first();
        $pro_qty = $pro_size->instock;
        if ($item_qty > $pro_qty) {
            $qtyF = $item->quantity;
            return response()->json([
                'status' => true,
                'message' => 'Product stock is available',
                'qtyF' => $qtyF,

            ]);
        }
        Cart::where('product_id', $pro_id)
            ->where('user_id', Auth::id())->update(['quantity' => $item_qty]);
        $totalPrices = $this->totalPrice();
        $totalPrice = $totalPrices['totalPrice'];
        $total_item = $item_qty *  $pro_size->price;

        return response()->json(['success' => ' Cap nhat thanh cong', 'total_item' => $total_item, 'totalPrice' => $totalPrice]);
    }

    public function delItem(String $id)
    {
        Cart::destroy($id);
        return redirect()->back()->with('update', 'cap nhat gio hang thanh cong');
    }

    public function showCheckOut(Request $req)
    {
        // get user and cart info
        $user = User::with('deliveryAddress')->where('user_id', Auth::id())->first();
        $cart = Cart::with('cart_pro')->where('user_id', Auth::id())->get();

        //lay category_id cua cart
        $cart2 = Cart::with('cart_pro.category')->where('user_id', Auth::id())->get()->map(function ($e) {
            return $e->cart_pro->category->category_id;
        })->unique()->toArray();


        $addressuser = DeliveryAddress::where('user_id', Auth::id())->get();
        $address = Province::with('district', 'ward')->get();


        //Lấy promotion_id đã sử dụng trong order
        $order = Order::where('user_id', Auth::id())
            ->whereNotNull('promotion_id')
            ->pluck('promotion_id')
            ->unique()
            ->toArray();
        $totalPrice = $this->totalPrice();
        $totalPricee2 = $totalPrice['totalPrice'];
        $a = [];
        //Lấy ra những promotion có thể sử dụng
        $promotions = Promotion::where('endDate', '>', Carbon::now())
            ->where('startDate', '<', Carbon::now())
            ->where('discountQuantity', '>', '0')
            ->when($totalPricee2, function ($e) use ($totalPricee2) {
                return $e->where('minprice', '<', $totalPricee2);
            })
            ->where(function ($query) use ($cart2, $order, $totalPricee2) {
                $query->whereNull('product_id')
                    ->orWhereIn('product_id', $cart2);
            })
            ->whereNotIn('promotion_id', $order)
            ->orWhere(function ($e) use ($order, $totalPricee2, $cart2) {
                $e->whereIn('promotion_id', $order)
                    ->where('minprice', '<', $totalPricee2)
                    ->wherenot('status', 'one');
            })
            ->get()
            ->toArray();

        ///Lấy ra những id của promotion có thể sử dụng
        $promotions_id = Promotion::where('endDate', '>', Carbon::now())
            ->where('startDate', '<', Carbon::now())
            ->where('discountQuantity', '>', '0')
            ->when($totalPricee2, function ($e) use ($totalPricee2) {
                return $e->where('minprice', '<', $totalPricee2);
            })
            ->where(function ($query) use ($cart2, $order, $totalPricee2) {
                $query->whereNull('product_id')
                    ->orWhereIn('product_id', $cart2);
            })
            ->whereNotIn('promotion_id', $order)
            ->orWhere(function ($e) use ($order, $totalPricee2, $cart2) {
                $e->whereIn('promotion_id', $order)
                    ->where('minprice', '<', $totalPricee2)
                    ->wherenot('status', 'one');
            })
            ->get('promotion_id')->map(function ($e) {
                return $e->promotion_id;
            })
            ->toArray();

        $promotionAll = Promotion::get('promotion_id')->map(function ($e) {
            return $e->promotion_id;
        })->toArray();
        $promotion_cant_use_id = array_diff($promotionAll, $promotions_id);

        $promotion_cant_use = Promotion::whereIn('promotion_id', $promotion_cant_use_id)->get()->toArray();
        // check if payment was successful
        if (isset($_GET['vnp_Amount'])) {
            $data = [
                'Amount' => $_GET['vnp_Amount'] / 100,
                'order_id' => $_GET['vnp_TxnRef'],
                'OrderInfo' => $_GET['vnp_OrderInfo'],
                'BankCode' => $_GET['vnp_BankCode'],
                'updated_at' => DB::raw('CURRENT_TIMESTAMP'),
                'created_at' => DB::raw('CURRENT_TIMESTAMP'),

            ];
            Vnpay::create($data);
        }

        // display checkout page with user and cart info
        return view('frontend.pages.checkout.checkout', compact('user', 'cart', 'address', 'addressuser', 'promotions', 'promotion_cant_use'));
    }

    public function saveOrder(Request $req, $payment, $status, $promotion_id, $address, $phone, $email, $totalPrice)
    {
        $total = $this->totalPrice();
        $req->validate([
            'phone' => 'min:9|max:12'
        ]);
        $order = new Order;
        $order->user_id = Auth::id();
        $order->order_date = DB::raw('CURRENT_TIMESTAMP');
        $order->totalAmount = $totalPrice;
        $order->status_id = $status;
        $order->promotion_id = $promotion_id;
        $order->quantity = $total['count'];
        $order->payment_id = $payment;
        $order->address = $address;
        $order->phone = $phone;
        $order->email = $email;
        $order->save();

        return $order;
    }


    public function thanks()
    {
        return view('frontend.pages.checkout.thanks');
    }

    public function Code()
    {
        do {
            $code = random_int(100000, 999999);
        } while (DeliveryAddress::where('_token', $code)->first());
        return $code;
    }

    public function checkOut(Request $req)
    {
        $myCoup = Promotion::where('code', $req->coupon)->first();
        $promotion_id = $myCoup->promotion_id ?? null;
        $total = $this->totalPrice();
        $new_total_price = $req->session()->get('new_total_price');
        $code = $this->code();
        $req->validate([
            'email' => 'required|email',
            'phone' => 'required|min:9|max:13',
            'redirect' => 'required',
        ], [
            'email.email' => 'Email của bạn phải có dang xxx@xxx.xx',
            'phone.min' => 'Số điện thoại phải có trên 9 ký tự',
            'phone.max' => 'Số điện thoại phải có  13 ký tự',
            'redirect.required' => 'Phải chọn thông tin thanh toán',
        ]);
        $name = $req->fullname;
        $phone = $req->phone;
        $coupon = $req->coupon;
        $address = implode(',', [$req->wards, $req->district, $req->province]);
        $email = $req->email;
        $redirect = $req->redirect;
        $saveinfo = $req->saveinfo;;
        $coupon = $req->coupon;
        $myCoup = Promotion::where('code', $coupon)->first();
        $cart = Cart::with('cart_pro')->where('user_id', Auth::id())->get();


        if ($redirect == 'cod') {
            $payment = 1;
            $status = 4;
            if (isset($new_total_price)) {
                $order = $this->saveOrder($req, $payment, $status, $promotion_id, $address, $phone, $email, $new_total_price);
            } else {
                $order = $this->saveOrder($req, $payment, $status, $promotion_id, $address, $phone, $email, $total['totalPrice']);
            }
            $req->session()->forget('new_total_price');
            foreach ($cart as $key => $value) {
                $pro_size = Size::where('product_id', $value->cart_pro->product_id)->where('size', $value->size)->first();
                OrderDetails::create([
                    'order_id' =>  $order->order_id,
                    'product_id' => $value->product_id,
                    'quantity' => $value->quantity,
                    'total' => $value->quantity * $pro_size->price,
                    'size' => $value->size
                ]);
                if ($pro_size->instock > 0 && $pro_size->instock == $value->quantity) {
                    Size::where('product_id', $value->product_id)->where('size', $pro_size->size)->update([
                        'instock' => $pro_size->instock - $value->quantity,
                    ]);
                }
            }
            if ($myCoup) {
                $myCoup->discountQuantity = $myCoup->discountQuantity - 1;
            }
            $orders = Order::with('orderDe', 'order_sta', 'orderDe.order_pro')->where('user_id', Auth::id())->get();

            $orderItemss = []; // Khởi tạo mảng trống
            foreach ($orders as $value) {

                if (!empty($value)) {
                    array_push($orderItemss, $value);
                }
            }

            $orderItems = end($orderItemss);
            Mail::to($req->email)->send(new OrderMail(
                $orderItems,
                $name,
                $phone,
                $email,
                $coupon,
                $address,
                $redirect,
            ));
            Cart::where('user_id', Auth::id())->delete();
            if ($saveinfo == 'yes') {
                DeliveryAddress::create([
                    'user_id' => Auth::id(),
                    'fullname' => $name, 'phone' => $phone,
                    'address' => $address,
                    'province' => $req->province, 'district' => $req->district, 'ward' => $req->wards,
                    '_token' => $code,
                    'emailladd' => $req->email
                ]);
            }
            return redirect()->back()->with('orderSuccess', 'Cảm ơn bạn đã mua hàng');
        } elseif ($redirect == 'vnpay') {

            $payment = 2;
            $status = 2;
            if (isset($new_total_price)) {
                $order = $this->saveOrder($req, $payment, $status, $promotion_id, $address, $phone, $email, $new_total_price);
            } else {
                $order = $this->saveOrder($req, $payment, $status, $promotion_id, $address, $phone, $email, $total['totalPrice']);
            }
            $req->session()->forget('new_total_price');
            foreach ($cart as $key => $value) {
                $pro_size = Size::where('product_id', $value->cart_pro->product_id)->where('size', $value->size)->first();
                OrderDetails::create([
                    'order_id' =>  $order->order_id,
                    'product_id' => $value->product_id,
                    'quantity' => $value->quantity,
                    'total' => $value->quantity * $pro_size->price,
                    'size' => $value->size
                ]);
                if ($pro_size->instock > 0 && $pro_size->instock == $value->quantity) {
                    Size::where('product_id', $value->product_id)->where('size', $pro_size->size)->update([
                        'instock' => $pro_size->instock - $value->quantity,
                    ]);
                }
            }
            if ($myCoup) {
                $myCoup->discountQuantity = $myCoup->discountQuantity - 1;
            }
            $orders = Order::with('orderDe', 'order_sta')->where('user_id', Auth::id())->get();

            $orderItemss = []; // Khởi tạo mảng trống
            foreach ($orders as $value) {

                if (!empty($value)) {
                    array_push($orderItemss, $value);
                }
            }

            $orderItems = end($orderItemss);
            Mail::to($req->email)->send(new OrderMail(
                $orderItems,
                $name,
                $email,
                $phone,
                $coupon,
                $address,
                $redirect,
            ));
            Cart::where('user_id', Auth::id())->delete();

            $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
            $vnp_Returnurl = "http://127.0.0.1:8000/thanks";
            $vnp_TmnCode = "SIHMN6Y8"; //Mã website tại VNPAY 
            $vnp_HashSecret = "WXLPPUMGAAMSKXISDNRPJMVWQTTVGKPU"; //Chuỗi bí mật

            $vnp_TxnRef = $order->order_id; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này 
            $vnp_OrderInfo = 'Thanh toan don hang apcake';
            $vnp_OrderType = 'billingpayment';
            if (isset($new_total_price)) {
                $vnp_Amount = $new_total_price * 100;
            } else {
                $vnp_Amount = $total['totalPrice'] * 100;
            }
            $vnp_Locale = 'vn';
            $vnp_BankCode = 'NCB';
            $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
            $inputData = array(
                "vnp_Version" => "2.1.0",
                "vnp_TmnCode" => $vnp_TmnCode,
                "vnp_Amount" => $vnp_Amount,
                "vnp_Command" => "pay",
                "vnp_CreateDate" => date('YmdHis'),
                "vnp_CurrCode" => "VND",
                "vnp_IpAddr" => $vnp_IpAddr,
                "vnp_Locale" => $vnp_Locale,
                "vnp_OrderInfo" => $vnp_OrderInfo,
                "vnp_OrderType" => $vnp_OrderType,
                "vnp_ReturnUrl" => $vnp_Returnurl,
                "vnp_TxnRef" => $vnp_TxnRef,
            );

            if (isset($vnp_BankCode) && $vnp_BankCode != "") {
                $inputData['vnp_BankCode'] = $vnp_BankCode;
            }

            //var_dump($inputData);
            ksort($inputData);
            $query = "";
            $i = 0;
            $hashdata = "";
            foreach ($inputData as $key => $value) {
                if ($i == 1) {
                    $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                } else {
                    $hashdata .= urlencode($key) . "=" . urlencode($value);
                    $i = 1;
                }
                $query .= urlencode($key) . "=" . urlencode($value) . '&';
            }

            $vnp_Url = $vnp_Url . "?" . $query;
            if (isset($vnp_HashSecret)) {
                $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //  
                $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
            }
            $returnData = array(
                'code' => '00', 'message' => 'success', 'data' => $vnp_Url
            );
            if (isset($_POST['redirect'])) {
                header('Location: ' . $vnp_Url);
                die();
            } else {
                echo json_encode($returnData);
            }
            $req->session()->forget('new_total_price');
        }
    }
}
