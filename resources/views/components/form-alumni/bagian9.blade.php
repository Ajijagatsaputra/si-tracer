<!-- Kompetensi Point A-->
<div class="section-card animate-fade-in" id="kompetensiA" style="display: none">
    <div class="section-header">
        <i class="fas fa-star"></i>
        Kompetensi Alumni Point A
    </div>
    <div class="section-body">
        <div class="alert"
            style="background: linear-gradient(135deg, rgba(6, 182, 212, 0.1), rgba(6, 182, 212, 0.05)); border-left: 4px solid var(--accent-color); color: var(--accent-color);">
            <i class="fas fa-info-circle me-2"></i>
            Berikan penilaian pada kompetensi anda pada <strong>SAAT AWAL</strong> kelulusan
        </div>
        <div class="row g-4">
            <div class="col-md-6">
                <label class="form-label">
                    <i class="fas fa-heart text-primary"></i>
                    Etika
                </label>
                <select name="etika_awal" class="form-select" required>
                    <option value="" disabled {{ old('etika_awal', $tracer->kompetensi->etika_awal ?? '') == '' ? 'selected' : '' }}>-- Pilih Level --</option>
                    <option value="sangat_baik" {{ old('etika_awal', $tracer->kompetensi->etika_awal ?? '') == 'sangat_baik' ? 'selected' : '' }}>⭐⭐⭐⭐⭐ Sangat Baik</option>
                    <option value="baik" {{ old('etika_awal', $tracer->kompetensi->etika_awal ?? '') == 'baik' ? 'selected' : '' }}>⭐⭐⭐⭐ Baik</option>
                    <option value="cukup" {{ old('etika_awal', $tracer->kompetensi->etika_awal ?? '') == 'cukup' ? 'selected' : '' }}>⭐⭐⭐ Cukup</option>
                    <option value="kurang_baik" {{ old('etika_awal', $tracer->kompetensi->etika_awal ?? '') == 'kurang_baik' ? 'selected' : '' }}>⭐⭐ Kurang Baik</option>
                    <option value="tidak_baik" {{ old('etika_awal', $tracer->kompetensi->etika_awal ?? '') == 'tidak_baik' ? 'selected' : '' }}>⭐ Tidak Baik</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">
                    <i class="fas fa-tools text-primary"></i>
                    Keahlian berdasarkan bidang ilmu
                </label>
                <select name="keahlian_awal" class="form-select" required>
                    <option value="" disabled {{ old('keahlian_awal', $tracer->kompetensi->keahlian_awal ?? '') == '' ? 'selected' : '' }}>-- Pilih Level --</option>
                    <option value="sangat_baik" {{ old('keahlian_awal', $tracer->kompetensi->keahlian_awal ?? '') == 'sangat_baik' ? 'selected' : '' }}>⭐⭐⭐⭐⭐ Sangat Baik</option>
                    <option value="baik" {{ old('keahlian_awal', $tracer->kompetensi->keahlian_awal ?? '') == 'baik' ? 'selected' : '' }}>⭐⭐⭐⭐ Baik</option>
                    <option value="cukup" {{ old('keahlian_awal', $tracer->kompetensi->keahlian_awal ?? '') == 'cukup' ? 'selected' : '' }}>⭐⭐⭐ Cukup</option>
                    <option value="kurang_baik" {{ old('keahlian_awal', $tracer->kompetensi->keahlian_awal ?? '') == 'kurang_baik' ? 'selected' : '' }}>⭐⭐ Kurang Baik</option>
                    <option value="tidak_baik" {{ old('keahlian_awal', $tracer->kompetensi->keahlian_awal ?? '') == 'tidak_baik' ? 'selected' : '' }}>⭐ Tidak Baik</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">
                    <i class="fas fa-tools text-primary"></i>
                    Bahasa Inggris
                </label>
                <select name="bahasa_inggris_awal" class="form-select" required>
                    <option value="" disabled {{ old('bahasa_inggris_awal', $tracer->kompetensi->bahasa_inggris_awal ?? '') == '' ? 'selected' : '' }}>-- Pilih Level --</option>
                    <option value="sangat_baik" {{ old('bahasa_inggris_awal', $tracer->kompetensi->bahasa_inggris_awal ?? '') == 'sangat_baik' ? 'selected' : '' }}>⭐⭐⭐⭐⭐ Sangat Baik</option>
                    <option value="baik" {{ old('bahasa_inggris_awal', $tracer->kompetensi->bahasa_inggris_awal ?? '') == 'baik' ? 'selected' : '' }}>⭐⭐⭐⭐ Baik</option>
                    <option value="cukup" {{ old('bahasa_inggris_awal', $tracer->kompetensi->bahasa_inggris_awal ?? '') == 'cukup' ? 'selected' : '' }}>⭐⭐⭐ Cukup</option>
                    <option value="kurang_baik" {{ old('bahasa_inggris_awal', $tracer->kompetensi->bahasa_inggris_awal ?? '') == 'kurang_baik' ? 'selected' : '' }}>⭐⭐ Kurang Baik</option>
                    <option value="tidak_baik" {{ old('bahasa_inggris_awal', $tracer->kompetensi->bahasa_inggris_awal ?? '') == 'tidak_baik' ? 'selected' : '' }}>⭐ Tidak Baik</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">
                    <i class="fas fa-laptop text-primary"></i>
                    Penggunaan teknologi informasi
                </label>
                <select name="teknologi_awal" class="form-select" required>
                    <option value="" disabled {{ old('teknologi_awal', $tracer->kompetensi->teknologi_awal ?? '') == '' ? 'selected' : '' }}>-- Pilih Level --</option>
                    <option value="sangat_baik" {{ old('teknologi_awal', $tracer->kompetensi->teknologi_awal ?? '') == 'sangat_baik' ? 'selected' : '' }}>⭐⭐⭐⭐⭐ Sangat Baik</option>
                    <option value="baik" {{ old('teknologi_awal', $tracer->kompetensi->teknologi_awal ?? '') == 'baik' ? 'selected' : '' }}>⭐⭐⭐⭐ Baik</option>
                    <option value="cukup" {{ old('teknologi_awal', $tracer->kompetensi->teknologi_awal ?? '') == 'cukup' ? 'selected' : '' }}>⭐⭐⭐ Cukup</option>
                    <option value="kurang_baik" {{ old('teknologi_awal', $tracer->kompetensi->teknologi_awal ?? '') == 'kurang_baik' ? 'selected' : '' }}>⭐⭐ Kurang Baik</option>
                    <option value="tidak_baik" {{ old('teknologi_awal', $tracer->kompetensi->teknologi_awal ?? '') == 'tidak_baik' ? 'selected' : '' }}>⭐ Tidak Baik</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">
                    <i class="fas fa-users text-primary"></i>
                    Kemampuan bekerjasama
                </label>
                <select name="kerjasama_awal" class="form-select" required>
                    <option value="" disabled {{ old('kerjasama_awal', $tracer->kompetensi->kerjasama_awal ?? '') == '' ? 'selected' : '' }}>-- Pilih Level --</option>
                    <option value="sangat_baik" {{ old('kerjasama_awal', $tracer->kompetensi->kerjasama_awal ?? '') == 'sangat_baik' ? 'selected' : '' }}>⭐⭐⭐⭐⭐ Sangat Baik</option>
                    <option value="baik" {{ old('kerjasama_awal', $tracer->kompetensi->kerjasama_awal ?? '') == 'baik' ? 'selected' : '' }}>⭐⭐⭐⭐ Baik</option>
                    <option value="cukup" {{ old('kerjasama_awal', $tracer->kompetensi->kerjasama_awal ?? '') == 'cukup' ? 'selected' : '' }}>⭐⭐⭐ Cukup</option>
                    <option value="kurang_baik" {{ old('kerjasama_awal', $tracer->kompetensi->kerjasama_awal ?? '') == 'kurang_baik' ? 'selected' : '' }}>⭐⭐ Kurang Baik</option>
                    <option value="tidak_baik" {{ old('kerjasama_awal', $tracer->kompetensi->kerjasama_awal ?? '') == 'tidak_baik' ? 'selected' : '' }}>⭐ Tidak Baik</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">
                    <i class="fas fa-comments text-primary"></i>
                    Kemampuan komunikasi
                </label>
                <select name="komunikasi_awal" class="form-select" required>
                    <option value="" disabled {{ old('komunikasi_awal', $tracer->kompetensi->komunikasi_awal ?? '') == '' ? 'selected' : '' }}>-- Pilih Level --</option>
                    <option value="sangat_baik" {{ old('komunikasi_awal', $tracer->kompetensi->komunikasi_awal ?? '') == 'sangat_baik' ? 'selected' : '' }}>⭐⭐⭐⭐⭐ Sangat Baik</option>
                    <option value="baik" {{ old('komunikasi_awal', $tracer->kompetensi->komunikasi_awal ?? '') == 'baik' ? 'selected' : '' }}>⭐⭐⭐⭐ Baik</option>
                    <option value="cukup" {{ old('komunikasi_awal', $tracer->kompetensi->komunikasi_awal ?? '') == 'cukup' ? 'selected' : '' }}>⭐⭐⭐ Cukup</option>
                    <option value="kurang_baik" {{ old('komunikasi_awal', $tracer->kompetensi->komunikasi_awal ?? '') == 'kurang_baik' ? 'selected' : '' }}>⭐⭐ Kurang Baik</option>
                    <option value="tidak_baik" {{ old('komunikasi_awal', $tracer->kompetensi->komunikasi_awal ?? '') == 'tidak_baik' ? 'selected' : '' }}>⭐ Tidak Baik</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">
                    <i class="fas fa-chart-line text-primary"></i>
                    Pengembangan diri
                </label>
                <select name="pengembangan_awal" class="form-select" required>
                    <option value="" disabled {{ old('pengembangan_awal', $tracer->kompetensi->pengembangan_awal ?? '') == '' ? 'selected' : '' }}>-- Pilih Level --</option>
                    <option value="sangat_baik" {{ old('pengembangan_awal', $tracer->kompetensi->pengembangan_awal ?? '') == 'sangat_baik' ? 'selected' : '' }}>⭐⭐⭐⭐⭐ Sangat Baik</option>
                    <option value="baik" {{ old('pengembangan_awal', $tracer->kompetensi->pengembangan_awal ?? '') == 'baik' ? 'selected' : '' }}>⭐⭐⭐⭐ Baik</option>
                    <option value="cukup" {{ old('pengembangan_awal', $tracer->kompetensi->pengembangan_awal ?? '') == 'cukup' ? 'selected' : '' }}>⭐⭐⭐ Cukup</option>
                    <option value="kurang_baik" {{ old('pengembangan_awal', $tracer->kompetensi->pengembangan_awal ?? '') == 'kurang_baik' ? 'selected' : '' }}>⭐⭐ Kurang Baik</option>
                    <option value="tidak_baik" {{ old('pengembangan_awal', $tracer->kompetensi->pengembangan_awal ?? '') == 'tidak_baik' ? 'selected' : '' }}>⭐ Tidak Baik</option>
                </select>
            </div>
        </div>
    </div>
</div>

<!-- Kompetensi Point B -->
<div class="section-card animate-fade-in" id="kompetensiB" style="display: none">
    <div class="section-header">
        <i class="fas fa-star"></i>
        Kompetensi Alumni Point B
    </div>
    <div class="section-body">
        <div class="alert"
            style="background: linear-gradient(135deg, rgba(255, 193, 7, 0.1), rgba(255, 193, 7, 0.05)); border-left: 4px solid #ffc107; color: #f57c00;">
            <i class="fas fa-info-circle me-2"></i>
            Berikan penilaian pada kompetensi anda pada<strong>SAAT INI</strong>
        </div>
        <div class="row g-4">
            <div class="col-md-6">
                <label class="form-label">
                    <i class="fas fa-heart text-warning"></i>
                    Etika
                </label>
                <select name="etika_sekarang" class="form-select" required>
                    <option value="" disabled {{ old('etika_sekarang', $tracer->kompetensi->etika_sekarang ?? '') == '' ? 'selected' : '' }}>-- Pilih Level --</option>
                    <option value="sangat_baik" {{ old('etika_sekarang', $tracer->kompetensi->etika_sekarang ?? '') == 'sangat_baik' ? 'selected' : '' }}>⭐⭐⭐⭐⭐ Sangat Baik</option>
                    <option value="baik" {{ old('etika_sekarang', $tracer->kompetensi->etika_sekarang ?? '') == 'baik' ? 'selected' : '' }}>⭐⭐⭐⭐ Baik</option>
                    <option value="cukup" {{ old('etika_sekarang', $tracer->kompetensi->etika_sekarang ?? '') == 'cukup' ? 'selected' : '' }}>⭐⭐⭐ Cukup</option>
                    <option value="kurang_baik" {{ old('etika_sekarang', $tracer->kompetensi->etika_sekarang ?? '') == 'kurang_baik' ? 'selected' : '' }}>⭐⭐ Kurang Baik</option>
                    <option value="tidak_baik" {{ old('etika_sekarang', $tracer->kompetensi->etika_sekarang ?? '') == 'tidak_baik' ? 'selected' : '' }}>⭐ Tidak Baik</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">
                    <i class="fas fa-tools text-warning"></i>
                    Keahlian berdasarkan bidang ilmu
                </label>
                <select name="keahlian_sekarang" class="form-select" required>
                    <option value="" disabled {{ old('keahlian_sekarang', $tracer->kompetensi->keahlian_sekarang ?? '') == '' ? 'selected' : '' }}>-- Pilih Level --</option>
                    <option value="sangat_baik" {{ old('keahlian_sekarang', $tracer->kompetensi->keahlian_sekarang ?? '') == 'sangat_baik' ? 'selected' : '' }}>⭐⭐⭐⭐⭐ Sangat Baik</option>
                    <option value="baik" {{ old('keahlian_sekarang', $tracer->kompetensi->keahlian_sekarang ?? '') == 'baik' ? 'selected' : '' }}>⭐⭐⭐⭐ Baik</option>
                    <option value="cukup" {{ old('keahlian_sekarang', $tracer->kompetensi->keahlian_sekarang ?? '') == 'cukup' ? 'selected' : '' }}>⭐⭐⭐ Cukup</option>
                    <option value="kurang_baik" {{ old('keahlian_sekarang', $tracer->kompetensi->keahlian_sekarang ?? '') == 'kurang_baik' ? 'selected' : '' }}>⭐⭐ Kurang Baik</option>
                    <option value="tidak_baik" {{ old('keahlian_sekarang', $tracer->kompetensi->keahlian_sekarang ?? '') == 'tidak_baik' ? 'selected' : '' }}>⭐ Tidak Baik</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">
                    <i class="fas fa-tools text-warning"></i>
                    Bahasa Inggris
                </label>
                <select name="bahasa_inggris_sekarang" class="form-select" required>
                    <option value="" disabled {{ old('bahasa_inggris_sekarang', $tracer->kompetensi->bahasa_inggris_sekarang ?? '') == '' ? 'selected' : '' }}>-- Pilih Level --</option>
                    <option value="sangat_baik" {{ old('bahasa_inggris_sekarang', $tracer->kompetensi->bahasa_inggris_sekarang ?? '') == 'sangat_baik' ? 'selected' : '' }}>⭐⭐⭐⭐⭐ Sangat Baik</option>
                    <option value="baik" {{ old('bahasa_inggris_sekarang', $tracer->kompetensi->bahasa_inggris_sekarang ?? '') == 'baik' ? 'selected' : '' }}>⭐⭐⭐⭐ Baik</option>
                    <option value="cukup" {{ old('bahasa_inggris_sekarang', $tracer->kompetensi->bahasa_inggris_sekarang ?? '') == 'cukup' ? 'selected' : '' }}>⭐⭐⭐ Cukup</option>
                    <option value="kurang_baik" {{ old('bahasa_inggris_sekarang', $tracer->kompetensi->bahasa_inggris_sekarang ?? '') == 'kurang_baik' ? 'selected' : '' }}>⭐⭐ Kurang Baik</option>
                    <option value="tidak_baik" {{ old('bahasa_inggris_sekarang', $tracer->kompetensi->bahasa_inggris_sekarang ?? '') == 'tidak_baik' ? 'selected' : '' }}>⭐ Tidak Baik</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">
                    <i class="fas fa-laptop text-warning"></i>
                    Penggunaan teknologi informasi
                </label>
                <select name="teknologi_sekarang" class="form-select" required>
                    <option value="" disabled {{ old('teknologi_sekarang', $tracer->kompetensi->teknologi_sekarang ?? '') == '' ? 'selected' : '' }}>-- Pilih Level --</option>
                    <option value="sangat_baik" {{ old('teknologi_sekarang', $tracer->kompetensi->teknologi_sekarang ?? '') == 'sangat_baik' ? 'selected' : '' }}>⭐⭐⭐⭐⭐ Sangat Baik</option>
                    <option value="baik" {{ old('teknologi_sekarang', $tracer->kompetensi->teknologi_sekarang ?? '') == 'baik' ? 'selected' : '' }}>⭐⭐⭐⭐ Baik</option>
                    <option value="cukup" {{ old('teknologi_sekarang', $tracer->kompetensi->teknologi_sekarang ?? '') == 'cukup' ? 'selected' : '' }}>⭐⭐⭐ Cukup</option>
                    <option value="kurang_baik" {{ old('teknologi_sekarang', $tracer->kompetensi->teknologi_sekarang ?? '') == 'kurang_baik' ? 'selected' : '' }}>⭐⭐ Kurang Baik</option>
                    <option value="tidak_baik" {{ old('teknologi_sekarang', $tracer->kompetensi->teknologi_sekarang ?? '') == 'tidak_baik' ? 'selected' : '' }}>⭐ Tidak Baik</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">
                    <i class="fas fa-users text-warning"></i>
                    Kemampuan bekerjasama
                </label>
                <select name="kerjasama_sekarang" class="form-select" required>
                    <option value="" disabled {{ old('kerjasama_sekarang', $tracer->kompetensi->kerjasama_sekarang ?? '') == '' ? 'selected' : '' }}>-- Pilih Level --</option>
                    <option value="sangat_baik" {{ old('kerjasama_sekarang', $tracer->kompetensi->kerjasama_sekarang ?? '') == 'sangat_baik' ? 'selected' : '' }}>⭐⭐⭐⭐⭐ Sangat Baik</option>
                    <option value="baik" {{ old('kerjasama_sekarang', $tracer->kompetensi->kerjasama_sekarang ?? '') == 'baik' ? 'selected' : '' }}>⭐⭐⭐⭐ Baik</option>
                    <option value="cukup" {{ old('kerjasama_sekarang', $tracer->kompetensi->kerjasama_sekarang ?? '') == 'cukup' ? 'selected' : '' }}>⭐⭐⭐ Cukup</option>
                    <option value="kurang_baik" {{ old('kerjasama_sekarang', $tracer->kompetensi->kerjasama_sekarang ?? '') == 'kurang_baik' ? 'selected' : '' }}>⭐⭐ Kurang Baik</option>
                    <option value="tidak_baik" {{ old('kerjasama_sekarang', $tracer->kompetensi->kerjasama_sekarang ?? '') == 'tidak_baik' ? 'selected' : '' }}>⭐ Tidak Baik</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">
                    <i class="fas fa-comments text-warning"></i>
                    Kemampuan komunikasi
                </label>
                <select name="komunikasi_sekarang" class="form-select" required>
                    <option value="" disabled {{ old('komunikasi_sekarang', $tracer->kompetensi->komunikasi_sekarang ?? '') == '' ? 'selected' : '' }}>-- Pilih Level --</option>
                    <option value="sangat_baik" {{ old('komunikasi_sekarang', $tracer->kompetensi->komunikasi_sekarang ?? '') == 'sangat_baik' ? 'selected' : '' }}>⭐⭐⭐⭐⭐ Sangat Baik</option>
                    <option value="baik" {{ old('komunikasi_sekarang', $tracer->kompetensi->komunikasi_sekarang ?? '') == 'baik' ? 'selected' : '' }}>⭐⭐⭐⭐ Baik</option>
                    <option value="cukup" {{ old('komunikasi_sekarang', $tracer->kompetensi->komunikasi_sekarang ?? '') == 'cukup' ? 'selected' : '' }}>⭐⭐⭐ Cukup</option>
                    <option value="kurang_baik" {{ old('komunikasi_sekarang', $tracer->kompetensi->komunikasi_sekarang ?? '') == 'kurang_baik' ? 'selected' : '' }}>⭐⭐ Kurang Baik</option>
                    <option value="tidak_baik" {{ old('komunikasi_sekarang', $tracer->kompetensi->komunikasi_sekarang ?? '') == 'tidak_baik' ? 'selected' : '' }}>⭐ Tidak Baik</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">
                    <i class="fas fa-chart-line text-warning"></i>
                    Pengembangan diri
                </label>
                <select name="pengembangan_sekarang" class="form-select" required>
                    <option value="" disabled {{ old('pengembangan_sekarang', $tracer->kompetensi->pengembangan_sekarang ?? '') == '' ? 'selected' : '' }}>-- Pilih Level --</option>
                    <option value="sangat_baik" {{ old('pengembangan_sekarang', $tracer->kompetensi->pengembangan_sekarang ?? '') == 'sangat_baik' ? 'selected' : '' }}>⭐⭐⭐⭐⭐ Sangat Baik</option>
                    <option value="baik" {{ old('pengembangan_sekarang', $tracer->kompetensi->pengembangan_sekarang ?? '') == 'baik' ? 'selected' : '' }}>⭐⭐⭐⭐ Baik</option>
                    <option value="cukup" {{ old('pengembangan_sekarang', $tracer->kompetensi->pengembangan_sekarang ?? '') == 'cukup' ? 'selected' : '' }}>⭐⭐⭐ Cukup</option>
                    <option value="kurang_baik" {{ old('pengembangan_sekarang', $tracer->kompetensi->pengembangan_sekarang ?? '') == 'kurang_baik' ? 'selected' : '' }}>⭐⭐ Kurang Baik</option>
                    <option value="tidak_baik" {{ old('pengembangan_sekarang', $tracer->kompetensi->pengembangan_sekarang ?? '') == 'tidak_baik' ? 'selected' : '' }}>⭐ Tidak Baik</option>
                </select>
            </div>
        </div>
    </div>
</div>

<!-- Evaluasi Pendidikan -->
<div class="section-card animate-fade-in" id="evaluasiPendidikan" style="display: none;">
    <div class="section-header">
        <i class="fas fa-graduation-cap"></i>
        Evaluasi Pendidikan
    </div>
    <div class="section-body">
        <div class="alert"
            style="background: linear-gradient(135deg, rgba(103, 58, 183, 0.1), rgba(103, 58, 183, 0.05)); border-left: 4px solid #673ab7; color: #673ab7;">
            <i class="fas fa-info-circle me-2"></i>
            Menurut anda seberapa besar penekanan pada metode pembelajaran yang dilaksanakan Program Studi anda?
        </div>
        <div class="row g-4">
            <div class="col-md-6">
                <label class="form-label">
                    <i class="fas fa-chalkboard-teacher text-primary"></i>
                    Perkuliahan
                </label>
                <select name="perkuliahan" class="form-select" required>
                    <option value="" disabled {{ old('perkuliahan', $tracer->evaluasiPendidikan->perkuliahan ?? '') == '' ? 'selected' : '' }}>-- Pilih Level --</option>
                    <option value="sangat_baik" {{ old('perkuliahan', $tracer->evaluasiPendidikan->perkuliahan ?? '') == 'sangat_baik' ? 'selected' : '' }}>⭐⭐⭐⭐⭐ Sangat Baik</option>
                    <option value="baik" {{ old('perkuliahan', $tracer->evaluasiPendidikan->perkuliahan ?? '') == 'baik' ? 'selected' : '' }}>⭐⭐⭐⭐ Baik</option>
                    <option value="cukup" {{ old('perkuliahan', $tracer->evaluasiPendidikan->perkuliahan ?? '') == 'cukup' ? 'selected' : '' }}>⭐⭐⭐ Cukup</option>
                    <option value="kurang_baik" {{ old('perkuliahan', $tracer->evaluasiPendidikan->perkuliahan ?? '') == 'kurang_baik' ? 'selected' : '' }}>⭐⭐ Kurang Baik</option>
                    <option value="tidak_baik" {{ old('perkuliahan', $tracer->evaluasiPendidikan->perkuliahan ?? '') == 'tidak_baik' ? 'selected' : '' }}>⭐ Tidak Baik</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">
                    <i class="fas fa-flask text-primary"></i>
                    Praktikum
                </label>
                <select name="praktikum" class="form-select" required>
                    <option value="" disabled {{ old('praktikum', $tracer->evaluasiPendidikan->praktikum ?? '') == '' ? 'selected' : '' }}>-- Pilih Level --</option>
                    <option value="sangat_baik" {{ old('praktikum', $tracer->evaluasiPendidikan->praktikum ?? '') == 'sangat_baik' ? 'selected' : '' }}>⭐⭐⭐⭐⭐ Sangat Baik</option>
                    <option value="baik" {{ old('praktikum', $tracer->evaluasiPendidikan->praktikum ?? '') == 'baik' ? 'selected' : '' }}>⭐⭐⭐⭐ Baik</option>
                    <option value="cukup" {{ old('praktikum', $tracer->evaluasiPendidikan->praktikum ?? '') == 'cukup' ? 'selected' : '' }}>⭐⭐⭐ Cukup</option>
                    <option value="kurang_baik" {{ old('praktikum', $tracer->evaluasiPendidikan->praktikum ?? '') == 'kurang_baik' ? 'selected' : '' }}>⭐⭐ Kurang Baik</option>
                    <option value="tidak_baik" {{ old('praktikum', $tracer->evaluasiPendidikan->praktikum ?? '') == 'tidak_baik' ? 'selected' : '' }}>⭐ Tidak Baik</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">
                    <i class="fas fa-presentation text-primary"></i>
                    Demonstrasi
                </label>
                <select name="demonstrasi" class="form-select" required>
                    <option value="" disabled {{ old('demonstrasi', $tracer->evaluasiPendidikan->demonstrasi ?? '') == '' ? 'selected' : '' }}>-- Pilih Level --</option>
                    <option value="sangat_baik" {{ old('demonstrasi', $tracer->evaluasiPendidikan->demonstrasi ?? '') == 'sangat_baik' ? 'selected' : '' }}>⭐⭐⭐⭐⭐ Sangat Baik</option>
                    <option value="baik" {{ old('demonstrasi', $tracer->evaluasiPendidikan->demonstrasi ?? '') == 'baik' ? 'selected' : '' }}>⭐⭐⭐⭐ Baik</option>
                    <option value="cukup" {{ old('demonstrasi', $tracer->evaluasiPendidikan->demonstrasi ?? '') == 'cukup' ? 'selected' : '' }}>⭐⭐⭐ Cukup</option>
                    <option value="kurang_baik" {{ old('demonstrasi', $tracer->evaluasiPendidikan->demonstrasi ?? '') == 'kurang_baik' ? 'selected' : '' }}>⭐⭐ Kurang Baik</option>
                    <option value="tidak_baik" {{ old('demonstrasi', $tracer->evaluasiPendidikan->demonstrasi ?? '') == 'tidak_baik' ? 'selected' : '' }}>⭐ Tidak Baik</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">
                    <i class="fas fa-search text-primary"></i>
                    Riset
                </label>
                <select name="riset" class="form-select" required>
                    <option value="" disabled {{ old('riset', $tracer->evaluasiPendidikan->riset ?? '') == '' ? 'selected' : '' }}>-- Pilih Level --</option>
                    <option value="sangat_baik" {{ old('riset', $tracer->evaluasiPendidikan->riset ?? '') == 'sangat_baik' ? 'selected' : '' }}>⭐⭐⭐⭐⭐ Sangat Baik</option>
                    <option value="baik" {{ old('riset', $tracer->evaluasiPendidikan->riset ?? '') == 'baik' ? 'selected' : '' }}>⭐⭐⭐⭐ Baik</option>
                    <option value="cukup" {{ old('riset', $tracer->evaluasiPendidikan->riset ?? '') == 'cukup' ? 'selected' : '' }}>⭐⭐⭐ Cukup</option>
                    <option value="kurang_baik" {{ old('riset', $tracer->evaluasiPendidikan->riset ?? '') == 'kurang_baik' ? 'selected' : '' }}>⭐⭐ Kurang Baik</option>
                    <option value="tidak_baik" {{ old('riset', $tracer->evaluasiPendidikan->riset ?? '') == 'tidak_baik' ? 'selected' : '' }}>⭐ Tidak Baik</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">
                    <i class="fas fa-briefcase text-primary"></i>
                    Magang
                </label>
                <select name="magang" class="form-select" required>
                    <option value="" disabled {{ old('magang', $tracer->evaluasiPendidikan->magang ?? '') == '' ? 'selected' : '' }}>-- Pilih Level --</option>
                    <option value="sangat_baik" {{ old('magang', $tracer->evaluasiPendidikan->magang ?? '') == 'sangat_baik' ? 'selected' : '' }}>⭐⭐⭐⭐⭐ Sangat Baik</option>
                    <option value="baik" {{ old('magang', $tracer->evaluasiPendidikan->magang ?? '') == 'baik' ? 'selected' : '' }}>⭐⭐⭐⭐ Baik</option>
                    <option value="cukup" {{ old('magang', $tracer->evaluasiPendidikan->magang ?? '') == 'cukup' ? 'selected' : '' }}>⭐⭐⭐ Cukup</option>
                    <option value="kurang_baik" {{ old('magang', $tracer->evaluasiPendidikan->magang ?? '') == 'kurang_baik' ? 'selected' : '' }}>⭐⭐ Kurang Baik</option>
                    <option value="tidak_baik" {{ old('magang', $tracer->evaluasiPendidikan->magang ?? '') == 'tidak_baik' ? 'selected' : '' }}>⭐ Tidak Baik</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">
                    <i class="fas fa-map text-primary"></i>
                    Kerja Lapangan
                </label>
                <select name="kerja_lapangan" class="form-select" required>
                    <option value="" disabled {{ old('kerja_lapangan', $tracer->evaluasiPendidikan->kerja_lapangan ?? '') == '' ? 'selected' : '' }}>-- Pilih Level --</option>
                    <option value="sangat_baik" {{ old('kerja_lapangan', $tracer->evaluasiPendidikan->kerja_lapangan ?? '') == 'sangat_baik' ? 'selected' : '' }}>⭐⭐⭐⭐⭐ Sangat Baik</option>
                    <option value="baik" {{ old('kerja_lapangan', $tracer->evaluasiPendidikan->kerja_lapangan ?? '') == 'baik' ? 'selected' : '' }}>⭐⭐⭐⭐ Baik</option>
                    <option value="cukup" {{ old('kerja_lapangan', $tracer->evaluasiPendidikan->kerja_lapangan ?? '') == 'cukup' ? 'selected' : '' }}>⭐⭐⭐ Cukup</option>
                    <option value="kurang_baik" {{ old('kerja_lapangan', $tracer->evaluasiPendidikan->kerja_lapangan ?? '') == 'kurang_baik' ? 'selected' : '' }}>⭐⭐ Kurang Baik</option>
                    <option value="tidak_baik" {{ old('kerja_lapangan', $tracer->evaluasiPendidikan->kerja_lapangan ?? '') == 'tidak_baik' ? 'selected' : '' }}>⭐ Tidak Baik</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">
                    <i class="fas fa-comments text-primary"></i>
                    Diskusi
                </label>
                <select name="diskusi" class="form-select" required>
                    <option value="" disabled {{ old('diskusi', $tracer->evaluasiPendidikan->diskusi ?? '') == '' ? 'selected' : '' }}>-- Pilih Level --</option>
                    <option value="sangat_baik" {{ old('diskusi', $tracer->evaluasiPendidikan->diskusi ?? '') == 'sangat_baik' ? 'selected' : '' }}>⭐⭐⭐⭐⭐ Sangat Baik</option>
                    <option value="baik" {{ old('diskusi', $tracer->evaluasiPendidikan->diskusi ?? '') == 'baik' ? 'selected' : '' }}>⭐⭐⭐⭐ Baik</option>
                    <option value="cukup" {{ old('diskusi', $tracer->evaluasiPendidikan->diskusi ?? '') == 'cukup' ? 'selected' : '' }}>⭐⭐⭐ Cukup</option>
                    <option value="kurang_baik" {{ old('diskusi', $tracer->evaluasiPendidikan->diskusi ?? '') == 'kurang_baik' ? 'selected' : '' }}>⭐⭐ Kurang Baik</option>
                    <option value="tidak_baik" {{ old('diskusi', $tracer->evaluasiPendidikan->diskusi ?? '') == 'tidak_baik' ? 'selected' : '' }}>⭐ Tidak Baik</option>
                </select>
            </div>
        </div>
    </div>
</div>
