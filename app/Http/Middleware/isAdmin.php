<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class isAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if($request->user() && $request->user()->level == 'administrator'){
            return $next($request);
        }
        $notification = array(
            'message' => 'Gagal, anda tidak memiliki akses admin!',
            'alert-type' => 'error'
        );
        return redirect()->route('login')->with($notification);
    }
}
