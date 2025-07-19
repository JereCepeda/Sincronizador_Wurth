<?php
namespace App\Imports;

use App\Models\Lista;
use Maatwebsite\Excel\Concerns\ToModel;

class ListasImport implements ToModel{
    public function model(array $row)  {
        return new Lista([
        'codigo_proveedor' => trim($row[0]),
        'precio_final' => is_numeric($row[1]) ? floatval($row[1]) : null,
        'url' => null,
        'descripcion' => $row[2] ?? null
        ]);
    }

}