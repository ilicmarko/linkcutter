<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->increments('id');
            $table->string('unique_id', 100);
            $table->string('user_agent')->nullable();
            $table->unsignedInteger('link_id');

            $table->ipAddress('ip_address', 45)->nullable();
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->string('country')->nullable();
            $table->string('country_code')->nullable();
            $table->string('city')->nullable();
            $table->boolean('unique_visit')->default(false);
            $table->boolean('is_vpn')->nullable();

            $table->string('referer')->nullable();
            $table->string('referer_host')->nullable();

            $table->timestamps();

            $table->foreign('link_id')->references('id')->on('links')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('visits');
    }
}
