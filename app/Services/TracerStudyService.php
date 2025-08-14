<?php

namespace App\Services;

use App\Models\TracerStudy;
use App\Models\TracerPekerjaan;
use App\Models\TracerWirausaha;
use App\Models\TracerPendidikan;
use App\Models\TracerKompetensi;
use App\Models\TracerPencarianKerja;
use App\Models\TracerEvaluasiPendidikan;
use App\Services\NotificationService;
use App\Jobs\SendNotificationJob;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TracerStudyService
{
    public function saveTracerStudy(array $data)
    {
        return DB::transaction(function () use ($data) {
            // Dapatkan alumni_id dari user yang login
            $user = auth()->user();
            $alumni = \App\Models\Alumni::where('id_users', $user->id)->first();

            // 1. Simpan data utama tracer study
            $tracerStudy = TracerStudy::create([
                'user_id' => $user->id,
                'alumni_id' => $alumni ? $alumni->id : null,
                'nama' => $data['nama'],
                'email' => $data['email'],
                'no_hp' => $data['no_hp'],
                'nim' => $data['nim'],
                'tahun_lulus' => $data['tahun_lulus'],
                'prodi' => $data['prodi'] ?? 'teknik_informatika',
                'alamat' => $data['alamat'],
                'status_pekerjaan' => $data['bekerja'], // dari form radio button
                'saran' => $data['saran'] ?? null,
                'tanggal_isi' => now()->toDateString()
            ]);

            if (!empty($data['alamat']) || !empty($data['tahun_lulus'])) {
                if ($alumni) {
                    $alumni->update([
                        'alamat' => $data['alamat'] ?? $alumni->alamat,
                        'tahun_lulus' => $data['tahun_lulus'] ?? $alumni->tahun_lulus,
                    ]);

                }
            }

            // 2. Simpan kompetensi (hanya untuk yang bekerja dan wiraswasta)
            if (in_array($data['bekerja'], ['bekerja_full', 'wirausaha'])) {
                TracerKompetensi::create([
                    'tracer_study_id' => $tracerStudy->id,
                    // Kompetensi awal (Point A)
                    'etika_awal' => $data['etika_awal'] ?? null,
                    'keahlian_awal' => $data['keahlian_awal'] ?? null,
                    'bahasa_inggris_awal' => $data['bahasa_inggris_awal'] ?? null,
                    'teknologi_awal' => $data['teknologi_awal'] ?? null,
                    'kerjasama_awal' => $data['kerjasama_awal'] ?? null,
                    'komunikasi_awal' => $data['komunikasi_awal'] ?? null,
                    'pengembangan_awal' => $data['pengembangan_awal'] ?? null,
                    // Kompetensi sekarang (Point B)
                    'etika_sekarang' => $data['etika_sekarang'] ?? null,
                    'keahlian_sekarang' => $data['keahlian_sekarang'] ?? null,
                    'bahasa_inggris_sekarang' => $data['bahasa_inggris_sekarang'] ?? null,
                    'teknologi_sekarang' => $data['teknologi_sekarang'] ?? null,
                    'kerjasama_sekarang' => $data['kerjasama_sekarang'] ?? null,
                    'komunikasi_sekarang' => $data['komunikasi_sekarang'] ?? null,
                    'pengembangan_sekarang' => $data['pengembangan_sekarang'] ?? null,
                ]);
            }

            // 3. Simpan evaluasi pendidikan (hanya untuk yang bekerja dan wiraswasta)
            if (in_array($data['bekerja'], ['bekerja_full', 'wirausaha'])) {
                TracerEvaluasiPendidikan::create([
                    'tracer_study_id' => $tracerStudy->id,
                    'perkuliahan' => $data['perkuliahan'] ?? null,
                    'praktikum' => $data['praktikum'] ?? null,
                    'demonstrasi' => $data['demonstrasi'] ?? null,
                    'riset' => $data['riset'] ?? null,
                    'magang' => $data['magang'] ?? null,
                    'kerja_lapangan' => $data['kerja_lapangan'] ?? null,
                    'diskusi' => $data['diskusi'] ?? null,
                ]);
            }

            // 4. Simpan detail berdasarkan status pekerjaan
            switch ($data['bekerja']) {
                case 'bekerja_full':
                    $this->savePekerjaanDetail($tracerStudy->id, $data);
                    $this->savePencarianKerjaDetail($tracerStudy->id, $data);
                    break;

                case 'wirausaha':
                    $this->saveWirausahaDetail($tracerStudy->id, $data);
                    $this->savePencarianKerjaDetail($tracerStudy->id, $data);
                    break;

                case 'lanjutstudy':
                    $this->savePendidikanDetail($tracerStudy->id, $data);
                    break;

                case 'belum_bekerja':
                    // Hanya simpan aktivitas saat ini (2 field saja)
                    $this->saveUnemployedDetail($tracerStudy->id, $data);
                    break;

                case 'tidak':
                    // Simpan semua detail pencarian kerja (termasuk cara mendapatkan pekerjaan)
                    $this->savePencarianKerjaDetail($tracerStudy->id, $data);
                    break;
            }

            // Kirim notifikasi otomatis setelah data berhasil disimpan
            $this->sendNotificationAfterSave($data);

            return $tracerStudy;
        });
    }

    /**
     * Kirim notifikasi setelah data berhasil disimpan
     */
    private function sendNotificationAfterSave(array $data)
    {
        try {
            // Dispatch job untuk pengiriman notifikasi async
            SendNotificationJob::dispatch($data);

            Log::info('Job notifikasi berhasil di-dispatch', [
                'nama' => $data['nama'] ?? 'Unknown'
            ]);

            // Jika status bekerja_full, buat kuesioner atasan
            if (($data['bekerja'] ?? '') === 'bekerja_full' &&
                (!empty($data['wa_atasan']) || !empty($data['email_atasan']))) {
                $this->createAndSendSupervisorQuestionnaire($data);
            }

        } catch (\Exception $e) {
            // Log error tapi jangan hentikan proses
            Log::error('Gagal dispatch job notifikasi: ' . $e->getMessage(), [
                'data' => $data,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Buat dan kirim kuesioner atasan
     */
    private function createAndSendSupervisorQuestionnaire(array $data)
    {
        try {
            // Ambil tracer study yang baru dibuat
            $tracerStudy = TracerStudy::where('nama', $data['nama'])
                ->where('email', $data['email'])
                ->latest()
                ->first();

            if (!$tracerStudy) {
                Log::error('Tracer study tidak ditemukan untuk kuesioner atasan', $data);
                return;
            }

            // Generate encrypted link
            $encryptedLink = \App\Models\TracerPengguna::generateEncryptedLink(
                $tracerStudy->id,
                $data['nama_atasan'] ?? 'Atasan',
                $data['jabatan_atasan'] ?? 'Jabatan'
            );

            // Buat record kuesioner atasan
            $supervisorQuestionnaire = \App\Models\TracerPengguna::create([
                'tracer_study_id' => $tracerStudy->id,
                'nama_atasan' => $data['nama_atasan'] ?? 'Atasan',
                'jabatan_atasan' => $data['jabatan_atasan'] ?? 'Jabatan',
                'nama_perusahaan' => $data['nama_perusahaan'] ?? 'Perusahaan',
                'nama_alumni' => $data['nama'] ?? 'Alumni',
                'jabatan_alumni' => $data['jabatan'] ?? 'Staff',
                'tanggal_mulai_kerja' => $data['tanggal_mulai_kerja'] ?? now(),
                'email_atasan' => $data['email_atasan'] ?? null,
                'wa_atasan' => $data['wa_atasan'] ?? null,
                'encrypted_link' => $encryptedLink,
                'expires_at' => now()->addDays(7), // Link kadaluarsa dalam 7 hari
                'status_pengisian' => 'pending',
            ]);

            // Generate token akses
            $supervisorQuestionnaire->generateToken();

            // Kirim notifikasi ke atasan
            $this->sendSupervisorNotification($supervisorQuestionnaire, $data);

            Log::info('Kuesioner atasan berhasil dibuat dan notifikasi dikirim', [
                'tracer_study_id' => $tracerStudy->id,
                'nama_atasan' => $data['nama_atasan'] ?? 'Atasan',
                'encrypted_link' => $encryptedLink
            ]);

        } catch (\Exception $e) {
            Log::error('Gagal membuat kuesioner atasan: ' . $e->getMessage(), [
                'data' => $data,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Buat supervisor questionnaire dari data yang sudah ada
     */
    public function createSupervisorQuestionnaireFromExisting($tracerStudyId)
    {
        try {
            $tracerStudy = TracerStudy::with('pekerjaan')->findOrFail($tracerStudyId);

            if ($tracerStudy->status_pekerjaan !== 'bekerja_full') {
                throw new \Exception('Tracer study status bukan bekerja_full');
            }

            $pekerjaan = $tracerStudy->pekerjaan;
            if (!$pekerjaan || (empty($pekerjaan->wa_atasan) && empty($pekerjaan->email_atasan))) {
                throw new \Exception('Data atasan tidak lengkap');
            }

            // Generate encrypted link
            $encryptedLink = \App\Models\TracerPengguna::generateEncryptedLink(
                $tracerStudy->id,
                $pekerjaan->nama_atasan ?? 'Atasan',
                $pekerjaan->jabatan_atasan ?? 'Jabatan'
            );

            // Buat record kuesioner atasan
            $supervisorQuestionnaire = \App\Models\TracerPengguna::create([
                'tracer_study_id' => $tracerStudy->id,
                'nama_atasan' => $pekerjaan->nama_atasan ?? 'Atasan',
                'jabatan_atasan' => $pekerjaan->jabatan_atasan ?? 'Jabatan',
                'nama_perusahaan' => $pekerjaan->nama_perusahaan ?? 'Perusahaan',
                'nama_alumni' => $tracerStudy->nama ?? 'Alumni',
                'jabatan_alumni' => $pekerjaan->jabatan ?? 'Staff',
                'tanggal_mulai_kerja' => now()->subMonths(3), // Default 3 bulan yang lalu
                'email_atasan' => $pekerjaan->email_atasan ?? null,
                'wa_atasan' => $pekerjaan->wa_atasan ?? null,
                'encrypted_link' => $encryptedLink,
                'expires_at' => now()->addDays(7), // Link kadaluarsa dalam 7 hari
                'status_pengisian' => 'pending',
            ]);

            // Generate token akses
            $supervisorQuestionnaire->generateToken();

            // Kirim notifikasi ke atasan
            $this->sendSupervisorNotification($supervisorQuestionnaire, [
                'nama' => $tracerStudy->nama,
                'nama_atasan' => $pekerjaan->nama_atasan,
                'jabatan_atasan' => $pekerjaan->jabatan_atasan,
                'nama_perusahaan' => $pekerjaan->nama_perusahaan,
                'email_atasan' => $pekerjaan->email_atasan,
                'wa_atasan' => $pekerjaan->wa_atasan,
            ]);

            Log::info('Kuesioner atasan berhasil dibuat dari data existing', [
                'tracer_study_id' => $tracerStudy->id,
                'nama_atasan' => $pekerjaan->nama_atasan,
                'supervisor_questionnaire_id' => $supervisorQuestionnaire->id
            ]);

            return $supervisorQuestionnaire;

        } catch (\Exception $e) {
            Log::error('Gagal membuat kuesioner atasan dari data existing: ' . $e->getMessage(), [
                'tracer_study_id' => $tracerStudyId,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Kirim notifikasi ke atasan
     */
    private function sendSupervisorNotification($supervisorQuestionnaire, array $data)
    {
        try {
            $notificationService = new \App\Services\NotificationService();

            $supervisorData = [
                'email_atasan' => $data['email_atasan'] ?? null,
                'wa_atasan' => $data['wa_atasan'] ?? null,
                'nama_atasan' => $data['nama_atasan'] ?? 'Atasan',
                'nama_alumni' => $data['nama'] ?? 'Alumni',
                'nama_perusahaan' => $data['nama_perusahaan'] ?? 'Perusahaan',
                'questionnaire_url' => $supervisorQuestionnaire->getQuestionnaireUrl(),
            ];

            $notificationService->sendSupervisorNotification($supervisorData);

            // Mark sebagai sent
            $supervisorQuestionnaire->markAsSent();

        } catch (\Exception $e) {
            Log::error('Gagal mengirim notifikasi ke atasan: ' . $e->getMessage(), [
                'supervisor_questionnaire_id' => $supervisorQuestionnaire->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    private function savePekerjaanDetail($tracerStudyId, array $data)
    {
        TracerPekerjaan::create([
            'tracer_study_id' => $tracerStudyId,
            'mendapatkan_pekerjaan' => $data['mendapatkan_pekerjaan'] ?? null,
            'bulan_kerja' => $data['bulan_kerja_kurang6'] ?? $data['bulan_kerja_lebih6'] ?? null,
            'pendapatan' => $data['pendapatan_kurang6'] ?? $data['pendapatan_lebih6'] ?? null,
            'nama_perusahaan' => $data['nama_perusahaan'] ?? null,
            'jabatan' => $data['jabatan'] ?? null,
            'alamat_pekerjaan' => $data['alamat_pekerjaan'] ?? null,
            'provinsi' => $data['provinsi'] ?? null,
            'kota' => $data['kota'] ?? null,
            'tingkat_usaha_level' => $data['tingkat_usaha_level'] ?? null,
            'hubungan_studi_pekerjaan' => $data['hubungan_studi_pekerjaan'] ?? null,
            'pendidikan_sesuai_pekerjaan' => $data['pendidikan_sesuai_pekerjaan'] ?? null,
            'wa_atasan' => $data['wa_atasan'] ?? null,
            'email_atasan' => $data['email_atasan'] ?? null,
        ]);
    }

    private function saveWirausahaDetail($tracerStudyId, array $data)
    {
        TracerWirausaha::create([
            'tracer_study_id' => $tracerStudyId,
            'nama_usaha' => $data['nama_usaha'] ?? null,
            'posisi_usaha' => $data['posisi_usaha'] ?? null,
            'tingkat_usaha_level' => $data['tingkat_usaha_level'] ?? null,
            'alamat_usaha' => $data['alamat_usaha'] ?? null,
            'pendapatan_usaha' => $data['pendapatan_usaha'] ?? null,
        ]);
    }

    private function savePendidikanDetail($tracerStudyId, array $data)
    {
        TracerPendidikan::create([
            'tracer_study_id' => $tracerStudyId,
            'universitas' => $data['universitas'] ?? null,
            'program_studi' => $data['program_studi'] ?? null,
            'sumber_biaya' => $data['sumber_biaya'] ?? null,
            'tanggal_masuk' => $data['tanggal_masuk'] ?? null,
            'lokasi_universitas' => $data['lokasi_universitas'] ?? null,
            'sumber_biaya_politeknik' => $data['sumber_biaya_politeknik'] ?? null,
            'sumber_biaya_lainnya' => $data['sumber_biaya_lainnya'] ?? null,
        ]);
    }

    // Method khusus untuk yang belum/tidak bekerja (hanya 2 field)
    private function saveUnemployedDetail($tracerStudyId, array $data)
    {
        TracerPencarianKerja::create([
            'tracer_study_id' => $tracerStudyId,
            // Hanya field yang relevan untuk yang belum bekerja
            'aktif_cari_kerja_4minggu' => $data['aktif_cari_kerja_4minggu'] ?? null,
            'alasan_pekerjaan_tidak_sesuai' => $data['alasan_pekerjaan_tidak_sesuai'] ?? null,
        ]);
    }

    private function savePencarianKerjaDetail($tracerStudyId, array $data)
    {
        TracerPencarianKerja::create([
            'tracer_study_id' => $tracerStudyId,
            // Cara mendapatkan pekerjaan
            'waktu_cari_kerja' => $data['waktu_cari_kerja'] ?? null,
            'bulan_sebelum_lulus' => $data['bulan_sebelum_lulus'] ?? null,
            'bulan_setelah_lulus' => $data['bulan_setelah_lulus'] ?? null,

            // Metode pencarian
            'aktif_cari_kerja' => $data['aktif_cari_kerja'] ?? null,
            'jumlah_perusahaan_lamar' => $data['jumlah_perusahaan_lamar'] ?? null,
            'jumlah_perusahaan_respon' => $data['jumlah_perusahaan_respon'] ?? null,
            'jumlah_perusahaan_wawancara' => $data['jumlah_perusahaan_wawancara'] ?? null,

            // Aktivitas saat ini
            'aktif_cari_kerja_4minggu' => $data['aktif_cari_kerja_4minggu'] ?? null,
            'alasan_pekerjaan_tidak_sesuai' => $data['alasan_pekerjaan_tidak_sesuai'] ?? null,
        ]);
    }

    // Method untuk mendapatkan data dengan relasi
    public function getTracerStudyWithDetails($id)
    {
        return TracerStudy::with([
            'alumni', 'user', 'kompetensi', 'evaluasiPendidikan',
            'pekerjaan', 'wirausaha', 'pendidikan', 'pencarianKerja'
        ])->findOrFail($id);
    }

    // Method untuk reporting berdasarkan status
    public function getStatisticsByStatus()
    {
        return TracerStudy::select('status_pekerjaan', DB::raw('count(*) as jumlah'))
            ->groupBy('status_pekerjaan')
            ->get();
    }

    // Method untuk mendapatkan data pekerjaan dengan detail
    public function getPekerjaanData()
    {
        return TracerStudy::with(['pekerjaan', 'kompetensi'])
            ->byStatus('bekerja_full')
            ->get();
    }

    // Method untuk update tracer study
    public function updateTracerStudy($id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $tracerStudy = TracerStudy::findOrFail($id);

            // Log data yang diterima
            \Log::info('TracerStudyService - Data received:', [
                'id' => $id,
                'data_keys' => array_keys($data),
                'status_pekerjaan' => $data['bekerja'] ?? 'not_set',
                'mendapatkan_pekerjaan' => $data['mendapatkan_pekerjaan'] ?? 'not_set',
                'bulan_kerja_kurang6' => $data['bulan_kerja_kurang6'] ?? 'not_set',
                'bulan_kerja_lebih6' => $data['bulan_kerja_lebih6'] ?? 'not_set',
            ]);

            // 1. Update data utama
            $updateData = [
                'nama' => $data['nama'],
                'email' => $data['email'],
                'no_hp' => $data['no_hp'],
                'nim' => $data['nim'],
                'tahun_lulus' => $data['tahun_lulus'],
                'prodi' => $data['prodi'] ?? 'teknik_informatika',
                'alamat' => $data['alamat'],
                'status_pekerjaan' => $data['bekerja'],
                'saran' => $data['saran'] ?? null,
            ];

            \Log::info('TracerStudyService - Updating main data:', $updateData);
            $tracerStudy->update($updateData);

            // 2. Update kompetensi (hanya untuk yang bekerja dan wiraswasta)
            if (in_array($data['bekerja'], ['bekerja_full', 'wirausaha'])) {
                $kompetensiData = [
                    'etika_awal' => $data['etika_awal'] ?? null,
                    'keahlian_awal' => $data['keahlian_awal'] ?? null,
                    'bahasa_inggris_awal' => $data['bahasa_inggris_awal'] ?? null,
                    'teknologi_awal' => $data['teknologi_awal'] ?? null,
                    'kerjasama_awal' => $data['kerjasama_awal'] ?? null,
                    'komunikasi_awal' => $data['komunikasi_awal'] ?? null,
                    'pengembangan_awal' => $data['pengembangan_awal'] ?? null,
                    'etika_sekarang' => $data['etika_sekarang'] ?? null,
                    'keahlian_sekarang' => $data['keahlian_sekarang'] ?? null,
                    'bahasa_inggris_sekarang' => $data['bahasa_inggris_sekarang'] ?? null,
                    'teknologi_sekarang' => $data['teknologi_sekarang'] ?? null,
                    'kerjasama_sekarang' => $data['kerjasama_sekarang'] ?? null,
                    'komunikasi_sekarang' => $data['komunikasi_sekarang'] ?? null,
                    'pengembangan_sekarang' => $data['pengembangan_sekarang'] ?? null,
                ];

                $tracerStudy->kompetensi()->updateOrCreate(
                    ['tracer_study_id' => $tracerStudy->id],
                    $kompetensiData
                );
            } else {
                // Hapus data kompetensi jika bukan status bekerja/wiraswasta
                $tracerStudy->kompetensi()->delete();
            }

            // 3. Update evaluasi pendidikan (hanya untuk yang bekerja dan wiraswasta)
            if (in_array($data['bekerja'], ['bekerja_full', 'wirausaha'])) {
                $evaluasiData = [
                    'perkuliahan' => $data['perkuliahan'] ?? null,
                    'praktikum' => $data['praktikum'] ?? null,
                    'demonstrasi' => $data['demonstrasi'] ?? null,
                    'riset' => $data['riset'] ?? null,
                    'magang' => $data['magang'] ?? null,
                    'kerja_lapangan' => $data['kerja_lapangan'] ?? null,
                    'diskusi' => $data['diskusi'] ?? null,
                ];

                $tracerStudy->evaluasiPendidikan()->updateOrCreate(
                    ['tracer_study_id' => $tracerStudy->id],
                    $evaluasiData
                );
            } else {
                // Hapus data evaluasi pendidikan jika bukan status bekerja/wiraswasta
                $tracerStudy->evaluasiPendidikan()->delete();
            }

            // 4. Hapus detail yang tidak sesuai dengan status baru
            $this->cleanupOldDetails($tracerStudy, $data['bekerja']);

            // 5. Update detail sesuai status baru
            switch ($data['bekerja']) {
                case 'bekerja_full':
                    $this->updatePekerjaanDetail($tracerStudy->id, $data);
                    $this->updatePencarianKerjaDetail($tracerStudy->id, $data);
                    break;

                case 'wirausaha':
                    $this->updateWirausahaDetail($tracerStudy->id, $data);
                    $this->updatePencarianKerjaDetail($tracerStudy->id, $data);
                    break;

                case 'lanjutstudy':
                    $this->updatePendidikanDetail($tracerStudy->id, $data);
                    break;

                case 'belum_bekerja':
                    // Hanya update aktivitas saat ini (2 field saja)
                    $this->updateUnemployedDetail($tracerStudy->id, $data);
                    break;

                case 'tidak':
                    // Update semua detail pencarian kerja (termasuk cara mendapatkan pekerjaan)
                    $this->updatePencarianKerjaDetail($tracerStudy->id, $data);
                    break;
            }

            $this->sendNotificationAfterSave($data);

            return $tracerStudy->fresh();
        });
    }

    // Method untuk membersihkan detail lama yang tidak relevan
    private function cleanupOldDetails($tracerStudy, $newStatus)
    {
        // Hapus detail pekerjaan jika bukan status bekerja_full
        if ($newStatus !== 'bekerja_full') {
            $tracerStudy->pekerjaan()->delete();
        }

        // Hapus detail wirausaha jika bukan status wirausaha
        if ($newStatus !== 'wirausaha') {
            $tracerStudy->wirausaha()->delete();
        }

        // Hapus detail pendidikan jika bukan status lanjutstudy
        if ($newStatus !== 'lanjutstudy') {
            $tracerStudy->pendidikan()->delete();
        }

        // Hapus pencarian kerja jika bukan status yang menggunakan pencarian kerja
        if (!in_array($newStatus, ['bekerja_full', 'belum_bekerja', 'tidak'])) {
            $tracerStudy->pencarianKerja()->delete();
        }

        // Untuk status belum_bekerja, hapus field yang tidak relevan (hanya 2 field)
        if ($newStatus === 'belum_bekerja') {
            $pencarianKerja = $tracerStudy->pencarianKerja;
            if ($pencarianKerja) {
                // Hapus field yang tidak relevan untuk yang belum bekerja
                $pencarianKerja->update([
                    'waktu_cari_kerja' => null,
                    'bulan_sebelum_lulus' => null,
                    'bulan_setelah_lulus' => null,
                    'aktif_cari_kerja' => null,
                    'jumlah_perusahaan_lamar' => null,
                    'jumlah_perusahaan_respon' => null,
                    'jumlah_perusahaan_wawancara' => null,
                ]);
            }
        }

        // Untuk status 'tidak', biarkan semua field pencarian kerja (tidak perlu cleanup)
        // Karena status 'tidak' memang menggunakan semua field pencarian kerja

        // Hapus kompetensi jika bukan status bekerja/wiraswasta
        if (!in_array($newStatus, ['bekerja_full', 'wirausaha'])) {
            $tracerStudy->kompetensi()->delete();
        }

        // Hapus evaluasi pendidikan jika bukan status bekerja/wiraswasta
        if (!in_array($newStatus, ['bekerja_full', 'wirausaha'])) {
            $tracerStudy->evaluasiPendidikan()->delete();
        }
    }

    // Update methods untuk detail
    private function updatePekerjaanDetail($tracerStudyId, array $data)
    {
        $pekerjaanData = [
            'mendapatkan_pekerjaan' => $data['mendapatkan_pekerjaan'] ?? null,
            'bulan_kerja' => $data['bulan_kerja_kurang6'] ?? $data['bulan_kerja_lebih6'] ?? null,
            'pendapatan' => $data['pendapatan_kurang6'] ?? $data['pendapatan_lebih6'] ?? null,
            'nama_perusahaan' => $data['nama_perusahaan'] ?? null,
            'jabatan' => $data['jabatan'] ?? null,
            'alamat_pekerjaan' => $data['alamat_pekerjaan'] ?? null,
            'provinsi' => $data['provinsi'] ?? null,
            'kota' => $data['kota'] ?? null,
            'tingkat_usaha_level' => $data['tingkat_usaha_level'] ?? null,
            'hubungan_studi_pekerjaan' => $data['hubungan_studi_pekerjaan'] ?? null,
            'pendidikan_sesuai_pekerjaan' => $data['pendidikan_sesuai_pekerjaan'] ?? null,
            'wa_atasan' => $data['wa_atasan'] ?? null,
            'email_atasan' => $data['email_atasan'] ?? null,
        ];

        TracerPekerjaan::updateOrCreate(
            ['tracer_study_id' => $tracerStudyId],
            $pekerjaanData
        );

    }

    private function updateWirausahaDetail($tracerStudyId, array $data)
    {
        TracerWirausaha::updateOrCreate(
            ['tracer_study_id' => $tracerStudyId],
            [
                'nama_usaha' => $data['nama_usaha'] ?? null,
                'posisi_usaha' => $data['posisi_usaha'] ?? null,
                'tingkat_usaha_level' => $data['tingkat_usaha_level'] ?? null,
                'alamat_usaha' => $data['alamat_usaha'] ?? null,
                'pendapatan_usaha' => $data['pendapatan_usaha'] ?? null,
                'hubungan_studi_pekerjaan' => $data['hubungan_studi_pekerjaan'] ?? null,
            'pendidikan_sesuai_pekerjaan' => $data['pendidikan_sesuai_pekerjaan'] ?? null,
            ]
        );
    }

    private function updatePendidikanDetail($tracerStudyId, array $data)
    {
        TracerPendidikan::updateOrCreate(
            ['tracer_study_id' => $tracerStudyId],
            [
                'universitas' => $data['universitas'] ?? null,
                'program_studi' => $data['program_studi'] ?? null,
                'sumber_biaya' => $data['sumber_biaya'] ?? null,
                'tanggal_masuk' => $data['tanggal_masuk'] ?? null,
                'lokasi_universitas' => $data['lokasi_universitas'] ?? null,
                'sumber_biaya_politeknik' => $data['sumber_biaya_politeknik'] ?? null,
                'sumber_biaya_lainnya' => $data['sumber_biaya_lainnya'] ?? null,
            ]
        );
    }

    private function updateUnemployedDetail($tracerStudyId, array $data)
    {
        TracerPencarianKerja::updateOrCreate(
            ['tracer_study_id' => $tracerStudyId],
            [
                // Hanya field yang relevan untuk yang belum bekerja
                'aktif_cari_kerja_4minggu' => $data['aktif_cari_kerja_4minggu'] ?? null,
                'alasan_pekerjaan_tidak_sesuai' => $data['alasan_pekerjaan_tidak_sesuai'] ?? null,
            ]
        );
    }

    private function updatePencarianKerjaDetail($tracerStudyId, array $data)
    {
        TracerPencarianKerja::updateOrCreate(
            ['tracer_study_id' => $tracerStudyId],
            [
                // Cara mendapatkan pekerjaan
                'waktu_cari_kerja' => $data['waktu_cari_kerja'] ?? null,
                'bulan_sebelum_lulus' => $data['bulan_sebelum_lulus'] ?? null,
                'bulan_setelah_lulus' => $data['bulan_setelah_lulus'] ?? null,

                // Metode pencarian
                'aktif_cari_kerja' => $data['aktif_cari_kerja'] ?? null,
                'jumlah_perusahaan_lamar' => $data['jumlah_perusahaan_lamar'] ?? null,
                'jumlah_perusahaan_respon' => $data['jumlah_perusahaan_respon'] ?? null,
                'jumlah_perusahaan_wawancara' => $data['jumlah_perusahaan_wawancara'] ?? null,

                // Aktivitas saat ini
                'aktif_cari_kerja_4minggu' => $data['aktif_cari_kerja_4minggu'] ?? null,
                'alasan_pekerjaan_tidak_sesuai' => $data['alasan_pekerjaan_tidak_sesuai'] ?? null,
            ]
        );
    }

    // Method untuk mendapatkan statistik lengkap
    public function getDetailedStatistics()
    {
        return [
            'total_responden' => TracerStudy::count(),
            'by_status' => TracerStudy::select('status_pekerjaan', DB::raw('count(*) as jumlah'))
                ->groupBy('status_pekerjaan')
                ->get(),
            'by_tahun_lulus' => TracerStudy::select('tahun_lulus', DB::raw('count(*) as jumlah'))
                ->groupBy('tahun_lulus')
                ->orderBy('tahun_lulus', 'desc')
                ->get(),
            'rata_rata_gaji' => TracerPekerjaan::avg('pendapatan'),
            'waktu_dapat_kerja' => TracerPekerjaan::select('mendapatkan_pekerjaan', DB::raw('count(*) as jumlah'))
                ->groupBy('mendapatkan_pekerjaan')
                ->get(),
        ];
    }

    // Method untuk export data (untuk admin)
    public function getDataForExport($filters = [])
    {
        $query = TracerStudy::with([
            'alumni', 'user', 'kompetensi', 'evaluasiPendidikan',
            'pekerjaan', 'wirausaha', 'pendidikan', 'pencarianKerja'
        ]);

        if (isset($filters['status_pekerjaan'])) {
            $query->where('status_pekerjaan', $filters['status_pekerjaan']);
        }

        if (isset($filters['tahun_lulus'])) {
            $query->where('tahun_lulus', $filters['tahun_lulus']);
        }

        if (isset($filters['date_from'])) {
            $query->where('tanggal_isi', '>=', $filters['date_from']);
        }

        if (isset($filters['date_to'])) {
            $query->where('tanggal_isi', '<=', $filters['date_to']);
        }

        return $query->get();
    }
}
