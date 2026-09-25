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
        $input = file_get_contents('php://input');
        error_log("JSON recibido FinalizarMantenimiento: " . $input);
        $data = json_decode($input, true);
        if (!is_array($data)) {
            echo json_encode([
                "success" => false,
                "message" => "JSON inválido"
            ]);
            exit;
        }

        $ID_Mantenimiento = intval($data['ID_Mantenimiento'] ?? 0);
        $ID_Montacargas = intval($data['ID_Montacargas'] ?? 0);
        $ID_Supervisor = intval($data['ID_Supervisor'] ?? 0);
        $HoraInicio = $data['HoraInicio'] ?? null;
        $HoraFinal = $data['HoraFinal'] ?? null;
        $Horometro = $data['Horometro'] ?? null;
        $Externo_Recibe = intval($data['Externo_Recibe'] ?? 0);
        $ID_Recibe = !empty($data['ID_Recibe']) ? intval($data['ID_Recibe']) : null;
        $Nombre_Recibe = !empty($data['Nombre_Recibe']) ? trim($data['Nombre_Recibe']) : null;

        error_log(
            "Datos: ID_Mantenimiento={$ID_Mantenimiento}, " .
            "ID_Montacargas={$ID_Montacargas}".
            "ID_Supervisor={$ID_Supervisor}, " .
            "HoraInicio={$HoraInicio}, " .
            "HoraFinal={$HoraFinal}, " .
            "Horometro={$Horometro}, " .
            "Externo_Recibe={$Externo_Recibe}, " .
            "ID_Recibe=" . ($ID_Recibe ?? 'NULL') . ", " .
            "Nombre_Recibe=" . ($Nombre_Recibe ?? 'NULL')
        );

        if ($ID_Mantenimiento <= 0) {
            echo json_encode([
                "success" => false,
                "message" => "ID_Mantenimiento inválido"
            ]);

            exit;
        }

        if ($ID_Montacargas <= 0) {
            echo json_encode([
                "success" => false,
                "message" => "ID_Montacargas inválido"
            ]);

            exit;
        }

        if ($ID_Supervisor <= 0) {
            echo json_encode([
                "success" => false,
                "message" => "Debe seleccionar un supervisor"
            ]);
            exit;
        }

        if (empty($HoraInicio)) {
            echo json_encode([
                "success" => false,
                "message" => "Hora de inicio no recibida"
            ]);
            exit;
        }

        if (empty($HoraFinal)) {
            echo json_encode([
                "success" => false,
                "message" => "Hora final no recibida"
            ]);
            exit;
        }

        if ($Horometro === null || $Horometro === '') {
            echo json_encode([
                "success" => false,
                "message" => "Horómetro no recibido"
            ]);
            exit;
        }


        if ($Externo_Recibe === 0) {
            $Externo = 'No';
            $Nombre_Recibe = null;
            if (empty($ID_Recibe)) {
                echo json_encode([
                    "success" => false,
                    "message" => "Debe seleccionar quién recibe"
                ]);
                exit;
            }

        } else {
            $Externo = 'Si';
            $ID_Recibe = null;
            if (empty($Nombre_Recibe)) {
                echo json_encode([
                    "success" => false,
                    "message" => "Debe ingresar el nombre de quien recibe"
                ]);
                exit;
            }
        }


        $Resultado = $MantenimientosController->FinalizarMantenimiento($ID_Mantenimiento, $ID_Supervisor, $HoraInicio, $HoraFinal, $Externo, $ID_Recibe, $Nombre_Recibe, $Horometro, $ID_Montacargas);
        if ($Resultado) {

            echo json_encode([
                "success" => true,
                "message" => "Mantenimiento finalizado correctamente"
            ]);

        } else {

            echo json_encode([
                "success" => false,
                "message" => "No se pudo finalizar el mantenimiento"
            ]);
        }

    } catch (Throwable $e) {

        error_log("ERROR FINALIZAR MANTENIMIENTO: " . $e->getMessage());
        error_log("Archivo: " . $e->getFile() . " Línea: " . $e->getLine());
        echo json_encode([
            "success" => false,
            "message" => "Error interno: " . $e->getMessage()
        ]);
    }

exit;