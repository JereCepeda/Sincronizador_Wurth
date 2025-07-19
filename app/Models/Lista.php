<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lista extends Model
{
    use HasFactory;
    protected $fillable = [
        'codigo_proveedor',
        'precio_final',
        'url',
        'descripcion'
    ];

    protected $table='listas';
}
