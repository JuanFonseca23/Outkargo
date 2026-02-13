<?php
header('Content-Type: application/json; charset=utf-8');

include_once "App/Controllers/OrdenesTrabajoController.php";

$OrdenesTrabajoController = new OrdenesTrabajoController();
$data = $OrdenesTrabajoController->TraerSolicitud();

echo json_encode($data ?: []);
exit;
?>