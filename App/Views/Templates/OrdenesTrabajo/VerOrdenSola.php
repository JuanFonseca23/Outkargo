<?php
include_once "App/Controllers/OrdenesTrabajoController.php";
$OrdenesTrabajoController = new OrdenesTrabajoController();
$DataOrden = $OrdenesTrabajoController->VerOrden($_GET['ID']);
$DataMecanicos = $OrdenesTrabajoController->VerMecanicos($_GET['ID']);
$DataMontacargas = $OrdenesTrabajoController->VerMontacargas($_GET['ID']);
$DataInsumos = $OrdenesTrabajoController->VerDetallesInsumosOrden($_GET['ID']);

if($DataOrden['Tipo_Trabajo'] === 'MantenimientoP'){
    $Tipo = 'Mantenimiento Preventivo';
}else if ($DataOrden['Tipo_Trabajo'] === 'MantenimientoC'){
    $Tipo = 'Mantenimiento Correctivo';
}else{
    $Tipo = $DataOrden['Tipo_Trabajo'];
}

$DataOrdenDetalles = $OrdenesTrabajoController->VerDetallesOrden($_GET['ID'], $DataOrden['Tipo_Trabajo']);

$TotalTrabajos = 0;
$TrabajosRealizados = 0;

if (!empty($DataOrdenDetalles)) {
    foreach ($DataOrdenDetalles as $detalle) {
        $TotalTrabajos++;
        if ($detalle['EstadoTrabajo'] == 1) { 
            $TrabajosRealizados++;
        }
    }
}

$PorcentajeAvance = 0;
if ($TotalTrabajos > 0) {
    $PorcentajeAvance = round(($TrabajosRealizados / $TotalTrabajos) * 100);
}

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
            font-family: "Segoe UI", Arial, Helvetica, sans-serif;
            font-size: 13px;
            color: #222;
        }

        .tabla-encabezado{
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }

        .tabla-encabezado th,
        .tabla-encabezado td {
            padding: 3px 4px;
            border: 1px solid #000000;
            white-space: nowrap;
        }

        .Titulo {
            font-size: 20px;
            font-weight: 700;
            text-align: center;
            letter-spacing: 0.5px;
        }

        .tabla-contenedor{
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }

        .tabla-contenedor2,
        .tabla-contenedor3{
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .tabla-contenedor4{
            width: 50%;
            border-collapse: collapse;
            align-items: center;
        }

        .tabla-info,
        .tabla-info2 {
            width: 100%;
            border-collapse: collapse;
        }

        .tabla-info th, 
        .tabla-info td  {
            text-align: left;
            padding: 3px 4px;
            border: 1px solid #000000;
            white-space: nowrap;
            font-size: 12px;
        }

        .tabla-info2 th, 
        .tabla-info2 td  {
            text-align: center;
            padding: 3px 4px;
            border: 1px solid #000000;
            white-space: nowrap;
            font-size: 12px;
        }

        .tabla-contenedor2 th, 
        .tabla-contenedor2 td {
            text-align: left;
            padding: 3px 4px;
            border: 1px solid #000000;
            font-size: 12px;
            white-space: normal;    
            word-break: break-word;  
        }
        
        .tabla-contenedor3 th, 
        .tabla-contenedor3 td {
            text-align: left;
            padding: 3px 4px;
            border: 1px solid #000000;
            font-size: 12px;
            white-space: normal;    
            word-break: break-word;  
        }

        .tabla-contenedor4 th, 
        .tabla-contenedor4 td {
            text-align: center;
            padding: 3px 4px;
            border: 1px solid #000000;
            font-size: 12px;
            white-space: normal;    
            word-break: break-word;  
        }

        .col-tecnicos {
            width: 30%;
        }

        .porcentaje {
            font-size: 40px;
            font-weight: bold;
        }

        .oculto {
            visibility: hidden;
        }
    </style>

    <table class="tabla-encabezado">
        <thead>
            <tr>
                <th rowspan="3"><img src="<?= $baseUrl ?>App/Views/Img/Outkargo.png" width="150px"></th>
                <th rowspan="3" class="Titulo">ORDEN DE TRABAJO</th>
                <th>CODIGO:</th>
                <td></td>
            </tr>
            <tr>
                <th>FECHA:</th>
                <td>29/01/2026</td>
            </tr>
            <tr>
                <th>VERSIÓN:</th>
                <td>1</td>
            </tr>
        </thead>
    </table>

    <table class="tabla-contenedor">
        <tr>
            <td style="width:40%;">
                <table class="tabla-info2">
                    <thead>
                        <tr>
                            <th colspan="2">Índice de finalización</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="porcentaje"><?= $PorcentajeAvance ?>%</td>
                            <td>
                                <img width="80" height="80" src="https://img.icons8.com/dotty/80/checked.png" alt="checked" class="<?= $DataOrden['Estado_Orden'] === 'Aprobada' ? '' : 'oculto' ?>"/>
                            </td>
                        </tr>
                    </tbody>

                </table>
            </td>
            <!-- BLOQUE DERECHO -->
            <td style="width:60%;">
                <table class="tabla-info">
                    <tr>
                        <th>Numero de orden:</th>
                        <td><?= $DataOrden['Numero'] ?></td>
                    </tr>
                    <tr>
                        <th>Fecha de emisión de orden:</th>
                        <td><?= $DataOrden['Fecha_Generada'] ?></td>
                    </tr>
                    <tr>
                        <th>Prioridad:</th>
                        <td><?= $DataOrden['Prioridad'] ?></td>
                    </tr>
                    <tr>
                        <th>Emitido por:</th>
                        <td><?= $DataOrden['NombreSupervisor'] ?></td>
                    </tr>
                    <tr>
                        <th>Centro de trabajo:</th>
                        <td><?= $DataOrden['CentroOrden'] ?></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <table class="tabla-contenedor2">
        <?php 
            $Mostrado = false;
            if ($DataOrdenDetalles) {
                foreach ($DataOrdenDetalles as $DataOrdenDetalle) {
                    if ($DataOrden['Tipo_Trabajo'] === 'Repuesto'){ 
                        if (!$Mostrado) {?>
            <tr>
                <th>Solicita:</th>
                <td colspan="3"><?= $DataOrdenDetalle["NombreSolicita"] ?></td>
                <th>Centro Solicita:</th>
                <td><?= $DataOrdenDetalle["NombreCentro"] ?></td>
                <th>Fecha Solicita:</th>
                <td><?= $DataOrdenDetalle["FechaSolicitud"] ?></td>
            </tr>
        <?php
                        $Mostrado = true;
                        }
                    }
                }
            }
        ?>

        <tr>
            <th style="width: 90px;">Tecnico(s) Encargado(s):</th>
            <td colspan="4" class="col-tecnicos">
                <?php
                if ($DataMecanicos) {
                    echo '<ul style="list-style:none; margin:0; padding:0;">';
                    foreach ($DataMecanicos as $mecanico) {
                        echo '<li>' . htmlspecialchars($mecanico['NombreMecanico']) . '</li>';
                    }
                    echo '</ul>';
                } else {
                    echo 'No hay técnicos asignados';
                }
                ?>
            </td>
            <th>Tipo de Trabajo:</th>
            <td colspan="2"><?= $Tipo ?></td>
        </tr>
        <tr>
            <th >Fecha de Inicio:</th>
            <td><?= $DataOrden['Fecha_Inicio'] ?></td>
            <th colspan="2" >Fecha de Finalización Prevista:</th>
            <td ><?= $DataOrden['Fecha_Entrega_Aprox'] ?></td>
            <th >Fecha de Finalización:</th>
            <td colspan="2"><?= $DataOrden['Fecha_Finalizacion'] ?></td>
        </tr>
        <?php if ($DataOrden['Tipo_Trabajo'] === 'Overhauling' || $DataOrden['Tipo_Trabajo'] ==='MantenimientoP' || $DataOrden['Tipo_Trabajo'] === 'MantenimientoC'): ?>
            <tr>
                <th colspan="8" style="background-color: #e6e6e6; text-align: center;">Montacargas</th>
            </tr>
            <tr>
                <th>Numero:</th>
                <td><?= $DataMontacargas["Numero"] ?></td>
                <th>Marca:</th>
                <td><?= $DataMontacargas["Marca"] ?></td>
                <th>Modelo:</th>
                <td><?= $DataMontacargas["Modelo"] ?></td>
                <th >Serie:</th>
                <td ><?= $DataMontacargas["Serie"] ?></td>
            </tr>
        <?php endif; ?>
        <?php
            $tituloMostrado = false;
            if ($DataOrdenDetalles) {
                foreach ($DataOrdenDetalles as $DataOrdenDetalle) {
                    if($DataOrden ['Tipo_Trabajo'] === 'Repuesto' && $DataOrdenDetalle['Tipo_Producto'] === 'Montacargas'){
                        if (!$tituloMostrado) {
        ?>
            <tr>
                <th colspan="8" style="background-color: #e6e6e6; text-align: center;">Montacargas</th>
            </tr>
        <?php
                        $tituloMostrado = true;
                    }
        ?>
            <tr>
                <th>Numero:</th>
                <td><?= $DataOrdenDetalle["NumeroMontacargas"] ?></td>
                <th>Marca:</th>
                <td><?= $DataOrdenDetalle["MarcaMontacargas"] ?></td>
                <th>Modelo:</th>
                <td style="width: 80px;"><?= $DataOrdenDetalle["ModeloMontacargas"] ?></td>
                <th style="width: 50px;">Serie:</th>
                <td ><?= $DataOrdenDetalle["SerieMontacargas"] ?></td>
            </tr>

        <?php
                    }
                }
            }
        ?>
    </table>

    <table class="tabla-contenedor3">
        <?php
            $esMantenimiento = (
                $DataOrden['Tipo_Trabajo'] === 'Overhauling' ||
                $DataOrden['Tipo_Trabajo'] === 'MantenimientoP' ||
                $DataOrden['Tipo_Trabajo'] === 'MantenimientoC'
            );
        ?>

        <?php if ($esMantenimiento): ?>
            <!-- ================= MANTENIMIENTOS ================= -->
            <thead>
                <tr>
                    <th colspan="3" style="background-color:#e6e6e6;text-align:center;">
                        TRABAJOS A REALIZAR EN MONTACARGAS
                    </th>
                </tr>
                <tr>
                    <th style="width: 20px; text-align: center;">#</th>
                    <th style="width: 60px; text-align: center;">Código</th>
                    <th style="text-align: center;">Descripción de Falla</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $n = 0;
                    foreach ($DataOrdenDetalles as $d) {
                        $n++;
                ?>
                    <tr>
                        <td style="width: 20px; text-align: center;"><?= $n ?></td>
                        <td style="width: 60px; text-align: center;">DTR<?= $d['ID'] ?></td>
                        <td><?= $d['DescripcionFalla'] ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        <?php else: ?>
            <!-- ================= REPUESTOS ================= -->
            <?php
                $tieneMontacargas = false;
                $tieneRepuestos = false;
                foreach ($DataOrdenDetalles as $d) {
                    if ($d['Tipo_Producto'] === 'Montacargas') {
                        $tieneMontacargas = true;
                        break;
                    }
                }
                foreach ($DataOrdenDetalles as $d) {
                    if ($d['Tipo_Producto'] === 'Repuestos') {
                        $tieneRepuestos = true;
                        break;
                    }
                }
            ?>

            <?php if ($tieneMontacargas): ?>
                <!-- -------- MONTACARGAS EN REPUESTOS -------- -->
                <thead>
                    <tr>
                        <th colspan="6" style="background-color:#e6e6e6;text-align:center;">
                            TRABAJOS A REALIZAR EN MONTACARGAS
                        </th>
                    </tr>
                    <tr>
                        <th style="width: 20px; text-align: center;">#</th>
                        <th style="width: 60px; text-align: center;">Código</th>
                        <th style="width: 60px; text-align: center;">Numero</th>
                        <th colspan="3">Descripción de Falla</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $n = 0;
                        foreach ($DataOrdenDetalles as $d) {
                            if ($d['Tipo_Producto'] === 'Montacargas') {
                                $n++;
                    ?>
                        <tr>
                            <td style="width: 20px; text-align: center;"><?= $n ?></td>
                            <td style="width: 60px; text-align: center;">DTR<?= $d['ID'] ?></td>
                            <td style="width: 60px; text-align: center;"><?= $d['NumeroMontacargas'] ?></td>
                            <td colspan="3"><?= $d['DescripcionFalla'] ?></td>
                        </tr>
                    <?php }} ?>
                </tbody>

            <?php endif; ?>

            <!-- -------- PRODUCTOS -------- -->
            <?php if ($tieneRepuestos): ?>
                <thead>
                    <tr>
                        <th colspan="6" style="background-color:#e6e6e6;text-align:center;">
                            TRABAJOS A REALIZAR EN PRODUCTOS
                        </th>
                    </tr>
                    <tr>
                        <th style="width: 20px; text-align: center;">#</th>
                        <th style="width: 60px; text-align: center;">Código</th>
                        <th style="width: 90px; text-align: center;">Serie</th>
                        <th style="width: 90px; text-align: center;">Parte</th>
                        <th style="text-align: center;" colspan="2">Descripción de Falla</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $n = 0;
                        foreach ($DataOrdenDetalles as $d) {
                            if ($d['Tipo_Producto'] !== 'Montacargas') {
                                $n++;
                    ?>
                        <tr>
                            <td style="width: 20px; text-align: center;"><?= $n ?></td>
                            <td style="width: 60px; text-align: center;">DTR<?= $d['ID'] ?></td>
                            <td style="width: 90px; text-align: center;"><?= $d['Serie'] ?? '' ?></td>
                            <td style="width: 90px; text-align: center;"><?= $d['Parte'] ?? '' ?></td>
                            <td colspan="2"><?= $d['DescripcionFalla'] ?></td>
                        </tr>
                    <?php }} ?>
                </tbody>
            <?php endif; ?>
        <?php endif; ?>
    </table>

    <table class="tabla-contenedor2">
        <thead>
                <tr>
                    <th colspan="3" style="background-color:#e6e6e6;text-align:center;">
                        TRABAJOS REALIZADOS
                    </th>
                </tr>
                <tr>
                    <th style="width: 20px; text-align: center;">#</th>
                    <th style="text-align: center;">Código</th>
                    <th style="text-align: center;">Descripción de Trabajo Realizado</th>
                </tr>
        </thead>
        <tbody>
            <?php
            $Numero = 0;
            if ($DataOrdenDetalles) {
                foreach ($DataOrdenDetalles as $DataOrdenDetalle) {
                    $Numero++;
            ?>
            <tr>
                <td style="text-align:center;"><?= $Numero ?></td>
                <td style="width: 60px; text-align: center;">DTR<?= $DataOrdenDetalle['ID'] ?></td>
                <td><?= $DataOrdenDetalle['Descripcion'] ?></td>
            </tr>
            <?php
                }
            }
            ?>
        </tbody>        
    </table>

    <table class="tabla-contenedor2">
        <thead>
                <tr>
                    <th colspan="5" style="background-color:#e6e6e6;text-align:center;">
                        INSUMOS Y REPUESTOS INSTALADOS 
                    </th>
                </tr>
                <tr>
                    <th style="width: 20px; text-align: center;">#</th>
                    <th style="text-align: center;">Código</th>
                    <th style="text-align: center;">Cantidad</th>
                    <th style="text-align: center;"></th>
                    <th style="text-align: center;">Nombre</th>
                </tr>
        </thead>
        <tbody>
            <?php
            $Numero = 0;

            if (!empty($DataInsumos)) {
                foreach ($DataInsumos as $DataInsumo) {
                    $Numero++;
            ?>
            <tr>
                <td style="text-align:center;"><?= $Numero ?></td>
                <td style="width: 60px; text-align: center;"><?= $DataInsumo['CodigoInsumo'] ?></td>
                <td style="width: 60px; text-align: center;"><?= $DataInsumo['Cantidad'] ?></td>
                <td style="width: 60px; text-align: center;"><?= $DataInsumo['Medida'] ?></td>
                <td><?= $DataInsumo['NombreInsumo'] ?></td>
            </tr>
            <?php
                }
            } else {
            ?>
            <tr>
                <td colspan="5" style="text-align:center; font-style:italic;">
                    No hay insumos ni repuestos instalados
                </td>
            </tr>
            <?php
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
    <table class="tabla-contenedor2">
        <thead>
            <tr>
                <th style="font-size:14px; text-align: center;">Técnico</th>
                <th style="font-size:14px; text-align: center;">Dir. Técnico y Logístico | Jefe de Taller</th>
            </tr>
        </thead>
        <tbody>
            <tr height="100px">
                <td width="50%" align="center">
                    <img src="<?= $DataMecanicos[0]['Firma_Mecanico'] ?>" style="max-width:100%;">
                </td>
                <td width="50%" align="center">
                    <img src="<?= $DataOrden['Firma_Verifica'] ?>" style="max-width:100%;">
                </td>
            </tr>
            <tr>
                <th><?= htmlspecialchars($DataMecanicos[0]['NombreMecanico']) ?></th>
                <th><?= htmlspecialchars($DataOrden['NombreSupervisor']) ?></th>
            </tr>
            <tr>
                <th>Firma</th>
                <th>Firma</th>
            </tr>
        </tbody>
    </table>
    <?php elseif ($totalMecanicos === 2): ?>
    <!-- 2 TÉCNICOS + SUPERVISOR -->
    <table class="tabla-contenedor2">
        <thead>
            <tr>
                <th colspan="2" style="font-size:14px; text-align: center;">Técnico(s)</th>
                <th style="font-size:14px; text-align: center;">Dir. Técnico y Logístico | Jefe de Taller</th>
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
                    <img src="<?= $DataOrden['Firma_Verifica'] ?>" style="max-width:100%;">
                </td>
            </tr>
            <tr>
                <?php foreach ($DataMecanicos as $mecanico): ?>
                    <th><?= htmlspecialchars($mecanico['NombreMecanico']) ?></th>
                <?php endforeach; ?>
                <th><?= htmlspecialchars($DataOrden['NombreSupervisor']) ?></th>
            </tr>
            <tr>
                <th>Firma</th>
                <th>Firma</th>
                <th>Firma</th>
            </tr>
        </tbody>
    </table>
    <?php else: ?>
    <table class="tabla-contenedor2">
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
    <table class="tabla-contenedor4">
        <thead>
            <tr>
                <th style="font-size:14px;">
                    Dir. Técnico y Logístico | Jefe de Taller
                </th>
            </tr>
        </thead>
        <tbody>
            <tr height="100px">
                <td>
                    <img src="<?= $DataOrden['Firma_Verifica'] ?>" style="max-width:100%;">
                </td>
            </tr>
            <tr>
                <th><?= htmlspecialchars($DataOrden['NombreSupervisor']) ?></th>
            </tr>
            <tr>
                <th>Firma</th>
            </tr>
        </tbody>
    </table>
    <?php endif; ?>
</body>
</html>