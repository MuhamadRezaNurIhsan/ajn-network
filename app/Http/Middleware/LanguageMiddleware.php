<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageMiddleware
{
    public function handle($request, Closure $next)
    {
        // Cek apakah session 'locale' ada, jika tidak set default ke 'id' (Indonesia)
        if (!Session::has('locale')) {
            Session::put('locale', 'id');
            App::setLocale('id');
        } else {
            App::setLocale(Session::get('locale'));
        }
        
        return $next($request);
    }
}