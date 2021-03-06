<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountConfirmationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_confirmations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('code', 255);  // hash string combination of time hash and user hash
            $table->string('full_url', 255)->nullable(); // full url with code
            $table->tinyInteger('status')->default(0);
            // expiration will be added if the client request
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
        Schema::dropIfExists('account_confirmations');
    }
}
