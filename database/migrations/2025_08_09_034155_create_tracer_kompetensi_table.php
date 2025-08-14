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
        Schema::create('tracer_kompetensi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tracer_study_id')->constrained('tracer_studies')->onDelete('cascade');

            // Kompetensi saat awal lulus (Point A)
            $table->enum('etika_awal', ['sangat_baik', 'baik', 'cukup', 'kurang_baik', 'tidak_baik'])->nullable();
            $table->enum('keahlian_awal', ['sangat_baik', 'baik', 'cukup', 'kurang_baik', 'tidak_baik'])->nullable();
            $table->enum('komunikasi_awal', ['sangat_baik', 'baik', 'cukup', 'kurang_baik', 'tidak_baik'])->nullable();
            $table->enum('kerjasama_awal', ['sangat_baik', 'baik', 'cukup', 'kurang_baik', 'tidak_baik'])->nullable();
            $table->enum('teknologi_awal', ['sangat_baik', 'baik', 'cukup', 'kurang_baik', 'tidak_baik'])->nullable();
            $table->enum('pengembangan_awal', ['sangat_baik', 'baik', 'cukup', 'kurang_baik', 'tidak_baik'])->nullable();

            // Kompetensi saat ini (Point B)
            $table->enum('etika_sekarang', ['sangat_baik', 'baik', 'cukup', 'kurang_baik', 'tidak_baik'])->nullable();
            $table->enum('keahlian_sekarang', ['sangat_baik', 'baik', 'cukup', 'kurang_baik', 'tidak_baik'])->nullable();
            $table->enum('komunikasi_sekarang', ['sangat_baik', 'baik', 'cukup', 'kurang_baik', 'tidak_baik'])->nullable();
            $table->enum('kerjasama_sekarang', ['sangat_baik', 'baik', 'cukup', 'kurang_baik', 'tidak_baik'])->nullable();
            $table->enum('teknologi_sekarang', ['sangat_baik', 'baik', 'cukup', 'kurang_baik', 'tidak_baik'])->nullable();
            $table->enum('pengembangan_sekarang', ['sangat_baik', 'baik', 'cukup', 'kurang_baik', 'tidak_baik'])->nullable();

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracer_kompetensi');
    }
};
