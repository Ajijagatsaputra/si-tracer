<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Alumni;
use App\Models\TracerStudy;
use App\Models\NilaiAkademik;
use App\Models\HistoryPrediksi;

class AlumniCvController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $alumni = $user->alumni;

        if (!$alumni) {
            return redirect()->route('profile')->with('error', 'Silakan lengkapi profil alumni Anda terlebih dahulu.');
        }

        // Ambil Nilai Akademik dan Hitung IPK
        $nilaiList = NilaiAkademik::where('idAlumni', $alumni->id)->get();
        $totalSks = 0;
        $totalPoints = 0.0;

        foreach ($nilaiList as $nilai) {
            $grade = strtoupper(trim($nilai->grade));
            $sks = (int) $nilai->sks;

            $points = match($grade) {
                'A', 'A+' => 4.0,
                'A-'      => 3.7,
                'B+'      => 3.3,
                'B'       => 3.0,
                'B-'      => 2.7,
                'C+'      => 2.3,
                'C'       => 2.0,
                'C-'      => 1.7,
                'D'       => 1.0,
                default   => 0.0
            };

            $totalSks += $sks;
            $totalPoints += ($points * $sks);
        }

        $ipk = $totalSks > 0 ? round($totalPoints / $totalSks, 2) : null;

        // Ambil Tracer Study terbaru
        $tracer = TracerStudy::where('alumni_id', $alumni->id)
            ->with(['pekerjaan', 'wirausaha', 'kompetensi', 'pendidikan'])
            ->latest()
            ->first();

        // Ambil Prediksi Karir AI terbaru
        $prediksi = HistoryPrediksi::where('idAlumni', $alumni->id)
            ->latest()
            ->first();

        // Extract rekomendasi karir dari teks hasil prediksi
        $rekomendasiKarir = [];
        if ($prediksi && $prediksi->hasil) {
            $rekomendasiKarir = $this->extractJobTitlesFromText($prediksi->hasil);
        }

        return view('alumni.cv', compact(
            'alumni',
            'nilaiList',
            'ipk',
            'totalSks',
            'tracer',
            'prediksi',
            'rekomendasiKarir'
        ));
    }

    private function extractJobTitlesFromText(string $text): array
    {
        $jobTitles = [
            'AI ML Specialist',
            'API Specialist',
            'Application Support Engineer',
            'Business Analyst',
            'Customer Service Executive',
            'Cyber Security Specialist',
            'Database Administrator',
            'Graphics Designer',
            'Hardware Engineer',
            'Helpdesk Engineer',
            'Information Security Specialist',
            'Networking Engineer',
            'Project Manager',
            'Software Developer',
            'Software Tester',
            'Technical Writer'
        ];

        $found = [];
        $textLower = ' ' . strtolower($text) . ' ';
        foreach ($jobTitles as $title) {
            $pattern = '/\b' . preg_quote(strtolower($title), '/') . '\b/i';
            if (preg_match($pattern, $textLower)) {
                $found[] = $title;
            }
        }
        return $found;
    }
}
