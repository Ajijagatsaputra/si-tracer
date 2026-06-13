@extends('layouts.admin')

@section('content')
    <!-- Hero -->
    <div class="bg-white">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-2">
                        <span class="bg-primary-lighter p-2 rounded-3 me-2">
                            <i class="fa fa-briefcase text-primary"></i>
                        </span>
                        Moderasi Bursa Kerja
                    </h1>
                    <p class="fs-sm fw-medium text-muted mb-0">
                        Kelola dan validasi lowongan pekerjaan yang diunggah oleh mitra perusahaan.
                    </p>
                </div>
                <div class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3">
                    <a href="{{ route('admin.loker.create') }}" class="btn btn-primary rounded-pill px-4 fw-bold">
                        <i class="fa fa-plus-circle me-1"></i> Tambah Loker Baru
                    </a>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ route('admin.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Kelola Loker</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="content">

        <!-- Filter Card -->
        <div class="block block-rounded block-mode-loading-oneui shadow-sm mb-4">
            <div class="block-content block-content-full">
                <form action="{{ route('admin.loker.index') }}" method="GET" id="filter-form">
                    <div class="row g-2">
                        <div class="col-md-5">
                            <input type="text" name="search" class="form-control"
                                placeholder="Cari posisi atau nama perusahaan..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-4">
                            <select name="status" class="form-select" onchange="this.form.submit()">
                                <option value="">Semua Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu
                                    Persetujuan (Pending)</option>
                                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui
                                    (Approved)</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak
                                    (Rejected)</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary w-100"><i class="fa fa-search me-1"></i>
                                Cari</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Table Card -->
        <div class="block block-rounded shadow-sm">
            <div class="block-content block-content-full">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-vcenter">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 50px;">No</th>
                                <th>Perusahaan</th>
                                <th>Posisi</th>
                                <th>Pengunggah (PIC)</th>
                                <th>Kategori</th>
                                <th>Lokasi</th>
                                <th class="text-center">Status</th>
                                <th class="text-center" style="width: 150px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($jobs as $index => $job)
                                <tr>
                                    <td class="text-center">{{ ($jobs->currentPage() - 1) * $jobs->perPage() + $index + 1 }}
                                    </td>
                                    <td class="fw-semibold">
                                        <div class="d-flex align-items-center gap-2">
                                            @if($job->logo_path)
                                                <img src="{{ $job->logo_path }}" alt="Logo" class="rounded"
                                                    style="width: 32px; height: 32px; object-fit: cover;">
                                            @else
                                                <div class="bg-primary-lighter text-primary rounded d-flex align-items-center justify-content-center fw-bold"
                                                    style="width: 32px; height: 32px; font-size: 0.8rem;">
                                                    {{ substr($job->company_name, 0, 2) }}
                                                </div>
                                            @endif
                                            <span>{{ $job->company_name }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $job->position }}</td>
                                    <td>
                                        @if($job->pic_name)
                                            <div class="small">
                                                <div class="fw-semibold text-dark">{{ $job->pic_name }}</div>
                                                @if($job->pic_position)
                                                    <div class="text-muted">{{ $job->pic_position }}</div>
                                                @endif
                                                <div><i class="fa fa-envelope text-muted me-1"
                                                        style="font-size:0.7rem;"></i>{{ $job->pic_email }}</div>
                                                <div><i class="fa fa-phone text-muted me-1"
                                                        style="font-size:0.7rem;"></i>{{ $job->pic_phone }}</div>
                                            </div>
                                        @else
                                            <span class="text-muted small fst-italic">Admin Upload</span>
                                        @endif
                                    </td>
                                    <td><span class="badge bg-primary-lighter text-primary">{{ $job->category }}</span></td>
                                    <td>{{ $job->location }}</td>
                                    <td class="text-center">
                                        @if($job->status === 'pending')
                                            <span class="badge bg-warning"><i class="fa fa-clock me-1"></i> Pending</span>
                                        @elseif($job->status === 'approved')
                                            <span class="badge bg-success"><i class="fa fa-check me-1"></i> Approved</span>
                                        @else
                                            <span class="badge bg-danger"><i class="fa fa-times me-1"></i> Rejected</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <!-- View Detail Button -->
                                            <button type="button" class="btn btn-sm btn-alt-info btn-view-detail"
                                                data-id="{{ $job->id }}" title="Lihat Detail">
                                                <i class="fa fa-eye"></i>
                                            </button>

                                            <!-- Edit Button -->
                                            <a href="{{ route('admin.loker.edit', $job->id) }}"
                                                class="btn btn-sm btn-alt-warning" title="Edit Lowongan">
                                                <i class="fa fa-pencil-alt"></i>
                                            </a>

                                            @if($job->status === 'pending')
                                                <!-- Approve Button -->
                                                <button type="button" class="btn btn-sm btn-alt-success btn-approve"
                                                    data-id="{{ $job->id }}" title="Setujui">
                                                    <i class="fa fa-check"></i>
                                                </button>
                                                <!-- Reject Button -->
                                                <button type="button" class="btn btn-sm btn-alt-danger btn-reject"
                                                    data-id="{{ $job->id }}" title="Tolak">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            @endif

                                            <!-- Delete Button -->
                                            <button type="button" class="btn btn-sm btn-alt-danger btn-delete"
                                                data-id="{{ $job->id }}" title="Hapus">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center text-muted py-4">Belum ada data lowongan pekerjaan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="fs-sm text-muted">
                        Menampilkan {{ $jobs->firstItem() ?? 0 }} sampai {{ $jobs->lastItem() ?? 0 }} dari
                        {{ $jobs->total() }} data
                    </div>
                    {{ $jobs->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Job Detail Modal (Admin) -->
    <div class="modal fade" id="modalAdminDetailLoker" tabindex="-1" aria-labelledby="modalAdminDetailLokerLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 overflow-hidden rounded-4">
                <div class="modal-header bg-dark text-white p-3">
                    <h5 class="modal-title fw-bold text-white"><i class="fa fa-briefcase me-2"></i> Detail Lowongan
                        Pekerjaan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 bg-light/30">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="p-3 bg-white border border-light shadow-xs rounded-3">
                                <span class="text-muted text-uppercase fw-bold d-block mb-1"
                                    style="font-size: 0.65rem;">Nama Perusahaan</span>
                                <span class="fw-bold text-dark" id="modal-company-name">-</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 bg-white border border-light shadow-xs rounded-3">
                                <span class="text-muted text-uppercase fw-bold d-block mb-1"
                                    style="font-size: 0.65rem;">Posisi Jabatan</span>
                                <span class="fw-bold text-dark" id="modal-position">-</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 bg-white border border-light shadow-xs rounded-3">
                                <span class="text-muted text-uppercase fw-bold d-block mb-1"
                                    style="font-size: 0.65rem;">Kategori Bidang</span>
                                <span class="fw-bold text-dark" id="modal-category">-</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 bg-white border border-light shadow-xs rounded-3">
                                <span class="text-muted text-uppercase fw-bold d-block mb-1"
                                    style="font-size: 0.65rem;">Lokasi</span>
                                <span class="fw-bold text-dark" id="modal-location">-</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 bg-white border border-light shadow-xs rounded-3">
                                <span class="text-muted text-uppercase fw-bold d-block mb-1"
                                    style="font-size: 0.65rem;">Gaji</span>
                                <span class="fw-bold text-dark" id="modal-salary">-</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 bg-white border border-light shadow-xs rounded-3">
                                <span class="text-muted text-uppercase fw-bold d-block mb-1"
                                    style="font-size: 0.65rem;">Email Pendaftaran</span>
                                <span class="fw-bold text-dark" id="modal-contact-email">-</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 bg-white border border-light shadow-xs rounded-3">
                                <span class="text-muted text-uppercase fw-bold d-block mb-1"
                                    style="font-size: 0.65rem;">Link Pendaftaran</span>
                                <span class="fw-bold text-dark" id="modal-contact-link">-</span>
                            </div>
                        </div>

                        <!-- PIC Info Section -->
                        <div class="col-12" id="modal-pic-container" style="display: none;">
                            <div class="p-3 bg-warning-light border border-warning rounded-3"
                                style="background-color: rgba(255,193,7,0.08);">
                                <span class="text-muted text-uppercase fw-bold d-block mb-2" style="font-size: 0.65rem;">
                                    <i class="fa fa-user-tie me-1"></i> Penanggung Jawab (PIC Pengunggah)
                                </span>
                                <div class="row g-2">
                                    <div class="col-md-6"><span class="small text-muted">Nama:</span> <span
                                            class="fw-bold text-dark d-block" id="modal-pic-name">-</span></div>
                                    <div class="col-md-6"><span class="small text-muted">Jabatan:</span> <span
                                            class="fw-bold text-dark d-block" id="modal-pic-position">-</span></div>
                                    <div class="col-md-6"><span class="small text-muted">Email:</span> <span
                                            class="fw-bold text-dark d-block" id="modal-pic-email">-</span></div>
                                    <div class="col-md-6"><span class="small text-muted">No. HP:</span> <span
                                            class="fw-bold text-dark d-block" id="modal-pic-phone">-</span></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="p-3 bg-white border border-light shadow-xs rounded-3">
                                <span class="text-muted text-uppercase fw-bold d-block mb-2"
                                    style="font-size: 0.65rem;">Deskripsi Pekerjaan</span>
                                <div class="text-dark fs-sm" id="modal-description"
                                    style="white-space: pre-line; line-height: 1.6;">-</div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="p-3 bg-white border border-light shadow-xs rounded-3">
                                <span class="text-muted text-uppercase fw-bold d-block mb-2"
                                    style="font-size: 0.65rem;">Kualifikasi / Persyaratan</span>
                                <div class="text-dark fs-sm" id="modal-requirements"
                                    style="white-space: pre-line; line-height: 1.6;">-</div>
                            </div>
                        </div>

                        <div class="col-12" id="modal-poster-container" style="display: none;">
                            <div class="p-3 bg-white border border-light shadow-xs rounded-3 text-center">
                                <span class="text-muted text-uppercase fw-bold d-block mb-2 text-start"
                                    style="font-size: 0.65rem;">Poster / Brosur Lowongan</span>

                                <div id="carouselAdminPosters" class="carousel slide carousel-dark" data-bs-ride="carousel">
                                    <div class="carousel-indicators" id="carousel-admin-indicators">
                                        <!-- Indicators populated by JS -->
                                    </div>
                                    <div class="carousel-inner rounded-3 shadow-sm bg-light" id="carousel-admin-inner"
                                        style="max-height: 480px;">
                                        <!-- Slides populated by JS -->
                                    </div>
                                    <button class="carousel-control-prev" type="button"
                                        data-bs-target="#carouselAdminPosters" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button"
                                        data-bs-target="#carouselAdminPosters" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top p-3">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            // CSRF Token Setup
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // View Details
            $('.btn-view-detail').on('click', function () {
                var id = $(this).data('id');
                var url = "{{ route('alumni.loker.show', ':id') }}".replace(':id', id);

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function (job) {
                        $('#modal-company-name').text(job.company_name);
                        $('#modal-position').text(job.position);
                        $('#modal-category').text(job.category);
                        $('#modal-location').text(job.location);
                        $('#modal-salary').text(job.salary_range ? job.salary_range : '-');
                        $('#modal-description').text(job.description);
                        $('#modal-requirements').text(job.requirements);

                        // PIC Info
                        if (job.pic_name) {
                            $('#modal-pic-name').text(job.pic_name);
                            $('#modal-pic-email').text(job.pic_email || '-');
                            $('#modal-pic-phone').text(job.pic_phone || '-');
                            $('#modal-pic-position').text(job.pic_position || '-');
                            $('#modal-pic-container').show();
                        } else {
                            $('#modal-pic-container').hide();
                        }

                        var posterContainer = $('#modal-poster-container');
                        var indicators = $('#carousel-admin-indicators');
                        var inner = $('#carousel-admin-inner');

                        indicators.empty();
                        inner.empty();

                        var posters = job.poster_paths;
                        if (posters && Array.isArray(posters) && posters.length > 0) {
                            posters.forEach(function (path, index) {
                                var activeClass = index === 0 ? 'active' : '';
                                var ariaCurrent = index === 0 ? 'aria-current="true"' : '';
                                indicators.append('<button type="button" data-bs-target="#carouselAdminPosters" data-bs-slide-to="' + index + '" class="' + activeClass + '" ' + ariaCurrent + ' aria-label="Slide ' + (index + 1) + '"></button>');

                                inner.append(
                                    '<div class="carousel-item ' + activeClass + '">' +
                                    '<img src="' + path + '" class="d-block w-100 rounded-3 shadow-sm" style="max-height: 450px; object-fit: contain;" alt="Poster Lowongan">' +
                                    '</div>'
                                );
                            });

                            if (posters.length <= 1) {
                                $('#carouselAdminPosters .carousel-control-prev, #carouselAdminPosters .carousel-control-next, #carouselAdminPosters .carousel-indicators').hide();
                            } else {
                                $('#carouselAdminPosters .carousel-control-prev, #carouselAdminPosters .carousel-control-next, #carouselAdminPosters .carousel-indicators').show();
                            }

                            posterContainer.show();

                            var carouselEl = document.getElementById('carouselAdminPosters');
                            var carousel = bootstrap.Carousel.getOrCreateInstance(carouselEl);
                            carousel.to(0);
                        } else {
                            posterContainer.hide();
                        }

                        var myModal = new bootstrap.Modal(document.getElementById('modalAdminDetailLoker'));
                        myModal.show();
                    },
                    error: function () {
                        Swal.fire('Error', 'Gagal memuat detail data.', 'error');
                    }
                });
            });

            // Approve
            $('.btn-approve').on('click', function () {
                var id = $(this).data('id');
                var url = "{{ route('admin.loker.approve', ':id') }}".replace(':id', id);

                Swal.fire({
                    title: 'Setujui Lowongan?',
                    text: "Lowongan kerja akan langsung ditampilkan pada dashboard bursa kerja alumni.",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#10b981',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Setujui!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: 'POST',
                            success: function (res) {
                                Swal.fire('Berhasil', res.message, 'success').then(() => {
                                    location.reload();
                                });
                            },
                            error: function () {
                                Swal.fire('Error', 'Gagal menyetujui lowongan kerja.', 'error');
                            }
                        });
                    }
                });
            });

            // Reject
            $('.btn-reject').on('click', function () {
                var id = $(this).data('id');
                var url = "{{ route('admin.loker.reject', ':id') }}".replace(':id', id);

                Swal.fire({
                    title: 'Tolak Lowongan?',
                    text: "Lowongan kerja ini akan ditolak dan tidak akan ditampilkan ke alumni.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Tolak!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: 'POST',
                            success: function (res) {
                                Swal.fire('Berhasil', res.message, 'success').then(() => {
                                    location.reload();
                                });
                            },
                            error: function () {
                                Swal.fire('Error', 'Gagal menolak lowongan kerja.', 'error');
                            }
                        });
                    }
                });
            });

            // Delete
            $('.btn-delete').on('click', function () {
                var id = $(this).data('id');
                var url = "{{ route('admin.loker.destroy', ':id') }}".replace(':id', id);

                Swal.fire({
                    title: 'Hapus Lowongan?',
                    text: "Data lowongan kerja akan dihapus permanen dari sistem.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: 'DELETE',
                            success: function (res) {
                                Swal.fire('Berhasil', res.message, 'success').then(() => {
                                    location.reload();
                                });
                            },
                            error: function () {
                                Swal.fire('Error', 'Gagal menghapus lowongan kerja.', 'error');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection