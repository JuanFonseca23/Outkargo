<?php
include_once "App/Controllers/UsuarioController.php";
require 'vendor/autoload.php';
$Empleados = new UsuarioController;
$ID = $_GET['ID'];
$Lista = $Empleados->Mostrar($ID);

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

$ID = $_GET['ID'];
$qrCode = new QrCode('https://outkargo.com.co/Empleados/Ver?ID=' . $ID);
$qrCode->setSize(300);
$qrCode->setMargin(10);
$writer = new PngWriter();
$result = $writer->write($qrCode);
$qrImageData = base64_encode($result->getString());



if ($_SERVER['HTTP_HOST'] == 'localhost') {
    $baseUrl = 'http://localhost/outkargo2/';
} else {
    $baseUrl = 'https://outkargo.com.co/';
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contenedor</title>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@100;400;600&display=swap");

        @page {
            size: 55mm 85mm;
            margin: 0;
            /* Sin márgenes en el papel */
        }

        html,
        body {
            margin: 0;
            padding: 0;
            height: 100%;
            width: 100%;
            font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container,
        .container-2 {
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            page-break-after: always;
            height: 100%;
            width: 100%;
        }

        .container {
            background-color: #fff;
        }

        .container img,
        .container-2 img {
            width: 100%;
            max-width: 100%;
            display: block;
            margin-left: 0px;
        }

        .container p,
        .container-2 p {
            margin: 0;
            padding: 0;
            text-align: center;
            box-sizing: border-box;
        }

        .container p {
            font-size: 8px;
        }

        .container_perfil {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
        }
        .container_perfil img {
            width: 90px; 
            height: 90px; 
            object-fit: cover; 
            border-radius: 10%; 
            margin-left: 55px;
        }

        .container_perfil p {
            font-size: 12px;
            margin-top: 5px;
        }

        .Linea {
            width: 80%;
            height: 2px;
            background-color: #ff5000;
            margin-top: 5px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-left: 20px;
        }

        .container_Qr {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 50px;
            height: 50px;
            margin-left: 22px;
        }

        .container_Qr img {
            width: 50px;
            height: 50px;
        }

        .container-2 {
            background-image: url("<?=$baseUrl?>App/Views/Img/Fondo_Carnet_2.png");
            background-size: cover;
            background-position: center;
            color: #fff;
            padding: 0.5cm;
            justify-content: space-between;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .container-2 .Imagen {
            width: 60px;
            height: 60px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 10px;
        }

        .container-2 img {
            max-width: 100%;
            max-height: 100%;
            display: block;
            margin-left: 50px;
        }

        .container-2 p {
            font-size: 10px;
            text-align: left;
            width: 100%;
            box-sizing: border-box;
        }

        .container-2 .LetraPeque {
            margin-top: 10px;
            font-size: 6px;
            text-align: justify;
            width: 80%;
            box-sizing: border-box;
        }
    </style>
</head>

<body>
    <div class="Contenedor-general">
        <div class="container">
            <img src="<?=$baseUrl?>App/Views/Img/Outkargo.png" alt="Logo">
            <p><strong>NIT.</strong> 900.095.335-4</p>
            <div class="container_perfil">
                <img src="<?=$baseUrl?>App/Views/Upload/Img/Perfil/<?= htmlspecialchars($Lista['Foto']) ?>" alt="Perfil">
                <p><?= htmlspecialchars($Lista['NombreCompleto']) ?></p>
                <div class="Linea"></div>
                <p><strong><?= htmlspecialchars($Lista['Nombre_Cargo']) ?></strong></p>
                <div class="container_Qr">
                    <img src="data:image/png;base64,<?= $qrImageData ?>" alt="Código QR">
                </div>
            </div>
        </div>
        <div class="container-2">
            <div class="Imagen">
                <img src="<?=$baseUrl?>App/Views/Img/Rueda_Blanca.png">
            </div>
            <p>
                <strong>
                    <?php
                    if ($Lista['Tipo_Documento'] == 1) {
                        echo  'C.C';
                    } elseif ($Lista['Tipo_Documento'] == 2) {
                        echo  'T.I';
                    } elseif ($Lista['Tipo_Documento'] == 3) {
                        echo  'Otro';
                    }
                    ?>
                </strong><?= htmlspecialchars($Lista['Documento']) ?>
            </p>
            <p><strong>RH</strong> <?= htmlspecialchars($Lista['RH']) ?></p>
            <p><strong>EPS</strong> <?= htmlspecialchars($Lista['EPS']) ?></p>
            <p><strong>ARL</strong> <?= htmlspecialchars($Lista['ARL']) ?></p>
            <p><strong>Fecha Ingreso</strong><br> <?= htmlspecialchars($Lista['Fecha_Creado']) ?></p>
            <p class="LetraPeque">Este carnet es personal e intrasferible y acredita a su portador como trabajador de Outsorsing Kargo Limitada. Debe presentarlo cuando se requiera, portarlo en un lugar visible. No es válido para efectuar transacciones comerciales y su titular es responsable de su correcta utilización</p>
        </div>
    </div>
</body>

</html>