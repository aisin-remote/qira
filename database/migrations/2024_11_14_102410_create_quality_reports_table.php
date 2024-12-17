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
        Schema::create('quality_reports', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');  // Menggunakan tipe date untuk menyimpan tanggal
            $table->string('section');
            $table->string('line');
            $table->string('modell');
            $table->string('part_name');
            $table->string('problem');
            $table->integer('quantity');
            $table->string('standard');  // Kolom standard
            $table->string('actual');    // Kolom actual
            $table->text('visual_ok')->nullable();   // Nilai JSON, nullable
            $table->text('visual_ng')->nullable();   // Nilai JSON, nullable
            $table->text('measurement_photo')->nullable();  // Nullable
            $table->text('qty')->nullable();  // Disimpan dalam bentuk JSON, nullable
            $table->text('ok')->nullable();   // Disimpan dalam bentuk JSON, nullable
            $table->text('ng')->nullable();   // Disimpan dalam bentuk JSON, nullable
            $table->text('pic')->nullable();  // Disimpan dalam bentuk JSON, nullable
            $table->text('problem_analysis');  // Kolom untuk analisis masalah
            $table->text('occure')->nullable();  // Disimpan dalam bentuk JSON, nullable
            $table->text('outflow')->nullable();  // Disimpan dalam bentuk JSON, nullable
            $table->text('temporary_actions')->nullable();  // Tindakan sementara, disimpan sebagai JSON, nullable
            $table->text('corrective_actions')->nullable();  // Tindakan korektif, disimpan sebagai JSON, nullable
            $table->string('photo_path')->nullable();  // Kolom untuk path file, nullable
            $table->timestamps();  // Kolom created_at dan updated_at
        });
    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quality_reports');
    }
};
