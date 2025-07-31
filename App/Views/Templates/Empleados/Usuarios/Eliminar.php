<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php
        require_once "App/Controllers/UsuarioController.php";
        $UsuarioController = new UsuarioController();
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
        session_start();
        $DataUsuario = $UsuarioController->Mostrar($ID);
        $Nombre1 = $DataUsuario['Nombre1'];
        $UsuarioController->DesactivarUsuario($_SESSION['ID'], $_SESSION['Nombre1'],$ID,$Nombre1);   
    ?>
</body>
</html>