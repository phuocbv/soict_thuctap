<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Student extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student', function ($table) {
            $table->increments('id');
            $table->string('name');
            $table->string('avatar');
            $table->string('gender');
            $table->string('birthday');
            $table->string('grade');
            $table->string('program_university');
            $table->string('msv');
            $table->string('phone');
            $table->string('english');
            $table->string('programing_skill');
            $table->string('programing_skill_best');
            $table->string('user_id');
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
        Schema::drop('student');
    }
}
