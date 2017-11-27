<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckZeroSellCode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sellcode:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if the account has zero sell code';

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
