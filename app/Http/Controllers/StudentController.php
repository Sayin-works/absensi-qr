<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Classroom;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Subject;
use Intervention\Image\ImageManagerStatic as Image;


class StudentController extends Controller
{


public function downloadAllCards()
{
    // Ambil semua data siswa
    $students = Student::with('classroom')->get();

    // Load view kartu pelajar untuk semua siswa
    $pdf = Pdf::loadView('students.cards_all', compact('students'))
        ->setPaper('a4', 'portrait');

    return $pdf->download('kartu_pelajar_semua.pdf');
}

    public function downloadCard($id)
    {
        $student = Student::with('classroom')->findOrFail($id);
        $pdf = Pdf::loadView('students.card', compact('student'));
        return $pdf->download('kartu_pelajar_' . $student->name . '.pdf');
    }

public function index(Request $request)
{
    $classes = Classroom::all();
    $query = Student::with('classroom', 'walimurid');

    // Filter kelas
    if ($request->class_id) {
        $query->where('class_id', $request->class_id);
    }

    // Search nama atau NISN
    if ($request->search) {
        $query->where(function ($q) use ($request) {
            $q->where('name', 'like', '%'.$request->search.'%')
              ->orWhere('nisn', 'like', '%'.$request->search.'%');
        });
    }

    $students = $query->paginate(10);

    return view('students.index', compact('students', 'classes'));
}


    public function create()
    {
        $classes = Classroom::all();
        $walimurid = User::where('role', 'walimurid')->get();
        $subjects = Subject::with('teachers')->get();

        return view('students.create', compact('classes', 'walimurid', 'subjects'));
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'class_id' => 'required|exists:classes,id',
        'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // max 2MB
    ]);

    $qrCode = 'QR-' . strtoupper(Str::random(8));

    $student = new Student();
    $student->name = $request->name;
    $student->class_id = $request->class_id;
    $student->walimurid_id = $request->walimurid_id;
    $student->nisn = $request->nisn;
    $student->gender = $request->gender;
    $student->birth_place = $request->birth_place;
    $student->birth_date = $request->birth_date;
    $student->address = $request->address;
    $student->religion = $request->religion;
    $student->phone = $request->phone;
    $student->qr_code_id = $qrCode;

    // Upload & Kompres Foto
    if ($request->hasFile('photo')) {
        $image = $request->file('photo');
        $filename = time().'_'.$image->getClientOriginalName();

        // Resize & Kompres
        $img = Image::make($image->getRealPath());
        $img->resize(80, 100, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })->encode('jpg', 80);

        $img->save(public_path('foto_siswa/' . $filename));
        $student->photo = 'foto_siswa/' . $filename;
    }

    $student->save();

    return redirect()->route('students.index')->with('success', 'Siswa berhasil ditambahkan.');
}

// UPDATE
public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'class_id' => 'required|exists:classes,id',
        'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $student = Student::findOrFail($id);
    $student->fill($request->except('photo'));

    // Upload & Kompres Foto
    if ($request->hasFile('photo')) {
        $image = $request->file('photo');
        $filename = time().'_'.$image->getClientOriginalName();

        // Resize dan kompres
        $img = \Image::make($image->getRealPath())
            ->resize(80, 100, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->encode('jpg', 80); // kualitas 80%

        // Simpan ke folder publik
        $img->save(public_path('foto_siswa/' . $filename));

        // Simpan path ke database
        $student->photo = 'foto_siswa/' . $filename;
    }

    $student->save();

    return redirect()->route('students.index')->with('success', 'Data siswa berhasil diperbarui.');
}

    public function edit($id)
    {
        $student = Student::findOrFail($id);
        $classes = Classroom::all();
        $walimurid = User::where('role', 'walimurid')->get();

        return view('students.edit', compact('student', 'classes', 'walimurid'));
    }

    

    public function destroy($id)
    {
        Student::findOrFail($id)->delete();
        return redirect()->route('students.index')->with('success', 'Siswa berhasil dihapus.');
    }
}
