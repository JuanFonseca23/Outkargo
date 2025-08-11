<?php
require_once "App/Views/Templates/Layouts/Header.php";
include_once "App/Controllers/CentroDeTrabajoController.php";

$CentrosDeTrabajo = new CentroDeTrabajoController;
$ListaCentrosDeTrabajo = $CentrosDeTrabajo->TraerCentrosDeTrabajo();

$ID_Centro = isset($_GET['centro']) ? $_GET['centro'] : $_SESSION['NoCentro'];
?>

<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-6 col-xl-3">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <img width="50" height="50" src="https://img.icons8.com/pastel-glyph/50/000020/hand-truck--v2.png" alt="hand-truck--v2"/>
                <div class="ms-3">
                    <p class="mb-2" style="color: #000020;">Preventivos Realizados</p>
                    <h6 class="mb-0" style="color: #000020;"></h6>
                </div>
            </div>
        </div>
        <a class="col-sm-6 col-xl-3" data-bs-toggle="modal" data-bs-target="#NumerDocumentoModal">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <img width="50" height="50" src="https://img.icons8.com/pastel-glyph/100/000020/hand-truck--v1.png" alt="hand-truck--v2" style="transform: scaleX(-1);" />
                <div class="ms-3">
                    <p class="mb-2" style="color: #000020;">Preventivo</p>
                </div>
            </div>
        </a>
        <a class="col-sm-6 col-xl-3" href="#"></a>
        <a class="col-sm-6 col-xl-3" href="#"></a>
    </div>
</div>

<div class="container-fluid pt-4 px-4">
    <div class="bg-light text-center rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <form method="get" action="" class="mb-0">
                <h6 class="mb-0 d-flex align-items-center">
                    Preventivos Realizados |
                    <select name="centro" class="form-select form-select-sm d-inline w-auto ms-2" onchange="this.form.submit()">
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
                </h6>
            </form>

            <div>
                <a href="#">Ver Todas</a>
                <a>|</a>
                <a href="#">Descargar Excel</a>
            </div>
        </div>

        <!-- Tabla -->
        <div class="table-responsive">
            <table class="table text-start align-middle table-bordered table-hover mb-0" id="myTable">
                <thead>
                    <tr class="text-dark">
                        <th scope="col" class="text-center">N°</th>
                        <th scope="col" class="text-center">Nombre Ingresa</th>
                        <th scope="col">Nombre Supervisor</th>
                        <th scope="col" class="text-center">Estado</th>
                        <th scope="col" class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Aquí irían los datos -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Ingresso de datos -->
<div class="modal fade" id="NumerDocumentoModal" tabindex="-1" aria-labelledby="NumerDocumentoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="NumerDocumentoModalLabel">Mantenimiento Preventivo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form id="documentForm" method="POST">
                    <div class="mb-3">
                        <label for="floatingSelect">Seleccione el centro de trabajo</label>
                        <select class="form-select" name="ID_Centro1" id="ID_Centro1" aria-label="Floating label select example" onchange="cargarMontacargas()" required>
                            <option value="" disabled selected>Centro de Trabajo</option>
                            <?php
                                if ($ListaCentrosDeTrabajo) {
                                    foreach ($ListaCentrosDeTrabajo as $ListaCentroDeTrabajo) {
                                        echo "<option value='{$ListaCentroDeTrabajo['ID']}'>{$ListaCentroDeTrabajo['Nombre']}</option>";
                                    }
                                }
                            ?>
                        </select>
                        <label for="floatingSelect">Seleccione el numeró de montacargas</label>
                        <select class="form-select" name="ID_Montacargas" id="ID_Montacargas" aria-label="Seleccione una montacargas">
                            <option value="" disabled selected>Seleccione un montacargas</option>
                        </select>
                        <input type="hidden" name="Tipo" value="DocumentoEntrega">
                    </div>
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function cargarMontacargas() {
        const ID_Centro = document.getElementById('ID_Centro1').value;
        if (!ID_Centro) return;

        // Hacemos la petición a tu controlador
        $.get(`TraerMontacargas?ID_Centro=${ID_Centro}`, function(data) {
            try {
                const Montacargas = Array.isArray(data) ? data : JSON.parse(data);
                const $montacargasSelect = $('#ID_Montacargas');

                // Limpiar y poner la opción por defecto
                $montacargasSelect.empty().append('<option value="" disabled selected>Seleccione un montacargas</option>');

                if (Montacargas.length > 0) {
                    Montacargas.forEach(m => {
                        $montacargasSelect.append(`<option value="${m.ID}">${m.Numero}</option>`);
                    });
                }
            } catch (error) {
                console.error('Error al procesar los montacargas:', error);
            }
        }).fail(function(xhr, status, error) {
            console.error('Error en la solicitud AJAX:', error);
        });
    }

</script>
<?php require "App/Views/Templates/Layouts/Footer.php"; ?>
