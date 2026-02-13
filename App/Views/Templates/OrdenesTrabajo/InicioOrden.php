<?php
require_once "App/Views/Templates/Layouts/Header.php";
include_once "App/Controllers/CentroDeTrabajoController.php";
include_once "App/Controllers/OrdenesTrabajoController.php";

$CentrosDeTrabajo = new CentroDeTrabajoController;
$OrdenesTrabajoController = new OrdenesTrabajoController();
$ListaCentrosDeTrabajo = $CentrosDeTrabajo->TraerCentrosDeTrabajo();

$ID_Centro = isset($_GET['centro']) ? $_GET['centro'] : $_SESSION['NoCentro'];
$No_Solicitudes = $OrdenesTrabajoController->ContarOrdenesPorCentro($ID_Centro);
$Ordenes = $OrdenesTrabajoController->leerOrdenesTrabajo($ID_Centro);

if ($_SERVER['HTTP_HOST'] == 'localhost') {
    $baseUrl = 'http://localhost/OUTKARGO/';
} else {
    $baseUrl = 'https://outkargo.com.co/';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['Tipo']) && $_POST['Tipo'] === "GuardarOrden") {

        $ID_Usuario = $_SESSION['ID'];
        $NombreCreo = $_SESSION['Nombre1'];
        $Tipo_Trabajo = $_POST['TipoSolicitud'];
        $Prioridad = $_POST['Prioridad'];
        $ID_Tecnicos  = $_POST['Tecnicos'] ?? [];
        if ($Tipo_Trabajo == 'MantenimientoP' || $Tipo_Trabajo == 'MantenimientoC') {
            $Centro_Trabajo = $_POST['CentroTrabajo'];
        } else {
            $Centro_Trabajo = $_SESSION['NoCentro'];
        }

        $Fecha_InicioA = $_POST['FechaI'] ?? null;
        $Fecha_FinA    = $_POST['FechaF'] ?? null;
        if (!empty($Fecha_InicioA)) {
            $fechaIA = DateTime::createFromFormat('Y-m-d', $Fecha_InicioA);
            $Fecha_InicioF = $fechaIA ? $fechaIA->format('d/m/Y') : null;
        } else {
            $Fecha_InicioF = null;
        }

        if (!empty($Fecha_FinA)) {
            $Fecha_FA = DateTime::createFromFormat('Y-m-d', $Fecha_FinA);
            $Fecha_FinF = $Fecha_FA ? $Fecha_FA->format('d/m/Y') : null;
        } else {
            $Fecha_FinF = null;
        }

        $Trabajos = json_decode($_POST['Trabajos'] ?? '[]', true);
        if($ID_Orden = $OrdenesTrabajoController->RegistrarOrdenTrabajo($ID_Usuario,  $NombreCreo, $Tipo_Trabajo, $Prioridad, $ID_Tecnicos, $Centro_Trabajo, $Fecha_InicioF, $Fecha_FinF, $Trabajos)){
            echo "
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                Swal.fire({
                    title: 'Orden de Trabajo!',
                    text: 'La  orden de trabajo se ha creado exitosamente.',
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
                    text: 'La orden de trabajo no se pudo crear, por favor intente de nuevo.',
                    icon: 'error',
                    timer: 3000,
                    timerProgressBar: true
                });
            </script>";
        }

    }
}
?>

<!-- Tom Select: Librerías CSS y JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.bootstrap5.min.css">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>

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

<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-6 col-xl-3">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <img width="50" height="50" src="https://img.icons8.com/ink/50/000020/purchase-order.png" alt="purchase-order"/>
                <div class="ms-3">
                    <p class="mb-2" style="color: #000020;">Órdenes Realizadas</p>
                    <h6 class="mb-0" style="color: #000020;"><?= $No_Solicitudes['Nosolicitudes'] ?></h6>
                </div>
            </div>
        </div>
        <a class="col-sm-6 col-xl-3" data-bs-toggle="modal" data-bs-target="#agregarSolicitud">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <img width="50" height="50" src="https://img.icons8.com/ios/50/000020/work.png" alt="work"/>
                <div class="ms-3">
                    <p class="mb-2" style="color: #000020;">Realizar Orden de Trabajo</p>
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
                    <h6 class="mb-0">Ordenes Realizadas |</h6>
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
                        <th scope="col" class="text-center">Prioridad</th>
                        <th scope="col" class="text-center">Fecha Generada</th>
                        <th scope="col" class="text-center">Estado</th>
                        <th scope="col" class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($Ordenes) {
                        foreach ($Ordenes as $Orden) {
                            if ($Orden['Estado_Orden'] == 'Aprobada') {
                                $progressBarClass = 'bg-success';
                                $estadoTexto = 'Aprobada';
                            } elseif ($Orden['Estado_Orden'] == 'En proceso') {
                                $progressBarClass = 'bg-primary';
                                $estadoTexto = 'En proceso';
                            }elseif ($Orden['Estado_Orden'] == 'Rechazada') {
                                $progressBarClass = 'bg-danger';
                                $estadoTexto = 'Rechazada';
                            }elseif ($Orden['Estado_Orden'] == 'Pausada') {
                                $progressBarClass = 'bg-info';
                                $estadoTexto = 'Pausada';
                            }elseif ($Orden['Estado_Orden'] == 'Pendiente') {
                                $progressBarClass = 'bg-warning text-dark';
                                $estadoTexto = 'Pendiente';
                            }elseif ($Orden['Estado_Orden'] == 'En verificacion') {
                                $progressBarClass = 'bg-secondary';
                                $estadoTexto = 'En verificación';

                            }else {
                                $progressBarClass = 'bg-secondary';
                                $estadoTexto = $Orden['Estado_Orden'];
                            }
                    ?>
                            <tr>
                                <td class="text-center"><?= htmlspecialchars($Orden['Numero']) ?></td>
                                <td class="text-center"><?= htmlspecialchars($Orden['Prioridad']) ?></td>
                                <td class="text-center"><?= htmlspecialchars($Orden['Fecha_Generada']) ?></td>
                                <td>
                                    <div class="progress">
                                        <div id="progressStatus" class="progress-bar <?= $progressBarClass ?>" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                            <?=  $estadoTexto ?>
                                        </div>
                                    </div>
                                </td>
                                <td width="200" class="text-center">
                                    <a class="btn btn-sm btn-primary" target="_blank" href="VerOrden?ID=<?= urlencode(htmlspecialchars($Orden['ID'])) ?>">
                                        <img width="20" height="20" src="https://img.icons8.com/material-outlined/24/ffffff/visible--v1.png" alt="Ver" />
                                    </a>
                                    <?php $idsTecnicos = array_map('trim', explode(',', $Orden['IDMecanicos'] ?? ''));
                                            if (in_array($_SESSION['ID'], $idsTecnicos)) { 
                                    ?>
                                        <?php if ( $Orden['Estado_Orden'] == 'Pendiente' || $Orden['Estado_Orden'] == 'En proceso' || $Orden['Estado_Orden'] == 'Pausada' || $Orden['Estado_Orden'] == 'Rechazada') { ?>
                                        <a class="btn btn-sm btn-info" target="_blank" href="RealizarOrden?ID=<?= urlencode($Orden['ID']) ?>">
                                            <img width="20" height="20" src="https://img.icons8.com/ios/20/ffffff/maintenance--v1.png" />
                                        </a>
                                        <?php } ?>
                                    <?php } ?>

                                    <?php if ( $Orden['Estado_Orden'] == 'En verificacion') { ?>
                                        <a class="btn btn-sm btn-dark" target="_blank" href="AutorizarOrden?ID=<?= urlencode(htmlspecialchars($Orden['ID'])) ?>">
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

<div class="modal fade" id="agregarSolicitud" tabindex="-1" aria-labelledby="agregarSolicitudModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="agregarSolicitudModalLabel">Crear Orden de Trabajo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formAgregarOrden" method="post">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="nombreTecnico" >Técnicos Encargados</label> 
                                    <select name="Tecnicos[]" id="select-para" class="form-control" placeholder="Escribe nombre o codigo..."></select>
                                </div>
                                <div class="mb-3">
                                    <label for="Prioridad" class="form-label">Prioridad</label>
                                    <select class="form-select" id="Prioridad" name="Prioridad" required>
                                        <option value="">Seleccione...</option>
                                        <option value="Alta">Alta</option>
                                        <option value="Media">Media</option>
                                        <option value="Baja">Baja</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="TipoSolicitud" class="form-label"> Tipo de órden de trabajo</label>
                                    <select class="form-select" id="TipoSolicitud" name="TipoSolicitud" required>
                                        <option value="">Seleccione...</option>
                                        <option value="Overhauling">Overhauling</option>
                                        <option value="MantenimientoP">Mantenimiento Preventivo</option>
                                        <option value="MantenimientoC">Mantenimiento Correctivo</option>
                                        <option value="Repuesto">Repuesto</option>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Centro de Trabajo</label>
                                    <input type="text" class="form-control" id="CentroTexto" value="<?= htmlspecialchars($_SESSION['Centro']) ?>" readonly>
                                    <!-- Select cargado desde PHP -->
                                    <select class="form-select d-none" id="CentroSelect" name="CentroTrabajo">
                                        <option value="">Seleccione centro...</option>
                                            <?php foreach ($ListaCentrosDeTrabajo as $centro): ?>
                                                <option value="<?= $centro['ID'] ?>">
                                                    <?= htmlspecialchars($centro['Nombre']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                    </select>

                                    <label for="FechaI">Fecha de inicio</label>
                                    <input type="date" class="form-control" name="FechaI" id="FechaI">
                                    <label for="FechaF">Fecha programada de finalización</label>
                                    <input type="date" class="form-control" name="FechaF" id="FechaF">
                                </div>
                                <div class="mb-3 d-none" id="grupoDiagnostico">
                                    <label for="DiagnosticoInicial" class="form-label">
                                        Diagnóstico inicial
                                    </label>
                                    <select class="form-select" id="DiagnosticoInicial" name="OverhaulingID" required></select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8" id="contenedorTrabajos">

                        </div>
                    </div>
                    <input type="hidden" name="Trabajos" id="TrabajosHidden">
                    <input type="hidden" name="Tipo" value="GuardarOrden">
                    <button type="submit" class="btn btn-primary mt-3">Agregar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    let tom = null;
    document.addEventListener('DOMContentLoaded', function () {

        // FECHAS - BLOQUEAR FECHAS PASADAS
        const hoy = new Date().toISOString().split('T')[0];
        document.getElementById('FechaI').setAttribute('min', hoy);
        document.getElementById('FechaF').setAttribute('min', hoy);

        // TOMSELECT - TÉCNICOS
        if (document.querySelector('#select-para') && !document.querySelector('#select-para').tomselect) {

            tom = new TomSelect('#select-para', {
                plugins: ['remove_button'],
                placeholder: 'Escribe nombre',
                maxItems: null,
                valueField: 'id',
                labelField: 'nombre',
                searchField: ['nombre'],
                closeAfterSelect: true,
                hideSelected: true,
                create: false,

                load: function(query, callback) {
                    if (query.length < 2) return callback([]);

                    fetch(`<?= $baseUrl ?>OrdenesTrabajo/BuscarTecnicos?q=${encodeURIComponent(query)}`)
                        .then(r => r.json())
                        .then(data => callback(Array.isArray(data) ? data : []))
                        .catch(() => callback([]));
                }
            });
        }

        // VARIABLES
        const centroInput        = $('#CentroTexto');
        const centroSelect       = $('#CentroSelect');
        const grupo              = $('#grupoDiagnostico');
        const selectDiagnostico  = $('#DiagnosticoInicial');
        const contenedorTrabajos = $('#contenedorTrabajos');
        const trabajosHidden     = $('#TrabajosHidden');

        // CAMBIO TIPO SOLICITUD
        $('#TipoSolicitud').on('change', function () {

            const tipo = $(this).val();

            grupo.addClass('d-none');
            selectDiagnostico.html('<option value="">Seleccione...</option>');
            contenedorTrabajos.html('');
            trabajosHidden.val('');   // limpiar selección

            if (tipo === 'MantenimientoP' || tipo === 'MantenimientoC') {
                centroInput.addClass('d-none');
                centroSelect.removeClass('d-none');
            } else {
                centroInput.removeClass('d-none');
                centroSelect.addClass('d-none').val('');
            }

            let urlDiagnostico = null;
            if (tipo === 'Overhauling') {
                urlDiagnostico = 'TraerOverhauling';
            } else if (tipo === 'MantenimientoP') {
                urlDiagnostico = 'TraerOverhauling';
            } else if (tipo === 'MantenimientoC') {
                urlDiagnostico = 'TraerOverhauling';
            } else if (tipo === 'Repuesto') {
                urlDiagnostico = 'TraerSolicitudes';
            } else {
                return;
            }

            grupo.removeClass('d-none');
            selectDiagnostico.html('<option value="">Cargando...</option>');

            $.get(urlDiagnostico).done(function (data) {

                const listado = Array.isArray(data) ? data : JSON.parse(data);

                selectDiagnostico
                    .empty()
                    .append('<option value="">Seleccione diagnóstico...</option>');

                if (!listado.length) {
                    selectDiagnostico.append('<option value="">No hay registros</option>');
                    return;
                }

                listado.forEach(item => {

                    let texto = '';
                    if (tipo === 'Repuesto') {
                        texto = item.Numero;
                    } else {
                        texto = `#${item.Marca} / ${item.Modelo} / ${item.Serie}`;
                    }

                    selectDiagnostico.append(`
                        <option value="${item.ID}">
                            ${texto}
                        </option>
                    `);
                });

            }).fail(() => {
                selectDiagnostico.html('<option value="">Error al cargar datos</option>');
            });

        });

        // CARGAR TRABAJOS
        $('#DiagnosticoInicial').on('change', function () {

        const id   = $(this).val();
        const tipo = $('#TipoSolicitud').val();

        contenedorTrabajos.html('');
        trabajosHidden.val('');

        if (!id || !tipo) return;

        contenedorTrabajos.html(`<div class="text-center p-3">Cargando trabajos...</div>`);

        const url = `<?= $baseUrl ?>OrdenesTrabajo/ObtenerTrabajos?tipo=${tipo}&id=${id}`;

        fetch(url)
            .then(r => r.json())
            .then(data => {

                if (!Array.isArray(data) || !data.length) {
                    contenedorTrabajos.html(`<div class="alert alert-warning">No existen registros.</div>`);
                    return;
                }

                let html = `<h5 class="mb-3">Trabajos Pendientes</h5>
                            <table class="table table-bordered table-sm">`;
                
                // CABECERA DINÁMICA
                if (tipo === 'Repuesto') {
                    html += `<thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Serial</th>
                                <th>Descripción de falla</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>`;
                    }else{
                    html += `<thead>
                            <tr>
                                <th>#</th>
                                <th>Descripción de falla</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>`;}

                // FILAS
                data.forEach((item, index) => {

                    if (tipo === 'Repuesto') {
                        const numero = item.NumeroMontacargas ?? '';
                        const marca  = item.MarcaMontacargas ?? '';
                        const serial = item.Serie ?? '';
                        const descripcion   = item.Descripcion ?? '';

                        let nombreProducto = '';

                        if (item.Tipo_Producto === 'Montacargas') {
                            nombreProducto = `Montacargas ${marca} #${numero}`;
                        } else {
                            nombreProducto = item.NombreProducto ?? '';
                        }

                        html += `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${nombreProducto}</td>
                                <td>${serial}</td>
                                <td>${descripcion}</td>
                                <td class="text-center">
                                    <input type="checkbox"
                                        class="chk-trabajo"
                                        value="${item.ID}"
                                        data-descripcion="${descripcion}">
                                </td>
                            </tr>
                        `;

                    } else {
                        const descripcion = item.Descripcion ?? '';
                        html += `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${descripcion}</td>
                                <td class="text-center">
                                    <input type="checkbox"
                                        class="chk-trabajo"
                                        value="${item.ID}"
                                        data-descripcion="${descripcion}">
                                </td>
                            </tr>
                        `;
                    }

                });

                html += `</tbody></table>`;
                contenedorTrabajos.html(html);
            })
            .catch(() => {
                contenedorTrabajos.html(`<div class="alert alert-danger">Error al cargar.</div>`);
            });
    });


        // GUARDAR CHECKS EN INPUT HIDDEN
        $(document).on('change', '.chk-trabajo', function () {

            const trabajos = [];

            $('.chk-trabajo:checked').each(function () {
                trabajos.push({
                    id: $(this).val(),
                    descripcion: $(this).data('descripcion')
                });
            });

            trabajosHidden.val(JSON.stringify(trabajos));
            console.log('Trabajos seleccionados:', trabajos);
        });

    });

</script>

<?php require "App/Views/Templates/Layouts/Footer.php"; ?>