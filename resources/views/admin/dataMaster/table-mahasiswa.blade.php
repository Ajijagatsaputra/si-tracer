@extends('layouts.admin')

@section('content')
    <!-- Hero -->
    <div class="bg-white">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-2">
                        <span class="bg-info-lighter p-2 rounded-3 me-2">
                            <i class="fa fa-users text-info"></i>
                        </span>
                        Data Mahasiswa
                    </h1>
                    <p class="fs-sm fw-medium text-muted mb-0">
                        Kelola data mahasiswa aktif, cuti, DO, lulus, dan keluar dengan sistem yang lebih cerdas dan modern.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="content">
        <div class="card card-modern overflow-hidden shadow-sm border-0">
            <div class="card-body p-4">
                <!-- Modern Table Toolbar -->
                <div class="table-toolbar mb-4">
                    <div class="row g-3 align-items-center">
                        <!-- Filter & Entries Group -->
                        <div class="col-12 col-xl-8">
                            <div class="d-flex flex-wrap align-items-center gap-3">
                                <!-- Angkatan Filter -->
                                <div class="d-flex align-items-center bg-white p-2 px-3 rounded-pill border shadow-sm">
                                    <label for="filter-tahun" class="mb-0 me-2 fw-bold text-muted fs-xs text-uppercase">
                                        <i class="fa fa-calendar-alt text-info me-1"></i> Angkatan
                                    </label>
                                    <select id="filter-tahun"
                                        class="form-select form-select-sm border-0 bg-transparent fw-bold text-info p-0 h-auto"
                                        style="width: auto; min-width: 80px;"></select>
                                </div>

                                <!-- Total Badge -->
                                <div
                                    class="bg-info-light text-info px-3 py-2 rounded-pill shadow-sm fs-sm fw-bold border border-info-lighter">
                                    <i class="fa fa-users me-1"></i> <span id="jumlah-mahasiswa">0</span> <small
                                        class="text-uppercase ms-1 opacity-75">Mahasiswa</small>
                                </div>

                                <!-- Entries Selection -->
                                <div id="entries-container" class="ms-md-auto"></div>
                            </div>
                        </div>

                        <!-- Search Group -->
                        <div class="col-12 col-xl-4 text-xl-end">
                            <div
                                class="input-group input-group-modern shadow-sm border rounded-pill overflow-hidden bg-white">
                                <span class="input-group-text border-0 bg-white ps-3">
                                    <i class="fa fa-search text-muted"></i>
                                </span>
                                <input type="text" id="customSearch" class="form-control border-0 fs-sm"
                                    placeholder="Cari data mahasiswa...">
                                <button class="btn btn-info px-4 fw-semibold shadow-sm text-white"
                                    id="searchBtn">Cari</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table align-middle table-hover js-dataTable-full w-100 border-0">
                        <!-- Table header is generated via JS -->
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail -->
    <div class="modal fade" id="modalViewMahasiswa" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg overflow-hidden rounded-4">
                <!-- Close Button absolute positioned -->
                <button type="button"
                    class="btn-close btn-close-white position-absolute top-0 end-0 m-3 z-3 bg-dark/20 backdrop-blur rounded-circle p-2 shadow-sm"
                    data-bs-dismiss="modal" aria-label="Tutup"
                    style="width: 32px; height: 32px; font-size: 0.75rem; border: none;"></button>

                <div class="modal-body p-0">
                    <div class="row g-0">
                        <!-- Left Side: Profile Banner & Core Info -->
                        <div class="col-lg-5 text-white position-relative d-flex flex-column align-items-center justify-content-center p-4 py-5"
                            style="background: linear-gradient(135deg, #0ea5e9 0%, #2563eb 100%); min-height: 380px;">

                            <!-- Subtle background pattern decorative circles -->
                            <div class="position-absolute top-0 start-0 w-100 h-100 overflow-hidden"
                                style="opacity: 0.15; pointer-events: none;">
                                <div class="position-absolute rounded-circle bg-white"
                                    style="width: 200px; height: 200px; top: -50px; left: -50px;"></div>
                                <div class="position-absolute rounded-circle bg-white"
                                    style="width: 150px; height: 150px; bottom: -30px; right: -30px;"></div>
                            </div>

                            <!-- Profile Header Content -->
                            <div class="text-center z-1 w-100 px-3">
                                <div class="position-relative d-inline-block mb-3">
                                    <!-- Profile Avatar Ring -->
                                    <div class="avatar-ring p-1 rounded-circle bg-white/20 d-inline-block">
                                        <img id="view-avatar" class="modal-avatar rounded-circle shadow-sm"
                                            alt="Avatar Mahasiswa"
                                            style="width:110px; height:110px; object-fit:cover; border: 3px solid #fff;">
                                    </div>
                                    <!-- Glowing status badge positioned nicely -->
                                    <span id="view-status-badge"
                                        class="position-absolute bottom-0 end-0 translate-middle-x badge rounded-pill border border-2 border-white shadow px-3 py-1 fs-xs fw-bold text-white">Active</span>
                                </div>
                                <h3 class="fw-bold mb-1 text-white fs-4" id="view-nama"></h3>
                                <p class="text-white/80 fs-sm mb-4 fw-medium" id="view-prodi"></p>

                                <div class="d-flex justify-content-center gap-2 pt-2" id="view-wa-btn">
                                    <!-- Quick action populated via JS -->
                                </div>
                            </div>
                        </div>

                        <!-- Right Side: Grid of detailed cards -->
                        <div class="col-lg-7 bg-white p-4 p-md-5">
                            <div class="d-flex align-items-center justify-content-between mb-4 border-bottom pb-3">
                                <div>
                                    <h5 class="fw-bold text-dark mb-1">Detail Informasi Akademik</h5>
                                    <p class="text-muted fs-xs mb-0">Informasi lengkap status perkuliahan mahasiswa</p>
                                </div>
                            </div>

                            <div class="row g-3">
                                <!-- NIM Card -->
                                <div class="col-sm-6">
                                    <div class="detail-card p-3 rounded-3 border border-light shadow-xs bg-light/30">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-box me-3 rounded-3 bg-primary/10 text-primary d-flex align-items-center justify-content-center"
                                                style="width: 40px; height: 40px; min-width: 40px;">
                                                <i class="fa fa-id-card fs-5"></i>
                                            </div>
                                            <div>
                                                <span class="text-muted text-uppercase fw-bold text-xs d-block mb-0"
                                                    style="font-size: 0.65rem; letter-spacing: 1px;">NIM</span>
                                                <span id="view-nim" class="fw-bold text-dark fs-sm d-block"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Kelas Card -->
                                <div class="col-sm-6">
                                    <div class="detail-card p-3 rounded-3 border border-light shadow-xs bg-light/30">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-box me-3 rounded-3 bg-success/10 text-success d-flex align-items-center justify-content-center"
                                                style="width: 40px; height: 40px; min-width: 40px;">
                                                <i class="fa fa-layer-group fs-5"></i>
                                            </div>
                                            <div>
                                                <span class="text-muted text-uppercase fw-bold text-xs d-block mb-0"
                                                    style="font-size: 0.65rem; letter-spacing: 1px;">Kelas</span>
                                                <span id="view-kelas" class="fw-bold text-dark fs-sm d-block"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Jalur Masuk Card -->
                                <div class="col-sm-6">
                                    <div class="detail-card p-3 rounded-3 border border-light shadow-xs bg-light/30">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-box me-3 rounded-3 bg-info/10 text-info d-flex align-items-center justify-content-center"
                                                style="width: 40px; height: 40px; min-width: 40px;">
                                                <i class="fa fa-route fs-5"></i>
                                            </div>
                                            <div>
                                                <span class="text-muted text-uppercase fw-bold text-xs d-block mb-0"
                                                    style="font-size: 0.65rem; letter-spacing: 1px;">Jalur Masuk</span>
                                                <span id="view-jalur" class="fw-bold text-dark fs-sm d-block"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tahun Masuk Card -->
                                <div class="col-sm-6">
                                    <div class="detail-card p-3 rounded-3 border border-light shadow-xs bg-light/30">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-box me-3 rounded-3 bg-warning/10 text-warning d-flex align-items-center justify-content-center"
                                                style="width: 40px; height: 40px; min-width: 40px;">
                                                <i class="fa fa-calendar-check fs-5"></i>
                                            </div>
                                            <div>
                                                <span class="text-muted text-uppercase fw-bold text-xs d-block mb-0"
                                                    style="font-size: 0.65rem; letter-spacing: 1px;">Tahun Masuk</span>
                                                <span id="view-tahun" class="fw-bold text-dark fs-sm d-block"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Semester Card -->
                                <div class="col-sm-6">
                                    <div class="detail-card p-3 rounded-3 border border-light shadow-xs bg-light/30">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-box me-3 rounded-3 bg-danger/10 text-danger d-flex align-items-center justify-content-center"
                                                style="width: 40px; height: 40px; min-width: 40px;">
                                                <i class="fa fa-graduation-cap fs-5"></i>
                                            </div>
                                            <div>
                                                <span class="text-muted text-uppercase fw-bold text-xs d-block mb-0"
                                                    style="font-size: 0.65rem; letter-spacing: 1px;">Semester Aktif</span>
                                                <span id="view-semester" class="fw-bold text-dark fs-sm d-block"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- WhatsApp Card -->
                                <div class="col-sm-6">
                                    <div class="detail-card p-3 rounded-3 border border-light shadow-xs bg-light/30">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-box me-3 rounded-3 bg-success/10 text-success d-flex align-items-center justify-content-center"
                                                style="width: 40px; height: 40px; min-width: 40px;">
                                                <i class="fab fa-whatsapp fs-5"></i>
                                            </div>
                                            <div>
                                                <span class="text-muted text-uppercase fw-bold text-xs d-block mb-0"
                                                    style="font-size: 0.65rem; letter-spacing: 1px;">WhatsApp</span>
                                                <span id="view-telp" class="fw-bold text-dark fs-sm d-block"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Footer details / Quick info -->
                            <div
                                class="mt-4 pt-3 border-top d-flex flex-wrap justify-content-between align-items-center gap-3">
                                <span class="text-muted fs-xs"><i class="fa fa-info-circle me-1"></i> Data terintegrasi
                                    dengan SIAKAD</span>
                                <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill px-4 shadow-sm"
                                    data-bs-dismiss="modal">
                                    <i class="fa fa-times me-1"></i> Tutup
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        let table;

        function renderStatusBadge(status) {
            const map = {
                'Aktif': 'status-badge-aktif',
                'Cuti': 'status-badge-cuti',
                'DO': 'status-badge-do',
                'Lulus': 'status-badge-lulus',
                'Keluar': 'status-badge-keluar'
            };
            return `<span class="badge ${map[status] || 'bg-secondary text-white'} rounded-pill px-2.5 py-1.5 fs-xs fw-bold">${status}</span>`;
        }

        function initDataTable(tahunAngkatan) {
            if (table) { table.destroy(); $('.js-dataTable-full').empty(); }
            $('.js-dataTable-full').html(`
                        <thead>
                            <tr class="bg-light text-muted text-uppercase fs-xs fw-bold border-0">
                                <th class="py-3 px-4 border-0">Mahasiswa</th>
                                <th class="py-3 border-0">NIM</th>
                                <th class="py-3 border-0">Prodi</th>
                                <th class="py-3 border-0">Semester</th>
                                <th class="py-3 border-0 text-center">Kelas</th>
                                <th class="py-3 border-0">Jalur</th>
                                <th class="py-3 border-0">Tahun</th>
                                <th class="py-3 border-0">Status</th>
                                <th class="py-3 border-0 text-center">Aksi</th>
                            </tr>
                        </thead><tbody></tbody>`);

            table = $('.js-dataTable-full').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                responsive: true,
                pageLength: 15,
                autoWidth: false,
                dom: "<'row mt-3 mb-1'<'col-sm-12'B>>" +
                    "<'row'<'col-sm-12 table-responsive'tr>>" +
                    "<'row mt-3'<'col-sm-12 col-md-5 fs-sm text-muted'i><'col-sm-12 col-md-7 d-flex justify-content-md-end'p>>",
                buttons: [
                    { extend: 'excelHtml5', className: 'btn btn-sm btn-success rounded-pill px-3 shadow-sm border-0 me-2', text: '<i class="fa fa-file-excel me-1"></i> Excel' },
                    { extend: 'pdfHtml5', className: 'btn btn-sm btn-danger rounded-pill px-3 shadow-sm border-0 me-2', text: '<i class="fa fa-file-pdf me-1"></i> PDF', orientation: 'landscape', pageSize: 'A4' },
                    { extend: 'print', className: 'btn btn-sm btn-info rounded-pill px-3 shadow-sm border-0', text: '<i class="fa fa-print me-1"></i> Cetak' }
                ],
                initComplete: function () {
                    $('#entries-container').empty();
                    let lengthMenu = $('.dataTables_length').detach();
                    $('#entries-container').append(lengthMenu);
                    $('#customSearch').on('keyup', function () { table.search(this.value).draw(); });
                    $('#searchBtn').on('click', function () { table.search($('#customSearch').val()).draw(); });
                },
                ajax: {
                    url: '{{ route('api.mahasiswa') }}', type: 'GET',
                    data: { tahun_angkatan: tahunAngkatan },
                    dataSrc: json => {
                        if (json.status) { $('#jumlah-mahasiswa').text(json.data.length); }
                        return json.status ? json.data.map(item => ({
                            nama: `<div class='d-flex align-items-center py-1'>
                                        <img src="${item.avatar_url ?? 'https://ui-avatars.com/api/?name=' + encodeURIComponent(item.nama_lengkap)}" class="shadow-sm border border-2 border-white" style="width:36px;height:36px;border-radius:12px;margin-right:12px;object-fit:cover;">
                                        <div><div class="fw-bold text-dark">${item.nama_lengkap}</div><small class="text-muted d-sm-none">${item.nim}</small></div>
                                      </div>`,
                            nim: `<span class="text-muted fw-medium">${item.nim}</span>`,
                            prodi: `<div class="fs-xs fw-semibold text-primary bg-primary-light px-2 py-1 rounded-pill d-inline-block border border-primary-10">${item.prodi?.nama || 'N/A'}</div>`,
                            semester: item.semester,
                            kelas: `<div class="text-center fw-bold">${item.kelas}</div>`,
                            jalur: item.jalur,
                            tahun_masuk: item.tahun_masuk,
                            status: renderStatusBadge(item.status_mahasiswa),
                            aksi: `<div class="text-center">
                                        <button class="btn btn-sm btn-white rounded-pill px-3 shadow-sm border btn-view" 
                                            data-nim='${item.nim}' data-nama='${item.nama_lengkap}' data-prodi='${item.prodi?.nama || ''}'
                                            data-semester='${item.semester}' data-kelas='${item.kelas}' data-jalur='${item.jalur}'
                                            data-tahun='${item.tahun_masuk}' data-status='${item.status_mahasiswa}'
                                            data-telp='${item.no_whatsapp || ''}' data-avatar='${item.avatar_url ?? ''}'><i class="fa fa-eye text-primary"></i></button>
                                     </div>`
                        })) : [];
                    }
                },
                columns: [
                    { data: 'nama' }, { data: 'nim' }, { data: 'prodi' }, { data: 'semester' }, { data: 'kelas' }, { data: 'jalur' },
                    { data: 'tahun_masuk' }, { data: 'status' }, { data: 'aksi', orderable: false }
                ]
            });
        }

        $(function () {
            let now = new Date().getFullYear();
            for (let y = now; y >= 2015; y--) { $('#filter-tahun').append(`<option value='${y}' ${y === 2021 ? 'selected' : ''}>${y}</option>`); }
            $('#filter-tahun').select2({ minimumResultsForSearch: -1, width: 'style' });
            initDataTable($('#filter-tahun').val());
            $('#filter-tahun').on('change', () => initDataTable($('#filter-tahun').val()));

            $(document).on('click', '.btn-view', function () {
                let data = $(this).data();
                $('#view-avatar').attr('src', data.avatar ? data.avatar : `https://ui-avatars.com/api/?name=${encodeURIComponent(data.nama)}&background=0284c7&color=fff&bold=true`);
                $('#view-nama').text(data.nama);
                $('#view-prodi').text(data.prodi);
                $('#view-nim').text(data.nim);
                $('#view-kelas').text(data.kelas);
                $('#view-jalur').text(data.jalur);
                $('#view-tahun').text(data.tahun);
                $('#view-semester').text(data.semester);

                // Status badge in modal
                const statusMap = {
                    'Aktif': 'bg-success text-white',
                    'Cuti': 'bg-warning text-dark',
                    'DO': 'bg-danger text-white',
                    'Lulus': 'bg-info text-white',
                    'Keluar': 'bg-secondary text-white'
                };
                $('#view-status-badge')
                    .text(data.status)
                    .attr('class', 'position-absolute bottom-0 end-0 translate-middle-x badge rounded-pill border border-2 border-white shadow px-3 py-1 fs-xs fw-bold ' + (statusMap[data.status] || 'bg-secondary text-white'));

                if (data.telp) {
                    $('#view-telp').html(`<a href='https://wa.me/${data.telp}' class="text-success text-decoration-none fw-bold" target='_blank'>${data.telp}</a>`);
                    $('#view-wa-btn').html(`<a href='https://wa.me/${data.telp}' target='_blank' class="btn btn-sm btn-light rounded-pill px-3 fw-bold text-success shadow-sm border-0"><i class="fab fa-whatsapp me-1"></i> Hubungi WhatsApp</a>`);
                } else {
                    $('#view-telp').text('-');
                    $('#view-wa-btn').html('');
                }
                $('#modalViewMahasiswa').modal('show');
            });
        });
    </script>
@endsection

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .icon-circle-xs {
            width: 32px;
            height: 32px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
        }

        .bg-primary-light {
            background-color: rgba(59, 130, 246, 0.08);
        }

        .border-primary-10 {
            border-color: rgba(59, 130, 246, 0.15) !important;
        }

        .bg-info-lighter {
            background-color: rgba(13, 202, 240, 0.1);
        }

        .btn-white {
            background: #fff;
        }

        .btn-white:hover {
            background: #f8fafc;
        }

        .table-toolbar .input-group-modern .input-group-text,
        .table-toolbar .input-group-modern .form-control {
            border: none;
        }

        .table-toolbar .input-group-modern:focus-within {
            border-color: var(--bs-info) !important;
            box-shadow: 0 0 0 0.25rem rgba(13, 202, 240, 0.25);
        }

        /* DataTables Custom Pagination */
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #0dcaf0 !important;
            color: #fff !important;
            border: none !important;
            border-radius: 50% !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: #f8fafc !important;
            color: #0dcaf0 !important;
            border: none !important;
            border-radius: 50% !important;
        }

        /* Modern Detail Modal Styles */
        .avatar-ring {
            transition: transform 0.3s ease;
        }

        .avatar-ring:hover {
            transform: scale(1.05);
        }

        .detail-card {
            transition: all 0.25s ease-in-out;
            background: #f8fafc;
            padding: 10px 12px !important;
        }

        .detail-card .icon-box {
            width: 32px !important;
            height: 32px !important;
            min-width: 32px !important;
            margin-right: 10px !important;
        }

        .detail-card .icon-box i {
            font-size: 0.875rem !important;
        }

        .detail-card span.text-muted {
            font-size: 0.6rem !important;
        }

        #view-telp, #view-telp a, .detail-card a {
            word-break: break-all !important;
            white-space: normal !important;
        }

        .detail-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.04) !important;
            background: #fff;
            border-color: rgba(14, 165, 233, 0.25) !important;
        }

        .icon-box {
            transition: transform 0.2s ease;
        }

        .detail-card:hover .icon-box {
            transform: scale(1.1);
        }

        .fs-xs {
            font-size: 0.75rem;
        }

        .shadow-xs {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
        }

        /* Modern Table styling */
        .table-responsive {
            border-radius: 0.75rem;
            overflow: hidden;
            border: 1px solid #e2e8f0;
        }

        .js-dataTable-full {
            border-collapse: separate !important;
            border-spacing: 0 !important;
            width: 100% !important;
        }

        .js-dataTable-full thead th {
            background-color: #f8fafc !important;
            color: #475569 !important;
            font-size: 0.75rem !important;
            font-weight: 700 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.05em !important;
            padding: 14px 16px !important;
            border-bottom: 2px solid #e2e8f0 !important;
            border-top: none !important;
            white-space: nowrap;
        }

        .js-dataTable-full tbody tr {
            transition: all 0.2s ease-in-out;
        }

        .js-dataTable-full tbody tr:hover {
            background-color: rgba(241, 245, 249, 0.4) !important;
        }

        .js-dataTable-full tbody td {
            padding: 14px 16px !important;
            border-bottom: 1px solid #f1f5f9 !important;
            color: #334155;
            font-size: 0.875rem;
        }

        /* Modern Pagination styling */
        .dataTables_wrapper .dataTables_paginate {
            margin-top: 1.5rem !important;
            margin-bottom: 0.5rem !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border: 1px solid #e2e8f0 !important;
            background: #fff !important;
            color: #475569 !important;
            border-radius: 8px !important;
            padding: 6px 12px !important;
            margin: 0 3px !important;
            font-weight: 600 !important;
            font-size: 0.85rem !important;
            transition: all 0.2s !important;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05) !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: #f1f5f9 !important;
            color: #0f172a !important;
            border-color: #cbd5e1 !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            background: #0ea5e9 !important; /* Sky Blue for Mahasiswa */
            color: #fff !important;
            border-color: #0ea5e9 !important;
        }

        /* Modern Status Badges */
        .status-badge-aktif {
            background-color: #ecfdf5 !important;
            color: #059669 !important;
            border: 1px solid #a7f3d0 !important;
        }
        .status-badge-cuti {
            background-color: #fffbeb !important;
            color: #d97706 !important;
            border: 1px solid #fde68a !important;
        }
        .status-badge-do {
            background-color: #fff1f2 !important;
            color: #e11d48 !important;
            border: 1px solid #fecdd3 !important;
        }
        .status-badge-lulus, .status-badge-alumni {
            background-color: #e0e7ff !important;
            color: #4f46e5 !important;
            border: 1px solid #c7d2fe !important;
        }
        .status-badge-keluar {
            background-color: #f1f5f9 !important;
            color: #475569 !important;
            border: 1px solid #cbd5e1 !important;
        }

        /* View Button modern circle style */
        .btn-view {
            transition: all 0.2s ease-in-out !important;
            border: 1px solid #e2e8f0 !important;
            background-color: #fff !important;
            width: 34px !important;
            height: 34px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            border-radius: 50% !important;
            padding: 0 !important;
        }
        
        .btn-view:hover {
            background-color: #f8fafc !important;
            border-color: #cbd5e1 !important;
            transform: scale(1.05);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03) !important;
        }
    </style>
@endsection