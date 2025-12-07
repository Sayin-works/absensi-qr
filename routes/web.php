<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Attendance;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\WalimuridController;
use App\Http\Controllers\StudentImportController;
use App\Http\Controllers\StudentTemplateController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\AcademicYearController;
use App\Http\Controllers\TeacherImportController;
use App\Http\Controllers\InformationController;
use App\Models\SchoolInfo;
use App\Http\Controllers\ClassAttendanceController;
use App\Http\Controllers\SubjectAttendanceController;
use App\Http\Controllers\GradeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ========== PUBLIC ==========

Route::get('information/{id}', [InformationController::class, 'show'])->name('information.show');
Route::get('/information/{id}', [App\Http\Controllers\InformationController::class, 'show'])->name('information.show');

Route::get('/', function () {
    $infos = SchoolInfo::orderBy('date', 'desc')->take(5)->get();
    return view('welcome', compact('infos'));
});

Route::get('/students/cards/all', [StudentController::class, 'downloadAllCards'])->name('students.cards.all');

// ========== AUTH + VERIFIED ==========
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard (Redirect handled by middleware)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');
Route::get('/classes', [ClassroomController::class, 'index'])->name('classes.index')->middleware(['auth', 'can:admin']);
Route::post('/classes/{id}/update-walikelas', [ClassroomController::class, 'updateWaliKelas'])->name('classes.updateWaliKelas')->middleware(['auth', 'can:admin']);


//route admin
Route::middleware(['auth', 'can:admin'])->group(function () {
    Route::resource('/admin/informations', InformationController::class);
    Route::get('/teachers', [TeacherController::class, 'index'])->name('teachers.index');
    Route::get('/teachers/create', [TeacherController::class, 'create'])->name('teachers.create'); // <== tambahkan ini
    Route::post('/teachers', [TeacherController::class, 'store'])->name('teachers.store');
    Route::get('/teachers/{id}/edit', [TeacherController::class, 'edit'])->name('teachers.edit');
    Route::put('/teachers/{id}', [TeacherController::class, 'update'])->name('teachers.update');
    Route::delete('/teachers/{id}', [TeacherController::class, 'destroy'])->name('teachers.destroy');
    
    Route::resource('school-infos', SchoolInfoController::class);
    Route::resource('information', InformationController::class);

    Route::resource('subjects', SubjectController::class);
    Route::post('subjects/{subject}/assign-teachers', [SubjectController::class, 'assignTeachers'])->name('subjects.assignTeachers');
    Route::post('/teaching-assignments', [TeachingAssignmentController::class, 'store'])->name('teaching.assign');
    Route::get('subjects/create', [SubjectController::class, 'create'])->name('subjects.create');
    Route::post('subjects', [SubjectController::class, 'store'])->name('subjects.store');

    Route::get('academic-years', [AcademicYearController::class, 'index'])->name('academic-years.index');
    Route::get('academic-years/create', [AcademicYearController::class, 'create'])->name('academic-years.create');
    Route::post('academic-years', [AcademicYearController::class, 'store'])->name('academic-years.store');
    Route::post('academic-years/{academicYear}/activate', [AcademicYearController::class, 'activate'])->name('academic-years.activate');

    // Statistics
    Route::get('/statistics/attendance', [StatisticsController::class, 'attendance'])->name('statistics.attendance');

    // Teacher Import
    Route::get('/teachers/import', [TeacherImportController::class, 'showForm'])->name('teachers.import.form');
    Route::post('/teachers/import', [TeacherImportController::class, 'import'])->name('teachers.import');
    Route::get('/teachers/template', [TeacherImportController::class, 'template'])->name('teachers.template');


});
// Rekap Bulanan
Route::get('/rekap-bulanan', [AttendanceController::class, 'rekapBulanan'])
    ->name('attendance.rekap.bulanan');

// Download Rekap Bulanan (Excel)
Route::get('/rekap-bulanan/download', [AttendanceController::class, 'downloadRekapBulanan'])
    ->name('attendance.rekap.bulanan.download');

// Untuk guru
Route::middleware(['auth', 'can:guru'])->group(function () {
                
    Route::get('/attendance/scan', [AttendanceController::class, 'scanView'])->name('attendance.scan');
    Route::post('/attendance/scan/process', [AttendanceController::class, 'scanProcess'])->name('attendance.scan.process');});
    Route::get('/attendance/reason/{id}', [AttendanceController::class, 'reasonForm'])->name('attendance.reason');
    Route::post('/attendance/reason/{id}', [AttendanceController::class, 'saveReason'])->name('attendance.reason.save');

    Route::get('/rekap-bulanan', [AttendanceController::class, 'rekapBulanan'])
    ->name('attendance.rekap.bulanan')
    ->middleware(['auth', 'can:admin']);
    Route::get('/subject-attendance/download/{format}', [SubjectAttendanceController::class, 'download'])
    ->name('subject_attendance.download');
Route::get('/subject-attendance/{id}', [SubjectAttendanceController::class, 'show'])
    ->name('subject_attendance.show');
Route::get('/subject-attendance/{id}/edit', [SubjectAttendanceController::class, 'edit'])
    ->name('subject_attendance.edit');
Route::middleware(['auth', 'can:guru'])->group(function () {
    Route::resource('grades', GradeController::class);
    Route::get('/grades/create/{subject}', [GradeController::class, 'create'])->name('grades.create');

});


// Tampilkan profil
// Proses update profil
Route::middleware(['auth', 'can:guru'])->group(function () {
    Route::get('/class-attendance', [ClassAttendanceController::class, 'index'])->name('class_attendance.index');
    Route::get('/class-attendance/create', [ClassAttendanceController::class, 'create'])->name('class_attendance.create');
    Route::post('/class-attendance/store', [ClassAttendanceController::class, 'store'])->name('class_attendance.store');
});
Route::middleware(['auth', 'can:guru'])->group(function () {
    Route::get('/class-attendance', [ClassAttendanceController::class, 'index'])->name('class_attendance.index');
    Route::post('/class-attendance/store', [ClassAttendanceController::class, 'store'])->name('class_attendance.store');

    // Rekap & Edit
    Route::get('/class-attendance/rekap', [ClassAttendanceController::class, 'rekap'])->name('class_attendance.rekap');
    Route::get('/class-attendance/edit/{date}', [ClassAttendanceController::class, 'edit'])->name('class_attendance.edit');
    Route::post('/class-attendance/update/{date}', [ClassAttendanceController::class, 'update'])->name('class_attendance.update');
    Route::put('/class-attendance/update/{date}', [ClassAttendanceController::class, 'update'])
    ->name('class_attendance.update');
    Route::get('/class-attendance/download/{date}', [ClassAttendanceController::class, 'download'])
    ->name('class_attendance.download');
Route::middleware(['auth', 'can:guru'])->group(function () {
    Route::get('/subject-attendance', [SubjectAttendanceController::class, 'index'])->name('subject_attendance.index');
    Route::get('/subject-attendance/create', [SubjectAttendanceController::class, 'create'])->name('subject_attendance.create');
    Route::post('/subject-attendance/store', [SubjectAttendanceController::class, 'store'])->name('subject_attendance.store');
});

});



// ========== AUTH ==========
Route::middleware('auth')->group(function () {

        // Halaman untuk melihat data kehadiran oleh guru/petugas
    Route::get('/attendance/records', [AttendanceController::class, 'records'])
        ->name('attendance.records');

    // ========== WALIMURID ==========
        Route::get('/tautkan-siswa', [App\Http\Controllers\WalimuridController::class, 'tautkanForm'])->name('tautkan.form');
        Route::post('/tautkan-siswa', [App\Http\Controllers\WalimuridController::class, 'tautkanSimpan'])->name('tautkan.store');
        Route::get('/statistik-anak', [WalimuridController::class, 'statistics'])
        ->name('walimurid.statistics')
        ->middleware(['auth', 'can:walimurid']);


    // ========== PROFILE ==========
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile'); // <--- INI YANG BELUM ADA
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    
    // ========== STUDENTS ==========
    

    Route::get('/students/import', [StudentImportController::class, 'showImportForm'])->name('students.import.form');
    Route::post('/students/import', [StudentImportController::class, 'import'])->name('students.import');
    Route::get('/students/template', [StudentController::class, 'downloadTemplate'])->name('students.template');
    Route::get('/template-siswa', [StudentTemplateController::class, 'download'])->name('students.template');
    Route::get('/students/{student}/edit', [StudentController::class, 'edit'])->name('students.edit');
    Route::get('/students/{id}/card', [StudentController::class, 'downloadCard'])->name('students.card');
    Route::resource('students', StudentController::class);
});

Route::get('/rekap-bulanan', [AttendanceController::class, 'rekapBulanan'])
    ->name('attendance.rekap.bulanan');

// Download Rekap Bulanan (Excel)
Route::get('/rekap-bulanan/download', [AttendanceController::class, 'downloadRekapBulanan'])
    ->name('attendance.rekap.bulanan.download');
Route::get('/class-attendance/{class}/scan', [ClassAttendanceController::class, 'scan'])
    ->name('class_attendance.scan');
Route::post('/scan-absen', [ClassAttendanceController::class, 'scan'])->name('scan.absen');

require __DIR__.'/auth.php';
