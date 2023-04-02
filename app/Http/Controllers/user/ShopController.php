<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    public function products()
    {
        $product = Product::simplePaginate(9);
        $category = Category::with('products')->get();
        $title_head = 'shop';
        return view('frontend.pages.shop ', compact('product', 'category', 'title_head'))
            ->with('i', (request()->input('page', 1) - 1) * 9);
    }

    public function productDetail(String $id)
    {
        $procom2 = 0;
        $procom = 0;
        $product = Product::find($id);
        $order =   Order::with('orderDe', 'order_sta', 'orderDe.order_pro')->where('user_id', Auth::id())->get();
        $orderdetails =  [];
        foreach ($order as $item) {
            $orderdetail = OrderDetails::with('order_pro', 'order')->where('order_id', $item->order_id)->where('product_id', $id)->first();
            array_push($orderdetails, $orderdetail);
        }

        $arr_filtered = array_filter($orderdetails, function ($item) {
            return !is_null($item) && $item !== 0 && $item !== '';
        });
        $reviewUser = Review::with('user_review')->where('product_id', $id)->where('user_id', Auth::id())->get();
        foreach ($orderdetails as $key => $orderde) {
            foreach ($reviewUser as $key => $review) {
                if (isset($orderde->product_id)) {
                    if ($orderde->product_id == $review->product_id && $orderde->order->user_id == $review->user_id) {
                        $procom++;
                    } else {
                        $procom2++;
                    }
                }
            }
        }
        $review = Review::with('user_review', 'feedback')->where('product_id', $id)->get();
        $reviewShow = Review::where('status', 'Show')->where('product_id', $id)->get();
        $title_head = $product->name;
        return view('frontend.pages.products ', compact('title_head', 'product', 'review', 'arr_filtered', 'procom', 'procom2', 'reviewUser', 'reviewShow'));
    }


    public function getSize(Request $req)
    {
        $size = $req->input('size');
        $pro_id = $req->input('pro_id');

        return response()->json(['status' => 'success', 'size' => $size, 'pro_id' => $pro_id]);
    }
}
