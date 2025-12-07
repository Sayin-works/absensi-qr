<form method="POST" action="{{ route('subjects.assignTeachers', $subject) }}">
    @csrf
    <label>Pilih Guru:</label>
    @foreach ($teachers as $teacher)
        <div>
            <input type="checkbox" name="teacher_ids[]" value="{{ $teacher->id }}"
                {{ in_array($teacher->id, $assignedTeachers) ? 'checked' : '' }}>
            {{ $teacher->name }}
        </div>
    @endforeach
    <button type="submit">Simpan</button>
</form>
