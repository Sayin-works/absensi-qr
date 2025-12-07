@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Isi Keterangan</h4>
    <form action="{{ route('attendance.reason.save', $attendance->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Pilih Keterangan:</label>
            <select name="keterangan" class="form-control">
                <option value="Hadir">Hadir</option>
                <option value="Izin">Izin</option>
                <option value="Sakit">Sakit</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
