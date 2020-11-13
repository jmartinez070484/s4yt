<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Closure;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
        $userRole = Auth::check() ? Auth::user() -> role : null;
        $prefix = $request -> route() -> getPrefix();
        
        if($userRole){
            $validRoute = true;
            
            if($userRole -> slug !== $prefix && $userRole -> id !== 2 || $userRole -> id === 2 && $prefix){
                $validRoute = false;
            }
            
            if(!$validRoute){
                return redirect() -> route($userRole -> slug);
            }else if($userRole -> id == 2 && strtotime('NOW') < env('APP_LAUNCH_DATE')){
                try{
                    $validUsers = explode(',',env('APP_USERS'));
                }catch(Exception $exception){
                    $validUsers = [];
                }
                
                if(!in_array(Auth::id(),$validUsers)){
                    return redirect() -> route('oops');
                }
            }
        }else{
            return redirect() -> route('login');
        }

        return $next($request);
    }
}
