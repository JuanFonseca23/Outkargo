<?php
header('Content-Type: application/json; charset=utf-8');

include_once "App/Controllers/OrdenesTrabajoController.php";

$OrdenesTrabajoController = new OrdenesTrabajoController();
$ID_Centro = $_GET['ID_Centro'] ?? null;
$data = $OrdenesTrabajoController->TraerMantenimientosC($ID_Centro);

echo json_encode($data ?: []);
exit;
?>