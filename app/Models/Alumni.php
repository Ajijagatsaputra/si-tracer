<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumni extends Model
{
    use HasFactory;

    protected $table = 'alumni';

    protected $fillable = [
        'id_users',
        'nim',
        'nama_lengkap',
        'prodi',
        'alamat',
        'no_hp',
        'kelas',
        'jalur',
        'tahun_masuk',
        'tahun_lulus',
        'status_mahasiswa',
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'id_users');
    }

    public function tracerStudies()
    {
        return $this->hasMany(TracerStudy::class, 'alumni_id');
    }

    public function tracerStudy()
    {
        return $this->hasOne(TracerStudy::class, 'alumni_id');
    }

    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class, 'alumni_id');
    }
}
