<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use App\Item;

class CreateItem extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'item:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new item';

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
        $name = $this->ask('name');
        $slug = Str::slug($name,'-');

        $item = new Item();
        $item -> name = $name;
        $item -> slug = $slug;
        $item -> save();

        $this->info('Item created');
    }
}
