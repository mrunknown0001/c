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
        	'password' => bcrypt('admin12345'),
        	'privilege' => 1,
            'active' => 1
        ]);
    }
}
