<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobVacancy extends Model
{
    use HasFactory;

    protected $table = 'job_vacancies';

    protected $fillable = [
        'company_name',
        'logo_path',
        'poster_paths',
        'position',
        'category',
        'description',
        'requirements',
        'location',
        'salary_range',
        'contact_email',
        'contact_link',
        'status',
        'pic_name',
        'pic_email',
        'pic_phone',
        'pic_position',
    ];

    protected $casts = [
        'poster_paths' => 'array',
    ];

    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class, 'job_vacancy_id');
    }
}
