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
                    <li class="nav-item ms-lg-2">
                        <a href="{{ route('login') }}" class="btn btn-outline-primary rounded-pill px-4 fw-bold">Login Portal</a>
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
                    <div class="hero-badge mb-3">
                        <i class="fa fa-circle-nodes text-accent me-1 animate-pulse"></i> Integrasi Tracer Study & Bursa Kerja
                    </div>
                    <h1 class="hero-title mb-4">Membangun Jembatan Karir <span>Masa Depan</span></h1>
                    <p class="text-white/80 fs-5 mb-5 fw-medium" style="line-height: 1.6;">
                        Portal Tracer Study Program Studi Teknik Informatika Universitas Harkat Negeri. Kami menghubungkan keselarasan kurikulum akademik dengan kebutuhan nyata industri kerja.
                    </p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="{{ route('login') }}" class="btn btn-modern-primary shadow-lg px-4 py-3"><i class="fa fa-right-to-bracket me-2"></i> Masuk Sebagai Alumni</a>
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
                <a href="{{ route('login') }}" class="btn btn-outline-primary rounded-pill px-4 mt-3 mt-md-0 fw-bold">Lihat Semua Loker <i class="fa fa-arrow-right ms-1"></i></a>
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
                            
                            <a href="{{ route('login') }}" class="btn btn-light btn-sm rounded-pill py-2 w-100 fw-bold border text-primary">Masuk untuk Melamar <i class="fa fa-arrow-right ms-1"></i></a>
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

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
