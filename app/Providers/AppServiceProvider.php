<?php

namespace App\Providers;

use App\Models\Cart;
use App\Models\Size;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
            $pro_sizes = array();
            $cart_name = array();
            foreach ($cart as $key => $value) {
                $pro_size = Size::where('product_id', $value->cart_pro->product_id)->where('size', $value->size)->first();
                $count++;
                $totalPrice += $pro_size->price * $value->quantity;
                if (!isset($pro_sizes[$value->size])) {
                    $pro_sizes[$value->size][$value->cart_pro->product_id] = [];
                }
                $pro_sizes[$value->size][$value->cart_pro->product_id] = $pro_size;
                $cart_name[$value->size][$value->cart_pro->product_id] = $value->cart_pro->name;
            }
            $product = DB::table('products')->get();
            return $view->with([
                'cart_items' => $cart,
                'cart_total_price' => $totalPrice,
                'cart_total_quantity' => $count,
                'product_special' => $product,
                'pro_sizes' => $pro_sizes,
                'cart_name' => $cart_name
            ]);
        });
    }
}
