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
        Schema::create('penanganan_internals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quality_internal_id')->constrained()->onDelete('cascade');
            $table->string('komponen');
            $table->integer('qty');
            $table->integer('ok');
            $table->integer('ng');
            $table->string('pic');
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
        Schema::dropIfExists('penanganan_internals');
    }
};
