@extends('layouts.admin')

@section('content')
    <!-- Premium Glassmorphic Hero -->
    <div class="card card-modern border-0 shadow-lg mb-4 overflow-hidden mx-4 mt-4" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
        <div class="card-body p-4 p-md-5 position-relative">
            <div class="row align-items-center">
                <div class="col-lg-8 position-relative" style="z-index: 2;">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-circle bg-white-20 text-white me-3" style="width: 50px; height: 50px;">
                            <i class="fa fa-list-ul fa-lg"></i>
                        </div>
                        <h1 class="h2 fw-bold text-white mb-0">Daftar Prediksi Karier</h1>
                    </div>
                    <p class="lead text-white-50 mb-0">Kumpulan seluruh riwayat analisis AI untuk karier alumni.</p>
                </div>
                <div class="col-lg-4 text-lg-end mt-4 mt-lg-0 position-relative" style="z-index: 2;">
                    <a href="{{ route('admin.prediksi.data') }}" class="btn btn-lg btn-white rounded-pill px-4 shadow-sm hover-scale">
                        <i class="fa fa-chart-line me-2 text-primary"></i> Dashboard AI
                    </a>
                </div>
            </div>
            <!-- Decorative Elements -->
            <div class="position-absolute top-0 end-0 p-5 mt-n5 me-n5 opacity-10">
                <i class="fa fa-brain fa-10x text-white"></i>
            </div>
        </div>
    </div>

    <!-- Page Content -->
    <div class="content content-full">
        <!-- Modern Stats Grid -->
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <div class="card card-modern border-0 shadow-sm h-100 stat-hover-effect overflow-hidden">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="icon-circle bg-primary-light text-primary">
                                <i class="fa fa-database fa-lg"></i>
                            </div>
                            <span class="badge bg-primary-light text-primary rounded-pill px-2 py-0 fs-xs border border-primary-10">Total</span>
                        </div>
                        <h3 class="display-6 fw-bold text-dark mb-1 stat-counter">{{ $totalPredictions ?? 0 }}</h3>
                        <p class="text-muted small mb-0">Total History Prediksi</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-modern border-0 shadow-sm h-100 stat-hover-effect overflow-hidden">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="icon-circle bg-danger-light text-danger">
                                <i class="fa fa-users fa-lg"></i>
                            </div>
                            <span class="badge bg-danger-light text-danger rounded-pill px-2 py-0 fs-xs border border-danger-10">Unik</span>
                        </div>
                        <h3 class="display-6 fw-bold text-dark mb-1 stat-counter">{{ $uniqueUsers ?? 0 }}</h3>
                        <p class="text-muted small mb-0">Alumni Menggunakan AI</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Riwayat Prediksi Table Section -->
        <div class="card card-modern border-0 shadow-sm">
            <div class="card-header bg-white py-3 px-4 border-bottom d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <div class="icon-circle bg-primary-light text-primary me-3" style="width: 40px; height: 40px;">
                        <i class="fa fa-table"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-0">Tabel Riwayat Prediksi</h5>
                </div>
                <span class="badge bg-light text-primary rounded-pill px-3 py-2 border">Total: {{ $predictions->total() }} Data</span>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table align-middle table-hover w-100 border-0">
                        <thead>
                            <tr class="text-uppercase fs-xs fw-bold text-muted bg-light border-0">
                                <th class="text-center border-0 py-3" style="width: 60px;">#</th>
                                <th class="border-0 py-3">Nama Alumni</th>
                                <th class="border-0 py-3">Rekomendasi Karier (AI)</th>
                                <th class="border-0 py-3">Waktu Analisis</th>
                                <th class="text-center border-0 py-3" style="width: 120px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="border-0">
                            @foreach ($predictions as $index => $item)
                                <tr class="hover-translate-y transition-all">
                                    <td class="text-center fw-medium text-muted border-0">
                                        {{ ($predictions->currentPage() - 1) * $predictions->perPage() + $index + 1 }}
                                    </td>
                                    <td class="border-0">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-circle-sm bg-primary text-white fw-bold me-2">
                                                {{ substr($item->alumni->nama_lengkap ?? 'A', 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark">{{ $item->alumni->nama_lengkap ?? 'Alumni #' . ($item->idAlumni ?? '-') }}</div>
                                                <div class="text-muted small">ID: {{ $item->idAlumni ?? '-' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="border-0">
                                        <div class="d-flex flex-wrap gap-1">
                                            @php $titles = $item->extracted_job_titles ?? []; @endphp
                                            @foreach($titles as $title)
                                                <span class="badge bg-primary-light text-primary rounded-pill px-2 border border-primary-10 fs-xs">{{ $title }}</span>
                                            @endforeach
                                            @if(empty($titles))
                                                <span class="text-muted small fst-italic">No labels detected</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="border-0">
                                        <span class="text-muted small">
                                            <i class="far fa-clock me-1"></i>
                                            {{ $item->created_at->format('d/m/Y H:i') }}
                                        </span>
                                        <div class="text-primary small fw-medium">{{ $item->created_at->diffForHumans() }}</div>
                                    </td>
                                    <td class="text-center border-0">
                                        <button type="button" class="btn btn-sm btn-white rounded-pill px-3 shadow-sm border"
                                                onclick="showDetail({{ $item->id }})"
                                                data-bs-toggle="modal"
                                                data-bs-target="#detailModal">
                                            <i class="fa fa-eye text-primary me-1"></i> Detail
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            @if ($predictions->isEmpty())
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="text-muted fst-italic">Belum ada data hasil prediksi karier alumni.</div>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($predictions->hasPages())
                    <div class="mt-4 pt-3 border-top">
                        {{ $predictions->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Detail Modal (Same as Dashboard) -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-lg overflow-hidden">
                <div class="modal-header border-0 p-4" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
                    <div class="d-flex align-items-center">
                        <div class="icon-circle bg-white-20 text-white me-3" style="width: 40px; height: 40px;">
                            <i class="fa fa-robot"></i>
                        </div>
                        <h5 class="modal-title text-white fw-bold" id="detailModalLabel">AI Analysis Report</h5>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0" id="modalContent">
                    <!-- Dynamic Content -->
                </div>
                <div class="modal-footer bg-light border-0 p-3">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animate counters
            if (typeof jQuery !== 'undefined') {
                $('.stat-counter').each(function() {
                    const $this = $(this);
                    const countTo = parseInt($this.text());
                    $({ countNum: 0 }).animate({ countNum: countTo }, {
                        duration: 1500,
                        easing: 'swing',
                        step: function() {
                            $this.text(Math.floor(this.countNum));
                        },
                        complete: function() {
                            $this.text(this.countNum);
                        }
                    });
                });
            }
        });

        function showDetail(id) {
            const container = document.getElementById('modalContent');
            container.innerHTML = `
                <div class="p-5 text-center">
                    <div class="spinner-grow text-primary" role="status"></div>
                    <p class="mt-3 text-muted small">AI is analyzing historical data...</p>
                </div>
            `;

            fetch(`/admin/prediksi/detail/${id}`)
                .then(r => r.json())
                .then(data => {
                    const date = new Date(data.created_at).toLocaleDateString('id-ID', {
                        day: 'numeric', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit'
                    });

                    let titlesHTML = data.extracted_job_titles?.map(t => 
                        `<span class="badge bg-primary-light text-primary rounded-pill px-3 py-2 border border-primary-10 me-2 mb-2">${t}</span>`
                    ).join('') || '<span class="text-muted fst-italic">No titles extracted</span>';

                    container.innerHTML = `
                        <div class="p-4 bg-light shadow-inner border-bottom">
                            <div class="row align-items-center">
                                <div class="col-md-7">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle-lg bg-primary text-white fs-4 me-3">
                                            ${(data.alumni?.nama_lengkap || 'A').charAt(0)}
                                        </div>
                                        <div>
                                            <h5 class="fw-bold mb-0 text-dark">${data.alumni?.nama_lengkap || 'Unknown Alumni'}</h5>
                                            <p class="text-muted small mb-0">ID: ${data.idAlumni || '-'} • Analysis on ${date}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5 text-md-end mt-3 mt-md-0">
                                    <span class="badge bg-success-light text-success rounded-pill px-3 py-2 border border-success-10">
                                        <i class="fa fa-shield-check me-1"></i> Verified AI Output
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="p-4">
                            <div class="mb-4">
                                <h6 class="text-uppercase text-primary fw-bold small mb-3 letter-spacing-1">
                                    <i class="fa fa-tags me-2"></i> Predicted Job Categories
                                </h6>
                                <div class="d-flex flex-wrap">${titlesHTML}</div>
                            </div>
                            <div class="mb-0">
                                <h6 class="text-uppercase text-primary fw-bold small mb-3 letter-spacing-1">
                                    <i class="fa fa-file-invoice me-2"></i> Detailed Analysis & Recommendation
                                </h6>
                                <div class="p-4 rounded-4 bg-white border shadow-sm" style="max-height: 400px; overflow-y: auto;">
                                    <div class="ai-content-body fs-sm text-dark" style="line-height: 1.7;">
                                        ${data.hasil || '<p class="text-muted text-center py-4">No content available</p>'}
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                })
                .catch(err => {
                    container.innerHTML = `<div class="p-5 text-center text-danger"><i class="fa fa-exclamation-circle fa-3x mb-3"></i><p>Failed to load analysis.</p></div>`;
                });
        }

        function deleteItem(id) {
            if (confirm('Yakin ingin menghapus data ini?')) {
                document.getElementById('delete-form-' + id).submit();
            }
        }
    </script>

    <style>
        .icon-circle.bg-white-20 { background: rgba(255,255,255,0.2); }
        .avatar-circle-sm { width: 35px; height: 35px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.9rem; }
        .avatar-circle-lg { width: 60px; height: 60px; border-radius: 18px; display: flex; align-items: center; justify-content: center; }
        .stat-hover-effect { transition: all 0.3s ease; }
        .stat-hover-effect:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important; }
        .bg-light-soft { background-color: #f8fafc; }
        .hover-scale { transition: all 0.3s ease; }
        .hover-scale:hover { transform: scale(1.02); }
        .transition-all { transition: all 0.3s ease; }
        .hover-translate-y:hover { transform: translateY(-3px); }
        .shadow-inner { box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.05); }
        .letter-spacing-1 { letter-spacing: 1px; }
        .ai-content-body { white-space: pre-line; }
        .ai-content-body strong { color: var(--bs-primary); }
    </style>
@endsection
