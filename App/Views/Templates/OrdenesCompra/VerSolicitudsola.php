<?php
include_once "App/Controllers/OrdenesCompraController.php";
$OrdenesCompraController = new OrdenesCompraController();
$DataSolicitud = $OrdenesCompraController->VerSolicitud($_GET['ID']);

$Filas = $OrdenesCompraController->MostrarDetallesSolicitud($_GET['ID']);
if ($_SERVER['HTTP_HOST'] == 'localhost') {
    $baseUrl = 'http://localhost/OUTKARGO/';
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
    <style>
        /* ===== FILA APROBADA ===== */
        .fila-aprobada {
            background-color: #d4edda !important;   /* verde suave */
        }

        .fila-aprobada td,
        .fila-aprobada th {
            background-color: #d4edda !important;
        }

        /* ===== FILA RECHAZADA ===== */
        .fila-rechazada {
            background-color: #f8d7da !important;   /* rojo suave */
        }

        .fila-rechazada td,
        .fila-rechazada th {
            background-color: #f8d7da !important;
        }
    </style>
</head>

<body>
    <style>
        body {
            font-family: "Segoe UI", Arial, Helvetica, sans-serif;
            font-size: 13px;
            color: #222;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        th, td {
            padding: 6px 6px;
            vertical-align: middle;
        }

        .Titulo {
            font-size: 16px;
            font-weight: 700;
            text-align: center;
            letter-spacing: 0.5px;
        }

        th {
            font-size: 12px;
            font-weight: 600;
            background-color: #f2f2f2;
            text-transform: uppercase;
        }

        td {
            font-size: 12px;
            font-weight: 400;
        }

        .Titulo2 {
            font-size: 13px;
            font-weight: 500;
            text-align: center;
            letter-spacing: 0.5px;
        }

        .tabla-detalle th {
            font-size: 13px;
            text-align: center;
        }

        .tabla-detalle td {
            font-size: 12px;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .tabla-firmas th {
            font-size: 12px;
        }

        .tabla-firmas td {
            font-size: 12px;
        }
    </style>

    <table border="1">
        <thead>
            <tr>
                <th rowspan="3"><img src="<?= $baseUrl ?>App/Views/Img/Outkargo.png" width="200px"></th>
                <th rowspan="3" class="Titulo" >FORMATO SOLICITUD DE COMPRA DE REPUESTOS E INSUMOS</th>
                <th>CODIGO:</th>
                <td></td>
            </tr>
            <tr>
                <th>FECHA:</th>
                <td>13/01/2026</td>
            </tr>
            <tr>
                <th>VERSIÓN:</th>
                <td>1</td>
            </tr>
        </thead>
    </table>
    
    <table border="1">
        <tr>
            <th>Solicitante</th>
            <td colspan="2"><?= $DataSolicitud['NombreSolicita'] ?></td>
            <th>No. Orden</th>
            <td style="text-align: center;"><?= $DataSolicitud['Numero'] ?></td>
            <th>Fecha</th>
            <td><?= $DataSolicitud['Fecha_Solicitud'] ?></td>
        </tr>
        <tr>
            <th colspan="2">Autorizado por:</th>
            <td colspan="2"><?= $DataSolicitud['NombreSupervisor'] ?></td>
            <th >Centro de trabajo</th>
            <td colspan="2"><?= $DataSolicitud['CentroSolicita'] ?></td>
        </tr>
        <tr>
            <th>Descripción</th>
            <td colspan="6"><?= $DataSolicitud['Descripcion'] ?></td>
        </tr>
    </table>

    <table border="1">
        <thead>
            <tr>
                <th colspan="7" class="Titulo2">DETALLE DE REPUESTOS / INSUMOS</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="30px">#</th>
                <th width="50px">Cantidad</th>
                <th style="text-align: center;">Descripción</th>
                <th style="text-align: center;">Medidas</th>
                <th style="width: 110px;">Precio Unitario</th>
                <th style="width: 110px;">Precio Total</th>
                <th style="width: 110px;">Estado</th>
            </tr>
            <?php
            $Numero = 0;
            $SumaTotal = 0;
            if ($Filas) {
                foreach ($Filas as $Fila) {
                    $Numero = $Numero + 1;
                    if (strtoupper($Fila['Estado']) === 'APROBADO') {
                        $SumaTotal += $Fila['Precio_Total'];
                        $claseFila = 'fila-aprobada';
                    }else{
                         $claseFila = 'fila-rechazada';
                    }
            ?>
                    <tr class="<?= $claseFila ?>">
                        <td style="text-align: center;"><?= $Numero ?></td>
                        <td style="text-align: center;"><?= $Fila['Cantidad'] ?></td>
                        <td style="text-align: left;"><?= $Fila['Descripcion'] ?></td>
                        <td style="text-align: left;"><?= $Fila['Medidas'] ?></td>
                        <td style="text-align: center;">$<?= number_format($Fila['Precio_Unitario'], 0, ',', '.') ?></td>
                        <td style="text-align: center;">$<?= number_format($Fila['Precio_Total'], 0, ',', '.') ?></td>
                        <td style="text-align: center;"><?= $Fila['Estado'] ?></td>
                    </tr>
            <?php
                }
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="5" class="text-right">TOTAL</th>
                <td colspan="2" style="text-align: right;">$ <?= number_format($SumaTotal, 2, ',', '.') ?></td>
            </tr>
        </tfoot>
    </table>

    <table border="1">
        <thead>
            <tr>
                <th>Solicita</th>
                <th>Autoriza</th>
            </tr>
        </thead>
        <tbody>
            <tr height="100px">
                <td width="50%" style="text-align: center;">
                    <img src="<?= $DataSolicitud['Firma_Solicita'] ?>" style="max-width: 100%;">
                </td>
                <td width="50%" style="text-align: center;">
                    <img src="<?= $DataSolicitud['Firma_Autoriza'] ?>" style="max-width: 100%;">
                </td>
            </tr>

            <tr>
                <th style="text-align: center;"><?= $DataSolicitud['NombreSolicita'] ?></th>
                <th style="text-align: center;"><?= $DataSolicitud['NombreSupervisor'] ?></th>
            </tr>
            <tr>
                <th>Firma</th>
                <th>Firma</th>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td><b>Fecha:</b><?= $DataSolicitud['Fecha_Solicitud'] ?></td>
                <td><b>Fecha:</b><?= $DataSolicitud['Fecha_Autoriza'] ?></td>
            </tr>
        </tfoot>
    </table>
</body>

</html>