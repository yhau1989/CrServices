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
    if(!(isset($decode) || isset($decode->user) || isset($decode->user->nombres) 
        || isset($decode->user->apellidos) || isset($decode->user->email) || isset($decode->user->password) 
        || isset($decode->user->estado)))
    {
       $response = array(
           'error' => 'error',
           'mensaje' => 'Parametros de entrada incorrectos.'
       );
    }
    else
    {
        $ft = new TUsuarios();
        $response = $ft->insertUsuario($decode->user->nombres, $decode->user->apellidos, $decode->user->email, $decode->user->password, $decode->user->estado);

        if($response["error"] == 0)
        {
            $url = URL_CONFIRMACION . $response["data"] . "/" . md5($decode->user->password);
            $response["data"] =  $url;
            $gt = new Smtp();
            $gt->confirmarRegistro($decode->user->nombres, $url, $decode->user->email);
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


