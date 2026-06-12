@extends('layouts.admin')

@section('content')
    <!-- Hero -->
    <div class="bg-white">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-2">
                        <span class="bg-primary-lighter p-2 rounded-3 me-2">
                            <i class="fa fa-clipboard-list text-primary"></i>
                        </span>
                        Lamaran Masuk Alumni
                    </h1>
                    <p class="fs-sm fw-medium text-muted mb-0">
                        Kelola dan tinjau lamaran pekerjaan yang dikirim oleh alumni.
                    </p>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ route('admin.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Lamaran Alumni</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="content">

        <!-- Stats Row -->
        <div class="row g-3 mb-4">
            <div class="col-6 col-md">
                <div class="block block-rounded text-center shadow-sm mb-0">
                    <div class="block-content py-3">
                        <div class="fs-3 fw-bold">{{ $stats['total'] }}</div>
                        <div class="fs-sm text-muted fw-semibold">Total</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md">
                <div class="block block-rounded text-center shadow-sm mb-0">
                    <div class="block-content py-3">
                        <div class="fs-3 fw-bold text-warning">{{ $stats['applied'] }}</div>
                        <div class="fs-sm text-muted fw-semibold">Dilamar</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md">
                <div class="block block-rounded text-center shadow-sm mb-0">
                    <div class="block-content py-3">
                        <div class="fs-3 fw-bold text-info">{{ $stats['reviewed'] }}</div>
                        <div class="fs-sm text-muted fw-semibold">Ditinjau</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md">
                <div class="block block-rounded text-center shadow-sm mb-0">
                    <div class="block-content py-3">
                        <div class="fs-3 fw-bold text-success">{{ $stats['accepted'] }}</div>
                        <div class="fs-sm text-muted fw-semibold">Diterima</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md">
                <div class="block block-rounded text-center shadow-sm mb-0">
                    <div class="block-content py-3">
                        <div class="fs-3 fw-bold text-danger">{{ $stats['rejected'] }}</div>
                        <div class="fs-sm text-muted fw-semibold">Ditolak</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Card -->
        <div class="block block-rounded block-mode-loading-oneui shadow-sm mb-4">
            <div class="block-content block-content-full">
                <form action="{{ route('admin.loker.applications') }}" method="GET" id="filter-form">
                    <div class="row g-2">
                        <div class="col-md-5">
                            <input type="text" name="search" class="form-control"
                                placeholder="Cari nama alumni, NIM, posisi, atau perusahaan..."
                                value="{{ request('search') }}">
                        </div>
                        <div class="col-md-4">
                            <select name="status" class="form-select" onchange="this.form.submit()">
                                <option value="">Semua Status</option>
                                <option value="applied" {{ request('status') == 'applied' ? 'selected' : '' }}>Dilamar
                                </option>
                                <option value="reviewed" {{ request('status') == 'reviewed' ? 'selected' : '' }}>Ditinjau
                                </option>
                                <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>Diterima
                                </option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak
                                </option>
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
                                <th>Alumni</th>
                                <th>Posisi Dilamar</th>
                                <th>Perusahaan</th>
                                <th>Tanggal Apply</th>
                                <th class="text-center">Status</th>
                                <th class="text-center" style="width: 150px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($applications as $index => $app)
                                <tr>
                                    <td class="text-center">
                                        {{ ($applications->currentPage() - 1) * $applications->perPage() + $index + 1 }}</td>
                                    <td>
                                        <div class="fw-semibold text-dark">{{ $app->alumni->nama_lengkap ?? '-' }}</div>
                                        <div class="fs-xs text-muted mb-1">NIM: {{ $app->alumni->nim ?? '-' }}</div>
                                        @if($app->phone)
                                            <div class="fs-xs mt-1">
                                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $app->phone) }}" target="_blank" class="text-success fw-medium">
                                                    <i class="fab fa-whatsapp me-1"></i> {{ $app->phone }}
                                                </a>
                                            </div>
                                        @endif
                                        @if($app->expected_salary)
                                            <div class="fs-xs text-muted mt-1">
                                                <i class="fa fa-money-bill-wave text-success me-1"></i> {{ $app->expected_salary }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="fw-semibold">{{ $app->jobVacancy->position ?? '-' }}</td>
                                    <td>{{ $app->jobVacancy->company_name ?? '-' }}</td>
                                    <td>
                                        <div class="small">{{ $app->applied_at->translatedFormat('d M Y') }}</div>
                                        <div class="fs-xs text-muted">{{ $app->applied_at->translatedFormat('H:i') }}</div>
                                    </td>
                                    <td class="text-center">
                                        @if($app->status === 'applied')
                                            <span class="badge bg-warning"><i class="fa fa-paper-plane me-1"></i> Dilamar</span>
                                        @elseif($app->status === 'reviewed')
                                            <span class="badge bg-info"><i class="fa fa-eye me-1"></i> Ditinjau</span>
                                        @elseif($app->status === 'accepted')
                                            <span class="badge bg-success"><i class="fa fa-check-circle me-1"></i> Diterima</span>
                                        @elseif($app->status === 'rejected')
                                            <span class="badge bg-danger"><i class="fa fa-times-circle me-1"></i> Ditolak</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <!-- View Cover Letter -->
                                            @if($app->cover_letter)
                                                <button type="button" class="btn btn-sm btn-alt-info btn-view-letter"
                                                    data-letter="{{ $app->cover_letter }}"
                                                    data-name="{{ $app->alumni->nama_lengkap ?? '-' }}" title="Lihat Pesan">
                                                    <i class="fa fa-envelope"></i>
                                                </button>
                                            @endif

                                            <!-- View / Download CV -->
                                            @if($app->cv_path)
                                                <a href="{{ $app->cv_path }}" target="_blank" class="btn btn-sm btn-alt-success" title="Lihat / Unduh CV">
                                                    <i class="fa fa-file-pdf"></i>
                                                </a>
                                            @endif

                                            <!-- Update Status -->
                                            <button type="button" class="btn btn-sm btn-alt-primary btn-update-status"
                                                data-id="{{ $app->id }}" data-status="{{ $app->status }}"
                                                data-name="{{ $app->alumni->nama_lengkap ?? '-' }}"
                                                data-position="{{ $app->jobVacancy->position ?? '-' }}"
                                                data-notes="{{ $app->admin_notes }}" title="Ubah Status">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">Belum ada lamaran masuk dari alumni.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="fs-sm text-muted">
                        Menampilkan {{ $applications->firstItem() ?? 0 }} sampai {{ $applications->lastItem() ?? 0 }} dari
                        {{ $applications->total() }} data
                    </div>
                    {{ $applications->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Cover Letter Modal -->
    <div class="modal fade" id="modalCoverLetter" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 overflow-hidden">
                <div class="modal-header bg-dark text-white p-3">
                    <h5 class="modal-title fw-bold text-white"><i class="fa fa-envelope me-2"></i> Pesan dari <span
                            id="letter-name">Alumni</span></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <p id="letter-content" style="white-space: pre-line; line-height: 1.6;"></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Status Modal -->
    <div class="modal fade" id="modalUpdateStatus" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 overflow-hidden">
                <div class="modal-header bg-dark text-white p-3">
                    <h5 class="modal-title fw-bold text-white"><i class="fa fa-edit me-2"></i> Ubah Status Lamaran</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <input type="hidden" id="update-app-id">
                    <div class="mb-3">
                        <p class="fw-bold mb-1" id="update-info"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Status Baru</label>
                        <select id="update-status" class="form-select">
                            <option value="reviewed">Sedang Ditinjau</option>
                            <option value="accepted">Diterima</option>
                            <option value="rejected">Ditolak</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Catatan Admin (Opsional)</label>
                        <textarea id="update-notes" class="form-control" rows="3" maxlength="500"
                            placeholder="Tuliskan catatan untuk alumni..."></textarea>
                    </div>
                </div>
                <div class="modal-footer p-3">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary fw-bold" id="btn-save-status">
                        <i class="fa fa-save me-1"></i> Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            // View Cover Letter
            $('.btn-view-letter').on('click', function () {
                $('#letter-name').text($(this).data('name'));
                $('#letter-content').text($(this).data('letter'));
                var modal = new bootstrap.Modal(document.getElementById('modalCoverLetter'));
                modal.show();
            });

            // Open Update Status Modal
            $('.btn-update-status').on('click', function () {
                var id = $(this).data('id');
                var status = $(this).data('status');
                var name = $(this).data('name');
                var position = $(this).data('position');
                var notes = $(this).data('notes');

                $('#update-app-id').val(id);
                $('#update-status').val(status === 'applied' ? 'reviewed' : status);
                $('#update-notes').val(notes || '');
                $('#update-info').text(name + ' — ' + position);

                var modal = new bootstrap.Modal(document.getElementById('modalUpdateStatus'));
                modal.show();
            });

            // Save Status Update
            $('#btn-save-status').on('click', function () {
                var btn = $(this);
                var id = $('#update-app-id').val();
                var status = $('#update-status').val();
                var notes = $('#update-notes').val();

                btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin me-1"></i> Menyimpan...');

                var url = "{{ route('admin.loker.application.update-status', ':id') }}".replace(':id', id);

                $.ajax({
                    url: url,
                    type: 'PUT',
                    data: { status: status, admin_notes: notes },
                    success: function (res) {
                        bootstrap.Modal.getInstance(document.getElementById('modalUpdateStatus')).hide();
                        Swal.fire('Berhasil', res.message, 'success').then(() => {
                            location.reload();
                        });
                    },
                    error: function (err) {
                        btn.prop('disabled', false).html('<i class="fa fa-save me-1"></i> Simpan');
                        var msg = err.responseJSON?.message || 'Gagal memperbarui status.';
                        Swal.fire('Error', msg, 'error');
                    }
                });
            });
        });
    </script>
@endsection