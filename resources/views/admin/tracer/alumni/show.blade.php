@extends('layouts.admin')

@section('content')
    <div class="container py-5 px-3 px-md-4">
        <!-- HEADER -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="h3 fw-bold text-primary mb-1">
                    <i class="bi bi-person-badge me-2"></i>Detail Tracer Study Alumni
                </h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('listtraceralumni.index') }}">Tracer Alumni</a></li>
                        <li class="breadcrumb-item active">Detail</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('listtraceralumni.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i>Kembali
                </a>
                <a href="{{ route('listtraceralumni.edit', $tracerStudy->id) }}" class="btn btn-warning">
                    <i class="bi bi-pencil me-1"></i>Edit
                </a>
            </div>
        </div>

        <!-- BASIC INFO CARD -->
        <div class="col-12 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-user text-primary me-2"></i>Informasi Pribadi
                    </h5>
                    <div class="row row-cols-1 row-cols-md-3 g-4">
                        <div class="col">
                            <div class="small text-muted">Nama Lengkap</div>
                            <div class="fw-medium">{{ $tracerStudy->nama ?? '-' }}</div>
                        </div>
                        <div class="col">
                            <div class="small text-muted">Email</div>
                            <div class="fw-medium">{{ $tracerStudy->email ?? '-' }}</div>
                        </div>
                        <div class="col">
                            <div class="small text-muted">No. HP</div>
                            <div class="fw-medium">{{ $tracerStudy->no_hp ?? '-' }}</div>
                        </div>
                        <div class="col">
                            <div class="small text-muted">NIM</div>
                            <div class="fw-medium">{{ $tracerStudy->nim ?? '-' }}</div>
                        </div>
                        <div class="col">
                            <div class="small text-muted">Program Studi</div>
                            <div class="fw-medium">{{ ucwords(str_replace('_', ' ', $tracerStudy->prodi)) ?? '-' }}</div>
                        </div>
                        <div class="col">
                            <div class="small text-muted">Tahun Lulus</div>
                            <div class="fw-medium">{{ $tracerStudy->tahun_lulus ?? '-' }}</div>
                        </div>
                        <div class="col-12">
                            <div class="small text-muted">Alamat</div>
                            <div class="fw-medium">{{ $tracerStudy->alamat ?? '-' }}</div>
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
                                <span class="badge bg-{{ $tracerStudy->status_pekerjaan === 'bekerja_full' ? 'success' : ($tracerStudy->status_pekerjaan === 'wirausaha' ? 'warning' : ($tracerStudy->status_pekerjaan === 'lanjutstudy' ? 'info' : 'secondary')) }}">
                                    {{ $status_labels[$tracerStudy->status_pekerjaan] ?? $tracerStudy->status_pekerjaan }}
                                </span>
                            </div>
                        </div>
                        <div class="col">
                            <div class="small text-muted">Tanggal Pengisian</div>
                            <div class="fw-medium">{{ $tracerStudy->tanggal_isi?->format('d F Y') ?? '-' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- DETAIL BASED ON STATUS -->
        @if ($tracerStudy->status_pekerjaan === 'bekerja_full' && $tracerStudy->pekerjaan)
                    <div class="col-12 mb-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <h5 class="fw-bold mb-3">
                                    <i class="fas fa-briefcase text-success me-2"></i>Detail Pekerjaan
                                </h5>
                                <div class="row row-cols-1 row-cols-md-3 g-4">
                                    <div class="col">
                                        <div class="small text-muted">Mendapatkan Pekerjaan</div>
                                        <div class="fw-medium">
                                            {{ $tracerStudy->pekerjaan->mendapatkan_pekerjaan === '<=6bulan' ? 'Sebelum 6 bulan sejak lulus' : 'Setelah 6 bulan sejak lulus' }}
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="small text-muted">Waktu Mendapat Kerja</div>
                                        <div class="fw-medium">{{ $tracerStudy->pekerjaan->bulan_kerja ?? '-' }} bulan</div>
                                    </div>
                                    <div class="col">
                                        <div class="small text-muted">Pendapatan</div>
                                        <div class="fw-medium">
                                            {{ $tracerStudy->pekerjaan->pendapatan ? 'Rp ' . number_format($tracerStudy->pekerjaan->pendapatan, 0, ',', '.') : '-' }}
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="small text-muted">Nama Perusahaan</div>
                                        <div class="fw-medium">{{ $tracerStudy->pekerjaan->nama_perusahaan ?? '-' }}</div>
                                    </div>
                                    <div class="col">
                                        <div class="small text-muted">Jabatan</div>
                                        <div class="fw-medium">{{ $tracerStudy->pekerjaan->jabatan ?? '-' }}</div>
                                    </div>
                                    <div class="col">
                                        <div class="small text-muted">Provinsi</div>
                                        <div class="fw-medium">
                                            {{ \Laravolt\Indonesia\Models\Province::where('code', $tracerStudy->pekerjaan?->provinsi)->first()?->name ?? '-' }}
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="small text-muted">Kota</div>
                                        <div class="fw-medium">
                                            {{ \Laravolt\Indonesia\Models\City::where('code', $tracerStudy->pekerjaan?->kota)->first()?->name ?? '-' }}

                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="small text-muted">Tingkat Usaha</div>
                                        <div class="fw-medium">
                                            @php
                                                $tingkatUsaha = $tracerStudy->pekerjaan->tingkat_usaha_level ?? '-';
                                                if ($tingkatUsaha !== '-' && $tingkatUsaha !== null) {
                                                    $tingkatUsaha = ucwords(str_replace('_', ' ', $tingkatUsaha));
                                                }
                                            @endphp
                                            {{ $tingkatUsaha }}
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="small text-muted">Alamat Pekerjaan</div>
                                        <div class="fw-medium">{{ $tracerStudy->pekerjaan->alamat_pekerjaan ?? '-' }}</div>
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
                                            {{ $hubungan_labels[$tracerStudy->pekerjaan->hubungan_studi_pekerjaan] ?? '-' }}
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
                                            {{ $pendidikan_labels[$tracerStudy->pekerjaan->pendidikan_sesuai_pekerjaan] ?? '-' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif ($tracerStudy->status_pekerjaan === 'wirausaha' && $tracerStudy->wirausaha)
                    <div class="col-12 mb-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <h5 class="fw-bold mb-3">
                                    <i class="fas fa-store text-warning me-2"></i>Detail Wirausaha
                                </h5>
                                <div class="row row-cols-1 row-cols-md-3 g-4">
                                    <div class="col">
                                        <div class="small text-muted">Nama Usaha</div>
                                        <div class="fw-medium">{{ $tracerStudy->wirausaha->nama_usaha ?? '-' }}</div>
                                    </div>
                                    <div class="col">
                                        <div class="small text-muted">Posisi Usaha</div>
                                        <div class="fw-medium">{{ ucfirst($tracerStudy->wirausaha->posisi_usaha) ?? '-' }}</div>
                                    </div>
                                    <div class="col">
                                        <div class="small text-muted">Tingkat Usaha</div>
                                        <div class="fw-medium">
                                            @php
                                                $tingkatUsaha = $tracerStudy->wirausaha->tingkat_usaha_level ?? '-';
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
                                            {{ $tracerStudy->wirausaha->pendapatan_usaha ? 'Rp ' . number_format($tracerStudy->wirausaha->pendapatan_usaha, 0, ',', '.') : '-' }}
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="small text-muted">Alamat Usaha</div>
                                        <div class="fw-medium">{{ $tracerStudy->wirausaha->alamat_usaha ?? '-' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif ($tracerStudy->status_pekerjaan === 'lanjutstudy' && $tracerStudy->pendidikan)
                    <div class="col-12 mb-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <h5 class="fw-bold mb-3">
                                    <i class="fas fa-graduation-cap text-info me-2"></i>Detail Pendidikan Lanjut
                                </h5>
                                <div class="row row-cols-1 row-cols-md-3 g-4">
                                    <div class="col">
                                        <div class="small text-muted">Universitas</div>
                                        <div class="fw-medium">{{ $tracerStudy->pendidikan->universitas ?? '-' }}</div>
                                    </div>
                                    <div class="col">
                                        <div class="small text-muted">Program Studi</div>
                                        <div class="fw-medium">{{ $tracerStudy->pendidikan->program_studi ?? '-' }}</div>
                                    </div>
                                    <div class="col">
                                        <div class="small text-muted">Sumber Biaya</div>
                                        <div class="fw-medium">{{ ucwords(str_replace('_', ' ', $tracerStudy->pendidikan->sumber_biaya)) ?? '-' }}</div>
                                    </div>
                                    <div class="col">
                                        <div class="small text-muted">Tanggal Masuk</div>
                                        <div class="fw-medium">{{ $tracerStudy->pendidikan->tanggal_masuk?->format('d F Y') ?? '-' }}</div>
                                    </div>
                                    <div class="col-12">
                                        <div class="small text-muted">Lokasi Universitas</div>
                                        <div class="fw-medium">{{ $tracerStudy->pendidikan->lokasi_universitas ?? '-' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

        <!-- PENCARIAN KERJA & AKTIVITAS -->
        @if (in_array($tracerStudy->status_pekerjaan, ['bekerja_full', 'wirausaha', 'belum_bekerja', 'tidak']) && $tracerStudy->pencarianKerja)
                    <div class="col-12 mb-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <h5 class="fw-bold mb-3">
                                    <i class="fas fa-search text-secondary me-2"></i>Detail Pencarian Kerja
                                </h5>
                                <div class="row row-cols-1 row-cols-md-3 g-4">
                                    @if ($tracerStudy->pencarianKerja->waktu_cari_kerja)
                                        <div class="col">
                                            <div class="small text-muted">Waktu Mulai Cari Kerja</div>
                                            <div class="fw-medium">{{ ucwords(str_replace('_', ' ', $tracerStudy->pencarianKerja->waktu_cari_kerja)) }}</div>
                                        </div>
                                    @endif
                                    @if ($tracerStudy->pencarianKerja->bulan_sebelum_lulus)
                                        <div class="col">
                                            <div class="small text-muted">Bulan Sebelum Lulus</div>
                                            <div class="fw-medium">{{ $tracerStudy->pencarianKerja->bulan_sebelum_lulus }} bulan</div>
                                        </div>
                                    @endif
                                    @if ($tracerStudy->pencarianKerja->bulan_setelah_lulus)
                                        <div class="col">
                                            <div class="small text-muted">Bulan Setelah Lulus</div>
                                            <div class="fw-medium">{{ $tracerStudy->pencarianKerja->bulan_setelah_lulus }} bulan</div>
                                        </div>
                                    @endif
                                    @if ($tracerStudy->pencarianKerja->aktif_cari_kerja_4minggu)
                                        <div class="col">
                                            <div class="small text-muted">Aktif Cari Kerja 4 Minggu Terakhir</div>
                                            <div class="fw-medium">
                                                {{ ucwords(str_replace('_', ' ', $tracerStudy->pencarianKerja->aktif_cari_kerja_4minggu)) }}
                                            </div>
                                        </div>
                                    @endif
                                    @if ($tracerStudy->pencarianKerja->alasan_pekerjaan_tidak_sesuai)
                                        <div class="col">
                                            <div class="small text-muted">Alasan Pekerjaan Tidak Sesuai Pendidikan</div>
                                            <div class="fw-medium">
                                                {{ $tracerStudy->pencarianKerja->alasan_pekerjaan_tidak_sesuai }}
                                            </div>
                                        </div>
                                    @endif
                                    @if ($tracerStudy->pencarianKerja->aktif_cari_kerja)
                                        <div class="col">
                                            <div class="small text-muted">Cara Mencari Pekerjaan</div>
                                            <div class="fw-medium">
                                                {{ $tracerStudy->pencarianKerja->aktif_cari_kerja }}
                                            </div>
                                        </div>
                                    @endif
                                    @if ($tracerStudy->pencarianKerja->jumlah_perusahaan_lamar)
                                        <div class="col">
                                            <div class="small text-muted">Jumlah Perusahaan Dilamar</div>
                                            <div class="fw-medium">{{ $tracerStudy->pencarianKerja->jumlah_perusahaan_lamar }} perusahaan</div>
                                        </div>
                                    @endif
                                    @if ($tracerStudy->pencarianKerja->jumlah_perusahaan_respon)
                                        <div class="col">
                                            <div class="small text-muted">Jumlah Perusahaan Merespon</div>
                                            <div class="fw-medium">{{ $tracerStudy->pencarianKerja->jumlah_perusahaan_respon }} perusahaan</div>
                                        </div>
                                    @endif
                                    @if ($tracerStudy->pencarianKerja->jumlah_perusahaan_wawancara)
                                        <div class="col">
                                            <div class="small text-muted">Jumlah Perusahaan Wawancara</div>
                                            <div class="fw-medium">{{ $tracerStudy->pencarianKerja->jumlah_perusahaan_wawancara }} perusahaan</div>
                                        </div>
                                    @endif
                                    @if ($tracerStudy->pencarianKerja->cara_mencari_kerja)
                                        <div class="col">
                                            <div class="small text-muted">Cara Mencari Kerja (Lainnya)</div>
                                            <div class="fw-medium">{{ $tracerStudy->pencarianKerja->cara_mencari_kerja }}</div>
                                        </div>
                                    @endif
                                    @if ($tracerStudy->pencarianKerja->sumber_informasi)
                                        <div class="col">
                                            <div class="small text-muted">Sumber Informasi</div>
                                            <div class="fw-medium">{{ $tracerStudy->pencarianKerja->sumber_informasi }}</div>
                                        </div>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                @endif

        <!-- KOMPETENSI -->
        @if(isset($tracerStudy->kompetensi))
        <div class="col-12 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-star text-secondary me-2"></i>Kompetensi Alumni
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
                                <h6 class="fw-semibold text-muted mb-3">Kompetensi Saat Awal Lulus</h6>
                                <div class="row row-cols-1 row-cols-md-4 g-3 mb-4">
                                    <div class="col">
                                        <div class="small text-muted">Etika</div>
                                        <div class="fw-medium">{{ $opsi_kompetensi[$tracerStudy->kompetensi->etika_awal] ?? '-' }}</div>
                                    </div>
                                    <div class="col">
                                        <div class="small text-muted">Keahlian</div>
                                        <div class="fw-medium">{{ $opsi_kompetensi[$tracerStudy->kompetensi->keahlian_awal] ?? '-' }}</div>
                                    </div>
                                    <div class="col">
                                        <div class="small text-muted">Bahasa Inggris</div>
                                        <div class="fw-medium">{{ $opsi_kompetensi[$tracerStudy->kompetensi->bahasa_inggris_awal] ?? '-' }}</div>
                                    </div>
                                    <div class="col">
                                        <div class="small text-muted">Teknologi</div>
                                        <div class="fw-medium">{{ $opsi_kompetensi[$tracerStudy->kompetensi->teknologi_awal] ?? '-' }}</div>
                                    </div>
                                    <div class="col">
                                        <div class="small text-muted">Kerja Sama</div>
                                        <div class="fw-medium">{{ $opsi_kompetensi[$tracerStudy->kompetensi->kerjasama_awal] ?? '-' }}</div>
                                    </div>
                                    <div class="col">
                                        <div class="small text-muted">Komunikasi</div>
                                        <div class="fw-medium">{{ $opsi_kompetensi[$tracerStudy->kompetensi->komunikasi_awal] ?? '-' }}</div>
                                    </div>
                                    <div class="col">
                                        <div class="small text-muted">Pengembangan</div>
                                        <div class="fw-medium">{{ $opsi_kompetensi[$tracerStudy->kompetensi->pengembangan_awal] ?? '-' }}</div>
                                    </div>
                                </div>

                                <!-- Kompetensi Sekarang -->
                                <h6 class="fw-semibold text-muted mb-3">Kompetensi Saat Ini</h6>
                                <div class="row row-cols-1 row-cols-md-4 g-3">
                                    <div class="col">
                                        <div class="small text-muted">Etika</div>
                                        <div class="fw-medium">{{ $opsi_kompetensi[$tracerStudy->kompetensi->etika_sekarang] ?? '-' }}</div>
                                    </div>
                                    <div class="col">
                                        <div class="small text-muted">Keahlian</div>
                                        <div class="fw-medium">{{ $opsi_kompetensi[$tracerStudy->kompetensi->keahlian_sekarang] ?? '-' }}</div>
                                    </div>
                                    <div class="col">
                                        <div class="small text-muted">Bahasa Inggris</div>
                                        <div class="fw-medium">{{ $opsi_kompetensi[$tracerStudy->kompetensi->bahasa_inggris_sekarang] ?? '-' }}</div>
                                    </div>
                                    <div class="col">
                                        <div class="small text-muted">Teknologi</div>
                                        <div class="fw-medium">{{ $opsi_kompetensi[$tracerStudy->kompetensi->teknologi_sekarang] ?? '-' }}</div>
                                    </div>
                                    <div class="col">
                                        <div class="small text-muted">Kerja Sama</div>
                                        <div class="fw-medium">{{ $opsi_kompetensi[$tracerStudy->kompetensi->kerjasama_sekarang] ?? '-' }}</div>
                                    </div>
                                    <div class="col">
                                        <div class="small text-muted">Komunikasi</div>
                                        <div class="fw-medium">{{ $opsi_kompetensi[$tracerStudy->kompetensi->komunikasi_sekarang] ?? '-' }}</div>
                                    </div>
                                    <div class="col">
                                        <div class="small text-muted">Pengembangan</div>
                                        <div class="fw-medium">{{ $opsi_kompetensi[$tracerStudy->kompetensi->pengembangan_sekarang] ?? '-' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
        @endif

        @if ($tracerStudy->evaluasiPendidikan)
                    <div class="col-12 mb-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <h5 class="fw-bold mb-3">
                                    <i class="fas fa-graduation-cap text-info me-2"></i>Evaluasi Pendidikan
                                </h5>
                                <div class="row row-cols-1 row-cols-md-4 g-3">
                                    <div class="col">
                                        <div class="small text-muted">Perkuliahan</div>
                                        <div class="fw-medium">{{ $opsi_kompetensi[$tracerStudy->evaluasiPendidikan->perkuliahan] ?? '-' }}</div>
                                    </div>
                                    <div class="col">
                                        <div class="small text-muted">Praktikum</div>
                                        <div class="fw-medium">{{ $opsi_kompetensi[$tracerStudy->evaluasiPendidikan->praktikum] ?? '-' }}</div>
                                    </div>
                                    <div class="col">
                                        <div class="small text-muted">Demonstrasi</div>
                                        <div class="fw-medium">{{ $opsi_kompetensi[$tracerStudy->evaluasiPendidikan->demonstrasi] ?? '-' }}</div>
                                    </div>
                                    <div class="col">
                                        <div class="small text-muted">Riset</div>
                                        <div class="fw-medium">{{ $opsi_kompetensi[$tracerStudy->evaluasiPendidikan->riset] ?? '-' }}</div>
                                    </div>
                                    <div class="col">
                                        <div class="small text-muted">Magang</div>
                                        <div class="fw-medium">{{ $opsi_kompetensi[$tracerStudy->evaluasiPendidikan->magang] ?? '-' }}</div>
                                    </div>
                                    <div class="col">
                                        <div class="small text-muted">Kerja Lapangan</div>
                                        <div class="fw-medium">{{ $opsi_kompetensi[$tracerStudy->evaluasiPendidikan->kerja_lapangan] ?? '-' }}</div>
                                    </div>
                                    <div class="col">
                                        <div class="small text-muted">Diskusi</div>
                                        <div class="fw-medium">{{ $opsi_kompetensi[$tracerStudy->evaluasiPendidikan->diskusi] ?? '-' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                </div>
                </div>





        <!-- SARAN -->
        {{-- <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-warning text-dark py-3">
                <h5 class="mb-0 fw-semibold">
                    <i class="bi bi-chat-dots me-2"></i>Saran & Masukan
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <label class="form-label fw-semibold">Saran</label>
                        <div class="p-3 bg-light rounded">
                            {{ $tracerStudy->saran ?? 'Tidak ada saran yang diberikan.' }}
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>

    @push('styles')
        <style>
            .card {
                border-radius: 0.75rem;
                transition: all 0.3s ease;
            }

            .card:hover {
                transform: translateY(-2px);
                box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
            }

            .card-header {
                border-radius: 0.75rem 0.75rem 0 0 !important;
            }

            .badge {
                font-size: 0.875rem;
                padding: 0.5rem 0.75rem;
            }

            .form-label {
                color: #6c757d;
                font-size: 0.875rem;
                margin-bottom: 0.25rem;
            }

            .bg-light.rounded-circle {
                width: 40px;
                height: 40px;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .breadcrumb-item + .breadcrumb-item::before {
                content: ">";
                color: #6c757d;
            }
        </style>
    @endpush
@endsection
