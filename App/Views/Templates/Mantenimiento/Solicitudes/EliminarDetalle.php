<?php
    include_once "App/Controllers/MantenimientosController.php";
    $MantenimientosController = new MantenimientosController();
    header('Content-Type: application/json; charset=utf-8');
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
    // DEBUG
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
    if (!isset($data['ID_Detalle'])){
        echo json_encode([
            'success' => false,
            'message' => 'Datos incompletos'
        ]);
        exit;
    }
    $ID_Detalle = (int)$data['ID_Detalle'];
    $ID_Novedad = (int)$data['ID_Novedad'];
    // Validar ID_Detalle
    if (empty($ID_Detalle)) {
        echo json_encode([
            'success' => false,
            'message' => 'ID_Detalle vacío'
        ]);
        exit;
    }
    // Ejecutar eliminación
    $resultado = $MantenimientosController->EliminarDetalle($ID_Detalle, $ID_Novedad);
    // Respuesta
    if ($resultado) {
        echo json_encode([
            'success' => true,
            'message' => 'Detalle eliminado correctamente'
        ]);

    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Error al eliminar el detalle'
        ]);
    }
    exit;
?>