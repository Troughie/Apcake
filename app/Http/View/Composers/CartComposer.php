<?php

namespace App\Http\View\Composers;

use App\Models\Cart;
use Illuminate\View\View;

class OrdersComposer
{
    public function compose(View $view)
    {
        $cart = Cart::all();
        $view->with('orders', $cart);
    }
}
