<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class AdminCurriculumAnalysisController extends Controller
{
    public function index()
    {
        // 1. Ambil data agregat kompetensi alumni (evaluasi diri)
        $competencyStats = \App\Models\TracerKompetensi::selectRaw('
            AVG(etika_awal) as etika_awal,
            AVG(keahlian_awal) as keahlian_awal,
            AVG(bahasa_inggris_awal) as bahasa_inggris_awal,
            AVG(teknologi_awal) as teknologi_awal,
            AVG(kerjasama_awal) as kerjasama_awal,
            AVG(komunikasi_awal) as komunikasi_awal,
            AVG(pengembangan_awal) as pengembangan_awal,
            
            AVG(etika_sekarang) as etika_sekarang,
            AVG(keahlian_sekarang) as keahlian_sekarang,
            AVG(bahasa_inggris_sekarang) as bahasa_inggris_sekarang,
            AVG(teknologi_sekarang) as teknologi_sekarang,
            AVG(kerjasama_sekarang) as kerjasama_sekarang,
            AVG(komunikasi_sekarang) as komunikasi_sekarang,
            AVG(pengembangan_sekarang) as pengembangan_sekarang
        ')->first();

        // 2. Ambil data agregat kepuasan atasan (Tracer Pengguna)
        $supervisorStats = \App\Models\TracerPengguna::where('status_pengisian', 'completed')
            ->selectRaw('
                AVG(integritas) as integritas,
                AVG(keahlian) as keahlian,
                AVG(kemampuan) as kemampuan,
                AVG(penguasaan) as penguasaan,
                AVG(komunikasi) as komunikasi,
                AVG(kerja_tim) as kerja_tim,
                AVG(pengembangan) as pengembangan
            ')->first();

        // 3. Ambil saran perbaikan dari atasan
        $suggestions = \App\Models\TracerPengguna::where('status_pengisian', 'completed')
            ->whereNotNull('saran_perbaikan')
            ->where('saran_perbaikan', '!=', '')
            ->latest()
            ->limit(20)
            ->pluck('saran_perbaikan')
            ->toArray();

        // Hitung total partisipasi
        $totalAlumniTracer = \App\Models\TracerKompetensi::count();
        $totalSupervisorTracer = \App\Models\TracerPengguna::where('status_pengisian', 'completed')->count();

        // Ambil hasil analisis dari cache jika ada
        $analysisResult = Cache::get('curriculum_gap_analysis');

        return view('admin.tracer.curriculum-analysis', compact(
            'competencyStats',
            'supervisorStats',
            'suggestions',
            'totalAlumniTracer',
            'totalSupervisorTracer',
            'analysisResult'
        ));
    }

    public function generate(Request $request)
    {
        $competencyStats = \App\Models\TracerKompetensi::selectRaw('
            AVG(etika_awal) as etika_awal,
            AVG(keahlian_awal) as keahlian_awal,
            AVG(bahasa_inggris_awal) as bahasa_inggris_awal,
            AVG(teknologi_awal) as teknologi_awal,
            AVG(kerjasama_awal) as kerjasama_awal,
            AVG(komunikasi_awal) as komunikasi_awal,
            AVG(pengembangan_awal) as pengembangan_awal,
            
            AVG(etika_sekarang) as etika_sekarang,
            AVG(keahlian_sekarang) as keahlian_sekarang,
            AVG(bahasa_inggris_sekarang) as bahasa_inggris_sekarang,
            AVG(teknologi_sekarang) as teknologi_sekarang,
            AVG(kerjasama_sekarang) as kerjasama_sekarang,
            AVG(komunikasi_sekarang) as komunikasi_sekarang,
            AVG(pengembangan_sekarang) as pengembangan_sekarang
        ')->first();

        $supervisorStats = \App\Models\TracerPengguna::where('status_pengisian', 'completed')
            ->selectRaw('
                AVG(integritas) as integritas,
                AVG(keahlian) as keahlian,
                AVG(kemampuan) as kemampuan,
                AVG(penguasaan) as penguasaan,
                AVG(komunikasi) as komunikasi,
                AVG(kerja_tim) as kerja_tim,
                AVG(pengembangan) as pengembangan
            ')->first();

        $suggestions = \App\Models\TracerPengguna::where('status_pengisian', 'completed')
            ->whereNotNull('saran_perbaikan')
            ->where('saran_perbaikan', '!=', '')
            ->latest()
            ->limit(20)
            ->pluck('saran_perbaikan')
            ->toArray();

        // Validasi ketersediaan data
        if (\App\Models\TracerKompetensi::count() == 0 && \App\Models\TracerPengguna::where('status_pengisian', 'completed')->count() == 0) {
            return redirect()->back()->with('error', 'Data Tracer Study belum mencukupi untuk dianalisis oleh AI.');
        }

        // Susun prompt untuk Gemini
        $prompt = $this->buildAnalysisPrompt($competencyStats, $supervisorStats, $suggestions);

        // Panggil API Gemini dengan fallback ke OpenRouter jika gagal
        $result = $this->callGemini($prompt);

        if (!$result['success']) {
            Log::info('Direct Gemini API failed. Attempting OpenRouter fallback...');
            $openrouterResult = $this->callOpenRouter($prompt);
            if ($openrouterResult['success']) {
                $result = [
                    'success' => true,
                    'text' => $openrouterResult['text']
                ];
            }
        }

        if ($result['success']) {
            // Simpan di Cache selama 24 jam
            Cache::put('curriculum_gap_analysis', $result['text'], now()->addHours(24));
            return redirect()->back()->with('success', 'Analisis kurikulum berhasil diperbarui oleh Jagat AI.');
        } else {
            return redirect()->back()->with('error', 'Gagal memanggil Jagat AI: ' . ($result['error'] ?? 'Terjadi kesalahan sistem pada API AI.'));
        }
    }

    private function buildAnalysisPrompt($comp, $sup, $suggestions)
    {
        $suggestionsStr = empty($suggestions) ? "Tidak ada saran spesifik." : implode("\n- ", $suggestions);

        return "Anda adalah pakar Evaluasi Pendidikan Tinggi dan Penjaminan Mutu Akademik untuk Program Studi Teknik Informatika di Universitas Harkat Negeri. "
            . "Tugas Anda adalah melakukan Analisis Kesenjangan Kurikulum (Curriculum Gap Analysis) berdasarkan data Tracer Study berikut:\n\n"
            . "1. EVALUASI MANDIRI ALUMNI (Skala 1-5, rata-rata):\n"
            . "   - Etika/Moral: Awal lulus = " . round($comp->etika_awal ?? 0, 2) . ", Sekarang = " . round($comp->etika_sekarang ?? 0, 2) . "\n"
            . "   - Keahlian Bidang Ilmu (Hard Skill): Awal lulus = " . round($comp->keahlian_awal ?? 0, 2) . ", Sekarang = " . round($comp->keahlian_sekarang ?? 0, 2) . "\n"
            . "   - Bahasa Inggris: Awal lulus = " . round($comp->bahasa_inggris_awal ?? 0, 2) . ", Sekarang = " . round($comp->bahasa_inggris_sekarang ?? 0, 2) . "\n"
            . "   - Penggunaan Teknologi Informasi: Awal lulus = " . round($comp->teknologi_awal ?? 0, 2) . ", Sekarang = " . round($comp->teknologi_sekarang ?? 0, 2) . "\n"
            . "   - Kerjasama Tim: Awal lulus = " . round($comp->kerjasama_awal ?? 0, 2) . ", Sekarang = " . round($comp->kerjasama_sekarang ?? 0, 2) . "\n"
            . "   - Komunikasi: Awal lulus = " . round($comp->komunikasi_awal ?? 0, 2) . ", Sekarang = " . round($comp->komunikasi_sekarang ?? 0, 2) . "\n"
            . "   - Pengembangan Diri: Awal lulus = " . round($comp->pengembangan_awal ?? 0, 2) . ", Sekarang = " . round($comp->pengembangan_sekarang ?? 0, 2) . "\n\n"
            . "2. PENILAIAN DARI PENGGUNA LULUSAN / INDUSTRI (Skala 1-5, rata-rata kepuasan atasan terhadap alumni):\n"
            . "   - Integritas/Etika: " . round($sup->integritas ?? 0, 2) . "\n"
            . "   - Keahlian Bidang (Hard Skill): " . round($sup->keahlian ?? 0, 2) . "\n"
            . "   - Kemampuan Berbahasa Asing: " . round($sup->kemampuan ?? 0, 2) . "\n"
            . "   - Penggunaan Teknologi: " . round($sup->penguasaan ?? 0, 2) . "\n"
            . "   - Komunikasi: " . round($sup->komunikasi ?? 0, 2) . "\n"
            . "   - Kerjasama Tim: " . round($sup->kerja_tim ?? 0, 2) . "\n"
            . "   - Pengembangan Diri: " . round($sup->pengembangan ?? 0, 2) . "\n\n"
            . "3. SARAN PERBAIKAN DARI ATASAN/PENGGUNA LULUSAN:\n"
            . "- " . $suggestionsStr . "\n\n"
            . "Berdasarkan data di atas, berikan analisis komprehensif dengan struktur berikut (dalam bahasa Indonesia yang formal, taktis, dan berbobot akademis):\n\n"
            . "### 1. Kekuatan Utama Lulusan\n"
            . "Analisis kompetensi alumni yang dinilai tinggi baik oleh diri mereka sendiri maupun industri.\n\n"
            . "### 2. Kesenjangan Kompetensi (Gap Analysis)\n"
            . "Soroti aspek-aspek di mana nilai awal lulusan atau penilaian atasan masih rendah, atau jika terdapat perbedaan besar antara kompetensi saat awal lulus dengan kebutuhan saat ini.\n\n"
            . "### 3. Rekomendasi Kurikulum & Pembaruan Mata Kuliah\n"
            . "Berikan rekomendasi mata kuliah spesifik (misal: penambahan materi DevOps, Cloud Computing, Artificial Intelligence, English for IT, Project Management, dll.) untuk menutupi kesenjangan tersebut pada prodi Teknik Informatika.\n\n"
            . "### 4. Langkah Strategis Program Studi\n"
            . "Langkah-langkah taktis prodi (seperti workshop, sertifikasi industri, magang bersertifikat, dll.) untuk meningkatkan kesiapan kerja lulusan.\n\n"
            . "Format respons Anda dalam Markdown yang rapi dan profesional.";
    }

    private function callGemini($prompt, $attempt = 1)
    {
        $apiKey = config('services.gemini.key');
        $apiUrl = config('services.gemini.url');

        if (!$apiKey || !$apiUrl) {
            return [
                'success' => false,
                'error' => 'API Key atau API URL untuk Gemini belum dikonfigurasi di file .env.'
            ];
        }

        $url = $apiUrl . '?key=' . $apiKey;
        $payload = [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ]
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // Jika terjadi 503 (High Demand) atau 429 (Rate Limit), coba lagi sampai 3 kali
        if (($httpCode === 503 || $httpCode === 429) && $attempt < 3) {
            sleep(2);
            return $this->callGemini($prompt, $attempt + 1);
        }

        if ($httpCode !== 200) {
            Log::error('Gemini API Error: ' . $response);
            return [
                'success' => false,
                'error' => 'HTTP Code ' . $httpCode . ' - ' . ($response ?: 'Empty response')
            ];
        }

        $result = json_decode($response, true);
        $text = $result['candidates'][0]['content']['parts'][0]['text'] ?? null;

        if ($text) {
            return [
                'success' => true,
                'text' => $text
            ];
        }

        return [
            'success' => false,
            'error' => 'Respon dari Gemini kosong.'
        ];
    }

    /**
     * Fallback to OpenRouter using free reliable models when Gemini API fails
     */
    private function callOpenRouter($prompt)
    {
        $apiKey = config('services.openrouter.key');
        $apiUrl = config('services.openrouter.url', 'https://openrouter.ai/api/v1/chat/completions');

        if (!$apiKey) {
            return [
                'success' => false,
                'error' => 'OPENROUTER_API_KEY belum dikonfigurasi'
            ];
        }

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
                    [
                        'role' => 'user',
                        'content' => $prompt
                    ]
                ],
                'max_tokens' => 2500
            ];

            $ch = curl_init($apiUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $apiKey,
            ]);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
            curl_setopt($ch, CURLOPT_TIMEOUT, 60);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode === 200) {
                $result = json_decode($response, true);
                $text = $result['choices'][0]['message']['content'] ?? null;
                if ($text) {
                    return [
                        'success' => true,
                        'text' => $text
                    ];
                }
            } else {
                Log::warning("OpenRouter Fallback Error for model {$model}: {$response}");
            }
        }

        return [
            'success' => false,
            'error' => 'Fallback OpenRouter gagal untuk semua model'
        ];
    }
}
