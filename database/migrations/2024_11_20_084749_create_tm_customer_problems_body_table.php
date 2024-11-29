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
        Schema::create('tm_customer_problems_body', function (Blueprint $table) {
            $table->string('id', 191)->primary();
            $table->string('problem', 191);
            $table->date('date_of_problem');
            $table->string('customer', 191);
            $table->string('model_product', 191);
            $table->integer('quantity_product');
            $table->string('process_problem', 191);
            $table->date('date_of_process');
            $table->string('status_problem', 191);
            $table->string('status_kaizen', 191);
            $table->string('photo', 191)->nullable();
            $table->string('report', 191)->nullable();
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
        Schema::dropIfExists('tm_customer_problems_body');
    }
};
