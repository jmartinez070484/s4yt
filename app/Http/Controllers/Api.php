<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Notifications\StudentRegistrationEmail;
use App\User;
use App\UserMeta;

class Api extends Controller
{
	/*

		User

    */
	public function user(Request $request){
		$user = Auth::user();
		$response = ['success'=>true,'user'=>$user];

		return response($response);
	}

    /*

		Students

    */
	public function students(Request $request){
		$user = Auth::user();
		$role = $user -> role;
		
		if($role -> id === 1){
			$data = $request->all();
			$validator = Validator::make($data,[
	            'first_name' => ['required','string'],
	            'last_name' => ['required','string'],
	            'email' => ['required','string','email','unique:users'],
	            'institution'=>['required','string'],
	            'grade'=>['required','string'],
	            'dob'=>['required','string'],
	            'city_state'=>['required','string'],
	            'phone'=>['required','string'],
	            'wp_user'=>['required','string'],
	        ]);
	       
	        if(!$validator -> fails()){
	        	$newUser = new User();
	        	$newUser -> role_id = 2;
	        	$newUser -> first_name = $data['first_name'];
	        	$newUser -> last_name = $data['last_name'];
	        	$newUser -> email = $data['email'];
	        	$newUser -> password = Hash::make(Str::random(40));
        		$newUser -> api_token = Str::random(80);	
	        	$newUser -> save();

	        	$metadata = ['institution','grade','dob','city_state','phone','wp_user'];

	        	foreach($metadata as $key){
	        		if(isset($data[$key])){
	        			$newUserMeta = new UserMeta();
	        			$newUserMeta -> user_id = $newUser -> id;
		        		$newUserMeta -> key = $key;
		        		$newUserMeta -> value = $data[$key];
		        		$newUserMeta -> save();
	        		}
	        	}

	        	$newUser -> notify(new StudentRegistrationEmail());
	        	$newUser -> tickets;
	        	
	            $response = ['success'=>true,'user'=>$newUser];
	        }else{
	            $response = ['success'=>false,'error'=>$validator -> errors() ->first()];
	        }
		}else{
			$response = ['success'=>false,'error'=>'Invalid credentials authorization!'];
		}

        return response($response);
	}

	/*

		Students

    */
	public function business(Request $request){
		$user = Auth::user();
		$role = $user -> role;
		
		if($role -> id === 1){
			$data = $request->all();
			$validator = Validator::make($data,[
	            'first_name' => ['required','string'],
	            'last_name' => ['required','string'],
	            'email' => ['required','string','email','unique:users'],
	            'business'=>['required','string'],
	            'city_state'=>['required','string'],
	            'phone'=>['required','string'],
	            'wp_user'=>['required','string'],
	        ]);
	       
	        if(!$validator -> fails()){
	        	$newUser = new User();
	        	$newUser -> role_id = 3;
	        	$newUser -> first_name = $data['first_name'];
	        	$newUser -> last_name = $data['last_name'];
	        	$newUser -> email = $data['email'];
	        	$newUser -> password = Hash::make(Str::random(40));
        		$newUser -> api_token = Str::random(80);	
	        	$newUser -> save();

	        	$metadata = ['business','city_state','phone','wp_user'];

	        	foreach($metadata as $key){
	        		if(isset($data[$key])){
	        			$newUserMeta = new UserMeta();
	        			$newUserMeta -> user_id = $newUser -> id;
		        		$newUserMeta -> key = $key;
		        		$newUserMeta -> value = $data[$key];
		        		$newUserMeta -> save();
	        		}
	        	}

	            $response = ['success'=>true,'user'=>$newUser];
	        }else{
	            $response = ['success'=>false,'error'=>$validator -> errors() ->first()];
	        }
		}else{
			abort(404);
		}

        return response($response);
	}
}
