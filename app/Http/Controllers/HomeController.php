<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\TracerStudy;
use App\Models\TracerPengguna;
use App\Services\OaseClient;

class HomeController extends Controller
{
    public function index(OaseClient $oase)
    {
        // 1) Tahun akademik (cache 1 jam)
        $tahunAkademikList = $oase->getTahunAkademikList();
        $selectedTA = null;

        if (!empty($tahunAkademikList)) {
            $defaultTA = collect($tahunAkademikList)->firstWhere('status', 1);
            $selectedTA = request()->input('tahun_akademik', $defaultTA['kode'] ?? null);
        }

        // 2) Dosen count berdasarkan TA (cache 30 menit) — kalau perlu
        // $countDosen = $oase->getDosenCount($selectedTA);

        $user = Auth::user();

        // Data grafik lokal (DB)
        $tahun = range(2021, 2025);
        $alumniData = $this->getAlumniData($tahun);
        $kuisonerData = $this->getKuisionerData($tahun);

        if ($user && in_array($user->role, ['admin', 'superadmin'])) {
            // 3) Hit API mahal (mahasiswa total) pakai cache 6 jam
            $countMahasiswa = $oase->getMahasiswaTotal(2020, 2025);

            // Lokal (DB)
            $countAlumni = $this->getAlumniCount();
            $statistikAlumni = $this->getStatistikBekerja();

            $countQuestioner = TracerPengguna::count();
            $countQuestionerCompleted = TracerPengguna::where('status_pengisian', 'completed')->count();

            return view('admin.admin-dashboard', compact(
                'countMahasiswa',
                'countAlumni',
                'statistikAlumni',
                'tahun',
                'alumniData',
                'kuisonerData',
                'tahunAkademikList',
                'selectedTA',
                'countQuestioner',
                'countQuestionerCompleted'
                // ,'countDosen'
            ));
        }

        // Alumni
        $alumni = $user->alumni ?? Alumni::where('id_users', $user->id)->first();
        $hasFilledTracer = $alumni ? TracerStudy::where('alumni_id', $alumni->id)->exists() : false;
        $statusTracer = $hasFilledTracer ? 'sudah' : 'belum';

        return view('alumni.main', compact('tahun', 'alumniData', 'kuisonerData', 'statusTracer'));
    }

    private function getAlumniCount()
    {
        return DB::table('alumni')->count();
    }

    private function getStatistikBekerja()
    {
        $bekerja      = TracerStudy::where('status_pekerjaan', 'bekerja_full')->count();
        $belum        = TracerStudy::where('status_pekerjaan', 'belum_bekerja')->count();
        $wirausaha    = TracerStudy::where('status_pekerjaan', 'wirausaha')->count();
        $lanjutStudy  = TracerStudy::where('status_pekerjaan', 'lanjutstudy')->count();
        $tidakBekerja = TracerStudy::where('status_pekerjaan', 'tidak')->count();

        $total = $bekerja + $belum + $wirausaha + $lanjutStudy + $tidakBekerja;

        $pct = fn($n) => $total ? round(($n / $total) * 100, 1) . '%' : '0%';

        return [
            'Bekerja'         => ['jumlah' => $bekerja,      'persen' => $pct($bekerja)],
            'Belum Bekerja'   => ['jumlah' => $belum,        'persen' => $pct($belum)],
            'Wirausaha'       => ['jumlah' => $wirausaha,    'persen' => $pct($wirausaha)],
            'Lanjut Studi'    => ['jumlah' => $lanjutStudy,  'persen' => $pct($lanjutStudy)],
            'Tidak Bekerja'   => ['jumlah' => $tidakBekerja, 'persen' => $pct($tidakBekerja)],
        ];
    }

    private function getAlumniData($tahun)
    {
        $raw = DB::table('alumni')
            ->selectRaw('tahun_lulus as tahun, COUNT(*) as total')
            ->whereBetween('tahun_lulus', [$tahun[0], end($tahun)])
            ->groupBy('tahun_lulus')
            ->pluck('total', 'tahun')
            ->toArray();

        return array_map(fn($t) => $raw[$t] ?? 0, $tahun);
    }

    private function getKuisionerData($tahun)
    {
        $raw = DB::table('tracer_studies')
            ->join('alumni', 'tracer_studies.alumni_id', '=', 'alumni.id')
            ->selectRaw('alumni.tahun_lulus as tahun, COUNT(*) as total')
            ->whereBetween('alumni.tahun_lulus', [$tahun[0], end($tahun)])
            ->groupBy('alumni.tahun_lulus')
            ->pluck('total', 'tahun')
            ->toArray();

        return array_map(fn($t) => $raw[$t] ?? 0, $tahun);
    }
}
