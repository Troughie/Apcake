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
        $product_sort = null;

        if (isset($_GET['sort_by'])) {
            $sort_by = $_GET['sort_by'];
            if ($sort_by == 'giam_dan') {
                $product_sort = Product::with('product_size')->get()->map(function ($product) {
                    return $product->product_size->first();
                })->filter(function ($size) {
                    return $size !== null;
                })->sortByDesc('price');
            }
            if ($sort_by == 'tang_dan') {
                $product_sort = Product::with('product_size')->get()->map(function ($product) {
                    return $product->product_size->first();
                })->filter(function ($size) {
                    return $size !== null;
                })->sortBy('price');
            }
        }
        return view('frontend.pages.shop ', compact('product', 'category', 'title_head', 'product_sort'))
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
        $review = Review::with('user_review', 'feedback')->where('product_id', $id)->get();
        $reviewShow = Review::where('status', 'Show')->where('product_id', $id)->get();
        $title_head = $product->name;
        return view('frontend.pages.products ', compact('title_head', 'product', 'review', 'arr_filtered', 'reviewShow'));
    }



    public function addwList(Request $req)
    {
        $pro_id = $req->input('pro_id');
        $user = Auth::check();
        return response()->json(['status' => 'aaaa', 'user' => $user, 'pro_id' => $pro_id]);
    }

    public function getSize(Request $req)
    {
        $size = 'aaaaa';
        $pro_id = $req->input('pro_id');

        // $product_size = Product::with('')->where('product_id', $pro_id)->first();

        return response()->json(['status' => 'success', 'size' => $size, 'pro_id' => $pro_id]);
    }
}
