@extends('layouts.admin')

@section('content')
    <!-- Premium Glassmorphic Hero -->
    <div class="card card-modern border-0 shadow-lg mb-4 overflow-hidden mx-4 mt-4" style="background: linear-gradient(135deg, #0f2027 0%, #203a43 50%, #2c5364 100%);">
        <div class="card-body p-4 p-md-5 position-relative">
            <div class="row align-items-center">
                <div class="col-lg-8 position-relative" style="z-index: 2;">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-circle bg-white-20 text-white me-3" style="width: 50px; height: 50px;">
                            <i class="fa fa-chart-pie fa-lg"></i>
                        </div>
                        <h1 class="h2 fw-bold text-white mb-0">Dashboard Supervisor</h1>
                    </div>
                    <p class="lead text-white-50 mb-0">Analisis Mendalam dan Statistik Evaluasi Kinerja Alumni Berdasarkan Feedback Pengguna Lulusan.</p>
                </div>
                <div class="col-lg-4 text-lg-end mt-4 mt-lg-0 position-relative" style="z-index: 2;">
                    <a href="{{ route('admin.supervisor-questionnaire.index') }}" class="btn btn-lg btn-white rounded-pill px-4 shadow-sm hover-scale">
                        <i class="fa fa-list me-2"></i> Kelola Data
                    </a>
                </div>
            </div>
            <!-- Decorative Elements -->
            <div class="position-absolute top-0 end-0 p-5 mt-n5 me-n5 opacity-10">
                <i class="fa fa-briefcase fa-10x text-white"></i>
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
                                <i class="fa fa-clipboard-list fa-lg"></i>
                            </div>
                            <span class="badge bg-primary-light text-primary rounded-pill px-2 py-0 fs-xs border border-primary-10">Total</span>
                        </div>
                        <h3 class="display-6 fw-bold text-dark mb-1 stat-counter">{{ $totalQuestionnaires }}</h3>
                        <p class="text-muted small mb-0">Total Kuesioner Dialokasikan</p>
                    </div>
                    <div class="position-absolute bottom-0 start-0 end-0 bg-primary" style="height: 4px; opacity: 0.1;"></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-modern border-0 shadow-sm h-100 stat-hover-effect overflow-hidden">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="icon-circle bg-warning-light text-warning">
                                <i class="fa fa-clock fa-lg"></i>
                            </div>
                            <span class="badge bg-warning-light text-warning rounded-pill px-2 py-0 fs-xs border border-warning-10">Pending</span>
                        </div>
                        <h3 class="display-6 fw-bold text-dark mb-1 stat-counter">{{ $pendingQuestionnaires }}</h3>
                        <p class="text-muted small mb-0">Menunggu Respon Supervisor</p>
                    </div>
                    <div class="position-absolute bottom-0 start-0 end-0 bg-warning" style="height: 4px; opacity: 0.1;"></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-modern border-0 shadow-sm h-100 stat-hover-effect overflow-hidden">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="icon-circle bg-success-light text-success">
                                <i class="fa fa-check-circle fa-lg"></i>
                            </div>
                            <span class="badge bg-success-light text-success rounded-pill px-2 py-0 fs-xs border border-success-10">Selesai</span>
                        </div>
                        <h3 class="display-6 fw-bold text-dark mb-1 stat-counter">{{ $completedQuestionnaires }}</h3>
                        <p class="text-muted small mb-0">Respon Selesai Dievaluasi</p>
                    </div>
                    <div class="position-absolute bottom-0 start-0 end-0 bg-success" style="height: 4px; opacity: 0.1;"></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-modern border-0 shadow-sm h-100 stat-hover-effect overflow-hidden">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="icon-circle bg-danger-light text-danger">
                                <i class="fa fa-exclamation-triangle fa-lg"></i>
                            </div>
                            <span class="badge bg-danger-light text-danger rounded-pill px-2 py-0 fs-xs border border-danger-10">Expired</span>
                        </div>
                        <h3 class="display-6 fw-bold text-dark mb-1 stat-counter">{{ $expiredQuestionnaires }}</h3>
                        <p class="text-muted small mb-0">Tautan Survey Kadaluarsa</p>
                    </div>
                    <div class="position-absolute bottom-0 start-0 end-0 bg-danger" style="height: 4px; opacity: 0.1;"></div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Chart Evaluasi Rata-rata -->
            <div class="col-lg-8">
                <div class="card card-modern border-0 shadow-sm h-100">
                    <div class="card-header bg-white py-3 px-4 border-bottom-0">
                        <div class="d-flex align-items-center">
                            <div class="icon-circle bg-primary-light text-primary me-3" style="width: 40px; height: 40px;">
                                <i class="fa fa-chart-line"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold text-dark mb-0">Rata-rata Skor per Kategori</h5>
                                <p class="text-muted small mb-0">Performa kompetensi alumni di dunia kerja</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4 pt-0">
                        <div class="chart-container" style="height: 350px;">
                            <canvas id="averageScoreChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Distribusi Skor -->
            <div class="col-lg-4">
                <div class="card card-modern border-0 shadow-sm h-100">
                    <div class="card-header bg-white py-3 px-4 border-bottom-0">
                        <div class="d-flex align-items-center">
                            <div class="icon-circle bg-info-light text-info me-3" style="width: 40px; height: 40px;">
                                <i class="fa fa-chart-pie"></i>
                            </div>
                            <h5 class="fw-bold text-dark mb-0">Distribusi Skor</h5>
                        </div>
                    </div>
                    <div class="card-body p-4 pt-0">
                        <div class="chart-container" style="height: 350px;">
                            <canvas id="scoreDistributionChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mt-2">
            <!-- Top Performers -->
            <div class="col-lg-6">
                <div class="card card-modern border-0 shadow-sm h-100">
                    <div class="card-header bg-white py-3 px-4 border-bottom-0">
                        <div class="d-flex align-items-center">
                            <div class="icon-circle bg-warning-light text-warning me-3" style="width: 40px; height: 40px;">
                                <i class="fa fa-trophy"></i>
                            </div>
                            <h5 class="fw-bold text-dark mb-0">Top Performers</h5>
                        </div>
                    </div>
                    <div class="card-body p-4 pt-0">
                        @if($topPerformers->count() > 0)
                            <div class="space-y-3">
                                @foreach($topPerformers as $performer)
                                    <div class="p-3 rounded-4 bg-light-soft border border-white shadow-sm hover-scale transition-all d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-circle-sm bg-primary text-white fw-bold me-3">
                                                {{ substr($performer->nama_alumni, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark mb-0">{{ $performer->nama_alumni }}</div>
                                                <div class="text-muted small">{{ $performer->nama_perusahaan }} • {{ $performer->jabatan_alumni }}</div>
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <div class="badge bg-success-light text-success rounded-pill px-3 py-1 border border-success-10">
                                                <i class="fa fa-star me-1 fs-xs"></i> {{ number_format($performer->average_score, 2) }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fa fa-info-circle fa-3x text-light mb-3"></i>
                                <p class="text-muted mb-0">Belum ada data evaluasi yang selesai.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Kesesuaian Pendidikan -->
            <div class="col-lg-6">
                <div class="card card-modern border-0 shadow-sm h-100">
                    <div class="card-header bg-white py-3 px-4 border-bottom-0">
                        <div class="d-flex align-items-center">
                            <div class="icon-circle bg-success-light text-success me-3" style="width: 40px; height: 40px;">
                                <i class="fa fa-graduation-cap"></i>
                            </div>
                            <h5 class="fw-bold text-dark mb-0">Kesesuaian Pendidikan</h5>
                        </div>
                    </div>
                    <div class="card-body p-4 pt-0 text-center">
                        <div class="chart-container" style="height: 300px;">
                            <canvas id="educationMatchChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animate counters if jQuery is available
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

            // Chart Configuration Common
            const chartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            };

            // Chart 1: Rata-rata Skor Evaluasi per Kategori
            const ctx1 = document.getElementById('averageScoreChart').getContext('2d');
            new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: ['Integritas', 'Keahlian', 'Kemampuan', 'Penguasaan', 'Komunikasi', 'Kerja Tim', 'Pengembangan'],
                    datasets: [{
                        label: 'Skor Rata-rata',
                        data: [
                            {{ $averageScores['integritas'] ?? 0 }},
                            {{ $averageScores['keahlian'] ?? 0 }},
                            {{ $averageScores['kemampuan'] ?? 0 }},
                            {{ $averageScores['penguasaan'] ?? 0 }},
                            {{ $averageScores['komunikasi'] ?? 0 }},
                            {{ $averageScores['kerja_tim'] ?? 0 }},
                            {{ $averageScores['pengembangan'] ?? 0 }}
                        ],
                        backgroundColor: 'rgba(54, 162, 235, 0.7)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 0,
                        borderRadius: 8
                    }]
                },
                options: {
                    ...chartOptions,
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 5,
                            grid: {
                                display: true,
                                drawBorder: false,
                                color: 'rgba(0,0,0,0.05)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });

            // Chart 2: Distribusi Skor Rata-rata
            const ctx2 = document.getElementById('scoreDistributionChart').getContext('2d');
            new Chart(ctx2, {
                type: 'doughnut',
                data: {
                    labels: ['Sangat Baik', 'Baik', 'Cukup', 'Kurang', 'Sangat Kurang'],
                    datasets: [{
                        data: [
                            {{ $scoreDistribution['excellent'] ?? 0 }},
                            {{ $scoreDistribution['good'] ?? 0 }},
                            {{ $scoreDistribution['fair'] ?? 0 }},
                            {{ $scoreDistribution['poor'] ?? 0 }},
                            {{ $scoreDistribution['very_poor'] ?? 0 }}
                        ],
                        backgroundColor: ['#10b981', '#3b82f6', '#f59e0b', '#f97316', '#ef4444'],
                        borderWidth: 0,
                        cutout: '70%'
                    }]
                },
                options: {
                    ...chartOptions,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                padding: 20,
                                font: { size: 11 }
                            }
                        }
                    }
                }
            });

            // Chart 3: Kesesuaian Pendidikan
            const ctx3 = document.getElementById('educationMatchChart').getContext('2d');
            new Chart(ctx3, {
                type: 'pie',
                data: {
                    labels: ['Sangat Sesuai', 'Sesuai', 'Cukup Sesuai', 'Kurang Sesuai', 'Tidak Sesuai'],
                    datasets: [{
                        data: [
                            {{ $educationMatch['sangat_sesuai'] ?? 0 }},
                            {{ $educationMatch['sesuai'] ?? 0 }},
                            {{ $educationMatch['cukup_sesuai'] ?? 0 }},
                            {{ $educationMatch['kurang_sesuai'] ?? 0 }},
                            {{ $educationMatch['tidak_sesuai'] ?? 0 }}
                        ],
                        backgroundColor: ['#10b981', '#3b82f6', '#f59e0b', '#f97316', '#ef4444'],
                        borderWidth: 0
                    }]
                },
                options: {
                    ...chartOptions,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                padding: 20,
                                font: { size: 11 }
                            }
                        }
                    }
                }
            });
        });
    </script>

    <style>
        .icon-circle.bg-white-20 { background: rgba(255,255,255,0.2); }
        .avatar-circle-sm {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
        }
        .stat-hover-effect { transition: all 0.3s ease; }
        .stat-hover-effect:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important; }
        .hover-scale { transition: all 0.3s ease; }
        .hover-scale:hover { transform: scale(1.05); }
        .space-y-3 > * + * { margin-top: 0.75rem !important; }
        .bg-light-soft { background-color: #f8fafc; }
        .chart-container { position: relative; width: 100%; }
        .transition-all { transition: all 0.3s ease; }
    </style>
@endsection
