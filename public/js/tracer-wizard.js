/**
 * Tracer Study Wizard Logic
 * Handles section transitions, progress bar, and validation
 */

class TracerWizard {
    constructor() {
        this.currentStep = 1;
        this.totalSteps = document.querySelectorAll('.form-section').length;
        this.form = document.getElementById('alumniForm');
        this.init();
    }

    init() {
        this.showStep(this.currentStep);
        this.bindEvents();
        this.updateProgress();
    }

    bindEvents() {
        document.querySelectorAll('.btn-next').forEach(btn => {
            btn.addEventListener('click', () => this.nextStep());
        });

        document.querySelectorAll('.btn-prev').forEach(btn => {
            btn.addEventListener('click', () => this.prevStep());
        });

        // Optional: Auto-save on input
        this.form.querySelectorAll('input, select, textarea').forEach(input => {
            input.addEventListener('change', () => this.saveToLocal());
        });
    }

    showStep(step) {
        document.querySelectorAll('.form-section').forEach(section => {
            section.classList.remove('active');
        });
        document.querySelector(`.form-section[data-step="${step}"]`).classList.add('active');

        // Update indicators
        document.querySelectorAll('.step-item').forEach((item, index) => {
            if (index + 1 === step) {
                item.classList.add('active');
                item.classList.remove('completed');
            } else if (index + 1 < step) {
                item.classList.remove('active');
                item.classList.add('completed');
                item.innerHTML = '<i class="fas fa-check"></i>';
            } else {
                item.classList.remove('active', 'completed');
                item.innerHTML = index + 1;
            }
        });

        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    validateStep(step) {
        const currentSection = document.querySelector(`.form-section[data-step="${step}"]`);
        const inputs = currentSection.querySelectorAll('[required]');
        let isValid = true;

        inputs.forEach(input => {
            // Only validate visible inputs
            if (input.offsetWidth > 0 && input.offsetHeight > 0) {
                if (!input.value || (input.type === 'radio' && !this.isRadioChecked(input.name))) {
                    input.classList.add('is-invalid');
                    isValid = false;
                } else {
                    input.classList.remove('is-invalid');
                }
            }
        });

        if (!isValid) {
            Swal.fire({
                icon: 'warning',
                title: 'Data Belum Lengkap',
                text: 'Harap lengkapi semua field wajib sebelum melanjutkan.',
                confirmButtonColor: '#1e3a8a'
            });
        }

        return isValid;
    }

    isRadioChecked(name) {
        return document.querySelector(`input[name="${name}"]:checked`) !== null;
    }

    nextStep() {
        if (this.validateStep(this.currentStep)) {
            if (this.currentStep < this.totalSteps) {
                this.currentStep++;
                this.showStep(this.currentStep);
                this.updateProgress();
            }
        }
    }

    prevStep() {
        if (this.currentStep > 1) {
            this.currentStep--;
            this.showStep(this.currentStep);
            this.updateProgress();
        }
    }

    updateProgress() {
        const progress = ((this.currentStep - 1) / (this.totalSteps - 1)) * 100;
        const progressBar = document.getElementById('wizardProgressBar');
        if (progressBar) {
            progressBar.style.width = `${progress}%`;
        }
    }

    saveToLocal() {
        const formData = new FormData(this.form);
        const data = {};
        formData.forEach((value, key) => {
            data[key] = value;
        });
        localStorage.setItem('tracer_wizard_draft', JSON.stringify(data));
    }
}

document.addEventListener('DOMContentLoaded', () => {
    window.wizard = new TracerWizard();
});
