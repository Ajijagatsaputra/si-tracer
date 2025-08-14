<!-- BAGIAN 15: SARAN DAN MASUKAN -->
<div class="section-card animate-fade-in" id="saranMasukan">
    <div class="section-header">
        <i class="fas fa-comment-dots"></i>
        Saran dan Masukan
    </div>
    <div class="section-body">
        <div class="alert alert-info mb-4">
            <i class="fas fa-lightbulb me-2"></i>
            Berikan saran dan masukan Anda untuk pengembangan kampus dan program studi
        </div>

        <div class="row g-3">
            <div class="col-12">
                <label for="saran" class="form-label">
                    <i class="fas fa-comments text-primary"></i>
                    Saran untuk Pengembangan Kampus
                </label>
                <textarea
                    name="saran"
                    id="saran"
                    class="form-control"
                    rows="5"
                    placeholder="Berikan saran dan masukan Anda untuk pengembangan fasilitas, kurikulum, atau layanan kampus..."
                    >{{ old('saran', $tracer->saran ?? '') }}</textarea>
                <div class="form-text">
                    <i class="fas fa-info-circle me-1"></i>
                    Contoh: Peningkatan fasilitas laboratorium, penambahan mata kuliah praktis, kerjasama dengan industri, dll.
                </div>
            </div>
        </div>
    </div>
</div>
