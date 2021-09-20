<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMsLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ms_links', function (Blueprint $table) {
            $table->id();
            $table->string("name_link");
            $table->string("penanggung_jawab_link");
            $table->string("vlan")->nullable();
            $table->integer('id_capacity_rel')->nullable();
            $table->integer('id_site_rel')->nullable();
            $table->integer('id_vendor_rel')->nullable();
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
        Schema::dropIfExists('ms_links');
    }
}
