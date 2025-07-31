<?php
include_once "App/Controllers/ProductosController.php";
require_once "App/Views/Templates/Layouts/Header.php";

if (empty($_SESSION['ID'])) {
    header("location:../IniciarSesion");
    exit;
}
if (!isset($_GET['ID'])) {
    echo "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
            Swal.fire({
                title: 'Error',
                text: 'ID no proporcionado',
                icon: 'error',
                timer: 2000,
                timerProgressBar: true,
                didClose: () => {
                    window.location.href = 'Inicio';
                }
            });
        </script>";
    exit();
}
$ProductosController = new ProductosController;
$ID_Usuario = $_SESSION['ID'];
$NombreEdita = $_SESSION['Nombre1'];
$ID_Producto = $_GET['ID'];
$Productos = $ProductosController->obtenerProducto($ID_Producto);
$ListaCategorias = $ProductosController->TraerCategorias();
$ListaSubcategorias = $ProductosController->TraerSubcategorias1();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Nombre = $_POST['nombreProducto'];
    $Codigo = $_POST['Codigo'];
    $Descripcion = $_POST['descripcionProducto'];
    $ID_Categoria = $_POST['ID_Categoria1'];
    $ID_SubCategoria  = $_POST['ID_SubCategoria'];
    $NumeroParte = $_POST['N_Parte'];
    $NumeroSerie = $_POST['N_Serial'];
    $stockMinimo = $_POST['stockMinimo'];
    $Estado = $_POST['Estado'];
    $Foto = $_FILES['Foto']; 
    $ProductosController->Editar($ID_Usuario, $NombreEdita, $ID_Producto, $Codigo, $Nombre, $Descripcion, $Estado, $ID_Categoria, $ID_SubCategoria, $NumeroParte, $NumeroSerie, $stockMinimo, $Foto);
}
?>

<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-12 col-xl-12">
            <?php
            if ($Productos) {
                foreach ($Productos as $Producto) {
            ?>
            <form id="productoForm" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <h5 class="mb-4">Nombre</h5>
                            <input hidden type="text" name="Codigo" class="form-control" value="<?= $Producto['Codigo'] ?>">
                            <input type="text" name="nombreProducto" id="nombreProducto" class="form-control" value="<?= $Producto['Nombre'] ?>" disabled required>
                        </div>
                        <img id="imagenPreview" src="../<?= $Producto['Foto'] ?>" alt="Imagen de Presentación" class="img-fluid mb-3">
                        <div class="mb-3">
                             <label for="imagenProducto" class="form-label">Subir Imagen</label>
                            <input class="form-control" type="file" name="Foto" id="imagenProducto" accept="image/*">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <h6>Descripcion</h6>
                                <textarea class="form-control" name="descripcionProducto" id="descripcionProducto" rows="3" disabled><?= htmlspecialchars($Producto['Descripcion']) ?></textarea>
                            </div>
                            <div class="col-md-6">
                                <h6>Estado</h6>
                                <select class="form-select" name="Estado" id="Estado" disabled>
                                    <option <?= $Producto['Estado'] === 'Nuevo' ? 'selected' : '' ?>>Nuevo</option>
                                    <option <?= $Producto['Estado'] === 'Remanufacturado' ? 'selected' : '' ?>>Remanufacturado</option>
                                    <option <?= $Producto['Estado'] === 'Usado' ? 'selected' : '' ?>>Usado</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <h6>Categoria</h6>
                                <select class="form-select" name="ID_Categoria1" id="ID_Categoria1" aria-label="Seleccione una categoría" onchange="cargarSubcategorias()" disabled required>
                                    <?php foreach ($ListaCategorias as $ListaCategoria): ?>
                                        <option value="<?= $ListaCategoria['ID'] ?>" <?= $ListaCategoria['ID'] == $Producto['Categoria'] ? 'selected' : '' ?>>
                                            <?= $ListaCategoria['Nombre'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>    
                            <div class="col-md-6">
                                <h6>Subcategoría</h6>
                                <select class="form-select" name="ID_SubCategoria" id="ID_SubCategoria" aria-label="Seleccione una subcategoría" disabled>
                                    
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <h6>Numero de Parte</h6>
                                <input type="text" class="form-control" name="N_Parte" id="N_Parte" value="<?= htmlspecialchars($Producto['N_Parte']) ?>" disabled>
                            </div>
                            <div class="col-md-6">
                                <h6>Numero de Serie</h6>
                                <input type="text" class="form-control" name="N_Serial" id="N_Serial" value="<?= htmlspecialchars($Producto['N_Serial']) ?>" disabled>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <h6>Stock Minimo</h6>
                                <input type="number" class="form-control" name="stockMinimo" id="stockMinimo" value="<?= htmlspecialchars($Producto['stockMinimo']) ?>" disabled>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div id="botonesVer">
                                    <a class="btn btn-sm btn-primary" target="_blank" href="CodigoBarras?Codigo=<?= urlencode(htmlspecialchars($Producto['Codigo'])) ?>&Nombre=<?= urlencode(htmlspecialchars($Producto['Nombre'])) ?>">
                                        <img width="20" height="20" src="https://img.icons8.com/ios-filled/50/ffffff/barcode-scanner-2.png" alt="barcode-scanner-2" />
                                    </a>
                                    <button type="button" class="btn btn-sm btn-warning" id="editarBtn">Editar</button>
                                </div>
                                <div id="botonGuardar" style="display: none;">
                                    <button type="submit" class="btn btn-sm btn-success">Guardar</button>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <a class="btn btn-sm btn-primary" href="Inicio">Volver</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <?php
                }
            }
            ?>
        </div>
    </div>
</div>

<script>
    document.getElementById('imagenProducto').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imagenPreview').src = e.target.result;}
                reader.readAsDataURL(file);}
    });

    document.getElementById('editarBtn').addEventListener('click', function () {
    document.querySelectorAll('#productoForm input, #productoForm textarea, #productoForm select').forEach(el => el.disabled = false);
    document.getElementById('botonesVer').style.display = 'none';
    document.getElementById('botonGuardar').style.display = 'block';
    });

        document.getElementById('editarBtn').addEventListener('click', function () {
        document.querySelectorAll('#productoForm input, #productoForm textarea, #productoForm select').forEach(el => el.disabled = false);
        document.getElementById('botonesVer').style.display = 'none';
        document.getElementById('botonGuardar').style.display = 'block';
    });

    function cargarSubcategorias() {
        const ID_Categoria = document.getElementById('ID_Categoria1').value;
        console.log('ID_Categoria enviado:', ID_Categoria);

        if (!ID_Categoria) return;

        $.get(`TraerSubcategorias?ID_Categoria=${ID_Categoria}`, function(data) {
            try {
                const Subcategorias = Array.isArray(data) ? data : JSON.parse(data);
                $('#ID_SubCategoria').empty();

                $('#ID_SubCategoria').append('<option value="" disabled selected>Seleccione una subcategoría</option>');

                const subcategoriaSeleccionada = '<?= $Producto["SubCategoria"] ?>';
                if (subcategoriaSeleccionada === null) {
                    $('#ID_SubCategoria').append('<option value="" selected>No aplica</option>');
                }

                if (Subcategorias.length > 0) {
                    Subcategorias.forEach(subcategoria => {
                        const selected = (subcategoria.ID == subcategoriaSeleccionada) ? 'selected' : '';
                        $('#ID_SubCategoria').append(`<option value="${subcategoria.ID}" ${selected}>${subcategoria.Nombre}</option>`);
                    });
                } else {
                    $('#ID_SubCategoria').append('<option value="" selected>No aplica</option>');
                }
            } catch (error) {
                console.error('Error al procesar las subcategorías:', error);
            }
        }).fail(function(xhr, status, error) {
            console.error('Error en la solicitud AJAX:', error);
        });
    }
    // Llamada inicial para cargar las subcategorías al cargar la página
    window.onload = cargarSubcategorias;
</script>

<?php require "App/Views/Templates/Layouts/Footer.php"; ?>