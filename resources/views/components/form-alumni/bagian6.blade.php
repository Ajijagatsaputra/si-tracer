<div class="section-card animate-fade-in" id="wiraswasta" style="display: none;">
    <div class="section-header">
        <i class="fas fa-store"></i>
        Wiraswasta
    </div>
    <div class="section-body">
        <div class="row g-4">
            <div class="col-md-6">
                <label class="form-label">
                    <i class="fas fa-user-tie text-primary"></i> Apa Posisi/Jabatan saat ini?
                </label>
                <select name="posisi_usaha" class="form-select">
                    <option value="" disabled {{ old('posisi_usaha', $tracer->wiraswasta->posisi_usaha ?? '') == '' ? 'selected' : '' }}>-- Pilih --</option>
                    <option value="founder" {{ old('posisi_usaha', $tracer->wiraswasta->posisi_usaha ?? '') == 'founder' ? 'selected' : '' }}>1. Founder</option>
                    <option value="co-founder" {{ old('posisi_usaha', $tracer->wiraswasta->posisi_usaha ?? '') == 'co-founder' ? 'selected' : '' }}>2. Co-Founder</option>
                    <option value="staff" {{ old('posisi_usaha', $tracer->wiraswasta->posisi_usaha ?? '') == 'staff' ? 'selected' : '' }}>3. Staff</option>
                    <option value="freelance" {{ old('posisi_usaha', $tracer->wiraswasta->posisi_usaha ?? '') == 'freelance' ? 'selected' : '' }}>4. Freelance</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">
                    <i class="fas fa-globe text-primary"></i> Apa Tingkat Tempat Kerja Anda?
                </label>
                <select name="tingkat_usaha_level" class="form-select">
                    <option value="" disabled {{ old('tingkat_usaha_level', $tracer->wiraswasta->tingkat_usaha_level ?? '') == '' ? 'selected' : '' }}>-- Pilih tingkat --</option>
                    <option value="lokal" {{ old('tingkat_usaha_level', $tracer->wiraswasta->tingkat_usaha_level ?? '') == 'lokal' ? 'selected' : '' }}>1. Lokal/Wilayah/Wiraswasta tidak berbadan hukum</option>
                    <option value="nasional" {{ old('tingkat_usaha_level', $tracer->wiraswasta->tingkat_usaha_level ?? '') == 'nasional' ? 'selected' : '' }}>2. Nasional/Wiraswasta berbadan hukum</option>
                    <option value="internasional" {{ old('tingkat_usaha_level', $tracer->wiraswasta->tingkat_usaha_level ?? '') == 'internasional' ? 'selected' : '' }}>3. Multinasional/internasional</option>
                </select>
            </div>
            <div class="col-md-12">
                <label class="form-label">
                    <i class="fas fa-map-marker-alt text-primary"></i>
                    Alamat Tempat Kerja Anda
                </label>
                <textarea name="alamat_usaha" class="form-control" rows="3"
                    placeholder="Isikan nama Jalan, Desa/Kelurahan, RT, RW, Kecamatan, Kab/Kota">{{ old('alamat_usaha', $tracer->wiraswasta->alamat_usaha ?? '') }}</textarea>
            </div>
        </div>
    </div>
</div>
