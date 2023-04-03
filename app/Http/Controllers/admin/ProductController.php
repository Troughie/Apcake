<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Size;
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

        $product = Product::with('product_size')->simplePaginate(7);
        $categories = Category::with('products')->get();
        $size = Size::with('productSize')->get();
        $title = 'Thêm sản phẩm';
        return view('backend.Products.show', compact('title', 'categories', 'product', 'size'))->with('i', (request()->input('page', 1) - 1) * 7);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::with('products')->get();
        $size = Size::with('productSize')->get();
        $title = 'Thêm sản phẩm';
        return view('backend.Products.add', compact('title', 'categories', 'size'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => ['required'],
            'category_id' => ['required'],
            'size' => ['required'],
            'description' => ['required'],
            'image' => ['required'],
            // 'priceS'=>[$request->has('sizeS')],

        ]);
        // dd([
        //     $request->has('Small')
        // ]);

        $data = array();
        $data_size = array();
        $data['name'] = $request->name;
        $data['category_id'] = $request->category_id;
        $data['description'] = $request->description;
        $data['status'] = $request->status;
        $get_image = $request->file('image');
        if ($get_image) {
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image = $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension();
            $get_image->move('uploads/products', $new_image);
            $data['image'] = $new_image;
            DB::table('products')->insert($data);
        }
        $product = Product::all();
        $data_size['price'] = $request->price;
        $data_size['instock'] = $request->instock;
        $test = array();
        foreach ($product as $key => $value) {
            array_push($test, $value);
        }
        $data_size['product_id'] = end($test)->product_id;
        $test2 = $request->size;
        foreach ($test2 as $key => $value) {
            if ($value == 'Small') {
                DB::table('sizes')->insert(['price' => $request->priceS,'instock' => $request->instockS, 'size' => $value, 'product_id' => $data_size['product_id']]);
            } elseif ($value == 'Medium') {
                DB::table('sizes')->insert(['price' => $request->priceM,'instock' => $request->instockM, 'size' => $value, 'product_id' => $data_size['product_id']]);
            } else {
                DB::table('sizes')->insert(['price' => $request->priceL,'instock' => $request->instockL, 'size' => $value, 'product_id' => $data_size['product_id']]);
            }
        }
        return redirect()->route('admin.showProduct', compact('product'))->with('success', 'Thêm sản phẩm thành công');
    }
    public function activeProduct(string $id)
    {
        $product = Product::findOrFail($id);
        DB::table('products')->where('product_id', $id)->update(['status' => 1]);
        Session::put('message', 'Kích hoạt sản phẩm thành công');
        return redirect()->route('admin.showProduct')->with('product', $product);
    }

    public function unactiveProduct(string $id)
    {
        $product = Product::findOrFail($id);
        DB::table('products')->where('product_id', $id)->update(['status' => 0]);
        Session::put('message', 'Không kích hoạt sản phẩm');
        return redirect()->route('admin.showProduct')->with('product', $product);
    }

    public function searchProduct(Request $request)
    {
        $product = Product::simplePaginate(7);
        $products = Product::all();
        $categories = Category::with('products')->get();
        $name = $request->search;
        $result = Product::where('name', 'like', '%' . $name . '%')->get();
        $title = 'Search';
        return view('backend.Products.show', compact('result', 'products', 'title', 'categories', 'product'))->with('result', $result)->with('i', (request()->input('page', 1) - 1) * 7);


    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::find($id);
        $categories = Category::with('products')->get();
        $title = 'Chi tiết sản phẩm';
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
        $data['category_id'] = $request->category_id;
        $data['price'] = $request->price;
        $data['size'] = $request->size;
        $data['description'] = $request->description;
        $data['quantity'] = $request->quantity;
        $data['status'] = $request->status;
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
            return redirect()->route('admin.showProduct')->with('success', 'Cập nhập sản phẩm thành công!');
        }
        DB::table('products')->where('product_id', $id)->update($data);
        return redirect()->route('admin.showProduct')->with('success', 'Cập nhập sản phẩm thành công !');
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

        return redirect()->back()->with('success', 'Xóa sản phẩm thành công!');
    }
}