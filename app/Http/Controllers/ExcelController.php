<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\ListasExport;
use App\Imports\ListasImport;
use Illuminate\Routing\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    public function POST_excel(Request $request){
        $import = new ListasImport;
        Excel::import($import,$request->file('subida'));
        return redirect()->route('GET_productos')->with('success', 'Archivo importado correctamente.');
    }
    public function GET_exportarExcel()  {
        return Excel::download(new ListasExport, 'resultadowurth.xlsx');
    }
}
