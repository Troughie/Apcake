<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PromotionController extends Controller
{
    public function index()
    {
        $coupon = Promotion::all();
        $title = 'Promotion';
        return view('backend.Promotions.promotions', compact('coupon', 'title'));
    }

    public function add()
    {
        $title = 'Add promptions';
        return view('backend.Promotions.addpro', compact('title'));
    }

    public function store(Request $req)
    {
        $req->validate([
            'coupon' => 'required|unique:promotions,code|min:8',
            'price' => 'required',
        ]);
        $startdate = $req->startdate;
        $enddate = $req->enddate;
        if (isset($startdate) && isset($enddate)) {
            $startObject = Carbon::createFromFormat('Y-m-d', $startdate);
            $endObject = Carbon::createFromFormat('Y-m-d', $enddate);
        }

        Promotion::create([
            'code' => $req->coupon,
            'product_id' => $req->product,
            'discountAmount' => $req->price,
            'discountQuantity' => $req->quantity,
            'status' => $req->status,
            'startDate' => $startObject ?? null,
            'endDate' => $endObject ?? null,
        ]);
        return redirect()->route('admin.promotion')->with('couponsuccess', 'Đã thêm mã giảm giá');
    }

    public function delete(string $id)
    {
        Promotion::where('promotion_id', $id)->delete();
        return redirect()->back()->with('delcoupon', 'Đã xoá');
    }
}
