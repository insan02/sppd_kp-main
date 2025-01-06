<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKaryawanKantorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('karyawan_kantor', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('kantor_id')->unsigned()->index();
            $table->foreign('kantor_id')->references('id')->on('kantor')->onDelete('cascade');
            $table->bigInteger('karyawan_id')->unsigned()->index();
            $table->foreign('karyawan_id')->references('id')->on('karyawan')->onDelete('cascade');
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
        Schema::dropIfExists('karyawan_kantor');
    }
}
