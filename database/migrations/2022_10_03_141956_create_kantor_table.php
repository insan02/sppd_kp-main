<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKantorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kantor', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('lokasi_id')->unsigned()->index();
            $table->foreign('lokasi_id')->references('id')->on('lokasi')->onDelete('cascade');
            $table->bigInteger('users_id')->unsigned()->index();
            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('judul_surat');
            $table->date('tanggal_pergi');
            $table->date('tanggal_pulang');
            $table->string('lampiran_surat');
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
        Schema::dropIfExists('kantor');
    }
}
