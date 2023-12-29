<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        //  Ако се опиташ да идеш в стрнаицата на др потребител те редиректва към dashboard на ролята ти
        if($request->user()->role !== $role){
            return redirect($request->user()->role."/dashboard");
        }

        return $next($request);
    }
}
