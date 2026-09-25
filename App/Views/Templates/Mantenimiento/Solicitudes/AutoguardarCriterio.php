<?php

include_once "App/Controllers/MantenimientosController.php";

$MantenimientosController = new MantenimientosController();

header('Content-Type: application/json');

error_log("===== INICIO AUTOGUARDAR CRITERIO =====");

// Validar método
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    error_log("ERROR: Método no permitido");

    echo json_encode([
        'success' => false,
        'message' => 'Método no permitido'
    ]);

    exit;
}

// Leer JSON
$input = file_get_contents("php://input");

error_log("JSON recibido: " . $input);

$data = json_decode($input, true);

// DEBUG
file_put_contents("debug.txt", $input);

// Validar JSON
if (!$data) {

    error_log("ERROR: No llegó JSON válido");

    echo json_encode([
        'success' => false,
        'message' => 'No llegó JSON válido'
    ]);

    exit;
}

// Validar datos
if (
    !isset($data['ID_Detalle']) ||
    !isset($data['campo']) ||
    !isset($data['valor'])
) {

    error_log("ERROR: Datos incompletos");

    echo json_encode([
        'success' => false,
        'message' => 'Datos incompletos'
    ]);

    exit;
}

$ID_Detalle = $data['ID_Detalle'];
$campo = $data['campo'];
$valor = $data['valor'];

error_log("ID_Detalle: " . $ID_Detalle);
error_log("Campo: " . $campo);
error_log("Valor: " . $valor);

if (empty($ID_Detalle) || empty($campo)) {

    error_log("ERROR: Datos vacíos");

    echo json_encode([
        'success' => false,
        'message' => 'Datos vacíos'
    ]);

    exit;
}

error_log("Llamando a GuardarCriterio del Controller...");

$resultado = $MantenimientosController->GuardarCriterio(
    $ID_Detalle,
    $campo,
    $valor
);

error_log("Resultado recibido del Controller: " . ($resultado ? 'TRUE' : 'FALSE'));

// Respuesta
if ($resultado) {

    error_log("Criterio guardado correctamente");

    echo json_encode([
        'success' => true,
        'message' => 'Criterio guardado correctamente'
    ]);

} else {

    error_log("ERROR: El modelo devolvió FALSE");

    echo json_encode([
        'success' => false,
        'message' => 'Error al guardar el criterio'
    ]);
}

error_log("===== FIN AUTOGUARDAR CRITERIO =====");

?>