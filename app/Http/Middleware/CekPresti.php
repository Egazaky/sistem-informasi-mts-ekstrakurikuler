<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CekPresti
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->session()->has('presti_role') || !$request->session()->has('presti_user_id')) {
            return redirect()->route('presti.login')->with('error', 'Silakan login terlebih dahulu.');
        }

        return $next($request);
    }
}
