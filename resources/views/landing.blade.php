<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Tracer Study & Bursa Kerja - Universitas Harkat Negeri</title>
    
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
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--gray-light);
            color: var(--dark-light);
            overflow-x: hidden;
        }

        /* Navbar Styling */
        .navbar-modern {
            background: #ffffff !important;
            backdrop-filter: none;
            border-bottom: 1px solid rgba(0, 0, 0, 0.08);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .navbar-brand-text {
            color: var(--primary) !important;
            letter-spacing: -0.5px;
        }

        .navbar-modern .nav-link {
            color: var(--dark-light) !important;
            transition: color 0.2s ease;
        }

        .navbar-modern .nav-link:hover {
            color: var(--primary) !important;
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

        .section-title {
            font-size: 2.25rem;
            font-weight: 800;
            color: var(--dark);
            letter-spacing: -0.5px;
        }

        /* Feature Card */
        .feature-card {
            background: #fff;
            border: 1px solid rgba(0, 0, 0, 0.03);
            border-radius: 20px;
            transition: all 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.05);
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

        /* Job Posting Card */
        .job-card {
            background: #fff;
            border: 1px solid rgba(0, 0, 0, 0.04);
            border-radius: 20px;
            transition: all 0.3s ease;
        }

        .job-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.04);
            border-color: rgba(79, 70, 229, 0.15);
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
    </style>
</head>
<body>

    <!-- Header Navigation -->
    <nav class="navbar navbar-expand-lg navbar-modern fixed-top py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="{{ asset('assets/media/favicons/logo_harkatnegeri.png') }}" alt="Logo" class="me-2" style="width: 38px; height: 38px; object-fit: contain;">
                <span class="navbar-brand-text fs-4"><span class="fw-normal">Tracer</span> <span class="fw-bold">Study TI UHN</span></span>
            </a>
            <button class="navbar-expand-lg navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ms-auto align-items-center gap-2 mt-3 mt-lg-0">
                    <li class="nav-item">
                        <a class="nav-link fw-semibold text-dark px-3" href="#statistik">Statistik</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold text-dark px-3" href="#mitra">Untuk Mitra</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold text-dark px-3" href="#loker">Lowongan Kerja</a>
                    </li>
                    @auth
                        <li class="nav-item dropdown ms-lg-2">
                            <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="{{ Auth::user()->avatar ? asset('storage/avatars/' . Auth::user()->avatar) : asset('assets/media/avatars/avatar10.jpg') }}" alt="Avatar" class="rounded-circle border border-secondary" style="width: 38px; height: 38px; object-fit: cover;">
                                <span class="fw-semibold text-dark">{{ Auth::user()->username }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 mt-2">
                                <li>
                                    <a class="dropdown-item py-2" href="{{ route('dashboard') }}">
                                        <i class="fa fa-gauge me-2 text-primary"></i> Dashboard Alumni
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" class="mb-0">
                                        @csrf
                                        <button type="submit" class="dropdown-item py-2 text-danger border-0 bg-transparent w-100 text-start">
                                            <i class="fa fa-right-from-bracket me-2"></i> Keluar
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item ms-lg-2">
                            <a href="{{ route('login') }}" class="btn btn-outline-primary rounded-pill px-4 fw-bold">Masuk</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6 z-1">
                    <div class="hero-badge mb-3">
                        <i class="fa fa-circle-nodes text-accent me-1 animate-pulse"></i> Integrasi Tracer Study & Bursa Kerja
                    </div>
                    <h1 class="hero-title mb-4">Membangun Jembatan Karir <span>Masa Depan</span></h1>
                    <p class="text-white/80 fs-5 mb-5 fw-medium" style="line-height: 1.6;">
                        Portal Tracer Study Program Studi Teknik Informatika Universitas Harkat Negeri. Kami menghubungkan keselarasan kurikulum akademik dengan kebutuhan nyata industry kerja.
                    </p>
                    <div class="d-flex flex-wrap gap-3">
                        @auth
                            <a href="{{ route('dashboard') }}" class="btn btn-modern-primary shadow-lg px-4 py-3"><i class="fa fa-gauge me-2"></i> Ke Dashboard Alumni</a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-modern-primary shadow-lg px-4 py-3"><i class="fa fa-right-to-bracket me-2"></i> Masuk Sebagai Alumni</a>
                        @endauth
                        <a href="{{ route('mitra.loker.create') }}" class="btn btn-modern-outline px-4 py-3"><i class="fa fa-briefcase me-2"></i> Unggah Loker Mitra</a>
                    </div>
                </div>
                
                <!-- Hero Visual Statistics Grid -->
                <div class="col-lg-6 z-1">
                    <div class="row g-4">
                        <div class="col-sm-6">
                            <div class="stat-card-glow p-4 text-center">
                                <div class="bg-primary/20 text-indigo-200 rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 56px; height: 56px;">
                                    <i class="fa fa-users fs-4 text-white"></i>
                                </div>
                                <h2 class="fw-extrabold text-white mb-1">{{ $totalAlumni }}</h2>
                                <p class="text-white/60 small mb-0 fw-semibold text-uppercase letter-spacing-1">Total Alumni</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="stat-card-glow p-4 text-center">
                                <div class="bg-success/20 text-success rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 56px; height: 56px;">
                                    <i class="fa fa-check-circle fs-4 text-white"></i>
                                </div>
                                <h2 class="fw-extrabold text-white mb-1">{{ $totalTracer }}</h2>
                                <p class="text-white/60 small mb-0 fw-semibold text-uppercase letter-spacing-1">Alumni Terlacak</p>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="stat-card-glow p-4 text-center d-flex flex-column flex-md-row align-items-center justify-content-center gap-4">
                                <div class="position-relative d-inline-flex">
                                    <!-- Simple CSS Progress Circle -->
                                    <div class="d-flex align-items-center justify-content-center bg-white/10 rounded-circle text-white fw-bold" style="width: 80px; height: 80px; font-size: 1.1rem; border: 4px solid var(--accent);">
                                        {{ $workingPercentage }}%
                                    </div>
                                </div>
                                <div class="text-md-start text-center">
                                    <h4 class="text-white fw-bold mb-1">Tingkat Keterserapan Industri</h4>
                                    <p class="text-white/70 small mb-0 fw-medium">Alumni Teknik Informatika yang telah berhasil bekerja atau berwirausaha secara profesional.</p>
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
            <div class="text-center max-w-2xl mx-auto mb-5">
                <span class="section-tag">Statistik Karir</span>
                <h2 class="section-title">Hasil Penelusuran Alumni</h2>
                <p class="text-muted fw-medium mt-2">Gambaran sebaran profesional karir alumni Teknik Informatika Universitas Harkat Negeri.</p>
            </div>
            
            <div class="row g-4 justify-content-center">
                <!-- Card Bekerja -->
                <div class="col-md-4 col-sm-6">
                    <div class="feature-card p-4 text-center h-100">
                        <div class="icon-box-primary mx-auto mb-3" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
                            <i class="fa fa-briefcase"></i>
                        </div>
                        <h3 class="fw-bold text-dark mb-1">{{ $employed }}</h3>
                        <h5 class="fw-semibold text-muted mb-2">Bekerja Profesional</h5>
                        <p class="text-muted small mb-0">Alumni yang bekerja sebagai staf IT, engineer, manager, atau profesional di perusahaan nasional & global.</p>
                    </div>
                </div>
                <!-- Card Wirausaha -->
                <div class="col-md-4 col-sm-6">
                    <div class="feature-card p-4 text-center h-100">
                        <div class="icon-box-primary mx-auto mb-3" style="background: rgba(6, 182, 212, 0.1); color: #06b6d4;">
                            <i class="fa fa-lightbulb"></i>
                        </div>
                        <h3 class="fw-bold text-dark mb-1">{{ $entrepreneur }}</h3>
                        <h5 class="fw-semibold text-muted mb-2">Wirausaha / Startup</h5>
                        <p class="text-muted small mb-0">Alumni yang mendirikan unit usaha sendiri, konsultan IT, startup teknologi, atau agensi kreatif digital.</p>
                    </div>
                </div>
                <!-- Card Lanjut Studi -->
                <div class="col-md-4 col-sm-6">
                    <div class="feature-card p-4 text-center h-100">
                        <div class="icon-box-primary mx-auto mb-3">
                            <i class="fa fa-book-open"></i>
                        </div>
                        <h3 class="fw-bold text-dark mb-1">{{ $continuing }}</h3>
                        <h5 class="fw-semibold text-muted mb-2">Melanjutkan Pendidikan</h5>
                        <p class="text-muted small mb-0">Alumni yang menempuh pendidikan Master (S2) baik di dalam negeri maupun universitas luar negeri.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Partner CTA Card Section -->
    <section class="pb-5" id="mitra">
        <div class="container">
            <div class="partner-cta-section p-4 p-md-5 shadow-lg">
                <div class="row align-items-center g-4">
                    <div class="col-lg-8">
                        <div class="badge bg-white/20 text-white rounded-pill px-3 py-1 mb-3 fw-bold fs-xs text-uppercase letter-spacing-1">Kolaborasi Industri</div>
                        <h2 class="fw-extrabold text-white mb-3 fs-1">Bagi Perusahaan Mitra & Atasan Alumni</h2>
                        <p class="text-white/80 fs-5 mb-0 fw-medium">
                            Bantu kami menyelaraskan kualitas pembelajaran kurikulum dengan mengisi survei kepuasan atasan. Dapatkan juga akses langsung membagikan lowongan pekerjaan kepada talenta terbaik program studi kami.
                        </p>
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <a href="{{ route('mitra.loker.create') }}" class="btn btn-light text-primary rounded-pill px-4 py-3 fw-extrabold shadow-sm"><i class="fa fa-plus-circle me-1"></i> Mulai Posting Loker</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Recent Jobs Board -->
    <section class="py-5" id="loker">
        <div class="container py-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-5 border-bottom pb-4">
                <div>
                    <span class="section-tag">Bursa Karir</span>
                    <h2 class="section-title">Lowongan Kerja Terbaru</h2>
                    <p class="text-muted fw-medium mb-0">Raih kesempatan berkarir di berbagai perusahaan mitra terbaik kami.</p>
                </div>
                @auth
                    <a href="{{ route('alumni.loker.index') }}" class="btn btn-outline-primary rounded-pill px-4 mt-3 mt-md-0 fw-bold">Riwayat Lamaran Saya <i class="fa fa-arrow-right ms-1"></i></a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-primary rounded-pill px-4 mt-3 mt-md-0 fw-bold">Masuk untuk Melamar <i class="fa fa-arrow-right ms-1"></i></a>
                @endauth
            </div>

            <div class="row g-4">
                @forelse($recentJobs as $job)
                    <div class="col-lg-4 col-md-6">
                        <div class="job-card p-4 d-flex flex-column justify-content-between h-100">
                            <div>
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <span class="badge bg-primary-light text-primary rounded-pill px-2.5 py-1.5 fs-xs fw-bold">{{ $job->category }}</span>
                                    <small class="text-muted"><i class="fa fa-calendar-alt me-1"></i> {{ $job->created_at->diffForHumans() }}</small>
                                </div>
                                <h4 class="fw-bold text-dark mb-1">{{ $job->position }}</h4>
                                <h6 class="text-muted fw-semibold mb-3"><i class="fa fa-building me-1"></i> {{ $job->company_name }}</h6>
                                
                                <div class="d-flex flex-wrap gap-3 mb-4 text-muted small">
                                    <span><i class="fa fa-map-marker-alt text-danger me-1"></i> {{ $job->location }}</span>
                                    @if($job->salary_range)
                                        <span><i class="fa fa-money-bill-wave text-success me-1"></i> {{ $job->salary_range }}</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="d-flex gap-2">
                                <button class="btn btn-outline-secondary btn-sm rounded-pill px-3 fw-semibold btn-detail-landing" data-id="{{ $job->id }}">
                                    <i class="fa fa-eye me-1"></i> Detail
                                </button>
                                @auth
                                    @if(in_array($job->id, $appliedJobIds ?? []))
                                        <button class="btn btn-light btn-sm rounded-pill py-2 flex-grow-1 fw-bold border text-success" disabled>
                                            <i class="fa fa-check-circle me-1"></i> Sudah Dilamar
                                        </button>
                                    @else
                                        <button class="btn btn-primary btn-sm rounded-pill py-2 flex-grow-1 fw-bold btn-apply-landing"
                                            data-id="{{ $job->id }}"
                                            data-position="{{ $job->position }}"
                                            data-company="{{ $job->company_name }}">
                                            <i class="fa fa-paper-plane me-1"></i> Lamar
                                        </button>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-light btn-sm rounded-pill py-2 flex-grow-1 fw-bold border text-primary text-center">Lamar</a>
                                @endauth
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <div class="text-muted">
                            <i class="fa fa-briefcase fs-1 mb-3"></i>
                            <p class="fw-semibold mb-0">Belum ada lowongan pekerjaan aktif saat ini.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    @auth
    <!-- Apply Job Modal -->
    <div class="modal fade" id="modalApplyJob" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 overflow-hidden">
                <div class="modal-header bg-dark text-white border-0 p-4">
                    <div>
                        <h5 class="modal-title fw-bold text-white mb-1">Lamar Posisi</h5>
                        <p class="mb-0 text-white-50 fs-sm" id="apply-job-info">-</p>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4 text-start">
                    <input type="hidden" id="apply-job-id">
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted small text-uppercase">Nomor WhatsApp / Telepon Aktif <span class="text-danger">*</span></label>
                        <input type="text" id="apply-phone" class="form-control" placeholder="Contoh: 081234567890" required style="border-radius: 12px;" value="{{ Auth::check() && Auth::user()->alumni ? Auth::user()->alumni->no_hp : '' }}">
                        <div class="form-text">Nomor telepon yang bisa dihubungi oleh perusahaan.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted small text-uppercase">Gaji yang Diharapkan (Opsional)</label>
                        <input type="text" id="apply-expected-salary" class="form-control" placeholder="Contoh: Rp 5.000.000" style="border-radius: 12px;">
                        <div class="form-text">Masukkan perkiraan atau rentang gaji yang Anda harapkan.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted small text-uppercase">Unggah CV / Resume <span class="text-danger">*</span></label>
                        <input type="file" id="apply-cv" class="form-control" accept=".pdf,.doc,.docx" required style="border-radius: 12px;">
                        <div class="form-text">Format yang diperbolehkan: PDF, DOC, DOCX. Maksimal 2MB.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted small text-uppercase">Pesan Singkat / Cover Letter (Opsional)</label>
                        <textarea id="apply-cover-letter" class="form-control" rows="4" maxlength="1000"
                            placeholder="Tuliskan pesan singkat atau motivasi Anda melamar posisi ini..." style="border-radius: 12px;"></textarea>
                        <div class="form-text">Maksimal 1000 karakter</div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-3">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary rounded-pill px-4 fw-bold" id="btn-submit-apply">
                        <i class="fa fa-paper-plane me-1"></i> Kirim Lamaran
                    </button>
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
            <div class="modal-content border-0 rounded-4 overflow-hidden shadow-xl">
                <div class="modal-header border-0 p-0">
                    <div class="w-100 text-center p-4" style="background: linear-gradient(135deg, #5a121b 0%, #8b1a28 100%);">
                        <div class="d-flex align-items-center justify-content-center mb-3" style="width: 72px; height: 72px; background: rgba(255,255,255,0.15); border-radius: 50%; margin: 0 auto;">
                            <i class="fa fa-clipboard-list text-white" style="font-size: 2rem;"></i>
                        </div>
                        <h5 class="fw-extrabold text-white mb-1">Satu Langkah Lagi!</h5>
                        <p class="text-white-50 mb-0 fs-sm">Lengkapi profil Tracer Study Anda</p>
                    </div>
                </div>
                <div class="modal-body p-4 text-center">
                    <p class="fw-semibold text-dark mb-2">Untuk dapat melamar lowongan kerja,</p>
                    <p class="text-muted mb-4">
                        Anda perlu mengisi <strong>Kuesioner Tracer Study</strong> terlebih dahulu.<br>
                        Hanya membutuhkan <strong>±5 menit</strong> dan membantu kampus
                        meningkatkan kualitas pendidikan untuk adik angkatan Anda.
                    </p>
                    <div class="d-flex align-items-center gap-3 p-3 rounded-3 mb-4 text-start" style="background: rgba(90, 18, 27, 0.06); border: 1px solid rgba(90, 18, 27, 0.12);">
                        <i class="fa fa-circle-check text-success fs-4 flex-shrink-0"></i>
                        <div>
                            <div class="fw-bold text-dark small">Setelah mengisi, Anda bisa:</div>
                            <div class="text-muted small">Melamar semua lowongan yang tersedia di platform ini</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0 px-4 pb-4 d-flex gap-2">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4 flex-fill" data-bs-dismiss="modal">
                        Nanti Saja
                    </button>
                    <a href="{{ route('new-tracer.index') }}" class="btn btn-primary rounded-pill px-4 fw-bold flex-fill" style="background: #5a121b; border-color: #5a121b;">
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
            <div class="modal-content border-0 rounded-4 overflow-hidden shadow-lg">
                <div class="modal-header bg-dark text-white border-0 p-4">
                    <div class="d-flex align-items-center gap-3">
                        <div id="detail-company-logo-container">
                            <!-- Logo populated by JS -->
                        </div>
                        <div>
                            <h5 class="modal-title fw-bold text-white mb-1" id="detail-job-position">-</h5>
                            <p class="mb-0 text-white-50 fs-sm" id="detail-company-name">-</p>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4 bg-light/30">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="p-3 bg-white border border-light shadow-xs rounded-3">
                                <span class="text-muted text-uppercase fw-bold d-block mb-1" style="font-size: 0.65rem;">Kategori Bidang</span>
                                <span class="fw-bold text-dark" id="detail-job-category">-</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 bg-white border border-light shadow-xs rounded-3">
                                <span class="text-muted text-uppercase fw-bold d-block mb-1" style="font-size: 0.65rem;">Lokasi</span>
                                <span class="fw-bold text-dark" id="detail-job-location">-</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 bg-white border border-light shadow-xs rounded-3">
                                <span class="text-muted text-uppercase fw-bold d-block mb-1" style="font-size: 0.65rem;">Gaji</span>
                                <span class="fw-bold text-dark" id="detail-job-salary">-</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 bg-white border border-light shadow-xs rounded-3">
                                <span class="text-muted text-uppercase fw-bold d-block mb-1" style="font-size: 0.65rem;">Email Pendaftaran</span>
                                <span class="fw-bold text-dark" id="detail-job-contact-email">-</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 bg-white border border-light shadow-xs rounded-3">
                                <span class="text-muted text-uppercase fw-bold d-block mb-1" style="font-size: 0.65rem;">Link Pendaftaran</span>
                                <span class="fw-bold text-dark" id="detail-job-contact-link">-</span>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="p-3 bg-white border border-light shadow-xs rounded-3">
                                <span class="text-muted text-uppercase fw-bold d-block mb-2" style="font-size: 0.65rem;">Deskripsi Pekerjaan</span>
                                <div class="text-dark fs-sm" id="detail-job-description" style="white-space: pre-line; line-height: 1.6;">-</div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="p-3 bg-white border border-light shadow-xs rounded-3">
                                <span class="text-muted text-uppercase fw-bold d-block mb-2" style="font-size: 0.65rem;">Kualifikasi / Persyaratan</span>
                                <div class="text-dark fs-sm" id="detail-job-requirements" style="white-space: pre-line; line-height: 1.6;">-</div>
                            </div>
                        </div>

                        <!-- Poster display -->
                        <div class="col-12" id="detail-poster-container" style="display: none;">
                            <div class="p-3 bg-white border border-light shadow-xs rounded-3 text-center">
                                <span class="text-muted text-uppercase fw-bold d-block mb-2 text-start" style="font-size: 0.65rem;">Poster / Brosur Lowongan</span>
                                
                                <div id="carouselLandingPosters" class="carousel slide carousel-dark" data-bs-ride="carousel">
                                    <div class="carousel-indicators" id="carousel-landing-indicators">
                                        <!-- Indicators populated by JS -->
                                    </div>
                                    <div class="carousel-inner rounded-3 shadow-sm bg-light" id="carousel-landing-inner" style="max-height: 480px;">
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
                <div class="modal-footer border-0 p-3 bg-light/50">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
                    <div id="detail-action-container">
                        <!-- Action button populated dynamically by JS -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
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

                // ✅ Opsi C: Cek apakah sudah isi tracer study
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
                            logoContainer.innerHTML = '<img src="' + job.logo_path + '" alt="Logo" class="rounded-3 shadow-xs" style="width: 48px; height: 48px; object-fit: cover;">';
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
                                        '<img src="' + path + '" class="d-block w-100 rounded-3 shadow-sm" style="max-height: 450px; object-fit: contain;" alt="Poster Lowongan">' +
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
                            actionContainer.innerHTML = '<a href="/login" class="btn btn-primary rounded-pill px-4 fw-bold">Masuk untuk Melamar <i class="fa fa-arrow-right ms-1"></i></a>';
                        } else if (job.already_applied) {
                            actionContainer.innerHTML = '<button class="btn btn-light rounded-pill px-4 fw-bold border text-success" disabled><i class="fa fa-check-circle me-1"></i> Sudah Dilamar</button>';
                        } else {
                            actionContainer.innerHTML = '<button class="btn btn-primary rounded-pill px-4 fw-bold btn-apply-from-detail" data-id="' + job.id + '" data-position="' + job.position + '" data-company="' + job.company_name + '"><i class="fa fa-paper-plane me-1"></i> Lamar Sekarang</button>';

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
                        applyBtn.outerHTML = '<button class="btn btn-light btn-sm rounded-pill py-2 flex-grow-1 fw-bold border text-success" disabled><i class="fa fa-check-circle me-1"></i> Sudah Dilamar</button>';
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
    <footer class="footer-uhn py-5 mt-5">
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
                    <p class="text-muted-uhn small mb-1"><i class="fa fa-envelope me-2"></i> info@harkatnegeri.ac.id</p>
                    <p class="text-muted-uhn small"><i class="fa fa-map-marker-alt me-2"></i> Kampus Terpadu Univ Harkat Negeri</p>
                </div>
            </div>
            <hr class="my-4">
            <div class="row align-items-center justify-content-between">
                <div class="col-md-6 text-center text-md-start">
                    <p class="small text-muted-uhn mb-0">&copy; 2026 Universitas Harkat Negeri. Hak Cipta Dilindungi.</p>
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
