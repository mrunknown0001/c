<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;


use App\User;
use App\Member;
use App\MemberAccount;
use App\AccountSellCodeMonitor;

class DisableMember extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'members:disable';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Disable Members if 3 accounts is disabled/inactive';

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
         * find members that as 3 disabled account
         */
        $members = User::where('active', 1)->where('privilege', 5)->get();

        foreach($members as $member) {
            // check if the member has 3 disabled accounts
            if(count($member->accounts->where('status', 0)) > 2) {
                // disable the member account
                // make users table active to 0
                $member->active = 0;
                $member->save();
                // make all accounts status 0 and available 1
                foreach($member->accounts as $acc) {
                    $acc->status = 0;
                    $acc->available = 1;
                    $acc->save();
                }
            }
        }


        $this->info('Members Disabled!');
    }
}
