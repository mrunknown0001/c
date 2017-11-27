<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;


use App\User;
use App\Member;
use App\MemberAccount;
use App\AccountSellCodeMonitor;

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
        /*
         * find all account that has 5 days of 0 sell code
         */
        $accounts = AccountSellCodeMonitor::where('days', 5)->get();

        foreach($accounts as $acc) {
            $acc->account->status = 0;
            $acc->account->save();

            $acc->delete();
        }

        $this->info('Accounts Disabled!');
    }
}
