<?php
    session_start();    
    include_once "App/Controllers/MantenimientosController.php";
    header('Content-Type: application/json');
    $MantenimientosController = new MantenimientosController();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        /*  DATOS DEL DETALLE */
        $ID_Mantenimiento = intval($_POST['ID_Mantenimiento'] ?? 0);
        $DescripcionFalla = $_POST['DescripcionFalla'] ?? '';
        $DescripcionCorreccion = $_POST['DescripcionCorreccion'] ?? '';
        $Seccion = $_POST['Seccion'] ?? '';
        $ID_Novedad =!empty($_POST['ID_Novedad']) ? intval($_POST['ID_Novedad']) : null;
        $Fecha = date('Y-m-d');

        /* IMÁGENES */
        $Falla = $_FILES['Falla'] ?? null;
        $Correcciones = $_FILES['Correcciones'] ?? null;

        /* VALIDAR DATOS PRINCIPALES */
        if ($ID_Mantenimiento <= 0) {
            echo json_encode([
                'success' => false,
                'message' => 'ID de mantenimiento inválido'
            ]);
            exit;
        }

        /* RUTA DE IMÁGENES */
        $uploadDir ='App/Views/Upload/Img/Mantenimientos_Correctivos/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        /* TIPOS PERMITIDOS */
        $allowedTypes = [
            'image/jpeg',
            'image/png',
            'image/gif'
        ];
        try {
            /* GUARDAR EL DETALLE */
            $ID_Detalle = $MantenimientosController->GuardarDetallesCorrectivos($ID_Mantenimiento, $DescripcionFalla, $DescripcionCorreccion, $Seccion, $ID_Novedad, $Fecha);
            if (!$ID_Detalle) {
                throw new Exception('No se pudo guardar el detalle correctivo');
            }
            /* IMÁGENES DE FALLA */
            if ($Falla !== null && isset($Falla['name']) && is_array($Falla['name'])){
                foreach ($Falla['name'] as $i => $nombreOriginal) {
                    /* Error de subida */
                    if ($Falla['error'][$i] !== UPLOAD_ERR_OK){
                        throw new Exception('Error al subir una imagen de falla');
                    }
                    /* Tipo */
                    if (!in_array($Falla['type'][$i], $allowedTypes,true)){
                        throw new Exception('Tipo de imagen de falla no permitido');
                    }
                    /* Extensión */
                    $extension = strtolower( pathinfo($nombreOriginal, PATHINFO_EXTENSION));

                    /* Nombre */
                    $nombreArchivo ='Mantenimiento' . $ID_Mantenimiento . '_' . $ID_Detalle .'_Falla_' . uniqid() .'.' . $extension;
                    $rutaArchivo = $uploadDir . $nombreArchivo;

                    /* Mover archivo */
                    if (!move_uploaded_file($Falla['tmp_name'][$i],$rutaArchivo)){
                        throw new Exception('No se pudo guardar una imagen de falla');
                    }

                    /* Guardar BD */
                    $resultado =$MantenimientosController->GuardarImagenCorrectivo($ID_Mantenimiento, $ID_Detalle, $rutaArchivo,'falla');

                    /* IMPORTANTE: No hacemos echo aquí. Solo verificamos si realmente falló el INSERT. */
                    if ($resultado === false) {
                        if (file_exists($rutaArchivo)) {
                            unlink($rutaArchivo);
                        }
                        throw new Exception('Error al guardar imagen de falla en la base de datos');
                    }
                }
            }
            /* IMÁGENES DE CORRECCIÓN */
            if ($Correcciones !== null && isset($Correcciones['name']) && is_array($Correcciones['name'])){
                foreach ($Correcciones['name'] as $i => $nombreOriginal){
                    /* Error de subida */
                    if ($Correcciones['error'][$i] !== UPLOAD_ERR_OK){
                        throw new Exception('Error al subir una imagen de corrección');
                    }

                    /* Tipo */
                    if (!in_array($Correcciones['type'][$i], $allowedTypes, true)){
                        throw new Exception('Tipo de imagen de corrección no permitido');
                    }

                    /* Extensión */
                    $extension = strtolower(pathinfo($nombreOriginal, PATHINFO_EXTENSION));

                    /* Nombre */
                    $nombreArchivo ='Mantenimiento' . $ID_Mantenimiento . '_' . $ID_Detalle .'_Correccion_' . uniqid() .'.' . $extension;
                    $rutaArchivo = $uploadDir . $nombreArchivo;

                    /* Mover archivo */
                    if (!move_uploaded_file($Correcciones['tmp_name'][$i], $rutaArchivo)){
                        throw new Exception('No se pudo guardar una imagen de corrección');
                    }

                    /* Guardar BD */
                    $resultado = $MantenimientosController->GuardarImagenCorrectivo($ID_Mantenimiento, $ID_Detalle, $rutaArchivo, 'reparacion');
                    if ($resultado === false) {
                        if (file_exists($rutaArchivo)) {
                            unlink($rutaArchivo);
                        }
                        throw new Exception('Error al guardar imagen de corrección en la base de datos');
                    }
                }
            }
            /* ÚNICA RESPUESTA */
            echo json_encode([
                'success' => true,
                'message' => 'Detalle e imágenes guardados correctamente',
                'ID_Detalle' => $ID_Detalle
            ]);

            exit;   
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
            exit;
        }
    }
?>
    
