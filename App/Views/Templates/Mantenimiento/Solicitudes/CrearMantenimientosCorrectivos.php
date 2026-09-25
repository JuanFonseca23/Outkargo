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
    $Fecha = date('Y-m-d');
    try {
        $Resultados = $MantenimientosController->CrearMantenimientoCorrectivoBorrador($ID_Usuario, $ID_Montacargas, $ID_Centro, $ID_Area, $ID_Operario, $Fecha, $Externo, $Operario_Externo);    
        $ID_Mantenimiento = $Resultados[0];
        $Detalles = $Resultados[1];
        $Novedades = $Resultados[2];
        echo json_encode([
            "success" => true,
            "ID_Mantenimiento" => $ID_Mantenimiento,
            "Detalles" => $Detalles,
            "Novedades" => $Novedades,
            "ID_Montacargas" => $ID_Montacargas,
            "ID_Centro" => $ID_Centro,
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