<?php

require_once "../../src/dataobject/TUsuarios.php";
require_once "../../src/smtp/Smtp.php";

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
$decode = json_decode(file_get_contents("php://input"));


if($decode){
    if(!(isset($decode) || isset($decode->login) || isset($decode->login->user) 
        || isset($decode->login->password) ))
    {
       $response = array(
           'error' => 'error',
           'mensaje' => 'Parametros de entrada incorrectos.'
       );
    }
    else
    {
        $ft = new TUsuarios();
        $response = $ft->login($decode->login->user, $decode->login->password);              
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


