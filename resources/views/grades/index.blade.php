@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h4>Daftar Nilai</h4>

    {{-- Tombol Input Nilai untuk setiap mapel --}}
    @foreach($subjects as $subject)
        <a href="{{ route('grades.create', $subject->id) }}" class="btn btn-primary mb-2">
            Input Nilai {{ $subject->name }}
        </a>
    @endforeach

    {{-- Cek jika ada nilai --}}
    @if($grades->count())
    <div class="table-responsive" style="overflow-x: auto;">
        <table class="table table-bordered" style="min-width: 1500px; position: relative;">
            <thead>
                <tr>
                    <th style="position: sticky; left: 0; background: white; z-index: 2;">Siswa</th>
                    <th style="position: sticky; left: 120px; background: white; z-index: 2;">Mapel</th>

                    @php
                        $maxTugas = 0;
                        foreach($grades as $g) {
                            $tugasArr = json_decode($g->nilai_tugas, true);

                            // Pastikan jadi array walaupun nilainya angka
                            if (!is_array($tugasArr)) {
                                $tugasArr = [$tugasArr];
                            }

                            $maxTugas = max($maxTugas, count($tugasArr));
                        }
                    @endphp

                    {{-- Header Tugas --}}
                    @for($i = 1; $i <= $maxTugas; $i++)
                        <th>Tugas {{ $i }}</th>
                    @endfor

                    <th>UTS</th>
                    <th>UAS</th>
                    <th>Nilai Akhir</th>
                </tr>
            </thead>
            <tbody>
                @foreach($grades as $grade)
                    @php
                        $tugasArr = json_decode($grade->nilai_tugas, true);
                        if (!is_array($tugasArr)) {
                            $tugasArr = [$tugasArr];
                        }
                    @endphp
                    <tr>
                        <td style="position: sticky; left: 0; background: white; z-index: 1;">
                            {{ $grade->student->name ?? '-' }}
                        </td>
                        <td style="position: sticky; left: 120px; background: white; z-index: 1;">
                            {{ $grade->subject->name ?? '-' }}
                        </td>

                        {{-- Nilai Tugas --}}
                        @for($i = 0; $i < $maxTugas; $i++)
                            <td>{{ $tugasArr[$i] ?? '-' }}</td>
                        @endfor

                        {{-- UTS --}}
                        <td>{{ $grade->nilai_uts ?? '-' }}</td>

                        {{-- UAS --}}
                        <td>{{ $grade->nilai_uas ?? '-' }}</td>

                        {{-- Nilai Akhir --}}
                        <td>{{ number_format($grade->nilai_akhir, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
        <p class="text-muted mt-3">Belum ada data nilai.</p>
    @endif
</div>
@endsection
