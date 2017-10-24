<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user', 11);
            $table->string('sent_thru', 100);
            $table->string('image_file', 255);
            $table->string('description', 300)->nullable();
            $table->tinyInteger('status')->default(0); // 0 for pending and 1 for approved and verified 2 for declined
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
        Schema::dropIfExists('payments');
    }
}
