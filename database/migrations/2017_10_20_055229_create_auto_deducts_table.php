<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAutoDeductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auto_deducts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('member_id', 11); // uid of member
            $table->tinyInteger('status')->default(0);
            $table->integer('cash')->default(0); // usable cash
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
        Schema::dropIfExists('auto_deducts');
    }
}
