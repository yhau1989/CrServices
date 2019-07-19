<?php

require_once "../../src/dataobject/TMateriales.php";

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

/*$decode = json_decode(file_get_contents("php://input"));


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
        $ft = new TMateriales();
        $response = $ft->getMateriales();     
    }    
}
else
{
   $response = array(
       'error' => 'error',
       'mensaje' => 'No JSON value set'
   );
}
*/
        $ft = new TMateriales();
        $response = $ft->getMateriales();    


$encode = json_encode($response);

exit( $encode );


