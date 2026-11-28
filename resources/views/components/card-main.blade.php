@php
    $totalAlumniCount = $countAlumni ?? array_sum($alumniData ?? []);
    $totalKuesioner = isset($statistikAlumni)
        ? array_sum(array_column($statistikAlumni, 'jumlah'))
        : array_sum($kuisonerData ?? []);
    $completionRate = $totalAlumniCount > 0 ? round(($totalKuesioner / $totalAlumniCount) * 100, 1) : 0;

    $alumniModel = auth()->user()->alumni;
    $alumniName = $alumniModel->nama_lengkap ?? auth()->user()->username;
    $alumniId = optional($alumniModel)->id ?? optional($existingTracer ?? null)->alumni_id;

    $supervisorCompleted = isset($tracerPengguna) && $tracerPengguna && $tracerPengguna->status_pengisian === 'completed';
    $supervisorPending = isset($tracerPengguna) && $tracerPengguna && $tracerPengguna->status_pengisian !== 'completed';

    // Hitung kelengkapan aktivitas akun mahasiswa/alumni
    $myStepsDone = 1; // Akun aktif
    $myTotalSteps = 3;
    if ($alumniModel && !empty($alumniModel->no_hp) && !empty($alumniModel->alamat)) {
        $myStepsDone++;
    }
    if ($statusTracer === 'sudah') {
        $myStepsDone++;
    }
    $myReadinessRate = round(($myStepsDone / $myTotalSteps) * 100);

    $statsKarir = $statistikAlumni ?? [
        'Bekerja' => ['jumlah' => 0, 'persen' => '0%'],
        'Wirausaha' => ['jumlah' => 0, 'persen' => '0%'],
        'Lanjut Studi' => ['jumlah' => 0, 'persen' => '0%'],
        'Belum Bekerja' => ['jumlah' => 0, 'persen' => '0%'],
        'Tidak Bekerja' => ['jumlah' => 0, 'persen' => '0%'],
    ];
@endphp

<style>
    /* Hero Banner (Identik dengan Admin Dashboard) */
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

    .hero-badge-status-ok {
        background: rgba(16, 185, 129, 0.2);
        color: #6ee7b7;
        font-size: 0.72rem;
        font-weight: 600;
        padding: 0.35rem 0.7rem;
        border-radius: 2rem;
        border: 1px solid rgba(16, 185, 129, 0.35);
    }

    .hero-badge-status-warn {
        background: rgba(245, 158, 11, 0.2);
        color: #fcd34d;
        font-size: 0.72rem;
        font-weight: 600;
        padding: 0.35rem 0.7rem;
        border-radius: 2rem;
        border: 1px solid rgba(245, 158, 11, 0.35);
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

    .hero-cta-btn {
        background: rgba(255, 255, 255, 0.14);
        border: 1px solid rgba(255, 255, 255, 0.24);
        color: #ffffff !important;
        font-size: 0.78rem;
        font-weight: 600;
        padding: 0.45rem 1rem;
        border-radius: 2rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        transition: all 0.2s ease;
    }

    .hero-cta-btn:hover {
        background: rgba(255, 255, 255, 0.24);
        transform: translateY(-1px);
    }

    /* Metric Cards (Identik dengan Admin Dashboard) */
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
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
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
        height: 100%;
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
    .shortcut-icon.bg-emerald { background: #ecfdf5; color: #059669; }

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

    /* Dark Mode Compatibility */
    #page-container.dark-mode .metric-card,
    #page-container.dark-mode .panel-card,
    #page-container.dark-mode .shortcut-box {
        background: #1e293b !important;
        border-color: rgba(255, 255, 255, 0.08) !important;
    }

    #page-container.dark-mode .panel-header,
    #page-container.dark-mode .metric-footer {
        border-color: rgba(255, 255, 255, 0.08) !important;
    }

    #page-container.dark-mode .metric-value,
    #page-container.dark-mode .shortcut-title {
        color: #f8fafc !important;
    }

    #page-container.dark-mode .kpi-widget {
        background: #0f172a !important;
        border-color: rgba(255, 255, 255, 0.08) !important;
    }
</style>

<div class="content content-full">
    {{-- Flash Messages --}}
    @if (session('error') || session('success'))
        <div class="mb-3">
            @if (session('error'))
                <div class="mb-2 border-0 shadow-sm alert alert-danger rounded-3 d-flex align-items-center">
                    <i class="fa fa-exclamation-circle me-2"></i>
                    <div>{{ session('error') }}</div>
                </div>
            @endif
            @if (session('success'))
                <div class="mb-2 border-0 shadow-sm alert alert-success rounded-3 d-flex align-items-center">
                    <i class="fa fa-check-circle me-2"></i>
                    <div>{{ session('success') }}</div>
                </div>
            @endif
        </div>
    @endif

    <!-- Hero Header Modern (Sama dengan Admin Dashboard) -->
    <div class="mb-4 dashboard-hero">
        <div class="row align-items-center g-3">
            <div class="col-lg-7">
                <div class="flex-wrap gap-2 mb-2 d-flex align-items-center">
                    <span class="badge hero-badge">
                        <i class="fa fa-star text-warning me-1"></i> Tracer Study Portal
                    </span>
                    @if ($alumniModel)
                        <span class="badge hero-badge-sub">
                            NIM: {{ $alumniModel->nim }} • Angkatan {{ $alumniModel->tahun_masuk ?? '-' }}
                        </span>
                    @else
                        <span class="badge hero-badge-sub">
                            T.A {{ $selectedTA ?? 'Aktif' }}
                        </span>
                    @endif

                    @if ($statusTracer === 'sudah')
                        <span class="badge hero-badge-status-ok">
                            <i class="fa fa-check-circle me-1"></i> Sudah Mengisi Tracer
                        </span>
                    @else
                        <span class="badge hero-badge-status-warn">
                            <i class="fa fa-exclamation-triangle me-1"></i> Belum Mengisi Tracer
                        </span>
                    @endif
                </div>

                <h1 class="mb-2 text-white h3 fw-bold">
                    Selamat Datang, {{ $alumniName }}! 👋
                </h1>
                <p class="mb-3 text-white-50 small">
                    Kelola data penelusuran karir lulusan, pantau evaluasi pengguna, cetak CV ATS otomatis, dan lacak riwayat lamaran kerja Anda secara real-time.
                </p>

                <div class="flex-wrap gap-2 d-flex align-items-center">
                    @if ($statusTracer === 'sudah' && $alumniId)
                        <a href="{{ route('new-tracer.show', $alumniId) }}" class="hero-cta-btn">
                            <i class="fa fa-eye text-info"></i> Lihat Kuesioner Saya
                        </a>
                        <a href="{{ route('new-tracer.edit') }}" class="hero-cta-btn">
                            <i class="fa fa-edit text-warning"></i> Perbarui Data
                        </a>
                    @else
                        <a href="{{ route('new-tracer.index') }}" class="hero-cta-btn">
                            <i class="fa fa-edit text-warning"></i> Isi Kuesioner Sekarang
                        </a>
                    @endif
                </div>
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

    <!-- 4 Top Metric Cards (Sama dengan Admin Dashboard) -->
    <div class="mb-4 row g-3">
        {{-- Card 1: Status Tracer Saya --}}
        <div class="col-sm-6 col-xl-3">
            <div class="metric-card metric-blue h-100">
                <div class="metric-card-body">
                    <div class="mb-3 d-flex align-items-center justify-content-between">
                        <div class="metric-icon">
                            <i class="fa fa-file-signature"></i>
                        </div>
                        <span class="metric-pill">
                            {{ $statusTracer === 'sudah' ? 'Terverifikasi' : 'Wajib Diisi' }}
                        </span>
                    </div>
                    <div class="metric-value" style="font-size: 1.55rem;">
                        {{ $statusTracer === 'sudah' ? 'Sudah Diisi' : 'Belum Diisi' }}
                    </div>
                    <div class="metric-label">Status Kuesioner Tracer Saya</div>
                    <div class="metric-footer">
                        @if ($statusTracer === 'sudah' && $alumniId)
                            <a href="{{ route('new-tracer.show', $alumniId) }}" class="metric-link">
                                Lihat Kuesioner <i class="fa fa-arrow-right ms-1"></i>
                            </a>
                        @else
                            <a href="{{ route('new-tracer.index') }}" class="metric-link">
                                Isi Sekarang <i class="fa fa-arrow-right ms-1"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Card 2: Total Alumni Terdata --}}
        <div class="col-sm-6 col-xl-3">
            <div class="metric-card metric-emerald h-100">
                <div class="metric-card-body">
                    <div class="mb-3 d-flex align-items-center justify-content-between">
                        <div class="metric-icon">
                            <i class="fa fa-award"></i>
                        </div>
                        <span class="metric-pill">Alumni TI</span>
                    </div>
                    <div class="metric-value stat-counter">{{ $totalAlumniCount }}</div>
                    <div class="metric-label">Total Lulusan Terdata</div>
                    <div class="metric-footer">
                        <a href="{{ route('profile.cv') }}" class="metric-link">
                            Cetak CV ATS <i class="fa fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card 3: Responden Tracer Alumni --}}
        <div class="col-sm-6 col-xl-3">
            <div class="metric-card metric-amber h-100">
                <div class="metric-card-body">
                    <div class="mb-3 d-flex align-items-center justify-content-between">
                        <div class="metric-icon">
                            <i class="fa fa-chart-pie"></i>
                        </div>
                        <span class="metric-pill">{{ $completionRate }}% Terisi</span>
                    </div>
                    <div class="metric-value stat-counter">{{ $totalKuesioner }}</div>
                    <div class="metric-label">Responden Kuesioner Alumni</div>
                    <div class="metric-footer">
                        <a href="{{ route('profile') }}" class="metric-link">
                            Kelola Profil <i class="fa fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card 4: Evaluasi Atasan & Bursa Kerja --}}
        <div class="col-sm-6 col-xl-3">
            <div class="metric-card metric-violet h-100">
                <div class="metric-card-body">
                    <div class="mb-3 d-flex align-items-center justify-content-between">
                        <div class="metric-icon">
                            <i class="fa fa-briefcase"></i>
                        </div>
                        <span class="metric-pill">{{ $activeLokerCount ?? 0 }} Loker Aktif</span>
                    </div>
                    <div class="metric-value stat-counter">{{ $lamaranCount ?? 0 }}</div>
                    <div class="metric-label">Riwayat Lamaran Kerja Saya</div>
                    <div class="metric-footer">
                        <a href="{{ route('alumni.loker.index') }}" class="metric-link">
                            Lihat Riwayat Saya <i class="fa fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Dashboard Visual Rows (2 Kolom: 8 + 4 sama dengan Admin Dashboard) --}}
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
                        <i class="fa fa-check-circle text-success me-1"></i> {{ $totalKuesioner }} Responden
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
                                ['label' => 'Wirausaha', 'key' => 'Wirausaha', 'icon' => 'fa-store', 'color' => '#f59e0b', 'bg' => '#fffbeb'],
                                ['label' => 'Lanjut Studi', 'key' => 'Lanjut Studi', 'icon' => 'fa-graduation-cap', 'color' => '#3b82f6', 'bg' => '#eff6ff'],
                                ['label' => 'Belum Bekerja', 'key' => 'Belum Bekerja', 'icon' => 'fa-clock', 'color' => '#ef4444', 'bg' => '#fef2f2'],
                                ['label' => 'Tidak Bekerja', 'key' => 'Tidak Bekerja', 'icon' => 'fa-user-slash', 'color' => '#6b7280', 'bg' => '#f9fafb']
                            ];
                        @endphp
                        @foreach ($alumniStatsConfig as $conf)
                            @php $statData = $statsKarir[$conf['key']] ?? ['jumlah' => 0, 'persen' => '0%']; @endphp
                            <div class="col-6 col-sm-4 col-xl">
                                <div class="p-2 text-center border career-stat-card rounded-3"
                                    style="background-color: {{ $conf['bg'] }}; border-color: rgba(0,0,0,0.04) !important;">
                                    <div class="gap-1 mb-1 d-flex align-items-center justify-content-center">
                                        <i class="fa {{ $conf['icon'] }} fs-xs" style="color: {{ $conf['color'] }}"></i>
                                        <span class="fs-xs fw-bold text-muted text-uppercase"
                                            style="font-size: 0.65rem;">{{ $conf['label'] }}</span>
                                    </div>
                                    <div class="mb-0 fs-4 fw-extrabold" style="color: #0f172a;">{{ $statData['jumlah'] }}</div>
                                    <div class="px-1 py-0 fs-xs fw-bold rounded-pill d-inline-block"
                                        style="color: {{ $conf['color'] }}; font-size: 0.68rem;">
                                        {{ $statData['persen'] }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Rasio Partisipasi & Tren Lulusan --}}
        <div class="col-xl-4">
            <div class="panel-card h-100 d-flex flex-column">
                <div class="panel-header d-flex align-items-center justify-content-between">
                    <div class="gap-2 d-flex align-items-center">
                        <div class="panel-icon bg-info-soft text-success">
                            <i class="fa fa-chart-pie"></i>
                        </div>
                        <h6 class="mb-0 fw-bold text-dark">Rasio Partisipasi & Progres</h6>
                    </div>
                </div>

                <div class="panel-body flex-grow-1 d-flex flex-column justify-content-between">
                    <!-- Progress Card Kelengkapan Saya -->
                    <div class="p-3 mb-3 kpi-widget rounded-3">
                        <div class="mb-1 d-flex justify-content-between align-items-center">
                            <span class="fw-bold fs-xs text-uppercase text-muted">Kelengkapan Data Saya</span>
                            <span class="text-white badge bg-primary fw-bold">{{ $myReadinessRate }}%</span>
                        </div>
                        <div class="mb-2 progress rounded-pill" style="height: 8px; background-color: #e2e8f0;">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary rounded-pill"
                                style="width: {{ $myReadinessRate }}%;"></div>
                        </div>
                        <div class="d-flex justify-content-between text-muted fs-xs">
                            <span>{{ $myStepsDone }}/{{ $myTotalSteps }} Tahap Selesai</span>
                            <span>{{ $supervisorCompleted ? 'Evaluasi Atasan Selesai' : ($supervisorPending ? 'Menunggu Atasan' : 'Profil & Tracer') }}</span>
                        </div>
                    </div>

                    <!-- Progress Card Tracer Alumni -->
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
                            <span>{{ $totalKuesioner }} Mengisi</span>
                            <span>Total {{ $totalAlumniCount }} Alumni</span>
                        </div>
                    </div>

                    <!-- Mini Timeline Chart -->
                    <div class="pt-2 mt-2 border-top">
                        <div class="mb-2 d-flex align-items-center justify-content-between">
                            <span class="fs-xs fw-bold text-dark text-uppercase">Tren Lulusan ({{ $tahun[0] ?? 2021 }}-{{ end($tahun) ?: 2025 }})</span>
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

    {{-- Quick Shortcut Grid (Sama dengan Admin Dashboard) --}}
    <div class="row g-3">
        <div class="col-sm-6 col-xl-3">
            <a href="{{ $statusTracer === 'sudah' && $alumniId ? route('new-tracer.show', $alumniId) : route('new-tracer.index') }}"
                class="shortcut-box">
                <div class="shortcut-icon bg-blue">
                    <i class="fa fa-clipboard-list"></i>
                </div>
                <div>
                    <div class="shortcut-title">{{ $statusTracer === 'sudah' ? 'Data Tracer Saya' : 'Isi Tracer Study' }}</div>
                    <div class="shortcut-desc">Kelola kuesioner penelusuran karir lulusan</div>
                </div>
                <i class="fa fa-chevron-right ms-auto text-muted fs-xs"></i>
            </a>
        </div>
        <div class="col-sm-6 col-xl-3">
            <a href="{{ route('profile.cv') }}" class="shortcut-box">
                <div class="shortcut-icon bg-violet">
                    <i class="fa fa-file-invoice"></i>
                </div>
                <div>
                    <div class="shortcut-title">Resume & CV ATS</div>
                    <div class="shortcut-desc">Cetak CV profesional otomatis berbasis AI</div>
                </div>
                <i class="fa fa-chevron-right ms-auto text-muted fs-xs"></i>
            </a>
        </div>
        <div class="col-sm-6 col-xl-3">
            <a href="{{ route('alumni.loker.index') }}" class="shortcut-box">
                <div class="shortcut-icon bg-amber">
                    <i class="fa fa-briefcase"></i>
                </div>
                <div>
                    <div class="shortcut-title">Riwayat Lamaran</div>
                    <div class="shortcut-desc">Pantau status pengajuan lowongan kerja</div>
                </div>
                <i class="fa fa-chevron-right ms-auto text-muted fs-xs"></i>
            </a>
        </div>
        <div class="col-sm-6 col-xl-3">
            <a href="{{ route('profile') }}" class="shortcut-box">
                <div class="shortcut-icon bg-emerald">
                    <i class="fa fa-user-cog"></i>
                </div>
                <div>
                    <div class="shortcut-title">Profil & Biodata</div>
                    <div class="shortcut-desc">Perbarui informasi kontak dan akun alumni</div>
                </div>
                <i class="fa fa-chevron-right ms-auto text-muted fs-xs"></i>
            </a>
        </div>
    </div>
</div>

@push('scripts')
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
            if (typeof jQuery !== 'undefined') {
                jQuery('.stat-counter').each(function () {
                    const $this = jQuery(this);
                    const countTo = parseInt($this.text()) || 0;
                    jQuery({ countNum: 0 }).animate({ countNum: countTo }, {
                        duration: 1100,
                        easing: 'swing',
                        step: function () { $this.text(Math.floor(this.countNum)); },
                        complete: function () { $this.text(this.countNum); }
                    });
                });
            }

            // Bar Chart Distribusi Karir (Identik dengan Admin Dashboard)
            const barEl = document.getElementById('barChartAlumni');
            if (barEl && typeof Chart !== 'undefined') {
                const ctxBar = barEl.getContext('2d');

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
                                {{ $statsKarir['Bekerja']['jumlah'] ?? 0 }},
                                {{ $statsKarir['Wirausaha']['jumlah'] ?? 0 }},
                                {{ $statsKarir['Lanjut Studi']['jumlah'] ?? 0 }},
                                {{ $statsKarir['Belum Bekerja']['jumlah'] ?? 0 }},
                                {{ $statsKarir['Tidak Bekerja']['jumlah'] ?? 0 }}
                            ],
                            backgroundColor: [gradBekerja, gradWirausaha, gradStudi, gradBelum, gradTidak],
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
                                    label: function (context) {
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
            }

            // Line Chart Tren Lulusan (Identik dengan Admin Dashboard)
            const lineEl = document.getElementById('lineChartAlumni');
            if (lineEl && typeof Chart !== 'undefined') {
                const ctxLine = lineEl.getContext('2d');
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
            }
        });
    </script>
@endpush
