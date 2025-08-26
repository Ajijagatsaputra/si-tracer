<!doctype html>
<html lang="en">

<head id="page-header" class="sticky-top bg-body">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <title>@yield('title', 'SIKEMA')</title>

    <meta name="description"
        content="OneUI - Bootstrap 5 Admin Template &amp; UI Framework created by pixelcave and published on Themeforest">
    <meta name="author" content="pixelcave">
    <meta name="robots" content="noindex, nofollow">

    <!-- Open Graph Meta -->
    <meta property="og:title" content="OneUI - Bootstrap 5 Admin Template &amp; UI Framework">
    <meta property="og:site_name" content="OneUI">
    <meta property="og:description"
        content="OneUI - Bootstrap 5 Admin Template &amp; UI Framework created by pixelcave and published on Themeforest">
    <meta property="og:type" content="website">
    <meta property="og:url" content="">
    <meta property="og:image" content="">

    <!-- Icons -->
    <link rel="shortcut icon" href="{{ asset('assets/media/favicons/logo.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('assets/media/favicons/logo.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('assets/media/favicons/logo_phb.png') }}">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" id="css-main" href="{{ asset('assets/css/oneui.min.css') }}">
    @stack('styles')
</head>

<body>
    <div id="page-container" class="page-header-dark main-content-boxed">
        <!-- Header -->
        <header id="page-header">
            <div class="content-header">
                <!-- Left Section -->
                <div class="d-flex align-items-center">
                    <!-- Logo -->
                    <a class="tracking-wider fw-semibold fs-5 text-dual me-3" href="/">SIKEMA<span
                            class="fw-normal">TI</span></a>

                    <!-- Notifications -->
                    <div class="dropdown d-inline-block me-2" style="z-index: 1040;">
                        <button type="button" class="btn btn-sm btn-alt-secondary"
                            id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <i class="fa fa-fw fa-bell"></i>
                            <span class="text-primary">•</span>
                        </button>
                        <div class="p-0 border-0 dropdown-menu dropdown-menu-lg fs-sm"
                            aria-labelledby="page-header-notifications-dropdown">
                            <div class="p-2 text-center bg-body-light border-bottom rounded-top">
                                <h5 class="dropdown-header text-uppercase">Pemberitahuan</h5>
                            </div>
                            <ul class="mb-0 nav-items">
                                <li>
                                    <a class="py-2 text-dark d-flex" href="javascript:void(0)">
                                        <div class="flex-shrink-0 me-2 ms-3">
                                            <i class="fa fa-fw fa-check-circle text-success"></i>
                                        </div>
                                        <div class="flex-grow-1 pe-2">
                                            <div class="fw-semibold">Selamat datang di SIKEMA</div>
                                            <span class="fw-medium text-muted">2025-06-25</span>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a class="py-2 text-dark d-flex" href="javascript:void(0)">
                                        <div class="flex-shrink-0 me-2 ms-3">
                                            <i class="fa fa-fw fa-plus-circle text-primary"></i>
                                        </div>
                                        <div class="flex-grow-1 pe-2">
                                            <div class="fw-semibold">Segera ganti password akun, jika belum diganti
                                            </div>
                                            <span class="fw-medium text-muted">26 min ago</span>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- END Left Section -->

                <!-- Right Section -->
                <div class="d-flex align-items-center">


                </div>
                <!-- END Right Section -->
            </div>

            <!-- Header Loader -->
            <div id="page-header-loader" class="overlay-header bg-primary-lighter">
                <div class="content-header">
                    <div class="text-center w-100">
                        <i class="fa fa-fw fa-circle-notch fa-spin text-primary"></i>
                    </div>
                </div>
            </div>
            <!-- END Header Loader -->
        </header>
        <!-- END Header -->

        <!-- Main Content -->
        <!-- Navigation Bar-->
        <div class="bg-primary-darker sticky-top" style="z-index : 1030;">
            <div class="container py-3 content">
                <!-- Toggle Main Navigation -->
                <div class="d-lg-none">
                    <!-- Class Toggle, functionality initialized in Helpers.oneToggleClass() -->
                    <button type="button"
                        class="btn w-100 btn-alt-secondary d-flex justify-content-between align-items-center"
                        data-toggle="class-toggle" data-target="#main-navigation" data-class="d-none">
                        Menu
                        <i class="fa fa-bars"></i>
                    </button>
                </div>
                <!-- END Toggle Main Navigation -->

                <!-- Main Navigation -->
                <div id="main-navigation" class="mt-2 d-none d-lg-block mt-lg-0">
                    <ul class="nav-main nav-main-dark nav-main-horizontal nav-main-hover">

                    </ul>
                </div>
                <!-- END Main Navigation -->
            </div>
        </div>
        <!-- END Navigation -->


        <div class="container py-4">
            <!-- Header -->
            <div class="mb-4 row">
                <div class="col-12">
                    <div class="p-3 rounded shadow-sm d-flex align-items-center justify-content-between bg-secondary">
                        <div>
                            <h2 class="mb-1 text-white fw-bold">
                                <i class="fas fa-chart-bar me-2"></i>Hasil Kuesioner Supervisor
                            </h2>
                            <div class="text-white-50">Evaluasi kinerja alumni berdasarkan penilaian atasan</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <!-- Informasi Alumni -->
                <div class="col-lg-12">
                    <div class="border-0 shadow-sm card h-100">
                        <div class="text-white card-header bg-secondary rounded-top">
                            <i class="fas fa-user me-2"></i>Informasi Alumni
                        </div>
                        <div class="card-body">
                            <dl class="mb-0 row">
                                <dt class="col-5 col-md-4">Nama Alumni</dt>
                                <dd class="col-7 col-md-8">{{ $tracerPengguna->nama_alumni }}</dd>
                                <dt class="col-5 col-md-4">Jabatan Alumni</dt>
                                <dd class="col-7 col-md-8">{{ $tracerPengguna->jabatan_alumni }}</dd>
                                <dt class="col-5 col-md-4">Nama Perusahaan</dt>
                                <dd class="col-7 col-md-8">{{ $tracerPengguna->nama_perusahaan }}</dd>
                                <dt class="col-5 col-md-4">Tanggal Mulai Kerja</dt>
                                <dd class="col-7 col-md-8">
                                    {{ $tracerPengguna->tanggal_mulai_kerja ? \Carbon\Carbon::parse($tracerPengguna->tanggal_mulai_kerja)->format('d-m-Y') : '-' }}
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <!-- Informasi Atasan -->
                <div class="col-lg-12">
                    <div class="border-0 shadow-sm card h-100">
                        <div class="text-white card-header bg-secondary rounded-top">
                            <i class="fas fa-user-tie me-2"></i>Informasi Atasan
                        </div>
                        <div class="card-body">
                            <dl class="mb-0 row">
                                <dt class="col-5 col-md-4">Nama Atasan</dt>
                                <dd class="col-7 col-md-8">{{ $tracerPengguna->nama_atasan }}</dd>
                                <dt class="col-5 col-md-4">Jabatan Atasan</dt>
                                <dd class="col-7 col-md-8">{{ $tracerPengguna->jabatan_atasan }}</dd>
                                <dt class="col-5 col-md-4">NIPY Atasan</dt>
                                <dd class="col-7 col-md-8">{{ $tracerPengguna->nipy}}</dd>
                                <dt class="col-5 col-md-4">Email Atasan</dt>
                                <dd class="col-7 col-md-8">
                                    @if ($tracerPengguna->email_atasan)
                                        <i class=""></i>{{ $tracerPengguna->email_atasan }}
                                    @else
                                        <span class="text-muted">Tidak ada email</span>
                                    @endif
                                </dd>
                                <dt class="col-5 col-md-4">WhatsApp Atasan</dt>
                                <dd class="col-7 col-md-8">
                                    @if ($tracerPengguna->wa_atasan)
                                        <i class=""></i>{{ $tracerPengguna->wa_atasan }}
                                    @else
                                        <span class="text-muted">Tidak ada WhatsApp</span>
                                    @endif
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Kuesioner -->
            <div class="mt-4 row">
                <div class="col-lg-12">
                    <div class="border-0 shadow-sm card h-100">
                        <div class="text-white card-header bg-secondary rounded-top">
                            <i class="fas fa-check-circle me-2"></i>Status Pengisian
                        </div>
                        <div class="card-body">
                            <dl class="mb-0 row">
                                <dt class="col-5 col-md-4">Status</dt>
                                <dd class="col-7 col-md-8">
                                    @if ($tracerPengguna->status_pengisian == 'completed')
                                        <span class="text-dark fs-6">Selesai</span>
                                    @else
                                        <span
                                            class="badge bg-warning text-dark fs-6">{{ ucfirst($tracerPengguna->status_pengisian) }}</span>
                                    @endif
                                </dd>
                                <dt class="col-5 col-md-4">Tanggal Pengisian</dt>
                                <dd class="col-7 col-md-8">
                                    {{ $tracerPengguna->tanggal_isi ? \Carbon\Carbon::parse($tracerPengguna->tanggal_isi)->format('d-m-Y H:i:s') : '-' }}
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hasil Evaluasi -->
            <div class="mt-4 row">
                <div class="col-12">
                    @if ($tracerPengguna->status_pengisian == 'completed')
                        <div class="border-0 shadow-sm card">
                            <div class="text-white card-header bg-secondary rounded-top">
                                <i class="fas fa-star me-2"></i>Hasil Evaluasi Kinerja
                            </div>
                            <div class="card-body">
                                <div class="row g-4">
                                    <!-- Evaluasi Kinerja -->
                                    <div class="col-lg-6">
                                        <div class="mb-4">
                                            <h6 class="mb-3 fw-semibold text-dark">
                                                <i class="fas fa-chart-line me-2"></i>Evaluasi Kinerja Alumni
                                            </h6>
                                            <table class="table mb-0 table-borderless">
                                                <tbody>
                                                    @php
                                                        $aspek = [
                                                            'integritas' => 'Integritas',
                                                            'keahlian' => 'Keahlian',
                                                            'kemampuan' => 'Kemampuan',
                                                            'penguasaan' => 'Penguasaan',
                                                            'komunikasi' => 'Komunikasi',
                                                            'kerja_tim' => 'Kerja Tim',
                                                            'pengembangan' => 'Pengembangan',
                                                        ];
                                                    @endphp
                                                    @foreach ($aspek as $key => $label)
                                                        <tr>
                                                            <td class="align-middle" style="width: 40%;">
                                                                {{ $label }}</td>
                                                            <td class="align-middle" style="width: 40%;">
                                                                @for ($i = 1; $i <= 5; $i++)
                                                                    <i
                                                                        class="fa fa-star {{ $i <= ($tracerPengguna->$key ?? 0) ? 'text-warning' : 'text-muted' }}"></i>
                                                                @endfor
                                                            </td>
                                                            <td class="align-middle" style="width: 20%;">
                                                                <span
                                                                    class="badge bg-primary">{{ $tracerPengguna->$key ?? '-' }}/5</span>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- Evaluasi Kesesuaian Pendidikan & Kualitas Lulusan -->
                                    <div class="col-lg-6">
                                        <div class="mb-4">
                                            <h6 class="mb-3 fw-semibold text-dark">
                                                <i class="fas fa-graduation-cap me-2"></i>Evaluasi Kesesuaian
                                                Pendidikan
                                            </h6>
                                            <table class="table mb-0 table-borderless">
                                                <tbody>
                                                    <tr>
                                                        <td style="width: 60%;">Kesesuaian Pendidikan dengan Pekerjaan
                                                        </td>
                                                        <td>
                                                            @if ($tracerPengguna->kesesuaian_pendidikan_pekerjaan)
                                                                @php
                                                                    $kesesuaianLabels = [
                                                                        'sangat_sesuai' => 'Sangat Sesuai',
                                                                        'sesuai' => 'Sesuai',
                                                                        'cukup_sesuai' => 'Cukup Sesuai',
                                                                        'kurang_sesuai' => 'Kurang Sesuai',
                                                                        'tidak_sesuai' => 'Tidak Sesuai',
                                                                    ];
                                                                @endphp
                                                                <span class="badge text-dark fs-6">
                                                                    {{ $kesesuaianLabels[$tracerPengguna->kesesuaian_pendidikan_pekerjaan] }}
                                                                </span>
                                                            @else
                                                                <span class="text-muted">-</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Kualitas Lulusan</td>
                                                        <td>
                                                            @if ($tracerPengguna->kualitas_lulusan)
                                                                @php
                                                                    $kualitasLabels = [
                                                                        'sangat_baik' => 'Sangat Baik',
                                                                        'baik' => 'Baik',
                                                                        'cukup' => 'Cukup',
                                                                        'kurang' => 'Kurang',
                                                                        'sangat_kurang' => 'Sangat Kurang',
                                                                    ];

                                                                @endphp
                                                                <span class="badge text-dark fs-6">
                                                                    {{ $kualitasLabels[$tracerPengguna->kualitas_lulusan] }}
                                                                </span>
                                                            @else
                                                                <span class="text-muted">-</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- Saran Perbaikan -->
                                @if ($tracerPengguna->saran_perbaikan)
                                    <div class="mb-4 row">
                                        <div class="col-12">
                                            <div class="shadow-sm alert alert-light">
                                                <div class="mb-1 fw-semibold">
                                                    <i class="fas fa-comment me-2"></i>Saran Perbaikan
                                                </div>
                                                <div>{{ $tracerPengguna->saran_perbaikan }}</div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- Chart Evaluasi & Ringkasan -->
                                <div class="row align-items-stretch">
                                    <div class="mb-3 col-lg-8 mb-lg-0">
                                        <div
                                            class="p-3 rounded bg-light h-100 d-flex flex-column justify-content-center">
                                            <h6 class="mb-3 fw-semibold text-dark">
                                                <i class="fas fa-chart-bar me-2"></i>Grafik Evaluasi Kinerja
                                            </h6>
                                            <div style="height: 320px;">
                                                <canvas id="evaluationChart" style="max-height: 300px;"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="p-3 rounded bg-light h-100">
                                            <h6 class="mb-2 fw-semibold">Ringkasan Skor</h6>
                                            @php
                                                $scores = [
                                                    'integritas' => $tracerPengguna->integritas,
                                                    'keahlian' => $tracerPengguna->keahlian,
                                                    'kemampuan' => $tracerPengguna->kemampuan,
                                                    'penguasaan' => $tracerPengguna->penguasaan,
                                                    'komunikasi' => $tracerPengguna->komunikasi,
                                                    'kerja_tim' => $tracerPengguna->kerja_tim,
                                                    'pengembangan' => $tracerPengguna->pengembangan,
                                                ];
                                                $nonZeroScores = array_filter($scores, function ($score) {
                                                    return $score > 0;
                                                });
                                                $labels = [
                                                    'integritas' => 'Integritas',
                                                    'keahlian' => 'Keahlian',
                                                    'kemampuan' => 'Kemampuan',
                                                    'penguasaan' => 'Penguasaan',
                                                    'komunikasi' => 'Komunikasi',
                                                    'kerja_tim' => 'Kerja Tim',
                                                    'pengembangan' => 'Pengembangan',
                                                ];
                                            @endphp
                                            <div class="mb-2">
                                                <small class="text-muted">Skor Tertinggi:</small><br>
                                                <span class="badge bg-success fs-6">
                                                    @if (!empty($nonZeroScores))
                                                        @php
                                                            $maxScore = max($nonZeroScores);
                                                            $maxKey = array_search($maxScore, $nonZeroScores);
                                                        @endphp
                                                        {{ $labels[$maxKey] . ' (' . $maxScore . '/5)' }}
                                                    @else
                                                        Belum ada data
                                                    @endif
                                                </span>
                                            </div>
                                            <div class="mb-2">
                                                <small class="text-muted">Skor Terendah:</small><br>
                                                <span class="badge bg-warning text-dark fs-6">
                                                    @if (!empty($nonZeroScores))
                                                        @php
                                                            $minScore = min($nonZeroScores);
                                                            $minKey = array_search($minScore, $nonZeroScores);
                                                        @endphp
                                                        {{ $labels[$minKey] . ' (' . $minScore . '/5)' }}
                                                    @else
                                                        Belum ada data
                                                    @endif
                                                </span>
                                            </div>
                                            <div>
                                                <small class="text-muted">Rata-rata:</small><br>
                                                <span class="badge bg-primary fs-6">
                                                    @if (!empty($nonZeroScores))
                                                        {{ number_format(array_sum($nonZeroScores) / count($nonZeroScores), 2) . '/5' }}
                                                    @else
                                                        0.00/5
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Pesan jika belum diisi -->
                        <div class="border-0 shadow-sm card">
                            <div class="text-white card-header bg-secondary rounded-top">
                                <i class="fas fa-info-circle me-2"></i>Status Kuesioner
                            </div>
                            <div class="py-4 text-center card-body">
                                <i class="mb-3 fa fa-file-alt fa-3x text-muted"></i>
                                <p class="mb-0 text-muted">
                                    @if ($tracerPengguna->status_pengisian == 'pending')
                                        Kuesioner belum diisi oleh supervisor.
                                    @elseif($tracerPengguna->status_pengisian == 'expired')
                                        Link kuesioner sudah kadaluarsa.
                                    @else
                                        Kuesioner belum tersedia untuk diisi.
                                    @endif
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <style>
            .bg-gradient-primary {
                background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            }

            .card {
                border-radius: 12px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            }

            .card-header {
                border-bottom: none;
                border-radius: 12px 12px 0 0 !important;
                font-weight: 600;
                font-size: 1.1rem;
            }

            .table-borderless> :not(caption)>*>* {
                border-bottom-width: 0;
            }

            .fa-star {
                font-size: 1.1em;
            }

            .badge {
                font-size: 0.95em;
                font-weight: 500;
            }

            .alert-light {
                background: #f8f9fa;
            }

            @media (max-width: 767.98px) {
                .card-header {
                    font-size: 1rem;
                }

                .badge {
                    font-size: 0.85em;
                }
            }
        </style>

        @if ($tracerPengguna->status_pengisian == 'completed')
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const ctx = document.getElementById('evaluationChart').getContext('2d');
                    const data = {
                        labels: ['Integritas', 'Keahlian', 'Kemampuan', 'Penguasaan', 'Komunikasi', 'Kerja Tim',
                            'Pengembangan'
                        ],
                        datasets: [{
                            label: 'Skor Evaluasi',
                            data: [
                                {{ $tracerPengguna->integritas ?? 0 }},
                                {{ $tracerPengguna->keahlian ?? 0 }},
                                {{ $tracerPengguna->kemampuan ?? 0 }},
                                {{ $tracerPengguna->penguasaan ?? 0 }},
                                {{ $tracerPengguna->komunikasi ?? 0 }},
                                {{ $tracerPengguna->kerja_tim ?? 0 }},
                                {{ $tracerPengguna->pengembangan ?? 0 }}
                            ],
                            backgroundColor: 'rgba(54, 162, 235, 0.15)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 2,
                            pointBackgroundColor: 'rgba(54, 162, 235, 1)',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 6,
                            pointHoverRadius: 8
                        }]
                    };
                    const config = {
                        type: 'radar',
                        data: data,
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                r: {
                                    beginAtZero: true,
                                    max: 5,
                                    ticks: {
                                        stepSize: 1,
                                        callback: function(value) {
                                            return value + '/5';
                                        }
                                    },
                                    pointLabels: {
                                        font: {
                                            size: 14
                                        }
                                    }
                                }
                            },
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            return context.parsed.r + '/5';
                                        }
                                    }
                                }
                            }
                        }
                    };
                    new Chart(ctx, config);
                });
            </script>
        @endif
        <!-- END Main Content -->





        <!-- Footer -->
        <div class="mt-5">
            <footer id="page-footer" class="mt-5 footer-sticky bg-body-extra-light fixed-bottom">
                <div class="py-3 content">
                    <div class="row fs-sm">
                        <div class="py-1 text-center col-sm-6 order-sm-2 text-sm-end">
                            Politeknik Harapan Bersama
                        </div>
                        <div class="py-1 text-center col-sm-6 order-sm-1 text-sm-start">
                            <a class="fw-semibold" href="https://1.envato.market/AVD6j" target="_blank">Copyright</a>
                            &copy; SikemaTI<span data-toggle="year-copy">2025</span>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <!-- END Footer -->
    </div>
    <!-- END Page Container -->

    <!-- Scripts -->
    <script src="{{ asset('assets/js/lib/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/oneui.app.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/chart.js/chart.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables-bs5/js/dataTables.bootstrap5.min.js') }}"></script>

    @stack('scripts')
</body>

</html>
