<?php

/**
 * Iz nekog razloga (verovatno umora) sam dodao ovo tabelu,
 * generalno ona nema svrhu zato sto svakako za svaku posetu
 * upisem tog visitora u tabeli, tako da mogu odmah da upisem i link_id
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinksVisitorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('links_visitors', function (Blueprint $table) {
        //     $table->unsignedInteger('link_id');
        //     $table->unsignedInteger('visitors_id');
        //     $table->foreign('link_id')->references('id')->on('links');
        //     $table->foreign('visitors_id')->references('id')->on('visitors');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('links_visitors');
    }
}
