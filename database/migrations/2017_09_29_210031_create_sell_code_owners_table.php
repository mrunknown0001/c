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
            $table->integer('code_id')->unsigned();
            $table->foreign('code_id')->references('id')->on('sell_activation_codes');
            $table->integer('usage')->default(0); // code usage max:5 use
            $table->tinyInteger('visible')->default(1); // 1 is for visible 0 is for invisible
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
