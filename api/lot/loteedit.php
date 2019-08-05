<?php

require_once "../../src/dataobject/TClientes.php";

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$decode = json_decode(file_get_contents("php://input"));

//ruc, nombres, apellidos, direccion, telefono

if($decode){
    if (!(isset($decode) || isset($decode->lote) || isset($decode->cliente->tipocambio) || isset($decode->cliente->id) || isset($decode->cliente->usuario) 
    || isset($decode->cliente->fini) || isset($decode->cliente->ffin)))
    {
       $response = array(
           'error' => 'error',
           'mensaje' => 'Parametros de entrada incorrectos.'
       );
    }
    else
    {
        $ft = new TLotes();
        switch ($decode->cliente->tipocambio) {
            case 's':
                $response = $ft->updateLoteSetProcessSeleccion($decode->cliente->id, $decode->cliente->usuario, $decode->cliente->fini, $decode->cliente->ffin);     
                break;
            case 't':
                $response = $ft->updateLoteSetProcessProceso($decode->cliente->id, $decode->cliente->usuario, $decode->cliente->fini, $decode->cliente->ffin);
                break;
            case 'a':
                $response = $ft->updateLoteSetProcessAlmacena($decode->cliente->id, $decode->cliente->usuario, $decode->cliente->fini, $decode->cliente->ffin);
                break;
        }
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


