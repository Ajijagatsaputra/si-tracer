// /**
//  * Form Auto-Save System
//  * Menyimpan data form secara otomatis ke localStorage
//  * untuk mencegah kehilangan data saat ada error validasi
//  */

// class FormAutoSave {
//     constructor(formId, storageKey = 'form_autosave') {
//         this.form = document.getElementById(formId);
//         this.storageKey = storageKey;
//         this.autoSaveInterval = null;
//         this.lastSaveTime = null;

//         if (this.form) {
//             this.init();
//         }
//     }

//     init() {
//         // Mulai auto-save setelah 2 detik
//         this.startAutoSave();

//         // Event listeners untuk input changes
//         this.setupEventListeners();

//         // Restore data saat halaman dimuat
//         this.restoreFormData();

//         // Tampilkan notifikasi auto-save
//         this.showAutoSaveNotification();

//         // Setup form submission handler
//         this.setupFormSubmission();

//         // Setup session checking
//         this.setupSessionChecking();
//     }

//     setupEventListeners() {
//         // Monitor semua input, select, dan textarea
//         const formElements = this.form.querySelectorAll('input, select, textarea');

//         formElements.forEach(element => {
//             // Skip readonly dan disabled elements
//             if (element.readOnly || element.disabled) return;

//             // Event untuk input text, email, number, tel
//             if (['text', 'email', 'number', 'tel'].includes(element.type)) {
//                 element.addEventListener('input', () => this.saveFormData());
//                 element.addEventListener('blur', () => this.saveFormData());
//             }

//             // Event untuk select
//             if (element.tagName === 'SELECT') {
//                 element.addEventListener('change', () => this.saveFormData());
//             }

//             // Event untuk textarea
//             if (element.tagName === 'TEXTAREA') {
//                 element.addEventListener('input', () => this.saveFormData());
//                 element.addEventListener('blur', () => this.saveFormData());
//             }

//             // Event untuk radio buttons dan checkboxes
//             if (['radio', 'checkbox'].includes(element.type)) {
//                 element.addEventListener('change', () => this.saveFormData());
//             }
//         });
//     }

//     startAutoSave() {
//         // Auto-save setiap 5 detik
//         this.autoSaveInterval = setInterval(() => {
//             this.saveFormData();
//         }, 5000);
//     }

//     saveFormData() {
//         try {
//             const formData = new FormData(this.form);
//             const data = {};

//             // Convert FormData to plain object
//             for (let [key, value] of formData.entries()) {
//                 // Handle multiple values (checkboxes, multiple select)
//                 if (data[key]) {
//                     if (Array.isArray(data[key])) {
//                         data[key].push(value);
//                     } else {
//                         data[key] = [data[key], value];
//                     }
//                 } else {
//                     data[key] = value;
//                 }
//             }

//             // Tambahkan timestamp
//             data._lastSaved = new Date().toISOString();

//             // Simpan ke localStorage
//             localStorage.setItem(this.storageKey, JSON.stringify(data));

//             this.lastSaveTime = new Date();
//             this.updateLastSaveIndicator();

//         } catch (error) {
//             console.error('Error saving form data:', error);
//         }
//     }

//     restoreFormData() {
//         try {
//             const savedData = localStorage.getItem(this.storageKey);
//             if (!savedData) return;

//             const data = JSON.parse(savedData);

//             // Cek apakah ada error validation atau session expired
//             const hasErrors = document.querySelector('.alert-danger');
//             if (hasErrors) {
//                 console.log('Validation errors detected, clearing auto-saved data');
//                 this.clearSavedData();
//                 return;
//             }

//             // Restore form values
//             Object.keys(data).forEach(key => {
//                 if (key === '_lastSaved') return; // Skip metadata

//                 const element = this.form.querySelector(`[name="${key}"]`);
//                 if (!element) return;

//                 const value = data[key];

//                 if (element.type === 'checkbox') {
//                     if (Array.isArray(value)) {
//                         element.checked = value.includes(element.value);
//                     } else {
//                         element.checked = value === element.value;
//                     }
//                 } else if (element.type === 'radio') {
//                     if (Array.isArray(value)) {
//                         element.checked = value.includes(element.value);
//                     } else {
//                         element.checked = value === element.value;
//                     }
//                 } else if (element.tagName === 'SELECT' && element.multiple) {
//                     // Handle multiple select
//                     if (Array.isArray(value)) {
//                         Array.from(element.options).forEach(option => {
//                             option.selected = value.includes(option.value);
//                         });
//                     }
//                 } else {
//                     element.value = value;
//                 }
//             });

//             // Trigger change events untuk update UI
//             this.triggerChangeEvents();

//             console.log('Form data restored from auto-save');

//         } catch (error) {
//             console.error('Error restoring form data:', error);
//         }
//     }

//     triggerChangeEvents() {
//         // Trigger change events untuk update progress bar dan validasi
//         const formElements = this.form.querySelectorAll('input, select, textarea');
//         formElements.forEach(element => {
//             if (element.type !== 'hidden') {
//                 element.dispatchEvent(new Event('change', { bubbles: true }));
//             }
//         });
//     }

//     setupFormSubmission() {
//         this.form.addEventListener('submit', (e) => {
//             // Clear saved data setelah submit berhasil
//             this.clearSavedData();
//         });
//     }

//     clearSavedData() {
//         localStorage.removeItem(this.storageKey);
//         console.log('Auto-saved form data cleared after successful submission');

//         // Update UI untuk hide data management section
//         const dataSection = document.getElementById('data-management-section');
//         if (dataSection) {
//             dataSection.style.display = 'none';
//         }

//         // Update last save indicator
//         const indicator = document.getElementById('last-save-indicator');
//         if (indicator) {
//             indicator.remove();
//         }
//     }

//     // Function untuk clear data saat session expired
//     clearDataOnSessionExpired() {
//         console.log('Session expired detected, clearing auto-saved data');
//         this.clearSavedData();

//         // Reset form ke state awal
//         this.form.reset();

//         // Trigger change events untuk update UI
//         this.triggerChangeEvents();

//         // Tampilkan notifikasi
//         this.showSessionExpiredNotification();
//     }

//     showSessionExpiredNotification() {
//         const notification = document.createElement('div');
//         notification.className = 'alert alert-warning alert-dismissible fade show mt-3';
//         notification.innerHTML = `
//             <i class="fas fa-exclamation-triangle me-2"></i>
//             <strong>Session Expired!</strong> Data form telah di-reset. Silakan isi ulang form.
//             <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
//         `;

//         // Insert setelah alert errors
//         const firstAlert = document.querySelector('.alert');
//         if (firstAlert) {
//             firstAlert.parentNode.insertBefore(notification, firstAlert.nextSibling);
//         }

//         // Auto-hide setelah 15 detik
//         setTimeout(() => {
//             if (notification.parentNode) {
//                 notification.remove();
//             }
//         }, 15000);
//     }

//     updateLastSaveIndicator() {
//         // Update atau buat indicator last save
//         let indicator = document.getElementById('last-save-indicator');
//         if (!indicator) {
//             indicator = document.createElement('div');
//             indicator.id = 'last-save-indicator';
//             indicator.className = 'text-muted small mt-2';
//             indicator.innerHTML = '<i class="fas fa-save me-1"></i>Data tersimpan otomatis';

//             // Insert setelah progress bar
//             const progressSection = this.form.querySelector('.mb-4');
//             if (progressSection) {
//                 progressSection.appendChild(indicator);
//             }
//         }

//         if (this.lastSaveTime) {
//             const timeAgo = this.getTimeAgo(this.lastSaveTime);
//             indicator.innerHTML = `<i class="fas fa-save me-1"></i>Data tersimpan otomatis ${timeAgo}`;

//             // Update data management section
//             this.updateDataManagementSection();
//         }
//     }

//     updateDataManagementSection() {
//         const dataSection = document.getElementById('data-management-section');
//         const savedDataInfo = document.getElementById('saved-data-info');

//         if (dataSection && savedDataInfo && this.lastSaveTime) {
//             const timeAgo = this.getTimeAgo(this.lastSaveTime);
//             savedDataInfo.textContent = `Data tersimpan ${timeAgo}`;
//             dataSection.style.display = 'block';
//         }
//     }

//     getTimeAgo(date) {
//         const now = new Date();
//         const diffMs = now - date;
//         const diffSecs = Math.floor(diffMs / 1000);
//         const diffMins = Math.floor(diffSecs / 60);
//         const diffHours = Math.floor(diffMins / 60);

//         if (diffSecs < 60) return 'baru saja';
//         if (diffMins < 60) return `${diffMins} menit yang lalu`;
//         if (diffHours < 24) return `${diffHours} jam yang lalu`;
//         return 'kemarin';
//     }

//     showAutoSaveNotification() {
//         // Tampilkan notifikasi bahwa auto-save aktif
//         const notification = document.createElement('div');
//         notification.className = 'alert alert-info alert-dismissible fade show mt-3';
//         notification.innerHTML = `
//             <i class="fas fa-info-circle me-2"></i>
//             <strong>Auto-Save Aktif!</strong> Data form Anda akan tersimpan otomatis setiap 5 detik.
//             Jika ada error, data tidak akan hilang.
//             <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
//         `;

//         // Insert setelah alert errors
//         const firstAlert = document.querySelector('.alert');
//         if (firstAlert) {
//             firstAlert.parentNode.insertBefore(notification, firstAlert.nextSibling);
//         }

//         // Auto-hide setelah 10 detik
//         setTimeout(() => {
//             if (notification.parentNode) {
//                 notification.remove();
//             }
//         }, 10000);
//     }

//     // Method untuk manual save
//     manualSave() {
//         this.saveFormData();
//         this.showManualSaveNotification();
//     }

//     showManualSaveNotification() {
//         // Tampilkan notifikasi manual save
//         const notification = document.createElement('div');
//         notification.className = 'alert alert-success alert-dismissible fade show mt-3';
//         notification.innerHTML = `
//             <i class="fas fa-check-circle me-2"></i>
//             <strong>Data Tersimpan!</strong> Form telah disimpan secara manual.
//             <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
//         `;

//         // Insert setelah alert errors
//         const firstAlert = document.querySelector('.alert');
//         if (firstAlert) {
//             firstAlert.parentNode.insertBefore(notification, firstAlert.nextSibling);
//         }

//         // Auto-hide setelah 5 detik
//         setTimeout(() => {
//             if (notification.parentNode) {
//                 notification.remove();
//             }
//         }, 5000);
//     }

//     setupSessionChecking() {
//         // Check session setiap 30 detik
//         setInterval(() => {
//             this.checkSession();
//         }, 30000);

//         // Check session saat halaman focus
//         window.addEventListener('focus', () => {
//             this.checkSession();
//         });

//         // Check session saat form di-submit
//         this.form.addEventListener('submit', () => {
//             this.checkSession();
//         });
//     }

//     checkSession() {
//         // Check apakah ada error 419 (session expired)
//         const hasSessionError = document.querySelector('.alert-danger') &&
//                               document.querySelector('.alert-danger').textContent.includes('419');

//         if (hasSessionError) {
//             this.clearDataOnSessionExpired();
//             return;
//         }

//         // Check apakah ada error validation yang berhubungan dengan session
//         const hasValidationErrors = document.querySelector('.alert-danger');
//         if (hasValidationErrors) {
//             const errorText = hasValidationErrors.textContent.toLowerCase();
//             if (errorText.includes('session') || errorText.includes('expired') || errorText.includes('token')) {
//                 this.clearDataOnSessionExpired();
//                 return;
//             }
//         }
//     }
// }

// // Initialize FormAutoSave when DOM is loaded
// document.addEventListener('DOMContentLoaded', function() {
//     // Initialize auto-save untuk form alumni
//     if (document.getElementById('alumniForm')) {
//         window.formAutoSave = new FormAutoSave('alumniForm', 'alumni_tracer_form');
//     }

//     // Tambahkan tombol manual save
//     addManualSaveButton();
// });

// function addManualSaveButton() {
//     const form = document.getElementById('alumniForm');
//     if (!form) return;

//     // Cari progress section
//     const progressSection = form.querySelector('.mb-4');
//     if (!progressSection) return;

//     // Buat tombol manual save
//     const saveButton = document.createElement('button');
//     saveButton.type = 'button';
//     saveButton.className = 'btn btn-outline-primary btn-sm ms-2';
//     saveButton.innerHTML = '<i class="fas fa-save me-1"></i>Simpan Sekarang';
//     saveButton.onclick = () => {
//         if (window.formAutoSave) {
//             window.formAutoSave.manualSave();
//         }
//     };

//     // Buat tombol clear data
//     const clearButton = document.createElement('button');
//     clearButton.type = 'button';
//     clearButton.className = 'btn btn-outline-danger btn-sm ms-2';
//     clearButton.innerHTML = '<i class="fas fa-trash me-1"></i>Clear Data';
//     clearButton.onclick = () => {
//         if (confirm('Yakin ingin menghapus semua data tersimpan? Form akan di-reset.')) {
//             if (window.formAutoSave) {
//                 window.formAutoSave.clearDataOnSessionExpired();
//             }
//         }
//     };

//     // Insert setelah progress bar
//     const progressBar = progressSection.querySelector('.progress');
//     if (progressBar) {
//         progressBar.parentNode.insertBefore(saveButton, progressBar.nextSibling);
//         progressBar.parentNode.insertBefore(clearButton, progressBar.nextSibling);
//     }
// }

// // Tambahkan event listener untuk page unload warning
// window.addEventListener('beforeunload', function(e) {
//     // Cek apakah ada data tersimpan
//     const savedData = localStorage.getItem('alumni_tracer_form');
//     if (savedData) {
//         e.preventDefault();
//         e.returnValue = 'Data form Anda akan tersimpan otomatis. Yakin ingin meninggalkan halaman ini?';
//         return e.returnValue;
//     }
// });
