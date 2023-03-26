<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Promotion;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        return $totalPrice;
    }
    public function appCoupon(Request $req)
    {
        $coupon = Promotion::all();
        $myCoup = Promotion::where('code', $req->coupon)->first();
        if (!$myCoup) {
            return back()->withErrors(['coupon_code' => 'Mã giảm giá không hợp lệ']);
        }

        // Kiểm tra xem mã giảm giá đã hết hạn chưa
        if ($myCoup->endDate < now()) {
            return back()->withErrors(['coupon_code' => 'Mã giảm giá đã hết hạn']);
        }
        $user = auth()->user();
        $cart = Cart::where('user_id', $user->id)->get();

        // Tính tổng tiền của giỏ hàng
        $cart_totalprice = $this->totalPrice();

        // Kiểm tra điều kiện áp dụng mã giảm giá
        // if ($cart_total_price < $coupon->min_order_amount) {
        //     return back()->withErrors(['coupon_code' => 'Đơn hàng của bạn chưa đạt yêu cầu tối thiểu để áp dụng mã giảm giá']);
        // }

        // Tính giá tiền mới sau khi áp dụng mã giảm giá
        $discount = $myCoup->discountAmount;
        $new_total_price = $cart_totalprice - $discount;
        $req->session()->put('new_total_price', $new_total_price);
        return redirect()->back()->with(
            'success',
            'Áp dụng mã giảm giá thành công'
        );
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
        $totalPrice = $this->totalPrice();
        $total_item = $item_qty *  $item->cart_pro->price;

        return response()->json(['success' => ' Cap nhat thanh cong', 'total_item' => $total_item, 'totalPrice' => $totalPrice]);
    }

    public function delItem(String $id)
    {
        Cart::destroy($id);
        return redirect()->back()->with('update', 'cap nhat gio hang thanh cong');
    }

    public function checkOut()
    {
        $user = User::with('deliveryAddress')->where('user_id', Auth::id())->first();
        $cart = Cart::with('cart_pro')->where('user_id', Auth::id())->get();
        return view('frontend.pages.checkout', compact('user', 'cart'));
    }
}
