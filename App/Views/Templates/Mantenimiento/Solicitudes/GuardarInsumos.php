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
file_put_contents("debug.txt", $input);

// Validar JSON
if (!$data) {
    echo json_encode([
        'success' => false,
        'message' => 'No llegó JSON válido'
    ]);
    exit;
}

// Validar datos
if (!isset($data['Insumos']) || !isset($data['ID_Mantenimiento'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Datos incompletos'
    ]);
    exit;
}

$Insumos = $data['Insumos'];
$ID_Mantenimiento = $data['ID_Mantenimiento'];
$Tipo_Mantenimiento = $data['Tipo_Mantenimiento'];

if (empty($Insumos) || empty($ID_Mantenimiento)  || empty($Tipo_Mantenimiento)) {
    echo json_encode([
        'success' => false,
        'message' => 'Datos vacíos'
    ]);
    exit;
}

$resultado = $MantenimientosController->GuardarInsumos($ID_Mantenimiento, $Insumos, $Tipo_Mantenimiento);

// Respuesta
if ($resultado) {
    echo json_encode([
        'success' => true,
        'message' => 'Insumos guardados correctamente'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Error al guardar los insumos'
    ]);
}
?>