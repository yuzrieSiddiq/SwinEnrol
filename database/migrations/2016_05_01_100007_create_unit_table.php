<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unit', function(Blueprint $table)
        {
            $table->string('unitCode');
            $table->string('unitName');
            $table->decimal('creditPoints', 5, 2);
            $table->integer('maxStudentCount')->unsigned();
            $table->integer('lectureGroupCount')->unsigned();
            $table->string('lectureDuration');
            $table->integer('tutorialGroupCount')->unsigned();
            $table->string('tutorialDuration');
            $table->string('unitInfo');

            $table->timestamps();

            $table->primary('unitCode');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('unit');
    }
}
