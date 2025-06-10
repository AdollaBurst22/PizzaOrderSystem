<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::user()){   //after login
            if(Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin'){
                if($request->route()->getName() == 'login' || $request->route()->getName() == 'register'){
                    return back();
                }else{
                    return $next($request);
                }
            }else{
                return back();
            }
        }else{ //before login => can access login and register page
            return $next($request);
        }
        /*

        if(Auth::user()->role == 'superadmin' || Auth::user()->role == 'admin'){
            return $next($request);
        }

        // Store the current URL in the session if it's not an asset
        if (!$this->isAsset($request->url())) {
            session()->put('url.intended', $request->url());
        }

        // Redirect to user home page with error message
        return redirect()->route('user.homePage')
            ->with('error', 'You do not have permission to access this page.');
        */
    }

    /*
    private function isAsset($url)
    {
        $assetExtensions = ['jpg', 'jpeg', 'png', 'gif', 'css', 'js', 'ico', 'svg'];
        $path = parse_url($url, PHP_URL_PATH);
        $extension = pathinfo($path, PATHINFO_EXTENSION);

        return in_array(strtolower($extension), $assetExtensions);
    }
    */
}
