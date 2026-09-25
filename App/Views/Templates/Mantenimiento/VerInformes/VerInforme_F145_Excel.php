<?php
    include_once "App/Controllers/MantenimientosController.php";
    $MantenimientosController = new MantenimientosController();

    $tipoInforme = $_GET['tipoInforme'] ?? '';
    $centro = $_GET['centro'] ?? '';
    $fechaDesde = $_GET['fechaDesde'] ?? '';
    $fechaHasta = $_GET['fechaHasta'] ?? '';
    $montacargas = $_GET['montacargas'] ?? '';
    $tipoMantenimiento = $_GET['tipoMantenimiento'] ?? '';
    $nombreGenera = $_GET['NombreGenera'] ?? '';

    $DataInforme = $MantenimientosController->VerInforme($tipoInforme, $centro, $fechaDesde, $fechaHasta, $montacargas, $tipoMantenimiento);
    $FechaActualizacion = date("d/m/Y");

    /*URL BASE*/
    if ($_SERVER['HTTP_HOST'] == 'localhost') {
        $baseUrl = 'http://localhost/OUTKARGO/';
    } else {
        $baseUrl = 'https://outkargo.com.co/';
    }

    /*FUNCIONES*/

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
        if ($horometroUltimo === null || $horometroUltimo === '') {
            $horometroBase = 0;
        } else {
            $horometroBase = (float)$horometroUltimo;
        }
        $diferencia = $actual - $horometroBase;
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

        $porcentaje = $umbral > 0 ? min(100, ($diferencia / $umbral) * 100) : 0;
        return [
            'estado' => $estado,
            'clase' => $clase,
            'diferencia' => $diferencia,
            'porcentaje' => $porcentaje,
            'tolerancia' => $tolerancia
        ];
    }

    /*EXCEL*/
    header("Content-Type: application/vnd.ms-excel; charset=utf-8");
    header("Content-Disposition: attachment; filename=F-145_MATRIZ_SEGUIMIENTO_MANTENIMIENTOS.xls");
    header("Pragma: no-cache");
    header("Expires: 0");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>F-145</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        th, td {
            border: 1px solid #000000;
            padding: 5px;
            font-size: 10px;
            text-align: center;
            vertical-align: middle;
        }
        .titulo {
            background: #003366;
            color: #ffffff;
            font-size: 14px;
            font-weight: bold;
        }
        .encabezado {
            background: #000020;
            color: #ffffff;
            font-weight: bold;
        }
        .vencido {
            background: #ff293b;
            color: #ffffff;
            font-weight: bold;
        }
        .al-dia {
            background: #d4edda;
            color: #155724;
            font-weight: bold;
        }
        .pendiente {
            background: #ffae62;
            color: #ffffff;
            font-weight: bold;
        }
        .resumen {
            background: #eeeeee;
            font-weight: bold;
        }
    </style>
</head>

<body>

<!-- ENCABEZADO F-145 -->
<table>
    <tr>
        <th rowspan="3" colspan="2">
            <img src="<?= $baseUrl ?>App/Views/Img/Outkargo.png" width="210">
        </th>
        <th rowspan="3" colspan="8" style="font-size:14px;">
            MATRIZ DE SEGUIMIENTO DE MANTENIMIENTOS PREVENTIVOS
        </th>
        <th>CODIGO:</th>
        <td>F-145</td>
    </tr>
    <tr>
        <th>FECHA:</th>
        <td>26/11/2026</td>
    </tr>
    <tr>
        <th>VERSIÓN:</th>
        <td>3</td>
    </tr>
</table>
<table>
    <tr>
        <th colspan="2">Fecha de actualización:</th>
        <td><?= $FechaActualizacion ?></td>
        <th>Responsable del reporte:</th>
        <td colspan="8"><?= htmlspecialchars($nombreGenera) ?></td>
    </tr>
</table>

<?php
    /* FUNCIÓN PARA CALCULAR RESUMEN*/
    function mostrarResumenExcel($total, $vencidos, $pendientes, $vigentes){
        $porcentajeVencido = $total > 0 ? round(($vencidos / $total) * 100, 2) : 0;
        $porcentajePendiente = $total > 0 ? round(($pendientes / $total) * 100, 2) : 0;
        $porcentajeVigente = $total > 0 ? round(($vigentes / $total) * 100, 2) : 0;
?>
    <tr>
        <th colspan="7" class="resumen">% MANTENIMIENTO VENCIDO</th>
        <th colspan="5" class="vencido"><?= number_format($porcentajeVencido, 2) ?>%
            <br>
            <small>(<?= $vencidos ?> equipos)</small>
        </th>
    </tr>
    <tr>
        <th colspan="7" class="resumen">% MANTENIMIENTO PENDIENTE</th>
        <th colspan="5" class="pendiente"><?= number_format($porcentajePendiente, 2) ?>%
            <br>
            <small>(<?= $pendientes ?> equipos)</small>
        </th>
    </tr>
    <tr>
        <th colspan="7" class="resumen">% MANTENIMIENTO VIGENTE</th>
        <th colspan="5" class="al-dia"><?= number_format($porcentajeVigente, 2) ?>%
            <br>
            <small>(<?= $vigentes ?> equipos)</small>
        </th>
    </tr>

<?php
    }
?>
<!-- 250 HORAS -->

<?php if ($tipoMantenimiento === '' || $tipoMantenimiento === '250_Horas'): ?>
    <?php
        $total250 = count($DataInforme);
        $vencidos250 = 0;
        $pendientes250 = 0;
        $vigentes250 = 0;
    ?>
    <table>
        <thead>
            <tr>
                <th colspan="12" class="titulo">MANTENIMIENTO 250 HORAS (MENSUAL)</th>
            </tr>
            <tr class="encabezado">
                <th>Centro de trabajo</th>
                <th>Equipo</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Serie</th>
                <th>Fecha Último Mant. 250h</th>
                <th>Estado</th>
                <th>Días transcurridos</th>
                <th>Horómetro último mantenimiento</th>
                <th>Horómetro actual</th>
                <th>Diferencia horómetro</th>
                <th>Observaciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($DataInforme as $fila): ?>

                <?php

                $estado250 = estadoMantenimiento250(
                    $fila['Fecha_Ultimo_250'] ?? null
                );

                if ($estado250['estado'] === 'VENCIDO') {
                    $vencidos250++;
                }

                if ($estado250['estado'] === 'PENDIENTE') {
                    $pendientes250++;
                }

                if ($estado250['estado'] === 'VIGENTE') {
                    $vigentes250++;
                }

                $horometroUltimo = $fila['Horometro_Ultimo_250'] ?? 0;

                $horometroActual = $fila['Horometro'] ?? 0;

                $diferencia = (
                    is_numeric($horometroUltimo) &&
                    is_numeric($horometroActual)
                )
                    ? $horometroActual - $horometroUltimo
                    : '';

                $dias = $estado250['dias'];

                ?>

                <tr>

                    <td>
                        <?= htmlspecialchars($fila['CentroTrabajo'] ?? '') ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($fila['Equipo'] ?? '') ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($fila['Marca'] ?? '') ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($fila['Modelo'] ?? '') ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($fila['Serie'] ?? '') ?>
                    </td>

                    <td>

                        <?= !empty($fila['Fecha_Ultimo_250'])
                            ? date(
                                'd/m/Y',
                                strtotime($fila['Fecha_Ultimo_250'])
                            )
                            : 'Sin registro'
                        ?>

                    </td>

                    <td class="<?= $estado250['clase'] ?>">

                        <?= $estado250['estado'] ?>

                    </td>

                    <td>

                        <?= $dias !== null
                            ? $dias . ' días'
                            : '-'
                        ?>

                    </td>

                    <td>

                        <?= htmlspecialchars($horometroUltimo) ?>

                    </td>

                    <td>

                        <?= htmlspecialchars($horometroActual) ?>

                    </td>

                    <td>

                        <?= htmlspecialchars($diferencia) ?>

                    </td>

                    <td>

                        <?= htmlspecialchars(
                            $fila['Observaciones'] ?? ''
                        ) ?>

                    </td>

                </tr>

            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <?php
                mostrarResumenExcel($total250, $vencidos250, $pendientes250,$vigentes250);
            ?>
        </tfoot>
    </table>
<?php endif; ?>


<!--1000 HORAS-->
<?php if ($tipoMantenimiento === '' || $tipoMantenimiento === '1000_Horas'): ?>
    <?php
        $total1000 = count($DataInforme);
        $vencidos1000 = 0;
        $pendientes1000 = 0;
        $vigentes1000 = 0;
    ?>
    <table>
        <thead>
            <tr>
                <th colspan="12" class="titulo"> MANTENIMIENTO 1000 HORAS</th>
            </tr>
            <tr class="encabezado">
                <th>Centro de trabajo</th>
                <th>Equipo</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Serie</th>
                <th>Fecha Último Mant. 1000h</th>
                <th>Estado</th>
                <th>Días transcurridos</th>
                <th>Horómetro último mantenimiento</th>
                <th>Horómetro actual</th>
                <th>Diferencia horómetro</th>
                <th>Observaciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($DataInforme as $fila): ?>
                <?php
                    $horometroActual = is_numeric($fila['Horometro'] ?? null) ? (float)$fila['Horometro'] : 0;
                    $horometroUltimo1000 =( isset($fila['Horometro_Ultimo_1000']) && $fila['Horometro_Ultimo_1000'] !== '') ? (float)$fila['Horometro_Ultimo_1000'] : null;
                    $estado1000 = estadoMantenimientoPorHorometro($horometroActual, $horometroUltimo1000, 1000);
                    $fechaUltimo1000 = $fila['Fecha_Ultimo_1000'] ?? null;
                    if (!empty($fechaUltimo1000)) {
                        $dias1000 = (int) floor((strtotime(date('Y-m-d')) - strtotime($fechaUltimo1000)) / 86400);
                    } else {
                        $dias1000 = null;
                    }
                    if ($estado1000['estado'] === 'VENCIDO') {
                        $vencidos1000++;
                    }
                    if ($estado1000['estado'] === 'PENDIENTE') {
                        $pendientes1000++;
                    }
                    if ($estado1000['estado'] === 'VIGENTE') {
                        $vigentes1000++;
                    }
                ?>
                <tr>
                    <td><?= htmlspecialchars($fila['CentroTrabajo'] ?? '') ?></td>
                    <td><?= htmlspecialchars($fila['Equipo'] ?? '') ?></td>
                    <td><?= htmlspecialchars($fila['Marca'] ?? '') ?></td>
                    <td><?= htmlspecialchars($fila['Modelo'] ?? '') ?></td>
                    <td><?= htmlspecialchars($fila['Serie'] ?? '') ?></td>
                    <td><?= !empty($fechaUltimo1000) ? date('d/m/Y', strtotime($fechaUltimo1000)) : 'Sin registro' ?></td>
                    <td class="<?= $estado1000['clase'] ?>"><?= $estado1000['estado'] ?></td>
                    <td><?= $dias1000 !== null ? $dias1000 . ' días' : '-' ?></td>
                    <td><?= $horometroUltimo1000 !== null ? htmlspecialchars($horometroUltimo1000) : 'Sin registro' ?></td>
                    <td><?= htmlspecialchars($horometroActual) ?></td>
                    <td><?= number_format($estado1000['diferencia'], 0 ) ?></td>
                    <td><?= htmlspecialchars($fila['Observaciones'] ?? '') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <?php
                mostrarResumenExcel($total1000, $vencidos1000, $pendientes1000, $vigentes1000);
            ?>
        </tfoot>
    </table>
<?php endif; ?>


<!--2000 HORAS-->
<?php if ($tipoMantenimiento === '' || $tipoMantenimiento === '2000_Horas'): ?>
    <?php
        $total2000 = count($DataInforme);
        $vencidos2000 = 0;
        $pendientes2000 = 0;
        $vigentes2000 = 0;
    ?>
    <table>
        <thead>
            <tr><th colspan="12" class="titulo">MANTENIMIENTO 2000 HORAS</th></tr>
            <tr class="encabezado">
                <th>Centro de trabajo</th>
                <th>Equipo</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Serie</th>
                <th>Fecha Último Mant. 2000h</th>
                <th>Estado</th>
                <th>Días transcurridos</th>
                <th>Horómetro último mantenimiento</th>
                <th>Horómetro actual</th>
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
                    $fechaUltimo2000 = $fila['Fecha_Ultimo_2000'] ?? null;
                    if (!empty($fechaUltimo2000)) {
                        $dias2000 = (int) floor((strtotime(date('Y-m-d')) - strtotime($fechaUltimo2000)) / 86400);
                    } else {
                        $dias2000 = null;
                    }
                    if ($estado2000['estado'] === 'VENCIDO') {
                        $vencidos2000++;
                    }
                    if ($estado2000['estado'] === 'PENDIENTE') {
                        $pendientes2000++;
                    }
                    if ($estado2000['estado'] === 'VIGENTE') {
                        $vigentes2000++;
                    }
                ?>
                <tr>
                    <td><?= htmlspecialchars($fila['CentroTrabajo'] ?? '') ?></td>
                    <td><?= htmlspecialchars($fila['Equipo'] ?? '') ?></td>
                    <td><?= htmlspecialchars($fila['Marca'] ?? '') ?></td>
                    <td><?= htmlspecialchars($fila['Modelo'] ?? '') ?></td>
                    <td><?= htmlspecialchars($fila['Serie'] ?? '') ?></td>
                    <td><?= !empty($fechaUltimo2000) ? date('d/m/Y', strtotime($fechaUltimo2000)) : 'Sin registro' ?></td>
                    <td class="<?= $estado2000['clase'] ?>"><?= $estado2000['estado'] ?></td>
                    <td><?= $dias2000 !== null ? $dias2000 . ' días' : '-'?></td>
                    <td><?= $horometroUltimo2000 !== null ? htmlspecialchars($horometroUltimo2000) : 'Sin registro'?></td>
                    <td><?= htmlspecialchars($horometroActual) ?></td>
                    <td><?= number_format($estado2000['diferencia'], 0) ?></td>
                    <td><?= htmlspecialchars($fila['Observaciones'] ?? '') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <?php
                mostrarResumenExcel($total2000, $vencidos2000, $pendientes2000, $vigentes2000);
            ?>
        </tfoot>

    </table>
<?php endif; ?>

</body>

</html>