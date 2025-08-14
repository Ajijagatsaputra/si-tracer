<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tracer_evaluasi_pendidikan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tracer_study_id')->constrained('tracer_studies')->onDelete('cascade');

            // Metode pembelajaran
            $table->enum('perkuliahan', ['sangat_baik', 'baik', 'cukup', 'kurang_baik', 'tidak_baik'])->nullable();
            $table->enum('praktikum', ['sangat_baik', 'baik', 'cukup', 'kurang_baik', 'tidak_baik'])->nullable();
            $table->enum('demonstrasi', ['sangat_baik', 'baik', 'cukup', 'kurang_baik', 'tidak_baik'])->nullable();
            $table->enum('riset', ['sangat_baik', 'baik', 'cukup', 'kurang_baik', 'tidak_baik'])->nullable();
            $table->enum('magang', ['sangat_baik', 'baik', 'cukup', 'kurang_baik', 'tidak_baik'])->nullable();
            $table->enum('kerja_lapangan', ['sangat_baik', 'baik', 'cukup', 'kurang_baik', 'tidak_baik'])->nullable();
            $table->enum('diskusi', ['sangat_baik', 'baik', 'cukup', 'kurang_baik', 'tidak_baik'])->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracer_evaluasi_pendidikan');
    }
};
