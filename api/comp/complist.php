<?php

require_once "../../src/dataobject/TCompras.php";

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$decode = json_decode(file_get_contents("php://input"));

if($decode){
    if((isset($decode) && isset($decode->compra) && isset($decode->compra->fecini) && isset($decode->compra->fecfin)))
    {
        $ft = new Tcompras();
        $response = $ft->getComprasList($decode->compra->fecini, $decode->compra->fecfin); 
    }
    else
    {
        $response = array(
            'error' => 'error',
            'mensaje' => 'Parametros de entrada incorrectos.'
        );
    }    
}
else
{
    $ft = new Tcompras();
    $response = $ft->getComprasList();
}

$encode = json_encode($response);
exit( $encode );


