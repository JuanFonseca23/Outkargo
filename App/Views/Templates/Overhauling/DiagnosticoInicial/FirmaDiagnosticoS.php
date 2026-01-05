<?php
    session_start();
    if (empty($_SESSION['ID'])) {
        header("location:../IniciarSesion");
        exit;
    }

    include_once "App/Controllers/UsuarioController.php";
    include_once "App/Controllers/OverhaulingController.php";

    $UsuariosController = new UsuarioController();
    $OverhaulingController = new OverhaulingController();

    $DataMantenimiento = $OverhaulingController->ObtenerDiagnostico($_GET['ID']); 
    $Estado_Firma_Supervisor = $DataMantenimiento['Estado_Firma_Supervisor'];

    if ($DataMantenimiento['Estado_Firma_Supervisor'] === 1) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Atención',
                    text: 'Ya has firmado este Diagnostico.',
                    icon: 'warning',
                    confirmButtonText: 'Aceptar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'Inicial'; 
                    }
                });
            });
        </script>";
        exit;
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
                $ID_Diagnostico = isset($_GET['ID']) ? htmlspecialchars($_GET['ID']) : '';
                $Firma = isset($_POST['firma']) ? $_POST['firma'] : '';
                $OverhaulingController->FirmarOverhaulingSupervisor($ID_Diagnostico, $Firma);
            }
        }        
    ?>   
    <h2>Firma Supervisor</h2>
    
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
                document.getElementById('firma').value = signaturePad.toDataURL(); 
            } else {
                alertify.error("Por favor, firma antes de enviar.");
                return false; 
            }
        };
    </script>
</body>
</html>
