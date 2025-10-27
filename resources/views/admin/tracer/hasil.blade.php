@extends('layouts.admin')

@section('content')
    <div class="px-4 py-5 container-fluid">

        <!-- === STATISTICS CARDS === -->
        <div class="mb-5 row g-4">
            @php
                $stats = [
                    [
                        'label' => 'Total Alumni',
                        'icon' => 'bi-people-fill',
                        'value' => $totalAlumni,
                        'color' => 'linear-gradient(135deg, #667eea, #764ba2)',
                    ],
                    [
                        'label' => 'Sudah Diisi Supervisor',
                        'icon' => 'bi-check2-circle',
                        'value' => $sudahMengisi,
                        'color' => 'linear-gradient(135deg, #43cea2, #185a9d)',
                    ],
                    [
                        'label' => 'Belum Diisi Supervisor',
                        'icon' => 'bi-hourglass-split',
                        'value' => $belumMengisi,
                        'color' => 'linear-gradient(135deg, #f7971e, #ffd200)',
                    ],
                ];
            @endphp

            @foreach ($stats as $stat)
                <div class="col-12 col-md-4">
                    <div class="text-white border-0 shadow-lg card stat-card" style="background: {{ $stat['color'] }};">
                        <div class="p-4 card-body d-flex justify-content-between align-items-center">
                            <div>
                                <div class="mb-2 fs-2"><i class="bi {{ $stat['icon'] }}"></i></div>
                                <p class="mb-1 text-white-50">{{ $stat['label'] }}</p>
                                <h2 class="fw-bold counter" data-value="{{ $stat['value'] }}">{{ $stat['value'] }}</h2>
                            </div>
                            @if ($stat['label'] !== 'Total Alumni')
                                <span class="shadow-sm badge bg-light text-dark fw-semibold fs-6">
                                    {{ $totalAlumni > 0 ? round(($stat['value'] / $totalAlumni) * 100, 1) : 0 }}%
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- === TABLE HASIL SURVEI === -->
        <div class="mb-4 border-0 shadow-lg card rounded-4">
            <div class="py-3 text-white border-0 card-header bg-gradient rounded-top-4"
                style="background: linear-gradient(90deg,#1e3c72 0%,#2a5298 100%)">
                <div class="d-flex align-items-center">
                    <i class="bi bi-bar-chart-fill fs-3 me-3"></i>
                    <div>
                        <h5 class="mb-1 text-black fw-semibold">Hasil Evaluasi Supervisor Terhadap Alumni</h5>
                        <small class="text-black opacity-75 text-light">Analisis penilaian berdasarkan indikator kompetensi</small>
                    </div>
                </div>
            </div>
            <div class="p-4 card-body">
                <div class="table-responsive">
                    <table id="table-hasil-survei" class="table mb-0 align-middle table-hover">
                        <thead class="text-center text-white"
                            style="background: linear-gradient(90deg,#283e51 0%,#485563 100%)">
                            <tr>
                                <th class="p-3 text-start">Indikator Kompetensi</th>
                                @foreach (['Tidak Baik', 'Kurang Baik', 'Cukup', 'Baik', 'Sangat Baik'] as $i => $label)
                                    <th class="p-3">{{ $label }}<br><small>({{ $i + 1 }})</small></th>
                                @endforeach
                                <th class="p-3">Responden</th>
                                <th class="p-3">Rata-Rata</th>
                                <th class="p-3">Nilai Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($hasil as $row)
                                <tr>
                                    <td class="px-4 fw-semibold">{{ $row['label'] }}</td>
                                    @for ($i = 1; $i <= 5; $i++)
                                        <td class="text-center">
                                            <span
                                                class="badge rounded-pill {{ $row['rekap'][$i] > 0 ? 'bg-light text-dark' : 'bg-light text-muted' }}">
                                                {{ $row['rekap'][$i] }} / {{ $row['jumlah_responden'] }}
                                                ({{ $row['jumlah_responden'] > 0 ? round(($row['rekap'][$i] / $row['jumlah_responden']) * 100, 1) : 0 }}%)
                                            </span>
                                        </td>
                                    @endfor
                                    <td class="text-center fw-bold">{{ $row['jumlah_responden'] }}</td>
                                    <td class="text-center">
                                        @if ($row['rata_rata'] > 0)
                                            <span class="text-white badge fs-6 fw-semibold"
                                                style="background:
                                                {{ $row['rata_rata'] >= 4.5
                                                    ? '#38b000'
                                                    : ($row['rata_rata'] >= 3.5
                                                        ? '#2196f3'
                                                        : ($row['rata_rata'] >= 2.5
                                                            ? '#6c757d'
                                                            : ($row['rata_rata'] >= 1.5
                                                                ? '#ffc107'
                                                                : '#dc3545'))) }};">
                                                {{ $row['rata_rata'] }}
                                            </span>
                                            <div class="mt-1 small text-muted">{{ $row['keterangan'] }}</div>
                                        @else
                                            <span class="badge bg-secondary">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($row['nilai_total'] > 0)
                                            <span class="text-white badge bg-info fs-6">{{ $row['nilai_total'] }}%</span>
                                        @else
                                            <span class="badge bg-secondary">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- === CONCLUSION BOX === -->
        @if ($sudahMengisi > 0)
            <div class="px-4 py-3 border-0 shadow-sm alert bg-gradient rounded-4 d-flex align-items-center"
                style="background: linear-gradient(90deg,#2193b0 0%,#6dd5ed 100%); color:white;">
                <i class="bi bi-info-circle-fill fs-2 me-3"></i>
                <div>
                    <h6 class="mb-1 text-black fw-bold">Kesimpulan Evaluasi</h6>
                    <p class="mb-0 text-black fw-light">
                        Berdasarkan hasil evaluasi supervisor, alumni tergolong
                        <span class="badge bg-light text-primary fw-semibold">{{ $kesimpulanKategori }}</span>
                        dengan rata-rata skor
                        <span class="badge bg-light text-primary fw-semibold">{{ $kesimpulanRataRata }}</span>
                        dan persentase pencapaian
                        <span class="badge bg-light text-primary fw-semibold">{{ $kesimpulanPersentase }}%</span>.
                    </p>
                </div>
            </div>
        @else
            <div class="px-4 py-3 shadow-sm alert alert-warning rounded-4 d-flex align-items-center">
                <i class="bi bi-exclamation-triangle-fill fs-2 me-3 text-warning"></i>
                <div>
                    <h6 class="mb-1 fw-bold text-dark">Belum Ada Data Evaluasi</h6>
                    <p class="mb-0 text-muted">
                        Saat ini belum ada supervisor yang mengisi evaluasi. Data akan muncul setelah penilaian selesai.
                    </p>
                </div>
            </div>
        @endif

        <!-- === LEGEND === -->
        <div class="mt-3 border-0 shadow-sm card bg-light rounded-4">
            <div class="px-3 py-2 card-body">
                <small class="text-muted">
                    <i class="bi bi-info-circle me-1"></i>
                    <strong>Skala Penilaian:</strong> 1 = Tidak Baik, 2 = Kurang Baik, 3 = Cukup, 4 = Baik, 5 = Sangat Baik
                </small>
            </div>
        </div>
    </div>

    <!-- === STYLES === -->
    @push('styles')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">
        <style>
            .stat-card {
                border-radius: 1.4rem;
                transition: 0.3s ease;
                animation: fadeInUp 0.5s forwards;
            }

            .stat-card:hover {
                transform: translateY(-6px) scale(1.02);
                box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            }

            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        </style>
    @endpush

    <!-- === SCRIPTS === -->
    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
        <script>
            $(function() {
                $('.counter').each(function() {
                    const $this = $(this),
                        countTo = $this.data('value');
                    $({
                        countNum: 0
                    }).animate({
                        countNum: countTo
                    }, {
                        duration: 1200,
                        easing: 'swing',
                        step: function() {
                            $this.text(Math.floor(this.countNum));
                        },
                        complete: function() {
                            $this.text(this.countNum);
                        }
                    });
                });

                $('#table-hasil-survei').DataTable({
                    paging: false,
                    searching: false,
                    ordering: false,
                    info: false,
                    responsive: true,
                    dom: "<'row mb-3'<'col-12 d-flex gap-2 justify-content-end'B>>" + "<'row'<'col-12't>>",
                    buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdfHtml5', 'print']
                });
            });
        </script>
    @endpush
@endsection
