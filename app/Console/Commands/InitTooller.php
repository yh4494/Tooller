<?php

namespace App\Console\Commands;

use App\Model\User;
use Illuminate\Console\Command;

class InitTooller extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'init:tooller';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $user = new User();
        $user->name     = 'admin';
        $user->level    = 1;
        $user->password = md5('admin888');
        $user->save();
    }
}
