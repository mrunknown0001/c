<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentReferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_references', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('member_id')->unsigned(); // id of the paid member, for referral or sales
            $table->integer('member_account_id')->unsigned();
            $table->integer('buyer_id')->unsigned(); // the member who bought codes
            $talbe->integer('buyer_account_id');
            $table->integer('sales')->unsigned(); // sales on codes
            $table->integer('direct_referral')->unsigned(); 
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('visible')->default(1);
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
        Schema::dropIfExists('payment_references');
    }
}
