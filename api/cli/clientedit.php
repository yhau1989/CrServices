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
    if (!(isset($decode) || isset($decode->cliente) || isset($decode->cliente->id) || isset($decode->cliente->ruc) || isset($decode->cliente->nombres) 
    || isset($decode->cliente->apellidos) || isset($decode->cliente->direccion) || isset($decode->cliente->telefono) || isset($decode->cliente->estado)))
    {
       $response = array(
           'error' => 'error',
           'mensaje' => 'Parametros de entrada incorrectos.'
       );
    }
    else
    {
        $ft = new TClientes();
        $response = $ft->updateCliente($decode->cliente->id,$decode->cliente->ruc, 
                                        $decode->cliente->nombres, $decode->cliente->apellidos, 
                                        $decode->cliente->direccion, $decode->cliente->telefono,
                                        $decode->cliente->estado);     
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


