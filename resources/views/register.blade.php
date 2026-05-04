<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register | SIKEMA - Universitas Harkat Negeri</title>

    <!-- Premium Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('assets/media/favicons/logo.png') }}">

    <!-- Premium SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --primary-color: #0d6efd;
            --primary-gradient: linear-gradient(135deg, #0d6efd 0%, #0043a8 100%);
            --soft-bg: #f8fafc;
        }

        body,
        html {
            height: 100%;
            margin: 0;
            background-color: var(--soft-bg);
            font-family: 'Plus Jakarta Sans', sans-serif;
            overflow-x: hidden;
        }

        .login-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            overflow-y: auto;
        }

        .login-card {
            width: 100%;
            max-width: 1100px;
            margin: auto;
            background: #fff;
            border-radius: 2.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.08);
            display: flex;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.3);
            animation: slideUp 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(40px) scale(0.98);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .login-side-info {
            flex: 1.2;
            background: var(--primary-gradient);
            padding: 3rem;
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
        }

        .login-side-info::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("{{ asset('assets/media/favicons/logo-sikema.png') }}") no-repeat center;
            background-size: 80%;
            opacity: 0.05;
        }

        .login-form-area {
            flex: 1;
            padding: 3rem;
            background: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .brand-logo {
            width: 70px;
            margin-bottom: 2rem;
            transition: transform 0.3s ease;
        }

        h2 {
            font-weight: 800;
            color: #1e293b;
            letter-spacing: -0.025em;
        }

        .text-muted {
            color: #64748b !important;
        }

        .form-label {
            font-weight: 700;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #475569;
            margin-bottom: 0.6rem;
        }

        .input-group-modern {
            position: relative;
            margin-bottom: 1.2rem;
        }

        .input-group-modern .form-control {
            border-radius: 1rem;
            padding: 0.75rem 3.2rem 0.75rem 3.2rem;
            border: 2px solid #e2e8f0;
            background: #f8fafc;
            font-weight: 500;
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }

        .input-group-modern i {
            position: absolute;
            left: 1.1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 1rem;
            transition: color 0.2s ease;
            z-index: 5;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.1);
        }

        .form-control:focus+i {
            color: var(--primary-color);
        }

        .btn-primary-modern {
            background: var(--primary-gradient);
            border: none;
            border-radius: 1rem;
            padding: 1rem;
            font-weight: 700;
            transition: all 0.3s ease;
            box-shadow: 0 10px 15px -3px rgba(13, 110, 253, 0.3);
        }

        .btn-primary-modern:hover {
            transform: translateY(-2px);
            filter: brightness(1.1);
        }

        .toggle-password {
            position: absolute;
            right: 1.25rem;
            top: 0;
            bottom: 0;
            border: none;
            background: transparent;
            padding: 0 1rem;
            margin: 0;
            color: #94a3b8;
            cursor: pointer;
            z-index: 10;
            outline: none !important;
            transition: color 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .toggle-password:hover {
            color: var(--primary-color);
        }

        /* Validation Styles */
        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-8px);
            }

            50% {
                transform: translateX(8px);
            }

            75% {
                transform: translateX(-8px);
            }
        }

        .shake {
            animation: shake 0.4s ease-in-out;
        }

        .is-invalid {
            border-color: #dc3545 !important;
            background-color: #fff8f8 !important;
        }

        .btn-loading {
            pointer-events: none;
            opacity: 0.8;
        }

        .btn-loading .spinner-border {
            width: 1rem;
            height: 1rem;
        }

        .timeline-bullet {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #fff;
            margin-right: 1rem;
            display: inline-block;
            box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.2);
        }

        @media (max-width: 1199.98px) {
            .login-card {
                max-width: 900px;
            }

            .login-side-info,
            .login-form-area {
                padding: 2.5rem;
            }
        }

        @media (max-height: 800px) {

            .login-side-info,
            .login-form-area {
                padding: 2rem 3rem;
            }

            .brand-logo {
                width: 60px;
                margin-bottom: 1rem;
            }

            .mb-4 {
                margin-bottom: 1rem !important;
            }

            .mb-5 {
                margin-bottom: 2rem !important;
            }

            .mt-5 {
                margin-top: 2rem !important;
            }
        }

        @media (max-width: 991.98px) {
            .login-card {
                flex-direction: column;
                max-width: 550px;
            }

            .login-side-info {
                display: none;
            }

            .login-form-area {
                padding: 3rem 2.5rem;
            }
        }

        @media (max-width: 767.98px) {
            .login-wrapper {
                padding: 1rem;
            }

            .login-card {
                border-radius: 1.5rem;
            }

            .login-form-area {
                padding: 2.5rem 1.5rem;
            }

            .brand-logo {
                width: 60px;
                margin-bottom: 1.5rem;
            }

            h2 {
                font-size: 1.75rem;
            }
        }
    </style>
</head>

<body>

    <div class="login-wrapper">
        <div class="login-card shadow-lg">
            <!-- Left Branding Side -->
            <div class="login-side-info d-none d-lg-flex flex-column justify-content-between">
                <div>
                    <h1 class="display-4 fw-800 text-white mb-2">Tracer<span class="fw-300">Study</span></h1>
                    <p class="fs-5 text-white-50 mb-5">Daftarkan akun alumni Anda secara mandiri.</p>

                    <div class="mt-5 space-y-4">
                        <div class="d-flex align-items-center mb-4 animate-fade-in" style="animation-delay: 0.1s;">
                            <span class="timeline-bullet"></span>
                            <div>
                                <h6 class="fw-bold mb-0">Verifikasi NIM & Angkatan</h6>
                                <p class="small text-white-50 mb-0">Pastikan data akademik Anda valid sesuai sistem.</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-4 animate-fade-in" style="animation-delay: 0.2s;">
                            <span class="timeline-bullet text-white-50"
                                style="background: rgba(255,255,255,0.3); box-shadow:none;"></span>
                            <div>
                                <h6 class="fw-bold mb-0">Lengkapi Akun</h6>
                                <p class="small text-white-50 mb-0">Gunakan email yang aktif untuk notifikasi alumni.
                                </p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center animate-fade-in" style="animation-delay: 0.3s;">
                            <span class="timeline-bullet text-white-50"
                                style="background: rgba(255,255,255,0.3); box-shadow:none;"></span>
                            <div>
                                <h6 class="fw-bold mb-0">Mulai Tracer Study</h6>
                                <p class="small text-white-50 mb-0">Bantu kampus dengan mengisi laporan karir Anda.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex align-items-center">
                    <img src="{{ asset('assets/media/favicons/logo_harkatnegeri.png') }}" alt="Logo"
                        class="me-3 shadow-sm" style="width: 40px; height: 40px; object-fit: contain;">
                    <span class="fw-bold">Universitas Harkat Negeri</span>
                </div>
            </div>

            <!-- Right Form Side -->
            <div class="login-form-area">
                <div class="mb-4">
                    <img src="{{ asset('assets/media/favicons/logo_harkatnegeri.png') }}" alt="Logo"
                        class="brand-logo mb-3">
                    <h2 class="mb-1 h3">Registrasi Alumni</h2>
                    <p class="text-muted small">Ciptakan akun baru untuk akses portal SIKEMA</p>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger border-0 rounded-4 shadow-sm mb-4 py-2 px-3 small">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li class="fw-medium">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" id="regForm" novalidate>
                    @csrf

                    <div class="row g-2">
                        <div class="col-md-7">
                            <label class="form-label">Nomor Induk (NIM)</label>
                            <div class="input-group-modern">
                                <i class="fas fa-id-card"></i>
                                <input type="text" class="form-control" placeholder="Contoh: 19000123" name="nim"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label">Tahun Angkatan</label>
                            <div class="input-group-modern">
                                <i class="fas fa-calendar-alt"></i>
                                <input type="number" class="form-control" placeholder="2019" name="tahun_angkatan"
                                    required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat Email</label>
                        <div class="input-group-modern">
                            <i class="fas fa-envelope"></i>
                            <input type="email" class="form-control" placeholder="alumni@email.com" name="email"
                                required>
                        </div>
                    </div>

                    <div class="row g-2">
                        <div class="col-md-6">
                            <label class="form-label">Password Baru</label>
                            <div class="input-group-modern">
                                <i class="fas fa-key"></i>
                                <input type="password" class="form-control" placeholder="••••••••" name="password"
                                    id="password" required>
                                <button type="button" class="toggle-password" data-target="password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Konfirmasi</label>
                            <div class="input-group-modern">
                                <i class="fas fa-shield-alt"></i>
                                <input type="password" class="form-control" placeholder="••••••••"
                                    name="password_confirmation" id="password_confirm" required>
                                <button type="button" class="toggle-password" data-target="password_confirm">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4 mt-2">
                        <div class="form-check">
                            <input class="form-check-input rounded-3 shadow-sm" type="checkbox" id="terms" required>
                            <label class="form-check-label xsmall text-muted fw-medium" for="terms">
                                Saya setuju dengan <a href="#" class="text-primary text-decoration-none">Ketentuan
                                    Privasi</a> universitas.
                            </label>
                        </div>
                    </div>

                    <button type="submit" id="register-submit"
                        class="btn btn-primary-modern text-white w-100 mb-4 py-3 d-flex align-items-center justify-content-center">
                        <span class="btn-text">Buat Akun Sekarang</span>
                        <i class="fas fa-plus-circle ms-2 btn-icon"></i>
                        <div class="spinner-border text-light ms-2 d-none" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </button>

                    <div class="text-center">
                        <p class="text-muted small">Sudah memiliki akun?
                            <a href="/login" class="text-primary fw-800 text-decoration-none ms-1">Silakan Masuk</a>
                        </p>
                    </div>

                    <div class="mt-4 text-center">
                        <small class="text-muted opacity-50 xsmall fw-bold">Universitas Harkat Negeri</small>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Simple form validation visual feedback
        const inputs = document.querySelectorAll('.form-control');
        inputs.forEach(input => {
            input.addEventListener('focus', () => {
                input.closest('div').previousElementSibling?.classList.add('text-primary');
            });
            input.addEventListener('blur', () => {
                input.closest('div').previousElementSibling?.classList.remove('text-primary');
            });
        });

        // Toggle password visibility
        const toggleBtns = document.querySelectorAll('.toggle-password');
        toggleBtns.forEach(btn => {
            btn.addEventListener('click', function () {
                const targetId = this.getAttribute('data-target');
                const input = document.getElementById(targetId);
                const type = input.type === 'password' ? 'text' : 'password';
                input.type = type;
                this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
            });
        });

        // Form Validation
        const regForm = document.getElementById('regForm');
        const submitBtn = document.getElementById('register-submit');

        regForm.addEventListener('submit', function (e) {
            let isValid = true;
            let errorMessage = "";

            const nim = document.querySelector('input[name="nim"]');
            const tahun = document.querySelector('input[name="tahun_angkatan"]');
            const email = document.querySelector('input[name="email"]');
            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('password_confirm');
            const terms = document.getElementById('terms');

            // Reset validation states
            document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));

            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!nim.value.trim()) {
                isValid = false;
                errorMessage = "NIM tidak boleh kosong!";
                nim.classList.add('is-invalid');
            } else if (!tahun.value.trim()) {
                isValid = false;
                errorMessage = "Tahun Angkatan tidak boleh kosong!";
                tahun.classList.add('is-invalid');
            } else if (!email.value.trim()) {
                isValid = false;
                errorMessage = "Email tidak boleh kosong!";
                email.classList.add('is-invalid');
            } else if (!emailRegex.test(email.value.trim())) {
                isValid = false;
                errorMessage = "Format email tidak valid!";
                email.classList.add('is-invalid');
            } else if (!password.value.trim()) {
                isValid = false;
                errorMessage = "Password tidak boleh kosong!";
                password.classList.add('is-invalid');
            } else if (password.value.length < 8) {
                isValid = false;
                errorMessage = "Password minimal 8 karakter!";
                password.classList.add('is-invalid');
            } else if (password.value !== confirmPassword.value) {
                isValid = false;
                errorMessage = "Konfirmasi password tidak cocok!";
                confirmPassword.classList.add('is-invalid');
                password.classList.add('is-invalid');
            } else if (!terms.checked) {
                isValid = false;
                errorMessage = "Anda harus menyetujui Ketentuan Privasi!";
            }

            if (!isValid) {
                e.preventDefault();

                // Shake animation
                const formArea = document.querySelector('.login-form-area');
                formArea.classList.remove('shake');
                void formArea.offsetWidth; // trigger reflow
                formArea.classList.add('shake');

                // SweetAlert
                Swal.fire({
                    icon: 'error',
                    title: 'Validasi Gagal',
                    text: errorMessage,
                    confirmButtonColor: '#0d6efd',
                    customClass: { popup: 'rounded-4' }
                });
            } else {
                // Loading state
                submitBtn.classList.add('btn-loading');
                submitBtn.querySelector('.btn-text').textContent = 'Memproses...';
                submitBtn.querySelector('.btn-icon').classList.add('d-none');
                submitBtn.querySelector('.spinner-border').classList.remove('d-none');
            }
        });
    </script>

</body>

</html>