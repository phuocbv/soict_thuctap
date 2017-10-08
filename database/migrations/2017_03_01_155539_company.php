<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Company extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company', function ($table) {
            $table->increments('id');
            $table->string('name');
            $table->string('address');
            $table->string('logo');
            $table->string('birthday');
            $table->string('description');
            $table->string('require_skill');
            $table->string('hr_mail');
            $table->string('hr_phone');
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
        Schema::drop('company');
    }
}
