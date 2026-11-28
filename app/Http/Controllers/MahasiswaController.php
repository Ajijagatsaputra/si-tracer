<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class MahasiswaController extends Controller
{
    /**
     * Mendapatkan data mahasiswa berdasarkan tahun angkatan dari API OASE.
     * Hanya menyimpan ke cache jika respons berhasil (mencegah negative caching saat API timeout).
     */
    public function getData(Request $request)
    {
        $tahun = $request->input('tahun_angkatan');
        $forceRefresh = $request->boolean('refresh');

        $cacheKey = 'oase:mahasiswa_list:' . ($tahun ?: 'all');

        if ($forceRefresh) {
            Cache::forget('oase:is_offline');
            Cache::forget($cacheKey);
        }

        // Gunakan cache yang valid bila sudah tersimpan sebelumnya
        $cached = Cache::get($cacheKey);
        if (is_array($cached) && !empty($cached['status']) && !empty($cached['data'])) {
            return response()->json($cached);
        }

        if (Cache::has('oase:is_offline') && !$forceRefresh) {
            return response()->json([
                'status' => false,
                'offline' => true,
                'message' => 'Server API OASE (api.oase.poltektegal.ac.id) sedang tidak merespons / offline.',
                'data' => [],
            ]);
        }

        try {
            $baseUrl = rtrim(config('services.oase.url', 'https://api.oase.poltektegal.ac.id/api/web'), '/');
            $apiKey = config('services.oase.key') ?: env('OASE_API_KEY');

            $response = Http::connectTimeout(15)
                ->timeout(15)
                ->withoutVerifying()
                ->get("{$baseUrl}/mahasiswa", [
                    'key' => $apiKey,
                    'tahun_angkatan' => $tahun,
                ]);

            if (!$response->successful()) {
                Log::warning('OASE Mahasiswa API HTTP ' . $response->status());
                return response()->json([
                    'status' => false,
                    'offline' => true,
                    'message' => 'Server API OASE mengembalikan status HTTP ' . $response->status() . '.',
                    'data' => [],
                ]);
            }

            $json = $response->json();

            // Hanya simpan ke cache (30 menit) bila data valid & berhasil
            if (is_array($json) && !empty($json['status']) && isset($json['data']) && is_array($json['data'])) {
                Cache::forget('oase:is_offline');
                Cache::put($cacheKey, $json, 1800);
                return response()->json($json);
            }

            return response()->json([
                'status' => false,
                'message' => $json['message'] ?? 'Tidak ada data mahasiswa untuk tahun angkatan tersebut.',
                'data' => [],
            ]);
        } catch (\Throwable $e) {
            Log::warning('OASE Mahasiswa API Timeout/Error: ' . $e->getMessage());
            Cache::put('oase:is_offline', true, 120);

            return response()->json([
                'status' => false,
                'offline' => true,
                'message' => 'Koneksi ke server API OASE (api.oase.poltektegal.ac.id) timeout / sedang gangguan.',
                'data' => [],
            ]);
        }
    }
}
