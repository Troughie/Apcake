<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();

        $title = 'Thêm sản phẩm';

        return view('backend.Products.show', compact('title', 'products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::with('products')->get();
        $title = 'Thêm sản phẩm';
        return view('backend.Products.add', compact('title', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'price' => ['required'],
            'category_id' => ['required'],
            'description' => ['required'],
            'quantity' => ['required'],
            'image' => ['required'],

        ]);
        $data = array();
        $data['name'] = $request->name;
        $data['price'] = $request->price;
        $data['category_id'] = $request->category_id;
        $data['description'] = $request->description;
        $data['quantity'] = $request->quantity;
        $get_image = $request->file('image');
        if ($get_image) {
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image = $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension();
            $get_image->move('uploads/products', $new_image);
            $data['image'] = $new_image;
            DB::table('products')->insert($data);
            Session::put('message', 'Thêm sản phẩm thành công');

            return redirect()->route('admin.showProduct')->with('success', 'Thêm sản phẩm thành công');
        }
    }

    public function searchProduct(Request $request)
    {
        $products = Product::all();
        $name = $request->search;
        $result = Product::where('name', 'like', '%' . $name . '%')->get();
        $title = 'Search';


        return view('backend.Products.show', compact('result', 'products', 'title'))->with('result', $result);


    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::find($id);
        $categories = Category::with('products')->get();
        $title = 'Thêm sản phẩm';
        return view('backend.Products.detail', compact('title', 'categories'))->with('product', $product);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $categories = Category::with('products')->get();
        $product = Product::find($id);
        $title = 'Chỉnh sửa sản phẩm: ' . $product->name;
        return view('backend.Products.edit', compact('title', 'categories'))->with('product', $product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);
        $data = array();
        $data['name'] = $request->name;
        $data['price'] = $request->price;
        $data['description'] = $request->description;
        $data['quantity'] = $request->quantity;
        $get_image = $request->file('image');
        if ($get_image) {
            $path = 'uploads/products/' . $product->image;
            if (File::exists($path)) {
                File::delete($path);
            }
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image = $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension();
            $get_image->move('uploads/products', $new_image);
            $data['image'] = $new_image;
            DB::table('products')->where('product_id', $id)->update($data);
            return redirect()->route('admin.showProduct')->with('success', 'Product Updated!');
        }
        DB::table('products')->where('product_id', $id)->update($data);
        return redirect()->route('admin.showProduct')->with('success', 'Product Updated!');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $product = Product::findOrFail($id);

        $path = 'uploads/products/' . $product->image;
        if (File::exists($path)) {
            File::delete($path);
        }
        $product->delete();

        return redirect()->back()->with('success', 'Product Deleted!');
    }
}