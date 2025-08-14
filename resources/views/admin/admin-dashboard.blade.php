@php
    $userRole = Auth::user()->role;
@endphp

<!doctype html>
<html lang="id">
@include('components.admin.head')

<body class="d-flex flex-column min-vh-100 bg-light text-dark">

    {{-- Page Container --}}
    <div id="page-container"
        class="d-flex flex-column flex-grow-1 sidebar-o sidebar-dark enable-page-overlay side-scroll page-header-fixed main-content-narrow">

        {{-- Sidebar + Header --}}
        @include('components.admin.admin-header')
        @include('components.admin.sidebar')
        @include('components.admin.side-overlay')

        {{-- Main Content --}}
        <main id="main-container" class="flex-grow-1">
            <div class="content py-4">

                {{-- Header Section --}}
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4">
                    <div>
                        <h1 class="h3 fw-bold mb-1">Dashboard Admin</h1>
                        <p class="text-muted mb-0">
                            Selamat datang kembali, <span
                                class="fw-semibold text-primary">{{ Auth::user()->username }}</span>
                            {{-- <span class="badge bg-success ms-2">{{ ucfirst($userRole) }}</span> --}}
                        </p>
                    </div>
                    <div class="mt-3 mt-md-0">
                        <div class="text-end">
                            <small class="text-muted d-block">Terakhir Update</small>
                            <span class="fw-semibold">{{ now()->format('d M Y H:i') }}</span>
                        </div>
                    </div>
                </div>

                {{-- Info Boxes --}}
                <div class="row g-4 mb-4">
                    {{-- Mahasiswa --}}
                    <div class="col-md-6 col-xl-3">
                        <div class="card shadow-sm border-0 h-100 dashboard-card">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="fw-bold mb-1 text-primary">{{ number_format($countMahasiswa) }}</h4>
                                    <p class="text-muted mb-0">Total Mahasiswa</p>
                                    <small class="text-success">
                                        <i class="fas fa-arrow-up me-1"></i>Active
                                    </small>
                                </div>
                                <div class="dashboard-icon bg-primary bg-opacity-10">
                                    <i class="fas fa-chalkboard-teacher fa-2x text-primary"></i>
                                </div>
                            </div>
                            <div class="card-footer bg-light py-2">
                                <a href="/listmahasiswa"
                                    class="text-decoration-none text-primary fw-medium d-flex align-items-center justify-content-between">
                                    <span>Lihat semua mahasiswa</span>
                                    <i class="fa fa-arrow-alt-circle-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>



                    {{-- Alumni --}}
                    <div class="col-md-6 col-xl-3">
                        <div class="card shadow-sm border-0 h-100 dashboard-card">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="fw-bold mb-1 text-success">{{ number_format($countAlumni) }}</h4>
                                    <p class="text-muted mb-0">Total Alumni</p>
                                    <small class="text-success">
                                        <i class="fas fa-graduation-cap me-1"></i>Graduated
                                    </small>
                                </div>
                                <div class="dashboard-icon bg-success bg-opacity-10">
                                    <i class="fas fa-user-graduate fa-2x text-success"></i>
                                </div>
                            </div>
                            <div class="card-footer bg-light py-2">
                                <a href="/listalumni"
                                    class="text-decoration-none text-success fw-medium d-flex align-items-center justify-content-between">
                                    <span>Lihat semua alumni</span>
                                    <i class="fa fa-arrow-alt-circle-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Tracer Study Completion --}}
                    <div class="col-md-6 col-xl-3">
                        <div class="card shadow-sm border-0 h-100 dashboard-card">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    @php
                                        $totalTracer = array_sum(array_column($statistikAlumni, 'jumlah'));
                                        $completionRate =
                                            $countAlumni > 0 ? round(($totalTracer / $countAlumni) * 100, 1) : 0;
                                    @endphp
                                    <h4 class="fw-bold mb-1 text-warning">{{ $completionRate }}%</h4>
                                    <p class="text-muted mb-0">Persentase Pengisian Tracer</p>
                                    <small class="text-warning">
                                        <i class="fas fa-chart-line me-1"></i>{{ $totalTracer }}/{{ $countAlumni }} Alumni
                                    </small>
                                </div>
                                <div class="dashboard-icon bg-warning bg-opacity-10">
                                    <i class="fas fa-chart-pie fa-2x text-warning"></i>
                                </div>
                            </div>
                            <div class="card-footer bg-light py-2">
                                <a href="/listtraceralumni"
                                    class="text-decoration-none text-warning fw-medium d-flex align-items-center justify-content-between">
                                    <span>Lihat tracer study</span>
                                    <i class="fa fa-arrow-alt-circle-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-xl-3">
                        <div class="card shadow-sm border-0 h-100 dashboard-card">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="fw-bold mb-1 text-info">{{ number_format($countQuestionerCompleted) }} / {{ number_format($countQuestioner) }}</h4>
                                    <p class="text-muted mb-0">Quesioner Pengguna</p>
                                    <small class="text-info">
                                        <i class="fas fa-question-circle me-1"></i>Questioner
                                    </small>
                                </div>
                                <div class="dashboard-icon bg-info bg-opacity-10">
                                    <i class="fas fa-user-graduate fa-2x text-info"></i>
                                </div>
                            </div>
                            <div class="card-footer bg-light py-2">
                                <a href="{{ route('admin.supervisor-questionnaire.index') }}"
                                    class="text-decoration-none text-info fw-medium d-flex align-items-center justify-content-between">
                                    <span>Lihat semua questioner</span>
                                    <i class="fa fa-arrow-alt-circle-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>


                </div>

                {{-- Charts Row --}}
                <div class="row g-4 mb-4">
                    {{-- Statistik Alumni Chart --}}
                    <div class="col-lg-8">
                        <div class="card shadow-sm border-0 h-100">
                            <div
                                class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">
                                    <i class="fas fa-chart-bar text-primary me-2"></i>
                                    Statistik Status Alumni
                                </h5>

                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <canvas id="barChartAlumni"></canvas>
                                </div>
                            </div>
                            <div class="card-footer bg-light">
                                <div class="row g-3 justify-content-between">
                                    @foreach ([['label' => 'Bekerja', 'data' => $statistikAlumni['Bekerja'], 'icon' => 'fa-briefcase', 'color' => 'success'], ['label' => 'Belum Bekerja', 'data' => $statistikAlumni['Belum Bekerja'], 'icon' => 'fa-user-times', 'color' => 'danger'], ['label' => 'Wirausaha', 'data' => $statistikAlumni['Wirausaha'], 'icon' => 'fa-store', 'color' => 'warning'], ['label' => 'Melanjutkan Studi', 'data' => $statistikAlumni['Lanjut Studi'] ?? ['jumlah' => 0, 'persen' => '0%'], 'icon' => 'fa-graduation-cap', 'color' => 'primary'], ['label' => 'Tidak Bekerja', 'data' => $statistikAlumni['Tidak Bekerja'] ?? ['jumlah' => 0, 'persen' => '0%'], 'icon' => 'fa-search', 'color' => 'secondary']] as $stat)
                                        <div class="col-6 col-md-4 col-lg-2 d-flex">
                                            <div class="stat-card p-3 border rounded bg-white flex-fill w-100 text-center">
                                                <div class="fw-bold text-{{ $stat['color'] }} mb-1">
                                                    <i class="fa {{ $stat['icon'] }} me-1"></i>
                                                    {{ $stat['data']['jumlah'] }}
                                                </div>
                                                <div class="text-muted small">{{ $stat['label'] }}</div>
                                                <div class="text-{{ $stat['color'] }} small fw-semibold">
                                                    {{ $stat['data']['persen'] }}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Quick Stats --}}
                    <div class="col-lg-4">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-header bg-white border-bottom">
                                <h5 class="mb-0">
                                    <i class="fas fa-tachometer-alt text-info me-2"></i>
                                    Quick Statistics
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="d-flex flex-column gap-3">
                                    <!-- Alumni Growth -->
                                    <div class="stat-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="mb-1">Alumni</h6>
                                            </div>
                                            <div class="text-end">
                                                <div class="h5 mb-0 text-success">{{ array_sum($alumniData) }}</div>
                                                <small class="text-success">
                                                    <i
                                                        class="fas fa-arrow-up me-1"></i>+{{ round(((end($alumniData) - reset($alumniData)) / max(reset($alumniData), 1)) * 100, 1) }}%
                                                </small>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Tracer Response Rate -->
                                    <div class="stat-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="mb-1">Respon Tracer</h6>
                                                <p class="text-muted small mb-0">Tingkat penyelesaian</p>
                                            </div>
                                            <div class="text-end">
                                                <div class="h5 mb-0 text-warning">{{ $completionRate ?? 0 }}%</div>
                                                <small class="text-warning">
                                                    <i class="fas fa-chart-line me-1"></i>{{ $totalTracer ?? 0 }}
                                                    responses
                                                </small>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Additional Charts Row --}}
                {{-- <div class="row g-4">

                    <div class="col-lg-6">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-white border-bottom">
                                <h5 class="mb-0">
                                    <i class="fas fa-chart-line text-success me-2"></i>
                                    Alumni Growth Trend
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <canvas id="lineChartAlumni"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-6">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-white border-bottom">
                                <h5 class="mb-0">
                                    <i class="fas fa-chart-area text-info me-2"></i>
                                    Tracer Study Response Rate
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <canvas id="lineChartTracer"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
        </main>

        {{-- Sticky Footer --}}
        <footer id="page-footer" class="footer-sticky bg-body-extra-light">
            <div class="content py-3">
                <div class="row fs-sm">
                    <div class="col-sm-6 order-sm-2 py-1 text-center text-sm-end">
                        Politeknik Harapan Bersama
                    </div>
                    <div class="col-sm-6 order-sm-1 py-1 text-center text-sm-start">
                        <a class="fw-semibold" href="https://1.envato.market/AVD6j" target="_blank">Copyright</a>
                        &copy; SikemaTI<span data-toggle="year-copy">2025</span>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    {{-- Dashboard Script - Load First to Override --}}
    @include('components.admin.dashboard-script')

    {{-- Script --}}
    @include('components.admin.script')

    {{-- Populate Chart Data --}}
    <script>
        // Populate chart data when charts are ready
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                // Update Bar Chart Data
                if (window.dashboardCharts.barChartAlumni) {
                    window.dashboardCharts.barChartAlumni.data.datasets[0].data = [
                        {{ $statistikAlumni['Bekerja']['jumlah'] }},
                        {{ $statistikAlumni['Belum Bekerja']['jumlah'] }},
                        {{ $statistikAlumni['Wirausaha']['jumlah'] }},
                        {{ $statistikAlumni['Lanjut Studi']['jumlah'] }},
                        {{ $statistikAlumni['Tidak Bekerja']['jumlah'] }}
                    ];
                    window.dashboardCharts.barChartAlumni.update();
                }

                // Update Line Chart Alumni Data
                if (window.dashboardCharts.lineChartAlumni) {
                    window.dashboardCharts.lineChartAlumni.data.labels = @json($tahun);
                    window.dashboardCharts.lineChartAlumni.data.datasets[0].data =
                        @json($alumniData);
                    window.dashboardCharts.lineChartAlumni.update();
                }

                // Update Line Chart Tracer Data
                if (window.dashboardCharts.lineChartTracer) {
                    window.dashboardCharts.lineChartTracer.data.labels = @json($tahun);
                    window.dashboardCharts.lineChartTracer.data.datasets[0].data =
                        @json($kuisonerData);
                    window.dashboardCharts.lineChartTracer.update();
                }
            }, 1500);
        });
    </script>

    {{-- Enhanced Dashboard Styles --}}
    <style>
        /* Sticky Footer Styles */
        .footer-sticky {
            margin-top: auto;
            position: sticky;
            bottom: 0;
            width: 100%;
            z-index: 1000;
            border-top: 1px solid rgba(0,0,0,0.1);
        }

        /* Ensure page container takes full height */
        #page-container {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Main content should grow to fill available space */
        #main-container {
            flex: 1;
        }

        .dashboard-card {
            transition: all 0.3s ease;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .dashboard-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
        }

        .stat-card {
            transition: all 0.3s ease;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .stat-item {
            padding: 15px;
            border-radius: 8px;
            background: rgba(0, 0, 0, 0.02);
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        .card-header {
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            border-radius: 12px 12px 0 0 !important;
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        }

        .btn-outline-secondary {
            border-color: #dee2e6;
            color: #6c757d;
        }

        .btn-outline-secondary:hover {
            background-color: #6c757d;
            border-color: #6c757d;
            color: #fff;
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            border-radius: 8px;
        }

        .dropdown-item {
            padding: 8px 16px;
            transition: all 0.2s ease;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
            color: #495057;
        }

        @media (max-width: 768px) {
            .chart-container {
                height: 250px;
            }

            .stat-card {
                margin-bottom: 10px;
            }
        }
    </style>
</body>

</html>
