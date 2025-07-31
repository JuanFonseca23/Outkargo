<?php
date_default_timezone_set('America/Bogota');
session_start();
include_once "App/Controllers/InspeccionesController.php";
$InspeccionesController = new InspeccionesController();
if (empty($_SESSION['ID'])) {
    header("location:../IniciarSesion");
    exit;
}
$FechaHoy = date("d/m/Y");
$HoraActual = date("H:i:s");

$Cod = $_GET['Cod'];

$NombreEvaluada = $InspeccionesController->ObtenerNombreEvaluada($Cod);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>OUTKARGO - Administrador</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="description" content="OUTKARGO ofrece servicios de alquiler de montacargas con y sin operador en Colombia.">
    <meta name="keywords" content="OUTKARGO, alquiler de montacargas, montacargas, Colombia, Toma Pedido, Lift, Diesel, Gas">
    <link rel="icon" href="../Favicon.ico" type="image/x-icon">

    <!-- JavaScript -->
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- CSS -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css" />
    <!-- Google Web Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">  
    <!-- CSS y JS de Alertify -->
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>
    <!-- Signature Pad -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.5.3/signature_pad.min.js"></script>
</head>

<body>
<h2>Firma <?= $NombreEvaluada ?></h2>
    <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['Tipo']) && $_POST['Tipo'] == "1") {
                $Firma = isset($_POST['firma']) ? $_POST['firma'] : '';
                $InspeccionesController->FirmarEvaluada($Cod, $Firma);
            }
        }    
    ?>
    <form method="post">
        <!-- Campo para la firma -->
        <canvas id="signature-pad" width="400" height="200" style="border: 2px solid #000; border-radius: 5px;"></canvas>
        <input type="hidden" name="firma" id="firma">
        <input type="hidden" name="Tipo" value="1">
        <br>
        <button type="submit">Guardar Firma</button>
    </form>
    <button id="clear-button">Borrar</button>

    <script>
        // Inicializa Signature Pad
        var canvas = document.getElementById('signature-pad');
        var signaturePad = new SignaturePad(canvas);

        // Botón para borrar la firma
        document.getElementById('clear-button').addEventListener('click', function () {
            signaturePad.clear();
        });

        // Al enviar el formulario, guarda la firma en un campo oculto
        document.querySelector('form').onsubmit = function () {
            if (!signaturePad.isEmpty()) {
                document.getElementById('firma').value = signaturePad.toDataURL();  // Guardar como base64
            } else {
                alertify.error("Por favor, firma antes de enviar.");
                return false;  // Previene el envío si no hay firma
            }
        };
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>