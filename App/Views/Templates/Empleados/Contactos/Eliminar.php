<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>
<body>
    <?php
        require_once "App/Controllers/UsuarioController.php";
        require_once "App/Controllers/ContactosController.php";
        $UsuarioController = new UsuarioController();
        $ContactosController = new ContactosController();
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
        $ID_Usuario = $_GET['ID_Usuario'];
        session_start();
        $DataUsuario = $UsuarioController->Mostrar($ID_Usuario);
        $Nombre1 = $DataUsuario['Nombre1'];
        $ContactosController->EliminarContacto($_SESSION['ID'], $_SESSION['Nombre1'],$ID,$Nombre1, $ID_Usuario);   
    ?>
</body>
</html>