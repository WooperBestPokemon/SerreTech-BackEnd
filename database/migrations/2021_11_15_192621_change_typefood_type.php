<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTypefoodType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('tblZone');

        Schema::create('tblZone', function (Blueprint $table) {
            $table->id("idZone")->autoIncrement();
            $table->string('name');
            $table->string('description');
            $table->integer('typeFood');
            $table->string('img')->nullable();
            $table->boolean('water')->default(0);
            $table->timestamps();
            $table->foreignId('idGreenHouse');
            $table->foreign('idGreenHouse')->references('idGreenHouse')->on('tblGreenHouse')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tblZone');
    }
}
