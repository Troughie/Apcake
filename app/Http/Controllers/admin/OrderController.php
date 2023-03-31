<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetails;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function order()
    {
        $title = 'order';
        $order = Order::with('orderDe')->get();
        return view('backend.Order.order', compact('order', 'title'));
    }

    public function orderdetail(string $id)
    {
        $title = 'orderDetail';
        $orDetail = OrderDetails::with('order_pro', 'order', 'order.order_sta')->where('order_id', $id)->get();
        return view('backend.Order.orderdetail', compact('orDetail', 'title'));
    }

    public function searchOrder(Request $req)
    {
        $priceFrom = $req->input('priceFrom');
        $priceTo = $req->input('priceTo');
        $dateFrom = $req->input('dateFrom');
        $dateTo = $req->input('dateTo');
        $status = $req->input('status');
        $payment = $req->input('payment');

        // Query the database to retrieve the relevant records
        $records = Order::query()->with('orderDe', 'order_sta')
            ->when($priceFrom && $priceTo, function ($query) use ($priceFrom, $priceTo) {
                return $query->whereBetween('totalAmount', [$priceFrom, $priceTo]);
            })
            ->when($dateFrom && $dateTo, function ($query) use ($dateFrom, $dateTo) {
                return $query->whereBetween('created_at', [$dateFrom, $dateTo]);
            })
            ->when($status, function ($query) use ($status) {
                return $query->where('status_id', $status);
            })
            ->when($payment, function ($query) use ($payment) {
                return $query->where('payment_id', $payment);
            })
            ->get();


        // Generate the HTML table
        $table = '';
        foreach ($records as $record) {
            $table .= '<tr>';
            $table .= '<td>' . $record->created_at . '</td>';
            $table .= '<td>' . $record->order_id . '</td>';
            $table .= '<td>';
            foreach ($record->orderDe as $product) {
                $table .= '<p><span>' . $product->order_pro->name . '</span> x ' . $product->quantity . '</p>';
            }
            $table .= '</td>';
            $table .= '<td>' . '$' . $record->totalAmount . '</td>';
            $table .= '<td>' . $record->order_sta->name . '</td>';
            $table .= '<td><a href="' . route('admin.orderdetail', $record->order_id) . '">Chi tiết</a></td>';
            $table .= '</tr>';
        }
        return response()->json(['status' => true, 'records' => $table]);
    }
}
