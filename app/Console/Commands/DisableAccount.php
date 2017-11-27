<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DisableAccount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'accounts:disable';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Disable Account if 5 days of 0 sell code';

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
        //
    }
}
