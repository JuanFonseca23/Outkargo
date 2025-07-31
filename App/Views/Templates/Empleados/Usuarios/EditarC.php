<?php
    include_once "App/Controllers/UsuarioController.php";
    require_once "App/Views/Templates/Layouts/Header.php";
    include_once "App/Controllers/CentroDeTrabajoController.php";
    $CentrosDeTrabajo = new CentroDeTrabajoController;
    $UsuarioController = new UsuarioController();
    $ListaCentrosDeTrabajo = $CentrosDeTrabajo->TraerCentrosDeTrabajo();
    $ListasCargos = $CentrosDeTrabajo->ListaCargos();
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
    $UsuarioRegistrado = $UsuarioController->Mostrar($ID);
    if ($UsuarioRegistrado) {
?>
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-12 col-xl-12">
            <div class="bg-light rounded h-100 p-4">
                <?php
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $RH = $_POST['RH'];
                        $EPS = $_POST['EPS'];
                        $ARL = $_POST['ARL'];
                        $UsuarioController->EditarC($_SESSION['ID'], $_SESSION['Nombre1'],$ID, $RH, $EPS, $ARL);
                    }
                ?>
                <form method="post" enctype="multipart/form-data">
                    <h6 class="mb-4">Editar Carnet de Usuario</h6>
                    <div class="form-floating mb-3">
                        <input type="text" name="RH" class="form-control" id="floatingInput" placeholder="Grupo sanguíneo" required value="<?= $UsuarioRegistrado['RH'] ?>">
                        <label for="floatingInput">Grupo sanguíneo</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" name="EPS" class="form-control" id="floatingInput" placeholder="EPS" required value="<?= $UsuarioRegistrado['EPS'] ?>">
                        <label for="floatingInput">EPS</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" name="ARL" class="form-control" id="floatingInput" placeholder="ARL" required value="<?= $UsuarioRegistrado['ARL'] ?>">
                        <label for="floatingInput">ARL</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar</button>
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