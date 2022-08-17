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
        Schema::create('shop', function (Blueprint $table) {
            $table->increments('itemid');
            $table->string('name');
            $table->integer('price');
            $table->string('thumbnail');
            $table->string('type');
            $table->string('description');
            $table->integer('creator');
            $table->string('robloxid');
            $table->integer('onsale');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop');
    }
};
