<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redis;

class CheckNodeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(session('admin')!=null &&session('access')!=null) {
            $tmp=explode('?',$request->getRequestUri());
            if(in_array($tmp[0],session('access'))){
                return $next($request);
            }else{
                return redirect('/index/access');
            }
        } else {
            return redirect('/');
        }
    }
}
