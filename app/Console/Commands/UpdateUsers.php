<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use App\User;
use App\UserMeta;

class UpdateUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates users from s4yt website';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $page = 1;
        
        while($page !== 0){
            $httpRequestPosts = Http::get('http://building-u.com/wp-json/building-u/v1/leads?page='.$page.'&taxonomy=student-registration');
        
            if($httpRequestPosts -> ok()){
                $data = $httpRequestPosts -> json();

                if(isset($data['success']) && $data['success']){
                    $users = $data['leads'];
                    
                    foreach($users as $user){
                        $userEmail = isset($user['meta']['email']) ? $user['meta']['email'] : null;

                        if($userEmail){
                            $user = User::where('email',$userEmail) -> first();

                            if(!$user){
                                $token = Str::random(80);

                                $user = new User();
                                $user -> role_id = 2;
                                $user -> email = $email;
                                $user -> password = Hash::make($token);
                                $user -> api_token = $token;
                            }

                            $user -> first_name = $user['meta']['first_name'];
                            $user -> last_name = $user['meta']['last_name'];
                            $user -> save();

                            //metadata
                            $metaData = ['contact_email','phone','grade','city_state','instagram'];

                            foreach($metaData as $key => $meta){
                                if(isset($user['meta'][$meta])){
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
                        }
                    }
                }
            }

            $page = 0;
        };
    }
}
