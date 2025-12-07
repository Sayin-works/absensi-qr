<x-guest-layout>
    <style>
        .bg-login {
            background: linear-gradient(135deg, #4f46e5, #3b82f6);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }
        .login-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            box-shadow: 0 4px 30px rgba(0,0,0,0.1);
            padding: 2rem;
            width: 100%;
            max-width: 380px;
            color: white;
        }
        .login-title {
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }
        .login-subtitle {
            text-align: center;
            font-size: 0.9rem;
            color: #dbeafe;
            margin-bottom: 1.5rem;
        }
        .login-input {
            width: 100%;
            padding: 0.7rem;
            margin-bottom: 1rem;
            border-radius: 8px;
            border: none;
            outline: none;
        }
        .login-btn {
            width: 100%;
            padding: 0.8rem;
            background: #10b981;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        .login-btn:hover {
            background: #059669;
        }
        .forgot-link {
            display: block;
            text-align: center;
            margin-top: 0.8rem;
            color: #dbeafe;
            font-size: 0.85rem;
            text-decoration: none;
        }
        .forgot-link:hover {
            text-decoration: underline;
        }
    </style>

    <div class="bg-login">
        <div class="login-card">
            <!-- Logo -->
            <div class="text-center mb-4">
                <img src="{{ asset('logo-sekolah.png') }}" alt="Logo" style="width:60px; height:60px;">
            </div>

            <!-- Title -->
            <div class="login-title">Sistem Absensi</div>
            <div class="login-subtitle">SMP Negeri 3 Jati Agung</div>

            <!-- Form -->
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <input type="email" name="email" class="login-input" placeholder="Email" required autofocus>
                <input type="password" name="password" class="login-input" placeholder="Password" required>

                <button type="submit" class="login-btn">Masuk</button>
            </form>

            <!-- Forgot Password -->
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="forgot-link">
                    Lupa password?
                </a>
            @endif
        </div>
    </div>
</x-guest-layout>
