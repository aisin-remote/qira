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
            $table->string('id')->primary();
            $table->date('tanggal');
            $table->string('shift');
            $table->time('jam');
            $table->string('tempat');
            $table->string('part_number');
            $table->string('nama_produk');
            $table->text('konten_problem');
            $table->string('sumber_informasi');
            $table->string('status');
            $table->string('sudah_sortir');
            $table->integer('quantity_sortir');
            $table->string('kondisi_sortir_area');
            $table->string('PIC');
            $table->text('penyebab');
            $table->text('countermeasure');
            $table->text('data_verifikasi');
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
