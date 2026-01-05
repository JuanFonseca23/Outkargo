<?php
include_once "App/Controllers/DotacionController.php";
require_once "App/Views/Templates/Layouts/Header.php";
if (empty($_SESSION['ID'])) {
    header("location:../IniciarSesion");
    exit;
}
$DotacionController = new DotacionController;
$ID_Centro = $_SESSION['NoCentro'];
$Listas = $DotacionController->LeerE($ID_Centro);
$Nombre = $DotacionController->Centro($ID_Centro);
$NoEntregas = $DotacionController->ContarEntregas($ID_Centro);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['Tipo'] == "DocumentoEntrega") {
        $No_Documento = $_POST['documentNumber'];
        if($datausuario = $DotacionController->BuscarPersona($No_Documento)){
            echo "
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                Swal.fire({
                    title: 'Usuario Encontrado!',
                    text: 'El usuario encontrado es: " . htmlspecialchars($datausuario['NombreCompleto']) . " - ". $datausuario['Nombre_Centro'] ."',
                    icon: 'success',
                    showCancelButton: true,
                    confirmButtonText: 'Continuar',
                    cancelButtonText: 'Cancelar',
                    allowOutsideClick: false,
                    allowEscapeKey: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'Entrega?Documento=".$datausuario['Documento']."';
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
<!-- Sale & Revenue Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-6 col-xl-3">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <img width="50" height="50" src="https://img.icons8.com/ios/50/000020/delivery--v1.png" alt="delivery--v1"/>
                <div class="ms-3">
                    <p class="mb-2" style="color: #000020;">Entregas Realizadas</p>
                    <h6 class="mb-0" style="color: #000020;"><?= $NoEntregas['NoEntregas'] ?></h6>
                </div>
            </div>
        </div>
        <a class="col-sm-6 col-xl-3" data-bs-toggle="modal" data-bs-target="#NumerDocumentoModal">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <img width="50" height="50" src="https://img.icons8.com/ios/50/000020/truck.png" alt="truck" />
                <div class="ms-3">
                    <p class="mb-2" style="color: #000020;">Registrar Entrega</p>
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
                echo '<h6 class="mb-0">Entregas Realizadas | ' . htmlspecialchars($Nombre_Centro['Nombre_Centro']) . '</h6>';
            } else {
                echo '<h6 class="mb-0">Entregas Realizadas | No disponible</h6>';
            }
            ?>
            <a href="#">Descargar Excel</a>
        </div>
        <div class="table-responsive">
            <table class="table text-start align-middle table-bordered table-hover mb-0" id="myTable">
                <thead>
                    <tr class="text-dark">
                        <th scope="col" class="text-center">Codigo</th>
                        <th scope="col">Entrega</th>
                        <th scope="col">Recibe</th>
                        <th scope="col" class="text-center">Acciónes</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($Listas) {
                        foreach ($Listas as $Lista) {
                    ?>
                            <tr data-id="<?= htmlspecialchars($Lista['ID']) ?>">
                                <td width="100" class="text-center"><?= htmlspecialchars($Lista['ID']) ?></td>
                                <td><?= htmlspecialchars($Lista['NombreUsuario']) ?></td>
                                <td><?= htmlspecialchars($Lista['NombreSupervisor']) ?></td>
                                <td width="200" class="text-center">
                                    <a class="btn btn-sm btn-primary" target="_blank" href="VerEntrega?Codigo=<?= urlencode(htmlspecialchars($Lista['ID'])) ?>">
                                        <img width="20" height="20" src="https://img.icons8.com/material-outlined/24/ffffff/visible--v1.png" alt="Ver" />
                                    </a>
                                    <?php
                                        if($Lista['Estado'] == 1){
                                    ?>
                                        <a class="btn btn-sm btn-danger" target="_blank" href="AnularEntrega?ID=<?= urlencode(htmlspecialchars($Lista['ID'])) ?>">
                                            <img width="20" height="20" src="https://img.icons8.com/ios/50/ffffff/cancel-order.png" alt="cancel-order"/>
                                        </a>
                                    <?php
                                        }
                                    ?>
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