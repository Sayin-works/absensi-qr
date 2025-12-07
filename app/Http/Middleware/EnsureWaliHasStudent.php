<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;

class EnsureWaliHasStudent
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user && $user->role === 'walimurid') {
            $hasStudent = Student::where('walimurid_id', $user->id)->exists();

            if (! $hasStudent && $request->path() !== 'tautkan-siswa') {
                return redirect('/tautkan-siswa');
            }
        }

        return $next($request);
    }
}
