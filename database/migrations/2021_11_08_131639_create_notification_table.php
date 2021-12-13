<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblnotification', function (Blueprint $table) {
            $table->id('idAlerte')->autoIncrement();
            $table->string('description');
            $table->boolean('alerteStatus');
            $table->integer('codeErreur');
            $table->timestamps();
            $table->foreignId('idSensor');
            $table->foreign('idSensor')->references('idSensor')->on('tblSensor')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tblNotification');
    }
}
