<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('rainbux')->default(0);
            $table->string('blurb')->nullable()->default("Hi! I am new to Rainway!");
            $table->string('avatar')->default("https://tr.rbxcdn.com/624190d4f34f9f15d35284ae604f8062/420/420/Avatar/Png");
            $table->integer('Head')->default(24);
            $table->integer('Torso')->default(1011);
            $table->integer('LeftArm')->default(24);
            $table->integer('RightArm')->default(24);
            $table->integer('LeftLeg')->default(29);
            $table->integer('RightLeg')->default(29);
            $table->integer('timestamp')->default(time());
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
