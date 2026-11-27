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
                <li class="breadcrumb-item text-muted">Fitur AI</li>
                <li class="breadcrumb-item active text-dark fw-semibold" aria-current="page">Analisis Kurikulum</li>
            </ol>
        </nav>
        <div class="gap-2 d-flex align-items-center">
            <a href="{{ route('admin.supervisor-questionnaire.dashboard') }}" class="px-3 shadow-sm btn btn-sm btn-outline-secondary rounded-pill hover-lift">
                <i class="fa fa-chart-pie me-1"></i> Evaluasi Pengguna
            </a>
            <a href="{{ route('admin.prediksi.data') }}" class="px-3 shadow-sm btn btn-sm btn-outline-primary rounded-pill hover-lift">
                <i class="fa fa-brain me-1"></i> Prediksi Kelulusan
            </a>
        </div>
    </div>

    <!-- Hero Header Modern (AI Theme) -->
    <div class="mb-4 curriculum-hero">
        <div class="row align-items-center g-3">
            <div class="col-lg-8">
                <div class="flex-wrap gap-2 mb-2 d-flex align-items-center">
                    <span class="badge hero-badge">
                        <i class="fa fa-robot text-warning me-1"></i> Jagat AI Curriculum Intelligence
                    </span>
                    <span class="badge hero-badge-sub">
                        Evaluasi Kebutuhan Industri
                    </span>
                    @if ($analysisResult)
                        <span class="badge hero-badge-ready">
                            <i class="fa fa-check-circle text-emerald me-1"></i> Analisis Aktif Tersedia
                        </span>
                    @else
                        <span class="badge hero-badge-empty">
                            <i class="fa fa-info-circle text-info me-1"></i> Menunggu Pemrosesan AI
                        </span>
                    @endif
                </div>
                <h1 class="mb-2 text-white h3 fw-bold">
                    Analisis Kesenjangan Kurikulum & Kompetensi 🎯
                </h1>
                <p class="mb-0 text-white-50 small">
                    Pemetaan komprehensif keselarasan kurikulum Teknik Informatika Universitas Harkat Negeri dengan dinamika kebutuhan riil dunia industri berdasarkan integrasi tracer study alumni dan penilaian kepuasan atasan.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="gap-2 flex-column flex-sm-row flex-lg-column d-inline-flex align-items-lg-end">
                    <div class="hero-chip">
                        <i class="fa fa-calendar-alt text-warning"></i>
                        <span>{{ now()->translatedFormat('l, d F Y') }}</span>
                    </div>
                    <div class="hero-chip">
                        <i class="fa fa-microchip text-info"></i>
                        <span id="liveTimeCurriculum">{{ now()->format('H:i:s') }} WIB</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Notifications -->
    @if (session('success'))
        <div class="mb-4 border-0 shadow-sm alert alert-success alert-dismissible rounded-3 d-flex align-items-center" role="alert">
            <div class="p-2 text-white me-3 rounded-circle bg-success d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                <i class="fa fa-check"></i>
            </div>
            <div class="flex-grow-1">
                <div class="fw-bold text-dark">Berhasil!</div>
                <div class="text-secondary small">{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 border-0 shadow-sm alert alert-danger alert-dismissible rounded-3 d-flex align-items-center" role="alert">
            <div class="p-2 text-white me-3 rounded-circle bg-danger d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                <i class="fa fa-exclamation-triangle"></i>
            </div>
            <div class="flex-grow-1">
                <div class="fw-bold text-dark">Terjadi Kendala</div>
                <div class="text-secondary small">{{ session('error') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- 3 Top Metric Cards -->
    <div class="mb-4 row g-3">
        <!-- Kuesioner Alumni -->
        <div class="col-md-4">
            <div class="metric-card metric-blue h-100">
                <div class="metric-card-body">
                    <div class="mb-3 d-flex align-items-center justify-content-between">
                        <div class="metric-icon">
                            <i class="fa fa-user-graduate"></i>
                        </div>
                        <span class="metric-pill">Data Alumni</span>
                    </div>
                    <div class="metric-value stat-counter">{{ $totalAlumniTracer }}</div>
                    <div class="metric-label">Kuesioner Kompetensi Alumni Terisi</div>
                    <div class="metric-footer">
                        <a href="{{ route('listtraceralumni.index') }}" class="metric-link">
                            Lihat Responden Alumni <i class="fa fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Survei Atasan -->
        <div class="col-md-4">
            <div class="metric-card metric-emerald h-100">
                <div class="metric-card-body">
                    <div class="mb-3 d-flex align-items-center justify-content-between">
                        <div class="metric-icon">
                            <i class="fa fa-building"></i>
                        </div>
                        <span class="metric-pill">Industri & Mitra</span>
                    </div>
                    <div class="metric-value stat-counter">{{ $totalSupervisorTracer }}</div>
                    <div class="metric-label">Survei Pengguna Lulusan Selesai</div>
                    <div class="metric-footer">
                        <a href="{{ route('admin.supervisor-questionnaire.index', ['status' => 'completed']) }}" class="metric-link">
                            Daftar Penilaian Pengguna <i class="fa fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Masukan Industri -->
        <div class="col-md-4">
            <div class="metric-card metric-amber h-100">
                <div class="metric-card-body">
                    <div class="mb-3 d-flex align-items-center justify-content-between">
                        <div class="metric-icon">
                            <i class="fa fa-comments"></i>
                        </div>
                        <span class="metric-pill">Feedback Riil</span>
                    </div>
                    <div class="metric-value stat-counter">{{ count($suggestions) }}</div>
                    <div class="metric-label">Saran Perbaikan Kurikulum Industri</div>
                    <div class="metric-footer">
                        <a href="#section-suggestions" class="metric-link">
                            Telusuri Saran Industri <i class="fa fa-arrow-down ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts & Insight Section -->
    <div class="mb-4 row g-4">
        <!-- Radar Chart 3-Dimensi -->
        <div class="col-lg-7">
            <div class="panel-card h-100 d-flex flex-column">
                <div class="flex-wrap gap-2 panel-header d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="panel-icon bg-primary-soft text-primary me-3">
                            <i class="fa fa-chart-pie"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold text-dark">Radar Kompetensi 3 Dimensi</h5>
                            <p class="mb-0 text-muted small">Perbandingan evaluasi diri alumni (awal & sekarang) vs ekspektasi industri</p>
                        </div>
                    </div>
                    <span class="px-3 py-1 badge bg-primary-soft text-primary fw-bold rounded-pill">
                        Skala 1.0 – 5.0
                    </span>
                </div>
                <div class="panel-body flex-grow-1 d-flex flex-column justify-content-between">
                    @if ($totalAlumniTracer > 0 || $totalSupervisorTracer > 0)
                        <div class="mb-3 chart-container" style="height: 340px; position: relative;">
                            <canvas id="radarChartCompetencies"></canvas>
                        </div>

                        <!-- Legend Details Table/Grid -->
                        <div class="pt-3 row g-2 border-top">
                            <div class="col-sm-4">
                                <div class="p-2 border rounded-3 bg-light-subtle d-flex align-items-center">
                                    <span class="indicator-dot bg-primary me-2"></span>
                                    <div>
                                        <div class="fw-bold fs-xs text-dark">Kompetensi Awal</div>
                                        <div class="text-muted" style="font-size: 0.72rem;">Kondisi awal saat wisuda</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="p-2 border rounded-3 bg-light-subtle d-flex align-items-center">
                                    <span class="indicator-dot bg-emerald me-2"></span>
                                    <div>
                                        <div class="fw-bold fs-xs text-dark">Kompetensi Sekarang</div>
                                        <div class="text-muted" style="font-size: 0.72rem;">Kapasitas riil alumni saat ini</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="p-2 border rounded-3 bg-light-subtle d-flex align-items-center">
                                    <span class="indicator-dot bg-warning me-2"></span>
                                    <div>
                                        <div class="fw-bold fs-xs text-dark">Kepuasan Pengguna</div>
                                        <div class="text-muted" style="font-size: 0.72rem;">Standar kepuasan atasan kerja</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="py-5 my-auto text-center">
                            <div class="mx-auto mb-3 avatar-circle-lg bg-light text-muted">
                                <i class="fa fa-chart-bar fa-2x"></i>
                            </div>
                            <h6 class="fw-bold text-dark">Data Pengisian Belum Cukup</h6>
                            <p class="mb-0 text-muted small">Data kuesioner alumni atau evaluasi atasan belum mencukupi untuk membentuk grafik radar.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Masukan Terbaru dari Industri -->
        <div class="col-lg-5" id="section-suggestions">
            <div class="panel-card h-100 d-flex flex-column">
                <div class="flex-wrap gap-2 panel-header d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="panel-icon bg-warning-soft text-warning me-3">
                            <i class="fa fa-comments"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold text-dark">Masukan Terbaru Industri</h5>
                            <p class="mb-0 text-muted small">Saran nyata stakeholder & pimpinan tempat alumni bekerja</p>
                        </div>
                    </div>
                    <span class="px-2 py-1 badge bg-warning-soft text-warning fw-bold rounded-pill fs-xs">
                        {{ count($suggestions) }} Masukan
                    </span>
                </div>
                <div class="p-3 panel-body flex-grow-1 d-flex flex-column">
                    <div class="suggestion-list-scroll flex-grow-1 pe-1">
                        @forelse ($suggestions as $index => $sug)
                            <div class="p-3 mb-2 bg-white border shadow-xs suggestion-card rounded-3">
                                <div class="mb-1 d-flex align-items-center justify-content-between">
                                    <div class="gap-1 d-flex align-items-center text-primary fs-xs fw-semibold">
                                        <i class="opacity-50 fa fa-quote-left me-1"></i> Feedback Stakeholder #{{ $index + 1 }}
                                    </div>
                                    <span class="border badge bg-light text-muted fs-xs">Pengguna</span>
                                </div>
                                <p class="mb-0 text-secondary fs-sm" style="line-height: 1.55;">
                                    "{{ $sug }}"
                                </p>
                            </div>
                        @empty
                            <div class="py-5 my-auto text-center">
                                <div class="mx-auto mb-3 avatar-circle-lg bg-light text-muted">
                                    <i class="fa fa-comment-slash fa-2x"></i>
                                </div>
                                <h6 class="fw-bold text-dark">Belum Ada Saran Masuk</h6>
                                <p class="mb-0 text-muted small">Belum ada saran perbaikan kurikulum dari instansi pengguna saat ini.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- AI Analysis Report Section -->
    <div class="mb-4 panel-card" id="ai-analysis-card">
        <div class="flex-wrap gap-3 panel-header d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <div class="panel-icon bg-emerald-soft text-emerald me-3">
                    <i class="fa fa-robot"></i>
                </div>
                <div>
                    <div class="flex-wrap gap-2 d-flex align-items-center">
                        <h5 class="mb-0 fw-bold text-dark">Rekomendasi Pembaruan Kurikulum (Jagat AI)</h5>
                        <span class="px-2 py-1 badge bg-emerald-soft text-emerald rounded-pill fs-xs fw-semibold">
                            DeepSeek / LLM Intelligence
                        </span>
                    </div>
                    <p class="mb-0 text-muted small">Laporan evaluasi komprehensif, kesenjangan kompetensi, dan usulan pembaruan mata kuliah</p>
                </div>
            </div>

            <div class="gap-2 d-flex align-items-center">
                @if ($analysisResult)
                    <button type="button" class="px-3 btn btn-sm btn-outline-secondary rounded-pill" onclick="window.printReportContent()">
                        <i class="fa fa-print me-1"></i> Cetak Laporan
                    </button>
                    <form class="form-generate-analysis d-inline-block" method="POST"
                        action="{{ route('admin.curriculum-analysis.generate') }}"
                        onsubmit="return window.handleCurriculumAnalysisSubmit(event, this);">
                        @csrf
                        <button type="submit" class="px-3 shadow-xs btn btn-sm btn-success rounded-pill hover-lift btn-analyze-analysis">
                            <span class="btn-text-analysis"><i class="fa fa-sync-alt me-1"></i> Perbarui Analisis AI</span>
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <div class="p-4 panel-body">
            @if ($analysisResult)
                <!-- Report Hero Header inside Card -->
                <div class="flex-wrap gap-2 p-3 mb-4 border rounded-3 bg-gradient-light d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="p-2 bg-white shadow-xs me-3 rounded-3 text-primary">
                            <i class="fa fa-file-alt fa-lg"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark fs-sm">Dokumen Rekomendasi Kurikulum Akademik</div>
                            <div class="text-muted" style="font-size: 0.75rem;">
                                Digenerasi berdasarkan {{ $totalAlumniTracer }} data alumni dan {{ $totalSupervisorTracer }} data pengguna lulusan
                            </div>
                        </div>
                    </div>
                    <div>
                        <span class="px-3 py-1 bg-white border badge text-secondary rounded-pill fs-xs">
                            <i class="fa fa-history text-primary me-1"></i> Tersimpan di Cache Aktif
                        </span>
                    </div>
                </div>

                <!-- Markdown Content Render Container -->
                <div class="p-4 bg-white border shadow-xs rounded-3 markdown-rendered-box" id="ai-markdown-content">
                    {{ $analysisResult }}
                </div>
            @else
                <div class="px-3 py-5 text-center border-2 border-dashed rounded-3 bg-light-subtle">
                    <div class="mx-auto mb-3 avatar-circle-xl bg-success-soft text-success">
                        <i class="fa fa-brain fa-2x"></i>
                    </div>
                    <h5 class="mb-1 fw-bold text-dark">Analisis Kurikulum Belum Dibuat</h5>
                    <p class="mx-auto mb-4 text-muted small" style="max-width: 520px;">
                        Sistem belum menjalankan pemetaan kesenjangan kompetensi untuk data terkini. Klik tombol di bawah untuk memproses data kuesioner alumni dan survei industri menggunakan Jagat AI.
                    </p>
                    <form class="form-generate-analysis" method="POST"
                        action="{{ route('admin.curriculum-analysis.generate') }}"
                        onsubmit="return window.handleCurriculumAnalysisSubmit(event, this);">
                        @csrf
                        <button type="submit" class="px-4 py-2 shadow-sm btn btn-success rounded-pill hover-lift btn-analyze-analysis">
                            <span class="btn-text-analysis"><i class="fa fa-play me-2"></i> Mulai Analisis AI Sekarang</span>
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>

    <!-- Quick Navigation Shortcuts -->
    <div class="mb-4 row g-3">
        <div class="col-md-4">
            <a href="{{ route('admin.supervisor-questionnaire.index') }}" class="shortcut-box">
                <div class="shortcut-icon bg-blue text-primary">
                    <i class="fa fa-user-check"></i>
                </div>
                <div>
                    <div class="shortcut-title">Daftar Survei Pengguna</div>
                    <div class="shortcut-desc">Kelola kuesioner atasan, pantau progres, & kirim tautan</div>
                </div>
                <i class="fa fa-chevron-right ms-auto text-muted fs-xs"></i>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('admin.prediksi.data') }}" class="shortcut-box">
                <div class="shortcut-icon bg-amber text-warning">
                    <i class="fa fa-brain"></i>
                </div>
                <div>
                    <div class="shortcut-title">Prediksi Kelulusan & Karir</div>
                    <div class="shortcut-desc">Simulasi kecerdasan buatan untuk profil kelulusan mahasiswa</div>
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
                    <div class="shortcut-desc">Statistik gabungan alumni, waktu tunggu, dan gaji pertama</div>
                </div>
                <i class="fa fa-chevron-right ms-auto text-muted fs-xs"></i>
            </a>
        </div>
    </div>

    <!-- Full-screen AI Loading Modal (High-Tech Orbital Animation) -->
    <div id="ai-global-loading-modal" class="ai-loading-backdrop" aria-hidden="true" style="display: none;">
        <div class="ai-loading-dialog">
            <div class="mx-auto mb-3 ai-orbital-spinner">
                <div class="ai-ring ai-ring-outer"></div>
                <div class="ai-ring ai-ring-inner"></div>
                <div class="ai-core-icon">
                    <i class="fa fa-brain"></i>
                </div>
            </div>
            <span class="px-3 py-1 mb-2 badge bg-success-soft text-emerald rounded-pill fw-semibold fs-xs">
                <i class="fa fa-sparkles me-1"></i> Jagat AI Processing Engine
            </span>
            <h5 class="mb-1 fw-bold text-dark" id="ai-loading-title">Menganalisis Kurikulum...</h5>
            <p class="px-2 mb-3 text-muted small" id="ai-loading-step-text">
                Mengumpulkan data kompetensi alumni & survei pengguna lulusan...
            </p>
            <div class="mb-3 ai-progress-track">
                <div class="ai-progress-fill" id="ai-loading-progress-bar" style="width: 15%;"></div>
            </div>
            <div class="d-flex justify-content-between align-items-center text-muted" style="font-size: 0.78rem;">
                <span><i class="fa fa-circle-notch fa-spin text-success me-1"></i> Mohon jangan tutup halaman</span>
                <span class="fw-semibold text-dark" id="ai-loading-timer">0 dtk</span>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Marked JS for parsing markdown to HTML beautifully -->
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Live Clock
            function updateCurriculumClock() {
                const now = new Date();
                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');
                const seconds = String(now.getSeconds()).padStart(2, '0');
                const el = document.getElementById('liveTimeCurriculum');
                if (el) el.innerText = `${hours}:${minutes}:${seconds} WIB`;
            }
            setInterval(updateCurriculumClock, 1000);

            // Counter Animation
            if (typeof jQuery !== 'undefined') {
                $('.stat-counter').each(function() {
                    const $this = $(this);
                    const countTo = parseInt($this.text()) || 0;
                    $({ countNum: 0 }).animate({ countNum: countTo }, {
                        duration: 1000,
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

            // Convert Markdown content to HTML
            const markdownContainer = document.getElementById('ai-markdown-content');
            if (markdownContainer && typeof marked !== 'undefined') {
                const rawMarkdown = markdownContainer.innerHTML.trim();
                const unescapedMarkdown = rawMarkdown
                    .replace(/&amp;/g, '&')
                    .replace(/&lt;/g, '<')
                    .replace(/&gt;/g, '>')
                    .replace(/&quot;/g, '"')
                    .replace(/&#039;/g, "'");
                markdownContainer.innerHTML = marked.parse(unescapedMarkdown);
            }

            // Radar Chart 3-Dimensi
            const ctxRadar = document.getElementById('radarChartCompetencies');
            if (ctxRadar && typeof Chart !== 'undefined') {
                const fontFamily = "'Plus Jakarta Sans', 'Inter', sans-serif";

                new Chart(ctxRadar.getContext('2d'), {
                    type: 'radar',
                    data: {
                        labels: [
                            'Etika & Moral',
                            'Keahlian Bidang',
                            'Bahasa Inggris',
                            'Penguasaan TI',
                            'Kerjasama Tim',
                            'Komunikasi',
                            'Pengembangan Diri'
                        ],
                        datasets: [
                            {
                                label: 'Kompetensi Awal (Alumni)',
                                data: [
                                    {{ $competencyStats->etika_awal ?? 0 }},
                                    {{ $competencyStats->keahlian_awal ?? 0 }},
                                    {{ $competencyStats->bahasa_inggris_awal ?? 0 }},
                                    {{ $competencyStats->teknologi_awal ?? 0 }},
                                    {{ $competencyStats->kerjasama_awal ?? 0 }},
                                    {{ $competencyStats->komunikasi_awal ?? 0 }},
                                    {{ $competencyStats->pengembangan_awal ?? 0 }}
                                ],
                                backgroundColor: 'rgba(59, 130, 246, 0.22)',
                                borderColor: '#3b82f6',
                                pointBackgroundColor: '#2563eb',
                                pointBorderColor: '#ffffff',
                                pointHoverBackgroundColor: '#ffffff',
                                pointHoverBorderColor: '#2563eb',
                                pointRadius: 4,
                                pointHoverRadius: 6,
                                borderWidth: 2
                            },
                            {
                                label: 'Kompetensi Sekarang (Alumni)',
                                data: [
                                    {{ $competencyStats->etika_sekarang ?? 0 }},
                                    {{ $competencyStats->keahlian_sekarang ?? 0 }},
                                    {{ $competencyStats->bahasa_inggris_sekarang ?? 0 }},
                                    {{ $competencyStats->teknologi_sekarang ?? 0 }},
                                    {{ $competencyStats->kerjasama_sekarang ?? 0 }},
                                    {{ $competencyStats->komunikasi_sekarang ?? 0 }},
                                    {{ $competencyStats->pengembangan_sekarang ?? 0 }}
                                ],
                                backgroundColor: 'rgba(16, 185, 129, 0.22)',
                                borderColor: '#10b981',
                                pointBackgroundColor: '#059669',
                                pointBorderColor: '#ffffff',
                                pointHoverBackgroundColor: '#ffffff',
                                pointHoverBorderColor: '#059669',
                                pointRadius: 4,
                                pointHoverRadius: 6,
                                borderWidth: 2
                            },
                            {
                                label: 'Kepuasan Pengguna (Atasan)',
                                data: [
                                    {{ $supervisorStats->integritas ?? 0 }},
                                    {{ $supervisorStats->keahlian ?? 0 }},
                                    {{ $supervisorStats->kemampuan ?? 0 }},
                                    {{ $supervisorStats->penguasaan ?? 0 }},
                                    {{ $supervisorStats->komunikasi ?? 0 }},
                                    {{ $supervisorStats->kerja_tim ?? 0 }},
                                    {{ $supervisorStats->pengembangan ?? 0 }}
                                ],
                                backgroundColor: 'rgba(245, 158, 11, 0.22)',
                                borderColor: '#f59e0b',
                                pointBackgroundColor: '#d97706',
                                pointBorderColor: '#ffffff',
                                pointHoverBackgroundColor: '#ffffff',
                                pointHoverBorderColor: '#d97706',
                                pointRadius: 4,
                                pointHoverRadius: 6,
                                borderWidth: 2
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    usePointStyle: true,
                                    pointStyle: 'circle',
                                    padding: 16,
                                    boxWidth: 8,
                                    font: {
                                        size: 11,
                                        family: fontFamily,
                                        weight: '600'
                                    },
                                    color: '#475569'
                                }
                            },
                            tooltip: {
                                backgroundColor: '#0f172a',
                                titleFont: { size: 12, family: fontFamily, weight: 'bold' },
                                bodyFont: { size: 11, family: fontFamily },
                                padding: 10,
                                cornerRadius: 8,
                                callbacks: {
                                    label: function(context) {
                                        return ` ${context.dataset.label}: ${context.raw ? Number(context.raw).toFixed(2) : '0'} / 5.0`;
                                    }
                                }
                            }
                        },
                        scales: {
                            r: {
                                angleLines: { display: true, color: 'rgba(226, 232, 240, 0.8)' },
                                grid: { color: 'rgba(226, 232, 240, 0.8)' },
                                pointLabels: {
                                    font: {
                                        size: window.innerWidth < 576 ? 9 : 11,
                                        weight: '600',
                                        family: fontFamily
                                    },
                                    color: '#1e293b'
                                },
                                ticks: {
                                    backdropColor: 'transparent',
                                    color: '#94a3b8',
                                    font: { size: 9, family: fontFamily },
                                    stepSize: 1
                                },
                                min: 0,
                                max: 5
                            }
                        }
                    }
                });
            }
        });

        // Submit Handler with High-tech orbital modal
        window.handleCurriculumAnalysisSubmit = function (event, form) {
            if (form.dataset.submitting === 'true') {
                if (event) event.preventDefault();
                return false;
            }
            form.dataset.submitting = 'true';

            const btn = form.querySelector('.btn-analyze-analysis');
            const btnText = form.querySelector('.btn-text-analysis');
            const modal = document.getElementById('ai-global-loading-modal');
            const stepText = document.getElementById('ai-loading-step-text');
            const titleText = document.getElementById('ai-loading-title');
            const progressBar = document.getElementById('ai-loading-progress-bar');
            const timerEl = document.getElementById('ai-loading-timer');

            if (btn) {
                btn.disabled = true;
                btn.classList.add('disabled');
            }
            if (btnText) {
                btnText.innerHTML = '<i class="fa fa-circle-notch fa-spin me-2"></i> Sedang Menganalisis...';
            }
            if (modal) {
                modal.style.display = 'flex';
                modal.setAttribute('aria-hidden', 'false');
            }

            if (typeof window.fetch !== 'function') {
                return true;
            }

            if (event) event.preventDefault();

            const steps = [
                { at: 0, pct: 15, text: 'Mengumpulkan data kompetensi alumni & survei pengguna lulusan...' },
                { at: 3, pct: 40, text: 'Menghubungkan ke Jagat AI & memetakan kesenjangan kompetensi...' },
                { at: 7, pct: 65, text: 'Menyusun rekomendasi pembaruan mata kuliah & strategi prodi...' },
                { at: 12, pct: 85, text: 'Merapikan format laporan evaluasi penjaminan mutu akademik...' },
                { at: 18, pct: 95, text: 'Hampir selesai, memfinalisasi ringkasan rekomendasi kurikulum...' }
            ];

            let seconds = 0;
            const intervalId = setInterval(function () {
                seconds++;
                if (timerEl) timerEl.textContent = seconds + ' dtk';
                for (let i = steps.length - 1; i >= 0; i--) {
                    if (seconds >= steps[i].at) {
                        if (stepText) stepText.textContent = steps[i].text;
                        if (progressBar) progressBar.style.width = steps[i].pct + '%';
                        break;
                    }
                }
            }, 1000);

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                },
                body: new FormData(form)
            })
                .then(function () {
                    clearInterval(intervalId);
                    if (progressBar) progressBar.style.width = '100%';
                    if (titleText) titleText.textContent = 'Analisis Selesai!';
                    if (stepText) stepText.textContent = 'Memuat pembaruan laporan kurikulum...';
                    setTimeout(function () {
                        window.location.reload();
                    }, 400);
                })
                .catch(function () {
                    clearInterval(intervalId);
                    window.location.reload();
                });

            return false;
        };

        // Print Report
        window.printReportContent = function() {
            const printContent = document.getElementById('ai-markdown-content');
            if (!printContent) return;
            const originalTitle = document.title;
            document.title = 'Laporan_Analisis_Kurikulum_TI_UHN';
            window.print();
            document.title = originalTitle;
        };
    </script>
@endsection

@section('styles')
    <style>
        /* Hero Banner */
        .curriculum-hero {
            background: linear-gradient(135deg, #0f172a 0%, #134e4a 50%, #065f46 100%);
            border-radius: 1rem;
            padding: 1.6rem 1.85rem;
            box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.2);
            position: relative;
            overflow: hidden;
        }

        .curriculum-hero::after {
            content: '';
            position: absolute;
            top: -60px;
            right: -60px;
            width: 240px;
            height: 240px;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.25) 0%, rgba(255, 255, 255, 0) 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .hero-badge {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(8px);
            color: #ffffff;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.4rem 0.75rem;
            border-radius: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .hero-badge-sub {
            background: rgba(16, 185, 129, 0.25);
            color: #6ee7b7;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.4rem 0.75rem;
            border-radius: 2rem;
            border: 1px solid rgba(16, 185, 129, 0.35);
        }

        .hero-badge-ready {
            background: rgba(16, 185, 129, 0.3);
            color: #a7f3d0;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.4rem 0.75rem;
            border-radius: 2rem;
            border: 1px solid rgba(16, 185, 129, 0.4);
        }

        .hero-badge-empty {
            background: rgba(14, 165, 233, 0.2);
            color: #7dd3fc;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.4rem 0.75rem;
            border-radius: 2rem;
            border: 1px solid rgba(14, 165, 233, 0.3);
        }

        .hero-chip {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 2rem;
            padding: 0.45rem 1rem;
            color: #e2e8f0;
            font-size: 0.8rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            backdrop-filter: blur(4px);
        }

        /* Metric Cards */
        .metric-card {
            background: #ffffff;
            border-radius: 0.875rem;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04);
            position: relative;
            overflow: hidden;
            transition: all 0.2s ease;
        }

        .metric-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 20px -5px rgba(15, 23, 42, 0.08);
            border-color: #cbd5e1;
        }

        .metric-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3.5px;
        }

        .metric-blue::before { background: linear-gradient(90deg, #3b82f6, #60a5fa); }
        .metric-emerald::before { background: linear-gradient(90deg, #10b981, #34d399); }
        .metric-amber::before { background: linear-gradient(90deg, #f59e0b, #fbbf24); }

        .metric-card-body {
            padding: 1.35rem 1.4rem;
        }

        .metric-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .metric-blue .metric-icon { background: rgba(59, 130, 246, 0.1); color: #2563eb; }
        .metric-emerald .metric-icon { background: rgba(16, 185, 129, 0.1); color: #059669; }
        .metric-amber .metric-icon { background: rgba(245, 158, 11, 0.1); color: #d97706; }

        .metric-pill {
            font-size: 0.72rem;
            font-weight: 600;
            padding: 0.25rem 0.65rem;
            border-radius: 2rem;
            background: #f1f5f9;
            color: #475569;
        }

        .metric-value {
            font-size: 1.85rem;
            font-weight: 700;
            color: #0f172a;
            line-height: 1.2;
            margin-bottom: 0.25rem;
        }

        .metric-label {
            font-size: 0.82rem;
            color: #64748b;
            margin-bottom: 1rem;
            font-weight: 500;
        }

        .metric-footer {
            border-top: 1px solid #f1f5f9;
            padding-top: 0.75rem;
        }

        .metric-link {
            font-size: 0.78rem;
            font-weight: 600;
            color: #3b82f6;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            transition: all 0.15s ease;
        }

        .metric-link:hover {
            color: #1d4ed8;
            transform: translateX(3px);
        }

        /* Panel Card */
        .panel-card {
            background: #ffffff;
            border-radius: 0.875rem;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04);
            overflow: hidden;
        }

        .panel-header {
            padding: 1.25rem 1.4rem;
            border-bottom: 1px solid #f1f5f9;
        }

        .panel-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.05rem;
        }

        .panel-body {
            padding: 1.4rem;
        }

        /* Helpers */
        .bg-primary-soft { background-color: rgba(59, 130, 246, 0.1) !important; color: #2563eb !important; }
        .bg-emerald-soft { background-color: rgba(16, 185, 129, 0.1) !important; color: #059669 !important; }
        .bg-warning-soft { background-color: rgba(245, 158, 11, 0.1) !important; color: #d97706 !important; }
        .text-emerald { color: #059669 !important; }
        .bg-emerald { background-color: #10b981 !important; }

        .indicator-dot {
            width: 9px;
            height: 9px;
            border-radius: 50%;
            display: inline-block;
            flex-shrink: 0;
        }

        /* Suggestions Scroll */
        .suggestion-list-scroll {
            max-height: 420px;
            overflow-y: auto;
        }

        .suggestion-list-scroll::-webkit-scrollbar {
            width: 5px;
        }

        .suggestion-list-scroll::-webkit-scrollbar-track {
            background: #f8fafc;
            border-radius: 8px;
        }

        .suggestion-list-scroll::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 8px;
        }

        .suggestion-card {
            border-left: 3.5px solid #f59e0b !important;
            transition: all 0.18s ease;
        }

        .suggestion-card:hover {
            transform: translateX(3px);
            border-color: #d97706 !important;
            background: #fffbeb !important;
        }

        /* Markdown Styling inside content */
        .markdown-rendered-box {
            font-size: 0.94rem;
            line-height: 1.8;
            color: #334155;
        }

        .markdown-rendered-box h2,
        .markdown-rendered-box h3 {
            font-size: 1.15rem;
            font-weight: 700;
            color: #0f172a;
            margin-top: 1.75rem;
            margin-bottom: 0.85rem;
            border-bottom: 2px solid #f1f5f9;
            padding-bottom: 0.5rem;
            display: flex;
            align-items: center;
        }

        .markdown-rendered-box h2::before,
        .markdown-rendered-box h3::before {
            content: '';
            display: inline-block;
            width: 4px;
            height: 1.15rem;
            background: #10b981;
            margin-right: 0.55rem;
            border-radius: 2px;
        }

        .markdown-rendered-box h3:first-child,
        .markdown-rendered-box h2:first-child {
            margin-top: 0;
        }

        .markdown-rendered-box p {
            margin-bottom: 1.1rem;
            color: #475569;
        }

        .markdown-rendered-box ul,
        .markdown-rendered-box ol {
            padding-left: 1.4rem;
            margin-bottom: 1.25rem;
        }

        .markdown-rendered-box li {
            margin-bottom: 0.45rem;
            color: #334155;
        }

        .markdown-rendered-box strong {
            color: #0f172a;
            font-weight: 600;
        }

        /* Shortcut Cards */
        .shortcut-box {
            background: #ffffff;
            border-radius: 0.875rem;
            border: 1px solid #e2e8f0;
            padding: 1.15rem 1.25rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .shortcut-box:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px -5px rgba(15, 23, 42, 0.08);
            border-color: #cbd5e1;
        }

        .shortcut-icon {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .shortcut-icon.bg-blue { background: rgba(59, 130, 246, 0.1); }
        .shortcut-icon.bg-amber { background: rgba(245, 158, 11, 0.1); }
        .shortcut-icon.bg-violet { background: rgba(139, 92, 246, 0.1); }

        .shortcut-title {
            font-size: 0.875rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 0.15rem;
        }

        .shortcut-desc {
            font-size: 0.75rem;
            color: #64748b;
            line-height: 1.35;
        }

        /* Avatar Circles */
        .avatar-circle-lg {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .avatar-circle-xl {
            width: 68px;
            height: 68px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Full-Screen AI Loading Modal */
        .ai-loading-backdrop {
            position: fixed;
            inset: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(15, 23, 42, 0.68);
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            padding: 1rem;
            animation: aiFadeIn 0.25s ease-out;
        }

        .ai-loading-dialog {
            background: #ffffff;
            width: 100%;
            max-width: 420px;
            border-radius: 24px;
            padding: 2rem 1.75rem;
            text-align: center;
            box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.35);
            border: 1px solid rgba(226, 232, 240, 0.9);
            animation: aiPopUp 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .ai-orbital-spinner {
            position: relative;
            width: 84px;
            height: 84px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .ai-ring {
            position: absolute;
            border-radius: 50%;
            border-style: solid;
        }

        .ai-ring-outer {
            width: 84px;
            height: 84px;
            border-width: 3px;
            border-color: rgba(16, 185, 129, 0.15);
            border-top-color: #10b981;
            border-right-color: #10b981;
            animation: aiSpin 1.15s linear infinite;
        }

        .ai-ring-inner {
            width: 64px;
            height: 64px;
            border-width: 3px;
            border-color: rgba(14, 165, 233, 0.15);
            border-bottom-color: #0ea5e9;
            border-left-color: #0ea5e9;
            animation: aiSpinReverse 1.5s linear infinite;
        }

        .ai-core-icon {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            box-shadow: 0 8px 18px rgba(16, 185, 129, 0.35);
            animation: aiPulseCore 1.6s ease-in-out infinite;
        }

        .ai-progress-track {
            width: 100%;
            height: 8px;
            background: #f1f5f9;
            border-radius: 999px;
            overflow: hidden;
        }

        .ai-progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #10b981 0%, #0ea5e9 50%, #10b981 100%);
            background-size: 200% 100%;
            border-radius: 999px;
            transition: width 0.6s ease;
            animation: aiShimmer 1.8s linear infinite;
        }

        @keyframes aiSpin { to { transform: rotate(360deg); } }
        @keyframes aiSpinReverse { to { transform: rotate(-360deg); } }
        @keyframes aiPulseCore { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.08); } }
        @keyframes aiShimmer { 0% { background-position: 200% 0; } 100% { background-position: -200% 0; } }
        @keyframes aiFadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes aiPopUp { from { opacity: 0; transform: translateY(14px) scale(0.96); } to { opacity: 1; transform: translateY(0) scale(1); } }

        /* Print Media Styles */
        @media print {
            body * {
                visibility: hidden;
            }
            #ai-markdown-content, #ai-markdown-content * {
                visibility: visible;
            }
            #ai-markdown-content {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                border: none !important;
                box-shadow: none !important;
                padding: 0 !important;
            }
        }
    </style>
@endsection
