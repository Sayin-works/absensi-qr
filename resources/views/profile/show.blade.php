@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4"><i class="fas fa-user"></i> Profil Saya</h4>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card mb-3">
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">Nama Lengkap</dt>
                <dd class="col-sm-9">{{ $user->name }}</dd>

                <dt class="col-sm-3">Email</dt>
                <dd class="col-sm-9">{{ $user->email }}</dd>

                <dt class="col-sm-3">No. HP</dt>
                <dd class="col-sm-9">{{ $user->phone ?? '-' }}</dd>

                <dt class="col-sm-3">Peran</dt>
                <dd class="col-sm-9">{{ ucfirst($user->role) }}</dd>

                @if($user->role === 'guru')
                    <dt class="col-sm-3">Sebagai Guru Mapel?</dt>
                    <dd class="col-sm-9">{{ $user->is_subject_teacher ? 'Ya' : 'Tidak' }}</dd>

                    <dt class="col-sm-3">Sebagai Wali Kelas?</dt>
                    <dd class="col-sm-9">{{ $user->is_homeroom_teacher ? 'Ya' : 'Tidak' }}</dd>

                    @if($user->subjects && $user->subjects->count())
                        <dt class="col-sm-3">Mata Pelajaran</dt>
                        <dd class="col-sm-9">
                            <ul class="mb-0">
                                @foreach($user->subjects as $subject)
                                    <li>{{ $subject->name }}</li>
                                @endforeach
                            </ul>
                        </dd>
                    @endif

                    @if($user->class)
                        <dt class="col-sm-3">Wali dari Kelas</dt>
                        <dd class="col-sm-9">{{ $user->class->name }}</dd>
                    @endif
                @endif

                @if($user->role === 'wali')
                    <dt class="col-sm-3">Anak Tertaut</dt>
                    <dd class="col-sm-9">
                        @if($user->student)
                            {{ $user->student->name }} ({{ $user->student->nisn }})
                        @else
                            Belum tertaut
                        @endif
                    </dd>
                @endif
            </dl>

            <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                <i class="fas fa-edit"></i> Edit Profil
            </a>
        </div>
    </div>
</div>
@endsection
