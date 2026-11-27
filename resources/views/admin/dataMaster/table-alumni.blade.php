@extends('layouts.admin')

@section('content')
    <div class="akila-page-wrap">
        <!-- Breadcrumb -->
        <div class="akila-breadcrumb">
            <a href="{{ route('admin.dashboard') }}"><i class="fa fa-home me-1"></i> Home</a>
            <span class="sep">&rsaquo;</span>
            <span class="active">Daftar Alumni</span>
        </div>

        <!-- Main Card -->
        <div class="akila-list-card">
            <div class="akila-card-header">
                <div>
                    <h1 class="akila-title">Daftar Alumni</h1>
                    <p class="akila-subtitle">Kelola semua data alumni terdaftar dan status pengisian kuesioner di sistem.</p>
                </div>
                <div class="akila-header-actions">
                    <div class="d-inline-flex align-items-center gap-2">
                        <label for="filter-tahun" class="text-muted mb-0" style="font-size: 0.8rem; font-weight: 600;">Angkatan:</label>
                        <select id="filter-tahun" name="tahun_angkatan" class="akila-length-select" style="min-width: 115px;">
                            <option value="">Semua Tahun</option>
                            @php $tahunSekarang = date('Y'); @endphp
                            @for ($i = $tahunSekarang; $i >= 2018; $i--)
                                <option value="{{ $i }}" {{ request('tahun_angkatan') == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div id="export-buttons-container" class="d-inline-flex gap-1"></div>
                </div>
            </div>

            <!-- Length & Summary Row -->
            <div class="akila-toolbar-row">
                <div id="entries-container" class="akila-length-wrap"></div>
                <div class="akila-stat-chip">
                    <i class="fa fa-user-graduate text-muted"></i>
                    <span>Total Terdata: <strong id="jumlah-alumni">0</strong> Alumni</span>
                </div>
            </div>

            <!-- Table -->
            <div class="akila-table-wrapper">
                <table id="tabel-alumni" class="table akila-table align-middle w-100">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 38px;">
                                <input type="checkbox" class="form-check-input akila-checkbox" id="check-all-alumni">
                            </th>
                            <th class="text-center" style="width: 56px;">No.</th>
                            <th>Nama Alumni</th>
                            <th>NIM & Kontak</th>
                            <th>Tipe Akademik</th>
                            <th>Angkatan & Lulus</th>
                            <th class="text-center">Status</th>
                            <th class="text-center" style="width: 96px;">Aksi</th>
                        </tr>
                        <tr class="akila-filter-row">
                            <th></th>
                            <th class="text-center"><span class="akila-no-pill">No</span></th>
                            <th>
                                <div class="akila-filter-input">
                                    <i class="fa fa-search"></i>
                                    <input type="text" class="col-filter" data-col="2" placeholder="Cari nama alumni...">
                                </div>
                            </th>
                            <th>
                                <div class="akila-filter-input">
                                    <i class="fa fa-search"></i>
                                    <input type="text" class="col-filter" data-col="3" placeholder="Cari NIM / email...">
                                </div>
                            </th>
                            <th>
                                <select class="akila-filter-select col-filter-select" data-col="4" id="filter-prodi-col">
                                    <option value="">Semua Prodi</option>
                                    <option value="Teknik Informatika">Teknik Informatika</option>
                                </select>
                            </th>
                            <th>
                                <div class="akila-filter-input">
                                    <i class="fa fa-search"></i>
                                    <input type="text" class="col-filter" data-col="5" placeholder="Cari tahun...">
                                </div>
                            </th>
                            <th>
                                <select class="akila-filter-select col-filter-select" data-col="6">
                                    <option value="">Semua Status</option>
                                    <option value="Lengkap">Lengkap (Sudah Isi)</option>
                                    <option value="Belum Lengkap">Belum Lengkap</option>
                                </select>
                            </th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Detail -->
    <div class="modal fade" id="modalViewMahasiswa" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg overflow-hidden rounded-4">
                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3 z-3 bg-dark/20 backdrop-blur rounded-circle p-2 shadow-sm" data-bs-dismiss="modal" aria-label="Tutup" style="width: 32px; height: 32px; font-size: 0.75rem; border: none;"></button>
                <div class="modal-body p-0" id="modal-detail-content"></div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        let table;

        function initDataTable() {
            $.fn.dataTable.ext.errMode = 'none';

            $('#tabel-alumni').off('error.dt').on('error.dt', function (e, settings, techNote, message) {
                console.error('DataTables Error:', message);
            });

            if (table) {
                table.destroy();
                $('#tabel-alumni tbody').empty();
            }

            table = $('#tabel-alumni').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                orderCellsTop: true,
                pageLength: 10,
                lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
                autoWidth: false,
                order: [[1, 'asc']],
                dom: "lBrt<'row align-items-center mt-3'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 d-flex justify-content-md-end'p>>",
                language: {
                    lengthMenu: 'Tampilkan _MENU_ data',
                    info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                    infoEmpty: 'Tidak ada data tersedia',
                    infoFiltered: '(difilter dari _MAX_ total data)',
                    zeroRecords: 'Tidak ada data alumni yang cocok dengan pencarian.',
                    emptyTable: 'Belum ada data alumni tersedia.',
                    paginate: { first: '&laquo;', last: '&raquo;', next: '&rsaquo;', previous: '&lsaquo;' }
                },
                buttons: [
                    { extend: 'excelHtml5', className: 'btn btn-sm', text: '<i class="fa fa-file-excel text-success me-1"></i> Excel', exportOptions: { columns: [1, 2, 3, 4, 5, 6] } },
                    { extend: 'pdfHtml5', className: 'btn btn-sm', text: '<i class="fa fa-file-pdf text-danger me-1"></i> PDF', orientation: 'landscape', pageSize: 'A4', exportOptions: { columns: [1, 2, 3, 4, 5, 6] } },
                    { extend: 'print', className: 'btn btn-sm', text: '<i class="fa fa-print text-secondary me-1"></i> Cetak', exportOptions: { columns: [1, 2, 3, 4, 5, 6] } }
                ],
                initComplete: function () {
                    $('#entries-container').empty().append($('.dataTables_length').detach());
                    $('#export-buttons-container').empty().append(table.buttons().container());

                    // Populate unique prodi options dynamically
                    const prodiSet = new Set();
                    table.column(4).data().each(function (val) {
                        const text = $('<div>').html(val).text().trim();
                        if (text) prodiSet.add(text.split('Kelas')[0].trim());
                    });
                    const $prodiSelect = $('#filter-prodi-col');
                    $prodiSelect.find('option:not(:first)').remove();
                    prodiSet.forEach(p => {
                        if (p && p !== '-') $prodiSelect.append(`<option value="${p}">${p}</option>`);
                    });
                },
                ajax: {
                    url: '{{ route('api.alumni') }}',
                    type: 'GET',
                    data: () => ({ tahun_angkatan: $('#filter-tahun').val() }),
                    dataSrc: json => {
                        const data = json.data || [];
                        $('#jumlah-alumni').text(data.length);
                        return data;
                    },
                    error: function () {
                        $('#jumlah-alumni').text('0');
                    }
                },
                columns: [
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        className: 'text-center',
                        render: row => `<input type="checkbox" class="form-check-input akila-checkbox row-check" value="${row.id || ''}">`
                    },
                    {
                        data: null,
                        className: 'text-center text-muted fw-semibold',
                        render: (data, type, row, meta) => meta.row + 1
                    },
                    {
                        data: 'nama_lengkap',
                        render: (data, type, row) => {
                            const name = data || '-';
                            const avatar = row.avatar_url || `https://ui-avatars.com/api/?name=${encodeURIComponent(name)}&background=e2e8f0&color=334155&bold=true`;
                            return `
                                <div class="d-flex align-items-center gap-2">
                                    <img src="${avatar}" alt="" class="akila-person-avatar" style="width:30px;height:30px;">
                                    <div>
                                        <div class="akila-cell-title">${name}</div>
                                        <div class="akila-cell-desc" style="font-size:0.75rem;">${row.alamat ? (row.alamat.length > 42 ? row.alamat.substring(0, 42) + '...' : row.alamat) : 'Domisili belum diisi'}</div>
                                    </div>
                                </div>`;
                        }
                    },
                    {
                        data: 'nim',
                        render: (data, type, row) => {
                            const email = row.users && row.users.email ? row.users.email : (row.no_hp || '-');
                            return `
                                <div class="akila-cell-title">${data || '-'}</div>
                                <div class="akila-cell-desc" style="font-size:0.75rem;">${email}</div>`;
                        }
                    },
                    {
                        data: 'prodi',
                        render: (data, type, row) => `
                            <div class="d-flex flex-wrap gap-1">
                                <span class="akila-badge akila-badge-outline">${data || '-'}</span>
                                ${row.kelas ? `<span class="akila-badge akila-badge-orange">Kelas ${row.kelas}</span>` : ''}
                                ${row.jalur ? `<span class="akila-badge akila-badge-blue">${row.jalur}</span>` : ''}
                            </div>`
                    },
                    {
                        data: 'tahun_masuk',
                        render: (data, type, row) => `
                            <div class="akila-person">
                                <span class="akila-person-avatar"><i class="fa fa-calendar-alt"></i></span>
                                <span>${data || '-'} ${row.tahun_lulus ? '&rarr; ' + row.tahun_lulus : ''}</span>
                            </div>`
                    },
                    {
                        data: 'status_kuesioner',
                        className: 'text-center',
                        render: (data, type, row) => {
                            const statusMhs = (row.status_mahasiswa || 'ALUMNI').toUpperCase();
                            const isDone = data === 'sudah';
                            return `
                                <div class="akila-status-stack">
                                    <span class="akila-badge ${isDone ? 'akila-badge-green' : 'akila-badge-slate'}">${statusMhs}</span>
                                    <span class="${isDone ? 'akila-substatus-ok' : 'akila-substatus-warn'}">${isDone ? 'Lengkap' : 'Belum Lengkap'}</span>
                                </div>`;
                        }
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        className: 'text-center',
                        render: data => `
                            <div class="akila-actions">
                                <button type="button" class="akila-action-btn btn-view" title="Lihat Detail"
                                    data-bs-toggle="modal" data-bs-target="#modalViewMahasiswa"
                                    data-nim="${data.nim || '-'}" data-nama="${data.nama_lengkap || 'No Name'}"
                                    data-prodi="${data.prodi || '-'}" data-alamat="${data.alamat || '-'}"
                                    data-no_hp="${data.no_hp || '-'}" data-kelas="${data.kelas || '-'}"
                                    data-jalur="${data.jalur || '-'}" data-tahun_masuk="${data.tahun_masuk || '-'}"
                                    data-tahun_lulus="${data.tahun_lulus || '-'}" data-status="${data.status_mahasiswa || '-'}"
                                    data-status_kuesioner="${data.status_kuesioner || 'belum'}"
                                    data-email="${data.users ? data.users.email : '-'}"
                                    data-updated="${data.updated_at || '-'}">
                                    <i class="far fa-eye"></i>
                                </button>
                                <button type="button" class="akila-action-btn act-delete btn-delete" title="Hapus Alumni"
                                    data-id="${data.id}" data-nama="${data.nama_lengkap || 'No Name'}">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            </div>`
                    }
                ]
            });
        }

        $(document).ready(function () {
            initDataTable();

            // Prevent sorting when clicking inline filter row
            $('.akila-filter-row th').on('click mousedown', function (e) {
                e.stopPropagation();
            });

            // Per-column text filter
            $(document).on('keyup change', '#tabel-alumni .col-filter', function () {
                const colIdx = $(this).data('col');
                if (table && table.column(colIdx).search() !== this.value) {
                    table.column(colIdx).search(this.value).draw();
                }
            });

            // Per-column select filter
            $(document).on('change', '#tabel-alumni .col-filter-select', function () {
                const colIdx = $(this).data('col');
                if (table) {
                    table.column(colIdx).search(this.value).draw();
                }
            });

            // Check all rows
            $('#check-all-alumni').on('change', function () {
                $('#tabel-alumni .row-check').prop('checked', this.checked);
            });

            $('#filter-tahun').on('change', function () {
                if (table) {
                    table.ajax.reload();
                }
            });

            $(document).on('click', '.btn-view', function () {
                const d = $(this).data();
                $('#modal-detail-content').html(`
                    <div class="row g-0">
                        <div class="col-lg-5 text-white position-relative d-flex flex-column align-items-center justify-content-center p-4 py-5"
                             style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); min-height: 400px;">
                             <div class="text-center z-1 w-100 px-3">
                                 <img class="rounded-circle shadow-sm mb-3" alt="Avatar Alumni" src="https://ui-avatars.com/api/?name=${encodeURIComponent(d.nama)}&background=eab308&color=0f172a&bold=true"
                                     style="width:96px; height:96px; object-fit:cover; border: 3px solid #fff;">
                                 <div class="mb-2"><span class="akila-badge akila-badge-green">${d.status}</span></div>
                                 <h3 class="fw-bold mb-1 text-white fs-5">${d.nama}</h3>
                                 <p class="text-white-50 fs-xs mb-3">${d.prodi}</p>
                                 <div class="d-flex justify-content-center gap-2">
                                     ${d.no_hp && d.no_hp !== '-' ? `<a href="https://wa.me/${d.no_hp}" target="_blank" class="btn btn-sm btn-success rounded-2 px-3 fw-semibold"><i class="fab fa-whatsapp me-1"></i> WhatsApp</a>` : ''}
                                 </div>
                             </div>
                        </div>
                        <div class="col-lg-7 bg-white p-4">
                            <h5 class="fw-bold text-dark mb-1">Detail Informasi Alumni</h5>
                            <p class="text-muted fs-xs mb-3 pb-2 border-bottom">Informasi akademik dan profil alumni terdaftar</p>
                            <div class="row g-3 fs-sm">
                                <div class="col-6"><span class="text-muted d-block fs-xs">NIM</span><strong class="text-dark">${d.nim}</strong></div>
                                <div class="col-6"><span class="text-muted d-block fs-xs">Kelas / Jalur</span><strong class="text-dark">${d.kelas} / ${d.jalur}</strong></div>
                                <div class="col-6"><span class="text-muted d-block fs-xs">Tahun Masuk</span><strong class="text-dark">${d.tahun_masuk}</strong></div>
                                <div class="col-6"><span class="text-muted d-block fs-xs">Tahun Lulus</span><strong class="text-dark">${d.tahun_lulus}</strong></div>
                                <div class="col-6"><span class="text-muted d-block fs-xs">Status Tracer</span><strong class="${d.status_kuesioner === 'sudah' ? 'text-success' : 'text-danger'}">${d.status_kuesioner === 'sudah' ? 'Sudah Mengisi' : 'Belum Mengisi'}</strong></div>
                                <div class="col-6"><span class="text-muted d-block fs-xs">No. WhatsApp</span><strong class="text-dark">${d.no_hp}</strong></div>
                                <div class="col-12"><span class="text-muted d-block fs-xs">Email</span><strong class="text-dark">${d.email || '-'}</strong></div>
                                <div class="col-12"><span class="text-muted d-block fs-xs">Alamat</span><strong class="text-dark">${d.alamat || '-'}</strong></div>
                            </div>
                            <div class="mt-4 pt-3 border-top text-end">
                                <button type="button" class="btn-akila-outline" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                `);
            });

            $(document).on('click', '.btn-delete', function (e) {
                e.preventDefault();
                const id = $(this).data('id');
                const nama = $(this).data('nama');

                Swal.fire({
                    title: 'Hapus Alumni?',
                    html: `Apakah Anda yakin ingin menghapus alumni <b>${nama}</b>?<br><span class="text-danger small">Tindakan ini akan menghapus akun dan semua data kuesioner terkait.</span>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus',
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
                        $.ajax({
                            url: `/admin/alumni/${id}`,
                            type: 'POST',
                            data: { _token: '{{ csrf_token() }}', _method: 'DELETE' },
                            success: function (response) {
                                if (response.success) {
                                    Swal.fire({ title: 'Berhasil!', text: response.message, icon: 'success', customClass: { popup: 'swal-modern' } })
                                        .then(() => table.ajax.reload());
                                } else {
                                    Swal.fire({ title: 'Gagal!', text: response.message, icon: 'error', customClass: { popup: 'swal-modern' } });
                                }
                            },
                            error: function () {
                                Swal.fire({ title: 'Error!', text: 'Terjadi kesalahan saat menghapus data alumni.', icon: 'error', customClass: { popup: 'swal-modern' } });
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
