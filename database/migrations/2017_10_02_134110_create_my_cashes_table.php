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
            $table->integer('total')->unsigned()->default(0); // cash from selling codes
            $table->integer('direct_referral')->unsigned()->default(0); // cash from direct referral cash
            $table->integer('advance_payment')->unsigned()->default(0); // the advance payment
            $table->integer('pending')->unsigned()->nullable()->default(0); // incomming cash
            $table->integer('total_sent')->unsigned()->nullable(); // total sent money
            $table->integer('total_received')->unsigned()->nullable();
            $table->tinyInteger('status')->unsigned()->default(1);
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
