<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Attendance;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RekapBulananExport;

class AttendanceController extends Controller
{
    /**
     * Menampilkan halaman scan QR
     */
    public function scanView()
    {
        return view('attendance.scan'); // nanti kita buat blade sederhana
    }
public function autoMarkAlpa()
{
    $today = Carbon::today()->toDateString();
    $now = Carbon::now();

    // Jalankan hanya setelah jam 12 siang
    if ($now->greaterThan(Carbon::createFromTime(12, 0, 0))) {
        $students = Student::all();

        foreach ($students as $student) {
            $attendance = Attendance::where('student_id', $student->id)
                ->where('date', $today)
                ->first();

            // Jika tidak ada absensi sama sekali
            if (!$attendance) {
                Attendance::create([
                    'student_id' => $student->id,
                    'date' => $today,
                    'status' => 'Alpa',
                    'check_in' => null,
                    'check_out' => null,
                    'keterangan' => 'Alpa'
                ]);
            } else {
                // Jika ada absensi tapi belum check_in
                if (is_null($attendance->check_in)) {
                    $attendance->update([
                        'status' => 'Alpa',
                        'keterangan' => 'Alpa'
                    ]);
                }
            }
        }
    }
}
public function autoMarkAlpaAndCheckout()
{
    $today = Carbon::today()->toDateString();
    $now = Carbon::now();

    // Jam batas untuk auto Alpa (tidak masuk pagi)
    $batasAlpa = Carbon::createFromTime(12, 0, 0);

    // Jam batas untuk auto check-out (pulang otomatis)
    $batasCheckout = Carbon::createFromTime(15, 0, 0);

    $students = Student::all();

    foreach ($students as $student) {
        $attendance = Attendance::where('student_id', $student->id)
            ->where('date', $today)
            ->first();

        // ✅ Jika tidak ada record absensi sama sekali
        if (!$attendance && $now->greaterThan($batasAlpa)) {
            Attendance::create([
                'student_id' => $student->id,
                'date' => $today,
                'status' => 'Alpa',
                'check_in' => null,
                'check_out' => null,
                'keterangan' => 'Alpa'
            ]);
            continue;
        }

        // ✅ Jika ada record tapi belum check_in setelah jam 12
        if ($attendance && is_null($attendance->check_in) && $now->greaterThan($batasAlpa)) {
            $attendance->update([
                'status' => 'Alpa',
                'keterangan' => 'Alpa'
            ]);
        }

        // ✅ Jika sudah check_in tapi belum check_out sampai jam 15
        if ($attendance && !is_null($attendance->check_in) && is_null($attendance->check_out) && $now->greaterThan($batasCheckout)) {
            $attendance->update([
                'check_out' => $batasCheckout->format('H:i:s') // otomatis set jam pulang
            ]);
        }
    }
}




    /**
     * Proses scan QR
     */
public function scanProcess(Request $request)
    {
        $qrCodeId = $request->qr_code_id;
        $student = Student::where('qr_code_id', $qrCodeId)->first();

        if (!$student) {
            return back()->with('error', 'QR Code tidak valid / Siswa tidak ditemukan');
        }

        $today = Carbon::today()->toDateString();
        $now = Carbon::now();
        $jamSekarang = $now->format('H:i:s');

        $attendance = Attendance::where('student_id', $student->id)
            ->where('date', $today)
            ->first();

        if (!$attendance) {
            // Check-in
            Attendance::create([
                'student_id' => $student->id,
                'date' => $today,
                'status' => 'Hadir',
                'check_in' => $jamSekarang
            ]);
            return back()->with('success', $student->name . ' berhasil absen masuk.');
        } else {
            // Check-out
            if (!$attendance->check_out) {
                if ($now->greaterThan(Carbon::createFromTime(8, 0, 0))) {
                    // Lewat jam 8, redirect ke form izin/sakit
                    return redirect()->route('attendance.reason', $attendance->id);
                } else {
                    // Check-out normal
                    $attendance->update([
                        'check_out' => $jamSekarang
                    ]);
                    return back()->with('success', $student->name . ' berhasil absen pulang.');
                }
            }
        }
    }

    public function rekapBulanan(Request $request)
{
    $bulan = $request->input('bulan', now()->format('m'));
    $tahun = $request->input('tahun', now()->format('Y'));
    $classId = $request->input('class_id');
    $tanggalMulai = $request->input('tanggal_mulai');
    $tanggalAkhir = $request->input('tanggal_akhir');

    $classes = \App\Models\Classroom::all();

    $rekap = \App\Models\Attendance::with('student.classroom')
        ->whereYear('date', $tahun)
        ->when($bulan, function ($q) use ($bulan) {
            $q->whereMonth('date', $bulan);
        })
        ->when($classId, function ($q) use ($classId) {
            $q->whereHas('student', function ($sq) use ($classId) {
                $sq->where('class_id', $classId);
            });
        })
        ->when($tanggalMulai && $tanggalAkhir, function ($q) use ($tanggalMulai, $tanggalAkhir) {
            $q->whereBetween('date', [$tanggalMulai, $tanggalAkhir]);
        })
        ->get();

    return view('attendance.rekap-bulanan', compact('rekap', 'classes', 'bulan', 'tahun', 'classId'));
}


public function reasonForm($id)
    {
        $attendance = Attendance::findOrFail($id);
        return view('attendance.reason', compact('attendance'));
    }

public function saveReason(Request $request, $id)
    {
        $attendance = Attendance::findOrFail($id);
        $request->validate([
            'keterangan' => 'required|in:Izin,Sakit,Hadir'
        ]);

        $attendance->update([
            'check_out' => Carbon::now()->format('H:i:s'),
            'keterangan' => $request->keterangan
        ]);

        return redirect()->route('attendance.scan')->with('success', 'Keterangan berhasil disimpan.');
    }





public function downloadRekapBulanan(Request $request)
{
    $bulan = $request->bulan ?? now()->format('m');
    $kelas = $request->kelas ?? null;

    return Excel::download(new RekapBulananExport($bulan, $kelas), 'Rekap-Bulanan.xlsx');
}
}
