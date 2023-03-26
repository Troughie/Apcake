<?php

namespace App\Providers;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        view()->composer(['frontend.*', 'auth.*'], function ($view) {
            $user = Auth::id();
            $cart = Cart::with('cart_pro')->where('user_id', $user)->get();
            $totalPrice = 0;
            $count = 0;
            foreach ($cart as $key => $value) {
                $count++;
                $totalPrice += $value->cart_pro->price * $value->quantity;
            }
            return $view->with([
                'cart_items' => $cart,
                'cart_total_price' => $totalPrice,
                'cart_total_quantity' => $count,
            ]);
        });
    }
}
