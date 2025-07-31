<?php
include_once "App/Controllers/BlogController.php";
require_once "App/Views/Templates/Layouts/Header.php";
if (empty($_SESSION['ID'])) {
    header("location:../IniciarSesion");
    exit;
}

$BlogController = new BlogController;
$ID_Centro = $_SESSION['NoCentro'];
$Listas = $BlogController->ListarBlog();
?>
<!-- Sale & Revenue Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <a class="col-sm-6 col-xl-3" href="#" data-bs-toggle="modal" data-bs-target="#crearBlogModal">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <img width="50" height="50" src="https://img.icons8.com/pastel-glyph/100/000020/hand-truck--v1.png" alt="hand-truck--v1" />
                <div class="ms-3">
                    <p class="mb-2" style="color: #000020;">Registrar</p>
                </div>
            </div>
        </a>

        <a class="col-sm-6 col-xl-3" href="#">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <img width="50" height="50" src="https://img.icons8.com/pastel-glyph/64/000020/create-new--v2.png" alt="create-new--v2" />
                <div class="ms-3">
                    <p class="mb-2" style="color: #000020;">Opcional</p>
                </div>
            </div>
        </a>
        <a class="col-sm-6 col-xl-3" href="#">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <img width="50" height="50" src="https://img.icons8.com/pastel-glyph/64/000020/delivery-tracking--v2.png" alt="delivery-tracking--v2" />
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
                echo '<h6 class="mb-0">Blog Actual | ' . htmlspecialchars($Nombre_Centro['Nombre_Centro']) . '</h6>';
            } else {
                echo '<h6 class="mb-0">Blog Actual | No disponible</h6>';
            }
            ?>
            <a href="#">Descargar Excel</a>
        </div>
        <div class="table-responsive">
            <table class="table text-start align-middle table-bordered table-hover mb-0" id="myTable">
                <thead>
                    <tr class="text-dark">
                        <th scope="col" class="text-center">#</th>
                        <th scope="col" class="text-center">Titulo</th>
                        <th scope="col">Descripcion</th>
                        <th scope="col" class="text-center">Publico</th>
                        <th scope="col" class="text-center">Acciones</th>
                    </tr>
        </thead>
                <tbody>
                    <?php
                    if ($Listas) {
                        foreach ($Listas as $Lista) {
                    ?>
                            <tr data-id="<?= htmlspecialchars($Lista['ID']) ?>">
                                <td width="100" class="text-center"><?= htmlspecialchars($Lista['ID']) ?></td>
                                <td width="100" class="text-center"><?= htmlspecialchars($Lista['Titulo']) ?></td>
                                <?php $Contenido = $BlogController->LimitarContenido($Lista['Contenido']) ?>
                                <td><?= $Contenido ?></td>
                                <?php $NombrePersona = $BlogController->ObtenerNombrePersona($Lista['ID_Usuario']) ?>
                                <td><?= $NombrePersona ?></td>
                                <td width="200" class="text-center">
                                    <a class="btn btn-sm btn-primary" target="_blank" href="Editar?ID=<?= urlencode(htmlspecialchars($Lista['ID'])) ?>">
                                        <img width="20" height="20" src="https://img.icons8.com/ios/50/ffffff/edit--v1.png" alt="barcode-scanner-2" />
                                    </a>
                                    <a class="btn btn-sm btn-primary" target="_blank" href="Eliminar?ID=<?= urlencode(htmlspecialchars($Lista['ID'])) ?>">
                                        <img width="20" height="20" src="https://img.icons8.com/material-outlined/50/ffffff/filled-trash.png" alt="barcode-scanner-2" />
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
<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $Titulo = $_POST['Titulo'] ?? '';
        $Tema = $_POST['Tema'] ?? '';
        $Contenido = $_POST['Contenido'] ?? '';
        $ID_Usuario = $_SESSION['ID'];
        $Fecha_Creacion = $_POST['Fecha_Creacion'] ?? '';
        $Estado = $_POST['Estado'] ?? '';
        $Foto = $_FILES['Imagen_Portada'] ?? '';
        $BlogController->CrearBlog($ID_Usuario, $Titulo, $Foto, $Tema, $Contenido, $Fecha_Creacion, $Estado);
    }
?>
<div class="modal fade" id="crearBlogModal" tabindex="-1" aria-labelledby="crearBlogModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" enctype="multipart/form-data">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white" id="crearBlogModalLabel">Crear Nuevo Blog</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">

                    <input type="hidden" name="ID_Usuario" value="<?= htmlspecialchars($_SESSION['ID']) ?>">
                    <input type="hidden" name="Fecha_Creacion" value="<?= date('d/m/Y') ?>">
                    <input type="hidden" name="Estado" value="1">

                    <div class="mb-3">
                        <label for="Titulo" class="form-label">Título</label>
                        <input type="text" class="form-control" id="Titulo" name="Titulo" required>
                    </div>

                    <div class="mb-3">
                        <label for="Tema" class="form-label">Tema</label>
                        <select class="form-select" id="Tema" name="Tema" required>
                            <option value="">Seleccione un tema</option>
                            <option value="Información">Información</option>
                            <option value="Actualización">Actualización</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="Imagen_Portada" class="form-label">Imagen de Portada</label>
                        <input type="file" class="form-control" id="Imagen_Portada" name="Imagen_Portada" accept="image/*" required>
                    </div>

                    <div class="mb-3">
                        <label for="Contenido" class="form-label">Contenido</label>
                        <textarea class="form-control" id="Contenido" name="Contenido" rows="5" required></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Crear Blog</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<?php require "App/Views/Templates/Layouts/Footer.php"; ?>