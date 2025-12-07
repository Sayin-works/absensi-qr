<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
{
    $user = Auth::user();

    // Jika Wali Murid
    if ($user->role === 'walimurid') {
        // Ambil semua anak yang tertaut ke wali murid ini
        $children = Student::where('walimurid_id', $user->id)
            ->with(['classroom', 'grades.subject', 'attendances'])
            ->get();

        return view('dashboard', compact('user', 'children'));
    }

    // Jika role lain
    return view('dashboard', compact('user'));
}
}
