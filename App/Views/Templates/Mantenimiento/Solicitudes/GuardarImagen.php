<?php

include_once "App/Controllers/MantenimientosController.php";

$MantenimientosController = new MantenimientosController();

header('Content-Type: application/json');

error_log("===== INICIO GUARDAR IMAGEN =====");

// Validar método
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    echo json_encode([
        'success' => false,
        'message' => 'Método no permitido'
    ]);

    exit;
}

// Validar datos
if (
    !isset($_POST['ID_Mantenimiento']) ||
    !isset($_POST['Categoria']) ||
    !isset($_FILES['imagen'])
) {

    echo json_encode([
        'success' => false,
        'message' => 'Datos incompletos'
    ]);

    exit;
}

$ID_Mantenimiento = $_POST['ID_Mantenimiento'];
$Categoria        = $_POST['Categoria'];
$Archivo          = $_FILES['imagen'];

// Validar ID y categoría
if (empty($ID_Mantenimiento) || empty($Categoria)) {

    echo json_encode([
        'success' => false,
        'message' => 'Datos vacíos'
    ]);

    exit;
}

// Validar error de subida
if ($Archivo['error'] !== UPLOAD_ERR_OK) {

    echo json_encode([
        'success' => false,
        'message' => 'Error al subir la imagen'
    ]);

    exit;
}

// Ruta donde se almacenarán las imágenes
$uploadDir = 'App/Views/Upload/Img/Mantenimientos_Preventivos/';

// Crear carpeta si no existe
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// Tipos permitidos
$allowedTypes = [
    'image/jpeg',
    'image/png',
    'image/gif'
];

if (!in_array($Archivo['type'], $allowedTypes, true)) {

    echo json_encode([
        'success' => false,
        'message' => 'Tipo de imagen no permitido'
    ]);

    exit;
}

// Obtener extensión
$extension = strtolower(
    pathinfo($Archivo['name'], PATHINFO_EXTENSION)
);

// Generar nombre único
$NombreFoto =
    'Mantenimiento' .
    $ID_Mantenimiento .
    '_' .
    preg_replace('/[^a-zA-Z0-9_-]/', '_', $Categoria) .
    '_' .
    uniqid() .
    '.' .
    $extension;

$uploadFile = $uploadDir . $NombreFoto;

error_log("Archivo destino: " . $uploadFile);

// Mover archivo
if (!move_uploaded_file($Archivo['tmp_name'], $uploadFile)) {

    echo json_encode([
        'success' => false,
        'message' => 'No se pudo guardar físicamente la imagen'
    ]);

    exit;
}

// Guardar registro en BD
$resultado = $MantenimientosController->GuardarImagen(
    $ID_Mantenimiento,
    $Categoria,
    $uploadFile
);

if ($resultado) {

    echo json_encode([
        'success' => true,
        'message' => 'Imagen guardada correctamente',
        'id'      => $resultado['id'],
        'ruta'    => $resultado['ruta']
    ]);

} else {

    // Si falló el INSERT, eliminamos el archivo
    // para no dejarlo huérfano.
    if (file_exists($uploadFile)) {
        unlink($uploadFile);
    }

    echo json_encode([
        'success' => false,
        'message' => 'Error al guardar imagen'
    ]);
}

error_log("===== FIN GUARDAR IMAGEN =====");

?>