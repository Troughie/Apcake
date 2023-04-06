<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Size;
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
        $size_id = $req->input('size_id');
        $validator = Validator::make($req->all(), [
            'pro_size' => 'required'
        ]);
        $product = Size::where('product_id', $product_id)->where('size_id', $size_id)->first();
        if ($product_qty > $product->instock) {
            return response()->json(['fail_qty' => 'Số lượng sản phẩm quá lớn', 'pro_stock' => $product->quantity]);
        }
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all(), 'size' => $product_size]);
        }

        $cartItem = Cart::where('product_id', $product_id)->where('user_id', Auth::id())->first();
        if (Auth::check()) {

            $pro_check = Product::where('product_id', $product_id)->first();
            if ($pro_check) {
                if ($cartItem && $cartItem->size == $product_size) {
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
                    return response()->json(['status' => $pro_check->name . ' đã thêm thành công']);
                }
            }
        } else {
            $login = true;
            return response()->json(['status' => 'Bạn phải đăng nhập', 'data' => $login]);
        }
    }



    public function showCart(Request $req)
    {
        $cart = Cart::where('user_id', Auth::id())->get();
        $title_head = 'cart';
        $new_total_price = $req->session()->get('new_total_price');
        $pro_price = null;
        $price_item = array();
        if (true) {
            $pro_price = Product::with('product_size')->get()->map(function ($product) {
                return $product->product_size->first();
            })->filter(function ($size) {
                return $size !== null;
            });
        }
        return view('frontend.pages.shopping-cart', compact('title_head', 'cart', 'new_total_price', 'price_item'));
    }

    public function getSize(Request $req)
    {
        $size = $req->input('size');
        $pro_id = $req->input('pro_id');

        $product_size = Size::with('productSize')->where('product_id', $pro_id)->where('size', $size)->first();

        return response()->json(['status' => 'success', 'product_size' => $product_size]);
    }
}
