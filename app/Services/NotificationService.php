<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class NotificationService
{
    /**
     * Kirim notifikasi berdasarkan kontak yang tersedia
     */
    public function sendNotification($data)
    {
        $waPekerjaan = $data['wa_pekerjaan'] ?? null;
        $emailPekerjaan = $data['email_pekerjaan'] ?? null;
        $nama = $data['nama'] ?? 'Alumni';
        $namaPerusahaan = $data['nama_perusahaan'] ?? 'Perusahaan';

        // Jika ada WhatsApp, kirim notifikasi WA
        if ($waPekerjaan) {
            $this->sendWhatsAppNotification($waPekerjaan, $nama, $namaPerusahaan);
        }

        // Jika ada Email, kirim notifikasi Email
        if ($emailPekerjaan) {
            $this->sendEmailNotification($emailPekerjaan, $nama, $namaPerusahaan);
        }

        // Log aktivitas notifikasi
        Log::info('Notifikasi kuesioner dikirim', [
            'nama' => $nama,
            'wa_pekerjaan' => $waPekerjaan,
            'email_pekerjaan' => $emailPekerjaan,
            'perusahaan' => $namaPerusahaan
        ]);
    }

    /**
     * Kirim notifikasi WhatsApp menggunakan gateway
     */
    private function sendWhatsAppNotification($phoneNumber, $nama, $namaPerusahaan)
    {
        try {
            // Format nomor telepon (hapus +62, ganti dengan 62)
            $formattedPhone = str_replace('+62', '62', $phoneNumber);

            // Pesan yang akan dikirim
            $message = $this->getWhatsAppMessage($nama, $namaPerusahaan);

            // Kirim request ke GOWA API menggunakan Basic Auth
            $response = Http::withBasicAuth(
                env('GOWA_USERNAME'),
                env('GOWA_PASSWORD')
            )->post(env('GOWA_API_URL'), [
                'phone' => $formattedPhone . '@s.whatsapp.net',
                'message' => $message,
                'reply_message_id' => '',
                'is_forwarded' => false,
            ]);

            if ($response->successful()) {
                Log::info('WhatsApp notification sent successfully via GOWA API', [
                    'phone' => $formattedPhone,
                    'response' => $response->json()
                ]);
            } else {
                Log::error('Failed to send WhatsApp notification via GOWA API', [
                    'phone' => $formattedPhone,
                    'response' => $response->body(),
                    'status' => $response->status(),
                ]);
            }

        } catch (\Exception $e) {
            Log::error('Error sending WhatsApp notification via GOWA API: ' . $e->getMessage(), [
                'phone' => $phoneNumber,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Kirim notifikasi Email menggunakan SMTP
     */
    private function sendEmailNotification($email, $nama, $namaPerusahaan)
    {
        try {
            // Kirim email menggunakan Mail facade
            Mail::send('emails.kuesioner-notification', [
                'nama' => $nama,
                'namaPerusahaan' => $namaPerusahaan,
                'tanggal' => now()->format('d F Y H:i'),
                'subject' => 'Konfirmasi Pengisian Kuesioner Tracer Study'
            ], function ($message) use ($email, $nama) {
                $message->to($email, $nama)
                        ->subject('Konfirmasi Pengisian Kuesioner Tracer Study - Universitas Harkat Negeri');
            });

            Log::info('Email notification sent successfully', [
                'email' => $email,
                'nama' => $nama
            ]);

        } catch (\Exception $e) {
            Log::error('Error sending email notification: ' . $e->getMessage(), [
                'email' => $email,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Generate pesan WhatsApp
     */
    private function getWhatsAppMessage($nama, $namaPerusahaan)
    {
        return "Halo {$nama}! 👋\n\n" .
               "Terima kasih telah mengisi kuesioner Tracer Study Universitas Harkat Negeri. 📋\n\n" .
               "Data Anda telah berhasil disimpan dan akan digunakan untuk pengembangan kampus.\n\n" .
               "Detail pengisian:\n" .
               "• Nama: {$nama}\n" .
               "• Perusahaan: {$namaPerusahaan}\n" .
               "• Tanggal: " . now()->format('d F Y H:i') . "\n\n" .
               "Jika ada pertanyaan, silakan hubungi kami.\n\n" .
               "Salam,\n" .
               "Tim Tracer Study\n" .
               "Universitas Harkat Negeri 📚";
    }

    /**
     * Generate pesan Email
     */
    private function getEmailMessage($nama, $namaPerusahaan)
    {
        return [
            'subject' => 'Konfirmasi Pengisian Kuesioner Tracer Study',
            'body' => "Halo {$nama}!\n\n" .
                     "Terima kasih telah mengisi kuesioner Tracer Study Universitas Harkat Negeri.\n\n" .
                     "Data Anda telah berhasil disimpan dan akan digunakan untuk pengembangan kampus.\n\n" .
                     "Detail pengisian:\n" .
                     "• Nama: {$nama}\n" .
                     "• Perusahaan: {$namaPerusahaan}\n" .
                     "• Tanggal: " . now()->format('d F Y H:i') . "\n\n" .
                     "Jika ada pertanyaan, silakan hubungi kami.\n\n" .
                     "Salam,\n" .
                     "Tim Tracer Study\n" .
                     "Universitas Harkat Negeri"
        ];
    }

    /**
     * Kirim notifikasi untuk kuesioner atasan
     */
    public function sendSupervisorNotification($supervisorData)
    {
        $emailAtasan = $supervisorData['email_atasan'] ?? null;
        $waAtasan = $supervisorData['wa_atasan'] ?? null;
        $namaAtasan = $supervisorData['nama_atasan'] ?? 'Atasan';
        $namaAlumni = $supervisorData['nama_alumni'] ?? 'Alumni';
        $namaPerusahaan = $supervisorData['nama_perusahaan'] ?? 'Perusahaan';
        $questionnaireUrl = $supervisorData['questionnaire_url'] ?? '';

        if (!$questionnaireUrl) {
            Log::error('URL kuesioner tidak tersedia untuk notifikasi atasan', $supervisorData);
            return;
        }

        // Kirim notifikasi WhatsApp jika tersedia
        if ($waAtasan) {
            $this->sendSupervisorWhatsAppNotification($waAtasan, $namaAtasan, $namaAlumni, $namaPerusahaan, $questionnaireUrl);
        }

        // Kirim notifikasi Email jika tersedia
        if ($emailAtasan) {
            $this->sendSupervisorEmailNotification($emailAtasan, $namaAtasan, $namaAlumni, $namaPerusahaan, $questionnaireUrl);
        }

        // Log aktivitas notifikasi
        Log::info('Notifikasi kuesioner atasan dikirim', [
            'nama_atasan' => $namaAtasan,
            'nama_alumni' => $namaAlumni,
            'perusahaan' => $namaPerusahaan,
            'wa_atasan' => $waAtasan,
            'email_atasan' => $emailAtasan
        ]);
    }

    /**
     * Kirim notifikasi WhatsApp untuk atasan
     */
    private function sendSupervisorWhatsAppNotification($phoneNumber, $namaAtasan, $namaAlumni, $namaPerusahaan, $questionnaireUrl)
    {
        try {
            // Ambil konfigurasi GOWA API
            $driver = config('whatsapp.default', 'gowa');
            $config = config("whatsapp.drivers.{$driver}");

            if (!$config) {
                throw new \Exception("Driver WhatsApp '{$driver}' tidak ditemukan");
            }

            // Format nomor telepon (hapus +62, ganti dengan 62)
            $formattedPhone = str_replace('+62', '62', $phoneNumber);

            // Pesan khusus untuk atasan
            $message = $this->getSupervisorWhatsAppMessage($namaAtasan, $namaAlumni, $namaPerusahaan, $questionnaireUrl);

            // Format payload sesuai format GOWA standar
            $payload = [
                'phone' => $formattedPhone . '@s.whatsapp.net',
                'message' => $message,
                'reply_message_id' => '',
                'is_forwarded' => false,
            ];

            // Kirim request ke GOWA API menggunakan Basic Auth
            $response = Http::withBasicAuth(
                $config['username'],
                $config['password']
            )->post($config['gateway_url'], $payload);

            if ($response->successful()) {
                Log::info('WhatsApp notification sent successfully to supervisor via GOWA API', [
                    'phone' => $formattedPhone,
                    'driver' => $driver,
                    'nama_atasan' => $namaAtasan,
                    'response' => $response->json()
                ]);
            } else {
                Log::error('Failed to send WhatsApp notification to supervisor via GOWA API', [
                    'phone' => $formattedPhone,
                    'driver' => $driver,
                    'nama_atasan' => $namaAtasan,
                    'response' => $response->body(),
                    'status' => $response->status(),
                    'payload' => $payload
                ]);
            }

        } catch (\Exception $e) {
            Log::error('Error sending WhatsApp notification to supervisor via GOWA API: ' . $e->getMessage(), [
                'phone' => $phoneNumber,
                'driver' => $driver ?? 'unknown',
                'nama_atasan' => $namaAtasan,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Kirim notifikasi Email untuk atasan
     */
    private function sendSupervisorEmailNotification($email, $namaAtasan, $namaAlumni, $namaPerusahaan, $questionnaireUrl)
    {
        try {
            // Kirim email menggunakan Mail facade
            Mail::send('emails.supervisor-questionnaire', [
                'namaAtasan' => $namaAtasan,
                'namaAlumni' => $namaAlumni,
                'namaPerusahaan' => $namaPerusahaan,
                'questionnaireUrl' => $questionnaireUrl,
                'tanggal' => now()->format('d F Y H:i'),
                'expiresAt' => now()->addDays(7)->format('d F Y H:i')
            ], function ($message) use ($email, $namaAtasan) {
                $message->to($email, $namaAtasan)
                        ->subject('Kuesioner Tracer Study - Evaluasi Kinerja Alumni');
            });

            Log::info('Email notification sent successfully to supervisor', [
                'email' => $email,
                'nama_atasan' => $namaAtasan
            ]);

        } catch (\Exception $e) {
            Log::error('Error sending email notification to supervisor: ' . $e->getMessage(), [
                'email' => $email,
                'nama_atasan' => $namaAtasan,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Generate pesan WhatsApp untuk atasan
     */
    private function getSupervisorWhatsAppMessage($namaAtasan, $namaAlumni, $namaPerusahaan, $questionnaireUrl)
    {
        return "Halo {$namaAtasan}! 👋\n\n" .
               "Anda diminta untuk mengisi kuesioner Tracer Study untuk mengevaluasi kinerja alumni yang bekerja di perusahaan Anda.\n\n" .
               "Detail:\n" .
               "• Nama Alumni: {$namaAlumni}\n" .
               "• Perusahaan: {$namaPerusahaan}\n" .
               "• Tanggal Request: " . now()->format('d F Y H:i') . "\n\n" .
               "Silakan klik link berikut untuk mengisi kuesioner evaluasi:\n" .
               "🔗 {$questionnaireUrl}\n\n" .
               "Link akan kadaluarsa dalam 7 hari.\n" .
               "Kuesioner ini untuk evaluasi kinerja dan kompetensi alumni.\n\n" .
               "Terima kasih atas partisipasi Anda dalam pengembangan pendidikan.\n\n" .
               "Salam,\n" .
               "Tim Tracer Study\n" .
               "Universitas Harkat Negeri 📚";
    }
}
