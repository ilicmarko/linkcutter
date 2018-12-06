<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrackedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trackeds', function (Blueprint $table) {
            $table->increments('id');
            $table->string('hash', 20)->unique()->index();
            $table->string('email');
            $table->string('unique_id', 100);
            $table->unsignedInteger('link_id');
            $table->foreign('link_id')->references('id')->on('links');
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
        Schema::dropIfExists('trackeds');
    }
}
