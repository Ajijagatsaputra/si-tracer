<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class OaseClient
{
    private string $baseUrl = 'https://api.oase.poltektegal.ac.id/api/web';
    private string $apiKey;

    // TTL cache (detik). Silakan sesuaikan.
    private int $ttlTA = 3600;         // 1 jam untuk tahun akademik
    private int $ttlDosen = 1800;      // 30 menit untuk dosen per TA
    private int $ttlMahasiswa = 21600; // 6 jam untuk total mahasiswa

    public function __construct()
    {
        $this->apiKey = config('services.oase.key', env('OASE_API_KEY'));
    }

    private function http()
    {
        return Http::timeout(6)      // hindari ngegantung
                   ->retry(2, 300)   // 2x retry dengan jeda 300ms
                   ->acceptJson();
    }

    public function getTahunAkademikList(): array
    {
        return Cache::remember('oase:tahun_akademik', $this->ttlTA, function () {
            $res = $this->http()->get("{$this->baseUrl}/master/tahun-akademik", [
                'key' => $this->apiKey,
            ]);

            if (!$res->successful() || !isset($res['data'])) {
                // fallback: kosong
                return [];
            }
            return $res['data'];
        });
    }

    public function getDosenCount(?string $kodeTA, string $kodeProdi = '09'): int
    {
        if (!$kodeTA) return 0;

        $cacheKey = "oase:dosen_count:{$kodeProdi}:{$kodeTA}";
        return Cache::remember($cacheKey, $this->ttlDosen, function () use ($kodeProdi, $kodeTA) {
            $res = $this->http()->get("{$this->baseUrl}/dosen", [
                'key' => $this->apiKey,
                'kd_prodi' => $kodeProdi,
                'kode_tahun_akademik' => $kodeTA,
            ]);

            if (!$res->successful() || !isset($res['data'])) {
                return 0;
            }
            return count($res['data']);
        });
    }

    /**
     * Total mahasiswa 2020..2025.
     * Disarankan kalau API mendukung year-list sekaligus, gunakan endpoint batch.
     */
    public function getMahasiswaTotal(int $start = 2020, int $end = 2025): int
    {
        $cacheKey = "oase:mahasiswa_total:{$start}:{$end}";
        return Cache::remember($cacheKey, $this->ttlMahasiswa, function () use ($start, $end) {
            $total = 0;
            for ($tahun = $start; $tahun <= $end; $tahun++) {
                $res = $this->http()->get("{$this->baseUrl}/mahasiswa", [
                    'key' => $this->apiKey,
                    'tahun_angkatan' => $tahun,
                ]);

                if ($res->successful() && isset($res['data'])) {
                    $total += count($res['data']);
                }
                // Jika gagal satu tahun, lanjut; nanti akan dihitung ulang saat cache expire.
            }
            return $total;
        });
    }
}
