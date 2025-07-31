<?php
include_once "App/Controllers/TicketsController.php";
$chatController = new TicketsController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_ticket = $_POST['ID_Ticket'];
    $id_remitente = $_POST['ID_Remitente'];
    $id_destinatario = $_POST['ID_Destinatario'];
    $mensaje = $_POST['Mensaje'];
    $Evidencia_Fotografica = $_FILES['Evidencia_Fotografica'] ?? null;
    $chatController->sendMessage($id_ticket, $id_remitente, $id_destinatario, $mensaje, $Evidencia_Fotografica);
    
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id_ticket = $_GET['id_ticket'];
    echo json_encode($chatController->getMessages($id_ticket));
}
?>