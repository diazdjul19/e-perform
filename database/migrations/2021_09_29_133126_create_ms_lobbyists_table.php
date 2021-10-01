<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMsLobbyistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ms_lobbyists', function (Blueprint $table) {
            $table->id();
            $table->string("uuid_lobbyists");
            $table->string("name_prospective_client");
            $table->string("respont_prospective_client");
            $table->string("relation_from")->nullable();
            $table->string("open_by")->nullable();
            $table->string("close_by")->nullable();
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
        Schema::dropIfExists('ms_lobbyists');
    }
}
