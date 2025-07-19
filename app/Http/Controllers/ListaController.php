<?php

namespace App\Http\Controllers;

use App\Models\Lista;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class ListaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */ 
    public function GET_productos()
    {
        info('Cargando vista de productos');
        return view('productos');
    }
    public function GET_datatable(Request $request)
    {
        if ($request->ajax()) {
        $productos = Lista::select(['codigo_proveedor', 'precio_final', 'url','descripcion'])->get();

        return DataTables::of($productos)
    ->setTotalRecords($productos->count())
    ->setFilteredRecords($productos->count())
    ->make(true);
    }

    abort(403);
    }
}
