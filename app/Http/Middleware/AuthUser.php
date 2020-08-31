<?php
/**
 * Created by PhpStorm.
 * User: varun
 * Date: 7/17/2019
 * Time: 3:43 PM
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class authUser
{
    public function handle($request, Closure $next, $guard = null)
    {
        if (!Auth::guard($guard)->check()) {
            return redirect('/');
        }
        return $next($request);
    }
}