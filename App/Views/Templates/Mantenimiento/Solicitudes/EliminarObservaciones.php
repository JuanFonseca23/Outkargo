<?php
include_once "App/Controllers/MantenimientosController.php";
$MantenimientosController = new MantenimientosController();

header('Content-Type: application/json');

// Validar método
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Método no permitido'
    ]);
    exit;
}

// Leer JSON
$input = file_get_contents("php://input");
$data = json_decode($input, true);

// DEBUG (CLAVE AHORA)
file_put_contents("debug.txt", $input . PHP_EOL, FILE_APPEND);

// Validar JSON
if (!$data) {
    echo json_encode([
        'success' => false,
        'message' => 'No llegó JSON válido'
    ]);
    exit;
}

// Validar datos
if (!isset($data['indice']) || !isset($data['ID_Mantenimiento']) ) {
    echo json_encode([
        'success' => false,
        'message' => 'Datos incompletos'
    ]);
    exit;
}

$ID_Mantenimiento = (int)$data['ID_Mantenimiento'];
$Indice = (int)$data['indice'];

if (!isset($ID_Mantenimiento) || $ID_Mantenimiento === '' || !isset($Indice) || $Indice === '' || !is_numeric($Indice) || (int)$Indice < 0){
    echo json_encode([
        'success' => false,
        'message' => 'Datos inválidos'
    ]);
    exit;
}

$resultado = $MantenimientosController->EliminarObservacionCorrectivo($ID_Mantenimiento, $Indice);

// Respuesta
if ($resultado) {
    echo json_encode([
        'success' => true,
        'message' => 'Observacion eliminada correctamente'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Error al eliminar la novedad'
    ]);
}

?>