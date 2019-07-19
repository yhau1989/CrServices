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
    if(!(isset($decode) || isset($decode->reset) || isset($decode->reset->email)))
    {
       $response = array(
           'error' => 'error',
           'mensaje' => 'Parametros de entrada incorrectos.');
    }
    else
    {
        $ft = new TUsuarios();
        $response = $ft->InsertResetPassword($decode->reset->email); 

        if($response["error"] == 0)
        {
            $url = URL_RESET . $response["data"] ;
            $response["data"] =  $url;
            
            $gt = new Smtp();
            $gt->recuperarPassword($url, $decode->reset->email);
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


