<?php
include_once "App/Controllers/MantenimientosController.php";
$MantenimientosController = new MantenimientosController();
$DataMantenimiento = $MantenimientosController->VerMantenimientoC($_GET['ID']);
$DataMecanicos = $MantenimientosController->VerMecanicosC($_GET['ID']);
$DataDetallesM = $MantenimientosController->VerDetalleMC($_GET['ID']);
$DataImagenesM = $MantenimientosController->DataImagenesMC($_GET['ID']);
$DataInsumosM = $MantenimientosController->DataInsumosMC($_GET['ID']);

$imagenesPorDetalle   = $DataImagenesM['imagenesPorDetalle'] ?? [];
$imagenesPorCategoria = $DataImagenesM['imagenesPorCategoria'] ?? [];



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
                <th rowspan="3" class="Titulo" style="font-size: 14px;" >REPORTE DE MANTENIMIENTO CORRECTIVO</th>
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
                <th colspan="2"># Mantenimiento:</th>
                <td><?= $DataMantenimiento['Numero'] ?></td>         
                <th>Fecha:</th>
                <td ><?= $DataMantenimiento['Fecha_Realizado'] ?></td>
            </tr>
            <tr>
                <th>Orden de trabajo</th>
                <th>Si</th>
                <td><?= $DataMantenimiento['ID_Orden_Trabajo'] !== null ? 'X' : '' ?></td>
                <th>No</th>
                <td><?= $DataMantenimiento['ID_Orden_Trabajo'] === null ? 'X' : '' ?></td>
                <th>Prioridad</th>
                <td><?= $DataMantenimiento['PrioridadOrden'] ?? 'NO APLICA' ?></td>
                <th ># Orden de Trabajo</th>
                <td><?= $DataMantenimiento['NumeroOrden'] ?? 'NO APLICA' ?></td>
            </tr>
            <tr>
                <th>Sección:</th>
                <td  style="width: 100px;" colspan="2"><?= $DataMantenimiento['AreaMantenimiento'] ?? 'NO APLICA' ?></td>
                <th>Horometro:</th>
                <td ><?= $DataMantenimiento['HorometroM'] !== null ? $DataMantenimiento['HorometroM']  : 'NO APLICA';?></td>
                <th>Hora Inicio:</th>
                <td><?= $DataMantenimiento['Hora_Inicio'] ?></td>
                <th>Hora Finalización:</th>
                <td><?= $DataMantenimiento['Hora_Finalizacion'] ?></td>  
            </tr> 
            

            <tr>
                <th>Montacargas N°:</th>
                <td style="width: 40px; text-align: center;"><?= $DataMantenimiento['NumeroM'] ?? 'N/A'?></td>
                <th>Serie:</th>
                <td colspan="2"><?= $DataMantenimiento['SerieM'] ?? 'NO APLICA'?></td>
                <th>Modelo:</th>
                <td><?= $DataMantenimiento['ModeloM'] ?? 'NO APLICA' ?></td>
                <th>Voltaje:</th>
                <td><?= $DataMantenimiento['VoltajeM'] ?? 'N/A' ?></td>
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
                <th>Operario:</th>
                <td colspan="3"><?= $DataMantenimiento['NombreOperario'] ?? 'NO APLICA'?></td>
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
            <?php foreach ($DataDetallesM as $DataDetalleM): ?>
                <?php if ($DataDetalleM['ID_Detalle'] === null) {?>
                    <tr>
                        <td style="width: 60px;" colspan="4"><?= $DataDetalleM['Descripcion_Falla']?></td>
                    </tr>
                <?php } else { ?>
                    <tr>
                        <td style="width: 60px;">DTR<?= $DataDetalleM['ID_Detalle']?></td>
                        <td style="width: 60px;" colspan="4"><?= $DataDetalleM['Descripcion_Falla']?></td>
                    </tr>
                <?php } ?>
            <?php endforeach; ?>
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
            <?php foreach ($DataDetallesM as $DataDetalleM): ?>
                <?php if ($DataDetalleM['ID_Detalle'] === null) {?>
                    <tr>
                        <td style="width: 60px;" colspan="4"><?= $DataDetalleM['Reparacion_Realizada']?></td>
                    </tr>
                <?php } else { ?>
                     <tr>
                        <td style="width: 60px;">DTR<?= $DataDetalleM['ID_Detalle']?></td>
                        <td style="width: 60px;"colspan="4"><?= $DataDetalleM['Reparacion_Realizada']?></td>
                    </tr>
                <?php } ?>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Tabla de insumos -->
    <table border="1">
        <thead>
            <tr>
                <th colspan="7" style="text-align: center; background-color: #e7e5e5ff;" >INSUMOS Y REPUESTOS INSTALADOS</th>
            </tr>
            <tr>
                <th style="width: 60px;">Codigo</th>
                <th style="width: 60px;">Cantidad</th>
                <th style="width: 40px;"></th>
                <th colspan="4">Nombre</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($DataInsumosM)): ?>
                <?php foreach ($DataInsumosM as $insumo): ?>
                    <tr>
                        <td style="width: 60px;"><?= $insumo['CodigoInsumo'] ?></td>
                        <td style="width: 60px; text-align: center;"><?= $insumo['Cantidad'] ?></td>
                        <td style="width: 40px; text-align: center;"><?= $insumo['Medida'] ?></td>
                        <td colspan="4"><?= $insumo['NombreInsumo'] ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" style="text-align: center;">No se registraron insumos o repuestos instalados.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Tabla falla -->
    <table border="1">
        <thead>
            <tr>
                <th style="text-align: center; background-color: #e7e5e5ff;">FALLA CORREGIDA: </th>
                <td style="text-align: center;"><?= $DataDetalleM['FallaC']?></td>
                <th style="text-align: center; background-color: #e7e5e5ff;">PROGRAMAR NUEVAMENTE PARA EL DÍA: </th>
                <td style="text-align: center;"><?= $DataDetalleM['Fecha_Correcion'] ?? 'N/A'?></td>
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
                <td th colspan="4"><?= $DataDetalleM['Pendiente'] ?? 'NO HAY PENDIENTES'?></td>
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
                <td th colspan="4"><?= $DataDetalleM['Observaciones'] ?? 'SIN OBSERVACIONES'?></td>
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
                <?php if ($totalMecanicos == 1): ?>
                    <th style="font-size: 14px;">Técnico</th>
                <?php endif; ?>
                <th style="font-size: 14px;">Dir. Técnico y Logístico | Jefe de Taller</th>
                <th style="font-size: 14px;">Operario o Supervisor (recibe el equipo)</th>
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
                    <?php if ($DataMantenimiento['ID_Operario'] !== null): ?>
                        <img src="<?= $DataMantenimiento['Firma_Operario'] ?>" style="max-width: 100%;">
                    <?php else: ?>
                        <span>No aplica</span>
                    <?php endif; ?>
                </td>
            </tr>

            <tr>
                <?php if ($totalMecanicos == 1): ?>
                    <th style="text-align:center;"><?= $DataMecanicos[0]['NombreMecanico'] ?></th>
                <?php endif; ?>
                <th style="text-align:center;"><?= $DataMantenimiento['NombreSupervisor'] ?></th>
                <th style="text-align:center;">
                    <?= ($DataMantenimiento['ID_Operario'] !== null)
                        ? htmlspecialchars($DataMantenimiento['NombreOperario'])
                        : 'No aplica'; ?>
                </th>
            </tr>

            <tr>
                <?php if ($totalMecanicos == 1): ?>
                    <th>Firma</th>
                <?php endif; ?>
                <th>Firma</th>
                <th>Firma</th>
            </tr>
        </tbody>
    </table>
    
    <div style="page-break-before: always;"></div>

   <table border="1">
    <thead>
        <tr>
            <th colspan="4" style="font-size: 14px;">EVIDENCIA FOTOGRÁFICA</th>
        </tr>
    </thead>
    <tbody>

        <!-- ================= IMÁGENES POR DETALLE (ORDEN) ================= -->
        <?php foreach ($imagenesPorDetalle as $ID_Detalle => $imagenes): ?>
            <tr>
                <td rowspan="<?= ceil(count($imagenes) / 3); ?>"
                    style="writing-mode: vertical-rl; text-orientation: upright;
                           background-color:#000020; color:white;
                           font-weight:bold; width:20px;
                           font-size:15px; vertical-align:middle; text-align:center;">
                    DETALLE <?= $ID_Detalle ?>
                </td>

                <?php
                    $contador = 0;
                    foreach ($imagenes as $index => $img):
                        if ($contador > 0 && $contador % 3 == 0) {
                            echo '</tr><tr>';
                        }
                ?>
                    <td style="text-align:center; padding:5px;">
                        <img src="<?= $baseUrl . htmlspecialchars($img['Evidencia_Fotografica']) ?>"
                             width="100px" height="100px">
                    </td>
                <?php
                    $contador++;
                    endforeach;

                    $resto = $contador % 3;
                    if ($resto > 0) {
                        for ($i = $resto; $i < 3; $i++) {
                            echo '<td></td>';
                        }
                    }
                ?>
            </tr>
        <?php endforeach; ?>


        <!-- ================= IMÁGENES POR CATEGORÍA (CORRECTIVO) ================= -->
        <?php foreach ($imagenesPorCategoria as $categoria => $imagenes): ?>
            <tr>
                <td rowspan="<?= ceil(count($imagenes) / 3); ?>"
                    style="writing-mode: vertical-rl; text-orientation: upright;
                           background-color:#1e1e1e; color:white;
                           font-weight:bold; width:20px;
                           font-size:15px; vertical-align:middle; text-align:center;">
                    <?= htmlspecialchars($categoria) ?>
                </td>

                <?php
                    $contador = 0;
                    foreach ($imagenes as $index => $img):
                        if ($contador > 0 && $contador % 3 == 0) {
                            echo '</tr><tr>';
                        }
                ?>
                    <td style="text-align:center; padding:5px;">
                        <img src="<?= $baseUrl . htmlspecialchars($img['Evidencia_Fotografica']) ?>"
                             width="100px" height="100px">
                    </td>
                <?php
                    $contador++;
                    endforeach;

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