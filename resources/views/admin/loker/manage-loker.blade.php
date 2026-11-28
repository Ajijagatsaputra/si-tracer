@extends('layouts.admin')

@section('content')
    <div class="akila-page-wrap">
        <!-- Breadcrumb -->
        <div class="akila-breadcrumb">
            <a href="{{ route('admin.dashboard') }}"><i class="fa fa-home me-1"></i> Home</a>
            <span class="sep">&rsaquo;</span>
            <span>Bursa Kerja</span>
            <span class="sep">&rsaquo;</span>
            <span class="active">Daftar Lowongan Kerja</span>
        </div>

        <!-- Main Card -->
        <div class="akila-list-card">
            <div class="akila-card-header">
                <div>
                    <h1 class="akila-title">Daftar Lowongan Kerja</h1>
                    <p class="akila-subtitle">Kelola semua data lowongan pekerjaan dari admin dan mitra perusahaan yang tersedia di sistem.</p>
                </div>
                <div class="akila-header-actions">
                    <a href="{{ route('admin.loker.create') }}" class="btn-akila-dark">
                        <i class="fa fa-plus"></i> Tambah Lowongan
                    </a>
                </div>
            </div>

            <!-- Length Row -->
            <div class="akila-toolbar-row">
                <div id="entries-container" class="akila-length-wrap"></div>
            </div>

            <!-- Table -->
            <div class="akila-table-wrapper">
                <table class="table align-middle akila-table w-100" id="tabel-loker">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 38px;">
                                <input type="checkbox" class="form-check-input akila-checkbox" id="check-all-loker">
                            </th>
                            <th class="text-center" style="width: 56px;">No.</th>
                            <th style="min-width: 210px;">Nama Lowongan & Perusahaan</th>
                            <th style="min-width: 210px;">Deskripsi</th>
                            <th>Tipe & Lokasi</th>
                            <th class="text-center">Sampul</th>
                            <th>Nama Pengunggah</th>
                            <th class="text-center">Status</th>
                            <th class="text-center" style="width: 130px;">Aksi</th>
                        </tr>
                        <tr class="akila-filter-row">
                            <th></th>
                            <th class="text-center"><span class="akila-no-pill">No</span></th>
                            <th>
                                <div class="akila-filter-input">
                                    <i class="fa fa-search"></i>
                                    <input type="text" class="col-filter" data-col="2" placeholder="Cari posisi / PT...">
                                </div>
                            </th>
                            <th>
                                <div class="akila-filter-input">
                                    <i class="fa fa-search"></i>
                                    <input type="text" class="col-filter" data-col="3" placeholder="Cari deskripsi...">
                                </div>
                            </th>
                            <th>
                                <select class="akila-filter-select col-filter-select" data-col="4">
                                    <option value="">Semua Kategori</option>
                                    @foreach($jobs->pluck('category')->filter()->unique() as $cat)
                                        <option value="{{ $cat }}">{{ $cat }}</option>
                                    @endforeach
                                </select>
                            </th>
                            <th></th>
                            <th>
                                <div class="akila-filter-input">
                                    <i class="fa fa-search"></i>
                                    <input type="text" class="col-filter" data-col="6" placeholder="Cari pengunggah...">
                                </div>
                            </th>
                            <th>
                                <select class="akila-filter-select col-filter-select" data-col="7">
                                    <option value="">Semua Status</option>
                                    <option value="PUBLISHED">Published (Approved)</option>
                                    <option value="PENDING">Pending</option>
                                    <option value="DITOLAK">Ditolak</option>
                                </select>
                            </th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jobs as $index => $job)
                            @php
                                $descExcerpt = mb_strimwidth(trim(strip_tags($job->description ?? '')), 0, 90, '...');
                                $firstPoster = is_array($job->poster_paths) && count($job->poster_paths) > 0 ? $job->poster_paths[0] : $job->logo_path;
                                $isComplete = !empty($job->description) && !empty($job->requirements);
                            @endphp
                            <tr>
                                <td class="text-center">
                                    <input type="checkbox" class="form-check-input akila-checkbox row-check" value="{{ $job->id }}">
                                </td>
                                <td class="text-center text-muted fw-semibold">{{ $index + 1 }}</td>
                                <td>
                                    <div class="akila-cell-title">{{ $job->position }}</div>
                                    <div class="akila-cell-desc" style="font-size: 0.76rem;">{{ $job->company_name }}</div>
                                </td>
                                <td>
                                    <div class="akila-cell-desc">{{ $descExcerpt ?: 'Tidak ada deskripsi singkat.' }}</div>
                                </td>
                                <td>
                                    <div class="flex-wrap gap-1 d-flex">
                                        <span class="akila-badge akila-badge-outline">{{ $job->category ?: 'Umum' }}</span>
                                        @if($job->location)
                                            <span class="akila-badge akila-badge-orange">{{ $job->location }}</span>
                                        @endif
                                        @if($job->pic_name)
                                            <span class="akila-badge akila-badge-purple">Mitra</span>
                                        @else
                                            <span class="akila-badge akila-badge-blue">Internal</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="text-center">
                                    @if($firstPoster)
                                        <img src="{{ $firstPoster }}" alt="Sampul" class="akila-thumb">
                                    @else
                                        <span class="d-inline-flex align-items-center justify-content-center akila-thumb fw-bold text-muted" style="font-size: 0.72rem;">
                                            {{ strtoupper(substr($job->company_name, 0, 2)) }}
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="akila-person">
                                        <span class="akila-person-avatar"><i class="fa fa-user"></i></span>
                                        <span>{{ $job->pic_name ?: 'Admin' }}</span>
                                    </div>
                                </td>
                                <td class="text-center">
                                    @if($job->status === 'approved')
                                        <div class="akila-status-stack">
                                            <span class="akila-badge akila-badge-green">PUBLISHED</span>
                                            <span class="{{ $isComplete ? 'akila-substatus-ok' : 'akila-substatus-warn' }}">
                                                {{ $isComplete ? 'Lengkap' : 'Belum Lengkap' }}
                                            </span>
                                        </div>
                                    @elseif($job->status === 'pending')
                                        <div class="akila-status-stack">
                                            <span class="akila-badge akila-badge-amber">PENDING</span>
                                            <span class="akila-substatus-muted">Moderasi</span>
                                        </div>
                                    @else
                                        <div class="akila-status-stack">
                                            <span class="akila-badge akila-badge-red">DITOLAK</span>
                                            <span class="akila-substatus-warn">Non-Aktif</span>
                                        </div>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="akila-actions">
                                        <button type="button" class="akila-action-btn btn-view-detail"
                                            data-id="{{ $job->id }}" title="Lihat Detail">
                                            <i class="far fa-eye"></i>
                                        </button>
                                        <a href="{{ route('admin.loker.edit', $job->id) }}"
                                            class="akila-action-btn act-edit" title="Edit Lowongan">
                                            <i class="far fa-edit"></i>
                                        </a>
                                        @if($job->status === 'pending')
                                            <button type="button" class="akila-action-btn act-approve btn-approve"
                                                data-id="{{ $job->id }}" title="Setujui">
                                                <i class="fa fa-check"></i>
                                            </button>
                                            <button type="button" class="akila-action-btn act-delete btn-reject"
                                                data-id="{{ $job->id }}" title="Tolak">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        @endif
                                        <button type="button" class="akila-action-btn act-delete btn-delete"
                                            data-id="{{ $job->id }}" title="Hapus">
                                            <i class="far fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Job Detail Modal (Admin) -->
    <div class="modal fade" id="modalAdminDetailLoker" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="overflow-hidden border-0 modal-content rounded-4">
                <div class="p-3 text-white modal-header bg-dark">
                    <h5 class="text-white modal-title fw-bold"><i class="fa fa-briefcase me-2"></i> Detail Lowongan Pekerjaan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="p-4 modal-body bg-light">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="p-3 bg-white border rounded-3">
                                <span class="mb-1 text-muted text-uppercase fw-bold d-block" style="font-size: 0.65rem;">Nama Perusahaan</span>
                                <span class="fw-bold text-dark" id="modal-company-name">-</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 bg-white border rounded-3">
                                <span class="mb-1 text-muted text-uppercase fw-bold d-block" style="font-size: 0.65rem;">Posisi Jabatan</span>
                                <span class="fw-bold text-dark" id="modal-position">-</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 bg-white border rounded-3">
                                <span class="mb-1 text-muted text-uppercase fw-bold d-block" style="font-size: 0.65rem;">Kategori</span>
                                <span class="fw-bold text-dark" id="modal-category">-</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 bg-white border rounded-3">
                                <span class="mb-1 text-muted text-uppercase fw-bold d-block" style="font-size: 0.65rem;">Lokasi</span>
                                <span class="fw-bold text-dark" id="modal-location">-</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 bg-white border rounded-3">
                                <span class="mb-1 text-muted text-uppercase fw-bold d-block" style="font-size: 0.65rem;">Gaji</span>
                                <span class="fw-bold text-dark" id="modal-salary">-</span>
                            </div>
                        </div>
                        <div class="col-12" id="modal-pic-container" style="display: none;">
                            <div class="p-3 border bg-warning-light border-warning rounded-3">
                                <span class="mb-2 text-muted text-uppercase fw-bold d-block" style="font-size: 0.65rem;">
                                    <i class="fa fa-user-tie me-1"></i> Penanggung Jawab (PIC Pengunggah)
                                </span>
                                <div class="row g-2">
                                    <div class="col-md-6"><span class="small text-muted">Nama:</span> <span class="fw-bold text-dark d-block" id="modal-pic-name">-</span></div>
                                    <div class="col-md-6"><span class="small text-muted">Jabatan:</span> <span class="fw-bold text-dark d-block" id="modal-pic-position">-</span></div>
                                    <div class="col-md-6"><span class="small text-muted">Email:</span> <span class="fw-bold text-dark d-block" id="modal-pic-email">-</span></div>
                                    <div class="col-md-6"><span class="small text-muted">No. HP:</span> <span class="fw-bold text-dark d-block" id="modal-pic-phone">-</span></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="p-3 bg-white border rounded-3">
                                <span class="mb-2 text-muted text-uppercase fw-bold d-block" style="font-size: 0.65rem;">Deskripsi Pekerjaan</span>
                                <div class="text-dark fs-sm" id="modal-description" style="white-space: pre-line; line-height: 1.6;">-</div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="p-3 bg-white border rounded-3">
                                <span class="mb-2 text-muted text-uppercase fw-bold d-block" style="font-size: 0.65rem;">Kualifikasi / Persyaratan</span>
                                <div class="text-dark fs-sm" id="modal-requirements" style="white-space: pre-line; line-height: 1.6;">-</div>
                            </div>
                        </div>
                        <div class="col-12" id="modal-poster-container" style="display: none;">
                            <div class="p-3 text-center bg-white border rounded-3">
                                <span class="mb-2 text-muted text-uppercase fw-bold d-block text-start" style="font-size: 0.65rem;">Poster / Brosur Lowongan</span>
                                <div id="carouselAdminPosters" class="carousel slide carousel-dark" data-bs-ride="carousel">
                                    <div class="carousel-indicators" id="carousel-admin-indicators"></div>
                                    <div class="carousel-inner rounded-3 bg-light" id="carousel-admin-inner" style="max-height: 460px;"></div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselAdminPosters" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#carouselAdminPosters" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-3 bg-white modal-footer border-top">
                    <button type="button" class="btn-akila-outline" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <style>
        #modalAdminDetailLoker .modal-dialog { max-width: 860px; }
        #modalAdminDetailLoker .modal-content { border-radius: 20px !important; box-shadow: 0 24px 70px rgba(15, 23, 42, .28); }
        #modalAdminDetailLoker .modal-header { padding: 1.35rem 1.6rem; background: linear-gradient(120deg, #172033, #263b5a) !important; }
        #modalAdminDetailLoker .modal-header::after { content: ""; position: absolute; bottom: 0; left: 0; width: 100%; height: 3px; background: linear-gradient(90deg, #d7ad55, #f0d898, transparent); }
        #modalAdminDetailLoker .modal-header { position: relative; }
        #modalAdminDetailLoker .modal-body { max-height: 70vh; overflow-y: auto; padding: 1.5rem; background: #f5f7fb !important; }
        #modalAdminDetailLoker .modal-body .row > div > div { border: 1px solid #e6ebf2 !important; border-radius: 14px !important; box-shadow: 0 4px 14px rgba(15, 23, 42, .035); }
        #modalAdminDetailLoker .modal-body [class*="text-uppercase"] { letter-spacing: .07em; }
        #modalAdminDetailLoker .modal-footer { padding: 1rem 1.5rem; }
        .swal2-popup.swal-modern { border: 1px solid #e8edf4; border-radius: 22px; padding: 1.75rem; box-shadow: 0 24px 70px rgba(15, 23, 42, .2); }
        .swal-modern .swal2-title { color: #172033; font-size: 1.35rem; font-weight: 800; }
        .swal-modern .swal2-html-container { color: #64748b; font-size: .95rem; }
        .swal-modern .swal2-icon { border-width: 3px; }
        .swal-modern .btn-modern { min-width: 118px; margin: .25rem; padding: .7rem 1.1rem; border: 0; border-radius: 12px; font-weight: 700; transition: transform .18s ease, box-shadow .18s ease; }
        .swal-modern .btn-modern:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(15, 23, 42, .15); }
        .swal-modern .btn-modern-danger { color: #fff; background: #d63e4b; }
        .swal-modern .btn-modern-secondary { color: #334155; background: #edf1f6; }
        .akila-page-wrap { min-width: 0; }
        .akila-table-wrapper { max-width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch; }
        #tabel-loker { min-width: 1050px; }
        #modalAdminDetailLoker .modal-body .row > div, #modalAdminDetailLoker .modal-body [id^="modal-"] { min-width: 0; overflow-wrap: anywhere; }
        #modalAdminDetailLoker #carousel-admin-inner { display: flex; align-items: center; justify-content: center; }
        #modalAdminDetailLoker #carousel-admin-inner img { max-width: 100%; max-height: min(55vh, 460px); object-fit: contain; }
        @media (max-width: 767.98px) {
            .akila-page-wrap { padding-inline: .75rem; }
            .akila-list-card { padding: 1rem !important; }
            .akila-header-actions { width: 100%; }
            .akila-header-actions > * { max-width: 100%; }
            #modalAdminDetailLoker .modal-dialog { width: auto; max-width: none; margin: .5rem; }
            #modalAdminDetailLoker .modal-body .col-md-4, #modalAdminDetailLoker .modal-body .col-md-6 { width: 100%; }
            #modalAdminDetailLoker .modal-body { max-height: calc(100dvh - 145px); padding: .85rem; }
            #modalAdminDetailLoker .modal-header { padding: 1rem; }
            #modalAdminDetailLoker .modal-title { font-size: 1rem; }
            #modalAdminDetailLoker .modal-footer { padding: .75rem 1rem; }
            #modalAdminDetailLoker .modal-body .p-3 { padding: .85rem !important; }
            .swal2-popup.swal-modern { width: calc(100% - 2rem); padding: 1.25rem; }
        }
        @media (max-width: 420px) {
            #modalAdminDetailLoker .modal-dialog { margin: .35rem; }
            #modalAdminDetailLoker .modal-body { max-height: calc(100dvh - 125px); }
            #modalAdminDetailLoker .modal-header .btn-close { margin-left: .5rem; }
        }
    </style>
    <script>
        jQuery(document).ready(function ($) {
            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            const table = $('#tabel-loker').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                orderCellsTop: true,
                pageLength: 10,
                lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
                autoWidth: false,
                dom: "lrt<'row align-items-center mt-3'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 d-flex justify-content-md-end'p>>",
                columnDefs: [
                    { orderable: false, targets: [0, 5, 8] }
                ],
                order: [[1, 'asc']],
                language: {
                    lengthMenu: 'Tampilkan _MENU_ data',
                    info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                    infoEmpty: 'Tidak ada data tersedia',
                    zeroRecords: 'Tidak ada lowongan yang cocok dengan filter.',
                    emptyTable: 'Belum ada data lowongan pekerjaan.',
                    paginate: { first: '&laquo;', last: '&raquo;', next: '&rsaquo;', previous: '&lsaquo;' }
                },
                initComplete: function () {
                    $('#entries-container').empty().append($('.dataTables_length').detach());
                }
            });

            $('.akila-filter-row th').on('click mousedown', function (e) {
                e.stopPropagation();
            });

            $(document).on('keyup change', '#tabel-loker .col-filter', function () {
                const colIdx = $(this).data('col');
                if (table.column(colIdx).search() !== this.value) {
                    table.column(colIdx).search(this.value).draw();
                }
            });

            $(document).on('change', '#tabel-loker .col-filter-select', function () {
                const colIdx = $(this).data('col');
                table.column(colIdx).search(this.value).draw();
            });

            $('#check-all-loker').on('change', function () {
                $('#tabel-loker .row-check').prop('checked', this.checked);
            });

            // View Details (delegated for DataTables pages)
            $(document).on('click', '.btn-view-detail', function () {
                const id = $(this).data('id');
                const url = "{{ route('alumni.loker.show', ':id') }}".replace(':id', id);

                $.get(url, function (job) {
                    $('#modal-company-name').text(job.company_name || '-');
                    $('#modal-position').text(job.position || '-');
                    $('#modal-category').text(job.category || '-');
                    $('#modal-location').text(job.location || '-');
                    $('#modal-salary').text(job.salary_range || '-');
                    $('#modal-description').text(job.description || '-');
                    $('#modal-requirements').text(job.requirements || '-');

                    if (job.pic_name) {
                        $('#modal-pic-name').text(job.pic_name);
                        $('#modal-pic-email').text(job.pic_email || '-');
                        $('#modal-pic-phone').text(job.pic_phone || '-');
                        $('#modal-pic-position').text(job.pic_position || '-');
                        $('#modal-pic-container').show();
                    } else {
                        $('#modal-pic-container').hide();
                    }

                    const posterContainer = $('#modal-poster-container');
                    const indicators = $('#carousel-admin-indicators').empty();
                    const inner = $('#carousel-admin-inner').empty();
                    const posters = job.poster_paths;

                    if (posters && Array.isArray(posters) && posters.length > 0) {
                        posters.forEach(function (path, index) {
                            const activeClass = index === 0 ? 'active' : '';
                            indicators.append(`<button type="button" data-bs-target="#carouselAdminPosters" data-bs-slide-to="${index}" class="${activeClass}"></button>`);
                            inner.append(`<div class="carousel-item ${activeClass}"><img src="${path}" class="d-block w-100 rounded-3" style="max-height: 440px; object-fit: contain;"></div>`);
                        });
                        $('#carouselAdminPosters .carousel-control-prev, #carouselAdminPosters .carousel-control-next, #carouselAdminPosters .carousel-indicators').toggle(posters.length > 1);
                        posterContainer.show();
                    } else {
                        posterContainer.hide();
                    }

                    new bootstrap.Modal(document.getElementById('modalAdminDetailLoker')).show();
                }).fail(function () {
                    Swal.fire('Error', 'Gagal memuat detail lowongan.', 'error');
                });
            });

            // Approve
            $(document).on('click', '.btn-approve', function () {
                const id = $(this).data('id');
                const url = "{{ route('admin.loker.approve', ':id') }}".replace(':id', id);

                Swal.fire({
                    title: 'Setujui Lowongan?',
                    text: 'Lowongan kerja akan langsung ditampilkan pada bursa kerja alumni.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Setujui',
                    cancelButtonText: 'Batal',
                    customClass: { popup: 'swal-modern', confirmButton: 'btn-modern btn-modern-primary', cancelButton: 'btn-modern btn-modern-secondary' },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.post(url, function (res) {
                            Swal.fire('Berhasil', res.message, 'success').then(() => location.reload());
                        }).fail(() => Swal.fire('Error', 'Gagal menyetujui lowongan kerja.', 'error'));
                    }
                });
            });

            // Reject
            $(document).on('click', '.btn-reject', function () {
                const id = $(this).data('id');
                const url = "{{ route('admin.loker.reject', ':id') }}".replace(':id', id);

                Swal.fire({
                    title: 'Tolak Lowongan?',
                    text: 'Lowongan kerja ini akan ditolak dan tidak ditampilkan ke alumni.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Tolak',
                    cancelButtonText: 'Batal',
                    customClass: { popup: 'swal-modern', confirmButton: 'btn-modern btn-modern-danger', cancelButton: 'btn-modern btn-modern-secondary' },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.post(url, function (res) {
                            Swal.fire('Berhasil', res.message, 'success').then(() => location.reload());
                        }).fail(() => Swal.fire('Error', 'Gagal menolak lowongan kerja.', 'error'));
                    }
                });
            });

            // Delete
            $(document).on('click', '.btn-delete', function () {
                const id = $(this).data('id');
                const url = "{{ route('admin.loker.destroy', ':id') }}".replace(':id', id);

                Swal.fire({
                    title: 'Hapus Lowongan?',
                    text: 'Data lowongan kerja akan dihapus permanen dari sistem.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus',
                    cancelButtonText: 'Batal',
                    customClass: { popup: 'swal-modern', confirmButton: 'btn-modern btn-modern-danger', cancelButton: 'btn-modern btn-modern-secondary' },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: 'DELETE',
                            success: function (res) {
                                Swal.fire('Berhasil', res.message, 'success').then(() => location.reload());
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
