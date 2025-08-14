<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TracerPengguna extends Model
{
    use HasFactory;

    protected $table = 'supervisor_questionnaires';

    protected $fillable = [
        'tracer_study_id',
        'nama_atasan',
        'jabatan_atasan',
        'nama_perusahaan',
        'nama_alumni',
        'jabatan_alumni',
        'tanggal_mulai_kerja',
        'tanggal_isi',
        'email_atasan',
        'wa_atasan',
        'encrypted_link',
        'expires_at',
        // Evaluasi kinerja (Point A)
        'integritas',
        'keahlian',
        'kemampuan',
        'penguasaan',
        'komunikasi',
        'kerja_tim',
        'pengembangan',
        // Evaluasi kesesuaian pendidikan
        'kesesuaian_pendidikan_pekerjaan',
        'kualitas_lulusan',
        'saran_perbaikan',
        'status_pengisian',
        'token_akses',
        'expired_at',
    ];

    protected $casts = [
        'tanggal_mulai_kerja' => 'date',
        'tanggal_isi' => 'date',
        'expired_at' => 'datetime',
    ];

    // Relasi ke TracerStudy
    public function tracerStudy(): BelongsTo
    {
        return $this->belongsTo(TracerStudy::class);
    }

    // Scope untuk filter berdasarkan status
    public function scopeByStatus($query, $status)
    {
        return $query->where('status_pengisian', $status);
    }

    // Scope untuk filter yang belum expired
    public function scopeNotExpired($query)
    {
        return $query->where('expired_at', '>', now());
    }

    // Scope untuk filter yang sudah expired
    public function scopeExpired($query)
    {
        return $query->where('expired_at', '<=', now());
    }

    // Accessor untuk status pengisian
    public function getStatusTextAttribute()
    {
        return match($this->status_pengisian) {
            'pending' => 'Menunggu Pengisian',
            'completed' => 'Sudah Diisi',
            'expired' => 'Kadaluarsa',
            default => 'Tidak Diketahui'
        };
    }

    // Method untuk generate token akses
    public function generateToken()
    {
        $this->token_akses = \Str::random(32);
        $this->expired_at = now()->addDays(30); // Token berlaku 30 hari
        $this->save();

        return $this->token_akses;
    }

    // Method untuk check apakah token masih valid
    public function isTokenValid()
    {
        return $this->expired_at && $this->expired_at->isFuture();
    }

    // Method untuk mark sebagai completed
    public function markAsCompleted()
    {
        $this->status_pengisian = 'completed';
        $this->tanggal_isi = now();
        $this->save();
    }

    // Method untuk mark sebagai sent
    public function markAsSent()
    {
        $this->status_pengisian = 'sent';
        $this->save();
    }

    // Method untuk generate encrypted link
    public static function generateEncryptedLink($tracerStudyId, $namaAtasan, $jabatanAtasan)
    {
        $data = [
            'tracer_study_id' => $tracerStudyId,
            'nama_atasan' => $namaAtasan,
            'jabatan_atasan' => $jabatanAtasan,
            'timestamp' => now()->timestamp
        ];

        $jsonData = json_encode($data);
        $encrypted = base64_encode($jsonData);

        return $encrypted;
    }

    // Method untuk get questionnaire URL
    public function getQuestionnaireUrl()
    {
        $baseUrl = config('app.url');
        return $baseUrl . '/supervisor/questionnaire/' . $this->token_akses;
    }

    // Method untuk menghitung skor rata-rata evaluasi
    public function getAverageScoreAttribute()
    {
        if ($this->status_pengisian !== 'completed') {
            return null;
        }

        $scores = [
            $this->integritas,
            $this->keahlian,
            $this->kemampuan,
            $this->penguasaan,
            $this->komunikasi,
            $this->kerja_tim,
            $this->pengembangan
        ];

        // Filter out null values
        $validScores = array_filter($scores, function($score) {
            return $score !== null;
        });

        if (empty($validScores)) {
            return null;
        }

        return array_sum($validScores) / count($validScores);
    }

    // Method untuk decrypt link
    public static function decryptLink($encryptedLink)
    {
        try {
            $decoded = base64_decode($encryptedLink);
            $data = json_decode($decoded, true);

            if (!$data || !isset($data['tracer_study_id'])) {
                return null;
            }

            return $data;
        } catch (\Exception $e) {
            return null;
        }
    }
}
