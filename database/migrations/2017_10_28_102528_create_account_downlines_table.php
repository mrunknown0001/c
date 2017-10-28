<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountDownlinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_downlines', function (Blueprint $table) {
            $table->increments('id');
            $table->string('account_id', 50)->nullable();
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
        Schema::dropIfExists('account_downlines');
    }
}
