/**
 * JavaScript untuk Tracer Study Form
 * Mengelola visibility section berdasarkan status pekerjaan
 */

document.addEventListener('DOMContentLoaded', function() {
    initTracerStudyForm();
});

function initTracerStudyForm() {
    // Handler untuk radio button status pekerjaan
    const statusRadios = document.querySelectorAll('input[name="bekerja"]');
    statusRadios.forEach(radio => {
        radio.addEventListener('change', handleStatusChange);
    });

    // Handler untuk mendapatkan pekerjaan
    const mendapatkanPekerjaanSelect = document.getElementById('mendapatkanPekerjaan');
    if (mendapatkanPekerjaanSelect) {
        mendapatkanPekerjaanSelect.addEventListener('change', handleMendapatkanPekerjaanChange);
    }

    // Handler untuk sumber biaya
    const sumberBiayaSelect = document.getElementById('sumberBiayaSelect');
    if (sumberBiayaSelect) {
        sumberBiayaSelect.addEventListener('change', handleSumberBiayaChange);
    }

    // Handler untuk waktu cari kerja (bagian 10-11-12)
    const waktuCariKerjaRadios = document.querySelectorAll('input[name="waktu_cari_kerja"]');
    waktuCariKerjaRadios.forEach(radio => {
        radio.addEventListener('change', handleWaktuCariKerjaChange);
    });

    // Reset required attributes terlebih dahulu
    resetRequiredAttributes();

    // Inisialisasi awal
    updateFormSections();

    // Progress tracking
    initProgressTracking();

    // Check existing data
    checkExistingData();

    // Initialize job search form fields
    initializeJobSearchFields();

    // Initialize CSRF token refresh
    initCsrfTokenRefresh();
}

function handleStatusChange() {
    updateFormSections();
    updateProgressBar();
}

function updateFormSections() {
    const selectedStatus = document.querySelector('input[name="bekerja"]:checked');

    // Sembunyikan semua section detail
    hideAllDetailSections();

    // Reset semua required attributes
    resetRequiredAttributes();

    if (!selectedStatus) return;

    const status = selectedStatus.value;

    // Tampilkan section yang sesuai dan set required attributes
    switch (status) {
        case 'bekerja_full':
            showSection('waktuAlumniMendapatkanPekerjaan');
            showSection('lokasikerja');
            showSection('kesesuaianPekerjaan');
            showSection('kompetensiA');
            showSection('kompetensiB');
            showSection('caraMendapatkanPekerjaan');
            showSection('sectionCariKerja');
            showSection('evaluasiPendidikan');
            showSection('aktivitasSaatIni');
            setRequiredForWorkingSections();
            break;

        case 'wirausaha':
            showSection('wiraswasta');
            showSection('waktuAlumniMendapatkanPekerjaan');
            showSection('kesesuaianPekerjaan');
            showSection('kompetensiA');
            showSection('kompetensiB');
            showSection('evaluasiPendidikan');
            showSection('caraMendapatkanPekerjaan');
            showSection('sectionCariKerja');
            showSection('aktivitasSaatIni');
            setRequiredForWirausahaSections();
            break;

        case 'lanjutstudy':
            showSection('detailLanjutStudy');
            // showSection('kompetensiA');
            // showSection('kompetensiB');
            // showSection('evaluasiPendidikan');
            setRequiredForStudySections();
            break;

        case 'belum_bekerja':
            showSection('aktivitasSaatIni');
            setRequiredForUnemployedSections();
            break;

        case 'tidak':
            // showSection('caraMendapatkanPekerjaan');
            showSection('sectionCariKerja');
            showSection('aktivitasSaatIni');
            setRequiredForUnemployedSections();
            break;
    }
}

function hideAllDetailSections() {
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
        hideSection(sectionId);
    });
}

function showSection(sectionId) {
    const section = document.getElementById(sectionId);
    if (section) {
        section.style.display = 'block';
        section.classList.add('animate-fade-in');
    }
}

function hideSection(sectionId) {
    const section = document.getElementById(sectionId);
    if (section) {
        section.style.display = 'none';
        section.classList.remove('animate-fade-in');
    }
}

function resetRequiredAttributes() {
    // Hapus required dari semua field yang bisa tersembunyi
    const fieldsToReset = [
        // Pekerjaan fields
        'mendapatkan_pekerjaan',
        'bulan_kerja_kurang6', 'bulan_kerja_lebih6',
        'pendapatan_kurang6', 'pendapatan_lebih6',
        'nama_perusahaan', 'jabatan', 'alamat_pekerjaan',
        'provinsi', 'kota', 'tingkat_usaha_level',
        'hubungan_studi_pekerjaan', 'pendidikan_sesuai_pekerjaan',
        'nama_atasan', 'jabatan_atasan', 'wa_atasan', 'email_atasan',

        // Wirausaha fields
        'nama_usaha', 'posisi_usaha', 'alamat_usaha', 'pendapatan_usaha',

        // Pendidikan fields
        'universitas', 'program_studi', 'sumber_biaya', 'tanggal_masuk', 'lokasi_universitas',

        // Kompetensi fields (yang conditional required)
        'etika_awal', 'keahlian_awal', 'bahasa_inggris_awal', 'teknologi_awal', 'kerjasama_awal', 'komunikasi_awal', 'pengembangan_awal',
        'etika_sekarang', 'keahlian_sekarang', 'bahasa_inggris_sekarang', 'teknologi_sekarang', 'kerjasama_sekarang', 'komunikasi_sekarang', 'pengembangan_sekarang',

        // Pencarian kerja fields
        'waktu_cari_kerja', 'aktif_cari_kerja',
        'jumlah_perusahaan_lamar', 'jumlah_perusahaan_respon', 'jumlah_perusahaan_wawancara',
        'bulan_sebelum_lulus', 'bulan_setelah_lulus',

        // Aktivitas saat ini fields
        'aktif_cari_kerja_4minggu', 'alasan_pekerjaan_tidak_sesuai',

        // Evaluasi pendidikan fields
        'perkuliahan', 'praktikum', 'demonstrasi', 'riset', 'magang', 'kerja_lapangan', 'diskusi',

        // Saran dan masukan
        'saran',

        // Other fields
        'sumber_informasi', 'faktor_utama_diterima', 'hambatan_mencari_kerja'
    ];

    fieldsToReset.forEach(fieldName => {
        const field = document.querySelector(`[name="${fieldName}"]`);
        if (field) {
            field.removeAttribute('required');
        }
    });

    // Reset checkboxes for cara_mencari_kerja
    const checkboxes = document.querySelectorAll('input[name="cara_mencari_kerja[]"]');
    checkboxes.forEach(checkbox => {
        checkbox.removeAttribute('required');
    });

    // Reset field bulan pencarian kerja
    const bulanSebelumLulus = document.getElementById('bulanSebelumLulus');
    const bulanSetelahLulus = document.getElementById('bulanSetelahLulus');
    if (bulanSebelumLulus) bulanSebelumLulus.style.display = 'none';
    if (bulanSetelahLulus) bulanSetelahLulus.style.display = 'none';
}

function setRequiredForWorkingSections() {
    // Set required untuk field pekerjaan yang wajib
    const requiredWorkFields = [
        'mendapatkan_pekerjaan',
        'nama_perusahaan', 'jabatan', 'alamat_pekerjaan',
        'provinsi', 'kota', 'hubungan_studi_pekerjaan', 'pendidikan_sesuai_pekerjaan',
        // Pencarian kerja fields (hanya untuk yang bekerja)
        'waktu_cari_kerja', 'aktif_cari_kerja',
        // Aktivitas saat ini untuk yang bekerja
        'aktif_cari_kerja_4minggu'
    ];

    requiredWorkFields.forEach(fieldName => {
        const field = document.querySelector(`[name="${fieldName}"]`);
        if (field) {
            field.setAttribute('required', 'required');
        }
    });

    // Set required untuk field bulan berdasarkan pilihan waktu cari kerja
    const selectedWaktuCariKerja = document.querySelector('input[name="waktu_cari_kerja"]:checked');
    if (selectedWaktuCariKerja) {
        if (selectedWaktuCariKerja.value === 'sebelum_lulus') {
            const bulanSebelumLulus = document.querySelector('[name="bulan_sebelum_lulus"]');
            if (bulanSebelumLulus) bulanSebelumLulus.setAttribute('required', 'required');
        } else if (selectedWaktuCariKerja.value === 'setelah_lulus') {
            const bulanSetelahLulus = document.querySelector('[name="bulan_setelah_lulus"]');
            if (bulanSetelahLulus) bulanSetelahLulus.setAttribute('required', 'required');
        }
    }

    // Set required untuk field atasan hanya jika section visible
    const atasanSection = document.querySelector('input[name="nama_atasan"]');
    if (atasanSection && isFieldVisible(atasanSection)) {
        atasanSection.setAttribute('required', 'required');
    }

    const jabatanAtasanSection = document.querySelector('input[name="jabatan_atasan"]');
    if (jabatanAtasanSection && isFieldVisible(jabatanAtasanSection)) {
        jabatanAtasanSection.setAttribute('required', 'required');
    }

    // Set required untuk field kompetensi (hanya untuk yang bekerja)
    const kompetensiFields = [
        'etika_awal', 'keahlian_awal', 'bahasa_inggris_awal', 'teknologi_awal',
        'kerjasama_awal', 'komunikasi_awal', 'pengembangan_awal',
        'etika_sekarang', 'keahlian_sekarang', 'bahasa_inggris_sekarang', 'teknologi_sekarang',
        'kerjasama_sekarang', 'komunikasi_sekarang', 'pengembangan_sekarang'
    ];

    kompetensiFields.forEach(fieldName => {
        const field = document.querySelector(`[name="${fieldName}"]`);
        if (field) {
            field.setAttribute('required', 'required');
        }
    });

    // Set required untuk field evaluasi pendidikan (hanya untuk yang bekerja)
    const evaluasiFields = [
        'perkuliahan', 'praktikum', 'demonstrasi', 'riset', 'magang', 'kerja_lapangan', 'diskusi'
    ];

    evaluasiFields.forEach(fieldName => {
        const field = document.querySelector(`[name="${fieldName}"]`);
        if (field) {
            field.setAttribute('required', 'required');
        }
    });
}

function setRequiredForWirausahaSections() {
    // Set required untuk field wirausaha yang wajib
    const requiredWirausahaFields = [
        'nama_usaha', 'posisi_usaha', 'alamat_usaha',
        // Pencarian kerja fields (hanya untuk yang bekerja)
        'waktu_cari_kerja', 'aktif_cari_kerja',
        // Aktivitas saat ini untuk yang bekerja
        'aktif_cari_kerja_4minggu'
    ];

    requiredWirausahaFields.forEach(fieldName => {
        const field = document.querySelector(`[name="${fieldName}"]`);
        if (field) {
            field.setAttribute('required', 'required');
        }
    });

    // Pastikan field atasan TIDAK required untuk wirausaha
    const atasanFields = ['nama_atasan', 'jabatan_atasan', 'wa_atasan', 'email_atasan'];
    atasanFields.forEach(fieldName => {
        const field = document.querySelector(`[name="${fieldName}"]`);
        if (field) {
            field.removeAttribute('required');
        }
    });

    // Pastikan field pekerjaan TIDAK required untuk wirausaha
    const pekerjaanFields = [
        'hubungan_studi_pekerjaan', 'pendidikan_sesuai_pekerjaan',
        'nama_perusahaan', 'jabatan', 'alamat_pekerjaan', 'provinsi', 'kota'
    ];
    pekerjaanFields.forEach(fieldName => {
        const field = document.querySelector(`[name="${fieldName}"]`);
        if (field) {
            field.removeAttribute('required');
        }
    });

    // Pastikan field pendidikan TIDAK required untuk wirausaha
    const pendidikanFields = [
        'universitas', 'program_studi', 'sumber_biaya', 'tanggal_masuk', 'lokasi_universitas'
    ];
    pendidikanFields.forEach(fieldName => {
        const field = document.querySelector(`[name="${fieldName}"]`);
        if (field) {
            field.removeAttribute('required');
        }
    });

    // Set required untuk field kompetensi (untuk wirausaha juga)
    const kompetensiFields = [
        'etika_awal', 'keahlian_awal', 'bahasa_inggris_awal', 'teknologi_awal',
        'kerjasama_awal', 'komunikasi_awal', 'pengembangan_awal',
        'etika_sekarang', 'keahlian_sekarang', 'bahasa_inggris_sekarang', 'teknologi_sekarang',
        'kerjasama_sekarang', 'komunikasi_sekarang', 'pengembangan_sekarang'
    ];

    kompetensiFields.forEach(fieldName => {
        const field = document.querySelector(`[name="${fieldName}"]`);
        if (field) {
            field.setAttribute('required', 'required');
        }
    });

    // Set required untuk field evaluasi pendidikan (untuk wirausaha juga)
    const evaluasiFields = [
        'perkuliahan', 'praktikum', 'demonstrasi', 'riset', 'magang', 'kerja_lapangan', 'diskusi'
    ];

    evaluasiFields.forEach(fieldName => {
        const field = document.querySelector(`[name="${fieldName}"]`);
        if (field) {
            field.setAttribute('required', 'required');
        }
    });
}

function setRequiredForStudySections() {
    // Set required untuk field pendidikan yang wajib
    const requiredStudyFields = [
        'universitas', 'program_studi', 'sumber_biaya', 'tanggal_masuk', 'lokasi_universitas'
    ];

    requiredStudyFields.forEach(fieldName => {
        const field = document.querySelector(`[name="${fieldName}"]`);
        if (field) {
            field.setAttribute('required', 'required');
        }
    });

    // Pastikan field atasan TIDAK required untuk yang melanjutkan study
    const atasanFields = ['nama_atasan', 'jabatan_atasan', 'wa_atasan', 'email_atasan'];
    atasanFields.forEach(fieldName => {
        const field = document.querySelector(`[name="${fieldName}"]`);
        if (field) {
            field.removeAttribute('required');
        }
    });

    // Pastikan field kompetensi TIDAK required untuk yang melanjutkan study
    const kompetensiFields = [
        'etika_awal', 'keahlian_awal', 'bahasa_inggris_awal', 'teknologi_awal',
        'kerjasama_awal', 'komunikasi_awal', 'pengembangan_awal',
        'etika_sekarang', 'keahlian_sekarang', 'bahasa_inggris_sekarang', 'teknologi_sekarang',
        'kerjasama_sekarang', 'komunikasi_sekarang', 'pengembangan_sekarang'
    ];

    kompetensiFields.forEach(fieldName => {
        const field = document.querySelector(`[name="${fieldName}"]`);
        if (field) {
            field.removeAttribute('required');
        }
    });

    // Pastikan field evaluasi pendidikan TIDAK required untuk yang melanjutkan study
    const evaluasiFields = [
        'perkuliahan', 'praktikum', 'demonstrasi', 'riset', 'magang', 'kerja_lapangan', 'diskusi'
    ];

    evaluasiFields.forEach(fieldName => {
        const field = document.querySelector(`[name="${fieldName}"]`);
        if (field) {
            field.removeAttribute('required');
        }
    });
}

function setRequiredForUnemployedSections() {
    // Untuk yang belum/tidak bekerja, set required untuk aktivitas saat ini
    const requiredUnemployedFields = [
        'aktif_cari_kerja_4minggu'
    ];

    requiredUnemployedFields.forEach(fieldName => {
        const field = document.querySelector(`[name="${fieldName}"]`);
        if (field) {
            field.setAttribute('required', 'required');
        }
    });

    // Pastikan field atasan TIDAK required untuk yang tidak bekerja
    const atasanFields = ['nama_atasan', 'jabatan_atasan', 'wa_atasan', 'email_atasan'];
    atasanFields.forEach(fieldName => {
        const field = document.querySelector(`[name="${fieldName}"]`);
        if (field) {
            field.removeAttribute('required');
        }
    });

    // Pastikan field kompetensi TIDAK required untuk yang tidak bekerja
    const kompetensiFields = [
        'etika_awal', 'keahlian_awal', 'bahasa_inggris_awal', 'teknologi_awal',
        'kerjasama_awal', 'komunikasi_awal', 'pengembangan_awal',
        'etika_sekarang', 'keahlian_sekarang', 'bahasa_inggris_sekarang', 'teknologi_sekarang',
        'kerjasama_sekarang', 'komunikasi_sekarang', 'pengembangan_sekarang'
    ];

    kompetensiFields.forEach(fieldName => {
        const field = document.querySelector(`[name="${fieldName}"]`);
        if (field) {
            field.removeAttribute('required');
        }
    });

    // Pastikan field evaluasi pendidikan TIDAK required untuk yang tidak bekerja
    const evaluasiFields = [
        'perkuliahan', 'praktikum', 'demonstrasi', 'riset', 'magang', 'kerja_lapangan', 'diskusi'
    ];

    evaluasiFields.forEach(fieldName => {
        const field = document.querySelector(`[name="${fieldName}"]`);
        if (field) {
            field.removeAttribute('required');
        }
    });

    // Set required untuk field bulan berdasarkan pilihan waktu cari kerja (jika ada)
    const selectedWaktuCariKerja = document.querySelector('input[name="waktu_cari_kerja"]:checked');
    if (selectedWaktuCariKerja) {
        if (selectedWaktuCariKerja.value === 'sebelum_lulus') {
            const bulanSebelumLulus = document.querySelector('[name="bulan_sebelum_lulus"]');
            if (bulanSebelumLulus) bulanSebelumLulus.setAttribute('required', 'required');
        } else if (selectedWaktuCariKerja.value === 'setelah_lulus') {
            const bulanSetelahLulus = document.querySelector('[name="bulan_setelah_lulus"]');
            if (bulanSetelahLulus) bulanSetelahLulus.setAttribute('required', 'required');
        }
    }
}

function handleMendapatkanPekerjaanChange() {
    const select = document.getElementById('mendapatkanPekerjaan');
    const detailKurang6 = document.getElementById('detailKurang6Bulan');
    const detailLebih6 = document.getElementById('detailLebih6Bulan');

    if (!select || !detailKurang6 || !detailLebih6) return;

    const selectedValue = select.value;

    // Reset semua field mendapatkan pekerjaan
    resetMendapatkanPekerjaanFields();

    // Tampilkan bagian sesuai pilihan dan set required
    if (selectedValue === '<=6bulan') {
        detailKurang6.style.display = 'flex';
        setRequiredForKurang6Bulan();
    } else if (selectedValue === '>6bulan') {
        detailLebih6.style.display = 'flex';
        setRequiredForLebih6Bulan();
    }
}

function resetMendapatkanPekerjaanFields() {
    const detailKurang6 = document.getElementById('detailKurang6Bulan');
    const detailLebih6 = document.getElementById('detailLebih6Bulan');

    if (detailKurang6) detailKurang6.style.display = 'none';
    if (detailLebih6) detailLebih6.style.display = 'none';

    // Reset required attributes
    const fieldsToReset = [
        'bulan_kerja_kurang6', 'pendapatan_kurang6',
        'bulan_kerja_lebih6', 'pendapatan_lebih6'
    ];

    fieldsToReset.forEach(fieldName => {
        const field = document.querySelector(`[name="${fieldName}"]`);
        if (field) {
            field.removeAttribute('required');
        }
    });
}

function setRequiredForKurang6Bulan() {
    const fields = ['bulan_kerja_kurang6', 'pendapatan_kurang6'];
    fields.forEach(fieldName => {
        const field = document.querySelector(`[name="${fieldName}"]`);
        if (field) {
            field.setAttribute('required', 'required');
        }
    });
}

function setRequiredForLebih6Bulan() {
    const fields = ['bulan_kerja_lebih6', 'pendapatan_lebih6'];
    fields.forEach(fieldName => {
        const field = document.querySelector(`[name="${fieldName}"]`);
        if (field) {
            field.setAttribute('required', 'required');
        }
    });
}

function handleSumberBiayaChange() {
    const select = document.getElementById('sumberBiayaSelect');
    const lainnyaDiv = document.getElementById('sumberBiayaLainnya');

    if (!select || !lainnyaDiv) return;

    if (select.value === 'lainnya') {
        lainnyaDiv.style.display = 'block';
    } else {
        lainnyaDiv.style.display = 'none';
    }
}

function initializeJobSearchFields() {
    // Inisialisasi field bulan berdasarkan data yang sudah ada
    const selectedWaktuCariKerja = document.querySelector('input[name="waktu_cari_kerja"]:checked');
    if (selectedWaktuCariKerja) {
        handleWaktuCariKerjaChange();
    }

    // Add input validation for month fields
    const bulanSebelumLulusInput = document.getElementById('bulan_sebelum_lulus');
    const bulanSetelahLulusInput = document.getElementById('bulan_setelah_lulus');

    if (bulanSebelumLulusInput) {
        bulanSebelumLulusInput.addEventListener('input', function() {
            validateMonthInput(this, 1, 60);
        });
    }

    if (bulanSetelahLulusInput) {
        bulanSetelahLulusInput.addEventListener('input', function() {
            validateMonthInput(this, 1, 60);
        });
    }
}

function validateMonthInput(input, min, max) {
    let value = parseInt(input.value);

    if (isNaN(value) || value < min) {
        input.value = min;
    } else if (value > max) {
        input.value = max;
    }

    // Update progress bar
    updateProgressBar();
}

function handleWaktuCariKerjaChange() {
    const selectedRadio = document.querySelector('input[name="waktu_cari_kerja"]:checked');
    const bulanSebelumLulus = document.getElementById('bulanSebelumLulus');
    const bulanSetelahLulus = document.getElementById('bulanSetelahLulus');
    const bulanSebelumLulusInput = document.getElementById('bulan_sebelum_lulus');
    const bulanSetelahLulusInput = document.getElementById('bulan_setelah_lulus');

    if (!bulanSebelumLulus || !bulanSetelahLulus || !bulanSebelumLulusInput || !bulanSetelahLulusInput) return;

    if (!selectedRadio) {
        // Jika tidak ada yang dipilih, sembunyikan semua
        bulanSebelumLulus.style.display = 'none';
        bulanSetelahLulus.style.display = 'none';
        bulanSebelumLulusInput.removeAttribute('required');
        bulanSetelahLulusInput.removeAttribute('required');
        return;
    }

    const selectedValue = selectedRadio.value;

    // Reset semua field bulan
    bulanSebelumLulus.style.display = 'none';
    bulanSetelahLulus.style.display = 'none';
    bulanSebelumLulusInput.removeAttribute('required');
    bulanSetelahLulusInput.removeAttribute('required');

    // Clear values when hiding fields
    if (selectedValue !== 'sebelum_lulus') {
        bulanSebelumLulusInput.value = '';
    }
    if (selectedValue !== 'setelah_lulus') {
        bulanSetelahLulusInput.value = '';
    }

    // Tampilkan field yang sesuai
    if (selectedValue === 'sebelum_lulus') {
        bulanSebelumLulus.style.display = 'block';
        bulanSebelumLulusInput.setAttribute('required', 'required');
        // Focus ke input field
        setTimeout(() => {
            bulanSebelumLulusInput.focus();
        }, 100);
    } else if (selectedValue === 'setelah_lulus') {
        bulanSetelahLulus.style.display = 'block';
        bulanSetelahLulusInput.setAttribute('required', 'required');
        // Focus ke input field
        setTimeout(() => {
            bulanSetelahLulusInput.focus();
        }, 100);
    }
    // Jika 'tidak_mencari', tidak ada field tambahan yang ditampilkan

    // Update progress bar setelah perubahan
    updateProgressBar();
}

function initProgressTracking() {
    const form = document.getElementById('alumniForm');
    if (!form) return;

    const inputs = form.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
        input.addEventListener('change', updateProgressBar);
        input.addEventListener('keyup', debounce(updateProgressBar, 500));
    });
}

function updateProgressBar() {
    const form = document.getElementById('alumniForm');
    const progressBar = document.getElementById('progressBar');
    const progressText = document.getElementById('progressText');

    if (!form || !progressBar || !progressText) return;

    const requiredInputs = form.querySelectorAll('input[required], select[required], textarea[required]');

    // Filter hanya field yang visible dan required
    const visibleRequiredInputs = Array.from(requiredInputs).filter(input => {
        return isFieldVisible(input);
    });

    const filledInputs = visibleRequiredInputs.filter(input => {
        if (input.type === 'radio') {
            return document.querySelector(`input[name="${input.name}"]:checked`);
        } else if (input.type === 'checkbox' && input.name.includes('[]')) {
            // Untuk checkbox group
            const checkedBoxes = document.querySelectorAll(`input[name="${input.name}"]:checked`);
            return checkedBoxes.length > 0;
        }
        return input.value.trim() !== '';
    });

    const progress = visibleRequiredInputs.length > 0
        ? Math.round((filledInputs.length / visibleRequiredInputs.length) * 100)
        : 0;

    progressBar.style.width = progress + '%';
    progressText.textContent = progress + '%';

    // Update color based on progress
    if (progress < 30) {
        progressBar.className = 'progress-bar bg-danger';
    } else if (progress < 70) {
        progressBar.className = 'progress-bar bg-warning';
    } else {
        progressBar.className = 'progress-bar bg-success';
    }
}

function checkExistingData() {
    fetch('/new-tracer/check-existing')
        .then(response => response.json())
        .then(data => {
            if (data.exists) {
                showExistingDataAlert(data.data);
            }
        })
        .catch(error => {
            console.error('Error checking existing data:', error);
        });
}

function showExistingDataAlert(data) {
    const alertHtml = `
        <div class="container">
            <div class="alert alert-info mt-3 animate-fade-in">
                <i class="fas fa-info-circle me-2"></i>
                <strong>Informasi:</strong> Anda sudah pernah mengisi tracer study pada tanggal ${data.tanggal_isi}
                dengan status "${getStatusLabel(data.status_pekerjaan)}".
                <a href="/new-tracer/edit" class="btn btn-sm btn-outline-primary ms-2">
                    <i class="fas fa-edit"></i> Edit Data
                </a>
            </div>
        </div>
    `;

    const navbar = document.querySelector('.navbar');
    if (navbar) {
        navbar.insertAdjacentHTML('afterend', alertHtml);
    }
}

function getStatusLabel(status) {
    const labels = {
        'bekerja_full': 'Bekerja (Full/Part Time)',
        'belum_bekerja': 'Belum Memungkinkan Bekerja',
        'wirausaha': 'Wiraswasta',
        'lanjutstudy': 'Melanjutkan Pendidikan',
        'tidak': 'Tidak Kerja, Sedang Mencari Kerja'
    };
    return labels[status] || status;
}

// Utility functions
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Scroll to top function
function scrollToTop() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
}

// Show/hide back to top button
window.addEventListener('scroll', function() {
    const backToTopBtn = document.getElementById('backToTop');
    if (backToTopBtn) {
        if (window.pageYOffset > 300) {
            backToTopBtn.style.display = 'block';
        } else {
            backToTopBtn.style.display = 'none';
        }
    }
});

// Form validation before submit
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('alumniForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            console.log('Form submission started');

            const validationResult = validateForm();
            console.log('Validation result:', validationResult);

            if (!validationResult.isValid) {
                e.preventDefault();
                console.log('Form validation failed, preventing submission');
                showValidationErrors(validationResult.errors);
                return;
            }

            console.log('Form validation passed, allowing submission');

            // Tambahkan loading state
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
            }

            // Log form data for debugging
            const formData = new FormData(form);
            console.log('Form data to be submitted:');
            for (let [key, value] of formData.entries()) {
                console.log(key + ': ' + value);
            }

            // Form akan di-submit secara normal
            console.log('Proceeding with normal form submission...');
        });
    }
});

function validateForm() {
    const form = document.getElementById('alumniForm');
    if (!form) return { isValid: true, errors: [] };

    const errors = [];
    const selectedStatus = document.querySelector('input[name="bekerja"]:checked');

    // Validasi status pekerjaan
    if (!selectedStatus) {
        errors.push('Status pekerjaan wajib dipilih');
    }

    // Validasi field yang visible dan required
    const requiredInputs = form.querySelectorAll('input[required], select[required], textarea[required]');

    for (let input of requiredInputs) {
        // Skip jika field tersembunyi
        if (!isFieldVisible(input)) continue;

        if (input.type === 'radio') {
            if (!document.querySelector(`input[name="${input.name}"]:checked`)) {
                errors.push(`Field ${input.name} wajib diisi`);
            }
        } else if (input.type === 'checkbox') {
            // Untuk checkbox group (seperti cara_mencari_kerja[])
            if (input.name.includes('[]')) {
                const groupName = input.name.replace('[]', '');
                const checkedBoxes = document.querySelectorAll(`input[name="${input.name}"]:checked`);
                if (checkedBoxes.length === 0 && isFieldVisible(input)) {
                    errors.push(`Field ${groupName} wajib dipilih minimal satu opsi`);
                }
            }
        } else if (!input.value.trim()) {
            errors.push(`Field ${input.name} wajib diisi`);
        }
    }

    // Validasi conditional berdasarkan status
    if (selectedStatus) {
        const status = selectedStatus.value;

        if (status === 'bekerja_full') {
            // Validasi field wajib untuk yang bekerja
            const namaPerusahaan = form.querySelector('input[name="nama_perusahaan"]');
            const jabatan = form.querySelector('input[name="jabatan"]');
            const waPekerjaan = form.querySelector('input[name="wa_pekerjaan"]');
            const emailPekerjaan = form.querySelector('input[name="email_pekerjaan"]');
            const namaAtasan = form.querySelector('input[name="nama_atasan"]');
            const jabatanAtasan = form.querySelector('input[name="jabatan_atasan"]');
            const waAtasan = form.querySelector('input[name="wa_atasan"]');
            const emailAtasan = form.querySelector('input[name="email_atasan"]');

            if (namaPerusahaan && !namaPerusahaan.value.trim()) {
                errors.push('Nama perusahaan wajib diisi untuk yang bekerja');
            }
            if (jabatan && !jabatan.value.trim()) {
                errors.push('Jabatan wajib diisi untuk yang bekerja');
            }
            if (namaAtasan && !namaAtasan.value.trim()) {
                errors.push('Nama atasan wajib diisi untuk yang bekerja');
            }
            if (jabatanAtasan && !jabatanAtasan.value.trim()) {
                errors.push('Jabatan atasan wajib diisi untuk yang bekerja');
            }

            // Validasi kontak pekerjaan: minimal salah satu harus diisi
            if (waPekerjaan && emailPekerjaan) {
                if (!waPekerjaan.value.trim() && !emailPekerjaan.value.trim()) {
                    errors.push('Minimal salah satu kontak (WhatsApp atau Email) harus diisi untuk keperluan komunikasi langsung');
                }
            }

            // Validasi kontak atasan: minimal salah satu harus diisi
            if (waAtasan && emailAtasan) {
                if (!waAtasan.value.trim() && !emailAtasan.value.trim()) {
                    errors.push('Minimal salah satu kontak atasan (WhatsApp atau Email) harus diisi untuk pengiriman kuesioner evaluasi');
                }
            }
        }

        if (status === 'wirausaha') {
            const namaUsaha = form.querySelector('input[name="nama_usaha"]');
            const posisiUsaha = form.querySelector('input[name="posisi_usaha"]');

            if (namaUsaha && !namaUsaha.value.trim()) {
                errors.push('Nama usaha wajib diisi untuk wiraswasta');
            }
            if (posisiUsaha && !posisiUsaha.value.trim()) {
                errors.push('Posisi usaha wajib diisi untuk wiraswasta');
            }
        }

        if (status === 'lanjutstudy') {
            const universitas = form.querySelector('input[name="universitas"]');
            const programStudi = form.querySelector('input[name="program_studi"]');

            if (universitas && !universitas.value.trim()) {
                errors.push('Nama universitas wajib diisi untuk yang melanjutkan pendidikan');
            }
            if (programStudi && !programStudi.value.trim()) {
                errors.push('Program studi wajib diisi untuk yang melanjutkan pendidikan');
            }
        }
    }

    return {
        isValid: errors.length === 0,
        errors: errors
    };
}

function isFieldVisible(field) {
    // Cek apakah field atau parent containernya visible
    let element = field;
    while (element && element !== document.body) {
        const style = window.getComputedStyle(element);
        if (style.display === 'none' || style.visibility === 'hidden' || style.opacity === '0') {
            return false;
        }

        // Cek apakah parent section visible
        if (element.classList && element.classList.contains('section-card')) {
            if (style.display === 'none') {
                return false;
            }
        }

        element = element.parentElement;
    }

    // Cek apakah field berada dalam section yang tersembunyi
    const sectionCard = field.closest('.section-card');
    if (sectionCard && sectionCard.style.display === 'none') {
        return false;
    }

    return true;
}

function scrollToField(field) {
    // Scroll ke field yang error dan fokus
    field.scrollIntoView({ behavior: 'smooth', block: 'center' });
    setTimeout(() => {
        field.focus();
    }, 300);
}

function showValidationErrors(errors) {
    const alertHtml = `
        <div class="alert alert-danger mt-3 animate-fade-in" id="validationAlert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Perhatian:</strong> Mohon lengkapi semua field yang wajib diisi sebelum mengirim kuesioner.
            <ul class="mt-2 mb-0">
                ${errors.map(error => `<li>${error}</li>`).join('')}
            </ul>
        </div>
    `;

    const form = document.getElementById('alumniForm');
    const existingAlert = document.getElementById('validationAlert');

    if (existingAlert) {
        existingAlert.remove();
    }

    if (form) {
        form.insertAdjacentHTML('beforebegin', alertHtml);

        // Auto remove alert after 10 seconds
        setTimeout(() => {
            const alert = document.getElementById('validationAlert');
            if (alert) alert.remove();
        }, 10000);
    }
}

// Fungsi untuk refresh CSRF token
function refreshCsrfToken() {
    fetch('/csrf-token')
        .then(response => response.json())
        .then(data => {
            const tokenInput = document.querySelector('input[name="_token"]');
            if (tokenInput) {
                tokenInput.value = data.token;
                console.log('CSRF token refreshed successfully');
            }
        })
        .catch(error => {
            console.error('Error refreshing CSRF token:', error);
        });
}

// Inisialisasi refresh CSRF token
function initCsrfTokenRefresh() {
    // Refresh token setiap 30 menit (1800000 ms)
    setInterval(refreshCsrfToken, 30 * 60 * 1000);

    // Refresh token sebelum submit form
    const form = document.getElementById('alumniForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            // Refresh token sebelum submit untuk memastikan token masih valid
            refreshCsrfToken();

            // Tambahkan delay kecil untuk memastikan token sudah di-refresh
            setTimeout(() => {
                console.log('Form submission with refreshed CSRF token');
            }, 100);
        });
    }

    // Refresh token saat halaman focus (user kembali ke tab)
    window.addEventListener('focus', refreshCsrfToken);

    // Refresh token saat user melakukan aktivitas di form
    const formInputs = document.querySelectorAll('#alumniForm input, #alumniForm select, #alumniForm textarea');
    formInputs.forEach(input => {
        input.addEventListener('blur', function() {
            // Refresh token setiap kali user selesai mengisi field
            // tapi tidak terlalu sering, hanya setiap 5 menit
            if (!window.lastTokenRefresh || Date.now() - window.lastTokenRefresh > 5 * 60 * 1000) {
                refreshCsrfToken();
                window.lastTokenRefresh = Date.now();
            }
        });
    });
}

