<!doctype html>
<html lang="en">

<head id="page-header" class="sticky-top bg-body">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <title>@yield('title', 'Tracer Study TI UHN')</title>

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
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('assets/media/favicons/logo_harkatnegeri.png') }}">

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
                    <a class="fw-semibold fs-5 tracking-wider text-dual me-3 d-flex align-items-center" href="/">
                        <img src="{{ asset('assets/media/favicons/logo_harkatnegeri.png') }}" alt="Logo" class="me-2"
                            style="width: 28px; height: 28px; object-fit: contain;">
                        Tracer Study <span class="fw-normal ms-1">TI UHN</span>
                    </a>

                    <!-- Notifications -->
                    <div class="dropdown d-inline-block me-2" style="z-index: 1040;">
                        <button type="button" class="btn btn-sm btn-alt-secondary"
                            id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <i class="fa fa-fw fa-bell"></i>
                            <span class="text-primary">•</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg p-0 border-0 fs-sm"
                            aria-labelledby="page-header-notifications-dropdown">
                            <div class="p-2 bg-body-light border-bottom text-center rounded-top">
                                <h5 class="dropdown-header text-uppercase">Pemberitahuan</h5>
                            </div>
                            <ul class="nav-items mb-0">
                                <li>
                                    <a class="text-dark d-flex py-2" href="javascript:void(0)">
                                        <div class="flex-shrink-0 me-2 ms-3">
                                            <i class="fa fa-fw fa-check-circle text-success"></i>
                                        </div>
                                        <div class="flex-grow-1 pe-2">
                                            <div class="fw-semibold">Selamat datang di Tracer Study TI UHN</div>
                                            <span class="fw-medium text-muted">2025-06-25</span>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a class="text-dark d-flex py-2" href="javascript:void(0)">
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
                    <div class="w-100 text-center">
                        <i class="fa fa-fw fa-circle-notch fa-spin text-primary"></i>
                    </div>
                </div>
            </div>
            <!-- END Header Loader -->
        </header>
        <!-- END Header -->

        <!-- Main Content -->
        <div class="container-lg mt-5 mb-5">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow-sm">
                        <div class="card-body text-center p-5">
                            <div class="mb-4">
                                <i class="fas fa-check-circle fa-4x text-success"></i>
                            </div>

                            <h2 class="card-title text-success mb-3">Terima Kasih!</h2>

                            <p class="card-text text-muted mb-4">
                                {{ $message ?? 'Kuesioner evaluasi kinerja alumni berhasil disimpan.' }}
                            </p>

                            <div class="alert alert-success">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Informasi:</strong>
                                <ul class="mb-0 mt-2 text-start">
                                    <li>Data evaluasi Anda telah tersimpan dengan aman</li>
                                    <li>Feedback Anda akan digunakan untuk perbaikan kualitas pendidikan</li>
                                    <li>Terima kasih atas kontribusi Anda dalam pengembangan kampus</li>
                                </ul>
                            </div>

                            <div class="mt-4 gap-2 d-flex justify-content-center flex-wrap">
                                <a href="{{ route('supervisor.questionnaire.hasil', $tracerPengguna->token_akses) }}"
                                    class="btn btn-success rounded-pill px-4">
                                    <i class="fas fa-chart-bar me-2"></i>Lihat Hasil
                                </a>
                                <a href="{{ route('mitra.loker.create') }}" class="btn btn-primary rounded-pill px-4">
                                    <i class="fa fa-briefcase me-2"></i>Posting Loker Mitra
                                </a>
                            </div>

                            <!-- Loker Upload Banner -->
                            <div class="card border-0 mt-5 text-start rounded-4 shadow-sm"
                                style="background-color: rgba(79, 70, 229, 0.05); border: 1px solid rgba(79, 70, 229, 0.15) !important;">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center gap-3 mb-2">
                                        <div class="bg-primary text-white p-2.5 rounded-3 d-flex align-items-center justify-content-center"
                                            style="width: 44px; height: 44px; min-width: 44px;">
                                            <i class="fa fa-briefcase fs-4"></i>
                                        </div>
                                        <div>
                                            <h5 class="fw-bold text-dark mb-0">Punya Lowongan Pekerjaan Aktif?</h5>
                                            <small class="text-muted">Pasang lowongan kerja gratis untuk alumni
                                                bertalenta kami</small>
                                        </div>
                                    </div>
                                    <p class="text-muted fs-sm mt-3 mb-4">
                                        Anda dapat langsung membagikan lowongan kerja aktif dari perusahaan Anda.
                                        Lowongan yang Anda unggah akan secara otomatis ditampilkan di Bursa Karir
                                        dashboard alumni Teknik Informatika setelah melalui validasi admin.
                                    </p>
                                    <a href="{{ route('mitra.loker.create') }}"
                                        class="btn btn-primary btn-sm rounded-pill px-4 fw-bold">
                                        <i class="fa fa-plus-circle me-1"></i> Posting Lowongan Kerja
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Main Content -->

        <!-- Footer -->
        <div class="mt-5">
            <footer id="page-footer" class="footer-sticky bg-body-extra-light fixed-bottom mt-5">
                <div class="content py-3">
                    <div class="row fs-sm">
                        <div class="col-sm-6 order-sm-2 py-1 text-center text-sm-end">
                            Universitas Harkat Negeri
                        </div>
                        <div class="col-sm-6 order-sm-1 py-1 text-center text-sm-start">
                            <a class="fw-semibold" href="https://1.envato.market/AVD6j" target="_blank">Copyright</a>
                            &copy; Tracer Study TI UHN<span data-toggle="year-copy">2025</span>
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