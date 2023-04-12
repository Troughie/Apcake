<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function show()
    {
        $title = 'DASHBOARD';
        $order = DB::table('orders')->get();
        $order2 = $order->pluck('order_id');
        $orderDay  = Order::whereDate('created_at',   Carbon::today())->get();
        $orderMonth = Order::whereMonth('created_at', Carbon::now()->month)->get();
        return view('backend.Dashboard.show', compact('title', 'order2', 'orderDay', 'orderMonth'));
    }

    public function orderUser(string $id)
    {
        $user = User::where('user_id', $id)->first();
        $title = 'Danh sách đơn hàng cua' . $user->name;
        $orderUser = Order::where('user_id', $id)->get();
        return view('backend.Order.order', compact('orderUser', 'title'));
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
