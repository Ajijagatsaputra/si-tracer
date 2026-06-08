<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\TracerStudy;
use App\Models\JobVacancy;
use Illuminate\Http\Request;

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

        // Fetch latest 3 approved job vacancies
        $recentJobs = JobVacancy::where('status', 'approved')->latest()->take(3)->get();

        return view('landing', compact(
            'totalAlumni',
            'totalTracer',
            'employed',
            'entrepreneur',
            'continuing',
            'workingPercentage',
            'recentJobs'
        ));
    }
}
