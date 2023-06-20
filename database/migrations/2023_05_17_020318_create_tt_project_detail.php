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
        Schema::create('tt_project_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_project');
            $table->string('nama');
            $table->timestamp('start');
            $table->timestamp('deadline')->nullable();
            $table->enum('status',['0','1'])->default(0);
            $table->string('document')->nullable();
            $table->timestamps();
            $table->foreign('id_project')->references('id')->on('tt_project');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tt_project_detail');
    }
};
