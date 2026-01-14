<?php
header('Content-Type: application/json; charset=utf-8');

include_once "App/Controllers/OrdenesCompraController.php";

$OrdenesCompraController = new OrdenesCompraController();
$data = $OrdenesCompraController->TraerOverhauling();

echo json_encode($data ?: []);
exit;
?>