<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uid', 11)->unique()->nullable();
            $table->string('username', 15)->unique();
            $table->string('firstname', 100)->nullable();
            $table->string('lastname', 100)->nullable();
            $table->string('gender', 6)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('mobile', 15)->nullable();
            $table->string('email', 80)->unique()->nullable();
            $table->tinyInteger('privilege')->default(5); // 1 => admin, 2,3,4 => co-admin, 5 => members
            $table->tinyInteger('active')->default(0);
            $table->string('password', 150);
            $table->tinyInteger('visible')->default(1); // 1 is for visible 0 is for invisible
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
