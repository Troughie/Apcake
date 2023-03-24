<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function addCart(Request $req)
    {
        $product_id = $req->input('pro_id');
        $product_qty = $req->input('pro_qty');
        $cartItem = Cart::where('product_id', $product_id)->where('user_id', Auth::id())->first();
        if (Auth::check()) {

            $pro_check = Product::where('product_id', $product_id)->first();
            if ($pro_check) {

                if ($cartItem) {
                    $cartItem->quantity += $product_qty;
                    $cartItem->save();
                    return response()->json(['status' => $pro_check->name . 'added to cart']);
                } else {
                    $cartItem = new Cart();
                    $cartItem->product_id = $product_id;
                    $cartItem->user_id = Auth::id();
                    $cartItem->quantity = $product_qty;
                    $cartItem->save();
                    return response()->json(['status' => $pro_check->name . ' added to cart']);
                }
            }
        } else {
            $login = true;
            return response()->json(['status' => 'You must login', 'data' => $login]);
        }
    }



    public function showCart()
    {
        $cart = Cart::with('cart_pro')->get();
        dd($cart->cart_pro);
        exit();

        $title_head = 'home';
        return view('frontend.pages.index', compact('title_head', 'cart'));
    }
}
