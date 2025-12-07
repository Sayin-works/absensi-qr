@extends('layouts.app')

@section('content')
<div class="container mt-4">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-3">
        <a href="{{ route('grades.index') }}" class="btn btn-secondary">⬅ Kembali</a>
    </div>

    <h4>Input Nilai Mapel {{ $subject->name }}</h4>

    <!-- Tab KD -->
    <ul class="nav nav-tabs mb-3">
        @for($kd=1; $kd<=8; $kd++)
            <li class="nav-item">
                <a class="nav-link {{ $kd==1 ? 'active' : '' }}" data-bs-toggle="tab" href="#kd{{ $kd }}">
                    KD {{ $kd }}
                </a>
            </li>
        @endfor
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#rekap">Rekap</a>
        </li>
    </ul>

    <form method="POST" action="{{ route('grades.store') }}">
        @csrf
        <input type="hidden" name="subject_id" value="{{ $subject->id }}">
        <input type="hidden" name="semester" value="Ganjil">

        <div class="tab-content">
            @for($kd=1; $kd<=8; $kd++)
                <div class="tab-pane fade {{ $kd==1 ? 'show active' : '' }}" id="kd{{ $kd }}">
                    <h5>KD {{ $kd }}</h5>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nama Siswa</th>
                                @for($t=1; $t<=5; $t++)
                                    <th>Tugas {{ $t }}</th>
                                @endfor
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($classes as $class)
                                @foreach($class->students as $student)
                                    @php
                                        $gradeKey = $grades->get($student->id.'_'.$class->id.'_'.$subject->id);
                                        $tasksVal = $gradeKey && $gradeKey->{'kd'.$kd}
                                                    ? json_decode($gradeKey->{'kd'.$kd}, true)
                                                    : [];
                                    @endphp
                                    <tr>
                                        <td>{{ $student->name }}</td>
                                        @for($t=0; $t<5; $t++)
                                            <td>
                                                <input type="number" class="form-control"
                                                    name="scores[{{ $kd }}][{{ $t }}][{{ $class->id }}][{{ $student->id }}]"
                                                    value="{{ $tasksVal[$t] ?? '' }}">
                                            </td>
                                        @endfor
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endfor

            <!-- Rekap -->
            <div class="tab-pane fade" id="rekap">
                <h5>Rekap Nilai</h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nama Siswa</th>
                            <th>Rata-rata KD (50%)</th>
                            <th>UTS (25%)</th>
                            <th>UAS (25%)</th>
                            <th>Nilai Akhir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($classes as $class)
                            @foreach($class->students as $student)
                                @php
                                    $gradeKey = $grades->get($student->id.'_'.$class->id.'_'.$subject->id);
                                    $totalKD = 0;
                                    $countKD = 0;
                                    for($kd=1; $kd<=8; $kd++){
                                        $arr = $gradeKey && $gradeKey->{'kd'.$kd}
                                                ? json_decode($gradeKey->{'kd'.$kd}, true)
                                                : [];
                                        $arr = is_array($arr) ? array_filter($arr, fn($n) => $n !== null) : [];
                                        if(count($arr)>0){
                                            $totalKD += array_sum($arr)/count($arr);
                                            $countKD++;
                                        }
                                    }
                                    $avgKD = $countKD > 0 ? $totalKD / $countKD : 0;
                                    $utsVal = $gradeKey->nilai_uts ?? 0;
                                    $uasVal = $gradeKey->nilai_uas ?? 0;
                                    $nilaiAkhir = ($avgKD * 0.5) + ($utsVal * 0.25) + ($uasVal * 0.25);
                                @endphp
                                <tr>
                                    <td>{{ $student->name }}</td>
                                    <td>
                                        <input type="number" class="form-control bg-light" readonly value="{{ number_format($avgKD,2) }}">
                                        <input type="hidden" name="nilai_tugas[{{ $class->id }}][{{ $student->id }}]" value="{{ $avgKD }}">
                                    </td>
                                    <td><input type="number" class="form-control" name="uts[{{ $class->id }}][{{ $student->id }}]" value="{{ $utsVal }}"></td>
                                    <td><input type="number" class="form-control" name="uas[{{ $class->id }}][{{ $student->id }}]" value="{{ $uasVal }}"></td>
                                    <td><input type="number" class="form-control bg-light" readonly value="{{ number_format($nilaiAkhir,2) }}"></td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <button type="submit" class="btn btn-success mt-3">💾 Simpan Nilai</button>
    </form>
</div>
@endsection
