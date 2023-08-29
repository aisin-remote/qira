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
        Schema::create('tm_customer_problems', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('problem');
            $table->date('date_of_problem');
            $table->string('customer');
            $table->string('model_product');
            $table->integer('quantity_product');
            $table->string('process_problem');
            $table->date('date_of_process');
            $table->string('status_problem');
            $table->string('status_kaizen');
            $table->string('photo')->nullable();
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
        Schema::dropIfExists('tm_customer_problems');
    }
};
