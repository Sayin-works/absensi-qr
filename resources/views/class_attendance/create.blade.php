@extends('layouts.app')

@section('content')
@php
    $today = now()->toDateString();
@endphp

@foreach($students as $index => $student)
    @php
        $attendance = \App\Models\ClassAttendance::where('student_id', $student->id)
            ->where('class_id', $class->id)
            ->where('date', $today)
            ->first();
        $selectedStatus = $attendance->status ?? '';
    @endphp
    <tr>
        <td>{{ $index + 1 }}</td>
        <td>{{ $student->name }}</td>
        <td>
            <select name="attendance[{{ $student->id }}]" class="form-select">
                <option value="Hadir" {{ $selectedStatus == 'Hadir' ? 'selected' : '' }}>Hadir</option>
                <option value="Izin" {{ $selectedStatus == 'Izin' ? 'selected' : '' }}>Izin</option>
                <option value="Sakit" {{ $selectedStatus == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                <option value="Alpa" {{ $selectedStatus == 'Alpa' ? 'selected' : '' }}>Alpa</option>
            </select>
        </td>
    </tr>
@endforeach

@endsection
