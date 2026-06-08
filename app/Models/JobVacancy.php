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
        'position',
        'category',
        'description',
        'requirements',
        'location',
        'salary_range',
        'contact_email',
        'contact_link',
        'status',
    ];
}
