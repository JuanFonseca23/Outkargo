<?php
    session_start();
    if (empty($_SESSION['ID'])) {
        header("location:../IniciarSesion");
        exit;
    }

    include_once "App/Controllers/UsuarioController.php";
    include_once "App/Controllers/MantenimientosController.php";

    $UsuariosController = new UsuarioController();
    $MantenimientoController = new MantenimientosController();

    $Tecnicos = $MantenimientoController->ObtenerTecnicosMantenimiento($_GET['ID']);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>OUTKARGO - Administrador</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.5.3/signature_pad.min.js"></script>
</head>
<body>  

    <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['Tipo']) && $_POST['Tipo'] == "1") {
                $ID_Mantenimiento = isset($_GET['ID']) ? htmlspecialchars($_GET['ID']) : '';
                $Firmas = isset($_POST['firmasMecanicos']) ? $_POST['firmasMecanicos'] : [];
                $MantenimientoController->FirmarMantenimiento($ID_Mantenimiento, $Firmas);
            }
        }        
    ?>   
    <h2>Firmas de Técnicos</h2>
    <form method="post" id="firmasForm" enctype="multipart/form-data">
        <!-- Técnicos-->
        <div id="firmasMecanicos">
            <?php foreach ($Tecnicos as $i => $tecnico): ?>
                <div>
                    <h3><?= htmlspecialchars($tecnico['Nombre_Mecanico']) ?></h3>
                    <canvas id="firmasMecanico_<?= $tecnico['ID_Mecanico'] ?>" width="400" height="200" style="border:2px solid #000; border-radius:5px;"></canvas>
                    <input type="hidden" name="firmasMecanicos[<?= $tecnico['ID_Mecanico'] ?>]" id="firmaMecanicoInput_<?= $tecnico['ID_Mecanico'] ?>">
                    <button type="button" onclick="clearSignature('firmasMecanico_<?= $tecnico['ID_Mecanico'] ?>')">Borrar</button>
                    <input type="hidden" name="Tipo" value="1">
                </div>
                <hr>
            <?php endforeach; ?>
        </div>
        
        <br>
        <button type="submit">Guardar Firmas</button>
    </form>

    <script>
        const pads = {};

        function initSignaturePad(canvasId, inputId, nombre) {
            let canvas = document.getElementById(canvasId);
            let pad = new SignaturePad(canvas);
            pads[canvasId] = { pad: pad, input: document.getElementById(inputId), nombre: nombre };
        }

        function clearSignature(canvasId) {
            if (pads[canvasId]) {
                pads[canvasId].pad.clear();
            }
        }

        
        // Inicializar técnicos secundarios
        <?php foreach ($Tecnicos as $tecnico): ?>
            initSignaturePad("firmasMecanico_<?= $tecnico['ID_Mecanico'] ?>", "firmaMecanicoInput_<?= $tecnico['ID_Mecanico'] ?>", "<?= htmlspecialchars($tecnico['Nombre_Mecanico']) ?>");
        <?php endforeach; ?>

        // Al enviar formulario -> guardar las firmas
        document.getElementById("firmasForm").onsubmit = function() {
            const faltantes = [];

            for (const key in pads) {
                const { pad, input, nombre } = pads[key];
                if (!pad.isEmpty()) {
                    input.value = pad.toDataURL();
                } else {
                    faltantes.push(nombre);
                }
            }

            if (faltantes.length > 0) {
                alertify.error("Faltan las firmas de: " + faltantes.join(", "));
                return false;
            }

            return true;
        };
    </script>
</body>
</html>