<?php
include_once "App/Controllers/DotacionController.php";
require_once "App/Views/Templates/Layouts/Header.php";
if (empty($_SESSION['ID'])) {
    header("location:../IniciarSesion");
    exit;
}
$DotacionController = new DotacionController;
$ID_Centro = $_SESSION['NoCentro'];
$Listas = $DotacionController->LeerEntradas($ID_Centro);
$Nombre = $DotacionController->Centro($ID_Centro);
$NoEntradas = $DotacionController->ContarEntradas($ID_Centro);

?>
<!-- Sale & Revenue Start -->
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
            if (!empty($Nombre) && is_array($Nombre)) {
                // Mostrar el mensaje solo una vez
                $Nombre_Centro = $Nombre[0]; // Obtener el primer elemento del array
                echo '<h6 class="mb-0">Entradas Realizadas | ' . htmlspecialchars($Nombre_Centro['Nombre_Centro']) . '</h6>';
            } else {
                echo '<h6 class="mb-0">Entradas Realizadas | No disponible</h6>';
            }
            ?>
            <div>
                <a href="InicioEntradaSedes">Ver Todas</a>
                <a> | </a>
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
                                    <a class="btn btn-sm btn-danger" target="_blank" href="AnularEntrada?ID=<?= urlencode(htmlspecialchars($Lista['ID'])) ?>">
                                        <img width="20" height="20" src="https://img.icons8.com/ios/50/ffffff/cancel-order.png" alt="cancel-order"/>
                                    </a>
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
<div class="modal fade" id="NumerDocumentoModal" tabindex="-1" aria-labelledby="NumerDocumentoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="NumerDocumentoModalLabel">Ingrese su Número de Documento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form id="documentForm" method="POST">
                    <div class="mb-3">
                        <label for="documentNumber" class="form-label">Número de Documento</label>
                        <input type="text" class="form-control" name="documentNumber" placeholder="Ingrese su número de documento" required>
                        <input type="hidden" name="Tipo" value="DocumentoEntrega">
                    </div>
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require "App/Views/Templates/Layouts/Footer.php"; ?>