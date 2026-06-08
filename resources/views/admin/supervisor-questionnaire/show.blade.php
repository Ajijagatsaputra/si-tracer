@extends('layouts.admin')

@section('content')
    <!-- Hero -->
    <div class="bg-white border-bottom">
        <div class="content content-full py-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <div class="hero-content">
                    <h1 class="h2 fw-bold text-dark mb-2">
                        <i class="fa fa-user-tie text-primary me-2"></i>Detail Evaluasi Atasan
                    </h1>
                    <p class="text-muted mb-0 fs-sm">
                        Laporan lengkap hasil kuesioner yang diisi oleh atasan/supervisor alumni.
                    </p>
                </div>
                <div class="hero-actions d-flex gap-2">
                    <a href="{{ route('admin.supervisor-questionnaire.index') }}" class="btn btn-outline-secondary px-4 rounded-pill shadow-sm">
                        <i class="fa fa-arrow-left me-2"></i>Kembali
                    </a>
                    <a href="{{ route('admin.supervisor-questionnaire.dashboard') }}" class="btn btn-primary px-4 rounded-pill shadow-sm">
                        <i class="fa fa-chart-pie me-2"></i>Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <div class="content content-full">
        <div class="row g-4">
            <div class="col-lg-8">
                <!-- Data Profil Atasan & Alumni -->
                <div class="card card-modern border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4 pb-2 border-bottom">
                            <div class="icon-circle bg-primary-light text-primary me-3">
                                <i class="fa fa-info-circle fa-lg"></i>
                            </div>
                            <h5 class="fw-bold text-dark mb-0">Informasi Utama</h5>
                        </div>
                        
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="text-uppercase fs-xs fw-bold text-muted ls-wider d-block mb-1">Nama Alumni</label>
                                <p class="text-dark fw-bold mb-0">{{ $questionnaire->nama_alumni }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="text-uppercase fs-xs fw-bold text-muted ls-wider d-block mb-1">Jabatan Alumni</label>
                                <p class="text-dark fw-bold mb-0">{{ $questionnaire->jabatan_alumni }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="text-uppercase fs-xs fw-bold text-muted ls-wider d-block mb-1">Nama Atasan</label>
                                <p class="text-dark fw-bold mb-0">{{ $questionnaire->nama_atasan }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="text-uppercase fs-xs fw-bold text-muted ls-wider d-block mb-1">Jabatan Atasan</label>
                                <p class="text-dark fw-bold mb-0">{{ $questionnaire->jabatan_atasan }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="text-uppercase fs-xs fw-bold text-muted ls-wider d-block mb-1">NIPY / ID Atasan</label>
                                <p class="text-dark fw-bold mb-0">{{ $questionnaire->nipy ?? '-' }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="text-uppercase fs-xs fw-bold text-muted ls-wider d-block mb-1">Nama Perusahaan</label>
                                <p class="text-dark fw-bold mb-0">{{ $questionnaire->nama_perusahaan }}</p>
                            </div>
                            <div class="col-md-12">
                                <label class="text-uppercase fs-xs fw-bold text-muted ls-wider d-block mb-1">Tanggal Mulai Kerja</label>
                                <p class="badge bg-light text-dark px-3 py-2 mb-0">
                                    <i class="fa fa-calendar-alt text-primary me-2"></i>{{ $questionnaire->tanggal_mulai_kerja ? $questionnaire->tanggal_mulai_kerja->format('d F Y') : '-' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informasi Kontak -->
                <div class="card card-modern border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4 pb-2 border-bottom">
                            <div class="icon-circle bg-success-light text-success me-3">
                                <i class="fa fa-address-book fa-lg"></i>
                            </div>
                            <h5 class="fw-bold text-dark mb-0">Informasi Kontak Atasan</h5>
                        </div>
                        
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center p-3 rounded-4 bg-light">
                                    <div class="icon-circle bg-white text-primary me-3 shadow-sm">
                                        <i class="fa fa-envelope"></i>
                                    </div>
                                    <div>
                                        <label class="text-uppercase fs-xs fw-bold text-muted ls-wider d-block mb-0">Email</label>
                                        <p class="text-dark fw-bold mb-0 fs-sm">{{ $questionnaire->email_atasan ?: 'Tidak ada email' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center p-3 rounded-4 bg-light">
                                    <div class="icon-circle bg-white text-success me-3 shadow-sm">
                                        <i class="fab fa-whatsapp"></i>
                                    </div>
                                    <div>
                                        <label class="text-uppercase fs-xs fw-bold text-muted ls-wider d-block mb-0">WhatsApp</label>
                                        <p class="text-dark fw-bold mb-0 fs-sm">{{ $questionnaire->wa_atasan ?: 'Tidak ada WhatsApp' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status dan Akses -->
                <div class="card card-modern border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4 pb-2 border-bottom">
                            <div class="icon-circle bg-warning-light text-warning me-3">
                                <i class="fa fa-key fa-lg"></i>
                            </div>
                            <h5 class="fw-bold text-dark mb-0">Status & Akses Kuesioner</h5>
                        </div>
                        
                        <div class="row g-4 text-center">
                            <div class="col-md-4">
                                <label class="text-uppercase fs-xs fw-bold text-muted ls-wider d-block mb-2">Status</label>
                                @if ($questionnaire->status_pengisian == 'completed')
                                    <span class="badge bg-success-light text-success px-3 py-2 rounded-pill border border-success">
                                        <i class="fa fa-check-circle me-1"></i>Selesai
                                    </span>
                                @elseif($questionnaire->status_pengisian == 'sent')
                                    <span class="badge bg-info-light text-info px-3 py-2 rounded-pill border border-info">
                                        <i class="fa fa-paper-plane me-1"></i>Terkirim
                                    </span>
                                @elseif($questionnaire->status_pengisian == 'pending')
                                    @if ($questionnaire->expires_at < now())
                                        <span class="badge bg-danger-light text-danger px-3 py-2 rounded-pill border border-danger">
                                            <i class="fa fa-times-circle me-1"></i>Kadaluarsa
                                        </span>
                                    @else
                                        <span class="badge bg-warning-light text-warning px-3 py-2 rounded-pill border border-warning">
                                            <i class="fa fa-clock me-1"></i>Menunggu
                                        </span>
                                    @endif
                                @endif
                            </div>
                            <div class="col-md-4 border-start border-end">
                                <label class="text-uppercase fs-xs fw-bold text-muted ls-wider d-block mb-2">Token Akses</label>
                                <span class="badge bg-light text-dark font-monospace px-3 py-2 border">{{ $questionnaire->token_akses }}</span>
                            </div>
                            <div class="col-md-4">
                                <label class="text-uppercase fs-xs fw-bold text-muted ls-wider d-block mb-2">Kadaluarsa</label>
                                @if ($questionnaire->expires_at)
                                    <span class="fw-bold fs-sm {{ $questionnaire->expires_at < now() ? 'text-danger' : 'text-dark' }}">
                                        {{ \Carbon\Carbon::parse($questionnaire->expires_at)->format('d/m/Y') }}
                                        <div class="fs-xs font-normal text-muted">{{ \Carbon\Carbon::parse($questionnaire->expires_at)->format('H:i') }}</div>
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </div>
                            <div class="col-12 text-start">
                                <div class="p-3 rounded-4 bg-light border-start border-4 border-primary">
                                    <label class="text-uppercase fs-xs fw-bold text-muted ls-wider d-block mb-2">Link Kuesioner (Salin & Kirim ke Atasan)</label>
                                    <div class="input-group input-group-sm">
                                        <input type="text" class="form-control border-0 bg-transparent fw-bold"
                                            value="{{ $questionnaire->getQuestionnaireUrl() }}" readonly id="copyUrlInput">
                                        <button class="btn btn-primary px-3 rounded-pill shadow-sm ms-2" onclick="copyToClipboard(this)">
                                            <i class="fa fa-copy me-1"></i> Salin
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Data Evaluasi Kuesioner -->
                @if ($questionnaire->status_pengisian == 'completed')
                    <div class="card card-modern border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-4 pb-2 border-bottom">
                                <div class="icon-circle bg-primary-light text-primary me-3">
                                    <i class="fa fa-star fa-lg"></i>
                                </div>
                                <h5 class="fw-bold text-dark mb-0">Hasil Evaluasi Kinerja Alumni</h5>
                            </div>

                            <!-- Dashboard Stats Mini -->
                            <div class="row g-3 mb-4">
                                <div class="col-md-4">
                                    <div class="p-3 rounded-4 bg-light border-bottom border-3 border-success text-center h-100">
                                        <label class="text-uppercase fs-xs fw-bold text-muted d-block mb-1">Rata-Rata Skor</label>
                                        <h3 class="fw-bold text-dark mb-0">
                                            @php
                                                $scores = array_filter([$questionnaire->integritas, $questionnaire->keahlian, $questionnaire->kemampuan, $questionnaire->penguasaan, $questionnaire->komunikasi, $questionnaire->kerja_tim, $questionnaire->pengembangan]);
                                                echo count($scores) > 0 ? number_format(array_sum($scores) / count($scores), 2) : '0';
                                            @endphp
                                        </h3>
                                        <small class="text-muted">Skala 1 - 5</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="p-3 rounded-4 bg-light border-bottom border-3 border-primary text-center h-100">
                                        <label class="text-uppercase fs-xs fw-bold text-muted d-block mb-1">Kualitas Lulusan</label>
                                        <h5 class="fw-bold text-dark mb-0">
                                            {{ [
                                                'sangat_baik' => 'Sangat Baik',
                                                'baik' => 'Baik',
                                                'cukup' => 'Cukup',
                                                'kurang' => 'Kurang',
                                                'sangat_kurang' => 'Sangat Kurang'
                                            ][$questionnaire->kualitas_lulusan] ?? 'N/A' }}
                                        </h5>
                                        <small class="text-muted">Penilaian Atasan</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="p-3 rounded-4 bg-light border-bottom border-3 border-info text-center h-100">
                                        <label class="text-uppercase fs-xs fw-bold text-muted d-block mb-1">Kesesuaian Prodi</label>
                                        <h5 class="fw-bold text-dark mb-0">
                                            {{ [
                                                'sangat_sesuai' => 'Sangat Sesuai',
                                                'sesuai' => 'Sesuai',
                                                'cukup_sesuai' => 'Cukup',
                                                'kurang_sesuai' => 'Kurang',
                                                'tidak_sesuai' => 'Tidak Sesuai'
                                            ][$questionnaire->kesesuaian_pendidikan_pekerjaan] ?? 'N/A' }}
                                        </h5>
                                        <small class="text-muted">Linearitas Kerja</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row items-push">
                                <div class="col-md-6 border-end">
                                    <h6 class="text-uppercase fs-xs fw-bold text-muted ls-wider mb-3">Grafik Radar Kompetensi</h6>
                                    <div style="height: 300px;">
                                        <canvas id="evaluationChart"></canvas>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-uppercase fs-xs fw-bold text-muted ls-wider mb-3">Detail Penilaian Indikator</h6>
                                    @php
                                        $indicators = [
                                            ['label' => 'Integritas (Etika)', 'val' => $questionnaire->integritas, 'color' => 'success'],
                                            ['label' => 'Keahlian Bidang', 'val' => $questionnaire->keahlian, 'color' => 'primary'],
                                            ['label' => 'Kemampuan (Skill)', 'val' => $questionnaire->kemampuan, 'color' => 'info'],
                                            ['label' => 'Penguasaan Teknologi', 'val' => $questionnaire->penguasaan, 'color' => 'warning'],
                                            ['label' => 'Komunikasi', 'val' => $questionnaire->komunikasi, 'color' => 'success'],
                                            ['label' => 'Kerjasama Tim', 'val' => $questionnaire->kerja_tim, 'color' => 'primary'],
                                            ['label' => 'Pengembangan Diri', 'val' => $questionnaire->pengembangan, 'color' => 'info'],
                                        ];
                                    @endphp
                                    <div class="space-y-3">
                                        @foreach($indicators as $ind)
                                            <div class="d-flex align-items-center justify-content-between mb-2 pb-1 border-bottom">
                                                <span class="fs-sm fw-semibold text-dark">{{ $ind['label'] }}</span>
                                                <div class="d-flex align-items-center">
                                                    <div class="me-2">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <i class="fa fa-star fs-xs {{ $i <= $ind['val'] ? 'text-warning' : 'text-muted opacity-25' }}"></i>
                                                        @endfor
                                                    </div>
                                                    <span class="badge bg-{{ $ind['color'] }}-light text-{{ $ind['color'] }} rounded-pill fs-xs px-2">{{ $ind['val'] }}/5</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            @if ($questionnaire->saran_perbaikan)
                                <div class="mt-4 p-4 rounded-4 bg-light-soft border">
                                    <h6 class="fw-bold text-dark mb-2">
                                        <i class="fa fa-comment-dots text-primary me-2"></i>Saran & Masukan dari Atasan:
                                    </h6>
                                    <p class="mb-0 fs-sm text-muted fst-italic">"{{ $questionnaire->saran_perbaikan }}"</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="card card-modern border-0 shadow-sm mb-4">
                        <div class="card-body p-5 text-center">
                            <div class="icon-circle bg-light text-muted mx-auto mb-3" style="width: 80px; height: 80px;">
                                <i class="fa fa-file-invoice fa-2x"></i>
                            </div>
                            <h5 class="fw-bold text-dark mb-2">Belum Ada Data Evaluasi</h5>
                            <p class="text-muted fs-sm mb-0">Supervisor belum mengisi kuesioner ini atau masa berlaku link sudah habis.</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Aksi -->
                <div class="card card-modern border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3 pb-2 border-bottom">
                            <div class="icon-circle bg-warning-light text-warning me-3" style="width: 40px; height: 40px;">
                                <i class="fa fa-cogs"></i>
                            </div>
                            <h6 class="fw-bold text-dark mb-0">Panel Kontrol</h6>
                        </div>
                        
                        <div class="gap-2 d-grid">
                            @if (Auth::user() && Auth::user()->role === 'admin')
                                <a href="{{ route('admin.supervisor-questionnaire.edit', $questionnaire->id) }}"
                                    class="btn btn-warning rounded-pill shadow-sm py-2">
                                    <i class="fa fa-pencil-alt me-2"></i>Edit Data
                                </a>
                            @endif

                            @if ($questionnaire->status_pengisian == 'pending')
                                <button type="button" class="btn btn-info rounded-pill shadow-sm py-2"
                                    onclick="resendNotification({{ $questionnaire->id }})">
                                    <i class="fa fa-paper-plane me-2"></i>Kirim Ulang Notifikasi
                                </button>
                            @endif

                            @if ($questionnaire->expires_at < now() && $questionnaire->status_pengisian != 'completed')
                                <button type="button" class="btn btn-success rounded-pill shadow-sm py-2"
                                    onclick="extendExpiry({{ $questionnaire->id }})">
                                    <i class="fa fa-clock me-2"></i>Perpanjang Masa Berlaku
                                </button>
                            @endif
                            
                            @if (Auth::user() && Auth::user()->role === 'admin')
                                <button type="button" class="btn btn-outline-danger rounded-pill py-2"
                                    onclick="deleteQuestionnaire({{ $questionnaire->id }})">
                                    <i class="fa fa-trash me-2"></i>Hapus Kuesioner
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Statistik Histori -->
                <div class="card card-modern border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3 pb-2 border-bottom">
                            <div class="icon-circle bg-primary-light text-primary me-3" style="width: 40px; height: 40px;">
                                <i class="fa fa-history"></i>
                            </div>
                            <h6 class="fw-bold text-dark mb-0">Timeline Data</h6>
                        </div>
                        
                        <div class="space-y-3">
                            <div class="p-3 rounded-4 bg-light text-center border">
                                <h4 class="fw-bold text-primary mb-0 fs-5">
                                    {{ $questionnaire->created_at ? $questionnaire->created_at->diffForHumans() : '-' }}
                                </h4>
                                <div class="text-muted small text-uppercase fw-bold ls-wide" style="font-size: 0.65rem;">Data Dibuat Pada Sistem</div>
                            </div>
                            <div class="p-3 rounded-4 bg-light-soft text-center border">
                                <h4 class="fw-bold text-warning mb-0 fs-5">
                                    @if ($questionnaire->expires_at)
                                        {{ \Carbon\Carbon::parse($questionnaire->expires_at)->diffForHumans() }}
                                    @else
                                        -
                                    @endif
                                </h4>
                                <div class="text-muted small text-uppercase fw-bold ls-wide" style="font-size: 0.65rem;">Masa Berlaku Link Akses</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Initialize chart if questionnaire is completed
        @if ($questionnaire->status_pengisian == 'completed')
            document.addEventListener('DOMContentLoaded', function() {
                const ctx = document.getElementById('evaluationChart').getContext('2d');

                const data = {
                    labels: ['Integritas', 'Keahlian', 'Kemampuan', 'Penguasaan', 'Komunikasi', 'Kerja Tim', 'Pengembangan'],
                    datasets: [{
                        label: 'Skor Evaluasi',
                        data: [
                            {{ $questionnaire->integritas ?? 0 }},
                            {{ $questionnaire->keahlian ?? 0 }},
                            {{ $questionnaire->kemampuan ?? 0 }},
                            {{ $questionnaire->penguasaan ?? 0 }},
                            {{ $questionnaire->komunikasi ?? 0 }},
                            {{ $questionnaire->kerja_tim ?? 0 }},
                            {{ $questionnaire->pengembangan ?? 0 }}
                        ],
                        backgroundColor: 'rgba(78, 115, 223, 0.15)',
                        borderColor: '#4e73df',
                        borderWidth: 2,
                        pointBackgroundColor: '#4e73df',
                        pointBorderColor: '#fff',
                        pointHoverBackgroundColor: '#fff',
                        pointHoverBorderColor: '#4e73df',
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        fill: true
                    }]
                };

                const config = {
                    type: 'radar',
                    data: data,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            r: {
                                min: 0,
                                max: 5,
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1,
                                    backdropColor: 'transparent',
                                    color: '#858796',
                                    font: { size: 10 }
                                },
                                grid: { color: 'rgba(0,0,0,0.05)' },
                                angleLines: { color: 'rgba(0,0,0,0.05)' },
                                pointLabels: {
                                    color: '#4e73df',
                                    font: { weight: 'bold', size: 11 }
                                }
                            }
                        },
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: '#1f2937',
                                titleColor: '#fff',
                                bodyColor: '#fff',
                                displayColors: false,
                                callbacks: {
                                    label: (context) => ` Skor: ${context.parsed.r}/5`
                                }
                            }
                        }
                    }
                };

                new Chart(ctx, config);
            });
        @endif

        // Copy to clipboard
        function copyToClipboard(button) {
            const input = document.getElementById('copyUrlInput');
            input.select();
            input.setSelectionRange(0, 99999);
            navigator.clipboard.writeText(input.value).then(() => {
                const originalText = button.innerHTML;
                button.innerHTML = '<i class="fa fa-check me-1"></i> Tersalin';
                button.classList.remove('btn-primary');
                button.classList.add('btn-success');

                setTimeout(() => {
                    button.innerHTML = originalText;
                    button.classList.remove('btn-success');
                    button.classList.add('btn-primary');
                }, 2000);
            });
        }

        // Resend notification
        function resendNotification(id) {
            Swal.fire({
                title: 'Kirim Ulang Notifikasi?',
                text: 'Apakah Anda yakin ingin mengirim ulang notifikasi ke supervisor?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, kirim!',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'swal-modern',
                    confirmButton: 'btn-modern btn-modern-primary',
                    cancelButton: 'btn-modern btn-modern-secondary'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    var url = "{{ route('admin.supervisor-questionnaire.resend-notification', ':id') }}";
                    url = url.replace(':id', id);
                    window.location.href = url;
                }
            });
        }

        // Extend expiry
        function extendExpiry(id) {
            Swal.fire({
                title: 'Perpanjang Masa Berlaku?',
                text: 'Link akan diperpanjang 7 hari dari sekarang.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, perpanjang!',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'swal-modern',
                    confirmButton: 'btn-modern btn-modern-primary',
                    cancelButton: 'btn-modern btn-modern-secondary'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading state
                    Swal.fire({
                        title: 'Memproses...',
                        text: 'Sedang memperpanjang masa berlaku',
                        allowOutsideClick: false,
                        customClass: {
                            popup: 'swal-modern'
                        },
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Make AJAX call to extend expiry
                    fetch(`/admin/supervisor-questionnaire/${id}/extend-expiry`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content'),
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: data.message,
                                    icon: 'success',
                                    customClass: {
                                        popup: 'swal-modern'
                                    }
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    title: 'Gagal!',
                                    text: data.message,
                                    icon: 'error',
                                    customClass: {
                                        popup: 'swal-modern'
                                    }
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                title: 'Error!',
                                text: 'Terjadi kesalahan saat memperpanjang masa berlaku.',
                                icon: 'error',
                                customClass: {
                                    popup: 'swal-modern'
                                }
                            });
                        });
                }
            });
        }

        // Delete questionnaire
        function deleteQuestionnaire(id) {
            Swal.fire({
                title: 'Hapus Data?',
                text: 'Data yang dihapus tidak dapat dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'swal-modern',
                    confirmButton: 'btn-modern btn-modern-danger',
                    cancelButton: 'btn-modern btn-modern-secondary'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    var url = "{{ route('admin.supervisor-questionnaire.destroy', ':id') }}";
                    url = url.replace(':id', id);

                    // Create form and submit
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = url;

                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';

                    const methodField = document.createElement('input');
                    methodField.type = 'hidden';
                    methodField.name = '_method';
                    methodField.value = 'DELETE';

                    form.appendChild(csrfToken);
                    form.appendChild(methodField);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    </script>
@endsection
