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
        // Update tracer_kompetensi table - add only missing bahasa_inggris fields
        Schema::table('tracer_kompetensi', function (Blueprint $table) {
            // Check jika belum ada, baru ditambahkan
            if (!Schema::hasColumn('tracer_kompetensi', 'bahasa_inggris_awal')) {
                $table->enum('bahasa_inggris_awal', ['sangat_baik', 'baik', 'cukup', 'kurang_baik', 'tidak_baik'])->nullable()->after('keahlian_awal');
            }
            if (!Schema::hasColumn('tracer_kompetensi', 'bahasa_inggris_sekarang')) {
                $table->enum('bahasa_inggris_sekarang', ['sangat_baik', 'baik', 'cukup', 'kurang_baik', 'tidak_baik'])->nullable()->after('keahlian_sekarang');
            }
        });

        // Update tracer_pencarian_kerja table - add new fields after existing ones
        Schema::table('tracer_pencarian_kerja', function (Blueprint $table) {
            // Cara mendapatkan pekerjaan
            if (!Schema::hasColumn('tracer_pencarian_kerja', 'waktu_cari_kerja')) {
                $table->enum('waktu_cari_kerja', ['sebelum_lulus', 'setelah_lulus', 'tidak_mencari'])->nullable()->after('tracer_study_id');
            }
            if (!Schema::hasColumn('tracer_pencarian_kerja', 'bulan_sebelum_lulus')) {
                $table->integer('bulan_sebelum_lulus')->nullable()->after('waktu_cari_kerja');
            }
            if (!Schema::hasColumn('tracer_pencarian_kerja', 'bulan_setelah_lulus')) {
                $table->integer('bulan_setelah_lulus')->nullable()->after('bulan_sebelum_lulus');
            }

            // Metode pencarian
            if (!Schema::hasColumn('tracer_pencarian_kerja', 'aktif_cari_kerja')) {
                $table->string('aktif_cari_kerja')->nullable()->after('bulan_setelah_lulus');
            }
            if (!Schema::hasColumn('tracer_pencarian_kerja', 'jumlah_perusahaan_lamar')) {
                $table->integer('jumlah_perusahaan_lamar')->nullable()->after('aktif_cari_kerja');
            }
            if (!Schema::hasColumn('tracer_pencarian_kerja', 'jumlah_perusahaan_respon')) {
                $table->integer('jumlah_perusahaan_respon')->nullable()->after('jumlah_perusahaan_lamar');
            }
            if (!Schema::hasColumn('tracer_pencarian_kerja', 'jumlah_perusahaan_wawancara')) {
                $table->integer('jumlah_perusahaan_wawancara')->nullable()->after('jumlah_perusahaan_respon');
            }

            // Aktivitas saat ini
            if (!Schema::hasColumn('tracer_pencarian_kerja', 'aktif_cari_kerja_4minggu')) {
                $table->string('aktif_cari_kerja_4minggu')->nullable()->after('jumlah_perusahaan_wawancara');
            }
            if (!Schema::hasColumn('tracer_pencarian_kerja', 'alasan_pekerjaan_tidak_sesuai')) {
                $table->string('alasan_pekerjaan_tidak_sesuai')->nullable()->after('aktif_cari_kerja_4minggu');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tracer_kompetensi', function (Blueprint $table) {
            $table->dropColumn(['bahasa_inggris_awal', 'bahasa_inggris_sekarang']);
        });

        Schema::table('tracer_pencarian_kerja', function (Blueprint $table) {
            $table->dropColumn([
                'waktu_cari_kerja', 'bulan_sebelum_lulus', 'bulan_setelah_lulus',
                'jumlah_perusahaan_lamar', 'jumlah_perusahaan_respon', 'jumlah_perusahaan_wawancara',
                'aktif_cari_kerja_4minggu', 'alasan_pekerjaan_tidak_sesuai'
            ]);
        });
    }
};
