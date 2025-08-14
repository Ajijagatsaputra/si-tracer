<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TracerPencarianKerja extends Model
{
    use HasFactory;

    protected $table = 'tracer_pencarian_kerja';

    protected $fillable = [
        'tracer_study_id',
        // Cara mendapatkan pekerjaan
        'waktu_cari_kerja',
        'bulan_sebelum_lulus',
        'bulan_setelah_lulus',
        // Metode pencarian
        'aktif_cari_kerja',
        'jumlah_perusahaan_lamar',
        'jumlah_perusahaan_respon',
        'jumlah_perusahaan_wawancara',
        // Aktivitas saat ini
        'aktif_cari_kerja_4minggu',
        'alasan_pekerjaan_tidak_sesuai'
    ];

    protected $casts = [
        'cara_mencari_kerja' => 'array'
    ];

    public function tracerStudy(): BelongsTo
    {
        return $this->belongsTo(TracerStudy::class);
    }
}
