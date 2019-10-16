<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
header('Content-Type: application/json');

require_once('./backUpClass.php');

$peticion = json_decode(file_get_contents("php://input"), true);
$tipoPeticion = $peticion["backup"];

$respuestaFinal = "{\"backup\": \"ok\"}";

/* Devolver JSON */

echo $respuestaFinal;
