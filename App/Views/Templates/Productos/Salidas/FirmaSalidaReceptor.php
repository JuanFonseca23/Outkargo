<?php
    session_start();
    if (empty($_SESSION['ID'])) {
        header("location:../IniciarSesion");
        exit;
    }

    include_once "App/Controllers/UsuarioController.php";
    include_once "App/Controllers/ProductosController.php";
    include_once "App/Controllers/DotacionController.php";

    $UsuariosController = new UsuarioController();
    $ProductosController = new ProductosController();
    $DotacionController = new DotacionController;

    $No_Documento = $_GET['Documento'];
    $ID_Salida = $_GET['Salida'];
    $DataUsuario = $DotacionController->BuscarPersona($No_Documento);
    $estadoFirma = $ProductosController->verificarEstadoFirmaS($ID_Salida); 

    if ($estadoFirma['Firma_Estado_Recibe'] === 1) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Atención',
                    text: 'Ya has firmado esta salida.',
                    icon: 'warning',
                    confirmButtonText: 'Aceptar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'Inicio'; 
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
                $No_Documento = isset($_POST['No_Documento']) ? htmlspecialchars($_POST['No_Documento']) : '';
                $ID_Salida = isset($_POST['ID_Salida']) ? htmlspecialchars($_POST['ID_Salida']) : '';
                $No_Formulario = isset($_POST['No_Formulario']) ? htmlspecialchars($_POST['No_Formulario']) : '';
                $ID_Recibe = isset($_POST['ID_Recibe']) ? htmlspecialchars($_POST['ID_Recibe']) : '';
                $Nombre_Ingresa = isset($_POST['NombreIngresa']) ? htmlspecialchars($_POST['NombreIngresa']) : '';
                $Firma = isset($_POST['firma']) ? $_POST['firma'] : '';
                
                $ProductosController->FirmarSalidaRecibe($ID_Salida, $No_Formulario, $ID_Recibe, $Nombre_Ingresa, $Firma);
            }
        }        
    ?>   
    <h2>Firma Recibe</h2>
    
    <form method="post">
        <!-- Campo para la firma -->
        <canvas id="signature-pad" width="400" height="200" style="border: 2px solid #000; border-radius: 5px;"></canvas>
        <input type="hidden" name="No_Formulario" value="<?=$_GET['No_Formulario']?>">
        <input type="hidden" name="ID_Salida" value="<?=$_GET['Salida']?>">
        <input type="hidden" name="ID_Recibe" value = "<?= $DataUsuario['ID'] ?>">
        <input type="hidden" name="NombreIngresa" value="<?= $DataUsuario['Nombre1'] ?>">
        <input type="hidden" name="firma" id="firma">
        <input type="hidden" name="Tipo" value="1">
        <br>
        <button type="submit">Guardar Firma</button>
    </form>
    <button id="clear-button">Borrar</button>
    <a href="InicioSalida">
        <button>Volver</button>
    </a>


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
