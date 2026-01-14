<?php
    session_start();
    if (empty($_SESSION['ID'])) {
        header("location:../IniciarSesion");
        exit;
    }
    include_once "App/Controllers/UsuarioController.php";
    include_once "App/Controllers/OrdenesCompraController.php";

    $UsuariosController = new UsuarioController();
    $OrdenesCompraController = new OrdenesCompraController;

    date_default_timezone_set('America/Bogota');
    $Fecha = date("d/m/Y");
    $ID_Solicitud = $_GET['ID'];


    $Filas = $OrdenesCompraController->DetallesTempSolicitudCompra($_SESSION['ID']);
    $CantidadDetalles = is_array($Filas) ? count($Filas) : 0; 

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($_POST['Tipo'] === "1") {
            $ID_Solicitante = $_SESSION['ID'];
            $NombreCreo = $_SESSION['Nombre1'];
            $Cantidad = $_POST['Cantidad'];
            $Descripcion = $_POST['Descripcion1'];
            $Medidas = trim($_POST['Medidas'] ?? '') ?: NULL;
            $Precio_Unitario = isset($_POST['Precio_Unitario']) && $_POST['Precio_Unitario'] !== '' ? floatval($_POST['Precio_Unitario']) : 0;
            $Precio_Total = isset($_POST['Precio_Total']) && $_POST['Precio_Total'] !== ''? floatval($_POST['Precio_Total']) : 0;
            if ($OrdenesCompraController->InsertarSolicitudTemp($Cantidad, $Descripcion, $Medidas, $Precio_Unitario, $Precio_Total, $ID_Solicitante)) {
                header("Location: Solicitud?TipoSolicitud=" . $TipoSolicitud . (isset($OverhaulingNumero) ? "&OverhaulingNumero=" . $OverhaulingNumero : ""));
                exit;
            } else {
                echo "<script>alert('Error al agregar el repuesto temporal.');</script>";
            }
        }
        if ($_POST['Tipo'] === "2") {
            $ID_Solicitante = $_SESSION['ID'];
            $ID = $_POST['ID'];

            if ($OrdenesCompraController->EliminarSolicitudTemp($ID_Solicitante, $ID)) {
                header("Location: Solicitud?TipoSolicitud=" . $TipoSolicitud . (isset($OverhaulingNumero) ? "&OverhaulingNumero=" . $OverhaulingNumero : ""));
                exit;
            } else {
                echo "<script>alert('Error al eliminar el repuesto temporal.');</script>";
            }
        }
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
        .btn-add{
            background:#0d6efd;
            color:#fff;
            border: 1px solid #000;
            border-radius: 5px;
            padding:6px 10px;
            cursor:pointer;
        }
        .btn-remove{
            background:#dc3545;
            color:#fff;
            border: 1px solid #000;
            border-radius: 5px;
            padding:6px 10px;
            cursor:pointer;
        }
        .btn-guardar{
            background:#198754;
            color:#fff;
            border: 1px solid #000;
            border-radius: 5px;
            padding:6px 10px;
            cursor:pointer;
        }

        /* ===== FIRMA DIGITAL ===== */
        #firmaCanvas {
            border: 1px solid #ccc;
            width: 100%;
            min-height: 220px;
            touch-action: none;
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

        /* ===== RESPONSIVE ===== */
        @media screen and (max-width: 768px) {
            body{
                font-family: Arial, Helvetica, sans-serif;
                font-size: 9px;
                margin: 0;
                padding: 7px;
                color: #000;
            }

            .text-center{text-align:center;}
            .text-right{text-align:right;}
            .text-red{color:#c00000;font-weight:bold;}
            .bg-gray{background:#e6e6e6;}

            table{
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 2px;
                border: 1px solid #000;
            }
            th, td{
                border: 1px solid #000;
                padding: 4px;
            }
            th{
                background: #f0f0f0;
            }
            .titulo{
                font-size: 11px;
                font-weight: bold;
                text-align: center;
            }
            .logo img{
                max-width: 110px;
            }

            .btn-add{
                background:#0d6efd;
                color:#fff;
                border: 1px solid #000;
                border-radius: 5px;
                font-size: 10px;
                padding:4px 8px;
                cursor:pointer;
            }

            .btn-guardar{
                background:#ff5000;
                color:#fff;
                border: 1px solid #000;
                border-radius: 5px;
                font-size: 10px;
                padding:4px 8px;
                cursor:pointer;
            }

            .btn-remove{
                background:#dc3545;
                color:#fff;
                border: 1px solid #000;
                border-radius: 5px;
                font-size: 10px;
                padding:4px 8px;
                cursor:pointer;
            }

            #firmaCanvas{
                width:100%;
                height:120px;
                border:1px solid #000;
                background:#fff;
                touch-action:none;
            }
            .firma-actions{
                margin-top:6px;
            }
            .firma-actions button{
                padding:3px 9px;
                border:1px solid #000;
                border-radius: 5px;
                font-size: 10px;
                font-weight: bold;
                background:#f0f0f0;
                cursor:pointer;
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
            <td><?= $_SESSION['NombreCompleto'] ?></td>
            <th>Centro de trabajo</th>
            <td><?= $_SESSION['Centro'] ?></td>
            <th style="width: 70px;">No. Orden</th>
            <td style="width: 70px;" class="text-red text-center">------</td>
            <th style="width: 70px;">Fecha</th>
            <td style="width: 70px;"><?= $Fecha ?></td>
        </tr>
        <tr>
            <th>Descripción</th>
            <td colspan="7"><?= $Descripcion ?></td>
        </tr>
    </table>

    <!-- INGREO DE DATOS -->
    <form method="post" id="formAgregar">
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th style="width: 70px;">Cantidad</th>
                <th>Descripción</th>
                <th>Medidas</th>
                <th style="width: 110px;">Precio Unitario</th>
                <th style="width: 110px;">Precio Total</th>
                <th style="width: 80px;">Acción</th>
            </tr>
        </thead> 
        <tbody>
            <tr>
                <td></td>
                <td>
                    <input type="number" name="Cantidad" class="cantidad"
                           min="1" required oninput="calcularTotal(this)">
                </td>
                <td>
                    <input type="text" name="Descripcion1" required>
                </td>
                <td><input type="text" name="Medidas"></td>
                <td>
                    <input type="number" name="Precio_Unitario" class="precio-unitario"
                           oninput="calcularTotal(this)">
                </td>
                <td>
                    $<span class="precio-total">0.00</span>
                    <input type="hidden" name="Precio_Total">
                </td>
                <td>
                    <button type="submit" class="btn-add">Agregar</button>
                </td>
            </tr>
        </tbody>
    </table>
    <input type="hidden" name="Tipo" value="1">
</form>


    <!-- DETALLES -->
    <table>
        <thead>
            <tr><th colspan="7" class="bg-gray text-center">DETALLE DE REPUESTOS / INSUMOS</th></tr>
            <tr>
                <th>#</th>
                <th style="width: 70px;">Cantidad</th>
                <th>Descripción</th>
                <th>Medidas</th>
                <th style="width: 110px;">Precio Unitario</th>
                <th style="width: 110px;">Precio Total</th>
                <th style="width: 80px;">Acción</th>
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
            <tr>
                <th><?= $Numero ?></th>
                <td style="text-align: center;"><?= $Fila['Cantidad'] ?></td>
                <td style="text-align: center;"><?= $Fila['Descripcion'] ?></td>
                <td style="text-align: center;"><?= $Fila['Medidas'] ?></td>
                <td style="text-align: right;">$ <?= number_format($Fila['Precio_Unitario'], 2, ',', '.') ?></td>
                <td style="text-align: right;">$ <?= number_format($Fila['Precio_Total'], 2, ',', '.') ?></td>
                <form method="post">
                    <input type="hidden" name="ID" value="<?= $Fila['ID'] ?>">
                    <input type="hidden" name="Tipo" value="2">
                    <td style="text-align: center;">
                        <button type="submit" class="btn-remove">Eliminar</button>
                    </td>
                </form>
            
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
                <td colspan="2" style="text-align: right;">$ <?= number_format($SumaTotal, 2, ',', '.') ?></td>
            </tr>
        </tfoot>
    </table>

    
    <!-- FIRMA -->
    <table >
        <tr>
            <th colspan="2" class="bg-gray text-center">FIRMA DEL SOLICITANTE</th>
        </tr>
        <tr>
            <td colspan="2" data-label="Firma">
                <canvas id="firmaCanvas"></canvas>
                <div class="firma-actions">
                <button type="button" onclick="limpiarFirma()">Limpiar firma</button>
                </div>
            </td>
        </tr>
        <tr>
            <td data-label="Nombre"><strong>Nombre:</strong><?= $_SESSION['NombreCompleto'] ?></td>
            <td data-label="Fecha"><strong>Fecha:</strong><?= $Fecha ?></td>
        </tr>
    </table>

    <form method="POST" id="formEnviar">
        <input type="hidden" name="firma" id="firma">
        <input type="hidden" name="Tipo" value="3">
        <button type="submit" class="btn-guardar">Enviar</button>
    </form>

    <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($_POST['Tipo'] === "3") {
                $Firma = $_POST['firma'];
                $ID_Solicitante = $_SESSION['ID'];
                $ID_Centro = $_SESSION['NoCentro'];
                $NombreCreo = $_SESSION['Nombre1'];
                $Fecha_Solicitud = $Fecha;
                $Descripcion;
                $OrdenesCompraController->InsertarSolicitudCompra($ID_Solicitante, $ID_Centro, $Firma, $Fecha_Solicitud, $NombreCreo, $Descripcion);
            } 
        }
    ?>

    <script>
        function calcularTotal(el) {
            const fila = el.closest("tr");
            const cantidad = parseFloat(fila.querySelector(".cantidad").value) || 0;
            const precio = parseFloat(fila.querySelector(".precio-unitario").value) || 0;
            const total = cantidad * precio;

            fila.querySelector(".precio-total").textContent = total.toFixed(2);
            fila.querySelector("input[name='Precio_Total']").value = total.toFixed(2);
        }

        const canvas = document.getElementById('firmaCanvas');
const ctx = canvas.getContext('2d');
let dibujando = false;

// ================== CONFIGURACIÓN DE TAMAÑO (IMPORTANTE) ==================
function ajustarTamanioCanvas() {

    // Tamaño visible mínimo (puedes ajustarlo)
    const anchoVisible = canvas.parentElement.offsetWidth || 350;
    const altoVisible  = 220;

    canvas.style.width  = anchoVisible + "px";
    canvas.style.height = altoVisible + "px";

    const ratio = window.devicePixelRatio || 1;

    canvas.width  = anchoVisible * ratio;
    canvas.height = altoVisible * ratio;

    ctx.setTransform(ratio, 0, 0, ratio, 0, 0);

    // Estilo del trazo
    ctx.lineWidth   = 3.2;   // más grueso para móvil
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
