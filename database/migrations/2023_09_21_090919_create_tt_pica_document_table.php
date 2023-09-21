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
        Schema::create('tt_pica_document', function (Blueprint $table) {
            $table->string('id', 191)->primary();
            $table->string('id_pica', 191);
            $table->string('data_verifikasi', 191)->nullable();
            $table->timestamps();

            $table->foreign('id_pica')->references('id')->on('tm_pica')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tt_pica_document');
    }
};
