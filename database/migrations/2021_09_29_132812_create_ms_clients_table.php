<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMsClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ms_clients', function (Blueprint $table) {
            $table->id();
            $table->string("cid_client")->nullable();
            $table->string("name_client");
            $table->string("no_telp_client");
            $table->string("email_client");
            $table->string("address_client");
            $table->string('company_client')->nullable();
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
        Schema::dropIfExists('ms_clients');
    }
}
