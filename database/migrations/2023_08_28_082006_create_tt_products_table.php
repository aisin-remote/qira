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
            $table->string('id', 191)->primary();
            $table->string('model', 191);
            $table->string('line', 191);
            $table->date('start_date');
            $table->date('planning_finished');
            $table->integer('target_check');
            $table->integer('finish_check');
            $table->string('document', 191)->nullable();
            $table->string('status', 191);
            $table->string('approval', 191)->nullable();
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
