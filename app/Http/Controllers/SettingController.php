<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SettingController extends Controller
{
    public function setLanguage($locale)
    {
        if (in_array($locale, ['id', 'en'])) {
            Session::put('locale', $locale);
            App::setLocale($locale);
        }
        return redirect()->back();
    }

    public function setTheme(Request $request)
    {
        $theme = $request->theme;
        if (in_array($theme, ['dark', 'light'])) {
            Session::put('theme', $theme);
        }
        
        // Return response dengan mengirimkan cookie/header untuk localStorage
        return redirect()->back()->with('theme', $theme);
    }
}