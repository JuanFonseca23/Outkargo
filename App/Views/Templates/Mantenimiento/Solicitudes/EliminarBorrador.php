<?php

include_once "App/Controllers/MantenimientosController.php";

$MantenimientosController =  new MantenimientosController();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    echo json_encode([
        'success' => false,
        'message' => 'Método no permitido'
    ]);

    exit;
}

$input = file_get_contents('php://input');

$data = json_decode($input, true);

if (!is_array($data)) {

    echo json_encode([
        'success' => false,
        'message' => 'JSON inválido'
    ]);

    exit;
}

if (!isset($data['ID_Mantenimiento']) || empty($data['ID_Mantenimiento'])) {

    echo json_encode([
        'success' => false,
        'message' => 'ID no recibido'
    ]);

    exit;
}

$ID = $data['ID_Mantenimiento'];
$Tipo_Mantenimiento = $data['Tipo_Mantenimiento'];

$Resultado = $MantenimientosController->EliminarBorrador($ID, $Tipo_Mantenimiento);

if ($Resultado) {

    echo json_encode([
        'success' => true,
        'message' => 'Mantenimiento eliminada correctamente'
    ]);

} else {

    echo json_encode([
        'success' => false,
        'message' => 'Error al eliminar el mantenimiento'
    ]);
}