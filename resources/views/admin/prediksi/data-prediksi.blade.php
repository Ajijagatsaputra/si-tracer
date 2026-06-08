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
                                            <a href="javascript:void(0)"
                                               onclick="showDetail({{ $item->id }})"
                                               data-bs-toggle="modal"
                                               data-bs-target="#detailModal"
                                               class="btn-read-article text-uppercase fw-bold text-decoration-none">
                                                Detail <i class="fa fa-chevron-right ms-1" style="font-size: 0.7rem;"></i>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            <!-- Pagination -->
                            @if ($histories->hasPages())
                                <div class="mt-4 pt-3 border-top">
                                    {{ $histories->links() }}
                                </div>
                            @endif
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
    <div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-lg overflow-hidden rounded-4 position-relative">
                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3 z-3 bg-dark/20 backdrop-blur rounded-circle p-2 shadow-sm" data-bs-dismiss="modal" aria-label="Close" style="width: 32px; height: 32px; font-size: 0.75rem; border: none;"></button>
                <div class="modal-body p-0" id="modalContent">
                    <!-- Dynamic Content -->
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

        function formatAIResponse(text) {
            if (!text) return '<p class="text-muted text-center py-4">Belum ada analisis yang tersedia.</p>';
            
            let formatted = text;
            
            // Format headings ###
            formatted = formatted.replace(/^### (.*?)$/gm, '<h6 class="fw-bold text-primary mt-4 mb-3 border-bottom pb-2"><i class="fa fa-chevron-right text-primary me-2 fs-xs"></i>$1</h6>');
            
            // Format headings ##
            formatted = formatted.replace(/^## (.*?)$/gm, '<h5 class="fw-bold text-dark mt-4 mb-3">$1</h5>');
            
            // Format bold **
            formatted = formatted.replace(/\*\*(.*?)\*\*/g, '<strong class="text-dark fw-bold">$1</strong>');
            
            // Format bullet points
            formatted = formatted.replace(/^- (.*?)$/gm, '<li class="mb-2">$1</li>');
            
            // Replace double newlines with spacing div
            formatted = formatted.replace(/\n\n/g, '<div class="mb-3"></div>');
            
            return formatted;
        }

        function printReport() {
            const printContent = document.getElementById('modalContent').innerHTML;
            const printWindow = window.open('', '_blank');
            printWindow.document.write(`
                <html>
                    <head>
                        <title>Laporan Analisis Prediksi Karir Alumni</title>
                        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
                        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
                        <style>
                            body { font-family: 'Inter', sans-serif; padding: 40px; background: #fff; }
                            .row { margin: 0; }
                            .col-lg-5 { background: #000428 !important; color: #fff !important; padding: 40px; border-radius: 12px 0 0 12px; }
                            .col-lg-7 { padding: 40px; border: 1px solid #dee2e6; border-radius: 0 12px 12px 0; }
                            .btn, .btn-close { display: none !important; }
                            .text-white-50 { color: #94a3b8 !important; }
                            .text-primary-light { color: #60a5fa !important; }
                            .badge { border: 1px solid currentColor !important; }
                            .bg-primary-light { background-color: #eff6ff !important; color: #1d4ed8 !important; }
                            .bg-success-light { background-color: #f0fdf4 !important; color: #15803d !important; }
                            .bg-warning-light { background-color: #fffbeb !important; color: #b45309 !important; }
                            .avatar-ring { padding: 4px; border-radius: 50%; display: inline-block; background: rgba(255,255,255,0.1); }
                            @media print {
                                body { padding: 0; }
                                .col-lg-5 { background: linear-gradient(135deg, #000428 0%, #004e92 100%) !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
                            }
                        </style>
                    </head>
                    <body>
                        <div class="container mt-4">
                            <div class="row">
                                ${printContent}
                            </div>
                        </div>
                        <script>
                            window.onload = function() {
                                window.print();
                                setTimeout(function() { window.close(); }, 500);
                            };
                        <\/script>
                    </body>
                </html>
            `);
            printWindow.document.close();
        }

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
                        <div class="row g-0">
                            <!-- Left Side: Profile Banner & Core Info -->
                            <div class="col-lg-5 text-white position-relative d-flex flex-column justify-content-between p-4 py-5 modal-banner-left">
                                 
                                 <!-- Subtle background pattern decorative circles -->
                                 <div class="position-absolute top-0 start-0 w-100 h-100 overflow-hidden" style="opacity: 0.15; pointer-events: none;">
                                     <div class="position-absolute rounded-circle bg-white" style="width: 200px; height: 200px; top: -50px; left: -50px;"></div>
                                     <div class="position-absolute rounded-circle bg-white" style="width: 150px; height: 150px; bottom: -30px; right: -30px;"></div>
                                 </div>
    
                                 <!-- Profile Header Content -->
                                 <div class="z-1 w-100 px-3">
                                     <div class="mb-4">
                                         <div class="avatar-ring p-1 rounded-circle bg-white/20 d-inline-block">
                                             <div class="avatar-circle-lg bg-primary text-white fs-4 fw-bold d-flex align-items-center justify-content-center" style="width:85px; height:85px; border-radius: 50%; border: 3px solid #fff;">
                                                 ${(data.alumni?.nama_lengkap || 'A').charAt(0)}
                                             </div>
                                         </div>
                                     </div>
                                     <span class="badge bg-success-light text-success rounded-pill border border-success-10 px-3 py-1 fs-xs fw-bold mb-2">
                                         <i class="fa fa-shield-check me-1"></i> Verified AI Output
                                     </span>
                                     <h3 class="fw-bold mb-1 text-white fs-4">${data.alumni?.nama_lengkap || 'Unknown Alumni'}</h3>
                                     
                                     <div class="mt-4 pt-3 border-top border-white-10">
                                         <div class="d-flex align-items-center text-white-75 fs-sm py-2">
                                             <i class="fa fa-id-card text-white-50 me-3" style="width: 20px;"></i>
                                             <div>
                                                 <small class="text-white-50 d-block text-uppercase fw-semibold" style="font-size: 0.65rem;">NIM</small>
                                                 <span class="fw-bold text-white">${data.alumni?.nim || '-'}</span>
                                             </div>
                                         </div>
                                         <div class="d-flex align-items-center text-white-75 fs-sm py-2">
                                             <i class="fa fa-calendar-alt text-white-50 me-3" style="width: 20px;"></i>
                                             <div>
                                                 <small class="text-white-50 d-block text-uppercase fw-semibold" style="font-size: 0.65rem;">Waktu Analisis</small>
                                                 <span class="fw-semibold text-white">${date}</span>
                                             </div>
                                         </div>
                                     </div>

                                     <div class="mt-4 pt-3 border-top border-white-10">
                                         <small class="text-white-50 d-block text-uppercase fw-semibold mb-2" style="font-size: 0.65rem;">Predicted Job Categories</small>
                                         <div class="d-flex flex-wrap">${titlesHTML}</div>
                                     </div>
                                 </div>
                                 
                                 <div class="d-flex gap-2 pt-4 px-3 z-1">
                                     <button type="button" class="btn btn-sm btn-white rounded-pill px-4 fw-bold text-primary shadow-sm border-0" onclick="printReport()"><i class="fa fa-print me-1"></i> Cetak</button>
                                     <button type="button" class="btn btn-sm btn-white/25 text-white rounded-pill px-4 fw-bold shadow-sm border border-white/20" data-bs-dismiss="modal"><i class="fa fa-times me-1"></i> Tutup</button>
                                 </div>
                            </div>
    
                            <!-- Right Side: Grid of detailed cards -->
                            <div class="col-lg-7 bg-white p-4 p-md-5 d-flex flex-column justify-content-between">
                                 <div>
                                     <div class="d-flex align-items-center justify-content-between mb-4 border-bottom pb-3">
                                         <div>
                                             <h5 class="fw-bold text-dark mb-1">Detail Informasi & Rekomendasi</h5>
                                             <p class="text-muted fs-xs mb-0">Rekomendasi karir masa depan berdasarkan transkrip nilai.</p>
                                         </div>
                                     </div>
                                     
                                     <div class="pe-2" style="max-height: 420px; overflow-y: auto; scrollbar-width: thin;">
                                         <div class="ai-content-body fs-sm text-dark" style="line-height: 1.7;">
                                             ${formatAIResponse(data.hasil)}
                                         </div>
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
        .btn-read-article {
            font-size: 0.72rem;
            letter-spacing: 1.5px;
            color: var(--bs-primary, #3b82f6);
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
        }
        .btn-read-article:hover {
            color: #004e92 !important;
            text-decoration: none;
        }
        .btn-read-article i {
            transition: transform 0.2s ease;
        }
        .btn-read-article:hover i {
            transform: translateX(3px);
        }

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
        
        .modal-banner-left {
            background: linear-gradient(135deg, #000428 0%, #004e92 100%);
        }
        @media (min-width: 992px) {
            .modal-banner-left {
                min-height: 480px !important;
            }
        }
        @media (max-width: 991.98px) {
            .modal-banner-left {
                min-height: auto !important;
                padding-top: 3.5rem !important;
                padding-bottom: 2.5rem !important;
            }
        }
        
        @media (max-width: 768px) {
            .border-start-md { border-left: 0; }
        }
    </style>
@endsection
