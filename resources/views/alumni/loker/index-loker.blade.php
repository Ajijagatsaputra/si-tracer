@extends('layout')

@section('title', 'Bursa Kerja Alumni - SIKEMA')

@push('styles')
    <style>
        .loker-card {
            background: #ffffff;
            border: 1px solid rgba(0, 0, 0, 0.05);
            border-radius: 16px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .loker-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.05);
            border-color: rgba(79, 70, 229, 0.15);
        }

        .loker-logo-placeholder {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: rgba(79, 70, 229, 0.08);
            color: #4f46e5;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .loker-logo-img {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            object-fit: cover;
            border: 1px solid #f1f5f9;
        }

        .badge-category {
            background: rgba(79, 70, 229, 0.08);
            color: #4f46e5;
            font-weight: 600;
            font-size: 0.75rem;
            padding: 6px 12px;
            border-radius: 50px;
        }

        .modal-banner-top {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            color: #ffffff;
            padding: 24px;
            position: relative;
        }

        .modal-banner-top::before {
            content: '';
            position: absolute;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(79, 70, 229, 0.15) 0%, transparent 70%);
            top: -50px;
            right: -50px;
        }

        .detail-section-title {
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #4f46e5;
            border-bottom: 2px solid rgba(79, 70, 229, 0.1);
            padding-bottom: 6px;
            margin-bottom: 12px;
        }
    </style>
@endpush

@section('content')
    <main class="main">
        @include('components.navbar')

        <div class="container py-4 content">
            <!-- Page Header -->
            <div
                class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-alt mb-1">
                            <li class="breadcrumb-item">
                                <a class="link-fx" href="/">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Bursa Kerja</li>
                        </ol>
                    </nav>
                    <h2 class="h3 fw-extrabold text-dark mb-0">Bursa Kerja & Karir Alumni</h2>
                </div>
            </div>

            <!-- Search & Filter Area -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-3">
                    <form action="{{ route('alumni.loker.index') }}" method="GET">
                        <div class="row g-2">
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-text bg-transparent border-end-0 text-muted"><i
                                            class="fa fa-search"></i></span>
                                    <input type="text" name="search" class="form-control border-start-0"
                                        placeholder="Cari posisi, perusahaan, atau lokasi..."
                                        value="{{ request('search') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <select name="category" class="form-select">
                                    <option value="">Semua Kategori Bidang</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary w-100 rounded-pill"><i
                                        class="fa fa-filter me-1"></i> Terapkan Filter</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Job Grid -->
            <div class="row g-4">
                @forelse($jobs as $job)
                    <div class="col-lg-4 col-md-6">
                        <div class="loker-card p-4 d-flex flex-column justify-content-between h-100 shadow-xs">
                            <div>
                                <!-- Header Card: Category & Logo -->
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <span class="badge-category">{{ $job->category }}</span>
                                    @if($job->logo_path)
                                        <img src="{{ $job->logo_path }}" class="loker-logo-img" alt="Logo {{ $job->company_name }}">
                                    @else
                                        <div class="loker-logo-placeholder">
                                            {{ substr($job->company_name, 0, 2) }}
                                        </div>
                                    @endif
                                </div>

                                <!-- Position & Company -->
                                <h4 class="fw-bold text-dark mb-1 h5">{{ $job->position }}</h4>
                                <h6 class="text-muted fw-semibold mb-3"><i class="fa fa-building me-1"></i>
                                    {{ $job->company_name }}</h6>

                                <!-- Short Details -->
                                <div class="d-flex flex-column gap-2 mb-4 text-muted small">
                                    <span><i class="fa fa-map-marker-alt text-danger me-1"></i> {{ $job->location }}</span>
                                    @if($job->salary_range)
                                        <span><i class="fa fa-money-bill-wave text-success me-1"></i>
                                            {{ $job->salary_range }}</span>
                                    @endif
                                    <span><i class="fa fa-clock me-1"></i> Diunggah
                                        {{ $job->created_at->diffForHumans() }}</span>
                                </div>
                            </div>

                            <!-- Action Button -->
                            <button type="button"
                                class="btn btn-alt-primary btn-sm rounded-pill w-100 fw-bold py-2 btn-detail-loker"
                                data-id="{{ $job->id }}">
                                Lihat Detail Karir <i class="fa fa-arrow-right ms-1"></i>
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <div class="text-muted card border-0 shadow-sm p-5 rounded-4">
                            <i class="fa fa-briefcase fs-1 mb-3 text-secondary"></i>
                            <h4 class="fw-bold text-dark">Belum Ada Lowongan Kerja</h4>
                            <p class="mb-0">Mohon maaf, tidak ditemukan lowongan kerja yang cocok dengan filter pencarian Anda
                                saat ini.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-5">
                {{ $jobs->appends(request()->query())->links() }}
            </div>
        </div>
    </main>

    <!-- Job Detail Modal -->
    <div class="modal fade" id="modalDetailLoker" tabindex="-1" aria-labelledby="modalDetailLokerLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 overflow-hidden rounded-4">

                <!-- Banner Header -->
                <div class="modal-banner-top">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="badge bg-primary text-white rounded-pill px-3 py-1.5 fs-xs fw-bold"
                            id="detail-category">Category</span>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <h3 class="fw-extrabold text-white mb-1" id="detail-position">Position Title</h3>
                    <p class="text-white-50 mb-0 fw-semibold" id="detail-company-name"><i class="fa fa-building me-1"></i>
                        Company Name</p>
                </div>

                <!-- Content Body -->
                <div class="modal-body p-4 bg-light/30">
                    <div class="row g-4">

                        <!-- Quick Info Columns -->
                        <div class="col-md-6">
                            <div class="p-3 bg-white border border-light shadow-xs rounded-3 h-100">
                                <span class="text-muted text-uppercase fw-bold d-block mb-1"
                                    style="font-size: 0.65rem; letter-spacing: 1px;">Lokasi Penempatan</span>
                                <span class="fw-bold text-dark" id="detail-location"><i
                                        class="fa fa-map-marker-alt text-danger me-1"></i> Location</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 bg-white border border-light shadow-xs rounded-3 h-100">
                                <span class="text-muted text-uppercase fw-bold d-block mb-1"
                                    style="font-size: 0.65rem; letter-spacing: 1px;">Rentang Gaji</span>
                                <span class="fw-bold text-dark" id="detail-salary"><i
                                        class="fa fa-money-bill-wave text-success me-1"></i> Salary</span>
                            </div>
                        </div>

                        <!-- Job Description -->
                        <div class="col-12">
                            <div class="p-4 bg-white border border-light shadow-xs rounded-4">
                                <h5 class="detail-section-title"><i class="fa fa-align-left me-1"></i> Deskripsi Pekerjaan
                                </h5>
                                <div class="text-dark fs-sm" id="detail-description"
                                    style="line-height: 1.6; white-space: pre-line;">
                                    Description text here...
                                </div>
                            </div>
                        </div>

                        <!-- Job Requirements -->
                        <div class="col-12">
                            <div class="p-4 bg-white border border-light shadow-xs rounded-4">
                                <h5 class="detail-section-title"><i class="fa fa-list-check me-1"></i> Kualifikasi &
                                    Persyaratan</h5>
                                <div class="text-dark fs-sm" id="detail-requirements"
                                    style="line-height: 1.6; white-space: pre-line;">
                                    Requirements text here...
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Action -->
                <div class="modal-footer bg-light border-top p-3 justify-content-between">
                    <div class="small text-muted" id="detail-uploaded-time">
                        Diunggah: -
                    </div>
                    <div class="d-flex gap-2">
                        <a href="#" class="btn btn-primary rounded-pill px-4" id="detail-btn-apply" target="_blank"><i
                                class="fa fa-paper-plane me-1"></i> Lamar Sekarang</a>
                        <button type="button" class="btn btn-secondary rounded-pill px-4"
                            data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('.btn-detail-loker').on('click', function () {
                var id = $(this).data('id');
                var url = "{{ route('alumni.loker.show', ':id') }}".replace(':id', id);

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function (job) {
                        // Inject data into modal elements
                        $('#detail-category').text(job.category);
                        $('#detail-position').text(job.position);
                        $('#detail-company-name').html('<i class="fa fa-building me-1"></i> ' + job.company_name);
                        $('#detail-location').html('<i class="fa fa-map-marker-alt text-danger me-1"></i> ' + job.location);
                        $('#detail-salary').html('<i class="fa fa-money-bill-wave text-success me-1"></i> ' + (job.salary_range ? job.salary_range : '-'));
                        $('#detail-description').text(job.description);
                        $('#detail-requirements').text(job.requirements);

                        var date = new Date(job.created_at);
                        $('#detail-uploaded-time').text('Diunggah: ' + date.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }));

                        // Set up Apply Button
                        if (job.contact_link) {
                            $('#detail-btn-apply').attr('href', job.contact_link).show();
                        } else if (job.contact_email) {
                            $('#detail-btn-apply').attr('href', 'mailto:' + job.contact_email + '?subject=Lamaran Pekerjaan: ' + encodeURIComponent(job.position)).show();
                        } else {
                            $('#detail-btn-apply').hide();
                        }

                        // Open modal
                        var myModal = new bootstrap.Modal(document.getElementById('modalDetailLoker'));
                        myModal.show();
                    },
                    error: function (err) {
                        alert('Gagal mengambil detail lowongan pekerjaan.');
                    }
                });
            });
        });
    </script>
@endpush