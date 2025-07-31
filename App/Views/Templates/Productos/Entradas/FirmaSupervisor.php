<?php
    session_start();
    // Verificar si el usuario ha iniciado sesión
    if (empty($_SESSION['ID'])) {
        header("Location: ../IniciarSesion");
        exit;
    }

    include_once "App/Controllers/UsuarioController.php";
    include_once "App/Controllers/ProductosController.php";
    $UsuariosController = new UsuarioController();
    $ProductosController = new ProductosController;

    $ID_Entrada = $_GET['ID']; 
    $estadoFirma = $ProductosController->verificarEstadoFirma($ID_Entrada); 

    if ($estadoFirma['Firma_Supervisor_Estado'] === 1) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Atención',
                    text: 'Ya has autorizado esta entrada.',
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
    <meta name="description" content="OUTKARGO ofrece servicios de alquiler de montacargas con y sin operador en Colombia. Contamos con una amplia flota de montacargas para cubrir tus necesidades de carga y descarga.">
    <meta name="keywords" content=
    "OUTKARGO, alquiler de montacargas, montacargas con operador, montacargas sin operador, Colombia, Montacargas, Pasillo angosto, Toma Pedido, Contrabalanceada, Contrabalanceado, Snorlift, Manlift, Lift, Combustion Interna, Diesel, Gas">
    <link rel="icon" href="../../App/Favicon.ico" type="image/x-icon" >

    <!-- JavaScript -->
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <!-- CSS -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
    <!-- Default theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.5.3/signature_pad.min.js"></script>
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link rel= "stylesheet" href= "https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css" >
    <link href="../../App/Views/Resources/Lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="../../App/Views/Resources/Lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />
    <!-- Template Stylesheet -->
    <link href="../../App/Views/Resources/Css/Dashboard/style.css" rel="stylesheet">
</head>
<body>
    <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {  
                $Firma_Supervisor = $_POST['firma'];
                $Usuario = $_POST['Usuario'];
                $Nombre_Ingresa = $_POST['NombreIngresa'];
                $ID = $_GET['ID'];
                $No_Formulario = $_GET['No'];
                $ProductosController->FirmarEntradaSupervisor($ID, $Usuario, $Nombre_Ingresa, $No_Formulario, $Firma_Supervisor);                                                   
            }
    ?>
    <style>
        #signature-pad {
            border: 2px solid #000;
            border-radius: 5px;
        }
    </style>
    <h2>Firma Supervisor</h2>
    <form action="" method="post">
        <canvas id="signature-pad" width="400" height="200"></canvas>
        <input type="hidden" name="firma" id="firma">
        <input type="hidden" name="Usuario" value="<?= $_SESSION['ID'] ?>">
        <input type="hidden" name="NombreIngresa" value="<?= $_SESSION['Nombre1'] ?>">
        <br>
        
        <button type="submit">Guardar Firma</button>
    </form>
    <button id="clear-button">Borrar</button>

    <script>
        function disableButton(form) {
            var submitButton = form.querySelector('input[type="submit"]');
            submitButton.disabled = true;
        }

        var canvas = document.getElementById('signature-pad');
        var signaturePad = new SignaturePad(canvas);

        document.getElementById('clear-button').addEventListener('click', function () {
            signaturePad.clear();
        });

        document.querySelector('form').onsubmit = function () {
            if (!signaturePad.isEmpty()) {
                document.getElementById('firma').value = signaturePad.toDataURL();  
                disableButton(this); 
            } else {
                alertify.error("Por favor, firma antes de enviar.");
                return false;  
            }
        };
    </script>
</body>
</html>
