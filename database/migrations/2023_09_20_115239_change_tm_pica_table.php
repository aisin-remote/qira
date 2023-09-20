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
        Schema::table('tm_pica', function (Blueprint $table) {
            $table->string('quantity_sortir', 191)->change();
            $table->string('tipe', 191);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tm_pica', function (Blueprint $table) {
            $table->integer('quantity_sortir')->change();
        });
    }
};
