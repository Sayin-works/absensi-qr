<?php

namespace App\Http\Controllers;

use App\Models\ClassAttendance;
use App\Models\Classroom;
use App\Models\Student;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class ClassAttendanceController extends Controller
{
    // Form pilih kelas
    public function scanView($classId)
{
    $class = \App\Models\Classroom::findOrFail($classId);
    return view('class_attendance.scan', compact('class'));
}

public function scan(Request $request)
{
    $request->validate([
        'qr_code_id' => 'required|string'
    ]);

    $student = \App\Models\Student::where('qr_code_id', $request->qr_code_id)->first();

    if (!$student) {
        return response()->json(['message' => 'Siswa tidak ditemukan'], 404);
    }

    // Simpan absensi
    \App\Models\ClassAttendance::create([
        'class_id'   => $student->class_id,
        'student_id' => $student->id,
        'date'       => now()->toDateString(),
        'status'     => 'Hadir'
    ]);

    return response()->json(['message' => 'Absensi berhasil disimpan untuk ' . $student->name]);
}

public function index()
{
    $user = auth()->user();

    // Pastikan dia wali kelas
    if (!$user->is_homeroom_teacher || !$user->class_id) {
        abort(403, 'Anda tidak memiliki kelas yang diwalikan.');
    }

    // Ambil kelas wali yang dia pegang
    $class = $user->class;

    // Ambil daftar siswa di kelas itu
    $students = $class->students;

    return view('attendance.class-index', compact('class', 'students'));
}


    // Form input absensi berdasarkan kelas
    public function create(Request $request)
    {
        $classId = $request->class_id;
        $class = Classroom::findOrFail($classId);
        $students = Student::where('class_id', $classId)->get();

        return view('class_attendance.create', compact('class', 'students'));
    }

    // Simpan absensi per kelas
public function store(Request $request)
{
    $user = auth()->user();

    // Pastikan hanya wali kelas kelasnya sendiri
    $classId = $user->class_id;

    $attendanceData = $request->attendance; // array: student_id => status

    foreach ($attendanceData as $studentId => $status) {
        ClassAttendance::updateOrCreate(
            [
                'student_id' => $studentId,
                'class_id' => $classId,
                'date' => now()->toDateString(),
            ],
            [
                'status' => $status,
                'note' => null,
            ]
        );
    }

    return redirect()->route('class_attendance.index')
        ->with('success', 'Absensi kelas berhasil disimpan.');
}

public function rekap()
{
    $user = auth()->user();
    $class = $user->class;
    $attendances = ClassAttendance::where('class_id', $class->id)
        ->orderBy('date', 'desc')
        ->get()
        ->groupBy('date');

    return view('class_attendance.rekap', compact('class', 'attendances'));
}

public function edit($date)
{
    $user = auth()->user();
    $class = $user->class;
    $students = $class->students;
    $attendances = ClassAttendance::where('class_id', $class->id)
        ->where('date', $date)
        ->get()
        ->keyBy('student_id');

    return view('class_attendance.edit', compact('class', 'students', 'attendances', 'date'));
}

public function update(Request $request, $date)
{
    $classId = auth()->user()->class_id;
    foreach ($request->attendance as $studentId => $status) {
        ClassAttendance::updateOrCreate(
            ['student_id' => $studentId, 'class_id' => $classId, 'date' => $date],
            ['status' => $status]
        );
    }
    return redirect()->route('class_attendance.rekap')->with('success', 'Absensi berhasil diperbarui.');
}

public function download($date)
{
    $user = auth()->user();
    $class = $user->class;
    $attendances = ClassAttendance::where('class_id', $class->id)
        ->where('date', $date)
        ->get();

    $pdf = Pdf::loadView('class_attendance.pdf', compact('class', 'date', 'attendances'));
    
    return $pdf->download("Rekap_Absensi_{$class->name}_{$date}.pdf");
}
}
