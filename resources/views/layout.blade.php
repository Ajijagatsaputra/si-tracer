<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Tracer Study TI UHN | Portal Mahasiswa & Alumni')</title>

    <meta name="description" content="Tracer Study TI UHN - Portal Mahasiswa & Alumni">
    <meta name="author" content="Universitas Harkat Negeri">
    <meta name="robots" content="noindex, nofollow">

    <!-- Icons -->
    <link rel="shortcut icon" href="{{ asset('assets/media/favicons/logo_harkatnegeri.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('assets/media/favicons/logo_harkatnegeri.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/media/favicons/logo_harkatnegeri.png') }}">

    <!-- Stylesheets -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" id="css-main" href="{{ asset('assets/css/oneui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/modern-custom.css') }}?v=4">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">

    <style>
        @media screen {
            html,
            body {
                height: 100%;
                overflow: hidden;
            }

            #page-container {
                display: flex;
                flex-direction: column;
                height: 100vh;
                height: 100dvh;
                min-height: 0 !important;
                overflow: hidden;
                padding-top: 60px !important;
            }

            #alumni-scroll-viewport {
                flex: 1 1 auto;
                min-height: 0;
                display: flex;
                flex-direction: column;
                overflow-y: auto;
                overflow-x: hidden;
                overscroll-behavior-y: contain;
                -webkit-overflow-scrolling: touch;
                scroll-behavior: smooth;
                background-color: #f8fafc;
                padding-bottom: 2rem;
            }

            #page-container.dark-mode #alumni-scroll-viewport {
                background-color: #0b0f19 !important;
            }

            #alumni-scroll-viewport > #main-container {
                flex: 1 0 auto;
                width: 100%;
                max-width: 100%;
                padding-top: 0 !important;
                padding-left: 0 !important;
            }
        }

        @media print {
            html,
            body,
            #page-container,
            #alumni-scroll-viewport,
            #main-container {
                height: auto !important;
                min-height: 0 !important;
                overflow: visible !important;
                margin: 0 !important;
                padding: 0 !important;
                width: 100% !important;
                display: block !important;
                background: #ffffff !important;
            }

            #page-header,
            #sidebar {
                display: none !important;
            }
        }
    </style>
    @yield('styles')
    @stack('styles')
</head>

<body>
    @php
        $navUser = Auth::user();
        $navAlumni = $navUser ? ($navUser->alumni ?? \App\Models\Alumni::where('id_users', $navUser->id)->first()) : null;
        $navExistingTracer = null;
        if ($navUser) {
            $navExistingTracer = $navAlumni
                ? \App\Models\TracerStudy::where('alumni_id', $navAlumni->id)->first()
                : \App\Models\TracerStudy::where('user_id', $navUser->id)->first();
        }
        $navTracerPengguna = $navExistingTracer
            ? \App\Models\TracerPengguna::where('tracer_study_id', $navExistingTracer->id)->first()
            : null;
    @endphp

    <div id="page-container"
        class="sidebar-o sidebar-dark enable-page-overlay side-scroll page-header-fixed main-content-narrow">

        <!-- Top Header (Admin Akila Style) -->
        <header id="page-header">
            <div class="content-header">
                <!-- Left Section -->
                <div class="gap-2 d-flex align-items-center flex-grow-1" style="max-width: 420px;">
                    <button type="button" class="border-0 btn btn-sm btn-light text-secondary d-lg-none"
                        data-toggle="layout" data-action="sidebar_toggle" aria-label="Buka Sidebar">
                        <i class="fa fa-fw fa-bars"></i>
                    </button>

                    <button type="button" class="border-0 btn btn-sm btn-light text-secondary d-none d-lg-inline-block"
                        data-toggle="layout" data-action="sidebar_mini_toggle" aria-label="perkecil Sidebar">
                        <i class="fa fa-fw fa-bars"></i>
                    </button>

                    <div class="akila-header-search d-none d-sm-flex align-items-center flex-grow-1">
                        <i class="fa fa-search text-muted"></i>
                        <input type="text" id="akila-global-table-search"
                            placeholder="Cari data pada halaman ini..." autocomplete="off">
                    </div>
                </div>
                <!-- END Left Section -->

                <!-- Right Section -->
                <div class="gap-2 d-flex align-items-center">
                    <!-- Notifications -->
                    <div class="dropdown d-inline-block">
                        <button type="button"
                            class="border-0 btn btn-sm btn-light text-secondary rounded-circle d-flex align-items-center justify-content-center position-relative"
                            style="width: 34px; height: 34px;" id="page-header-notifications-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Pemberitahuan">
                            <i class="fa fa-bell"></i>
                            @if(isset($headerUnreadCount) && $headerUnreadCount > 0)
                                <span
                                    class="top-0 position-absolute start-100 translate-middle badge rounded-pill bg-danger"
                                    style="font-size: 0.6rem; padding: 0.25em 0.45em;">
                                    {{ $headerUnreadCount }}
                                </span>
                            @endif
                        </button>
                        <div class="p-0 border shadow-sm dropdown-menu dropdown-menu-lg dropdown-menu-end rounded-3 fs-sm"
                            aria-labelledby="page-header-notifications-dropdown">
                            <div class="p-2 text-center bg-body-light border-bottom rounded-top">
                                <h5 class="mb-0 dropdown-header text-uppercase">Pemberitahuan</h5>
                            </div>
                            <ul class="mb-0 nav-items" style="max-height: 320px; overflow-y: auto;">
                                @forelse(($headerNotifications ?? []) as $notif)
                                    <li>
                                        <a class="text-dark d-flex py-2 {{ $notif['unread'] ? 'bg-light' : '' }}"
                                            href="{{ $notif['url'] }}">
                                            <div class="flex-shrink-0 me-2 ms-3">
                                                <i class="fa fa-fw {{ $notif['icon'] }} {{ $notif['color'] }}"></i>
                                            </div>
                                            <div class="flex-grow-1 pe-2">
                                                <div class="fw-semibold">{{ $notif['title'] }}</div>
                                                <div class="text-muted fs-xs">{{ $notif['desc'] }}</div>
                                                <span class="fw-medium text-muted fs-xs">{{ $notif['time'] }}</span>
                                            </div>
                                            @if($notif['unread'])
                                                <div class="flex-shrink-0 me-2 d-flex align-items-center">
                                                    <span class="d-inline-block rounded-circle bg-primary"
                                                        style="width: 8px; height: 8px;"></span>
                                                </div>
                                            @endif
                                        </a>
                                    </li>
                                @empty
                                    <li class="py-3 text-center text-muted">
                                        <i class="fa fa-bell-slash me-1"></i> Tidak ada pemberitahuan
                                    </li>
                                @endforelse
                            </ul>
                        </div>
                    </div>

                    <!-- Theme Toggle -->
                    <button type="button"
                        class="border-0 btn btn-sm btn-light text-secondary rounded-circle d-flex align-items-center justify-content-center"
                        style="width: 34px; height: 34px;" data-toggle="layout" data-action="dark_mode_toggle"
                        title="Tema Tampilan">
                        <i class="fa fa-cog"></i>
                    </button>

                    @if (Auth::check())
                        <!-- User Dropdown -->
                        <div class="dropdown d-inline-block">
                            <button type="button" class="p-1 bg-transparent border-0 btn btn-sm d-flex align-items-center"
                                id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                @if (Auth::user()->avatar)
                                    <img class="rounded-circle object-fit-cover"
                                        src="{{ asset('storage/avatars/' . Auth::user()->avatar) }}" alt="Avatar"
                                        style="width: 34px; height: 34px; border: 2px solid #eab308;">
                                @else
                                    <span class="akila-avatar-ring">
                                        <i class="fa fa-user"></i>
                                    </span>
                                @endif
                                <span class="d-none d-md-inline-block ms-2 fw-semibold text-dark"
                                    style="font-size: 0.84rem;">{{ Auth::user()->username }}</span>
                                <i class="opacity-50 fa fa-fw fa-angle-down d-none d-md-inline-block ms-1 text-muted"
                                    style="font-size: 0.75rem;"></i>
                            </button>
                            <div class="p-0 border shadow-sm dropdown-menu dropdown-menu-md dropdown-menu-end rounded-3"
                                aria-labelledby="page-header-user-dropdown">
                                <div class="p-3 text-center bg-body-light border-bottom rounded-top">
                                    <img class="img-avatar img-avatar48 img-avatar-thumb"
                                        src="{{ Auth::user()->avatar ? asset('storage/avatars/' . Auth::user()->avatar) : asset('assets/media/avatars/avatar10.jpg') }}"
                                        alt="Avatar">
                                    <p class="mt-2 mb-0 fw-semibold text-dark">{{ Auth::user()->username }}</p>
                                    <p class="mb-0 text-muted fs-xs fw-medium text-uppercase">{{ Auth::user()->role }}</p>
                                </div>
                                <div class="p-2">
                                    <a class="dropdown-item d-flex align-items-center justify-content-between rounded-2 {{ request()->routeIs('profile') ? 'active' : '' }}"
                                        href="{{ route('profile') }}">
                                        <span class="fs-sm fw-medium"><i
                                                class="fa fa-user-cog me-2 text-muted"></i>Profil Saya</span>
                                    </a>
                                    @if (Auth::user()->role === 'alumni')
                                        <a class="dropdown-item d-flex align-items-center justify-content-between rounded-2 {{ request()->routeIs('profile.cv') ? 'active' : '' }}"
                                            href="{{ route('profile.cv') }}">
                                            <span class="fs-sm fw-medium"><i
                                                    class="fa fa-file-invoice me-2 text-muted"></i>Cetak CV (ATS)</span>
                                        </a>
                                    @endif
                                    <a class="dropdown-item d-flex align-items-center justify-content-between rounded-2"
                                        href="{{ route('home') }}">
                                        <span class="fs-sm fw-medium"><i
                                                class="fa fa-globe me-2 text-muted"></i>Ke Landing Page</span>
                                    </a>
                                </div>
                                <div role="separator" class="m-0 dropdown-divider"></div>
                                <div class="p-2">
                                    <form method="POST" action="{{ route('logout') }}"
                                        class="d-flex align-items-center justify-content-between">
                                        @csrf
                                        <button type="submit"
                                            class="bg-transparent border-0 dropdown-item fs-sm fw-medium text-danger rounded-2">
                                            <i class="fa fa-sign-out-alt me-2"></i>Log Out
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <!-- END Right Section -->
            </div>
        </header>
        <!-- END Top Header -->

        <!-- Sidebar (Admin Akila Dark Navy Style) -->
        <nav id="sidebar" aria-label="Main Navigation">
            <!-- Side Header -->
            <div class="content-header">
                <!-- Logo -->
                <a class="fw-bold text-dual d-flex align-items-center text-decoration-none"
                    href="{{ route('dashboard') }}">
                    <img src="{{ asset('assets/media/favicons/logo_harkatnegeri.png') }}" alt="Logo" class="me-2"
                        style="width: 28px; height: 28px; object-fit: contain;">
                    <span class="tracking-wider smini-hide fs-5">
                        <span class="text-white">Tracer</span><span style="color: #4facfe;">Study</span>
                    </span>
                </a>
                <!-- END Logo -->

                <!-- Extra -->
                <div>
                    <button type="button" class="btn btn-sm btn-alt-secondary" data-toggle="layout"
                        data-action="dark_mode_toggle" title="Dark Mode">
                        <i class="far fa-moon"></i>
                    </button>

                    <a class="d-lg-none btn btn-sm btn-alt-secondary ms-1" data-toggle="layout"
                        data-action="sidebar_close" href="javascript:void(0)">
                        <i class="fa fa-fw fa-times"></i>
                    </a>
                </div>
                <!-- END Extra -->
            </div>
            <!-- END Side Header -->

            <!-- Sidebar Scrolling -->
            <div class="js-sidebar-scroll">
                <div class="content-side">
                    <ul class="nav-main">
                        <!-- DASHBOARD -->
                        <li class="nav-main-item">
                            <a class="nav-main-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                                href="{{ route('dashboard') }}">
                                <i class="nav-main-link-icon fa fa-tachometer-alt text-primary"></i>
                                <span class="nav-main-link-name">Dashboard</span>
                            </a>
                        </li>

                        <!-- TRACER STUDY -->
                        <li class="nav-main-heading text-uppercase text-muted fw-bold">Tracer Study</li>

                        @if (!$navExistingTracer)
                            <li class="nav-main-item">
                                <a class="nav-main-link {{ request()->routeIs('new-tracer.index') ? 'active' : '' }}"
                                    href="{{ route('new-tracer.index') }}">
                                    <i class="nav-main-link-icon fa fa-clipboard-list text-success"></i>
                                    <span class="nav-main-link-name">Isi Tracer Study</span>
                                </a>
                            </li>
                        @else
                            <li
                                class="nav-main-item {{ request()->routeIs('new-tracer.*') || request()->routeIs('supervisor.questionnaire.*') || request()->routeIs('alumni.evaluasi-atasan') ? 'open' : '' }}">
                                <a class="nav-main-link nav-main-link-submenu" data-toggle="custom-submenu"
                                    aria-haspopup="true" aria-expanded="false" href="javascript:void(0)">
                                    <i class="nav-main-link-icon fa fa-clipboard-list text-success"></i>
                                    <span class="nav-main-link-name">Tracer Study</span>
                                </a>
                                <ul class="nav-main-submenu">
                                    <li class="nav-main-item">
                                        <a class="nav-main-link {{ request()->routeIs('new-tracer.show') ? 'active' : '' }}"
                                            href="{{ route('new-tracer.show', $navExistingTracer->alumni_id) }}">
                                            <i class="nav-main-link-icon fa fa-user-check"></i>
                                            <span class="nav-main-link-name">Kuesioner Saya</span>
                                        </a>
                                    </li>
                                    <li class="nav-main-item">
                                        <a class="nav-main-link {{ request()->routeIs('new-tracer.edit') ? 'active' : '' }}"
                                            href="{{ route('new-tracer.edit') }}">
                                            <i class="nav-main-link-icon fa fa-edit"></i>
                                            <span class="nav-main-link-name">Perbarui Data</span>
                                        </a>
                                    </li>
                                    <li class="nav-main-item">
                                        <a class="nav-main-link {{ request()->routeIs('alumni.evaluasi-atasan') || request()->routeIs('supervisor.questionnaire.hasil') ? 'active' : '' }}"
                                            href="{{ route('alumni.evaluasi-atasan') }}">
                                            <i class="nav-main-link-icon fa fa-building"></i>
                                            <span class="nav-main-link-name">Evaluasi Atasan</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif

                        <!-- KARIR & DOKUMEN -->
                        <li class="nav-main-heading text-uppercase text-muted fw-bold">Karir & Dokumen</li>

                        <li class="nav-main-item">
                            <a class="nav-main-link {{ request()->routeIs('profile.cv') ? 'active' : '' }}"
                                href="{{ route('profile.cv') }}">
                                <i class="nav-main-link-icon fa fa-file-invoice text-warning"></i>
                                <span class="nav-main-link-name">Resume & CV ATS</span>
                            </a>
                        </li>

                        <li class="nav-main-item">
                            <a class="nav-main-link {{ request()->routeIs('alumni.loker.*') ? 'active' : '' }}"
                                href="{{ route('alumni.loker.index') }}">
                                <i class="nav-main-link-icon fa fa-briefcase text-info"></i>
                                <span class="nav-main-link-name">Riwayat Lamaran</span>
                            </a>
                        </li>

                        <!-- PENGATURAN AKUN -->
                        <li class="nav-main-heading text-uppercase text-muted fw-bold">Pengaturan</li>

                        <li class="nav-main-item">
                            <a class="nav-main-link {{ request()->routeIs('profile') ? 'active' : '' }}"
                                href="{{ route('profile') }}">
                                <i class="nav-main-link-icon fa fa-user-cog text-primary"></i>
                                <span class="nav-main-link-name">Profil Saya</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- END Sidebar Scrolling -->
        </nav>
        <!-- END Sidebar -->

        <!-- Scrollable Body Viewport -->
        <div id="alumni-scroll-viewport">
            @yield('content')
        </div>
        <!-- END Scrollable Body Viewport -->
    </div>

    <!-- Scripts -->
    <script src="{{ asset('assets/js/lib/jquery.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/js/oneui.app.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/chart.js/chart.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof jQuery !== 'undefined') {
                jQuery('[data-toggle="custom-submenu"]').on('click', function (e) {
                    e.preventDefault();
                    let parentLi = jQuery(this).parent('li');
                    let submenu = parentLi.children('.nav-main-submenu');

                    if (parentLi.hasClass('open')) {
                        parentLi.removeClass('open');
                        submenu.slideUp(200);
                    } else {
                        parentLi.addClass('open');
                        submenu.hide().slideDown(200);
                    }
                });
            }

            const globalSearch = document.getElementById('akila-global-table-search');
            if (globalSearch) {
                globalSearch.addEventListener('input', function () {
                    const val = this.value;
                    if (window.jQuery && jQuery.fn && jQuery.fn.dataTable) {
                        const tables = jQuery.fn.dataTable.tables({ visible: true, api: true });
                        if (tables.count() > 0) {
                            tables.search(val).draw();
                        }
                    }
                });
            }
        });
    </script>

    @yield('scripts')
    @stack('scripts')
</body>

</html>
