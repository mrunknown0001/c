<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMyCashesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('my_cashes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned(); // id of the user
            $table->integer('total')->unsigned()->default(0); // total spendable cash
            $table->integer('pending')->unsigned()->nullable(); // incomming cash
            $table->integer('total_sent')->unsigned()->nullable(); // total sent money
            $table->integer('total_received')->unsigned()->nullable();
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
        Schema::dropIfExists('my_cashes');
    }
}
