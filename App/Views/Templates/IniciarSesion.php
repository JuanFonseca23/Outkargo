<?php
    include "App/Controllers/UsuarioController.php";
    include "App/Controllers/PaginaController.php";
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OUTKARGO | Iniciar Sesion</title>
    <link rel="stylesheet" type="text/css" href="App/Views/Css/Login.css">
    <link rel="icon" href="App/Views/Img/favicon.png" type="image/gif" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" href="Favicon.ico" type="image/x-icon" >

</head>
<body>
    <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $Documento = $_POST['Nombre'];
            $Clave = $_POST['Password'];
            $Usuario = new UsuarioController();
            $Usuario->IniciarSesion($Documento, $Clave);
        }
        $Pagina = new PaginaController;
        $Pagina->ValidarSiExisteSession();
    ?>
    <div class="wrapper">
        <form method="POST">
            <h2>Iniciar Sesión</h2>
            <div class="input-field">
                <input type="text" required name="Nombre">
                <label>Usuario</label>
            </div>
            <div class="input-field">
                <input type="password" required name="Password">
                <label>Contraseña</label>
            </div>
            <div class="forget">
                <a href="#">Olvidaste tu contraseña?</a>
            </div>
            <input type="hidden" name="redirect_url" value="<?php echo isset($_SESSION['redirect_url']) ? $_SESSION['redirect_url'] : ''; ?>">
            <button type="submit">Ingresar</button>
        </form>
    </div>
</body>

</html>