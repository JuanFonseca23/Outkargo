<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OUTKARGO | Iniciar Sesion</title>
    <link rel="stylesheet" type="text/css" href="App/Views/Css/Login.css">
    <link rel="icon" href="App/Views/Img/favicon.png" type="image/gif" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body>
<?php
    require "App/Controllers/UsuarioController.php";
    $Usuario = new UsuarioController;
    $Usuario->CerrarSesion();
?>
</body>
</html>