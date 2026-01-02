<x-layout title="Login - CMS Landing Page">

    @push('styles')
    <style>
        body {
            background-color: #ffffff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .login-container {
            flex: 1;
            display: flex;
            align-items: center;
            padding: 32px 0;
        }

        .hero-card {
            background-color: #0076d6;
            color: white;
            border-radius: 40px;
            padding: 80px 60px; /* Padding diperbesar agar lebih lega seperti di gambar */
            min-height: 550px;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
        }

        /* Perbaikan selector: hapus titik jika menargetkan tag HTML (h1, p) */
        .hero-card h1 {
            font-weight: 700;
            font-size: 3rem;
            margin-bottom: 25px;
            color: #ffffff;
            line-height: 1.2;
        }

        .hero-card p.lead {
            font-size: 1.25rem;
            opacity: 0.9;
            color: #ffffff;
        }

        .login-form-section {
            padding: 20px 40px;
        }

        .login-form-section h2 {
            color: #2D2F35;
        }

        .form-control {
            background-color: #f8f9fa;
            border: 1px solid #f1f3f5; /* Border lebih tipis/halus */
            padding: 14px 18px;
            border-radius: 12px;
        }

        .form-control:focus {
            background-color: #ffffff;
            box-shadow: none;
            border-color: #0076d6;
        }

        .form-label {
            color: #2D2F35;
            font-weight: 500;
        }

        .btn-login {
            background-color: #adb5bd;
            border: none;
            color: white;
            padding: 14px;
            border-radius: 30px; /* Lebih lonjong (pill) */
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            background-color: #0076d6;
            color: white;
        }

        /* Styling Checkbox agar lebih rapi */
        .form-check-input:checked {
            background-color: #0076d6;
            border-color: #0076d6;
        }

        .form-check{
            padding: 0px;
        }
    </style>
    @endpush

    <div class="login-container">
        <div class="container">
            <div class="row g-5 align-items-stretch"> {{-- align-items-stretch agar tinggi kiri-kanan sama --}}

                {{-- Left Hero --}}
                <div class="col-lg-6 d-none d-lg-block">
                    <div class="hero-card">
                        <div class="text-start">
                            <h1>Build Your Landing Page in Minutes</h1>
                            <p class="lead">
                                Create branded short links and custom QR codes instantly.
                                Monitor performance with real-time analytics.
                            </p>
                        </div>
                        <img src="{{ asset('assets/images/hero-cms.svg') }}" alt="CMS Illustration" class="mx-auto d-block mt-4" style="width: 100%; max-width: 400px;">
                    </div>
                </div>

                {{-- Login Form --}}
                <div class="col-lg-5 offset-lg-1 d-flex flex-column justify-content-center">
                    <div class="login-form-section">

                        <div class="text-center mb-5">
                            <h2 class="fw-bold">Welcome Back!</h2>
                            <p class="text-muted">
                                Enter your email and password to manage your landing page.
                            </p>
                        </div>

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            {{-- <div class="mb-4">
                                <label class="form-label small fw-bold">
                                    Email <span class="text-danger">*</span>
                                </label>
                                <input type="email"
                                       class="form-control"
                                       name="email"
                                       placeholder="name@email.com"
                                       required>
                            </div> --}}
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Username <span class="text-danger">*</span></label>
                                <input type="username" class="form-control" id="username" name="username" required autofocus>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold">
                                    Password <span class="text-danger">*</span>
                                </label>
                                <input type="password"
                                       class="form-control"
                                       name="password"
                                       placeholder="Enter your password"
                                       required>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-5">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                    <label class="form-check-label small text-muted" for="remember">
                                        Remember Me
                                    </label>
                                </div>
                                <a href="#" class="small text-danger text-decoration-none fw-semibold">
                                    Forgot Password?
                                </a>
                            </div>

                            <button type="submit" class="btn btn-login w-100 mb-4">
                                Log In
                            </button>

                            <div class="text-center">
                                <span class="small text-muted">
                                    Don't have an account yet?
                                    <a href="{{ route('register') }}" class="text-primary text-decoration-none fw-bold ms-1">
                                        Sign Up
                                    </a>
                                </span>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

</x-layout>