<?php
    include_once "App/Controllers/UsuarioController.php";
    require_once "App/Views/Templates/Layouts/Header.php";
    include_once "App/Controllers/ComparendosController.php";
    
    $UsuarioController = new UsuarioController();
    $ComparendosController = new ComparendosController();

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
    $ID = $_GET['ID'];      
    $ID_Usuario = $UsuarioController->Mostrar($ID);
    if ($ID_Usuario) {
        $NombreUsuario = $ID_Usuario['Nombre1'];
        $DocumentoUsuario = $ID_Usuario['Documento']
?>
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-12 col-xl-12">
            <div class="bg-light rounded h-100 p-4">
                <?php
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $Nombre = $_POST['Nombre'];
                        $Fecha_Realizado = $_POST['Fecha_Realizado'];
                        $Fecha_Pagado = $_POST['Fecha_Pagado'];
                        $Documento = $_FILES['Documento'];
                        $ComparendosController->IngresarComparendos($_SESSION['ID'], $_SESSION['Nombre1'], $ID, $Nombre, $Fecha_Realizado, $Documento, $Fecha_Pagado, $NombreUsuario, $DocumentoUsuario);
                    }
                ?>
                <form method="post" enctype="multipart/form-data">
                    <h6 class="mb-4">Ingresar Comparendo</h6>
                    <div class="form-floating mb-3">
                        <input type="text" name="Nombre" class="form-control" id="floatingInput" placeholder="Nombre" required>
                        <label for="floatingInput">Nombre</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="date" name="Fecha_Realizado" class="form-control" id="floatingInput" required>
                        <label for="floatingInput">Fecha de Realizado</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="date" name="Fecha_Pagado" class="form-control" id="floatingInput">
                        <label for="floatingInput">Fecha de Pago</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="file" name="Documento" class="form-control" id="floatingFile" accept=".pdf" required>
                        <label for="floatingFile">Subir Documento PDF</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Ingresar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
    }
?>
<script>
    document.getElementById('formFile').addEventListener('change', function(event) {
        var input = event.target;
        var reader = new FileReader();
        reader.onload = function(){
            var dataURL = reader.result;
            var output = document.getElementById('preview');
            output.src = dataURL;
        };
        reader.readAsDataURL(input.files[0]);
    });
</script>
<?php require "App/Views/Templates/Layouts/Footer.php"; ?>