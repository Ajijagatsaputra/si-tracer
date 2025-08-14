<!doctype html>
<html lang="en">

<head id="page-header" class="sticky-top bg-body">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <title>@yield('title', 'SIKEMA')</title>

    <meta name="description" content="OneUI - Bootstrap 5 Admin Template &amp; UI Framework created by pixelcave and published on Themeforest">
    <meta name="author" content="pixelcave">
    <meta name="robots" content="noindex, nofollow">

    <!-- Open Graph Meta -->
    <meta property="og:title" content="OneUI - Bootstrap 5 Admin Template &amp; UI Framework">
    <meta property="og:site_name" content="OneUI">
    <meta property="og:description" content="OneUI - Bootstrap 5 Admin Template &amp; UI Framework created by pixelcave and published on Themeforest">
    <meta property="og:type" content="website">
    <meta property="og:url" content="">
    <meta property="og:image" content="">

    <!-- Icons -->
    <link rel="shortcut icon" href="{{ asset('assets/media/favicons/logo.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('assets/media/favicons/logo.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('assets/media/favicons/logo_phb.png') }}">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" id="css-main" href="{{ asset('assets/css/oneui.min.css') }}">

    <link rel="stylesheet" href="{{ asset('css/kuesioner-tracer-pengguna.css') }}">
    <link rel="stylesheet" href="{{ asset('css/supervisor-questionnaire.css') }}">
    @stack('styles')
</head>

<body>
    <div id="page-container" class="page-header-dark main-content-boxed">
        <!-- Header -->
        <header id="page-header">
            <div class="content-header">
                <!-- Left Section -->
                <div class="d-flex align-items-center">
                    <!-- Logo -->
                    <a class="fw-semibold fs-5 tracking-wider text-dual me-3" href="/">SIKEMA<span class="fw-normal">TI</span></a>

                    <!-- Notifications -->
                    <div class="dropdown d-inline-block me-2" style="z-index: 1040;">
                        <button type="button" class="btn btn-sm btn-alt-secondary" id="page-header-notifications-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-fw fa-bell"></i>
                            <span class="text-primary">•</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg p-0 border-0 fs-sm" aria-labelledby="page-header-notifications-dropdown">
                            <div class="p-2 bg-body-light border-bottom text-center rounded-top">
                                <h5 class="dropdown-header text-uppercase">Pemberitahuan</h5>
                            </div>
                            <ul class="nav-items mb-0">
                                <li>
                                    <a class="text-dark d-flex py-2" href="javascript:void(0)">
                                        <div class="flex-shrink-0 me-2 ms-3">
                                            <i class="fa fa-fw fa-check-circle text-success"></i>
                                        </div>
                                        <div class="flex-grow-1 pe-2">
                                            <div class="fw-semibold">Selamat datang di SIKEMA</div>
                                            <span class="fw-medium text-muted">2025-06-25</span>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a class="text-dark d-flex py-2" href="javascript:void(0)">
                                        <div class="flex-shrink-0 me-2 ms-3">
                                            <i class="fa fa-fw fa-plus-circle text-primary"></i>
                                        </div>
                                        <div class="flex-grow-1 pe-2">
                                            <div class="fw-semibold">Segera ganti password akun, jika belum diganti</div>
                                            <span class="fw-medium text-muted">26 min ago</span>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- END Left Section -->

                <!-- Right Section -->
                <div class="d-flex align-items-center">

                    
                </div>
                <!-- END Right Section -->
            </div>

            <!-- Header Loader -->
            <div id="page-header-loader" class="overlay-header bg-primary-lighter">
                <div class="content-header">
                    <div class="w-100 text-center">
                        <i class="fa fa-fw fa-circle-notch fa-spin text-primary"></i>
                    </div>
                </div>
            </div>
            <!-- END Header Loader -->
        </header>
        <!-- END Header -->

        <!-- Main Content -->
         <!-- Panggil CSS di Folder Public -->


    <div class="container-lg mt-5 mb-5">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-4 mx-4" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show mt-4 mx-4" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mt-4 mx-4" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="questionnaire-container supervisor-questionnaire">
            <!-- Header -->
            <div class="header-section">
                <i class="fas fa-user-tie fa-3x mb-3"></i>
                <h1>Kuesioner Evaluasi Kinerja Alumni</h1>
                <h2 style="font-size: 1.8rem; font-weight: 600; margin: 0.5rem 0;">Politeknik Harapan Bersama</h2>
                <p>Kuesioner untuk mengevaluasi kinerja dan kompetensi alumni di tempat kerja</p>
            </div>

            <div class="p-4 p-md-5">
                <form id="supervisorForm" action="{{ route('supervisor.questionnaire.submit', $tracerPengguna->token_akses) }}" method="POST">
                    @csrf

                    {{-- SECTION: Informasi Alumni --}}
                    <div class="section-card mb-4">
                        <div class="section-header">
                            <i class="fas fa-user me-2"></i>Informasi Alumni
                        </div>
                        <div class="p-4 row g-4">
                            <div class="col-md-6">
                                <label class="form-label">Nama Alumni</label>
                                <input type="text" class="form-control" value="{{ $tracerPengguna->nama_alumni }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Jabatan Alumni</label>
                                <input type="text" class="form-control" value="{{ $tracerPengguna->jabatan_alumni }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nama Perusahaan</label>
                                <input type="text" class="form-control" value="{{ $tracerPengguna->nama_perusahaan }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tanggal Mulai Bekerja</label>
                                <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($tracerPengguna->tanggal_mulai_kerja)->format('d/m/Y') }}" readonly>
                            </div>
                        </div>
                    </div>

                    {{-- SECTION: Informasi Atasan --}}
                    <div class="section-card mb-4">
                        <div class="section-header">
                            <i class="fas fa-user-tie me-2"></i>Informasi Atasan
                        </div>
                        <div class="p-4 row g-4">
                            <div class="col-md-6">
                                <label class="form-label">Nama Lengkap Atasan</label>
                                <input type="text" class="form-control" value="{{ $tracerPengguna->nama_atasan }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Jabatan Atasan</label>
                                <input type="text" class="form-control" value="{{ $tracerPengguna->jabatan_atasan }}" readonly>
                            </div>
                        </div>
                    </div>

                    {{-- SECTION: Evaluasi Kinerja (Point A) --}}
                    <div class="section-card mb-4">
                        <div class="section-header">
                            <i class="fas fa-star me-2"></i>Evaluasi Kinerja Alumni
                        </div>
                        <div class="p-4">
                            <div class="evaluation-scale">
                                <p class="text-muted mb-3">Berikan penilaian terhadap kinerja alumni berdasarkan skala berikut:</p>
                                <div class="row mb-3">
                                    <div class="col-md-2">
                                        <small class="text-muted">1 = Sangat Kurang</small>
                                    </div>
                                    <div class="col-md-2">
                                        <small class="text-muted">2 = Kurang</small>
                                    </div>
                                    <div class="col-md-2">
                                        <small class="text-muted">3 = Cukup</small>
                                    </div>
                                    <div class="col-md-2">
                                        <small class="text-muted">4 = Baik</small>
                                    </div>
                                    <div class="col-md-2">
                                        <small class="text-muted">5 = Sangat Baik</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-4">
                                @php
                                    $evaluasiFields = [
                                        'integritas' => 'Integritas',
                                        'keahlian' => 'Keahlian',
                                        'kemampuan' => 'Kemampuan',
                                        'penguasaan' => 'Penguasaan',
                                        'komunikasi' => 'Komunikasi',
                                        'kerja_tim' => 'Kerja Tim',
                                        'pengembangan' => 'Pengembangan'
                                    ];
                                @endphp

                                @foreach ($evaluasiFields as $field => $label)
                                    <div class="col-md-6">
                                        <label class="form-label">{{ $label }}</label>
                                        <select name="{{ $field }}" class="form-select @error($field) is-invalid @enderror" required>
                                            <option value="">-- Pilih Nilai --</option>
                                            <option value="1" {{ old($field) == '1' ? 'selected' : '' }}>1 - Sangat Kurang</option>
                                            <option value="2" {{ old($field) == '2' ? 'selected' : '' }}>2 - Kurang</option>
                                            <option value="3" {{ old($field) == '3' ? 'selected' : '' }}>3 - Cukup</option>
                                            <option value="4" {{ old($field) == '4' ? 'selected' : '' }}>4 - Baik</option>
                                            <option value="5" {{ old($field) == '5' ? 'selected' : '' }}>5 - Sangat Baik</option>
                                        </select>
                                        @error($field)
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- SECTION: Evaluasi Kesesuaian Pendidikan --}}
                    <div class="section-card mb-4">
                        <div class="section-header">
                            <i class="fas fa-graduation-cap me-2"></i>Evaluasi Kesesuaian Pendidikan
                        </div>
                        <div class="p-4 row g-4">
                            <div class="col-md-6">
                                <label class="form-label">Kesesuaian Pendidikan dengan Pekerjaan</label>
                                <select name="kesesuaian_pendidikan_pekerjaan" class="form-select @error('kesesuaian_pendidikan_pekerjaan') is-invalid @enderror" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="sangat_sesuai" {{ old('kesesuaian_pendidikan_pekerjaan') == 'sangat_sesuai' ? 'selected' : '' }}>Sangat Sesuai</option>
                                    <option value="sesuai" {{ old('kesesuaian_pendidikan_pekerjaan') == 'sesuai' ? 'selected' : '' }}>Sesuai</option>
                                    <option value="cukup_sesuai" {{ old('kesesuaian_pendidikan_pekerjaan') == 'cukup_sesuai' ? 'selected' : '' }}>Cukup Sesuai</option>
                                    <option value="kurang_sesuai" {{ old('kesesuaian_pendidikan_pekerjaan') == 'kurang_sesuai' ? 'selected' : '' }}>Kurang Sesuai</option>
                                    <option value="tidak_sesuai" {{ old('kesesuaian_pendidikan_pekerjaan') == 'tidak_sesuai' ? 'selected' : '' }}>Tidak Sesuai</option>
                                </select>
                                @error('kesesuaian_pendidikan_pekerjaan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Kualitas Lulusan Secara Umum</label>
                                <select name="kualitas_lulusan" class="form-select @error('kualitas_lulusan') is-invalid @enderror" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="sangat_baik" {{ old('kualitas_lulusan') == 'sangat_baik' ? 'selected' : '' }}>Sangat Baik</option>
                                    <option value="baik" {{ old('kualitas_lulusan') == 'baik' ? 'selected' : '' }}>Baik</option>
                                    <option value="cukup" {{ old('kualitas_lulusan') == 'cukup' ? 'selected' : '' }}>Cukup</option>
                                    <option value="kurang" {{ old('kualitas_lulusan') == 'kurang' ? 'selected' : '' }}>Kurang</option>
                                    <option value="sangat_kurang" {{ old('kualitas_lulusan') == 'sangat_kurang' ? 'selected' : '' }}>Sangat Kurang</option>
                                </select>
                                @error('kualitas_lulusan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label">Saran Perbaikan untuk Kampus</label>
                                <textarea name="saran_perbaikan" class="form-control @error('saran_perbaikan') is-invalid @enderror" rows="4" placeholder="Berikan saran untuk perbaikan kualitas pendidikan...">{{ old('saran_perbaikan') }}</textarea>
                                @error('saran_perbaikan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Tombol Submit --}}
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-submit">
                            <i class="fas fa-paper-plane me-2"></i>Kirim Evaluasi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('supervisorForm');

            form.addEventListener('submit', function(e) {
                // Validasi semua field required
                const requiredFields = form.querySelectorAll('select[required], textarea[required]');
                let isValid = true;

                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        isValid = false;
                        field.classList.add('is-invalid');
                    } else {
                        field.classList.remove('is-invalid');
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    alert('Mohon lengkapi semua field yang wajib diisi');
                    return;
                }

                // Tampilkan loading state
                const submitBtn = form.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengirim...';
                submitBtn.disabled = true;

                // Reset button setelah beberapa detik (fallback)
                setTimeout(() => {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }, 10000);
            });
        });
    </script>
        <!-- END Main Content -->

        <!-- Footer -->
        <div class="mt-5">
        <footer id="page-footer" class="footer-sticky bg-body-extra-light fixed-bottom mt-5">
            <div class="content py-3">
                <div class="row fs-sm">
                    <div class="col-sm-6 order-sm-2 py-1 text-center text-sm-end">
                        Politeknik Harapan Bersama
                    </div>
                    <div class="col-sm-6 order-sm-1 py-1 text-center text-sm-start">
                        <a class="fw-semibold" href="https://1.envato.market/AVD6j" target="_blank">Copyright</a>
                        &copy; SikemaTI<span data-toggle="year-copy">2025</span>
                    </div>
                </div>
                </div>
            </footer>
        </div>
        <!-- END Footer -->
    </div>
    <!-- END Page Container -->

    <!-- Scripts -->
    <script src="{{ asset('assets/js/lib/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/oneui.app.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/chart.js/chart.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables-bs5/js/dataTables.bootstrap5.min.js') }}"></script>

    @stack('scripts')
</body>

</html>
