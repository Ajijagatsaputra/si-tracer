@extends('layouts.admin')

@section('content')
    <!-- Breadcrumb & Top Bar -->
    <div class="flex-wrap gap-2 mb-3 d-flex align-items-center justify-content-between">
        <nav aria-label="breadcrumb">
            <ol class="p-0 mb-0 breadcrumb fs-sm">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}" class="text-primary text-decoration-none">
                        <i class="fa fa-home me-1"></i> Home
                    </a>
                </li>
                <li class="breadcrumb-item text-muted">Kelola Tracer</li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.supervisor-questionnaire.index') }}" class="text-primary text-decoration-none">
                        Pengguna
                    </a>
                </li>
                <li class="breadcrumb-item active text-dark fw-semibold" aria-current="page">Ringkasan Statistik</li>
            </ol>
        </nav>
        <div>
            <a href="{{ route('admin.supervisor-questionnaire.index') }}" class="px-3 shadow-sm btn btn-sm btn-outline-secondary rounded-pill hover-lift">
                <i class="fa fa-list me-1"></i> Kelola Data Kuesioner
            </a>
        </div>
    </div>

    @php
        $validAvgScores = array_filter($averageScores ?? [], fn($v) => !is_null($v) && $v > 0);
        $overallScore = count($validAvgScores) > 0 ? array_sum($validAvgScores) / count($validAvgScores) : 0;
        $responseRate = $totalQuestionnaires > 0 ? round(($completedQuestionnaires / $totalQuestionnaires) * 100, 1) : 0;
        $totalEdu = array_sum($educationMatch ?? []);
    @endphp

    <!-- Hero Header Modern -->
    <div class="mb-4 supervisor-hero">
        <div class="row align-items-center g-3">
            <div class="col-lg-8">
                <div class="flex-wrap gap-2 mb-2 d-flex align-items-center">
                    <span class="badge hero-badge">
                        <i class="fa fa-briefcase text-warning me-1"></i> Tracer Pengguna Lulusan
                    </span>
                    <span class="badge hero-badge-sub">
                        Evaluasi Atasan & Stakeholder
                    </span>
                    <span class="badge hero-badge-rate">
                        <i class="fa fa-chart-pie me-1"></i> Response Rate: {{ $responseRate }}%
                    </span>
                </div>
                <h1 class="mb-2 text-white h3 fw-bold">
                    Dashboard Evaluasi Pengguna Lulusan 💼
                </h1>
                <p class="mb-0 text-white-50 small">
                    Analisis komprehensif performa kerja, integritas, dan keselarasan kurikulum alumni di dunia kerja berdasarkan penilaian langsung atasan/pengguna lulusan.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="gap-2 flex-column flex-sm-row flex-lg-column d-inline-flex align-items-lg-end">
                    <div class="hero-chip">
                        <i class="fa fa-calendar-alt text-warning"></i>
                        <span>{{ now()->translatedFormat('l, d F Y') }}</span>
                    </div>
                    <div class="hero-chip">
                        <i class="fa fa-clock text-info"></i>
                        <span id="liveTimeSupervisor">{{ now()->format('H:i:s') }} WIB</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 4 Top Metric Cards -->
    <div class="mb-4 row g-3">
        <!-- Total Kuesioner -->
        <div class="col-sm-6 col-xl-3">
            <div class="metric-card metric-blue h-100">
                <div class="metric-card-body">
                    <div class="mb-3 d-flex align-items-center justify-content-between">
                        <div class="metric-icon">
                            <i class="fa fa-clipboard-list"></i>
                        </div>
                        <span class="metric-pill">Target</span>
                    </div>
                    <div class="metric-value stat-counter">{{ $totalQuestionnaires }}</div>
                    <div class="metric-label">Total Kuesioner Dialokasikan</div>
                    <div class="metric-footer">
                        <a href="{{ route('admin.supervisor-questionnaire.index') }}" class="metric-link">
                            Kelola Semua Data <i class="fa fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Menunggu Respon -->
        <div class="col-sm-6 col-xl-3">
            <div class="metric-card metric-amber h-100">
                <div class="metric-card-body">
                    <div class="mb-3 d-flex align-items-center justify-content-between">
                        <div class="metric-icon">
                            <i class="fa fa-clock"></i>
                        </div>
                        <span class="metric-pill">Pending</span>
                    </div>
                    <div class="metric-value stat-counter">{{ $pendingQuestionnaires }}</div>
                    <div class="metric-label">Menunggu Respon Atasan</div>
                    <div class="metric-footer">
                        <a href="{{ route('admin.supervisor-questionnaire.index', ['status' => 'pending']) }}" class="metric-link">
                            Cek Antrean Pending <i class="fa fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Respon Selesai -->
        <div class="col-sm-6 col-xl-3">
            <div class="metric-card metric-emerald h-100">
                <div class="metric-card-body">
                    <div class="mb-3 d-flex align-items-center justify-content-between">
                        <div class="metric-icon">
                            <i class="fa fa-check-circle"></i>
                        </div>
                        <span class="metric-pill">{{ $responseRate }}% Selesai</span>
                    </div>
                    <div class="metric-value stat-counter">{{ $completedQuestionnaires }}</div>
                    <div class="metric-label">Respon Berhasil Dievaluasi</div>
                    <div class="metric-footer">
                        <a href="{{ route('admin.supervisor-questionnaire.index', ['status' => 'completed']) }}" class="metric-link">
                            Lihat Evaluasi Masuk <i class="fa fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Expired -->
        <div class="col-sm-6 col-xl-3">
            <div class="metric-card metric-rose h-100">
                <div class="metric-card-body">
                    <div class="mb-3 d-flex align-items-center justify-content-between">
                        <div class="metric-icon">
                            <i class="fa fa-exclamation-triangle"></i>
                        </div>
                        <span class="metric-pill">Kadaluarsa</span>
                    </div>
                    <div class="metric-value stat-counter">{{ $expiredQuestionnaires }}</div>
                    <div class="metric-label">Tautan Survei Expired</div>
                    <div class="metric-footer">
                        <a href="{{ route('admin.supervisor-questionnaire.index', ['status' => 'expired']) }}" class="metric-link">
                            Tinjau Tautan Kadaluarsa <i class="fa fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row 1: Skor Rata-rata & Distribusi Skor -->
    <div class="mb-4 row g-4">
        <!-- Chart Rata-rata Skor per Kategori -->
        <div class="col-lg-8">
            <div class="panel-card h-100 d-flex flex-column">
                <div class="flex-wrap gap-2 panel-header d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="panel-icon bg-primary-soft text-primary me-3">
                            <i class="fa fa-chart-bar"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold text-dark">Rata-rata Skor per Kategori Evaluasi</h5>
                            <p class="mb-0 text-muted small">Performa kompetensi alumni di dunia kerja (Skala 1.0 - 5.0)</p>
                        </div>
                    </div>
                    <div>
                        <span class="px-3 py-2 border badge bg-primary-soft text-primary rounded-pill fw-bold border-primary-subtle">
                            <i class="fa fa-star text-warning me-1"></i> Rata-rata Total: {{ number_format($overallScore, 2) }} / 5.0
                        </span>
                    </div>
                </div>
                <div class="panel-body flex-grow-1 d-flex flex-column justify-content-between">
                    <div class="mb-3 chart-container" style="height: 330px; position: relative;">
                        <canvas id="averageScoreChart"></canvas>
                    </div>

                    <!-- Mini Category Cards -->
                    <div class="pt-2 row g-2 border-top">
                        @php
                            $categoryItems = [
                                ['label' => 'Integritas', 'score' => $averageScores['integritas'] ?? 0, 'icon' => 'fa-shield-alt', 'color' => '#3b82f6'],
                                ['label' => 'Keahlian', 'score' => $averageScores['keahlian'] ?? 0, 'icon' => 'fa-laptop-code', 'color' => '#10b981'],
                                ['label' => 'Kemampuan', 'score' => $averageScores['kemampuan'] ?? 0, 'icon' => 'fa-cogs', 'color' => '#8b5cf6'],
                                ['label' => 'Penguasaan TI', 'score' => $averageScores['penguasaan'] ?? 0, 'icon' => 'fa-microchip', 'color' => '#f59e0b'],
                                ['label' => 'Komunikasi', 'score' => $averageScores['komunikasi'] ?? 0, 'icon' => 'fa-comments', 'color' => '#06b6d4'],
                                ['label' => 'Kerja Tim', 'score' => $averageScores['kerja_tim'] ?? 0, 'icon' => 'fa-users', 'color' => '#ec4899'],
                                ['label' => 'Pengembangan', 'score' => $averageScores['pengembangan'] ?? 0, 'icon' => 'fa-chart-line', 'color' => '#6366f1'],
                            ];
                        @endphp

                        @foreach($categoryItems as $item)
                            <div class="col-6 col-md-4 col-xl" style="flex: 1 0 13%;">
                                <div class="p-2 text-center border rounded-3 bg-light border-light-subtle h-100">
                                    <div class="mb-1 fs-xs text-muted text-truncate" title="{{ $item['label'] }}">{{ $item['label'] }}</div>
                                    <div class="gap-1 fw-bold fs-sm text-dark d-flex align-items-center justify-content-center">
                                        <i class="fa {{ $item['icon'] }} fs-xs" style="color: {{ $item['color'] }}"></i>
                                        <span>{{ number_format($item['score'], 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Distribusi Predikat Skor -->
        <div class="col-lg-4">
            <div class="panel-card h-100 d-flex flex-column">
                <div class="panel-header d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="panel-icon bg-violet-soft text-purple me-3">
                            <i class="fa fa-chart-pie"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold text-dark">Distribusi Predikat</h5>
                            <p class="mb-0 text-muted small">Klasifikasi performa lulusan</p>
                        </div>
                    </div>
                </div>
                <div class="panel-body flex-grow-1 d-flex flex-column justify-content-between">
                    <div class="my-auto chart-container position-relative d-flex align-items-center justify-content-center" style="height: 240px;">
                        <canvas id="scoreDistributionChart"></canvas>
                        <div class="text-center chart-center-badge">
                            <div class="fs-4 fw-extrabold text-dark">{{ number_format($overallScore, 1) }}</div>
                            <div class="fs-xs text-muted fw-semibold">Rata-rata</div>
                        </div>
                    </div>

                    <!-- Breakdown Legends with percentages -->
                    <div class="pt-3 mt-3 space-y-2 border-top">
                        @php
                            $totalScoreDist = array_sum($scoreDistribution ?? []);
                            $distLegends = [
                                ['label' => 'Sangat Baik (≥ 4.5)', 'count' => $scoreDistribution['excellent'] ?? 0, 'color' => '#10b981'],
                                ['label' => 'Baik (3.5 – 4.4)', 'count' => $scoreDistribution['good'] ?? 0, 'color' => '#3b82f6'],
                                ['label' => 'Cukup (2.5 – 3.4)', 'count' => $scoreDistribution['fair'] ?? 0, 'color' => '#f59e0b'],
                                ['label' => 'Kurang (1.5 – 2.4)', 'count' => $scoreDistribution['poor'] ?? 0, 'color' => '#f97316'],
                                ['label' => 'Sangat Kurang (< 1.5)', 'count' => $scoreDistribution['very_poor'] ?? 0, 'color' => '#ef4444'],
                            ];
                        @endphp

                        @foreach($distLegends as $legend)
                            @php
                                $percent = $totalScoreDist > 0 ? round(($legend['count'] / $totalScoreDist) * 100, 1) : 0;
                            @endphp
                            <div class="d-flex align-items-center justify-content-between fs-xs">
                                <div class="d-flex align-items-center">
                                    <span class="legend-dot me-2" style="background-color: {{ $legend['color'] }};"></span>
                                    <span class="text-secondary">{{ $legend['label'] }}</span>
                                </div>
                                <div class="gap-2 d-flex align-items-center">
                                    <span class="fw-bold text-dark">{{ $legend['count'] }}</span>
                                    <span class="text-muted" style="min-width: 42px; text-align: right;">({{ $percent }}%)</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Row 2: Top Performers & Kesesuaian Pendidikan -->
    <div class="mb-4 row g-4">
        <!-- Top Performers -->
        <div class="col-lg-6">
            <div class="panel-card h-100 d-flex flex-column">
                <div class="panel-header d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="panel-icon bg-warning-soft text-warning me-3">
                            <i class="fa fa-trophy"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold text-dark">Alumni Berpredikat Terbaik</h5>
                            <p class="mb-0 text-muted small">Lulusan dengan evaluasi kinerja tertinggi dari atasan</p>
                        </div>
                    </div>
                    <span class="px-3 py-1 badge bg-warning-soft text-warning fw-bold rounded-pill">Top 5</span>
                </div>
                <div class="panel-body flex-grow-1">
                    @if($topPerformers->count() > 0)
                        <div class="space-y-3">
                            @foreach($topPerformers as $index => $performer)
                                @php
                                    $rankBadges = [
                                        0 => ['bg' => 'linear-gradient(135deg, #f59e0b, #d97706)', 'color' => '#fff', 'label' => '1'],
                                        1 => ['bg' => 'linear-gradient(135deg, #94a3b8, #64748b)', 'color' => '#fff', 'label' => '2'],
                                        2 => ['bg' => 'linear-gradient(135deg, #b45309, #78350f)', 'color' => '#fff', 'label' => '3'],
                                    ];
                                    $rank = $rankBadges[$index] ?? ['bg' => '#f1f5f9', 'color' => '#475569', 'label' => ($index + 1)];
                                @endphp
                                <div class="p-3 bg-white border shadow-xs performer-item d-flex align-items-center justify-content-between rounded-3 border-light-subtle">
                                    <div class="d-flex align-items-center">
                                        <div class="rank-badge me-3" style="background: {{ $rank['bg'] }}; color: {{ $rank['color'] }};">
                                            #{{ $rank['label'] }}
                                        </div>
                                        <div class="avatar-circle-sm bg-primary-soft text-primary fw-bold me-3">
                                            {{ strtoupper(substr($performer->nama_alumni, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="mb-0 fw-bold text-dark">{{ $performer->nama_alumni }}</div>
                                            <div class="text-muted fs-xs">
                                                <i class="opacity-75 fa fa-building me-1"></i> {{ $performer->nama_perusahaan }}
                                                <span class="mx-1">•</span>
                                                <i class="opacity-75 fa fa-user-tie me-1"></i> {{ $performer->jabatan_alumni }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <div class="px-3 py-2 border badge bg-success-soft text-success rounded-pill fw-bold border-success-subtle">
                                            <i class="fa fa-star text-warning me-1"></i> {{ number_format($performer->average_score, 2) }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="py-5 my-auto text-center">
                            <div class="mx-auto mb-3 avatar-circle-lg bg-light text-muted">
                                <i class="fa fa-clipboard-check fa-2x"></i>
                            </div>
                            <h6 class="mb-1 fw-bold text-dark">Belum Ada Evaluasi Selesai</h6>
                            <p class="mb-0 text-muted small">Data top performers akan otomatis terisi setelah atasan mengisi kuesioner evaluasi.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Kesesuaian Pendidikan -->
        <div class="col-lg-6">
            <div class="panel-card h-100 d-flex flex-column">
                <div class="panel-header d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="panel-icon bg-emerald-soft text-emerald me-3">
                            <i class="fa fa-graduation-cap"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold text-dark">Kesesuaian Bidang Studi (Relevansi)</h5>
                            <p class="mb-0 text-muted small">Tingkat relevansi kurikulum perkuliahan dengan pekerjaan</p>
                        </div>
                    </div>
                </div>
                <div class="panel-body flex-grow-1 d-flex flex-column justify-content-between">
                    <div class="mb-3 chart-container" style="height: 220px; position: relative;">
                        <canvas id="educationMatchChart"></canvas>
                    </div>

                    <!-- Visual Progress List for Education Match -->
                    <div class="pt-3 space-y-2 border-top">
                        @php
                            $eduLabels = [
                                'sangat_sesuai' => ['label' => 'Sangat Sesuai', 'color' => '#10b981'],
                                'sesuai' => ['label' => 'Sesuai', 'color' => '#3b82f6'],
                                'cukup_sesuai' => ['label' => 'Cukup Sesuai', 'color' => '#f59e0b'],
                                'kurang_sesuai' => ['label' => 'Kurang Sesuai', 'color' => '#f97316'],
                                'tidak_sesuai' => ['label' => 'Tidak Sesuai', 'color' => '#ef4444'],
                            ];
                        @endphp

                        @foreach($eduLabels as $key => $meta)
                            @php
                                $val = $educationMatch[$key] ?? 0;
                                $percentage = $totalEdu > 0 ? round(($val / $totalEdu) * 100, 1) : 0;
                            @endphp
                            <div>
                                <div class="mb-1 d-flex justify-content-between align-items-center fs-xs">
                                    <span class="text-secondary fw-semibold">{{ $meta['label'] }}</span>
                                    <span class="text-dark fw-bold">{{ $val }} <span class="text-muted fw-normal">({{ $percentage }}%)</span></span>
                                </div>
                                <div class="progress" style="height: 6px; background-color: #f1f5f9; border-radius: 10px;">
                                    <div class="progress-bar rounded-pill" role="progressbar"
                                         style="width: {{ $percentage }}%; background-color: {{ $meta['color'] }};"
                                         aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Shortcuts / Modul Terkait -->
    <div class="row g-3">
        <div class="col-md-4">
            <a href="{{ route('admin.supervisor-questionnaire.index') }}" class="shortcut-box">
                <div class="shortcut-icon bg-blue text-primary">
                    <i class="fa fa-list-alt"></i>
                </div>
                <div>
                    <div class="shortcut-title">Daftar Survei Pengguna</div>
                    <div class="shortcut-desc">Kelola kuesioner atasan, kirim tautan, & ekspor data</div>
                </div>
                <i class="fa fa-chevron-right ms-auto text-muted fs-xs"></i>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('admin.curriculum-analysis.index') }}" class="shortcut-box">
                <div class="shortcut-icon bg-amber text-warning">
                    <i class="fa fa-book-open"></i>
                </div>
                <div>
                    <div class="shortcut-title">Analisis Kurikulum</div>
                    <div class="shortcut-desc">Evaluasi kesesuaian mata kuliah & gap kompetensi industri</div>
                </div>
                <i class="fa fa-chevron-right ms-auto text-muted fs-xs"></i>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('tracer.rekap') }}" class="shortcut-box">
                <div class="shortcut-icon bg-violet text-purple">
                    <i class="fa fa-chart-line"></i>
                </div>
                <div>
                    <div class="shortcut-title">Rekapitulasi Hasil Tracer</div>
                    <div class="shortcut-desc">Statistik gabungan alumni & mitra industri secara detail</div>
                </div>
                <i class="fa fa-chevron-right ms-auto text-muted fs-xs"></i>
            </a>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Live clock updater
            function updateSupervisorClock() {
                const now = new Date();
                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');
                const seconds = String(now.getSeconds()).padStart(2, '0');
                const clockEl = document.getElementById('liveTimeSupervisor');
                if (clockEl) clockEl.innerText = `${hours}:${minutes}:${seconds} WIB`;
            }
            setInterval(updateSupervisorClock, 1000);

            // Counter Animation
            if (typeof jQuery !== 'undefined') {
                $('.stat-counter').each(function() {
                    const $this = $(this);
                    const countTo = parseInt($this.text()) || 0;
                    $({ countNum: 0 }).animate({ countNum: countTo }, {
                        duration: 1200,
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

            // Common font styling
            const fontFamily = "'Plus Jakarta Sans', 'Inter', sans-serif";

            // Chart 1: Rata-rata Skor per Kategori (Bar Chart with Gradients)
            const ctx1 = document.getElementById('averageScoreChart').getContext('2d');

            // Bar Gradient
            const gradBar = ctx1.createLinearGradient(0, 0, 0, 300);
            gradBar.addColorStop(0, '#3b82f6');
            gradBar.addColorStop(1, '#1d4ed8');

            new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: ['Integritas', 'Keahlian', 'Kemampuan', 'Penguasaan TI', 'Komunikasi', 'Kerja Tim', 'Pengembangan'],
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
                        backgroundColor: gradBar,
                        hoverBackgroundColor: '#2563eb',
                        borderRadius: 8,
                        borderSkipped: false,
                        barPercentage: 0.55
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#0f172a',
                            titleFont: { size: 13, family: fontFamily, weight: 'bold' },
                            bodyFont: { size: 12, family: fontFamily },
                            padding: 10,
                            cornerRadius: 8,
                            displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    return ' Skor: ' + context.parsed.y.toFixed(2) + ' / 5.0';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 5,
                            ticks: {
                                stepSize: 1,
                                font: { family: fontFamily, size: 11 },
                                color: '#94a3b8'
                            },
                            grid: {
                                color: 'rgba(226, 232, 240, 0.7)',
                                drawBorder: false
                            }
                        },
                        x: {
                            ticks: {
                                font: { family: fontFamily, size: 11, weight: '600' },
                                color: '#475569'
                            },
                            grid: { display: false }
                        }
                    }
                }
            });

            // Chart 2: Distribusi Skor (Doughnut Chart)
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
                        borderWidth: 2,
                        borderColor: '#ffffff',
                        hoverOffset: 4,
                        cutout: '76%'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#0f172a',
                            titleFont: { size: 12, family: fontFamily, weight: 'bold' },
                            bodyFont: { size: 12, family: fontFamily },
                            padding: 10,
                            cornerRadius: 8,
                            callbacks: {
                                label: function(context) {
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const val = context.parsed;
                                    const pct = total > 0 ? ((val / total) * 100).toFixed(1) : 0;
                                    return ` ${context.label}: ${val} (${pct}%)`;
                                }
                            }
                        }
                    }
                }
            });

            // Chart 3: Kesesuaian Pendidikan (Modern Doughnut)
            const ctx3 = document.getElementById('educationMatchChart').getContext('2d');
            new Chart(ctx3, {
                type: 'doughnut',
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
                        borderWidth: 2,
                        borderColor: '#ffffff',
                        hoverOffset: 4,
                        cutout: '65%'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                pointStyle: 'circle',
                                padding: 14,
                                font: { family: fontFamily, size: 11, weight: '500' },
                                color: '#475569'
                            }
                        },
                        tooltip: {
                            backgroundColor: '#0f172a',
                            titleFont: { size: 12, family: fontFamily, weight: 'bold' },
                            bodyFont: { size: 12, family: fontFamily },
                            padding: 10,
                            cornerRadius: 8,
                            callbacks: {
                                label: function(context) {
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const val = context.parsed;
                                    const pct = total > 0 ? ((val / total) * 100).toFixed(1) : 0;
                                    return ` ${context.label}: ${val} (${pct}%)`;
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection

@section('styles')
    <style>
        /* Hero Banner */
        .supervisor-hero {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #1e3a8a 100%);
            border-radius: 1rem;
            padding: 1.6rem 1.85rem;
            box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.2);
            position: relative;
            overflow: hidden;
        }

        .supervisor-hero::after {
            content: '';
            position: absolute;
            top: -60px;
            right: -60px;
            width: 220px;
            height: 220px;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.25) 0%, rgba(255, 255, 255, 0) 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .hero-badge {
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(8px);
            color: #f8fafc;
            font-size: 0.72rem;
            font-weight: 600;
            padding: 0.35rem 0.65rem;
            border-radius: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .hero-badge-sub {
            background: rgba(59, 130, 246, 0.2);
            color: #93c5fd;
            font-size: 0.72rem;
            font-weight: 600;
            padding: 0.35rem 0.65rem;
            border-radius: 2rem;
            border: 1px solid rgba(59, 130, 246, 0.3);
        }

        .hero-badge-rate {
            background: rgba(16, 185, 129, 0.2);
            color: #6ee7b7;
            font-size: 0.72rem;
            font-weight: 600;
            padding: 0.35rem 0.65rem;
            border-radius: 2rem;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .hero-chip {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 2rem;
            padding: 0.4rem 0.85rem;
            color: #f1f5f9;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            backdrop-filter: blur(8px);
        }

        /* Metric Cards */
        .metric-card {
            background: #ffffff;
            border-radius: 0.875rem;
            border: 1px solid #f1f5f9;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04), 0 1px 2px rgba(0, 0, 0, 0.02);
            position: relative;
            overflow: hidden;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .metric-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 20px -5px rgba(15, 23, 42, 0.08);
            border-color: #e2e8f0;
        }

        .metric-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
        }

        .metric-blue::before { background: linear-gradient(90deg, #3b82f6, #60a5fa); }
        .metric-emerald::before { background: linear-gradient(90deg, #10b981, #34d399); }
        .metric-amber::before { background: linear-gradient(90deg, #f59e0b, #fbbf24); }
        .metric-rose::before { background: linear-gradient(90deg, #ef4444, #f87171); }

        .metric-card-body {
            padding: 1.25rem;
        }

        .metric-icon {
            width: 42px;
            height: 42px;
            border-radius: 0.65rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }

        .metric-blue .metric-icon { background: #eff6ff; color: #2563eb; }
        .metric-amber .metric-icon { background: #fffbeb; color: #d97706; }
        .metric-emerald .metric-icon { background: #ecfdf5; color: #059669; }
        .metric-rose .metric-icon { background: #fef2f2; color: #dc2626; }

        .metric-pill {
            font-size: 0.7rem;
            font-weight: 700;
            padding: 0.25rem 0.6rem;
            border-radius: 1rem;
        }

        .metric-blue .metric-pill { background: #eff6ff; color: #1d4ed8; }
        .metric-amber .metric-pill { background: #fffbeb; color: #b45309; }
        .metric-emerald .metric-pill { background: #ecfdf5; color: #047857; }
        .metric-rose .metric-pill { background: #fef2f2; color: #b91c1c; }

        .metric-value {
            font-size: 1.85rem;
            font-weight: 800;
            color: #0f172a;
            line-height: 1.2;
            margin-bottom: 0.25rem;
        }

        .metric-label {
            font-size: 0.78rem;
            color: #64748b;
            font-weight: 500;
            margin-bottom: 0.75rem;
        }

        .metric-footer {
            border-top: 1px dashed #f1f5f9;
            padding-top: 0.65rem;
        }

        .metric-link {
            font-size: 0.75rem;
            font-weight: 600;
            color: #475569;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            transition: color 0.15s ease;
        }

        .metric-card:hover .metric-link {
            color: #2563eb;
        }

        /* Panels */
        .panel-card {
            background: #ffffff;
            border-radius: 0.875rem;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
            overflow: hidden;
        }

        .panel-header {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid #f1f5f9;
        }

        .panel-body {
            padding: 1.25rem;
        }

        .panel-icon {
            width: 38px;
            height: 38px;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.95rem;
        }

        .bg-primary-soft { background: #eff6ff; }
        .bg-emerald-soft { background: #ecfdf5; }
        .bg-warning-soft { background: #fffbeb; }
        .bg-violet-soft { background: #f5f3ff; }
        .bg-success-soft { background: #ecfdf5; }
        .text-purple { color: #7c3aed; }
        .text-emerald { color: #059669; }

        .chart-center-badge {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            pointer-events: none;
        }

        .legend-dot {
            width: 9px;
            height: 9px;
            border-radius: 50%;
            display: inline-block;
        }

        .space-y-2 > * + * { margin-top: 0.55rem !important; }
        .space-y-3 > * + * { margin-top: 0.85rem !important; }

        /* Performers */
        .performer-item {
            transition: all 0.2s ease;
        }
        .performer-item:hover {
            transform: translateX(4px);
            border-color: #cbd5e1 !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .rank-badge {
            width: 28px;
            height: 28px;
            border-radius: 0.4rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: 800;
        }

        .avatar-circle-sm {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.95rem;
        }

        .avatar-circle-lg {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Shortcuts */
        .shortcut-box {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 0.875rem;
            padding: 1.15rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            text-decoration: none;
            transition: all 0.2s ease;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.02);
        }

        .shortcut-box:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.06);
            border-color: #cbd5e1;
        }

        .shortcut-icon {
            width: 44px;
            height: 44px;
            border-radius: 0.65rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.15rem;
            flex-shrink: 0;
        }

        .shortcut-icon.bg-blue { background: #eff6ff; }
        .shortcut-icon.bg-violet { background: #f5f3ff; }
        .shortcut-icon.bg-amber { background: #fffbeb; }

        .shortcut-title {
            font-size: 0.85rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 0.15rem;
        }

        .shortcut-desc {
            font-size: 0.73rem;
            color: #64748b;
            line-height: 1.35;
        }

        .hover-lift {
            transition: all 0.2s ease;
        }
        .hover-lift:hover {
            transform: translateY(-2px);
        }
    </style>
@endsection
