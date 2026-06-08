<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | Tracer Study TI UHN</title>

    <!-- Premium Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('assets/media/favicons/logo_harkatnegeri.png') }}">
    <!-- Premium SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --primary-color: #5a121b;
            --primary-gradient: linear-gradient(135deg, #5a121b 0%, #2b0408 100%);
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
            max-width: 1000px;
            margin: auto;
            background: #fff;
            border-radius: 2rem;
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
            flex: 1;
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
            display: none;
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
            width: 80px;
            margin-bottom: 2rem;
            transition: transform 0.3s ease;
        }

        .brand-logo:hover {
            transform: rotate(-10deg) scale(1.1);
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
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #475569;
            margin-bottom: 0.75rem;
        }

        .input-group-modern {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .input-group-modern .form-control {
            border-radius: 1rem;
            padding: 0.85rem 3.5rem 0.85rem 3.5rem;
            border: 2px solid #e2e8f0;
            background: #f8fafc;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .input-group-modern i {
            position: absolute;
            left: 1.25rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 1.1rem;
            transition: color 0.2s ease;
            z-index: 5;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(90, 18, 27, 0.1);
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
            letter-spacing: 0.01em;
            transition: all 0.3s ease;
            box-shadow: 0 10px 15px -3px rgba(90, 18, 27, 0.3);
        }

        .btn-primary-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(90, 18, 27, 0.4);
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
            box-shadow: none !important;
            transition: color 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .toggle-password:hover {
            color: var(--primary-color);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.7) !important;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        /* NEW: Shake animation for validation */
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

        .btn-loading {
            pointer-events: none;
            opacity: 0.8;
        }

        .btn-loading .spinner-border {
            width: 1rem;
            height: 1rem;
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

        .floating-circles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: -1;
        }

        .circle {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 15s infinite linear;
        }

        @keyframes float {
            0% {
                transform: translateY(0) rotate(0deg);
                opacity: 0;
            }

            10% {
                opacity: 0.3;
            }

            90% {
                opacity: 0.3;
            }

            100% {
                transform: translateY(-1000px) rotate(720deg);
                opacity: 0;
            }
        }
    </style>
</head>

<body>

    <div class="login-wrapper">
        <div class="login-card">
            <!-- Left Branding Side -->
            <div class="login-side-info d-none d-lg-flex flex-column justify-content-between">
                <div>
                    <h1 class="display-4 fw-800 text-white mb-2">TRACER <span class="fw-300">STUDY</span></h1>
                    <p class="fs-5 text-white-50">Sistem Informasi Penelusuran Alumni & Bursa Kerja</p>
                </div>

                <!-- Illustration in the middle -->
                <div class="text-center my-4 animate-fade-in">
                    <img src="{{ asset('assets/media/favicons/login-uhn.png') }}" alt="UHN Login Illustration"
                        class="img-fluid" style="max-height: 220px; object-fit: contain;">
                </div>

                <div class="mb-5 animate-fade-in">
                    <div class="glass-card p-4 rounded-4 shadow-lg mb-4 text-dark position-relative">
                        <i class="fas fa-quote-left fa-2x opacity-10 position-absolute top-0 start-0 m-2"></i>
                        <p class="mb-0 fw-medium ps-4 text-dark-50">"Data Anda sangat berharga bagi peningkatan
                            akreditasi dan kualitas universitas kita di masa depan."</p>
                    </div>
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('assets/media/favicons/logo-uhn-new.svg') }}" alt="Universitas Harkat Negeri"
                            style="height: 50px; max-width: 100%; object-fit: contain;">
                    </div>
                </div>

                <div class="floating-circles">
                    <div class="circle" style="width: 80px; height: 80px; left: 10%; animation-delay: 0s;"></div>
                    <div class="circle" style="width: 120px; height: 120px; left: 70%; animation-delay: 2s;"></div>
                    <div class="circle" style="width: 60px; height: 60px; left: 40%; animation-delay: 4s;"></div>
                </div>
            </div>

            <!-- Right Form Side -->
            <div class="login-form-area position-relative">
                <div class="position-absolute top-0 end-0 mt-3 me-3">
                    <a href="{{ route('home') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3 fw-bold"><i
                            class="fa fa-arrow-left me-1"></i> Kembali</a>
                </div>
                <div class="mb-4 text-center text-lg-start">
                    <img src="{{ asset('assets/media/favicons/logo_harkatnegeri.png') }}" alt="Logo"
                        class="brand-logo mb-4" style="object-fit: contain;">
                    <h2 class="mb-2">Selamat Datang</h2>
                    <p class="text-muted">Masuk untuk mengakses portal alumni</p>
                </div>

                @if (session('status'))
                    <div class="alert alert-success border-0 rounded-4 shadow-sm mb-4">
                        <i class="fas fa-check-circle me-2"></i> {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" novalidate>
                    @csrf

                    <div class="mb-4">
                        <label class="form-label">Email Institusi</label>
                        <div class="input-group-modern">
                            <i class="fas fa-envelope"></i>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                placeholder="nama@email.com" name="email" value="{{ old('email') }}" required autofocus>
                        </div>
                        @error('email')
                            <div class="text-danger small mt-n3 mb-3 fw-bold"><i class="fas fa-exclamation-circle me-1"></i>
                                {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label class="form-label mb-0">Password Akun</label>
                            <a href="#" class="text-primary text-decoration-none xsmall fw-bold">Lupa Password?</a>
                        </div>
                        <div class="input-group-modern">
                            <i class="fas fa-lock"></i>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                placeholder="••••••••" name="password" id="password" required>
                            <button type="button" class="toggle-password" id="togglePassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="text-danger small mt-n3 mb-3 fw-bold"><i class="fas fa-exclamation-circle me-1"></i>
                                {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4 d-flex justify-content-between align-items-center">
                        <div class="form-check">
                            <input class="form-check-input shadow-sm" type="checkbox" name="remember" id="remember">
                            <label class="form-check-label small fw-medium" for="remember">Ingat Saya</label>
                        </div>
                    </div>

                    <button type="submit" id="ログイン-submit"
                        class="btn btn-primary-modern text-white w-100 mb-4 d-flex align-items-center justify-content-center">
                        <span class="btn-text">Masuk Sekarang</span>
                        <i class="fas fa-arrow-right ms-2 fs-xs btn-icon"></i>
                        <div class="spinner-border text-light ms-2 d-none" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </button>

                    <div class="text-center">
                        <p class="text-muted small">Belum memiliki akun?
                            <a href="/register"
                                class="text-primary fw-800 text-decoration-none ms-1 border-bottom border-2 border-primary border-opacity-10">Mendaftar
                                Disini</a>
                        </p>
                    </div>

                    <div class="mt-5 text-center">
                        <small class="text-muted opacity-50 xsmall fw-bold">Universitas Harkat Negeri</small>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const loginForm = document.querySelector('form');
        const passwordInput = document.getElementById('password');
        const emailInput = document.querySelector('input[type="email"]');
        const togglePasswordBtn = document.getElementById('togglePassword');
        const submitBtn = document.getElementById('ログイン-submit');

        togglePasswordBtn.addEventListener('click', function () {
            const type = passwordInput.type === 'password' ? 'text' : 'password';
            passwordInput.type = type;
            this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
        });

        loginForm.addEventListener('submit', function (e) {
            let isValid = true;
            let errorMessage = "";

            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!emailInput.value.trim()) {
                isValid = false;
                errorMessage = "Email institusi tidak boleh kosong!";
                emailInput.classList.add('is-invalid');
            } else if (!emailRegex.test(emailInput.value.trim())) {
                isValid = false;
                errorMessage = "Format email tidak valid!";
                emailInput.classList.add('is-invalid');
            } else {
                emailInput.classList.remove('is-invalid');
            }

            if (!passwordInput.value.trim()) {
                isValid = false;
                errorMessage = "Password tidak boleh kosong!";
                passwordInput.classList.add('is-invalid');
            } else {
                passwordInput.classList.remove('is-invalid');
            }

            if (!isValid) {
                e.preventDefault();
                // Play shake animation
                const formArea = document.querySelector('.login-form-area');
                formArea.classList.add('shake');
                setTimeout(() => formArea.classList.remove('shake'), 400);

                // Show SweetAlert
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: errorMessage,
                    confirmButtonColor: '#0d6efd',
                    customClass: {
                        popup: 'rounded-4'
                    }
                });
            } else {
                // Show loading state
                submitBtn.classList.add('btn-loading');
                submitBtn.querySelector('.btn-text').textContent = 'Memproses...';
                submitBtn.querySelector('.btn-icon').classList.add('d-none');
                submitBtn.querySelector('.spinner-border').classList.remove('d-none');
            }
        });

        // Add focus effect to labels
        document.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener('focus', () => {
                const label = input.closest('.mb-4').querySelector('.form-label');
                if (label) label.style.color = 'var(--primary-color)';
            });
            input.addEventListener('blur', () => {
                const label = input.closest('.mb-4').querySelector('.form-label');
                if (label) label.style.color = '#475569';
            });
        });
    </script>

</body>

</html>