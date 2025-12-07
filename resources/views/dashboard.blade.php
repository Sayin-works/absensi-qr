@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h4>Selamat Datang, {{ Auth::user()->name }}</h4>
    <p class="text-muted">Role: {{ Auth::user()->role }}</p>

    <div class="row mt-4">

        {{-- ==================== ADMIN MENU ==================== --}}
        @if(Auth::user()->role === 'admin')
            {{-- Manajemen Informasi --}}
            <div class="col-md-4 mb-3">
                <a href="{{ route('information.index') }}" class="card text-decoration-none shadow-sm h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-newspaper fa-2x mb-2 text-primary"></i>
                        <h6>Informasi Sekolah</h6>
                    </div>
                </a>
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

            {{-- Tahun Ajaran --}}
            <div class="col-md-4 mb-3">
                <a href="{{ route('academic-years.index') }}" class="card text-decoration-none shadow-sm h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-school fa-2x mb-2 text-info"></i>
                        <h6>Tahun Ajaran</h6>
                    </div>
                </a>
            </div>

            {{-- Rekap Absensi Bulanan --}}
            <div class="col-md-4 mb-3">
                <a href="{{ route('attendance.rekap.bulanan') }}" class="card text-decoration-none shadow-sm h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-calendar-alt fa-2x mb-2 text-success"></i>
                        <h6>Rekap Absensi Bulanan</h6>
                    </div>
                </a>
            </div>
        @endif

        {{-- ==================== GURU MENU ==================== --}}
@if(Auth::user()->role === 'guru')

    {{-- Profil Guru --}}
    <div class="col-md-12 mb-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="mb-3">Profil Guru</h5>
                <p><strong>Nama:</strong> {{ Auth::user()->name }}</p>
                <p><strong>Email:</strong> {{ Auth::user()->email }}</p>

                <h6 class="mt-4">Peran:</h6>
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
                        <li class="list-group-item">Petugas Piket</li>
                    @endif
                </ul>
            </div>
        </div>
    </div>

    {{-- Tombol Input Nilai untuk Guru Mapel --}}
                    {{-- Manajemen Informasi --}}
            <div class="col-md-4 mb-3">
                <a href="{{ route('information.index') }}" class="card text-decoration-none shadow-sm h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-newspaper fa-2x mb-2 text-primary"></i>
                        <h6>Informasi Sekolah</h6>
                    </div>
                </a>
            </div>
    @if(Auth::user()->is_subject_teacher && Auth::user()->subjects->isNotEmpty())
        @foreach(Auth::user()->subjects as $subject)
            <div class="col-md-4 mb-3">
                <a href="{{ route('grades.create', $subject->id) }}" 
                   class="card text-decoration-none shadow-sm h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-clipboard-list fa-2x mb-2 text-success"></i>
                        <h6>Input Nilai {{ $subject->name }}</h6>
                    </div>
                </a>
            </div>
        @endforeach
    @endif

    {{-- Scan Kehadiran Siswa --}}
    <div class="col-md-4 mb-3">
        <a href="{{ route('attendance.scan') }}" class="card text-decoration-none shadow-sm h-100">
            <div class="card-body text-center">
                <i class="fas fa-qrcode fa-2x mb-2 text-danger"></i>
                <h6>Scan Kehadiran Siswa</h6>
                <p class="small text-muted mb-0">Absen masuk & pulang</p>
            </div>
        </a>
    </div>
                {{-- Rekap Absensi Bulanan --}}
            <div class="col-md-4 mb-3">
                <a href="{{ route('attendance.rekap.bulanan') }}" class="card text-decoration-none shadow-sm h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-calendar-alt fa-2x mb-2 text-success"></i>
                        <h6>Rekap Absensi Bulanan</h6>
                    </div>
                </a>
            </div>

    {{-- Absensi Kelas (Wali Kelas) --}}
    @if(Auth::user()->is_homeroom_teacher)
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <h6>Absensi Kelas</h6>
                    <a href="{{ route('class_attendance.index') }}" class="btn btn-primary btn-sm">Mulai Absensi</a>
                    <a href="{{ route('class_attendance.rekap') }}" class="btn btn-secondary btn-sm">Lihat Rekap</a>
                </div>
            </div>
        </div>
    @endif

    {{-- Absensi Mapel --}}
    <div class="col-md-4 mb-3">
        <a href="{{ route('subject_attendance.index') }}" class="card text-decoration-none shadow-sm h-100">
            <div class="card-body text-center">
                <i class="fas fa-book-open fa-2x mb-2 text-primary"></i>
                <h6>Absensi Mapel</h6>
            </div>
        </a>
    </div>

    {{-- Rekap Bulanan --}}
    <div class="col-md-4 mb-3">
        <a href="{{ route('attendance.rekap.bulanan') }}" class="card text-decoration-none shadow-sm h-100">
            <div class="card-body text-center">
                <i class="fas fa-calendar-check fa-2x mb-2 text-primary"></i>
                <h6>Lihat Rekap Bulanan</h6>
            </div>
        </a>
    </div>
@endif


{{-- ==================== WALI MURID MENU ==================== --}}
@if(Auth::user()->role === 'walimurid')

    {{-- Profil Wali Murid --}}
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

    {{-- Data Anak --}}
    @if($children->count() > 0)
        @foreach($children as $child)
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-primary text-white">
                    {{ $child->name }} - Kelas {{ $child->classroom->nama ?? '-' }}
                </div>

                <div class="card-body">
                    <p><strong>NISN:</strong> {{ $child->nisn }}</p>

                    {{-- NILAI ANAK --}}
                    <h6 class="mt-3">Nilai Akademik</h6>
                    @if($child->grades->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered table-striped text-center align-middle">
                                <thead class="table-primary">
                                    <tr style="font-size: 12px;">
                                        <th>Mapel</th>
                                        @for($i=1; $i<=8; $i++)
                                            <th>KD{{ $i }}</th>
                                        @endfor
                                        <th>UTS</th>
                                        <th>UAS</th>
                                        <th>Nilai Akhir</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($child->grades as $grade)
                                        <tr style="font-size: 12px;">
                                            <td>{{ $grade->subject->name }}</td>
                                            @for($i = 1; $i <= 8; $i++)
                                                @php $kdField = 'kd'.$i; @endphp
                                                <td>{{ $grade->$kdField ?? 0 }}</td>
                                            @endfor
                                            <td>{{ $grade->nilai_uts ?? 0 }}</td>
                                            <td>{{ $grade->nilai_uas ?? 0 }}</td>
                                            <td>{{ $grade->nilai_akhir ?? 0 }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <small class="text-muted fst-italic">
                            *Nilai 0 menandakan belum ada data (kosong).
                        </small>
                    @else
                        <p class="text-muted">Belum ada nilai akademik.</p>
                    @endif
                </div>
                                {{-- Rekap Absensi --}}
                <h6 class="mt-4">Rekap Absensi Bulan Ini</h6>
                @if($child->attendances->count() > 0)
                    <ul>
                        <li>Hadir: {{ $child->attendances->where('status', 'Hadir')->count() }}</li>
                        <li>Izin: {{ $child->attendances->where('keterangan', 'Izin')->count() }}</li>
                        <li>Sakit: {{ $child->attendances->where('keterangan', 'Sakit')->count() }}</li>
                        <li>Alpha: {{ $child->attendances->where('keterangan', 'Alpha')->count() }}</li>
                    </ul>
                @else
                    <p class="text-muted">Belum ada data absensi bulan ini.</p>
                @endif
            </div>
        @endforeach
        
    @else
        <div class="alert alert-warning">Belum ada siswa yang tertaut.</div>
    @endif

    
@endif

@endsection
