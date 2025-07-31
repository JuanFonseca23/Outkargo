<?php
    require_once "App/Views/Templates/Layouts/Header.php";
    include_once "App/Controllers/UsuarioController.php";
    include_once "App/Controllers/ProductosController.php";
    if (empty($_SESSION['ID'])) {
        header("location:../IniciarSesion");
        exit;
    }
    $UsuariosController = new UsuarioController();
    $ProductosController = new ProductosController;

    $DataEntrada = $ProductosController->VerEntrada($_GET['ID'], $_SESSION['NoCentro']);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $Descripcion = $_POST['Comentario'];
        $NoFormulario = $_POST['NoFormulario'];      
        $ProductosController->AnularDotacionEntrada($_GET['ID'], $_SESSION['ID'], $_SESSION['Nombre1'], $Descripcion, $NoFormulario);
    }
?>

<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-12 col-xl-12">
            <div class="bg-light rounded h-100 p-4">
                <form method="post" enctype="multipart/form-data">
                    <h6 class="mb-4">Anular Entrada</h6>
                    <div class="form-floating mb-3">
                        <input name="NoFormulario" class="form-control" id="floatingInput" value=<?= $DataEntrada['Numero'] ?> required readonly>
                        <label for="floatingInput">No. de formulario</label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea name="Comentario" class="form-control" id="floatingTextarea" placeholder="Escribe un comentario" required></textarea>
                        <label for="floatingTextarea">Comentario</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Anular</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    const fileInput = document.getElementById('formFile');
    const previewImage = document.getElementById('preview');
    fileInput.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });
</script>
<?php require "App/Views/Templates/Layouts/Footer.php"; ?>