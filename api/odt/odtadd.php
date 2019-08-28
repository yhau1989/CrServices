<?php

require_once "../../src/dataobject/TOrdenTrabajo.php";

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$decode = json_decode(file_get_contents("php://input"));

//ruc, nombres, apellidos, direccion, telefono

if($decode){
    if (!(isset($decode) 
        || isset($decode->odt) 
        || isset($decode->odt->material) 
        || isset($decode->odt->peso)
        || isset($decode->odt->user_selecciona)
        || isset($decode->odt->fecini)
        || isset($decode->odt->fecfin)
        || isset($decode->odt->lotes)))
    {
       $response = array(
           'error' => 'error',
           'mensaje' => 'Parametros de entrada incorrectos.'
       );
    }
    else
    {
        $ft = new TOrdenTrabajo();
        $response = $ft->insertODT($decode->odt->material, $decode->odt->peso,$decode->odt->user_selecciona,$decode->odt->fecini, $decode->odt->fecfin, $decode->odt->lotes);
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


