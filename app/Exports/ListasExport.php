<?php
namespace App\Exports;

use App\Models\Lista;
use Maatwebsite\Excel\Concerns\FromCollection;


class ListasExport implements FromCollection{
    public function collection(){
        
        return Lista::selectRaw('codigo_proveedor,precio_final,url')->get();
    }

}