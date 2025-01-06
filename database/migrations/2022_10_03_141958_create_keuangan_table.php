<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKeuanganTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('keuangan', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('users_id')->unsigned()->index();
            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('disposisi_id')->nullable()->unsigned()->index();
            $table->foreign('disposisi_id')->references('id')->on('disposisi')->onDelete('cascade');
            $table->bigInteger('kantor_id')->nullable()->unsigned()->index();
            $table->foreign('kantor_id')->references('id')->on('kantor')->onDelete('cascade');
            $table->bigInteger('transportasi_id')->unsigned()->index();
            $table->foreign('transportasi_id')->references('id')->on('transportasi')->onDelete('cascade');
            $table->bigInteger('penginapan_id')->unsigned()->index();
            $table->foreign('penginapan_id')->references('id')->on('penginapan')->onDelete('cascade');
            $table->integer('uang_transport');
            $table->integer('uang_penginapan');
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
        Schema::dropIfExists('keuangan');
    }
}
