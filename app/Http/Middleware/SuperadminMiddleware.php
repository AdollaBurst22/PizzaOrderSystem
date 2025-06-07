<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SuperadminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /*
        if(Auth::user()->role == 'superadmin'){
            return $next($request);
        }else{
            return back();
        }
        */
        if(Auth::user()){   //after login
            if(Auth::user()->role == 'superadmin'){
                if($request->route()->getName() == 'login' || $request->route()->getName() == 'register'){
                    return back();
                }else{
                    return $next($request);
                }
            }else{
                return redirect()->route('user#homePage')
            ->with('error', 'You do not have permission to access this page.');
            }
        }else{ //before login => can access login and register page
            return $next($request);
        }
    }
}
