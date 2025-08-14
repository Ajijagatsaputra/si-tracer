<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TracerPendidikan extends Model
{
    use HasFactory;

    protected $table = 'tracer_pendidikan';

    protected $fillable = [
        'tracer_study_id',
        'universitas',
        'program_studi',
        'sumber_biaya',
        'tanggal_masuk',
        'lokasi_universitas',
        'sumber_biaya_politeknik',
        'sumber_biaya_lainnya'
    ];

    protected $casts = [
        'tanggal_masuk' => 'date'
    ];

    public function tracerStudy(): BelongsTo
    {
        return $this->belongsTo(TracerStudy::class);
    }
}
