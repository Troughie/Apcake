<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\OrderDetails;
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
        $title = 'Hiển thị sản phẩm';
        return view('backend.Products.show', compact('title', 'categories', 'product', 'size'))->with('i', (request()->input('page', 1) - 1) * 7);
    }

    public function showall()
    {
        $product = Product::with('product_size')->simplePaginate(99);
        $categories = Category::with('products')->get();
        $size = Size::with('productSize')->get();
        $title = 'Hiển thị sản phẩm';
        return view('backend.Products.show', compact('title', 'categories', 'product', 'size'))->with('i', (request()->input('page', 1) - 1) * 99);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::with('products')->get();
        $size = Size::with('productSize')->get();
        $title = 'Thêm sản phẩm mới';
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
                DB::table('sizes')->insert(['price' => $request->priceS, 'instock' => $request->instockS, 'size' => $value, 'product_id' => $data_size['product_id']]);
            } elseif ($value == 'Medium') {
                DB::table('sizes')->insert(['price' => $request->priceM, 'instock' => $request->instockM, 'size' => $value, 'product_id' => $data_size['product_id']]);
            } else {
                DB::table('sizes')->insert(['price' => $request->priceL, 'instock' => $request->instockL, 'size' => $value, 'product_id' => $data_size['product_id']]);
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

        $products = Product::all();
        $product = Product::with('product_size')->simplePaginate(7);
        $size = Size::with('productSize')->get();
        $categories = Category::with('products')->get();
        $name = $request->search;
        $result = Product::where('name', 'like', '%' . $name . '%')->get();
        $title = 'Tìm kiếm sản phẩm';
        return view('backend.Products.show', compact('result', 'products', 'title', 'categories', 'product', 'size'))->with('result', $result)->with('i', (request()->input('page', 1) - 1) * 7);
    }
    public function show(string $id)
    {
        $product = Product::with('product_size')->where('product_id', $id)->first();
        $categories = Category::with('products')->get();
        $totalquantity = OrderDetails::where('product_id',$id)->sum('quantity');
        $totalprofit = OrderDetails::where('product_id',$id)->sum('total');
        $title = 'Chi tiết sản phẩm';
        return view('backend.Products.detail', compact('title', 'categories','totalquantity','totalprofit'))->with('product', $product);
    }

    public function edit(string $id)
    {
        $categories = Category::with('products')->get();
        $product = Product::find($id);
        $size = Size::with('productSize')->where('product_id', $id)->get();
        $size_name = null;
        $size_name2 = array();
        foreach ($size as $value) {
            array_push($size_name2, $value->size);
            $size_name[$value->size] = $value;
        }
        $size_default = ['Medium', 'Large', 'Small'];
        $size_left = array_diff($size_default, $size_name2);
        // dd($size_left);
        $title = 'Chỉnh sửa sản phẩm: ' . $product->name;
        return view('backend.Products.edit', compact('title', 'categories', 'size', 'size_name', 'size_left'))->with('product', $product);
    }

    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id)->with('product_size')->get();
        $data = array();
        $data['name'] = $request->name;
        $data['category_id'] = $request->category_id;
        $data['description'] = $request->description;
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
        $test2 = $request->size;
        $gan1 = [];
        $test = DB::table('sizes')->where('product_id', $id)->get();
        foreach ($test as $value) {
            array_push($gan1, $value->size);
        }

        $deleteSize = array_diff($gan1, $test2);

        if (count($deleteSize) > 0) {
            foreach ($deleteSize as $delete) {
                DB::table('sizes')->where('product_id', $id)->where('size', $delete)->delete();
            }
        }
        foreach ($test2 as $key => $value) {
            if ($value == 'Small') {
                $gan2 = (DB::table('sizes')->where('product_id', $id)->where('size', $value)->first());
                if ($gan2 == null) {
                    DB::table('sizes')->insert(['price' => $request->priceSmall, 'instock' => $request->instockSmall, 'size' => $value, 'product_id' => $id]);
                } else {
                    DB::table('sizes')->where('product_id', $id)->where('size', $value)->update(['price' => $request->priceSmall, 'instock' => $request->instockSmall, 'size' => $value]);
                }
            } elseif ($value == 'Medium') {
                $gan2 = (DB::table('sizes')->where('product_id', $id)->where('size', $value)->first());
                if ($gan2 == null) {
                    DB::table('sizes')->insert(['price' => $request->priceMedium, 'instock' => $request->instockMedium, 'size' => $value, 'product_id' => $id]);
                } else {
                    DB::table('sizes')->where('product_id', $id)->where('size', $value)->update(['price' => $request->priceMedium, 'instock' => $request->instockMedium, 'size' => $value]);
                }
            } else {
                $gan2 = (DB::table('sizes')->where('product_id', $id)->where('size', $value)->first());
                if ($gan2 == null) {
                    DB::table('sizes')->insert(['price' => $request->priceLarge, 'instock' => $request->instockLarge, 'size' => $value, 'product_id' => $id]);
                } else {
                    DB::table('sizes')->where('product_id', $id)->where('size', $value)->update(['price' => $request->priceLarge, 'instock' => $request->instockLarge, 'size' => $value]);
                }
            }
        }
        DB::table('products')->where('product_id', $id)->update($data);
        return redirect()->route('admin.showProduct')->with('success', 'Cập nhập sản phẩm thành công !');
    }

    public function destroy(string $id, Request $req)
    {
        $size = $req->size;
        if (is_array($size)) {
            foreach ($size as $key => $value) {
                $orderDetail = OrderDetails::where('product_id', $id)->where('size', $value)->first();
                $item = Size::where('product_id', $id)->where('size', $value)->first();
                if ($orderDetail) {
                    return redirect()->back()->with('fail_destroy', 'Sản phẩm đang có trong 1 đơn hàng chưa hoàn thành');
                } else {
                    if ($item) {
                        $item->delete();
                    }
                    $product = Product::with('product_size')->findOrFail($id);
                    if (count($product->product_size) == 0) {
                        $path = 'uploads/products/' . $product->image;
                        if (File::exists($path)) {
                            File::delete($path);
                        }
                        $product->delete();
                    }
                }
            }
            return redirect()->back()->with('success', 'Xóa sản phẩm thành công!');
        } else {
            return redirect()->back()->with('fail_destroy', 'Phải chọn size');
        }
    }
}
