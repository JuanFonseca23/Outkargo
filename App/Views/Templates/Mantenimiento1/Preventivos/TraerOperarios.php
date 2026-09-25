<?php
include_once "App/Controllers/MantenimientosController.php";
$MantenimientosController = new MantenimientosController();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $ID_Centro = intval($_GET['ID_Centro']);

    if ($ID_Centro) {
        echo json_encode($MantenimientosController->TraerOperarios($ID_Centro));
    } else {
        echo json_encode(["error" => "ID de centro no proporcionado."]);
    }
}
?>