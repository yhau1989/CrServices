<?php

require_once "../../src/dataobject/TVentas.php";

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$ft = new TVentas();
$response = $ft->getVentas();    

$response = 


        


$encode = json_encode($response);

exit( $encode );


