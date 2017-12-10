<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;


use App\User;
use App\Member;
use App\MemberAccount;
use App\AccountSellCodeMonitor;
use Illuminate\Support\Facades\Mail;
use App\Mail\ZeroSellCodeEmail;

class ZeroSellCodeNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification:zerosellcode';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Notification if the sell code is 0';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }


    private function sendSms($number = null, $message = null)
    {
        // if($number == null) {
        //     return '';
        // }

        $ch = curl_init();
        $parameters = array(
            'apikey' => '8f934d4c8d91337dc98445e52faf85ab', //Your API KEY
            'number' =>  $number,
            'message' => $message,
            'sendername' => 'CLLRTrading'
        );
        curl_setopt( $ch, CURLOPT_URL,'http://api.semaphore.co/api/v4/messages' );
        curl_setopt( $ch, CURLOPT_POST, 1 );

        //Send the parameters set above with the request
        curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $parameters ) );

        // Receive response from server
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        $output = curl_exec( $ch );
        curl_close ($ch);

        //Show the server response
        // return $output;

    }



    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /*
         * find all account in the account_sell_code_monitor
         */
        $accounts = AccountSellCodeMonitor::get();


        foreach($accounts as $acc) {
            // send each sms and email
            Mail::to($acc->account->member->email)->send(new ZeroSEllCodeEmail($acc->days));
            $message = "Your Account has Zero Sell Code";
            // $this->sendSms($acc->account->member->mobile, $message);
            
        } 
        if(count($accounts) > 0)
            foreach($accounts as $acc) {
                // send each sms and email
                Mail::to($acc->account->member->email)->send(new ZeroSEllCodeEmail($acc->days));
                $message = "Your Account has Zero Sell Code";
                // $this->sendSms($acc->account->member->mobile, $message);
                // increase day by 1
                $acc->days += 1;
                $acc->save();
            } 
        }

        $this->info('Notifications has been sent!');
    }
}
