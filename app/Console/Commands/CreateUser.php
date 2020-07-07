<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use App\User;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user';

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
        $role = $this->ask('Role');
        $firstName = $this->ask('First Name');
        $lastName = $this->ask('Last Name');
        $email = $this->ask('Email Address');
        $password = Hash::make($this->secret('Password'));
        $token = Str::random(80);

        $user = new User();
        $user -> role_id = $role;
        $user -> first_name = $firstName;
        $user -> last_name = $lastName;
        $user -> email = $email;
        $user -> password = $password;
        $user -> api_token = $token;
        $user -> save();

        $this->info('API Token: '.$token);

    }
}
