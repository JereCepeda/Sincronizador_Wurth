<?php
namespace App\Imports;

use App\Models\Lista;
use Maatwebsite\Excel\Concerns\ToModel;

class ListasImport implements ToModel{
    public function model(array $row)  {
        return new Lista([
        'codigo_proveedor' => $row[0], // Ajusta los índices según las columnas de tu archivo Exce
        'precio_final' => $row[1],
        'url'=> null,
        'descripcion' => $row[2] ?? null, 
        ]);
    }

}