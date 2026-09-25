<?php

include_once "App/Controllers/MantenimientosController.php";

$MantenimientosController = new MantenimientosController();

header('Content-Type: application/json');

error_log("===== INICIO GUARDAR OBSERVACION =====");

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
if (!is_array($data)) {

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
    !isset($data['criterio']) ||
    !array_key_exists('observacion', $data)
) {

    error_log("ERROR: Datos incompletos");

    echo json_encode([
        'success' => false,
        'message' => 'Datos incompletos'
    ]);

    exit;
}

$ID_Detalle = $data['ID_Detalle'];
$criterio = $data['criterio'];
$observacion = $data['observacion'];

error_log("ID_Detalle: " . $ID_Detalle);
error_log("Criterio: " . $criterio);
error_log("Observacion: [" . $observacion . "]");

// Validar solo los datos obligatorios
if (empty($ID_Detalle) || empty($criterio)) {

    error_log("ERROR: ID_Detalle o criterio vacío");

    echo json_encode([
        'success' => false,
        'message' => 'Datos obligatorios vacíos'
    ]);

    exit;
}

// Determinar qué operación se está solicitando
if ($observacion === '') {
    error_log(
        "Se solicita ELIMINAR observación del criterio: " .
        $criterio
    );
} else {
    error_log(
        "Se solicita GUARDAR/ACTUALIZAR observación del criterio: " .
        $criterio
    );
}

error_log("Llamando a GuardarObservacion del Controller...");

$resultado = $MantenimientosController->GuardarObservacion(
    $ID_Detalle,
    $criterio,
    $observacion
);

error_log(
    "Resultado recibido del Controller: " .
    ($resultado ? 'TRUE' : 'FALSE')
);

// Respuesta
if ($resultado) {

    error_log("Operación de observación realizada correctamente");

    echo json_encode([
        'success' => true,
        'message' => (
            $observacion === ''
                ? 'Observación eliminada correctamente'
                : 'Observación guardada correctamente'
        )
    ]);

} else {

    error_log("ERROR: El modelo devolvió FALSE");

    echo json_encode([
        'success' => false,
        'message' => (
            $observacion === ''
                ? 'Error al eliminar la observación'
                : 'Error al guardar la observación'
        )
    ]);
}

error_log("===== FIN GUARDAR OBSERVACION =====");

?>