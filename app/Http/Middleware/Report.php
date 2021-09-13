<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
class Report
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
        $repoet=Auth::user()->repoet;

        if ($repoet!=1) {
             return Redirect()->route('admin.home');
        }
        return $next($request);
    }
}
 