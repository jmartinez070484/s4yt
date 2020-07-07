<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Answer;

class Organization extends Controller
{
	/**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','auth.roles']);
    }
    
    /*

		Profile

    */
    public function profile(Request $request){
        $user = Auth::user();
        $business = $user -> business;

        if($request -> isMethod('post')){
            $data = $request->all();
            $updatePassword = isset($data['change_password']) && $data['change_password'] == 1 ? true : false;
            $response = ['success'=>true];

            $validator = $updatePassword ? Validator::make($data,[
                'first_name' => ['required','string'],
                'last_name' => ['required','string'],
                'password' => ['required','string','confirmed'],
                'business' => ['required','string'],
                'description' => ['required','string']
            ]) : Validator::make($data,[
                'first_name' => ['required','string'],
                'last_name' => ['required','string'],
                'business' => ['required','string'],
                'description' => ['required','string']
            ]);

            if(!$validator -> fails()){
                $user -> first_name = $data['first_name'];
                $user -> last_name = $data['last_name'];

                if($updatePassword){
                    $user -> password = Hash::make($data['password']);
                }

                $user -> save();

                $business -> name = $data['business'];
                $business -> description = $data['description'];
                $business -> save();
                
                $response = ['success'=>true,'redirect'=>route('organization',['success'=>1])];
            }else{
                $response['error'] = $validator -> errors() ->first();
            }

            return response($response);
        }else{
            return view('organization.profile',compact('business','user'));
        }
    }

    /*

        Schedule

    */
    public function schedule(Request $request){
        $user = Auth::user();
        $business = $user -> business;

        if($request -> isMethod('post')){
            
        }else{
            return view('organization.schedule',compact('business'));
        }
    }

    /*

        Question

    */
    public function question(Request $request){
        $user = Auth::user();
        $business = $user -> business;

        if($request -> isMethod('post')){
            $data = $request->all();
            $validator = Validator::make($data,[
                'question' => ['required','string']
            ]);

            if(!$validator -> fails()){
                $question = $business -> question;
                $question -> text = $data['question'];
                $question -> save();

                $response = ['success'=>true,'redirect'=>route('organization.question',['success'=>1])];
            }else{
                $response = ['success'=>false,'error'=>$validator -> errors() ->first()];
            }

            return response($response);
        }else{
            return view('organization.question',compact('business'));
        }
    }

    /*


    */
    public function answersDetails(Request $request,Answer $answer){
        $user = Auth::user();
        $business = $user -> business;
        $question = $business -> question;
        
        if($answer -> question -> business_id === $business -> id){
            $student = $answer -> user;

            return view('organization.answer-details',compact('business','answer','student'));
        }else{
            abort(404);
        }
    }

    /*

        Answers

    */
    public function answers(Request $request){
        $user = Auth::user();
        $business = $user -> business;
        $question = $business -> question;
        $answers = Answer::where('question_id',$question -> id) -> orderBy('created_at','DESC') -> paginate(25);
        
        return view('organization.answers',compact('business','answers'));
    }
}
