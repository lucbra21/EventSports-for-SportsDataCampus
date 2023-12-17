<?php

//INICIO CONFIGURACION

$host = 'localhost';
$db   = 'db_sdckl';
$user = 'root';
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

$data = json_decode(file_get_contents("php://input"));

// Separar los datos por líneas
$lineas = explode("\n", $data);

$bandera='no';
// Recorrer cada línea y convertirla en un array
$linea_1 = $lineas[1];
$registro_1 = str_getcsv($linea_1);
$codigoSesion = $registro_1[21];
$stmt = $pdo->prepare("DELETE FROM `bot_events` WHERE codigoSesion = :codigoSesion;");
$stmt->bindParam(':codigoSesion', $codigoSesion);
$stmt->execute();

foreach ($lineas as $linea) {

    $registro = str_getcsv($linea);

    if ($registro[5]!='' & $bandera == 'si') {

        $stmt = $pdo->prepare("
                                INSERT INTO `bot_events`(
                                    `ID`,
                                    `match`,
                                    `descripcion`,
                                    `fecha`,
                                    `linkMatch`,
                                    `mins`,
                                    `segs`,
                                    `idcode`,
                                    `idgroup`,
                                    `idtext`,
                                    `team`,
                                    `player`,
                                    `secundary`,
                                    `periodo`,
                                    `xStart`,
                                    `yStart`,
                                    `xEnd`,
                                    `yEnd`,
                                    `xPort`,
                                    `yPort`,
                                    `link`,
                                    `au_fecha_hora`,
                                    `codigoSesion`
                                ) VALUES (
                                    :ID,
                                    :match,
                                    :descripcion,
                                    :fecha,
                                    :linkMatch,
                                    :mins,
                                    :segs,
                                    :idcode,
                                    :idgroup,
                                    :idtext,
                                    :team,
                                    :player,
                                    :secundary,
                                    :periodo,
                                    :xStart,
                                    :yStart,
                                    :xEnd,
                                    :yEnd,
                                    :xPort,
                                    :yPort,
                                    :link,
                                    NOW(),
                                    :codigoSesion
                                )
                            ");

        // csvContent += '"Id Partido","Link Partido","Descripción","Fecha","Link Evento","eventID","Team","Player","Secundary",
        // "code","group","text","Periodo","Mins","Secs","startX","startY","endX","endY","porX","porY"';
        
       
        $stmt->bindParam(':match', $registro[0]);
        $stmt->bindParam(':linkMatch', $registro[1]);
        $stmt->bindParam(':descripcion', $registro[2]);
        $stmt->bindParam(':fecha', $registro[3]);
        $stmt->bindParam(':link', $registro[4]);
        $stmt->bindParam(':ID', $registro[5]);
        $stmt->bindParam(':team', $registro[6]);
        $stmt->bindParam(':player', $registro[7]);
        $stmt->bindParam(':secundary', $registro[8]);
        $stmt->bindParam(':idcode', $registro[9]);
        $stmt->bindParam(':idgroup', $registro[10]);
        $stmt->bindParam(':idtext', $registro[11]);
        $stmt->bindParam(':periodo', $registro[12]);
        $stmt->bindParam(':mins', $registro[13]);
        $stmt->bindParam(':segs', $registro[14]);
        $stmt->bindParam(':xStart', $registro[15]);
        $stmt->bindParam(':yStart', $registro[16]);
        $stmt->bindParam(':xEnd', $registro[17]);
        $stmt->bindParam(':yEnd', $registro[18]);
        $stmt->bindParam(':xPort', $registro[19]);
        $stmt->bindParam(':yPort', $registro[20]);
        $stmt->bindParam(':codigoSesion', $registro[21]);
        // $stmt->bindParam(':idinstance_relacionada', $registro[18]);

        try {
            $stmt->execute();
        } catch (PDOException $e) {
            // Aquí manejas el error. Por ejemplo, puedes guardar un log del error o simplemente ignorarlo.
            error_log($e->getMessage());
            // echo "Error al insertar el registro: " . $e->getMessage();
        }
    }else {
        // echo "Error al recibir los datos.";
    }
    $bandera='si';
}

?>
