<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function show()
    {
        $title = 'DASHBOARD';
        return view('backend.Dashboard.show', compact('title'));
    }

    public function orderDay()
    {
        $title = 'Danh sách đơn hàng';
        $orderDay = Order::whereDate('created_at', Carbon::today())->get();
        return view('backend.Order.order', compact('orderDay', 'title'));
    }

    public function orderMonth()
    {
        $title = 'Danh sách đơn hàng';
        $orderMonth = Order::whereMonth('created_at', Carbon::now()->month)->get();
        return view('backend.Order.order', compact('orderMonth', 'title'));
    }
}
