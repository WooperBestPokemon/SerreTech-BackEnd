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
            $table->id("idCompany")->autoIncrement();
            $table->string('name');
            $table->timestamps();
        });
        Schema::create('tblGreenHouse', function (Blueprint $table) {
            $table->id("idGreenHouse")->autoIncrement();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('img')->nullable();
            $table->foreignId('idCompany');
            $table->timestamps();
            $table->foreign('idCompany')->references('idCompany')->on('tblCompany')->onDelete('cascade');
        });
        Schema::create('tblZone', function (Blueprint $table) {
            $table->id("idZone")->autoIncrement();
            $table->string('name');
            $table->string('description')->nullable();
            $table->integer('typeFood');
            $table->string('img')->nullable();
            $table->boolean('water')->default(0);
            $table->timestamps();
            $table->foreignId('idGreenHouse');
            $table->foreign('idGreenHouse')->references('idGreenHouse')->on('tblGreenHouse')->onDelete('cascade');
        });
        Schema::create('tblSensor', function (Blueprint $table) {
            $table->id('idSensor')->autoIncrement();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('typeData');
            $table->boolean('actif')->default(1);
            $table->timestamps();
            $table->foreignId('idZone');
            $table->foreign('idZone')->references('idZone')->on('tblZone')->onDelete('cascade');
        });
        Schema::create('tblData', function (Blueprint $table) {
            $table->id('idData')->autoIncrement();
            $table->string('data');
            $table->timestamp('timestamp');
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
