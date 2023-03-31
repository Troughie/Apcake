<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function products()
    {
        $product = Product::paginate(9)->all();
        $category = Category::with('products')->get();
        $title_head = 'shop';
        return view('frontend.pages.shop ', ['product'=>$product],compact('category','title_head'));
    }

    public function productDetail(String $id)
    {
        $product = Product::find($id);
        $title_head = $product->name;
        return view('frontend.pages.products ', compact('title_head', 'product'));
    }


    public function getSize(Request $req)
    {
        $size = $req->input('size');
        $pro_id = $req->input('pro_id');

        return response()->json(['status' => 'success', 'size' => $size, 'pro_id' => $pro_id]);
    }
}
