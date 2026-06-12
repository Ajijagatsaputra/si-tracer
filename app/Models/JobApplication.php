<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobApplication extends Model
{
    use HasFactory;

    protected $table = 'job_applications';

    protected $fillable = [
        'alumni_id',
        'job_vacancy_id',
        'status',
        'cover_letter',
        'cv_path',
        'phone',
        'expected_salary',
        'admin_notes',
        'applied_at',
        'reviewed_at',
    ];

    protected $casts = [
        'applied_at' => 'datetime',
        'reviewed_at' => 'datetime',
    ];

    // Relasi ke Alumni
    public function alumni(): BelongsTo
    {
        return $this->belongsTo(Alumni::class);
    }

    // Relasi ke JobVacancy
    public function jobVacancy(): BelongsTo
    {
        return $this->belongsTo(JobVacancy::class);
    }

    // Scope filter by status
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Scope filter by alumni
    public function scopeByAlumni($query, $alumniId)
    {
        return $query->where('alumni_id', $alumniId);
    }

    // Accessor: label status dalam Bahasa Indonesia
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'applied' => 'Dilamar',
            'reviewed' => 'Sedang Ditinjau',
            'accepted' => 'Diterima',
            'rejected' => 'Ditolak',
            default => 'Tidak Diketahui',
        };
    }

    // Accessor: CSS class untuk badge status
    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'applied' => 'warning',
            'reviewed' => 'info',
            'accepted' => 'success',
            'rejected' => 'danger',
            default => 'secondary',
        };
    }

    // Accessor: icon untuk badge status
    public function getStatusIconAttribute(): string
    {
        return match ($this->status) {
            'applied' => 'fa-paper-plane',
            'reviewed' => 'fa-eye',
            'accepted' => 'fa-check-circle',
            'rejected' => 'fa-times-circle',
            default => 'fa-question-circle',
        };
    }
}
