<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\HistoryPrediksi;
use App\Models\Alumni;

class AdminPrediksiController extends Controller
{
    const JOB_TITLES = [
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

    public function index()
    {
        return view('admin.prediksi.index');
    }

    public function data()
    {
        // Statistik ringkas
        $totalPredictions = HistoryPrediksi::count();
        $todayPredictions = HistoryPrediksi::whereDate('created_at', now()->toDateString())->count();
        $last7DaysPredictions = HistoryPrediksi::where('created_at', '>=', now()->subDays(7))->count();
        $uniqueUsers = HistoryPrediksi::distinct('idAlumni')->count('idAlumni');

        // Prediksi per hari 7 hari terakhir
        $start = now()->subDays(6)->startOfDay();
        $byDay = HistoryPrediksi::select(DB::raw('DATE(created_at) as d'), DB::raw('COUNT(*) as c'))
            ->where('created_at', '>=', $start)
            ->groupBy('d')
            ->orderBy('d')
            ->pluck('c', 'd');
        $last7DaysLabels = [];
        $last7DaysCounts = [];
        for ($i = 0; $i < 7; $i++) {
            $day = $start->copy()->addDays($i)->toDateString();
            $last7DaysLabels[] = date('d M', strtotime($day));
            $last7DaysCounts[] = (int)($byDay[$day] ?? 0);
        }

        // Extract job titles dari hasil prediksi
        // Hitung semua job titles yang ditemukan (bisa multiple per prediksi)
        $allHistories = HistoryPrediksi::select('hasil')->get();
        $jobTitleCounts = []; // Dinamis, tidak hanya dari konstanta

        foreach ($allHistories as $h) {
            $hasil = $h->hasil ?? '';
            $titles = $this->extractJobTitlesFromText($hasil);
            // Hitung setiap job title yang ditemukan
            foreach ($titles as $title) {
                if (!isset($jobTitleCounts[$title])) {
                    $jobTitleCounts[$title] = 0;
                }
                $jobTitleCounts[$title]++;
            }
        }

        // Sort by count descending, take top 10
        arsort($jobTitleCounts);
        $jobTitleCounts = array_slice($jobTitleCounts, 0, 10, true);
        $jobTitleLabels = array_keys($jobTitleCounts);
        $jobTitleCounts = array_values($jobTitleCounts);

        // Riwayat terbaru dengan extracted job titles
        $histories = HistoryPrediksi::with('alumni')->latest()->limit(20)->get()->map(function ($h) {
            $h->extracted_job_titles = $this->extractJobTitlesFromText($h->hasil ?? '');
            return $h;
        });

        return view('admin.prediksi.data-prediksi', compact(
            'totalPredictions',
            'todayPredictions',
            'last7DaysPredictions',
            'uniqueUsers',
            'last7DaysLabels',
            'last7DaysCounts',
            'jobTitleLabels',
            'jobTitleCounts',
            'histories'
        ));
    }

    private function extractJobTitlesFromText(string $text): array
    {
        $found = [];
        $text = ' ' . strtolower($text) . ' ';
        foreach (self::JOB_TITLES as $title) {
            // Cari dengan case-insensitive, pastikan match sebagai whole word
            $pattern = '/\b' . preg_quote(strtolower($title), '/') . '\b/i';
            if (preg_match($pattern, $text)) {
                $found[] = $title;
            }
        }
        return $found;
    }

    public function show($id)
    {
        $history = HistoryPrediksi::with('alumni')->findOrFail($id);
        $history->extracted_job_titles = $this->extractJobTitlesFromText($history->hasil ?? '');

        return view('admin.prediksi.show', compact('history'));
    }

    public function destroy($id)
    {
        $history = HistoryPrediksi::find($id);
        if (!$history) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        $history->delete();
        return redirect()->route('admin.prediksi.data')->with('success', 'Data berhasil dihapus.');
    }
}
