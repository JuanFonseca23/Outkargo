<?php
include_once "App/Controllers/DotacionController.php";
require_once "App/Views/Templates/Layouts/Header.php";
if (empty($_SESSION['ID'])) {
    header("location:../IniciarSesion");
    exit;
}
$DotacionController = new DotacionController;
$ID_Centro = $_SESSION['NoCentro'];
$Listas = $DotacionController->Leer($ID_Centro);
$Nombre = $DotacionController->Centro($ID_Centro);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['Tipo'] == "DocumentoEntrega") {
        switch ($_POST['area']) {
            case $_POST['area']:
                echo "
                    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                    <script>
                        Swal.fire({
                            title: 'Area Seleccionada!',
                            text: 'El Area Seleccionada es: " . htmlspecialchars($_POST['area'])."',
                            icon: 'success',
                            showCancelButton: true,
                            confirmButtonText: 'Continuar',
                            cancelButtonText: 'Cancelar',
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = 'Registrar?Area=".$_POST['area']."';
                            }
                        });
                    </script>
                ";
                break;
            default:
                echo "
                    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                    <script>
                        Swal.fire({
                            title: 'Error!',
                            text: 'Area no encontrado',
                            icon: 'error',
                            timer: 3000,
                            timerProgressBar: true
                        });
                    </script>
                ";
                break;
        }
    }
}
?>
<!-- Sale & Revenue Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-6 col-xl-3">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <img width="50" height="50" src="https://img.icons8.com/ios/50/000020/add-rule.png" alt="add-rule"/>
                <div class="ms-3">
                    <p class="mb-2" style="color: #000020;">Realizadas</p>
                    <h6 class="mb-0" style="color: #000020;">00000</h6>
                </div>
            </div>
        </div>
        <a class="col-sm-6 col-xl-3" data-bs-toggle="modal" data-bs-target="#NumerDocumentoModal">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <img width="50" height="50" src="https://img.icons8.com/ios/50/000020/new--v1.png" alt="new--v1" />
                <div class="ms-3">
                    <p class="mb-2" style="color: #000020;">Registrar Inspeccion</p>
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
                echo '<h6 class="mb-0">Inspecciones Realizadas | ' . htmlspecialchars($Nombre_Centro['Nombre_Centro']) . '</h6>';
            } else {
                echo '<h6 class="mb-0">Dotacion Actual | No disponible</h6>';
            }
            ?>
            <a href="#">Descargar Excel</a>
        </div>
        <div class="table-responsive">
            <table class="table text-start align-middle table-bordered table-hover mb-0" id="myTable">
                <thead>
                    <tr class="text-dark">
                        <th scope="col" class="text-center">Codigo</th>
                        <th scope="col" class="text-center">Cantidad</th>
                        <th scope="col">Nombre</th>
                        <th scope="col" class="text-center">Codigo de barras</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($Listas) {
                        foreach ($Listas as $Lista) {
                    ?>
                            <tr data-id="<?= htmlspecialchars($Lista['ID']) ?>">
                                <td width="100" class="text-center"><?= htmlspecialchars($Lista['Codigo_Producto']) ?></td>
                                <td width="100" class="text-center"><?= htmlspecialchars($Lista['Cantidad']) ?></td>
                                <td><?= htmlspecialchars($Lista['Nombre_producto']) ?></td>
                                <td width="200" class="text-center">
                                    <a class="btn btn-sm btn-primary" target="_blank" href="CodigoBarras?Codigo=<?= urlencode(htmlspecialchars($Lista['Codigo_Producto'])) ?>&Nombre=<?= urlencode(htmlspecialchars($Lista['Nombre_producto'])) ?>">
                                        <img width="20" height="20" src="https://img.icons8.com/ios-filled/50/ffffff/barcode-scanner-2.png" alt="barcode-scanner-2" />
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
                <h5 class="modal-title text-white" id="NumerDocumentoModalLabel">Seleccione el área</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form id="documentForm" method="POST">
                    <div class="mb-3">
                        <label for="areaSelect" class="form-label">Área:</label>
                        <select class="form-control" name="area" id="areaSelect" required>
                            <option value="" disabled>Seleccione un área</option>
                            <option value="Puesto de trabajo">Puesto de trabajo</option>
                            <option value="Cargue Contenedores">Cargue Contenedores</option>
                            <option value="Almacen PT">Almacén PT</option>
                            <option value="Almacen PP">Almacén PP</option>
                            <option value="Almacen Empaque">Almacén Empaque</option>
                            <option value="Cierre Pallet">Cierre Pallet</option>
                            <option value="Eremas">Eremas</option>
                            <option value="Materia prima">Materia prima</option>
                            <option value="Scrap">Scrap</option>
                            <option value="Taller">Taller</option>
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