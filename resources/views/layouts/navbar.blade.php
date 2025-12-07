<!-- resources/views/layouts/navbar.blade.php -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">📋 Absensi QR</a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            {{-- MENU KIRI --}}
            <ul class="navbar-nav me-auto">
                @auth
                    {{-- Admin --}}
                    @can('admin')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('attendance.rekap.bulanan') }}">Rekap Bulanan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('statistics.attendance') }}">Statistik Absensi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('students.index') }}">Data Siswa</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('teachers.index') }}">Data Guru</a>
                        </li>
                    @endcan

                    {{-- Guru --}}
                    @can('guru')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('class_attendance.index') }}">Absensi Kelas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('subject_attendance.index') }}">Absensi Mapel</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('grades.index') }}">Manajemen Nilai</a>
                        </li>
                    @endcan

                    {{-- Wali Murid --}}
                    @can('walimurid')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('walimurid.statistics') }}">Statistik Anak</a>
                        </li>
                    @endcan
                @endauth
            </ul>

            {{-- MENU KANAN --}}
            <ul class="navbar-nav ms-auto">
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                           data-bs-toggle="dropdown" aria-expanded="false">
                            👤 {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">⚙ Pengaturan Profil</a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">🚪 Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">🔑 Login</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
