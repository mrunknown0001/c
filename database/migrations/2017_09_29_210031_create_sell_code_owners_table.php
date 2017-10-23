<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSellCodeOwnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sell_code_owners', function (Blueprint $table) {
            $table->increments('id');
            $table->string('member_uid', 11); // uid of the member
            $table->string('account_id', 50); // id of the account
            $table->integer('code_id')->unsigned();
            $table->foreign('code_id')->references('id')->on('sell_activation_codes');
            $table->integer('usage')->default(0); // code usage max:5 use
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
        Schema::dropIfExists('sell_code_owners');
    }
}
