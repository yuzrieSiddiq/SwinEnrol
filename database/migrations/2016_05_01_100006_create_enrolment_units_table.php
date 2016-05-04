<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnrolmentUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enrolment_units', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('studentID')->unsigned();
            $table->string('unitCode');
            $table->integer('year')->unsigned();
            $table->string('term');
            $table->string('status');
            $table->timestamps();
            $table->foreign('studentID')->references('studentID')->on('student');
            $table->foreign('unitCode')->references('unitCode')->on('unit');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('enrolment_units');
    }
}