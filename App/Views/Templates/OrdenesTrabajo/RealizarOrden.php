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
    $DataInsumoTemp = $OrdenesTrabajoController->VerDetalleInsumoTemp($_GET['ID']);
    $Mantenimiento = $OrdenesTrabajoController->BuscarMantenimiento($_GET['ID']);
    $Fecha = date("d/m/Y");

    if($DataOrden['Estado_Orden'] === 'Pendiente'){
        $Fecha_FinO = NULL;
        $OrdenesTrabajoController->CambiarFecha($_GET['ID'], $Fecha, $Fecha_FinO);
    }
    if (!$Mantenimiento) {
        $ID_Mantenimiento = $OrdenesTrabajoController->CrearMantenimiento($_GET['ID'], $DataMecanicos, $DataOrden['ID_Genera'], $DataOrden['ID_Centro'], $Fecha);
    }else{
        $ID_Mantenimiento = $Mantenimiento['ID'];
    }

    if ($DataOrden['Estado_Orden'] === 'Pendiente' || $DataOrden['Estado_Orden'] === 'Pausada') {
        $OrdenesTrabajoController->CambiarEstadoOrden($_GET['ID'], 'En Proceso');
        $DataOrden = $OrdenesTrabajoController->VerOrden($_GET['ID']);
    }

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
    <link href="../App/Views/Css/bootstrap.min.dashboard.css" rel="stylesheet">
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
        .btn-pausar{
            background:#ffc107;
            color:#000;
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
            max-width: 500px;   /* IMPORTANTE */
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

        /* TODOS LOS CANVAS */
        canvas[id^="firmaCanvas"] {
            border: 1px solid #ccc;
            width: 100% !important;
            max-width: 100% !important;
            height: 180px;
            touch-action: none;
            display: block;
            margin: 0 auto;
            box-sizing: border-box;
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

        .modal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background: rgba(0, 0, 0, 0.55);
            backdrop-filter: blur(3px);
            animation: fadeIn 0.25s ease;
        }

        /* ================= CONTENIDO ================= */
        .modal-contenido {
            background: #ffffff;
            margin: 6% auto;
            padding: 15px 20px;
            width: 520px;
            max-width: 95%;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.25);
            border: 1px solid #000020;
            animation: slideDown 0.3s ease;
            font-family: "Segoe UI", Arial, sans-serif;
        }

        /* ================= TITULO ================= */
        .modal-contenido h3 {
            margin-top: 0;
            margin-bottom: 15px;
            font-size: 18px;
            text-align: center;
            color: #000000;
        }

        /* ================= TEXTAREA ================= */
        .modal-contenido textarea {
            width: 100%;
            border-radius: 6px;
            border: 1px solid #ccc;
            padding: 5px;
            font-size: 14px;
            resize: vertical;
            outline: none;
            transition: border 0.2s;
        }

        .modal-contenido textarea:focus {
            border-color: #ff5000;
        }

        /* ================= BOTONES ================= */
        .modal-contenido button {
            padding: 8px 14px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-size: 14px;
            margin-right: 6px;
            transition: 0.2s;
        }

        /* Guardar */
        .modal-contenido button[type="submit"] {
            background: #28a745;
            color: white;
        }

        .modal-contenido button[type="submit"]:hover {
            background: #218838;
        }

        /* Cancelar */
        .modal-contenido .btn-cancelar{
            background: #dc3545;
            color: white;
        }

        .modal-contenido .btn-cancelar:hover {
            background: #c82333;
        }

        /*Tomar Foto */
        .modal-contenido .btn-tomar {
            background: #ffffff; 
            border: 1px solid #ff5000; 
            color: #ff5000;
        }

        .modal-contenido .btn-tomar:hover {
            background: #ff5000;
            color: #ffffff;
        }

        /*Cargar  Foto */
        .modal-contenido .btn-cargar {
            background: #ffffff; 
            border: 1px solid #6c757d;  
            color: #6c757d;
        }

        .modal-contenido .btn-cargar:hover {
            background: #5a6268;
            color: #ffffff;
        }

        .img-check {
            width: 77px;
            height: 77px;
            object-fit: contain;
        }

        .oculto {
            visibility: hidden;
        }

        .ts-dropdown {
            background-color: white !important;
            border: 1px solid #ced4da !important;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15) !important;
            border-radius: 8px !important;
            margin-top: 4px !important;
        }

        .ts-dropdown .option {
            padding: 10px 12px !important;
            color: #212529 !important;
            border-bottom: 1px solid #eee;
        }

        .ts-dropdown .option:hover,
        .ts-dropdown .option.active {
            background-color: #e3f2fd !important;
            color: #1976d2 !important;
        }

        .ts-control {
            border: none !important;
            border-bottom: 2px solid #adb5bd !important;
            border-radius: 0 !important;
            padding: 8px 0 !important;
            box-shadow: none !important;
        }

        .ts-control .placeholder {
            color: #6c757d !important;
            font-size: 1.1rem;
        }

        /* Adjuntos */
        .adjunto-box {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            background: #f8f9fa;
        }

        .adjunto-nombre {
            font-weight: 600;
        }

        .adjunto-desc {
            font-size: 0.85rem;
            color: #6c757d;
        }

        /* Fondo del lightbox */
        .lightbox-bg {
            background: rgba(0, 0, 0, 0.90);
            z-index: 9999;
        }

        /* Imagen del lightbox */
        .lightbox-img {
            max-height: 95vh;
            max-width: 95vw;
            object-fit: contain;
            cursor: default;
        }

        /* Botones de navegación (prev y next) */
        .nav-btn {
            top: 50%;
            transform: translateY(-50%);
            background-color: black !important;
            color: white !important;
            width: 40px;
            height: 40px;
            font-size: 2rem;
            padding: 0;
            border-radius: 50%;

            display: flex;              
            align-items: center;      
            justify-content: center;
        }

        /* Botón cerrar */
        .close-btn {
            background-color: black !important;
            color: white !important;
            width: 40px;
            height: 40px;
            font-size: 1.2rem;
            padding: 0;
            border-radius: 50%;
        }

        .ts-dropdown {
            background-color: white !important;
            border: 1px solid #ced4da !important;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15) !important;
            border-radius: 8px !important;
            margin-top: 4px !important;
        }

        .ts-dropdown .option {
            padding: 10px 12px !important;
            color: #212529 !important;
            border-bottom: 1px solid #eee;
        }

        .ts-dropdown .option:hover,
        .ts-dropdown .option.active {
            background-color: #e3f2fd !important;
            color: #1976d2 !important;
        }

        .ts-control {
            border: none !important;
            border-bottom: 2px solid #adb5bd !important;
            border-radius: 0 !important;
            padding: 8px 0 !important;
            box-shadow: none !important;
        }

        .ts-control .placeholder {
            color: #6c757d !important;
            font-size: 1.1rem;
        }

        /* Adjuntos */
        .adjunto-box {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            background: #f8f9fa;
        }

        .adjunto-nombre {
            font-weight: 600;
        }

        .adjunto-desc {
            font-size: 0.85rem;
            color: #6c757d;
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

            canvas[id^="firmaCanvas"] {
                height: 150px;
            }

            .firma-actions button{
                padding:3px 9px;
                font-size: 10px;
                font-weight: bold;
            }

            .modal {
                display: none;
                position: fixed;
                z-index: 9999;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                overflow: auto;
                background: rgba(0, 0, 0, 0.55);
                backdrop-filter: blur(3px);
                animation: fadeIn 0.25s ease;
            }

            /* ================= CONTENIDO ================= */
            .modal-contenido {
                background: #ffffff;
                margin: 6% auto;
                padding: 15px 20px;
                width: 360px;
                max-width: 95%;
                border-radius: 12px;
                box-shadow: 0 10px 25px rgba(0,0,0,0.25);
                border: 1px solid #000020;
                animation: slideDown 0.3s ease;
                font-family: "Segoe UI", Arial, sans-serif;
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

            canvas[id^="firmaCanvas"] {
                height: 120px;
            }

            input{
                padding: 4px;
                font-size: 9px;
            }

            .modal {
                display: none;
                position: fixed;
                z-index: 9999;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                overflow: auto;
                background: rgba(0, 0, 0, 0.55);
                backdrop-filter: blur(3px);
                animation: fadeIn 0.25s ease;
            }

            /* ================= CONTENIDO ================= */
            .modal-contenido {
                background: #ffffff;
                margin: 6% auto;
                padding: 15px 20px;
                width: 320px;
                max-width: 85%;
                border-radius: 10px;
                box-shadow: 0 10px 25px rgba(0,0,0,0.25);
                border: 1px solid #000020;
                animation: slideDown 0.3s ease;
                font-family: "Segoe UI", Arial, sans-serif;
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

            canvas[id^="firmaCanvas"] {
                height: 95px;
            }

            .firma-actions button{
                font-size: 8px;
                padding: 2px 6px;
            }

            input{
                padding: 3px;
                font-size: 8px;
            }

            .modal {
                display: none;
                position: fixed;
                z-index: 9999;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                overflow: auto;
                background: rgba(0, 0, 0, 0.55);
                backdrop-filter: blur(3px);
                animation: fadeIn 0.25s ease;
            }

            /* ================= CONTENIDO ================= */
            .modal-contenido {
                background: #ffffff;
                margin: 6% auto;
                padding: 15px 20px;
                width: 250px;
                max-width: 95%;
                border-radius: 12px;
                box-shadow: 0 10px 25px rgba(0,0,0,0.25);
                border: 1px solid #000020;
                animation: slideDown 0.3s ease;
                font-family: "Segoe UI", Arial, sans-serif;
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
                            <th style="width: 60px; text-align: center;">Acciones</th>
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
                                <td>
                                    <?php if ($d['EstadoTrabajo'] === 2){?>
                                        <button class="btn-guardar" data-id="<?= $d['ID'] ?>" data-idtrabajo="<?= $d['IDTrabajo'] ?? '' ?>" data-descripcionfalla="<?= $d['DescripcionFalla'] ?>" onclick="abrirModal(this)">
                                            Registrar
                                        </button>
                                    <?php }?>
                                </td>
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
                                <th colspan="2">Descripción de Falla</th>
                                <th style="width: 60px; text-align: center;">Acciones</th>
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
                                    <td>
                                        <?php if ($d['EstadoTrabajo'] === 2){?>
                                            <button class="btn-guardar" data-id="<?= $d['ID'] ?>" data-idtrabajo="<?= $d['IDTrabajo'] ?? '' ?>" data-descripcionfalla="<?= $d['DescripcionFalla'] ?>" onclick="abrirModal(this)">
                                                Registrar
                                            </button>
                                        <?php }?>
                                    </td>
                                </tr>
                            <?php }} ?>
                        </tbody>

                    <?php endif; ?>

                    <!-- -------- PRODUCTOS -------- -->
                    <?php if ($tieneRepuestos): ?>
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
                                <th style="width: 60px; text-align: center;">Acciones</th>
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
                                    <td>
                                        <?php if ($d['EstadoTrabajo'] === 2){?>
                                            <button class="btn-guardar" data-id="<?= $d['ID'] ?>" data-idtrabajo="<?= $d['IDTrabajo'] ?? '' ?>" data-descripcionfalla="<?= $d['DescripcionFalla'] ?>" onclick="abrirModal(this)">
                                                Registrar
                                            </button>
                                        <?php }?>
                                    </td>
                                </tr>
                            <?php }} ?>
                        </tbody>
                    <?php endif; ?>

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
                        <th style="width: 70px; text-align: center;">Acciones</th>
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
                    <td>
                        <?php if ($DataOrdenDetalle['EstadoTrabajo'] === 1){?>
                            <form method="POST">
                                <input type="hidden" name="ID_Detalle" value="<?= $DataOrdenDetalle['ID'] ?>">
                                <input type="hidden" name="ID_Trabajo" value="<?= $DataOrdenDetalle['IDTrabajo'] ?>">
                                <button type="submit"  class="btn-eliminar" name="EliminarTrabajo">Eliminar</button>
                            </form>
                        <?php }?>
                    </td>
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
                
                <form method="POST">
                    <tr>
                        <td colspan="2">
                            <input type="number" id="cantidad" name="Cantidad" class="form-control" min="1" placeholder="Cantidad">
                        </td>

                        <td width="50px"> 
                            <select id="tipoMedida" name="tipoMedida">
                                <option value="Und">Und</option>
                                <option value="Gal">Gal</option>
                                <option value="1/4">1/4</option>
                                <option value="1/2">1/2</option>
                                <option value="3/4">3/4</option>
                                <option value="Kilo">Kilo</option>
                                <option value="Bulto">Bulto</option> 
                            </select>
                        </td>

                        <td colspan="3">
                            <select name="para[]" id="select-para" multiple required></select>
                        </td>

                        <td width="70px">
                            <button type="submit" class="btn-guardar" name="AgregarInsumos">Agregar</button>
                        </td>
                    </tr>
                </form>

                <tr>
                    <th style="width: 60px; text-align: center;">#</th>
                    <th width="60px">Cantidad</th>
                    <th width="50px"></th>
                    <th style="width: 80px; text-align: center;">Codigo</th>
                    <th colspan="2">Descripción</th>
                    <th width="60px">Acciones</th>
                </tr>
                
            </thead>
            <tbody>
                <?php
                $Numero = 0;

                if (!empty($DataInsumoTemp)) {
                    foreach ($DataInsumoTemp as $DataInsumo) {
                        $Numero++;
                ?>
                <tr>
                    <td style="text-align:center;"><?= $Numero ?></td>
                    <td style="width: 60px; text-align: center;"><?= $DataInsumo['Cantidad'] ?></td>
                    <td style="width: 60px; text-align: center;"><?= $DataInsumo['Medida'] ?></td>
                    <td style="width: 60px; text-align: center;"><?= $DataInsumo['CodigoInsumo'] ?></td>
                    <td colspan="2"><?= $DataInsumo['NombreInsumo'] ?></td>
                    <td width="60px" style="align-items: center;">
                        <form method="POST">
                            <input type="hidden" name="ID_Insumo" value="<?= $DataInsumo['ID'] ?>">
                            <button type="submit" class="btn-eliminar" name="EliminarInsumos">Eliminar</button>
                        </form>
                    </td>
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
            <?php foreach ($DataMecanicos as $index => $mecanico): ?>
                <tr>
                    <th colspan="3" class="bg-gray text-center">FIRMA MECANICO</th>
                </tr>
                <tr>
                    <td colspan="3" class="text-center">
                        <canvas id="firmaCanvas<?= $index ?>" data-nombre="<?= $mecanico['NombreMecanico'] ?>"> </canvas>

                        <!-- IMPORTANTE -->
                        <input type="hidden" name="firma[]" id="firma<?= $index ?>">
                        <!-- ID MECÁNICO -->
                        <input type="hidden" name="id_mecanico[]" value="<?= $mecanico['ID_Mecanico'] ?>">
                       
                        <div class="firma-actions">
                            <button type="button" onclick="limpiarFirma(<?= $index ?>)">
                                Limpiar firma
                            </button>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <strong>Nombre:</strong> <?= $mecanico['NombreMecanico'] ?>
                    </td>
                    <td>
                        <strong>Fecha:</strong> <?= $mecanico['Fecha_Firma_Mecanico'] ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <button type="submit" class="btn-guardar" name="Guardar">Enviar</button>
        <button type="button" class="btn-pausar" data-id="<?= $_GET['ID'] ?>" onclick="abrirModal1(this)"> Continuar Después</button>
    </form>

    <div id="modalTrabajo" class="modal">
        <div class="modal-contenido">
            <h3>Registrar Trabajo Realizado</h3>

            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="ID_Detalle" id="ID_Detalle">
                <input type="hidden" name="ID_Trabajo" id="ID_Trabajo">
                <input type="hidden" name="DescripcionFalla" id="DescripcionFalla">
                <textarea name="DescripcionTrabajo" rows="8" style="width:100%" required></textarea>
                <label class="form-label">Subir Imágenes de la reparación</label>
                <div class="d-flex gap-2">
                    <button type="button" class="btn-tomar" id="btnTomarFoto">Tomar Foto</button>
                    <button type="button" class="btn-cargar" id="btnCargarImagen">Cargar Imágenes</button>
                </div>
                <input type="file" id="imagenesDetalle" name="imagenesDetalle[]" accept="image/*" multiple  style="display:none;">
                <div id="previewimagenesDetalle" class="mt-3 d-flex flex-wrap gap-2"></div>
                <br><br>
                <button type="submit" name="GuardarTrabajo">Guardar</button>
                <button type="button" class="btn-cancelar" onclick="cerrarModal()">Cancelar</button>
            </form>
        </div>
    </div>

    <div id="modalPausar" class="modal">
        <div class="modal-contenido">
            <h3>Pausar Actividad</h3>

            <form method="POST">
                <input type="hidden" name="ID_Orden" id="ID_Orden">

                <textarea name="DescripcionPausar" rows="8" style="width:100%" required></textarea>
                <br><br>
                <button type="submit" name="GuardarPausa">Guardar</button>
                <button type="button" class="btn-cancelar" onclick="cerrarModal1()">Cancelar</button>
            </form>
        </div>
    </div>

    <!-- LIGHTBOX DE REPARACIÓN -->
    <div id="lightbox" class="d-none position-fixed top-0 start-0 w-100 h-100 lightbox-bg">

        <div class="d-flex justify-content-center align-items-center h-100 px-3 position-relative">
            <button id="btnPrev" class="btn nav-btn position-absolute start-0"> ‹ </button>
            <img id="lightboxImg" src="" class="img-fluid rounded shadow lightbox-img">
            <button id="btnNext" class="btn nav-btn position-absolute end-0"> › </button>
        </div>

        <!-- Botón cerrar -->
        <button id="close" type="button" class="btn close-btn position-absolute top-0 end-0 m-4"> × </button>
    </div>

    <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['GuardarTrabajo'])) {
                $ID_Orden = $_GET['ID'];
                $Tipo_Trabajo = $DataOrden['Tipo_Trabajo'];
                $ID_Detalle = $_POST['ID_Detalle'];
                $ID_Trabajo = $_POST['ID_Trabajo'];
                $DescripcionFalla = $_POST['DescripcionFalla'];
                $DescripcionT = $_POST['DescripcionTrabajo'];
                $Imagenes = $_FILES['imagenesDetalle'];
                $Estado_Trabajo = 1;
                $resultado = $OrdenesTrabajoController->ActualizarOrden($ID_Trabajo, $ID_Detalle, $DescripcionT, $DescripcionFalla,$Tipo_Trabajo, $Estado_Trabajo, $Imagenes, $ID_Mantenimiento);

                if ($resultado) {
                    echo "<script>
                            alert('Trabajo guardado correctamente');
                            window.location.href = 'RealizarOrden?ID={$ID_Orden}';
                        </script>";
                } else {
                    echo "<script>
                            alert('No se pudo guardar el trabajo');
                        </script>";
                }
            }
            if (isset($_POST['GuardarPausa'])) {
                $ID_Orden = $_GET['ID'];
                $ID_Usuario = $_SESSION['ID'];
                $Estado_Trabajo = 'Pausada';
                $DescripcionT = $_POST['DescripcionPausar'];
                $resultado = $OrdenesTrabajoController->PausarOrden($ID_Orden, $ID_Usuario, $Estado_Trabajo, $DescripcionT);

                if ($resultado) {
                    echo "
                    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                    <script>
                        Swal.fire({
                            title: 'Orden de Trabajo!',
                            text: 'La  orden de trabajo ha sido pausada',
                            icon: 'info',
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
            if (isset($_POST['EliminarTrabajo'])) {
                $ID_Orden = $_GET['ID'];
                $Tipo_Trabajo = $DataOrden['Tipo_Trabajo'];
                $ID_Detalle = $_POST['ID_Detalle'];
                $ID_Trabajo = $_POST['ID_Trabajo'];
                $DescripcionT = NULL;
                $DescripcionFalla = NULL;
                $Imagenes = 'Eliminar';
                $Estado_Trabajo = 2;
                $resultado = $OrdenesTrabajoController->ActualizarOrden($ID_Trabajo, $ID_Detalle, $DescripcionT, $DescripcionFalla,$Tipo_Trabajo, $Estado_Trabajo, $Imagenes, $ID_Mantenimiento);

                if ($resultado) {
                    echo "<script>
                            alert('Trabajo Eliminado correctamente');
                            window.location.href = 'RealizarOrden?ID={$ID_Orden}';
                        </script>";
                } else {
                    echo "<script>
                            alert('No se pudo guardar el trabajo');
                        </script>";
                }
            }
            if (isset($_POST['AgregarInsumos'])) {
                $ID_Orden = $_GET['ID'];
                $ID_Insumo = $_POST['para'][0];
                $Cantidad = $_POST['Cantidad'];
                $Medida = $_POST['tipoMedida'];
                $ID_Usuario = $_SESSION['ID'];

                $resultado = $OrdenesTrabajoController->InsertarDetalleInsumoTemp($ID_Orden, $ID_Insumo, $Cantidad, $Medida, $ID_Usuario);

                if ($resultado) {
                    echo "<script>
                            window.location.href = 'RealizarOrden?ID={$ID_Orden}';
                        </script>";
                } else {
                    echo "<script>
                            alert('No se pudo guardar el trabajo');
                        </script>";
                }
            }
            if (isset($_POST['EliminarInsumos'])) {
                $ID_Orden = $_GET['ID'];
                $ID_Insumo = $_POST['ID_Insumo'];
                $resultado = $OrdenesTrabajoController->EliminarDetalleInsumoTemp($ID_Orden, $ID_Insumo);
                if ($resultado) {
                    echo "<script>
                            window.location.href = 'RealizarOrden?ID={$ID_Orden}';
                        </script>";
                } else {
                    echo "<script>
                            alert('No se pudo guardar el trabajo');
                        </script>";
                }
            }
            if (isset($_POST['Guardar'])) {
                $ID_Orden = $_GET['ID'];
                $FirmasMecanicos = $_POST['firma'];
                $Numero = $DataOrden['Numero'];
                $ID_Mecanicos = $_POST['id_mecanico'];
                $Estado_Trabajo = 'En verificacion';
                $ID_Centro = $DataOrden['ID_Centro'];
                $ID_Verifica = $DataOrden['ID_Genera'];
                $Resultado = $OrdenesTrabajoController->FirmarOrden($ID_Orden, $ID_Mecanicos, $FirmasMecanicos, $Estado_Trabajo, $ID_Centro, $ID_Verifica, $Numero, $ID_Mantenimiento);
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
        document.addEventListener('DOMContentLoaded', function () {
            new TomSelect('#select-para', {
                plugins: ['remove_button'],
                placeholder: 'Escribe nombre o codigo...',
                maxItems: 1,
                valueField: 'id',
                labelField: 'nombre',
                searchField: ['nombre', 'codigo'],
                closeAfterSelect: true,
                hideSelected: true,
                create: false,

                load: function(query, callback) {
                    if (query.length < 2) return callback();

                    fetch(`<?= $baseUrl ?>OrdenesTrabajo/BuscarInsumos?q=${encodeURIComponent(query)}`)
                        .then(r => r.json())
                        .then(data => callback(data))
                        .catch(() => callback());
                },

                onItemAdd() {
                    this.setTextboxValue('');
                    this.refreshOptions(false);
                }
            });
            
            /*============= FUNCIÓN REUTILIZABLE PARA MANEJO DE GALERÍAS =============*/
            function crearGaleria(config) {
                const {input, preview, btnFoto, btnCargar, lightbox, lightboxImg, btnNext, btnPrev, btnClose} = config;

                let imagenes = [];           
                let dt = new DataTransfer(); 
                let indexActual = 0;

                /* Botón tomar foto */
                btnFoto.addEventListener("click", () => {
                    input.removeAttribute('multiple');
                    input.setAttribute("capture", "environment");
                    input.click();
                });

                /* Botón cargar imágenes */
                btnCargar.addEventListener("click", () => {
                    input.setAttribute('multiple', 'true');
                    input.removeAttribute("capture");
                    input.click();
                });

                /* Renderizar miniaturas */
                function renderMiniaturas() {
                    preview.innerHTML = "";

                    imagenes.forEach((src, i) => {
                        const cont = document.createElement("div");
                        cont.className = "position-relative d-inline-block me-2 mb-2";

                        const img = document.createElement("img");
                        img.src = src;
                        img.className = "img-thumbnail";
                        img.style.cssText = "height: 100px; cursor: zoom-in; object-fit: cover;";
                        img.addEventListener("click", () => {
                            indexActual = i;
                            mostrarImagen();
                        });

                        /* Botón eliminar */
                        const btnEliminar = document.createElement("button");
                        btnEliminar.innerHTML = "×";
                        btnEliminar.className = "btn close-btn position-absolute top-0 end-0";
                        btnEliminar.style.cssText = `
                            border-radius: 50%;
                            width: 20px;
                            height: 20px;
                            padding: 0;
                            font-size: 14px;
                            line-height: 18px;
                        `;

                        btnEliminar.addEventListener("click", (ev) => {
                            ev.stopPropagation();

                            // ELIMINAR BASE64
                            imagenes.splice(i, 1);

                            // ELIMINAR ARCHIVO REAL
                            dt.items.remove(i);
                            input.files = dt.files;

                            // RECONSTRUIR MINIATURAS
                            renderMiniaturas();
                        });

                        cont.appendChild(img);
                        cont.appendChild(btnEliminar);
                        preview.appendChild(cont);
                    });
                }

                /* Cargar imágenes */
                input.addEventListener("change", () => {
                    Array.from(input.files).forEach(file => {

                        dt.items.add(file); 

                        const reader = new FileReader();
                        reader.onload = e => {
                            imagenes.push(e.target.result);
                            renderMiniaturas();
                        };
                        reader.readAsDataURL(file);
                    });

                    input.files = dt.files; 
                });

                /* Función mostrar imagen */
                function mostrarImagen() {
                    lightboxImg.src = imagenes[indexActual];
                    lightbox.classList.remove("d-none");
                    document.body.style.overflow = "hidden";
                }

                /* Navegación Lightbox */
                btnNext.addEventListener("click", (e) => {
                    e.stopPropagation();
                    indexActual = (indexActual + 1) % imagenes.length;
                    mostrarImagen();
                });

                btnPrev.addEventListener("click", (e) => {
                    e.stopPropagation();
                    indexActual = (indexActual - 1 + imagenes.length) % imagenes.length;
                    mostrarImagen();
                });

                btnClose.addEventListener("click", () => {
                    lightbox.classList.add("d-none");
                    document.body.style.overflow = "";
                });

                lightbox.addEventListener("click", e => {
                    if (e.target === lightbox) btnClose.click();
                });

                document.addEventListener("keydown", (e) => {
                    if (!lightbox.classList.contains("d-none")) {
                        if (e.key === "ArrowRight") btnNext.click();
                        if (e.key === "ArrowLeft") btnPrev.click();
                        if (e.key === "Escape") btnClose.click();
                    }
                });
            }

            /*=============== GALERÍA 1 – FALLA ===============*/
            crearGaleria({
                input: document.getElementById("imagenesDetalle"),
                preview: document.getElementById("previewimagenesDetalle"),
                btnFoto: document.getElementById("btnTomarFoto"),
                btnCargar: document.getElementById("btnCargarImagen"),
                lightbox: document.getElementById("lightbox"),
                lightboxImg: document.getElementById("lightboxImg"),
                btnNext: document.getElementById("btnNext"),
                btnPrev: document.getElementById("btnPrev"),
                btnClose: document.getElementById("close")
            });
        });
    </script>

    <script>
        function iniciarFirma(index) {

            const canvas = document.getElementById('firmaCanvas' + index);
            const ctx = canvas.getContext('2d');
            let dibujando = false;

            function ajustarTamanioCanvas() {

                const anchoVisible = Math.min(canvas.parentElement.offsetWidth, 380);
                const altoVisible  = 180;
                const ratio = window.devicePixelRatio || 1;

                canvas.style.width  = anchoVisible + "px";
                canvas.style.height = altoVisible + "px";

                canvas.width  = anchoVisible * ratio;
                canvas.height = altoVisible  * ratio;

                // IMPORTANTE
                ctx.lineWidth   = 3 * ratio;
                ctx.lineCap     = "round";
                ctx.strokeStyle = "#000";
            }

            ajustarTamanioCanvas();
            window.addEventListener('resize', ajustarTamanioCanvas);

            function obtenerPosicion(e) {
                const rect = canvas.getBoundingClientRect();

                const scaleX = canvas.width / rect.width;
                const scaleY = canvas.height / rect.height;

                let clientX, clientY;

                if (e.touches && e.touches.length > 0) {
                    clientX = e.touches[0].clientX;
                    clientY = e.touches[0].clientY;
                } else {
                    clientX = e.clientX;
                    clientY = e.clientY;
                }

                return {
                    x: (clientX - rect.left) * scaleX,
                    y: (clientY - rect.top)  * scaleY
                };
            }

            function guardarFirma() {
                document.getElementById('firma' + index).value =
                    canvas.toDataURL('image/png');
            }

            canvas.onmousedown = e => {
                dibujando = true;
                const p = obtenerPosicion(e);
                ctx.beginPath();
                ctx.moveTo(p.x, p.y);
            };

            canvas.onmousemove = e => {
                if (!dibujando) return;
                const p = obtenerPosicion(e);
                ctx.lineTo(p.x, p.y);
                ctx.stroke();
            };

            canvas.onmouseup = () => {
                dibujando = false;
                guardarFirma();
            };

            canvas.onmouseleave = () => dibujando = false;

            canvas.ontouchstart = e => {
                e.preventDefault();
                dibujando = true;
                const p = obtenerPosicion(e);
                ctx.beginPath();
                ctx.moveTo(p.x, p.y);
            };

            canvas.ontouchmove = e => {
                e.preventDefault();
                if (!dibujando) return;
                const p = obtenerPosicion(e);
                ctx.lineTo(p.x, p.y);
                ctx.stroke();
            };

            canvas.ontouchend = () => {
                dibujando = false;
                guardarFirma();
            };
        }

        function limpiarFirma(i){
            const canvas = document.getElementById('firmaCanvas'+i);
            const ctx = canvas.getContext('2d');
            ctx.clearRect(0,0,canvas.width,canvas.height);
            document.getElementById('firma'+i).value='';
        }

        function abrirModal(btn){ 
            let idDetalle = btn.getAttribute("data-id");
            let idTrabajo = btn.getAttribute("data-idtrabajo");
            let descripcionFalla = btn.getAttribute("data-descripcionfalla");

            document.getElementById("ID_Detalle").value = idDetalle;
            document.getElementById("ID_Trabajo").value = idTrabajo;
            document.getElementById("DescripcionFalla").value = descripcionFalla;

            document.getElementById("modalTrabajo").style.display = "block";
        }

        function abrirModal1(btn){ 
            let idDetalle = btn.getAttribute("data-id");

            document.getElementById("ID_Orden").value = idDetalle;

            document.getElementById("modalPausar").style.display = "block";
        }

        function cerrarModal(){
            document.getElementById("modalTrabajo").style.display = "none";
        }

        function cerrarModal1(){
            document.getElementById("modalPausar").style.display = "none";
        }

        // ==================== VALIDACIÓN AL ENVIAR ====================
        const formEnviar = document.getElementById('formEnviar');

        function canvasVacio(canvas){
            const ctx = canvas.getContext('2d');
            const pixel = ctx.getImageData(0,0,canvas.width,canvas.height).data;
            return !pixel.some(channel => channel !== 0);
        }

        if (formEnviar) {
            formEnviar.addEventListener('submit', function (e) {

                let totalFirmas = <?= count($DataMecanicos) ?>;
                let firmasValidas = 0;

                for (let i = 0; i < totalFirmas; i++) {

                    const canvas = document.getElementById('firmaCanvas'+i);
                    const input  = document.getElementById('firma'+i);

                    if (!canvas) continue;

                    const nombre = canvas.dataset.nombre; // ← AQUÍ

                    if (canvasVacio(canvas)) {
                        e.preventDefault();
                        alertify.error("El mecánico " + nombre + " no ha firmado.");
                        return false;
                    }

                    input.value = canvas.toDataURL('image/png');
                    firmasValidas++;
                }


                if (firmasValidas === 0) {
                    e.preventDefault();
                    alertify.error("Debe firmar antes de enviar.");
                    return false;
                }

                return true;
            });
        }
    </script>

    <script>
        <?php foreach ($DataMecanicos as $index => $mecanico): ?>
            iniciarFirma(<?= $index ?>);
        <?php endforeach; ?>
    </script>
</body>
</html>
