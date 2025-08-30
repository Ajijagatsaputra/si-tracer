<!DOCTYPE html>
<html lang="id">
<head>
    @include('components.admin.head')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <style>
        body { background: #f4f7fb; }

        /* Table modern style */
        .table-custom thead th {
            background: linear-gradient(90deg, #f0f4ff, #f8faff);
            font-weight: 600; color: #374151; border-bottom: 2px solid #e5e7eb;
        }
        .table-custom tbody tr:nth-child(odd) { background-color: #f9fafb; }
        .table-custom tbody tr:nth-child(even) { background: #ffffff; }
        .table-custom tbody tr:hover { background: #eef6ff; transition: .25s; }
        .table-custom th, .table-custom td { vertical-align: middle; padding: 12px; }

        /* Toolbar buttons */
        .dt-toolbar .btn {
            border-radius: 2rem; font-weight: 500; padding: 6px 14px; transition: .25s;
        }
        .dt-toolbar .btn:hover {
            transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,.12);
        }

        /* Badge style */
        .badge-status {
            padding: .4em 1em; border-radius: 1rem; font-size: .85rem; font-weight: 600; display: inline-block;
        }
        .badge-aktif { background:#d1fae5; color:#065f46; }
        .badge-cuti { background:#fef3c7; color:#92400e; }
        .badge-do { background:#fee2e2; color:#991b1b; }
        .badge-lulus { background:#ccfbf1; color:#115e59; }
        .badge-keluar { background:#ede9fe; color:#4c1d95; }

        /* View button */
        .btn-view { background:#e0f2fe; color:#0369a1; border-radius:1rem; }
        .btn-view:hover { background:#bae6fd; color:#075985; }

        /* Modal */
        .modal-content {
            border-radius: 1.5rem; border: none; box-shadow: 0 12px 40px rgba(0,0,0,.12);
        }
        .modal-header {
            border: none; border-radius: 1.5rem 1.5rem 0 0; background: linear-gradient(90deg, #e0f2fe, #f9fafb);
        }
        .modal-title { font-weight: 600; color: #1e40af; }
        .modal-avatar {
            width:100px; height:100px; border-radius:50%; object-fit:cover;
            box-shadow:0 4px 18px rgba(0,0,0,.15); margin-bottom:1rem;
        }
        .modal-profile-title { font-weight:700; font-size:1.25rem; color:#111827; }
        .modal-profile-subtitle { font-size:.95rem; color:#6b7280; }
        .dl-grid { display:grid; grid-template-columns:1fr 2.5fr; gap:.5em .8em; margin-top:1.5rem; }
        .dl-grid .ico { text-align:center; opacity:.8; }
        @media (max-width:576px){ .dl-grid { grid-template-columns:1fr; } }

        /* Select2 */
        .select2-container .select2-selection--single {
            height:38px!important; border-radius:.75rem!important; border-color:#d1d5db;
            display:flex; align-items:center; padding-left:.5rem;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            top:6px; right:6px;
        }
    </style>
</head>
<body>
<div id="page-container" class="sidebar-o sidebar-dark enable-page-overlay side-scroll page-header-fixed main-content-narrow">
    @include('components.admin.admin-header')
    @include('components.admin.sidebar')
    @include('components.admin.side-overlay')

    <main id="main-container">
        <div class="py-4 bg-body-light border-bottom">
            <div class="content d-flex flex-column flex-sm-row justify-content-between align-items-center">
                <div>
                    <h1 class="mb-1 h3 fw-bold">📚 Data Mahasiswa</h1>
                    <p class="mb-0 text-muted fs-sm">Kelola data mahasiswa aktif, cuti, DO, lulus, dan keluar dengan mudah.</p>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="block shadow-sm block-rounded">
                <div class="block-content block-content-full">
                    <!-- Filter Tahun Angkatan -->
                    <div class="mb-3">
                        <label for="filter-tahun" class="form-label fw-semibold me-2">Tahun Angkatan:</label>
                        <select id="filter-tahun" class="form-select d-inline-block" style="min-width:150px"></select>
                    </div>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table align-middle table-custom table-bordered js-dataTable-full w-100"></table>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('components.admin.footer')
</div>

<!-- Modal Detail -->
<div class="modal fade" id="modalViewMahasiswa" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa-solid fa-user-graduate me-2"></i>Detail Mahasiswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="text-center modal-body">
                <img id="view-avatar" class="modal-avatar" alt="Avatar Mahasiswa">
                <div class="modal-profile-title" id="view-nama"></div>
                <div class="modal-profile-subtitle" id="view-prodi"></div>
                <div class="dl-grid text-start">
                    <div class="ico"><i class="fa-solid fa-id-card"></i></div>
                    <div id="view-nim"></div>
                    <div class="ico"><i class="fa-solid fa-layer-group"></i></div>
                    <div id="view-kelas"></div>
                    <div class="ico"><i class="fa-solid fa-route"></i></div>
                    <div id="view-jalur"></div>
                    <div class="ico"><i class="fa-solid fa-calendar-check"></i></div>
                    <div id="view-tahun"></div>
                    <div class="ico"><i class="fa-solid fa-graduation-cap"></i></div>
                    <div id="view-semester"></div>
                    <div class="ico"><i class="fa-solid fa-circle-check"></i></div>
                    <div id="view-status"></div>
                    <div class="ico"><i class="fa-brands fa-whatsapp"></i></div>
                    <div id="view-telp"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JS Libs -->
<script src="assets/js/lib/jquery.min.js"></script>
<script src="assets/js/oneui.app.min.js"></script>
<script src="assets/js/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="assets/js/plugins/datatables-bs5/js/dataTables.bootstrap5.min.js"></script>
<script src="assets/js/plugins/datatables-buttons/dataTables.buttons.min.js"></script>
<script src="assets/js/plugins/datatables-buttons-bs5/js/buttons.bootstrap5.min.js"></script>
<script src="assets/js/plugins/datatables-buttons-jszip/jszip.min.js"></script>
<script src="assets/js/plugins/datatables-buttons-pdfmake/pdfmake.min.js"></script>
<script src="assets/js/plugins/datatables-buttons-pdfmake/vfs_fonts.js"></script>
<script src="assets/js/plugins/datatables-buttons/buttons.html5.min.js"></script>
<script src="assets/js/plugins/datatables-buttons/buttons.print.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    let table;

    // Mapping status → badge
    function renderStatusBadge(status) {
        const map = {
            'Aktif': 'badge-aktif',
            'Cuti': 'badge-cuti',
            'DO': 'badge-do',
            'Lulus': 'badge-lulus',
            'Keluar': 'badge-keluar'
        };
        return `<span class="badge-status ${map[status]||'badge-do'}">${status}</span>`;
    }

    function initDataTable(tahunAngkatan) {
        if (table) { table.destroy(); $('.js-dataTable-full').empty(); }
        $('.js-dataTable-full').html(`
            <thead><tr>
                <th>NIM</th><th>Nama</th><th>Prodi</th><th>Semester</th>
                <th>Kelas</th><th>Jalur</th><th>Tahun Masuk</th>
                <th>Status</th><th>No. Telp</th><th>Aksi</th>
            </tr></thead><tbody></tbody>`);

        table = $('.js-dataTable-full').DataTable({
            paging:true, searching:true, ordering:true, responsive:true, pageLength:15,
            dom:"<'dt-toolbar row mb-3'<'col-md-6'B><'col-md-6 text-end'f>>t<'row'<'col-sm-5'i><'col-sm-7'p>>",
            buttons:[
                {extend:'excelHtml5', className:'btn btn-success btn-sm', text:'<i class="fa fa-file-excel me-1"></i> Excel'},
                {extend:'pdfHtml5', className:'btn btn-danger btn-sm', text:'<i class="fa fa-file-pdf me-1"></i> PDF', orientation:'landscape', pageSize:'A4'},
                {extend:'print', className:'btn btn-info btn-sm', text:'<i class="fa fa-print me-1"></i> Cetak'}
            ],
            ajax:{
                url:'{{ route('api.mahasiswa') }}', type:'GET',
                data:{ tahun_angkatan:tahunAngkatan },
                dataSrc: json => json.status ? json.data.map(item => ({
                    nim:item.nim,
                    nama:`<div class='d-flex align-items-center'>
                            <img src="${item.avatar_url??'https://ui-avatars.com/api/?name='+encodeURIComponent(item.nama_lengkap)}" style="width:32px;height:32px;border-radius:50%;margin-right:8px;object-fit:cover;">${item.nama_lengkap}
                          </div>`,
                    prodi:item.prodi?.nama||'',
                    semester:item.semester,
                    kelas:item.kelas,
                    jalur:item.jalur,
                    tahun_masuk:item.tahun_masuk,
                    status: renderStatusBadge(item.status_mahasiswa),
                    telp: item.no_whatsapp?`<a href='https://wa.me/${item.no_whatsapp}' target='_blank'><i class='fa-brands fa-whatsapp'></i> ${item.no_whatsapp}</a>`:'-',
                    aksi:`<button class='btn btn-view btn-sm'
                            data-nim='${item.nim}' data-nama='${item.nama_lengkap}' data-prodi='${item.prodi?.nama||''}'
                            data-semester='${item.semester}' data-kelas='${item.kelas}' data-jalur='${item.jalur}'
                            data-tahun='${item.tahun_masuk}' data-status='${item.status_mahasiswa}'
                            data-telp='${item.no_whatsapp||''}' data-avatar='${item.avatar_url??''}'><i class='fa fa-eye'></i></button>`
                })) : []
            },
            columns:[
                {data:'nim'},{data:'nama'},{data:'prodi'},{data:'semester'},{data:'kelas'},{data:'jalur'},
                {data:'tahun_masuk'},{data:'status'},{data:'telp'},{data:'aksi',orderable:false}
            ]
        });
    }

    $(function(){
        // Populate tahun options
        let now = new Date().getFullYear();
        for(let y=now;y>=2015;y--){ $('#filter-tahun').append(`<option value='${y}' ${y===2021?'selected':''}>${y}</option>`); }
        $('#filter-tahun').select2({ minimumResultsForSearch:-1, width:'style' });

        initDataTable($('#filter-tahun').val());
        $('#filter-tahun').on('change', ()=>initDataTable($('#filter-tahun').val()));

        $(document).on('click','.btn-view',function(){
            let data=$(this).data();
            $('#view-avatar').attr('src', data.avatar?data.avatar:`https://ui-avatars.com/api/?name=${encodeURIComponent(data.nama)}`);
            $('#view-nama').text(data.nama);
            $('#view-prodi').text(data.prodi);
            $('#view-nim').text(data.nim);
            $('#view-kelas').text(data.kelas);
            $('#view-jalur').text(data.jalur);
            $('#view-tahun').text(data.tahun);
            $('#view-semester').text(data.semester);
            $('#view-status').html(renderStatusBadge(data.status));
            $('#view-telp').html(data.telp?`<a href='https://wa.me/${data.telp}' target='_blank'>${data.telp}</a>`:'-');
            $('#modalViewMahasiswa').modal('show');
        });
    });
</script>
</body>
</html>
