<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class DosenController extends Controller
{
    public function getTahunAkademik()
    {
        if (Cache::has('oase:is_offline')) {
            return response()->json(['status' => false, 'data' => []]);
        }

        try {
            $response = Http::timeout(2)->get('https://api.oase.poltektegal.ac.id/api/web/master/tahun-akademik', [
                'key' => env('OASE_API_KEY')
            ]);

            if (!$response->successful()) {
                return response()->json(['status' => false, 'data' => []]);
            }

            return response()->json($response->json());
        } catch (\Exception $e) {
            Cache::put('oase:is_offline', true, 300);
            return response()->json(['status' => false, 'data' => []]);
        }
    }

    public function getDataDosen(Request $request)
    {
        $tahun = $request->input('kode_tahun_akademik');

        if (Cache::has('oase:is_offline')) {
            return response()->json([
                'status' => false,
                'data' => [],
                'message' => 'Data dosen tidak tersedia karena API OASE sedang offline'
            ]);
        }

        try {
            $response = Http::timeout(2)->get('https://api.oase.poltektegal.ac.id/api/web/dosen', [
                'key' => env('OASE_API_KEY'),
                'kd_prodi' => '09',
                'kode_tahun_akademik' => $tahun
            ]);

            if (!$response->successful()) {
                return response()->json([
                    'status' => false,
                    'data' => [],
                    'message' => 'Gagal mengambil data dari API OASE'
                ]);
            }

            $json = $response->json();

            if (!isset($json['data']) || !is_array($json['data'])) {
                return response()->json([
                    'status' => false,
                    'data' => [],
                    'message' => 'Data dosen tidak tersedia atau tidak valid'
                ]);
            }

            return response()->json([
                'status' => true,
                'data' => $json['data']
            ]);
        } catch (\Exception $e) {
            Cache::put('oase:is_offline', true, 300);
            return response()->json([
                'status' => false,
                'data' => [],
                'message' => 'Gagal terhubung ke API OASE'
            ]);
        }
    }
}
