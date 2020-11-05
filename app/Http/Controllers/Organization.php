<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Notifications\ScholarshipWinner;
use App\Answer;
use App\Schedule;
use App\Scholarship;
use App\Business;
use App\Item;

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
                'description' => ['required','string'],
                'zoom_link' => ['required','string']
            ]) : Validator::make($data,[
                'first_name' => ['required','string'],
                'last_name' => ['required','string'],
                'business' => ['required','string'],
                'description' => ['required','string'],
                'zoom_link' => ['required','string']
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
                $business -> zoom_link = $data['zoom_link'];
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
            $schedule = $business -> schedule;

            return view('organization.schedule',compact('business','schedule'));
        }
    }

    /*

        Schedule Edit

    */
    public function scheduleEdit(Request $request,Schedule $schedule){
        $user = Auth::user();
        $business = $user -> business;

        if($request -> isMethod('post')){
            $data = $request->all();
            $validator = Validator::make($data,[
                'time' => ['required','string'],
                'text' => ['required','string']
            ]);
            $response = ['success'=>false];
           
            if(!$validator -> fails()){
                $schedule -> time = $data['time'];
                $schedule -> content = $data['text'];
                $schedule -> save();

                $response['redirect'] = route('organization.schedule.item',['schedule'=>$schedule -> id,'success'=>1]);
                $response['success'] = true;
            }else{
                $response['error'] = $validator -> errors() ->first();
            }
           
            return response($response);
        }else if($request -> isMethod('delete')){
            $schedule -> delete();

            return response(['success'=>true]);
        }else{
            return view('organization.schedule-edit',compact('business','schedule'));
        }
    }

    /*

        Schedule New

    */
    public function scheduleNew(Request $request){
        $user = Auth::user();
        $business = $user -> business;

        if($request -> isMethod('post')){
            $data = $request->all();
            $validator = Validator::make($data,[
                'time' => ['required','string'],
                'text' => ['required','string']
            ]);
            $response = ['success'=>false];
           
            if(!$validator -> fails()){
                $schedule = new Schedule();
                $schedule -> business_id = $business -> id;
                $schedule -> time = $data['time'];
                $schedule -> content = $data['text'];
                $schedule -> save();

                $response['redirect'] = route('organization.schedule.item',['schedule'=>$schedule -> id,'success'=>1]);
                $response['success'] = true;
            }else{
                $response['error'] = $validator -> errors() ->first();
            }
           
            return response($response);
        }else{
            return view('organization.schedule-new',compact('business'));
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
            $question = $business -> question;

            return view('organization.question',compact('business','question'));
        }
    }

    /*

        Answer Details

    */
    public function answersDetails(Request $request,Answer $answer){
        $user = Auth::user();
        $business = $user -> business;
        $question = $business -> question;
        
        if($answer -> question -> business_id == $business -> id){
            if($request -> isMethod('post')){
                $data = $request->all();

                if(isset($data['score']) && is_numeric($data['score']) && in_array($data['score'],array(1,2,3))){
                    $answer -> score = $data['score'];
                    $answer -> save();
                }

                return response(['success'=>true,'redirect'=>route('organization.answers.details',['answer'=>$answer -> id,'success'=>1])]);
            }else{
                $student = $answer -> user;
                $scholarships = $business -> scholarships;
                $answerScholarship = $answer -> scholarship;
                
                return view('organization.answer-details',compact('business','question','answer','student','scholarships','answerScholarship'));   
            }
        }else{
            abort(404);
        }
    }

    /*

        Answer Winner

    */
    public function answersWinner(Request $request,Answer $answer){
        $user = Auth::user();
        $business = $user -> business;
        $question = $business -> question;
        $scholarship = Scholarship::find($request->all('scholarship')) -> first();

        if($question -> id == $answer -> question_id && $scholarship -> business_id == $business -> id && !$scholarship -> user_id){
           $scholarship -> user_id = $answer -> user_id;
           $scholarship -> answer_id = $answer -> id;
           $scholarship -> save();

           //user
           $answerUser = $answer -> user;
           $answerUser -> notify(new ScholarshipWinner($scholarship));
        }

        //user
        $answerUser = $answer -> user;
        $answerUser -> notify(new ScholarshipWinner($scholarship));
        
        return response(['success'=>true,'redirect'=>route('organization.answers.details',['answer'=>$answer -> id,'success'=>1])]);
    }

    /*

        Answers

    */
    public function answers(Request $request){
        $user = Auth::user();
        $business = $user -> business;
        $question = $business -> question;
        $scholarships = $business -> scholarships;
        $answers = Answer::query() -> where('question_id',$question -> id);

        foreach($scholarships as $scholarship){
            $answers = $answers -> where('id','!=',$scholarship -> answer_id);
        }

        $answers = $answers -> orderBy('created_at','DESC') -> paginate(25);
       
        return view('organization.answers',compact('business','question','answers','scholarships'));
    }

    /*

        Business scholarships

    */
    public function scholarships(Request $request){
        $user = Auth::user();
        $business = $user -> business;
        $scholarships = Scholarship::where('business_id',$business -> id) -> get();

        return view('organization.scholarships',compact('scholarships'));
    }

    /*

        Organization map

    */
    public function enterprise(Request $request){
        $user = Auth::user();
        $organization = $user -> business;
        $businesses = Business::where('status',1) -> get();

        return view('organization.enterprise',compact('businesses','organization'));
    }

    /*

        Event

    */
    public function event(Request $request){
        return view('organization.event');
    }

    /*

        Organization self

    */
    public function self(Request $request){
        $user = Auth::user();
        $business = $user -> business;

        return view('organization.business',compact('business'));
    }

    /*

        Organization items

    */
    public function items(Request $request){
        $items = Item::where('status',1) -> paginate(10);
        $total = $items -> count();
            
        return view('organization.items',compact('items','user','total'));
    }

    /*

        Organizatioin question

    */
    public function selfQuestion(Request $request){
        $user = Auth::user();
        $business = $user -> business;
        $question = $business -> question;

        if($question){
            return view('organization.view-question',compact('business','question'));
        }else{
            abort(404);
        }
    }
}
