<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Notifications\StudentRegistrationEmail;
use App\Notifications\BusinessRegistrationEmail;
use App\Notifications\ItemWinner;
use App\User;
use App\UserMeta;
use App\Ticket;
use App\Item;
use App\Business;
use App\Question;
use App\Schedule;  
use App\Scholarship; 

class Admin extends Controller
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

		Index

    */
    public function index(Request $request){

    	return redirect() -> route('admin.students');
    }

    /*

        Items

    */
    public function items(Request $request){
        $items = Item::all();

        return view('admin.items',compact('items'));
    }

    /*


    */
    public function userEmail(Request $request,User $user){
        $response = ['success'=>true,'user'=>$user];

        if($user -> role_id == 2){
            $user -> notify(new StudentRegistrationEmail());
        }else if($user -> role_id == 3){
            $user -> notify(new BusinessRegistrationEmail());
        }

        return response($response);
    }

    /*

        Winner Item

    */
    public function winnerItem(Request $request,Item $item){
        $response = ['success'=>true,'item'=>$item];

        if(!$item -> user_id || $item -> user_id){
            $ticket = Ticket::where('item_id',$item -> id) -> where('status',1) -> inRandomOrder() -> limit(1) -> first();

            if(!$ticket){
                $ticket = Ticket::where('item_id',$item -> id) -> inRandomOrder() -> limit(1) -> first();
            }

            if($ticket && $ticket -> user_id){
                Ticket::where('user_id',$ticket -> user_id) -> update(['status'=>1]);

                $item -> user_id = $ticket -> user_id;
                $item -> status = 2;
                $item -> save();

                //send email
                $user = $ticket -> winner;
                $user -> notify(new ItemWinner($item));
            }

            $response['ticket'] = $ticket;
        }

        return response($response);
    }   

    /*

        Edit Item

    */
    public function editItem(Request $request,Item $item){
        if($request->isMethod('post')){
            $data = $request->all();
            $validator = isset($data['slug']) && $data['slug'] == $item -> slug ? Validator::make($data,[
                'name' => ['required','string'],
                'slug' => ['required','string'],
            ]) : Validator::make($data,[
                'name' => ['required','string'],
                'slug' => ['required','string','unique:items'],
            ]);

            if(!$validator -> fails()){
                $item -> name = $data['name'];
                $item -> slug = Str::slug($data['slug'],'-');

                if($request -> hasFile('image')){
                    $item -> image = 'item-'.$item -> id.'.'.$request -> file('image') -> extension();
                    $request -> image -> storeAs('',$item -> image,'public');
                }

                $item -> save();

                $response = ['success'=>true,'redirect'=>route('admin.items.details',['item'=>$item -> id,'success'=>1])];
            }else{
                $response = ['success'=>false,'error'=>$validator -> errors() ->first()];
            }

            return response($response);
        }else{
            return view('admin.items-details',compact('item'));
        }
    }

    /*

        New Image

    */
    public function newItem(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            $validator = Validator::make($data,[
                'name' => ['required','string'],
                'slug' => ['required','string','unique:items'],
                'image'=>['required','file'],
            ]);

            if(!$validator -> fails()){
                $item = new Item();
                $item -> name = $data['name'];
                $item -> slug = Str::slug($data['slug'],'-');
                $item -> save();

                if($request->hasFile('image')){
                    $fileName = 'item-'.$item -> id.'.'.$request -> file('image') -> extension();
                    $item -> image = $fileName;
                    $filePath = $request -> image -> storeAs('',$fileName,'public');
                }

                $item -> save();

                $response['redirect'] = route('admin.items.details',['item'=>$item -> id,'success'=>1]);
                $response['success'] = true;
                $response['file'] = $filePath;
            }else{
                $response['error'] = $validator -> errors() ->first();
            }

            return response($response);
        }else{
            return view('admin.items-new');
        }
    }

    /*

		Students

    */
    public function students(Request $request){
        $query = $request -> input('q');
        $users = $query ? User::where('role_id',2) -> where('email','LIKE','%'.$query.'%') -> orWhere('first_name','LIKE','%'.$query.'%') -> where('role_id',2) -> orWhere('last_name','LIKE','%'.$query.'%') -> where('role_id',2) -> paginate(20) : User::where('role_id',2) -> paginate(20);
        $type = 'students';

    	return view('admin.listing',compact('users','type'));
    }

    /*

        Business Schedule

    */
    public function businessSchedule(Request $request,User $user){
        $role = $user -> role;
        
        if($role -> id == 3){
            if($request->isMethod('post')){
                $data = $request->all();
                $response = ['success'=>false];
               
                return response($response);
            }else{
                $business = $user -> business;
                $schedule = $business -> schedule;

                return view('admin.business-schedule',compact('user','business','schedule'));
            }
        }

        abort(404);
    }

    /*

        New Business Schedule

    */
    public function businessScheduleItem(Request $request,User $user, Schedule $schedule){
        $role = $user -> role;
        $business = $user -> business;
        
        if($role -> id == 3 && $business -> id == $schedule -> business_id){
            if($request->isMethod('post')){
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

                    $response['redirect'] = route('admin.business.schedule.item',['user'=>$user -> id,'schedule'=>$schedule -> id,'success'=>1]);
                    $response['success'] = true;
                }else{
                    $response['error'] = $validator -> errors() ->first();
                }
               
                return response($response);
               
                return response($response);
            }else if($request->isMethod('delete')){
                $response = $schedule -> delete() ? ['success'=>true] : ['success'=>true];

                return response($response);
            }else{
                return view('admin.business-schedule-item',compact('user','business','schedule'));
            }
        }

        abort(404);
    }

    /*

        New Business Schedule

    */
    public function businessScheduleNew(Request $request,User $user){
        $role = $user -> role;
        
        if($role -> id == 3){
            if($request->isMethod('post')){
                $data = $request->all();
                $validator = Validator::make($data,[
                    'time' => ['required','string'],
                    'text' => ['required','string']
                ]);
                $response = ['success'=>false];
               
                if(!$validator -> fails()){
                    $business = $user -> business;
                    $schedule = new Schedule();
                    $schedule -> business_id = $business -> id;
                    $schedule -> time = $data['time'];
                    $schedule -> content = $data['text'];
                    $schedule -> save();

                    $response['redirect'] = route('admin.business.schedule.item',['user'=>$user -> id,'schedule'=>$schedule -> id,'success'=>1]);
                    $response['success'] = true;
                }else{
                    $response['error'] = $validator -> errors() ->first();
                }
               
                return response($response);
            }else{
                $business = $user -> business;
                return view('admin.business-schedule-new',compact('user','business'));
            }
        }

        abort(404);
    }

    /*

        Business Profile

    */
    public function businessQuestion(Request $request,User $user){
        $role = $user -> role;
        
        if($role -> id == 3){
            if($request->isMethod('post')){
                $data = $request->all();
                
                $validator = Validator::make($data,[
                    'question' => ['required','string']
                ]);
                $response = ['success'=>false];
               
                if(!$validator -> fails()){
                    $business = $user -> business;
                    $question = $business -> question;

                    if(!$question){
                        $question = new Question();
                        $question -> business_id = $business -> id;
                    }

                    $question -> text = $data['question'];
                    $question -> save();

                    $response['success'] = true;
                    $response['redirect'] = route('admin.business.question',['user'=>$user -> id,'success'=>1]);
                }else{
                    $response['error'] = $validator -> errors() ->first();
                }

                return response($response);
            }else{
                $business = $user -> business;

                return view('admin.business-question',compact('user','business'));
            }
        }

        abort(404);
    }

    /*

        Business Profile

    */
    public function businessProfile(Request $request,User $user){
        $role = $user -> role;
        
        if($role -> id == 3){
            if($request->isMethod('post')){
                $data = $request->all();
                $sameEmail = isset($data['email']) && $data['email'] == $user -> email ? true : false;
                $validator = $sameEmail ? Validator::make($data,[
                    'first_name' => ['required','string'],
                    'last_name' => ['required','string'],
                    'email' => ['required','string','email'],
                    'business'=>['required','string'],
                    'slug'=>['required','string'],
                    'description'=>['required','string']
                ]) : Validator::make($data,[
                    'first_name' => ['required','string'],
                    'last_name' => ['required','string'],
                    'email' => ['required','string','email','unique:users'],
                    'business'=>['required','string'],
                    'slug'=>['required','string'],
                    'description'=>['required','string']
                ]);
                $response = ['success'=>false];
               
                if(!$validator -> fails()){
                    $user -> first_name = $data['first_name'];
                    $user -> last_name = $data['last_name'];
                    $user -> email = $data['email'];
                    $user -> save();

                    $business = $user -> business;

                    if(!$business){
                        $business = new Business();
                        $business -> user_id = $user -> id;
                    }

                    $business -> name = $data['business'];
                    $business -> slug = Str::slug($data['slug'],'-');
                    $business -> description = $data['description'];
                    $business -> short_description = $data['short_description'];
                    $business -> zoom_link = isset($data['zoom_link']) ? $data['zoom_link'] : null;
                    $business -> youtube = isset($data['youtube']) ? $data['youtube'] : null;

                    if($request->hasFile('logo')){
                        $fileName = 'logo-'.$business -> id.'.'.$request -> file('logo') -> extension();
                        $filePath = $request -> logo -> storeAs('',$fileName,'public');
                        $business -> logo = $fileName;
                    }

                    if($request->hasFile('icon')){
                        $fileName = 'icon-'.$business -> id.'.'.$request -> file('icon') -> extension();
                        $filePath = $request -> icon -> storeAs('',$fileName,'public');
                        $business -> icon = $fileName;
                    }

                    $business -> save();

                    $response['redirect'] = route('admin.business.profile',['user'=>$user -> id,'success'=>1]);
                    $response['success'] = true;
                }else{
                    $response['error'] = $validator -> errors() ->first();
                }

                return response($response); 
            }else{
                $business = $user -> business;

                return view('admin.business',compact('user','business'));
            }
        }

        abort(404);
    }

    /*

        Student Profile

    */
    public function studentProfile(Request $request,User $user){
        $role = $user -> role;
        
        if($role -> id == 2){
            if($request->isMethod('post')){
                $data = $request->all();
                $validator = isset($data['email']) && $data['email'] == $user -> email ? Validator::make($data,[
                    'first_name' => ['required','string'],
                    'last_name' => ['required','string'],
                    'institution'=>['required','string'],
                    'grade'=>['required','string'],
                    'dob'=>['required','string'],
                    'city_state'=>['required','string'],
                    'phone'=>['required','string']
                ]) : Validator::make($data,[
                    'first_name' => ['required','string'],
                    'last_name' => ['required','string'],
                    'email' => ['required','string','email','unique:users'],
                    'institution'=>['required','string'],
                    'grade'=>['required','string'],
                    'dob'=>['required','string'],
                    'city_state'=>['required','string'],
                    'phone'=>['required','string']
                ]);
                $response = ['success'=>false];
               
                if(!$validator -> fails()){
                    $user -> first_name = $data['first_name'];
                    $user -> last_name = $data['last_name'];
                    $user -> email = $data['email'];
                    $user -> save();

                    $metadata = ['institution','grade','dob','city_state','phone'];

                    foreach($metadata as $meta){
                        if(isset($data[$meta])){
                            $metaItem = UserMeta::where('user_id',$user -> id) -> where('key',$meta) -> first();

                            if(!$metaItem){
                                $metaItem = new UserMeta();
                                $metaItem -> user_id = $user -> id;
                                $metaItem -> key = $meta;
                            };

                            $metaItem -> value = $data[$meta];
                            $metaItem -> save();
                        }
                    }

                    $response['redirect'] = route('admin.students.profile',['user'=>$user -> id,'success'=>1]);
                    $response['success'] = true;
                }else{
                    $response['error'] = $validator -> errors() ->first();
                }

                return response($response); 
            }else{
                return view('admin.student',compact('user','metaData'));
            }
        }

        abort(404);
    }

    /*

        Student Tickets

    */
    public function studentTickets(Request $request,User $user){
        $role = $user -> role;
        
        if($role -> id == 2){
            if($request->isMethod('post')){
                $response = ['success'=>true];

                $ticket = new Ticket();
                $ticket -> user_id = $user -> id;
                $ticket -> save();

                return response($response);
            }else{
                $tickets = $user -> tickets;

                return view('admin.student-tickets',compact('user','tickets'));
            }
        }

        //abort(404);
    }

    /*

        Student create

    */
    public function studentCreate(Request $request){
        if($request->isMethod('post')){
            $response = ['success'=>false];

            $data = $request->all();
            $validator = Validator::make($data,[
                'first_name' => ['required','string'],
                'last_name' => ['required','string'],
                'email' => ['required','string','email','unique:users'],
                'institution'=>['required','string'],
                'grade'=>['required','string'],
                'dob'=>['required','string'],
                'city_state'=>['required','string'],
                'phone'=>['required','string']
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

                $metadata = ['institution'=>'Institution','grade'=>'Grade','dob'=>'Date of Birth','city_state'=> 'City/State','phone'=>'Phone Number'];

                foreach($metadata as $key => $value){
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
                
                $response['success'] = true;
                $response['user'] = $newUser;
                $response['redirect'] = route('admin.students.profile',['user'=>$newUser -> id]);
            }else{
                $response['error'] = $validator -> errors() ->first();
            }

            return response($response);
        }else{
            return view('admin.student-new');
        }
    }

    /*

        Business create

    */
    public function businessCreate(Request $request){
        if($request->isMethod('post')){
            $response = ['success'=>false];

            $data = $request->all();
            $validator = Validator::make($data,[
                'first_name' => ['required','string'],
                'last_name' => ['required','string'],
                'email' => ['required','string','email','unique:users'],
                'business'=>['required','string'],
                'slug'=>['required','string','unique:businesses'],
                'description'=>['required','string'],
                'logo'=>['required','file'],
                'icon'=>['required','file']
            ]);
           
            if(!$validator -> fails()){
                $newUser = new User();
                $newUser -> role_id = 3;
                $newUser -> first_name = $data['first_name'];
                $newUser -> last_name = $data['last_name'];
                $newUser -> email = $data['email'];
                $newUser -> password = Hash::make(Str::random(80));
                $newUser -> api_token = Str::random(80);    
                $newUser -> save();

                $business = new Business();
                $business -> user_id = $newUser -> id;
                $business -> name = $data['business'];
                $business -> slug = Str::slug($data['slug'],'-');
                $business -> description = $data['description'];
                $business -> short_description = $data['short_description'];
                $business -> zoom_link = isset($data['zoom_link']) ? $data['zoom_link'] : null;
                $business -> youtube = isset($data['youtube']) ? $data['youtube'] : null;
                $business -> save();

                if($request->hasFile('logo')){
                    $fileName = 'logo-'.$business -> id.'.'.$request -> file('logo') -> extension();
                    $filePath = $request -> logo -> storeAs('',$fileName,'public');
                    $business -> logo = $fileName;
                }

                if($request->hasFile('icon')){
                    $fileName = 'icon-'.$business -> id.'.'.$request -> file('icon') -> extension();
                    $filePath = $request -> icon -> storeAs('',$fileName,'public');
                    $business -> icon = $fileName;
                }

                $business -> save();

                $response['success'] = true;
                $response['business'] = $business;
                $response['redirect'] = route('admin.business.profile',['user'=>$newUser -> id,'success'=>1]);
            }else{
                $response['error'] = $validator -> errors() ->first();
            }

            return response($response);
        }else{
            return view('admin.business-new');
        }
    }

    /*

        Business scholarships

    */
    public function businessScholarships(Request $request,User $user){
        $business = $user -> business;
        $scholarships = Scholarship::where('business_id',$business -> id) -> get();

        return view('admin.business-scholarships',compact('scholarships','user'));
    }

    /*

        Delete User

    */
    public function deleteUser(Request $request,User $user){
        if($user -> role_id == 2 || $user -> role_id == 3){
            $response = $user -> delete() ? ['success'=>true] : ['success'=>false];

            return response($response);
        }else{
            abort(403);
        }
    }

    /*

        Delete Ticket

    */
    public function deleteTicket(Request $request,User $user,Ticket $ticket){
        if($user -> role_id == 2 && $ticket -> user_id == $user -> id){
            $response = $ticket -> delete() ? ['success'=>true] : ['success'=>false];

            return response($response);
        }else{
            abort(403);
        }
    }

    /*

        Delete Item

    */
    public function deleteItem(Request $request,Item $item){
        if($item){
            $tickets = Ticket::where('item_id',$item -> id) ->update(['item_id' => null]);

            if(Storage::disk('public') -> exists($item -> image) && $item -> image !== 'default.png'){
                Storage::disk('public') -> delete($item -> image);
            }

            $item -> delete();
            $response = ['success'=>true];

            return response($response);
        }else{
            abort(403);
        }
    }

    /*

		Business

    */
    public function business(Request $request,User $business){
        $query = $request -> input('q');
        $users = $query ? User::where('role_id',3) -> where('email','LIKE','%'.$query.'%') -> orWhere('first_name','LIKE','%'.$query.'%') -> where('role_id',2) -> orWhere('last_name','LIKE','%'.$query.'%') -> paginate(20) : User::where('role_id',3) -> paginate(20);
        $type = 'business';

    	return view('admin.listing',compact('users','type'));
    }
}
