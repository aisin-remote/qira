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
        Schema::create('tt_products', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('model');
            $table->string('line');
            $table->date('start_date');
            $table->date('planning_finished');
            $table->integer('target_check');
            $table->integer('finish_check');
            $table->string('document')->nullable();
            $table->string('status');
            $table->string('approval')->nullable();
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
        Schema::dropIfExists('tt_products');
    }
};
