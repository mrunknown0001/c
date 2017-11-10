<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayoutSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payout_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('member_uid', 20);
            $table->string('mop', 50);
            $table->string('name', 255); //fullname of the receipeint of the payout
            $table->string('wallet_address', 150)->nullable(); // if the mop is coins.ph
            $table->string('bank_account', 20)->nullable(); // if the mop is bank deposit
            $table->string('contact_number', 20)->nullable(); // if the mop is cebuana or secrutiy bank ecash
            $table->string('others', 255)->nullable(); // others
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
        Schema::dropIfExists('payout_settings');
    }
}
