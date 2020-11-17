<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Notifications\StudentFollowUpEmail;
use App\User;

class SendFollowUpEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:followup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send follow up emails';

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
        $users = User::where('role_id',2) -> get();
        
        foreach($users as $key => $user){
            $user -> notify(new StudentFollowUpEmail());
        }
    }
}
