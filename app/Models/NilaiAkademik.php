<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NilaiAkademik extends Model
{
    protected $table = 'nilai_akademik';

    protected $fillable = [
        'idAlumni',
        'mataKuliah',
        'sks',
        'grade',
    ];

    protected $casts = [
        'sks' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];


    public function alumni(): BelongsTo
    {
        return $this->belongsTo(Alumni::class, 'idAlumni');
    }
}
