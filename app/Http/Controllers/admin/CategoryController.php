<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Models\Cart;
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return view('backend.Category.add', [
            'title' => 'Thêm Danh mục sản phẩm'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $category = Category::all();
        $input = $request->category_name;
        $request->validate([
            'category_name' => 'required|unique:categories'
        ]);
        Category::create([
            'category_name' => $input
        ]);
        $title = 'Danh mục sản phẩm';

        return view('backend.Category.show', compact('title','category'))->with('flash_message', 'Tạo thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $category = Category::all();
        $title = 'Danh mục sản phẩm';
        return view('backend.Category.show', compact('title'))->with('category', $category);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::find($id);
        $title = 'Danh mục sản phẩm';
        return view('backend.Category.edit', compact('title', 'category'));
    }
    public function detail(string $id)
    {
        $category = Category::findOrFail($id);
        $product = Product::with('category')->get();
        $title = 'Chi tiết danh mục sản phẩm';
        return view('backend.Category.detail', compact('title','product'))->with('category',$category);
    }

    // public function decreaseQuantity($id){
    //     $product = Cart::get($id);
    //     $qty = $product->quantity-1;
    //     Cart::update($id,$qty);

    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::find($id);
        $input = $request->all();
        $category->update($input);
        $title = 'Danh mục sản phẩm';
        return redirect()->route('admin.showCategory')->with('flash_message', 'Category Updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Category::destroy($id);
        return redirect()->back()->with('success', 'Category Deleted!');
    }
}
