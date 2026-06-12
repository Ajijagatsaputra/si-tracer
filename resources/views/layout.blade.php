<!doctype html>
<html lang="en">

<head id="page-header" class="sticky-top bg-body">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
                    <a class="fw-semibold fs-5 tracking-wider text-dual me-3 d-flex align-items-center"
                        href="{{ route('dashboard') }}">
                        <img src="{{ asset('assets/media/favicons/logo_harkatnegeri.png') }}" alt="Logo" class="me-2"
                            style="width: 28px; height: 28px; object-fit: contain;">
                        Tracer Study <span class="fw-normal ms-1">TI UHN</span>
                    </a>



                    <!-- Notifications -->
                    <div class="dropdown d-inline-block me-2" style="z-index: 1040;">
                        <button type="button" class="btn btn-sm btn-alt-secondary position-relative"
                            id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <i class="fa fa-fw fa-bell"></i>
                            @if(isset($headerUnreadCount) && $headerUnreadCount > 0)
                                <span
                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                    style="font-size: 0.6rem; padding: 0.25em 0.45em;">
                                    {{ $headerUnreadCount }}
                                </span>
                            @endif
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg p-0 border-0 fs-sm"
                            aria-labelledby="page-header-notifications-dropdown">
                            <div class="p-2 bg-body-light border-bottom text-center rounded-top">
                                <h5 class="dropdown-header text-uppercase">Pemberitahuan</h5>
                            </div>
                            <ul class="nav-items mb-0" style="max-height: 320px; overflow-y: auto;">
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
                                    <li class="text-center py-3 text-muted">
                                        <i class="fa fa-bell-slash me-1"></i> Tidak ada pemberitahuan
                                    </li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- END Left Section -->

                <!-- Right Section -->
                <div class="d-flex align-items-center">

                    @if (Auth::check())
                        <!-- User Dropdown -->
                        <div class="dropdown d-inline-block ms-2" style="z-index: 1040;">
                            <button type="button" class="btn btn-sm btn-alt-secondary" id="page-header-user-dropdown"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="rounded"
                                    src="{{ Auth::user()->avatar ? asset('storage/avatars/' . Auth::user()->avatar) : asset('assets/media/avatars/avatar10.jpg') }}"
                                    alt="Header Avatar" style="width: 21px;" />
                                <span class="d-none d-sm-inline-block ms-1">{{ Auth::user()->username }}</span>
                                <i class="fa fa-fw fa-angle-down d-none d-sm-inline-block"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-md dropdown-menu-end p-0 border-0"
                                aria-labelledby="page-header-user-dropdown">
                                <div class="p-3 text-center text-white bg-dark border-bottom rounded-top">
                                    <img class="img-avatar img-avatar48 img-avatar-thumb"
                                        src="{{ Auth::user()->avatar ? asset('storage/avatars/' . Auth::user()->avatar) : asset('assets/media/avatars/avatar10.jpg') }}"
                                        alt="Avatar">
                                    <p class="mt-2 mb-0 fw-medium">{{ Auth::user()->username }}</p>
                                    <p class="mb-0 text-muted fs-sm fw-medium">{{ Auth::user()->role }}</p>
                                </div>
                                <div class="p-2">
                                    <a class="dropdown-item d-flex align-items-center justify-content-between"
                                        href="{{ route('profile') }}">
                                        <span class="fs-sm fw-medium">Profile</span>
                                    </a>
                                    @if (Auth::user()->role === 'alumni')
                                        <a class="dropdown-item d-flex align-items-center justify-content-between"
                                            href="{{ route('profile.cv') }}">
                                            <span class="fs-sm fw-medium">Cetak CV (ATS)</span>
                                        </a>
                                    @endif
                                    <a class="dropdown-item d-flex align-items-center justify-content-between"
                                        href="{{ route('home') }}">
                                        <span class="fs-sm fw-medium">Ke Landing Page</span>
                                    </a>
                                </div>
                                <div role="separator" class="dropdown-divider m-0"></div>
                                <div class="p-2">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit"
                                            class="dropdown-item d-flex align-items-center justify-content-between">
                                            <span class="fs-sm fw-medium">Log Out</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
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
        @yield('content')
        <!-- END Main Content -->

        <!-- Footer -->
        <footer id="page-footer" class="bg-primary-darker text-white-75 mt-5">
            <div class="content py-4">
                <div class="row items-push fs-sm align-items-center">
                    <div class="col-sm-6 text-center text-sm-start animate-fade-in">
                        <a class="fw-semibold text-white" href="/" target="_blank">Tracer Study TI UHN</a>
                        &copy; <span data-toggle="year-copy">2026</span>
                    </div>
                    <div class="col-sm-6 text-center text-sm-end animate-fade-in">
                        <img src="{{ asset('assets/media/favicons/logo-uhn-new.svg') }}" alt="Logo UHN"
                            style="height: 32px; max-width: 100%; object-fit: contain;">
                    </div>
                </div>
            </div>
        </footer>
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