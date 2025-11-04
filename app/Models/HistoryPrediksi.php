<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HistoryPrediksi extends Model
{
    protected $table = 'history_prediksi';

    protected $fillable = [
        'idAlumni',
        'hasil',
    ];

    public function alumni(): BelongsTo
    {
        return $this->belongsTo(Alumni::class, 'idAlumni');
    }
}
