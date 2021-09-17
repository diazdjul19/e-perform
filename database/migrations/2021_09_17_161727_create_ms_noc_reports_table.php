<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMsNocReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ms_noc_reports', function (Blueprint $table) {
            $table->id();
            $table->string("tiket_report");
            $table->integer('id_user_rel');
            $table->integer('id_link_rel');
            $table->string('issues');
            $table->string('solution');
            $table->dateTime('dari_long');
            $table->dateTime('sampai_long');
            $table->string('status');
            $table->string('notes');
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
        Schema::dropIfExists('ms_noc_reports');
    }
}
