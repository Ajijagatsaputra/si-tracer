@extends('layout')

@section('title', 'Curriculum Vitae - ' . $alumni->nama_lengkap)

@section('content')
    <!-- Navbar untuk Alumni -->
    @include('components.navbar')

    <div class="container py-4 mb-5">
        <!-- Action Header (Hide on Print) -->
        <div class="d-flex justify-content-between align-items-center mb-4 no-print">
            <div>
                <a href="{{ route('profile') }}" class="btn btn-sm btn-alt-secondary rounded-pill">
                    <i class="fa fa-arrow-left me-1"></i> Kembali ke Profil
                </a>
            </div>
            <div class="d-flex gap-2">
                <button onclick="window.print();" class="btn btn-primary rounded-pill shadow-sm">
                    <i class="fa fa-print me-1"></i> Cetak / Simpan PDF
                </button>
            </div>
        </div>

        @if (!$tracer)
            <!-- Warning Banner if Tracer Study is not completed (Hide on Print) -->
            <div class="alert alert-warning border-0 shadow-sm rounded-4 mb-4 no-print" role="alert">
                <div class="d-flex">
                    <i class="fa fa-exclamation-triangle fa-2x me-3 mt-1"></i>
                    <div>
                        <h5 class="alert-heading fw-bold mb-1">Kuesioner Tracer Study Belum Lengkap</h5>
                        <p class="mb-2 small">
                            Lengkapi kuesioner Tracer Study Anda untuk mengisi riwayat pekerjaan, kompetensi, dan evaluasi pendidikan pada CV otomatis ini secara lengkap.
                        </p>
                        <a href="/kuesioner" class="btn btn-sm btn-warning rounded-pill">Isi Tracer Study Sekarang</a>
                    </div>
                </div>
            </div>
        @endif

        <!-- CV Document Paper -->
        <div class="cv-paper bg-white shadow-lg mx-auto p-5 rounded-3 border" id="printable-cv">
            <!-- Header Section -->
            <div class="border-bottom pb-4 mb-4 text-center text-md-start">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h1 class="fw-bold text-dark mb-1 tracking-tight" style="font-size: 2.2rem;">{{ strtoupper($alumni->nama_lengkap) }}</h1>
                        <h5 class="text-primary fw-medium mb-3">Lulusan Teknik Informatika</h5>
                        <p class="text-muted small mb-0">
                            NIM: {{ $alumni->nim }} &bull; Program Studi: {{ $alumni->prodi }}
                        </p>
                    </div>
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        <div class="text-muted small space-y-1">
                            <div><i class="fa fa-envelope me-2 text-primary"></i>{{ Auth::user()->email }}</div>
                            <div><i class="fa fa-phone me-2 text-primary"></i>{{ $alumni->no_hp ?: '-' }}</div>
                            <div><i class="fa fa-map-marker-alt me-2 text-primary"></i>{{ $alumni->alamat ?: '-' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Summary -->
            <div class="mb-4 pb-2">
                <h5 class="fw-bold text-dark border-bottom pb-2 mb-3 text-uppercase tracking-wider" style="font-size: 0.95rem; border-color: #cbd5e1 !important;">
                    Tentang Saya
                </h5>
                <p class="text-secondary mb-0 text-justify" style="line-height: 1.6; font-size: 0.9rem;">
                    Lulusan Program Studi Teknik Informatika Universitas Harkat Negeri angkatan {{ $alumni->tahun_masuk ?? '-' }} - {{ $alumni->tahun_lulus ?? '-' }}. Memiliki komitmen tinggi terhadap pengembangan profesionalitas di bidang teknologi informasi. Telah dibekali keterampilan teoritis dan praktis di bangku kuliah serta memiliki adaptabilitas tinggi terhadap ekosistem industri digital.
                    @if (!empty($rekomendasiKarir))
                        Berdasarkan analisis akademik dan rekomendasi kecerdasan buatan (AI), saya memiliki kecocokan karir yang kuat di bidang <strong>{{ implode(', ', $rekomendasiKarir) }}</strong>.
                    @endif
                </p>
            </div>

            <div class="row g-4">
                <!-- Left Side: Education & Experience -->
                <div class="col-md-7 border-md-end" style="border-color: #e2e8f0 !important;">
                    <!-- Education -->
                    <div class="mb-4">
                        <h5 class="fw-bold text-dark border-bottom pb-2 mb-3 text-uppercase tracking-wider" style="font-size: 0.95rem; border-color: #cbd5e1 !important;">
                            Riwayat Pendidikan
                        </h5>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <h6 class="fw-bold text-dark mb-0">Universitas Harkat Negeri</h6>
                                <span class="badge bg-secondary-light text-secondary rounded-pill px-2 py-1 fs-xs">{{ $alumni->tahun_masuk ?? '-' }} - {{ $alumni->tahun_lulus ?? '-' }}</span>
                            </div>
                            <p class="text-muted small mb-1">Sarjana Komputer (S1) - Teknik Informatika</p>
                            @if ($ipk)
                                <p class="mb-0 text-dark small">
                                    <strong>Indeks Prestasi Kumulatif (IPK):</strong> {{ number_format($ipk, 2) }} / 4.00
                                    <span class="text-muted">({{ $totalSks }} SKS diselesaikan)</span>
                                </p>
                            @endif
                        </div>
                    </div>

                    <!-- Work Experience -->
                    <div class="mb-4">
                        <h5 class="fw-bold text-dark border-bottom pb-2 mb-3 text-uppercase tracking-wider" style="font-size: 0.95rem; border-color: #cbd5e1 !important;">
                            Pengalaman Kerja / Usaha
                        </h5>
                        @if ($tracer)
                            @if ($tracer->status_pekerjaan === 'Bekerja' && $tracer->pekerjaan)
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <h6 class="fw-bold text-dark mb-0">{{ $tracer->pekerjaan->jabatan }}</h6>
                                        <span class="text-muted small">{{ $tracer->pekerjaan->bulan_kerja ? $tracer->pekerjaan->bulan_kerja . ' Bulan' : 'Bekerja' }}</span>
                                    </div>
                                    <p class="text-primary small mb-1">{{ $tracer->pekerjaan->nama_perusahaan }}</p>
                                    <p class="text-muted small mb-2"><i class="fa fa-map-marker-alt me-1"></i>{{ $tracer->pekerjaan->kota ?? '' }}, {{ $tracer->pekerjaan->provinsi ?? '' }}</p>
                                    <p class="mb-0 text-secondary text-justify" style="font-size: 0.85rem;">
                                        Menjabat sebagai {{ $tracer->pekerjaan->jabatan }} dengan korelasi keilmuan yang erat terhadap bidang Teknik Informatika. Bertanggung jawab dalam eksekusi tugas divisi untuk menyokong performa bisnis perusahaan.
                                    </p>
                                </div>
                            @elseif ($tracer->status_pekerjaan === 'Wirausaha' && $tracer->wirausaha)
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <h6 class="fw-bold text-dark mb-0">{{ $tracer->wirausaha->posisi_usaha }}</h6>
                                        <span class="badge bg-success-light text-success rounded-pill px-2 py-1 fs-xs">Wirausaha</span>
                                    </div>
                                    <p class="text-primary small mb-1">{{ $tracer->wirausaha->nama_usaha }}</p>
                                    <p class="text-muted small mb-2"><i class="fa fa-map-marker-alt me-1"></i>{{ $tracer->wirausaha->alamat_usaha }}</p>
                                    <p class="mb-0 text-secondary text-justify" style="font-size: 0.85rem;">
                                        Mengembangkan dan mengelola usaha {{ $tracer->wirausaha->nama_usaha }} secara mandiri dengan tingkat keterkaitan bidang studi yang relevan.
                                    </p>
                                </div>
                            @elseif ($tracer->status_pekerjaan === 'Lanjut Studi' && $tracer->pendidikan)
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <h6 class="fw-bold text-dark mb-0">Mahasiswa Pascasarjana</h6>
                                        <span class="badge bg-info-light text-info rounded-pill px-2 py-1 fs-xs">Studi Lanjut</span>
                                    </div>
                                    <p class="text-primary small mb-1">{{ $tracer->pendidikan->universitas }}</p>
                                    <p class="text-muted small mb-2">Program Studi: {{ $tracer->pendidikan->program_studi }}</p>
                                    <p class="mb-0 text-secondary text-justify" style="font-size: 0.85rem;">
                                        Melanjutkan jenjang pendidikan tinggi pascasarjana di {{ $tracer->pendidikan->universitas }} dibiayai oleh {{ $tracer->pendidikan->sumber_biaya }}.
                                    </p>
                                </div>
                            @else
                                <div class="text-center py-4 bg-light rounded-4">
                                    <p class="text-muted mb-0 small">Sedang mempersiapkan karir profesional / mencari peluang kerja.</p>
                                </div>
                            @endif
                        @else
                            <div class="text-center py-4 bg-light rounded-4">
                                <p class="text-muted mb-0 small">Belum menginputkan riwayat pekerjaan pada kuesioner Tracer Study.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Right Side: Skills & AI Career Matches -->
                <div class="col-md-5">
                    <!-- Competencies -->
                    <div class="mb-4">
                        <h5 class="fw-bold text-dark border-bottom pb-2 mb-3 text-uppercase tracking-wider" style="font-size: 0.95rem; border-color: #cbd5e1 !important;">
                            Kompetensi Mandiri
                        </h5>
                        @if ($tracer && $tracer->kompetensi)
                            <div class="space-y-3">
                                @php
                                    $skills = [
                                        ['label' => 'Keahlian Bidang (Hard Skill)', 'val' => $tracer->kompetensi->keahlian_sekarang],
                                        ['label' => 'Penggunaan Teknologi', 'val' => $tracer->kompetensi->teknologi_sekarang],
                                        ['label' => 'Kerjasama Tim', 'val' => $tracer->kompetensi->kerjasama_sekarang],
                                        ['label' => 'Komunikasi', 'val' => $tracer->kompetensi->komunikasi_sekarang],
                                        ['label' => 'Pengembangan Diri', 'val' => $tracer->kompetensi->pengembangan_sekarang],
                                        ['label' => 'Bahasa Inggris', 'val' => $tracer->kompetensi->bahasa_inggris_sekarang],
                                        ['label' => 'Etika & Profesionalisme', 'val' => $tracer->kompetensi->etika_sekarang]
                                    ];
                                @endphp
                                @foreach ($skills as $s)
                                    <div class="mb-2">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <span class="text-dark small" style="font-weight: 500;">{{ $s['label'] }}</span>
                                            <span class="text-muted small" style="font-size: 0.75rem;">{{ $s['val'] }}/5</span>
                                        </div>
                                        <div class="progress rounded-pill bg-light" style="height: 6px;">
                                            <div class="progress-bar bg-primary rounded-pill" style="width: {{ ($s['val'] / 5) * 100 }}%"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4 bg-light rounded-4">
                                <p class="text-muted mb-0 small">Isi data kompetensi pada kuesioner Tracer Study untuk memetakan grafik keahlian.</p>
                            </div>
                        @endif
                    </div>

                    <!-- AI Career Matches -->
                    <div class="mb-4">
                        <h5 class="fw-bold text-dark border-bottom pb-2 mb-3 text-uppercase tracking-wider" style="font-size: 0.95rem; border-color: #cbd5e1 !important;">
                            Rekomendasi Profesi (AI)
                        </h5>
                        @if (!empty($rekomendasiKarir))
                            <div class="d-flex flex-wrap gap-2">
                                @foreach ($rekomendasiKarir as $r)
                                    <span class="badge bg-primary text-white rounded-pill px-3 py-2 fs-xs font-semibold shadow-sm">
                                        <i class="fa fa-check-circle me-1"></i> {{ $r }}
                                    </span>
                                @endforeach
                            </div>
                            <p class="text-muted small mt-2 mb-0" style="font-size: 0.75rem; line-height: 1.4;">
                                *Rekomendasi karir dipetakan secara cerdas berdasarkan klasterisasi rata-rata nilai mata kuliah akademik.
                            </p>
                        @else
                            <div class="text-center py-4 bg-light rounded-4">
                                <p class="text-muted mb-0 small">Belum ada hasil analisis prediksi karir AI. Silakan lakukan prediksi transkrip nilai terlebih dahulu.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .bg-primary-light { background-color: rgba(59, 130, 246, 0.08); }
        .bg-success-light { background-color: rgba(16, 185, 129, 0.08); }
        .bg-info-light { background-color: rgba(6, 182, 212, 0.08); }
        .bg-secondary-light { background-color: rgba(108, 117, 125, 0.08); }

        /* CV Paper Styling for preview */
        .cv-paper {
            max-width: 800px;
            min-height: 1000px;
            background: #fff;
            color: #1e293b;
            font-family: 'Inter', sans-serif;
            box-sizing: border-box;
            border: 1px solid #cbd5e1;
        }

        .text-justify {
            text-align: justify;
        }

        /* Printable media styling */
        @media print {
            /* Hide topbar, sidebar, footer, buttons */
            #page-header,
            #page-footer,
            .no-print,
            .navbar,
            footer {
                display: none !important;
            }

            body {
                background: #white !important;
                color: #000 !important;
                font-family: 'Inter', sans-serif !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            #page-container {
                padding: 0 !important;
                margin: 0 !important;
                background: #fff !important;
            }

            .container {
                max-width: 100% !important;
                width: 100% !important;
                padding: 0 !important;
                margin: 0 !important;
            }

            .cv-paper {
                box-shadow: none !important;
                border: none !important;
                padding: 0 !important;
                margin: 0 !important;
                width: 100% !important;
                max-width: 100% !important;
                min-height: auto !important;
            }

            /* Adjust borders and columns for print layout */
            .border-md-end {
                border-right: 1px solid #cbd5e1 !important;
            }
        }
    </style>
@endsection
