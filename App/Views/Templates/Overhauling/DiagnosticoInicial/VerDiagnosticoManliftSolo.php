<?php
include_once "App/Controllers/OverhaulingController.php";
$OverhaulingController = new OverhaulingController();
$DataOverhauling = $OverhaulingController->VerOverhauling($_GET['ID']);
$DataMecanicos = $OverhaulingController->VerMecanicos($_GET['ID']);
$DataDetalleD = $OverhaulingController->VerDetalleD($_GET['ID']);
$DataImagenesM = $OverhaulingController->DataImagenesM($_GET['ID']);

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
                <th rowspan="3" class="Titulo" style="font-size: 14px;">INFORME DIAGNOSTICO INICIAL DE MANLIFT</th>
                <th>CODIGO:</th>
                <td></td>
            </tr>
            <tr>
                <th>FECHA:</th>
                <td>19-12-2025</td>
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
                <td style="text-align: center; color: red;"> <?= $DataOverhauling['Numero'] ?></td>         
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
                <td colspan="3" style="background-color: #e6e6e6; font-weight: bold; text-align:center;">COMPONENTES ESTRUCTURALES</td>
                <td colspan="3" style="background-color: #e6e6e6; font-weight: bold; text-align:center;">SISTEMA DE FRENOS</td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold;">Estado de cables</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_1'] ?></td>
                <td colspan="2" style="font-weight: bold;">Estado del chasis-bastidor</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_39'] ?></td>
                <td colspan="2" style="font-weight: bold;">Eficiencia del mecanismo</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_76'] ?></td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold;">Nivel de electrolito</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_2'] ?></td>
                <td colspan="2" style="font-weight: bold;">Estructura extensible</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_40'] ?></td>
                <td colspan="2" style="font-weight: bold;">Estado desgaste del disco</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_77'] ?></td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold;">Conector Anderson</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_3'] ?></td>
                <td colspan="2" style="font-weight: bold;">Estado de la plataforma</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_41'] ?></td>
                <td colspan="2" style="font-weight: bold;">Nivel del aceite hidráulico de los frenos</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_78'] ?></td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold;">Compartimiento de la batería</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_4'] ?></td>
                <td colspan="2" style="font-weight: bold;">Estado del punto de anclaje</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_42'] ?></td>
                <td colspan="2" style="font-weight: bold;">Pedal de frenos</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_79'] ?></td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold;">Estado de batería</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_5'] ?></td>
                <td colspan="3" style="background-color: #e6e6e6; font-weight: bold; text-align:center;">AUSENCIA DE PIEZAS O COMPONENTES</td>
                <td colspan="2" style="font-weight: bold;">Bomba de frenado</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_80'] ?></td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold;">Estado de los puentes</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_6'] ?></td>
                <td colspan="2" style="font-weight: bold;">Pasadores</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_43'] ?></td>
                <td colspan="2" style="font-weight: bold;">Desgastes de pastillas de freno</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_81'] ?></td>
            </tr>
            <tr> 
                <td colspan="3" style="background-color: #e6e6e6; font-weight: bold; text-align:center;">CARGADOR</td>
                <td colspan="2" style="font-weight: bold;">Cojinetes</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_44'] ?></td>
               <td colspan="3" style="background-color: #e6e6e6; font-weight: bold; text-align:center;">CORREAS Y CADENAS</td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold;">Estado</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_7'] ?></td>
                <td colspan="2" style="font-weight: bold;">Ejes</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_45'] ?></td>
                <td colspan="2" style="font-weight: bold;">Chequear ajustes</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_82'] ?></td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold;">Voltaje promedio</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_8'] ?></td>
                <td colspan="2" style="font-weight: bold;">Corona de giro</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_46'] ?></td>
                <td colspan="2" style="font-weight: bold;">Ausencia de corrosión</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_83'] ?></td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold;">Cables de Potencia</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_9'] ?></td>
                <td colspan="2" style="font-weight: bold;">Motor de giro</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_47'] ?></td>
                <td colspan="2" style="font-weight: bold;">Ausencia de corte</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_84'] ?></td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold;">Conector anderson</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_10'] ?></td>
                <td colspan="2" style="font-weight: bold;">Rodillos</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_48'] ?></td>
                <td colspan="2" style="font-weight: bold;">Ausencia de deformaciones en eslabones</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_85'] ?></td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold;">Amperaje</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_11'] ?></td>
                <td colspan="2" style="font-weight: bold;">Pernos</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_50'] ?></td>
                <td colspan="2" style="font-weight: bold;">Ausencia de pasadores desencajados</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_86'] ?></td>
            </tr> 
            <tr>
                <td colspan="2" style="font-weight: bold;">Fusibles</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_12'] ?></td>
                <td colspan="2" style="font-weight: bold;">Tuercas</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_51'] ?></td>
                <td colspan="3" style="background-color: #e6e6e6; font-weight: bold; text-align:center;">LUBRICACIÓN</td>
            </tr>
            <tr>
                <td colspan="3" style="background-color: #e6e6e6; font-weight: bold; text-align:center;">SISTEMA ELÉCTRICO</td>
                <td colspan="2" style="font-weight: bold;">Remaches</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_52'] ?></td>
                <td colspan="2" style="font-weight: bold;">Engrasar - lubricar</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_62'] ?></td>
            </tr> 
            <tr>
                <td colspan="2" style="font-weight: bold;">Fusibles</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_13'] ?></td>
                <td colspan="3" style="background-color: #e6e6e6; font-weight: bold; text-align:center;">DIRECCIÓN</td>
                <td colspan="2" style="font-weight: bold;">Engranajes - cadenas - piñones</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_63'] ?></td>
            </tr> 
            <tr>
                <td colspan="2" style="font-weight: bold;">Conexiones</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_14'] ?></td>
                <td colspan="2" style="font-weight: bold;">Generador de torque</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_53'] ?></td>
                <td colspan="3" style="background-color: #e6e6e6; font-weight: bold; text-align:center;">FUNCIONAMIENTO GENERAL DEL EQUIPO</td>
                
            </tr> 
            <tr>
                <td colspan="2" style="font-weight: bold;">Sistema de seguridad cables potencia</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_15'] ?></td>
                <td colspan="2" style="font-weight: bold;">Escobillas</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_54'] ?></td>
                <td colspan="2" style="font-weight: bold;">Funcionamiento</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_75'] ?></td>
            </tr> 
            <tr>
                <td colspan="2" style="font-weight: bold;">Conectores</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_16'] ?></td>
                <td colspan="2" style="font-weight: bold;">Fugas por cilindro de direccion</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_55'] ?></td>
                <td colspan="3" style="background-color: #e6e6e6; font-weight: bold; text-align:center;">RUEDAS</td>
            </tr> 
            <tr>
                <td colspan="2" style="font-weight: bold;">Soportes</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_17'] ?></td>
                <td colspan="2" style="font-weight: bold;">Niveles de aceite y grasa</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_56'] ?></td>
                <td colspan="2" style="font-weight: bold;">Estado de los rines</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_87'] ?></td>
            </tr> 
            <tr>
                <td colspan="2" style="font-weight: bold;">Cauchos</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_18'] ?></td>
                <td colspan="2" style="font-weight: bold;">Mangueras de dirección</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_57'] ?></td>
                <td colspan="2" style="font-weight: bold;">Estado de ruedas</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_88'] ?></td>
            </tr> 
            <tr>
                <td colspan="2" style="font-weight: bold;">Controlador</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_19'] ?></td>
                <td colspan="2" style="font-weight: bold;">Columna de dirección</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_58'] ?></td>
                <td colspan="2" style="font-weight: bold;">Presión de neumáticos</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_89'] ?></td>
            </tr> 
            <tr>
                <td colspan="2" style="font-weight: bold;">Contactores</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_20'] ?></td>
                <td colspan="2" style="font-weight: bold;">Motor dirección</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_59'] ?></td>
                <td colspan="3" style="background-color: #e6e6e6; font-weight: bold; text-align:center;">PANEL DE CONTROLES</td>
            </tr> 
            <tr>
                <td colspan="2" style="font-weight: bold;">Displey</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_21'] ?></td>
                <td colspan="2" style="font-weight: bold;">Conexiones hidráulicas</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_60'] ?></td>
                <td colspan="2" style="font-weight: bold;">Controladores en marcha</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_94'] ?></td>
            </tr> 
            <tr>
                <td colspan="2" style="font-weight: bold;">Contactor de linea</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_22'] ?></td>
                <td colspan="2" style="font-weight: bold;">Funcionamiento del sistema de dirección</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_61'] ?></td>
                <td colspan="2" style="font-weight: bold;">Switches de marcha</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_95'] ?></td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold;">Contactor de dirección</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_23'] ?></td>
                <td colspan="3" style="background-color: #e6e6e6; font-weight: bold; text-align:center;">UNIDAD DE TRACCIÓN</td>
                <td colspan="2" style="font-weight: bold;">Contractores hidráulicos</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_96'] ?></td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold;">Contactor de elevacion</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_24'] ?></td>
                <td colspan="2" style="font-weight: bold;">Nivel de aceite</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_90'] ?></td>
                <td colspan="2" style="font-weight: bold;">Switches hidráulicos</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_97'] ?></td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold;">Contactores de marcha</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_25'] ?></td>
                <td colspan="2" style="font-weight: bold;">Fugas</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_91'] ?></td>
                <td colspan="2" style="font-weight: bold;">Mandos en el tablero de la canastilla</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_98'] ?></td>
            </tr>
            <tr>
                <td colspan="3" style="background-color: #e6e6e6; font-weight: bold; text-align:center;">SISTEMA HIDRAULICO</td>
                <td colspan="2" style="font-weight: bold;">Conexiones de cables</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_92'] ?></td>
                <td colspan="2" style="font-weight: bold;">Sensor de persona en canastilla</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_99'] ?></td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold;">Estado y nivel de aceite</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_26'] ?></td>
                <td colspan="2" style="font-weight: bold;">Motor tracción</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_93'] ?></td>
                <td colspan="3" style="background-color: #e6e6e6; font-weight: bold; text-align:center;">ESTADO DE PINTURA</td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold;">Fugas</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_27'] ?></td>
                <td colspan="3" style="background-color: #e6e6e6; font-weight: bold; text-align:center;">REVISIONES DE OPERACIÓN</td>
                <td colspan="2" style="font-weight: bold;">Estado de pintura en plataforma y barandas</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_100'] ?></td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold;">Filtros</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_28'] ?></td>
                <td colspan="2" style="font-weight: bold;">Medidor horas</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_64'] ?></td>
                <td colspan="2" style="font-weight: bold;">Pintura de base, brazos y estructura</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_101'] ?></td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold;">Funcionamiento de válvulas</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_29'] ?></td>
                <td colspan="2" style="font-weight: bold;">Extintores</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_65'] ?></td>
                <td colspan="2"></td>
                <td ></td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold;">Racores</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_30'] ?></td>
                <td colspan="2" style="font-weight: bold;">Bocina</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_66'] ?></td>
                <td colspan="2"></td>
                <td ></td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold;">Cilindros hidráulicos</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_31'] ?></td>
                <td colspan="2" style="font-weight: bold;">Luces indicadoras</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_67'] ?></td>
                <td colspan="2"></td>
                <td ></td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold;">Bomba hidráulica</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_32'] ?></td>
                <td colspan="2" style="font-weight: bold;">Desconector de emergencia</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_68'] ?></td>
                <td colspan="2"></td>
                <td ></td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold;">Estado de electroválvulas</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_33'] ?></td>
                <td colspan="2" style="font-weight: bold;">Operación de controles</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_69'] ?></td>
                <td ></td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold;">Abolladuras vástago y carcasa</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_34'] ?></td>
                <td colspan="2" style="font-weight: bold;">Frenado</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_70'] ?></td>
                <td colspan="2"></td>
                <td ></td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold;">Ojos o juntas conexión sueltas o fisuradas</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_35'] ?></td>
                <td colspan="2" style="font-weight: bold;">Control manual en tierra</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_71'] ?></td>
                <td colspan="2"></td>
                <td ></td>
            </tr>
            <div style="page-break-before: always;"></div>
            <tr>
                <td colspan="3" style="background-color: #e6e6e6; font-weight: bold; text-align:center;">SISTEMA DE FRENOS</td>
                <td colspan="3" style="background-color: #e6e6e6; font-weight: bold; text-align:center;">PANTOGRAFO</td>
                <td colspan="2"></td>
                <td ></td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold;">Estado de las mangueras</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_36'] ?></td>
                <td colspan="2" style="font-weight: bold;">Control manual en canastilla</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_72'] ?></td>
                <td colspan="2"></td>
                <td ></td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold;">Estado de las conexiónes</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_37'] ?></td>
                <td colspan="2" style="font-weight: bold;">Señalización de mandos de tierra</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_73'] ?></td>
                <td colspan="2"></td>
                <td ></td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight: bold;">Accionamiento normal sin bloqueos</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_38'] ?></td>
                <td colspan="2" style="font-weight: bold;">Señalización de mandos en plataforma</td>
                <td style="text-align:center;"><?= $DataDetalleD['Criterio_74'] ?></td>
                <td colspan="2"></td>
                <td ></td>
            </tr>
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
                    <!-- Columna lateral fija (nombre de categoría)  -->
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