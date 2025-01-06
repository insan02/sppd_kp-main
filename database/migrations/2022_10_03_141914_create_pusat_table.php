<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePusatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pusat', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('lokasi_id')->unsigned()->index();
            $table->foreign('lokasi_id')->references('id')->on('lokasi')->onDelete('cascade');
            $table->bigInteger('users_id')->unsigned()->index();
            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('no_surat')->unique();
            $table->string('judul_surat');
            $table->date('tanggal_pergi');
            $table->date('tanggal_pulang');
            $table->string('lampiran_undangan');
            $table->string('status_disposisi')->default('Pending');
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
        Schema::dropIfExists('pusat');
    }
}
