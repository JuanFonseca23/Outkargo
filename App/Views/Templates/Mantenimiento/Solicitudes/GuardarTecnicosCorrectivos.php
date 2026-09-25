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
if (!isset($data['ID_Tecnicos']) || !isset($data['ID_Mantenimiento'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Datos incompletos'
    ]);
    exit;
}

$ID_Tecnicos = $data['ID_Tecnicos'];
$ID_Mantenimiento = $data['ID_Mantenimiento'];

if (empty($ID_Tecnicos) || empty($ID_Mantenimiento)) {
    echo json_encode([
        'success' => false,
        'message' => 'Datos vacíos'
    ]);
    exit;
}

$resultado = $MantenimientosController->GuardarTecnicosCorrectivo($ID_Mantenimiento, $ID_Tecnicos);

// Respuesta
if ($resultado) {
    echo json_encode([
        'success' => true,
        'message' => 'Técnicos guardados correctamente'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Error al guardar los técnicos'
    ]);
}
?>