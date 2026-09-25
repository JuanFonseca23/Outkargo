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

    $ID_Mantenimiento = intval($data['ID_Mantenimiento'] ?? 0);
    $ID_Supervisor1 = intval($data['ID_Supervisor1'] ?? 0);
    $ID_Centro = intval($data['ID_Centro'] ?? 0);
    $Correo_Supervisor1 = !empty($data['Correo_Supervisor1']) ? trim($data['Correo_Supervisor1']) : null;
    $Nombre_Supervisor1 = !empty($data['Nombre_Supervisor1']) ? trim($data['Nombre_Supervisor1']) : null;
    $Tipo_Mantenimiento = !empty($data['Tipo_Mantenimiento']) ? trim($data['Tipo_Mantenimiento']) : null;
    $Tipo_Montacargas = !empty($data['Tipo_Montacargas']) ? trim($data['Tipo_Montacargas']) : null;
    $Firmas = $data['Firmas'] ?? [];
    $Insumos = $data['Insumos'] ?? [];
    $Mantenimiento = 'Mantenimiento Preventivo';

    // 3. DEBUG

    error_log("ID_Mantenimiento: {$ID_Mantenimiento}");
    error_log("ID_Supervisor1: {$ID_Supervisor1}");
    error_log("ID_Centro: {$ID_Centro}");
    error_log("Correo_Supervisor1: " .($Correo_Supervisor1 ?? 'NULL'));
    error_log("Nombre_Supervisor1: " .($Nombre_Supervisor1 ?? 'NULL'));
    error_log("Tipo_Mantenimiento: " .($Tipo_Mantenimiento ?? 'NULL'));
    error_log("Tipo_Montacargas: " .($Tipo_Montacargas ?? 'NULL'));
    error_log("Cantidad de firmas: " .count($Firmas));

    // 4. VALIDACIONES

    if ($ID_Mantenimiento <= 0) {
        echo json_encode([
            "success" => false,
            "message" => "ID_Mantenimiento inválido"
        ]);
        exit;
    }

    if ($ID_Supervisor1 <= 0) {
        echo json_encode([
            "success" => false,
            "message" => "ID del supervisor inválido"
        ]);
        exit;
    }

    if ($ID_Centro <= 0) {
        echo json_encode([
            "success" => false,
            "message" => "ID del Centro de trabajo no inválido"
        ]);
        exit;
    }

    if (!is_array($Firmas) || count($Firmas) === 0) {
        echo json_encode([
            "success" => false,
            "message" => "No se recibieron firmas"
        ]);
        exit;
    }

    // 5. VALIDAR CADA FIRMA
    foreach ($Firmas as $index => $firma) {
        $ID_Tecnico = intval($firma['ID_Tecnico'] ?? 0);
        $Nombre = !empty($firma['Nombre']) ? trim($firma['Nombre']): null;
        $Firma =!empty($firma['Firma']) ? trim($firma['Firma']): null;

        if ($ID_Tecnico <= 0) {
            echo json_encode([
                "success" => false,
                "message" =>"El técnico de la firma " . ($index + 1) . " no es válido"
            ]);
            exit;
        }

        if (empty($Firma)) {
            echo json_encode([
                "success" => false,
                "message" => "La firma del técnico " . ($Nombre ?? $ID_Tecnico) . " está vacía"
            ]);
            exit;
        }

        error_log("Firma {$index}: " . "ID_Tecnico={$ID_Tecnico}, " . "Nombre={$Nombre}");
    }

    //Campos para la salida 
    foreach ($Firmas as $Usuario){
        $ID_Usuario = intval($Usuario['ID_Tecnico'] ?? 0);
        $NombreCreo = $Usuario['Nombre'] ?? null;
        $FirmaSalida = $Usuario['Firma'] ?? null;
        break;
    }

    // 6. LLAMAR AL CONTROLADOR
    $Resultado = $MantenimientosController->FirmarMantenimientoPreventivoTecnicos($ID_Mantenimiento, $Firmas, $ID_Supervisor1, $Correo_Supervisor1, $Nombre_Supervisor1, $Tipo_Mantenimiento, $Tipo_Montacargas);

    // 7. RESPUESTA
    if ($Resultado) {
        //Realizar Salida
        $MantenimientosController->RealizarSalidaMantenimiento($ID_Mantenimiento, $ID_Usuario, $NombreCreo, $ID_Centro, $FirmaSalida, $Mantenimiento, $Insumos);
        echo json_encode([
            "success" => true,
            "message" => "Firmas guardadas correctamente"
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "No se pudieron guardar las firmas"
        ]);
    }

} catch (Throwable $e) {

    error_log("ERROR FIRMAS MANTENIMIENTO: " . $e->getMessage());

    error_log("Archivo: " . $e->getFile() . " Línea: " . $e->getLine());
    echo json_encode([
        "success" => false,
        "message" => "Error interno: " . $e->getMessage()
    ]);
}

exit;