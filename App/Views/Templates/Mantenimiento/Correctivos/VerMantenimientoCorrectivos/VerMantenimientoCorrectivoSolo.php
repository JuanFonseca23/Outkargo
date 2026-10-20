<?php
    include_once "App/Controllers/MantenimientosController.php";
    $MantenimientosController = new MantenimientosController();
    $Tipo = "Correctivo";
    $DataMantenimiento = $MantenimientosController->VerMantenimientoC($_GET['ID']);
    $DataMecanicos = $MantenimientosController->VerMecanicosC($_GET['ID']);
    $DataDetallesM = $MantenimientosController->VerDetalleMC($_GET['ID']);
    $DataImagenesM = $MantenimientosController->DataImagenesMC($_GET['ID']);
    $Insumos = $MantenimientosController->ObtenerInsumosMantenimiento($_GET['ID'], $Tipo);
    $observaciones = json_decode($DataMantenimiento['Observaciones'] ?? '[]', true);
    $observaciones = is_array($observaciones) ? $observaciones : [];
    $novedades = $MantenimientosController->ObtenerNovedadesMantenimiento($_GET['ID'], $Tipo);
    $DataMecanicos = is_array($DataMecanicos) ? $DataMecanicos : [];
    $DataDetallesM = is_array($DataDetallesM) ? $DataDetallesM : [];
    $Insumos = is_array($Insumos) ? $Insumos : [];
    $listaImagenes = $DataImagenesM['imagenes'] ?? $DataImagenesM;
    $listaImagenes = is_array($listaImagenes) ? $listaImagenes : [];
    $novedades = is_array($novedades) ? $novedades : [];
    $imagenesPorDetalle = [];
    foreach ($listaImagenes as $img) {
        $idDetalle = $img['ID_Detalle'];
        $categoria = trim($img['Categoria'] ?? '');

        if (!isset($imagenesPorDetalle[$idDetalle])) {
            $imagenesPorDetalle[$idDetalle] = [
                'Falla' => [],
                'Correccion' => []
            ];
        }

        if (strcasecmp($categoria, 'Falla') === 0) {
            $imagenesPorDetalle[$idDetalle]['Falla'][] = $img;
        } elseif (
            strcasecmp($categoria, 'Correccion') === 0 ||
            strcasecmp($categoria, 'Corrección') === 0 ||
            strcasecmp($categoria, 'Reparacion') === 0 ||
            strcasecmp($categoria, 'Reparación') === 0
        ) {
            $imagenesPorDetalle[$idDetalle]['Correccion'][] = $img;
        }
    }
    

    if ($_SERVER['HTTP_HOST'] == 'localhost') {
        $baseUrl = 'http://localhost/OUTKARGO/';
    } else {
        $baseUrl = 'https://outkargo.com.co/';
    }

    if ($DataMantenimiento['ID_Operario'] === Null){
        $NombreOperario = $DataMantenimiento['Nombre_Externo'];
    }else{
        $NombreOperario = $DataMantenimiento['NombreOperario'];
    }
    if ($DataMantenimiento['ID_Recibe'] === Null){
        $NombreRecibe = $DataMantenimiento['Nombre_Externo_Recibe'];
    }else{
        $NombreRecibe = $DataMantenimiento['NombreRecibe'];
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
                <td>13-04-2026</td>
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
                <td ><?= date('d/m/Y', strtotime($DataMantenimiento['Fecha_Realizado'])) ?></td>
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
                <td ><?= $DataMantenimiento['Horometro'] !== null ? $DataMantenimiento['Horometro']  : 'NO APLICA';?></td>
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
                <th colspan="6" style="text-align: center; background-color: #e7e5e5ff; font-size: 12px;" >DESCRIPCIÓN DE LA FALLA</th>
            </tr>
            <tr>
                <th style="width: 60px;">Código</th>
                <th style="width: 60px;">Sección</th>
                <th style="width: 60px;" colspan="4">Descripción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($DataDetallesM as $DataDetalleM): ?>
                <tr>
                    <td style="width: 60px;">DT<?= $DataDetalleM['ID']?></td>
                    <td style="width: 60px;"><?= $DataDetalleM['Seccion']?></td>
                    <td style="width: 60px;" colspan="4"><?= $DataDetalleM['Descripcion_Falla']?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Tabla REPARACIÓN REALIZADA -->
    <table border="1">
        <thead>
            <tr>
                <th colspan="6" style="text-align: center; background-color: #e7e5e5ff; font-size: 12px;">REPARACIÓN REALIZADA</th>
            </tr>
            <tr>
                <th style="width: 60px;">Código</th>
                <th style="width: 60px;">Sección</th>
                <th style="width: 60px;" colspan="4">Descripción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($DataDetallesM as $DataDetalleM): ?>
                <tr>
                    <td style="width: 60px;">DT<?= $DataDetalleM['ID']?></td>
                    <td style="width: 60px;"><?= $DataDetalleM['Seccion']?></td>
                    <td style="width: 60px;"colspan="4"><?= $DataDetalleM['Reparacion_Realizada']?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Tabla de observaciones y novedades -->
    <table border="1">
        <thead style="background-color: #e7e5e5ff;">
            <tr>
                <th style="font-size: 12px; width: 50%;">NOVEDADES PENDIENTES</th>
                <th style="font-size: 12px; width: 50%;">OBSERVACIONES</th>
            </tr>
        </thead>
    
        <tbody>
            <?php
            $totalFilas = max(count($novedades), count($observaciones));
    
            for ($i = 0; $i < $totalFilas; $i++):
            ?>
                <tr>
                    <td style="padding: 5px; vertical-align: top;">
                        <?php
                        if (isset($novedades[$i]['Descripcion'])) {
                            echo htmlspecialchars(
                                $novedades[$i]['Descripcion'],
                                ENT_QUOTES,
                                'UTF-8'
                            );
                        }
                        ?>
                    </td>
                    <td style="padding: 5px; vertical-align: top;">
                        <?php
                            if (isset($observaciones[$i])) {
                                echo htmlspecialchars(
                                    is_string($observaciones[$i])
                                        ? $observaciones[$i]
                                        : ($observaciones[$i]['observacion'] ?? ''),
                                    ENT_QUOTES,
                                    'UTF-8'
                                );
                            }
                        ?>
                    </td>
                </tr>
            <?php endfor; ?>
        </tbody>
    </table>

    <!-- Tabla de insumos -->
    <table border="1">
        <thead style="background-color: #e7e5e5ff;">
            <tr>
                <th colspan="5" style="font-size: 14px;">INSUMOS DE MANTENIMIENTO</th>
            </tr>
            <tr>
                <th colspan="2">Nombre</th>
                <th>Codigo</th>
                <th>Cantidad</th>
                <th>Medida</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($Insumos)) : ?>
                <?php foreach ($Insumos as $insumo) : ?>
                    <tr>
                        <td colspan="2"><?= htmlspecialchars($insumo['NombreInsumo']) ?></td>
                        <td style="text-align:center;" ><?= htmlspecialchars($insumo['CodigoInsumo']) ?></td>
                        <td style="text-align:center;" ><?= htmlspecialchars($insumo['Cantidad']) ?></td>
                        <td style="text-align:center;"><?= htmlspecialchars($insumo['Medida']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="5" style="text-align:center;">No se registraron insumos.</td>
                </tr>
            <?php endif; ?>
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
                <td width="50%" style="text-align: center;">
                    <img src="<?= $DataMantenimiento['Firma_Operario'] ?>" style="max-width: 100%;">
                </td>
            </tr>

            <tr>
                <?php if ($totalMecanicos == 1): ?>
                    <th style="text-align:center;"><?= $DataMecanicos[0]['NombreMecanico'] ?></th>
                <?php endif; ?>
                <th style="text-align:center;"><?= $DataMantenimiento['NombreSupervisor'] ?></th>
                <th style="text-align: center;"><?= $NombreRecibe ?></th>
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
            <th colspan="4" style="font-size:14px;">EVIDENCIA FOTOGRÁFICA</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($imagenesPorDetalle as $idDetalle => $categorias): ?>
            <!-- Encabezado del detalle -->
            <tr>
                <th colspan="4" style="background-color:#e9ecef; font-weight:bold; text-align:center; font-size:14px;">DT<?= htmlspecialchars((string)$idDetalle) ?></th>
            </tr>
            <?php foreach (['Falla', 'Correccion'] as $categoria): ?>
                <?php $imagenes = $categorias[$categoria] ?? [];
                    if (empty($imagenes)) {
                        continue;
                    }

                    $filas = (int) ceil(count($imagenes) / 3);
                    $contador = 0;
                ?>
                <tr>
                    <!-- Categoría en vertical -->
                    <td rowspan="<?= $filas ?>" style="writing-mode:vertical-rl; text-orientation:upright; background-color:#000020; color:white; font-weight:bold; width:25px; vertical-align:middle; text-align:center;">
                        <?= htmlspecialchars($categoria) ?>
                    </td>
                    <?php foreach ($imagenes as $img): ?>
                        <?php if ($contador > 0 && $contador % 3 === 0): ?>
                            </tr><tr>
                        <?php endif; ?>
                        <td style="text-align:center; padding:5px;">
                            <img src="<?= htmlspecialchars($baseUrl . $img['Evidencia_Fotografica'], ENT_QUOTES, 'UTF-8') ?>"
                            width="100" height="100" style="object-fit:contain;" alt="Evidencia <?= htmlspecialchars($categoria) ?>">
                        </td>
                        <?php $contador++; ?>
                    <?php endforeach; ?>
                    <?php
                        $resto = $contador % 3;
                        if ($resto > 0) {
                            for ($i = $resto; $i < 3; $i++) {
                                echo '<td></td>';
                            }
                        }
                    ?>
                </tr>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </tbody>
</table>

</body>

</html>
