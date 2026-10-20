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

    // Validar JSON
    if (!$data) {
        echo json_encode([
            'success' => false,
            'message' => 'No llegó JSON válido'
        ]);
        exit;
    }

    // Validar datos
    if (!isset($data['Repuestos']) || !isset($data['ID_Mantenimiento']) || !isset($data['ID_Montacargas'])) {
        echo json_encode([
            'success' => false,
            'message' => 'Datos incompletos'
        ]);
        exit;
    }

    $Repuestos = $data['Repuestos'];
    $ID_Mantenimiento = $data['ID_Mantenimiento'];
    $Tipo_Mantenimiento = $data['Tipo_Mantenimiento'];
    $ID_Montacargas = $data['ID_Montacargas'];

    if (empty($Repuestos) || empty($ID_Mantenimiento)  || empty($Tipo_Mantenimiento) || empty($ID_Montacargas)) {
        echo json_encode([
            'success' => false,
            'message' => 'Datos vacíos'
        ]);
        exit;
    }

    $resultado = $MantenimientosController->GuardarRepuestos($ID_Mantenimiento, $ID_Montacargas, $Repuestos, $Tipo_Mantenimiento);

    // Respuesta
    if ($resultado) {
        echo json_encode([
            'success' => true,
            'message' => 'Repuestos guardados correctamente'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Error al guardar los repuestos'
        ]);
    }
?>
