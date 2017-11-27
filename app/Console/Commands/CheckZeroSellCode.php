<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;


use App\User;
use App\Member;
use App\MemberAccount;
use App\SellCodeOwner;
use App\AccountSellCodeMonitor;

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
        /*
         * get all active member account
         */
        $accounts = MemberAccount::where('status', 1)
                                ->where('available', 0)
                                ->get(['id', 'user_name', 'user_id', 'account_alias', 'account_id']);
        /*
         * check if the account has 0 sell code
         */
        foreach($accounts as $acc) {
            // check the number of sell code remaining
            if(count($acc->codes) == 0) {
                // add to the monitoring
                $mon = new AccountSellCodeMonitor();
                $mon->account_id = $acc->id;
                $mon->save();
            }
        }
         
        $this->info('Check Zero Code Success');
    }
}
