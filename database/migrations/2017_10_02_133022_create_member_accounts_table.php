<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_name'); // username of the member in users table/ the owner of the account
            $table->string('user_id'); // id of the member is users table/ the owner of the account
            $table->string('account_alias', 50); // unique name of the account // the default account name is the username of the user and the other additional account is account2 account3 account4
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('available')->default(0); // 0 for not available or it has and owner, 1 for available no owner 
            $table->string('upline_account_alias')->nullable();
            $table->integer('downline_level')->nullable();
            $table->integer('downline_1')->nullable();
            $table->integer('downline_2')->nullable();
            $table->integer('downline_3')->nullable();
            $table->integer('downline_4')->nullable();
            $table->integer('downline_5')->nullable();
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
        Schema::dropIfExists('member_accounts');
    }
}
