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

        // Buat cache key unik per tahun angkatan
        // Jika tidak ada filter tahun, gunakan key 'all'
        $cacheKey = 'oase:mahasiswa_list:' . ($tahun ?? 'all');

        // TTL 30 menit (1800 detik) — konsisten dengan OaseClient::ttlDosen
        $ttl = 1800;

        $data = Cache::remember($cacheKey, $ttl, function () use ($tahun) {
            $response = Http::timeout(6)
                ->retry(2, 300)
                ->get('https://api.oase.poltektegal.ac.id/api/web/mahasiswa', [
                    'key' => config('services.oase.key', env('OASE_API_KEY')),
                    'tahun_angkatan' => $tahun,
                ]);

            // Jika API gagal, kembalikan struktur kosong agar tidak crash
            if (!$response->successful()) {
                return ['status' => false, 'data' => []];
            }

            return $response->json();
        });

        return response()->json($data);
    }
}
