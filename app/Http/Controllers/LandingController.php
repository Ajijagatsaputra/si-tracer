<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\TracerStudy;
use App\Models\JobVacancy;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LandingController extends Controller
{
    public function index()
    {
        $totalAlumni = Alumni::count();
        $totalTracer = TracerStudy::distinct('alumni_id')->count('alumni_id');

        $employed = TracerStudy::where('status_pekerjaan', 'bekerja_full')->count();
        $entrepreneur = TracerStudy::where('status_pekerjaan', 'wirausaha')->count();
        $continuing = TracerStudy::where('status_pekerjaan', 'lanjutstudy')->count();

        $workingCount = $employed + $entrepreneur;
        $workingPercentage = $totalTracer > 0 ? round(($workingCount / $totalTracer) * 100, 1) : 0;

        // Fetch latest 6 approved job vacancies
        $recentJobs = JobVacancy::where('status', 'approved')->latest()->take(6)->get();

        // Get applied job IDs for logged-in alumni
        $appliedJobIds = [];
        $hasFilledTracer = false; // Default: belum mengisi
        $user = Auth::user();

        if ($user && $user->role === 'alumni') {
            $alumni = $user->alumni ?? Alumni::where('id_users', $user->id)->first();
            if ($alumni) {
                $appliedJobIds = JobApplication::where('alumni_id', $alumni->id)
                    ->pluck('job_vacancy_id')
                    ->toArray();

                // Cek apakah alumni sudah mengisi tracer study
                $hasFilledTracer = TracerStudy::where('alumni_id', $alumni->id)->exists();
            }
        }

        return view('landing', compact(
            'totalAlumni',
            'totalTracer',
            'employed',
            'entrepreneur',
            'continuing',
            'workingPercentage',
            'recentJobs',
            'appliedJobIds',
            'hasFilledTracer'
        ));
    }
}
