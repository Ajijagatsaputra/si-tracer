<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TracerStudy extends Model
{
    use HasFactory;

    protected $table = 'tracer_studies';

    protected $fillable = [
        'user_id',
        'alumni_id',
        'nama',
        'email',
        'no_hp',
        'nim',
        'tahun_lulus',
        'prodi',
        'alamat',
        'status_pekerjaan',
        'saran',
        'tanggal_isi',
        // detail pekerjaan
        'nama_perusahaan',
        'jabatan',
        'alamat_pekerjaan',
        'gaji',
        'provinsi',
        'kota',
        'tingkat_usaha_level',

        // detail wirausaha
        'nama_usaha',
        'posisi_usaha',
        'tingkat_usaha',
        'alamat_usaha',
        'pendapatan_usaha',
        // kompetensi
        'etika',
        'keahlian',
        'penggunaanteknologi',
        'teamwork',
        'komunikasi',
        'pengembangan',
        // evaluasi
        'relevansi_pekerjaan',
        'bekerja',
        'status_kerja',
    ];

    protected $casts = [
        'tanggal_isi' => 'date',
        'tahun_lulus' => 'integer'
    ];

    // Relasi ke User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Alumni
    public function alumni(): BelongsTo
    {
        return $this->belongsTo(Alumni::class);
    }

    // Relasi ke detail pendidikan lanjut
    public function pendidikan(): HasOne
    {
        return $this->hasOne(TracerPendidikan::class);
    }

    // Relasi ke kuesioner atasan
    public function pengguna(): HasOne
    {
        return $this->hasOne(TracerPengguna::class);
    }

    // Relasi ke detail pekerjaan (hanya untuk yang bekerja)
    public function pekerjaan(): HasOne
    {
        return $this->hasOne(TracerPekerjaan::class);
    }

    // Relasi ke detail wirausaha
    public function wirausaha(): HasOne
    {
        return $this->hasOne(TracerWirausaha::class);
    }

    // Relasi ke kompetensi (untuk semua status)
    public function kompetensi(): HasOne
    {
        return $this->hasOne(TracerKompetensi::class);
    }

    // Relasi ke pencarian kerja (untuk yang bekerja)
    public function pencarianKerja(): HasOne
    {
        return $this->hasOne(TracerPencarianKerja::class);
    }

    // Relasi ke evaluasi pendidikan (untuk semua status)
    public function evaluasiPendidikan(): HasOne
    {
        return $this->hasOne(TracerEvaluasiPendidikan::class);
    }

    // Accessor untuk mendapatkan detail berdasarkan status
    public function getDetailAttribute()
    {
        return match($this->status_pekerjaan) {
            'bekerja_full' => $this->pekerjaan,
            'wirausaha' => $this->wirausaha,
            'lanjutstudy' => $this->pendidikan,
            default => null
        };
    }

    // Scope untuk filter berdasarkan status
    public function scopeByStatus($query, $status)
    {
        return $query->where('status_pekerjaan', $status);
    }

    // Scope untuk filter berdasarkan tahun lulus
    public function scopeByTahunLulus($query, $tahun)
    {
        return $query->where('tahun_lulus', $tahun);
    }
}
