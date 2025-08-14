<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TracerEvaluasiPendidikan extends Model
{
    use HasFactory;

    protected $table = 'tracer_evaluasi_pendidikan';

    protected $fillable = [
        'tracer_study_id',
        'perkuliahan',
        'praktikum',
        'demonstrasi',
        'riset',
        'magang',
        'kerja_lapangan',
        'diskusi'
    ];

    public function tracerStudy(): BelongsTo
    {
        return $this->belongsTo(TracerStudy::class);
    }
}
