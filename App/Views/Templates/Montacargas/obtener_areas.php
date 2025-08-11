<?php
include_once "App/Controllers/AreaController.php";

if (isset($_POST['ID_Centro'])) {
    $ID_Centro = $_POST['ID_Centro'];
    $AreaController = new AreaController();
    $areas = $AreaController->Leer($ID_Centro);
    header('Content-Type: application/json');
    echo json_encode($areas);
}
