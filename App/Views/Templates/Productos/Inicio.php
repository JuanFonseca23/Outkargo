<?php
require_once "App/Views/Templates/Layouts/Header.php";
include_once "App/Controllers/CentroDeTrabajoController.php";
include_once "App/Controllers/ProductosController.php";
include_once "App/Controllers/DotacionController.php";

$DotacionController = new DotacionController;
$CentrosDeTrabajo = new CentroDeTrabajoController;
$ProductosController = new ProductosController;

$Centro = $_SESSION['Centro'];
$ID_Centro = $_SESSION['NoCentro'];
$NombreCreo = $_SESSION['Nombre1'];
$ID_Crea = $_SESSION['ID'];
$Listas = $ProductosController->Leer($ID_Centro);
$NoProductos = $ProductosController->ContarProductosActivos($ID_Centro);
$ListaCentrosDeTrabajo = $CentrosDeTrabajo->TraerCentrosDeTrabajo();
$ListaCategorias = $ProductosController->TraerCategorias();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['Tipo1']) && $_POST['Tipo1'] === "NombreCategoria") {
        $Nombre = $_POST['nombreCategoria'];
        $manejaCategoria = $_POST['manejaCategoria'];
        if (!empty($Nombre)) {
            if ($manejaCategoria === "si") {
                $ID_Categoria = $_POST['ID_Categoria'];
                $ProductosController->registrarSubcategoria($Nombre, $ID_Categoria, $ID_Crea, $NombreCreo); 
            } elseif ($manejaCategoria === "no") {
                $ProductosController->registrarCategoria($Nombre,  $ID_Crea, $NombreCreo); 
            }
        }
    }
    if (isset($_POST['Tipo2'])) {
        $Nombre = $_POST['nombreProducto'];
        $Descripcion = $_POST['descripcionProducto'];
        $ID_Categoria = $_POST['ID_Categoria1'];
        $manejaSubcategoria = $_POST['manejaSubcategoria'];
        $manejaInventario = $_POST['manejaInventario'];
        $NumeroParte = $_POST['numeroParte'];
        $NumeroSerie = $_POST['numeroSerie'];
        $stockMinimo = $_POST['stockMinimo'];
        if ($manejaSubcategoria === "si") {
            $ID_SubCategoria  = $_POST['ID_SubCategoria'];
        } elseif ($manejaSubcategoria === "no") {
            $ID_SubCategoria  = NULL;
        }
        if ($manejaInventario === "si") {
            $Centro = $_POST['ID_Centro'];
            $stockInicial = $_POST['stockInicial'];
            $ValorUnitario = 0;
            $Factura = NULL; 
        } elseif ($manejaInventario === "no") {
            $Centro = $_SESSION['NoCentro'];
            $stockInicial = 0;
            $ValorUnitario = 0;
            $Factura = NULL; 

        }
        if(empty($_POST['numeroParte'])){
            $NumeroParte = NULL;
        }
        if(empty($_POST['numeroSerie'])){
            $NumeroSerie = NULL;
        }
        $Foto = $_FILES['Foto'];
        $Estado = $_POST['tipoProducto'];
        $ProductosController->registrarProducto($Nombre, $Descripcion, $ID_Categoria, $ID_SubCategoria, $Foto, $Estado, $NumeroParte, $stockMinimo, $manejaInventario, $Centro, $stockInicial, $ID_Crea, $NombreCreo, $NumeroSerie, $ValorUnitario, $Factura);
    }  
    if (isset($_POST['Tipo']) && $_POST['Tipo'] == "DocumentoEntrega") {
        $No_Documento = $_POST['documentNumber'];
        $ID_Centro = $_POST['ID_Centro'];
        if($datausuario = $DotacionController->BuscarPersona($No_Documento)){
            echo "
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

    if (isset($_POST['Tipo3']) && $_POST['Tipo3'] == "DocumentoEntrega1") {
        $No_Documento = $_POST['documentNumber'];
        $ID_Centro = $_POST['ID_Centro'];
        if ($datausuario = $DotacionController->BuscarPersona($No_Documento)) {
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
                        window.location.href = 'Traslados?Documento=".$datausuario['Documento']."&Centro=".$ID_Centro."';
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
                <img width="50" height="50" src="https://img.icons8.com/ios/50/000020/warehouse-1.png" alt="warehouse-1" />
                <div class="ms-3">
                    <p class="mb-2" style="color: #000020;">Productos</p>
                    <h6 class="mb-0" style="color: #000020;"><?= $NoProductos['NoProductos'] ?></h6>
                </div>
            </div>
        </div>
        <a class="col-sm-6 col-xl-3" href="Registrar" data-bs-toggle="modal" data-bs-target="#agregarProductoModal">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <img width="50" height="50" src="https://img.icons8.com/ios/50/000020/new--v1.png" alt="new--v1" />
                <div class="ms-3">
                    <p class="mb-2" style="color: #000020;">Registrar producto</p>
                </div>
            </div>
        </a>
        <a class="col-sm-6 col-xl-3" href="Entrada">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <img width="50" height="50" src="https://img.icons8.com/pastel-glyph/100/000020/hand-truck--v1.png" alt="hand-truck--v2" style="transform: scaleX(-1);" />
                <div class="ms-3">
                    <p class="mb-2" style="color: #000020;">Registrar Entrada</p>
                </div>
            </div>
        </a>
        <a class="col-sm-6 col-xl-3" data-bs-toggle="modal" data-bs-target="#NumerDocumentoModal1">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <img width="50" height="50" src="https://img.icons8.com/pastel-glyph/64/000020/delivery-tracking--v2.png" alt="delivery-tracking--v2" />
                <div class="ms-3">
                    <p class="mb-2" style="color: #000020;">Traslados</p>
                </div>
            </div>
        </a>
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
                <img width="50" height="50" src="https://img.icons8.com/pastel-glyph/64/000020/create-new--v2.png" alt="create-new--v2" />
                <div class="ms-3">
                    <p class="mb-2" style="color: #000020;">Ajustes</p>
                </div>
            </div>
        </a>
        <a class="col-sm-6 col-xl-3" href="Registrar" data-bs-toggle="modal" data-bs-target="#agregarCategoriaModal">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <img width="50" height="50" src="https://img.icons8.com/ios/50/000020/categorize.png" alt="categorize" />
                <div class="ms-3">
                    <p class="mb-2" style="color: #000020;">Categorias</p>
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
                    echo '<h6 class="mb-0">Inventario Actual | ' . htmlspecialchars($Centro) . '</h6>';
                } else {
                    echo '<h6 class="mb-0">Inventario Actual | No disponible</h6>';
                }
            ?>
            <div>
                <a href="InicioCantidadTotal">Detalle</a>
                <a>|</a>
                <a href="InicioInventarioTotal">Ver Todas</a>
                <a>|</a>
                <a href="#">Descargar Excel</a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table text-start align-middle table-bordered table-hover mb-0" id="myTable">
                <thead>
                    <tr class="text-dark">
                        <th scope="col" class="text-center">Codigo</th>
                        <th scope="col" class="text-center">Cantidad</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Stock Minimo</th>
                        <th scope="col"></th>
                        <th scope="col" class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($Listas) {
                        foreach ($Listas as $Lista) {
                            $cantidad = (int)$Lista['Total_Cantidad'];
                            $stockMinimo = (int)$Lista['stockMinimo'];
                            if ($cantidad == 0) {
                                $estado = 'Sin Stock';
                                $tipoBoton = 'bg-gray'; 
                            } elseif ($cantidad < $stockMinimo) {
                                $estado = 'Stock Insuficiente';
                                $tipoBoton = 'bg-danger';
                            } elseif ($cantidad <= $stockMinimo * 1.5) {
                                $estado = 'Próximo a acabarse';
                                $tipoBoton = 'bg-warning';
                            } else {
                                $estado = 'Stock Suficiente';
                                $tipoBoton = 'bg-success';
                            }
                    ?>
                            <tr data-id="<?= htmlspecialchars($Lista['ID']) ?>">
                                <td width="100" class="text-center"><?= htmlspecialchars($Lista['Codigo_insumos']) ?></td>
                                <td width="100" class="text-center"><?= htmlspecialchars($Lista['Total_Cantidad']) ?></td>
                                <td><?= htmlspecialchars($Lista['Nombre_insumos']) ?></td>
                                <td><?= htmlspecialchars($Lista['stockMinimo']) ?></td>
                                <td>
                                    <div class="progress">
                                        <div class="progress-bar <?= $tipoBoton ?>" role="progressbar" style="width: 100%;" aria-valuemin="0" aria-valuemax="100">
                                            <?= htmlspecialchars($estado) ?>
                                        </div>
                                    </div>
                                </td>
                                <td width="200" class="text-center">
                                    <a class="btn btn-sm btn-success" href="Ver?ID=<?= htmlspecialchars($Lista['ID_Insumo']) ?>">
                                        <img width="20" height="20" src="https://img.icons8.com/material-outlined/24/ffffff/visible--v1.png" alt="Ver" /> 
                                    </a>
                                    <a class="btn btn-sm btn-primary" target="_blank" href="CodigoBarras?Codigo=<?= urlencode(htmlspecialchars($Lista['Codigo_insumos'])) ?>&Nombre=<?= urlencode(htmlspecialchars($Lista['Nombre_insumos'])) ?>">
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
<!-- Modal Registrar Porducto-->
<div class="modal fade" id="agregarProductoModal" tabindex="-1" aria-labelledby="agregarProductoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="agregarProductoModalLabel">Agregar Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="documentForm" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <!-- Imagen de Presentación -->
                        <div class="col-md-4 text-center">
                            <img id="imagenPreview" src="https://via.placeholder.com/150" alt="Imagen de Presentación" class="img-fluid mb-3">
                            <div class="mb-3">
                                <label for="imagenProducto" class="form-label">Subir Imagen</label>
                                <input class="form-control" type="file" name="Foto" id="imagenProducto" accept="image/*" required>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="tipoProducto" id="Nuevo" value="Nuevo" checked>
                                <label class="form-check-label" for="Nuevo" >Nuevo</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="tipoProducto" id="Usado" value="Usado">
                                <label class="form-check-label" for="Usado" >Usado</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="tipoProducto" id="Remanufacturado" value="Remanufacturado">
                                <label class="form-check-label" for="Remanufacturado" >Remanufacturado</label>
                            </div>
                        </div>
                        <!-- Formulario -->
                        <div class="col-md-8">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="nombreProducto" class="form-label">Nombre</label>
                                        <input type="text" class="form-control" name= "nombreProducto" id="nombreProducto" placeholder="Nombre" required>
                                        <input type="hidden" name="Tipo2">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="descripcionProducto" class="form-label">Descripción</label>
                                        <textarea class="form-control" name="descripcionProducto" id="descripcionProducto" placeholder="Describir producto" required></textarea>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="categoriaProducto" class="form-label">Categoría</label>
                                        <select class="form-select" name="ID_Categoria1" id="ID_Categoria1" aria-label="Seleccione una categoría" onchange="cargarSubcategorias()" required> 
                                            <option value="" disabled selected>Categorías</option>
                                                <?php
                                                if ($ListaCategorias) {
                                                    foreach ($ListaCategorias as $ListaCategoria) {
                                                        echo "<option value='{$ListaCategoria['ID']}'>{$ListaCategoria['Nombre']}</option>";
                                                    }
                                                }
                                                ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="manejaSubcategoria" class="form-label">¿Tiene Subcategoría?</label>
                                        <select class="form-select" name="manejaSubcategoria" id="manejaSubcategoria" onchange="mostrarSubcategoria()" required>
                                            <option value="" selected>------</option>
                                            <option value="si" >Si</option>
                                            <option value="no">No</option>
                                        </select>
                                    </div>
                                </div>

                                <div id="SubcategoriaFields" class="d-none">
                                    <div class="col-md-6">
                                        <label for="categoriaProducto" class="form-label">Subcategoría</label>
                                        <select class="form-select" name="ID_SubCategoria" id="ID_SubCategoria" aria-label="Seleccione una subcategoría">
                                            <option value="" disabled selected>Seleccione una subcategoría</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="numeroParte" class="form-label">Número Parte</label>
                                        <input type="text" class="form-control" name="numeroParte" id="numeroParte" placeholder="Número Parte">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="numeroSerie" class="form-label">Número Serie</label>
                                        <input type="text" class="form-control" name="numeroSerie" id="numeroSerie" placeholder="Número Serie">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="stockMinimo" class="form-label">Stock Minimo</label>
                                        <input type="number" class="form-control" name="stockMinimo" id="stockMinimo" placeholder="Ingrese el stock minimo">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="manejaInventario" class="form-label">¿Maneja Inventario?</label>
                                        <select class="form-select" name="manejaInventario" id="manejaInventario" onchange="mostrarInventario()" required>
                                            <option selected>------</option>
                                            <option value="si" >Si</option>
                                            <option value="no">No</option>
                                        </select>
                                    </div>
                                </div>
                                                  
                                <!-- Campos de Inventario -->
                                <div id="inventarioFields" class="d-none">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="bodegaProducto" class="form-label">Centro de trabajo</label>
                                            <select class="form-select" name="ID_Centro" id="ID_Centro" aria-label="Floating label select example" required>
                                                <option disabled selected>Centros de trabajo</option>
                                                <?php
                                                    if ($ListaCentrosDeTrabajo) {
                                                        foreach ($ListaCentrosDeTrabajo as $ListaCentroDeTrabajo) {
                                                ?>
                                                    <option value="<?= $ListaCentroDeTrabajo['ID'] ?>"><?= $ListaCentroDeTrabajo['Nombre'] ?></option>
                                                <?php
                                                    }}
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="stockInicial" class="form-label">Stock Inicial</label>
                                            <input type="number" class="form-control" name="stockInicial" id="stockInicial" placeholder="Ingrese el stock inicial">
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Agregar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal Registrar Categoria-->
<div class="modal fade" id="agregarCategoriaModal" tabindex="-1" aria-labelledby="agregarCategoriaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header bg-primary ">
                <h5 class="modal-title text-white" id="agregarProductoModalLabel">Agregar Categoria</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Formulario -->
                    <div class="row md-12">
                        <form id="documentForm" method="POST" >
                            <div class="col-md-12">
                                <label for="nombreCategoria" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombreCategoria" name="nombreCategoria" placeholder="Nombre" required>
                                <input type="hidden" name="Tipo1" value="NombreCategoria">
                            </div>
                            <div class="col-md-12">
                                <label for="manejaCategoria" class="form-label">¿SubCategoría?</label>
                                <select class="form-select" id="manejaCategoria" name="manejaCategoria" onchange="mostrarCategoria()" required>
                                    <option value="" disabled selected>-------</option>
                                    <option value="si">Sí</option>
                                    <option value="no">No</option>
                                </select>
                            </div>
                            <!-- Campos de Categoria -->
                            <div id="categoriaFields" class="d-none">
                                <div class="row md-12">
                                    <div class="col-md-12">
                                        <label for="Categoria" class="form-label">Categoría</label>
                                            <select class="form-select" name="ID_Categoria" id="ID_Categoria" aria-label="Seleccione una categoría">
                                                <option value="" disabled selected>Categorías</option>
                                                <?php
                                                    if ($ListaCategorias) {
                                                        foreach ($ListaCategorias as $ListaCategoria) {
                                                            echo "<option value='{$ListaCategoria['ID']}'>{$ListaCategoria['Nombre']}</option>";
                                                        }
                                                    }
                                                ?>
                                            </select>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mt-3">Agregar</button>
                        </form>
                    </div>
                </div>
            </div>
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

<div class="modal fade" id="NumerDocumentoModal1" tabindex="-1" aria-labelledby="NumerDocumentoModalLabel" aria-hidden="true">
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
                        <input type="hidden" name="Tipo3" value="DocumentoEntrega1">
                    </div>
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Script para vista previa de la imagen -->
<script>
    document.getElementById('imagenProducto').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imagenPreview').src = e.target.result;}
                reader.readAsDataURL(file);}
    });

    function mostrarInventario() {
        const seleccion = document.getElementById('manejaInventario').value;
        const inventarioFields = document.getElementById('inventarioFields');
        if (seleccion === 'si') {
            inventarioFields.classList.remove('d-none');
            ID_SubCategoria.required = true;
            ID_SubCategoria.required = true;
        } else {
            inventarioFields.classList.add('d-none');
            ID_SubCategoria.required = false; 
            ID_SubCategoria.required = false; 
        }
    }

    function mostrarSubcategoria() {
        const seleccion = document.getElementById('manejaSubcategoria').value;
        const SubcategoriaFields = document.getElementById('SubcategoriaFields');
        if (seleccion === 'si') {
            SubcategoriaFields.classList.remove('d-none');
            ID_SubCategoria.required = true;
        } else {
            SubcategoriaFields.classList.add('d-none');
            ID_SubCategoria.required = false; 
        }
    }

    function mostrarCategoria() {
        const manejaCategoria = document.getElementById('manejaCategoria').value;
        const categoriaFields = document.getElementById('categoriaFields');
        const ID_Categoria = document.getElementById('ID_Categoria');

        if (manejaCategoria === "si") {
            categoriaFields.classList.remove('d-none');
            ID_Categoria.required = true;
        } else {
            categoriaFields.classList.add('d-none');  
            ID_Categoria.required = false; 
        }
    }

    function cargarSubcategorias() {
        const ID_Categoria = document.getElementById('ID_Categoria1').value;
        console.log('ID_Categoria enviado:', ID_Categoria);
        if (!ID_Categoria) return; 
        // Realizamos la solicitud AJAX
        $.get(`TraerSubcategorias?ID_Categoria=${ID_Categoria}`, function(data) {
            try {
                // Asegúrate de que la respuesta es un JSON válido
                const Subcategorias = Array.isArray(data) ? data : JSON.parse(data); // Aseguramos que data sea un array
                const SubcategoriaSelect = document.getElementById('ID_SubCategoria');
                const SubcategoriaFields = document.getElementById('SubcategoriaFields');
                
                console.log('Subcategorías recibidas:', Subcategorias);

                // Limpiar las opciones anteriores del select
                $('#ID_SubCategoria').empty();

                // Añadir la opción por defecto
                $('#ID_SubCategoria').append('<option value="" disabled selected>Seleccione una subcategoría</option>');

                // Comprobar si hay subcategorías
                if (Subcategorias.length > 0) {
                    // Llenar el select con las subcategorías
                    Subcategorias.forEach(subcategoria => {
                        $('#ID_SubCategoria').append(`<option value="${subcategoria.ID}">${subcategoria.Nombre}</option>`);
                    });
                }
            } catch (error) {
                console.error('Error al procesar las subcategorías:', error);
            }
        }).fail(function(xhr, status, error) {
            console.error('Error en la solicitud AJAX:', error);
        });
    }


</script>
<?php require "App/Views/Templates/Layouts/Footer.php"; ?>