<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_codes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('from'); // the member who request the code to buy
            $table->string('to'); // the member/admin where the code will come from
            $table->tinyInteger('status')->default(1); // if the request is viewed and successfully sold the status will become 0 or inactive
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
        Schema::dropIfExists('request_codes');
    }
}
