<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

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
        // $products = new Product();
        // $categories = Category::with('products')->get();
        // $input = $request->all();
        // $request->validate([
        //     'name' => ['required'],
        //     'price' => ['required'],
        //     'category_id' => ['required'],
        //     'decription' => ['required'],
        //     'quantity' => ['required', 'max:100'],
        // ]);
        // if ($request->hasfile('image')) {
        //     $file = $request->file('image');
        //     $extention = $file->getClientOriginalExtension();
        //     $filename = time() . '.' . $extention;
        //     $file->move('uploads/backend/products', $filename);
        //     $data['image']=$filename;
        //     DB::table('products')->insert($data)
        //     $products->image = $filename;
        // else {
        //     return $request;
        //     $products->image = '';
        // }

        // $products->create($input);






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
        $product = Product::find($id);
        $input = $request->all();
        $product->update($input);
        $title = 'Cập nhật sản phẩm';
        return redirect()->route('admin.showProduct')->with('success', 'Product Updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Product::destroy($id);
        return redirect()->back()->with('success', 'Product Deleted!');
    }
}
