<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class CheckCustomerRole
{
    public function handle(Request $request, Closure $next)
    {
        // Kiểm tra xem người dùng đã đăng nhập chưa
        if ($request->session()->get('user') == null) {
            return redirect('/frontend/myaccount');
        }
        return $next($request);
    }
}
