<?php

namespace App\Http\Controllers;

use App\Services\ProductoUpdater;

class PreciosController extends Controller
{   
    
    // public function conexionGuzzle($url){
        
    //     $client = new Client();
    //     return $client->get($url);
        
    // }
    // public function obtenerDom($respuesta){
    //     $htmlContenido= $respuesta->getBody()->getContents();
    //     $crawler = new Crawler($htmlContenido);
    //     return $crawler;
    // }

    // public function buscaEnWurth() {
    //     ini_set('max_execution_time', 300);
    //     Log::info('traza 1 empieza con clic en front');
    //     $productos = new ListaController();
    //     $productos = $productos->getLista();
    //     $existe="";
    //     foreach($productos as $key=>$valor){
    //         $codigo=trim($valor->codigo_proveedor);
    //         $url="https://www.wurth.com.ar/?action=check_codigo_barras&term=".$codigo;
    //         Log::info('traza 2 previo a conexion a guzzle');
    //         $response = $this->conexionGuzzle($url);
    //         $existe=json_decode($response->getBody(),true);
    //         if($existe['existe']==1){
    //             Log::info('traza 3, existe url y va a updateUrl'.$existe['url']);
    //             Log::info("ID: ".$key+1);
    //             $this->updateURL($existe['url'],$key+1);
    //         }else{
    //             Log::info(" Va sin url, ID: ".$key+1);
    //         }
    //     }
    //     return redirect()->back();
    //     // importante !! revisar en la bd los articulos que tienen "sin url"
    // }
 
    // public function updateURL($var,$key){
    //     $lista = new ListaController();
    //     Log::info('traza 3');
    //     $producto = $lista->Get_producto_id($key);
    //     $producto->url = $var;
    //     $producto->save();
    // }
    // public function updatePrecioFinal(){
    //     ini_set('max_execution_time', 300);
    //     Log::info('traza 1 Click en Actualizar Precios');
    //     $productos= new ListaController();
    //     $productos = $productos->Get_producto_url();
    //     foreach($productos as $valor){
    //         if(isset($valor->url) && $valor->url !='sin url'){
    //         Log::info('traza 2 previo a descargarPrecioFinal, url setteada y !="sinurl" ');
    //         $valor->precio_final = $this->descargarPrecioFinal($valor->url);
    //         }else{$valor->url="sin url";}
    //         $valor->save();
    //     }
    //     return redirect()->back();
    // }
    // public function descargarPrecioFinal($url) {
        
    //     // revisar y chequear que funcione bien esta funcionalidad y termino corrigiendo toodooo
    //     $precioFinal=0.0;
    //     $crawler = $this->obtenerDom($this->conexionGuzzle($url));
    //     Log::info('traza 3 conexion correcta del crawler con '.$url);


    //     $elementosPrecio = $crawler->filter('.precios_por_cantidad_item_col')->filter('.col-xs-5');
    //     $elementoprecio= $crawler->filter('.contenedor-precio .fweight-extrabold');
    //     if ($elementosPrecio->count() > 0) {
    //         $precioFinal = $elementosPrecio->text(); // Obtiene el texto del primer elemento encontrado
    //         Log::info('traza a coincide precios_por_cantidad_item_col'.$url);
    //     } elseif($elementoprecio->count()> 0 ) {
    //         Log::info("traza b coincide contenedor-precio");
    //         $precioFinal = $elementoprecio->text();
    //     }else{
    //         Log::info("---Traza con errores --- ".$url." - ".$precioFinal." es necesario chequearlo para verificar errores");
    //         $precioFinal=" ".(string)0.0;
    //     }
    //     Log::info($url."-".$precioFinal);
    //     return explode(" ",$precioFinal)[1];
    // }


    // // Sin Url 

    // public function buscaEnWurthSinUrl() {
    //     ini_set('max_execution_time', 300);
    //     Log::info('traza 1 empieza con clic en front');
    //     $productos = new ListaController();
    //     $productos = $productos->getListaSinUrl();
    //     foreach($productos as $valor){
    //         Log::info(json_encode($valor));
    //         $codigoFormateado="";
    //         $codigoFormateado = implode('+',explode(' ',trim($valor->codigo_proveedor)));
    //         $url="https://www.wurth.com.ar/es/busqueda/?term=".$codigoFormateado;
    //         Log::info('traza 2 previo a actualizar sin url '.$valor->codigo_proveedor);
    //         $resultadoArray= $this->actualizarSinURL($url,$valor->codigo_proveedor); 
         
    //         $valor->precio_final= $resultadoArray['precioFinal'];
    //         $valor->url= $resultadoArray['urlFinal'];
    //         Log::info(json_encode($valor));
    //         $valor->save();
    //     }
    //     return redirect()->back();
    // }
    
    // public function actualizarSinURL($url, $codigo) {
    //     $precioFinal=0.0;
    //     try {
    //         $crawler = $this->obtenerDom($this->conexionGuzzle($url));
    //     } catch (RequestException $e) {
    //         // Captura el error específico de HTTP 404
    //         if ($e->hasResponse() && $e->getResponse()->getStatusCode() == 404) {
    //             // Aquí puedes manejar el error 404, por ejemplo, registrando la traza
    //             Log::error('Error 404 al intentar obtener el DOM', json_encode(['url' => $url,'codigo'=>$codigo]));
                
    //             // Otra acción, como lanzar una excepción personalizada o devolver un valor especial
    //             throw new \Exception('Error 404 al intentar obtener el DOM');
    //         } else {
    //             // Maneja otros errores que puedan ocurrir
    //             Log::error('Error al intentar obtener el DOM', ['error' => $e->getMessage()]);
    //             throw $e; // Re-lanza la excepción original si no es un error 404
    //         }
    //     }
    //     $ruta="sin url";
    //     if($crawler->filter('.producto')->count()>0)
    //         {Log::info('valores encontrados por filter .producto, cantidad: '.$crawler->filter('.producto')->count());}
    //     $crawler->filter('.producto')->each(function ($elemento) use ($codigo,&$precioFinal,&$ruta) {
    //         $ruta = $elemento->filter('.titulo')->attr('href');
    //         $nvoArray=[];
    //         Log::info($codigo.' es el codigo para traza 3 para probar nuevo Crawler '.$ruta);
    //         $nuevoCrawler=$this->obtenerDom($this->conexionGuzzle($ruta));
    //         $elementoprecio= $nuevoCrawler->filter(' .fsize-33 .fweight-extrabold');
    //         if($elementoprecio->count()> 0 ) {
    //             Log::info('traza 4 producto encontrado por ser unico '.$ruta);
    //             $precioFinal =  explode(" ",$elementoprecio->text())[1]; 
    //             return ['precioFinal'=>$precioFinal,'urlFinal'=>$ruta]; 
    //         }elseif($nuevoCrawler->filter('.codigo')->count()> 0){
    //             Log::info('traza 5 Lista de productos encontrada '.$ruta);

    //             $elementosLista = $nuevoCrawler->filter('.codigo');

    //             $elementosLista->each(function (Crawler $node) use (&$nvoArray,$codigo,&$precioFinal,$ruta){
    //                 $code=str_replace("Cód: ","",$node->text());
    //                 Log::info($code.' Es el codigo encontrado, traza 6 Busqueda del producto en lista '.$codigo);
    //                 Log::info('traza 6b :'.trim($code) ." - ". trim($codigo));
    //                 Log::info(json_encode($nvoArray));
    //                 if(!in_array($code,$nvoArray)){
    //                     $nvoArray[]=$code;
    //                     try {
    //                             if (trim($code) === trim($codigo)) {
    //                                 $ruta = $node->previousAll()->filter('a')->attr('href');
    //                                 Log::info('traza 7 Codigo encontrado en lista con la url '.$ruta);
    //                                 $precioFinal = (double)$this->descargarPrecioFinal($ruta);
    //                                 return ['precioFinal'=>$precioFinal,'urlFinal'=>$ruta];
    //                             }
    //                         } 
    //                     catch (\Exception $e) {
    //                         Log::info("---Error por Nodo vacio---".$code."-".$ruta);
    //                     }
    //                 }
    //             });
    //         }
    //     });
    //     return ['precioFinal'=>$precioFinal,'urlFinal'=>$ruta];
    // }
 public function updatePrecios(ProductoUpdater $updater)
    {
        $updater->actualizarPreciosConUrl();
        return redirect()->back();
    }

    public function updateSinUrl(ProductoUpdater $updater)
    {
        $updater->actualizarPreciosSinUrl();
        return redirect()->back();
    }

}
     