<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Session;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Contracts\Auth\Guard;

class IsUserBanned
{
    public function handle($request, Closure $next)
    {
        if (auth()->check() && auth()->user()->banned_until && now()->lessThan(auth()->user()->banned_until)) {
            $banned_days = now()->diffInDays(auth()->user()->banned_until);
            auth()->logout();

            if ($banned_days > 14) {
                $message = 'Tài khoản của bạn đã bị khóa. Liên hệ người quản lí để biết thêm chi tiết';
            } else {
                $message = 'Tài khoản của bạn còn bị khóa '.$banned_days.' '.str('day', $banned_days).'ngày. Liên hệ người quản lí để biết thêm chi tiết.';
            }

            return redirect()->route('login')->withMessage($message);
        }

        return $next($request);
    }
}