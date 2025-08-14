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
        // Tabel utama tracer studies
        Schema::create('tracer_studies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('alumni_id')->nullable();
            $table->foreign('alumni_id')->references('id')->on('alumni')->onDelete('cascade');

            // Info Pribadi
            $table->string('nama');
            $table->string('email');
            $table->string('no_hp');
            $table->string('nim');
            $table->year('tahun_lulus');
            $table->string('prodi')->default('teknik_informatika');
            $table->text('alamat');

            // Status Utama
            $table->enum('status_pekerjaan', [
                'bekerja_full', 'belum_bekerja', 'wirausaha',
                'lanjutstudy', 'tidak'
            ]);

            $table->date('tanggal_isi');
            $table->timestamps();

            // Indexes untuk performa
            $table->index(['status_pekerjaan', 'tahun_lulus']);
            $table->index('tanggal_isi');
        });

        // Tabel detail pekerjaan (untuk yang bekerja)
        Schema::create('tracer_pekerjaan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tracer_study_id')->constrained('tracer_studies')->onDelete('cascade');

            // Mendapatkan pekerjaan
            $table->enum('mendapatkan_pekerjaan', ['<=6bulan', '>6bulan'])->nullable();
            $table->integer('bulan_kerja')->nullable();
            $table->decimal('pendapatan', 15, 2)->nullable();

            // Info perusahaan
            $table->string('nama_perusahaan')->nullable();
            $table->string('jabatan')->nullable();
            $table->text('alamat_pekerjaan')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kota')->nullable();
            $table->string('tingkat_usaha_level')->nullable();

            // Informasi Atasan
            $table->string('nama_atasan')->nullable();
            $table->string('jabatan_atasan')->nullable();
            $table->string('wa_atasan')->nullable();
            $table->string('email_atasan')->nullable();

            // Kesesuaian pendidikan
            $table->enum('hubungan_studi_pekerjaan', [
                'sangat_erat', 'erat', 'cukup_erat', 'kurang_erat', 'tidak_erat'
            ])->nullable();
            $table->enum('pendidikan_sesuai_pekerjaan', [
                'lebih_tinggi', 'sama', 'lebih_rendah', 'tidak_perlu_pt'
            ])->nullable();

            $table->timestamps();
        });

        // Tabel detail wirausaha
        Schema::create('tracer_wirausaha', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tracer_study_id')->constrained('tracer_studies')->onDelete('cascade');

            $table->string('nama_usaha')->nullable();
            $table->enum('posisi_usaha', ['founder', 'co-founder', 'staff', 'freelance'])->nullable();
            $table->string('tingkat_usaha_level')->nullable();
            $table->text('alamat_usaha')->nullable();
            $table->decimal('pendapatan_usaha', 15, 2)->nullable();

            $table->timestamps();
        });

        // Tabel detail pendidikan lanjut
        Schema::create('tracer_pendidikan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tracer_study_id')->constrained('tracer_studies')->onDelete('cascade');

            $table->string('universitas')->nullable();
            $table->string('program_studi')->nullable();
            $table->enum('sumber_biaya', ['biaya_sendiri_orangtua', 'beasiswa'])->nullable();
            $table->date('tanggal_masuk')->nullable();
            $table->string('lokasi_universitas')->nullable();

            // Sumber biaya detail untuk Politeknik
            $table->enum('sumber_biaya_politeknik', [
                'biaya_sendiri_orangtua', 'beasiswa_adik', 'beasiswa_bidikmisi',
                'beasiswa_ppa', 'beasiswa_afirmasi', 'beasiswa_swasta', 'lainnya'
            ])->nullable();
            $table->string('sumber_biaya_lainnya')->nullable();

            $table->timestamps();
        });

        // Tabel kompetensi (untuk semua status)
        Schema::create('tracer_kompetensi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tracer_study_id')->constrained('tracer_studies')->onDelete('cascade');

            // Kompetensi awal (Point A)
            $table->enum('etika_awal', ['sangat_baik', 'baik', 'cukup', 'kurang_baik', 'tidak_baik'])->nullable();
            $table->enum('keahlian_awal', ['sangat_baik', 'baik', 'cukup', 'kurang_baik', 'tidak_baik'])->nullable();
            $table->enum('bahasa_inggris_awal', ['sangat_baik', 'baik', 'cukup', 'kurang_baik', 'tidak_baik'])->nullable();
            $table->enum('teknologi_awal', ['sangat_baik', 'baik', 'cukup', 'kurang_baik', 'tidak_baik'])->nullable();
            $table->enum('kerjasama_awal', ['sangat_baik', 'baik', 'cukup', 'kurang_baik', 'tidak_baik'])->nullable();
            $table->enum('komunikasi_awal', ['sangat_baik', 'baik', 'cukup', 'kurang_baik', 'tidak_baik'])->nullable();
            $table->enum('pengembangan_awal', ['sangat_baik', 'baik', 'cukup', 'kurang_baik', 'tidak_baik'])->nullable();

            // Kompetensi sekarang (Point B)
            $table->enum('etika_sekarang', ['sangat_baik', 'baik', 'cukup', 'kurang_baik', 'tidak_baik'])->nullable();
            $table->enum('keahlian_sekarang', ['sangat_baik', 'baik', 'cukup', 'kurang_baik', 'tidak_baik'])->nullable();
            $table->enum('bahasa_inggris_sekarang', ['sangat_baik', 'baik', 'cukup', 'kurang_baik', 'tidak_baik'])->nullable();
            $table->enum('teknologi_sekarang', ['sangat_baik', 'baik', 'cukup', 'kurang_baik', 'tidak_baik'])->nullable();
            $table->enum('kerjasama_sekarang', ['sangat_baik', 'baik', 'cukup', 'kurang_baik', 'tidak_baik'])->nullable();
            $table->enum('komunikasi_sekarang', ['sangat_baik', 'baik', 'cukup', 'kurang_baik', 'tidak_baik'])->nullable();
            $table->enum('pengembangan_sekarang', ['sangat_baik', 'baik', 'cukup', 'kurang_baik', 'tidak_baik'])->nullable();

            $table->timestamps();
        });

        // Tabel pencarian kerja (untuk yang bekerja)
        Schema::create('tracer_pencarian_kerja', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tracer_study_id')->constrained('tracer_studies')->onDelete('cascade');

            // Cara mendapatkan pekerjaan
            $table->enum('waktu_cari_kerja', ['sebelum_lulus', 'setelah_lulus', 'tidak_mencari'])->nullable();
            $table->integer('bulan_sebelum_lulus')->nullable();
            $table->integer('bulan_setelah_lulus')->nullable();

            // Metode pencarian
            $table->string('aktif_cari_kerja')->nullable(); // 1-15 pilihan
            $table->integer('jumlah_perusahaan_lamar')->nullable();
            $table->integer('jumlah_perusahaan_respon')->nullable();
            $table->integer('jumlah_perusahaan_wawancara')->nullable();

            // Aktivitas saat ini
            $table->string('aktif_cari_kerja_4minggu')->nullable(); // 1-5 pilihan
            $table->string('alasan_pekerjaan_tidak_sesuai')->nullable(); // 1-13 pilihan

            $table->timestamps();
        });

        // Tabel evaluasi pendidikan
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
        Schema::dropIfExists('tracer_pencarian_kerja');
        Schema::dropIfExists('tracer_kompetensi');
        Schema::dropIfExists('tracer_pendidikan');
        Schema::dropIfExists('tracer_wirausaha');
        Schema::dropIfExists('tracer_pekerjaan');
        Schema::dropIfExists('tracer_studies');
    }
};
