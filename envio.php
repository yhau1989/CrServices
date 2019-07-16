<?php

require_once "src/smtp/Smtp.php";


$ft = new Smtp();


//$ft->test();

/*



	joffre_ernesto@hotmail.com,
fialis.yepez@gmail.com


*/
var_dump( $ft->confirmarRegistro("Samuel", "https://www.google.com" , "yhau1989@gmail.com") );




