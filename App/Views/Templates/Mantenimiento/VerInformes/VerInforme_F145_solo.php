<?php
include_once "App/Controllers/MantenimientosController.php";
$MantenimientosController = new MantenimientosController();
$DataInforme = $MantenimientosController->VerInforme($_GET['tipoInforme'], $_GET['centro'], $_GET['fechaDesde'], $_GET['fechaHasta'], $_GET['montacargas'], $_GET['tipoMantenimiento']);
$FechaActualización = date("d/m/Y");
$tipoMantenimientoSeleccionado = $_GET['tipoMantenimiento'] ?? '';
if ($_SERVER['HTTP_HOST'] == 'localhost') {
    $baseUrl = 'http://localhost/OUTKARGO/';
} else {
    $baseUrl = 'https://outkargo.com.co/';
}

function estadoMantenimiento250($fechaUltimo){
    if (empty($fechaUltimo)) {
        return [
            'estado' => 'VENCIDO',
            'clase' => 'vencido',
            'dias' => null
        ];
    }

    $hoy = strtotime(date('Y-m-d'));
    $fechaUltimoTimestamp = strtotime($fechaUltimo);

    $diasTranscurridos = (int) floor(($hoy - $fechaUltimoTimestamp) / 86400);

    if ($diasTranscurridos <= 30) {

        return [
            'estado' => 'VIGENTE',
            'clase' => 'al-dia',
            'dias' => $diasTranscurridos
        ];

    } elseif ($diasTranscurridos <= 40) {

        return [
            'estado' => 'PENDIENTE',
            'clase' => 'pendiente',
            'dias' => $diasTranscurridos
        ];

    } else {

        return [
            'estado' => 'VENCIDO',
            'clase' => 'vencido',
            'dias' => $diasTranscurridos
        ];
    }
}

function estadoMantenimientoPorHorometro($horometroActual, $horometroUltimo, $umbral){
    $actual = is_numeric($horometroActual) ? (float)$horometroActual : 0;

    /* Si no existe un mantenimiento anterior de este tipo, el punto de partida es 0 */
    if ($horometroUltimo === null || $horometroUltimo === '') {
        $horometroBase = 0;
    } else {
        $horometroBase = (float)$horometroUltimo;
    }

    $diferencia = $actual - $horometroBase;

    /* 10% de tolerancia para PENDIENTE.
        1000 -> 100 horas
        2000 -> 200 horas */

    $tolerancia = $umbral * 0.10;
    if ($diferencia < $umbral) {
        $estado = 'VIGENTE';
        $clase = 'al-dia';
    } elseif ($diferencia <= ($umbral + $tolerancia)) {
        $estado = 'PENDIENTE';
        $clase = 'pendiente';
    } else {
        $estado = 'VENCIDO';
        $clase = 'vencido';
    }

    /* Progreso respecto al intervalo */
    $porcentaje = $umbral > 0 ? min(100, ($diferencia / $umbral) * 100) : 0;
    return [
        'estado' => $estado,
        'clase' => $clase,
        'diferencia' => $diferencia,
        'porcentaje' => $porcentaje,
        'tolerancia' => $tolerancia
    ];
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

    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link href="../../App/Views/Resources/Lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="../../App/Views/Resources/Lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <link href="../../App/Views/Resources/Css/Dashboard/style.css" rel="stylesheet">
</head>

<body>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th,td {
            font-size: 10px;
            padding: 4px;
        }
        .titulo-tabla {
            background-color: #003366;
            color: #fff;
            font-size: 12px;
            text-align: left;
            padding: 6px;
        }
        .vencido {
            background-color: #ff293b;
            color: #fff;
            font-weight: bold;
        }
        .al-dia {
            background-color: #d4edda;
            font-weight: bold;
        }
        .pendiente {
            background-color: #ffae62;
            color: #fff;
            font-weight: bold;
        }
        .anulada {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translateX(-50%) translateY(-50%);
        }
        .barra-dias {
            width: 100%;
            min-width: 80px;
            max-width: 130px;
            margin: auto;
        }
        .barra-dias-fondo {
            position: relative;
            height: 18px;
            background: #eeeeee;
            border: 1px solid #cccccc;
            overflow: hidden;
            border-radius: 2px;
        }
        .barra-dias-progreso {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            transition: width 0.3s ease;
        }
        .barra-dias-progreso.al-dia {
            background: #d9f2d9;
            border-color: #28a745;
            color: #155724;
        }
        .barra-dias-progreso.pendiente {
            background: #fff3cd;
            border-color: #ff8b07;
            color: #856404;
        }
        .barra-dias-progreso.vencido {
            background: #ffd6d6;
            border-color: #ff0000;
            color: #8b0000;
        }
        .barra-dias-texto {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 9px;
            font-weight: bold;
            color: #000;
            z-index: 2;
        }
    </style>

    <!-- Tablas de encabezado -->
    <table border="1">
        <thead>
            <tr>
                <th rowspan="3">
                    <img src="<?= $baseUrl ?>App/Views/Img/Outkargo.png" width="200px">
                </th>
                <th rowspan="3" class="Titulo" style="font-size: 14px;">
                    MATRIZ DE SEGUIMIENTO DE MANTINIMIENTOS PREVENTIVOS
                </th>
                <th>CODIGO:</th>
                <td style="width: 70px; text-align: center;">F-145</td>
            </tr>
            <tr>
                <th>FECHA:</th>
                <td style="width: 70px; text-align: center;">26/11/2026</td>
            </tr>
            <tr>
                <th>VERSIÓN:</th>
                <td style="width: 70px; text-align: center;">3</td>
            </tr>
        </thead>
    </table>
    <table border="1">
        <thead>
            <tr>
                <th>Fecha de actualización:</th>
                <th><?= $FechaActualización ?></th>
                <th>Responsable del reporte:</th>
                <th><?= htmlspecialchars($_GET['NombreGenera'] ?? '') ?></th>
            </tr>
        </thead>
    </table>

    <?php if ($tipoMantenimientoSeleccionado === '' ||$tipoMantenimientoSeleccionado === '250_Horas'): ?>
        <!-- ================= TABLA 250 HORAS ================= -->
        <?php
            $totalMantenimientos250 = count($DataInforme);
            $totalVencidos250 = 0;
            $totalPendientes250 = 0;
            $totalVigentes250 = 0;
        ?>
        <table border="1">
            <thead>
                <tr>
                    <th class="titulo-tabla"  style="text-align: center;" colspan="12">MANTENIMIENTO 250 HORAS (mensual)</th>
                </tr>
                <tr>
                    <th>Centro de trabajo</th>
                    <th>Equipo</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Serie</th>
                    <th>Fecha Último Mant. 250h</th>
                    <th>Estado</th>
                    <th>Días transcurridos desde el último mantenimiento</th>
                    <th>Horómetro último mantenimiento</th>
                    <th>Horómetro Actual</th>
                    <th>Diferencia horómetro</th>
                    <th>Observaciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($DataInforme as $fila): ?>
                <?php
                    $estado250 = estadoMantenimiento250($fila['Fecha_Ultimo_250'] ?? null);
                    // Contadores
                    if ($estado250['estado'] === 'VENCIDO') {
                        $totalVencidos250++;
                    } elseif ($estado250['estado'] === 'PENDIENTE') {
                        $totalPendientes250++;
                    } elseif ($estado250['estado'] === 'VIGENTE') {
                        $totalVigentes250++;
                    }
                    // Horómetros
                    $horometroUltimo = $fila['Horometro_Ultimo_250'] ?? 0;
                    $horometroActual = $fila['Horometro'] ?? 0;
                    // Diferencia
                    $diferencia = is_numeric($horometroUltimo) && is_numeric($horometroActual) ? $horometroActual - $horometroUltimo : '';
                    // Días
                    $dias = $estado250['dias'];
                    $porcentajeBarra = $dias !== null ? min(100, ($dias / 30) * 100) : 0;
                ?>
                <tr>
                    <td style="text-align:center;"><?= htmlspecialchars($fila['CentroTrabajo'] ?? '') ?></td>
                    <td style="text-align:center;"><?= htmlspecialchars($fila['Equipo'] ?? '') ?></td>
                    <td style="text-align:center;"><?= htmlspecialchars($fila['Marca'] ?? '') ?></td>
                    <td style="text-align:center;"><?= htmlspecialchars($fila['Modelo'] ?? '') ?></td>
                    <td style="text-align:center;"><?= htmlspecialchars($fila['Serie'] ?? '') ?></td>
                    <td style="text-align:center;"><?= !empty($fila['Fecha_Ultimo_250']) ? date('d/m/Y', strtotime($fila['Fecha_Ultimo_250'])) : 'Sin registro' ?></td>
                    <td style="text-align:center;" class="<?= $estado250['clase'] ?>"><?= $estado250['estado'] ?></td>
                    <td class="text-center">
                        <div class="barra-dias">
                            <div class="barra-dias-fondo">
                                <div class="barra-dias-progreso 
                                    <?= $estado250['clase'] ?>" style="width: <?= $porcentajeBarra ?>%;">
                                </div>
                                <span class="barra-dias-texto"><?= $dias !== null ? $dias . ' días': '-' ?></span>
                            </div>
                        </div>
                    </td>
                    <td style="text-align:center;"><?= htmlspecialchars($horometroUltimo) ?></td>
                    <td style="text-align:center;"><?= htmlspecialchars($horometroActual) ?></td>
                    <td style="text-align:center;"><?= htmlspecialchars($diferencia) ?></td>
                    <td style="text-align:center;"><?= htmlspecialchars($fila['Observaciones'] ?? '') ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <?php
                    $porcentajeVencido250 = $totalMantenimientos250 > 0 ? round(($totalVencidos250 / $totalMantenimientos250) * 100, 2) : 0;
                    $porcentajePendiente250 = $totalMantenimientos250 > 0 ? round(($totalPendientes250 / $totalMantenimientos250) * 100, 2): 0;
                    $porcentajeVigente250 = $totalMantenimientos250 > 0 ? round(($totalVigentes250 / $totalMantenimientos250) * 100, 2): 0;
                ?>
                <tr>
                    <th style="text-align:center;" colspan="7">% MANTENIMIENTO VENCIDO</th>
                    <th style="text-align:center;" colspan="5"><?= number_format($porcentajeVencido250, 2) ?>%
                        <br> 
                        <small>(<?= $totalVencidos250 ?> equipos) </small>
                    </th>
                </tr>
                <tr>
                    <th style="text-align:center;" colspan="7">% MANTENIMIENTO PENDIENTE</th>
                    <th style="text-align:center;" colspan="5"><?= number_format($porcentajePendiente250, 2) ?>%
                        <br>
                        <small>(<?= $totalPendientes250 ?> equipos)</small>
                    </th>
                </tr>
                <tr>
                    <th style="text-align:center;" colspan="7">% MANTENIMIENTO VIGENTE</th>
                    <th style="text-align:center;" colspan="5"><?= number_format($porcentajeVigente250, 2) ?>%
                        <br>
                        <small>(<?= $totalVigentes250 ?> equipos)</small>
                    </th>
                </tr>

            </tfoot>
        </table>
    <?php endif; ?>
    <?php if ($tipoMantenimientoSeleccionado === '' ||$tipoMantenimientoSeleccionado === '1000_Horas'): ?>
        <!-- ================= TABLA 1000 HORAS ================= -->
        <?php
            $totalMantenimientos1000 = count($DataInforme);
            $totalVencidos1000 = 0;
            $totalPendientes1000 = 0;
            $totalVigentes1000 = 0;
        ?>
        <table border="1">
            <thead>
                <tr>
                    <th class="titulo-tabla" style="text-align:center;" colspan="12">MANTENIMIENTO 1000 HORAS</th>
                </tr>
                <tr>
                    <th>Centro de trabajo</th>
                    <th>Equipo</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Serie</th>
                    <th>Fecha Último Mant. 1000h</th>
                    <th>Estado</th>
                    <th>Días transcurridos desde el último mantenimiento</th>
                    <th>Horómetro último mantenimiento</th>
                    <th>Horómetro Actual</th>
                    <th>Diferencia horómetro</th>
                    <th>Observaciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($DataInforme as $fila): ?>
                    <?php
                        $horometroActual = is_numeric($fila['Horometro'] ?? null) ? (float)$fila['Horometro'] : 0;
                        $horometroUltimo1000 =(isset($fila['Horometro_Ultimo_1000']) && $fila['Horometro_Ultimo_1000'] !== '') ? (float)$fila['Horometro_Ultimo_1000'] : null;
                        $estado1000 = estadoMantenimientoPorHorometro( $horometroActual, $horometroUltimo1000, 1000);
                        // Días desde el último 1000
                        $fechaUltimo1000 = $fila['Fecha_Ultimo_1000'] ?? null;
                        if (!empty($fechaUltimo1000)) {
                            $dias1000 = (int) floor((strtotime(date('Y-m-d')) - strtotime($fechaUltimo1000)) / 86400);
                        } else {
                            $dias1000 = null;
                        }
                        // Contadores
                        if ($estado1000['estado'] === 'VENCIDO') {
                            $totalVencidos1000++;
                        } elseif ($estado1000['estado'] === 'PENDIENTE') {
                            $totalPendientes1000++;
                        } elseif ($estado1000['estado'] === 'VIGENTE') {
                            $totalVigentes1000++;
                        }
                    ?>
                    <tr>
                        <td style="text-align:center;"><?= htmlspecialchars($fila['CentroTrabajo'] ?? '') ?></td>
                        <td style="text-align:center;"><?= htmlspecialchars($fila['Equipo'] ?? '') ?></td>
                        <td style="text-align:center;"><?= htmlspecialchars($fila['Marca'] ?? '') ?></td>
                        <td style="text-align:center;"><?= htmlspecialchars($fila['Modelo'] ?? '') ?></td>
                        <td style="text-align:center;"><?= htmlspecialchars($fila['Serie'] ?? '') ?></td>
                        <td style="text-align:center;"><?= !empty($fila['Fecha_Ultimo_1000']) ? date('d/m/Y', strtotime($fila['Fecha_Ultimo_1000'])) : 'Sin registro' ?></td>
                        <td style="text-align:center;" class="<?= $estado1000['clase'] ?>"><?= $estado1000['estado'] ?></td>
                        <td class="text-center">
                            <div class="barra-dias">
                                <div class="barra-dias-fondo">
                                    <?php $porcentajeDias1000 = $dias1000 !== null ? min(100, ($dias1000 / 30) * 100) : 0;?>
                                    <div class="barra-dias-progreso <?= $estado1000['clase'] ?>" style="width: <?= $porcentajeDias1000 ?>%;"></div>
                                    <span class="barra-dias-texto"><?= $dias1000 !== null ? $dias1000 . ' días' : '-'?></span>
                                </div>
                            </div>
                        </td>
                        <td style="text-align:center;"><?= $horometroUltimo1000 !== null ? htmlspecialchars($horometroUltimo1000) : 'Sin registro'?></td>
                        <td style="text-align:center;"><?= htmlspecialchars($horometroActual) ?></td>
                        <td style="text-align:center;"><?= number_format($estado1000['diferencia'], 0) ?></td>
                        <td style="text-align:center;"><?= htmlspecialchars($fila['Observaciones'] ?? '') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>      
            <tfoot>
                <?php
                    $porcentajeVencido1000 = $totalMantenimientos1000 > 0 ? round(($totalVencidos1000 / $totalMantenimientos1000) * 100, 2) : 0;
                    $porcentajePendiente1000 = $totalMantenimientos1000 > 0 ? round(($totalPendientes1000 / $totalMantenimientos1000) * 100, 2) : 0;
                    $porcentajeVigente1000 = $totalMantenimientos1000 > 0 ? round(($totalVigentes1000 / $totalMantenimientos1000) * 100, 2) : 0;
                ?>
                <tr>
                    <th style="text-align:center;" colspan="7">% MANTENIMIENTO VENCIDO</th>
                    <th style="text-align:center;" colspan="5"><?= number_format($porcentajeVencido1000, 2) ?>%
                        <br>
                        <small>(<?= $totalVencidos1000 ?> equipos)</small>
                    </th>
                </tr>
                <tr>
                    <th style="text-align:center;" colspan="7">% MANTENIMIENTO PENDIENTE</th>
                    <th style="text-align:center;" colspan="5"><?= number_format($porcentajePendiente1000, 2) ?>%
                        <br>
                        <small>(<?= $totalPendientes1000 ?> equipos)</small>
                    </th>
                </tr>
                <tr>
                    <th style="text-align:center;" colspan="7">% MANTENIMIENTO VIGENTE</th>
                    <th style="text-align:center;" colspan="5"><?= number_format($porcentajeVigente1000, 2) ?>%
                        <br>
                        <small>(<?= $totalVigentes1000 ?> equipos)</small>
                    </th>
                </tr>
            </tfoot>
        </table>
    <?php endif; ?>
    <?php if ($tipoMantenimientoSeleccionado === '' ||$tipoMantenimientoSeleccionado === '2000_Horas'): ?>
        <!-- ================= TABLA 2000 HORAS ================= -->
        <?php
            $totalMantenimientos2000 = count($DataInforme);
            $totalVencidos2000 = 0;
            $totalPendientes2000 = 0;
            $totalVigentes2000 = 0;
        ?>
        <table border="1">
            <thead>
                <tr>
                    <th class="titulo-tabla" style="text-align:center;" colspan="12">MANTENIMIENTO 2000 HORAS</th>
                </tr>
                <tr>
                    <th>Centro de trabajo</th>
                    <th>Equipo</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Serie</th>
                    <th>Fecha Último Mant. 2000h</th>
                    <th>Estado</th>
                    <th>Días transcurridos desde el último mantenimiento</th>
                    <th>Horómetro último mantenimiento</th>
                    <th>Horómetro Actual</th>
                    <th>Diferencia horómetro</th>
                    <th>Observaciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($DataInforme as $fila): ?>
                    <?php
                        $horometroActual = is_numeric($fila['Horometro'] ?? null) ? (float)$fila['Horometro'] : 0;
                        $horometroUltimo2000 =(isset($fila['Horometro_Ultimo_2000']) && $fila['Horometro_Ultimo_2000'] !== '') ? (float)$fila['Horometro_Ultimo_2000'] : null;
                        $estado2000 = estadoMantenimientoPorHorometro($horometroActual, $horometroUltimo2000, 2000);
                        // Días desde el último 2000
                        $fechaUltimo2000 = $fila['Fecha_Ultimo_2000'] ?? null;
                        if (!empty($fechaUltimo2000)) {
                            $dias2000 = (int) floor((strtotime(date('Y-m-d')) - strtotime($fechaUltimo2000)) / 86400);
                        } else {
                            $dias2000 = null;
                        }
                        // Contadores
                        if ($estado2000['estado'] === 'VENCIDO') {
                            $totalVencidos2000++;
                        } elseif ($estado2000['estado'] === 'PENDIENTE') {
                            $totalPendientes2000++;
                        } elseif ($estado2000['estado'] === 'VIGENTE') {
                            $totalVigentes2000++;
                        }
                    ?>
                    <tr>
                        <td style="text-align:center;"><?= htmlspecialchars($fila['CentroTrabajo'] ?? '') ?></td>
                        <td style="text-align:center;"><?= htmlspecialchars($fila['Equipo'] ?? '') ?></td>
                        <td style="text-align:center;"><?= htmlspecialchars($fila['Marca'] ?? '') ?></td>
                        <td style="text-align:center;"><?= htmlspecialchars($fila['Modelo'] ?? '') ?></td>
                        <td style="text-align:center;"><?= htmlspecialchars($fila['Serie'] ?? '') ?></td>
                        <td style="text-align:center;"><?= !empty($fila['Fecha_Ultimo_2000']) ? date( 'd/m/Y', strtotime($fila['Fecha_Ultimo_2000'])) : 'Sin registro'?></td>
                        <td style="text-align:center;" class="<?= $estado2000['clase'] ?>"><?= $estado2000['estado'] ?></td>
                        <td class="text-center">
                            <div class="barra-dias">
                                <div class="barra-dias-fondo">
                                    <?php $porcentajeDias2000 = $dias2000 !== null ? min(100, ($dias2000 / 30) * 100) : 0;?>
                                    <div class="barra-dias-progreso <?= $estado2000['clase'] ?>" style="width: <?= $porcentajeDias2000 ?>%;"></div>
                                    <span class="barra-dias-texto"><?= $dias2000 !== null ? $dias2000 . ' días' : '-'?></span>
                                </div>
                            </div>
                        </td>
                        <td style="text-align:center;"><?= $horometroUltimo2000 !== null ? htmlspecialchars($horometroUltimo2000) : 'Sin registro' ?></td>
                        <td style="text-align:center;"><?= htmlspecialchars($horometroActual) ?></td>
                        <td style="text-align:center;"><?= number_format($estado2000['diferencia'], 0) ?></td>
                        <td style="text-align:center;"><?= htmlspecialchars($fila['Observaciones'] ?? '') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <?php
                    $porcentajeVencido2000 = $totalMantenimientos2000 > 0 ? round(($totalVencidos2000 / $totalMantenimientos2000) * 100, 2): 0;
                    $porcentajePendiente2000 = $totalMantenimientos2000 > 0 ? round(($totalPendientes2000 / $totalMantenimientos2000) * 100, 2) : 0;
                    $porcentajeVigente2000 = $totalMantenimientos2000 > 0 ? round(($totalVigentes2000 / $totalMantenimientos2000) * 100, 2): 0;
                ?>
                <tr>
                    <th style="text-align:center;" colspan="7">% MANTENIMIENTO VENCIDO</th>
                    <th style="text-align:center;" colspan="5"><?= number_format($porcentajeVencido2000,2 ) ?>%
                        <br>
                        <small>(<?= $totalVencidos2000 ?> equipos)</small>
                    </th>
                </tr>
                <tr>
                    <th style="text-align:center;" colspan="7">% MANTENIMIENTO PENDIENTE</th>
                    <th style="text-align:center;" colspan="5"><?= number_format($porcentajePendiente2000, 2) ?>%
                        <br>
                        <small>(<?= $totalPendientes2000 ?> equipos)</small>
                    </th>
                </tr>
                <tr>
                    <th style="text-align:center;" colspan="7">% MANTENIMIENTO VIGENTE</th>
                    <th style="text-align:center;" colspan="5"><?= number_format($porcentajeVigente2000, 2) ?>%
                        <br>
                        <small>(<?= $totalVigentes2000 ?> equipos)</small>
                    </th>
                </tr>
            </tfoot>
        </table>
    <?php endif; ?>

</body>

</html>