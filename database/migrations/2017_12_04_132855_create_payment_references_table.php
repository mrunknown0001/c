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
            $table->integer('member_account_id')->unsigned()->nullable();
            $table->integer('buyer_id')->unsigned(); // the member who bought codes
            $table->integer('buyer_account_id')->nullable();
            $table->integer('batch_number'); // payout batch number
            $table->integer('sales')->unsigned()->nullable(); // sales on codes
            $table->integer('direct_referral')->unsigned()->nullable();
            $table->tinyInteger('autodeduct')->nullable();
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
