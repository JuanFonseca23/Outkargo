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
    if (!isset($data['Observaciones']) || !isset($data['ID_Mantenimiento'])) {
        echo json_encode([
            'success' => false,
            'message' => 'Datos incompletos'
        ]);
        exit;
    }

    $Observaciones = $data['Observaciones'];
    $ID_Mantenimiento = $data['ID_Mantenimiento'];


    if (empty($Observaciones) || empty($ID_Mantenimiento)) {
        echo json_encode([
            'success' => false,
            'message' => 'Datos vacíos'
        ]);
        exit;
    }

    $Resultado = $MantenimientosController->GuardarObservaciones($ID_Mantenimiento, $Observaciones);
    // Respuesta
    if ($Resultado['success']) {
        echo json_encode([
            'success' => true,
            'message' => 'Observaciones guardadas correctamente',
            'observaciones' => $Resultado['observaciones']
        ]);

    } else {

        echo json_encode([
            'success' => false,
            'message' => $Resultado['message'] ?? 'Error al guardar las observaciones',
            'observaciones' => []
        ]);
    }
?>