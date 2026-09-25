<?php
require_once "App/Views/Templates/Layouts/Header.php";
include_once "App/Controllers/CentroDeTrabajoController.php";
include_once "App/Controllers/MantenimientosController.php";

$CentrosDeTrabajo = new CentroDeTrabajoController;
$MantenimientosController = new MantenimientosController();
$ListaCentrosDeTrabajo = $CentrosDeTrabajo->TraerCentrosDeTrabajo();

date_default_timezone_set('America/Bogota'); 
$horaFormateada = date("H:i");

$ID_Centro = isset($_GET['centro']) ? $_GET['centro'] : $_SESSION['NoCentro'];
$Mantenimientos = $MantenimientosController->LeerMantenimientosCorrectivosOrden($ID_Centro);
$NoMantenimientos = $MantenimientosController->ContarMantenimientosCorrectivoOrden($ID_Centro);

if ($_SERVER['HTTP_HOST'] == 'localhost') {
    $baseUrl = 'http://localhost/OUTKARGO/';
} else {
    $baseUrl = 'https://outkargo.com.co/';
}
?>

<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-6 col-xl-3">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <img width="50" height="50" src="https://img.icons8.com/pastel-glyph/50/000020/hand-truck--v2.png" alt="hand-truck--v2"/>
                <div class="ms-3">
                    <p class="mb-2" style="color: #000020;">Correctivos Realizados</p>
                    <h6 class="mb-0" style="color: #000020;"><?= $NoMantenimientos['NoMantenimientos'] ?></h6>
                </div>
            </div>
        </div> 
        <a class="col-sm-6 col-xl-3" href="#"></a>
        <a class="col-sm-6 col-xl-3" href="#"></a>
        <a class="col-sm-6 col-xl-3" href="#"></a>
    </div>
</div>

<div class="container-fluid pt-4 px-4">
    <div class="bg-light text-center rounded p-4">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2 mb-4">
            <form method="get" action="" class="mb-0">
                <div class="d-flex align-items-center flex-wrap gap-2">
                    <h6 class="mb-0">Correctivos Realizados |</h6>
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
                <a href="InicioCorrectivos" class="text-decoration-none me-2 text-primary fw-bold">Ver Mantenimiento Montacargas</a>
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
                        <th scope="col" class="text-center"># Orden de Trabajo</th>
                        <th scope="col" class="text-center">Estado</th>
                        <th scope="col" class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($Mantenimientos) {
                        foreach ($Mantenimientos as $Mantenimiento) {
                            if ($Mantenimiento['Estado_Firma_Supervisor'] === 1) {
                                $progressBarClass = 'bg-success';
                                $estadoTexto = 'Verificado';
                            } else{
                                $progressBarClass = 'bg-warning';
                                $estadoTexto = 'Por Verificar';
                            }

                    ?>
                            <tr data-id="<?= htmlspecialchars($Mantenimiento['ID']) ?>">
                                <td width="100" class="text-center"><?= htmlspecialchars($Mantenimiento['Numero']) ?></td>
                                <td><?= htmlspecialchars($Mantenimiento['Fecha_Realizado']) ?></td>
                                <td>Orden de Trabajo <?= htmlspecialchars($Mantenimiento['NumeroO']) ?></td>
                                <td>
                                    <div class="progress">
                                        <div id="progressStatus" class="progress-bar <?= $progressBarClass ?>" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                            <?=  $estadoTexto ?>
                                        </div>
                                    </div>
                                </td>
                                <td width="200" class="text-center">
                                    <a class="btn btn-sm btn-primary" target="_blank" href="VerMantenimientoCorrectivo?ID=<?= urlencode(htmlspecialchars($Mantenimiento['ID'])) ?>">
                                        <img width="20" height="20" src="https://img.icons8.com/material-outlined/24/ffffff/visible--v1.png" alt="Ver" />
                                    </a>
                                    <?php if ( $_SESSION['ID'] == $Mantenimiento['ID_Supervisor'] && $Mantenimiento['Estado_Firma_Supervisor'] != 1) { ?>
                                        <a class="btn btn-sm btn-dark" target="_blank" href="FirmaSupervisorC?ID=<?= urlencode(htmlspecialchars($Mantenimiento['ID'])) ?>">
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

<?php require "App/Views/Templates/Layouts/Footer.php"; ?>
