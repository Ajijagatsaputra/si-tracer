@extends('layout')

@section('title', 'Profil Alumni')

@section('content')
<main id="main-container">
    @include('components.navbar')

<style>
    /* Profile Page Custom Premium Styles */
    .profile-container {
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
    }
    
    .profile-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 24px;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.03);
        overflow: hidden;
    }

    .profile-cover {
        height: 180px;
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
        position: relative;
        overflow: hidden;
    }

    .profile-cover::before {
        content: '';
        position: absolute;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(59, 130, 246, 0.12) 0%, transparent 70%);
        top: -100px;
        right: -50px;
        pointer-events: none;
    }

    .profile-avatar-wrapper {
        margin-top: -65px;
        position: relative;
        z-index: 10;
        display: inline-block;
    }

    .profile-avatar {
        width: 130px;
        height: 130px;
        border: 5px solid #ffffff;
        box-shadow: 0 10px 20px -3px rgba(0, 0, 0, 0.12);
        background-color: #ffffff;
        object-fit: cover;
    }

    .profile-status-badge {
        position: absolute;
        bottom: 8px;
        right: 8px;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        border: 3px solid #ffffff;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .status-badge-lulus {
        background-color: #10b981;
        animation: pulse-avatar-green 2s infinite;
    }

    .status-badge-aktif {
        background-color: #3b82f6;
        animation: pulse-avatar-blue 2s infinite;
    }

    @keyframes pulse-avatar-green {
        0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.5); }
        70% { box-shadow: 0 0 0 6px rgba(16, 185, 129, 0); }
        100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
    }

    @keyframes pulse-avatar-blue {
        0% { box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.5); }
        70% { box-shadow: 0 0 0 6px rgba(59, 130, 246, 0); }
        100% { box-shadow: 0 0 0 0 rgba(59, 130, 246, 0); }
    }

    .info-card-item {
        background: #f8fafc;
        border: 1px solid #f1f5f9;
        border-radius: 16px;
        padding: 1.15rem;
        height: 100%;
        transition: all 0.2s ease-in-out;
        display: flex;
        align-items: center;
    }

    .info-card-item:hover {
        background: #ffffff;
        border-color: rgba(59, 130, 246, 0.3);
        transform: translateY(-3px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
    }

    .info-icon-wrapper {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.15rem;
        margin-right: 1.15rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.04);
    }

    .icon-primary { background: rgba(59, 130, 246, 0.08); color: #3b82f6; }
    .icon-success { background: rgba(16, 185, 129, 0.08); color: #10b981; }
    .icon-warning { background: rgba(245, 158, 11, 0.08); color: #f59e0b; }
    .icon-danger { background: rgba(239, 68, 68, 0.08); color: #ef4444; }
    .icon-purple { background: rgba(139, 92, 246, 0.08); color: #8b5cf6; }
    .icon-cyan { background: rgba(6, 182, 212, 0.08); color: #06b6d4; }
    .icon-indigo { background: rgba(79, 70, 229, 0.08); color: #4f46e5; }

    .glow-badge-pill {
        font-size: 0.75rem;
        font-weight: 600;
        padding: 0.35rem 0.85rem;
        border-radius: 50px;
        border: 1px solid transparent;
    }

    .glow-badge-pill-success {
        background: rgba(16, 185, 129, 0.1);
        color: #059669;
        border-color: rgba(16, 185, 129, 0.25);
    }
    
    .glow-badge-pill-blue {
        background: rgba(59, 130, 246, 0.1);
        color: #2563eb;
        border-color: rgba(59, 130, 246, 0.25);
    }

    .btn-edit-premium {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        color: white !important;
        border: none;
        box-shadow: 0 4px 14px rgba(59, 130, 246, 0.3);
        transition: all 0.2s ease;
        padding: 0.6rem 1.5rem;
        font-weight: 600;
    }

    .btn-edit-premium:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(59, 130, 246, 0.45);
    }

    .card-section-title {
        position: relative;
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        color: #1e293b;
        border-bottom: 2px solid #f1f5f9;
    }

    .card-section-title::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 50px;
        height: 2px;
        background: #3b82f6;
    }
</style>

<div class="container py-4 profile-container">
    <div class="row justify-content-center">
        <div class="col-12 col-xl-11">
            
            <!-- Main Profile Header Card -->
            <div class="profile-card mb-4">
                <div class="profile-cover"></div>
                <div class="px-4 pb-4 text-center text-md-start">
                    <div class="row align-items-end">
                        <div class="col-md-auto">
                            <div class="profile-avatar-wrapper">
                                <img src="{{ asset('assets/media/avatars/avatar10.jpg') }}"
                                     class="rounded-circle profile-avatar"
                                     alt="Foto Alumni">
                                <div class="profile-status-badge {{ strtolower($alumni->status_mahasiswa) == 'lulus' ? 'status-badge-lulus' : 'status-badge-aktif' }}"></div>
                            </div>
                        </div>
                        <div class="col-md mt-3 mt-md-0 ps-md-4">
                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center align-items-md-start gap-3">
                                <div>
                                    <h2 class="fw-bold mb-1 text-dark">{{ $alumni->nama_lengkap }}</h2>
                                    <p class="text-muted mb-2 fs-6">
                                        <i class="fas fa-graduation-cap me-1"></i> NIM: <strong>{{ $alumni->nim }}</strong> • {{ $alumni->prodi }}
                                    </p>
                                    <div class="d-flex flex-wrap justify-content-center justify-content-md-start gap-2">
                                        <span class="badge glow-badge-pill {{ strtolower($alumni->status_mahasiswa) == 'lulus' ? 'glow-badge-pill-success' : 'glow-badge-pill-blue' }}">
                                            Status: {{ $alumni->status_mahasiswa }}
                                        </span>
                                        <span class="badge glow-badge-pill bg-light text-muted border">
                                            {{ $tahunAjaran ?? '2024/2025 - Genap' }}
                                        </span>
                                        <span class="badge glow-badge-pill bg-light text-muted border">
                                            Semester {{ $semester ?? '8' }}
                                        </span>
                                    </div>
                                </div>
                                <div class="text-center text-md-end mt-2 mt-md-0">
                                    <button class="btn btn-edit-premium rounded-pill d-inline-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                                        <i class="fas fa-user-edit"></i> Edit Data Diri
                                    </button>
                                    <div class="text-muted small mt-2">
                                        Terakhir diperbarui: {{ $alumni->updated_at->format('d M Y H:i') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Details Section -->
            <div class="row g-4">
                <!-- Data Akademik Column -->
                <div class="col-12 col-md-6">
                    <div class="profile-card p-4 h-100 bg-white">
                        <h5 class="card-section-title">
                            <i class="fas fa-university text-primary me-2"></i> Data Akademik & Perkuliahan
                        </h5>
                        
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="info-card-item">
                                    <div class="info-icon-wrapper icon-primary">
                                        <i class="fas fa-id-card"></i>
                                    </div>
                                    <div>
                                        <span class="text-muted small d-block">Nomor Induk Mahasiswa (NIM)</span>
                                        <span class="fw-bold text-dark fs-5">{{ $alumni->nim }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="info-card-item">
                                    <div class="info-icon-wrapper icon-purple">
                                        <i class="fas fa-graduation-cap"></i>
                                    </div>
                                    <div>
                                        <span class="text-muted small d-block">Program Studi</span>
                                        <span class="fw-bold text-dark">{{ $alumni->prodi ?: '-' }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-sm-6">
                                <div class="info-card-item">
                                    <div class="info-icon-wrapper icon-cyan">
                                        <i class="fas fa-school"></i>
                                    </div>
                                    <div>
                                        <span class="text-muted small d-block">Kelas</span>
                                        <span class="fw-bold text-dark">{{ $alumni->kelas ?: '-' }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-sm-6">
                                <div class="info-card-item">
                                    <div class="info-icon-wrapper icon-warning">
                                        <i class="fas fa-route"></i>
                                    </div>
                                    <div>
                                        <span class="text-muted small d-block">Jalur Masuk</span>
                                        <span class="fw-bold text-dark">{{ $alumni->jalur ?: '-' }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-sm-6">
                                <div class="info-card-item">
                                    <div class="info-icon-wrapper icon-indigo">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                    <div>
                                        <span class="text-muted small d-block">Tahun Masuk</span>
                                        <span class="fw-bold text-dark">{{ $alumni->tahun_masuk ?: '-' }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-sm-6">
                                <div class="info-card-item">
                                    <div class="info-icon-wrapper icon-success">
                                        <i class="fas fa-calendar-check"></i>
                                    </div>
                                    <div>
                                        <span class="text-muted small d-block">Tahun Lulus</span>
                                        <span class="fw-bold text-dark">{{ $alumni->tahun_lulus ?: '-' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kontak & Alamat Column -->
                <div class="col-12 col-md-6">
                    <div class="profile-card p-4 h-100 bg-white">
                        <h5 class="card-section-title">
                            <i class="fas fa-address-book text-success me-2"></i> Kontak & Informasi Pendukung
                        </h5>
                        
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="info-card-item">
                                    <div class="info-icon-wrapper icon-success">
                                        <i class="fas fa-phone-alt"></i>
                                    </div>
                                    <div>
                                        <span class="text-muted small d-block">No. Telepon / WhatsApp</span>
                                        <span class="fw-bold text-dark fs-5">{{ $alumni->no_hp ?: '-' }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="info-card-item">
                                    <div class="info-icon-wrapper icon-primary">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <div>
                                        <span class="text-muted small d-block">Alamat Email Terdaftar</span>
                                        <span class="fw-bold text-dark">{{ auth()->user()->email }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="info-card-item" style="align-items: flex-start;">
                                    <div class="info-icon-wrapper icon-danger mt-1">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <span class="text-muted small d-block">Alamat Domisili</span>
                                        <span class="fw-bold text-dark d-block mt-1" style="line-height: 1.5;">{{ $alumni->alamat ?: 'Alamat belum diisi.' }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="info-card-item">
                                    <div class="info-icon-wrapper icon-cyan">
                                        <i class="fas fa-user-tag"></i>
                                    </div>
                                    <div>
                                        <span class="text-muted small d-block">Status Keanggotaan</span>
                                        <span class="fw-bold text-dark">Alumni TI Universitas Harkat Negeri</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@include('components.modal-edit-profile-alumni')

</main>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Layout auto adjustment is handled gracefully by main layout
    });
</script>
@endpush
