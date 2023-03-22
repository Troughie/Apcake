<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function products()
    {
        $product = Product::all();
        $category = Category::with('products')->get();
        $title_head = 'shop';
        return view('frontend.pages.shop ', compact('title_head', 'category', 'product'));
    }

    public function productDetail(String $id)
    {
        $product = Product::find($id);
        $title_head = $product->name;
        return view('frontend.pages.products ', compact('title_head', 'product'));
    }
}
