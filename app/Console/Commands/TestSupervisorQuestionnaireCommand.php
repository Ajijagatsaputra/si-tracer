<?php

namespace App\Console\Commands;

use App\Models\SupervisorQuestionnaire;
use App\Models\TracerStudy;
use App\Services\TracerStudyService;
use Illuminate\Console\Command;

class TestSupervisorQuestionnaireCommand extends Command
{
    protected $signature = 'supervisor:test-create {--nama=Test Alumni} {--email=test@example.com} {--nim=2021001} {--nama-atasan=Test Manager} {--jabatan-atasan=Manager} {--email-atasan=manager@example.com} {--wa-atasan=+6281234567890} {--nama-perusahaan=Test Corp} {--jabatan=Staff}';
    protected $description = 'Test supervisor questionnaire creation process';

    public function handle()
    {
        $this->info("🧪 Testing Supervisor Questionnaire Creation Process...");

        // Test data
        $testData = [
            'nama' => $this->option('nama'),
            'email' => $this->option('email'),
            'no_hp' => '+6281234567890',
            'nim' => $this->option('nim'),
            'tahun_lulus' => '2024',
            'prodi' => 'teknik_informatika',
            'alamat' => 'Test Address',
            'bekerja' => 'bekerja_full', // This triggers supervisor questionnaire creation
            'nama_atasan' => $this->option('nama-atasan'),
            'jabatan_atasan' => $this->option('jabatan-atasan'),
            'email_atasan' => $this->option('email-atasan'),
            'wa_atasan' => $this->option('wa-atasan'),
            'nama_perusahaan' => $this->option('nama-perusahaan'),
            'jabatan' => $this->option('jabatan'),
            'tanggal_mulai_kerja' => now()->subMonths(3),
            'mendapatkan_pekerjaan' => 'melamar_ke_perusahaan',
            'bulan_kerja_kurang6' => '3',
            'pendapatan_kurang6' => '3000000',
            'alamat_pekerjaan' => 'Test Work Address',
            'provinsi' => '32',
            'kota' => '3201',
            'tingkat_usaha_level' => 'nasional',
            'hubungan_studi_pekerjaan' => 'sangat_sesuai',
            'pendidikan_sesuai_pekerjaan' => 'sangat_sesuai',
            'etika_awal' => '4',
            'keahlian_awal' => '4',
            'bahasa_inggris_awal' => '4',
            'teknologi_awal' => '4',
            'kerjasama_awal' => '4',
            'komunikasi_awal' => '4',
            'pengembangan_awal' => '4',
            'etika_sekarang' => '5',
            'keahlian_sekarang' => '5',
            'bahasa_inggris_sekarang' => '5',
            'teknologi_sekarang' => '5',
            'kerjasama_sekarang' => '5',
            'komunikasi_sekarang' => '5',
            'pengembangan_sekarang' => '5',
            'perkuliahan' => 'sangat_bermanfaat',
            'praktikum' => 'sangat_bermanfaat',
            'demonstrasi' => 'sangat_bermanfaat',
            'riset' => 'bermanfaat',
            'magang' => 'sangat_bermanfaat',
            'kerja_lapangan' => 'bermanfaat',
            'diskusi' => 'sangat_bermanfaat',
            'saran' => 'Test suggestion for improvement',
        ];

        $this->info("📝 Test Data:");
        $this->info("• Nama: {$testData['nama']}");
        $this->info("• Email: {$testData['email']}");
        $this->info("• NIM: {$testData['nim']}");
        $this->info("• Nama Atasan: {$testData['nama_atasan']}");
        $this->info("• Jabatan Atasan: {$testData['jabatan_atasan']}");
        $this->info("• Email Atasan: {$testData['email_atasan']}");
        $this->info("• WA Atasan: {$testData['wa_atasan']}");
        $this->info("• Nama Perusahaan: {$testData['nama_perusahaan']}");
        $this->info("• Jabatan: {$testData['jabatan']}");

        try {
            $this->info("\n🔄 Creating Tracer Study and Supervisor Questionnaire...");

            $tracerStudyService = new TracerStudyService();
            $result = $tracerStudyService->saveTracerStudyForTesting($testData);

            if ($result) {
                $this->info("✅ Tracer Study created successfully!");

                // Check if supervisor questionnaire was created
                $supervisorQuestionnaire = SupervisorQuestionnaire::where('nama_alumni', $testData['nama'])
                    ->where('nama_atasan', $testData['nama_atasan'])
                    ->latest()
                    ->first();

                if ($supervisorQuestionnaire) {
                    $this->info("✅ Supervisor Questionnaire created successfully!");
                    $this->info("• ID: {$supervisorQuestionnaire->id}");
                    $this->info("• Token: {$supervisorQuestionnaire->token_akses}");
                    $this->info("• Status: {$supervisorQuestionnaire->status_pengisian}");
                    $this->info("• Expires: {$supervisorQuestionnaire->expired_at}");
                    $this->info("• Questionnaire URL: {$supervisorQuestionnaire->getQuestionnaireUrl()}");

                    // Test the URL
                    $this->info("\n🔗 Testing Questionnaire URL...");
                    $this->info("URL: {$supervisorQuestionnaire->getQuestionnaireUrl()}");

                } else {
                    $this->error("❌ Supervisor Questionnaire was not created!");
                }

            } else {
                $this->error("❌ Failed to create Tracer Study!");
            }

        } catch (\Exception $e) {
            $this->error("❌ Error: " . $e->getMessage());
            $this->error("Stack trace: " . $e->getTraceAsString());
        }

        $this->info("\n📊 Check logs for more details: tail -f storage/logs/laravel.log");
    }
}
