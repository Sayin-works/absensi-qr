<x-guest-layout>
    <style>
        .bg-register {
            background: linear-gradient(135deg, #4f46e5, #3b82f6);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }
        .register-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            box-shadow: 0 4px 30px rgba(0,0,0,0.1);
            padding: 2rem;
            width: 100%;
            max-width: 400px;
            color: white;
        }
        .register-title {
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }
        .register-subtitle {
            text-align: center;
            font-size: 0.9rem;
            color: #dbeafe;
            margin-bottom: 1.5rem;
        }
        .register-input {
            width: 100%;
            padding: 0.7rem;
            margin-bottom: 1rem;
            border-radius: 8px;
            border: none;
            outline: none;
        }
        .register-btn {
            width: 100%;
            padding: 0.8rem;
            background: #10b981;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        .register-btn:hover {
            background: #059669;
        }
        .login-link {
            display: block;
            text-align: center;
            margin-top: 0.8rem;
            color: #dbeafe;
            font-size: 0.85rem;
            text-decoration: none;
        }
        .login-link:hover {
            text-decoration: underline;
        }
    </style>

    <div class="bg-register">
        <div class="register-card">
            <!-- Logo -->
            <div class="text-center mb-4">
                <img src="{{ asset('logo-sekolah.png') }}" alt="Logo" style="width:60px; height:60px;">
            </div>

            <!-- Title -->
            <div class="register-title">Daftar Akun</div>
            <div class="register-subtitle">Sistem Absensi SMP Negeri 3 Jati Agung</div>

            <!-- Form -->
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Hidden Role -->
                <input type="hidden" name="role" value="walimurid">

                <!-- Name -->
                <input type="text" name="name" class="register-input" placeholder="Nama Lengkap" value="{{ old('name') }}" required autofocus>

                <!-- Email -->
                <input type="email" name="email" class="register-input" placeholder="Email" value="{{ old('email') }}" required>

                <!-- Password -->
                <input type="password" name="password" class="register-input" placeholder="Password" required>

                <!-- Confirm Password -->
                <input type="password" name="password_confirmation" class="register-input" placeholder="Konfirmasi Password" required>

                <button type="submit" class="register-btn">Daftar</button>
            </form>

            <!-- Link to Login -->
            <a href="{{ route('login') }}" class="login-link">
                Sudah punya akun? Login di sini
            </a>
        </div>
    </div>
</x-guest-layout>
