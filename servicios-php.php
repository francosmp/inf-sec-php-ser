<?php
require_once('./coneccion.php');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
header('Content-Type: application/json');
$peticion = json_decode(file_get_contents("php://input"), true);
$tipoPeticion = $peticion["crud"];
$respuestaFinal;
$datos = array();
$espejo = "http://415be02e.ngrok.io/inf-sec-php-ser/servicios-php.php";
if ($espejo != "") {
    if ($tipoPeticion != "read") {
        $ch = curl_init($espejo);
        $payload = json_encode($peticion);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
    }
}
switch ($tipoPeticion) {
    case "create":
        /* Obtener index */
        $query = "SELECT id, codigo FROM crud";
        $response = @mysqli_query($dbc, $query);
        while ($fila = mysqli_fetch_array($response, MYSQLI_ASSOC)) {
            $datos[$fila['id']] = array(
                'id'        => $fila['id'],
                'codigo'    => $fila['codigo']
            );
        }
        $cantidadTuplas = mysqli_num_rows($response) + 1;
        /* Cadena Random */
        $cadenaRandom = '';
        if (strcmp($peticion["codigo"], "") !== 0) {
            $cadenaRandom = $peticion["codigo"];
        } else {
            $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $tamanoCaracteres = strlen($caracteres);
            for ($i = 0; $i < 10; $i++) {
                $cadenaRandom .= $caracteres[rand(0, $tamanoCaracteres - 1)];
            }
        }
        /* Insert */
        $query = "INSERT INTO crud (id, codigo) VALUES (?, ?)";
        $stmt = mysqli_prepare($dbc, $query);
        mysqli_stmt_bind_param($stmt, "is", $cantidadTuplas, $cadenaRandom);
        mysqli_stmt_execute($stmt);
        $affected_rows = mysqli_stmt_affected_rows($stmt);
        if ($affected_rows == 1) {
            $respuestaFinal = "Successfully inserted";
        } else {
            $respuestaFinal = "There was an error inserting" . mysqli_error($response);
        }
        mysqli_stmt_close($stmt);
        break;
    case "read":
        /* Select */
        $query = "SELECT id, codigo FROM crud";
        $response = @mysqli_query($dbc, $query);
        while ($fila = mysqli_fetch_array($response, MYSQLI_ASSOC)) {
            $datos[$fila['id']] = array(
                'id'        => $fila['id'],
                'codigo'    => $fila['codigo']
            );
        }
        $respuestaFinal = (object) $datos;
        break;
    case "update":
        /* Update */
        $index = $peticion["index"];
        $codigo = $peticion["codigo"];
        $query = "UPDATE crud SET codigo='" . $codigo . "' WHERE id='" . $index . "'";
        $response = @mysqli_query($dbc, $query);
        if ($response == TRUE) {
            $respuestaFinal = "Successfully updated";
        } else {
            $respuestaFinal = "There was an error updating" . mysqli_error($response);
        }
        break;
    case "delete":
        /* Delete */
        $query = "DELETE FROM crud ORDER BY id DESC LIMIT 1";
        $response = @mysqli_query($dbc, $query);
        if ($response == TRUE) {
            $respuestaFinal = "Successfully deleted";
        } else {
            $respuestaFinal = "There was an error deleting" . mysqli_error($response);
        }
        break;
    default:
        $respuestaFinal = null;
}
/* Cerrar Con */
mysqli_close($dbc);
/* Devolver JSON */
echo json_encode($respuestaFinal);
