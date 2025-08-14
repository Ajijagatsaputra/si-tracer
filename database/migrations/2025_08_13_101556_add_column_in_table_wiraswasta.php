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
        Schema::table('tracer_wirausaha', function (Blueprint $table) {
            $table->enum('hubungan_studi_pekerjaan', ['sangat_erat', 'erat', 'cukup_erat', 'kurang_erat', 'tidak_erat'])->nullable()->after('pendapatan_usaha');
            $table->enum('pendidikan_sesuai_pekerjaan', ['lebih_tinggi', 'sama', 'lebih_rendah', 'tidak_perlu_pt'])->nullable()->after('hubungan_studi_pekerjaan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tracer_wirausaha', function (Blueprint $table) {
            $table->dropColumn('hubungan_studi_pekerjaan');
            $table->dropColumn('pendidikan_sesuai_pekerjaan');
        });
    }
};
