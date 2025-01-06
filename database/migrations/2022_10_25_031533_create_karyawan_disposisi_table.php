<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKaryawanDisposisiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('karyawan_disposisi', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('disposisi_id')->unsigned()->index();
            $table->foreign('disposisi_id')->references('id')->on('disposisi')->onDelete('cascade');
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
        Schema::dropIfExists('karyawan_disposisi');
    }
}
