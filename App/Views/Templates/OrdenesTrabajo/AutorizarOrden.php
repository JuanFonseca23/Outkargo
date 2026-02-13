<?php
    session_start();
    if (empty($_SESSION['ID'])) {
        header("location:../IniciarSesion");
        exit;
    }
    include_once "App/Controllers/UsuarioController.php";
    include_once "App/Controllers/OrdenesTrabajoController.php";
    
    $UsuariosController = new UsuarioController();
    $OrdenesTrabajoController = new OrdenesTrabajoController();

    $DataOrden = $OrdenesTrabajoController->VerOrden($_GET['ID']);
    $DataMecanicos = $OrdenesTrabajoController->VerMecanicos($_GET['ID']);
    $DataMontacargas = $OrdenesTrabajoController->VerMontacargas($_GET['ID']);
    $DataInsumos = $OrdenesTrabajoController->VerDetallesInsumosOrden($_GET['ID']);
    $Fecha = date("d/m/Y");

    if($DataOrden['Tipo_Trabajo'] === 'MantenimientoP'){
        $Tipo = 'Mantenimiento Preventivo';
    }else if ($DataOrden['Tipo_Trabajo'] === 'MantenimientoC'){
        $Tipo = 'Mantenimiento Correctivo';
    }else{
        $Tipo = $DataOrden['Tipo_Trabajo'];
    }

    $DataOrdenDetalles = $OrdenesTrabajoController->VerDetallesOrden($_GET['ID'], $DataOrden['Tipo_Trabajo']);
    date_default_timezone_set('America/Bogota');
    $TotalTrabajos = 0;
    $TrabajosRealizados = 0;
    $PorcentajeAvance = 0;

    if (!empty($DataOrdenDetalles)) {
        foreach ($DataOrdenDetalles as $detalle) {
            $TotalTrabajos++;
            if ($detalle['EstadoTrabajo'] == 1) { 
                $TrabajosRealizados++;
            }
        }
    }
    if ($TotalTrabajos > 0) {
        $PorcentajeAvance = round(($TrabajosRealizados / $TotalTrabajos) * 100);
    }

    if ($DataOrden['Estado_Orden'] === 'Aprobada') {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Atención',
                    text: 'Ya has verificado esta orden.',
                    icon: 'warning',
                    confirmButtonText: 'Aceptar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'InicioOrden'; 
                    }
                });
            });
        </script>";
        exit;
    }

    if ($_SERVER['HTTP_HOST'] == 'localhost') {
    $baseUrl = 'http://localhost/OUTKARGO/';
    } else {
        $baseUrl = 'https://outkargo.com.co/';
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>OUTKARGO - Administrador</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="description" content="OUTKARGO ofrece servicios de alquiler de montacargas con y sin operador en Colombia. Contamos con una amplia flota de montacargas para cubrir tus necesidades de carga y descarga.">
    <meta name="keywords" content="OUTKARGO, alquiler de montacargas, montacargas con operador, montacargas sin operador, Colombia, Montacargas, Pasillo angosto, Toma Pedido, Contrabalanceada, Contrabalanceado, Snorlift, Manlift, Lift, Combustion Interna, Diesel, Gas">
    <link rel="icon" href="../Favicon.ico" type="image/x-icon" >

    <!-- JavaScript -->
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <!-- CSS -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
    <!-- Default theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link rel= "stylesheet" href= "https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css" >
    <link href="../../App/Views/Resources/Lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="../../App/Views/Resources/Lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />
    <!-- Template Stylesheet -->
    <link href="../../App/Views/Resources/Css/Dashboard/style.css" rel="stylesheet">

    <!-- Tom Select: Librerías CSS y JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.bootstrap5.min.css">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>

    <style>
        /* ===== GENERAL ===== */
        body{
            font-family: Arial, Helvetica, sans-serif;
            font-size: 14px;
            margin: 0;
            padding: 8px;
            color: #000;
        }

        /* ===== TABLAS ===== */
        .tabla-1{
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            border: 2px solid #000;
        }

        .tabla-contenedor{
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
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
            border: 2px solid #000;
            white-space: nowrap;
            font-size: 12px;
        }

        .tabla-info2 th, 
        .tabla-info2 td  {
            text-align: center;
            padding: 3px 4px;
            border: 2px solid #000;
            white-space: nowrap;
            font-size: 12px;
        }

        .tabla-1 th, 
        .tabla-1 td{
            border: 2px solid #000;
            padding: 6px;
        }
        .tabla-1 th{
            background: #f0f0f0;
        }

        .titulo{
            font-size: 18px;
            font-weight: bold;
            text-align: center;
        }
        .logo img{
            max-width: 180px;
        }

        .text-center{text-align:center;}
        .text-right{text-align:right;}
        .text-red{color:#c00000;font-weight:bold;}
        .bg-gray{background:#e6e6e6;}

        /* ===== INPUTS ===== */
        input{
            width: 100%;
            padding: 6px;
            box-sizing: border-box;
        }

        /* ===== BOTONES ===== */
        .btn-guardar{
            background:#198754;
            color:#fff;
            border: 1px solid #000;
            border-radius: 5px;
            padding:6px 10px;
            cursor:pointer;
        }
        .btn-eliminar{
            background:#a60000;
            color:#fff;
            border: 1px solid #000;
            border-radius: 5px;
            padding:6px 10px;
            cursor:pointer;
        }

        /* ===== FIRMA DIGITAL ===== */
        .tabla-firma th,
        .tabla-firma td{
            border: 2px solid #000;
            padding: 6px;
        }

        .tabla-firma th{
            background: #f0f0f0;
        }

        .tabla-firma {
            width: 100%;
            max-width: 500px;  
            table-layout: fixed;
            overflow: hidden;
        }

        .tabla-firma th,
        .tabla-firma td{
            border: 2px solid #000;
            padding: 6px;
            word-wrap: break-word;
        }

        .tabla-firma th{
            background: #f0f0f0;
        }

        #firmaCanvas {
            border: 1px solid #ccc;
            width: 100%;
            max-width: 380px;         
            height: 180px;
            touch-action: none;
            display: block;
            margin: auto;
        }

        .firma-actions{
            margin-top:6px;
            text-align:center;
        }

        .firma-actions button{
            padding:6px 12px;
            border:1px solid #000;
            border-radius: 5px;
            background:#f0f0f0;
            cursor:pointer;
        }

        .tabla-wrapper{
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        .tablaDetalles{
            min-width: 720px;        
            white-space: nowrap;   
        }

        .tablaObservaciones textarea{
            width: 99%;
        }

        .img-check {
            width: 77px;
            height: 77px;
            object-fit: contain;
        }

        .oculto {
            visibility: hidden;
        }

        /* ================= ANIMACIONES ================= */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideDown {
            from {
                transform: translateY(-30px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        /* ===== RESPONSIVE ===== */
        @media screen and (max-width: 768px) {
            body{
                font-size: 8px;
                padding: 7px;
            }

            .tabla-1{
                margin-bottom: 2px;
                border: 1px solid #000;
            }

            .tabla-contenedor{
                margin-bottom: 2px;
            }
            
            .img-check {
                width: 54px;
                height: 54px;
                object-fit: contain;
            }

            .tabla-info th, 
            .tabla-info td  {
                text-align: left;
                padding: 3px 4px;
                border: 1px solid #000;
                white-space: nowrap;
                font-size: 7px;
            }

            .tabla-info2 th, 
            .tabla-info2 td  {
                text-align: center;
                padding: 1.5px 4px;
                border: 1px solid #000;
                white-space: nowrap;
                font-size: 7px;
            }

            .tabla-1 th, 
            .tabla-1 td{
                border: 1px solid #000;
                padding: 3px;
            }

            .titulo{
                font-size: 11px;
            }

            .logo img{
                max-width: 110px;
            }

            .btn-add,
            .btn-guardar,
            .btn-remove,
            .btn-eliminar{
                font-size: 10px;
                padding:4px 8px;
            }

            .tablaObservaciones{
                width: 100%;
            }

            .tablaObservaciones textarea{
                width: 99%;
            }

            .tabla-firma th,
            .tabla-firma td{
                border: 1px solid #000;
                padding: 3px;
            }

            #firmaCanvas {
                max-width: 100%;
                height: 150px;
            }

            .firma-actions button{
                padding:3px 9px;
                font-size: 10px;
                font-weight: bold;
            }

        }
        /* ===== RESPONSIVE MOVIL MEDIO (371px – 414px) ===== */
        @media screen and (max-width: 414px) and (min-width: 371px) {

            body{
                font-size: 7.5px;
                padding: 4px;
            }

            .img-check {
                width: 60px;
                height: 60px;
                object-fit: contain;
            }

            .tabla-info th, 
            .tabla-info td  {
                text-align: left;
                padding: 3px 4px;
                border: 1px solid #000;
                white-space: nowrap;
                font-size: 7.5px;
            }

            .tabla-info2 th, 
            .tabla-info2 td  {
                text-align: center;
                padding: 1.5px 4px;
                border: 1px solid #000;
                white-space: nowrap;
                font-size: 7.5px;
            }

            .tabla-1 th, 
            .tabla-1 td{
                border: 1px solid #000;
                padding: 2px;
            }

            .titulo{
                font-size: 10px;
            }

            .logo img{
                max-width: 95px;
            }

            .btn-add,
            .btn-guardar,
            .btn-remove,
            .btn-eliminar{
                font-size: 9px;
                padding: 3px 7px;
            }

            .tabla-firma th,
            .tabla-firma td{
                border: 1px solid #000;
                padding: 2px;
            }

            #firmaCanvas {
                height: 135px;
            }

            input{
                padding: 4px;
                font-size: 9px;
            }

        }
        /* ===== RESPONSIVE EXTRA PEQUEÑO (≤ 370px) ===== */
        @media screen and (max-width: 370px) {

            body{
                font-size: 7px;
                padding: 3px;
            }

            .img-check {
                width: 36px;
                height: 36px;
                object-fit: contain;
            }

            .tabla-info th, 
            .tabla-info td  {
                padding: 1px 1px;
                border: 1px solid #000;
            }

            .tabla-info2 th, 
            .tabla-info2 td  {
                padding: 1px 1px;
                border: 1px solid #000;
            }

            .tabla-1 th, 
            .tabla-1 td{
                border: 1px solid #000;
                padding: 1px;
            }

            .titulo{
                font-size: 9px;
            }

            .logo img{
                max-width: 85px;
            }

            .btn-add,
            .btn-guardar,
            .btn-remove,
            .btn-eliminar{
                font-size: 8px;
                padding: 3px 6px;
            }

            #firmaCanvas {
                height: 120px;
            }

            .firma-actions button{
                font-size: 8px;
                padding: 2px 6px;
            }

            input{
                padding: 3px;
                font-size: 8px;
            }

        }
    </style>
</head>

<body>
    <!-- ENCABEZADO -->
    <table class="tabla-1">
        <tr>
            <th rowspan="3" class="logo"><img src="../App/Views/Img/Outkargo.png"></th>
            <th rowspan="3" class="titulo">ORDEN DE TRABAJO</th>
            <th>CÓDIGO</th>
            <td></td>
        </tr>
        <tr>
            <th>FECHA</th>
            <td>13/01/2026</td>
        </tr>
        <tr>
            <th>VERSIÓN</th>
            <td>1</td>
        </tr>
    </table>

    <!-- DATOS -->
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
                            <td class="celda-check">
                                <img 
                                    src="https://img.icons8.com/dotty/80/checked.png" 
                                    alt="checked" 
                                    class="img-check <?= $DataOrden['Estado_Orden'] === 'Aprobada' ? '' : 'oculto' ?>"
                                />
                            </td>

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

    <table class="tabla-1">
        <?php 
            $Mostrado = false;
            if ($DataOrdenDetalles) {
                foreach ($DataOrdenDetalles as $DataOrdenDetalle) {
                    if ($DataOrden['Tipo_Trabajo'] === 'Repuesto'){ 
                        if (!$Mostrado) {?>
            <tr>
                <th>Solicitado por:</th>
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
            <th>Tecnico(s) Encargado(s):</th>
            <td ><?php
                if ($DataMecanicos) {
                    echo '<ul style="list-style:none; margin:0; padding:0;">';
                    foreach ($DataMecanicos as $mecanico) {
                        echo '<li>' . htmlspecialchars($mecanico['NombreMecanico']) . '</li>';
                    }
                    echo '</ul>';
                } else {
                    echo 'No hay técnicos asignados';
                }
                ?></td>
            <th>Centro de trabajo</th>
            <td><?= $DataOrden['CentroOrden'] ?></td>
            <th>Fecha de Inicio:</th>
            <td><?= $Fecha ?></td>
            <th>Fecha de Finalización Prevista:</th>
            <td><?= $DataOrden['Fecha_Entrega_Aprox'] ?></td>
        </tr>
    </table>

    <table class="tabla-1">
        
        <?php if ($DataOrden['Tipo_Trabajo'] === 'Overhauling' || $DataOrden['Tipo_Trabajo'] ==='MantenimientoP' || $DataOrden['Tipo_Trabajo'] === 'MantenimientoC'): ?>
            <tr>
                <th colspan="8" style="background-color: #e6e6e6; text-align: center;">Montacargas</th>
            </tr>
            <tr>
                <th>Numero:</th>
                <td style="width: 20px;"><?= $DataMontacargas["Numero"] ?></td>
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
                <td style="width: 20px;"><?= $DataOrdenDetalle["NumeroMontacargas"] ?></td>
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

    <!-- DETALLES -->
    <div class="tabla-wrapper">
            <table class="tabla-1" id="tablaDetalles">
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
                            <th colspan="4" style="background-color:#e6e6e6;text-align:center;">
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
                        foreach ($DataOrdenDetalles as $d) {
                            if ($d['Tipo_Producto'] === 'Montacargas') {
                                $tieneMontacargas = true;
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
                                <th colspan="2">Descripción de Falla</th>
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
                                    <td colspan="2"><?= $d['DescripcionFalla'] ?></td>
                                </tr>
                            <?php }} ?>
                        </tbody>

                    <?php endif; ?>

                    <!-- -------- PRODUCTOS -------- -->
                    <thead>
                        <tr>
                            <th colspan="7" style="background-color:#e6e6e6;text-align:center;">
                                TRABAJOS A REALIZAR EN PRODUCTOS
                            </th>
                        </tr>
                        <tr>
                            <th style="width: 20px; text-align: center;">#</th>
                            <th style="width: 60px; text-align: center;">Código</th>
                            <th style="width: 90px; text-align: center;">Serie</th>
                            <th style="width: 90px; text-align: center;">Parte</th>
                            <th style="text-align: center;">Descripción de Falla</th>
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
                                <td><?= $d['DescripcionFalla'] ?></td>
                            </tr>
                        <?php }} ?>
                    </tbody>

                <?php endif; ?>
            </table>
    </div>

    <table class="tabla-1">
            <thead>
                    <tr>
                        <th colspan="4" style="background-color:#e6e6e6;text-align:center;">
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

    <table class="tabla-1">
            <thead>
                <tr>
                    <th colspan="6" style="background-color:#e6e6e6;text-align:center;">
                        INSUMOS Y REPUESTOS INSTALADOS 
                    </th>    
                </tr>
                <tr>
                    <th width="50px">#</th>
                    <th width="60px">Cantidad</th>
                    <th width="60px"></th>
                    <th width="70px">Codigo</th>
                    <th>Descripción</th>
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
                    <td style="width: 60px; text-align: center;"><?= $DataInsumo['Cantidad'] ?></td>
                    <td style="width: 60px; text-align: center;"><?= $DataInsumo['Medida'] ?></td>
                    <td style="width: 60px; text-align: center;"><?= $DataInsumo['CodigoInsumo'] ?></td>
                    <td><?= $DataInsumo['NombreInsumo'] ?></td>
                </tr>
                <?php
                    }
                } else {
                ?>
                <tr>
                    <td colspan="6" style="text-align:center; font-style:italic;">
                        No hay insumos ni repuestos instalados
                    </td>
                </tr>
                <?php
                }
                ?>
            </tbody>
    </table>

    <form method="POST" id="formEnviar">
        <!-- FIRMA -->
        <table class="tabla-firma">
            <tr>
                <th colspan="2" class="bg-gray text-center">FIRMA AUTORIZA</th>
            </tr>
            <tr>
                <td colspan="2" data-label="Firma" class="text-center">
                    <canvas id="firmaCanvas"></canvas>
                    <div class="firma-actions">
                        <button type="button" onclick="limpiarFirma()">Limpiar firma</button>
                    </div>
                </td>
            </tr>
            <tr>
                <td data-label="Nombre">
                    <strong>Nombre:</strong> <?= $_SESSION['NombreCompleto'] ?>
                </td>
                <td data-label="Fecha">
                    <strong>Fecha:</strong> <?= $Fecha ?>
                </td>
            </tr>
        </table>
        <input type="hidden" name="firma" id="firma">
        <button type="submit" class="btn-guardar" name="Guardar">Enviar</button>
    </form>

    <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['Guardar'])) {
                $ID_Orden = $_GET['ID'];
                $FirmaVerifica = $_POST['firma'];
                $Estado_Trabajo = 'Aprobada';
                $ID_Verifica = $DataOrden['ID_Genera'];
                $Numero = $DataOrden['Numero'];
                $Nombre = $_SESSION['NombreCompleto'];
                $Resultado = $OrdenesTrabajoController->FirmarOrdenVerificada($ID_Orden, $ID_Verifica, $Estado_Trabajo, $FirmaVerifica, $Numero, $Nombre);
                if ($Resultado) {
                    echo "
                    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                    <script>
                        Swal.fire({
                            title: 'Orden de Trabajo!',
                            text: 'La  orden de trabajo ha sido firmada exitosamente.',
                            icon: 'success',
                            showCancelButton: true,
                            confirmButtonText: 'Continuar',
                            cancelButtonText: 'Cancelar',
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = 'InicioOrden';
                            }
                        });
                    </script>";
                }else{
                    echo "
                    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                    <script>
                        Swal.fire({
                            title: 'Error!',
                            text: 'La orden de trabajo no se pudo firmar, por favor intente de nuevo.',
                            icon: 'error',
                            timer: 3000,
                            timerProgressBar: true
                        });
                    </script>";
                }

            }
        }

    ?>

    <script>
        const canvas = document.getElementById('firmaCanvas');
        const ctx = canvas.getContext('2d');
        let dibujando = false;

        // ================== CONFIGURACIÓN DE TAMAÑO (IMPORTANTE) ==================
        function ajustarTamanioCanvas() {
            const anchoVisible = Math.min(canvas.parentElement.offsetWidth, 380);
            const altoVisible  = 180;

            canvas.style.width  = anchoVisible + "px";
            canvas.style.height = altoVisible + "px";

            const ratio = window.devicePixelRatio || 1;

            canvas.width  = anchoVisible * ratio;
            canvas.height = altoVisible * ratio;

            ctx.setTransform(ratio, 0, 0, ratio, 0, 0);

            ctx.lineWidth   = 3.2;
            ctx.lineCap     = "round";
            ctx.lineJoin    = "round";
            ctx.strokeStyle = "#000";
        }

        ajustarTamanioCanvas();
        window.addEventListener('resize', ajustarTamanioCanvas);

        // ==================== FUNCIÓN COORDENADAS ====================
        function obtenerPosicion(evento) {
            const rect = canvas.getBoundingClientRect();

            if (evento.touches) {
                return {
                    x: evento.touches[0].clientX - rect.left,
                    y: evento.touches[0].clientY - rect.top
                };
            } else {
                return {
                    x: evento.offsetX,
                    y: evento.offsetY
                };
            }
        }

        // ==================== EVENTOS MOUSE ====================
        canvas.addEventListener('mousedown', (e) => {
            dibujando = true;
            const pos = obtenerPosicion(e);
            ctx.beginPath();
            ctx.moveTo(pos.x, pos.y);
        });

        canvas.addEventListener('mousemove', (e) => {
            if (!dibujando) return;
            const pos = obtenerPosicion(e);
            ctx.lineTo(pos.x, pos.y);
            ctx.stroke();
        });

        canvas.addEventListener('mouseup', () => {
            if (dibujando) {
                dibujando = false;
                guardarFirmaEnCampo();
            }
        });

        canvas.addEventListener('mouseleave', () => {
            if (dibujando) {
                dibujando = false;
                guardarFirmaEnCampo();
            }
        });

        // ==================== EVENTOS TOUCH ====================
        canvas.addEventListener('touchstart', (e) => {
            e.preventDefault();
            dibujando = true;
            const pos = obtenerPosicion(e);
            ctx.beginPath();
            ctx.moveTo(pos.x, pos.y);
        });

        canvas.addEventListener('touchmove', (e) => {
            e.preventDefault();
            if (!dibujando) return;
            const pos = obtenerPosicion(e);
            ctx.lineTo(pos.x, pos.y);
            ctx.stroke();
        });

        canvas.addEventListener('touchend', (e) => {
            e.preventDefault();
            if (dibujando) {
                dibujando = false;
                guardarFirmaEnCampo();
            }
        });

        // ==================== GUARDAR FIRMA ====================
        function guardarFirmaEnCampo() {
            document.getElementById('firma').value = canvas.toDataURL('image/png');
        }

        // ==================== LIMPIAR FIRMA ====================
        function limpiarFirma() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            document.getElementById('firma').value = '';
        }

        // ==================== VALIDAR CANVAS VACÍO ====================
        function canvasVacio(c) {
            const datos = c.getContext('2d').getImageData(0, 0, c.width, c.height).data;
            for (let i = 3; i < datos.length; i += 4) {
                if (datos[i] !== 0) {
                    return false;
                }
            }
            return true;
        }

        // ==================== VALIDACIÓN AL ENVIAR ====================
        const formEnviar = document.getElementById('formEnviar');

        if (formEnviar) {
            formEnviar.addEventListener('submit', function (e) {
                if (canvasVacio(canvas)) {
                    e.preventDefault();
                    alertify.error("Debe firmar la solicitud antes de enviarla.");
                    return false;
                }

                document.getElementById('firma').value = canvas.toDataURL('image/png');
                return true;
            });
        }
    </script>
</body>
</html>
