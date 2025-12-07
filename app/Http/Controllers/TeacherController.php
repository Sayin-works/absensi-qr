<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Subject;
use App\Models\Classroom;



class TeacherController extends Controller
{
public function index()
{
    $teachers = User::where('role', 'guru')
        ->with(['subjects', 'class']) // pastikan juga 'class' kalau dipakai
        ->paginate(30);

    return view('teachers.index', compact('teachers'));
}



public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'subject_id' => 'nullable|array',
        'subject_id.*' => 'exists:subjects,id',
        'class_id' => 'nullable|exists:classes,id',
    ]);

    $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'role' => 'guru',
        'password' => bcrypt('password'), // password default
        'class_id' => $request->class_id,
        'is_subject_teacher' => $request->has('is_subject_teacher'),
        'is_homeroom_teacher' => $request->has('is_homeroom_teacher'),
    ]);

    // Simpan relasi many-to-many ke subject_user
    if ($request->has('subject_id')) {
        $user->subjects()->sync($request->subject_id);
    }

    return redirect()->route('teachers.index')->with('success', 'Guru berhasil ditambahkan.');
}




public function update(Request $request, Teacher $teacher)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'is_subject_teacher' => 'nullable|boolean',
        'is_homeroom_teacher' => 'nullable|boolean',
        'subject_id' => 'nullable|array',
        'subject_id.*' => 'exists:subjects,id',
        'class_id' => 'nullable|exists:classes,id',
    ]);

    // Update data guru
    $teacher->update([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'is_subject_teacher' => $request->has('is_subject_teacher'),
        'is_homeroom_teacher' => $request->has('is_homeroom_teacher'),
        'class_id' => $validated['class_id'] ?? null,
    ]);

    // Simpan relasi mata pelajaran (pivot table)
    if (!empty($validated['subject_id'])) {
        $teacher->subjects()->sync($validated['subject_id']);
    } else {
        $teacher->subjects()->detach(); // kosongkan kalau tidak ada pilihan
    }

    return redirect()->route('teachers.index')->with('success', 'Data guru berhasil diperbarui');
}



public function create()
{
    $subjects = Subject::all();
    $classes = Classroom::all();

    return view('teachers.create', compact('subjects', 'classes'));
}



public function edit($id)
{
    $teacher = User::where('role', 'guru')->findOrFail($id);
    $subjects = Subject::all();
    $classes = Classroom::all(); // Pastikan model Classroom sudah ada
    return view('teachers.edit', compact('teacher', 'subjects', 'classes'));
}


public function destroy($id)
{
    $teacher = User::findOrFail($id);

    // Pastikan hanya user dengan role guru yang bisa dihapus
    if ($teacher->role !== 'guru') {
        return redirect()->route('teachers.index')->with('error', 'Hanya guru yang dapat dihapus.');
    }

    // Hapus relasi ke tabel pivot subject_user (jika ada)
    $teacher->subjects()->detach();

    // Hapus guru dari tabel users
    $teacher->delete();

    return redirect()->route('teachers.index')->with('success', 'Data guru berhasil dihapus.');
}


}
