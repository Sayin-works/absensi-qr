<?php

namespace App\Http\Controllers;

use App\Exports\StudentTemplateExport;
use Maatwebsite\Excel\Facades\Excel;

class StudentTemplateController extends Controller
{
    public function download()
    {
        return Excel::download(new StudentTemplateExport, 'student_template.xlsx');
    }
}
