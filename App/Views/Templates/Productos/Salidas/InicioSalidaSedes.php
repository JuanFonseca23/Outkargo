<?php
require_once "App/Views/Templates/Layouts/Header.php";
include_once "App/Controllers/CentroDeTrabajoController.php";
include_once "App/Controllers/ProductosController.php";
include_once "App/Controllers/DotacionController.php";

if (empty($_SESSION['ID'])) {
    header("location:../IniciarSesion");
    exit;
}
$ProductosController = new ProductosController;
$DotacionController = new DotacionController;
$CentrosDeTrabajo = new CentroDeTrabajoController;

$ID_Centro = $_SESSION['NoCentro'];
$ListaCentrosDeTrabajo = $CentrosDeTrabajo->TraerCentrosDeTrabajo();
$Listas = $ProductosController->LeerSalidasTotales();
$NoSalidas = $ProductosController->ContarSalidasTotales();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['Tipo'] == "DocumentoEntrega") {
        $No_Documento = $_POST['documentNumber'];
        $ID_Centro = $_POST['ID_Centro'];
        if($datausuario = $DotacionController->BuscarPersona($No_Documento)){
            echo "
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
             <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                Swal.fire({
                    title: 'Usuario Encontrado!',
                    text: 'El usuario encontrado es: " . htmlspecialchars($datausuario['NombreCompleto']) . "',
                    icon: 'success',
                    showCancelButton: true,
                    confirmButtonText: 'Continuar',
                    cancelButtonText: 'Cancelar',
                    allowOutsideClick: false,
                    allowEscapeKey: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'Salida?Documento=".$datausuario['Documento']."&Centro=".$ID_Centro."';
                    }
                });
            </script>";
        } else {
            echo "
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                Swal.fire({
                    title: 'Error!',
                    text: 'Usuario no encontrado',
                    icon: 'error',
                    timer: 3000,
                    timerProgressBar: true
                });
            </script>";
        }
    }
}
?>

<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-6 col-xl-3">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
            <img width="50" height="50" src="https://img.icons8.com/pastel-glyph/50/000020/hand-truck--v2.png" alt="hand-truck--v2"/>
                <div class="ms-3">
                    <p class="mb-2" style="color: #000020;">Salidas Realizadas</p>
                    <h6 class="mb-0" style="color: #000020;"><?= $NoSalidas['NoSalidas'] ?></h6>
                </div>
            </div>
        </div>
        <a class="col-sm-6 col-xl-3" data-bs-toggle="modal" data-bs-target="#NumerDocumentoModal">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <img width="50" height="50" src="https://img.icons8.com/pastel-glyph/100/000020/hand-truck--v1.png" alt="hand-truck--v1" />
                <div class="ms-3">
                    <p class="mb-2" style="color: #000020;">Salidas</p>
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
            <h6 class="mb-0">Salidas Realizadas </h6>
            <div>
                <a href="InicioSalida">Atras</a>
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
                        <th scope="col">Nombre Recibe</th>
                        <th scope="col" class="text-center">Centro Traslado</th>
                        <th scope="col">Centro Destinado</th>
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
                                $estadoTexto = 'Recibio';
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
                                <td><?= htmlspecialchars($Lista['NombreRecibe']) ?></td>
                                <td><?= htmlspecialchars($Lista['NombreCentro']) ?></td>
                                <td><?= htmlspecialchars($Lista['NombreCentroRecibe']) ?></td>
                                <td>
                                    <div class="progress">
                                        <div id="progressStatus" class="progress-bar <?= $progressBarClass ?>" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                            <?=  $estadoTexto ?>
                                        </div>
                                    </div>
                                </td>
                                <td width="200" class="text-center">
                                    <a class="btn btn-sm btn-primary" target="_blank" href="VerSalida?ID=<?= urlencode(htmlspecialchars($Lista['ID'])) ?>">
                                        <img width="20" height="20" src="https://img.icons8.com/material-outlined/24/ffffff/visible--v1.png" alt="Ver" />
                                    </a>
                                    <?php if ($Lista['Firma_Estado_Recibe'] != 1) { ?>
                                        <a class="btn btn-sm btn-warning" target="_blank" href="FirmaSalidaReceptor?Documento=<?= urlencode(htmlspecialchars($Lista['Documento'])) ?>&Salida=<?= urlencode(htmlspecialchars($Lista['ID'])) ?>&No_Formulario=<?= urlencode(htmlspecialchars($Lista['Numero'])) ?>">
                                            <img width="20" height="20" src="https://img.icons8.com/sf-regular-filled/24/ffffff/autograph.png" alt="autograph"/>
                                        </a>
                                    <?php } ?>
                                    <?php if ( $_SESSION['ID'] == $Lista['ID_Supervisor'] && $Lista['Firma_Supervisor_Estado'] != 1) { ?>
                                        <a class="btn btn-sm btn-dark" target="_blank" href="FirmaSupervisorSalida?Documento=<?= urlencode(htmlspecialchars($Lista['Documento'])) ?>&Salida=<?= urlencode(htmlspecialchars($Lista['ID'])) ?>&No_Formulario=<?= urlencode(htmlspecialchars($Lista['Numero'])) ?>">
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
                        <label for="floatingSelect">Seleccione el centro de trabajo</label>
                        <select class="form-select" name="ID_Centro" id="floatingSelect" aria-label="Floating label select example" required>
                            <option value="" disabled selected>Centro de Trabajo</option>
                            <?php
                            if ($ListaCentrosDeTrabajo) {
                                foreach ($ListaCentrosDeTrabajo as $ListaCentroDeTrabajo) {
                            ?>
                                    <option value="<?= $ListaCentroDeTrabajo['ID'] ?>"><?= $ListaCentroDeTrabajo['Nombre'] ?></option>
                            <?php
                                }
                            }
                            ?>
                        </select>
                        <input type="hidden" name="Tipo" value="DocumentoEntrega">
                    </div>
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php require "App/Views/Templates/Layouts/Footer.php"; ?>