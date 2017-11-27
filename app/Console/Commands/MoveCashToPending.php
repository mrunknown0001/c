<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;


use App\MyCash;
use App\MemberBalance;
use App\User;
use App\Member;


class MoveCashToPending extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cash:movetopending';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Move Cash to Pending';

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
         * find all users that has cash total and direct referral
         * and must have no balance
         */
        $users = User::where('active', 1)
                    ->where('privilege', 5)
                    ->get();


        /*
         * each users cash will go to the pending cash
         */
        foreach($users as $user) {
            if($user->member->balance->current == 0) {
                if($user->cash->total > 0 || $user->cash->direct_referral > 0) {
                    $user->cash->pending += $user->cash->total + $user->cash->direct_referral;

                    $user->cash->total = 0;
                    $user->cash->direct_referral = 0;
                    $user->cash->save();
                }
            }
        }


        $this->info('Successfully Moved Cash to Pending');
        
    }
}
