<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tm_pica', function (Blueprint $table) {
            $table->string('id', 191)->primary();
            $table->date('tanggal');
            $table->string('shift', 191);
            $table->time('jam');
            $table->string('tempat', 191);
            $table->string('part_number', 191);
            $table->string('nama_produk', 191);
            $table->text('konten_problem');
            $table->string('sumber_informasi', 191);
            $table->string('status', 191);
            $table->string('sudah_sortir', 191);
            $table->integer('quantity_sortir');
            $table->string('kondisi_sortir_area', 191);
            $table->string('PIC', 191);
            $table->text('penyebab');
            $table->text('countermeasure');
            $table->string('data_verifikasi', 191)->nullable();
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
        Schema::dropIfExists('tm_pica');
    }
};
