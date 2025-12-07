<?php

namespace App\Http\Controllers;

use App\Models\SubjectAttendance;
use App\Models\Student;
use App\Models\Classroom;
use App\Models\Subject;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\SubjectAttendanceExport;

class SubjectAttendanceController extends Controller
{
public function index()
{
    $user = auth()->user();

    $subjects = $user->subjects; // semua mapel guru
    $classes = $user->classes;   // semua kelas guru

    // Ambil semua absensi mapel milik guru ini
    $attendances = \App\Models\SubjectAttendance::with(['subject', 'classroom'])
        ->whereIn('subject_id', $subjects->pluck('id'))
        ->whereIn('class_id', $classes->pluck('id'))
        ->orderBy('date', 'desc')
        ->get();

    return view('subject_attendance.index', compact('subjects', 'classes', 'attendances'));
}


    public function create(Request $request)
    {
        $subjectId = $request->subject_id;
        $classId = $request->class_id;

        $subject = Subject::findOrFail($subjectId);
        $class = Classroom::findOrFail($classId);
        $students = Student::where('class_id', $classId)->get();

        return view('subject_attendance.create', compact('subject', 'class', 'students'));
    }

    public function store(Request $request)
    {
        foreach ($request->attendance as $studentId => $status) {
            SubjectAttendance::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'subject_id' => $request->subject_id,
                    'class_id' => $request->class_id,
                    'date' => now()->toDateString(),
                ],
                [
                    'status' => $status,
                    'note' => null,
                ]
            );
        }

        return redirect()->route('subject_attendance.index')->with('success', 'Absensi mapel berhasil disimpan.');
    }

    public function download($format)
{
    $user = auth()->user();
    $subjects = $user->subjects;
    $classes = $user->classes;

    $attendances = \App\Models\SubjectAttendance::with(['subject', 'classroom'])
        ->whereIn('subject_id', $subjects->pluck('id'))
        ->whereIn('class_id', $classes->pluck('id'))
        ->orderBy('date', 'desc')
        ->get();

    if ($format === 'excel') {
        return Excel::download(new SubjectAttendanceExport($attendances), 'absensi_mapel.xlsx');
    }

    if ($format === 'pdf') {
        $pdf = Pdf::loadView('subject_attendance.pdf', compact('attendances'));
        return $pdf->download('absensi_mapel.pdf');
    }

    return back()->with('error', 'Format tidak valid.');
}

public function show($id)
{
    $attendance = SubjectAttendance::with(['subject', 'classroom', 'details.student'])
        ->findOrFail($id);

    return view('subject_attendance.show', compact('attendance'));
}

}
