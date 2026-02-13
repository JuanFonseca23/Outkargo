<?php
require_once "App/Views/Templates/Layouts/Header.php";
include_once "App/Controllers/OrdenesCompraController.php";

$OrdenesCompraController = new OrdenesCompraController;

// Recuperamos parámetros (por POST o GET)
$Asunto = $_POST['Mensaje'] ?? $_GET['Mensaje'] ?? '';
$ID_Solicitud = $_POST['ID_Solicitud'] ?? $_GET['ID_Solicitud'] ?? null;
$Numero = $_POST['Numero'] ?? $_GET['Numero'] ?? null;

// Escapamos para seguridad HTML
$Asunto = htmlspecialchars($Asunto);
$ID_Solicitud = htmlspecialchars($ID_Solicitud);
$Numero = htmlspecialchars($Numero);

if ($_SERVER['HTTP_HOST'] == 'localhost') {
    $baseUrl = 'http://localhost/OUTKARGO/';
} else {
    $baseUrl = 'https://outkargo.com.co/';
}
?>

<!-- Tom Select: Librerías CSS y JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.bootstrap5.min.css">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
<!-- CSS personalizado -->
<style>
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

    .item {
        background-color: #0d6efd !important;
        color: white !important;
        border-radius: 16px !important;
        padding: 5px 12px !important;
        font-size: 0.95rem !important;
        margin: 2px 4px 2px 0 !important;
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
</style>

<div class="container d-flex justify-content-center align-items-start min-vh-100 pt-5">
    <div class="card shadow-lg border-0" style="max-width: 700px; width: 100%; border-radius: 12px;">
        <div class="card-header bg-white border-0 pt-4 pb-3">
            <h4 class="mb-0 text-center">Nuevo mensaje</h4>
        </div>

        <div class="card-body p-4">
            <form method="POST" enctype="multipart/form-data">

                <!-- Campo Para -->
                <div class="mb-3">
                    <label class="form-label fw-medium text-muted">Para</label>
                    <select name="para[]" id="select-para" multiple required></select>
                </div>

                <!-- Asunto -->
                <div class="mb-3">
                    <label class="form-label fw-medium text-muted">Asunto</label>
                    <input type="text" name="asunto"
                        class="form-control form-control-lg border-0 border-bottom rounded-0"
                        value="<?= $Asunto ?>" readonly required>
                </div>

                <hr class="my-4">

                <!-- Mensaje -->
                <div class="mb-4">
                    <textarea name="mensaje" class="form-control" rows="7"
                        placeholder="Escribe tu mensaje aquí..." required
                        style="resize:none;border:none;box-shadow:none;"></textarea>
                </div>

                <!-- ================= ADJUNTO ================= -->
                <div class="mb-4">

                <?php if ($ID_Solicitud): ?>

                    <label class="form-label fw-medium text-muted">Archivo adjunto</label>

                    <div class="adjunto-box">
                        <div>
                            <div class="adjunto-nombre">
                                Solicitud_<?= $Numero ?>.pdf
                            </div>
                        </div>

                        <a href="<?= $baseUrl ?>OrdenesCompra/VerSolicitud?ID=<?= $ID_Solicitud ?>"
                           target="_blank" class="btn btn-outline-primary btn-sm ms-auto"> Ver
                        </a>
                    </div>

                    <!-- Enviar URL al backend -->
                    <input type="hidden"
                           name="adjunto_url"
                           value="<?= $baseUrl ?>OrdenesCompra/VerSolicitud?ID=<?= $ID_Solicitud ?>">

                <?php else: ?>

                    <label class="form-label fw-medium text-muted">Adjuntar archivo (opcional)</label>
                    <input type="file" name="archivo" class="form-control">

                <?php endif; ?>

                </div>

                <!-- ID_Solicitud oculto -->
                <?php if ($ID_Solicitud): ?>
                    <input type="hidden" name="ID_Solicitud" value="<?= $ID_Solicitud ?>">
                <?php endif; ?>

                <!-- Botón -->
                <div class="d-flex justify-content-end border-top pt-3">
                    <button type="submit" class="btn btn-primary btn-lg px-5 rounded-pill">
                        Enviar
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $ID_Correos = $_POST['para'] ?? [];       
        $Asunto1    = $_POST['asunto'] ?? '';
        $Mensaje    = $_POST['mensaje'] ?? '';
        $Link       = $_POST['adjunto_url'] ?? null;
        $OrdenesCompraController -> EnviarCorreos($ID_Solicitud, $ID_Correos, $Asunto1, $Mensaje, $Link);
    }
?>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        new TomSelect('#select-para', {
            plugins: ['remove_button'],
            placeholder: 'Escribe nombre o correo...',
            maxItems: null,
            valueField: 'id',
            labelField: 'nombre',
            searchField: ['nombre', 'email'],
            closeAfterSelect: true,
            hideSelected: true,
            create: false,

            load: function(query, callback) {
                if (query.length < 2) return callback();

                fetch(`<?= $baseUrl ?>OrdenesCompra/BuscarDestinatarios?q=${encodeURIComponent(query)}`)
                    .then(r => r.json())
                    .then(data => callback(data))
                    .catch(() => callback());
            },

            onItemAdd() {
                this.setTextboxValue('');
                this.refreshOptions(false);
            }
        });

    });
</script>

<?php require "App/Views/Templates/Layouts/Footer.php"; ?>
