<?php
    session_start();
    if (empty($_SESSION['ID'])) {
        header("location:../IniciarSesion");
        exit;
    }

    include_once "App/Controllers/UsuarioController.php";
    include_once "App/Controllers/ProductosController.php";

    $UsuariosController = new UsuarioController();
    $ProductosController = new ProductosController();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $ID_Recibe = isset($_POST['ID_Recibe']) ? htmlspecialchars($_POST['ID_Recibe']) : '';
        $ID_Usuario = isset($_POST['SessionID']) ? htmlspecialchars($_POST['SessionID']) : '';
        $ID_Supervisor = isset($_POST['IDSupervisor']) ? htmlspecialchars($_POST['IDSupervisor']) : '';
        $CorreoSupervisor = isset($_POST['CorreoSupervisor']) ? htmlspecialchars($_POST['CorreoSupervisor']) : '';
        $Nombre_Supervisor = isset($_POST['NombreSupervisor']) ? htmlspecialchars($_POST['NombreSupervisor']) : '';
        $Nombre_Ingresa = isset($_POST['NombreIngresa']) ? htmlspecialchars($_POST['NombreIngresa']) : '';
        $ID_Centro = isset($_POST['SessionCentro']) ? htmlspecialchars($_POST['SessionCentro']) : '';  
        $ID_CentroDestinado = isset($_POST['ID_CentroDestinado']) ? htmlspecialchars($_POST['ID_CentroDestinado']) : ''; 
        $No_Documento= isset($_POST['No_Documento']) ? htmlspecialchars($_POST['No_Documento']) : '';  
    }

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>OUTKARGO - Administrador</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="description" content="OUTKARGO ofrece servicios de alquiler de montacargas con y sin operador en Colombia.">
    <meta name="keywords" content="OUTKARGO, alquiler de montacargas, montacargas con operador, Colombia">
    <link rel="icon" href="../../App/Favicon.ico" type="image/x-icon">
    
    <!-- CSS y JS de Alertify -->
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>

    <!-- Signature Pad -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.5.3/signature_pad.min.js"></script>
</head>
<body>
    <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['Tipo']) && $_POST['Tipo'] == "1") {
                $No_Documento = isset($_POST['No_Documento']) ? htmlspecialchars($_POST['No_Documento']) : '';
                $ID_Recibe = isset($_POST['ID_Recibe']) ? htmlspecialchars($_POST['ID_Recibe']) : '';
                $ID_Usuario = isset($_POST['ID_Usuario']) ? htmlspecialchars($_POST['ID_Usuario']) : '';
                $Nombre_Ingresa = isset($_POST['NombreIngresa']) ? htmlspecialchars($_POST['NombreIngresa']) : '';
                $ID_Supervisor = isset($_POST['ID_Supervisor']) ? htmlspecialchars($_POST['ID_Supervisor']) : '';
                $CorreoSupervisor = isset($_POST['CorreoSupervisor']) ? htmlspecialchars($_POST['CorreoSupervisor']) : '';
                $Nombre_Supervisor = isset($_POST['Nombre_Supervisor']) ? htmlspecialchars($_POST['Nombre_Supervisor']) : '';
                $ID_Centro = isset($_POST['ID_Centro']) ? htmlspecialchars($_POST['ID_Centro']) : '';
                $ID_Destino = isset($_POST['ID_Destino']) ? htmlspecialchars($_POST['ID_Destino']) : '';
                $Firma = isset($_POST['firma']) ? $_POST['firma'] : '';
                $ProductosController->FirmarSalida($No_Documento,$ID_Recibe, $ID_Usuario, $ID_Centro, $ID_Destino, $Firma, $Nombre_Ingresa, $ID_Supervisor, $CorreoSupervisor, $Nombre_Supervisor);
            }
        }        
    ?>   
    <h2>Firma Salida</h2>
    
    <form method="post">
        <!-- Campo para la firma -->
        <canvas id="signature-pad" width="400" height="200" style="border: 2px solid #000; border-radius: 5px;"></canvas>
        <input type="hidden" name="No_Documento" value="<?=$_GET['Documento']?>">
        <input type="hidden" name="ID_Recibe" value="<?=$ID_Recibe?>">
        <input type="hidden" name="ID_Usuario" value="<?=$ID_Usuario?>">
        <input type="hidden" name="Nombre_Ingresa" value="<?=$Nombre_Ingresa?>">
        <input type="hidden" name="ID_Supervisor" value="<?=$ID_Supervisor?>">
        <input type="hidden" name="CorreoSupervisor" value="<?=$CorreoSupervisor?>">
        <input type="hidden" name="Nombre_Supervisor" value="<?=$Nombre_Supervisor?>">
        <input type="hidden" name="ID_Centro" value="<?=$ID_Centro?>">
        <input type="hidden" name="ID_Destino" value="<?=$ID_CentroDestinado?>">
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
                document.getElementById('firma').value = signaturePad.toDataURL(); 
            } else {
                alertify.error("Por favor, firma antes de enviar.");
                return false; 
            }
        };
    </script>
</body>
</html>
