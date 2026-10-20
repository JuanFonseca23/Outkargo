<?php
    include_once "App/Controllers/MantenimientosController.php";
    $MantenimientosController = new MantenimientosController();
    header('Content-Type: application/json');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $input = json_decode(file_get_contents('php://input'),true);
        $ID_Mantenimiento = intval($input['ID_Mantenimiento'] ?? 0);
        if (!$ID_Mantenimiento) {
            echo json_encode([
                "success" => false,
                "message" => "ID de mantenimiento no proporcionado."
            ]);
            exit;
        }
        try {
            $Detalles = $MantenimientosController->TraerDetallesCorrectivos($ID_Mantenimiento);
            echo json_encode([
                "success" => true,
                "detalles" => $Detalles['detalles'],
                "imagenes" => $Detalles['imagenes']
            ]);
            exit;
        } catch (Exception $e) {
            echo json_encode([
                "success" => false,
                "message" => $e->getMessage()
            ]);
            exit;
        }
    }
?>