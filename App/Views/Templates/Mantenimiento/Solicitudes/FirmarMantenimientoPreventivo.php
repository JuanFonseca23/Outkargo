<?php

session_start();

include_once "App/Controllers/MantenimientosController.php";

header('Content-Type: application/json; charset=utf-8');

$MantenimientosController = new MantenimientosController();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    echo json_encode([
        "success" => false,
        "message" => "Método no permitido"
    ]);

    exit;
}

try {
    // 1. LEER JSON
    $input = file_get_contents('php://input');
    error_log("JSON recibido FirmarMantenimientoPreventivoTecnicos: " . $input);
    $data = json_decode($input, true);
    if (!is_array($data)) {
        echo json_encode([
            "success" => false,
            "message" => "JSON inválido"
        ]);
        exit;
    }

    // 2. OBTENER DATOS
    $ID_Mantenimiento =intval($data['ID_Mantenimiento'] ?? 0);
    $Tipo =strtolower(trim($data['Tipo'] ?? ''));
    $ID_Mecanico2 = intval($data['ID_Mecanico2'] ?? null);
    $Firma = $data['Firma'] ?? null;
    $Fecha =date('Y-m-d');
    $Estado = 1;

    // 3. DEBUG
    error_log( "ID_Mantenimiento: {$ID_Mantenimiento}");
    error_log("Tipo: {$Tipo}");
    error_log("ID_Mecanico2: {$ID_Mecanico2}");
    error_log("Firma: " . ($Firma ?? 'NULL'));

    // 4. VALIDAR MANTENIMIENTO
    if ($ID_Mantenimiento <= 0) {
        echo json_encode([
            "success" => false,
            "message" => "ID_Mantenimiento inválido"
        ]);
        exit;
    }

    // 5. VALIDAR TIPO
    $tiposPermitidos = [
        'supervisor',
        'operario',
        'mecanico'
    ];

    if (!in_array($Tipo, $tiposPermitidos, true)) {
        echo json_encode([
            "success" => false,
            "message" => "Tipo de usuario no reconocido"
        ]);
        exit;
    }

    // 6. VALIDAR FIRMA
    if (empty($Firma)) {
        echo json_encode([
            "success" => false,
            "message" => "Firma es requerida"
        ]);
        exit;
    }

    // 7. GUARDAR FIRMA
    if ($Tipo === 'supervisor') {
        $Resultado = $MantenimientosController->FirmarMantenimientoPreventivoSupervisor($ID_Mantenimiento, $Fecha, $Firma, $Estado);
    } elseif ($Tipo === 'operario') {
        $Resultado = $MantenimientosController->FirmarMantenimientoPreventivoOperario($ID_Mantenimiento, $Fecha, $Firma, $Estado);
    } elseif ($Tipo === 'mecanico') {
        // El mecánico SÍ necesita su ID
        if ($ID_Mecanico2 <= 0) {
            echo json_encode([
                "success" => false,
                "message" => "ID del mecánico inválido"
            ]);
            exit;
        }
        $Resultado = $MantenimientosController->FirmarMantenimientoPreventivoMecanico($ID_Mantenimiento, $ID_Mecanico2, $Fecha, $Firma, $Estado);
    }


    // ==========================================
    // 8. RESPUESTA
    // ==========================================

    if ($Resultado) {

        echo json_encode([
            "success" => true,
            "message" => "Firma guardada correctamente"
        ]);

    } else {

        echo json_encode([
            "success" => false,
            "message" => "No se pudo guardar la firma"
        ]);
    }


} catch (Throwable $e) {

    error_log(
        "ERROR FIRMAS MANTENIMIENTO: "
        . $e->getMessage()
    );

    error_log(
        "Archivo: "
        . $e->getFile()
        . " Línea: "
        . $e->getLine()
    );

    echo json_encode([
        "success" => false,
        "message" => "Error interno: " . $e->getMessage()
    ]);
}
exit;