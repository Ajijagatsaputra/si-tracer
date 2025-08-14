<?php

namespace App\Console\Commands;

use App\Services\NotificationService;
use Illuminate\Console\Command;

class TestGowaCommand extends Command
{
    protected $signature = 'gowa:test {phone} {--nama=Test User} {--alumni=Alumni Test} {--perusahaan=Perusahaan Test}';
    protected $description = 'Test GOWA API WhatsApp notification for supervisor questionnaire';

    public function handle()
    {
        $phone = $this->argument('phone');
        $nama = $this->option('nama');
        $alumni = $this->option('alumni');
        $perusahaan = $this->option('perusahaan');

        $this->info("🧪 Testing GOWA API WhatsApp notification for supervisor...");
        $this->info("📱 Phone: {$phone}");
        $this->info("👤 Nama Atasan: {$nama}");
        $this->info("🎓 Nama Alumni: {$alumni}");
        $this->info("🏢 Perusahaan: {$perusahaan}");

        // Test data untuk supervisor notification
        $testData = [
            'email_atasan' => null,
            'wa_atasan' => $phone,
            'nama_atasan' => $nama,
            'nama_alumni' => $alumni,
            'nama_perusahaan' => $perusahaan,
            'questionnaire_url' => 'https://example.com/supervisor/questionnaire/test-token'
        ];

        try {
            $notificationService = new NotificationService();
            $notificationService->sendSupervisorNotification($testData);

            $this->info('✅ Test berhasil! Cek log untuk detail.');
            $this->info('📊 Log: tail -f storage/logs/laravel.log');

        } catch (\Exception $e) {
            $this->error('❌ Test gagal: ' . $e->getMessage());
        }
    }
}
