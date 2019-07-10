<?php

require_once "src/dataobject/TUsuarios.php";


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
$decode = json_decode(file_get_contents("php://input"));



$ft = new TUsuarios();

var_dump($ft->getUsuarios());