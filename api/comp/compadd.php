<?php

require_once "../../src/dataobject/TCompras.php";

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$decode = json_decode(file_get_contents("php://input"));


if($decode){
    if (!(isset($decode) 
            || isset($decode->compra) 
            || isset($decode->compra->proveedor) 
            || isset($decode->compra->material) 
            || isset($decode->compra->valor) 
            || isset($decode->compra->peso) 
            || isset($decode->compra->comprador)
            || isset($decode->compra->items)
            ))
    {
       $response = array(
           'error' => 'error',
           'mensaje' => 'Parametros de entrada incorrectos.'
       );
    }
    else
    {
        $ft = new TCompras();
        $response = $ft->insertCompra($decode->compra->proveedor, 
                                      $decode->compra->valor, 
                                      $decode->compra->peso,  
                                      $decode->compra->comprador,
                                      $decode->compra->items);
    }    
}
else
{
   $response = array(
       'error' => 'error',
       'mensaje' => 'No JSON value set'
   );
}


$encode = json_encode($response);

exit( $encode );


