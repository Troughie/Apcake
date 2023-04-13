<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Favorite;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Product;
use App\Models\Review;
use App\Models\Size;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $reviewShow = [];
        $favorites = [];
        //Sản phẩm yêu thích
        foreach ($product as $key => $value) {
            $favorites[$value->product_id] = Favorite::where('user_id', Auth::id())->where('product_id', $value->product_id)->first();
        }
        //loc
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
        //Sản phẩm bán chạy
        $order_detail = DB::table('order_details')->select(DB::raw('count(*) as sll, product_id'))->groupBy('product_id')->orderByDesc('sll')->limit(10)
            ->get();
        $pro_id = $order_detail->pluck('product_id');
        $pro_buy =  Product::with('product_review')->whereIn('product_id', $pro_id)->limit(6)->get();

        $review =  Review::with('product_comment')->whereIn('product_id', $pro_id)->get();
        foreach ($pro_buy as $key => $value) {
            foreach ($review as $key => $value2) {
                if ($value->product_id == $value2->product_id) {
                    $reviewShow[$value->name] = [$review->avg('rating'), $value2->product_id];
                }
            }
        }

        return view('frontend.pages.shop', compact('product', 'category', 'title_head', 'product_sort', 'product_sortbyName', 'pro_buy', 'reviewShow', 'favorites'))
            ->with('i', (request()->input('page', 1) - 1) * 9);
    }

    public function productDetail(string $id)
    {
        $product = Size::with('productSize')->where('product_id', $id)->get();
        $order = Order::with('orderDe', 'order_sta', 'orderDe.order_pro')->where('user_id', Auth::id())->get()->toArray();
        //tìm những order_detail của người dùng
        $orderdetails = [];
        if (is_array($order)) {
            foreach ($order as $item) {
                $orderdetail = OrderDetails::with('order_pro', 'order')->where('order_id', $item['order_id'])->where('product_id', $id)->first();
                array_push($orderdetails, $orderdetail);
            }
        } else if (count($order) !== 0) {
            $orderdetail = OrderDetails::with('order_pro', 'order')->where('order_id', end($order)['order_id'])->where('product_id', $id)->first();
            array_push($orderdetails, $orderdetail);
        }
        $arr_filtered = array_filter($orderdetails, function ($item) {
            return !is_null($item) && $item !== 0 && $item !== '';
        });

        //Lấy những order có status !== 4
        $orderCollection = collect($order);
        $statusId = $orderCollection->pluck('status_id')->toArray();
        $a = [4];

        $pro__4 = array_diff($statusId, $a);

        $review = Review::with('user_review', 'feedback')->where('product_id', $id)->get();
        $reviewShow = Review::where('status', 'Show')->where('product_id', $id)->get();
        $title_head = $product[0]->productSize->name;

        $category = Product::with('category')->find($id);
        $cate_id = $category->category->category_id;

        $product_similar = Category::with('products')->where('category_id', $cate_id)->first();

        return view('frontend.pages.products ', compact('title_head', 'product', 'review', 'orderdetails', 'arr_filtered', 'reviewShow', 'product_similar', 'category', 'pro__4'));
    }



    public function addwList(Request $req)
    {
        $pro_id = $req->input('pro_id');
        $user = Auth::check();
        if (Auth::check()) {
            Favorite::create([
                'user_id' => Auth::id(),
                'product_id' => $pro_id
            ]);
            return response()->json(['status' => 'aaaa', 'user' => $user, 'pro_id' => $pro_id]);
        } else {
            return response()->json(['status' => 'aaaa', 'user' => $user, 'pro_id' => $pro_id]);
        }
    }


    public function filterPrice(Request $request)
    {
        $filter_by = $request->input('price');
        $product_filter = null;
        $test = null;
        if ($filter_by == 0) {
            $product_filter = Product::with('product_size')->get()->map(function ($product) {
                return $product->product_size->first();
            })->filter(function ($size) {
                return $size !== null;
            });
            foreach ($product_filter as $item) {
                $test .= '<div class="container">
                            <div class="card" style="border-radius: 30px">
                                <img src="' . URL::to('uploads/products/' . $item->productSize->image) . '" class="picture"
                                    style="width: 100%;object-fit: cover;image-rendering: pixelated;border-radius: 30px 30px 0 0 ">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between mb-3">
                                        <h5 class="mb-0">' . $item->productSize->name . '</h5>
                                    </div>
                                    <input type="hidden" name="pro_id" id="pro_id" value="' . $item->productSize->product_id . '">
                                    <div class="d-flex flex-column justify-content-between mb-3">
                                        <div class="text-dark mb-0">
                                            <b>' . number_format($item->price) . ' VND</b>
                                        </div>
                                        <div class=" mb-0 mt-2 text-success">In Stock:
                                            <span class="fw-bold">' . $item->instock . '</span>
                                        </div>
            
                                    </div>
            
                                    <div class="d-flex flex-row justify-content-center">
                                        <a class="btn btn-xs btn-primary" href="' . route('products', ['id' => $item->productSize->product_id, 'slug' => str($item->productSize->name)]) . '">See detail</a>
                                        <button class="btn ml-2 btn-xs whilelist">
                                            <i class="fa fa-heart" class="heart" aria-hidden="true" style="box-shadow: rgba(0, 0, 0, 0.56) 0px 22px 70px 4px;"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>';
            }
        }
        if ($filter_by == 1) {
            $product_filter = Product::with('product_size')->get()->map(function ($product) {
                return $product->product_size->first();
            })->filter(function ($size) {
                return $size !== null;
            })->where('price', '<', 50000)->sortBy('price');
            foreach ($product_filter as $item) {
                $test .= '<div class="container">
                            <div class="card" style="border-radius: 30px">
                                <img src="' . URL::to('uploads/products/' . $item->productSize->image) . '" class="picture"
                                    style="width: 100%;object-fit: cover;image-rendering: pixelated;border-radius: 30px 30px 0 0 ">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between mb-3">
                                        <h5 class="mb-0">' . $item->productSize->name . '</h5>
                                    </div>
                                    <input type="hidden" name="pro_id" id="pro_id" value="' . $item->productSize->product_id . '">
                                    <div class="d-flex flex-column justify-content-between mb-3">
                                        <div class="text-dark mb-0">
                                            <b>' . number_format($item->price) . ' VND</b>
                                        </div>
                                        <div class=" mb-0 mt-2 text-success">In Stock:
                                            <span class="fw-bold">' . $item->instock . '</span>
                                        </div>
            
                                    </div>
            
                                    <div class="d-flex flex-row justify-content-center">
                                        <a class="btn btn-xs btn-primary" href="' . route('products', ['id' => $item->productSize->product_id, 'slug' => str($item->productSize->name)]) . '">See detail</a>
                                        <button class="btn ml-2 btn-xs whilelist">
                                            <i class="fa fa-heart" class="heart" aria-hidden="true" style="box-shadow: rgba(0, 0, 0, 0.56) 0px 22px 70px 4px;"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>';
            }
        }
        if ($filter_by == 2) {
            $product_filter = Product::with('product_size')->get()->map(function ($product) {
                return $product->product_size->first();
            })->filter(function ($size) {
                return $size !== null;
            })->where('price', '>=', 50000)->where('price', '<', 100000)->sortBy('price');
            foreach ($product_filter as $item) {
                $test .= '<div class="container">
                            <div class="card" style="border-radius: 30px">
                                <img src="' . URL::to('uploads/products/' . $item->productSize->image) . '" class="picture"
                                    style="width: 100%;object-fit: cover;image-rendering: pixelated;border-radius: 30px 30px 0 0 ">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between mb-3">
                                        <h5 class="mb-0">' . $item->productSize->name . '</h5>
                                    </div>
                                    <input type="hidden" name="pro_id" id="pro_id" value="' . $item->productSize->product_id . '">
                                    <div class="d-flex flex-column justify-content-between mb-3">
                                        <div class="text-dark mb-0">
                                            <b>' . number_format($item->price) . ' VND</b>
                                        </div>
                                        <div class=" mb-0 mt-2 text-success">In Stock:
                                            <span class="fw-bold">' . $item->instock . '</span>
                                        </div>
            
                                    </div>
            
                                    <div class="d-flex flex-row justify-content-center">
                                        <a class="btn btn-xs btn-primary" href="' . route('products', ['id' => $item->productSize->product_id, 'slug' => str($item->productSize->name)]) . '">See detail</a>
                                        <button class="btn ml-2 btn-xs whilelist">
                                            <i class="fa fa-heart" class="heart" aria-hidden="true" style="box-shadow: rgba(0, 0, 0, 0.56) 0px 22px 70px 4px;"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>';
            }
        }
        if ($filter_by == 3) {
            $product_filter = Product::with('product_size')->get()->map(function ($product) {
                return $product->product_size->first();
            })->filter(function ($size) {
                return $size !== null;
            })->where('price', '>=', 100000)->where('price', '<', 200000)->sortBy('price');
            foreach ($product_filter as $item) {
                $test .= '<div class="container">
                            <div class="card" style="border-radius: 30px">
                                <img src="' . URL::to('uploads/products/' . $item->productSize->image) . '" class="picture"
                                    style="width: 100%;object-fit: cover;image-rendering: pixelated;border-radius: 30px 30px 0 0 ">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between mb-3">
                                        <h5 class="mb-0">' . $item->productSize->name . '</h5>
                                    </div>
                                    <input type="hidden" name="pro_id" id="pro_id" value="' . $item->productSize->product_id . '">
                                    <div class="d-flex flex-column justify-content-between mb-3">
                                        <div class="text-dark mb-0">
                                            <b>' . number_format($item->price) . ' VND</b>
                                        </div>
                                        <div class=" mb-0 mt-2 text-success">In Stock:
                                            <span class="fw-bold">' . $item->instock . '</span>
                                        </div>
            
                                    </div>
            
                                    <div class="d-flex flex-row justify-content-center">
                                        <a class="btn btn-xs btn-primary" href="' . route('products', ['id' => $item->productSize->product_id, 'slug' => str($item->productSize->name)]) . '">See detail</a>
                                        <button class="btn ml-2 btn-xs whilelist">
                                            <i class="fa fa-heart" class="heart" aria-hidden="true" style="box-shadow: rgba(0, 0, 0, 0.56) 0px 22px 70px 4px;"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>';
            }
        }
        if ($filter_by == 4) {
            $product_filter = Product::with('product_size')->get()->map(function ($product) {
                return $product->product_size->first();
            })->filter(function ($size) {
                return $size !== null;
            })->where('price', '>', 200000)->sortBy('price');
            foreach ($product_filter as $item) {
                $test .= '<div class="container">
                            <div class="card" style="border-radius: 30px">
                                <img src="' . URL::to('uploads/products/' . $item->productSize->image) . '" class="picture"
                                    style="width: 100%;object-fit: cover;image-rendering: pixelated;border-radius: 30px 30px 0 0 ">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between mb-3">
                                        <h5 class="mb-0">' . $item->productSize->name . '</h5>
                                    </div>
                                    <input type="hidden" name="pro_id" id="pro_id" value="' . $item->productSize->product_id . '">
                                    <div class="d-flex flex-column justify-content-between mb-3">
                                        <div class="text-dark mb-0">
                                            <b>' . number_format($item->price) . ' VND</b>
                                        </div>
                                        <div class=" mb-0 mt-2 text-success">In Stock:
                                            <span class="fw-bold">' . $item->instock . '</span>
                                        </div>
            
                                    </div>
            
                                    <div class="d-flex flex-row justify-content-center">
                                        <a class="btn btn-xs btn-primary" href="' . route('products', ['id' => $item->productSize->product_id, 'slug' => str($item->productSize->name)]) . '">See detail</a>
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

    public function filterCate(Request $req)
    {
        $cate_name = $req->input('cate');
        $cate_id = $req->input('cate_id');
        $test = null;

        $product_filter = Product::with('product_size')->where('category_id', $cate_id)
            ->get()->map(function ($product) {
                return $product->product_size->first();
            })->filter(function ($size) {
                return $size !== null;
            });
        if ($product_filter == null) {
            $test = null;
        } else {
            foreach ($product_filter as $item) {
                $test .= '<div class="container">
                                    <div class="card" style="border-radius: 30px">
                                        <img src="' . URL::to('uploads/products/' . $item->productSize->image) . '" class="picture"
                                            style="width: 100%;object-fit: cover;image-rendering: pixelated;border-radius: 30px 30px 0 0 ">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between mb-3">
                                                <h5 class="mb-0">' . $item->productSize->name . '</h5>
                                            </div>
                                            <input type="hidden" name="pro_id" id="pro_id" value="' . $item->productSize->product_id . '">
                                            <div class="d-flex flex-column justify-content-between mb-3">
                                                <div class="text-dark mb-0">
                                                    <b>' . number_format($item->price) . ' VND</b>
                                                </div>
                                                <div class=" mb-0 mt-2 text-success">In Stock:
                                                    <span class="fw-bold">' . $item->instock . '</span>
                                                </div>
                    
                                            </div>
                    
                                            <div class="d-flex flex-row justify-content-center">
                                                <a class="btn btn-xs btn-primary" href="' . route('products', ['id' => $item->productSize->product_id, 'slug' => str($item->productSize->name)]) . '">See detail</a>
                                                <button class="btn ml-2 btn-xs whilelist">
                                                    <i class="fa fa-heart" class="heart" aria-hidden="true" style="box-shadow: rgba(0, 0, 0, 0.56) 0px 22px 70px 4px;"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
            }
        }

        return response()->json(['status' => $test]);
    }
}
