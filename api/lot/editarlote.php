<?php
use GuzzleHttp\Psr7\Response;

require_once "../../src/dataobject/Tlotes.php";

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$decode = json_decode(file_get_contents("php://input"));


if($decode){
    if (!(isset($decode) || isset($decode->lote) || isset($decode->lote->tipocambio) || isset($decode->lote->id) || isset($decode->lote->usuario) 
    || isset($decode->lote->fini) || isset($decode->lote->ffin)))
    {
       $response = array(
           'error' => 'error',
           'mensaje' => 'Parametros de entrada incorrectos.'
       );
    }
    else
    {
        /*$ft = new TLotes();
        switch ($decode->lote->tipocambio) {
            case 's':
                $response = $ft->updateLoteSetProcessSeleccion($decode->lote->id, $decode->lote->usuario, $decode->lote->fini, $decode->lote->ffin);     
                break;
            case 't':
                $response = $ft->updateLoteSetProcessProceso($decode->lote->id, $decode->lote->usuario, $decode->lote->fini, $decode->lote->ffin);
                break;
            case 'a':
                $response = $ft->updateLoteSetProcessAlmacena($decode->lote->id, $decode->lote->usuario, $decode->lote->fini, $decode->lote->ffin);
                break;
        }*/

        $response = 'Hola';
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


