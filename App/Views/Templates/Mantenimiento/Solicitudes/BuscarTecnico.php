<?php
include_once "App/Controllers/MantenimientosController.php";
$MantenimientosController = new MantenimientosController();


// Endpoint para AJAX
if (isset($_GET['Documento'])) {
    $No_Documento = $_GET['Documento'];
    $resultado = $MantenimientosController->BuscarPersona($No_Documento);

    header('Content-Type: application/json');
    if ($resultado) {
        echo json_encode([
            "ID" => $resultado['ID'],
            "NombreCompleto" => $resultado['NombreCompleto']
        ]);
    } else {
        echo json_encode(null);
    }
    exit;
}
?>