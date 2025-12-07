<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use Carbon\Carbon;

class StatisticsController extends Controller
{
    public function attendance()
    {
        // Contoh: Ambil total kehadiran per status dalam bulan ini
        $data = Attendance::selectRaw('status, COUNT(*) as total')
                    ->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
                    ->groupBy('status')
                    ->pluck('total', 'status');

        return view('statistics.attendance', compact('data'));
    }
}
