@extends('layout')

@section('title', 'Riwayat Lamaran Kerja - Tracer Study TI UHN')

@push('styles')
    <style>
        .app-card {
            background: #ffffff;
            border: 1px solid rgba(0, 0, 0, 0.05);
            border-radius: 16px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .app-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.05);
        }

        .stat-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.8rem;
            border: 1px solid;
            transition: all 0.2s ease;
            text-decoration: none !important;
        }

        .stat-pill:hover {
            transform: scale(1.05);
        }

        .stat-pill-all {
            background: rgba(100, 116, 139, 0.08);
            border-color: rgba(100, 116, 139, 0.2);
            color: #475569;
        }

        .stat-pill-warning {
            background: rgba(245, 158, 11, 0.08);
            border-color: rgba(245, 158, 11, 0.2);
            color: #d97706;
        }

        .stat-pill-info {
            background: rgba(59, 130, 246, 0.08);
            border-color: rgba(59, 130, 246, 0.2);
            color: #2563eb;
        }

        .stat-pill-success {
            background: rgba(16, 185, 129, 0.08);
            border-color: rgba(16, 185, 129, 0.2);
            color: #059669;
        }

        .stat-pill-danger {
            background: rgba(239, 68, 68, 0.08);
            border-color: rgba(239, 68, 68, 0.2);
            color: #dc2626;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.3px;
        }

        .status-applied {
            background: rgba(245, 158, 11, 0.12);
            color: #d97706;
        }

        .status-reviewed {
            background: rgba(59, 130, 246, 0.12);
            color: #2563eb;
        }

        .status-accepted {
            background: rgba(16, 185, 129, 0.12);
            color: #059669;
        }

        .status-rejected {
            background: rgba(239, 68, 68, 0.12);
            color: #dc2626;
        }

        .company-logo {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            object-fit: cover;
            border: 1px solid #f1f5f9;
        }

        .company-logo-placeholder {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: rgba(79, 70, 229, 0.08);
            color: #4f46e5;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
        }

        .empty-state {
            padding: 4rem 2rem;
            text-align: center;
        }

        .empty-state-icon {
            font-size: 4rem;
            color: #cbd5e1;
            margin-bottom: 1rem;
            display: block;
        }
    </style>
@endpush

@section('content')
    <main id="main-container" class="main">
        @include('components.navbar')

        <div class="container py-4">
            <!-- Page Header -->
            <div
                class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-alt mb-1">
                            <li class="breadcrumb-item">
                                <a class="link-fx" href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Riwayat Lamaran</li>
                        </ol>
                    </nav>
                    <h2 class="h3 fw-extrabold text-dark mb-0">Riwayat Lamaran Kerja</h2>
                    <p class="text-muted mb-0 fs-sm">Pantau status semua lamaran pekerjaan yang telah Anda kirim.</p>
                </div>
                <a href="{{ route('home') }}#loker" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">
                    <i class="fa fa-briefcase me-1"></i> Cari Lowongan Baru
                </a>
            </div>

            <!-- Stats Pills -->
            <div class="d-flex flex-wrap gap-2 mb-4">
                <a href="{{ route('alumni.loker.index') }}"
                    class="stat-pill stat-pill-all {{ !request('status') ? 'border-dark' : '' }}">
                    <i class="fa fa-layer-group"></i> Semua <span class="fw-bold">{{ $stats['total'] }}</span>
                </a>
                <a href="{{ route('alumni.loker.index', ['status' => 'applied']) }}"
                    class="stat-pill stat-pill-warning {{ request('status') == 'applied' ? 'border-warning' : '' }}">
                    <i class="fa fa-paper-plane"></i> Dilamar <span class="fw-bold">{{ $stats['applied'] }}</span>
                </a>
                <a href="{{ route('alumni.loker.index', ['status' => 'reviewed']) }}"
                    class="stat-pill stat-pill-info {{ request('status') == 'reviewed' ? 'border-info' : '' }}">
                    <i class="fa fa-eye"></i> Ditinjau <span class="fw-bold">{{ $stats['reviewed'] }}</span>
                </a>
                <a href="{{ route('alumni.loker.index', ['status' => 'accepted']) }}"
                    class="stat-pill stat-pill-success {{ request('status') == 'accepted' ? 'border-success' : '' }}">
                    <i class="fa fa-check-circle"></i> Diterima <span class="fw-bold">{{ $stats['accepted'] }}</span>
                </a>
                <a href="{{ route('alumni.loker.index', ['status' => 'rejected']) }}"
                    class="stat-pill stat-pill-danger {{ request('status') == 'rejected' ? 'border-danger' : '' }}">
                    <i class="fa fa-times-circle"></i> Ditolak <span class="fw-bold">{{ $stats['rejected'] }}</span>
                </a>
            </div>

            <!-- Search -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-3">
                    <form action="{{ route('alumni.loker.index') }}" method="GET">
                        @if(request('status'))
                            <input type="hidden" name="status" value="{{ request('status') }}">
                        @endif
                        <div class="row g-2">
                            <div class="col-md-9">
                                <div class="input-group">
                                    <span class="input-group-text bg-transparent border-end-0 text-muted"><i
                                            class="fa fa-search"></i></span>
                                    <input type="text" name="search" class="form-control border-start-0"
                                        placeholder="Cari posisi atau perusahaan..." value="{{ request('search') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary w-100 rounded-pill">
                                    <i class="fa fa-filter me-1"></i> Cari
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Applications List -->
            @forelse($applications as $app)
                <div class="app-card p-4 mb-3">
                    <div class="d-flex flex-column flex-md-row align-items-start gap-3">
                        <!-- Company Logo -->
                        <div class="flex-shrink-0">
                            @if($app->jobVacancy->logo_path)
                                <img src="{{ $app->jobVacancy->logo_path }}" class="company-logo"
                                    alt="{{ $app->jobVacancy->company_name }}">
                            @else
                                <div class="company-logo-placeholder">
                                    {{ substr($app->jobVacancy->company_name, 0, 2) }}
                                </div>
                            @endif
                        </div>

                        <!-- Job Info -->
                        <div class="flex-grow-1">
                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start mb-2">
                                <div>
                                    <h5 class="fw-bold text-dark mb-1">{{ $app->jobVacancy->position }}</h5>
                                    <h6 class="text-muted fw-semibold mb-0">
                                        <i class="fa fa-building me-1"></i> {{ $app->jobVacancy->company_name }}
                                    </h6>
                                </div>
                                <div class="mt-2 mt-md-0">
                                    <span class="status-badge status-{{ $app->status }}">
                                        <i class="fa {{ $app->status_icon }}"></i>
                                        {{ $app->status_label }}
                                    </span>
                                </div>
                            </div>

                            <div class="d-flex flex-wrap gap-3 text-muted small mb-2">
                                <span><i class="fa fa-map-marker-alt text-danger me-1"></i>
                                    {{ $app->jobVacancy->location }}</span>
                                @if($app->jobVacancy->salary_range)
                                    <span><i class="fa fa-money-bill-wave text-success me-1"></i>
                                        {{ $app->jobVacancy->salary_range }}</span>
                                @endif
                                <span><i class="fa fa-calendar me-1"></i> Dilamar:
                                    {{ $app->applied_at->translatedFormat('d M Y, H:i') }}</span>
                                @if($app->reviewed_at)
                                    <span><i class="fa fa-clock me-1"></i> Ditinjau:
                                        {{ $app->reviewed_at->translatedFormat('d M Y') }}</span>
                                @endif
                            </div>

                            @if($app->admin_notes)
                                <div class="mt-2 p-2 bg-light rounded-3 small">
                                    <i class="fa fa-comment-dots text-primary me-1"></i>
                                    <strong>Catatan Admin:</strong> {{ $app->admin_notes }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="empty-state">
                        <i class="fa fa-inbox empty-state-icon"></i>
                        <h4 class="fw-bold text-dark">Belum Ada Lamaran</h4>
                        <p class="text-muted mb-4">Anda belum melamar pekerjaan apapun. Mulai cari lowongan di halaman landing
                            page!</p>
                        <a href="{{ route('home') }}#loker" class="btn btn-primary rounded-pill px-4 fw-bold">
                            <i class="fa fa-search me-1"></i> Cari Lowongan Kerja
                        </a>
                    </div>
                </div>
            @endforelse

            <!-- Pagination -->
            @if($applications->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $applications->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </main>
@endsection