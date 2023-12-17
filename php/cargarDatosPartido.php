<?php

//INICIO CONFIGURACION
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', 'root');
define('DB_NAME', 'db_sdckl');

//FIN CONFIGURACION

// Establecer encabezados
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

$mysqli = new mysqli(DB_HOST, DB_USER , DB_PASSWORD , DB_NAME);

if ($mysqli->connect_errno) {
    echo "Error al conectar con la base de datos ";
    die();
}

// Obtener el ID del partido desde la petición
$matchId = $_GET['matchId'];


$sql = "SELECT fecha, descripcioncompleta, linkvideocompleto, competidor1, competidor2 FROM vw_grilla_partidos WHERE partido = " . $matchId;
$result = $mysqli->query($sql);
$matchData = $result->fetch_assoc();

$sql = "SELECT descripcioncorta, apellido, nombre FROM vw_list_convocatoriaspartido_paracarga WHERE partido = ".$matchId." AND competidor = ".$matchData['competidor1']."  ORDER BY apellido, nombre ASC";
$result = $mysqli->query($sql);
$jugadoresLocales = $result->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT descripcioncorta, apellido, nombre FROM vw_list_convocatoriaspartido_paracarga WHERE partido = ".$matchId." AND competidor = ".$matchData['competidor2']."  ORDER BY apellido, nombre ASC";
$result = $mysqli->query($sql);
$jugadoresVisitantes = $result->fetch_all(MYSQLI_ASSOC);

// Añadir las listas de jugadores al objeto que vas a retornar
$matchData['jugadoresLocales'] = $jugadoresLocales;
$matchData['jugadoresVisitantes'] = $jugadoresVisitantes;

// Devolver datos en formato JSON
// $ddd = json_encode($matchData);
// var_dump($ddd);
echo json_encode($matchData);


?>
