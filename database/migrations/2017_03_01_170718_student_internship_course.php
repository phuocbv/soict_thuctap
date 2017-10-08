<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class StudentInternshipCourse extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_internship_course', function ($table) {
            $table->increments('id');
            $table->string('report_file');
            $table->string('lecture_review_file');
            $table->string('company_review_file');
            $table->string('lecture_point');
            $table->string('company_point');
            $table->string('status');
            $table->string('register_date');
            $table->string('student_id');
            $table->string('internship_course_id');
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
        Schema::drop('student_internship_course');
    }
}
