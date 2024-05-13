<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\ListasExport;
use App\Imports\ListasImport;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    public function POST_excel(Request $request){
        $import = new ListasImport;
        Excel::import($import,$request->file('subida'));
        return back()->with('success', 'Importación exitosa');
    }
    public function GET_exportarExcel()  {
        return Excel::download(new ListasExport, 'resultadowurth.xlsx');
    }
}
