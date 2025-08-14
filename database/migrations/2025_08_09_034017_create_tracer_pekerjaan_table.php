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
        Schema::create('tracer_pekerjaan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tracer_study_id')->constrained('tracer_studies')->onDelete('cascade');

            // Waktu mendapat pekerjaan
            $table->enum('mendapatkan_pekerjaan', ['<=6bulan', '>6bulan'])->nullable();
            $table->integer('bulan_kerja')->nullable();
            $table->decimal('pendapatan', 15, 2)->nullable();

            // Detail pekerjaan
            $table->string('nama_perusahaan')->nullable();
            $table->string('jabatan')->nullable();
            $table->text('alamat_pekerjaan')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kota')->nullable();

            // Tingkat perusahaan
            $table->enum('tingkat_usaha_level', [
                'organisasi', 'perusahaan',
                'wirausaha', 'bumn', 'instansi'
            ])->nullable();

            // Kesesuaian pekerjaan
            $table->enum('hubungan_studi_pekerjaan', [
                'sangat_erat', 'erat', 'cukup_erat', 'kurang_erat', 'tidak_erat'
            ])->nullable();
            $table->enum('pendidikan_sesuai_pekerjaan', [
                'lebih_tinggi', 'sama', 'lebih_rendah', 'tidak_perlu_pt'
            ])->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracer_pekerjaan');
    }
};
