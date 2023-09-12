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
        Schema::create('tt_item_check_projects', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('project_id');
            $table->foreign('project_id')->references('id')->on('tt_projects')->onDelete('cascade');
            $table->string('item_check');
            $table->date('start');
            $table->date('finished');
            $table->string('status');
            $table->string('document')->nullable();
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
        Schema::dropIfExists('tt_item_check_projects');
    }
};
