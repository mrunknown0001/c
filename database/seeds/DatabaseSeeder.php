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



    }
}
