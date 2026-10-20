
<?php
    session_start();
    header('Content-Type: application/json; charset=utf-8');
    include_once "App/Controllers/MantenimientosController.php";
    $MantenimientosController = new MantenimientosController();
    try {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode([
                'success' => false,
                'message' => 'Método no permitido'
            ]);
            exit;
        }
        // DATOS DEL DETALLE
        $ID_Detalle = intval($_POST['ID_Detalle'] ?? 0);
        $ID_Mantenimiento = intval($_POST['ID_Mantenimiento'] ?? 0);
        $Categoria = trim($_POST['Categoria'] ?? '');
        $Descripcion = trim($_POST['Descripcion'] ?? '');
        $Seccion = trim($_POST['Seccion'] ?? '');
        // VALIDAR DATOS PRINCIPALES
        if ($ID_Detalle <= 0) {
            throw new Exception('ID de detalle inválido');
        }
        // LEER LOS IDS DE LAS IMÁGENES MARCADAS PARA ELIMINAR
        $imagenesEliminar = json_decode( $_POST['imagenesEliminar'] ?? '[]', true);
        if (!is_array($imagenesEliminar)) {
            throw new Exception('La lista de imágenes por eliminar no es válida');
        }
        // VALIDAR IDS RECIBIDOS
        foreach ($imagenesEliminar as $idImagen) {
            if (!is_numeric($idImagen) || intval($idImagen) <= 0) {
                throw new Exception('Se recibió un ID de imagen inválido');
            }
        }

        /* 1. ACTUALIZAR EL DETALLE Se conserva tu método actual.*/
        $resultado = $MantenimientosController->ActualizarDetallesCorrectivos($ID_Detalle, $Categoria, $Descripcion, $Seccion);
        if (!$resultado) {
            throw new Exception('No se pudo actualizar el detalle');
        }

        /* RUTA DE IMÁGENES */
$uploadDir = 'App/Views/Upload/Img/Mantenimientos_Correctivos/';

if (!is_dir($uploadDir)) {
    if (!mkdir($uploadDir, 0755, true) && !is_dir($uploadDir)) {
        throw new Exception('No se pudo crear la carpeta de imágenes');
    }
}

/* TIPOS PERMITIDOS */
$allowedTypes = [
    'image/jpeg' => 'jpg',
    'image/png'  => 'png',
    'image/gif'  => 'gif'
];

/* GUARDAR LAS IMÁGENES NUEVAS */
if (
    isset($_FILES['nuevasImagenes']) &&
    is_array($_FILES['nuevasImagenes']['name'])
) {
    $archivos = $_FILES['nuevasImagenes'];

    foreach ($archivos['name'] as $i => $nombreOriginal) {

        // Ignorar espacios vacíos
        if ($nombreOriginal === '') {
            continue;
        }

        /* ERROR DE SUBIDA */
        if ($archivos['error'][$i] !== UPLOAD_ERR_OK) {
            throw new Exception(
                'Error al subir la imagen: ' . $nombreOriginal
            );
        }

        /* VALIDAR TIPO REAL DEL ARCHIVO */
        $tmpName = $archivos['tmp_name'][$i];
        $tipoReal = mime_content_type($tmpName);

        if (!isset($allowedTypes[$tipoReal])) {
            throw new Exception(
                'Tipo de imagen no permitido: ' . $nombreOriginal
            );
        }

        /* EXTENSIÓN VALIDADA */
        $extension = $allowedTypes[$tipoReal];

        /* NOMBRE DEL ARCHIVO */
        $nombreArchivo =
            'Mantenimiento' . $ID_Mantenimiento . '_' .
            $ID_Detalle . '_' .
            $Categoria . '_' .
            uniqid() . '.' . $extension;

        $rutaArchivo = $uploadDir . $nombreArchivo;

        /* MOVER ARCHIVO */
        if (!move_uploaded_file($tmpName, $rutaArchivo)) {
            throw new Exception(
                'No se pudo guardar la imagen: ' . $nombreOriginal
            );
        }

        /* GUARDAR EN BASE DE DATOS */
        $resultado = $MantenimientosController->GuardarImagenCorrectivo(
            $ID_Mantenimiento,
            $ID_Detalle,
            $rutaArchivo,
            $Categoria
        );

        if ($resultado === false) {
            if (file_exists($rutaArchivo)) {
                unlink($rutaArchivo);
            }

            throw new Exception(
                'Error al guardar la imagen en la base de datos'
            );
        }
    }
}
        /* 3. ELIMINAR LAS IMÁGENES EXISTENTES */
        if (!empty($imagenesEliminar)) {
            $resultadoEliminar =
                $MantenimientosController->EliminarImagenCorrectivo($ID_Detalle, $imagenesEliminar);
            if (!$resultadoEliminar) {
                throw new Exception('No se pudieron eliminar las imágenes');
            }
        }
        echo json_encode([
            'success' => true,
            'message' => 'Detalle e imágenes procesados correctamente'
        ]);
    } catch (Throwable $e) {
        http_response_code(400);

        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
?>
