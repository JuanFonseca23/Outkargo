<?php
session_start();
include_once "App/Controllers/MantenimientosController.php";

header('Content-Type: application/json');

$MantenimientosController = new MantenimientosController();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $ID_Centro = intval($_POST['ID_Centro1']);
    $ID_Area = intval($_POST['ID_Area']);
    $ID_Montacargas = intval($_POST['ID_Montacargas']);
    $ID_Operario = intval($_POST['ID_Operario']);
    $ID_Usuario = $_SESSION['ID'];

    if (!empty($ID_Operario)) {
        $Externo = 'No';
        $Operario_Externo = null;
    } else {
        $Externo = 'Si';
        $Operario_Externo = $_POST['OperarioExterno'] ?? null;
        $ID_Operario = null;
    }

    $TipoMontacargas = $_POST['tipoMontacargas'];
    $TipoMantenimiento = $_POST['tipoMantenimiento'];
    $Fecha = date("d/m/Y");

    try {
        $Resultados = $MantenimientosController->CrearMantenimientoBorrador($ID_Usuario, $ID_Montacargas, $ID_Centro, $ID_Area, $ID_Operario, $Fecha, $Externo, $Operario_Externo, $TipoMontacargas, $TipoMantenimiento);    
        $ID_Mantenimiento = $Resultados[0];
        $Detalles = $Resultados[1];
        $ID_Detalle = $Resultados[2];
        echo json_encode([
            "success" => true,
            "ID_Mantenimiento" => $ID_Mantenimiento,
            "Detalles" => $Detalles,
            "ID_Detalle" => $ID_Detalle,
            "ID_Montacargas" => $ID_Montacargas
        ]);

    } catch (Exception $e) {

        echo json_encode([
            "success" => false,
            "message" => $e->getMessage()
        ]);
    }

    exit;
}
?>