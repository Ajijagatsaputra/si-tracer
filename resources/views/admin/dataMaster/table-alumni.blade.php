@extends('layouts.admin')

@section('content')
    <!-- Hero -->
    <div class="bg-white">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-2">
                        <span class="bg-primary-lighter p-2 rounded-3 me-2">
                            <i class="fa fa-graduation-cap text-primary"></i>
                        </span>
                        Data Alumni
                    </h1>
                    <p class="fs-sm fw-medium text-muted mb-0">
                        Kelola data alumni aktif, DO, dan cuti dengan sistem yang lebih cerdas dan modern.
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
                        <div class="col-12 col-xl-8">
                            <div class="d-flex flex-wrap align-items-center gap-3">
                                <!-- Angkatan Filter -->
                                <div class="d-flex align-items-center bg-white p-2 px-3 rounded-pill border shadow-sm">
                                    <label for="filter-tahun" class="mb-0 me-2 fw-bold text-muted fs-xs text-uppercase">
                                        <i class="fa fa-calendar-alt text-primary me-1"></i> Angkatan
                                    </label>
                                    <select id="filter-tahun" name="tahun_angkatan"
                                        class="form-select form-select-sm border-0 bg-transparent fw-bold text-primary p-0 h-auto"
                                        style="width: auto; min-width: 80px;">
                                        <option value="">Semua</option>
                                        @php $tahunSekarang = date('Y'); @endphp
                                        @for ($i = $tahunSekarang; $i >= 2018; $i--)
                                            <option value="{{ $i }}" {{ request('tahun_angkatan') == $i ? 'selected' : '' }}>
                                                {{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>

                                <!-- Total Badge -->
                                <div
                                    class="bg-primary-light text-primary px-3 py-2 rounded-pill shadow-sm fs-sm fw-bold border border-primary-lighter">
                                    <i class="fa fa-graduation-cap me-1"></i> <span id="jumlah-alumni">0</span> <small
                                        class="text-uppercase ms-1 opacity-75">Alumni</small>
                                </div>

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
                                    placeholder="Cari data alumni...">
                                <button class="btn btn-primary px-4 fw-semibold" id="searchBtn">Cari</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="table-responsive">
                    <table id="tabel-alumni" class="table align-middle table-hover js-dataTable-full w-100 border-0">
                        <thead>
                            <tr class="bg-light text-muted text-uppercase fs-xs fw-bold border-0">
                                <th class="py-3 px-4 border-0">Alumni</th>
                                <th class="py-3 border-0">NIM</th>
                                <th class="py-3 border-0">Prodi</th>
                                <th class="py-3 border-0 text-center">Kelas</th>
                                <th class="py-3 border-0 text-center">Angkatan</th>
                                <th class="py-3 border-0 text-center">Lulus</th>
                                <th class="py-3 border-0">Status</th>
                                <th class="py-3 border-0 text-center">Status Tracer</th>
                                <th class="py-3 border-0 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail -->
    <div class="modal fade" id="modalViewMahasiswa" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg overflow-hidden rounded-4">
                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3 z-3 bg-dark/20 backdrop-blur rounded-circle p-2 shadow-sm" data-bs-dismiss="modal" aria-label="Tutup" style="width: 32px; height: 32px; font-size: 0.75rem; border: none;"></button>
                <div class="modal-body p-0" id="modal-detail-content">
                    <!-- Content will be injected by JS -->
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        let table;

        function initDataTable(tahun) {
            // Matikan pop-up alert bawaan browser/DataTables
            $.fn.dataTable.ext.errMode = 'none';

            // Dengar event error dari DataTables
            $('#tabel-alumni').off('error.dt').on('error.dt', function (e, settings, techNote, message) {
                console.error('DataTables Error:', message);

                // Buat toast pemberitahuan yang elegan
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 8000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });

                Toast.fire({
                    icon: 'error',
                    title: '<span class="fw-bold text-dark fs-sm">Koneksi API OASE Bermasalah</span>',
                    html: '<div class="text-muted fs-xs text-start mt-1"><i class="fa fa-exclamation-circle me-1 text-danger"></i> Server API OASE Poltek Tegal sedang offline/timeout. Silakan hubungi admin atau coba lagi nanti.</div>'
                });
            });

            if (table) { table.destroy(); $('#tabel-alumni tbody').html(''); }

            table = $('#tabel-alumni').DataTable({
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
                },
                ajax: {
                    url: '{{ route('api.alumni') }}',
                    type: 'GET',
                    data: d => ({ tahun_angkatan: $('#filter-tahun').val() }),
                    dataSrc: json => {
                        $('#jumlah-alumni').text(json.data.length);
                        return json.data;
                    }
                },
                columns: [
                    { data: 'nama_lengkap', render: (data, type, row) => `
                        <div class="d-flex align-items-center py-1">
                            <img src="${row.avatar_url ?? 'https://ui-avatars.com/api/?name=' + encodeURIComponent(data || 'No Name') + '&background=4f46e5&color=fff&bold=true'}" class="shadow-sm border border-2 border-white" style="width:36px;height:36px;border-radius:12px;margin-right:12px;object-fit:cover;">
                            <div>
                                <div class="fw-bold text-dark">${data || '-'}</div>
                                <small class="text-muted d-sm-none">${row.nim || ''}</small>
                            </div>
                        </div>
                    `},
                    { data: 'nim', render: data => `<span class="text-muted fw-medium">${data || '-'}</span>` },
                    { data: 'prodi', render: data => `<div class="fs-xs fw-semibold text-primary bg-primary-light px-2 py-1 rounded-pill d-inline-block border border-primary-10">${data || '-'}</div>` },
                    { data: 'kelas', render: data => data || '-', className: 'text-center' },
                    { data: 'tahun_masuk', render: data => data || '-', className: 'text-center fw-bold text-muted' },
                    { data: 'tahun_lulus', render: data => data || '-', className: 'text-center fw-bold text-muted' },
                    { data: 'status_mahasiswa', render: data => {
                        const colors = {
                            'Lulus': 'status-badge-lulus',
                            'Aktif': 'status-badge-aktif',
                            'Cuti': 'status-badge-cuti',
                            'DO': 'status-badge-do',
                            'Alumni': 'status-badge-alumni'
                        };
                        return `<span class="badge ${colors[data] || 'bg-secondary text-white'} rounded-pill px-2.5 py-1.5 fs-xs fw-bold">${data || '-'}</span>`;
                    }},
                    { 
                        data: 'status_kuesioner', 
                        className: 'text-center',
                        render: (data, type, row) => {
                            if (data === 'sudah') {
                                return `<span class="badge status-badge-aktif rounded-pill px-2.5 py-1.5 fs-xs fw-bold"><i class="fa fa-check-circle me-1"></i>Sudah Mengisi</span>`;
                            } else {
                                return `<span class="badge status-badge-cuti rounded-pill px-2.5 py-1.5 fs-xs fw-bold"><i class="fa fa-clock me-1"></i>Belum Mengisi</span>`;
                            }
                        }
                    },
                    {
                        data: null,
                        orderable: false,
                        className: 'text-center',
                        render: data => `
                            <div class="dropdown d-inline-block">
                                <button type="button" class="btn btn-sm btn-alt-secondary" id="dropdown-alumni-${data.id}" data-bs-toggle="dropdown" data-bs-boundary="viewport" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-v"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end fs-sm" aria-labelledby="dropdown-alumni-${data.id}" style="min-width: 120px;">
                                    <a class="dropdown-item btn-view" href="javascript:void(0)"
                                        data-bs-toggle="modal" data-bs-target="#modalViewMahasiswa"
                                        data-nim="${data.nim || '-'}" data-nama="${data.nama_lengkap || 'No Name'}"
                                        data-prodi="${data.prodi || '-'}" data-alamat="${data.alamat || '-'}"
                                        data-no_hp="${data.no_hp || '-'}" data-kelas="${data.kelas || '-'}"
                                        data-jalur="${data.jalur || '-'}" data-tahun_masuk="${data.tahun_masuk || '-'}"
                                        data-tahun_lulus="${data.tahun_lulus || '-'}" data-status="${data.status_mahasiswa || '-'}"
                                        data-status_kuesioner="${data.status_kuesioner || 'belum'}"
                                        data-email="${data.users ? data.users.email : '-'}"
                                        data-updated="${data.updated_at || '-'}">
                                        <i class="fa fa-fw fa-eye text-primary me-2"></i> Detail
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item btn-delete text-danger" href="javascript:void(0)"
                                        data-id="${data.id}" data-nama="${data.nama_lengkap || 'No Name'}">
                                        <i class="fa fa-fw fa-trash-alt text-danger me-2"></i> Hapus
                                    </a>
                                </div>
                            </div>
                        `
                    }
                ]
            });
        }

        $(document).ready(function () {
            initDataTable($('#filter-tahun').val());
            $('#filter-tahun').on('change', function () { initDataTable($(this).val()); });

            $('#searchBtn').on('click', () => table.search($('#customSearch').val()).draw());
            $('#customSearch').on('keyup', e => { if (e.key === 'Enter') $('#searchBtn').click(); });

            $(document).on('click', '.btn-view', function () {
                const d = $(this).data();
                const colors = { 
                    'Lulus': 'bg-success text-white', 
                    'Aktif': 'bg-primary text-white', 
                    'Cuti': 'bg-warning text-dark', 
                    'DO': 'bg-danger text-white' 
                };
                const badgeClass = colors[d.status] || 'bg-secondary text-white';

                $('#modal-detail-content').html(`
                    <div class="row g-0">
                        <!-- Left Side: Profile Banner & Core Info -->
                        <div class="col-lg-5 text-white position-relative d-flex flex-column align-items-center justify-content-center p-4 py-5" 
                             style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); min-height: 420px;">
                             
                             <!-- Subtle background pattern decorative circles -->
                             <div class="position-absolute top-0 start-0 w-100 h-100 overflow-hidden" style="opacity: 0.15; pointer-events: none;">
                                 <div class="position-absolute rounded-circle bg-white" style="width: 200px; height: 200px; top: -50px; left: -50px;"></div>
                                 <div class="position-absolute rounded-circle bg-white" style="width: 150px; height: 150px; bottom: -30px; right: -30px;"></div>
                             </div>

                             <!-- Profile Header Content -->
                             <div class="text-center z-1 w-100 px-3">
                                 <div class="position-relative d-inline-block mb-3">
                                     <!-- Profile Avatar Ring -->
                                     <div class="avatar-ring p-1 rounded-circle bg-white/20 d-inline-block">
                                         <img class="modal-avatar rounded-circle shadow-sm" alt="Avatar Alumni" src="https://ui-avatars.com/api/?name=${encodeURIComponent(d.nama)}&background=4f46e5&color=fff&bold=true"
                                             style="width:110px; height:110px; object-fit:cover; border: 3px solid #fff;">
                                     </div>
                                     <!-- Glowing status badge positioned nicely -->
                                     <span class="position-absolute bottom-0 end-0 translate-middle-x badge rounded-pill border border-2 border-white shadow px-3 py-1 fs-xs fw-bold ${badgeClass}">${d.status}</span>
                                 </div>
                                 <h3 class="fw-bold mb-1 text-white fs-4">${d.nama}</h3>
                                 <p class="text-white/80 fs-sm mb-4 fw-medium">${d.prodi}</p>
                                 
                                 <div class="d-flex justify-content-center gap-2 pt-2">
                                     ${d.no_hp && d.no_hp !== '-' ? `<a href='https://wa.me/${d.no_hp}' target='_blank' class="btn btn-sm btn-light rounded-pill px-3 fw-bold text-success shadow-sm border-0"><i class="fab fa-whatsapp me-1"></i> WhatsApp</a>` : ''}
                                     <button type="button" class="btn btn-sm btn-white/25 text-white rounded-pill px-3 fw-bold shadow-sm border border-white/20" onclick="window.print()"><i class="fa fa-print me-1"></i> Cetak</button>
                                 </div>
                             </div>
                        </div>

                        <!-- Right Side: Grid of detailed cards -->
                        <div class="col-lg-7 bg-white p-4 p-md-5">
                            <div class="d-flex align-items-center justify-content-between mb-4 border-bottom pb-3">
                                <div>
                                    <h5 class="fw-bold text-dark mb-1">Detail Informasi Alumni</h5>
                                    <p class="text-muted fs-xs mb-0">Informasi lengkap akademik dan profil alumni</p>
                                </div>
                            </div>

                            <div class="row g-3">
                                <!-- NIM Card -->
                                <div class="col-sm-6">
                                    <div class="detail-card p-3 rounded-3 border border-light shadow-xs bg-light/30">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-box me-3 rounded-3 bg-primary/10 text-primary d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; min-width: 40px;">
                                                <i class="fa fa-id-card fs-5"></i>
                                            </div>
                                            <div>
                                                <span class="text-muted text-uppercase fw-bold text-xs d-block mb-0" style="font-size: 0.65rem; letter-spacing: 1px;">NIM</span>
                                                <span class="fw-bold text-dark fs-sm d-block">${d.nim}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Kelas Card -->
                                <div class="col-sm-6">
                                    <div class="detail-card p-3 rounded-3 border border-light shadow-xs bg-light/30">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-box me-3 rounded-3 bg-success/10 text-success d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; min-width: 40px;">
                                                <i class="fa fa-layer-group fs-5"></i>
                                            </div>
                                            <div>
                                                <span class="text-muted text-uppercase fw-bold text-xs d-block mb-0" style="font-size: 0.65rem; letter-spacing: 1px;">Kelas</span>
                                                <span class="fw-bold text-dark fs-sm d-block">${d.kelas}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Jalur Masuk Card -->
                                <div class="col-sm-6">
                                    <div class="detail-card p-3 rounded-3 border border-light shadow-xs bg-light/30">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-box me-3 rounded-3 bg-info/10 text-info d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; min-width: 40px;">
                                                <i class="fa fa-route fs-5"></i>
                                            </div>
                                            <div>
                                                <span class="text-muted text-uppercase fw-bold text-xs d-block mb-0" style="font-size: 0.65rem; letter-spacing: 1px;">Jalur Masuk</span>
                                                <span class="fw-bold text-dark fs-sm d-block">${d.jalur}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tahun Masuk Card -->
                                <div class="col-sm-6">
                                    <div class="detail-card p-3 rounded-3 border border-light shadow-xs bg-light/30">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-box me-3 rounded-3 bg-warning/10 text-warning d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; min-width: 40px;">
                                                <i class="fa fa-calendar-check fs-5"></i>
                                            </div>
                                            <div>
                                                <span class="text-muted text-uppercase fw-bold text-xs d-block mb-0" style="font-size: 0.65rem; letter-spacing: 1px;">Tahun Masuk</span>
                                                <span class="fw-bold text-dark fs-sm d-block">${d.tahun_masuk}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tahun Lulus Card -->
                                <div class="col-sm-6">
                                    <div class="detail-card p-3 rounded-3 border border-light shadow-xs bg-light/30">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-box me-3 rounded-3 bg-danger/10 text-danger d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; min-width: 40px;">
                                                <i class="fa fa-graduation-cap fs-5"></i>
                                            </div>
                                            <div>
                                                <span class="text-muted text-uppercase fw-bold text-xs d-block mb-0" style="font-size: 0.65rem; letter-spacing: 1px;">Tahun Lulus</span>
                                                <span class="fw-bold text-dark fs-sm d-block">${d.tahun_lulus}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- WhatsApp Card -->
                                <div class="col-sm-6">
                                    <div class="detail-card p-3 rounded-3 border border-light shadow-xs bg-light/30">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-box me-3 rounded-3 bg-success/10 text-success d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; min-width: 40px;">
                                                <i class="fab fa-whatsapp fs-5"></i>
                                            </div>
                                            <div>
                                                <span class="text-muted text-uppercase fw-bold text-xs d-block mb-0" style="font-size: 0.65rem; letter-spacing: 1px;">WhatsApp</span>
                                                <span class="fw-bold text-dark fs-sm d-block">${d.no_hp && d.no_hp !== '-' ? `<a href='https://wa.me/${d.no_hp}' class="text-success text-decoration-none fw-bold" target='_blank'>${d.no_hp}</a>` : '-'}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Status Kuesioner Card -->
                                <div class="col-sm-6">
                                    <div class="detail-card p-3 rounded-3 border border-light shadow-xs bg-light/30">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-box me-3 rounded-3 ${d.status_kuesioner === 'sudah' ? 'bg-success/10 text-success' : 'bg-warning/10 text-warning'} d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; min-width: 40px;">
                                                <i class="fa ${d.status_kuesioner === 'sudah' ? 'fa-check-circle' : 'fa-clock'} fs-5"></i>
                                            </div>
                                            <div>
                                                <span class="text-muted text-uppercase fw-bold text-xs d-block mb-0" style="font-size: 0.65rem; letter-spacing: 1px;">Status Tracer</span>
                                                <span class="fw-bold ${d.status_kuesioner === 'sudah' ? 'text-success' : 'text-warning'} fs-sm d-block">${d.status_kuesioner === 'sudah' ? 'Sudah Mengisi' : 'Belum Mengisi'}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Email Register Card -->
                                <div class="col-12">
                                    <div class="detail-card p-3 rounded-3 border border-light shadow-xs bg-light/30">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-box me-3 rounded-3 bg-danger/10 text-danger d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; min-width: 40px;">
                                                <i class="fa fa-envelope fs-5"></i>
                                            </div>
                                            <div class="w-100">
                                                <span class="text-muted text-uppercase fw-bold text-xs d-block mb-0" style="font-size: 0.65rem; letter-spacing: 1px;">Email Register</span>
                                                <span class="fw-bold text-dark fs-sm d-block text-wrap" style="word-break: break-all;">${d.email || '-'}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Alamat Card -->
                                <div class="col-12">
                                    <div class="detail-card p-3 rounded-3 border border-light shadow-xs bg-light/30">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-box me-3 rounded-3 bg-secondary/10 text-secondary d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; min-width: 40px;">
                                                <i class="fa fa-map-marker-alt fs-5"></i>
                                            </div>
                                            <div class="w-100">
                                                <span class="text-muted text-uppercase fw-bold text-xs d-block mb-0" style="font-size: 0.65rem; letter-spacing: 1px;">Alamat / Domisili</span>
                                                <span class="fw-bold text-dark fs-sm d-block text-wrap" style="max-height: 50px; overflow-y: auto;">${d.alamat || '-'}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Footer details / Quick info -->
                            <div class="mt-4 pt-3 border-top d-flex flex-wrap justify-content-between align-items-center gap-3">
                                <span class="text-muted fs-xs"><i class="fa fa-info-circle me-1"></i> Data alumni terverifikasi</span>
                                <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill px-4 shadow-sm" data-bs-dismiss="modal">
                                    <i class="fa fa-times me-1"></i> Tutup
                                </button>
                            </div>
                        </div>
                    </div>
                `);
            });

            // Handle Delete Button Click
            $(document).on('click', '.btn-delete', function (e) {
                e.preventDefault();
                const id = $(this).data('id');
                const nama = $(this).data('nama');

                Swal.fire({
                    title: 'Hapus Alumni?',
                    html: `Apakah Anda yakin ingin menghapus alumni <b>${nama}</b>?<br><span class="text-danger small">Tindakan ini akan menghapus akun dan semua data kuesioner terkait.</span>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal',
                    customClass: {
                        popup: 'swal-modern',
                        confirmButton: 'btn-modern btn-modern-danger',
                        cancelButton: 'btn-modern btn-modern-secondary'
                    },
                    buttonsStyling: false,
                    focusCancel: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show loading state
                        Swal.fire({
                            title: 'Memproses...',
                            text: 'Sedang menghapus data alumni',
                            allowOutsideClick: false,
                            customClass: {
                                popup: 'swal-modern'
                            },
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        // Ajax call
                        $.ajax({
                            url: `/admin/alumni/${id}`,
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                _method: 'DELETE'
                            },
                            success: function (response) {
                                if (response.success) {
                                    Swal.fire({
                                        title: 'Berhasil!',
                                        text: response.message,
                                        icon: 'success',
                                        customClass: {
                                            popup: 'swal-modern'
                                        }
                                    }).then(() => {
                                        // Reload DataTable
                                        table.ajax.reload();
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Gagal!',
                                        text: response.message,
                                        icon: 'error',
                                        customClass: {
                                            popup: 'swal-modern'
                                        }
                                    });
                                }
                            },
                            error: function (xhr) {
                                console.error(xhr);
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Terjadi kesalahan saat menghapus data alumni.',
                                    icon: 'error',
                                    customClass: {
                                        popup: 'swal-modern'
                                    }
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection

@section('styles')
    <style>
        .bg-primary-light {
            background-color: rgba(6, 101, 208, 0.08);
        }

        .border-primary-10 {
            border-color: rgba(6, 101, 208, 0.15) !important;
        }

        .bg-primary-lighter {
            background-color: rgba(13, 110, 253, 0.1);
        }

        .bg-success-lighter {
            background-color: rgba(25, 135, 84, 0.1);
        }

        .bg-warning-lighter {
            background-color: rgba(255, 193, 7, 0.1);
        }

        .bg-danger-lighter {
            background-color: rgba(220, 53, 69, 0.1);
        }

        .bg-info-lighter {
            background-color: rgba(13, 202, 240, 0.1);
        }

        .icon-circle-xs {
            width: 36px;
            height: 36px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
        }

        .btn-white {
            background: #fff;
        }

        .btn-white:hover {
            background: #f8fafc;
        }

        .card-modern {
            border-radius: 1rem;
        }

        .hover-scale {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .hover-scale:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05) !important;
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
            border-color: rgba(79, 70, 229, 0.25) !important;
            background: #fff;
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
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        }

        /* Modern Table styling */
        .table-responsive {
            border-radius: 0.75rem;
            border: 1px solid #e2e8f0;
            overflow: visible;
        }

        @media (max-width: 991.98px) {
            .table-responsive {
                overflow-x: auto;
            }
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
            transition: background-color 0.2s ease-in-out;
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
            background: #4f46e5 !important; /* Indigo for Alumni */
            color: #fff !important;
            border-color: #4f46e5 !important;
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
        /* Fix dropdown overlap pada tabel */
        .js-dataTable-full tbody tr {
            position: relative;
            z-index: 1;
        }
        .js-dataTable-full tbody tr.dropdown-row-active {
            z-index: 999 !important;
        }
        .js-dataTable-full .dropdown-menu {
            z-index: 1050 !important;
        }
    </style>

    <script>
        // Fix: Pastikan dropdown tidak tertutup oleh baris hover di bawahnya
        document.addEventListener('shown.bs.dropdown', function(e) {
            var row = e.target.closest('tr');
            if (row) row.classList.add('dropdown-row-active');
        });
        document.addEventListener('hidden.bs.dropdown', function(e) {
            var row = e.target.closest('tr');
            if (row) row.classList.remove('dropdown-row-active');
        });
    </script>
@endsection