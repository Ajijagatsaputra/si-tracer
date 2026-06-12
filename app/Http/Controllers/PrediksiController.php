<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\MataKuliah;
use Illuminate\Support\Facades\Cache;

class PrediksiController extends Controller
{

    public function showForm()
    {
        $MataKuliah = MataKuliah::all();

        if ($MataKuliah->isEmpty()) {
            return view('prediksi', compact('MataKuliah'))->with('warning', 'Data mata kuliah belum tersedia. Silakan hubungi administrator.');
        }

        return view('prediksi', compact('MataKuliah'));
    }

    /**
     * Constants & job title list
     */
    protected static $geminiKey;
    protected static $geminiUrl;

    const JOB_TITLES = [
        'AI ML Specialist',
        'API Specialist',
        'Application Support Engineer',
        'Business Analyst',
        'Customer Service Executive',
        'Cyber Security Specialist',
        'Database Administrator',
        'Graphics Designer',
        'Hardware Engineer',
        'Helpdesk Engineer',
        'Information Security Specialist',
        'Networking Engineer',
        'Project Manager',
        'Software Developer',
        'Software Tester',
        'Technical Writer'
    ];

    /**
     * Generate prompt untuk Gemini AI
     */
    protected static function gradeToNumber($grade)
    {
        $grade = strtoupper($grade);
        switch ($grade) {
            case 'A':
                return 4.0;
            case 'A-':
                return 3.75;
            case 'B+':
                return 3.5;
            case 'B':
                return 3.0;
            case 'B-':
                return 2.75;
            case 'C+':
                return 2.5;
            case 'C':
                return 2.0;
            case 'C-':
                return 1.75;
            case 'D':
                return 1.0;
            case 'E':
                return 0.0;
            default:
                return 0.0;
        }
    }

    protected static function generatePrompt($mata_kuliah, $sks_data, $grade_data, $deskripsi = '', $mode = 'flash')
    {
        $bidang = [
            'Data Science & AI' => [],
            'Software Development' => [],
            'Database & Data Engineering' => [],
            'Network & Security' => [],
            'System & Infrastructure' => [],
            'UI/UX & Design' => [],
            'Project Management' => []
        ];

        // Mapping MK ke bidang
        foreach ($mata_kuliah as $index => $matkul) {
            $sks = (int) ($sks_data[$index] ?? 0);
            $grade = strtoupper(trim($grade_data[$index] ?? ''));
            $bobot = self::gradeToNumber($grade);

            if (in_array($matkul, ['Machine Learning', 'Data Mining', 'Statistik', 'Matematika Diskrit', 'Big Data'])) {
                $bidang['Data Science & AI'][] = compact('matkul', 'sks', 'grade', 'bobot');
            } elseif (in_array($matkul, ['Pemrograman Komputer 1', 'Pemrograman Komputer 2', 'Pemrograman Web 1', 'Pemrograman Web 2', 'Framework Programming', 'Web Service'])) {
                $bidang['Software Development'][] = compact('matkul', 'sks', 'grade', 'bobot');
            } elseif (in_array($matkul, ['Basis Data 1', 'Basis Data 2', 'Data Warehouse'])) {
                $bidang['Database & Data Engineering'][] = compact('matkul', 'sks', 'grade', 'bobot');
            } elseif (in_array($matkul, ['Jaringan Komputer 1', 'Jaringan Komputer 2', 'Keamanan Data & Jaringan'])) {
                $bidang['Network & Security'][] = compact('matkul', 'sks', 'grade', 'bobot');
            } elseif (in_array($matkul, ['Sistem Operasi'])) {
                $bidang['System & Infrastructure'][] = compact('matkul', 'sks', 'grade', 'bobot');
            } elseif (in_array($matkul, ['Desain Grafis', 'Interaksi Manusia & Komputer'])) {
                $bidang['UI/UX & Design'][] = compact('matkul', 'sks', 'grade', 'bobot');
            } elseif (in_array($matkul, ['Manajemen Proyek TI', 'Analisis & Desain PL', 'Pengantar RPL'])) {
                $bidang['Project Management'][] = compact('matkul', 'sks', 'grade', 'bobot');
            }
        }

        // Hitung rata-rata per bidang
        $rata_bidang = [];
        foreach ($bidang as $nama => $matkuls) {
            if (!empty($matkuls)) {
                $total_sks = array_sum(array_column($matkuls, 'sks'));
                $total_bobot = 0;
                foreach ($matkuls as $m)
                    $total_bobot += $m['sks'] * $m['bobot'];
                $rata_bidang[$nama] = $total_sks > 0 ? round($total_bobot / $total_sks, 2) : 0;
            }
        }

        if ($mode === 'flash') {
            $prompt = "Kamu berperan sebagai career coach Gen-Z yang seru dan to the point. "
                . "Tugasmu: bantu mahasiswa Teknik Informatika nemuin karier yang cocok berdasarkan nilai dan minatnya. "
                . "Gunakan bahasa santai tapi sopan, dengan gaya obrolan ringan.\n\n";

            $prompt .= "=== PROFIL AKADEMIK SAYA ===\n";
            foreach ($rata_bidang as $nama => $nilai) {
                $prompt .= "- {$nama}: {$nilai}\n";
            }

            if (!empty($deskripsi)) {
                $prompt .= "\n=== DESKRIPSI DIRI ===\n" . trim($deskripsi) . "\n";
            }

            $prompt .= "\n=== PILIHAN JOB TITLE ===\n";
            foreach (self::JOB_TITLES as $i => $title) {
                $prompt .= ($i + 1) . ". {$title}\n";
            }

            $prompt .= "\n Berikan 1–3 rekomendasi karier terbaik dari daftar di atas (JANGAN buat job baru). "
                . "Tulis hasilnya dengan gaya ringan dan fun seperti ini:\n\n";

            $prompt .= " HASIL CEPAT\n";
            $prompt .= "[Nama Job Title]\n   Kenapa cocok: [penjelasan singkat, simpel, dan relate]\n";
            $prompt .= "   Skill unggulan: [3–5 skill relevan]\n\n";
            $prompt .= "[Nama Job Title]\n   Kenapa cocok: ...\n   Skill unggulan: ...\n\n";
            $prompt .= "Kesimpulan singkat: [1 kalimat motivasi atau arah karier secara umum]\n";
            $prompt .= "Jangan lebih dari 6 kalimat total. Gaya santai, mudah dibaca, dan inspiratif ✨";

        } elseif ($mode === 'pro') {
            $prompt = "Kamu adalah career coach profesional tapi tetap berjiwa muda, yang bantu alumni Informatika memahami kekuatannya secara mendalam. "
                . "Gunakan gaya bahasa santai namun informatif. Bahas secara detail kekuatan akademik, skill dominan, peluang karier, dan tips pengembangan diri.\n\n";

            $prompt .= "=== PROFIL AKADEMIK SAYA ===\n";
            foreach ($rata_bidang as $nama => $nilai) {
                $prompt .= "- {$nama}: {$nilai}\n";
            }

            $prompt .= "\n=== DESKRIPSI KEPRIBADIAN & MINAT ===\n";
            $prompt .= (!empty($deskripsi) ? trim($deskripsi) : "(belum ada deskripsi)") . "\n";

            $prompt .= "\n=== DAFTAR JOB TITLE ===\n";
            foreach (self::JOB_TITLES as $i => $title) {
                $prompt .= ($i + 1) . ". {$title}\n";
            }

            $prompt .= "\nTUGASMU: analisis secara mendalam profil saya di atas, lalu berikan 2–4 rekomendasi karier paling cocok dari daftar yang tersedia. "
                . "Bahas setiap rekomendasi dengan detail, jelaskan skill utama, potensi masa depan, serta saran pengembangan pribadi.\n\n";

            $prompt .= "=== FORMAT OUTPUT (MODE PRO) ===\n";
            $prompt .= "REKOMENDASI KARIER\n";
            $prompt .= "1. [Nama Job Title]\n";
            $prompt .= "   Alasan cocok: [jelaskan koneksi nilai dan minat secara mendalam]\n";
            $prompt .= "   Skill dominan: [4–6 skill utama]\n";
            $prompt .= "   Tips pengembangan: [saran atau insight pribadi]\n\n";

            $prompt .= "2. [Nama Job Title]\n";
            $prompt .= "   Alasan cocok: ...\n";
            $prompt .= "   Skill dominan: ...\n";
            $prompt .= "   Tips pengembangan: ...\n\n";

            $prompt .= "Kesimpulan Akhir: rangkum arah karier utama dan kasih semangat seperti mentor muda yang suportif. "
                . "Gunakan 8–12 kalimat, boleh pakai emoji secukupnya biar tetap hidup dan friendly, tapi jaga agar tetap profesional dan enak dibaca.\n";
        }

        return $prompt;
    }


    /**
     * Validasi job title
     */
    protected static function isValidJobTitle($job_title)
    {
        foreach (self::JOB_TITLES as $valid_title) {
            if (strcasecmp(trim($job_title), $valid_title) === 0) {
                return true;
            }
        }
        return false;
    }

    /**
     * Extract job titles dari respons AI
     */
    protected static function extractJobTitles($ai_text)
    {
        $lines = explode("\n", $ai_text);
        $recommendations = [];
        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line))
                continue;
            // Deteksi job title format "1. Nama Job Title"
            if (preg_match('/^\d+\.\s*(.+)$/', $line, $matches)) {
                $title = trim($matches[1]);
                if (self::isValidJobTitle($title)) {
                    $recommendations[] = $title;
                }
            }
        }
        return array_unique($recommendations);
    }

    /**
     * Kirim prompt ke Gemini API
     */
    protected static function getGeminiRecommendation($prompt, $attempt = 1)
    {
        $api_key = config('services.gemini.key');
        $api_url = config('services.gemini.url');
        if (!$api_key) {
            return [
                'success' => false,
                'error' => 'API Key belum dikonfigurasi'
            ];
        }
        if (!$api_url) {
            return [
                'success' => false,
                'error' => 'API URL belum dikonfigurasi'
            ];
        }
        $url = $api_url . '?key=' . $api_key;
        $data = [
            'contents' => [
                [
                    'parts' => [['text' => $prompt]]
                ]
            ]
        ];
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_code === 503 && $attempt < 3) {
            sleep(3);
            return self::getGeminiRecommendation($prompt, $attempt + 1);
        }

        $result = json_decode($response, true);
        if ($http_code === 200 && isset($result['candidates'][0]['content']['parts'][0]['text'])) {
            try {
                $userId = auth()->id();
                $alumni = \App\Models\Alumni::where('id_users', $userId)->first();
                if ($alumni) {
                    \App\Models\HistoryPrediksi::create([
                        'idAlumni' => $alumni->id,
                        'hasil' => $result['candidates'][0]['content']['parts'][0]['text'],
                    ]);
                }
            } catch (\Throwable $e) {
            }

            return [
                'success' => true,
                'text' => $result['candidates'][0]['content']['parts'][0]['text']
            ];
        }

        // Fallback to OpenRouter if direct Gemini call fails
        $openrouter_key = config('services.openrouter.key');
        if ($openrouter_key) {
            $openrouter_result = self::getOpenRouterFallback($prompt);
            if (!empty($openrouter_result['success'])) {
                return $openrouter_result;
            }
        }

        return [
            'success' => false,
            'error' => 'Error API: HTTP ' . $http_code . ' - ' . ($response ?: 'Empty response')
        ];
    }

    /**
     * Fallback to OpenRouter using free reliable models when Gemini API fails
     */
    protected static function getOpenRouterFallback($prompt)
    {
        $api_key = config('services.openrouter.key');
        $api_url = config('services.openrouter.url', 'https://openrouter.ai/api/v1/chat/completions');

        $models = [
            'google/gemini-2.5-flash:free',
            'google/gemini-2.0-flash-exp:free',
            config('services.openrouter.model', 'google/gemini-2.0-flash-exp:free')
        ];
        $models = array_unique($models);

        foreach ($models as $model) {
            $payload = [
                'model' => $model,
                'messages' => [
                    ['role' => 'user', 'content' => $prompt]
                ],
                'max_tokens' => 1000
            ];

            $ch = curl_init($api_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $api_key,
            ]);
            $response = curl_exec($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($http_code === 200) {
                $result = json_decode($response, true);
                $text = $result['choices'][0]['message']['content'] ?? null;
                if ($text) {
                    try {
                        $userId = auth()->id();
                        $alumni = \App\Models\Alumni::where('id_users', $userId)->first();
                        if ($alumni) {
                            \App\Models\HistoryPrediksi::create([
                                'idAlumni' => $alumni->id,
                                'hasil' => $text,
                            ]);
                        }
                    } catch (\Throwable $e) {
                    }
                    return ['success' => true, 'text' => $text];
                }
            }
        }

        return ['success' => false, 'error' => 'Fallback OpenRouter gagal'];
    }

    protected static function sanitizeAiText(string $text): string
    {
        // Hilangkan markdown emphasis: **bold**, *italic*, _italic_
        $text = preg_replace('/\*\*(.*?)\*\*/s', '$1', $text);
        $text = preg_replace('/\*(.*?)\*/s', '$1', $text);
        $text = preg_replace('/_(.*?)_/s', '$1', $text);
        // Hilangkan karakter bintang yang tersisa
        $text = str_replace('*', '', $text);
        // Rapikan spasi ganda
        $text = preg_replace('/[ \t]{2,}/', ' ', $text);
        return trim($text);
    }

    public function ajaxPredictGemini(Request $request)
    {
        $deskripsi = $request->input('deskripsi', '');
        $mode = $request->input('mode', 'flash');
        $userId = auth()->id();

        // Cooldown per user per mode (5 detik di local)
        $cooldownSeconds = config('app.env') === 'local' ? 5 : ($mode === 'pro' ? 600 : 60);
        $cooldownKey = 'ai_predict_cooldown_user_' . $userId . '_' . $mode;
        $lastHit = Cache::get($cooldownKey);
        if ($lastHit && (time() - (int) $lastHit) < $cooldownSeconds) {
            $retryAfter = $cooldownSeconds - (time() - (int) $lastHit);
            return response()->json([
                'success' => false,
                'error' => 'Eitss, kamu terlalu cepat nih! Sabar yaa, Coba lagi dalam ' . $retryAfter . ' detik yaa 🚦',
                'retry_after' => $retryAfter
            ], 429);
        }
        Cache::put($cooldownKey, time(), $cooldownSeconds);

        $alumni = \App\Models\Alumni::where('id_users', $userId)->first();
        if (!$alumni) {
            return response()->json([
                'success' => false,
                'error' => 'Data alumni tidak ditemukan. Silakan lengkapi/buat profil Anda.'
            ], 404);
        }
        $data = \App\Models\NilaiAkademik::where('idAlumni', $alumni->id)->get();
        if ($data->isEmpty()) {
            return response()->json([
                'success' => false,
                'error' => 'Belum ada nilai akademik yang diinputkan. Silakan isi nilai akademik dulu.'
            ], 422);
        }
        $mata_kuliah = $data->pluck('mataKuliah')->all();
        $sks_data = $data->pluck('sks')->all();
        $grade_data = $data->pluck('grade')->map(function ($v) {
            return $v ?: 'N/A';
        })->all();
        $prompt = self::generatePrompt($mata_kuliah, $sks_data, $grade_data, $deskripsi, $mode);
        $result = self::getGeminiRecommendation($prompt);
        if (!empty($result['success']) && !empty($result['text'])) {
            $result['text'] = self::sanitizeAiText($result['text']);
        }
        return response()->json($result);
    }




}
