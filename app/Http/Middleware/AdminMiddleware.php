<?php

namespace App\Http\Middleware;

use Closure;
use App\models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user()->role === 'ADM' || Auth::user()->role === 'ADC') {
            if (Auth::user()->role === 'ADC' && $request->is('admin/users*')) {
                return redirect()->route('admin.admin')->with('alert', 'Bạn không có quyền truy cập và trang này');
            }
            return $next($request);
        }
        return redirect()->route('index')->with('you cant login here');
    }
}
