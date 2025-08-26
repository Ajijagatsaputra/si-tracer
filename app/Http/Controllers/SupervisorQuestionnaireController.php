<?php

namespace App\Http\Controllers;

use App\Models\TracerPengguna;
use App\Models\TracerStudy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Services\NotificationService;

class SupervisorQuestionnaireController extends Controller
{
    /**
     * Tampilkan form kuesioner supervisor berdasarkan token
     */
    public function show($token)
    {
        try {
            // Cari kuesioner supervisor berdasarkan token
            $tracerPengguna = TracerPengguna::where('token_akses', $token)
                ->first();

            if (!$tracerPengguna) {
                return view('supervisor.questionnaire.invalid-link', [
                    'message' => 'Kuesioner tidak ditemukan atau sudah diisi.'
                ]);
            }

            if ($tracerPengguna->status_pengisian == 'completed') {
                return view('supervisor.questionnaire.success', [
                    'message' => 'Kuesioner sudah diisi.',
                    'tracerPengguna' => $tracerPengguna
                ]);
            }

            // Cek apakah token sudah expired
            if ($tracerPengguna->expired_at && $tracerPengguna->expired_at->isPast()) {
                return view('supervisor.questionnaire.invalid-link', [
                    'message' => 'Link kuesioner sudah kadaluarsa.'
                ]);
            }

            if ($tracerPengguna->status_pengisian == 'expired') {
                return view('supervisor.questionnaire.invalid-link', [
                    'message' => 'Link kuesioner sudah kadaluarsa.'
                ]);
            }

            // Ambil data tracer study
            $tracerStudy = TracerStudy::find($tracerPengguna->tracer_study_id);

            if (!$tracerStudy) {
                return view('supervisor.questionnaire.invalid-link', [
                    'message' => 'Data tracer study tidak ditemukan.'
                ]);
            }

            return view('supervisor.questionnaire.form', compact('tracerPengguna', 'tracerStudy'));

        } catch (\Exception $e) {
            Log::error('Error showing supervisor questionnaire: ' . $e->getMessage(), [
                'token' => $token,
                'error' => $e->getMessage()
            ]);

            return view('supervisor.questionnaire.invalid-link', [
                'message' => 'Terjadi kesalahan saat membuka kuesioner.'
            ]);
        }
    }

    /**
     * Submit kuesioner supervisor
     */
    public function submit(Request $request, $token)
    {
        try {
            // Cari kuesioner supervisor berdasarkan token
            $tracerPengguna = TracerPengguna::where('token_akses', $token)
                ->where('status_pengisian', '!=', 'completed')
                ->first();

            if (!$tracerPengguna) {
                return back()->withErrors(['error' => 'Kuesioner tidak ditemukan atau sudah diisi.']);
            }

            // Validasi input
            $validator = Validator::make($request->all(), [
                'integritas' => 'required|in:1,2,3,4,5',
                'keahlian' => 'required|in:1,2,3,4,5',
                'kemampuan' => 'required|in:1,2,3,4,5',
                'penguasaan' => 'required|in:1,2,3,4,5',
                'komunikasi' => 'required|in:1,2,3,4,5',
                'kerja_tim' => 'required|in:1,2,3,4,5',
                'pengembangan' => 'required|in:1,2,3,4,5',
                'kesesuaian_pendidikan_pekerjaan' => 'required|in:sangat_sesuai,sesuai,cukup_sesuai,kurang_sesuai,tidak_sesuai',
                'kualitas_lulusan' => 'required|in:sangat_baik,baik,cukup,kurang,sangat_kurang',
                'saran_perbaikan' => 'nullable|string|max:1000',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            // Update kuesioner supervisor
            $tracerPengguna->update([
                'integritas' => $request->integritas,
                'keahlian' => $request->keahlian,
                'kemampuan' => $request->kemampuan,
                'penguasaan' => $request->penguasaan,
                'komunikasi' => $request->komunikasi,
                'kerja_tim' => $request->kerja_tim,
                'pengembangan' => $request->pengembangan,
                'kesesuaian_pendidikan_pekerjaan' => $request->kesesuaian_pendidikan_pekerjaan,
                'kualitas_lulusan' => $request->kualitas_lulusan,
                'saran_perbaikan' => $request->saran_perbaikan,
                'status_pengisian' => 'completed',
                'tanggal_isi' => now(),
            ]);

            Log::info('Supervisor questionnaire completed successfully', [
                'supervisor_questionnaire_id' => $tracerPengguna->id,
                'tracer_study_id' => $tracerPengguna->tracer_study_id
            ]);

            return view('supervisor.questionnaire.success', [
                'message' => 'Terima kasih telah mengisi kuesioner evaluasi kinerja alumni.',
                'tracerPengguna' => $tracerPengguna
            ]);

        } catch (\Exception $e) {
            Log::error('Error submitting supervisor questionnaire: ' . $e->getMessage(), [
                'token' => $token,
                'error' => $e->getMessage()
            ]);

            return back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan kuesioner. Silakan coba lagi.']);
        }
    }

    /**
     * Preview kuesioner supervisor (untuk testing)
     */
    public function preview($id)
    {
        $tracerPengguna = TracerPengguna::with('tracerStudy')->findOrFail($id);

        return view('supervisor.questionnaire.form', compact('tracerPengguna'));
    }

    /**
     * Menampilkan hasil data pengisian kuesioner supervisor berdasarkan token
     */
    public function hasil($token)
    {
        try {
            $tracerPengguna = \App\Models\TracerPengguna::where('token_akses', $token)
                ->with('tracerStudy')
                ->firstOrFail();

            // Pastikan status pengisian sudah completed
            if ($tracerPengguna->status_pengisian !== 'completed') {
                if (auth()->check() && auth()->user()->role === 'admin') {
                    return redirect()->route('home')->with('error', 'Kuesioner belum diisi oleh supervisor.');
                } else {
                    return back()->with('error', 'Kuesioner belum diisi oleh supervisor.');
                }
            }

            if (auth()->check() ) {
                return view('supervisor.questionnaire.hasil-view-alumni', compact('tracerPengguna'));
            } else {
                return view('supervisor.questionnaire.hasil', compact('tracerPengguna'));
            }
        } catch (\Exception $e) {
            \Log::error('Error fetching supervisor questionnaire result: ' . $e->getMessage(), [
                'token' => $token,
                'error' => $e->getMessage()
            ]);
            if (auth()->check() && auth()->user()->role === 'admin') {
                return redirect()->route('home')->with('error', 'Data hasil kuesioner tidak ditemukan atau terjadi kesalahan.');
            } else {
                return back()->withErrors(['error' => 'Data hasil kuesioner tidak ditemukan atau terjadi kesalahan.']);
            }
        }
    }

    /**
     * Resend kuesioner supervisor
     */
    public function resend($id)
    {
        try {
            $tracerPengguna = TracerPengguna::findOrFail($id);

            // Generate token baru
            $tracerPengguna->generateToken();

            // Kirim notifikasi ulang
            $notificationService = new NotificationService();
            $supervisorData = [
                'email_atasan' => $tracerPengguna->email_atasan,
                'wa_atasan' => $tracerPengguna->wa_atasan,
                'nama_atasan' => $tracerPengguna->nama_atasan,
                'nama_alumni' => $tracerPengguna->nama_alumni,
                'nama_perusahaan' => $tracerPengguna->nama_perusahaan,
                'questionnaire_url' => $tracerPengguna->getQuestionnaireUrl(),
            ];

            $notificationService->sendSupervisorNotification($supervisorData);
            $tracerPengguna->markAsSent();

            return back()->with('success', 'Kuesioner berhasil dikirim ulang ke supervisor.');

        } catch (\Exception $e) {
            Log::error('Error resending supervisor questionnaire: ' . $e->getMessage(), [
                'supervisor_questionnaire_id' => $id,
                'error' => $e->getMessage()
            ]);

            return back()->withErrors(['error' => 'Gagal mengirim ulang kuesioner. Silakan coba lagi.']);
        }
    }
}
