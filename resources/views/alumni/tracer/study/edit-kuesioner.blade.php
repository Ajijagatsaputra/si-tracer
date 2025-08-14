@extends('layout')

@section('content')
    @include('components.navbar')

    <!-- Main Content -->
    <main id="main-container" class="mt-3">
        <div class="content py-4">
            <!-- Header -->
            <div class="bg-gradient-primary p-4 rounded-lg shadow-sm mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 fw-bold text-white mb-1">
                            <i class="fas fa-edit me-2"></i>Edit Kuesioner Tracer Study
                        </h1>
                        <p class="text-white-50 mb-0">Perbarui data tracer study alumni Anda dengan detail terbaru</p>
                    </div>
                    <div>
                        <a href="{{ route('home') }}" class="btn btn-light">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </div>
            </div>

            <!-- Progress Bar -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted">Progress Pengisian</span>
                        <span id="progress-text" class="fw-bold text-primary">0%</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div id="progress-bar" class="progress-bar bg-primary" role="progressbar" style="width: 0%"></div>
                    </div>
                </div>
            </div>

            <!-- Form -->
            <form id="tracerStudyForm" method="POST" action="{{ route('new-tracer.update', $tracer->id) }}">
                @csrf
                @method('PUT')

                <!-- Bagian 1: Info Pribadi -->
                <div class="section-card animate-fade-in mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-user me-2"></i>Bagian 1: Informasi Pribadi
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" name="nama" id="nama" class="form-control"
                                           value="{{ old('nama', $tracer->nama) }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" id="email" class="form-control"
                                           value="{{ old('email', $tracer->email) }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="no_hp" class="form-label">No. HP <span class="text-danger">*</span></label>
                                    <input type="text" name="no_hp" id="no_hp" class="form-control"
                                           value="{{ old('no_hp', $tracer->no_hp) }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="nim" class="form-label">NIM <span class="text-danger">*</span></label>
                                    <input type="text" name="nim" id="nim" class="form-control"
                                           value="{{ old('nim', $tracer->nim) }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="tahun_lulus" class="form-label">Tahun Lulus <span class="text-danger">*</span></label>
                                    <input type="number" name="tahun_lulus" id="tahun_lulus" class="form-control"
                                           value="{{ old('tahun_lulus', $tracer->tahun_lulus) }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="prodi" class="form-label">Program Studi <span class="text-danger">*</span></label>
                                    <select name="prodi" id="prodi" class="form-select" required>
                                        <option value="teknik_informatika" {{ old('prodi', $tracer->prodi) == 'teknik_informatika' ? 'selected' : '' }}>Teknik Informatika</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="alamat" class="form-label">Alamat <span class="text-danger">*</span></label>
                                    <textarea name="alamat" id="alamat" class="form-control" rows="3" required>{{ old('alamat', $tracer->alamat) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bagian 2: Status Pekerjaan -->
                <div class="section-card animate-fade-in mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-briefcase me-2"></i>Bagian 2: Status Pekerjaan Saat Ini
                            </h5>
                        </div>
                        <div class="card-body">
                            <label class="form-label">Pilih status yang sesuai dengan kondisi Anda saat ini <span class="text-danger">*</span></label>
                            <div class="row g-3">
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-check card-radio">
                                        <input class="form-check-input" type="radio" name="bekerja" id="bekerja_full" value="bekerja_full"
                                               {{ old('bekerja', $tracer->status_pekerjaan) == 'bekerja_full' ? 'checked' : '' }} required>
                                        <label class="form-check-label w-100" for="bekerja_full">
                                            <div class="text-center p-3">
                                                <i class="fas fa-briefcase fa-2x text-success mb-2"></i>
                                                <div class="fw-bold">Bekerja</div>
                                                <small class="text-muted">Full time/Part time</small>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-check card-radio">
                                        <input class="form-check-input" type="radio" name="bekerja" id="belum_bekerja" value="belum_bekerja"
                                               {{ old('bekerja', $tracer->status_pekerjaan) == 'belum_bekerja' ? 'checked' : '' }} required>
                                        <label class="form-check-label w-100" for="belum_bekerja">
                                            <div class="text-center p-3">
                                                <i class="fas fa-clock fa-2x text-warning mb-2"></i>
                                                <div class="fw-bold">Belum Memungkinkan Bekerja</div>
                                                <small class="text-muted">Melanjutkan studi/Kondisi tertentu</small>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-check card-radio">
                                        <input class="form-check-input" type="radio" name="bekerja" id="wirausaha" value="wirausaha"
                                               {{ old('bekerja', $tracer->status_pekerjaan) == 'wirausaha' ? 'checked' : '' }} required>
                                        <label class="form-check-label w-100" for="wirausaha">
                                            <div class="text-center p-3">
                                                <i class="fas fa-store fa-2x text-info mb-2"></i>
                                                <div class="fw-bold">Wiraswasta</div>
                                                <small class="text-muted">Memiliki usaha sendiri</small>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-check card-radio">
                                        <input class="form-check-input" type="radio" name="bekerja" id="lanjutstudy" value="lanjutstudy"
                                               {{ old('bekerja', $tracer->status_pekerjaan) == 'lanjutstudy' ? 'checked' : '' }} required>
                                        <label class="form-check-label w-100" for="lanjutstudy">
                                            <div class="text-center p-3">
                                                <i class="fas fa-graduation-cap fa-2x text-primary mb-2"></i>
                                                <div class="fw-bold">Melanjutkan Pendidikan</div>
                                                <small class="text-muted">S2/S3/Kursus</small>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-check card-radio">
                                        <input class="form-check-input" type="radio" name="bekerja" id="tidak" value="tidak"
                                               {{ old('bekerja', $tracer->status_pekerjaan) == 'tidak' ? 'checked' : '' }} required>
                                        <label class="form-check-label w-100" for="tidak">
                                            <div class="text-center p-3">
                                                <i class="fas fa-search fa-2x text-secondary mb-2"></i>
                                                <div class="fw-bold">Tidak Kerja</div>
                                                <small class="text-muted">Sedang mencari kerja</small>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Include semua bagian form dari komponen -->
                @include('components.form-alumni.bagian2-3-4', ['tracer' => $tracer])
                @include('components.form-alumni.bagian3-8', ['tracer' => $tracer])
                @include('components.form-alumni.bagian5', ['tracer' => $tracer])
                {{-- @include('components.form-alumni.bagian6', ['tracer' => $tracer]) --}}
                @include('components.form-alumni.bagian8', ['tracer' => $tracer])
                @include('components.form-alumni.bagian9', ['tracer' => $tracer])
                @include('components.form-alumni.bagian10-11-12', ['tracer' => $tracer])
                @include('components.form-alumni.bagian13', ['tracer' => $tracer])
                @include('components.form-alumni.bagian14', ['tracer' => $tracer])
                {{-- @include('components.form-alumni.bagian15', ['tracer' => $tracer]) --}}

                <!-- Submit Button -->
                <div class="text-center mt-5 mb-4">
                    <button type="submit" class="btn btn-primary btn-lg px-5">
                        <i class="fas fa-save me-2"></i>Update Data Tracer Study
                    </button>
                </div>
            </form>
        </div>
    </main>

    <!-- Custom CSS -->
    <style>
        .bg-gradient-primary {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        }

        .section-card {
            margin-bottom: 2rem;
        }

        .animate-fade-in {
            animation: fadeIn 0.6s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .card-radio {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            transition: all 0.3s ease;
            height: 100%;
        }

        .card-radio:hover {
            border-color: #007bff;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,123,255,0.15);
        }

        .card-radio input[type="radio"]:checked + label {
            background-color: #f8f9ff;
            border-color: #007bff;
        }

        .card-radio input[type="radio"] {
            display: none;
        }

        .card-radio label {
            cursor: pointer;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .form-label {
            font-weight: 600;
            color: #2c3e50;
        }

        .text-danger {
            color: #dc3545 !important;
        }

        .card-header {
            border-bottom: none;
            border-radius: 10px 10px 0 0 !important;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .btn-primary {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            border: none;
            border-radius: 25px;
            padding: 12px 30px;
            font-weight: 600;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,123,255,0.3);
        }

        .progress {
            border-radius: 10px;
            background-color: #e9ecef;
        }

        .progress-bar {
            border-radius: 10px;
            transition: width 0.3s ease;
        }

        /* Section styling for edit mode */
        .section-header {
            background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 10px 10px 0 0;
            margin-bottom: 0;
            font-weight: 600;
        }

        .section-body {
            background: white;
            padding: 1.5rem;
            border-radius: 0 0 10px 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .section-card .card {
            border: none;
            box-shadow: none;
        }

        /* Validation error styling */
        .is-invalid {
            border-color: #dc3545 !important;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
        }

        .invalid-feedback {
            display: block;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 0.875em;
            color: #dc3545;
        }
    </style>

    <!-- Edit Mode JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize form immediately
            initEditMode();

            // Load main JavaScript file
            loadMainScript();
        });

        function initEditMode() {
            // Add immediate event listeners
            const statusRadios = document.querySelectorAll('input[name="bekerja"]');

            statusRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    handleStatusChangeImmediate(this.value);
                });
            });

            // Show initial sections based on current status
            const checkedStatus = document.querySelector('input[name="bekerja"]:checked');
            if (checkedStatus) {
                handleStatusChangeImmediate(checkedStatus.value);
            }
        }

        function handleStatusChangeImmediate(status) {
            // Hide all sections first
            hideAllSections();

            // Show sections based on status
            switch (status) {
                case 'bekerja_full':
                    showSectionImmediate('waktuAlumniMendapatkanPekerjaan');
                    showSectionImmediate('lokasikerja');
                    showSectionImmediate('kesesuaianPekerjaan');
                    showSectionImmediate('kompetensiA');
                    showSectionImmediate('kompetensiB');
                    showSectionImmediate('caraMendapatkanPekerjaan');
                    showSectionImmediate('sectionCariKerja');
                    showSectionImmediate('evaluasiPendidikan');
                    showSectionImmediate('aktivitasSaatIni');
                    break;

                case 'wirausaha':
                    showSectionImmediate('wiraswasta');
                    showSectionImmediate('waktuAlumniMendapatkanPekerjaan');
                    showSectionImmediate('kesesuaianPekerjaan');
                    showSectionImmediate('kompetensiA');
                    showSectionImmediate('kompetensiB');
                    showSectionImmediate('evaluasiPendidikan');
                    showSectionImmediate('caraMendapatkanPekerjaan');
                    showSectionImmediate('sectionCariKerja');
                    showSectionImmediate('aktivitasSaatIni');
                    break;

                case 'lanjutstudy':
                    showSectionImmediate('detailLanjutStudy');
                    // showSectionImmediate('kompetensiA');
                    // showSectionImmediate('kompetensiB');
                    // showSectionImmediate('evaluasiPendidikan');
                    break;

                case 'belum_bekerja':
                    showSectionImmediate('aktivitasSaatIni');
                    break;

                case 'tidak':
                    // showSectionImmediate('caraMendapatkanPekerjaan');
                    showSectionImmediate('sectionCariKerja');
                    showSectionImmediate('aktivitasSaatIni');
                    break;
            }

            updateProgressImmediate();
        }

        function hideAllSections() {
            const sections = [
                'waktuAlumniMendapatkanPekerjaan',
                'lokasikerja',
                'wiraswasta',
                'detailLanjutStudy',
                'kesesuaianPekerjaan',
                'kompetensiA',
                'kompetensiB',
                'caraMendapatkanPekerjaan',
                'sectionCariKerja',
                'aktivitasSaatIni',
                'evaluasiPendidikan'
            ];

            sections.forEach(sectionId => {
                hideSectionImmediate(sectionId);
            });
        }

        function showSectionImmediate(sectionId) {
            const section = document.getElementById(sectionId);
            if (section) {
                section.style.display = 'block';
                section.classList.add('animate-fade-in');
            }
        }

        function hideSectionImmediate(sectionId) {
            const section = document.getElementById(sectionId);
            if (section) {
                section.style.display = 'none';
                section.classList.remove('animate-fade-in');
            }
        }

        function updateProgressImmediate() {
            const form = document.getElementById('tracerStudyForm');
            if (!form) return;

            const allInputs = form.querySelectorAll('input[required], select[required], textarea[required]');
            const visibleInputs = Array.from(allInputs).filter(input => {
                const section = input.closest('.section-card, [id*="section"], [id*="Section"]');
                return !section || window.getComputedStyle(section).display !== 'none';
            });

            const filledInputs = visibleInputs.filter(input => {
                if (input.type === 'radio') {
                    const name = input.name;
                    return form.querySelector(`input[name="${name}"]:checked`);
                }
                return input.value.trim() !== '';
            });

            const progress = visibleInputs.length > 0 ? Math.round((filledInputs.length / visibleInputs.length) * 100) : 0;

            const progressBar = document.getElementById('progress-bar');
            const progressText = document.getElementById('progress-text');

            if (progressBar && progressText) {
                progressBar.style.width = progress + '%';
                progressText.textContent = progress + '%';
            }
        }

        function loadMainScript() {
            // Load the main tracer study JavaScript
            const script = document.createElement('script');
            script.src = '{{ asset("js/tracer-study-form.js") }}';
            script.onload = function() {
                // Re-trigger section update after main script loads
                setTimeout(() => {
                    const checkedStatus = document.querySelector('input[name="bekerja"]:checked');
                    if (checkedStatus && typeof updateFormSections === 'function') {
                        updateFormSections();
                    }
                }, 100);
            };
            document.head.appendChild(script);
        }



        // Update progress when form changes
        document.addEventListener('input', updateProgressImmediate);
        document.addEventListener('change', updateProgressImmediate);

        // Add form validation for bulan_kerja_lebih6
        document.addEventListener('submit', function(e) {
            const form = e.target;
            const bulanLebih6Field = form.querySelector('input[name="bulan_kerja_lebih6"]');
            const detailLebih6Section = document.getElementById('detailLebih6Bulan');

            // Check if the lebih dari 6 bulan section is visible
            if (bulanLebih6Field && detailLebih6Section &&
                window.getComputedStyle(detailLebih6Section).display !== 'none') {

                const value = parseInt(bulanLebih6Field.value);

                // If field is visible, it must have a value >= 7
                if (isNaN(value) || value < 7) {
                    e.preventDefault();
                    bulanLebih6Field.focus();
                    bulanLebih6Field.classList.add('is-invalid');

                    // Show error message
                    let errorDiv = bulanLebih6Field.nextElementSibling;
                    if (!errorDiv || !errorDiv.classList.contains('invalid-feedback')) {
                        errorDiv = document.createElement('div');
                        errorDiv.className = 'invalid-feedback';
                        bulanLebih6Field.parentNode.appendChild(errorDiv);
                    }
                    errorDiv.textContent = 'Untuk pilihan lebih dari 6 bulan, minimal 7 bulan.';

                    return false;
                } else {
                    bulanLebih6Field.classList.remove('is-invalid');
                    const errorDiv = bulanLebih6Field.nextElementSibling;
                    if (errorDiv && errorDiv.classList.contains('invalid-feedback')) {
                        errorDiv.remove();
                    }
                }
            }
        });

        // Initialize pekerjaan detail toggle functionality
        function initPekerjaanDetailToggle() {
        const select = document.getElementById('mendapatkanPekerjaan');
        const detailKurang6 = document.getElementById('detailKurang6Bulan');
        const detailLebih6 = document.getElementById('detailLebih6Bulan');

            if (!select || !detailKurang6 || !detailLebih6) {
                console.log('Pekerjaan detail elements not found');
                return;
            }

        function toggleDetail() {
            const selectedValue = select.value;
                console.log('Selected value:', selectedValue);

                // Reset - hide both sections
            detailKurang6.style.display = 'none';
            detailLebih6.style.display = 'none';

            // Tampilkan bagian sesuai pilihan
            if (selectedValue === '<=6bulan') {
                detailKurang6.style.display = 'flex';
                    console.log('Showing detailKurang6');
            } else if (selectedValue === '>6bulan') {
                detailLebih6.style.display = 'flex';
                    console.log('Showing detailLebih6');
                }
            }

            // Add event listener
            select.addEventListener('change', toggleDetail);

            // Initial toggle based on current value
            toggleDetail();
        }

        // Initialize after sections are shown
        function initPekerjaanToggleAfterSections() {
            // Wait for sections to be visible
            const checkSections = setInterval(() => {
                const section = document.getElementById('waktuAlumniMendapatkanPekerjaan');
                if (section && window.getComputedStyle(section).display !== 'none') {
                    clearInterval(checkSections);
                    setTimeout(initPekerjaanDetailToggle, 100);
                }
            }, 100);

            // Timeout after 5 seconds to prevent infinite checking
            setTimeout(() => clearInterval(checkSections), 5000);
        }

        // Start the initialization process
        initPekerjaanToggleAfterSections();
    </script>


<!-- JavaScript untuk toggle field bulan -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Ambil semua radio button untuk waktu cari kerja
        const radioButtons = document.querySelectorAll('input[name="waktu_cari_kerja"]');
        const bulanSebelumLulus = document.getElementById('bulanSebelumLulus');
        const bulanSetelahLulus = document.getElementById('bulanSetelahLulus');

        // Function untuk toggle field bulan
        function toggleBulanField() {
            const selectedValue = document.querySelector('input[name="waktu_cari_kerja"]:checked')?.value;

            // Reset - hide semua field bulan
            bulanSebelumLulus.style.display = 'none';
            bulanSetelahLulus.style.display = 'none';

            // Clear nilai field yang tidak relevan
            if (selectedValue !== 'sebelum_lulus') {
                document.getElementById('bulan_sebelum_lulus').value = '';
            }
            if (selectedValue !== 'setelah_lulus') {
                document.getElementById('bulan_setelah_lulus').value = '';
            }

            // Tampilkan field yang sesuai
            if (selectedValue === 'sebelum_lulus') {
                bulanSebelumLulus.style.display = 'block';
            } else if (selectedValue === 'setelah_lulus') {
                bulanSetelahLulus.style.display = 'block';
            }
            // Jika 'tidak_mencari', tidak ada field yang ditampilkan
        }

        // Tambahkan event listener untuk setiap radio button
        radioButtons.forEach(radio => {
            radio.addEventListener('change', toggleBulanField);
        });

        // Jalankan toggle saat halaman dimuat (untuk edit form)
        toggleBulanField();
    });
    </script>


<!-- JavaScript untuk cascade dropdown provinsi-kota -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Initializing provinsi-kota cascade dropdown...');

        const provinsiSelect = document.getElementById('provinsi');
        const kotaSelect = document.getElementById('kota');

        if (!provinsiSelect || !kotaSelect) {
            console.log('Provinsi atau Kota select elements tidak ditemukan');
            return;
        }

        console.log('Elements found:', {
            provinsi: !!provinsiSelect,
            kota: !!kotaSelect
        });

        // Function untuk update kota dropdown berdasarkan provinsi yang dipilih
        function updateKotaDropdown() {
            const selectedProvinsi = provinsiSelect.value;
            console.log('Provinsi selected:', selectedProvinsi);

            // Reset kota dropdown
            kotaSelect.innerHTML = '<option value="" disabled>-- Pilih Kabupaten/Kota --</option>';

            if (!selectedProvinsi) {
                kotaSelect.disabled = true;
                console.log('No provinsi selected, kota dropdown disabled');
                return;
            }

            // Enable kota dropdown
            kotaSelect.disabled = false;
            console.log('Fetching cities for provinsi:', selectedProvinsi);

            // Fetch kota berdasarkan provinsi yang dipilih
            fetch(`/api/kota/${selectedProvinsi}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(cities => {
                    console.log('Cities loaded:', cities);

                    // Populate kota dropdown
                    Object.keys(cities).forEach(code => {
                        const option = document.createElement('option');
                        option.value = code;
                        option.textContent = cities[code];

                        // Check if this city was previously selected (for edit form)
                        const oldKota = '{{ old("kota", $tracer->pekerjaan->kota ?? "") }}';
                        if (oldKota && oldKota === code) {
                            option.selected = true;
                            console.log('Restored previous kota selection:', cities[code]);
                        }

                        kotaSelect.appendChild(option);
                    });

                    console.log(`Loaded ${Object.keys(cities).length} cities`);
                })
                .catch(error => {
                    console.error('Error loading cities:', error);
                    // Fallback: show error message
                    const option = document.createElement('option');
                    option.value = '';
                    option.textContent = 'Error loading cities - ' + error.message;
                    option.disabled = true;
                    kotaSelect.appendChild(option);
                });
        }

        // Add event listener untuk perubahan provinsi
        provinsiSelect.addEventListener('change', function(e) {
            console.log('Provinsi changed to:', e.target.value);
            updateKotaDropdown();
        });

        // Initialize kota dropdown jika provinsi sudah dipilih (untuk edit form)
        if (provinsiSelect.value) {
            console.log('Initializing kota dropdown for edit form with provinsi:', provinsiSelect.value);
            setTimeout(updateKotaDropdown, 100); // Small delay to ensure DOM is ready
        } else {
            console.log('No provinsi selected initially, kota dropdown will be disabled');
            kotaSelect.disabled = true;
        }
    });
</script>

@endsection
