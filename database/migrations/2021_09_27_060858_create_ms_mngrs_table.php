<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMsMngrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ms_mngrs', function (Blueprint $table) {
            $table->id();
            $table->string("mngr_login");
            $table->string("mngr_register");
            $table->string("mngr_fgpassword");
            $table->string("md5");
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
        Schema::dropIfExists('ms_mngrs');
    }
}
