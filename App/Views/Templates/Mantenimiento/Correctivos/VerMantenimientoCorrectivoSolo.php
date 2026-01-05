<?php
include_once "App/Controllers/MantenimientosController.php";
$MantenimientosController = new MantenimientosController();
$DataMantenimiento = $MantenimientosController->VerMantenimientoC($_GET['ID']);
$DataMecanicos = $MantenimientosController->VerMecanicosC($_GET['ID']);
$DataDetalleM = $MantenimientosController->VerDetalleMC($_GET['ID']);
$DataImagenesM = $MantenimientosController->DataImagenesMC($_GET['ID']);

$imagenesPorCategoria = [];
foreach ($DataImagenesM as $img) {
    $categoria = strtoupper(trim($img['Categoria'] ?? 'SIN CATEGORIA'));
    $imagenesPorCategoria[$categoria][] = $img;
}



// $Filas = $ProductosController->MostrarDetallesProductosSalida($_GET['ID']);
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

        .anulada{
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translateX(-50%) translateY(-50%);
        }
    </style>

    <!-- Tablas de encabezado -->
    <table border="1">
        <thead>
            <tr>
                <th rowspan="3"><img src="<?= $baseUrl ?>App/Views/Img/Outkargo.png" width="200px"></th>
                <th rowspan="3" class="Titulo" style="font-size: 14px;" >REPORTE DE MANTENIMIENTO PREVENTIVO ELECTRICA PASILLO ANGOSTO</th>
                <th>CODIGO:</th>
                <td>F-212</td>
            </tr>
            <tr>
                <th>FECHA:</th>
                <td>28-11-2025</td>
            </tr>
            <tr>
                <th>VERSIÓN:</th>
                <td>3</td>
            </tr>
        </thead>
    </table>
    <table border="1">
        <thead>
            <tr>
                <th>Centro de trabajo:</th>
                <td colspan="3"><?= $DataMantenimiento['CentroMantenimiento'] ?></td>
                <th>Sección:</th>
                <td><?= $DataMantenimiento['AreaMantenimiento'] ?></td>         
                <th>Fecha:</th>
                <td><?= $DataMantenimiento['Fecha_Realizado'] ?></td>
            </tr>  
            <tr>
                <th>Montacargas N°:</th>
                <td><?= $DataMantenimiento['NumeroM'] ?></td>
                <th>Serie:</th>
                <td><?= $DataMantenimiento['SerieM'] ?></td>
                <th>Modelo:</th>
                <td><?= $DataMantenimiento['ModeloM'] ?></td>
                <th>Voltaje:</th>
                <td><?= $DataMantenimiento['VoltajeM'] ?></td>
            </tr>
            <tr>
                <th>Tecnico(s) Encargado(s):</th>
                <td colspan="5"><?php
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
                <th>Hora Inicio:</th>
                <td><?= $DataMantenimiento['Hora_Inicio'] ?></td>
            </tr>
            <tr>
                <th>Operario:</th>
                <td colspan="3"><?= $DataMantenimiento['NombreOperario'] ?></td>
                <th>Horometro:</th>
                <td><?= $DataMantenimiento['HorometroM'] ?></td>
                <th>Hora de Finalización:</th>
                <td><?= $DataMantenimiento['Hora_Finalizacion'] ?></td>
            </tr>             
        </thead>
    </table>

    <!-- Tabla DESCRIPCIÓN DE LA FALLA -->
    <table border="1">
        <thead>
            <tr>
                <th colspan="4" style="text-align: center; background-color: #e7e5e5ff;" >DESCRIPCIÓN DE LA FALLA</th>
            </tr>
        </thead>
        <tbody>
            <td th colspan="4"><?= $DataDetalleM['Descripcion_Falla']?></td>
        </tbody>
    </table>

    <!-- Tabla REPARACIÓN REALIZADA -->
    <table border="1">
        <thead>
            <tr>
                <th colspan="4" style="text-align: center; background-color: #e7e5e5ff;">REPARACIÓN REALIZADA</th>
            </tr>
        </thead>
        <tbody>
            <td th colspan="4"><?= $DataDetalleM['Reparacion_Realizada']?></td>
        </tbody>
    </table>

    <!-- Tabla de insumos -->
    <table border="1">
        <thead>
            <tr>
                <th colspan="4" style="text-align: center; background-color: #e7e5e5ff;" >INSUMOS Y REPUESTOS INSTALADOS</th>
            </tr>
        </thead>
        <tbody>
            <td th colspan="4"><?= $DataDetalleM['Insumos_Utilizados']?></td>
        </tbody>
    </table>

    <!-- Tabla falla -->
    <table border="1">
        <thead>
            <tr>
                <th style="text-align: center; background-color: #e7e5e5ff;">FALLA CORREGIDA: </th>
                <td style="text-align: center;"><?= $DataDetalleM['FallaC']?></td>
                <th style="text-align: center; background-color: #e7e5e5ff;">PROGRAMAR NUEVAMENTE PARA EL DÍA: </th>
                <td style="text-align: center;"><?= $DataDetalleM['Fecha_Correcion']?></td>
            </tr>
        </thead>        
    </table>  

    <!-- Tabla falla -->
    <table border="1">
        <thead>
             <tr>
                <th colspan="4" style="text-align: center; background-color: #e7e5e5ff;"></td>PENDIENTE POR</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td th colspan="4"><?= $DataDetalleM['Pendiente']?></td>
            </tr>
        </tbody>
    </table>
    
    <!-- Tabla falla -->
    <table border="1">
        <thead>
             <tr>
                <th colspan="4" style="text-align: center; background-color: #e7e5e5ff;"></td>OBSERVACIONES</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td th colspan="4"><?= $DataDetalleM['Observaciones']?></td>
            </tr>
        </tbody>
    </table> 

    <?php 
    $totalMecanicos = count($DataMecanicos);
?>

    <!-- Si hay más de 1 técnico, mostrar tabla exclusiva de técnicos -->
    <?php if ($totalMecanicos > 1): ?>

        <table border="1">
            <thead>
                <?php $anchoPorFirma = 100 / $totalMecanicos; ?>
                <tr>
                    <th colspan="<?= $totalMecanicos ?>" style="font-size: 14px;">Técnico(s)</th>
                </tr>
            </thead>
            <tbody>
                <tr height="100px">
                    <?php foreach ($DataMecanicos as $mecanico): ?>
                        <td style="text-align: center; width: <?= $anchoPorFirma ?>%;">
                            <img src="<?= $mecanico['Firma_Mecanico'] ?>" style="max-width: 100%;">
                        </td>
                    <?php endforeach; ?>
                </tr>

                <tr>
                    <?php foreach ($DataMecanicos as $mecanico): ?>
                        <td style="text-align: center; font-weight: bold;">
                            <?= htmlspecialchars($mecanico['NombreMecanico']) ?>
                        </td>
                    <?php endforeach; ?>
                </tr>

                <tr>
                    <?php foreach ($DataMecanicos as $mecanico): ?>
                        <th>Firma</th>
                    <?php endforeach; ?>
                </tr>
            </tbody>
        </table>

    <?php endif; ?>


    <!-- TABLA SUPERVISOR + OPERARIO + TÉCNICO (si solo hay uno) -->
    <table border="1">
        <thead>
            <tr>
                <th style="font-size: 14px;">Dir. Técnico y Logístico | Jefe de Taller</th>
                <th style="font-size: 14px;">Operario o Supervisor (recibe el equipo)</th>

                <?php if ($totalMecanicos == 1): ?>
                    <th style="font-size: 14px;">Técnico</th>
                <?php endif; ?>
            </tr>
        </thead>

        <tbody>
            <tr height="100px">
                <!-- Firma Técnico (solo si hay 1 técnico) -->
                <?php if ($totalMecanicos == 1): ?>
                    <td width="33%" style="text-align: center;">
                        <img src="<?= $DataMecanicos[0]['Firma_Mecanico'] ?>" style="max-width: 100%;">
                    </td>
                <?php endif; ?>

                <!-- Firma Supervisor -->
                <td width="33%" style="text-align: center;">
                    <img src="<?= $DataMantenimiento['Firma_Supervisor'] ?>" style="max-width: 100%;">
                </td>

                <!-- Firma Operario -->
                <td width="33%" style="text-align: center;">
                    <img src="<?= $DataMantenimiento['Firma_Operario'] ?>" style="max-width: 100%;">
                </td>
            </tr>

            <tr>
                <th style="text-align:center;"><?= $DataMantenimiento['NombreSupervisor'] ?></th>
                <th style="text-align:center;"><?= $DataMantenimiento['NombreOperario'] ?></th>

                <?php if ($totalMecanicos == 1): ?>
                    <th style="text-align:center;"><?= $DataMecanicos[0]['NombreMecanico'] ?></th>
                <?php endif; ?>
            </tr>

            <tr>
                <th>Firma</th>
                <th>Firma</th>

                <?php if ($totalMecanicos == 1): ?>
                    <th>Firma</th>
                <?php endif; ?>
            </tr>
        </tbody>
    </table>
    
    <div style="page-break-before: always;"></div>

    <!-- Tabla de imagenes -->
    <table border="1" >
        <thead>
            <tr>
                <th colspan="4" style="font-size: 14px;">EVIDENCIA FOTOGRÁFICA</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($imagenesPorCategoria as $categoria => $imagenes): ?>
                <tr>
                    <!-- Columna lateral fija (nombre de categoría) -->
                    <td rowspan="<?php echo ceil(count($imagenes) / 3); ?>" 
                        style="writing-mode: vertical-rl; text-orientation: upright; 
                            background-color: #000020; color: white; 
                            font-weight: bold; width: 20px; 
                            font-size: 15px; vertical-align: middle; text-align: center;">
                        <?= htmlspecialchars($categoria) ?>
                    </td>
                    <?php 
                        $contador = 0;
                        foreach ($imagenes as $index => $img): 
                            // Abrir una nueva fila si ya se colocaron 3 imágenes
                            if ($contador > 0 && $contador % 3 == 0) {
                                echo '</tr><tr>';
                            }
                    ?>                    
                        <td style="text-align: center; padding: 5px;">
                            <div style="display: flex; flex-direction: column; align-items: center;">
                                <img src="<?= $baseUrl . htmlspecialchars($img['Evidencia_Fotografica']) ?>" alt="Evidencia <?= $index + 1 ?>" width="100px" height="100px">
                                <br>
                                <span style="font-size: 12px; font-weight: bold;">
                                    <?= htmlspecialchars($categoria .'_'. $contador) ?>
                                </span>
                            </div>
                        </td>
                    <?php 
                        $contador++;
                        endforeach;

                        // Completar fila si no se llegó a múltiplo de 3
                        $resto = $contador % 3;
                        if ($resto > 0) {
                            for ($i = $resto; $i < 3; $i++) {
                                echo '<td></td>';
                            }
                        }
                    ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>