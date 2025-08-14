@extends('layouts.admin')

@section('content')
    <!-- Hero -->
    <div class="bg-body-light border-bottom py-3">
        <div class="content d-flex flex-column flex-sm-row justify-content-between align-items-center">
            <div>
                <h1 class="h3 fw-bold mb-0 text-primary">
                    <i class="fa fa-chart-pie me-2"></i> Dashboard Supervisor Questionnaire
                </h1>
                <p class="text-muted fs-sm mb-0">Analisis dan statistik evaluasi supervisor questionnaire.</p>
            </div>
            <div>
                <a href="{{ route('admin.supervisor-questionnaire.index') }}" class="btn btn-secondary">
                    <i class="fa fa-list me-1"></i> Daftar Data
                </a>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <!-- Page Content -->
    <div class="content">
        <!-- Statistik Utama -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card card-body border-0 bg-gradient-primary text-white shadow-sm gradient-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="fs-2 fw-bold">{{ $totalQuestionnaires }}</div>
                            <div class="fs-sm">Total Kuesioner</div>
                        </div>
                        <div><i class="fa fa-clipboard-list fa-2x opacity-50"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-body border-0 bg-gradient-warning text-dark shadow-sm gradient-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="fs-2 fw-bold">{{ $pendingQuestionnaires }}</div>
                            <div class="fs-sm">Menunggu</div>
                        </div>
                        <div><i class="fa fa-clock fa-2x opacity-50"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-body border-0 bg-gradient-success text-white shadow-sm gradient-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="fs-2 fw-bold">{{ $completedQuestionnaires }}</div>
                            <div class="fs-sm">Selesai</div>
                        </div>
                        <div><i class="fa fa-check-circle fa-2x opacity-50"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-body border-0 bg-gradient-danger text-white shadow-sm gradient-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="fs-2 fw-bold">{{ $expiredQuestionnaires }}</div>
                            <div class="fs-sm">Kadaluarsa</div>
                        </div>
                        <div><i class="fa fa-exclamation-triangle fa-2x opacity-50"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Chart Evaluasi Rata-rata -->
            <div class="col-lg-8">
                <div class="block block-rounded shadow-sm">
                    <div class="block-header block-header-default bg-light">
                        <h3 class="block-title fw-semibold text-primary mb-0">
                            <i class="fa fa-chart-line me-2"></i> Rata-rata Skor Evaluasi per Kategori
                        </h3>
                    </div>
                    <div class="block-content block-content-full">
                        <canvas id="averageScoreChart" height="300"></canvas>
                    </div>
                </div>
            </div>

            <!-- Distribusi Skor -->
            <div class="col-lg-4">
                <div class="block block-rounded shadow-sm">
                    <div class="block-header block-header-default bg-light">
                        <h3 class="block-title fw-semibold text-primary mb-0">
                            <i class="fa fa-chart-pie me-2"></i> Distribusi Skor Rata-rata
                        </h3>
                    </div>
                    <div class="block-content block-content-full">
                        <canvas id="scoreDistributionChart" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mt-2">
            <!-- Top Performers -->
            <div class="col-lg-6">
                <div class="block block-rounded shadow-sm">
                    <div class="block-header block-header-default bg-light">
                        <h3 class="block-title fw-semibold text-primary mb-0">
                            <i class="fa fa-trophy me-2"></i> Top Performers
                        </h3>
                    </div>
                    <div class="block-content block-content-full">
                        @if($topPerformers->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-borderless table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Nama Alumni</th>
                                            <th>Perusahaan</th>
                                            <th>Skor Rata-rata</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($topPerformers as $performer)
                                            <tr>
                                                <td>
                                                    <div class="fw-semibold">{{ $performer->nama_alumni }}</div>
                                                    <div class="text-muted small">{{ $performer->jabatan_alumni }}</div>
                                                </td>
                                                <td>{{ $performer->nama_perusahaan }}</td>
                                                <td>
                                                    <span class="badge bg-success fs-6">
                                                        {{ number_format($performer->average_score, 2) }}/5
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fa fa-info-circle fa-2x text-muted mb-3"></i>
                                <p class="text-muted mb-0">Belum ada data evaluasi yang selesai.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Kesesuaian Pendidikan -->
            <div class="col-lg-6">
                <div class="block block-rounded shadow-sm">
                    <div class="block-header block-header-default bg-light">
                        <h3 class="block-title fw-semibold text-primary mb-0">
                            <i class="fa fa-graduation-cap me-2"></i> Kesesuaian Pendidikan
                        </h3>
                    </div>
                    <div class="block-content block-content-full">
                        <canvas id="educationMatchChart" height="300"></canvas>
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
                        backgroundColor: 'rgba(54, 162, 235, 0.8)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 5,
                            ticks: {
                                callback: function(value) {
                                    return value.toFixed(2) + '/5';
                                }
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.parsed.y.toFixed(2) + '/5';
                                }
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
                    labels: ['Sangat Baik (4.5-5.0)', 'Baik (3.5-4.4)', 'Cukup (2.5-3.4)', 'Kurang (1.5-2.4)', 'Sangat Kurang (1.0-1.4)'],
                    datasets: [{
                        data: [
                            {{ $scoreDistribution['excellent'] ?? 0 }},
                            {{ $scoreDistribution['good'] ?? 0 }},
                            {{ $scoreDistribution['fair'] ?? 0 }},
                            {{ $scoreDistribution['poor'] ?? 0 }},
                            {{ $scoreDistribution['very_poor'] ?? 0 }}
                        ],
                        backgroundColor: [
                            '#28a745',
                            '#17a2b8',
                            '#ffc107',
                            '#fd7e14',
                            '#dc3545'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true
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
                        backgroundColor: [
                            '#28a745',
                            '#17a2b8',
                            '#ffc107',
                            '#fd7e14',
                            '#dc3545'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true
                            }
                        }
                    }
                }
            });
        });
    </script>

    <style>
        .bg-gradient-primary { background: linear-gradient(92deg, #31c7ef 40%, #38d9c3 100%)!important; }
        .bg-gradient-success { background: linear-gradient(92deg, #32d484 30%, #75e095 100%)!important; }
        .bg-gradient-warning { background: linear-gradient(92deg, #ffed85 30%, #ffc371 100%)!important; }
        .bg-gradient-danger { background: linear-gradient(92deg, #ff6b6b 30%, #ee5a52 100%)!important; }
        .card { min-height: 85px; border-radius: 1.3rem; }
    </style>
@endsection
