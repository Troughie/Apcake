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
use Illuminate\Support\Facades\URL;

class ShopController extends Controller
{
    public function products()
    {
        $product = Product::where('status', 1)->simplePaginate(9);
        $category = Category::with('products')->get();
        $title_head = 'shop';
        $product_sort = null;
        $product_sortbyName = null;

        if (isset($_GET['sort_by'])) {
            $sort_by = $_GET['sort_by'];
            if ($sort_by == 'giam_dan') {
                $product_sort = Product::with('product_size')->get()->map(function ($product) {
                    return $product->product_size->first();
                })->filter(function ($size) {
                    return $size !== null;
                })->sortByDesc('price');
                $product_sortbyName = null;
            }
            if ($sort_by == 'tang_dan') {
                $product_sort = Product::with('product_size')->get()->map(function ($product) {
                    return $product->product_size->first();
                })->filter(function ($size) {
                    return $size !== null;
                })->sortBy('price');
                $product_sortbyName = null;
            } else if ($sort_by == 'kytu_az') {
                $product_sortbyName = Product::with('product_size')->orderBy('name', 'ASC')->get();
                $product_sort = null;
            }
            if ($sort_by == 'kytu_za') {
                $product_sortbyName = Product::with('product_size')->orderBy('name', 'DESC')->get();
                $product_sort = null;
            }
        }
        return view('frontend.pages.shop', compact('product', 'category', 'title_head', 'product_sort', 'product_sortbyName'))
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
    public function filterPrice(Request $request)
    {
        $filter_by = $request->input('price');
        $product_filter = null;
        $test = null;

        if ($filter_by == 1) {
            $product_filter = Product::with('product_size')->get()->map(function ($product) {
                return $product->product_size->first();
            })->filter(function ($size) {
                return $size !== null;
            })->where('price', '<=', 50000);
            foreach ($product_filter as $item) {
                $test .= '<div class="container">
                            <div class="card" style="border-radius: 30px">
                                <img src="' . URL::to('uploads/products/' . $item->productSize->image) . '" alt="" class="picture"
                                    style="width: 100%;object-fit: cover;image-rendering: pixelated;border-radius: 30px 30px 0 0 ">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between mb-3">
                                        <h5 class="mb-0">' . $item->name . '</h5>
                                    </div>
                                    <input type="hidden" name="pro_id" id="pro_id" value="' . $item->product_id . '">
                                    <div class="d-flex flex-column justify-content-between mb-3">
            
                                        <div class="text-dark mb-0">
                                            <b>' . number_format($item->price) . ' VND</b>
                                        </div>
                                        <div class=" mb-0 mt-2 text-success">In Stock:
                                            <span class="fw-bold">' . $item->instock . '</span>
                                        </div>
            
                                    </div>
            
                                    <div class="d-flex flex-row justify-content-center">
                                        <a class="btn btn-xs btn-primary" href="' . route('products', ['id' => $item->product_id, 'slug' => str($item->name)]) . '">See detail</a>
                                        <button class="btn ml-2 btn-xs whilelist">
                                            <i class="fa fa-heart" class="heart" aria-hidden="true" style="box-shadow: rgba(0, 0, 0, 0.56) 0px 22px 70px 4px;"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>';
            }
        }
        return response()->json(['filterProduct' => $test]);
    }
}
