<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function addCart(Request $req)
    {
        $product_id = $req->input('pro_id');
        $product_qty = $req->input('pro_qty');
        $product_size = $req->input('pro_size');
        $validator = Validator::make($req->all(), [
            'pro_size' => 'required'
        ]);
        $product = Product::where('product_id', $product_id)->first();
        if ($product_qty > $product->quantity) {
            return response()->json(['fail_qty' => 'Số lượng sản phẩm quá lớn', 'pro_stock' => $product->quantity]);
        }
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all(), 'size' => $product_size]);
        }

        $cartItem = Cart::where('product_id', $product_id)->where('user_id', Auth::id())->first();
        if (Auth::check()) {

            $pro_check = Product::where('product_id', $product_id)->first();
            if ($pro_check) {

                if ($cartItem) {
                    $cartItem->quantity += $product_qty;
                    $cartItem->save();
                    return response()->json(['status' => $pro_check->name . 'đã thêm thành công']);
                } else {
                    $cartItem = new Cart();
                    $cartItem->product_id = $product_id;
                    $cartItem->user_id = Auth::id();
                    $cartItem->quantity = $product_qty;
                    $cartItem->size = $product_size;
                    $cartItem->save();
                    return response()->json(['status' => $pro_check->name . 'đã thêm thành công']);
                }
            }
        } else {
            $login = true;
            return response()->json(['status' => 'Bạn phải đăng nhập', 'data' => $login]);
        }
    }



    public function showCart(Request $req)
    {
        $cart = Cart::all();
        $title_head = 'cart';
        $new_total_price = $req->session()->get('new_total_price');
        return view('frontend.pages.shopping-cart', compact('title_head', 'cart', 'new_total_price'));
    }
}
