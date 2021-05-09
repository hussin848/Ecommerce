<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Blog
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

        $blog=Auth::user()->blog;


        if ($blog!=1) {
             return Redirect()->route('admin.home');
        }
        return $next($request);
    }
}
