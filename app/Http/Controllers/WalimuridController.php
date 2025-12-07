<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

class WalimuridController extends Controller
{
    public function tautkanForm()
    {
        $students = Student::whereNull('walimurid_id')->with('classroom')->get();
        return view('tautkan-siswa', compact('students'));
    }


    public function tautkanSimpan(Request $request)
    {
        $request->validate([
            'qr_code_id' => 'required|string'
        ]);

        $student = Student::where('qr_code_id', $request->qr_code_id)->first();

        if (!$student) {
            return back()->with('error', 'Siswa tidak ditemukan.');
        }

        if ($student->walimurid_id) {
            return back()->with('error', 'Siswa sudah tertaut.');
        }

        $student->walimurid_id = auth()->id();
        $student->save();

        return redirect('/')->with('success', 'Berhasil menautkan akun dengan siswa.');
    }

    public function statistics()
    {
        $user = Auth::user();

        // Ambil siswa yang ditautkan ke wali murid
        $student = Student::where('walimurid_id', $user->id)->with('classroom')->first();

        if (!$student) {
            return redirect('/')->with('error', 'Belum ada siswa yang tertaut.');
        }

        // Ambil data kehadiran siswa
        $attendances = $student->attendances()
            ->orderBy('date', 'desc')
            ->take(30) // Ambil 30 hari terakhir (atau semua jika ingin)
            ->get();

        // Hitung ringkasan statistik
        $statistik = [
            'hadir' => $attendances->where('status', 'Hadir')->count(),
            'izin' => $attendances->where('status', 'Izin')->count(),
            'sakit' => $attendances->where('status', 'Sakit')->count(),
            'alpha' => $attendances->where('status', 'Alpha')->count(),
            'total' => $attendances->count(),
        ];

        return view('walimurid.statistics', compact('student', 'attendances', 'statistik'));
    }

}
