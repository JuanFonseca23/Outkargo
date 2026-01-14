<?php
require_once "App/Views/Templates/Layouts/Header.php";

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
                    <h6 class="mb-0" style="color: #000020;"></h6>
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
            <h6 class="mb-0">Solicitudes Realizadas</h6>

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
                        <th scope="col" class="text-center">Marca </th>
                        <th scope="col" class="text-center">Serie </th>
                        <th scope="col" class="text-center">Modelo</th>
                        <!-- <th scope="col" class="text-center">Estado</th> -->
                        <th scope="col" class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
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