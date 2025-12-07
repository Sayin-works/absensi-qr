<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;



class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::with('teachers')->get();
        return view('subjects.index', compact('subjects'));
    }


public function create()
{
    $teachers = User::where('role', 'guru')->get();
    return view('subjects.create', compact('teachers'));
}

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Menyimpan mata pelajaran baru
        $subject = new Subject();
        $subject->name = $request->name;
        $subject->save();

        return redirect()->route('subjects.index')->with('success', 'Mata pelajaran berhasil ditambahkan.');
    }

    public function edit(Subject $subject)
    {
        $teachers = User::where('role', 'guru')->get();
        $assignedTeachers = $subject->teachers->pluck('id')->toArray();

        return view('subjects.edit', compact('subject', 'teachers', 'assignedTeachers'));
    }

    public function update(Request $request, Subject $subject)
    {
        $request->validate(['name' => 'required|string']);
        $subject->update($request->only('name'));
        return redirect()->route('subjects.index')->with('success', 'Mata pelajaran diperbarui');
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();
        return back()->with('success', 'Mata pelajaran dihapus');
    }

    public function assignTeachers(Request $request, Subject $subject)
    {
        $subject->teachers()->sync($request->teacher_ids ?? []);
        return back()->with('success', 'Guru berhasil di-assign ke mata pelajaran');
    }
}
