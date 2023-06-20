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
        Schema::create('tt_data_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('data_id');
            $table->string('item');
            $table->enum('progress', ['0', '1','2','3','4'])->default('0');
            $table->timestamp('start');
            $table->timestamp('deadline')->nullable();
            $table->string('document');
            $table->timestamps();
            $table->foreign('data_id')->references('id')->on('tt_data');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tt_data_detail');
    }
};
