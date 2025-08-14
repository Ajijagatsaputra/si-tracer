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
        Schema::create('supervisor_questionnaires', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tracer_study_id');
            $table->string('nama_atasan');
            $table->string('jabatan_atasan');
            $table->string('nama_perusahaan');
            $table->string('nama_alumni');
            $table->string('jabatan_alumni');
            $table->date('tanggal_mulai_kerja');
            $table->string('email_atasan')->nullable();
            $table->string('wa_atasan')->nullable();
            $table->string('encrypted_link')->nullable();
            $table->timestamp('expires_at')->nullable();

            // Evaluasi kinerja (Point A) - skala 1-5
            $table->enum('integritas', ['1', '2', '3', '4', '5'])->nullable();
            $table->enum('keahlian', ['1', '2', '3', '4', '5'])->nullable();
            $table->enum('kemampuan', ['1', '2', '3', '4', '5'])->nullable();
            $table->enum('penguasaan', ['1', '2', '3', '4', '5'])->nullable();
            $table->enum('kerja_tim', ['1', '2', '3', '4', '5'])->nullable();
            $table->enum('komunikasi', ['1', '2', '3', '4', '5'])->nullable();
            $table->enum('pengembangan', ['1', '2', '3', '4', '5'])->nullable();

            // Evaluasi kesesuaian pendidikan
            $table->enum('kesesuaian_pendidikan_pekerjaan', ['sangat_sesuai', 'sesuai', 'cukup_sesuai', 'kurang_sesuai', 'tidak_sesuai'])->nullable();
            $table->enum('kualitas_lulusan', ['sangat_baik', 'baik', 'cukup', 'kurang', 'sangat_kurang'])->nullable();
            $table->text('saran_perbaikan')->nullable();

            // Status dan metadata
            $table->enum('status_pengisian', ['pending', 'sent', 'completed', 'expired'])->default('pending');
            $table->string('token_akses')->nullable();
            $table->timestamp('expired_at')->nullable();
            $table->timestamp('tanggal_isi')->nullable();
            $table->timestamps();

            // Foreign key ke tracer_study
            $table->foreign('tracer_study_id')->references('id')->on('tracer_studies')->onDelete('cascade');

            // Index untuk performa
            $table->index(['status_pengisian']);
            $table->index(['expired_at']);
            $table->index(['encrypted_link']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supervisor_questionnaires');
    }
};
