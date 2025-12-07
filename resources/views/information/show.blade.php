@extends('layouts.app')

@section('content')
<div class="container py-5">

    {{-- Tombol kembali --}}
@auth
    @if(Auth::user()->role === 'admin')
        <a href="{{ route('information.index') }}" class="btn btn-outline-secondary mb-4">
            ← Kembali ke Daftar Informasi
        </a>
    @endif
@endauth


    {{-- Judul dan Tanggal --}}
    <h2 class="fw-bold text-primary">{{ $info->title }}</h2>
    @if($info->date)
        <p class="text-muted mb-4">
            <i class="bi bi-calendar-event"></i> 
            {{ \Carbon\Carbon::parse($info->date)->translatedFormat('d F Y') }}
        </p>
    @endif

    {{-- Gambar --}}
    @if($info->image)
        <div class="mb-4 text-center">
            <img src="{{ asset('storage/' . $info->image) }}" alt="{{ $info->title }}" class="img-fluid rounded shadow" style="max-height: 400px;">
        </div>
    @endif

    {{-- Konten --}}
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="content" style="line-height: 1.8; font-size: 1.1rem;">
                {!! $info->content !!}
            </div>
        </div>
    </div>

</div>
@endsection
