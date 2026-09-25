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
if (!isset($data['ID_Novedad']) || !isset($data['ID_Mantenimiento']) || !isset($data['Tipo_Mantenimiento'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Datos incompletos'
    ]);
    exit;
}

$ID_Novedad = (int)$data['ID_Novedad'];
$ID_Mantenimiento = (int)$data['ID_Mantenimiento'];
$Tipo_Mantenimiento = $data['Tipo_Mantenimiento'];

if (empty($ID_Novedad) || empty($ID_Mantenimiento)) {
    echo json_encode([
        'success' => false,
        'message' => 'Datos vacíos'
    ]);
    exit;
}

$Tipo_Mantenimiento = isset($data['Tipo_Mantenimiento']) ? $data['Tipo_Mantenimiento'] : null;

$resultado = $MantenimientosController->EliminarNovedad($ID_Mantenimiento, $ID_Novedad, $Tipo_Mantenimiento);

// Respuesta
if ($resultado) {
    echo json_encode([
        'success' => true,
        'message' => 'Novedad eliminada correctamente'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Error al eliminar la novedad'
    ]);
}

?>