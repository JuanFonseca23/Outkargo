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

if (!isset($data['ID']) || empty($data['ID'])) {

    echo json_encode([
        'success' => false,
        'message' => 'ID de imagen no recibido'
    ]);

    exit;
}

$ID = $data['ID'];

$resultado =
    $MantenimientosController->EliminarImagen($ID);

if ($resultado) {

    echo json_encode([
        'success' => true,
        'message' => 'Imagen eliminada correctamente'
    ]);

} else {

    echo json_encode([
        'success' => false,
        'message' => 'Error al eliminar imagen'
    ]);
}