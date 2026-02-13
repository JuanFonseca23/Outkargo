<?php
require_once "App/Views/Templates/Layouts/Header.php";
include_once "App/Controllers/CentroDeTrabajoController.php";
include_once "App/Controllers/OrdenesCompraController.php";

$CentrosDeTrabajo = new CentroDeTrabajoController;
$OrdenesCompraController = new OrdenesCompraController();
$ListaCentrosDeTrabajo = $CentrosDeTrabajo->TraerCentrosDeTrabajo();

$ID_Centro = isset($_GET['centro']) ? $_GET['centro'] : $_SESSION['NoCentro'];
$No_Solicitudes = $OrdenesCompraController->ContarSolicitudesPorCentro($ID_Centro);
$Solicitudes = $OrdenesCompraController->leerSolicitudesCompra($ID_Centro);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['Tipo'] === "SolicitudCompra") {

        $TipoSolicitud = $_POST['TipoSolicitud'];

        // Mensaje dinámico
        if ($TipoSolicitud === 'Overhauling') {
            $OverhaulingNumero = $_POST['OverhaulingNumero'] ?? '';
            $redirectUrl = "Solicitud?TipoSolicitud=Overhauling&OverhaulingNumero={$OverhaulingNumero}";
            $mensaje = " Se creó correctamente la solicitud de compra asociada al overhauling: <strong>Número:</strong> {$OverhaulingNumero}<br>";
        } else {
            $redirectUrl = "Solicitud?TipoSolicitud=Mantenimiento";
            $mensaje = " Se creó correctamente la solicitud de compra de mantenimiento. ";
        }

        echo "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
            Swal.fire({
                title: 'Solicitud creada exitosamente',
                html: `$mensaje`,
                icon: 'success',
                showCancelButton: true,
                confirmButtonText: 'Continuar',
                cancelButtonText: 'Cancelar',
                allowOutsideClick: false,
                allowEscapeKey: false
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '{$redirectUrl}';
                }
            });
        </script>";
    }
}
?>

<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-6 col-xl-3">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <img width="50" height="50" src="https://img.icons8.com/ink/50/000020/purchase-order.png" alt="purchase-order"/>
                <div class="ms-3">
                    <p class="mb-2" style="color: #000020;">Solicitudes Realizadas</p>
                    <h6 class="mb-0" style="color: #000020;"><?= $No_Solicitudes['Nosolicitudes'] ?></h6>
                </div>
            </div>
        </div>
        <a class="col-sm-6 col-xl-3" data-bs-toggle="modal" data-bs-target="#NumerDocumentoModal">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <img width="50" height="50" src="https://img.icons8.com/wired/64/000020/purchase-order.png" alt="purchase-order"/>
                <div class="ms-3">
                    <p class="mb-2" style="color: #000020;">Realizar Solicitud</p>
                </div>
            </div>
        </a>
        <a class="col-sm-6 col-xl-3" href="#"></a>
        <a class="col-sm-6 col-xl-3" href="#"></a>
    </div>
</div>

<div class="container-fluid pt-4 px-4">
    <div class="bg-light text-center rounded p-4">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2 mb-4">
            <form method="get" action="" class="mb-0">
                <div class="d-flex align-items-center flex-wrap gap-2">
                    <h6 class="mb-0">Solicitudes Realizadas |</h6>
                    <select name="centro" 
                            class="form-select form-select-sm w-auto"
                            onchange="this.form.submit()">
                        <?php
                            if (!empty($ListaCentrosDeTrabajo)) {
                                foreach ($ListaCentrosDeTrabajo as $centro) {
                                    $idCentro = $centro['ID'];
                                    $nombreCentro = htmlspecialchars($centro['Nombre']);
                                    $selected = ($idCentro == $ID_Centro) ? 'selected' : '';
                                    echo "<option value=\"$idCentro\" $selected>$nombreCentro</option>";
                                }
                            } else {
                                echo '<option>No hay centros</option>';
                            }
                        ?>
                    </select>
                </div>
            </form>

            <!-- Enlaces de acción -->
            <div class="text-md-end text-center mt-2 mt-md-0">
                <a href="#" class="text-decoration-none me-2 text-primary fw-bold">Ver Todas</a>
                <span class="text-muted">|</span>
                <a href="#" class="text-decoration-none ms-2 text-success fw-bold">Descargar Excel</a>
            </div>
        </div>

        <!-- Tabla -->
        <div class="table-responsive">
            <table class="table text-start align-middle table-bordered table-hover mb-0" id="myTable">
                <thead>
                    <tr class="text-dark">
                        <th scope="col" class="text-center">Numero</th>
                        <th scope="col" class="text-center">Fecha Realizado</th>
                        <th scope="col" class="text-center">Solicita</th>
                        <th scope="col" class="text-center">Descripcion</th>
                        <th scope="col" class="text-center">Estado</th>
                        <th scope="col" class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($Solicitudes) {
                        foreach ($Solicitudes as $Solicitud) {
                            if ($Solicitud['Estado'] == 'REVISADO') {
                                $progressBarClass = 'bg-success';
                                $estadoTexto = 'Revisado';
                            } elseif ($Solicitud['Estado'] == 'PENDIENTE') {
                                $progressBarClass = 'bg-warning';
                                $estadoTexto = 'Pendiente';
                            }
                    ?>
                            <tr>
                                <td class="text-center"><?= htmlspecialchars($Solicitud['Numero']) ?></td>
                                <td class="text-center"><?= htmlspecialchars($Solicitud['Fecha_Solicitud']) ?></td>
                                <td class="text-center"><?= htmlspecialchars($Solicitud['NombreUsuario']) ?></td>
                                <td class="text-center"><?= htmlspecialchars($Solicitud['Descripcion']) ?></td>
                                <td>
                                    <div class="progress">
                                        <div id="progressStatus" class="progress-bar <?= $progressBarClass ?>" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                            <?=  $estadoTexto ?>
                                        </div>
                                    </div>
                                </td>
                                <td width="200" class="text-center">
                                    <a class="btn btn-sm btn-primary" target="_blank" href="VerSolicitud?ID=<?= urlencode(htmlspecialchars($Solicitud['ID'])) ?>">
                                        <img width="20" height="20" src="https://img.icons8.com/material-outlined/24/ffffff/visible--v1.png" alt="Ver" />
                                    </a>
                                    <?php if ( $Solicitud['Estado'] != 'REVISADO') { ?>
                                        <a class="btn btn-sm btn-dark" target="_blank" href="AutorizarSolicitud?ID=<?= urlencode(htmlspecialchars($Solicitud['ID'])) ?>">
                                            <img width="20" height="20" src="https://img.icons8.com/sf-regular-filled/24/ffffff/autograph.png" alt="autograph"/>
                                        </a>
                                    <?php } ?>
                                </td>
                            </tr>                       

                    <?php
                        }
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Ingreso de datos -->
<div class="modal fade" id="NumerDocumentoModal" tabindex="-1" aria-labelledby="NumerDocumentoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">                
                <h5 class="modal-title text-white" id="NumerDocumentoModalLabel">Solicitud De Compra</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form id="documentFormIngreso" method="POST">
                    <div class="mb-3">
                        <div class="mb-3">
                            <label for="TipoSolicitud" class="form-label"> Tipo de solicitud</label>
                            <select class="form-select" id="TipoSolicitud" name="TipoSolicitud" required>
                                <option value="">Seleccione...</option>
                                <option value="Overhauling">Overhauling</option>
                                <option value="Mantenimiento">Mantenimiento</option>
                            </select>
                        </div>

                        <div class="mb-3 d-none" id="grupoDiagnostico">
                            <label for="DiagnosticoInicial" class="form-label">
                                Diagnóstico inicial
                            </label>
                            <select class="form-select" id="DiagnosticoInicial" name="OverhaulingID" required></select>
                        </div>
                        <input type="hidden" name="OverhaulingNumero" id="OverhaulingNumero">
                        <input type="hidden" name="Tipo" value="SolicitudCompra">
                    </div>
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {

    // Cambio en tipo de solicitud
    $('#TipoSolicitud').on('change', function () {
        const tipo = $(this).val();
        const grupo = $('#grupoDiagnostico');
        const select = $('#DiagnosticoInicial');

        if (tipo === 'Overhauling') {
            grupo.removeClass('d-none');
            select.html('<option value="">Cargando...</option>');

            $.get('TraerOverhauling', function (data) {
                try {
                    const overhauling = Array.isArray(data) ? data : JSON.parse(data);

                    console.log('Overhauling recibido:', overhauling);

                    select
                        .empty()
                        .append('<option value="">Seleccione diagnóstico...</option>');

                    if (overhauling.length > 0) {
                        overhauling.forEach(item => {
                            select.append(`
                                <option value="${item.ID}" data-numero="${item.Numero}">
                                    ${item.Numero}
                                </option>
                            `);
                        });
                    }

                } catch (error) {
                    console.error('Error procesando JSON:', error);
                    select.html('<option value="">Error al procesar datos</option>');
                }
            }).fail(function (xhr, status, error) {
                console.error('Error AJAX:', error);
                select.html('<option value="">Error al cargar diagnósticos</option>');
            });

        } else {
            grupo.addClass('d-none');
            select.html('<option value="">Seleccione diagnóstico...</option>');
            $('#OverhaulingNumero').val('');
        }
    });

    // Capturar selección del diagnóstico
    $('#DiagnosticoInicial').on('change', function () {
        const selected = $(this).find(':selected');
        const numero = selected.data('numero') || '';

        $('#OverhaulingNumero').val(numero);
    });

});
</script>

<?php require "App/Views/Templates/Layouts/Footer.php"; ?>