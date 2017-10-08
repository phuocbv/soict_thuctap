<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Lecture extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lecture', function ($table) {
            $table->increments('id');
            $table->string('name');
            $table->string('avatar');
            $table->string('birthday');
            $table->string('qualification');
            $table->string('address');
            $table->string('phone');
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
        Schema::drop('lecture');
    }
}
