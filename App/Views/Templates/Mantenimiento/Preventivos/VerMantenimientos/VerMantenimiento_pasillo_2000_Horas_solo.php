<?php
include_once "App/Controllers/MantenimientosController.php";
$MantenimientosController = new MantenimientosController();
$Tipo = "Preventivo";
$DataMantenimiento = $MantenimientosController->VerMantenimiento($_GET['ID']);
$DataMecanicos = $MantenimientosController->VerMecanicos($_GET['ID']);
$DataDetalleM = $MantenimientosController->VerDetalleM($_GET['ID']);
$observaciones = json_decode($DataDetalleM['Observaciones'], true);
$novedades = $MantenimientosController->ObtenerNovedadesMantenimiento($_GET['ID'], $Tipo);
$Insumos = $MantenimientosController->ObtenerInsumosMantenimiento($_GET['ID'], $Tipo);
$DataImagenesM = $MantenimientosController->VerImagenesM($_GET['ID']);
$imagenesPorCategoria = [];
foreach ($DataImagenesM as $img) {
    $categoria = strtoupper(trim($img['Categoria'] ?? 'SIN CATEGORIA'));
    $imagenesPorCategoria[$categoria][] = $img;
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
                <th rowspan="3" class="Titulo" style="font-size: 14px;" >REPORTE DE MANTENIMIENTO PREVENTIVO ELECTRICA PASILLO ANGOSTO 2000 HORAS</th>
                <th>CODIGO:</th>
                <td>F-211-3-3</td>
            </tr>
            <tr>
                <th>FECHA:</th>
                <td>13-04-2026</td>
            </tr>
            <tr>
                <th>VERSIÓN:</th>
                <td>4</td>
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
                <td><?= date('d/m/Y', strtotime($DataMantenimiento['Fecha_Realizado'])) ?></td>
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
                <td colspan="3"><?= $NombreOperario ?></td>
                <th>Horometro:</th>
                <td><?= $DataMantenimiento['HorometroM'] ?></td>
                <th>Hora de Finalización:</th>
                <td><?= $DataMantenimiento['Hora_Finalizacion'] ?></td>
            </tr>          
        </thead>
    </table>

    <!-- Tabla de detalles -->
    <table border="1">
        <thead style="background-color: #e7e5e5ff;">
            <tr>
                <th colspan="2" style="text-align: center;">ASPECTOS DE EVALUACIÓN</th>
                <th style="text-align: center;">CONDICIÓN</th>
                <th colspan="2" style="text-align: center;">ASPECTOS DE EVALUACIÓN</th>
                <th style="text-align: center;">CONDICIÓN</th>
                <th colspan="2" style="text-align: center;">ASPECTOS DE EVALUACIÓN</th>
                <th style="text-align: center;">CONDICIÓN</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="3" style="background-color: #e6e6e6; font-weight: bold; text-align:center;">BATERIA</td>
                <td colspan="3" style="background-color: #e6e6e6; font-weight: bold; text-align:center;">SUSPENSIÓN Y CASTER</td>
                <td colspan="3" style="background-color: #e6e6e6; font-weight: bold; text-align:center;">RUEDAS</td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold;">No. de batería</td>
                <td style="text-align:center;"><?= $DataDetalleM['N_Bateria'] ?></td>
                <td colspan="2" style="font-weight: bold;">Mantenimiento suspension</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_52'] ?></td>
                <td colspan="2" style="font-weight: bold;">Desgaste ruedas de tracción</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_101'] ?></td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold;">Estado de cables</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_1'] ?></td>
                <td colspan="2" style="font-weight: bold;">Mantenimiento de caster</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_53'] ?></td>
                <td colspan="2" style="font-weight: bold;">Desgaste ruedas de caster</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_102'] ?></td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold;">Nivel de electrolito</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_2'] ?></td>
                <td colspan="2" style="font-weight: bold;">Pasador</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_54'] ?></td>
                <td colspan="2" style="font-weight: bold;">Desgaste ruedas de carga</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_103'] ?></td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold;">Conector Anderson</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_3'] ?></td>
                <td colspan="2" style="font-weight: bold;">Rodamientos</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_55'] ?></td>
                <td colspan="2" style="font-weight: bold;">Estado de rines de tracción</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_104'] ?></td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold;">Compartimiento de la batería</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_4'] ?></td>
                <td colspan="2" style="font-weight: bold;">Tornillería</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_56'] ?></td>
                <td colspan="2" style="font-weight: bold;">Estado de rines de caster</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_105'] ?></td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold;">Estado de los puentes</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_5'] ?></td>
                <td colspan="2" style="font-weight: bold;">Suspensión</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_57'] ?></td>
                <td colspan="2" style="font-weight: bold;">Estado de rines de carga</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_106'] ?></td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold;">Estado de batería</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_6'] ?></td>
                <td colspan="2" style="font-weight: bold;">Pines</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_58'] ?></td>
                <td colspan="2" style="font-weight: bold;">Balancines</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_107'] ?></td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold;">Medicion indivual celdas</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_7'] ?></td>
                <td colspan="2" style="font-weight: bold;">Amortiguador</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_59'] ?></td>
                <td colspan="2" style="font-weight: bold;">Tornillos</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_108'] ?></td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold;">Mantenimiento de bateria</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_8'] ?></td>
                <td colspan="3" style="background-color: #e6e6e6; font-weight: bold; text-align:center;">SISTEMA HIDRAULICO</td>
                <td colspan="2" style="font-weight: bold;">Bujes</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_109'] ?></td>
                
            </tr>
            <tr>
                <td colspan="3" style="background-color: #e6e6e6; font-weight: bold; text-align:center;">SISTEMA ELÉCTRICO</td>
                <td colspan="2" style="font-weight: bold;">Cambio aceite hidraulico</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_60'] ?></td>
                <td colspan="2" style="font-weight: bold;">Mantenimiento rueda de carga</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_110'] ?></td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold;">Controlador tracción</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_9'] ?></td>
                <td colspan="2" style="font-weight: bold;">Mantenimiento motor de sistema hidraulico</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_61'] ?></td>
                <td colspan="3" style="background-color: #e6e6e6; font-weight: bold; text-align:center;">HORQUILLAS</td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold;">Controlador elevación</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_10'] ?></td>
                <td colspan="2" style="font-weight: bold;">Escobillas</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_62'] ?></td>
                <td colspan="2" style="font-weight: bold;">Seguros</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_96'] ?></td>
                
            </tr> 
            <tr>
                <td colspan="2" style="font-weight: bold;">Tarjeta tracción</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_11'] ?></td>
                <td colspan="2" style="font-weight: bold;">Bomba sistema hidraulico</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_63'] ?></td>
                <td colspan="2" style="font-weight: bold;">Mordaza superior</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_97'] ?></td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold;">Tarjeta de direccion</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_12'] ?></td>
                <td colspan="2" style="font-weight: bold;">Cambio filtro de retorno</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_64'] ?></td>
                <td colspan="2" style="font-weight: bold;">Mordaza inferior</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_98'] ?></td>
            </tr> 
            <tr>
                <td colspan="2" style="font-weight: bold;">Tarjeta elevación</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_13'] ?></td>
                <td colspan="2" style="font-weight: bold;">Cuerpo de válvulas</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_65'] ?></td>
                <td colspan="2" style="font-weight: bold;">Clase de horquillas</td>
                <td style="text-align:center;"><?= $DataDetalleM['ClaseH'] ?></td>
            </tr> 
            <tr>
                <td colspan="2" style="font-weight: bold;">ECU</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_14'] ?></td>
                <td colspan="2" style="font-weight: bold;">Electroválvulas</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_66'] ?></td>
                <td colspan="2" style="font-weight: bold;">Longitud (m)</td>
                <td style="text-align:center;"><?= $DataDetalleM['LongitudH'] ?></td>
            </tr> 
            <tr>
                <td colspan="2" style="font-weight: bold;">MIB</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_15'] ?></td>
                <td colspan="2" style="font-weight: bold;">Mangueras</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_67'] ?></td>
                <td colspan="2" style="font-weight: bold;">Estado de horquillas (Inspeccion visual ver F-208 como referencia)</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_99'] ?></td>
            </tr> 
            <tr>
                <td colspan="2" style="font-weight: bold;">Displey</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_16'] ?></td>
                <td colspan="2" style="font-weight: bold;">Micros de funciones hidráulicas</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_68'] ?></td>
                <td colspan="2" style="font-weight: bold;">Prueba de tintas</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_100'] ?></td>
            </tr> 
            <tr>
                <td colspan="2" style="font-weight: bold;">Joystick</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_17'] ?></td>
                <td colspan="3" style="background-color: #e6e6e6; font-weight: bold; text-align:center;">MASTIL</td>
                <td colspan="3" style="background-color: #e6e6e6; font-weight: bold; text-align:center;">LUBRICACIÓN</td>
            </tr> 
            <tr>
                <td colspan="2" style="font-weight: bold;">Cables de potencia</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_18'] ?></td>
                <td colspan="2" style="font-weight: bold;">Ajuste mastil</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_69'] ?></td>
                <td colspan="2" style="font-weight: bold;">Engrase de caster</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_119'] ?></td>
            </tr> 
            <tr>
                <td colspan="2" style="font-weight: bold;">Desconector de emergencia</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_19'] ?></td>
                <td colspan="2" style="font-weight: bold;">Estado secciones</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_70'] ?></td>
                <td colspan="2" style="font-weight: bold;">Engrase de tande</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_120'] ?></td>
            </tr> 
            <tr>
                <td colspan="2" style="font-weight: bold;">Cables de control</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_20'] ?></td>
                <td colspan="2" style="font-weight: bold;">Bujes</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_71'] ?></td>
                <td colspan="2" style="font-weight: bold;">Engrase de pantógrafo</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_121'] ?></td>
            </tr> 
            <tr>
                <td colspan="2" style="font-weight: bold;">Conectores</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_21'] ?></td>
                <td colspan="2" style="font-weight: bold;">Rodamientos</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_72'] ?></td>
                <td colspan="2" style="font-weight: bold;">Lubricación cadenas y secciones mastil</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_122'] ?></td>
            </tr> 
            <tr>
                <td colspan="2" style="font-weight: bold;">Fusibles</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_22'] ?></td>
                <td colspan="2" style="font-weight: bold;">Cadenas</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_73'] ?></td>
                <td colspan="3" style="background-color: #e6e6e6; font-weight: bold; text-align:center;">CARGADOR</td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold;">Mantenimiento contactor de línea</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_23'] ?></td>
                <td colspan="2" style="font-weight: bold;">Poleas</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_74'] ?></td>
                <td colspan="2" style="font-weight: bold;">Inspección visual</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_123'] ?></td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold;">Mantenimiento contactor de funciones auxiliares</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_24'] ?></td>
                <td colspan="2" style="font-weight: bold;">Pasadores cadenas</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_75'] ?></td>
                <td colspan="2" style="font-weight: bold;">Cables de potencia</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_124'] ?></td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold;">Mantenimiento contactor elevación</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_25'] ?></td>
                <td colspan="2" style="font-weight: bold;">Mangueras freelift</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_76'] ?></td>
                <td colspan="2" style="font-weight: bold;">Conector anderson</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_125'] ?></td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold;">Micros</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_26'] ?></td>
                <td colspan="2" style="font-weight: bold;">Mangueras side shift</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_77'] ?></td>
                <td colspan="2" style="font-weight: bold;">Voltaje</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_126'] ?></td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold;">Switch de ignición</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_27'] ?></td>
                <td colspan="2" style="font-weight: bold;">Mangueras pantografo</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_78'] ?></td>
                <td colspan="2" style="font-weight: bold;">Amperaje</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_127'] ?></td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold;">Cable de autosostenido</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_28'] ?></td>
                <td colspan="2" style="font-weight: bold;">Tuberías</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_79'] ?></td>
                <td colspan="3" style="background-color: #e6e6e6; font-weight: bold; text-align:center;">ESTADO DE PINTURA</td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold;">Ventiladores</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_29'] ?></td>
                <td colspan="2" style="font-weight: bold;">Racores</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_80'] ?></td>
                <td colspan="2" style="font-weight: bold;">Estado general de pintura del chasis</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_128'] ?></td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold;">Conversor de luces (VMC)</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_30'] ?></td>
                <td colspan="2" style="font-weight: bold;">Cilindro de free lift</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_81'] ?></td>
                <td colspan="2" style="font-weight: bold;">Pintura en mastil y secciones móviles</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_129'] ?></td>
            </tr>
            <tr>
                <td colspan="3" style="background-color: #e6e6e6; font-weight: bold; text-align:center;">SISTEMA DE TRACCIÓN</td>
                <td colspan="2" style="font-weight: bold;">Cilindros laterales</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_82'] ?></td>
                <td colspan="2" style="font-weight: bold;">Pintura en protecciones laterales y cubiertas</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_130'] ?></td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold;">Mantenimiento motor de tracción</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_31'] ?></td>
                <td colspan="2" style="font-weight: bold;">Cilindro de side shift</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_83'] ?></td>
                <td colspan="3" style="background-color: #e6e6e6; font-weight: bold; text-align:center;">REVISION DE EQUIPO</td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold;">Escobillas</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_32'] ?></td>
                <td colspan="2" style="font-weight: bold;">Cilindros de pantógrafo</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_84'] ?></td>
                <td colspan="2" style="font-weight: bold;">Limpieza de equipo</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_131'] ?></td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold;">Cremallera</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_33'] ?></td>
                <td colspan="2" style="font-weight: bold;">Bloque de válvulas funciones auxiliares</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_85'] ?></td>
                <td colspan="2" style="font-weight: bold;">Horómetro</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_132'] ?></td>
            </tr>
            <div style="page-break-before: always;"></div>
            <tr>
                <td colspan="3" style="background-color: #e6e6e6; font-weight: bold; text-align:center;">SISTEMA DE TRACCIÓN</td>
                <td colspan="3" style="background-color: #e6e6e6; font-weight: bold; text-align:center;">PANTOGRAFO</td>
                <td colspan="3" style="background-color: #e6e6e6; font-weight: bold; text-align:center;">REVISION DE EQUIPO</td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold;">Rodamiento de tornamesa</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_34'] ?></td>
                <td colspan="2" style="font-weight: bold;">Ajuste de pantógrafo</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_86'] ?></td>
                <td colspan="2" style="font-weight: bold;">Etiquetas de seguridad</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_133'] ?></td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold;">Transmisión</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_35'] ?></td>
                <td colspan="2" style="font-weight: bold;">Rodamientos</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_87'] ?></td>
                <td colspan="2" style="font-weight: bold;">Limpieza área de trabajo</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_134'] ?></td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold;">Nivel de valvulina</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_36'] ?></td>
                <td colspan="2" style="font-weight: bold;">Cadenas</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_88'] ?></td>
                <td colspan="2" style="font-weight: bold;">Manual de operaciones</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_135'] ?></td>
            </tr>  
            <tr>
                <td colspan="2" style="font-weight: bold;">Tornilleria</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_37'] ?></td>
                <td colspan="2" style="font-weight: bold;">Pasadores</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_89'] ?></td>
                <td colspan="2" style="font-weight: bold;">Tapas</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_136'] ?></td>
            </tr>
            <tr>
                <td colspan="3" style="background-color: #e6e6e6; font-weight: bold; text-align:center;">SISTEMA DE FRENOS</td>
                <td colspan="2" style="font-weight: bold;">Parrilla (espejo)</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_90'] ?></td>
                <td colspan="2" style="font-weight: bold;">Silla</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_137'] ?></td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold;">Cambio liquido de frenos</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_38'] ?></td>
                <td colspan="2" style="font-weight: bold;">Mordazas</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_91'] ?></td>
                <td colspan="2" style="font-weight: bold;">Cinturon de seguridad</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_138'] ?></td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold;">Bomba de freno principal</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_39'] ?></td>
                <td colspan="2" style="font-weight: bold;">Deslizadores</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_92'] ?></td>
                <td colspan="2" style="font-weight: bold;">Extintor</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_139'] ?></td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold;">Bomba de freno auxiliar</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_40'] ?></td>
                <td colspan="2" style="font-weight: bold;">Bloque de tilt down</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_93'] ?></td>
                <td colspan="2"></td>
                <td ></td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold;">Mantenimiento sistema de frenos</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_41'] ?></td>
                <td colspan="2" style="font-weight: bold;">Mangueras</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_94'] ?></td>
                <td colspan="2"></td>
                <td ></td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold;">Estado de bandas</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_42'] ?></td>
                <td colspan="2" style="font-weight: bold;">Topes de reach (caucho)</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_95'] ?></td>
                <td colspan="2"></td>
                <td ></td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold;">Electrofreno</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_43'] ?></td>
                <td colspan="3" style="background-color: #e6e6e6; font-weight: bold; text-align:center;">CHASIS</td>
                <td colspan="2"></td>
                <td ></td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold;">Estado pastillas</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_44'] ?></td>
                <td colspan="2" style="font-weight: bold;">Ajustes de conjunto</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_111'] ?></td>
                <td colspan="2"></td>
                <td ></td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold;">Eficiencia de frenado</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_45'] ?></td>
                <td colspan="2" style="font-weight: bold;">Chequear soportes</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_112'] ?></td>
                <td colspan="2"></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="3" style="background-color: #e6e6e6; font-weight: bold; text-align:center;">SISTEMA DE FUNCIONES AUXILIARES</td>
                <td colspan="2" style="font-weight: bold;">Tornilleria</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_113'] ?></td>
                <td colspan="2"></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold;">Mantenimiento motor de funciones auxiliares</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_46'] ?></td>
                <td colspan="3" style="background-color: #e6e6e6; font-weight: bold; text-align:center;">LUCES Y ALARMAS</td>
                <td colspan="2"></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold;">Escobillas</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_47'] ?></td>
                <td colspan="2" style="font-weight: bold;">Luces frontales</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_114'] ?></td>
                <td colspan="2"></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold;">Bomba de funciones auxiliares</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_48'] ?></td>
                <td colspan="2" style="font-weight: bold;">Luz estroboscopia</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_115'] ?></td>
                <td colspan="2"></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold;">Generador de torque</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_49'] ?></td>
                <td colspan="2" style="font-weight: bold;">Blue light</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_116'] ?></td>
                <td colspan="2"></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold;">Orbitrol</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_50'] ?></td>
                <td colspan="2" style="font-weight: bold;">Pito bocina</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_117'] ?></td>
                <td colspan="2"></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold;">Mangueras</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_51'] ?></td>
                <td colspan="2" style="font-weight: bold;">Alarma reversa</td>
                <td style="text-align:center;"><?= $DataDetalleM['Criterio_118'] ?></td>
                <td colspan="2"></td>
                <td></td>
            </tr>
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
            // Obtener la cantidad mayor entre novedades y observaciones
            $totalFilas = max(count($novedades), count($observaciones));

            for ($i = 0; $i < $totalFilas; $i++):
            ?>
                <tr>
                    <!-- NOVEDAD -->
                    <td style="padding: 5px; vertical-align: top;">
                        <?php if (isset($novedades[$i])): ?>
                            <?= htmlspecialchars($novedades[$i]['Descripcion']) ?>
                        <?php endif; ?>
                    </td>

                    <!-- OBSERVACIÓN -->
                    <td style="padding: 5px; vertical-align: top;">
                        <?php if (isset($observaciones[$i])): ?>
                            <?= htmlspecialchars($observaciones[$i]['observacion']) ?>
                        <?php endif; ?>
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
                    <td colspan="4" style="text-align:center;">No se registraron insumos.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Tabla de firmas mecanicos -->
    <table border="1">
        <?php 
            $totalMecanicos = count($DataMecanicos);
            $anchoPorFirma = 100 / max($totalMecanicos, 1); 
        ?>
        <thead>
            <tr>
                <th colspan="<?= $totalMecanicos ?>" style="font-size: 14px;">Técnico(s) </th>
            </tr>
        </thead>
        <tbody>
            <tr height="100px">
                <?php foreach ($DataMecanicos as $mecanico) : ?>
                    <td style="text-align: center; width: <?= $anchoPorFirma ?>%;">
                        <img src="<?= $mecanico['Firma_Mecanico'] ?>" style="max-width: 100%;">
                    </td>
                <?php endforeach; ?>
            </tr>
            <tr>
                <?php foreach ($DataMecanicos as $mecanico) : ?>
                    <td style="text-align: center; font-weight: bold;">
                        <?= htmlspecialchars($mecanico['NombreMecanico']) ?>
                    </td>
                <?php endforeach; ?>
            </tr>
            <tr>
                <?php foreach ($DataMecanicos as $mecanico) : ?>
                    <th>Firma</th>
                <?php endforeach; ?>
            </tr>
        </tbody>
    </table>
    
    <!-- Tabla de firmas supervisor y operario -->
    <table border="1">
        <thead>
            <tr>
                <th style="font-size: 14px;">Dir. Técnico y Logístico | Jefe de Taller</th>
                <th style="font-size: 14px;">Operario o Supervisor (quien recibe el equipo)</th>
            </tr>
        </thead>
        <tbody>
            <tr height="100px">
                <td width="50%" style="text-align: center;">
                    <img src="<?= $DataMantenimiento['Firma_Supervisor'] ?>" style="max-width: 100%;">
                </td>
                <td width="50%" style="text-align: center;">
                    <img src="<?= $DataMantenimiento['Firma_Operario'] ?>" style="max-width: 100%;">
                </td>
            </tr>
            <tr>
                <th style="text-align: center;"><?= $DataMantenimiento['NombreSupervisor'] ?></th>
                <th style="text-align: center;"><?= $NombreRecibe?></th>
            </tr>
            <tr>
                <th>Firma</th>
                <th>Firma</th>
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