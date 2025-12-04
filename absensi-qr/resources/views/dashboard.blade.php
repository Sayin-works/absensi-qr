@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h4>Selamat Datang, {{ Auth::user()->name }}</h4>
    <p class="text-muted">Role: {{ Auth::user()->role }}</p>

    <div class="row mt-4">

        {{-- -------------------- ADMIN MENU -------------------- --}}
@if(Auth::user()->role === 'admin')
        {{-- Manajemen Informasi --}}
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title">Informasi Sekolah</h5>
                    
                    <a href="{{ route('information.index') }}" class="btn btn-primary">
                        📰 Kelola Informasi sekolah 
                    </a>
                </div>
            </div>
        </div>
        {{-- Manajemen Siswa --}}
        <div class="col-md-4 mb-3">
            <a href="{{ route('students.index') }}" class="card text-decoration-none shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-user-graduate fa-2x mb-2 text-primary"></i>
                    <h6>Manajemen Siswa</h6>
                </div>
            </a>
        </div>

        {{-- Manajemen Guru --}}
        <div class="col-md-4 mb-3">
            <a href="{{ route('teachers.index') }}" class="card text-decoration-none shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-user-tie fa-2x mb-2 text-dark"></i>
                    <h6>Manajemen Guru</h6>
                </div>
            </a>
        </div>

        {{-- Manajemen Mata Pelajaran --}}
        <div class="col-md-4 mb-3">
            <a href="{{ route('subjects.index') }}" class="card text-decoration-none shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-book fa-2x mb-2 text-success"></i>
                    <h6>Manajemen Mata Pelajaran</h6>
                </div>
            </a>
        </div>

        {{-- Manajemen Kelas --}}
        <div class="col-md-4 mb-3">
            <a href="{{ route('classes.index') }}" class="card text-decoration-none shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-chalkboard fa-2x mb-2 text-secondary"></i>
                    <h6>Manajemen Kelas</h6>
                </div>
            </a>
        </div>

        {{-- Rekap Mingguan --}}
        <div class="col-md-4 mb-3">
            <a href="{{ route('rekap.mingguan') }}" class="card text-decoration-none shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-calendar-week fa-2x mb-2 text-warning"></i>
                    <h6>Rekap Mingguan</h6>
                </div>
            </a>
        </div>

        {{-- Rekap Bulanan --}}
        <div class="col-md-4 mb-3">
            <a href="{{ route('rekap.bulanan') }}" class="card text-decoration-none shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-calendar-alt fa-2x mb-2 text-info"></i>
                    <h6>Rekap Bulanan</h6>
                </div>
            </a>
        </div>

        {{-- Rekap Tahunan --}}
        <div class="col-md-4 mb-3">
            <a href="{{ route('rekap.tahunan') }}" class="card text-decoration-none shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-calendar fa-2x mb-2 text-muted"></i>
                    <h6>Rekap Tahunan</h6>
                </div>
            </a>
        </div>

        {{-- Pengaturan Tahun Ajaran (Opsional) --}}
        <div class="col-md-4 mb-3">
            <a href="{{ route('academic-years.index') }}" class="card text-decoration-none shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-school fa-2x mb-2 text-indigo"></i>
                    <h6>Tahun Ajaran</h6>
                </div>
            </a>
        </div>

        {{-- Statistik Kehadiran (Opsional) --}}
        <div class="col-md-4 mb-3">
            <a href="{{ route('statistics.attendance') }}" class="card text-decoration-none shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-chart-bar fa-2x mb-2 text-danger"></i>
                    <h6>Statistik Kehadiran</h6>
                </div>
            </a>
        </div>

@endif

{{-- -------------------- GURU / PETUGAS MENU -------------------- --}}
@if(Auth::user()->role === 'guru')
        <div class="container mt-4">
            <div class="row">

                {{-- Profil dan Tugas --}}
                <div class="col-md-12 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="mb-3">Profil Guru</h5>
                            <p><strong>Nama:</strong> {{ Auth::user()->name }}</p>
                            <p><strong>Email:</strong> {{ Auth::user()->email }}</p>

                            <h6 class="mt-4">Peran Anda:</h6>
                            <ul class="list-group list-group-flush">
                                @if(Auth::user()->is_subject_teacher && Auth::user()->subjects->isNotEmpty())
                                    <li class="list-group-item">
                                        Guru Mapel:
                                        <span class="text-primary">{{ Auth::user()->subjects->pluck('name')->join(', ') }}</span>
                                    </li>
                                @endif

                                @if(Auth::user()->is_homeroom_teacher && Auth::user()->class)
                                    <li class="list-group-item">
                                        Wali Kelas:
                                        <span class="text-primary">{{ Auth::user()->class->name }}</span>
                                    </li>
                                @endif

                                @if(Auth::user()->is_pickett_teacher ?? false)
                                    <li class="list-group-item">
                                        Petugas Piket
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Fitur untuk Semua Guru --}}
                {{-- Scan QR untuk Absen --}}
                <div class="col-md-4 mb-3">
                    <a href="{{ route('attendance.form') }}" class="card text-decoration-none shadow-sm h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-qrcode fa-2x mb-2 text-primary"></i>
                            <h6>Form Absensi Siswa Masuk & Pulang</h6>
                        </div>
                    </a>
                </div>

                @if(Auth::user()->is_homeroom_teacher && Auth::user()->class)
                <div class="col-md-4 mb-3">
                    <a href="{{ route('attendance.homeroom.scan') }}" class="card text-decoration-none shadow-sm h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-qrcode fa-2x mb-2 text-info"></i>
                            <h6>Scan Siswa Kelas {{ Auth::user()->class->name }} (Masuk)</h6>
                        </div>
                    </a>
                </div>
                @endif

        {{-- Scan QR per Mapel --}}
        @foreach(Auth::user()->subjects as $subject)
            <div class="col-md-4 mb-3">
                <a href="{{ route('attendance.subject.scan', $subject->id) }}" class="card text-decoration-none shadow-sm h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-chalkboard-teacher fa-2x mb-2 text-warning"></i>
                        <h6>Scan Mapel: {{ $subject->name }}</h6>
                    </div>
                </a>
            </div>
        @endforeach

        @if(Auth::user()->is_homeroom_teacher)
            <div class="col-md-4 mb-3">
                <a href="{{ route('attendance.class.recap') }}" class="card text-decoration-none shadow-sm h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-download fa-2x mb-2 text-success"></i>
                        <h6>Download Rekap Kelas Saya</h6>
                    </div>
                </a>
            </div>
        @endif

        @if(Auth::user()->is_subject_teacher)
            @foreach(Auth::user()->subjects as $subject)
                <div class="col-md-4 mb-3">
                    <a href="{{ route('attendance.rekap.subject', $subject->id) }}" class="card text-decoration-none shadow-sm h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-file-download fa-2x mb-2 text-info"></i>
                            <h6>Download Rekap {{ $subject->name }}</h6>
                        </div>
                    </a>
                </div>
            @endforeach
        @endif

        {{-- Fitur untuk Semua Guru --}}
                <div class="col-md-4 mb-3">
                    <a href="{{ route('attendance.records') }}" class="card text-decoration-none shadow-sm h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-database fa-2x mb-2 text-secondary"></i>
                            <h6>Riwayat Presensi</h6>
                        </div>
                    </a>
                    </div>

                    </div>
                </div>
@endif

{{-- -------------------- WALI MURID MENU -------------------- --}}
@if(Auth::user()->role === 'walimurid')
    <div class="container mt-4">
        <div class="row">

            <div class="col-md-12 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="mb-3">Profil Wali Murid</h5>
                        <p><strong>Nama:</strong> {{ Auth::user()->name }}</p>
                        <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                        <p><strong>Nomor HP:</strong> {{ Auth::user()->phone ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <a href="{{ route('walimurid.statistics') }}" class="card text-decoration-none shadow-sm h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-chart-line fa-2x mb-2 text-success"></i>
                        <h6>Statistik Kehadiran Anak</h6>
                    </div>
                </a>
            </div>

            <div class="col-md-4 mb-3">
                <a href="{{ route('attendance.records') }}" class="card text-decoration-none shadow-sm h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-history fa-2x mb-2 text-primary"></i>
                        <h6>Riwayat Kehadiran Anak</h6>
                    </div>
                </a>
            </div>

            <div class="col-md-4 mb-3">
                <a href="{{ route('profile.edit') }}" class="card text-decoration-none shadow-sm h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-user-cog fa-2x mb-2 text-warning"></i>
                        <h6>Edit Profil</h6>
                    </div>
                </a>
            </div>

        </div>
    </div>
@endif


        
    </div>
</div>
@endsection
