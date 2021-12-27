<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoardingHousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boarding_houses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('owner');
            $table->text('description')->nullable();
            $table->char('village_id', 10);
            $table->string('postal_code');
            $table->text('address');
            $table->string('phone_number', 15)->nullable();
            $table->string('whatsapp_number', 15)->nullable();
            $table->text('rule')->nullable();
            $table->timestamps();
            // foreign
            $table->foreign('village_id')->references('id')->on('villages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('boarding_houses');
    }
}
