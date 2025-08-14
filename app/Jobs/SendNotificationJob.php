<?php

namespace App\Jobs;

use App\Services\NotificationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    public $tries = 3; // Maksimal 3 kali retry
    public $timeout = 60; // Timeout 60 detik

    /**
     * Create a new job instance.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            Log::info('Memulai pengiriman notifikasi', [
                'nama' => $this->data['nama'] ?? 'Unknown',
                'wa_pekerjaan' => $this->data['wa_pekerjaan'] ?? null,
                'email_pekerjaan' => $this->data['email_pekerjaan'] ?? null
            ]);

            $notificationService = new NotificationService();
            $notificationService->sendNotification($this->data);

            Log::info('Notifikasi berhasil dikirim', [
                'nama' => $this->data['nama'] ?? 'Unknown'
            ]);

        } catch (\Exception $e) {
            Log::error('Gagal mengirim notifikasi dalam job: ' . $e->getMessage(), [
                'data' => $this->data,
                'error' => $e->getMessage(),
                'attempt' => $this->attempts()
            ]);

            // Jika masih ada retry tersisa, throw exception untuk retry
            if ($this->attempts() < $this->tries) {
                throw $e;
            }

            // Jika sudah habis retry, log final failure
            Log::error('Notifikasi gagal dikirim setelah ' . $this->tries . ' percobaan', [
                'data' => $this->data,
                'final_error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('Job notifikasi gagal total', [
            'data' => $this->data,
            'error' => $exception->getMessage(),
            'attempts' => $this->attempts()
        ]);
    }

    /**
     * Calculate the number of seconds to wait before retrying the job.
     */
    public function backoff(): array
    {
        return [5, 15, 30]; // Delay 5, 15, 30 detik untuk setiap retry
    }
}
