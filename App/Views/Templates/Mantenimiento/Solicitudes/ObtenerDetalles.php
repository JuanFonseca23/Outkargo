<?php

include_once "App/Controllers/MantenimientosController.php";

$MantenimientosController = new MantenimientosController();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {

    echo json_encode([
        'success' => false,
        'message' => 'Método no permitido'
    ]);

    exit;
}

if (!isset($_GET['ID_Mantenimiento'])) {

    echo json_encode([
        'success' => false,
        'message' => 'ID_Mantenimiento no recibido'
    ]);

    exit;
}

$ID_Mantenimiento = intval($_GET['ID_Mantenimiento']);

if ($ID_Mantenimiento <= 0) {
    echo json_encode([
        'success' => false,
        'message' => 'ID_Mantenimiento inválido'
    ]);

    exit;
}

$resultado = $MantenimientosController->ObtenerMantenimientoCompleto( $ID_Mantenimiento);

if ($resultado) {

    echo json_encode([
        'success' => true,
        'data' => $resultado
    ]);

} else {

    echo json_encode([
        'success' => false,
        'message' => 'No se encontró el mantenimiento'
    ]);
}