<?php

require_once "../../src/dataobject/TLotes.php";

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$decode = json_decode(file_get_contents("php://input"));

//ruc, nombres, apellidos, direccion, telefono

if($decode){
    if (!(isset($decode) || isset($decode->lote) || isset($decode->lote->material) || isset($decode->lote->peso)))
    {
       $response = array(
           'error' => 'error',
           'mensaje' => 'Parametros de entrada incorrectos.'
       );
    }
    else
    {
        $ft = new TLotes();
        $response = $ft->insertLote($decode->lote->material, $decode->lote->peso);
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


