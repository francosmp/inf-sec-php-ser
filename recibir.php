<?php

require_once('./coneccion.php');

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
header('Content-Type: application/json');

$peticion = json_decode(file_get_contents("php://input"), true);

if(isset($_FILES['archivo']['tmp_name'])){
    $path = "../" . $_FILES['archivo']['name'];
    move_uploaded_file($_FILES['archivo']['tmp_name'], $path);
}