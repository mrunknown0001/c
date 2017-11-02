<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashMonitorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_monitors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type', 10); // in or out
            $table->string('method', 50)->nullable(); // deposit / autodeduct fun
            $table->string('via', 50)->nullable();
            $table->string('from'); // admin or member
            $table->string('to'); // admin or member
            $table->integer('amount');
            $table->string('remarks', 255)->nullable();
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('cash_monitors');
    }
}
