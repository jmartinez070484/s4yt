<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Notifications\UserResetPasswordEmail;
use App\User;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /*

		Login

    */
    public function auth(Request $request){
    	$user = Auth::check() ? Auth::user() : null;
        $element = Str::of($request->route()->getName()) -> replace('.','-');

        if($user){
    		$role = $user -> role;
            
            if($role){
                return redirect() -> route($role -> slug);
    		}
    	}

        return view('auth',compact('element'));
    }

    /*

        Logout

    */
    public function logout(Request $request){
        $logout = Auth::check() ? Auth::logout() : false;

        if($request -> expectsJson()){
            return response(['success'=>true]);
        }else{
            return redirect() -> route('login');
        }
    }

    /*

        Reset

    */
    public function reset(Request $request){
        $user = Auth::check() ? Auth::user() : null;
        $element = Str::of($request->route()->getName()) -> replace('.','-');
        $params = $request -> only('token','email');
        $validResetLink = false;
        $userReset = null;

        if($user){
            $role = $user -> role;

            if($role){
                return redirect() -> route($role -> slug);
            }
        }

        if(count($params) === 2){
            $userReset = User::where('email',$params['email']) -> first();

            if($userReset){
                $passwordBroker = Password::broker();
                $validResetLink = $passwordBroker -> tokenExists($userReset,$params['token']);
            }
        }

        if($request->isMethod('post')){
            $response = ['success'=>false];

            if($validResetLink){
                $passwords = $request -> only('password','password_confirmation');
                $validator = Validator::make($passwords,[
                    'password' => ['required','string','confirmed']
                ],[
                    'password.confirmed' => 'Passwords do not match!'
                ]);

                if(!$validator -> fails()){
                    $passwordBroker -> deleteToken($userReset);
                    $userReset -> password = Hash::make($passwords['password']);
                    $userReset -> save();

                    $response['redirect'] = route('login');
                    $response['success'] = true;
                }else{
                    $response['error'] = $validator -> errors() ->first();
                };
            }else{
                $response['error'] = 'Invalid reset link!';
            }

            return response($response);
        }else{
            return view('auth',compact('element','userReset','validResetLink','params'));
        }
    }   

    /*

        Forgot

    */
    public function forgot(Request $request){
        $validator = Validator::make($request->all(),[
            'email' => ['required','string','email'],
        ],[
            'email.email' => 'Not a valid email address!'
        ]);
       
        if(!$validator -> fails()){
            $user = User::where('email',$request -> input('email')) -> first();

            if($user){
                $passwordBroker = Password::broker();
                $token = $passwordBroker -> createToken($user);
                $user -> notify(new UserResetPasswordEmail($token));
            }

            $response = ['success'=>true];
        }else{
            $response = ['success'=>false,'error'=>$validator -> errors() ->first()];
        }

        return response($response);
    }

    /*

        Authenticate

    */
    public function authenticate(Request $request){
        $validator = Validator::make($request->all(),[
            'email' => ['required','string','email'],
            'password' => ['required','string']
        ],[
            'email.email' => 'Not a valid email address!'
        ]);
       
        if(!$validator -> fails()){
            $authAttempt = Auth::attempt($request->only('email', 'password'),true);
            $user = $authAttempt ? Auth::user() : null;
            $role = $user ? $user -> role : null;

            $response = $authAttempt ? ['success'=>true,'redirect'=>route($role -> slug)] : ['success'=>false,'error'=>'Invalid credentials!'];
        }else{
            $response = ['success'=>false,'error'=>$validator -> errors() ->first()];
        }

        return response($response);
    }
}
