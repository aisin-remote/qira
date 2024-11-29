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
        Schema::create('tt_projects_body', function (Blueprint $table) {
            $table->string('id', 191)->primary();
            $table->string('line', 191);
            $table->string('pcr', 191);
            $table->date('planning_masspro');
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
        Schema::dropIfExists('tt_projects_body');
    }
};
