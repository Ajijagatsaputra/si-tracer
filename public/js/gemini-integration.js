/**
 * Gemini AI Integration for Tracer Study
 * Handles PDF Transcript extraction and Career Prediction
 */

document.addEventListener('DOMContentLoaded', function() {
    console.log('Gemini Integration script v' + new Date().getTime());
    
    const transcriptInput = document.getElementById('transcript_input');
    const aiLoading = document.getElementById('ai_loading');
    const aiStatusText = document.getElementById('ai_status_text');
    const predictionResults = document.getElementById('prediction_results');
    const predictionText = document.getElementById('prediction_text');
    const closeBtn = document.getElementById('close_ai_loading');

    if (!transcriptInput) return;

    // Failsafe: Ensure hidden initially using Bootstrap classes
    if (aiLoading) {
        aiLoading.classList.add('d-none');
        aiLoading.classList.remove('d-flex');
    }

    // Handle manual close
    if (closeBtn) {
        closeBtn.addEventListener('click', function() {
            console.log('Manual close triggered');
            aiLoading.classList.add('d-none');
            aiLoading.classList.remove('d-flex');
        });
    }

    transcriptInput.addEventListener('change', async function(e) {
        const file = e.target.files[0];
        if (!file) return;

        console.log('File selected:', file.name, file.type);

        if (file.type !== 'application/pdf') {
            Swal.fire({
                icon: 'error',
                title: 'Format File Salah',
                text: 'Maaf, untuk saat ini AI hanya dapat menganalisis file dalam format PDF.',
                confirmButtonColor: '#1e3a8a'
            });
            transcriptInput.value = '';
            return;
        }

        // Show Loading using Flex for center alignment
        aiLoading.classList.remove('d-none');
        aiLoading.classList.add('d-flex');
        aiStatusText.innerText = 'Tahap 1: Mengekstrak data dari AI...';
        predictionResults.style.display = 'none';

        // Security: Add a global timeout (60s) to hide loader if everything fails
        const uiTimeout = setTimeout(() => {
            if (aiLoading.classList.contains('d-flex')) {
                console.warn('AI analysis timed out');
                aiLoading.classList.add('d-none');
                aiLoading.classList.remove('d-flex');
                Swal.fire({
                    icon: 'info',
                    title: 'Waktu Habis',
                    text: 'Proses AI memakan waktu terlalu lama. Anda tetap bisa melanjutkan form secara manual.',
                    confirmButtonColor: '#1e3a8a'
                });
            }
        }, 60000);

        try {
            const formData = new FormData();
            formData.append('pdf', file);

            // 1. Extract PDF
            console.log('Calling extraction API...');
            const extractResponse = await fetch('/api/ocr-gemini-extract', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            });

            const extractResult = await extractResponse.json();
            console.log('Extraction response:', extractResult);

            if (!extractResult.success) {
                throw new Error(extractResult.message || extractResult.error || 'Gagal ekstraksi PDF');
            }

            // 2. Save Scores
            aiStatusText.innerText = 'Tahap 2: Menyimpan nilai akademik...';
            const saveScoresResponse = await fetch('/api/academic-scores/save', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ academic_scores: extractResult.data })
            });
            
            const saveResult = await saveScoresResponse.json();
            console.log('Save response:', saveResult);

            // 3. Predict
            aiStatusText.innerText = 'Tahap 3: Menghasilkan rekomendasi karir...';
            const predictResponse = await fetch('/api/predict-gemini', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ mode: 'flash', deskripsi: 'Analisis otomatis dari transkrip.' })
            });

            const predictResult = await predictResponse.json();
            console.log('Prediction response:', predictResult);

            if (predictResult.success) {
                predictionText.innerHTML = formatAiText(predictResult.text);
                predictionResults.style.display = 'block';
                
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Analisis AI selesai dilakukan.',
                    timer: 2000,
                    showConfirmButton: false
                });
            } else {
                throw new Error(predictResult.error || 'Gagal prediksi AI');
            }

        } catch (error) {
            console.error('Gemini Flow Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Kesalahan AI',
                text: error.message || 'Gagal memproses AI.',
                confirmButtonColor: '#1e3a8a'
            });
        } finally {
            clearTimeout(uiTimeout);
            aiLoading.classList.add('d-none');
            aiLoading.classList.remove('d-flex');
        }
    });

    function formatAiText(text) {
        if (!text) return '';
        let formatted = text
            .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
            .replace(/\*(.*?)\*/g, '<em>$1</em>');
        
        const lines = formatted.split('\n');
        let html = '';
        let inList = false;

        lines.forEach(line => {
            const trim = line.trim();
            if (trim.startsWith('-') || trim.startsWith('•')) {
                if (!inList) { html += '<ul>'; inList = true; }
                html += `<li>${trim.substring(1).trim()}</li>`;
            } else {
                if (inList) { html += '</ul>'; inList = false; }
                if (trim !== '') html += `<p>${trim}</p>`;
            }
        });
        if (inList) html += '</ul>';
        return html;
    }
});
