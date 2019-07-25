<?php

require_once "../../src/dataobject/TProveedores.php";

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$decode = json_decode(file_get_contents("php://input"));

//ruc, nombres, apellidos, direccion, telefono

if($decode){
    if (!(isset($decode) || isset($decode->proveedor) || isset($decode->proveedor->ruc) || isset($decode->proveedor->nombres) 
    || isset($decode->proveedor->apellidos) || isset($decode->proveedor->direccion) || isset($decode->proveedor->telefono)))
    {
       $response = array(
           'error' => 'error',
           'mensaje' => 'Parametros de entrada incorrectos.'
       );
    }
    else
    {
        $ft = new TProveedores();
        $response = $ft->insertProveedor($decode->proveedor->ruc, $decode->proveedor->nombres, $decode->proveedor->apellidos, $decode->proveedor->direccion, $decode->proveedor->telefono);     
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


