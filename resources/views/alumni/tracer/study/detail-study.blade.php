@extends('layout')

@section('content')
    @include('components.navbar')

    <main id="main-container" class="mt-3">
        <div class="py-4 content">

            <!-- HEADER DETAIL STUDY -->
            <div class="mb-4">
                <h1 class="mb-1 h3 fw-bold text-dark">Detail Tracer Study</h1>
                <p class="mb-3 text-muted">Menampilkan informasi lengkap data tracer study alumni</p>
                <div class="gap-2 d-flex">
                    <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                    <a href="{{ route('new-tracer.edit') }}" class="btn btn-primary">
                        <i class="fas fa-edit me-2"></i>Edit Data
                    </a>
                </div>
            </div>

            <div class="row g-4">

                <!-- INFORMASI PRIBADI -->
                <div class="col-12">
                    <div class="border-0 shadow-sm card">
                        <div class="card-body">
                            <h5 class="mb-3 fw-bold">
                                <i class="fas fa-user text-primary me-2"></i>Informasi Pribadi
                            </h5>
                            <div class="row row-cols-1 row-cols-md-3 g-4">
                                <div class="col">
                                    <div class="small text-muted">Nama Lengkap</div>
                                    <div class="fw-medium">{{ $tracer->nama ?? '-' }}</div>
                                </div>
                                <div class="col">
                                    <div class="small text-muted">Email</div>
                                    <div class="fw-medium">{{ $tracer->email ?? '-' }}</div>
                                </div>
                                <div class="col">
                                    <div class="small text-muted">No. HP</div>
                                    <div class="fw-medium">{{ $tracer->no_hp ?? '-' }}</div>
                                </div>
                                <div class="col">
                                    <div class="small text-muted">NIM</div>
                                    <div class="fw-medium">{{ $tracer->nim ?? '-' }}</div>
                                </div>
                                <div class="col">
                                    <div class="small text-muted">Program Studi</div>
                                    <div class="fw-medium">{{ ucwords(str_replace('_', ' ', $tracer->prodi)) ?? '-' }}</div>
                                </div>
                                <div class="col">
                                    <div class="small text-muted">Tahun Lulus</div>
                                    <div class="fw-medium">{{ $tracer->tahun_lulus ?? '-' }}</div>
                                </div>
                                <div class="col-12">
                                    <div class="small text-muted">Alamat</div>
                                    <div class="fw-medium">{{ $tracer->alamat ?? '-' }}</div>
                                </div>
                                <div class="col">
                                    <div class="small text-muted">Status Pekerjaan</div>
                                    <div class="fw-medium">
                                        @php
                                            $status_labels = [
                                                'bekerja_full' => 'Bekerja (Full/Part Time)',
                                                'belum_bekerja' => 'Belum Memungkinkan Bekerja',
                                                'wirausaha' => 'Wiraswasta',
                                                'lanjutstudy' => 'Melanjutkan Pendidikan',
                                                'tidak' => 'Tidak Kerja, Sedang Mencari Kerja'
                                            ];
                                        @endphp
                                        <span class="badge bg-{{ $tracer->status_pekerjaan === 'bekerja_full' ? 'success' : ($tracer->status_pekerjaan === 'wirausaha' ? 'warning' : ($tracer->status_pekerjaan === 'lanjutstudy' ? 'info' : 'secondary')) }}">
                                            {{ $status_labels[$tracer->status_pekerjaan] ?? $tracer->status_pekerjaan }}
                                        </span>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="small text-muted">Tanggal Pengisian</div>
                                    <div class="fw-medium">{{ $tracer->tanggal_isi?->format('d F Y') ?? '-' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- DETAIL BERDASARKAN STATUS PEKERJAAN -->
                @if ($tracer->status_pekerjaan === 'bekerja_full' && $tracer->pekerjaan)
                    <div class="col-12">
                        <div class="border-0 shadow-sm card">
                            <div class="card-body">
                                <h5 class="mb-3 fw-bold">
                                    <i class="fas fa-briefcase text-success me-2"></i>Detail Pekerjaan
                                </h5>
                                <div class="row row-cols-1 row-cols-md-3 g-4">
                                    <div class="col">
                                        <div class="small text-muted">Mendapatkan Pekerjaan</div>
                                        <div class="fw-medium">
                                            {{ $tracer->pekerjaan->mendapatkan_pekerjaan === '<=6bulan' ? 'Sebelum 6 bulan sejak lulus' : 'Setelah 6 bulan sejak lulus' }}
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="small text-muted">Waktu Mendapat Kerja</div>
                                        <div class="fw-medium">{{ $tracer->pekerjaan->bulan_kerja ?? '-' }} bulan</div>
                                    </div>
                                    <div class="col">
                                        <div class="small text-muted">Pendapatan</div>
                                        <div class="fw-medium">
                                            {{ $tracer->pekerjaan->pendapatan ? 'Rp ' . number_format($tracer->pekerjaan->pendapatan, 0, ',', '.') : '-' }}
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="small text-muted">Nama Perusahaan</div>
                                        <div class="fw-medium">{{ $tracer->pekerjaan->nama_perusahaan ?? '-' }}</div>
                                    </div>
                                    <div class="col">
                                        <div class="small text-muted">Jabatan</div>
                                        <div class="fw-medium">{{ $tracer->pekerjaan->jabatan ?? '-' }}</div>
                                    </div>
                                    <div class="col">
                                        <div class="small text-muted">NIPY</div>
                                        <div class="fw-medium">{{ $tracer->pengguna->nipy ?? '-' }}</div>
                                    </div>
                                    <div class="col">
                                        <div class="small text-muted">Provinsi</div>
                                        <div class="fw-medium">
                                            {{ \Laravolt\Indonesia\Models\Province::where('code', $tracer->pekerjaan?->provinsi)->first()?->name ?? '-' }}
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="small text-muted">Kota</div>
                                        <div class="fw-medium">
                                            {{ \Laravolt\Indonesia\Models\City::where('code', $tracer->pekerjaan?->kota)->first()?->name ?? '-' }}
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="small text-muted">Tingkat Usaha</div>
                                        <div class="fw-medium">
                                            @php
                                                $tingkatUsaha = $tracer->pekerjaan->tingkat_usaha_level ?? '-';
                                                if ($tingkatUsaha !== '-' && $tingkatUsaha !== null) {
                                                    $tingkatUsaha = ucwords(str_replace('_', ' ', $tingkatUsaha));
                                                }
                                            @endphp
                                            {{ $tingkatUsaha }}
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="small text-muted">Alamat Pekerjaan</div>
                                        <div class="fw-medium">{{ $tracer->pekerjaan->alamat_pekerjaan ?? '-' }}</div>
                                    </div>
                                    <div class="col">
                                        <div class="small text-muted">Hubungan Studi - Pekerjaan</div>
                                        <div class="fw-medium">
                                            @php
                                                $hubungan_labels = [
                                                    'sangat_erat' => 'Sangat Erat',
                                                    'erat' => 'Erat',
                                                    'cukup_erat' => 'Cukup Erat',
                                                    'kurang_erat' => 'Kurang Erat',
                                                    'tidak_erat' => 'Tidak Erat'
                                                ];
                                            @endphp
                                            {{ $hubungan_labels[$tracer->pekerjaan->hubungan_studi_pekerjaan] ?? '-' }}
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="small text-muted">Kesesuaian Pendidikan</div>
                                        <div class="fw-medium">
                                            @php
                                                $pendidikan_labels = [
                                                    'lebih_tinggi' => 'Setingkat Lebih Tinggi',
                                                    'sama' => 'Tingkat yang Sama',
                                                    'lebih_rendah' => 'Setingkat Lebih Rendah',
                                                    'tidak_perlu_pt' => 'Tidak Perlu Pendidikan Tinggi'
                                                ];
                                            @endphp
                                            {{ $pendidikan_labels[$tracer->pekerjaan->pendidikan_sesuai_pekerjaan] ?? '-' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif ($tracer->status_pekerjaan === 'wirausaha' && $tracer->wirausaha)
                    <div class="col-12">
                        <div class="border-0 shadow-sm card">
                            <div class="card-body">
                                <h5 class="mb-3 fw-bold">
                                    <i class="fas fa-store text-warning me-2"></i>Detail Wirausaha
                                </h5>
                                <div class="row row-cols-1 row-cols-md-3 g-4">
                                    <div class="col">
                                        <div class="small text-muted">Nama Usaha</div>
                                        <div class="fw-medium">{{ $tracer->wirausaha->nama_usaha ?? '-' }}</div>
                                    </div>
                                    <div class="col">
                                        <div class="small text-muted">Posisi Usaha</div>
                                        <div class="fw-medium">{{ ucfirst($tracer->wirausaha->posisi_usaha) ?? '-' }}</div>
                                    </div>
                                    <div class="col">
                                        <div class="small text-muted">Tingkat Usaha</div>
                                        <div class="fw-medium">
                                            @php
                                                $tingkatUsaha = $tracer->wirausaha->tingkat_usaha_level ?? '-';
                                                if ($tingkatUsaha !== '-' && $tingkatUsaha !== null) {
                                                    $tingkatUsaha = ucwords(str_replace('_', ' ', $tingkatUsaha));
                                                }
                                            @endphp
                                            {{ $tingkatUsaha }}
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="small text-muted">Pendapatan Usaha</div>
                                        <div class="fw-medium">
                                            {{ $tracer->wirausaha->pendapatan_usaha ? 'Rp ' . number_format($tracer->wirausaha->pendapatan_usaha, 0, ',', '.') : '-' }}
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="small text-muted">Alamat Usaha</div>
                                        <div class="fw-medium">{{ $tracer->wirausaha->alamat_usaha ?? '-' }}</div>
                                    </div>
                                    <div class="col">
                                        <div class="small text-muted">Hubungan Studi - Pekerjaan</div>
                                        <div class="fw-medium">
                                            @php
                                                $hubungan_labels = [
                                                    'sangat_erat' => 'Sangat Erat',
                                                    'erat' => 'Erat',
                                                    'cukup_erat' => 'Cukup Erat',
                                                    'kurang_erat' => 'Kurang Erat',
                                                    'tidak_erat' => 'Tidak Erat'
                                                ];
                                            @endphp
                                            {{ $hubungan_labels[$tracer->wirausaha->hubungan_studi_pekerjaan] ?? '-' }}
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="small text-muted">Kesesuaian Pendidikan</div>
                                        <div class="fw-medium">
                                            @php
                                                $pendidikan_labels = [
                                                    'lebih_tinggi' => 'Setingkat Lebih Tinggi',
                                                    'sama' => 'Tingkat yang Sama',
                                                    'lebih_rendah' => 'Setingkat Lebih Rendah',
                                                    'tidak_perlu_pt' => 'Tidak Perlu Pendidikan Tinggi'
                                                ];
                                            @endphp
                                            {{ $pendidikan_labels[$tracer->wirausaha->pendidikan_sesuai_pekerjaan] ?? '-' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif ($tracer->status_pekerjaan === 'lanjutstudy' && $tracer->pendidikan)
                    <div class="col-12">
                        <div class="border-0 shadow-sm card">
                            <div class="card-body">
                                <h5 class="mb-3 fw-bold">
                                    <i class="fas fa-graduation-cap text-info me-2"></i>Detail Pendidikan Lanjut
                                </h5>
                                <div class="row row-cols-1 row-cols-md-3 g-4">
                                    <div class="col">
                                        <div class="small text-muted">Universitas</div>
                                        <div class="fw-medium">{{ $tracer->pendidikan->universitas ?? '-' }}</div>
                                    </div>
                                    <div class="col">
                                        <div class="small text-muted">Program Studi</div>
                                        <div class="fw-medium">{{ $tracer->pendidikan->program_studi ?? '-' }}</div>
                                    </div>
                                    <div class="col">
                                        <div class="small text-muted">Sumber Biaya</div>
                                        <div class="fw-medium">{{ ucwords(str_replace('_', ' ', $tracer->pendidikan->sumber_biaya)) ?? '-' }}</div>
                                    </div>
                                    <div class="col">
                                        <div class="small text-muted">Tanggal Masuk</div>
                                        <div class="fw-medium">{{ $tracer->pendidikan->tanggal_masuk?->format('d F Y') ?? '-' }}</div>
                                    </div>
                                    <div class="col-12">
                                        <div class="small text-muted">Lokasi Universitas</div>
                                        <div class="fw-medium">{{ $tracer->pendidikan->lokasi_universitas ?? '-' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- CARA MENCARI PEKERJAAN (untuk tidak) -->
                @if ($tracer->status_pekerjaan === 'asd' && $tracer->pencarianKerja)
                    <div class="col-12">
                        <div class="border-0 shadow-sm card">
                            <div class="card-body">
                                <h5 class="mb-3 fw-bold">
                                    <i class="fas fa-file-alt text-info me-2"></i>Cara Mencari Pekerjaan
                                </h5>
                                <div class="row row-cols-1 row-cols-md-3 g-4">
                                    @if ($tracer->pencarianKerja->aktif_cari_kerja)
                                        <div class="col">
                                            <div class="small text-muted">Cara Mencari Pekerjaan</div>
                                            <div class="fw-medium">{{ $tracer->pencarianKerja->aktif_cari_kerja }}</div>
                                        </div>
                                    @endif
                                    @if ($tracer->pencarianKerja->jumlah_perusahaan_lamar)
                                        <div class="col">
                                            <div class="small text-muted">Jumlah Perusahaan Dilamar</div>
                                            <div class="fw-medium">{{ $tracer->pencarianKerja->jumlah_perusahaan_lamar }} perusahaan</div>
                                        </div>
                                    @endif
                                    @if ($tracer->pencarianKerja->jumlah_perusahaan_respon)
                                        <div class="col">
                                            <div class="small text-muted">Jumlah Respon</div>
                                            <div class="fw-medium">{{ $tracer->pencarianKerja->jumlah_perusahaan_respon }} perusahaan</div>
                                        </div>
                                    @endif
                                    @if ($tracer->pencarianKerja->jumlah_perusahaan_wawancara)
                                        <div class="col">
                                            <div class="small text-muted">Jumlah Wawancara</div>
                                            <div class="fw-medium">{{ $tracer->pencarianKerja->jumlah_perusahaan_wawancara }} perusahaan</div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- PENCARIAN KERJA / AKTIVITAS (untuk bekerja_full, belum_bekerja, tidak) -->
                @if (in_array($tracer->status_pekerjaan, ['bekerja_full', 'wirausaha', 'tidak']) && $tracer->pencarianKerja)
                    <div class="col-12">
                        <div class="border-0 shadow-sm card">
                            <div class="card-body">
                                <h5 class="mb-3 fw-bold">
                                    <i class="fas fa-search text-secondary me-2"></i>Detail Pencarian Kerja
                                </h5>
                                <div class="row row-cols-1 row-cols-md-3 g-4">
                                    @if ($tracer->pencarianKerja->waktu_cari_kerja)
                                        <div class="col">
                                            <div class="small text-muted">Waktu Mulai Cari Kerja</div>
                                            <div class="fw-medium">{{ ucwords(str_replace('_', ' ', $tracer->pencarianKerja->waktu_cari_kerja)) }}</div>
                                        </div>
                                    @endif
                                    @if ($tracer->pencarianKerja->bulan_sebelum_lulus)
                                        <div class="col">
                                            <div class="small text-muted">Bulan Sebelum Lulus</div>

                                            <div class="fw-medium">{{ $tracer->pencarianKerja->bulan_sebelum_lulus }} bulan</div>
                                        </div>
                                    @endif
                                    @if ($tracer->pencarianKerja->bulan_setelah_lulus)
                                        <div class="col">
                                            <div class="small text-muted">Bulan Setelah Lulus</div>
                                            <div class="fw-medium">{{ $tracer->pencarianKerja->bulan_setelah_lulus }} bulan</div>
                                        </div>
                                    @endif

                                    @if ($tracer->pencarianKerja->aktif_cari_kerja)
                                        <div class="col">
                                            <div class="small text-muted">Cara Mencari Pekerjaan</div>
                                            @php
                                                $aktif_cari_kerja_labels = [
                                                    '1' => '1. Melalui iklan di koran/majalah, brosur',
                                                    '2' => '2. Melamar ke perusahaan tanpa mengetahui lowongan yang ada',
                                                    '3' => '3. Pergi ke bursa/pameran kerja',
                                                    '4' => '4. Mencari lewat internet / iklan online / milis',
                                                    '5' => '5. Dihubungi oleh perusahaan',
                                                    '6' => '6. Menghubungi Kemenakertrans',
                                                    '7' => '7. Menghubungi agen tenaga kerja komersial / swasta',
                                                    '8' => '8. Memeroleh informasi dari pusat / kantor pengembangan karir fakultas/universitas',
                                                    '9' => '9. Menghubungi kantor kemahasiswaan / hubungan alumni',
                                                    '10' => '10. Membangun jejaring (network) sejak masa kuliah',
                                                    '11' => '11. Melalui relasi (misalnya, dosen, orang tua, teman, saudara, dll.)',
                                                    '12' => '12. Membangun bisnis sendiri',
                                                    '13' => '13. Melalui penempatan kerja atau magang',
                                                    '14' => '14. Bekerja di tempat yang sama dengan tempat kerja semasa kuliah',
                                                    '15' => '15. Lainnya',
                                                ];
                                            @endphp
                                            <div class="fw-medium">
                                                {{ $aktif_cari_kerja_labels[$tracer->pencarianKerja->aktif_cari_kerja] ?? $tracer->pencarianKerja->aktif_cari_kerja }}
                                            </div>
                                        </div>
                                    @endif
                                    @if ($tracer->pencarianKerja->jumlah_perusahaan_lamar)
                                        <div class="col">
                                            <div class="small text-muted">Jumlah Perusahaan Dilamar</div>
                                            <div class="fw-medium">{{ $tracer->pencarianKerja->jumlah_perusahaan_lamar }} perusahaan</div>
                                        </div>
                                    @endif
                                    @if ($tracer->pencarianKerja->jumlah_perusahaan_respon)
                                        <div class="col">
                                            <div class="small text-muted">Jumlah Perusahaan Merespon</div>
                                            <div class="fw-medium">{{ $tracer->pencarianKerja->jumlah_perusahaan_respon }} perusahaan</div>
                                        </div>
                                    @endif
                                    @if ($tracer->pencarianKerja->jumlah_perusahaan_wawancara)
                                        <div class="col">
                                            <div class="small text-muted">Jumlah Perusahaan Wawancara</div>
                                            <div class="fw-medium">{{ $tracer->pencarianKerja->jumlah_perusahaan_wawancara }} perusahaan</div>
                                        </div>
                                    @endif
                                    @if ($tracer->pencarianKerja->cara_mencari_kerja)
                                        <div class="col">
                                            <div class="small text-muted">Cara Mencari Kerja (Lainnya)</div>
                                            <div class="fw-medium">{{ $tracer->pencarianKerja->cara_mencari_kerja }}</div>
                                        </div>
                                    @endif
                                    @if ($tracer->pencarianKerja->sumber_informasi)
                                        <div class="col">
                                            <div class="small text-muted">Sumber Informasi</div>
                                            <div class="fw-medium">{{ $tracer->pencarianKerja->sumber_informasi }}</div>
                                        </div>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- AKTIVITAS SAAT INI (untuk belum_bekerja) -->
                @if (in_array($tracer->status_pekerjaan, ['belum_bekerja', 'tidak', 'wirausaha', 'bekerja_full']) && $tracer->pencarianKerja)
                    <div class="col-12">
                        <div class="border-0 shadow-sm card">
                            <div class="card-body">
                                <h5 class="mb-3 fw-bold">
                                    <i class="fas fa-tasks text-primary me-2"></i>Aktivitas Saat Ini
                                </h5>
                                <div class="row row-cols-1 row-cols-md-12 g-4">
                                    @if ($tracer->pencarianKerja->aktif_cari_kerja_4minggu)
                                        <div class="col">
                                            <div class="small text-muted">Aktif Cari Kerja (4 Minggu Terakhir)</div>
                                            @php
                                                $aktif_cari_kerja_labels = [
                                                    'tidak' => 'Tidak',
                                                    'tidak_ada_lowongan' => 'Tidak, karena tidak ada lowongan kerja',
                                                    'tidak_ada_lowongan_sesuai' => 'Tidak, karena tidak ada lowongan kerja yang sesuai',
                                                    'tidak_memenuhi_kualifikasi' => 'Tidak, karena tidak memenuhi kualifikasi',
                                                    'sudah_dapat_pekerjaan' => 'Tidak, karena sudah dapat pekerjaan namun belum mulai bekerja',
                                                    'sedang_mencari' => 'Ya, sedang aktif mencari'
                                                ];
                                            @endphp
                                            <div class="fw-medium">{{ $aktif_cari_kerja_labels[$tracer->pencarianKerja->aktif_cari_kerja_4minggu] ?? $tracer->pencarianKerja->aktif_cari_kerja_4minggu }}</div>
                                        </div>
                                    @endif
                                    @if ($tracer->pencarianKerja->alasan_pekerjaan_tidak_sesuai)
                                        <div class="col-12">
                                            <div class="small text-muted">Alasan Pekerjaan</div>
                                            @php
                                                $alasan_pekerjaan_labels = [
                                                    '1' => 'Pekerjaan saya sekarang sudah sesuai dengan pendidikan saya',
                                                    '2' => 'Saya belum mendapatkan pekerjaan yg lebih sesuai',
                                                    '3' => 'Di pekerjaan ini saya memeroleh prospek karir yang baik',
                                                    '4' => 'Saya lebih suka bekerja di area pekerjaan yang tidak ada hubungannya dengan pendidikan saya',
                                                    '5' => 'Saya dipromosikan ke posisi yg kurang berhubungan dengan pendidikan saya dibanding posisi sebelumnya',
                                                    '6' => 'Saya dapat memeroleh pendapatan yang lebih tinggi di pekerjaan ini',
                                                    '7' => 'Pekerjaan saya saat ini lebih aman/terjamin/secure',
                                                    '8' => 'Pekerjaan saya saat ini lebih menarik',
                                                    '9' => 'Pekerjaan saya saat ini lebih memungkinkan saya mengambil pekerjaan tambahan/jadwal yang fleksibel, dll',
                                                    '10' => 'Pekerjaan saya saat ini lokasinya lebih dekat dari rumah saya',
                                                    '11' => 'Pekerjaan saya saat ini dapat lebih menjamin kebutuhan keluarga saya',
                                                    '12' => 'Pada awal meniti karir ini, saya harus menerima pekerjaan yang tidak berhubungan dengan pendidikan saya',
                                                    '13' => 'Lainnya...',
                                                ];
                                            @endphp
                                            <div class="fw-medium">{{ $alasan_pekerjaan_labels[$tracer->pencarianKerja->alasan_pekerjaan_tidak_sesuai] ?? $tracer->pencarianKerja->alasan_pekerjaan_tidak_sesuai }}</div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- KOMPETENSI ALUMNI -->
                @if ($tracer->kompetensi)
                    <div class="col-12">
                        <div class="border-0 shadow-sm card">
                            <div class="card-body">
                                <h5 class="mb-3 fw-bold">
                                    <i class="fas fa-star text-warning me-2"></i>Kompetensi Alumni
                                </h5>
                                @php
                                    $opsi_kompetensi = [
                                        'sangat_baik' => '⭐⭐⭐⭐⭐ Sangat Baik',
                                        'baik' => '⭐⭐⭐⭐ Baik',
                                        'cukup' => '⭐⭐⭐ Cukup',
                                        'kurang_baik' => '⭐⭐ Kurang Baik',
                                        'tidak_baik' => '⭐ Tidak Baik',
                                    ];
                                @endphp

                                <!-- Kompetensi Awal -->
                                <h6 class="mb-3 fw-semibold text-muted">Kompetensi Saat Awal Lulus</h6>
                                <div class="mb-4 row row-cols-1 row-cols-md-4 g-3">
                                    <div class="col">
                                        <div class="small text-muted">Etika</div>
                                        <div class="fw-medium">{{ $opsi_kompetensi[$tracer->kompetensi->etika_awal] ?? '-' }}</div>
                                    </div>
                                    <div class="col">
                                        <div class="small text-muted">Keahlian</div>
                                        <div class="fw-medium">{{ $opsi_kompetensi[$tracer->kompetensi->keahlian_awal] ?? '-' }}</div>
                                    </div>
                                    <div class="col">
                                        <div class="small text-muted">Bahasa Inggris</div>
                                        <div class="fw-medium">{{ $opsi_kompetensi[$tracer->kompetensi->bahasa_inggris_awal] ?? '-' }}</div>
                                    </div>
                                    <div class="col">
                                        <div class="small text-muted">Teknologi</div>
                                        <div class="fw-medium">{{ $opsi_kompetensi[$tracer->kompetensi->teknologi_awal] ?? '-' }}</div>
                                    </div>
                                    <div class="col">
                                        <div class="small text-muted">Kerja Sama</div>
                                        <div class="fw-medium">{{ $opsi_kompetensi[$tracer->kompetensi->kerjasama_awal] ?? '-' }}</div>
                                    </div>
                                    <div class="col">
                                        <div class="small text-muted">Komunikasi</div>
                                        <div class="fw-medium">{{ $opsi_kompetensi[$tracer->kompetensi->komunikasi_awal] ?? '-' }}</div>
                                    </div>
                                    <div class="col">
                                        <div class="small text-muted">Pengembangan</div>
                                        <div class="fw-medium">{{ $opsi_kompetensi[$tracer->kompetensi->pengembangan_awal] ?? '-' }}</div>
                                    </div>
                                </div>

                                <!-- Kompetensi Sekarang -->
                                <h6 class="mb-3 fw-semibold text-muted">Kompetensi Saat Ini</h6>
                                <div class="row row-cols-1 row-cols-md-4 g-3">
                                    <div class="col">
                                        <div class="small text-muted">Etika</div>
                                        <div class="fw-medium">{{ $opsi_kompetensi[$tracer->kompetensi->etika_sekarang] ?? '-' }}</div>
                                    </div>
                                    <div class="col">
                                        <div class="small text-muted">Keahlian</div>
                                        <div class="fw-medium">{{ $opsi_kompetensi[$tracer->kompetensi->keahlian_sekarang] ?? '-' }}</div>
                                    </div>
                                    <div class="col">
                                        <div class="small text-muted">Bahasa Inggris</div>
                                        <div class="fw-medium">{{ $opsi_kompetensi[$tracer->kompetensi->bahasa_inggris_sekarang] ?? '-' }}</div>
                                    </div>
                                    <div class="col">
                                        <div class="small text-muted">Teknologi</div>
                                        <div class="fw-medium">{{ $opsi_kompetensi[$tracer->kompetensi->teknologi_sekarang] ?? '-' }}</div>
                                    </div>
                                    <div class="col">
                                        <div class="small text-muted">Kerja Sama</div>
                                        <div class="fw-medium">{{ $opsi_kompetensi[$tracer->kompetensi->kerjasama_sekarang] ?? '-' }}</div>
                                    </div>
                                    <div class="col">
                                        <div class="small text-muted">Komunikasi</div>
                                        <div class="fw-medium">{{ $opsi_kompetensi[$tracer->kompetensi->komunikasi_sekarang] ?? '-' }}</div>
                                    </div>
                                    <div class="col">
                                        <div class="small text-muted">Pengembangan</div>
                                        <div class="fw-medium">{{ $opsi_kompetensi[$tracer->kompetensi->pengembangan_sekarang] ?? '-' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- EVALUASI PENDIDIKAN -->
                @if ($tracer->evaluasiPendidikan)
                    <div class="col-12">
                        <div class="border-0 shadow-sm card">
                            <div class="card-body">
                                <h5 class="mb-3 fw-bold">
                                    <i class="fas fa-graduation-cap text-info me-2"></i>Evaluasi Pendidikan
                                </h5>
                                <div class="row row-cols-1 row-cols-md-4 g-3">
                                    <div class="col">
                                        <div class="small text-muted">Perkuliahan</div>
                                        <div class="fw-medium">{{ $opsi_kompetensi[$tracer->evaluasiPendidikan->perkuliahan] ?? '-' }}</div>
                                    </div>
                                    <div class="col">
                                        <div class="small text-muted">Praktikum</div>
                                        <div class="fw-medium">{{ $opsi_kompetensi[$tracer->evaluasiPendidikan->praktikum] ?? '-' }}</div>
                                    </div>
                                    <div class="col">
                                        <div class="small text-muted">Demonstrasi</div>
                                        <div class="fw-medium">{{ $opsi_kompetensi[$tracer->evaluasiPendidikan->demonstrasi] ?? '-' }}</div>
                                    </div>
                                    <div class="col">
                                        <div class="small text-muted">Riset</div>
                                        <div class="fw-medium">{{ $opsi_kompetensi[$tracer->evaluasiPendidikan->riset] ?? '-' }}</div>
                                    </div>
                                    <div class="col">
                                        <div class="small text-muted">Magang</div>
                                        <div class="fw-medium">{{ $opsi_kompetensi[$tracer->evaluasiPendidikan->magang] ?? '-' }}</div>
                                    </div>
                                    <div class="col">
                                        <div class="small text-muted">Kerja Lapangan</div>
                                        <div class="fw-medium">{{ $opsi_kompetensi[$tracer->evaluasiPendidikan->kerja_lapangan] ?? '-' }}</div>
                                    </div>
                                    <div class="col">
                                        <div class="small text-muted">Diskusi</div>
                                        <div class="fw-medium">{{ $opsi_kompetensi[$tracer->evaluasiPendidikan->diskusi] ?? '-' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif



                <!-- SARAN DAN MASUKAN -->
                @if ($tracer->saran)
                    <div class="col-12">
                        <div class="border-0 shadow-sm card">
                            <div class="card-body">
                                <h5 class="mb-3 fw-bold">
                                    <i class="fas fa-comment-dots text-info me-2"></i>Saran dan Masukan
                                </h5>
                                <div class="p-3 rounded bg-light">
                                    <p class="mb-0">{{ $tracer->saran }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- INFO TIMESTAMP -->
                <div class="col-12">
                    <div class="border-0 card bg-light">
                        <div class="py-3 card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <i class="fas fa-calendar-plus me-1"></i>
                                    Dibuat: {{ $tracer->created_at->format('d F Y, H:i') }}
                                </small>
                                <small class="text-muted">
                                    <i class="fas fa-calendar-edit me-1"></i>
                                    Diperbarui: {{ $tracer->updated_at->format('d F Y, H:i') }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Custom CSS -->
        <style>
            .card {
                transition: all 0.2s ease;
                border-radius: 10px;
            }

            .card:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;
            }

            .card-body {
                padding: 1.5rem;
            }

            .text-muted {
                font-size: 0.875rem;
                font-weight: 500;
            }

            .fw-medium {
                font-weight: 500;
                font-size: 1rem;
                color: #2c3e50;
            }

            .badge {
                font-size: 0.8rem;
                padding: 0.5rem 0.8rem;
            }

            h5.fw-bold {
                color: #2c3e50;
                border-bottom: 2px solid #e9ecef;
                padding-bottom: 0.5rem;
            }

            h6.fw-semibold {
                margin-top: 1.5rem;
                padding-left: 1rem;
                border-left: 3px solid #007bff;
            }
        </style>

    </main>
@endsection
