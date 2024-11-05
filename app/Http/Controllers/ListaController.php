<?php

namespace App\Http\Controllers;

use App\Models\Lista;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class ListaController extends Controller
{
    protected $lista;
    protected $listaxid;
    protected $listaxurl;
    protected $listasinurl;
    public function getLista()
    {
        $this->lista = Lista::selectRaw('id,codigo_proveedor,precio_final,url')->whereNull('url')->get();
        return $this->lista;
    }

    public function Get_producto_id($id) {
        $this->listaxid = Lista::selectRaw('id,codigo_proveedor,precio_final,url')->where('id',$id)->first();
        return $this->listaxid;
    }

    public function  Get_producto_url()  {
        $this->listaxurl = Lista::selectRaw('id,codigo_proveedor,precio_final,url')->get();
        return $this->listaxurl;
    }

    public function getListaSinUrl()
    {
        $this->listasinurl = Lista::selectRaw('id,codigo_proveedor,precio_final,url')->where('url','=',"sin url")->get();
        return $this->listasinurl;
    }
}
