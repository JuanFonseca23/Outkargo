<?php
    session_start();
    if (empty($_SESSION['ID'])) {
        header("location:../IniciarSesion");
        exit;
    }
    include_once "App/Controllers/UsuarioController.php";
    include_once "App/Controllers/OrdenesCompraController.php";

    $UsuariosController = new UsuarioController();
    $OrdenesCompraController = new OrdenesCompraController();

    $DataSolicitud = $OrdenesCompraController->VerSolicitud($_GET['ID']);
    
    $Filas = $OrdenesCompraController->MostrarDetallesSolicitud($_GET['ID']);
    $ID_Solicitud = $_GET['ID'];

    date_default_timezone_set('America/Bogota');
    $Fecha = date("d/m/Y");
    $CantidadDetalles = is_array($Filas) ? count($Filas) : 0;

    if ($DataSolicitud['Estado'] === 'REVISADO') {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Atención',
                    text: 'Ya has firmado esta solicitud.',
                    icon: 'warning',
                    confirmButtonText: 'Aceptar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'InicioSolicitud'; 
                    }
                });
            });
        </script>";
        exit;
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
        table{
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            border: 2px solid #000;
        }

        th, td{
            border: 2px solid #000;
            padding: 6px;
        }

        th{
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

        /* ===== FIRMA DIGITAL ===== */
        .tabla-firma {
            width: 420px;             
            /* margin: 0 auto 12px auto;  centrada */
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

        /* ===== FILA APROBADA ===== */
        .fila-aprobada {
            background-color: #d4edda !important;   /* verde suave */
        }

        .fila-aprobada td,
        .fila-aprobada th {
            background-color: #d4edda !important;
        }

        /* ===== FILA RECHAZADA ===== */
        .fila-rechazada {
            background-color: #f8d7da !important;   /* rojo suave */
        }

        .fila-rechazada td,
        .fila-rechazada th {
            background-color: #f8d7da !important;
        }

        /* ===== RESPONSIVE ===== */
        @media screen and (max-width: 768px) {
            body{
                font-size: 9px;
                padding: 7px;
            }

            table{
                margin-bottom: 2px;
                border: 1px solid #000;
            }

            th, td{
                border: 1px solid #000;
                padding: 4px;
            }

            .titulo{
                font-size: 11px;
            }

            .logo img{
                max-width: 110px;
            }

            .btn-add,
            .btn-guardar,
            .btn-remove{
                font-size: 10px;
                padding:4px 8px;
            }

            .tabla-firma {
                width: 100%;
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
                font-size: 8.5px;
                padding: 5px;
            }

            th, td{
                padding: 3px;
            }

            .titulo{
                font-size: 10px;
            }

            .logo img{
                max-width: 95px;
            }

            .btn-add,
            .btn-guardar,
            .btn-remove{
                font-size: 9px;
                padding: 3px 7px;
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
                font-size: 8px;
                padding: 4px;
            }

            th, td{
                padding: 2px;
            }

            .titulo{
                font-size: 9px;
            }

            .logo img{
                max-width: 85px;
            }

            .btn-add,
            .btn-guardar,
            .btn-remove{
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
    <table>
        <tr>
            <th rowspan="3" class="logo"><img src="../App/Views/Img/Outkargo.png"></th>
            <th rowspan="3" class="titulo">SOLICITUD DE COMPRA DE REPUESTOS E INSUMOS</th>
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
    <table>
        <tr>
            <th>Solicitante</th>
            <td colspan="2"><?= $DataSolicitud['NombreSolicita'] ?></td>
            <th>No. Orden</th>
            <td style="text-align: center;"><?= $DataSolicitud['Numero'] ?></td>
            <th>Fecha</th>
            <td><?= $DataSolicitud['Fecha_Solicitud'] ?></td>
        </tr>
        <tr>
            <th colspan="2">Autorizado por:</th>
            <td colspan="2"><?= $_SESSION['NombreCompleto'] ?></td>
            <th >Centro de trabajo</th>
            <td colspan="2"><?= $DataSolicitud['CentroSolicita'] ?></td>
        </tr>
        <tr>
            <th>Descripción</th>
            <td colspan="6"><?= $DataSolicitud['Descripcion'] ?></td>
        </tr>
    </table>

    <!-- DETALLES -->
    <form method="POST" id="formEnviar">
        <div class="tabla-wrapper">
            <table id="tablaDetalles">
                <thead>
                    <tr><th colspan="8" class="bg-gray text-center">DETALLE DE REPUESTOS / INSUMOS</th></tr>
                    <tr>
                        <th>#</th>
                        <th style="width: 70px;">Cantidad</th>
                        <th>Descripción</th>
                        <th>Medidas</th>
                        <th style="width: 110px;">Precio Unitario</th>
                        <th style="width: 110px;">Precio Total</th>
                        <th style="width: 50px;">Aprobado</th>
                        <th style="width: 50px;">Rechazado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $Numero = 0;
                        $SumaTotal = 0;
                        if ($Filas) {
                            foreach ($Filas as $Fila) {
                                if ($Fila['Cantidad'] > 0) {
                                    $Numero = $Numero + 1;
                                    $SumaTotal += $Fila['Precio_Total']; 
                    ?>
                    <tr data-precio="<?= $Fila['Precio_Total'] ?>">
                        <input type="hidden" name="detalle_id[]" value="<?= $Fila['ID'] ?>">
                        <input type="hidden" name="estado[<?= $Fila['ID'] ?>]" class="input-estado"  value="APROBADO">

                        <th><?= $Numero ?></th>
                        <td style="text-align: center;"><?= $Fila['Cantidad'] ?></td>
                        <td style="text-align: center;"><?= $Fila['Descripcion'] ?></td>
                        <td style="text-align: center;"><?= $Fila['Medidas'] ?></td>
                        <td style="text-align: right;">$ <?= number_format($Fila['Precio_Unitario'], 2, ',', '.') ?></td>
                        <td style="text-align: right;">$ <?= number_format($Fila['Precio_Total'], 2, ',', '.') ?></td>

                        <td style="text-align: center;"> 
                            <input type="checkbox" class="chk-aprobado" data-id="<?= $Fila['ID'] ?>">
                        </td>

                        <td style="text-align: center;">
                            <input type="checkbox" class="chk-rechazado" data-id="<?= $Fila['ID'] ?>">
                        </td>
                    </tr>

                    <?php
                                }
                            }
                        }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="5" class="text-right">TOTAL</th>
                        <td colspan="3" style="text-align: right;">
                            $ <span id="totalGeneral"><?= number_format($SumaTotal, 2, ',', '.') ?></span>
                        </td>

                    </tr>
                </tfoot>
            </table>
        </div>
    
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
        <input type="hidden" name="Tipo" value="3">
        <button type="submit" class="btn-guardar">Enviar</button>
    </form>

    <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($_POST['Tipo'] === "3") {
                $Firma       = $_POST['firma'] ?? '';
                $ID_Autoriza = $_SESSION['ID'];
                $Numero_Orden = $DataSolicitud['Numero'];
                $NombreCreo  = $_SESSION['Nombre1'];
                $Estados     = $_POST['estado'] ?? [];
                $OrdenesCompraController->AutorizarSolicitudCompra($ID_Solicitud, $Estados, $Firma, $ID_Autoriza, $NombreCreo, $Numero_Orden);
            }
        }
    ?>

    <script>
        function recalcularTotal() {
            let total = 0;

            document.querySelectorAll('#tablaDetalles tbody tr').forEach(row => {
                const precio = parseFloat(row.dataset.precio) || 0;
                const aprobado = row.querySelector('.chk-aprobado');
                const rechazado = row.querySelector('.chk-rechazado');

                if (!aprobado || !rechazado) return;

                if (aprobado.checked && !rechazado.checked) {
                    total += precio;
                }
            });

            document.getElementById('totalGeneral').innerText =
                total.toLocaleString('es-CO', { minimumFractionDigits: 2 });
        }

        // Control exclusivo: solo uno puede estar activo
        document.getElementById('tablaDetalles').addEventListener('change', function(e) {

            const fila = e.target.closest('tr');
            if (!fila) return;

            const aprobado  = fila.querySelector('.chk-aprobado');
            const rechazado = fila.querySelector('.chk-rechazado');

            const id = e.target.dataset.id;
            const inputEstado = document.querySelector(
                'input[name="estado[' + id + ']"]'
            );

            if (!inputEstado) return;

            if (e.target.classList.contains('chk-aprobado')) {
                rechazado.checked = !aprobado.checked;
                inputEstado.value = aprobado.checked ? 'APROBADO' : 'RECHAZADO';
            }

            if (e.target.classList.contains('chk-rechazado')) {
                aprobado.checked = !rechazado.checked;
                inputEstado.value = rechazado.checked ? 'RECHAZADO' : 'APROBADO';
            }

            // ===== EFECTO VISUAL =====
            fila.classList.remove('fila-aprobada', 'fila-rechazada');

            if (rechazado.checked) {
                fila.classList.add('fila-rechazada');
            } 
            else if (aprobado.checked) {
                fila.classList.add('fila-aprobada');
            }

            recalcularTotal();
        });

        // Inicializar total al cargar
        recalcularTotal();

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
        const cantidadDetalles = <?= $CantidadDetalles ?>;
        const formEnviar = document.getElementById('formEnviar');

        if (formEnviar) {
            formEnviar.addEventListener('submit', function (e) {

                if (cantidadDetalles === 0) {
                    e.preventDefault();
                    alertify.error("Debe agregar al menos un repuesto o insumo antes de enviar la solicitud.");
                    return false;
                }

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
