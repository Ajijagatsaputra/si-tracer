@extends('layouts.admin')

@section('content')
    <div class="content content-full">
        <!-- Premium Glassmorphic Hero -->
        <div class="card card-modern border-0 shadow-lg mb-5 overflow-hidden" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);">
            <div class="card-body p-4 p-md-5 position-relative">
                <div class="row align-items-center">
                    <div class="col-lg-8 position-relative" style="z-index: 2;">
                        <h1 class="display-5 fw-bold text-white mb-2">Dashboard Admin</h1>
                        <p class="lead text-white-50 mb-0">Selamat datang kembali, <span class="text-white fw-bold">{{ Auth::user()->username }}</span>. Berikut adalah ringkasan performa sistem hari ini.</p>
                    </div>
                    <div class="col-lg-4 text-lg-end mt-4 mt-lg-0 position-relative" style="z-index: 2;">
                        <div class="glass-pill d-inline-block px-4 py-3 border border-white-25 rounded-pill shadow-sm" style="background: rgba(255,255,255,0.1); backdrop-filter: blur(10px);">
                            <div class="d-flex align-items-center text-start">
                                <div class="icon-circle bg-white-20 text-white me-3" style="width: 45px; height: 45px;">
                                    <i class="fa fa-clock"></i>
                                </div>
                                <div>
                                    <div class="text-white-50 small text-uppercase fw-bold ls-wide" style="font-size: 0.65rem;">Terakhir Update</div>
                                    <div class="text-white fw-bold">{{ now()->format('H:i') }} - {{ now()->format('d M Y') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Decorative Elements -->
                <div class="position-absolute top-0 end-0 p-5 mt-n5 me-n5 opacity-25">
                    <i class="fa fa-circle-notch fa-spin fa-10x text-white"></i>
                </div>
            </div>
        </div>

        <!-- Modern Stats Grid -->
        <div class="row g-4 mb-5">
            {{-- Mahasiswa --}}
            <div class="col-md-6 col-xl-3">
                <div class="card card-modern border-0 shadow-sm h-100 position-relative overflow-hidden stat-hover-effect">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="icon-circle bg-primary-light text-primary" style="width: 50px; height: 50px;">
                                <i class="fa fa-chalkboard-teacher fa-lg"></i>
                            </div>
                            <span class="badge bg-primary-light text-primary rounded-pill px-3 py-1 border border-primary-10 fs-xs fw-bold">Mahasiswa</span>
                        </div>
                        <h3 class="display-6 fw-bold text-dark mb-1 stat-counter">{{ $countMahasiswa }}</h3>
                        <p class="text-muted small mb-3">Total Mahasiswa Terdaftar</p>
                        <a href="{{ route('listmahasiswa') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 mt-auto">
                            Detail <i class="fa fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                    <div class="position-absolute bottom-0 start-0 end-0 bg-primary" style="height:4px; opacity:0.1;"></div>
                </div>
            </div>

            {{-- Alumni --}}
            <div class="col-md-6 col-xl-3">
                <div class="card card-modern border-0 shadow-sm h-100 position-relative overflow-hidden stat-hover-effect">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="icon-circle bg-success-light text-success" style="width: 50px; height: 50px;">
                                <i class="fa fa-user-graduate fa-lg"></i>
                            </div>
                            <span class="badge bg-success-light text-success rounded-pill px-3 py-1 border border-success-10 fs-xs fw-bold">Alumni</span>
                        </div>
                        <h3 class="display-6 fw-bold text-dark mb-1 stat-counter">{{ $countAlumni }}</h3>
                        <p class="text-muted small mb-3">Total Lulusan (Alumni)</p>
                        <a href="{{ route('listalumni') }}" class="btn btn-sm btn-outline-success rounded-pill px-3 mt-auto">
                            Detail <i class="fa fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                    <div class="position-absolute bottom-0 start-0 end-0 bg-success" style="height:4px; opacity:0.1;"></div>
                </div>
            </div>

            {{-- Tracer Participation --}}
            <div class="col-md-6 col-xl-3">
                <div class="card card-modern border-0 shadow-sm h-100 position-relative overflow-hidden stat-hover-effect">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="icon-circle bg-warning-light text-warning" style="width: 50px; height: 50px;">
                                <i class="fa fa-chart-pie fa-lg"></i>
                            </div>
                            @php
                                $totalTracer = array_sum(array_column($statistikAlumni, 'jumlah'));
                                $completionRate = $countAlumni > 0 ? round(($totalTracer / $countAlumni) * 100, 1) : 0;
                            @endphp
                            <span class="badge bg-warning-light text-warning rounded-pill px-3 py-1 border border-warning-10 fs-xs fw-bold">{{ $completionRate }}%</span>
                        </div>
                        <h3 class="display-6 fw-bold text-dark mb-1 stat-counter">{{ $totalTracer }}</h3>
                        <p class="text-muted small mb-3">Telah Mengisi Kuesioner</p>
                        <a href="{{ route('listtraceralumni.index') }}" class="btn btn-sm btn-outline-warning rounded-pill px-3 mt-auto">
                            Detail <i class="fa fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                    <div class="position-absolute bottom-0 start-0 end-0 bg-warning" style="height:4px; opacity:0.1;">
                        <div class="h-100 bg-warning" style="width: {{ $completionRate }}%;"></div>
                    </div>
                </div>
            </div>

            {{-- Questionnaire --}}
            <div class="col-md-6 col-xl-3">
                <div class="card card-modern border-0 shadow-sm h-100 position-relative overflow-hidden stat-hover-effect">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="icon-circle bg-info-light text-info" style="width: 50px; height: 50px;">
                                <i class="fa fa-clipboard-list fa-lg"></i>
                            </div>
                            @php
                                $surveyRate = $countQuestioner > 0 ? round(($countQuestionerCompleted / $countQuestioner) * 100, 1) : 0;
                            @endphp
                            <span class="badge bg-info-light text-info rounded-pill px-3 py-1 border border-info-10 fs-xs fw-bold">{{ $surveyRate }}%</span>
                        </div>
                        <h3 class="display-6 fw-bold text-dark mb-1 stat-counter">{{ $countQuestionerCompleted }}</h3>
                        <p class="text-muted small mb-3">Survey Pengguna Selesai</p>
                        <a href="{{ route('admin.supervisor-questionnaire.dashboard') }}" class="btn btn-sm btn-outline-info rounded-pill px-3 mt-auto">
                            Detail <i class="fa fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                    <div class="position-absolute bottom-0 start-0 end-0 bg-info" style="height:4px; opacity:0.1;">
                        <div class="h-100 bg-info" style="width: {{ $surveyRate }}%;"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modern Charts Row --}}
        <div class="row g-4 mb-4">
            {{-- Status Alumni Breakdown --}}
            <div class="col-lg-8">
                <div class="card card-modern border-0 shadow-sm h-100 overflow-hidden">
                    <div class="card-header bg-white py-3 px-4 border-bottom-0 border-0">
                        <div class="d-flex align-items-center">
                            <div class="icon-circle bg-primary-light text-primary me-3" style="width: 40px; height: 40px;">
                                <i class="fa fa-chart-bar"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold text-dark mb-0">Statistik Karir Alumni</h5>
                                <p class="text-muted small mb-0">Distribusi status lulusan berdasarkan isian tracer</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4 pt-0">
                        <div class="chart-container mb-4" style="height: 300px;">
                            <canvas id="barChartAlumni"></canvas>
                        </div>
                        <div class="row g-3">
                            @php
                                $alumniStatsConfig = [
                                    ['label' => 'Bekerja', 'key' => 'Bekerja', 'icon' => 'fa-briefcase', 'color' => 'success'],
                                    ['label' => 'Wirausaha', 'key' => 'Wirausaha', 'icon' => 'fa-store', 'color' => 'warning'],
                                    ['label' => 'Lanjut Studi', 'key' => 'Lanjut Studi', 'icon' => 'fa-graduation-cap', 'color' => 'primary'],
                                    ['label' => 'Belum Bekerja', 'key' => 'Belum Bekerja', 'icon' => 'fa-user-clock', 'color' => 'danger'],
                                    ['label' => 'Tidak Bekerja', 'key' => 'Tidak Bekerja', 'icon' => 'fa-search', 'color' => 'secondary']
                                ];
                            @endphp
                            @foreach ($alumniStatsConfig as $conf)
                                @php $statData = $statistikAlumni[$conf['key']] ?? ['jumlah' => 0, 'persen' => '0%']; @endphp
                                <div class="col-6 col-md-4 col-xl">
                                    <div class="p-3 rounded-4 bg-light-soft text-center border h-100 transition-all hover-translate-y">
                                        <div class="icon-circle bg-white text-{{ $conf['color'] }} shadow-sm mx-auto mb-2" style="width: 35px; height: 35px;">
                                            <i class="fa {{ $conf['icon'] }} small"></i>
                                        </div>
                                        <div class="fw-bold text-dark fs-5 mb-0">{{ $statData['jumlah'] }}</div>
                                        <div class="text-muted small text-uppercase fw-bold ls-wide mb-1" style="font-size: 0.6rem;">{{ $conf['label'] }}</div>
                                        <span class="badge bg-{{ $conf['color'] }}-light text-{{ $conf['color'] }} rounded-pill px-2 py-0 fs-xs border">{{ $statData['persen'] }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- Quick Stats / Target --}}
            <div class="col-lg-4">
                <div class="card card-modern border-0 shadow-sm h-100">
                    <div class="card-header bg-white py-3 px-4 border-bottom-0">
                        <div class="d-flex align-items-center">
                            <div class="icon-circle bg-info-light text-info me-3" style="width: 40px; height: 40px;">
                                <i class="fa fa-tachometer-alt"></i>
                            </div>
                            <h5 class="fw-bold text-dark mb-0">Indikator Partisipasi</h5>
                        </div>
                    </div>
                    <div class="card-body p-4 pt-0">
                        <div class="space-y-4">
                            <div class="p-3 rounded-4 bg-light border border-dashed mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted small fw-bold text-uppercase">Tingkat Kelengkapan</span>
                                    <span class="text-success fw-bold small">{{ $completionRate }}%</span>
                                </div>
                                <div class="progress rounded-pill bg-white shadow-none mb-2" style="height: 6px;">
                                    <div class="progress-bar bg-success rounded-pill" style="width: {{ $completionRate }}%"></div>
                                </div>
                                <p class="small text-muted mb-0">Target partisipasi alumni angkatan 2021-2025.</p>
                            </div>

                            <div class="p-4 rounded-4 bg-info text-white position-relative overflow-hidden">
                                <div class="position-relative" style="z-index: 2;">
                                    <h6 class="fw-bold mb-1 text-white text-uppercase">Survey Pengguna</h6>
                                    <div class="display-6 fw-bold mb-1">{{ $countQuestionerCompleted }}</div>
                                    <p class="small mb-0 opacity-80">Feedback dari instansi/perusahaan.</p>
                                </div>
                                <i class="fa fa-building fa-4x position-absolute bottom-0 end-0 mb-n2 me-n2 text-white opacity-20"></i>
                            </div>
                            
                            <div class="mt-4 p-3 rounded-4 bg-light">
                                <h6 class="fw-bold text-dark small text-uppercase mb-3">Timeline Lulusan</h6>
                                <div class="chart-container" style="height: 150px;">
                                    <canvas id="lineChartAlumni"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Counter Animation
            $('.stat-counter').each(function() {
                const $this = $(this);
                const countTo = parseInt($this.text());
                $({ countNum: 0 }).animate({ countNum: countTo }, {
                    duration: 1500,
                    easing: 'swing',
                    step: function() { $this.text(Math.floor(this.countNum)); },
                    complete: function() { $this.text(this.countNum); }
                });
            });

            // Bar Chart
            const ctxBar = document.getElementById('barChartAlumni').getContext('2d');
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
                            'rgba(16, 185, 129, 0.7)',
                            'rgba(245, 158, 11, 0.7)',
                            'rgba(59, 130, 246, 0.7)',
                            'rgba(239, 68, 68, 0.7)',
                            'rgba(107, 114, 128, 0.7)'
                        ],
                        borderRadius: 8,
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, grid: { display: true, color: 'rgba(0,0,0,0.05)', drawBorder: false } },
                        x: { grid: { display: false } }
                    }
                }
            });

            // Line Chart (Mini)
            const ctxLine = document.getElementById('lineChartAlumni').getContext('2d');
            new Chart(ctxLine, {
                type: 'line',
                data: {
                    labels: {!! json_encode($tahun) !!},
                    datasets: [{
                        label: 'Lulusan',
                        data: {!! json_encode($alumniData) !!},
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        fill: true,
                        tension: 0.4,
                        pointRadius: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { display: true, grid: { display: false } },
                        y: { display: false }
                    }
                }
            });
        });
    </script>
@endsection

@section('styles')
    <style>
        .icon-circle.bg-white-20 { background: rgba(255,255,255,0.2); }
        .bg-primary-light { background-color: rgba(59, 130, 246, 0.08); }
        .bg-success-light { background-color: rgba(16, 185, 129, 0.08); }
        .bg-warning-light { background-color: rgba(245, 158, 11, 0.08); }
        .bg-info-light { background-color: rgba(6, 182, 212, 0.08); }
        .bg-light-soft { background-color: #f8fafc; }
        .stat-hover-effect { transition: all 0.3s ease; }
        .stat-hover-effect:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important; }
        .hover-translate-y:hover { transform: translateY(-3px); }
        .glass-pill { transition: all 0.3s ease; }
        .glass-pill:hover { background: rgba(255,255,255,0.15) !important; transform: scale(1.02); }
        .ls-wide { letter-spacing: 0.05em; }
    </style>
@endsection
