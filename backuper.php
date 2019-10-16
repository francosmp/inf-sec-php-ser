<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
header('Content-Type: application/json');

$peticion = json_decode(file_get_contents("php://input"), true);
$serverBackUp = $peticion["url"];

unlink("C:/xampp/htdocs/inf-sec-php-ser/test.sql") or die("Couldn't delete file");

require_once('./backUpClass.php');

$cf = curl_init();
$cfile = new CURLFile('C:/xampp/htdocs/inf-sec-php-ser/test.sql', 'text/sql', 'test');
$data = array("archivo" => $cfile);

curl_setopt($cf, CURLOPT_URL, $serverBackUp); // me lo envia a mi
curl_setopt($cf, CURLOPT_POST, true);
curl_setopt($cf, CURLOPT_POSTFIELDS, $data);

$response = curl_exec($cf);

if ($response == true) {
    echo "{\"backup\": \"Backup Succesfully\"}";;
} else {
    echo "{\"backup\": \"Error\"}";;
}
