<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class MahasiswaController extends Controller
{
    /**
     * Mendapatkan data mahasiswa berdasarkan tahun angkatan.
     * Data di-cache per tahun angkatan selama 30 menit untuk menghindari
     * hit berulang ke API OASE eksternal pada setiap request DataTables.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getData(Request $request)
    {
        $tahun = $request->input('tahun_angkatan');

        if (Cache::has('oase:is_offline')) {
            return response()->json(['status' => false, 'data' => []]);
        }

        // Buat cache key unik per tahun angkatan
        // Jika tidak ada filter tahun, gunakan key 'all'
        $cacheKey = 'oase:mahasiswa_list:' . ($tahun ?? 'all');

        // TTL 30 menit (1800 detik) — konsisten dengan OaseClient::ttlDosen
        $ttl = 1800;

        $data = Cache::remember($cacheKey, $ttl, function () use ($tahun) {
            try {
                $response = Http::timeout(2)
                    ->get('https://api.oase.poltektegal.ac.id/api/web/mahasiswa', [
                        'key' => config('services.oase.key', env('OASE_API_KEY')),
                        'tahun_angkatan' => $tahun,
                    ]);

                // Jika API gagal, kembalikan struktur kosong agar tidak crash
                if (!$response->successful()) {
                    return ['status' => false, 'data' => []];
                }

                return $response->json();
            } catch (\Exception $e) {
                Cache::put('oase:is_offline', true, 300);
                return ['status' => false, 'data' => []];
            }
        });

        return response()->json($data);
    }
}
