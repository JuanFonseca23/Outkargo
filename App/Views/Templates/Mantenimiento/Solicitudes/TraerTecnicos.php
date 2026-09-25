<?php
    include_once "App/Controllers/MantenimientosController.php";
    $MantenimientosController = new MantenimientosController();

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        echo json_encode($MantenimientosController->TraerTecnicos());
    }
?>