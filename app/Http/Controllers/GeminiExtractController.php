<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use App\Models\MataKuliah;

class GeminiExtractController extends Controller
{
    public function extractFromPdf(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'pdf' => 'required|file|mimes:pdf|max:15360'
            ]);

            $userId = auth()->id() ?? $request->ip();
            $cooldownSeconds = 600; // 10 menit
            $cooldownKey = 'ocr_scan_cooldown_user_' . $userId;
            $lastHit = Cache::get($cooldownKey);
            if ($lastHit && (time() - (int)$lastHit) < $cooldownSeconds) {
                $retryAfter = $cooldownSeconds - (time() - (int)$lastHit);
                return response()->json([
                    'success' => false,
                    'code' => 429,
                    'error' => 'Terlalu sering melakukan scan.',
                    'retry_after' => $retryAfter
                ], 429);
            }

            // Harian
            $date = now()->format('Y-m-d');
            $dailyKey = 'ocr_scan_daily_' . $userId . '_' . $date;
            $dailyCount = (int) Cache::get($dailyKey, 0);
            if ($dailyCount >= 2) {
                return response()->json([
                    'success' => false,
                    'error' => 'Batas scan PDF harian tercapai (maks 2 kali per hari). Coba lagi besok.'
                ], 429);
            }
            // Set cooldown
            Cache::put($cooldownKey, time(), $cooldownSeconds);
            // TTL sampai akhir hari
            $ttl = now()->endOfDay()->diffInSeconds(now());
            Cache::put($dailyKey, $dailyCount + 1, $ttl);

            // Simpan sementara agar mudah dibaca sebagai base64
            $file = $request->file('pdf');
            $tempDir = storage_path('app/temp');
            if (!is_dir($tempDir)) @mkdir($tempDir, 0775, true);
            if (!is_writable($tempDir)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Folder temp tidak writable',
                ], 500);
            }
            $filename = 'gemini_extract_' . uniqid() . '.pdf';
            $fullPath = rtrim($tempDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $filename;
            $file->move($tempDir, $filename);
            if (!file_exists($fullPath)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menyimpan file upload.'
                ], 500);
            }

            // Encode PDF ke base64 dan panggil Gemini
            $pdfData = base64_encode(file_get_contents($fullPath));
            @unlink($fullPath);

            $mkList = MataKuliah::query()->pluck('mataKuliah')->toArray();
            $prompt = $this->buildInlineExtractionPrompt($mkList);
            $result = $this->callGeminiWithInline($pdfData, 'application/pdf', $prompt);
            if (!$result['success']) {
                return response()->json($result, 502);
            }

            $text = $result['text'];
            $json = $this->extractJsonArray($text);
            if (is_null($json)) {
                return response()->json([
                    'success' => true,
                    'message' => 'Ekstraksi via Gemini selesai, tetapi JSON tidak ditemukan. Mengembalikan teks mentah.',
                    'text' => $text,
                    'data' => []
                ]);
            }

            
            $data = [];
            foreach ($json as $row) {
                $mk = trim((string)($row['mataKuliah'] ?? $row['nama'] ?? $row['mata_kuliah'] ?? ''));
                $sks = (int) round((float) str_replace(',', '.', (string)($row['sks'] ?? 0)));
                $grade = strtoupper(trim((string)($row['grade'] ?? $row['nilai'] ?? $row['hm'] ?? '')));
                if ($mk !== '' && $sks > 0 && preg_match('/^[A-E][\+\-]?$/', $grade)) {
                    $data[] = [ 'mataKuliah' => $mk, 'sks' => $sks, 'grade' => $grade ];
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Ekstraksi via Gemini (inline PDF) berhasil',
                'data' => $data
            ]);
        } catch (\Throwable $e) {
            Log::error('GeminiExtract Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    private function buildInlineExtractionPrompt(array $knownSubjects): string
    {
        $subjects = implode("\n- ", array_map(fn($s)=>trim($s), $knownSubjects));
        return "Ekstrak nilai mata kuliah dari dokumen PDF ini menjadi JSON array.\n"
             . "Tiap item field: mataKuliah (string), sks (integer), grade (A/A-/B+/B/B-/C+/C/C-/D/E).\n"
             . "Cocokkan nama di PDF ke daftar berikut bila mirip agar konsisten penamaan.\n"
             . "Daftar mata kuliah yang dikenal:\n- {$subjects}\n\n"
             . "KELUARKAN HASIL HANYA FORMAT JSON ARRAY TANPA TEKS TAMBAHAN.";
    }

    private function callGeminiWithInline(string $base64Data, string $mime, string $prompt): array
    {
        $api_key = config('services.gemini.key');
        $api_url = config('services.gemini.url');
        if (!$api_key || !$api_url) {
            return [ 'success' => false, 'error' => 'Konfigurasi GEMINI API belum lengkap' ];
        }
        $url = $api_url . '?key=' . $api_key;
        $payload = [
            'contents' => [[
                'parts' => [
                    [ 'inline_data' => [ 'mime_type' => $mime, 'data' => $base64Data ] ],
                    [ 'text' => $prompt ]
                ]
            ]]
        ];
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($http_code !== 200) {
            Log::info('Gemini API Failure Output: ' . $response);
            return [ 'success' => false, 'error' => 'Error API: HTTP ' . $http_code . ' - ' . $response ];
        }
        $result = json_decode($response, true);
        $text = $result['candidates'][0]['content']['parts'][0]['text'] ?? null;
        if ($text) return [ 'success' => true, 'text' => $text ];
        return [ 'success' => false, 'error' => 'Tidak ada teks dari Gemini' ];
    }

    private function extractJsonArray(string $aiText): ?array
    {
        $decoded = json_decode($aiText, true);
        if (is_array($decoded)) return $decoded;
        if (preg_match('/\[.*\]/s', $aiText, $m)) {
            $decoded = json_decode($m[0], true);
            if (is_array($decoded)) return $decoded;
        }
        return null;
    }
}
