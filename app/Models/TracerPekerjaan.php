<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TracerPekerjaan extends Model
{
    use HasFactory;

    protected $table = 'tracer_pekerjaan';

    protected $fillable = [
        'tracer_study_id',
        'mendapatkan_pekerjaan',
        'bulan_kerja',
        'pendapatan',
        'nama_perusahaan',
        'jabatan',
        'alamat_pekerjaan',
        'provinsi',
        'kota',
        'tingkat_usaha_level',
        'hubungan_studi_pekerjaan',
        'pendidikan_sesuai_pekerjaan',
    ];

    protected $casts = [
        'pendapatan' => 'decimal:0'
    ];

    public function tracerStudy(): BelongsTo
    {
        return $this->belongsTo(TracerStudy::class);
    }
}
