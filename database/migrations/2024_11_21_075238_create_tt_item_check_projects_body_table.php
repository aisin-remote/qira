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
        Schema::create('tt_item_check_projects_body', function (Blueprint $table) {
            $table->string('id', 191)->primary();
            $table->string('project_id', 191);
            $table->foreign('project_id')->references('id')->on('tt_projects_body')->onDelete('cascade');
            $table->string('item_check', 191);
            $table->date('start');
            $table->date('finished');
            $table->string('status', 191);
            $table->string('document', 191)->nullable();
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
        Schema::dropIfExists('tt_item_check_projects_body');
    }
};
