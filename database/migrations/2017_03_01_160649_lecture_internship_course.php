<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LectureInternshipCourse extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lecture_internship_course', function ($table) {
            $table->increments('id');
            $table->string('lecture_id');
            $table->string('internship_course_id');
            $table->string('assignment_date');
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
        Schema::drop('lecture_internship_course');
    }
}
