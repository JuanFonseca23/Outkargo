<?php
require_once "App/Views/Templates/Layouts/Header.php";
include_once "App/Controllers/DotacionController.php";

$DotacionController = new DotacionController();
?>

<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-12 col-xl-12">
            <div class="bg-light rounded h-100 p-4">
                <?php
                    $codigoGenerado = null;

                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $Nombre = $_POST['Nombre'];
                        
                        // Registrar el producto
                        $codigoGenerado = $DotacionController->RegistrarProducto($_SESSION['ID'], $_SESSION['Nombre1'], $Nombre);

                        if ($codigoGenerado) {
                            echo "
                            <script>
                                Swal.fire({
                                    title: 'Éxito!',
                                    text: 'Producto registrado con éxito. Código: $codigoGenerado',
                                    icon: 'success',
                                    timer: 2000,
                                    timerProgressBar: true,
                                    didClose: () => {
                                        window.open('CodigoBarras?Codigo=$codigoGenerado&Nombre=" . urlencode($Nombre) . "', '_blank');
                                        window.location.href = 'Inicio'; // Redirige a la página de inicio
                                    }
                                });
                            </script>";
                        } else {
                            echo "
                            <script>
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Error al registrar el producto.',
                                    icon: 'error',
                                    timer: 2000,
                                    timerProgressBar: true
                                });
                            </script>";
                        }
                    }
                ?>
                <form method="post" enctype="multipart/form-data">
                    <h6 class="mb-4">Registrar Nuevo Producto</h6>
                    <div class="form-floating mb-3">
                        <input type="text" name="Nombre" class="form-control" id="floatingInput" placeholder="Nombre" required>
                        <label for="floatingPassword">Nombre</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Registrar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require "App/Views/Templates/Layouts/Footer.php"; ?>
