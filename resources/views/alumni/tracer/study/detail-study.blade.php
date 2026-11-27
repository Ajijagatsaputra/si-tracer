@extends('layout')

@section('content')
    <main id="main-container">
        <!-- Hero Section / Header -->
        <div class="bg-white border-bottom shadow-sm">
            <div class="container py-4">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                    <div>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-2 small fw-medium">
                                <li class="breadcrumb-item"><a class="text-decoration-none text-muted" href="{{ route('home') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active text-primary fw-semibold" aria-current="page">Detail Tracer Study</li>
                            </ol>
                        </nav>
                        <div class="d-flex align-items-center gap-2">
                            <h1 class="h3 fw-bold mb-0 text-dark">Laporan Hasil Tracer Study</h1>
                            <span class="badge bg-success text-white px-3 py-2 rounded-pill shadow-sm" style="font-size: 0.8rem; font-weight: 600;">
                                <i class="fas fa-check-circle me-1"></i> Terverifikasi
                            </span>
                        </div>
                        <p class="text-muted mb-0 small mt-1">Data historis kontribusi alumni untuk pengembangan dan akreditasi universitas</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary rounded-pill px-4 fw-semibold">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                        <a href="{{ route('new-tracer.edit') }}" class="btn btn-primary rounded-pill px-4 fw-semibold shadow-sm">
                            <i class="fas fa-edit me-2"></i>Edit Data
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="container py-4">
            <div class="row g-4">
                
                <!-- MAIN CONTENT (LEFT COLUMN) -->
                <div class="col-lg-8">
                    <!-- HEADER PROFILE CARD -->
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4 position-relative">
                        <div class="card-body p-0">
                            <div class="p-4 bg-primary text-white position-relative" style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%) !important;">
                                <div class="row align-items-center g-3">
                                    <div class="col-auto">
                                        <div class="rounded-circle bg-white text-primary fw-bold d-flex align-items-center justify-content-center shadow" style="width: 70px; height: 70px; font-size: 1.75rem;">
                                            {{ strtoupper(substr($tracer->nama, 0, 2)) }}
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="d-flex align-items-center gap-2 mb-1">
                                            <h3 class="mb-0 text-white fw-bold h4">{{ $tracer->nama }}</h3>
                                        </div>
                                        <div class="text-white-50 small">
                                            <i class="fas fa-id-card me-1"></i> NIM: <strong>{{ $tracer->nim ?? '-' }}</strong> &bull; 
                                            <i class="fas fa-graduation-cap me-1"></i> Angkatan: <strong>{{ $tracer->tahun_lulus ?? '-' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-md-auto">
                                        <span class="badge bg-white text-dark px-3 py-2 rounded-pill fw-bold shadow-sm">
                                            @php
                                                $status_labels = [
                                                    'bekerja_full' => '💼 Bekerja Full Time',
                                                    'belum_bekerja' => '⏳ Belum Bekerja',
                                                    'wirausaha' => '🚀 Wiraswasta / Entrepreneur',
                                                    'lanjutstudy' => '🎓 Lanjut Studi',
                                                    'tidak' => '🔍 Mencari Kerja'
                                                ];
                                            @endphp
                                            {{ $status_labels[$tracer->status_pekerjaan] ?? strtoupper($tracer->status_pekerjaan) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- QUICK METRICS BAR -->
                            <div class="bg-light p-3 border-top">
                                <div class="row text-center g-2">
                                    <div class="col-4 border-end">
                                        <div class="text-muted xsmall fw-bold">PROGRAM STUDI</div>
                                        <div class="fw-bold text-dark text-truncate">{{ ucwords(str_replace('_', ' ', $tracer->prodi)) ?? '-' }}</div>
                                    </div>
                                    <div class="col-4 border-end">
                                        <div class="text-muted xsmall fw-bold">TAHUN LULUS</div>
                                        <div class="fw-bold text-dark">{{ $tracer->tahun_lulus ?? '-' }}</div>
                                    </div>
                                    <div class="col-4">
                                        <div class="text-muted xsmall fw-bold">STATUS KUISIONER</div>
                                        <div class="fw-bold text-success"><i class="fas fa-check-circle me-1"></i>Selesai</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- DATA PRIBADI & KONTAK -->
                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-header bg-white border-0 pt-4 px-4 pb-2">
                            <h5 class="fw-bold text-dark mb-0 d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 p-2 rounded-3 text-primary me-2 d-inline-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                    <i class="fas fa-user-circle text-primary fs-5"></i>
                                </div>
                                Informasi Kontak & Domisili
                            </h5>
                        </div>
                        <div class="card-body p-4 pt-2">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="p-3 border rounded-3 bg-light bg-opacity-50 d-flex align-items-center gap-3">
                                        <div class="bg-primary text-white rounded-3 p-2 d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; flex-shrink: 0;">
                                            <i class="fas fa-envelope fs-5"></i>
                                        </div>
                                        <div>
                                            <div class="text-muted xsmall fw-bold mb-1">Email Aktif</div>
                                            <div class="fw-semibold text-dark">{{ $tracer->email ?? '-' }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="p-3 border rounded-3 bg-light bg-opacity-50 d-flex align-items-center gap-3">
                                        <div class="bg-success text-white rounded-3 p-2 d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; flex-shrink: 0;">
                                            <i class="fab fa-whatsapp fs-5"></i>
                                        </div>
                                        <div>
                                            <div class="text-muted xsmall fw-bold mb-1">WhatsApp / HP</div>
                                            <div class="fw-semibold text-dark">{{ $tracer->no_hp ?? '-' }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="p-3 border rounded-3 bg-light bg-opacity-50 d-flex align-items-center gap-3">
                                        <div class="bg-danger text-white rounded-3 p-2 d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; flex-shrink: 0;">
                                            <i class="fas fa-map-marker-alt fs-5"></i>
                                        </div>
                                        <div>
                                            <div class="text-muted xsmall fw-bold mb-1">Alamat Domisili</div>
                                            <div class="fw-semibold text-dark">{{ $tracer->alamat ?? '-' }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- KARIR / PEKERJAAN SECTION -->
                    @if ($tracer->status_pekerjaan === 'bekerja_full' && $tracer->pekerjaan)
                        <div class="card border-0 shadow-sm rounded-4 mb-4 border-start border-4 border-primary">
                            <div class="card-header bg-white border-0 pt-4 px-4 pb-2 d-flex justify-content-between align-items-center">
                                <h5 class="fw-bold text-dark mb-0 d-flex align-items-center">
                                    <span class="bg-primary bg-opacity-10 p-2 rounded-3 text-primary me-2">
                                        <i class="fas fa-briefcase"></i>
                                    </span>
                                    Pengalaman Pekerjaan Utama
                                </h5>
                                <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2 fw-semibold">Bekerja</span>
                            </div>
                            <div class="card-body p-4 pt-2">
                                <div class="p-3 bg-primary bg-opacity-10 rounded-3 mb-3 border border-primary border-opacity-10">
                                    <div class="row align-items-center">
                                        <div class="col-md-6 mb-2 mb-md-0">
                                            <div class="text-muted xsmall fw-bold">PERUSAHAAN / INSTANSI</div>
                                            <div class="fw-bold fs-5 text-primary">{{ $tracer->pekerjaan->nama_perusahaan ?? '-' }}</div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="text-muted xsmall fw-bold">JABATAN / POSISI</div>
                                            <div class="fw-bold fs-5 text-dark">{{ $tracer->pekerjaan->jabatan ?? '-' }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <div class="p-2 border rounded-3 text-center">
                                            <div class="text-muted xsmall fw-bold">Waktu Tunggu Kerja</div>
                                            <div class="fw-bold text-dark mt-1">{{ $tracer->pekerjaan->mendapatkan_pekerjaan === '<=6bulan' ? '≤ 6 Bulan' : '> 6 Bulan' }}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="p-2 border rounded-3 text-center">
                                            <div class="text-muted xsmall fw-bold">Kisaran Pendapatan</div>
                                            <div class="fw-bold text-success mt-1">{{ $tracer->pekerjaan->pendapatan ? 'Rp ' . number_format($tracer->pekerjaan->pendapatan, 0, ',', '.') : '-' }}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="p-2 border rounded-3 text-center">
                                            <div class="text-muted xsmall fw-bold">Kesesuaian Bidang</div>
                                            <div class="fw-bold text-primary mt-1">
                                                @php
                                                    $hubungan_labels = [
                                                        'sangat_erat' => 'Sangat Erat', 'erat' => 'Erat', 'cukup_erat' => 'Cukup Erat', 'kurang_erat' => 'Kurang Erat', 'tidak_erat' => 'Tidak Erat'
                                                    ];
                                                @endphp
                                                {{ $hubungan_labels[$tracer->pekerjaan->hubungan_studi_pekerjaan] ?? '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- DATA ATASAN -->
                                @if($tracer->pekerjaan->nama_atasan || $tracer->pekerjaan->wa_atasan)
                                    <div class="mt-4 pt-3 border-top">
                                        <h6 class="fw-bold text-muted small text-uppercase mb-3"><i class="fas fa-user-tie me-1"></i> Informasi Atasan Langsung</h6>
                                        <div class="row g-2">
                                            <div class="col-md-6">
                                                <small class="text-muted">Nama Atasan:</small>
                                                <div class="fw-semibold">{{ $tracer->pekerjaan->nama_atasan ?? '-' }} ({{ $tracer->pekerjaan->jabatan_atasan ?? '-' }})</div>
                                            </div>
                                            <div class="col-md-6">
                                                <small class="text-muted">Kontak Atasan:</small>
                                                <div class="fw-semibold">{{ $tracer->pekerjaan->wa_atasan ?? $tracer->pekerjaan->email_atasan ?? '-' }}</div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @elseif ($tracer->status_pekerjaan === 'wirausaha' && $tracer->wirausaha)
                        <!-- WIRAUSAHA SECTION -->
                        <div class="card border-0 shadow-sm rounded-4 mb-4 border-start border-4 border-warning">
                            <div class="card-header bg-white border-0 pt-4 px-4 pb-2 d-flex justify-content-between align-items-center">
                                <h5 class="fw-bold text-dark mb-0 d-flex align-items-center">
                                    <span class="bg-warning bg-opacity-10 p-2 rounded-3 text-warning me-2">
                                        <i class="fas fa-rocket"></i>
                                    </span>
                                    Usaha Mandiri / Business
                                </h5>
                                <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3 py-2 fw-semibold">Wirausaha</span>
                            </div>
                            <div class="card-body p-4 pt-2">
                                <div class="p-3 bg-warning bg-opacity-10 rounded-3 mb-3 border border-warning border-opacity-10">
                                    <div class="text-muted xsmall fw-bold">NAMA USAHA / BISNIS</div>
                                    <div class="fw-bold fs-4 text-dark">{{ $tracer->wirausaha->nama_usaha ?? '-' }}</div>
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="p-3 border rounded-3">
                                            <div class="text-muted xsmall fw-bold">POSISI / PERAN</div>
                                            <div class="fw-bold text-dark">{{ ucfirst($tracer->wirausaha->posisi_usaha) ?? '-' }}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="p-3 border rounded-3">
                                            <div class="text-muted xsmall fw-bold">OMZET / OMSET PER BULAN</div>
                                            <div class="fw-bold text-success">{{ $tracer->wirausaha->pendapatan_usaha ? 'Rp ' . number_format($tracer->wirausaha->pendapatan_usaha, 0, ',', '.') : '-' }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- KOMPETENSI SECTION -->
                    @if ($tracer->kompetensi)
                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-header bg-white border-0 pt-4 px-4 pb-2">
                                <h5 class="fw-bold text-dark mb-0 d-flex align-items-center">
                                    <span class="bg-info bg-opacity-10 p-2 rounded-3 text-info me-2">
                                        <i class="fas fa-chart-bar"></i>
                                    </span>
                                    Evaluasi Kompetensi Alumni
                                </h5>
                            </div>
                            <div class="card-body p-4 pt-2">
                                <div class="table-responsive border rounded-3">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="ps-3">Aspek Kompetensi</th>
                                                <th class="text-center">Saat Lulus</th>
                                                <th class="text-center">Saat Ini</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $kompetensi_rows = [
                                                    ['Etika & Profesionalisme', 'etika_awal', 'etika_sekarang'],
                                                    ['Keahlian Bidang Ilmu', 'keahlian_awal', 'keahlian_sekarang'],
                                                    ['Bahasa Inggris', 'bahasa_inggris_awal', 'bahasa_inggris_sekarang'],
                                                    ['Teknologi Informasi', 'teknologi_awal', 'teknologi_sekarang'],
                                                    ['Kerjasama Tim', 'kerjasama_awal', 'kerjasama_sekarang'],
                                                    ['Komunikasi', 'komunikasi_awal', 'komunikasi_sekarang'],
                                                    ['Pengembangan Diri', 'pengembangan_awal', 'pengembangan_sekarang']
                                                ];

                                                function formatRating($val) {
                                                    if (!$val) return '-';
                                                    if (is_numeric($val)) {
                                                        $n = (int)$val;
                                                        $badgeClass = $n >= 4 ? 'bg-success' : ($n >= 3 ? 'bg-primary' : 'bg-warning');
                                                        return '<span class="badge '.$badgeClass.' px-2 py-1">Skala '.$n.'</span>';
                                                    }
                                                    return '<span class="badge bg-secondary px-2 py-1">'.ucwords(str_replace('_', ' ', $val)).'</span>';
                                                }
                                            @endphp
                                            @foreach($kompetensi_rows as $row)
                                                <tr>
                                                    <td class="ps-3 fw-medium text-dark">{{ $row[0] }}</td>
                                                    <td class="text-center">{!! formatRating($tracer->kompetensi->{$row[1]} ?? null) !!}</td>
                                                    <td class="text-center">{!! formatRating($tracer->kompetensi->{$row[2]} ?? null) !!}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- RIGHT SIDEBAR (SUMMARY & AUDIT TRAIL) -->
                <div class="col-lg-4">
                    <!-- AUDIT TRAIL CARD -->
                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-header bg-white border-0 pt-4 px-4 pb-2">
                            <h6 class="fw-bold text-dark mb-0 d-flex align-items-center">
                                <i class="fas fa-history text-primary me-2 fs-5"></i> Riwayat Pengisian
                            </h6>
                        </div>
                        <div class="card-body p-4 pt-2">
                            <div class="d-flex align-items-center mb-3 p-2 rounded-3 bg-light">
                                <div class="bg-primary text-white p-2 rounded-3 me-3 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; flex-shrink: 0;">
                                    <i class="fas fa-calendar-plus"></i>
                                </div>
                                <div>
                                    <div class="text-muted xsmall fw-bold">PERTAMA KALI DISIMPAN</div>
                                    <div class="fw-semibold text-dark small">{{ $tracer->created_at ? $tracer->created_at->format('d F Y, H:i') . ' WIB' : '-' }}</div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center p-2 rounded-3 bg-light">
                                <div class="bg-info text-white p-2 rounded-3 me-3 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; flex-shrink: 0;">
                                    <i class="fas fa-sync-alt"></i>
                                </div>
                                <div>
                                    <div class="text-muted xsmall fw-bold">TERAKHIR DIPERBARUI</div>
                                    <div class="fw-semibold text-dark small">{{ $tracer->updated_at ? $tracer->updated_at->format('d F Y, H:i') . ' WIB' : '-' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SARAN CARD -->
                    @if ($tracer->saran)
                        <div class="card border-0 shadow-sm rounded-4 mb-4 bg-light">
                            <div class="card-body p-4">
                                <h6 class="fw-bold text-dark mb-2 d-flex align-items-center">
                                    <i class="fas fa-comment-dots text-primary me-2"></i> Saran Untuk Kampus
                                </h6>
                                <p class="mb-0 text-secondary small fst-italic border-start border-3 border-primary ps-3 py-1">
                                    "{{ $tracer->saran }}"
                                </p>
                            </div>
                        </div>
                    @endif

                    <!-- FOOTER KAMPUS CARD -->
                    <div class="card border-0 shadow-sm rounded-4 bg-white text-center p-4">
                        <div class="mb-2">
                            <img src="{{ asset('assets/media/favicons/logo.png') }}" class="img-fluid" style="width: 50px;" alt="Logo Kampus">
                        </div>
                        <h6 class="fw-bold text-dark mb-1">Universitas Harkat Negeri</h6>
                        <p class="text-muted xsmall mb-0">Tracer Study & Alumni Center System</p>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <style>
        body {
            background-color: #f1f5f9;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        #main-container {
            background: #f1f5f9;
        }

        #main-container > .bg-white.border-bottom {
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%) !important;
            border-color: #e2e8f0 !important;
        }

        #main-container .card {
            border: 1px solid #e2e8f0 !important;
            border-radius: 1rem !important;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.045) !important;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        #main-container .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 30px rgba(15, 23, 42, 0.08) !important;
        }

        #main-container .card-header {
            border-radius: 1rem 1rem 0 0;
        }

        #main-container .bg-light {
            background-color: #f8fafc !important;
        }

        #main-container .table thead th {
            color: #475569;
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        #main-container .table tbody tr:last-child td {
            border-bottom: 0;
        }

        .xsmall {
            font-size: 0.7rem;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        @media (max-width: 575.98px) {
            #main-container .container {
                padding-left: 1rem;
                padding-right: 1rem;
            }

            #main-container h1 {
                font-size: 1.35rem;
            }

            #main-container .d-flex.gap-2 > .btn {
                flex: 1;
                padding-left: 0.75rem !important;
                padding-right: 0.75rem !important;
            }
        }
    </style>
@endsection
