@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="mx-auto" style="max-width: 100%; width: 480px;">
        <div class="card shadow-sm rounded-4">
            <div class="card-body px-4 py-3">
                <h5 class="text-center mb-4">Tambah Data Siswa</h5>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0 small">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control form-control-sm" value="{{ old('name') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">NISN</label>
                        <input type="text" name="nisn" class="form-control form-control-sm" value="{{ old('nisn') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jenis Kelamin</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" value="L" {{ old('gender') == 'L' ? 'checked' : '' }}>
                            <label class="form-check-label small">Laki-laki</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" value="P" {{ old('gender') == 'P' ? 'checked' : '' }}>
                            <label class="form-check-label small">Perempuan</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tempat Lahir</label>
                        <input type="text" name="birth_place" class="form-control form-control-sm" value="{{ old('birth_place') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" name="birth_date" class="form-control form-control-sm" value="{{ old('birth_date') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea name="address" rows="2" class="form-control form-control-sm">{{ old('address') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Agama</label>
                        <select name="religion" class="form-select form-select-sm">
                            <option value="">Pilih Agama</option>
                            @foreach (['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'] as $agama)
                                <option value="{{ $agama }}" {{ old('religion') == $agama ? 'selected' : '' }}>{{ $agama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">No HP Orang Tua</label>
                        <input type="text" name="phone" class="form-control form-control-sm" value="{{ old('phone') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kelas</label>
                        <select name="class_id" class="form-select form-select-sm" required>
                            <option value="">Pilih Kelas</option>
                            @foreach ($classes as $class)
                                <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                    {{ $class->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

<div class="mb-3">
    <label class="form-label">QR Code ID</label>
    <input type="text" name="qr_code_id" id="qr_code_id" class="form-control form-control-sm" value="{{ old('qr_code_id') }}" required readonly>
</div>


                    <div class="mb-3">
                        <label class="form-label">Foto Siswa</label>
                        <input type="file" name="photo" class="form-control form-control-sm">
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                        <a href="{{ route('students.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function generateRandomQR() {
        const charset = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        let qr = "";
        for (let i = 0; i < 10; i++) {
            qr += charset.charAt(Math.floor(Math.random() * charset.length));
        }
        document.getElementById('qr_code_id').value = qr;
    }

    // Generate QR code saat halaman dimuat
    document.addEventListener("DOMContentLoaded", generateRandomQR);
</script>
@endpush

@endsection
