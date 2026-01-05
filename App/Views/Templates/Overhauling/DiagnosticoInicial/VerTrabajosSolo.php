<?php
include_once "App/Controllers/OverhaulingController.php";
$OverhaulingController = new OverhaulingController();
$DataOverhauling = $OverhaulingController->VerOverhauling($_GET['ID']);
$DataMecanicos = $OverhaulingController->VerMecanicos($_GET['ID']);
$DataDetalleTrabajos = $OverhaulingController->VerDetalleTrabajos($_GET['ID']);

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
</head>

<body>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }
        
        table {
            width: 100%;
        }
        th, td {
            font-size: 10px;
        }
        
    </style>

    <!-- Tablas de encabezado -->
    <table border="1">
        <thead>
            <tr>
                <th rowspan="3"><img src="<?= $baseUrl ?>App/Views/Img/Outkargo.png" width="200px"></th>
                <th rowspan="3" class="Titulo" style="font-size: 14px;">RESULTADOS DEL DIAGNOSTICO INICIAL DE OVERHAULING</th>
                <th>CODIGO:</th>
                <td></td>
            </tr>
            <tr>
                <th>FECHA:</th>
                <td>22-12-2025</td>
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
                <th>Centro de trabajo:</th>
                <td colspan="4"><?= $DataOverhauling['CentroOverhauling'] ?></td>
                <th colspan="2">Diagnostico #:</th>
                <td style="text-align: center;"> <?= $DataOverhauling['Numero'] ?></td>         
                <th>Fecha:</th>
                <td><?= $DataOverhauling['Fecha_Realizado'] ?></td>
            </tr>  
            <tr>
                <th colspan="10" style="background-color: #e6e6e6; text-align: center;">Montacargas</th>
            </tr>
            <tr>
                <th>Marca:</th>
                <td><?= $DataOverhauling['Marca'] ?></td>
                <th>Serie:</th>
                <td><?= $DataOverhauling['Serie'] ?></td>
                <th>Modelo:</th>
                <td><?= $DataOverhauling['Modelo'] ?></td>
                <th>Voltaje:</th>
                <td><?= !empty($DataOverhauling['Voltaje']) ? htmlspecialchars($DataOverhauling['Voltaje']) : 'Sin información' ?></td>
                <th>Horometro:</th>
                <td><?= !empty($DataOverhauling['Horometro']) ? htmlspecialchars($DataOverhauling['Horometro']) : 'Sin información' ?></td>
            </tr>
            <tr>
                <th>Tecnico(s) Encargado(s):</th>
                <td colspan="4"><?php
                    if ($DataMecanicos) {
                        echo '<ul style="list-style-type:none; margin:0; padding:0;">';
                        foreach ($DataMecanicos as $mecanico) {
                            echo '<li>' . htmlspecialchars($mecanico['NombreMecanico']) . '</li>';
                        }
                        echo '</ul>';
                    } else {
                        echo 'No hay técnicos asignados';
                    }
                ?></td>
                <th colspan="3">Dir. Técnico y Logístico | Jefe de Taller:</th>
                <td colspan="2"><?= $DataOverhauling['NombreSupervisor'] ?></td>
            </tr>       
        </thead>
    </table>

    <!-- Tabla de detalles -->
   <table border="1">
        <thead>
            <tr>
                <th colspan="4" style="background-color:#e6e6e6; text-align:center;">
                    TRABAJOS A REALIZAR
                </th>
            </tr>
            <tr>
                <th style="width:40px">#</th>
                <th style="width:120px">Sección</th>
                <th style="width:150px">Criterio</th>
                <th>Descripción</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $Numero = 0;
            if ($DataDetalleTrabajos) {
                foreach ($DataDetalleTrabajos as $DataDetalleTrabajo) {
                    $Numero++;
            ?>
            <tr>
                <td style="text-align:center;"><?= $Numero ?></td>
                <td><?= $DataDetalleTrabajo['Seccion'] ?></td>
                <td><?= $DataDetalleTrabajo['Criterio'] ?></td>
                <td><?= $DataDetalleTrabajo['Descripcion'] ?></td>
            </tr>
            <?php
                }
            }
            ?>
        </tbody>
    </table>

    <!-- Tabla de firmas mecanicos -->
    <?php
    $totalMecanicos = count($DataMecanicos);
    ?>

    <?php if ($totalMecanicos === 1): ?>
    <!-- 1 TÉCNICO -->
    <table border="1" width="100%">
        <thead>
            <tr>
                <th style="font-size:14px;">Técnico</th>
                <th style="font-size:14px;">Dir. Técnico y Logístico | Jefe de Taller</th>
            </tr>
        </thead>
        <tbody>
            <tr height="100px">
                <td width="50%" align="center">
                    <img src="<?= $DataMecanicos[0]['Firma_Mecanico'] ?>" style="max-width:100%;">
                </td>
                <td width="50%" align="center">
                    <img src="<?= $DataOverhauling['Firma_Supervisor'] ?>" style="max-width:100%;">
                </td>
            </tr>
            <tr>
                <th><?= htmlspecialchars($DataMecanicos[0]['NombreMecanico']) ?></th>
                <th><?= htmlspecialchars($DataOverhauling['NombreSupervisor']) ?></th>
            </tr>
            <tr>
                <th>Firma</th>
                <th>Firma</th>
            </tr>
        </tbody>
    </table>
    <?php elseif ($totalMecanicos === 2): ?>
    <!-- 2 TÉCNICOS + SUPERVISOR -->
    <table border="1" width="100%">
        <thead>
            <tr>
                <th colspan="2" style="font-size:14px;">Técnico(s)</th>
                <th style="font-size:14px;">Dir. Técnico y Logístico | Jefe de Taller</th>
            </tr>
        </thead>
        <tbody>
            <tr height="100px">
                <?php foreach ($DataMecanicos as $mecanico): ?>
                    <td width="33%" align="center">
                        <img src="<?= $mecanico['Firma_Mecanico'] ?>" style="max-width:100%;">
                    </td>
                <?php endforeach; ?>

                <td width="33%" align="center">
                    <img src="<?= $DataOverhauling['Firma_Supervisor'] ?>" style="max-width:100%;">
                </td>
            </tr>
            <tr>
                <?php foreach ($DataMecanicos as $mecanico): ?>
                    <th><?= htmlspecialchars($mecanico['NombreMecanico']) ?></th>
                <?php endforeach; ?>
                <th><?= htmlspecialchars($DataOverhauling['NombreSupervisor']) ?></th>
            </tr>
            <tr>
                <th>Firma</th>
                <th>Firma</th>
                <th>Firma</th>
            </tr>
        </tbody>
    </table>
    <?php else: ?>
    <!-- 3 O MÁS TÉCNICOS -->
    <table border="1" width="100%">
        <thead>
            <tr>
                <th colspan="3" style="font-size:14px;">Técnico(s)</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $contador = 0;
            foreach ($DataMecanicos as $mecanico):
                if ($contador % 3 === 0) echo '<tr height="100px">';
            ?>
                <td width="33%" align="center">
                    <img src="<?= $mecanico['Firma_Mecanico'] ?>" style="max-width:100%;">
                    <div style="font-weight:bold;">
                        <?= htmlspecialchars($mecanico['NombreMecanico']) ?>
                    </div>
                    <div>Firma</div>
                </td>
            <?php
                $contador++;
                if ($contador % 3 === 0) echo '</tr>';
            endforeach;

            if ($contador % 3 !== 0) echo '</tr>';
            ?>
        </tbody>
    </table>
    <!-- SUPERVISOR SEPARADO (50%) -->
    <table border="1" width="50%" align="center" style="margin-top:10px;">
        <thead>
            <tr>
                <th style="font-size:14px;">
                    Dir. Técnico y Logístico | Jefe de Taller
                </th>
            </tr>
        </thead>
        <tbody>
            <tr height="100px">
                <td align="center">
                    <img src="<?= $DataOverhauling['Firma_Supervisor'] ?>" style="max-width:100%;">
                </td>
            </tr>
            <tr>
                <th><?= htmlspecialchars($DataOverhauling['NombreSupervisor']) ?></th>
            </tr>
            <tr>
                <th>Firma</th>
            </tr>
        </tbody>
    </table>
    <?php endif; ?>

</body>