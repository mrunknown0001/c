<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDirectReferralsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('direct_referrals', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sponsor', 15); // uid of the sponsor, will be rawarded by 50
            $table->string('member', 15); // member who activated on of its account
            $table->tinyInteger('status')->default(1); // default is active status
            $table->tinyInteger('paid')->default(0); // 1 if paid
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
        Schema::dropIfExists('direct_referrals');
    }
}
