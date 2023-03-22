<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class FrontendController extends Controller
{
    public function index()
    {
        $title_head = 'home';
        return view('frontend.pages.index', compact('title_head'));
    }
    public function cart()
    {
        $title_head = 'cart';
        return view('frontend.pages.shopping-cart', compact('title_head'));
    }

    public function blog()
    {
        $title_head = 'blog';
        return view('frontend.pages.blog', compact('title_head'));
    }

    public function contact()
    {
        $title_head = 'contact';
        return view('frontend.pages.contact', compact('title_head'));
    }
    public function checkout()
    {
        $title_head = 'checkout';
        return view('frontend.pages.checkout', compact('title_head'));
    }

    public function products()
    {
        $title_head = 'product';
        return view('frontend.pages.products', compact('title_head'));
    }
    public function gallery()
    {
        $title_head = 'Gallery';
        return view('frontend.pages.gallery', compact('title_head'));
    }
    public function shop()
    {
        $title_head = 'shop';
        return view('frontend.pages.shop ', compact('title_head'));
    }

    public function testmail(Request $req)
    {
        $req->validate(
            [
                'name' => 'required',
                'email' => 'required',
                'phone' => 'required',
                'mes' => 'required',
            ]
        );
        Mail::send('frontend.pages.mail', compact('req'), function ($email) use ($req) {
            $email->subject('tks for quan tam');
            $email->to($req->email, $req->name);
        });
        return redirect()->back();
    }
}
