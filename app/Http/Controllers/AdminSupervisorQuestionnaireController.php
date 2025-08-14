<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TracerPengguna;
use App\Models\TracerStudy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminSupervisorQuestionnaireController extends Controller
{
    /**
     * Menampilkan data supervisor questionnaire untuk admin
     */
    public function index(Request $request)
    {
        $query = TracerPengguna::with(['tracerStudy.pekerjaan']);

        // Filter berdasarkan status jika ada
        if ($request->filled('status')) {
            $query->where('status_pengisian', $request->status);
        }

        // Filter berdasarkan perusahaan jika ada
        if ($request->filled('perusahaan')) {
            $query->where('nama_perusahaan', 'like', '%' . $request->perusahaan . '%');
        }

        // Filter berdasarkan tanggal jika ada
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $data = $query->latest()->paginate(10);

        // Statistik untuk dashboard
        $totalQuestionnaires = TracerPengguna::count();
        $pendingQuestionnaires = TracerPengguna::where('status_pengisian', 'pending')->count();
        $completedQuestionnaires = TracerPengguna::where('status_pengisian', 'completed')->count();
        $expiredQuestionnaires = TracerPengguna::where('expires_at', '<', now())->count();

        // Data untuk filter dropdown
        $statuses = ['pending', 'completed', 'expired'];
        $perusahaans = TracerPengguna::distinct()->pluck('nama_perusahaan')->filter();
        $tahuns = TracerPengguna::selectRaw('YEAR(created_at) as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        return view('admin.supervisor-questionnaire.index', compact(
            'data',
            'statuses',
            'perusahaans',
            'tahuns',
            'totalQuestionnaires',
            'pendingQuestionnaires',
            'completedQuestionnaires',
            'expiredQuestionnaires'
        ));
    }

    /**
     * Menampilkan dashboard supervisor questionnaire
     */
    public function dashboard()
    {
        // Statistik dasar
        $totalQuestionnaires = TracerPengguna::count();
        $pendingQuestionnaires = TracerPengguna::where('status_pengisian', 'pending')->count();
        $completedQuestionnaires = TracerPengguna::where('status_pengisian', 'completed')->count();
        $expiredQuestionnaires = TracerPengguna::where('expires_at', '<', now())->count();

        // Rata-rata skor evaluasi per kategori
        $averageScores = [];
        $evaluationFields = ['integritas', 'keahlian', 'kemampuan', 'penguasaan', 'komunikasi', 'kerja_tim', 'pengembangan'];

        foreach ($evaluationFields as $field) {
            $averageScores[$field] = TracerPengguna::where('status_pengisian', 'completed')
                ->whereNotNull($field)
                ->avg($field);
        }

        // Distribusi skor rata-rata
        $scoreDistribution = [
            'excellent' => TracerPengguna::where('status_pengisian', 'completed')
                ->whereRaw('(integritas + keahlian + kemampuan + penguasaan + komunikasi + kerja_tim + pengembangan) / 7 >= 4.5')
                ->count(),
            'good' => TracerPengguna::where('status_pengisian', 'completed')
                ->whereRaw('(integritas + keahlian + kemampuan + penguasaan + komunikasi + kerja_tim + pengembangan) / 7 >= 3.5')
                ->whereRaw('(integritas + keahlian + kemampuan + penguasaan + komunikasi + kerja_tim + pengembangan) / 7 < 4.5')
                ->count(),
            'fair' => TracerPengguna::where('status_pengisian', 'completed')
                ->whereRaw('(integritas + keahlian + kemampuan + penguasaan + komunikasi + kerja_tim + pengembangan) / 7 >= 2.5')
                ->whereRaw('(integritas + keahlian + kemampuan + penguasaan + komunikasi + kerja_tim + pengembangan) / 7 < 3.5')
                ->count(),
            'poor' => TracerPengguna::where('status_pengisian', 'completed')
                ->whereRaw('(integritas + keahlian + kemampuan + penguasaan + komunikasi + kerja_tim + pengembangan) / 7 >= 1.5')
                ->whereRaw('(integritas + keahlian + kemampuan + penguasaan + komunikasi + kerja_tim + pengembangan) / 7 < 2.5')
                ->count(),
            'very_poor' => TracerPengguna::where('status_pengisian', 'completed')
                ->whereRaw('(integritas + keahlian + kemampuan + penguasaan + komunikasi + kerja_tim + pengembangan) / 7 < 1.5')
                ->count(),
        ];

        // Kesesuaian pendidikan
        $educationMatch = [
            'sangat_sesuai' => TracerPengguna::where('status_pengisian', 'completed')
                ->where('kesesuaian_pendidikan_pekerjaan', 'sangat_sesuai')->count(),
            'sesuai' => TracerPengguna::where('status_pengisian', 'completed')
                ->where('kesesuaian_pendidikan_pekerjaan', 'sesuai')->count(),
            'cukup_sesuai' => TracerPengguna::where('status_pengisian', 'completed')
                ->where('kesesuaian_pendidikan_pekerjaan', 'cukup_sesuai')->count(),
            'kurang_sesuai' => TracerPengguna::where('status_pengisian', 'completed')
                ->where('kesesuaian_pendidikan_pekerjaan', 'kurang_sesuai')->count(),
            'tidak_sesuai' => TracerPengguna::where('status_pengisian', 'completed')
                ->where('kesesuaian_pendidikan_pekerjaan', 'tidak_sesuai')->count(),
        ];

        // Top performers (top 5 berdasarkan skor rata-rata)
        $topPerformers = TracerPengguna::where('status_pengisian', 'completed')
            ->whereNotNull('integritas')
            ->whereNotNull('keahlian')
            ->whereNotNull('kemampuan')
            ->whereNotNull('penguasaan')
            ->whereNotNull('komunikasi')
            ->whereNotNull('kerja_tim')
            ->whereNotNull('pengembangan')
            ->get()
            ->map(function ($item) {
                $item->average_score = $item->average_score;
                return $item;
            })
            ->sortByDesc('average_score')
            ->take(5);

        return view('admin.supervisor-questionnaire.dashboard', compact(
            'totalQuestionnaires',
            'pendingQuestionnaires',
            'completedQuestionnaires',
            'expiredQuestionnaires',
            'averageScores',
            'scoreDistribution',
            'educationMatch',
            'topPerformers'
        ));
    }

    /**
     * Menampilkan detail supervisor questionnaire
     */
    public function show($id)
    {
        $questionnaire = TracerPengguna::with(['tracerStudy.pekerjaan'])->findOrFail($id);
        return view('admin.supervisor-questionnaire.show', compact('questionnaire'));
    }

    /**
     * Menampilkan form edit supervisor questionnaire
     */
    public function edit($id)
    {
        $questionnaire = TracerPengguna::with(['tracerStudy.pekerjaan'])->findOrFail($id);
        return view('admin.supervisor-questionnaire.edit', compact('questionnaire'));
    }

    /**
     * Update supervisor questionnaire
     */
    public function update(Request $request, $id)
    {
        try {
            $questionnaire = TracerPengguna::findOrFail($id);

            $request->validate([
                'nama_atasan' => 'required|string|max:255',
                'jabatan_atasan' => 'required|string|max:255',
                'nama_perusahaan' => 'required|string|max:255',
                'email_atasan' => 'nullable|email|max:255',
                'wa_atasan' => 'nullable|string|max:20',
                'status_pengisian' => 'required|in:pending,completed,expired',
                'expires_at' => 'required|date',
            ]);

            if ($request->input('status_pengisian') === 'completed') {
                return redirect()->route('admin.supervisor-questionnaire.edit', $id)
                    ->withErrors(['error' => 'Status pengisian hanya dapat diubah menjadi completed oleh supervisor, bukan oleh admin.']);
            }

            $questionnaire->update($request->all());

            return redirect()->route('admin.supervisor-questionnaire.show', $id)
                ->with('success', 'Data supervisor questionnaire berhasil diperbarui.');
        } catch (\Exception $e) {
            \Log::error('Error updating supervisor questionnaire: ' . $e->getMessage(), [
                'id' => $id,
                'error' => $e->getMessage()
            ]);

            return redirect()->route('admin.supervisor-questionnaire.edit', $id)
                ->withErrors(['error' => 'Gagal memperbarui data: ' . $e->getMessage()]);
        }
    }

    /**
     * Hapus supervisor questionnaire
     */
    public function destroy($id)
    {
        try {
            $questionnaire = TracerPengguna::findOrFail($id);
            $questionnaire->delete();

            return redirect()->route('admin.supervisor-questionnaire.index')
                ->with('success', 'Data supervisor questionnaire berhasil dihapus.');
        } catch (\Exception $e) {
            \Log::error('Error deleting supervisor questionnaire: ' . $e->getMessage(), [
                'id' => $id,
                'error' => $e->getMessage()
            ]);

            return redirect()->route('admin.supervisor-questionnaire.index')
                ->withErrors(['error' => 'Gagal menghapus data: ' . $e->getMessage()]);
        }
    }

    /**
     * Resend notification to supervisor
     */
    public function resendNotification($id)
    {
        try {
            $questionnaire = TracerPengguna::with(['tracerStudy.pekerjaan'])->findOrFail($id);

            // Generate new token if expired
            if ($questionnaire->expires_at < now()) {
                $questionnaire->update([
                    'expires_at' => now()->addDays(7),
                    'status_pengisian' => 'pending'
                ]);
                $questionnaire->generateToken();
            }

            // Send notification
            $notificationService = new \App\Services\NotificationService();
            $supervisorData = [
                'email_atasan' => $questionnaire->email_atasan,
                'wa_atasan' => $questionnaire->wa_atasan,
                'nama_atasan' => $questionnaire->nama_atasan,
                'nama_alumni' => $questionnaire->nama_alumni,
                'nama_perusahaan' => $questionnaire->nama_perusahaan,
                'questionnaire_url' => $questionnaire->getQuestionnaireUrl(),
            ];

            $notificationService->sendSupervisorNotification($supervisorData);

            // Mark as sent
            $questionnaire->markAsSent();

            return redirect()->route('admin.supervisor-questionnaire.show', $id)
                ->with('success', 'Notifikasi berhasil dikirim ulang ke supervisor.');

        } catch (\Exception $e) {
            \Log::error('Error resending notification: ' . $e->getMessage(), [
                'id' => $id,
                'error' => $e->getMessage()
            ]);

            return redirect()->route('admin.supervisor-questionnaire.show', $id)
                ->withErrors(['error' => 'Gagal mengirim notifikasi: ' . $e->getMessage()]);
        }
    }

    /**
     * Export data supervisor questionnaire
     */
    public function export(Request $request)
    {
        $query = TracerPengguna::with(['tracerStudy.pekerjaan']);

        // Apply same filters as index
        if ($request->filled('status')) {
            $query->where('status_pengisian', $request->status);
        }

        if ($request->filled('perusahaan')) {
            $query->where('nama_perusahaan', 'like', '%' . $request->perusahaan . '%');
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $data = $query->get();

        // Return as JSON for DataTables export or implement Excel/PDF export
        return response()->json($data);
    }

    /**
     * Get statistics for dashboard
     */
    public function getStatistics()
    {
        $total = TracerPengguna::count();
        $thisMonth = TracerPengguna::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $byStatus = TracerPengguna::selectRaw('status_pengisian, COUNT(*) as total')
            ->groupBy('status_pengisian')
            ->get();

        $byCompany = TracerPengguna::selectRaw('nama_perusahaan, COUNT(*) as total')
            ->groupBy('nama_perusahaan')
            ->orderBy('total', 'desc')
            ->limit(10)
            ->get();

        return [
            'total' => $total,
            'this_month' => $thisMonth,
            'by_status' => $byStatus,
            'by_company' => $byCompany
        ];
    }
}
