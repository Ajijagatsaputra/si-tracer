<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\TracerStudy;
use App\Services\TracerStudyService;
use App\Http\Requests\TracerStudyRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TracerStudyController extends Controller
{
    protected $tracerStudyService;

    public function __construct(TracerStudyService $tracerStudyService)
    {
        $this->tracerStudyService = $tracerStudyService;
    }

    /**
     * Menampilkan form kuesioner
     */
    public function index()
    {
        $user = auth()->user();
        $alumni = Alumni::where('id_users', $user->id)->first();

        // Jika sudah ada kuesioner, arahkan ke halaman show
        $existingTracer = null;
        if ($alumni) {
            $existingTracer = TracerStudy::where('alumni_id', $alumni->id)->first();
            if ($existingTracer) {
                return redirect()->route('new-tracer.show', $existingTracer->id);
            }
        }


        return view('alumni.tracer.study.kuesioner', compact('alumni', 'existingTracer'));
    }

    /**
     * Menyimpan data tracer study
     */
    public function store(TracerStudyRequest $request)
    {
        try {
            // Data sudah divalidasi oleh TracerStudyRequest
            $validated = $request->validated();

            // Simpan data menggunakan service
            $tracerStudy = $this->tracerStudyService->saveTracerStudy($validated);

            Log::info('Tracer Study saved successfully:', [
                'tracer_study_id' => $tracerStudy->id,
                'status_pekerjaan' => $tracerStudy->status_pekerjaan
            ]);

            return redirect()->route('home')->with('success', 'Kuesioner tracer study berhasil disimpan!');
        } catch (\Exception $e) {
            Log::error('Error saving tracer study: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'url' => $request->url()
            ]);

            return back()
                ->withErrors(['error' => 'Gagal menyimpan data. Silakan coba lagi.'])
                ->withInput();
        }
    }

    /**
     * Menampilkan form edit
     */
    public function edit()
    {
        $user = auth()->user();
        $alumni = Alumni::where('id_users', $user->id)->first();

        if (!$alumni) {
            return redirect()->route('home')->withErrors(['error' => 'Data alumni tidak ditemukan']);
        }

        $tracer = TracerStudy::with([
            'pekerjaan',
            'wirausaha',
            'pendidikan',
            'kompetensi',
            'pencarianKerja',
            'evaluasiPendidikan'
        ])->where('alumni_id', $alumni->id)->first();

        if (!$tracer) {
            return redirect()->route('new-tracer.index')->withErrors(['error' => 'Anda belum mengisi tracer study']);
        }

        return view('alumni.tracer.study.edit-kuesioner', compact('alumni', 'tracer'));
    }

    /**
     * Update data tracer study
     */
    public function update(TracerStudyRequest $request, $id)
    {
        try {
            $tracer = TracerStudy::findOrFail($id);

            // Pastikan user hanya bisa edit data miliknya
            // dd($tracer->user_id, auth()->id());
            if ($tracer->user_id != auth()->id()) {
                return redirect()->route('home')->with('error', 'Anda tidak memiliki akses untuk mengubah data ini');
            }

            $validated = $request->validated();

            // Update menggunakan service
            $updatedTracer = $this->tracerStudyService->updateTracerStudy($id, $validated);

            return redirect()->route('home')->with('success', 'Data tracer study berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error('Error updating tracer study: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'tracer_study_id' => $id,
            ]);

            return back()
                ->with('error', 'Gagal memperbarui data. Silakan coba lagi.')
                ->withInput();
        }
    }

    /**
     * Menampilkan detail tracer study
     */
    public function show($id)
    {
        if ($id == Auth::user()->alumni->id) {
            $study = TracerStudy::where('alumni_id', $id)->first();
            $tracer = $this->tracerStudyService->getTracerStudyWithDetails($study->id);
            return view('alumni.tracer.study.detail-study', compact('tracer'));
        } else {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses untuk melihat data ini');
        }
    }

    /**
     * Check apakah user sudah mengisi tracer study
     */
    public function checkExisting()
    {
        $user = auth()->user();
        $alumni = Alumni::where('id_users', $user->id)->first();

        if (!$alumni) {
            return response()->json(['exists' => false, 'message' => 'Data alumni tidak ditemukan']);
        }

        $existing = TracerStudy::where('alumni_id', $alumni->id)->first();

        return response()->json([
            'exists' => $existing ? true : false,
            'data' => $existing ? [
                'id' => $existing->id,
                'tanggal_isi' => $existing->tanggal_isi,
                'status_pekerjaan' => $existing->status_pekerjaan
            ] : null
        ]);
    }
}
