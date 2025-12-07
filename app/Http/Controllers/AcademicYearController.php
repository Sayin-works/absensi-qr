<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use Illuminate\Http\Request;

class AcademicYearController extends Controller
{
    public function records()
    {
        // Tampilkan view absensi, contoh:
        return view('attendance.records');
    }

    public function index()
    {
        $years = AcademicYear::orderByDesc('year')->get();
        return view('academic_years.index', compact('years'));
    }

    public function create()
    {
        return view('academic_years.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'year' => 'required|string|unique:academic_years,year'
        ]);

        AcademicYear::create([
            'year' => $request->year,
            'is_active' => false
        ]);

        return redirect()->route('academic-years.index')->with('success', 'Tahun ajaran ditambahkan.');
    }

    public function activate(AcademicYear $academicYear)
    {
        // Matikan semua dulu
        AcademicYear::where('is_active', true)->update(['is_active' => false]);

        // Aktifkan yang dipilih
        $academicYear->update(['is_active' => true]);

        return back()->with('success', 'Tahun ajaran berhasil diaktifkan.');
    }
}
