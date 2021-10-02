<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDatabaseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblCompany', function (Blueprint $table) {
            $table->id("idCompany");
            $table->string('name');
            $table->timestamps();
        });
        Schema::create('tblGreenHouse', function (Blueprint $table) {
            $table->id("idGreenHouse");
            $table->string('name');
            $table->string('description');
            $table->string('img');
            $table->foreignId('idCompany');
            $table->timestamps();
            $table->foreign('idCompany')->references('idCompany')->on('tblCompany')->onDelete('cascade');
        });
        Schema::create('tblZone', function (Blueprint $table) {
            $table->id("idZone");
            $table->string('name');
            $table->string('description');
            $table->string('typeFood');
            $table->string('img');
            $table->boolean('water');
            $table->timestamps();
            $table->foreignId('idGreenhouse');
            $table->foreign('idGreenhouse')->references('idGreenHouse')->on('tblGreenHouse')->onDelete('cascade');
        });
        Schema::create('tblSensor', function (Blueprint $table) {
            $table->id('idSensor');
            $table->string('name');
            $table->string('description');
            $table->string('typeData');
            $table->timestamps();
            $table->foreignId('idZone');
            $table->foreign('idZone')->references('idZone')->on('tblZone')->onDelete('cascade');
        });
        Schema::create('tblData', function (Blueprint $table) {
            $table->id('idData');
            $table->string('data');
            $table->timestamps();
            $table->foreignId('idSensor');
            $table->foreign('idSensor')->references('idSensor')->on('tblSensor')->onDelete('cascade');
        });
        Schema::table('users', function (Blueprint $table){
            $table->foreign('idCompany')->references('idCompany')->on('tblCompany')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tblCompany');
        Schema::dropIfExists('tblGreenhouse');
        Schema::dropIfExists('tblZone');
        Schema::dropIfExists('tblSensor');
        Schema::dropIfExists('tblData');
    }
}
