@extends('layouts.admin')

@section('content')
    <!-- Premium Glassmorphic Hero -->
    <div class="card card-modern border-0 shadow-lg mb-4 overflow-hidden mx-4 mt-4"
        style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
        <div class="card-body p-4 p-md-5 position-relative">
            <div class="row align-items-center">
                <div class="col-lg-8 position-relative" style="z-index: 2;">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-circle bg-white-20 text-white me-3" style="width: 50px; height: 50px;">
                            <i class="fa fa-file-contract fa-lg"></i>
                        </div>
                        <h1 class="h2 fw-bold text-white mb-0">Detail Analisis AI</h1>
                    </div>
                    <p class="lead text-white-50 mb-0">Laporan mendalam hasil prediksi karier untuk alumni.</p>
                </div>
                <div class="col-lg-4 text-lg-end mt-4 mt-lg-0 position-relative" style="z-index: 2;">
                    <a href="{{ route('admin.prediksi.data') }}"
                        class="btn btn-lg btn-white rounded-pill px-4 shadow-sm hover-scale me-2">
                        <i class="fa fa-chart-line me-2 text-primary"></i> Stats
                    </a>
                    <a href="{{ route('admin.prediksi.data') }}"
                        class="btn btn-lg btn-alt-secondary rounded-pill px-4 shadow-sm hover-scale">
                        <i class="fa fa-arrow-left me-2"></i> Kembali
                    </a>
                </div>
            </div>
            <!-- Decorative Elements -->
            <div class="position-absolute top-0 end-0 p-5 mt-n5 me-n5 opacity-10">
                <i class="fa fa-robot fa-10x text-white"></i>
            </div>
        </div>
    </div>

    <!-- Page Content -->
    <div class="content content-full">
        <div class="row g-4">
            <!-- Sidebar Info -->
            <div class="col-lg-4">
                <div class="card card-modern border-0 shadow-sm h-100 overflow-hidden">
                    <div class="card-header bg-white py-3 px-4 border-bottom">
                        <h5 class="fw-bold mb-0 text-dark">Informasi Alumni</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <div class="avatar-circle-xl bg-primary text-white fs-1 mx-auto mb-3 shadow">
                                {{ substr($history->alumni->nama_lengkap ?? 'A', 0, 1) }}
                            </div>
                            <h4 class="fw-bold text-dark mb-1">
                                {{ $history->alumni->nama_lengkap ?? 'Alumni Tidak Ditemukan' }}</h4>
                            <span class="badge bg-primary-light text-primary rounded-pill px-3 py-1">ID:
                                {{ $history->idAlumni ?? '-' }}</span>
                        </div>

                        <div class="space-y-3 pt-3 border-top">
                            <div class="d-flex align-items-center p-3 rounded-3 bg-light-soft border border-white">
                                <div class="icon-circle-sm bg-info-light text-info me-3">
                                    <i class="fa fa-calendar-alt"></i>
                                </div>
                                <div>
                                    <div class="text-muted small">Tanggal Prediksi</div>
                                    <div class="fw-bold text-dark small">
                                        {{ $history->created_at->translatedFormat('d F Y, H:i') }} WIB</div>
                                </div>
                            </div>

                            <div class="d-flex align-items-center p-3 rounded-3 bg-light-soft border border-white">
                                <div class="icon-circle-sm bg-success-light text-success me-3">
                                    <i class="fa fa-shield-alt"></i>
                                </div>
                                <div>
                                    <div class="text-muted small">Status Verifikasi</div>
                                    <div class="fw-bold text-success small"><i class="fa fa-check-circle me-1"></i> Verified
                                        AI Output</div>
                                </div>
                            </div>
                        </div>

                        @if (!empty($history->extracted_job_titles))
                            <div class="mt-4">
                                <h6 class="text-uppercase text-primary fw-bold fs-xs mb-3 letter-spacing-1">
                                    <i class="fa fa-tags me-2"></i> Job Titles Terdeteksi
                                </h6>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach ($history->extracted_job_titles as $title)
                                        <span
                                            class="badge bg-white text-dark shadow-sm px-3 py-2 border rounded-pill small fst-italic">
                                            <i class="fa fa-medal text-warning me-1"></i> {{ $title }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="col-lg-8">
                <div class="card card-modern border-0 shadow-sm h-100 overflow-hidden">
                    <div
                        class="card-header bg-white py-3 px-4 border-bottom d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0 text-dark">Laporan Analisis AI</h5>
                        <button class="btn btn-sm btn-light rounded-pill px-3" onclick="window.print()">
                            <i class="fa fa-print me-1"></i> Cetak
                        </button>
                    </div>
                    <div class="card-body p-4 p-md-5">
                        <div class="p-4 rounded-4 bg-white border shadow-sm ai-report-container">
                            <div class="ai-content-body fs-sm text-dark px-2" style="line-height: 1.8;">
                                {!! nl2br(e($history->hasil)) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Optional script for print layout
    </script>

    <style>
        .icon-circle.bg-white-20 {
            background: rgba(255, 255, 255, 0.2);
        }

        .avatar-circle-xl {
            width: 80px;
            height: 80px;
            border-radius: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .icon-circle-sm {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .bg-light-soft {
            background-color: #f8fafc;
        }

        .space-y-3>*+* {
            margin-top: 1rem !important;
        }

        .letter-spacing-1 {
            letter-spacing: 1px;
        }

        .ai-content-body {
            white-space: pre-line;
        }

        .ai-report-container {
            max-height: 800px;
            overflow-y: auto;
        }

        @media print {

            .card-header,
            .btn,
            .icon-circle,
            .avatar-circle-xl {
                display: none !important;
            }

            .card {
                border: none !important;
                shadow: none !important;
            }

            .ai-report-container {
                border: none !important;
                max-height: none !important;
            }
        }
    </style>
@endsection