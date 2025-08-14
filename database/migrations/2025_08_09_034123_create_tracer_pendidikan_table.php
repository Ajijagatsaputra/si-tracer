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
        Schema::create('tracer_pendidikan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tracer_study_id')->constrained('tracer_studies')->onDelete('cascade');

            $table->string('universitas')->nullable();
            $table->string('program_studi')->nullable();
            $table->enum('sumber_biaya', ['biaya_sendiri', 'beasiswa_pemerintah', 'beasiswa_swasta', 'beasiswa_institusi'])->nullable();
            $table->date('tanggal_masuk')->nullable();
            $table->text('lokasi_universitas')->nullable();

            // Sumber biaya saat kuliah di Politeknik
            $table->enum('sumber_biaya_politeknik', [
                'biaya_sendiri_orangtua', 'beasiswa_adik', 'beasiswa_bidikmisi',
                'beasiswa_ppa', 'beasiswa_afirmasi', 'beasiswa_swasta', 'lainnya'
            ])->nullable();
            $table->string('sumber_biaya_lainnya')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracer_pendidikan');
    }
};
