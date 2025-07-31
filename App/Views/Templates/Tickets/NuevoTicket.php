<?php
require_once "App/Views/Templates/Layouts/Header.php";
include_once "App/Controllers/UsuarioController.php";
include_once "App/Controllers/DotacionController.php";
include_once "App/Controllers/TicketsController.php";

if (empty($_SESSION['ID'])) {
    header("location:../IniciarSesion");
    exit;
}

$UsuariosController = new UsuarioController();
$TicketsController = new TicketsController();
$DataSistemas = $UsuariosController->obtenerSistemas();
$correos = [];
if (!empty($DataSistemas)) {
    foreach ($DataSistemas as $usuario) {
        $correos[] = $usuario['Correo'];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ID_Solicitante = $_SESSION['ID'];
    $Nombre1 = $_SESSION['Nombre1'];
    $NombreCompleto = $_SESSION['NombreCompleto'];
    $Centro = $_SESSION['Centro'];
    $Tipo = $_POST['Tipo_Ticket']; 
    $Descripcion = $_POST['Descripción'];
    $Evidencia_Fotografica = $_FILES['Fotos'];

    $TicketsController->RegistrarTicket($ID_Solicitante, $NombreCompleto, $Centro, $Tipo, $Descripcion, $Evidencia_Fotografica, $correos, $Nombre1);
}


?>

<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-12 col-xl-12">
            <div class="bg-light rounded h-100 p-4">
                <form method="post" enctype="multipart/form-data">
                    <h6 class="mb-4">Nuevo Ticket</h6>
                    <div class="form-floating mb-3">
                        <input name="NoFormulario" class="form-control" id="floatingInput" value="<?= $_SESSION['NombreCompleto'] ?>" required readonly>
                        <label for="floatingInput">Nombre</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input name="Centro" class="form-control" id="floatingInput" value="<?= $_SESSION['Centro'] ?>" required readonly>
                        <label for="floatingInput">Centro</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" name="Tipo_Ticket" id="floatingSelect" aria-label="Floating label select example" required>
                            <option disabled selected>----</option>
                            <option value="Registro">Registro</option>
                            <option value="Falla">Falla</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Eliminar">Eliminar</option>
                        </select>
                        <label for="floatingSelect">Seleccione el tipo de ticket</label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea name="Descripción" class="form-control" id="floatingTextarea" placeholder="Descripción" required oninput="autoResize(this)"></textarea>
                        <label for="floatingTextarea">Descripción del ticket:</label>
                    </div>
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Seleccione las imágenes</label>
                        <input class="form-control" type="file" name="Fotos[]" id="formFile" accept="image/*" multiple required>
                    </div>
                    <button type="submit" class="btn btn-primary">Crear Ticket</button>
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

    function autoResize(textarea) {
        textarea.style.height = 'auto';
        textarea.style.height = textarea.scrollHeight + 'px';
    }
</script>

<?php require "App/Views/Templates/Layouts/Footer.php"; ?>
