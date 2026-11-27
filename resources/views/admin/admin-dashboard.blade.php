@extends('layouts.admin')

@section('content')
    <div class="content content-full">
        <!-- Hero Header Modern -->
        <div class="mb-4 dashboard-hero">
            <div class="row align-items-center g-3">
                <div class="col-lg-7">
                    <div class="gap-2 mb-2 d-flex align-items-center">
                        <span class="badge hero-badge">
                            <i class="fa fa-star text-warning me-1"></i> Tracer Study Portal
                        </span>
                        <span class="badge hero-badge-sub">
                            T.A {{ $selectedTA ?? 'Aktif' }}
                        </span>
                    </div>
                    <h1 class="mb-2 text-white h3 fw-bold">
                        Selamat Datang, {{ Auth::user()->username }}! 👋
                    </h1>
                    <p class="mb-0 text-white-50 small">
                        Pantau aktivitas penelusuran lulusan, respons survei pengguna, dan metrik keterserapan alumni secara real-time.
                    </p>
                </div>
                <div class="col-lg-5 text-lg-end">
                    <div class="flex-wrap gap-2 d-inline-flex align-items-center justify-content-lg-end">
                        <div class="hero-chip">
                            <i class="fa fa-calendar-alt text-warning"></i>
                            <span>{{ now()->translatedFormat('l, d F Y') }}</span>
                        </div>
                        <div class="hero-chip">
                            <i class="fa fa-clock text-info"></i>
                            <span id="liveTime">{{ now()->format('H:i:s') }} WIB</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 4 Top Metric Cards -->
        @php
            $totalTracer = array_sum(array_column($statistikAlumni, 'jumlah'));
            $completionRate = $countAlumni > 0 ? round(($totalTracer / $countAlumni) * 100, 1) : 0;
            $surveyRate = $countQuestioner > 0 ? round(($countQuestionerCompleted / $countQuestioner) * 100, 1) : 0;
        @endphp

        <div class="mb-4 row g-3">
            {{-- Total Mahasiswa --}}
            <div class="col-sm-6 col-xl-3">
                <div class="metric-card metric-blue h-100">
                    <div class="metric-card-body">
                        <div class="mb-3 d-flex align-items-center justify-content-between">
                            <div class="metric-icon">
                                <i class="fa fa-user-graduate"></i>
                            </div>
                            <span class="metric-pill">Mahasiswa</span>
                        </div>
                        <div class="metric-value stat-counter">{{ $countMahasiswa }}</div>
                        <div class="metric-label">Total Mahasiswa Terdaftar</div>
                        <div class="metric-footer">
                            <a href="{{ route('listmahasiswa') }}" class="metric-link">
                                Kelola Data <i class="fa fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Total Alumni --}}
            <div class="col-sm-6 col-xl-3">
                <div class="metric-card metric-emerald h-100">
                    <div class="metric-card-body">
                        <div class="mb-3 d-flex align-items-center justify-content-between">
                            <div class="metric-icon">
                                <i class="fa fa-award"></i>
                            </div>
                            <span class="metric-pill">Alumni</span>
                        </div>
                        <div class="metric-value stat-counter">{{ $countAlumni }}</div>
                        <div class="metric-label">Total Lulusan Terdata</div>
                        <div class="metric-footer">
                            <a href="{{ route('listalumni') }}" class="metric-link">
                                Lihat Lulusan <i class="fa fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tracer Kuesioner --}}
            <div class="col-sm-6 col-xl-3">
                <div class="metric-card metric-amber h-100">
                    <div class="metric-card-body">
                        <div class="mb-3 d-flex align-items-center justify-content-between">
                            <div class="metric-icon">
                                <i class="fa fa-file-signature"></i>
                            </div>
                            <span class="metric-pill">{{ $completionRate }}% Terisi</span>
                        </div>
                        <div class="metric-value stat-counter">{{ $totalTracer }}</div>
                        <div class="metric-label">Responden Kuesioner Alumni</div>
                        <div class="metric-footer">
                            <a href="{{ route('listtraceralumni.index') }}" class="metric-link">
                                Detail Tracer <i class="fa fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Survey Pengguna --}}
            <div class="col-sm-6 col-xl-3">
                <div class="metric-card metric-violet h-100">
                    <div class="metric-card-body">
                        <div class="mb-3 d-flex align-items-center justify-content-between">
                            <div class="metric-icon">
                                <i class="fa fa-university"></i>
                            </div>
                            <span class="metric-pill">{{ $surveyRate }}% Selesai</span>
                        </div>
                        <div class="metric-value stat-counter">{{ $countQuestionerCompleted }}</div>
                        <div class="metric-label">Survei Pengguna Lulusan</div>
                        <div class="metric-footer">
                            <a href="{{ route('admin.supervisor-questionnaire.dashboard') }}" class="metric-link">
                                Hasil Survei <i class="fa fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Dashboard Visual Rows --}}
        <div class="mb-4 row g-4">
            {{-- Statistik Karir Alumni (Chart Utama + Status Badges) --}}
            <div class="col-xl-8">
                <div class="panel-card h-100">
                    <div class="flex-wrap gap-2 panel-header d-flex align-items-center justify-content-between">
                        <div class="gap-2 d-flex align-items-center">
                            <div class="panel-icon bg-primary-soft text-primary">
                                <i class="fa fa-chart-bar"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold text-dark">Distribusi Karir & Keterserapan Alumni</h6>
                                <span class="text-muted fs-xs">Status aktivitas lulusan berdasarkan data kuesioner tracer</span>
                            </div>
                        </div>
                        <span class="px-2 py-1 border badge bg-light text-secondary fs-xs">
                            <i class="fa fa-check-circle text-success me-1"></i> {{ $totalTracer }} Responden
                        </span>
                    </div>

                    <div class="panel-body">
                        <!-- Chart Canvas -->
                        <div class="mb-4 chart-wrapper" style="height: 270px;">
                            <canvas id="barChartAlumni"></canvas>
                        </div>

                        <!-- Status Mini Pill Grid -->
                        <div class="pt-2 row g-2">
                            @php
                                $alumniStatsConfig = [
                                    ['label' => 'Bekerja', 'key' => 'Bekerja', 'icon' => 'fa-briefcase', 'color' => '#10b981', 'bg' => '#ecfdf5'],
                                    ['label' => 'Wirausaha', 'key' => 'Wirausaha', 'icon' => 'fa-shop', 'color' => '#f59e0b', 'bg' => '#fffbeb'],
                                    ['label' => 'Lanjut Studi', 'key' => 'Lanjut Studi', 'icon' => 'fa-graduation-cap', 'color' => '#3b82f6', 'bg' => '#eff6ff'],
                                    ['label' => 'Belum Bekerja', 'key' => 'Belum Bekerja', 'icon' => 'fa-clock', 'color' => '#ef4444', 'bg' => '#fef2f2'],
                                    ['label' => 'Tidak Bekerja', 'key' => 'Tidak Bekerja', 'icon' => 'fa-user-slash', 'color' => '#6b7280', 'bg' => '#f9fafb']
                                ];
                            @endphp
                            @foreach ($alumniStatsConfig as $conf)
                                @php $statData = $statistikAlumni[$conf['key']] ?? ['jumlah' => 0, 'persen' => '0%']; @endphp
                                <div class="col-6 col-sm-4 col-xl">
                                    <div class="p-2 text-center border career-stat-card rounded-3" style="background-color: {{ $conf['bg'] }}; border-color: rgba(0,0,0,0.04) !important;">
                                        <div class="gap-1 mb-1 d-flex align-items-center justify-content-center">
                                            <i class="fa {{ $conf['icon'] }} fs-xs" style="color: {{ $conf['color'] }}"></i>
                                            <span class="fs-xs fw-bold text-muted text-uppercase" style="font-size: 0.65rem;">{{ $conf['label'] }}</span>
                                        </div>
                                        <div class="mb-0 fs-4 fw-extrabold text-dark">{{ $statData['jumlah'] }}</div>
                                        <div class="px-1 py-0 fs-xs fw-bold rounded-pill d-inline-block" style="color: {{ $conf['color'] }}; font-size: 0.68rem;">
                                            {{ $statData['persen'] }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan: Donut & KPI Target --}}
            <div class="col-xl-4">
                <div class="panel-card h-100 d-flex flex-column">
                    <div class="panel-header d-flex align-items-center justify-content-between">
                        <div class="gap-2 d-flex align-items-center">
                            <div class="panel-icon bg-info-soft text-info">
                                <i class="fa fa-chart-pie"></i>
                            </div>
                            <h6 class="mb-0 fw-bold text-dark">Rasio Partisipasi</h6>
                        </div>
                    </div>

                    <div class="panel-body flex-grow-1 d-flex flex-column justify-content-between">
                        <!-- Progress Card Tracer -->
                        <div class="p-3 mb-3 kpi-widget rounded-3">
                            <div class="mb-1 d-flex justify-content-between align-items-center">
                                <span class="fw-bold fs-xs text-uppercase text-muted">Keterisian Tracer Alumni</span>
                                <span class="text-white badge bg-success fw-bold">{{ $completionRate }}%</span>
                            </div>
                            <div class="mb-2 progress rounded-pill" style="height: 8px; background-color: #e2e8f0;">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-success rounded-pill"
                                     style="width: {{ $completionRate }}%;"></div>
                            </div>
                            <div class="d-flex justify-content-between text-muted fs-xs">
                                <span>{{ $totalTracer }} Mengisi</span>
                                <span>Total {{ $countAlumni }} Alumni</span>
                            </div>
                        </div>

                        <!-- Progress Card Pengguna -->
                        <div class="p-3 mb-3 kpi-widget rounded-3">
                            <div class="mb-1 d-flex justify-content-between align-items-center">
                                <span class="fw-bold fs-xs text-uppercase text-muted">Survei Pengguna Lulusan</span>
                                <span class="text-white badge bg-info fw-bold">{{ $surveyRate }}%</span>
                            </div>
                            <div class="mb-2 progress rounded-pill" style="height: 8px; background-color: #e2e8f0;">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-info rounded-pill"
                                     style="width: {{ $surveyRate }}%;"></div>
                            </div>
                            <div class="d-flex justify-content-between text-muted fs-xs">
                                <span>{{ $countQuestionerCompleted }} Selesai</span>
                                <span>Total {{ $countQuestioner }} Mitra</span>
                            </div>
                        </div>

                        <!-- Mini Timeline Chart -->
                        <div class="pt-2 mt-2 border-top">
                            <div class="mb-2 d-flex align-items-center justify-content-between">
                                <span class="fs-xs fw-bold text-dark text-uppercase">Tren Lulusan (2021-2025)</span>
                                <i class="fa fa-chart-line text-primary fs-xs"></i>
                            </div>
                            <div style="height: 110px;">
                                <canvas id="lineChartAlumni"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Quick Shortcut Grid --}}
        <div class="row g-3">
            <div class="col-md-4">
                <a href="{{ route('tracer.rekap') }}" class="shortcut-box">
                    <div class="shortcut-icon bg-blue text-primary">
                        <i class="fa fa-list-alt"></i>
                    </div>
                    <div>
                        <div class="shortcut-title">Rekap Hasil Tracer</div>
                        <div class="shortcut-desc">Analisis statistik lengkap & ekspor data kuesioner</div>
                    </div>
                    <i class="fa fa-chevron-right ms-auto text-muted fs-xs"></i>
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('admin.prediksi.index') }}" class="shortcut-box">
                    <div class="shortcut-icon bg-violet text-purple">
                        <i class="fa fa-magic"></i>
                    </div>
                    <div>
                        <div class="shortcut-title">Prediksi & AI Tracer</div>
                        <div class="shortcut-desc">Simulasi keselarasan karir dan rekomendasi AI</div>
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
                        <div class="shortcut-desc">Evaluasi relevansi kompetensi terhadap industri</div>
                    </div>
                    <i class="fa fa-chevron-right ms-auto text-muted fs-xs"></i>
                </a>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Live clock updater
            function updateClock() {
                const now = new Date();
                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');
                const seconds = String(now.getSeconds()).padStart(2, '0');
                const clockEl = document.getElementById('liveTime');
                if (clockEl) clockEl.innerText = `${hours}:${minutes}:${seconds} WIB`;
            }
            setInterval(updateClock, 1000);

            // Counter Animation
            $('.stat-counter').each(function () {
                const $this = $(this);
                const countTo = parseInt($this.text()) || 0;
                $({ countNum: 0 }).animate({ countNum: countTo }, {
                    duration: 1200,
                    easing: 'swing',
                    step: function () { $this.text(Math.floor(this.countNum)); },
                    complete: function () { $this.text(this.countNum); }
                });
            });

            // Bar Chart Styling
            const ctxBar = document.getElementById('barChartAlumni').getContext('2d');

            // Create nice gradients for bar
            const gradBekerja = ctxBar.createLinearGradient(0, 0, 0, 240);
            gradBekerja.addColorStop(0, '#10b981');
            gradBekerja.addColorStop(1, '#059669');

            const gradWirausaha = ctxBar.createLinearGradient(0, 0, 0, 240);
            gradWirausaha.addColorStop(0, '#f59e0b');
            gradWirausaha.addColorStop(1, '#d97706');

            const gradStudi = ctxBar.createLinearGradient(0, 0, 0, 240);
            gradStudi.addColorStop(0, '#3b82f6');
            gradStudi.addColorStop(1, '#2563eb');

            const gradBelum = ctxBar.createLinearGradient(0, 0, 0, 240);
            gradBelum.addColorStop(0, '#ef4444');
            gradBelum.addColorStop(1, '#dc2626');

            const gradTidak = ctxBar.createLinearGradient(0, 0, 0, 240);
            gradTidak.addColorStop(0, '#9ca3af');
            gradTidak.addColorStop(1, '#6b7280');

            new Chart(ctxBar, {
                type: 'bar',
                data: {
                    labels: ['Bekerja', 'Wirausaha', 'Studi Lanjut', 'Belum Bekerja', 'Tidak Bekerja'],
                    datasets: [{
                        label: 'Jumlah Alumni',
                        data: [
                            {{ $statistikAlumni['Bekerja']['jumlah'] }},
                            {{ $statistikAlumni['Wirausaha']['jumlah'] }},
                            {{ $statistikAlumni['Lanjut Studi']['jumlah'] }},
                            {{ $statistikAlumni['Belum Bekerja']['jumlah'] }},
                            {{ $statistikAlumni['Tidak Bekerja']['jumlah'] }}
                        ],
                        backgroundColor: [
                            gradBekerja,
                            gradWirausaha,
                            gradStudi,
                            gradBelum,
                            gradTidak
                        ],
                        borderRadius: 10,
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
                            titleFont: { size: 13, family: 'Plus Jakarta Sans', weight: 'bold' },
                            bodyFont: { size: 12, family: 'Plus Jakarta Sans' },
                            padding: 10,
                            cornerRadius: 8,
                            displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    return ' ' + context.parsed.y + ' Alumni';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0,
                                font: { family: 'Plus Jakarta Sans', size: 11 },
                                color: '#94a3b8'
                            },
                            grid: {
                                color: 'rgba(226, 232, 240, 0.7)',
                                drawBorder: false
                            }
                        },
                        x: {
                            ticks: {
                                font: { family: 'Plus Jakarta Sans', size: 11, weight: '600' },
                                color: '#475569'
                            },
                            grid: { display: false }
                        }
                    }
                }
            });

            // Line Chart (Mini Timeline)
            const ctxLine = document.getElementById('lineChartAlumni').getContext('2d');
            const gradLine = ctxLine.createLinearGradient(0, 0, 0, 100);
            gradLine.addColorStop(0, 'rgba(59, 130, 246, 0.25)');
            gradLine.addColorStop(1, 'rgba(59, 130, 246, 0.0)');

            new Chart(ctxLine, {
                type: 'line',
                data: {
                    labels: {!! json_encode($tahun) !!},
                    datasets: [{
                        label: 'Lulusan',
                        data: {!! json_encode($alumniData) !!},
                        borderColor: '#3b82f6',
                        borderWidth: 2.5,
                        backgroundColor: gradLine,
                        fill: true,
                        tension: 0.35,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#3b82f6',
                        pointBorderWidth: 2,
                        pointRadius: 3.5,
                        pointHoverRadius: 5
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#0f172a',
                            padding: 8,
                            cornerRadius: 6,
                            displayColors: false
                        }
                    },
                    scales: {
                        x: {
                            display: true,
                            ticks: {
                                font: { family: 'Plus Jakarta Sans', size: 10 },
                                color: '#94a3b8'
                            },
                            grid: { display: false }
                        },
                        y: { display: false }
                    }
                }
            });
        });
    </script>
@endsection

@section('styles')
    <style>
        /* Hero Banner */
        .dashboard-hero {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #1e3a8a 100%);
            border-radius: 1rem;
            padding: 1.5rem 1.75rem;
            box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.2);
            position: relative;
            overflow: hidden;
        }

        .dashboard-hero::after {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.2) 0%, rgba(255, 255, 255, 0) 70%);
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
        .metric-violet::before { background: linear-gradient(90deg, #8b5cf6, #a78bfa); }

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
        .metric-emerald .metric-icon { background: #ecfdf5; color: #059669; }
        .metric-amber .metric-icon { background: #fffbeb; color: #d97706; }
        .metric-violet .metric-icon { background: #f5f3ff; color: #7c3aed; }

        .metric-pill {
            font-size: 0.7rem;
            font-weight: 700;
            padding: 0.25rem 0.6rem;
            border-radius: 1rem;
        }

        .metric-blue .metric-pill { background: #eff6ff; color: #1d4ed8; }
        .metric-emerald .metric-pill { background: #ecfdf5; color: #047857; }
        .metric-amber .metric-pill { background: #fffbeb; color: #b45309; }
        .metric-violet .metric-pill { background: #f5f3ff; color: #6d28d9; }

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
            width: 36px;
            height: 36px;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.95rem;
        }

        .bg-primary-soft { background: #eff6ff; }
        .bg-info-soft { background: #f0fdf4; }

        .career-stat-card {
            transition: all 0.2s ease;
        }
        .career-stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
        }

        .kpi-widget {
            background: #f8fafc;
            border: 1px solid #edf2f7;
        }

        /* Shortcut boxes */
        .shortcut-box {
            background: #ffffff;
            border-radius: 0.75rem;
            border: 1px solid #e2e8f0;
            padding: 1rem 1.15rem;
            display: flex;
            align-items: center;
            gap: 0.85rem;
            text-decoration: none;
            color: inherit;
            transition: all 0.2s ease;
        }

        .shortcut-box:hover {
            border-color: #cbd5e1;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px -2px rgba(15, 23, 42, 0.06);
            color: inherit;
        }

        .shortcut-icon {
            width: 40px;
            height: 40px;
            border-radius: 0.65rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .shortcut-icon.bg-blue { background: #eff6ff; color: #2563eb; }
        .shortcut-icon.bg-violet { background: #f5f3ff; color: #7c3aed; }
        .shortcut-icon.bg-amber { background: #fffbeb; color: #d97706; }

        .shortcut-title {
            font-size: 0.84rem;
            font-weight: 700;
            color: #1e293b;
        }

        .shortcut-desc {
            font-size: 0.72rem;
            color: #64748b;
        }

        .fw-extrabold {
            font-weight: 800;
        }
    </style>
@endsection
