<?php
    include "App/Controllers/UsuarioController.php";
    include "App/Controllers/PaginaController.php";
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OUTKARGO | Activar_Cuenta</title>
    <link rel="stylesheet" type="text/css" href="App/Views/Css/Login.css">
    <link rel="icon" href="App/Views/Img/favicon.png" type="image/gif" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <?php
        if (isset($_GET['ID'])) {
            $ID_Usuario = $_GET['ID'];            
            // Instanciar el controlador de usuario
            $usuarioController = new UsuarioController();
            $DataUsuario = $usuarioController->Mostrar($ID_Usuario);
            $Nombre1 = $DataUsuario['Nombre1'];
        
            // Activar la cuenta del usuario
            $resultado = $usuarioController->ActivacionCuenta(1, $ID_Usuario, $Nombre1); // 1 para activado
            
            if ($resultado) {
                echo "
                <script>
                    Swal.fire({
                        title: 'Éxito!',
                        text: 'Usuario activado exitosamente',
                        icon: 'success',
                        timer: 2000,
                        timerProgressBar: true,
                        didClose: () => {
                            window.location.href = 'Inicio'; // Redirige a la página 'Inicio' después de 2 segundos
                        }
                    });
                </script>";
            } else {
                echo "
                <script>
                    Swal.fire({
                        title: 'Fallo!',
                        text: 'Usuario No activo',
                        icon: 'Error',
                        timer: 2000,
                        timerProgressBar: true,
                        didClose: () => {
                            window.location.href = 'Inicio'; // Redirige a la página 'Inicio' después de 2 segundos
                        }
                    });
                </script>";
            }
        } 
    ?>
</body>

