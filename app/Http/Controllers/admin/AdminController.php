<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('backend.Layout.index', [
            'title' => 'admin'
        ]);
    }

    public function addProduct()
    {
        return view('backend.Products.add', [
            'title' => 'Thêm Sản phẩm'
        ]);
    }
    public function addCategory()
    {
        return view('backend.Category.add', [
            'title' => 'Thêm Danh mục sản phẩm'
        ]);
    }

    public function blog()
    {
        return view('backend.Blog.blog', [
            'title' => 'Quản lí Blog'
        ]);
    }
    public function invoice()
    {
        return view('backend.Invoice.invoice', [
            'title' => 'In Hóa đơn'
        ]);
    }
    public function users()
    {
        return view('backend.Users.users', [
            'title' => 'Quản lí người dùng'
        ]);
    }
    public function showProduct()
    {
        return view('backend.Products.show', [
            'title' => 'Quản lí hàng hóa'
        ]);
    }
    public function showCategory()
    {
        return view('backend.Category.show', [
            'title' => 'Quản lí Danh Mục'
        ]);
    }
}
