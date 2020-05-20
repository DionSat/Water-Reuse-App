<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use Illuminate\Support\Facades\Auth;

class CheckBanned
{
    //Handle the incoming request, check if the current user is banned
    public function handle($request, Closure $next) {
        //Check if a user is authenticated
        $User = Auth::user();
        if(Auth::check() == true && !$User->is_banned)
            return $next($request);
        else{
        	Auth::logout();
            abort(401, 'Unauthorized action. Your account has been disabled.');
        }
        return null;
    }

}
