<?php

session_start();
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

if (empty($_SESSION['ID'])) {

    echo json_encode([
        'success' => false,
        'message' => 'Sesión no válida'
    ]);

    exit;
}

$ID_Usuario = intval($_SESSION['ID']);
$borrador = $MantenimientosController->VerificarBorrador($ID_Usuario);

if ($borrador) {

    echo json_encode([
        'success' => true,
        'existe' => true,
        'ID_Mantenimiento' => $borrador['ID'],
        'borrador' => $borrador
    ]);

} else {

    echo json_encode([
        'success' => true,
        'existe' => false
    ]);
}