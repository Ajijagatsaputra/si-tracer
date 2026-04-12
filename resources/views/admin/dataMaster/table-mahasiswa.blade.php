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
                                    <select id="filter-tahun" class="form-select form-select-sm border-0 bg-transparent fw-bold text-info p-0 h-auto" style="width: auto; min-width: 80px;"></select>
                                </div>

                                <!-- Total Badge -->
                                <div class="bg-info-light text-info px-3 py-2 rounded-pill shadow-sm fs-sm fw-bold border border-info-lighter">
                                    <i class="fa fa-users me-1"></i> <span id="jumlah-mahasiswa">0</span> <small class="text-uppercase ms-1 opacity-75">Mahasiswa</small>
                                </div>

                                <!-- Entries Selection -->
                                <div id="entries-container" class="ms-md-auto"></div>
                            </div>
                        </div>
                        
                        <!-- Search Group -->
                        <div class="col-12 col-xl-4 text-xl-end">
                            <div class="input-group input-group-modern shadow-sm border rounded-pill overflow-hidden bg-white">
                                <span class="input-group-text border-0 bg-white ps-3">
                                    <i class="fa fa-search text-muted"></i>
                                </span>
                                <input type="text" id="customSearch" class="form-control border-0 fs-sm" placeholder="Cari data mahasiswa...">
                                <button class="btn btn-info px-4 fw-semibold shadow-sm text-white" id="searchBtn">Cari</button>
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
                <div class="modal-header bg-info py-3 px-4 border-0">
                    <h5 class="modal-title text-white mb-0 fw-bold">
                        <i class="fa-solid fa-user-graduate me-2"></i>Detail Mahasiswa
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body p-4 text-center">
                    <div class="position-relative d-inline-block mb-4">
                        <img id="view-avatar" class="modal-avatar" alt="Avatar Mahasiswa" style="width:120px; height:120px; border-radius:30px; object-fit:cover; border: 4px solid #fff; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                        <span id="view-status-badge" class="position-absolute bottom-0 end-0 translate-middle-x badge rounded-pill border border-2 border-white shadow-sm px-2 py-1 fs-xs">Active</span>
                    </div>
                    <div class="modal-profile-title h4 fw-bold mb-1" id="view-nama"></div>
                    <div class="modal-profile-subtitle text-muted mb-4" id="view-prodi"></div>
                    
                    <div class="row text-start g-3 p-3 bg-light rounded-4 mx-1">
                        <div class="col-md-6 mb-2">
                            <div class="d-flex align-items-center">
                                <div class="icon-circle-xs bg-white text-info me-3 shadow-sm"><i class="fa-solid fa-id-card"></i></div>
                                <div><small class="text-muted d-block">NIM</small><span id="view-nim" class="fw-bold"></span></div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="d-flex align-items-center">
                                <div class="icon-circle-xs bg-white text-info me-3 shadow-sm"><i class="fa-solid fa-layer-group"></i></div>
                                <div><small class="text-muted d-block">Kelas</small><span id="view-kelas" class="fw-bold"></span></div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="d-flex align-items-center">
                                <div class="icon-circle-xs bg-white text-info me-3 shadow-sm"><i class="fa-solid fa-route"></i></div>
                                <div><small class="text-muted d-block">Jalur</small><span id="view-jalur" class="fw-bold"></span></div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="d-flex align-items-center">
                                <div class="icon-circle-xs bg-white text-info me-3 shadow-sm"><i class="fa-solid fa-calendar-check"></i></div>
                                <div><small class="text-muted d-block">Tahun Masuk</small><span id="view-tahun" class="fw-bold"></span></div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="d-flex align-items-center">
                                <div class="icon-circle-xs bg-white text-info me-3 shadow-sm"><i class="fa-solid fa-graduation-cap"></i></div>
                                <div><small class="text-muted d-block">Semester</small><span id="view-semester" class="fw-bold"></span></div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="d-flex align-items-center">
                                <div class="icon-circle-xs bg-white text-info me-3 shadow-sm"><i class="fa-brands fa-whatsapp"></i></div>
                                <div><small class="text-muted d-block">WhatApp</small><span id="view-telp" class="fw-bold"></span></div>
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
                'Aktif': 'bg-success',
                'Cuti': 'bg-warning text-dark',
                'DO': 'bg-danger',
                'Lulus': 'bg-info',
                'Keluar': 'bg-secondary'
            };
            return `<span class="badge ${map[status]||'bg-secondary'} rounded-pill px-2 py-1 fs-xs border shadow-sm">${status}</span>`;
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
                paging:true, 
                searching:true, 
                ordering:true, 
                responsive:true, 
                pageLength:15,
                autoWidth: false,
                dom: "<'row mt-3 mb-1'<'col-sm-12'B>>" +
                     "<'row'<'col-sm-12 table-responsive'tr>>" +
                     "<'row mt-3'<'col-sm-12 col-md-5 fs-sm text-muted'i><'col-sm-12 col-md-7 d-flex justify-content-md-end'p>>",
                buttons:[
                    {extend:'excelHtml5', className:'btn btn-sm btn-success rounded-pill px-3 shadow-sm border-0 me-2', text:'<i class="fa fa-file-excel me-1"></i> Excel'},
                    {extend:'pdfHtml5', className:'btn btn-sm btn-danger rounded-pill px-3 shadow-sm border-0 me-2', text:'<i class="fa fa-file-pdf me-1"></i> PDF', orientation:'landscape', pageSize:'A4'},
                    {extend:'print', className:'btn btn-sm btn-info rounded-pill px-3 shadow-sm border-0', text:'<i class="fa fa-print me-1"></i> Cetak'}
                ],
                initComplete: function() {
                    $('#entries-container').empty();
                    let lengthMenu = $('.dataTables_length').detach();
                    $('#entries-container').append(lengthMenu);
                    $('#customSearch').on('keyup', function() { table.search(this.value).draw(); });
                    $('#searchBtn').on('click', function() { table.search($('#customSearch').val()).draw(); });
                },
                ajax:{
                    url:'{{ route('api.mahasiswa') }}', type:'GET',
                    data:{ tahun_angkatan:tahunAngkatan },
                    dataSrc: json => {
                        if (json.status) { $('#jumlah-mahasiswa').text(json.data.length); }
                        return json.status ? json.data.map(item => ({
                        nama:`<div class='d-flex align-items-center py-1'>
                                <img src="${item.avatar_url??'https://ui-avatars.com/api/?name='+encodeURIComponent(item.nama_lengkap)}" class="shadow-sm border border-2 border-white" style="width:36px;height:36px;border-radius:12px;margin-right:12px;object-fit:cover;">
                                <div><div class="fw-bold text-dark">${item.nama_lengkap}</div><small class="text-muted d-sm-none">${item.nim}</small></div>
                              </div>`,
                        nim:`<span class="text-muted fw-medium">${item.nim}</span>`,
                        prodi:`<div class="fs-xs fw-semibold text-primary bg-primary-light px-2 py-1 rounded-pill d-inline-block border border-primary-10">${item.prodi?.nama||'N/A'}</div>`,
                        semester:item.semester,
                        kelas:`<div class="text-center fw-bold">${item.kelas}</div>`,
                        jalur:item.jalur,
                        tahun_masuk:item.tahun_masuk,
                        status: renderStatusBadge(item.status_mahasiswa),
                        aksi:`<div class="text-center">
                                <button class="btn btn-sm btn-white rounded-pill px-3 shadow-sm border btn-view" 
                                    data-nim='${item.nim}' data-nama='${item.nama_lengkap}' data-prodi='${item.prodi?.nama||''}'
                                    data-semester='${item.semester}' data-kelas='${item.kelas}' data-jalur='${item.jalur}'
                                    data-tahun='${item.tahun_masuk}' data-status='${item.status_mahasiswa}'
                                    data-telp='${item.no_whatsapp||''}' data-avatar='${item.avatar_url??''}'><i class="fa fa-eye text-primary"></i></button>
                             </div>`
                        })) : [];
                    }
                },
                columns:[
                    {data:'nama'},{data:'nim'},{data:'prodi'},{data:'semester'},{data:'kelas'},{data:'jalur'},
                    {data:'tahun_masuk'},{data:'status'},{data:'aksi',orderable:false}
                ]
            });
        }

        $(function(){
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
                
                // Status badge in modal
                const statusMap = {'Aktif':'bg-success','Cuti':'bg-warning text-dark','DO':'bg-danger','Lulus':'bg-info','Keluar':'bg-secondary'};
                $('#view-status-badge').text(data.status).attr('class', 'position-absolute bottom-0 end-0 translate-middle-x badge rounded-pill border border-2 border-white shadow-sm px-2 py-1 fs-xs ' + (statusMap[data.status]||'bg-secondary'));
                
                $('#view-telp').html(data.telp?`<a href='https://wa.me/${data.telp}' class="text-info text-decoration-none fw-bold" target='_blank'><i class="fa-brands fa-whatsapp me-1"></i>${data.telp}</a>`:'-');
                $('#modalViewMahasiswa').modal('show');
            });
        });
    </script>
@endsection

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .icon-circle-xs { width: 32px; height: 32px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 0.8rem; }
        .bg-primary-light { background-color: rgba(59, 130, 246, 0.08); }
        .border-primary-10 { border-color: rgba(59, 130, 246, 0.15) !important; }
        .bg-info-lighter { background-color: rgba(13, 202, 240, 0.1); }
        .btn-white { background: #fff; }
        .btn-white:hover { background: #f8fafc; }
        .table-toolbar .input-group-modern .input-group-text, .table-toolbar .input-group-modern .form-control { border: none; }
        .table-toolbar .input-group-modern:focus-within { border-color: var(--bs-info) !important; box-shadow: 0 0 0 0.25rem rgba(13, 202, 240, 0.25); }
        
        /* DataTables Custom Pagination */
        .dataTables_wrapper .dataTables_paginate .paginate_button.current { background: #0dcaf0 !important; color: #fff !important; border: none !important; border-radius: 50% !important; }
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover { background: #f8fafc !important; color: #0dcaf0 !important; border: none !important; border-radius: 50% !important; }
    </style>
@endsection
