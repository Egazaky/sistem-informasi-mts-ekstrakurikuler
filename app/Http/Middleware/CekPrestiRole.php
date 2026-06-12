<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CekPrestiRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$roles
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!$request->session()->has('presti_role')) {
            return redirect()->route('presti.login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $role = $request->session()->get('presti_role');

        if (!in_array($role, $roles)) {
            return redirect('/presti')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
        }

        return $next($request);
    }
}
