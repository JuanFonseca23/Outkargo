

<?php
    session_start();
    if (empty($_SESSION['ID'])) {
        header("location:../../IniciarSesion");
        exit;
    }
    include_once "App/Controllers/UsuarioController.php";
    include_once "App/Controllers/DotacionController.php";
    $UsuariosController = new UsuarioController();
    $DotacionController = new DotacionController;
    $Nombre = $_SESSION['Nombre1'];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>OUTKARGO - Administrador</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="description" content="OUTKARGO ofrece servicios de alquiler de montacargas con y sin operador en Colombia. Contamos con una amplia flota de montacargas para cubrir tus necesidades de carga y descarga.">
    <meta name="keywords" content="OUTKARGO, alquiler de montacargas, montacargas con operador, montacargas sin operador, Colombia, Montacargas, Pasillo angosto, Toma Pedido, Contrabalanceada, Contrabalanceado, Snorlift, Manlift, Lift, Combustion Interna, Diesel, Gas">
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
                $Firma = $_POST['firma'];
                $Usuario = $_POST['Usuario'];
                $Cedula = $_GET['Cedula'];
                $Centro = $_SESSION['NoCentro'];
                $Fecha = date("d/m/Y");
                $DotacionController->FirmarEntrega($Firma,$Usuario, $Nombre,$Fecha, $Cedula, $Centro);                                                   
            }
    ?>
    <style>
        /* Estilo para el borde del área de firma */
        #signature-pad {
            border: 2px solid #000;
            border-radius: 5px;
        }
    </style>
    <h2>Firma ENTREGA</h2>
    <form action="" method="post">
        <!-- Campo para la firma -->
        <canvas id="signature-pad" width="400" height="200"></canvas>
        <!-- Campo oculto para almacenar la firma -->
        <input type="hidden" name="firma" id="firma">
        <input type="hidden" name="Usuario" value="<?= $_SESSION['ID'] ?>">
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
            document.getElementById('firma').value = signaturePad.toDataURL();
        };
    </script>
</body>
</html>
