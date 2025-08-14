<!-- Bagian 10-11-12: Cara Mendapatkan Pekerjaan -->
<div class="section-card animate-fade-in" id="caraMendapatkanPekerjaan" style="display: none;">
    <div class="section-header">
        <i class="fas fa-search"></i>
        Cara Mendapatkan Pekerjaan
    </div>
    <div class="section-body">
        <div class="alert"
            style="background: linear-gradient(135deg, rgba(34, 197, 94, 0.1), rgba(34, 197, 94, 0.05)); border-left: 4px solid #22c55e; color: #16a34a;">
            <i class="fas fa-info-circle me-2"></i>
            Informasi terkait pencarian pekerjaan Anda
        </div>
        <div class="row g-4">
            <div class="col-12">
                <label class="form-label fw-semibold">
                    <i class="fas fa-clock text-success"></i>
                    Kapan Anda mulai mencari pekerjaan?
                </label>
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="waktu_cari_kerja" id="sebelum_lulus"
                                value="sebelum_lulus" {{ old('waktu_cari_kerja', $tracer->pencarianKerja->waktu_cari_kerja ?? '') == 'sebelum_lulus' ? 'checked' : '' }}>
                            <label class="form-check-label" for="sebelum_lulus">
                                Sebelum lulus
                            </label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="waktu_cari_kerja" id="setelah_lulus"
                                value="setelah_lulus" {{ old('waktu_cari_kerja', $tracer->pencarianKerja->waktu_cari_kerja ?? '') == 'setelah_lulus' ? 'checked' : '' }}>
                            <label class="form-check-label" for="setelah_lulus">
                                Setelah lulus
                            </label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="waktu_cari_kerja" id="tidak_mencari"
                                value="tidak_mencari" {{ old('waktu_cari_kerja', $tracer->pencarianKerja->waktu_cari_kerja ?? '') == 'tidak_mencari' ? 'checked' : '' }}>
                            <label class="form-check-label" for="tidak_mencari">
                                Tidak mencari
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Field bulan sebelum lulus (hanya muncul jika pilih "sebelum lulus") -->
            <div class="col-md-6" id="bulanSebelumLulus" style="display: none;">
                <label for="bulan_sebelum_lulus" class="form-label fw-semibold">
                    <i class="fas fa-calendar-minus text-primary"></i>
                    Berapa bulan sebelum lulus?
                </label>
                <input type="number" name="bulan_sebelum_lulus" id="bulan_sebelum_lulus" class="form-control"
                    value="{{ old('bulan_sebelum_lulus', $tracer->pencarianKerja->bulan_sebelum_lulus ?? '') }}"
                    placeholder="Masukkan jumlah bulan" min="1" max="60">
                <div class="form-text">Contoh: 3 bulan sebelum lulus</div>
            </div>

            <!-- Field bulan setelah lulus (hanya muncul jika pilih "setelah lulus") -->
            <div class="col-md-6" id="bulanSetelahLulus" style="display: none;">
                <label for="bulan_setelah_lulus" class="form-label fw-semibold">
                    <i class="fas fa-calendar-plus text-primary"></i>
                    Berapa bulan setelah lulus?
                </label>
                <input type="number" name="bulan_setelah_lulus" id="bulan_setelah_lulus" class="form-control"
                    value="{{ old('bulan_setelah_lulus', $tracer->pencarianKerja->bulan_setelah_lulus ?? '') }}"
                    placeholder="Masukkan jumlah bulan" min="1" max="60">
                <div class="form-text">Contoh: 2 bulan setelah lulus</div>
            </div>


        </div>
    </div>
</div>


<style>
/* Styling untuk form pencarian kerja */
#caraMendapatkanPekerjaan .form-check {
    background: #f8f9fa;
    border: 2px solid #e9ecef;
    border-radius: 8px;
    padding: 15px;
    transition: all 0.3s ease;
    cursor: pointer;
}

#caraMendapatkanPekerjaan .form-check:hover {
    background: #e9ecef;
    border-color: #6c757d;
    transform: translateY(-2px);
}

#caraMendapatkanPekerjaan .form-check-input:checked + .form-check-label {
    color: #0d6efd;
    font-weight: 600;
}

#caraMendapatkanPekerjaan .form-check-input:checked ~ .form-check {
    background: #e7f3ff;
    border-color: #0d6efd;
}

/* Styling untuk field bulan */
#bulanSebelumLulus,
#bulanSetelahLulus {
    animation: slideDown 0.3s ease-out;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Styling untuk form controls */
#caraMendapatkanPekerjaan .form-control {
    border: 2px solid #e9ecef;
    border-radius: 8px;
    transition: all 0.3s ease;
}

#caraMendapatkanPekerjaan .form-control:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
}

/* Styling untuk labels */
#caraMendapatkanPekerjaan .form-label {
    color: #495057;
    margin-bottom: 8px;
}

/* Styling untuk form text */
#caraMendapatkanPekerjaan .form-text {
    color: #6c757d;
    font-size: 0.875rem;
    margin-top: 4px;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    #caraMendapatkanPekerjaan .col-md-4 {
        margin-bottom: 10px;
    }

    #caraMendapatkanPekerjaan .form-check {
        padding: 12px;
    }
}
</style>
