<?php

require_once "../../src/dataobject/TProveedores.php";

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$ft = new TProveedores();
$response = $ft->getProveedoresMant();


$encode = json_encode($response);

exit( $encode );


