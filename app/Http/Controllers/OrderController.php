<?php

namespace App\Http\Controllers;

use App\Mail\OrderMail;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Product;
use App\Models\Promotion;
use App\Models\User;
use App\Models\Vnpay;
use DateTime;
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
            $count++;
            $totalPrice += $value->cart_pro->price * $value->quantity;
        }
        return ['totalPrice' => $totalPrice, 'count' => $count];
    }


    public function addCoupon(Request $req)
    {
        $myCoup = Promotion::where('code', $req->input('coupon'))->first();
        $orderCoup = Order::where('promotion_id', $myCoup->promotion_id)->first();
        if (!$myCoup) {
            return response()->json(['coupon_code' => 'Mã giảm giá không hợp lệ']);
        }
        if ($orderCoup) {
            return response()->json(['coupon_code' => 'Mã giảm giá đã được sử dụng']);
        }

        // Kiểm tra xem mã giảm giá đã hết hạn chưa
        if ($myCoup->endDate < now()) {
            return response()->json(['coupon_code' => 'Mã giảm giá đã hết hạn']);
        }

        $user = auth()->user();
        $cart = Cart::where('user_id', $user->id)->get();

        // Tính tổng tiền của giỏ hàng
        $cart_totalprices = $this->totalPrice();
        $cart_totalprice = $cart_totalprices['totalPrice'];
        // Kiểm tra điều kiện áp dụng mã giảm giá
        // if ($cart_total_price < $coupon->min_order_amount) {
        //     return back()->withErrors(['coupon_code' => 'Đơn hàng của bạn chưa đạt yêu cầu tối thiểu để áp dụng mã giảm giá']);
        // }

        // Tính giá tiền mới sau khi áp dụng mã giảm giá
        $discount = $myCoup->discountAmount;
        $new_total_price = $cart_totalprice - $discount;
        $req->session()->put('new_total_price', $new_total_price);
        return response()->json([
            'status' => true, 'data' => $new_total_price,
            'coupon_code' => 'Bạn đã áp dụng mã giảm giá thành công',
            'discount' => $discount,
            'orderCoup' => $orderCoup,
            'promotion_id' => $myCoup->promotion_id,
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

        $pro_qty = $item->cart_pro->quantity;
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
        $total_item = $item_qty *  $item->cart_pro->price;

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
        return view('frontend.pages.checkout.checkout', compact('user', 'cart'));
    }

    public function saveOrder(Request $req, $payment, $status, $promotion_id, $address, $phone, $email, $totalPrice)
    {
        $total = $this->totalPrice();
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




    public function checkOut(Request $req)
    {
        $myCoup = Promotion::where('code', $req->coupon)->first();
        $promotion_id = $myCoup->promotion_id ?? null;
        $total = $this->totalPrice();
        $new_total_price = $req->session()->get('new_total_price');


        $req->validate([
            'fullname' => 'required',
            'address' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'redirect' => 'required',
        ]);
        $name = $req->name;
        $phone = $req->phone;
        $coupon = $req->coupon;
        $address = $req->address;
        $email = $req->email;
        $redirect = $req->redirect;


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
                OrderDetails::create([
                    'order_id' =>  $order->order_id,
                    'product_id' => $value->product_id,
                    'quantity' => $value->quantity,
                    'total' => $value->quantity * $value->cart_pro->price,
                ]);
                $product = Product::where('product_id', $value->product_id)->update([
                    'quantity' => $value->cart_pro->quantity - $value->quantity,
                ]);
            }

            $orders = Order::with('orderDe', 'order_sta')->where('user_id', Auth::id())->get();

            $orderItemss = []; // Khởi tạo mảng trống
            foreach ($orders as $value) {

                if (!empty($value)) {
                    array_push($orderItemss, $value);
                }
            }
            Cart::where('user_id', Auth::id())->delete();

            $orderItems = end($orderItemss);
            Mail::to($req->email)->send(new OrderMail(
                $orderItems,
                $name,
                $phone,
                $coupon,
                $address,
                $redirect,
            ));
            return redirect()->back()->with('orderSuccess', 'Cam on ban da mua hang chung toi se lien he voi ban de xac nhan don hang');
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
                OrderDetails::create([
                    'order_id' =>  $order->order_id,
                    'product_id' => $value->product_id,
                    'quantity' => $value->quantity,
                    'total' => $value->quantity * $value->cart_pro->price,
                ]);
                $product = Product::where('product_id', $value->product_id)->update([
                    'quantity' => $value->cart_pro->quantity - $value->quantity,
                ]);
            }

            $orders = Order::with('orderDe', 'order_sta')->where('user_id', Auth::id())->get();

            $orderItemss = []; // Khởi tạo mảng trống
            foreach ($orders as $value) {

                if (!empty($value)) {
                    array_push($orderItemss, $value);
                }
            }
            Cart::where('user_id', Auth::id())->delete();

            $orderItems = end($orderItemss);
            Mail::to($req->email)->send(new OrderMail(
                $orderItems,
                $name,
                $phone,
                $coupon,
                $address,
                $redirect,
            ));

            $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
            $vnp_Returnurl = "http://127.0.0.1:8000/checkout";
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
