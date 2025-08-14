<!-- Detail Pekerjaan -->
<div class="section-card animate-fade-in" id="waktuAlumniMendapatkanPekerjaan" style="display: none;">
    <div class="section-header">
        <i class="fas fa-building"></i>
        Anda Mendapatkan Pekerjaan
    </div>
    <div class="section-body">
        <div class="row g-4">
            <div class="col-md-6">
                <label class="form-label"><i class="fas fa-globe text-primary"></i> Apakah
                    anda mendapatkan pekerjaan sebelum 6 bulan sejak kelulusan?</label>
                <select name="mendapatkan_pekerjaan" class="form-select" id="mendapatkanPekerjaan">
                    <option value="" disabled {{ old('mendapatkan_pekerjaan', $tracer->pekerjaan->mendapatkan_pekerjaan ?? '') == '' ? 'selected' : '' }}>-- Pilih tingkat --</option>
                    <option value="<=6bulan" {{ old('mendapatkan_pekerjaan', $tracer->pekerjaan->mendapatkan_pekerjaan ?? '') == '<=6bulan' ? 'selected' : '' }}>
                        1. Ya, bekerja sebelum 6 bulan sejak lulus
                    </option>
                    <option value=">6bulan" {{ old('mendapatkan_pekerjaan', $tracer->pekerjaan->mendapatkan_pekerjaan ?? '') == '>6bulan' ? 'selected' : '' }}>
                        2. Tidak, bekerja setelah 6 bulan sejak lulus
                    </option>
                </select>
            </div>

            <!-- Detail sebelum 6 bulan -->
            <div id="detailKurang6Bulan" class="row g-4 mt-3" style="display: none;">
                <div class="col-md-6">
                    <label class="form-label">Berapa bulan anda mendapatkan pekerjaan pertama
                        sejak lulus?</label>
                    <input type="number" name="bulan_kerja_kurang6" class="form-control" min="0"
                        placeholder="Isikan dengan angka 0-6 bulan"
                        min="0"
                        max="6"
                        value="{{ (old('bulan_kerja_kurang6', $tracer->pekerjaan->bulan_kerja ?? '') !== null && old('bulan_kerja_kurang6', $tracer->pekerjaan->bulan_kerja ?? '') <= 6) ? old('bulan_kerja_kurang6', $tracer->pekerjaan->bulan_kerja ?? '') : '' }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Berapa rata-rata pendapatan anda per bulan? (Take
                        Home Pay)</label>
                    <input type="number" name="pendapatan_kurang6" class="form-control" min="0"
                        placeholder="diisi angka"
                        value="{{ old('pendapatan_kurang6', $tracer->pekerjaan->pendapatan ?? '') }}">
                </div>
            </div>

            <!-- Detail setelah 6 bulan -->
            <div id="detailLebih6Bulan" class="row g-4 mt-3" style="display: none;">
                <div class="col-md-6">
                    <label class="form-label">Berapa bulan anda mendapatkan pekerjaan?</label>
                    <input type="number" name="bulan_kerja_lebih6" class="form-control"
                        placeholder="Isikan dengan angka minimal 7 bulan"
                        min="7"
                        value="{{ (old('bulan_kerja_lebih6', $tracer->pekerjaan->bulan_kerja ?? '') >= 7) ? old('bulan_kerja_lebih6', $tracer->pekerjaan->bulan_kerja ?? '') : '' }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Berapa rata-rata pendapatan anda per bulan? (Take
                        Home Pay)</label>
                    <input type="number" name="pendapatan_lebih6" class="form-control" min="0"
                        placeholder="Isikan dengan angka"
                        value="{{ old('pendapatan_lebih6', $tracer->pekerjaan->pendapatan ?? '') }}">
                </div>
            </div>
        </div>
    </div>
</div>
