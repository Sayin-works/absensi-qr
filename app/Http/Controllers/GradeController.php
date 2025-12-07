<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grade;
use App\Models\Subject;

class GradeController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $subjects = $user->subjects;
        $classes = $user->classes;
        
        $grades = Grade::with(['student', 'subject', 'class'])
            ->whereIn('subject_id', $subjects->pluck('id'))
            ->whereIn('class_id', $classes->pluck('id'))
            ->get();

        return view('grades.index', compact('grades', 'subjects', 'classes'));
    }

    public function create($subjectId)
    {
        $subject = Subject::findOrFail($subjectId);
        $classes = auth()->user()->classes()->with('students')->get();

        // Ambil nilai lama dari DB dengan key berdasarkan student_id, class_id, dan subject_id
        $grades = Grade::where('subject_id', $subjectId)
            ->whereIn('class_id', $classes->pluck('id'))
            ->get()
            ->keyBy(function ($item) {
                return $item->student_id.'_'.$item->class_id.'_'.$item->subject_id;
            });

        // Default KD 8 × 5 tugas
        $kdsData = [];
        for ($kd = 1; $kd <= 8; $kd++) {
            $tasks = [];
            for ($t = 1; $t <= 5; $t++) {
                $tasks[] = "Tugas $t";
            }
            $kdsData[] = [
                'name' => "KD $kd",
                'tasks' => $tasks
            ];
        }

        return view('grades.create', compact('subject', 'classes', 'grades', 'kdsData'));
    }


    public function store(Request $request)
    {
        $subjectId  = $request->input('subject_id');
        $semester   = $request->input('semester', 'Ganjil');

        $scores     = $request->input('scores', []);       // scores[kd][task][classId][studentId]
        $uts        = $request->input('uts', []);
        $uas        = $request->input('uas', []);
        $nilaiTugas = $request->input('nilai_tugas', []);  // rata-rata KD dari Rekap

        foreach ($nilaiTugas as $classId => $students) {
            foreach ($students as $studentId => $avgKD) {

                // Ambil nilai UTS & UAS
                $nilaiUTS = $uts[$classId][$studentId] ?? 0;
                $nilaiUAS = $uas[$classId][$studentId] ?? 0;

                // Hitung nilai akhir
                $nilaiAkhir = ($avgKD * 0.5) + ($nilaiUTS * 0.25) + ($nilaiUAS * 0.25);

                // Simpan nilai KD (JSON untuk tiap KD)
                $kdData = [];
                for ($kd = 1; $kd <= 8; $kd++) {
                    $nilaiKD = [];
                    for ($t = 0; $t < 5; $t++) {
                        $nilaiKD[] = $scores[$kd][$t][$classId][$studentId] ?? null;
                    }
                    $kdData["kd$kd"] = json_encode($nilaiKD);
                }

                // Simpan ke database
                Grade::updateOrCreate(
                    [
                        'student_id' => $studentId,
                        'subject_id' => $subjectId,
                        'class_id'   => $classId,
                        'semester'   => $semester,
                    ],
                    array_merge($kdData, [
                        'nilai_tugas' => round($avgKD, 2),
                        'nilai_uts'   => $nilaiUTS,
                        'nilai_uas'   => $nilaiUAS,
                        'nilai_akhir' => round($nilaiAkhir, 2),
                    ])
                );
            }
        }

        return redirect()->route('grades.index')->with('success', 'Nilai berhasil disimpan!');
    }
}
