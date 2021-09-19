<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMsCapacitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ms_capacities', function (Blueprint $table) {
            $table->id();
            $table->string("bandwith_capacity");
            $table->string("type_trasfer");
            $table->float("price_capacity_fromme");
            $table->float("price_capacity_vendor")->nullable();
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
        Schema::dropIfExists('ms_capacities');
    }
}
