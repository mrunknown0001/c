<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        

        // admin user
        DB::table('users')->insert([
        	'username' => 'admin',
        	'firstname' => 'Admin',
        	'lastname' => 'Admin',
        	'password' => bcrypt('admin'),
        	'privilege' => 1,
            'active' => 1
        ]);


        DB::table('system_cashes')->insert([
            'in_cash' => 0,
            'out_cash' => 0
        ]);


        // settings
        DB::table('settings')->insert([
            'system_name' => 'CLLR Trading'
        ]);


        // payment options
        DB::table('payment_options')->insert([
            'name' => 'Coins.Ph',
            'description' => 'Coins.Ph E-wallet'
        ]);

        DB::table('payment_options')->insert([
            'name' => 'Palawan Express',
            'description' => 'Palawan Express Money Remitance'
        ]);

        DB::table('payment_options')->insert([
            'name' => 'Cebuana',
            'description' => 'Cebuana Money Remitance'
        ]);




        DB::table('payout_options')->insert([
            'name' => 'Coins.Ph',
            'description' => 'Coins.Ph Emoney'
        ]);


        DB::table('payout_options')->insert([
            'name' => 'Cebuana',
            'description' => 'Cebuana Money Remitance'
        ]);


        DB::table('payout_options')->insert([
            'name' => 'Bank Deposit',
            'description' => 'Bank Deposit'
        ]);


        DB::table('payout_options')->insert([
            'name' => 'Security Bank eCash',
            'description' => 'Security Bank eCash'
        ]);



        /*
         * Create the top account own by the company
         */
        
        // users table
        DB::table('users')->insert([
            'uid' => '00000000000',
            'username' => 'cllr',
            'firstname' => 'CLLR',
            'lastname' => 'Trading',
            'privilege' => 5,
            'active' => 1,
            'password' => bcrypt('cllr')
        ]);

        // members table
        DB::table('members')->insert([
            'uid' => '00000000000',
            'number_of_accounts' => 1,
            'confirmed' => 1
        ]);

        // memberaccount
        DB::table('member_accounts')->insert([
            'user_name' => 'cllr',
            'user_id' => 2,
            'account_alias' => 'cllr_1',
            'account_id' => '000000000000000',
            'status' => 1,
            'downline_level' => 0
        ]);
        
        // member cash
        DB::table('my_cashes')->insert([
            'user_id' => 2
        ]);

        // avatars table 
        DB::table('avatars')->insert([
            'user_id' => 2,
            'file' => '0'
        ]);
         
        
        // member balances table
        DB::table('member_balances')->insert([
            'uid' => '00000000000'
        ]);

        // auto deduct setting
        DB::table('auto_deducts')->insert([
            'member_id' => '00000000000'
        ]);


        // member tbc info table
        DB::table('member_tbc_infos')->insert([
            'user_id' => 2
        ]);


        // payout settings
        DB::table('payout_settings')->insert([
            'member_uid' => '00000000000',
            'mop' => 'Bank Deposit'
        ]);
    }
}
