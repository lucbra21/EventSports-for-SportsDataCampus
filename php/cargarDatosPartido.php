<?php

//INICIO CONFIGURACION

$host = 'localhost';
$db   = 'db_sdckl';
$user = 'root';
// $pass = 'cGEDeIFNke95';
$pass = 'root';
$charset = 'utf8mb4';

//FIN CONFIGURACION

// Establecer encabezados
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Si es una solicitud OPTIONS (preflight), solo termina con éxito
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}

// header('Access-Control-Allow-Origin: https://tudominio.com');

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

// Obtener el ID del partido desde la petición
$matchId = $_GET['matchId'];

// Consulta a la base de datos para obtener datos del partido
$stmt = $pdo->prepare("SELECT fecha, descripcioncompleta, linkvideocompleto, competidor1, competidor2 FROM vw_grilla_partidos WHERE partido = ?");

$stmt->execute([$matchId]);
$matchData = $stmt->fetch();

// Consulta para obtener jugadores locales
$stmtLocal = $pdo->prepare("SELECT descripcioncorta, apellido, nombre FROM vw_list_convocatoriaspartido_paracarga WHERE partido = ? AND competidor = ?  ORDER BY apellido, nombre ASC");
$stmtLocal->execute([$matchId,$matchData['competidor1']]);
$jugadoresLocales = $stmtLocal->fetchAll(PDO::FETCH_ASSOC); // Suponiendo que quieres todos los registros

// Consulta para obtener jugadores visitantes
$stmtVisitante = $pdo->prepare("SELECT descripcioncorta, apellido, nombre FROM vw_list_convocatoriaspartido_paracarga WHERE partido = ? AND competidor = ?  ORDER BY apellido, nombre ASC");
$stmtVisitante->execute([$matchId,$matchData['competidor2']]);
$jugadoresVisitantes = $stmtVisitante->fetchAll(PDO::FETCH_ASSOC); // Suponiendo que quieres todos los registros

// Añadir las listas de jugadores al objeto que vas a retornar
$matchData['jugadoresLocales'] = $jugadoresLocales;
$matchData['jugadoresVisitantes'] = $jugadoresVisitantes;

// Devolver datos en formato JSON
// $ddd = json_encode($matchData);
// var_dump($ddd);
echo json_encode($matchData);


?>
