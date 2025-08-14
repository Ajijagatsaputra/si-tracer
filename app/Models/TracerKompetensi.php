<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TracerKompetensi extends Model
{
    use HasFactory;

    protected $table = 'tracer_kompetensi';

    protected $fillable = [
        'tracer_study_id',
        // Kompetensi awal (Point A)
        'etika_awal',
        'keahlian_awal',
        'bahasa_inggris_awal',
        'teknologi_awal',
        'kerjasama_awal',
        'komunikasi_awal',
        'pengembangan_awal',
        // Kompetensi sekarang (Point B)
        'etika_sekarang',
        'keahlian_sekarang',
        'bahasa_inggris_sekarang',
        'teknologi_sekarang',
        'kerjasama_sekarang',
        'komunikasi_sekarang',
        'pengembangan_sekarang'
    ];

    public function tracerStudy(): BelongsTo
    {
        return $this->belongsTo(TracerStudy::class);
    }
}
