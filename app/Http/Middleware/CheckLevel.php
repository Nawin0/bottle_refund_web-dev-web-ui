<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckLevel
{
    public function handle($request, Closure $next, $level)
    {
        if (Auth::check()){
            if (Auth::user()->level == $level) {
                return $next($request);
        }
            return redirect()->route('login')->withErrors(['access' => 'Unauthorized access for your user level.']);
        }
        return redirect()->route('login')->withErrors(['access' => 'Please login first']);
    }
}