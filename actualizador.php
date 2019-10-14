<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
header('Content-Type: application/json');

$peticion = json_decode(file_get_contents("php://input"), true);
$url = $peticion["url"];
$respuestaFinal = $peticion;

/*
$myfile = fopen("C:\\Users\\iFiL\\Documents\\PythonProjects\\PureProjects\\route\\ng.py", "r") or die("Unable to open file!");
$texto = fread($myfile, filesize("C:\\Users\\iFiL\\Documents\\PythonProjects\\PureProjects\\route\\ng.py"));
$patron = "/urlEspejo = '(.*)'\n/";
preg_match_all("/urlEspejo = '(.*)'/", $texto, $output_array);
$texto = str_replace($output_array[1][0], $url, $texto);

$myfile = fopen("C:\\Users\\iFiL\\Documents\\PythonProjects\\PureProjects\\route\\ng.py", "w") or die("Unable to open file!");
fwrite($myfile, $texto);
*/

$command = "sudo ps ax | grep ng.py";
$output = shell_exec($command);

echo $output;

//echo $texto;

//fclose($myfile);
