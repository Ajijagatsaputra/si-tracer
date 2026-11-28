<!DOCTYPE html>
<html lang="id" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Tracer Study & Bursa Kerja - Universitas Harkat Negeri</title>

    <script>
        // Check local storage or system preference immediately to prevent theme flashing
        (function() {
            const savedTheme = localStorage.getItem('theme');
            const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (savedTheme === 'dark' || (!savedTheme && systemPrefersDark)) {
                document.documentElement.setAttribute('data-bs-theme', 'dark');
            } else {
                document.documentElement.setAttribute('data-bs-theme', 'light');
            }
        })();
    </script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Icons -->
    <link rel="shortcut icon" href="{{ asset('assets/media/favicons/logo_harkatnegeri.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('assets/media/favicons/logo_harkatnegeri.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/media/favicons/logo_harkatnegeri.png') }}">

    <style>
        :root {
            --primary: #5a121b;
            --primary-dark: #400b11;
            --primary-light: rgba(90, 18, 27, 0.08);
            --dark: #0f172a;
            --dark-light: #1e293b;
            --gray-light: #f8fafc;
            --accent: #b89635;

            --card-bg: #ffffff;
            --card-border: rgba(0, 0, 0, 0.03);
            --card-shadow: 0 15px 30px rgba(0, 0, 0, 0.05);
            --navbar-bg: #ffffff;
            --text-main: var(--dark-light);
            --text-dark: var(--dark);
            --text-muted: #64748b;
        }

        [data-bs-theme="dark"] {
            --primary: #8b1a28;
            --primary-dark: #5a121b;
            --primary-light: rgba(139, 26, 40, 0.15);
            --dark: #ffffff;
            --dark-light: #cbd5e1;
            --gray-light: #0b0f19;
            --accent: #d9af3f;

            --card-bg: #1e293b;
            --card-border: rgba(255, 255, 255, 0.06);
            --card-shadow: 0 20px 40px rgba(0, 0, 0, 0.35);
            --navbar-bg: #111827;
            --text-main: #cbd5e1;
            --text-dark: #ffffff;
            --text-muted: #94a3b8;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--gray-light);
            color: var(--text-main);
            overflow-x: hidden;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* Navbar Styling */
        .navbar-modern {
            background: var(--navbar-bg) !important;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--card-border);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .navbar-brand-text {
            color: var(--primary) !important;
            letter-spacing: -0.5px;
        }

        [data-bs-theme="dark"] .navbar-brand-text {
            color: #ffffff !important;
        }

        [data-bs-theme="dark"] .navbar-brand-text span.fw-bold {
            color: #fca5a5 !important;
        }

        .navbar-modern .nav-link {
            color: var(--text-main) !important;
            transition: color 0.2s ease;
        }

        .navbar-modern .nav-link:hover {
            color: var(--primary) !important;
        }

        [data-bs-theme="dark"] .navbar-modern .nav-link.text-dark {
            color: var(--text-main) !important;
        }

        [data-bs-theme="dark"] .navbar-modern .nav-link.text-dark:hover {
            color: #ffffff !important;
        }

        [data-bs-theme="dark"] .navbar-modern .dropdown-toggle {
            color: #ffffff !important;
        }

        [data-bs-theme="dark"] .navbar-modern .dropdown-menu {
            background-color: #1f2937 !important;
            border-color: rgba(255, 255, 255, 0.08) !important;
            box-shadow: var(--card-shadow);
        }

        [data-bs-theme="dark"] .navbar-modern .dropdown-item {
            color: #cbd5e1 !important;
        }

        [data-bs-theme="dark"] .navbar-modern .dropdown-item:hover {
            background-color: rgba(255, 255, 255, 0.05) !important;
            color: #ffffff !important;
        }

        .btn-outline-primary {
            color: var(--primary) !important;
            border-color: var(--primary) !important;
        }

        .btn-outline-primary:hover {
            color: #ffffff !important;
            background-color: var(--primary) !important;
            border-color: var(--primary) !important;
        }

        [data-bs-theme="dark"] .btn-outline-primary {
            color: #fca5a5 !important;
            border-color: #fca5a5 !important;
        }

        [data-bs-theme="dark"] .btn-outline-primary:hover {
            color: #ffffff !important;
            background-color: var(--primary) !important;
            border-color: var(--primary) !important;
        }

        /* Theme Toggle Button */
        .theme-toggle-btn {
            background: rgba(100, 116, 139, 0.08);
            border: 1px solid rgba(100, 116, 139, 0.15);
            color: var(--text-main);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.25s ease;
        }

        .theme-toggle-btn:hover {
            background: rgba(100, 116, 139, 0.15);
            transform: scale(1.05);
            color: var(--primary);
        }

        [data-bs-theme="dark"] .theme-toggle-btn {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(255, 255, 255, 0.15);
            color: #ffffff;
        }

        [data-bs-theme="dark"] .theme-toggle-btn:hover {
            background: rgba(255, 255, 255, 0.15);
            color: var(--accent);
        }

        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, #2b0408 0%, #150204 100%);
            color: #fff;
            padding: 140px 0 100px 0;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(184, 150, 53, 0.12) 0%, transparent 70%);
            top: -100px;
            right: -100px;
        }

        .hero-section::after {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(90, 18, 27, 0.25) 0%, transparent 70%);
            bottom: -50px;
            left: -50px;
        }

        .hero-badge {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: #e2e8f0;
            padding: 8px 16px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-block;
            backdrop-filter: blur(4px);
        }

        .hero-title {
            font-size: 3.2rem;
            font-weight: 800;
            line-height: 1.2;
            letter-spacing: -1px;
        }

        .hero-title span {
            background: linear-gradient(135deg, #fcd34d 0%, #d97706 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Stats Cards */
        .stat-card-glow {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 24px;
            backdrop-filter: blur(12px);
            transition: all 0.3s ease;
        }

        .stat-card-glow:hover {
            transform: translateY(-8px);
            background: rgba(255, 255, 255, 0.05);
            border-color: rgba(255, 255, 255, 0.15);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }

        /* Section Headings */
        .section-tag {
            font-size: 0.75rem;
            font-weight: 800;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--primary);
            display: inline-block;
            margin-bottom: 12px;
        }

        [data-bs-theme="dark"] .section-tag {
            color: var(--accent);
        }

        .section-title {
            font-size: 2.25rem;
            font-weight: 800;
            color: var(--text-dark);
            letter-spacing: -0.5px;
        }

        /* Feature Card */
        .feature-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 20px;
            transition: all 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--card-shadow);
        }

        .feature-card h3,
        .feature-card h5 {
            color: var(--text-dark) !important;
        }

        .icon-box-primary {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            background: var(--primary-light);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        [data-bs-theme="dark"] .icon-box-primary {
            color: #fca5a5;
        }

        /* Job Posting Card */
        .job-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 20px;
            transition: all 0.3s ease;
        }

        .job-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--card-shadow);
            border-color: rgba(90, 18, 27, 0.25);
        }

        [data-bs-theme="dark"] .job-card:hover {
            border-color: rgba(255, 255, 255, 0.15);
        }

        .job-card h4 {
            color: var(--text-dark);
        }

        .job-card h6 {
            color: var(--text-muted);
        }

        /* Partner CTA */
        .partner-cta-section {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: #fff;
            border-radius: 32px;
            overflow: hidden;
            position: relative;
        }

        /* Buttons styling */
        .btn-modern-primary {
            background: var(--primary);
            color: #fff;
            font-weight: 600;
            padding: 12px 28px;
            border-radius: 50px;
            border: none;
            transition: all 0.2s ease;
        }

        .btn-modern-primary:hover {
            background: var(--primary-dark);
            color: #fff;
            transform: scale(1.02);
        }

        .btn-modern-outline {
            background: transparent;
            color: #fff;
            border: 2px solid rgba(255, 255, 255, 0.2);
            font-weight: 600;
            padding: 12px 28px;
            border-radius: 50px;
            transition: all 0.2s ease;
        }

        .btn-modern-outline:hover {
            border-color: #fff;
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
        }

        /* Standard text overrides to match UHN maroon branding */
        .text-primary {
            color: var(--primary) !important;
        }

        [data-bs-theme="dark"] .text-primary {
            color: #fca5a5 !important;
        }

        .text-indigo-200 {
            color: #fca5a5 !important;
        }

        .bg-primary\/20 {
            background-color: rgba(90, 18, 27, 0.2) !important;
        }

        /* UHN Custom Footer Style */
        .footer-uhn {
            background-color: #5a121b !important;
            color: rgba(255, 255, 255, 0.8) !important;
        }
        .footer-uhn h4, .footer-uhn h5 {
            color: #ffffff !important;
            font-weight: 700;
        }
        .footer-uhn a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: color 0.2s ease;
        }
        .footer-uhn a:hover {
            color: #ffffff;
        }
        .footer-uhn .text-muted-uhn {
            color: rgba(255, 255, 255, 0.6) !important;
        }
        .footer-uhn hr {
            border-color: rgba(255, 255, 255, 0.15) !important;
            opacity: 1;
        }

        /* Dark mode custom overrides for other elements */
        .text-dark {
            color: var(--text-dark) !important;
        }

        .text-muted {
            color: var(--text-muted) !important;
        }

        #modalJobDetail .modal-dialog {
            max-width: 820px;
            padding: 1rem;
        }

        #modalJobDetail .modal-content {
            max-height: min(88vh, 820px);
            border: 1px solid rgba(15, 23, 42, 0.08) !important;
            border-radius: 1.25rem !important;
            box-shadow: 0 28px 80px rgba(15, 23, 42, 0.24) !important;
        }

        #modalJobDetail .modal-header {
            position: relative;
            padding: 1.5rem 1.75rem;
            background: linear-gradient(120deg, #4a1019, #761d2b) !important;
        }

        #modalJobDetail .modal-header::after {
            position: absolute;
            right: 0;
            bottom: 0;
            left: 0;
            height: 3px;
            content: "";
            background: linear-gradient(90deg, #d6b65d, #f1dfaa, transparent);
        }

        #modalJobDetail .modal-header #detail-company-logo-container > * {
            display: flex;
            width: 54px;
            height: 54px;
            align-items: center;
            justify-content: center;
            border: 2px solid rgba(255, 255, 255, 0.55);
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.12);
            color: #fff !important;
            object-fit: contain;
        }

        #modalJobDetail .modal-title {
            line-height: 1.3;
        }

        #modalJobDetail .modal-body {
            overflow-y: auto;
            padding: 1.5rem 1.75rem;
        }

        #modalJobDetail .modal-body .row > div > div {
            height: 100%;
            border-radius: 14px !important;
            box-shadow: 0 5px 18px rgba(15, 23, 42, 0.035);
        }

        #modalJobDetail .modal-body .row > div > div > span:first-child {
            letter-spacing: 0.06em;
            color: #64748b !important;
        }

        #modalJobDetail #detail-job-description,
        #modalJobDetail #detail-job-requirements {
            white-space: pre-line;
            line-height: 1.75;
        }

        #modalJobDetail .modal-footer {
            padding: 1rem 1.75rem 1.5rem;
            background: var(--card-bg);
        }

        #modalJobDetail .modal-footer .btn {
            min-width: 130px;
            padding: 0.65rem 1.25rem;
            font-weight: 700;
        }

        @media (max-width: 575.98px) {
            #modalJobDetail .modal-dialog {
                margin: 0.5rem;
                padding: 0;
            }

            #modalJobDetail .modal-content {
                max-height: calc(100vh - 1rem);
                border-radius: 1rem !important;
            }

            #modalJobDetail .modal-header,
            #modalJobDetail .modal-body {
                padding: 1.1rem;
            }

            #modalJobDetail .modal-footer {
                padding: 0.75rem 1.1rem 1.1rem;
            }

            #modalJobDetail .modal-footer .btn {
                flex: 1 1 auto;
                min-width: 0;
            }
        }

        [data-bs-theme="dark"] .modal-content {
            background-color: #1e293b !important;
            color: #cbd5e1 !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
        }

        [data-bs-theme="dark"] #modalJobDetail .modal-header {
            background: linear-gradient(120deg, #111827, #273449) !important;
        }

        [data-bs-theme="dark"] #modalJobDetail .modal-body .row > div > div {
            box-shadow: none;
        }

        [data-bs-theme="dark"] #modalJobDetail .modal-footer {
            background: #1e293b;
        }

        [data-bs-theme="dark"] .modal-header {
            border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
        }

        [data-bs-theme="dark"] .modal-footer {
            border-top: 1px solid rgba(255, 255, 255, 0.08) !important;
        }

        [data-bs-theme="dark"] .modal-body {
            background-color: #1e293b !important;
        }

        [data-bs-theme="dark"] .modal-body .bg-light,
        [data-bs-theme="dark"] .modal-body .bg-light\/30 {
            background-color: rgba(255, 255, 255, 0.03) !important;
        }

        [data-bs-theme="dark"] .modal-body .bg-white {
            background-color: #111827 !important;
            border-color: rgba(255, 255, 255, 0.06) !important;
        }

        [data-bs-theme="dark"] .form-control {
            background-color: #111827 !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
            color: #ffffff !important;
        }

        [data-bs-theme="dark"] .form-control:focus {
            background-color: #111827 !important;
            border-color: var(--primary) !important;
            color: #ffffff !important;
            box-shadow: 0 0 0 0.25rem rgba(139, 26, 40, 0.25) !important;
        }

        [data-bs-theme="dark"] .input-group-text {
            background-color: #111827 !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
            color: #94a3b8 !important;
        }

        [data-bs-theme="dark"] .card {
            background-color: var(--card-bg) !important;
            border-color: var(--card-border) !important;
        }

        [data-bs-theme="dark"] .btn-close {
            filter: invert(1) grayscale(1) brightness(2);
        }

        [data-bs-theme="dark"] .bg-primary-light {
            background-color: rgba(139, 26, 40, 0.15) !important;
        }

        [data-bs-theme="dark"] .btn-light {
            background-color: rgba(255, 255, 255, 0.05) !important;
            border-color: rgba(255, 255, 255, 0.08) !important;
            color: #ffffff !important;
        }

        [data-bs-theme="dark"] .btn-light:hover {
            background-color: rgba(255, 255, 255, 0.1) !important;
        }

        .apply-modal .modal-dialog { max-width: 560px; margin-inline: auto; }
        .apply-modal .modal-content { border-radius: 22px !important; box-shadow: 0 28px 80px rgba(15, 23, 42, .28) !important; }
        .apply-modal-header { display: flex; align-items: center; gap: 1rem; padding: 1.4rem 1.5rem; color: #fff; background: radial-gradient(circle at 100% 0, rgba(255,255,255,.13), transparent 40%), linear-gradient(135deg, #451019, #761b2a); }
        .apply-modal-mark { display: grid; width: 48px; height: 48px; flex: 0 0 48px; place-items: center; border: 1px solid rgba(255,255,255,.2); border-radius: 15px; background: rgba(255,255,255,.12); font-size: 1.1rem; }
        .apply-modal-eyebrow { display: block; margin-bottom: .25rem; color: #f2c6cb; font-size: .67rem; font-weight: 800; letter-spacing: .13em; }
        .apply-modal-job { color: rgba(255,255,255,.72); font-size: .87rem; line-height: 1.45; overflow-wrap: anywhere; }
        .apply-modal .modal-body { padding: 1.4rem 1.5rem !important; }
        .apply-modal-note { display: flex; gap: .65rem; align-items: flex-start; margin-bottom: 1.25rem; padding: .8rem .9rem; border: 1px solid #f0e1d5; border-radius: 12px; background: #fffaf5; color: #765333; font-size: .82rem; line-height: 1.45; }
        .apply-modal-note i { margin-top: .1rem; color: #a24d3a; }
        .apply-field { margin-bottom: 1.1rem; }
        .apply-field .form-label { margin-bottom: .45rem; color: #263449; font-size: .83rem; font-weight: 700; }
        .apply-modal .form-control { min-height: 45px; border: 1px solid #dce3ed; border-radius: 11px !important; box-shadow: none; }
        .apply-modal textarea.form-control { min-height: 110px; resize: vertical; }
        .apply-modal .form-control:focus { border-color: #8b1a28; box-shadow: 0 0 0 3px rgba(139,26,40,.1); }
        .apply-modal .form-text { margin-top: .4rem; color: #8490a1; font-size: .75rem; }
        .apply-modal .apply-file-input { padding: .4rem; }
        .apply-modal .apply-file-input::file-selector-button { margin: -.4rem .7rem -.4rem -.4rem; padding: .7rem .85rem; border: 0; border-right: 1px solid #dce3ed; background: #f4f6f9; color: #344256; }
        .apply-modal-footer { gap: .65rem; border-top: 1px solid #edf0f4; }
        .apply-modal-footer .btn { min-height: 44px; padding-inline: 1.2rem; border-radius: 11px; font-weight: 700; }
        .apply-modal-footer .apply-cancel-btn { border: 1px solid #dce3ed; color: #526174; }
        .apply-modal-footer .apply-submit-btn { border: 0; background: linear-gradient(135deg, #8b1a28, #681521); box-shadow: 0 6px 15px rgba(104,21,33,.2); }
        .apply-modal-footer .apply-submit-btn:hover { background: linear-gradient(135deg, #741622, #55111b); transform: translateY(-1px); }
        @media (max-width: 575.98px) {
            .apply-modal .modal-dialog { margin: .6rem; min-height: calc(100% - 1.2rem); }
            .apply-modal .modal-content { border-radius: 18px !important; }
            .apply-modal-header { gap: .75rem; padding: 1.1rem; }
            .apply-modal-mark { width: 42px; height: 42px; flex-basis: 42px; border-radius: 13px; }
            .apply-modal .modal-body { padding: 1.1rem !important; }
            .apply-modal-footer { display: grid; grid-template-columns: 1fr 1.5fr; padding: .85rem 1.1rem !important; }
            .apply-modal-footer .btn { padding-inline: .6rem; }
        }
    </style>
</head>
<body>

    <!-- Header Navigation -->
    <nav class="py-3 navbar navbar-expand-lg navbar-modern fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="{{ asset('assets/media/favicons/logo_harkatnegeri.png') }}" alt="Logo" class="me-2" style="width: 38px; height: 38px; object-fit: contain;">
                <span class="navbar-brand-text fs-4"><span class="fw-normal">Tracer</span> <span class="fw-bold">Study TI UHN</span></span>
            </a>
            <button class="border-0 shadow-none navbar-expand-lg navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="gap-2 mt-3 navbar-nav ms-auto align-items-center mt-lg-0">
                    <li class="nav-item">
                        <a class="px-3 nav-link fw-semibold text-dark" href="#statistik">Statistik</a>
                    </li>
                    <li class="nav-item">
                        <a class="px-3 nav-link fw-semibold text-dark" href="#mitra">Untuk Mitra</a>
                    </li>
                    <li class="nav-item">
                        <a class="px-3 nav-link fw-semibold text-dark" href="#loker">Lowongan Kerja</a>
                    </li>
                    @auth
                        <li class="nav-item dropdown ms-lg-2">
                            <a class="gap-2 nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="{{ Auth::user()->avatar ? asset('storage/avatars/' . Auth::user()->avatar) : asset('assets/media/avatars/avatar10.jpg') }}" alt="Avatar" class="border rounded-circle border-secondary" style="width: 38px; height: 38px; object-fit: cover;">
                                <span class="fw-semibold text-dark">{{ Auth::user()->username }}</span>
                            </a>
                            <ul class="mt-2 border-0 shadow dropdown-menu dropdown-menu-end rounded-3">
                                <li>
                                    <a class="py-2 dropdown-item" href="{{ route('dashboard') }}">
                                        <i class="fa fa-gauge me-2 text-primary"></i> Dashboard Alumni
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" class="mb-0">
                                        @csrf
                                        <button type="submit" class="py-2 bg-transparent border-0 dropdown-item text-danger w-100 text-start">
                                            <i class="fa fa-right-from-bracket me-2"></i> Keluar
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item ms-lg-2">
                            <a href="{{ route('login') }}" class="px-4 btn btn-outline-primary rounded-pill fw-bold">Masuk</a>
                        </li>
                    @endauth

                    <!-- Theme Toggle Button -->
                    <li class="mt-2 nav-item ms-lg-2 mt-lg-0">
                        <button id="theme-toggle" class="theme-toggle-btn" aria-label="Ubah Tema">
                            <i id="theme-icon" class="fa fa-moon"></i>
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6 z-1">
                    <div class="mb-3 hero-badge">
                        <i class="fa fa-circle-nodes text-accent me-1 animate-pulse"></i> Integrasi Tracer Study & Bursa Kerja
                    </div>
                    <h1 class="mb-4 hero-title">Membangun Jembatan Karir <span>Masa Depan</span></h1>
                    <p class="mb-5 text-white/80 fs-5 fw-medium" style="line-height: 1.6;">
                        Portal Tracer Study Program Studi Teknik Informatika Universitas Harkat Negeri. Kami menghubungkan keselarasan kurikulum akademik dengan kebutuhan nyata industry kerja.
                    </p>
                    <div class="flex-wrap gap-3 d-flex">
                        @auth
                            <a href="{{ route('dashboard') }}" class="px-4 py-3 shadow-lg btn btn-modern-primary"><i class="fa fa-gauge me-2"></i> Ke Dashboard Alumni</a>
                        @else
                            <a href="{{ route('login') }}" class="px-4 py-3 shadow-lg btn btn-modern-primary"><i class="fa fa-right-to-bracket me-2"></i> Masuk Sebagai Alumni</a>
                        @endauth
                    </div>
                </div>

                <!-- Hero Visual Statistics Grid -->
                <div class="col-lg-6 z-1">
                    <div class="row g-4">
                        <div class="col-sm-6">
                            <div class="p-4 text-center stat-card-glow">
                                <div class="mx-auto mb-3 text-indigo-200 bg-primary/20 rounded-circle d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                                    <i class="text-white fa fa-users fs-4"></i>
                                </div>
                                <h2 class="mb-1 text-white fw-extrabold">{{ $totalAlumni }}</h2>
                                <p class="mb-0 text-white/60 small fw-semibold text-uppercase letter-spacing-1">Total Alumni</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="p-4 text-center stat-card-glow">
                                <div class="mx-auto mb-3 bg-success/20 text-success rounded-circle d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                                    <i class="text-white fa fa-check-circle fs-4"></i>
                                </div>
                                <h2 class="mb-1 text-white fw-extrabold">{{ $totalTracer }}</h2>
                                <p class="mb-0 text-white/60 small fw-semibold text-uppercase letter-spacing-1">Alumni Terlacak</p>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="gap-4 p-4 text-center stat-card-glow d-flex flex-column flex-md-row align-items-center justify-content-center">
                                <div class="position-relative d-inline-flex">
                                    <!-- Simple CSS Progress Circle -->
                                    <div class="text-white d-flex align-items-center justify-content-center bg-white/10 rounded-circle fw-bold" style="width: 80px; height: 80px; font-size: 1.1rem; border: 4px solid var(--accent);">
                                        {{ $workingPercentage }}%
                                    </div>
                                </div>
                                <div class="text-center text-md-start">
                                    <h4 class="mb-1 text-white fw-bold">Tingkat Keterserapan Industri</h4>
                                    <p class="mb-0 text-white/70 small fw-medium">Alumni Teknik Informatika yang telah berhasil bekerja atau berwirausaha secara profesional.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Info Metrics Section -->
    <section class="py-5" id="statistik">
        <div class="container py-5">
            <div class="max-w-2xl mx-auto mb-5 text-center">
                <span class="section-tag">Statistik Karir</span>
                <h2 class="section-title">Hasil Penelusuran Alumni</h2>
                <p class="mt-2 text-muted fw-medium">Gambaran sebaran profesional karir alumni Teknik Informatika Universitas Harkat Negeri.</p>
            </div>

            <div class="row g-4 justify-content-center">
                <!-- Card Bekerja -->
                <div class="col-md-4 col-sm-6">
                    <div class="p-4 text-center feature-card h-100">
                        <div class="mx-auto mb-3 icon-box-primary" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
                            <i class="fa fa-briefcase"></i>
                        </div>
                        <h3 class="mb-1 fw-bold text-dark">{{ $employed }}</h3>
                        <h5 class="mb-2 fw-semibold text-muted">Bekerja Profesional</h5>
                        <p class="mb-0 text-muted small">Alumni yang bekerja sebagai staf IT, engineer, manager, atau profesional di perusahaan nasional & global.</p>
                    </div>
                </div>
                <!-- Card Wirausaha -->
                <div class="col-md-4 col-sm-6">
                    <div class="p-4 text-center feature-card h-100">
                        <div class="mx-auto mb-3 icon-box-primary" style="background: rgba(6, 182, 212, 0.1); color: #06b6d4;">
                            <i class="fa fa-lightbulb"></i>
                        </div>
                        <h3 class="mb-1 fw-bold text-dark">{{ $entrepreneur }}</h3>
                        <h5 class="mb-2 fw-semibold text-muted">Wirausaha / Startup</h5>
                        <p class="mb-0 text-muted small">Alumni yang mendirikan unit usaha sendiri, konsultan IT, startup teknologi, atau agensi kreatif digital.</p>
                    </div>
                </div>
                <!-- Card Lanjut Studi -->
                <div class="col-md-4 col-sm-6">
                    <div class="p-4 text-center feature-card h-100">
                        <div class="mx-auto mb-3 icon-box-primary">
                            <i class="fa fa-book-open"></i>
                        </div>
                        <h3 class="mb-1 fw-bold text-dark">{{ $continuing }}</h3>
                        <h5 class="mb-2 fw-semibold text-muted">Melanjutkan Pendidikan</h5>
                        <p class="mb-0 text-muted small">Alumni yang menempuh pendidikan Master (S2) baik di dalam negeri maupun universitas luar negeri.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Recent Jobs Board -->
    <section class="py-5" id="loker">
        <div class="container py-4">
            <div class="pb-4 mb-5 d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center border-bottom">
                <div>
                    <span class="section-tag">Bursa Karir</span>
                    <h2 class="section-title">Lowongan Kerja Terbaru</h2>
                    <p class="mb-0 text-muted fw-medium">Raih kesempatan berkarir di berbagai perusahaan mitra terbaik kami.</p>
                </div>
                @auth
                    @if(auth()->user()->role === 'alumni')
                        <a href="{{ route('alumni.loker.index') }}" class="px-4 mt-3 btn btn-outline-primary rounded-pill mt-md-0 fw-bold">Riwayat Lamaran Saya <i class="fa fa-arrow-right ms-1"></i></a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="px-4 mt-3 btn btn-outline-primary rounded-pill mt-md-0 fw-bold">Masuk untuk Melamar <i class="fa fa-arrow-right ms-1"></i></a>
                @endauth
            </div>

            <div class="row g-4">
                @forelse($recentJobs as $job)
                    <div class="col-lg-4 col-md-6">
                        <div class="p-4 job-card d-flex flex-column justify-content-between h-100">
                            <div>
                                <div class="mb-3 d-flex align-items-center justify-content-between">
                                    <span class="badge bg-primary-light text-primary rounded-pill px-2.5 py-1.5 fs-xs fw-bold">{{ $job->category }}</span>
                                    <small class="text-muted"><i class="fa fa-calendar-alt me-1"></i> {{ $job->created_at->diffForHumans() }}</small>
                                </div>
                                <h4 class="mb-1 fw-bold text-dark">{{ $job->position }}</h4>
                                <h6 class="mb-3 text-muted fw-semibold"><i class="fa fa-building me-1"></i> {{ $job->company_name }}</h6>

                                <div class="flex-wrap gap-3 mb-4 d-flex text-muted small">
                                    <span><i class="fa fa-map-marker-alt text-danger me-1"></i> {{ $job->location }}</span>
                                    @if($job->salary_range)
                                        <span><i class="fa fa-money-bill-wave text-success me-1"></i> {{ $job->salary_range }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="gap-2 d-flex">
                                <button class="px-3 btn btn-outline-secondary btn-sm rounded-pill fw-semibold btn-detail-landing" data-id="{{ $job->id }}">
                                    <i class="fa fa-eye me-1"></i> Detail
                                </button>
                                @auth
                                    @if(in_array($job->id, $appliedJobIds ?? []))
                                        <button class="py-2 border btn btn-light btn-sm rounded-pill flex-grow-1 fw-bold text-success" disabled>
                                            <i class="fa fa-check-circle me-1"></i> Sudah Dilamar
                                        </button>
                                    @else
                                        <button class="py-2 btn btn-primary btn-sm rounded-pill flex-grow-1 fw-bold btn-apply-landing"
                                            data-id="{{ $job->id }}"
                                            data-position="{{ $job->position }}"
                                            data-company="{{ $job->company_name }}">
                                            <i class="fa fa-paper-plane me-1"></i> Lamar
                                        </button>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" class="py-2 text-center border btn btn-light btn-sm rounded-pill flex-grow-1 fw-bold text-primary">Lamar</a>
                                @endauth
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="py-5 text-center col-12">
                        <div class="text-muted">
                            <i class="mb-3 fa fa-briefcase fs-1"></i>
                            <p class="mb-0 fw-semibold">Belum ada lowongan pekerjaan aktif saat ini.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    @auth
    <!-- Apply Job Modal -->
    <div class="modal fade apply-modal" id="modalApplyJob" tabindex="-1" aria-labelledby="apply-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="overflow-hidden border-0 shadow-lg modal-content rounded-4">
                <div class="apply-modal-header">
                    <div class="apply-modal-mark"><i class="fa fa-paper-plane"></i></div>
                    <div class="min-w-0 flex-grow-1">
                        <span class="apply-modal-eyebrow">LAMARAN KERJA</span>
                        <h5 class="mb-1 text-white modal-title fw-bold" id="apply-modal-title">Kirim Lamaran</h5>
                        <p class="mb-0 apply-modal-job" id="apply-job-info">-</p>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="p-4 modal-body text-start">
                    <input type="hidden" id="apply-job-id">
                    <div class="apply-modal-note"><i class="fa fa-shield-alt"></i><span>Pastikan informasi kontak dan CV Anda sudah benar sebelum mengirim.</span></div>

                    <div class="apply-field">
                        <label for="apply-phone" class="form-label">Nomor WhatsApp / Telepon <span class="text-danger">*</span></label>
                        <input type="text" id="apply-phone" class="form-control" placeholder="Contoh: 081234567890" required value="{{ Auth::check() && Auth::user()->alumni ? Auth::user()->alumni->no_hp : '' }}">
                        <div class="form-text">Nomor aktif yang dapat dihubungi perusahaan.</div>
                    </div>
                    <div class="apply-field">
                        <label for="apply-expected-salary" class="form-label">Gaji yang Diharapkan <span class="text-muted fw-normal">(Opsional)</span></label>
                        <input type="text" id="apply-expected-salary" class="form-control" placeholder="Contoh: Rp 5.000.000">
                        <div class="form-text">Masukkan perkiraan atau rentang gaji yang Anda harapkan.</div>
                    </div>
                    <div class="apply-field">
                        <label for="apply-cv" class="form-label">CV / Resume <span class="text-danger">*</span></label>
                        <input type="file" id="apply-cv" class="form-control apply-file-input" accept=".pdf,.doc,.docx" required>
                        <div class="form-text">PDF, DOC, atau DOCX · Maksimal 2 MB.</div>
                    </div>
                    <div class="mb-0 apply-field">
                        <label for="apply-cover-letter" class="form-label">Pesan Pengantar <span class="text-muted fw-normal">(Opsional)</span></label>
                        <textarea id="apply-cover-letter" class="form-control" rows="4" maxlength="1000" placeholder="Ceritakan secara singkat alasan Anda tertarik dengan posisi ini..."></textarea>
                        <div class="form-text d-flex justify-content-between"><span>Tambahkan pesan untuk perekrut.</span><span>Maks. 1000 karakter</span></div>
                    </div>
                </div>
                <div class="px-4 py-3 modal-footer apply-modal-footer">
                    <button type="button" class="btn btn-light apply-cancel-btn" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary apply-submit-btn" id="btn-submit-apply"><i class="fa fa-paper-plane me-2"></i>Kirim Lamaran</button>
                </div>
            </div>
        </div>
    </div>
    @endauth

    @auth
    {{-- Modal: Gate Tracer Study (Opsi C - Soft Gate) --}}
    {{-- Tampil ketika alumni yang belum isi kuesioner klik tombol Lamar --}}
    <div class="modal fade" id="modalTracerGate" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="overflow-hidden border-0 shadow-xl modal-content rounded-4">
                <div class="p-0 border-0 modal-header">
                    <div class="p-4 text-center w-100" style="background: linear-gradient(135deg, #5a121b 0%, #8b1a28 100%);">
                        <div class="mb-3 d-flex align-items-center justify-content-center" style="width: 72px; height: 72px; background: rgba(255,255,255,0.15); border-radius: 50%; margin: 0 auto;">
                            <i class="text-white fa fa-clipboard-list" style="font-size: 2rem;"></i>
                        </div>
                        <h5 class="mb-1 text-white fw-extrabold">Satu Langkah Lagi!</h5>
                        <p class="mb-0 text-white-50 fs-sm">Lengkapi profil Tracer Study Anda</p>
                    </div>
                </div>
                <div class="p-4 text-center modal-body">
                    <p class="mb-2 fw-semibold text-dark">Untuk dapat melamar lowongan kerja,</p>
                    <p class="mb-4 text-muted">
                        Anda perlu mengisi <strong>Kuesioner Tracer Study</strong> terlebih dahulu.<br>
                        Hanya membutuhkan <strong>±5 menit</strong> dan membantu kampus
                        meningkatkan kualitas pendidikan untuk adik angkatan Anda.
                    </p>
                    <div class="gap-3 p-3 mb-4 d-flex align-items-center rounded-3 text-start" style="background: rgba(90, 18, 27, 0.06); border: 1px solid rgba(90, 18, 27, 0.12);">
                        <i class="flex-shrink-0 fa fa-circle-check text-success fs-4"></i>
                        <div>
                            <div class="fw-bold text-dark small">Setelah mengisi, Anda bisa:</div>
                            <div class="text-muted small">Melamar semua lowongan yang tersedia di platform ini</div>
                        </div>
                    </div>
                </div>
                <div class="gap-2 px-4 pt-0 pb-4 border-0 modal-footer d-flex">
                    <button type="button" class="px-4 btn btn-outline-secondary rounded-pill flex-fill" data-bs-dismiss="modal">
                        Nanti Saja
                    </button>
                    <a href="{{ route('new-tracer.index') }}" class="px-4 btn btn-primary rounded-pill fw-bold flex-fill" style="background: #5a121b; border-color: #5a121b;">
                        <i class="fa fa-pencil-alt me-1"></i> Isi Sekarang
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endauth

    <!-- Job Detail Modal (Landing) -->
    <div class="modal fade" id="modalJobDetail" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="overflow-hidden border-0 shadow-lg modal-content rounded-4">
                <div class="p-4 text-white border-0 modal-header bg-dark">
                    <div class="gap-3 d-flex align-items-center">
                        <div id="detail-company-logo-container"></div>
                        <div>
                            <h5 class="mb-1 text-white modal-title fw-bold" id="detail-job-position">-</h5>
                            <p class="mb-0 text-white-50 fs-sm" id="detail-company-name">-</p>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="p-4 modal-body bg-light/30">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="p-3 bg-white border shadow-xs border-light rounded-3">
                                <span class="mb-1 text-muted text-uppercase fw-bold d-block" style="font-size: 0.65rem;">Kategori Bidang</span>
                                <span class="fw-bold text-dark" id="detail-job-category">-</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 bg-white border shadow-xs border-light rounded-3">
                                <span class="mb-1 text-muted text-uppercase fw-bold d-block" style="font-size: 0.65rem;">Lokasi</span>
                                <span class="fw-bold text-dark" id="detail-job-location">-</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 bg-white border shadow-xs border-light rounded-3">
                                <span class="mb-1 text-muted text-uppercase fw-bold d-block" style="font-size: 0.65rem;">Gaji</span>
                                <span class="fw-bold text-dark" id="detail-job-salary">-</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 bg-white border shadow-xs border-light rounded-3">
                                <span class="mb-1 text-muted text-uppercase fw-bold d-block" style="font-size: 0.65rem;">Email Pendaftaran</span>
                                <span class="fw-bold text-dark" id="detail-job-contact-email">-</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 bg-white border shadow-xs border-light rounded-3">
                                <span class="mb-1 text-muted text-uppercase fw-bold d-block" style="font-size: 0.65rem;">Link Pendaftaran</span>
                                <span class="fw-bold text-dark" id="detail-job-contact-link">-</span>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="p-3 bg-white border shadow-xs border-light rounded-3">
                                <span class="mb-2 text-muted text-uppercase fw-bold d-block" style="font-size: 0.65rem;">Deskripsi Pekerjaan</span>
                                <div class="text-dark fs-sm" id="detail-job-description" style="white-space: pre-line; line-height: 1.6;">-</div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="p-3 bg-white border shadow-xs border-light rounded-3">
                                <span class="mb-2 text-muted text-uppercase fw-bold d-block" style="font-size: 0.65rem;">Kualifikasi / Persyaratan</span>
                                <div class="text-dark fs-sm" id="detail-job-requirements" style="white-space: pre-line; line-height: 1.6;">-</div>
                            </div>
                        </div>

                        <!-- Poster display -->
                        <div class="col-12" id="detail-poster-container" style="display: none;">
                            <div class="p-3 text-center bg-white border shadow-xs border-light rounded-3">
                                <span class="mb-2 text-muted text-uppercase fw-bold d-block text-start" style="font-size: 0.65rem;">Poster / Brosur Lowongan</span>

                                <div id="carouselLandingPosters" class="carousel slide carousel-dark" data-bs-ride="carousel">
                                    <div class="carousel-indicators" id="carousel-landing-indicators">
                                        <!-- Indicators populated by JS -->
                                    </div>
                                    <div class="shadow-sm carousel-inner rounded-3 bg-light" id="carousel-landing-inner" style="max-height: 480px;">
                                        <!-- Slides populated by JS -->
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselLandingPosters" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#carouselLandingPosters" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-3 border-0 modal-footer bg-light/50">
                    <button type="button" class="px-4 btn btn-secondary rounded-pill" data-bs-dismiss="modal">Tutup</button>
                    <div id="detail-action-container">
                        <!-- Action button populated dynamically by JS -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Theme toggle logic
        var themeToggleBtn = document.getElementById('theme-toggle');
        var themeIcon = document.getElementById('theme-icon');

        function updateToggleIcon(theme) {
            if (theme === 'dark') {
                themeIcon.className = 'fa fa-sun text-warning';
            } else {
                themeIcon.className = 'fa fa-moon';
            }
        }

        // Initialize icon state
        var currentTheme = document.documentElement.getAttribute('data-bs-theme') || 'light';
        updateToggleIcon(currentTheme);

        if (themeToggleBtn) {
            themeToggleBtn.addEventListener('click', function() {
                var newTheme = document.documentElement.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark';
                document.documentElement.setAttribute('data-bs-theme', newTheme);
                localStorage.setItem('theme', newTheme);
                updateToggleIcon(newTheme);
            });
        }

        var isAuthenticated = @json(Auth::check());
        var hasFilledTracer = @json($hasFilledTracer ?? false);

        // Helper: tampilkan tracer gate modal
        function showTracerGate() {
            var gateModal = new bootstrap.Modal(document.getElementById('modalTracerGate'));
            gateModal.show();
        }

        // Helper: buka modal apply (dipanggil setelah gate lolos)
        function openApplyModal(id, position, company) {
            document.getElementById('apply-job-id').value = id;
            document.getElementById('apply-job-info').textContent = position + ' — ' + company;
            document.getElementById('apply-cover-letter').value = '';
            document.getElementById('apply-expected-salary').value = '';
            document.getElementById('apply-cv').value = '';
            var modal = new bootstrap.Modal(document.getElementById('modalApplyJob'));
            modal.show();
        }

        // Open apply modal from card — dengan gate tracer study
        document.querySelectorAll('.btn-apply-landing').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var id = this.dataset.id;
                var position = this.dataset.position;
                var company = this.dataset.company;

                if (!hasFilledTracer) {
                    showTracerGate();
                    return;
                }

                openApplyModal(id, position, company);
            });
        });

        // Open detail modal
        document.querySelectorAll('.btn-detail-landing').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var jobId = this.dataset.id;

                fetch('/alumni/loker/' + jobId)
                    .then(function(res) { return res.json(); })
                    .then(function(job) {
                        document.getElementById('detail-job-position').textContent = job.position;
                        document.getElementById('detail-company-name').textContent = job.company_name;
                        document.getElementById('detail-job-category').textContent = job.category;
                        document.getElementById('detail-job-location').textContent = job.location ? job.location : '-';
                        document.getElementById('detail-job-salary').textContent = job.salary_range ? job.salary_range : '-';
                        document.getElementById('detail-job-description').textContent = job.description ? job.description : '-';
                        document.getElementById('detail-job-requirements').textContent = job.requirements ? job.requirements : '-';
                        document.getElementById('detail-job-contact-email').textContent = job.contact_email ? job.contact_email : '-';
                        var contactLink = document.getElementById('detail-job-contact-link');
                        if (job.contact_link) {
                            contactLink.innerHTML = '<a href="' + job.contact_link + '" target="_blank" class="text-primary fw-bold"><i class="fa fa-external-link-alt me-1"></i> Buka Link</a>';
                        } else {
                            contactLink.textContent = '-';
                        }

                        // Logo
                        var logoContainer = document.getElementById('detail-company-logo-container');
                        if (job.logo_path) {
                            logoContainer.innerHTML = '<img src="' + job.logo_path + '" alt="Logo" class="shadow-xs rounded-3" style="width: 48px; height: 48px; object-fit: cover;">';
                        } else {
                            logoContainer.innerHTML = '<div class="bg-primary-light text-primary rounded-3 fw-bold d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; font-size: 1.1rem;">' + job.company_name.substring(0, 2).toUpperCase() + '</div>';
                        }

                        // Posters
                        var posterContainer = document.getElementById('detail-poster-container');
                        var indicators = document.getElementById('carousel-landing-indicators');
                        var inner = document.getElementById('carousel-landing-inner');

                        indicators.innerHTML = '';
                        inner.innerHTML = '';

                        var posters = job.poster_paths;
                        if (posters && Array.isArray(posters) && posters.length > 0) {
                            posters.forEach(function(path, index) {
                                var activeClass = index === 0 ? 'active' : '';
                                var ariaCurrent = index === 0 ? 'aria-current="true"' : '';

                                indicators.innerHTML += '<button type="button" data-bs-target="#carouselLandingPosters" data-bs-slide-to="' + index + '" class="' + activeClass + '" ' + ariaCurrent + ' aria-label="Slide ' + (index + 1) + '"></button>';

                                inner.innerHTML +=
                                    '<div class="carousel-item ' + activeClass + '">' +
                                        '<img src="' + path + '" class="shadow-sm d-block w-100 rounded-3" style="max-height: 450px; object-fit: contain;" alt="Poster Lowongan">' +
                                    '</div>';
                            });

                            var prevControl = document.querySelector('#carouselLandingPosters .carousel-control-prev');
                            var nextControl = document.querySelector('#carouselLandingPosters .carousel-control-next');

                            if (posters.length <= 1) {
                                indicators.style.display = 'none';
                                if (prevControl) prevControl.style.display = 'none';
                                if (nextControl) nextControl.style.display = 'none';
                            } else {
                                indicators.style.display = 'flex';
                                if (prevControl) prevControl.style.display = 'block';
                                if (nextControl) nextControl.style.display = 'block';
                            }

                            posterContainer.style.display = 'block';

                            var carouselEl = document.getElementById('carouselLandingPosters');
                            var carousel = bootstrap.Carousel.getOrCreateInstance(carouselEl);
                            carousel.to(0);
                        } else {
                            posterContainer.style.display = 'none';
                        }

                        // Action Button in detail modal
                        var actionContainer = document.getElementById('detail-action-container');
                        if (!isAuthenticated) {
                            actionContainer.innerHTML = '<a href="/login" class="px-4 btn btn-primary rounded-pill fw-bold">Masuk untuk Melamar <i class="fa fa-arrow-right ms-1"></i></a>';
                        } else if (job.already_applied) {
                            actionContainer.innerHTML = '<button class="px-4 border btn btn-light rounded-pill fw-bold text-success" disabled><i class="fa fa-check-circle me-1"></i> Sudah Dilamar</button>';
                        } else {
                            actionContainer.innerHTML = '<button class="px-4 btn btn-primary rounded-pill fw-bold btn-apply-from-detail" data-id="' + job.id + '" data-position="' + job.position + '" data-company="' + job.company_name + '"><i class="fa fa-paper-plane me-1"></i> Lamar Sekarang</button>';

                            // Bind click event for the dynamically generated button
                            actionContainer.querySelector('.btn-apply-from-detail').addEventListener('click', function() {
                                var id = this.dataset.id;
                                var position = this.dataset.position;
                                var company = this.dataset.company;

                                // Close detail modal first
                                var detailModalEl = document.getElementById('modalJobDetail');
                                var detailModalInstance = bootstrap.Modal.getInstance(detailModalEl);
                                if (detailModalInstance) {
                                    detailModalInstance.hide();
                                }

                                // ✅ Opsi C: Cek apakah sudah isi tracer study
                                if (!hasFilledTracer) {
                                    setTimeout(function() {
                                        showTracerGate();
                                    }, 400);
                                    return;
                                }

                                setTimeout(function() {
                                    openApplyModal(id, position, company);
                                }, 400);
                            });
                        }

                        var detailModal = new bootstrap.Modal(document.getElementById('modalJobDetail'));
                        detailModal.show();
                    })
                    .catch(function(err) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Gagal memuat detail lowongan kerja.',
                            confirmButtonColor: '#3085d6'
                        });
                    });
            });
        });

        // Submit application
        @auth
        document.getElementById('btn-submit-apply').addEventListener('click', function() {
            var btn = this;
            var jobId = document.getElementById('apply-job-id').value;
            var coverLetter = document.getElementById('apply-cover-letter').value;
            var phone = document.getElementById('apply-phone').value.trim();
            var expectedSalary = document.getElementById('apply-expected-salary').value.trim();
            var cvInput = document.getElementById('apply-cv');

            if (!phone) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Nomor WhatsApp / Telepon wajib diisi.',
                    confirmButtonColor: '#3085d6'
                });
                return;
            }

            if (cvInput.files.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Silakan unggah berkas CV / Resume Anda.',
                    confirmButtonColor: '#3085d6'
                });
                return;
            }

            var cvFile = cvInput.files[0];
            if (cvFile.size > 2 * 1024 * 1024) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Ukuran file CV melebihi batas 2MB.',
                    confirmButtonColor: '#3085d6'
                });
                return;
            }

            var formData = new FormData();
            formData.append('cover_letter', coverLetter);
            formData.append('phone', phone);
            formData.append('expected_salary', expectedSalary);
            formData.append('cv', cvFile);

            btn.disabled = true;
            btn.innerHTML = '<i class="fa fa-spinner fa-spin me-1"></i> Mengirim...';

            fetch('/alumni/loker/' + jobId + '/apply', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: formData
            })
            .then(function(res) { return res.json(); })
            .then(function(data) {
                btn.disabled = false;
                btn.innerHTML = '<i class="fa fa-paper-plane me-1"></i> Kirim Lamaran';

                var modalEl = document.getElementById('modalApplyJob');
                var applyModalInstance = bootstrap.Modal.getInstance(modalEl);
                if (applyModalInstance) {
                    applyModalInstance.hide();
                }

                if (data.success) {
                    // Update button to "Sudah Dilamar" on the card
                    var applyBtn = document.querySelector('.btn-apply-landing[data-id="' + jobId + '"]');
                    if (applyBtn) {
                        applyBtn.outerHTML = '<button class="py-2 border btn btn-light btn-sm rounded-pill flex-grow-1 fw-bold text-success" disabled><i class="fa fa-check-circle me-1"></i> Sudah Dilamar</button>';
                    }

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: data.message,
                        showConfirmButton: false,
                        timer: 3500,
                        timerProgressBar: true,
                        customClass: {
                            popup: 'rounded-4'
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: data.message || 'Gagal mengirim lamaran.',
                        confirmButtonColor: '#3085d6'
                    });
                }
            })
            .catch(function() {
                btn.disabled = false;
                btn.innerHTML = '<i class="fa fa-paper-plane me-1"></i> Kirim Lamaran';
                Swal.fire({
                    icon: 'error',
                    title: 'Kesalahan Sistem',
                    text: 'Terjadi kesalahan jaringan atau server. Silakan coba lagi.',
                    confirmButtonColor: '#3085d6'
                });
            });
        });
        @endauth
    });
    </script>

    <!-- Footer -->
    <footer class="py-5 mt-5 footer-uhn">
        <div class="container">
            <div class="row g-4 justify-content-between">
                <div class="col-lg-5">
                    <img src="{{ asset('assets/media/favicons/logo-uhn-new.svg') }}" alt="Universitas Harkat Negeri" class="mb-3" style="height: 55px; max-width: 100%; object-fit: contain;">
                    <p class="text-muted-uhn small" style="line-height: 1.6;">
                        Sistem Informasi Penelusuran Alumni dan Evaluasi Kurikulum Terpadu (Tracer Study TI UHN). Melayani pendataan alumni, monitoring relevansi kurikulum, dan jembatan bursa kerja industri.
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <h5 class="mb-3">Hubungi Kami</h5>
                    <p class="mb-1 text-muted-uhn small"><i class="fa fa-envelope me-2"></i> info@harkatnegeri.ac.id</p>
                    <p class="text-muted-uhn small"><i class="fa fa-map-marker-alt me-2"></i> Kampus Terpadu Univ Harkat Negeri</p>
                </div>
            </div>
            <hr class="my-4">
            <div class="row align-items-center justify-content-between">
                <div class="text-center col-md-6 text-md-start">
                    <p class="mb-0 small text-muted-uhn">&copy; 2026 Universitas Harkat Negeri. Hak Cipta Dilindungi.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
