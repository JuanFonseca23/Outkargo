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
if (!isset($data['Novedades']) || !isset($data['ID_Mantenimiento']) || !isset($data['ID_Montacargas']) || !isset($data['Tipo_Mantenimiento'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Datos incompletos'
    ]);
    exit;
}

$Novedades = $data['Novedades'];
$ID_Mantenimiento = $data['ID_Mantenimiento'];
$ID_Montacargas = $data['ID_Montacargas'];
$Tipo_Mantenimiento = $data['Tipo_Mantenimiento'];

if (empty($Novedades) || empty($ID_Mantenimiento) || empty($ID_Montacargas) || empty($Tipo_Mantenimiento)) {
    echo json_encode([
        'success' => false,
        'message' => 'Datos vacíos'
    ]);
    exit;
}

$resultado = $MantenimientosController->GuardarNovedades($ID_Mantenimiento, $Novedades, $ID_Montacargas, $Tipo_Mantenimiento);

// Respuesta
if ($resultado['success']) {

    echo json_encode([
        'success' => true,
        'message' => 'Novedades guardadas correctamente',
        'novedades' => $resultado['novedades']
    ]);

} else {

    echo json_encode([
        'success' => false,
        'message' => $resultado['message'] ?? 'Error al guardar las novedades',
        'novedades' => []
    ]);
}
?>