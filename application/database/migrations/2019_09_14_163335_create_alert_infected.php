<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlertInfected extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alert_infected', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('survivor_id');
            $table->foreign('survivor_id')->references('id')->on('survivor');
            //suvirvor that reported infection of survivor_id
            $table->unsignedBigInteger('reporter_id');
            $table->foreign('reporter_id')->references('id')->on('survivor');
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
        Schema::dropIfExists('alert_infected');
    }
}
