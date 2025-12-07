<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    public function index()
    {
        $classes = Classroom::all();
        return view('classes.index', compact('classes'));
    }

    public function scan(Classroom $class)
{
    $students = $class->students; // ambil siswa di kelas
    return view('class_attendance.scan', compact('class', 'students'));
}

    public function updateWaliKelas(Request $request, $id)
    {
        $request->validate([
            'walikelas' => 'nullable|string|max:255'
        ]);

        $class = Classroom::findOrFail($id);
        $class->walikelas = $request->walikelas;
        $class->save();

        return redirect()->route('classes.index')->with('success', 'Wali kelas berhasil diperbarui.');
    }
}
