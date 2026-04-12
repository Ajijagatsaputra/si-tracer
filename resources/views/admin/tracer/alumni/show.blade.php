@extends('layouts.admin')

@section('content')
    <!-- Premium Hero Section -->
    <div class="card card-modern border-0 shadow-lg mb-4 overflow-hidden" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);">
        <div class="card-body p-4 p-md-5 position-relative">
            <div class="row align-items-center">
                <div class="col-md-auto mb-4 mb-md-0 position-relative" style="z-index: 2;">
                    <div class="avatar-container position-relative">
                        <div class="avatar-placeholder bg-white-20 text-white fw-bold shadow-lg rounded-circle d-flex align-items-center justify-content-center" style="width: 100px; height: 100px; font-size: 2.5rem; backdrop-filter: blur(10px); border: 4px solid rgba(255,255,255,0.2);">
                            {{ strtoupper(substr($tracerStudy->nama, 0, 1)) }}
                        </div>
                        <span class="position-absolute bottom-0 end-0 badge rounded-pill bg-success border border-2 border-white p-2 shadow-sm" title="Verified Alumni">
                            <i class="fa fa-badge-check"></i>
                        </span>
                    </div>
                </div>
                <div class="col-md position-relative" style="z-index: 2;">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-2 fs-xs text-white-50 text-uppercase fw-bold ls-wide">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-white-50">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('listtraceralumni.index') }}" class="text-white-50">Tracer Alumni</a></li>
                            <li class="breadcrumb-item active text-white">Detail Profile</li>
                        </ol>
                    </nav>
                    <h1 class="display-6 fw-bold text-white mb-1">{{ $tracerStudy->nama }}</h1>
                    <div class="d-flex flex-wrap gap-2 mt-2">
                        <span class="badge bg-white-20 text-white rounded-pill px-3 py-2 border border-white-25 fs-xs">
                            <i class="fa fa-id-card me-1 opacity-75"></i> {{ $tracerStudy->nim }}
                        </span>
                        <span class="badge bg-white-20 text-white rounded-pill px-3 py-2 border border-white-25 fs-xs">
                            <i class="fa fa-graduation-cap me-1 opacity-75"></i> Angkatan {{ $tracerStudy->tahun_lulus }}
                        </span>
                    </div>
                </div>
                <div class="col-md-auto text-md-end mt-4 mt-md-0 position-relative" style="z-index: 2;">
                    <div class="d-flex gap-2">
                        <a href="{{ route('listtraceralumni.index') }}" class="btn btn-white-20 text-white px-4 rounded-pill border border-white-25">
                            <i class="fa fa-arrow-left me-2"></i>Kembali
                        </a>
                        <a href="{{ route('listtraceralumni.edit', $tracerStudy->id) }}" class="btn btn-warning px-4 rounded-pill shadow-sm fw-bold">
                            <i class="fa fa-edit me-2"></i>Edit Data
                        </a>
                    </div>
                </div>
            </div>
            <!-- Decorative Elements -->
            <div class="position-absolute top-0 end-0 p-5 mt-n4 me-n4 opacity-10">
                <i class="fa fa-user-graduate fa-10x text-white"></i>
            </div>
        </div>
    </div>

    <div class="content content-full">
        <div class="row g-4">
            <!-- Left Sidebar Info -->
            <div class="col-xl-4">
                <!-- Personal Info Card -->
                <div class="card card-modern border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold text-dark mb-4 pb-2 border-bottom d-flex align-items-center">
                            <div class="icon-circle-sm bg-primary-light text-primary me-2"><i class="fa fa-user"></i></div>
                            Kontak & Identitas
                        </h5>
                        <div class="space-y-4">
                            <div class="info-group">
                                <label class="text-uppercase text-muted fw-bold ls-wide" style="font-size: 0.65rem;">Email Address</label>
                                <div class="fw-bold text-dark">{{ $tracerStudy->email ?? '-' }}</div>
                            </div>
                            <div class="info-group">
                                <label class="text-uppercase text-muted fw-bold ls-wide" style="font-size: 0.65rem;">WhatsApp / Phone</label>
                                <div class="fw-bold text-dark d-flex align-items-center">
                                    <i class="fab fa-whatsapp text-success me-2"></i> {{ $tracerStudy->no_hp ?? '-' }}
                                </div>
                            </div>
                            <div class="info-group">
                                <label class="text-uppercase text-muted fw-bold ls-wide" style="font-size: 0.65rem;">Program Studi</label>
                                <div class="d-inline-block px-3 py-1 rounded-pill bg-primary-light text-primary fw-bold fs-xs border border-primary-10">
                                    {{ ucwords(str_replace('_', ' ', $tracerStudy->prodi)) }}
                                </div>
                            </div>
                            <div class="info-group">
                                <label class="text-uppercase text-muted fw-bold ls-wide" style="font-size: 0.65rem;">Home Address</label>
                                <div class="text-dark small lh-base">{{ $tracerStudy->alamat ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status Card -->
                <div class="card card-modern border-0 shadow-sm overflow-hidden">
                    <div class="card-body p-4">
                        <h5 class="fw-bold text-dark mb-4 pb-2 border-bottom d-flex align-items-center">
                            <div class="icon-circle-sm bg-success-light text-success me-2"><i class="fa fa-star"></i></div>
                            Status Tracer
                        </h5>
                        @php
                            $status_labels = [
                                'bekerja_full' => ['label' => 'Bekerja', 'color' => 'success', 'icon' => 'fa-briefcase'],
                                'belum_bekerja' => ['label' => 'Belum Bekerja', 'color' => 'danger', 'icon' => 'fa-clock'],
                                'wirausaha' => ['label' => 'Wirausaha', 'color' => 'warning', 'icon' => 'fa-store'],
                                'lanjutstudy' => ['label' => 'Studi Lanjut', 'color' => 'info', 'icon' => 'fa-graduation-cap'],
                                'tidak' => ['label' => 'Mencari Kerja', 'color' => 'secondary', 'icon' => 'fa-search'],
                            ];
                            $current = $status_labels[$tracerStudy->status_pekerjaan] ?? ['label' => $tracerStudy->status_pekerjaan, 'color' => 'primary', 'icon' => 'fa-circle'];
                        @endphp
                        <div class="text-center p-4 rounded-4 bg-light border border-white mb-3">
                            <div class="icon-circle bg-{{ $current['color'] }} text-white mx-auto mb-3 shadow" style="width: 60px; height: 60px;">
                                <i class="fa {{ $current['icon'] }} fa-lg"></i>
                            </div>
                            <div class="h5 fw-bold text-dark mb-1">{{ $current['label'] }}</div>
                            <div class="text-muted small">Update terakhir: {{ $tracerStudy->updated_at?->format('d M Y') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Content Area -->
            <div class="col-xl-8">
                <!-- Data Detail Berdasarkan Status -->
                @if ($tracerStudy->status_pekerjaan === 'bekerja_full' && $tracerStudy->pekerjaan)
                    <div class="card card-modern border-0 shadow-sm border-start border-4 border-success mb-4">
                        <div class="card-body p-4">
                            <h5 class="fw-bold text-dark mb-4 pb-2 border-bottom">
                                <i class="fa fa-briefcase text-success me-2"></i>Profesional Detail
                            </h5>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="p-3 rounded-4 bg-light-soft border">
                                        <label class="text-uppercase text-muted fw-bold ls-wide mb-1" style="font-size: 0.6rem;">Company</label>
                                        <div class="h5 fw-bold text-dark mb-0">{{ $tracerStudy->pekerjaan->nama_perusahaan ?? '-' }}</div>
                                        <div class="text-primary fw-semibold small">{{ $tracerStudy->pekerjaan->jabatan ?? '-' }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="p-3 rounded-4 bg-light-soft border">
                                        <label class="text-uppercase text-muted fw-bold ls-wide mb-1" style="font-size: 0.6rem;">Monthly Income</label>
                                        <div class="h5 fw-bold text-success mb-0">
                                            {{ $tracerStudy->pekerjaan->pendapatan ? 'Rp ' . number_format($tracerStudy->pekerjaan->pendapatan, 0, ',', '.') : '-' }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label class="text-uppercase text-muted fw-bold ls-wide mb-1" style="font-size: 0.6rem;">Location</label>
                                            <div class="fw-semibold text-dark small"><i class="fa fa-map-marker-alt text-danger me-1"></i>{{ $tracerStudy->pekerjaan->alamat_pekerjaan ?? '-' }}</div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="text-uppercase text-muted fw-bold ls-wide mb-1" style="font-size: 0.6rem;">Mulai Bekerja</label>
                                            <div class="fw-semibold text-dark small">{{ $tracerStudy->pekerjaan->mendapatkan_pekerjaan === '<=6bulan' ? '< 6 Bulan' : '> 6 Bulan' }}</div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="text-uppercase text-muted fw-bold ls-wide mb-1" style="font-size: 0.6rem;">Hubungan Studi</label>
                                            <span class="badge bg-success-light text-success border border-success-10 rounded-pill">{{ ucwords(str_replace('_', ' ', $tracerStudy->pekerjaan->hubungan_studi_pekerjaan)) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif ($tracerStudy->status_pekerjaan === 'wirausaha' && $tracerStudy->wirausaha)
                    <div class="card card-modern border-0 shadow-sm border-start border-4 border-warning mb-4">
                        <div class="card-body p-4">
                            <h5 class="fw-bold text-dark mb-4 pb-2 border-bottom">
                                <i class="fa fa-store text-warning me-2"></i>Business Detail
                            </h5>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="p-3 rounded-4 bg-light-soft border">
                                        <label class="text-uppercase text-muted fw-bold ls-wide mb-1" style="font-size: 0.6rem;">Business Name</label>
                                        <div class="h5 fw-bold text-dark mb-0 text-warning">{{ $tracerStudy->wirausaha->nama_usaha ?? '-' }}</div>
                                        <div class="text-muted fw-semibold small">{{ ucfirst($tracerStudy->wirausaha->posisi_usaha) }}</div>
                                    </div>
                                </div>
                                @if($tracerStudy->wirausaha->pendapatan_usaha)
                                <div class="col-md-6">
                                    <div class="p-3 rounded-4 bg-light-soft border">
                                        <label class="text-uppercase text-muted fw-bold ls-wide mb-1" style="font-size: 0.6rem;">Income</label>
                                        <div class="h5 fw-bold text-warning mb-0">Rp {{ number_format($tracerStudy->wirausaha->pendapatan_usaha, 0, ',', '.') }}</div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Kompetensi Sections -->
                @if (isset($tracerStudy->kompetensi))
                    <div class="card card-modern border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <h5 class="fw-bold text-dark mb-4 pb-2 border-bottom">
                                <i class="fa fa-chart-line text-info me-2"></i>Analysis Kompetensi Alumni
                            </h5>
                            <div class="row g-4">
                                @php
                                    $fields = ['etika', 'keahlian', 'bahasa_inggris', 'teknologi', 'kerjasama', 'komunikasi'];
                                    $renderStars = function($val) {
                                        $map = ['sangat_baik' => 5, 'baik' => 4, 'cukup' => 3, 'kurang_baik' => 2, 'tidak_baik' => 1];
                                        $n = $map[$val] ?? 0;
                                        $html = '';
                                        for($i=1; $i<=5; $i++) $html .= '<i class="fa fa-star '.($i <= $n ? 'text-warning' : 'text-muted opacity-25').' fs-xs"></i>';
                                        return $html;
                                    };
                                @endphp
                                @foreach($fields as $f)
                                    <div class="col-md-6">
                                        <div class="p-3 rounded-4 bg-light border-0 shadow-sm">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <span class="fw-bold text-muted small text-uppercase">{{ str_replace('_', ' ', $f) }}</span>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="small text-muted">Awal: {!! $renderStars($tracerStudy->kompetensi->{$f.'_awal'}) !!}</div>
                                                <div class="small text-muted">Skrg: {!! $renderStars($tracerStudy->kompetensi->{$f.'_sekarang'}) !!}</div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
                
                <div class="text-center mt-5 mb-4 d-print-none">
                    <button onclick="window.print()" class="btn btn-outline-primary px-5 rounded-pill shadow-sm">
                        <i class="fa fa-print me-2"></i>Cetak Laporan Lengkap
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .ls-wide { letter-spacing: 0.05em; }
        .bg-white-20 { background: rgba(255,255,255,0.2); }
        .bg-white-10 { background: rgba(255,255,255,0.1); }
        .border-white-25 { border-color: rgba(255,255,255,0.25) !important; }
        .bg-primary-light { background-color: rgba(59, 130, 246, 0.08); }
        .bg-success-light { background-color: rgba(16, 185, 129, 0.08); }
        .bg-light-soft { background-color: #fcfcfd; }
        .icon-circle-sm { width: 32px; height: 32px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 0.8rem; }
        .avatar-placeholder { text-shadow: 0 2px 10px rgba(0,0,0,0.2); }
        
        .space-y-4 > * + * { margin-top: 1.25rem; }
        
        @media print {
            .btn, footer, .sidebar, .header, .d-print-none { display: none !important; }
            .content { padding: 0 !important; }
            .card { box-shadow: none !important; border: 1px solid #eee !important; }
        }
        
        .btn-white-20 { 
            background: rgba(255,255,255,0.15); 
            transition: all 0.3s ease;
        }
        .btn-white-20:hover { 
            background: rgba(255,255,255,0.25);
            color: #fff;
        }
    </style>
@endsection
