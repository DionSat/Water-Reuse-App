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
        $user = Auth::user();
        if($user && $user->is_banned === false)
            return $next($request);
        elseif(!$user){
            abort(401, "Please log in to view this page.");
        } else {
        	Auth::logout();
            abort(401, 'Unauthorized action. Your account has been disabled.');
        }
        return null;
    }

}
