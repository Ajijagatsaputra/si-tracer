@extends('layout')

@section('content')
    @include('components.navbar')

    <main id="main-container" class="mt-4">
        <!-- Hero Section -->
        <div class="bg-body-light border-bottom">
            <div class="content py-4">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                    <div class="animate-fade-in">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-alt mb-2">
                                <li class="breadcrumb-item"><a class="link-fx" href="{{ route('home') }}">Dashboard</a></li>
                                <li class="breadcrumb-item" aria-current="page text-primary">Detail Tracer</li>
                            </ol>
                        </nav>
                        <h1 class="h3 fw-bold mb-1 text-dark">Laporan Tracer Study</h1>
                        <p class="text-muted mb-0 small"><i class="fas fa-info-circle me-1"></i> Data historis kontribusi alumni untuk universitas</p>
                    </div>
                    <div class="d-flex gap-2 animate-fade-in">
                        <a href="{{ route('home') }}" class="btn btn-white shadow-sm border-0 rounded-pill px-4">
                            <i class="fas fa-arrow-left me-2 text-muted"></i>Kembali
                        </a>
                        <a href="{{ route('new-tracer.edit') }}" class="btn btn-primary shadow-sm rounded-pill px-4">
                            <i class="fas fa-edit me-2"></i>Edit Data
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="content py-5">
            <div class="row g-4 justify-content-center">
                
                <!-- SUMMARY STATS CARD -->
                <div class="col-12 animate-fade-in">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-2">
                        <div class="card-body p-0">
                            <div class="row g-0">
                                <div class="col-md-4 bg-primary p-4 text-white d-flex flex-column justify-content-center">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="bg-white bg-opacity-20 p-2 rounded-3 me-3">
                                            <i class="fas fa-user-graduate fa-2x"></i>
                                        </div>
                                        <div>
                                            <h5 class="mb-0 text-white-50 small fw-bold">PROFIL KOMPLIT</h5>
                                            <div class="fs-4 fw-bold">{{ $tracer->nama }}</div>
                                        </div>
                                    </div>
                                    <div class="mt-2 pt-2 border-top border-white border-opacity-20">
                                        <span class="badge bg-white text-primary px-3 py-2 rounded-pill fw-bold">
                                            @php
                                                $status_labels = [
                                                    'bekerja_full' => 'AKTIF BEKERJA',
                                                    'belum_bekerja' => 'MENCARI OPPORTUNITY',
                                                    'wirausaha' => 'ENTREPRENEUR',
                                                    'lanjutstudy' => 'STUDI LANJUT',
                                                    'tidak' => 'MENCARI KERJA'
                                                ];
                                            @endphp
                                            {{ $status_labels[$tracer->status_pekerjaan] ?? strtoupper($tracer->status_pekerjaan) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-8 p-4">
                                    <div class="row g-4">
                                        <div class="col-sm-4">
                                            <div class="text-muted small fw-bold mb-1"><i class="fas fa-id-card me-1"></i> NIM</div>
                                            <div class="fw-bold fs-5">{{ $tracer->nim ?? '-' }}</div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="text-muted small fw-bold mb-1"><i class="fas fa-university me-1"></i> PROGRAM STUDI</div>
                                            <div class="fw-bold fs-5 text-primary">{{ ucwords(str_replace('_', ' ', $tracer->prodi)) ?? '-' }}</div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="text-muted small fw-bold mb-1"><i class="fas fa-calendar-check me-1"></i> ANGKATAN LULUS</div>
                                            <div class="fw-bold fs-5">{{ $tracer->tahun_lulus ?? '-' }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- MAIN INFO SECTIONS -->
                <div class="col-md-8">
                    <!-- DATA PRIBADI GRID -->
                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                            <h5 class="fw-bold text-dark mb-0"><i class="fas fa-id-badge me-2 text-primary"></i>Informasi Kontak & Domisili</h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-4">
                                <div class="col-md-6 mb-2">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary bg-opacity-10 p-2 rounded-circle me-3">
                                            <i class="fas fa-envelope text-primary"></i>
                                        </div>
                                        <div>
                                            <div class="text-muted xsmall">Email Aktif</div>
                                            <div class="fw-bold">{{ $tracer->email ?? '-' }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-success bg-opacity-10 p-2 rounded-circle me-3">
                                            <i class="fab fa-whatsapp text-success"></i>
                                        </div>
                                        <div>
                                            <div class="text-muted xsmall">WhatsApp</div>
                                            <div class="fw-bold">{{ $tracer->no_hp ?? '-' }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mt-2">
                                    <div class="d-flex">
                                        <div class="bg-warning bg-opacity-10 p-2 rounded-circle me-3">
                                            <i class="fas fa-map-marker-alt text-warning"></i>
                                        </div>
                                        <div>
                                            <div class="text-muted xsmall">Alamat Domisili Sekarang</div>
                                            <div class="fw-bold">{{ $tracer->alamat ?? '-' }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- KARIR SECTION -->
                    @if ($tracer->status_pekerjaan === 'bekerja_full' && $tracer->pekerjaan)
                        <div class="card border-0 shadow-sm rounded-4 border-start border-4 border-success mb-4 animate-fade-in">
                            <div class="card-header bg-white border-0 pt-4 px-4 pb-0 d-flex justify-content-between">
                                <h5 class="fw-bold text-dark mb-0"><i class="fas fa-briefcase me-2 text-success"></i>Pengalaman Kerja</h5>
                                <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">Sudah Bekerja</span>
                            </div>
                            <div class="card-body p-4">
                                <div class="row g-4">
                                    <div class="col-md-12">
                                        <div class="p-4 bg-light rounded-4">
                                            <div class="row items-push">
                                                <div class="col-md-6">
                                                    <div class="text-muted small">Instansi / Perusahaan</div>
                                                    <div class="fw-bold fs-5 mt-1">{{ $tracer->pekerjaan->nama_perusahaan ?? '-' }}</div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="text-muted small">Posisi / Jabatan</div>
                                                    <div class="fw-bold fs-5 mt-1 text-primary">{{ $tracer->pekerjaan->jabatan ?? '-' }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="text-muted small mb-1">Mulai Kerja</div>
                                        <div class="fw-bold">{{ $tracer->pekerjaan->mendapatkan_pekerjaan === '<=6bulan' ? '≤ 6 Bulan Pasca Lulus' : '> 6 Bulan Pasca Lulus' }}</div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="text-muted small mb-1">Rentang Gaji</div>
                                        <div class="fw-bold text-success">{{ $tracer->pekerjaan->pendapatan ? 'Rp ' . number_format($tracer->pekerjaan->pendapatan, 0, ',', '.') : '-' }}</div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="text-muted small mb-1">Kesesuaian Bidang</div>
                                        <div class="fw-bold text-info">
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
                        </div>
                    @elseif ($tracer->status_pekerjaan === 'wirausaha' && $tracer->wirausaha)
                        <!-- WIRAUSAHA UI REIMAGINED -->
                        <div class="card border-0 shadow-sm rounded-4 border-start border-4 border-warning mb-4 animate-fade-in">
                            <div class="card-header bg-white border-0 pt-4 px-4 pb-0 d-flex justify-content-between">
                                <h5 class="fw-bold text-dark mb-0"><i class="fas fa-rocket me-2 text-warning"></i>Usaha Mandiri</h5>
                                <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3">Wirausaha</span>
                            </div>
                            <div class="card-body p-4">
                                <div class="bg-warning bg-opacity-5 p-4 rounded-4 mb-4">
                                    <div class="text-muted small">Nama Produk/Usaha</div>
                                    <h2 class="h4 fw-bold text-warning mb-0 mt-1">{{ $tracer->wirausaha->nama_usaha ?? '-' }}</h2>
                                </div>
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="text-muted small">Posisi Owner</div>
                                        <div class="fw-bold">{{ ucfirst($tracer->wirausaha->posisi_usaha) ?? '-' }}</div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="text-muted small">Omzet Per Bulan</div>
                                        <div class="fw-bold text-success">{{ $tracer->wirausaha->pendapatan_usaha ? 'Rp ' . number_format($tracer->wirausaha->pendapatan_usaha, 0, ',', '.') : '-' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- KOMPETENSI SECTION -->
                    @if ($tracer->kompetensi)
                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                                <h5 class="fw-bold text-dark mb-0"><i class="fas fa-chart-line me-2 text-info"></i>Evaluasi Kompetensi</h5>
                            </div>
                            <div class="card-body p-4">
                                <div class="table-responsive">
                                    <table class="table table-borderless table-vcenter">
                                        <thead>
                                            <tr class="bg-light">
                                                <th class="rounded-start">Aspek Kompetensi</th>
                                                <th class="text-center">Saat Lulus</th>
                                                <th class="text-center rounded-end">Saat Ini</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $kompetensi_rows = [
                                                    ['Etika', 'etika_awal', 'etika_sekarang'],
                                                    ['Keahlian Bidang', 'keahlian_awal', 'keahlian_sekarang'],
                                                    ['Bahasa Inggris', 'bahasa_inggris_awal', 'bahasa_inggris_sekarang'],
                                                    ['Teknologi Informasi', 'teknologi_awal', 'teknologi_sekarang'],
                                                    ['Kerjasama Tim', 'kerjasama_awal', 'kerjasama_sekarang'],
                                                    ['Komunikasi', 'komunikasi_awal', 'komunikasi_sekarang']
                                                ];

                                                function getStars($rating) {
                                                    $map = ['sangat_baik' => 5, 'baik' => 4, 'cukup' => 3, 'kurang_baik' => 2, 'tidak_baik' => 1];
                                                    $count = $map[$rating] ?? 0;
                                                    $html = '';
                                                    for($i=1; $i<=5; $i++) {
                                                        $html .= '<i class="fa fa-star '.($i<=$count ? 'text-warning' : 'text-muted opacity-25').' fs-xs"></i>';
                                                    }
                                                    return $html;
                                                }
                                            @endphp
                                            @foreach($kompetensi_rows as $row)
                                                <tr>
                                                    <td class="fw-medium text-dark">{{ $row[0] }}</td>
                                                    <td class="text-center small">{!! getStars($tracer->kompetensi->{$row[1]}) !!}</td>
                                                    <td class="text-center small">{!! getStars($tracer->kompetensi->{$row[2]}) !!}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- SIDEBAR INFO -->
                <div class="col-md-4">
                    <!-- TIMESTAMPS CARD -->
                    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                        <div class="card-body p-0">
                            <div class="bg-dark p-4 text-white">
                                <h6 class="fw-bold mb-0 text-white-50"><i class="fas fa-history me-2"></i>History Pengisian</h6>
                            </div>
                            <div class="p-4">
                                <div class="d-flex align-items-center mb-4">
                                    <div class="bg-primary bg-opacity-10 p-2 rounded-3 me-3">
                                        <i class="fas fa-plus-circle text-primary"></i>
                                    </div>
                                    <div>
                                        <div class="text-muted xsmall">Data Dibuat Pada</div>
                                        <div class="fw-bold small">{{ $tracer->created_at->format('d F Y') }}</div>
                                        <div class="text-muted xsmall">{{ $tracer->created_at->format('H:i') }} WIB</div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="bg-info bg-opacity-10 p-2 rounded-3 me-3">
                                        <i class="fas fa-sync text-info"></i>
                                    </div>
                                    <div>
                                        <div class="text-muted xsmall">Terakhir Diperbarui</div>
                                        <div class="fw-bold small">{{ $tracer->updated_at->format('d F Y') }}</div>
                                        <div class="text-muted xsmall">{{ $tracer->updated_at->format('H:i') }} WIB</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SARAN CARD -->
                    @if ($tracer->saran)
                        <div class="card border-0 shadow-sm rounded-4 bg-primary text-white mb-4">
                            <div class="card-body p-4">
                                <h6 class="fw-bold mb-3 d-flex align-items-center">
                                    <i class="fas fa-quote-left me-2 text-white-50"></i>Saran Untuk Kampus
                                </h6>
                                <p class="mb-0 fs-sm font-italic border-start border-white border-opacity-20 ps-3">
                                    "{{ $tracer->saran }}"
                                </p>
                            </div>
                        </div>
                    @endif

                    <!-- UNI CARD -->
                    <div class="card border-0 shadow-sm rounded-4 bg-light text-center p-4">
                        <div class="mb-3">
                            <img src="{{ asset('assets/media/favicons/logo.png') }}" class="img-fluid" style="width: 60px;">
                        </div>
                        <h6 class="fw-bold mb-1">Universitas Harkat Negeri</h6>
                        <p class="text-muted xsmall mb-0">Tracer Study & Alumni Center</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <style>
        body {
            background-color: #f8fafc;
        }
        .wizard-header h1 {
            letter-spacing: -1px;
        }
        .card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.05) !important;
        }
        .xsmall {
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            font-weight: 700;
        }
        .font-italic {
            font-style: italic;
        }
        .table-vcenter td, .table-vcenter th {
            vertical-align: middle;
        }
        .fs-xs {
            font-size: 0.7rem;
        }
        .breadcrumb-alt .breadcrumb-item + .breadcrumb-item::before {
            content: "\f105";
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
        }
    </style>
@endsection
