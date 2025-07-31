<?php
    require_once "App/Views/Templates/Layouts/Header.php";
    include_once "App/Controllers/ContactosController.php";
    include_once "App/Controllers/UsuarioController.php";    
    $UsuarioController = new UsuarioController();
    $ContactosController = new ContactosController();   

    if (!isset($_GET['ID'])) {
        echo "
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
            </script>
        ";
        exit();
    } 
    $ID = $_GET['ID'];      
    $ID_Usuario = $UsuarioController->Mostrar($ID);
    if ($ID_Usuario) {
        $NombreUsuario = $ID_Usuario['Nombre1']
?>
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-12 col-xl-12">
            <div class="bg-light rounded h-100 p-4">
                <?php
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $NombreCompleto = $_POST['Nombre']." ".$_POST['Apellido'];
                        $Telefono = $_POST['Telefono'];
                        $EstadoContacto = 1;
                        $Fecha_Creado = date('Y-m-d');
                        $Resultado = $ContactosController->RegistrarContacto($_SESSION['ID'], $_SESSION['Nombre1'], $NombreUsuario,$ID, $NombreCompleto, $Telefono, $EstadoContacto, $Fecha_Creado);
                        
                        if ($Resultado) {
                            echo "
                                <script>
                                    Swal.fire({
                                        title: '!Registrado',
                                        text: 'El contacto fue registrado correctamente',
                                        icon: 'success',
                                        timer: 2000,
                                        timerProgressBar: true,
                                        didClose: () => {
                                            window.location.href = 'Ver?ID=".$ID."';
                                        }
                                    });
                                </script>
                            ";
                        }
                    }                    
                ?>
                <form method="post" enctype="multipart/form-data">
                    <h6 class="mb-4">Registrar Nuevo Contacto</h6>
                    <div class="form-floating mb-3">
                        <input type="text" name="Nombre" class="form-control" id="floatingInput" placeholder="Primer Nombre" required>
                        <label for="floatingInput">Nombre</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" name="Apellido" class="form-control" id="floatingInput" placeholder="Primer Apellido" required>
                        <label for="floatingInput">Apellido</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="number" name="Telefono" class="form-control" id="floatingInput" placeholder="Telefono" required>
                        <label for="floatingInput">Telefono</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Registrar</button>
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
