<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use App\User;
use App\Ticket;
use App\Item;
use App\Business;
use App\Answer;
use App\Visit;

class Event extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->middleware(['auth','auth.roles'])->except('oops');
    }

    /*

        Event Index

    */
    public function chatroom(){
        return view('event.chatroom');
    }

    /*

        Event Index

    */
    public function index(){
        return view('event.index');
    }

    /*

		Event maps

    */
    public function enterprise(){
        $businesses = Business::where('status',1) -> get();

        return view('event.enterprise',compact('businesses'));
    }

    /*

        Event business

    */
    public function business(Request $request,Business $business){
        if($business -> status == 1){
            $userId = Auth::id();
            $visit = Visit::where('user_id',$business -> id) -> where('user_id',$userId) -> get() -> first();

            if(!$visit){
                $visit = new Visit();
                $visit -> user_id = $userId;
                $visit -> business_id = $business -> id;
            }

            $visit -> save();

            return view('event.business',compact('business'));
        }else{
            abort(404);
        }
    }

    /*

        Event question

    */
    public function question(Request $request,Business $business){
        $question = $business -> question;

        if($question){
            $answer = $question -> user_answer;

            if($request->isMethod('post')){
                $postData = $request -> all();
                $response = ['success'=>false];

                //validate 
                $validator = Validator::make($postData,[
                    'answer' => ['required','string'],
                ]);

                if(!$validator -> fails()){
                    if(!$answer){
                        $answer = new Answer();
                        $answer -> question_id = $question -> id;
                        $answer -> user_id = Auth::id();
                    }

                    if($answer -> status !== 2){
                        $answer -> text = $postData['answer'];

                        if(isset($postData['status']) && $postData['status'] == 2){
                            $answer -> status = 2;
                        }

                        $answer -> save();

                        $response['success'] = true;
                    }else{
                        $response['error'] = 'Answer has been submitted and closed!';
                    }
                }else{
                    $response['error'] = $validator -> errors() ->first();
                };

                return response($response);
            }else if($request->isMethod('delete')){
                $response = ['success'=>true,'redirect'=>route('business',['business'=>$question -> business -> slug])];

                if($answer && $answer -> status !== 2){
                    $answer -> delete();
                }

                return response($response);
            }else{
                return view('event.question',compact('business','question','answer'));
            }
        }else{
            abort(404);
        }
    }

    /*

        Item winners

    */
    public function itemWinners(){
        $items = Item::where('status',2) -> whereNotNull('user_id') -> get();
            
        return view('event.items-winners',compact('items','user'));
    }

    /*

		Items

    */
    public function items(Request $request,Item $item){
        $user = Auth::user();

        if($request->isMethod('post')){
            $postData = $request -> all();
            $response = ['success'=>false];

            //validate 
            $validator = Validator::make($postData,[
                'qty' => ['required','int'],
                'change' => ['required','int']
            ]);

            if(!$validator -> fails()){
                $change = (int) $postData['change'];

                if($change == 1){
                    $userTickets = $user -> tickets;
                    $ticket = $userTickets -> whereNull('item_id') -> first();

                    if($ticket){
                        $ticket -> item_id = $item -> id;
                        $ticket -> save();
                    }
                }else{
                    $ticket = $item -> user_tickets -> first();

                    if($ticket){
                        $ticket -> item_id = null;
                        $ticket -> save();
                    }
                }

                if(!$ticket){
                    $response['error'] = $change == 1 ? 'You have used up all of your '.$userTickets -> count().' tickets!' : 'No more tickets to remove!';
                }

                $response['success'] = isset($response['error']) ? false : true;
                $response['change'] = $change;
                $response['tickets'] = $user -> tickets -> whereNull('item_id') -> count();
            }else{
                $response['error'] = $validator -> errors() ->first();
            };

            return response($response);
        }else{
            $items = Item::where('status',1) -> paginate(10);
            $total = $items -> count();
            
            return view('event.items',compact('items','user','total'));
        }
    }

    /*

        Event Cart

    */
    public function account(){
        $user = Auth::user();
        $collection = $user -> tickets -> whereNotNull('item_id') -> groupBy('item_id');
        $answers = $user -> answers;
        
        return view('event.account',compact('collection','answers'));
    }

    /*

        Landing

    */
    public function oops(){
        $launchDate = Carbon::createFromTimestamp(env('APP_LAUNCH_DATE'),'America/New_York');
        $launchDisplayDate = $launchDate -> format('M dS').' <br />at '.$launchDate -> format('g:ia');
        $element = 'message';

        return view('auth',compact('element','launchDisplayDate'));
    }

    /*

        Event Winners

    */
    public function winners(){
        $businesses = Business::all();
        
        return view('event.winners',compact('businesses'));
    }

    /*

        Elements

    */
    public function elements(Request $request){
        $postData = $request -> all();
        $response = ['success'=>false];

        //validate 
        $validator = Validator::make($postData,[
            'element' => ['required','string']
        ]);

        if(!$validator -> fails()){
            $element = 'partials.'.$postData['element'];

            if(view() -> exists($element)){
                $response['element'] = view($element) -> render();
                $response['success'] = true;
            }else{
                $response['error'] = 'Element does not exist';
            }
        }else{
            $response['error'] = 'Element does not exist';
        }

        return response($response);
    }
}
