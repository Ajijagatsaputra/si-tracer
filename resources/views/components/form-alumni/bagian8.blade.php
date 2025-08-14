<!-- Kesesuaian berkerja bagian 8 -->
<div class="section-card animate-fade-in" id="kesesuaianPekerjaan" style="display: none;">
    <div class="section-header">
        <i class="fas fa-star"></i>
        Kesesuaian Pekerjaan
    </div>
    <div class="section-body">

        <!-- Pertanyaan 1 -->
        <div class="col-md-6 mb-2">
            <label class="form-label">
                <i class="fas fa-link text-primary"></i>
                Seberapa erat hubungan bidang studi dengan pekerjaan anda?
            </label>
            <select name="hubungan_studi_pekerjaan" class="form-select" required>
                <option value="" disabled {{ old('hubungan_studi_pekerjaan', $tracer->pekerjaan->hubungan_studi_pekerjaan ?? '') == '' ? 'selected' : '' }}>-- Pilih --</option>
                <option value="sangat_erat" {{ old('hubungan_studi_pekerjaan', $tracer->pekerjaan->hubungan_studi_pekerjaan ?? '') == 'sangat_erat' ? 'selected' : '' }}>Sangat erat</option>
                <option value="erat" {{ old('hubungan_studi_pekerjaan', $tracer->pekerjaan->hubungan_studi_pekerjaan ?? '') == 'erat' ? 'selected' : '' }}>Erat</option>
                <option value="cukup_erat" {{ old('hubungan_studi_pekerjaan', $tracer->pekerjaan->hubungan_studi_pekerjaan ?? '') == 'cukup_erat' ? 'selected' : '' }}>Cukup erat</option>
                <option value="kurang_erat" {{ old('hubungan_studi_pekerjaan', $tracer->pekerjaan->hubungan_studi_pekerjaan ?? '') == 'kurang_erat' ? 'selected' : '' }}>Kurang erat</option>
                <option value="tidak_erat" {{ old('hubungan_studi_pekerjaan', $tracer->pekerjaan->hubungan_studi_pekerjaan ?? '') == 'tidak_erat' ? 'selected' : '' }}>Tidak erat</option>
            </select>
        </div>

        <!-- Pertanyaan 2 -->
        <div class="col-md-6">
            <label class="form-label">
                <i class="fas fa-graduation-cap text-primary"></i>
                Tingkat pendidikan apa yang paling tepat / sesuai untuk pekerjaan anda?
            </label>
            <select name="pendidikan_sesuai_pekerjaan" class="form-select" required>
                <option value="" disabled {{ old('pendidikan_sesuai_pekerjaan', $tracer->pekerjaan->pendidikan_sesuai_pekerjaan ?? '') == '' ? 'selected' : '' }}>-- Pilih --</option>
                <option value="lebih_tinggi" {{ old('pendidikan_sesuai_pekerjaan', $tracer->pekerjaan->pendidikan_sesuai_pekerjaan ?? '') == 'lebih_tinggi' ? 'selected' : '' }}>Setingkat lebih tinggi</option>
                <option value="sama" {{ old('pendidikan_sesuai_pekerjaan', $tracer->pekerjaan->pendidikan_sesuai_pekerjaan ?? '') == 'sama' ? 'selected' : '' }}>Tingkat yang sama</option>
                <option value="lebih_rendah" {{ old('pendidikan_sesuai_pekerjaan', $tracer->pekerjaan->pendidikan_sesuai_pekerjaan ?? '') == 'lebih_rendah' ? 'selected' : '' }}>Setingkat lebih rendah</option>
                <option value="tidak_perlu_pt" {{ old('pendidikan_sesuai_pekerjaan', $tracer->pekerjaan->pendidikan_sesuai_pekerjaan ?? '') == 'tidak_perlu_pt' ? 'selected' : '' }}>Tidak perlu pendidikan tinggi</option>
            </select>
        </div>

    </div>
</div>
