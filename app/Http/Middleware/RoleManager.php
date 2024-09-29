<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleManager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,$role): Response
    {

        // add role atrritube and we check if user is not uthenicated we send them to login
        if(!Auth::check()){
            return redirect()->route('login');
        }

        //if user authenicated we check the user role

        $authUserRole =Auth::user()->role;
//if user is admin we will check is authuser role is 0 , if true then we will go to the next stage
        switch($role){
            case 'admin':
                if($authUserRole == 0){
                    return $next($request);
                }
                 break;
            case 'business':
                if($authUserRole == 1){
                    return $next($request);
                }
                 break;
             case 'user':
                if($authUserRole == 2){
                      return $next($request);
                    }
                  break;                 
        
    }
            //another swithc case
            switch($authUserRole){
                case 0:
                    return redirect()->route('admin');
                case 1:
                    return redirect()->route('business');
                case 2:
                    return redirect()->route('dashboard');
            }
            return redirect()->route('login');
}
}