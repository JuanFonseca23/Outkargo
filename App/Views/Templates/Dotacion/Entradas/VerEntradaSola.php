<?php
include_once "App/Controllers/DotacionController.php";
$DotacionController = new DotacionController;
$DataEntrada = $DotacionController->VerEntrada($_GET['ID'], $_SESSION['NoCentro']);

if ($DataEntrada){
    if($DataEntrada['Estado'] == 1){
        $Filas = $DotacionController->MostrarDetallesDotacionEntrada($_GET['ID']);
    }
    else if ($DataEntrada['Estado'] == 2){
        $Filas = $DotacionController->MostrarDetallesDotacionEntradaTemp($_GET['ID']);
    }
    else if ($DataEntrada['Estado'] == 3){
        $Filas = NULL;
    }
}

if ($_SERVER['HTTP_HOST'] == 'localhost') {
    $baseUrl = 'http://localhost/outkargo2/';
} else {
    $baseUrl = 'https://outkargo.com.co/';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>OUTKARGO - Administrador</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="description" content="OUTKARGO ofrece servicios de alquiler de montacargas con y sin operador en Colombia. Contamos con una amplia flota de montacargas para cubrir tus necesidades de carga y descarga.">
    <meta name="keywords" content="OUTKARGO, alquiler de montacargas, montacargas con operador, montacargas sin operador, Colombia, Montacargas, Pasillo angosto, Toma Pedido, Contrabalanceada, Contrabalanceado, Snorlift, Manlift, Lift, Combustion Interna, Diesel, Gas">
    <link rel="icon" href="../../App/Favicon.ico" type="image/x-icon">

    <!-- JavaScript -->
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <!-- CSS -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
    <!-- Default theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css" />



    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link href="../../App/Views/Resources/Lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="../../App/Views/Resources/Lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Template Stylesheet -->
    <link href="../../App/Views/Resources/Css/Dashboard/style.css" rel="stylesheet">
</head>

<body>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        table {
            width: 100%;
        }

        .anulada{
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translateX(-50%) translateY(-50%);
        }
    </style>
    <?php if ($DataEntrada['Estado'] == 3): ?>
        <img class="anulada" src="<?= $baseUrl ?>App/Views/Img/anulado.png" alt="Anulada">
    <?php endif; ?>
    <table border="1">
        <thead>
            <tr>
                <th rowspan="3"><img src="<?= $baseUrl ?>App/Views/Img/Outkargo.png" width="200px"></th>
                <th rowspan="3" class="Titulo" style="font-size: 20px;">FORMATO ENTRADA DE DOTACIÓN</th>
                <th>CODIGO:</th>
                <td>F-243</td>
            </tr>
            <tr>
                <th>FECHA:</th>
                <td>16-05-2024</td>
            </tr>
            <tr>
                <th>VERSIÓN:</th>
                <td>1</td>
            </tr>
        </thead>
    </table>
    <table border="1">
        <thead>
            <tr>
                <th>Supervisado por:</th>
                <td><?= $DataEntrada['NombreSupervisor'] ?></td>
                <th>No.</th>
                <td style="color: red; text-align: center;"><?= $DataEntrada['Numero'] ?></td>
                <th>Fecha:</th>
                <td><?= $DataEntrada['Fecha_Realizado'] ?></td>
            </tr>            
        </thead>
        <tbody>
            <tr>
                
            </tr>
        </tbody>
    </table>
    <table border="1">
        <tbody>
            <tr>
                <th width="50px">#</th>
                <th width="50px">Cantidad</th>
                <th width="100px">Codigo</th>
                <th style="text-align: left;">Descripción</th>
            </tr>
            <?php
            $Numero = 0;
            if ($Filas) {
                foreach ($Filas as $Fila) {
                    $Numero = $Numero + 1;
            ?>
                    <tr>
                        <td><?= $Numero ?></td>
                        <td style="text-align: center;"><?= $Fila['Cantidad'] ?></td>
                        <td><?= $Fila['Codigo'] ?></td>
                        <td><?= $Fila['Nombre'] ?></td>
                    </tr>
            <?php
                }
            }
            ?>
        </tbody>
    </table>
    <table border="1">
        <thead>
            <tr>
                <th>REMITENTE</th>
                <th>DESTINATARIO</th>
            </tr>
        </thead>
        <tbody>
            <tr height="100px">
                <!-- Añadir width="50%" para que ambas firmas ocupen el 50% de la tabla -->
                <td width="50%" style="text-align: center;">
                    <img src="<?= $DataEntrada['Firma_Ingresa'] ?>" style="max-width: 100%;">
                </td>
                <td width="50%" style="text-align: center;">
                    <img src="<?= $DataEntrada['Firma_Supervisor'] ?>" style="max-width: 100%;">
                </td>
            </tr>
            <tr>
                <th style="text-align: center;"><?= $DataEntrada['NombreUsuario'] ?></th>
                <th style="text-align: center;"><?= $DataEntrada['NombreSupervisor'] ?></th>
            </tr>
            <tr>
                <th>Firma</th>
                <th>Firma</th>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td><b>Fecha: </b><?= $DataEntrada['Fecha_Realizado'] ?></td>
                <td><b>Fecha:</b><?= $DataEntrada['Fecha_Firma_Supervisor'] ?></td>
            </tr>
        </tfoot>
    </table>

</body>

</html>