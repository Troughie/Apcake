<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Mail\ConfirmMail;
use App\Models\Size;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use PDF;

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
                'message' => 'required',
            ]
        );
        Mail::send('frontend.pages.mail', compact('req'), function ($email) use ($req) {
            $email->subject('Cảm ơn bạn đã quan tâm và ý kiến về cho chúng tôi');
            $email->to($req->email, $req->name);
        });
        return redirect()->back();
    }

    public function search(Request $req)
    {
        $search = $req->input('query');
        $data = DB::table('products')
            ->join('categories', 'products.category_id', '=', 'categories.category_id')
            ->where(function ($query) use ($search) {
                $query->where(DB::raw('LOWER(products.name)'), 'like', '%' . strtolower($search) . '%')
                    ->orWhere(DB::raw('LOWER(categories.category_name)'), 'like', '%' . strtolower($search) . '%');
            })
            ->get();
        $output = '';
        $total_row = $data->count();
        if ($total_row > 0) {
            if ($search == '') {
                $output .= '';
            } else {
                foreach ($data as $key => $value) {
                    $output .=
                        '<span class="mt-3 ml-2 "><a class="text-dark" href="' . route('products', ['id' => $value->product_id, 'slug' => str($value->name)]) . '">' . $value->name . '</a> </span>';
                }
            }
        } else {
            $output .=     '<span class="mt-3 ml-2 ">No matching </span>';
        }
        return response()->json(['status' => $output]);
    }

    public function confirmOrder(string $order_id)
    {
        Order::where('user_id', Auth::id())->where('order_id', $order_id)->update(array('status_id' => 5));

        return view('frontend.pages.checkout.thanks');
    }

    public function generatePDF(string $id)
    {
        $orDetail = OrderDetails::with('order_pro', 'order', 'order.order_sta')->where('order_id', $id)->get()->toArray();

        $order = Order::with('user')->where('order_id', $orDetail[0]['order_id'])->first()->toArray();
        $order_pro = [];
        $title = 'PDF_ORDER';
        if (count($orDetail) > 0) {
            foreach ($orDetail as $key => $value) {
                $order_pro[$value['size']][$value['product_id']] =  Size::with('productSize')->where('product_id', $value['product_id'])->where('size', $value['size'])->first()->toArray();
            }
        }
        $pdf = PDF::loadView('backend.Order.pdfOrder', ['orDetail' => $orDetail, 'order' => $order, 'order_pro' => $order_pro, 'title' => $title]);
        return $pdf->stream('pdf_order.pdf');
    }
}
