<?php
require_once "App/Views/Templates/Layouts/Header.php";
include_once "App/Controllers/CentroDeTrabajoController.php";
include_once "App/Controllers/ProductosController.php";

$ProductosController = new ProductosController;

$ID_Centro = $_SESSION['NoCentro'];
$Centro = $_SESSION['Centro'];
$Listas = $ProductosController->LeerEntradas($ID_Centro);
$Nombre = $ProductosController->Centro($ID_Centro);
$NoEntradas = $ProductosController->ContarEntradas($ID_Centro);

?>

<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-6 col-xl-3">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
            <img width="50" height="50" src="https://img.icons8.com/pastel-glyph/50/000020/hand-truck--v2.png" alt="hand-truck--v2"/>
                <div class="ms-3">
                    <p class="mb-2" style="color: #000020;">Entradas Realizadas</p>
                    <h6 class="mb-0" style="color: #000020;"><?= $NoEntradas['NoEntradas'] ?></h6>
                </div>
            </div>
        </div>
        <a class="col-sm-6 col-xl-3" href="Entrada">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <img width="50" height="50" src="https://img.icons8.com/pastel-glyph/100/000020/hand-truck--v1.png" alt="hand-truck--v2" style="transform: scaleX(-1);" />
                <div class="ms-3">
                    <p class="mb-2" style="color: #000020;">Entradas</p>
                </div>
            </div>
        </a>
        <a class="col-sm-6 col-xl-3" href="#">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <img width="50" height="50" src="https://img.icons8.com/pastel-glyph/50/000020/search--v2.png" alt="search--v2"/>
                <div class="ms-3">
                    <p class="mb-2" style="color: #000020;">Buscar</p>
                </div>
            </div>
        </a>
        <a class="col-sm-6 col-xl-3" href="#">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <img width="50" height="50" src="https://img.icons8.com/ios/50/000020/document-1.png" alt="document-1" />
                <div class="ms-3">
                    <p class="mb-2" style="color: #000020;">Realizar Informe</p>
                </div>
            </div>
        </a>
    </div>
</div>
<div class="container-fluid pt-4 px-4">
    <div class="bg-light text-center rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <?php
            if (!empty($Centro)) {
                echo '<h6 class="mb-0">Entradas Realizadas | ' . htmlspecialchars($Centro) . '</h6>';
            } else {
                echo '<h6 class="mb-0">Entradas Realizadas | No disponible</h6>';
            }
            ?>
            <div>
                <a href="InicioEntradaSedes">Ver Todas</a>
                <a>|</a>
                <a href="#">Descargar Excel</a>
            </div>
        </div>
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
                    <?php
                    if ($Listas) {
                        foreach ($Listas as $Lista) {
                            if ($Lista['Estado'] == 1) {
                                $progressBarClass = 'bg-success';
                                $estadoTexto = 'Autorizado';
                            } elseif ($Lista['Estado'] == 2) {
                                $progressBarClass = 'bg-warning';
                                $estadoTexto = 'Pendiente';
                            } elseif ($Lista['Estado'] == 3) {
                                $progressBarClass = 'bg-danger';
                                $estadoTexto = 'Anulada';
                            } 
                    ?>
                            <tr data-id="<?= htmlspecialchars($Lista['ID']) ?>">
                                <td width="100" class="text-center"><?= htmlspecialchars($Lista['Numero']) ?></td>
                                <td><?= htmlspecialchars($Lista['NombreUsuario']) ?></td>
                                <td><?= htmlspecialchars($Lista['NombreSupervisor']) ?></td>
                                <td>
                                    <div class="progress">
                                        <div id="progressStatus" class="progress-bar <?= $progressBarClass ?>" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                            <?=  $estadoTexto ?>
                                        </div>
                                    </div>
                                </td>
                                <td width="200" class="text-center">
                                    <a class="btn btn-sm btn-primary" target="_blank" href="VerEntrada?ID=<?= urlencode(htmlspecialchars($Lista['ID'])) ?>">
                                        <img width="20" height="20" src="https://img.icons8.com/material-outlined/24/ffffff/visible--v1.png" alt="Ver" />
                                    </a>
                                    <?php if ($Lista['Estado'] != 3) { ?>
                                        <a class="btn btn-sm btn-warning" target="_blank" href="EditarEntrada?ID=<?= urlencode(htmlspecialchars($Lista['ID'])) ?>">
                                            <img width="20" height="20" src="https://img.icons8.com/pastel-glyph/64/ffffff/create-new--v1.png" alt="create-new--v1"/>
                                        </a>
                                        <a class="btn btn-sm btn-danger" target="_blank" href="AnularEntrada?ID=<?= urlencode(htmlspecialchars($Lista['ID'])) ?>">
                                            <img width="20" height="20" src="https://img.icons8.com/ios/50/ffffff/cancel-order.png" alt="cancel-order"/>
                                        </a>
                                    <?php } ?>
                                    <?php if ( $_SESSION['ID'] == $Lista['ID_Supervisor'] && $Lista['Firma_supervisor_Estado'] != 1) { ?>
                                        <a class="btn btn-sm btn-dark" target="_blank" href="FirmaSupervisor?ID=<?= urlencode(htmlspecialchars($Lista['ID'])) ?>&No=<?= urlencode(htmlspecialchars($Lista['Numero'])) ?>">
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