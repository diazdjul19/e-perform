<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMsSalesReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ms_sales_reports', function (Blueprint $table) {
            $table->id();
            $table->string('tiket_report');
            $table->integer('id_user_rel');
            $table->integer('id_client_rel');
            $table->integer('id_capacity_rel');
            $table->integer('id_site_rel');
            $table->float("price_capacity_fromme")->nullable();
            $table->float("price_capacity_vendor")->nullable();

            $table->float("ppn_percentage")->nullable();
            $table->float("subtotal_plus_ppn")->nullable();

            $table->string('status');
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
        Schema::dropIfExists('ms_sales_reports');
    }
}
