<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\TeachersImport;
use App\Exports\TeacherTemplateExport;

class TeacherImportController extends Controller
{
    public function showForm()
    {
        return view('teachers.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        Excel::import(new TeachersImport, $request->file('file'));

        return redirect()->route('teachers.index')->with('success', 'Data guru berhasil diimport.');
    }

    public function template()
    {
        return Excel::download(new TeacherTemplateExport, 'template-guru.xlsx');
    }
}
