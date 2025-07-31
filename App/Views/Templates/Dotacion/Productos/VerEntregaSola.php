<?php
include_once "App/Controllers/DotacionController.php";
$DotacionController = new DotacionController;
$DataEntrega = $DotacionController->VerEntrega($_GET['Codigo'], $_SESSION['NoCentro']);
$Filas = $DotacionController->MostrarDetallesDotacionEntrega($_GET['Codigo']);
if ($_SERVER['HTTP_HOST'] == 'localhost') {
    $baseUrl = 'http://localhost/outkargo2/';
} else {
    $baseUrl = 'https://outkargo.com.co/';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
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
    <?php
        if ($DataEntrega['Estado'] == 2) {
    ?>
            <img class="anulada" src="<?= $baseUrl ?>App/Views/Img/anulado.png" alt="Anulada">
    <?php
        }
    ?>    
    <table border="1">
        <thead>
            <tr>
                <th rowspan="3"><img src="<?= $baseUrl ?>App/Views/Img/Outkargo.png" width="200px"></th>
                <th rowspan="3" class="Titulo" style="font-size: 20px;">ACTA ENTREGA DE DOTACIÓN Y EPP</th>
                <th>CODIGO:</th>
                <td>F-242</td>
            </tr>
            <tr>
                <th>FECHA:</th>
                <td>17-05-2024</td>
            </tr>
            <tr>
                <th>VERSIÓN:</th>
                <td>2</td>
            </tr>
        </thead>
    </table>
    <p><b>Fecha:</b> <?= $DataEntrega['Fecha'] ?></p>
    <p><b>Señor:</b> <?= $DataEntrega['NombreSupervisor'] ?></p>
    <p>Con la presente acta <b>OUTKARGO LTDA</b> le hace entrega de la siguiente dotación:</p>
    <table border="1">
        <thead>
            <th colspan="4" style="font-size: 20px;">ELEMENTOS ENTREGADOS</th>
        </thead>
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
                        <th><?= $Numero ?></th>
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
    <p>La dotación que aqui se entrega es y será de la empresa en todo momento.</p>
    <ul>
        <li>
            En caso de daño o desgaste debe reportarse y entregar el elemento deteriorado para su respectiva disposición, para
            hacerle entrega de un nuevo elementro.
        </li>
        <li>
            Cuando haya terminación del contrato de trabajo, debe hacer la devolución de forma inmediata de todo lo entregado
        </li>
    </ul>

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
                    <img src="<?= $DataEntrega['Firma_Ingresa'] ?>" style="max-width: 100%;">
                </td>
                <td width="50%" style="text-align: center;">
                    <img src="<?= $DataEntrega['Firma_Supervisa'] ?>" style="max-width: 100%;">
                </td>
            </tr>
            <tr>
                <th><?= $DataEntrega['NombreUsuario'] ?></th>
                <th><?= $DataEntrega['NombreSupervisor'] ?></th>
            </tr>
            <tr>
                <th>Firma</th>
                <th>Firma</th>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td><b>Fecha: </b> <?= $DataEntrega['Fecha'] ?></td>
                <td><b>Fecha:</b> <?= $DataEntrega['Fecha_Firma_Supervisado'] ?></td>
            </tr>
        </tfoot>
    </table>
    <?php
        if ($DataEntrega['Estado'] == 2) {
    ?>
            <p><?= $DataEntrega['Descripcion_Anulacion'] ?></p>
    <?php
        }
    ?>     
</body>

</html>