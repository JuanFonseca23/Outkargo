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
if (!isset($data['ID_Insumo']) || !isset($data['ID_Mantenimiento']) || !isset($data['Tipo_Mantenimiento']) ) {
    echo json_encode([
        'success' => false,
        'message' => 'Datos incompletos'
    ]);
    exit;
}

$ID_Insumo = (int)$data['ID_Insumo'];
$ID_Mantenimiento = (int)$data['ID_Mantenimiento'];
$Tipo_Mantenimiento = $data['Tipo_Mantenimiento'];

if (empty($ID_Insumo) || empty($ID_Mantenimiento) || empty($Tipo_Mantenimiento)) {
    echo json_encode([
        'success' => false,
        'message' => 'Datos vacíos'
    ]);
    exit;
}

$resultado = $MantenimientosController->EliminarInsumo($ID_Mantenimiento, $ID_Insumo, $Tipo_Mantenimiento);

// Respuesta
if ($resultado) {
    echo json_encode([
        'success' => true,
        'message' => 'Insumo eliminado correctamente'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Error al eliminar el insumo'
    ]);
}

?>