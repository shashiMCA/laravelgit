<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\User;
class LoginMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
       $user = User::find(Auth::id());
   
       if($user->status == 0){
           Auth::logout();
           return redirect('login')->with('message', 'You need to verify your account first');
           
           
       }
        
        
        return $next($request);
    }
}
