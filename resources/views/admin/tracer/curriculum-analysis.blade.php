@extends('layouts.admin')

@section('content')
    <div class="content content-full">
        <!-- Premium Hero Section -->
        <div class="card border-0 shadow-lg mb-4 mb-md-5 overflow-hidden"
            style="background: linear-gradient(135deg, #0f2027 0%, #203a43 50%, #2c5364 100%);">
            <div class="card-body p-4 p-md-5 position-relative">
                <div class="row align-items-center">
                    <div class="col-lg-9 col-xl-8 position-relative" style="z-index: 2;">
                        <span
                            class="badge bg-success-light text-success rounded-pill px-3 py-2 mb-3 border border-success-10 fs-xs fw-bold">
                            <i class="fa fa-robot me-1"></i> AI Powered Analysis
                        </span>
                        <h1 class="display-6 fw-bold text-white mb-2 fs-2 fs-md-1">Analisis Kesenjangan Kurikulum</h1>
                        <p class="lead text-white mb-0 fs-6 fs-md-5">
                            Evaluasi keselarasan kurikulum Teknik Informatika Universitas Harkat Negeri dengan kebutuhan
                            riil dunia industri berdasarkan integrasi data kuesioner alumni dan survei pengguna lulusan.
                        </p>
                    </div>
                </div>
                <!-- Background decor -->
                <div class="position-absolute top-50 end-0 translate-middle-y p-5 opacity-10 d-none d-lg-block"
                    style="z-index: 1;">
                    <i class="fa fa-chart-line fa-10x text-white"></i>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible border-0 shadow-sm rounded-4 mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fa fa-check-circle fa-2x me-3"></i>
                    <div>
                        <h5 class="alert-heading fw-bold mb-1">Berhasil!</h5>
                        <p class="mb-0">{{ session('success') }}</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible border-0 shadow-sm rounded-4 mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fa fa-exclamation-circle fa-2x me-3"></i>
                    <div>
                        <h5 class="alert-heading fw-bold mb-1">Terjadi Kesalahan</h5>
                        <p class="mb-0">{{ session('error') }}</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Stats Overview Cards -->
        <div class="row g-3 g-md-4 mb-4 mb-md-5">
            <div class="col-12 col-md-4">
                <div class="card border-0 shadow-sm rounded-4 h-100 p-3 bg-white">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="icon-circle bg-primary-light text-primary" style="width: 45px; height: 45px;">
                            <i class="fa fa-user-graduate"></i>
                        </div>
                        <span class="badge bg-primary-light text-primary rounded-pill px-2 py-1 fs-xs">Alumni</span>
                    </div>
                    <h3 class="fw-bold mb-1 fs-2 fs-md-1">{{ $totalAlumniTracer }}</h3>
                    <p class="text-muted small mb-0">Kuesioner Kompetensi Alumni Terisi</p>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card border-0 shadow-sm rounded-4 h-100 p-3 bg-white">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="icon-circle bg-success-light text-success" style="width: 45px; height: 45px;">
                            <i class="fa fa-building"></i>
                        </div>
                        <span class="badge bg-success-light text-success rounded-pill px-2 py-1 fs-xs">Supervisor</span>
                    </div>
                    <h3 class="fw-bold mb-1 fs-2 fs-md-1">{{ $totalSupervisorTracer }}</h3>
                    <p class="text-muted small mb-0">Survei Atasan/Pengguna Lulusan Selesai</p>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card border-0 shadow-sm rounded-4 h-100 p-3 bg-white">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="icon-circle bg-warning-light text-warning" style="width: 45px; height: 45px;">
                            <i class="fa fa-comment-dots"></i>
                        </div>
                        <span class="badge bg-warning-light text-warning rounded-pill px-2 py-1 fs-xs">Saran</span>
                    </div>
                    <h3 class="fw-bold mb-1 fs-2 fs-md-1">{{ count($suggestions) }}</h3>
                    <p class="text-muted small mb-0">Saran Perbaikan Industri Terkumpul</p>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-5">
            <!-- Left Side: Competency Gap Visualization -->
            <div class="col-12 col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                    <div class="card-header bg-white py-3 px-3 px-md-4 border-0">
                        <div class="d-flex align-items-center">
                            <div class="icon-circle bg-primary-light text-primary me-3" style="width: 40px; height: 40px;">
                                <i class="fa fa-chart-pie"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold text-dark mb-0 fs-5">Radar Kompetensi 3 Dimensi</h5>
                                <p class="text-muted small mb-0">Perbandingan evaluasi diri alumni vs ekspektasi industri
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-3 p-md-4 pt-0">
                        @if ($totalAlumniTracer > 0 || $totalSupervisorTracer > 0)
                            <div class="chart-container py-3">
                                <canvas id="radarChartCompetencies"></canvas>
                            </div>
                            <div class="p-3 bg-light rounded-4 mt-2">
                                <div class="row g-2 fs-xs text-muted">
                                    <div class="col-12">
                                        <i class="fa fa-info-circle text-primary me-1"></i>
                                        <strong>Kompetensi Awal:</strong> Kondisi saat alumni pertama kali lulus.
                                    </div>
                                    <div class="col-12">
                                        <i class="fa fa-info-circle text-success me-1"></i>
                                        <strong>Kompetensi Sekarang:</strong> Perkembangan kompetensi alumni di lapangan kerja.
                                    </div>
                                    <div class="col-12">
                                        <i class="fa fa-info-circle text-warning me-1"></i>
                                        <strong>Kepuasan Atasan:</strong> Penilaian riil dari manajer/supervisor di industri.
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fa fa-chart-bar fa-3x text-muted mb-3"></i>
                                <p class="text-muted mb-0">Data pengisian tracer study belum mencukupi untuk menampilkan grafik.
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Side: Suggestions List -->
            <div class="col-12 col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                    <div class="card-header bg-white py-3 px-3 px-md-4 border-0">
                        <div class="d-flex align-items-center">
                            <div class="icon-circle bg-warning-light text-warning me-3" style="width: 40px; height: 40px;">
                                <i class="fa fa-comments"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold text-dark mb-0 fs-5">Masukan Terbaru dari Industri</h5>
                                <p class="text-muted small mb-0">Saran perbaikan kurikulum dari atasan tempat bekerja</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-3 p-md-4 pt-0">
                        <div class="suggestion-list-scroll">
                            @forelse ($suggestions as $sug)
                                <div class="p-3 rounded-4 bg-light-soft border-start border-4 border-warning mb-3">
                                    <p class="mb-0 text-dark-75 small italic">"{{ $sug }}"</p>
                                </div>
                            @empty
                                <div class="text-center py-5">
                                    <i class="fa fa-comment-slash fa-3x text-muted mb-3"></i>
                                    <p class="text-muted mb-0">Belum ada saran masuk dari atasan alumni.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- AI Analysis Result Section -->
        <div class="card border-0 shadow-sm rounded-4 mb-5 position-relative" id="ai-analysis-card">
            <!-- Loading Overlay -->
            <div id="loading-overlay" class="loading-overlay d-none">
                <div class="text-center py-5 px-3">
                    <div class="spinner-border text-success mb-3" role="status" style="width: 3.5rem; height: 3.5rem;">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <h5 class="fw-bold text-dark mt-2 fs-5">Menganalisis Kurikulum dengan Gemini AI</h5>
                    <p class="text-muted small mb-0">Harap tunggu, proses ini memakan waktu beberapa detik...</p>
                </div>
            </div>

            <div class="card-header bg-white py-3 px-3 px-md-4 border-0">
                <div class="d-flex align-items-center justify-content-between flex-wrap g-2">
                    <div class="d-flex align-items-center">
                        <div class="icon-circle bg-success-light text-success me-3" style="width: 40px; height: 40px;">
                            <i class="fa fa-robot"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold text-dark mb-0 fs-5">Rekomendasi Pembaruan Kurikulum (AI)</h5>
                            <p class="text-muted small mb-0">Laporan analisis komprehensif yang dihasilkan oleh Gemini AI
                            </p>
                        </div>
                    </div>
                    @if ($analysisResult)
                        <span class="badge bg-secondary-light text-secondary rounded-pill px-3 py-1 fs-xs border">
                            <i class="fa fa-clock me-1"></i> Data Teranalisis
                        </span>
                    @endif
                </div>
            </div>
            <div class="card-body p-3 p-md-4 pt-0">
                @if ($analysisResult)
                    <div class="p-3 p-md-4 rounded-4 bg-light border border-light-dark" id="ai-markdown-content"
                        style="line-height: 1.8; font-size: 0.95rem;">
                        {{ $analysisResult }}
                    </div>
                    <div class="text-center mt-4">
                        <form class="form-generate-analysis" method="POST"
                            action="{{ route('admin.curriculum-analysis.generate') }}">
                            @csrf
                            <button type="submit"
                                class="btn btn-success rounded-pill px-4 hover-scale btn-analyze-analysis w-100 w-sm-auto">
                                <i class="fa fa-sync-alt fa-spin me-2 d-none loader-icon-analysis"></i>
                                <span class="btn-text-analysis"><i class="fa fa-sync-alt me-2"></i> Perbarui Analisis AI</span>
                            </button>
                        </form>
                    </div>
                @else
                    <div class="text-center py-4 py-md-5 border border-dashed rounded-4 bg-light px-3">
                        <div class="icon-circle bg-success-light text-success mx-auto mb-3" style="width: 65px; height: 65px;">
                            <i class="fa fa-brain fa-2x"></i>
                        </div>
                        <h5 class="fw-bold text-dark">Analisis Belum Dibuat</h5>
                        <p class="text-muted small mb-4 px-3" style="max-width: 500px; margin: 0 auto;">
                            Sistem belum memproses analisis kesenjangan kurikulum untuk periode ini. Silakan klik tombol di
                            bawah untuk meminta Gemini AI menganalisis data saat ini.
                        </p>
                        <form class="form-generate-analysis" method="POST"
                            action="{{ route('admin.curriculum-analysis.generate') }}">
                            @csrf
                            <button type="submit"
                                class="btn btn-success rounded-pill px-4 hover-scale btn-analyze-analysis w-100 w-sm-auto">
                                <i class="fa fa-sync-alt fa-spin me-2 d-none loader-icon-analysis"></i>
                                <span class="btn-text-analysis"><i class="fa fa-play me-2"></i> Mulai Analisis Sekarang</span>
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .bg-primary-light {
            background-color: rgba(59, 130, 246, 0.08);
        }

        .bg-success-light {
            background-color: rgba(16, 185, 129, 0.08);
        }

        .bg-warning-light {
            background-color: rgba(245, 158, 11, 0.08);
        }

        .bg-secondary-light {
            background-color: rgba(108, 117, 125, 0.08);
        }

        .bg-light-soft {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            transition: all 0.2s ease;
        }

        .bg-light-soft:hover {
            background-color: #f1f5f9;
        }

        .hover-scale {
            transition: all 0.2s ease;
        }

        .hover-scale:hover {
            transform: scale(1.03);
        }

        /* Markdown Styling inside content */
        #ai-markdown-content h3 {
            font-size: 1.15rem;
            font-weight: 700;
            color: #1e293b;
            margin-top: 1.75rem;
            margin-bottom: 0.75rem;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 0.5rem;
        }

        #ai-markdown-content h3:first-child {
            margin-top: 0;
        }

        #ai-markdown-content p {
            color: #475569;
            margin-bottom: 1rem;
        }

        #ai-markdown-content ul,
        #ai-markdown-content ol {
            color: #475569;
            padding-left: 1.25rem;
            margin-bottom: 1.25rem;
        }

        #ai-markdown-content li {
            margin-bottom: 0.4rem;
        }

        #ai-markdown-content strong {
            color: #0f172a;
        }

        /* Custom Scrollbar for Suggestions */
        .suggestion-list-scroll::-webkit-scrollbar {
            width: 5px;
        }

        .suggestion-list-scroll::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 10px;
        }

        .suggestion-list-scroll::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .suggestion-list-scroll::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Loading Overlay Style */
        .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.85);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 10;
            backdrop-filter: blur(4px);
            border-radius: 16px;
        }

        .suggestion-list-scroll {
            max-height: 420px;
            overflow-y: auto;
            padding-right: 5px;
        }

        .chart-container {
            position: relative;
            height: 350px;
            width: 100%;
        }

        @media (max-width: 991.98px) {
            .chart-container {
                height: 320px;
            }

            .suggestion-list-scroll {
                max-height: 300px;
            }
        }

        @media (max-width: 575.98px) {
            .chart-container {
                height: 260px;
            }

            .suggestion-list-scroll {
                max-height: 240px;
            }
        }
    </style>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Marked JS for parsing markdown to HTML beautifully -->
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Loader handling for AI generation
            document.querySelectorAll('.form-generate-analysis').forEach(function (form) {
                form.addEventListener('submit', function () {
                    const btn = form.querySelector('.btn-analyze-analysis');
                    const loader = form.querySelector('.loader-icon-analysis');
                    const text = form.querySelector('.btn-text-analysis');
                    const overlay = document.getElementById('loading-overlay');

                    if (btn) btn.disabled = true;
                    if (loader) loader.classList.remove('d-none');
                    if (text) text.innerHTML = '<i class="fa fa-sync-alt fa-spin me-2"></i> Menganalisis...';
                    if (overlay) overlay.classList.remove('d-none');
                });
            });

            // Convert Markdown content to HTML
            const markdownContainer = document.getElementById('ai-markdown-content');
            if (markdownContainer) {
                const rawMarkdown = markdownContainer.innerHTML.trim();
                // Replace HTML entities back to normal characters
                const unescapedMarkdown = rawMarkdown
                    .replace(/&amp;/g, '&')
                    .replace(/&lt;/g, '<')
                    .replace(/&gt;/g, '>')
                    .replace(/&quot;/g, '"')
                    .replace(/&#039;/g, "'");
                markdownContainer.innerHTML = marked.parse(unescapedMarkdown);
            }

            // Render Radar Chart
            const ctxRadar = document.getElementById('radarChartCompetencies');
            if (ctxRadar) {
                new Chart(ctxRadar.getContext('2d'), {
                    type: 'radar',
                    data: {
                        labels: [
                            'Etika & Moral',
                            'Keahlian Bidang',
                            'Bahasa Inggris',
                            'Penggunaan TI',
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
                                backgroundColor: 'rgba(59, 130, 246, 0.2)',
                                borderColor: 'rgba(59, 130, 246, 0.8)',
                                pointBackgroundColor: 'rgba(59, 130, 246, 1)',
                                pointBorderColor: '#fff',
                                pointHoverBackgroundColor: '#fff',
                                pointHoverBorderColor: 'rgba(59, 130, 246, 1)'
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
                                backgroundColor: 'rgba(16, 185, 129, 0.2)',
                                borderColor: 'rgba(16, 185, 129, 0.8)',
                                pointBackgroundColor: 'rgba(16, 185, 129, 1)',
                                pointBorderColor: '#fff',
                                pointHoverBackgroundColor: '#fff',
                                pointHoverBorderColor: 'rgba(16, 185, 129, 1)'
                            },
                            {
                                label: 'Kepuasan Industri (Atasan)',
                                data: [
                                                    {{ $supervisorStats->integritas ?? 0 }},
                                                    {{ $supervisorStats->keahlian ?? 0 }},
                                                    {{ $supervisorStats->kemampuan ?? 0 }},
                                                    {{ $supervisorStats->penguasaan ?? 0 }},
                                                    {{ $supervisorStats->komunikasi ?? 0 }},
                                                    {{ $supervisorStats->kerja_tim ?? 0 }},
                                    {{ $supervisorStats->pengembangan ?? 0 }}
                                ],
                                backgroundColor: 'rgba(245, 158, 11, 0.2)',
                                borderColor: 'rgba(245, 158, 11, 0.8)',
                                pointBackgroundColor: 'rgba(245, 158, 11, 1)',
                                pointBorderColor: '#fff',
                                pointHoverBackgroundColor: '#fff',
                                pointHoverBorderColor: 'rgba(245, 158, 11, 1)'
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
                                    boxWidth: window.innerWidth < 576 ? 8 : 12,
                                    font: {
                                        size: window.innerWidth < 576 ? 9 : 11,
                                        family: 'Inter'
                                    }
                                }
                            }
                        },
                        scales: {
                            r: {
                                angleLines: { display: true, color: 'rgba(0,0,0,0.05)' },
                                grid: { color: 'rgba(0,0,0,0.05)' },
                                pointLabels: {
                                    font: {
                                        size: window.innerWidth < 576 ? 8 : 10,
                                        weight: '600',
                                        family: 'Inter'
                                    }
                                },
                                ticks: {
                                    backdropColor: 'transparent',
                                    color: '#64748b',
                                    font: { size: window.innerWidth < 576 ? 7 : 9 },
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
    </script>
@endsection