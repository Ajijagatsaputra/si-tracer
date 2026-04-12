@extends('layouts.admin')

@section('content')
    <!-- Premium Glassmorphic Hero -->
    <div class="card card-modern border-0 shadow-lg mb-4 overflow-hidden mx-4 mt-4" style="background: linear-gradient(135deg, #000428 0%, #004e92 100%);">
        <div class="card-body p-4 p-md-5 position-relative">
            <div class="row align-items-center">
                <div class="col-lg-8 position-relative" style="z-index: 2;">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-circle bg-white-20 text-white me-3" style="width: 50px; height: 50px;">
                            <i class="fa fa-brain fa-lg"></i>
                        </div>
                        <h1 class="h2 fw-bold text-white mb-0">Deep Analysis & Prediksi AI</h1>
                    </div>
                    <p class="lead text-white-50 mb-0">Visualisasi data historis dan prediksi karir alumni menggunakan model Machine Learning canggih.</p>
                </div>
                <div class="col-lg-4 text-lg-end mt-4 mt-lg-0 position-relative" style="z-index: 2;">
                    <a href="{{ route('admin.prediksi.index') }}" class="btn btn-lg btn-white rounded-pill px-4 shadow-sm hover-scale me-2 mb-2 mb-lg-0">
                        <i class="fa fa-list-ul me-2 text-primary"></i> Lihat Semua
                    </a>
                    <div class="glass-pill d-inline-block px-4 py-2 border border-white-25 rounded-pill shadow-sm" style="background: rgba(255,255,255,0.1); backdrop-filter: blur(10px);">
                        <span class="text-white-50 small text-uppercase fw-bold me-2">AI Status:</span>
                        <span class="text-success fw-bold"><i class="fa fa-check-circle me-1"></i> Active</span>
                    </div>
                </div>
            </div>
            <!-- Decorative Elements -->
            <div class="position-absolute top-0 end-0 p-5 mt-n5 me-n5 opacity-10">
                <i class="fa fa-microchip fa-10x text-white"></i>
            </div>
        </div>
    </div>

    <!-- Page Content -->
    <div class="content content-full">
        <!-- Modern Stats Grid -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card card-modern border-0 shadow-sm h-100 stat-hover-effect overflow-hidden">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="icon-circle bg-primary-light text-primary">
                                <i class="fa fa-database fa-lg"></i>
                            </div>
                            <span class="badge bg-primary-light text-primary rounded-pill px-2 py-0 fs-xs border border-primary-10">Total</span>
                        </div>
                        <h3 class="display-6 fw-bold text-dark mb-1 stat-counter">{{ $totalPredictions ?? 0 }}</h3>
                        <p class="text-muted small mb-0">Total History Prediksi</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-modern border-0 shadow-sm h-100 stat-hover-effect overflow-hidden">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="icon-circle bg-success-light text-success">
                                <i class="fa fa-calendar-day fa-lg"></i>
                            </div>
                            <span class="badge bg-success-light text-success rounded-pill px-2 py-0 fs-xs border border-success-10">Hari Ini</span>
                        </div>
                        <h3 class="display-6 fw-bold text-dark mb-1 stat-counter">{{ $todayPredictions ?? 0 }}</h3>
                        <p class="text-muted small mb-0">Prediksi Diproses Hari Ini</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-modern border-0 shadow-sm h-100 stat-hover-effect overflow-hidden">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="icon-circle bg-warning-light text-warning">
                                <i class="fa fa-history fa-lg"></i>
                            </div>
                            <span class="badge bg-warning-light text-warning rounded-pill px-2 py-0 fs-xs border border-warning-10">7 Hari</span>
                        </div>
                        <h3 class="display-6 fw-bold text-dark mb-1 stat-counter">{{ $last7DaysPredictions ?? 0 }}</h3>
                        <p class="text-muted small mb-0">Total Aktivitas Mingguan</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-modern border-0 shadow-sm h-100 stat-hover-effect overflow-hidden">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="icon-circle bg-danger-light text-danger">
                                <i class="fa fa-users fa-lg"></i>
                            </div>
                            <span class="badge bg-danger-light text-danger rounded-pill px-2 py-0 fs-xs border border-danger-10">Unik</span>
                        </div>
                        <h3 class="display-6 fw-bold text-dark mb-1 stat-counter">{{ $uniqueUsers ?? 0 }}</h3>
                        <p class="text-muted small mb-0">Alumni Menggunakan AI</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <!-- Chart Prediksi 7 Hari -->
            <div class="col-lg-8">
                <div class="card card-modern border-0 shadow-sm h-100">
                    <div class="card-header bg-white py-3 px-4 border-bottom-0">
                        <div class="d-flex align-items-center">
                            <div class="icon-circle bg-primary-light text-primary me-3" style="width: 40px; height: 40px;">
                                <i class="fa fa-chart-line"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold text-dark mb-0">Tren Prediksi Mingguan</h5>
                                <p class="text-muted small mb-0">Jumlah aktivitas prediksi 7 hari terakhir</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4 pt-0">
                        <div class="chart-container" style="height: 300px;">
                            <canvas id="prediksi7HariChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Distribusi Job Title -->
            <div class="col-lg-4">
                <div class="card card-modern border-0 shadow-sm h-100">
                    <div class="card-header bg-white py-3 px-4 border-bottom-0">
                        <div class="d-flex align-items-center">
                            <div class="icon-circle bg-info-light text-info me-3" style="width: 40px; height: 40px;">
                                <i class="fa fa-briefcase"></i>
                            </div>
                            <h5 class="fw-bold text-dark mb-0">Distribusi Karir</h5>
                        </div>
                    </div>
                    <div class="card-body p-4 pt-0">
                        <div class="chart-container" style="height: 300px;">
                            <canvas id="jobTitleChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Riwayat -->
        <div class="row g-4">
            <div class="col-12">
                <div class="card card-modern border-0 shadow-sm">
                    <div class="card-header bg-white py-3 px-4 border-bottom d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="icon-circle bg-primary-light text-primary me-3" style="width: 40px; height: 40px;">
                                <i class="fa fa-history"></i>
                            </div>
                            <h5 class="fw-bold text-dark mb-0">Riwayat Prediksi Terbaru</h5>
                        </div>
                        <span class="badge bg-light text-primary rounded-pill px-3">{{ isset($histories) ? $histories->count() : 0 }} Record</span>
                    </div>
                    <div class="card-body p-4">
                        @if(isset($histories) && $histories->count() > 0)
                            <div class="space-y-3">
                                @foreach($histories as $item)
                                    <div class="p-3 rounded-4 bg-light-soft border border-white shadow-sm hover-scale transition-all d-flex flex-column flex-md-row align-items-md-center justify-content-between">
                                        <div class="d-flex align-items-center mb-3 mb-md-0" style="min-width: 250px;">
                                            <div class="avatar-circle bg-primary text-white fw-bold me-3">
                                                {{ substr($item->alumni->nama_lengkap ?? 'A', 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark mb-0">{{ $item->alumni->nama_lengkap ?? ('Alumni #' . ($item->idAlumni ?? '-')) }}</div>
                                                <div class="text-muted small">ID: {{ $item->idAlumni ?? '-' }} • <span class="text-primary fw-medium">{{ optional($item->created_at)->diffForHumans() }}</span></div>
                                            </div>
                                        </div>
                                        
                                        <div class="flex-grow-1 px-md-4 mb-3 mb-md-0 border-start-md">
                                            @php
                                                $jobTitles = $item->extracted_job_titles ?? [];
                                            @endphp
                                            <div class="d-flex flex-wrap gap-1 mb-2">
                                                @foreach($jobTitles as $title)
                                                    <span class="badge bg-primary-light text-primary rounded-pill px-2 border border-primary-10 fs-xs">{{ $title }}</span>
                                                @endforeach
                                                @if(empty($jobTitles))
                                                    <span class="badge bg-light text-muted rounded-pill px-2 fs-xs italic">No job title match</span>
                                                @endif
                                            </div>
                                            @php
                                                $plain = trim(strip_tags($item->hasil ?? ''));
                                                $excerpt = mb_strimwidth($plain, 0, 120, '...');
                                            @endphp
                                            <div class="text-muted small" style="line-height: 1.4;">{{ $excerpt }}</div>
                                        </div>

                                        <div class="text-md-end ms-md-3">
                                            <button type="button" class="btn btn-sm btn-white rounded-pill px-3 shadow-sm border"
                                                    onclick="showDetail({{ $item->id }})"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#detailModal">
                                                <i class="fa fa-eye text-primary me-1"></i> Detail
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="py-5 text-center">
                                <div class="icon-circle bg-light text-muted mx-auto mb-3" style="width: 70px; height: 70px;">
                                    <i class="fa fa-info-circle fa-2x"></i>
                                </div>
                                <h6 class="fw-bold text-dark">Belum ada riwayat</h6>
                                <p class="text-muted small mb-0">Data prediksi akan muncul di sini setelah diproses.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Premium Detail Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-lg overflow-hidden">
                <div class="modal-header border-0 p-4" style="background: linear-gradient(135deg, #000428 0%, #004e92 100%);">
                    <div class="d-flex align-items-center">
                        <div class="icon-circle bg-white-20 text-white me-3" style="width: 40px; height: 40px;">
                            <i class="fa fa-robot"></i>
                        </div>
                        <h5 class="modal-title text-white fw-bold" id="detailModalLabel">AI Analysis Report</h5>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0" id="modalContent">
                    <!-- Dynamic Content -->
                </div>
                <div class="modal-footer bg-light border-0 p-3">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animate counters
            if (typeof jQuery !== 'undefined') {
                $('.stat-counter').each(function() {
                    const $this = $(this);
                    const countTo = parseInt($this.text());
                    $({ countNum: 0 }).animate({ countNum: countTo }, {
                        duration: 1500,
                        easing: 'swing',
                        step: function() {
                            $this.text(Math.floor(this.countNum));
                        },
                        complete: function() {
                            $this.text(this.countNum);
                        }
                    });
                });
            }

            const chartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                }
            };

            // Chart 1: Tren Prediksi
            const ctx1 = document.getElementById('prediksi7HariChart');
            if (ctx1) {
                new Chart(ctx1.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: @json($last7DaysLabels ?? []),
                        datasets: [{
                            data: @json($last7DaysCounts ?? []),
                            backgroundColor: 'rgba(59, 130, 246, 0.7)',
                            borderRadius: 6
                        }]
                    },
                    options: {
                        ...chartOptions,
                        scales: {
                            y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)', drawBorder: false } },
                            x: { grid: { display: false } }
                        }
                    }
                });
            }

            // Chart 2: Distribusi Job Title
            const ctx2 = document.getElementById('jobTitleChart');
            if (ctx2) {
                new Chart(ctx2.getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: @json($jobTitleLabels ?? []),
                        datasets: [{
                            data: @json($jobTitleCounts ?? []),
                            backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#ec4899'],
                            borderWidth: 0,
                            cutout: '75%'
                        }]
                    },
                    options: {
                        ...chartOptions,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'bottom',
                                labels: { usePointStyle: true, padding: 15, font: { size: 10 } }
                            }
                        }
                    }
                });
            }
        });

        function showDetail(id) {
            const container = document.getElementById('modalContent');
            container.innerHTML = `
                <div class="p-5 text-center">
                    <div class="spinner-grow text-primary" role="status"></div>
                    <p class="mt-3 text-muted small">AI is analyzing historical data...</p>
                </div>
            `;

            fetch(`/admin/prediksi/detail/${id}`)
                .then(r => r.json())
                .then(data => {
                    const date = new Date(data.created_at).toLocaleDateString('id-ID', {
                        day: 'numeric', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit'
                    });

                    let titlesHTML = data.extracted_job_titles?.map(t => 
                        `<span class="badge bg-primary-light text-primary rounded-pill px-3 py-2 border border-primary-10 me-2 mb-2">${t}</span>`
                    ).join('') || '<span class="text-muted fst-italic">No titles extracted</span>';

                    container.innerHTML = `
                        <div class="p-4 bg-light shadow-inner border-bottom">
                            <div class="row align-items-center">
                                <div class="col-md-7">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle-lg bg-primary text-white fs-4 me-3">
                                            ${(data.alumni?.nama_lengkap || 'A').charAt(0)}
                                        </div>
                                        <div>
                                            <h5 class="fw-bold mb-0 text-dark">${data.alumni?.nama_lengkap || 'Unknown Alumni'}</h5>
                                            <p class="text-muted small mb-0">ID: ${data.idAlumni || '-'} • Analysis on ${date}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5 text-md-end mt-3 mt-md-0">
                                    <span class="badge bg-success-light text-success rounded-pill px-3 py-2 border border-success-10">
                                        <i class="fa fa-shield-check me-1"></i> Verified AI Output
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="p-4">
                            <div class="mb-4">
                                <h6 class="text-uppercase text-primary fw-bold small mb-3 letter-spacing-1">
                                    <i class="fa fa-tags me-2"></i> Predicted Job Categories
                                </h6>
                                <div class="d-flex flex-wrap">${titlesHTML}</div>
                            </div>
                            <div class="mb-0">
                                <h6 class="text-uppercase text-primary fw-bold small mb-3 letter-spacing-1">
                                    <i class="fa fa-file-invoice me-2"></i> Detailed Analysis & Recommendation
                                </h6>
                                <div class="p-4 rounded-4 bg-white border shadow-sm" style="max-height: 400px; overflow-y: auto;">
                                    <div class="ai-content-body fs-sm text-dark" style="line-height: 1.7;">
                                        ${data.hasil || '<p class="text-muted text-center py-4">No content available</p>'}
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                })
                .catch(err => {
                    container.innerHTML = `<div class="p-5 text-center text-danger"><i class="fa fa-exclamation-circle fa-3x mb-3"></i><p>Failed to load analysis.</p></div>`;
                });
        }
        
        function deleteItem(id) {
            if (confirm('Yakin ingin menghapus data ini?')) {
                document.getElementById('delete-form-' + id).submit();
            }
        }
    </script>

    <style>
        .icon-circle.bg-white-20 { background: rgba(255,255,255,0.2); }
        .avatar-circle { width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center; }
        .avatar-circle-lg { width: 60px; height: 60px; border-radius: 18px; display: flex; align-items: center; justify-content: center; }
        .stat-hover-effect { transition: all 0.3s ease; }
        .stat-hover-effect:hover { transform: translateY(-5px); box-shadow: 0 12px 25px rgba(0,0,0,0.1) !important; }
        .bg-light-soft { background-color: #f8fafc; }
        .hover-scale { transition: all 0.3s ease; }
        .hover-scale:hover { transform: scale(1.02); }
        .transition-all { transition: all 0.3s ease; }
        .space-y-3 > * + * { margin-top: 1rem !important; }
        .border-start-md { border-left: 1px solid rgba(0,0,0,0.05); }
        .shadow-inner { box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.05); }
        .letter-spacing-1 { letter-spacing: 1px; }
        .ai-content-body { white-space: pre-line; }
        .ai-content-body strong { color: var(--bs-primary); }
        
        @media (max-width: 768px) {
            .border-start-md { border-left: 0; }
        }
    </style>
@endsection
