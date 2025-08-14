<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TracerWirausaha extends Model
{
    use HasFactory;

    protected $table = 'tracer_wirausaha';

    protected $fillable = [
        'tracer_study_id',
        'nama_usaha',
        'posisi_usaha',
        'tingkat_usaha_level',
        'alamat_usaha',
        'pendapatan_usaha',
        'hubungan_studi_pekerjaan',
        'pendidikan_sesuai_pekerjaan'
    ];

    protected $casts = [
        'pendapatan_usaha' => 'decimal:2'
    ];

    public function tracerStudy(): BelongsTo
    {
        return $this->belongsTo(TracerStudy::class);
    }
}
