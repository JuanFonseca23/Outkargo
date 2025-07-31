<?php
    session_start();
    if (empty($_SESSION['ID'])) {
        header("location:../IniciarSesion");
        exit;
    }
    
    include_once "App/Controllers/UsuarioController.php";
    include_once "App/Controllers/DotacionController.php";
    $UsuariosController = new UsuarioController();
    $DotacionController = new DotacionController;
    $No_Documento = $_GET['Documento'];
    $DataUsuario = $DotacionController->BuscarPersona($No_Documento);
    $Filas = $DotacionController->DetallesEntrega($DataUsuario['ID'], $_SESSION['ID']);
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>OUTKARGO - Administrador</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="description" content="OUTKARGO ofrece servicios de alquiler de montacargas con y sin operador en Colombia. Contamos con una amplia flota de montacargas para cubrir tus necesidades de carga y descarga.">
    <meta name="keywords" content="OUTKARGO, alquiler de montacargas, montacargas con operador, montacargas sin operador, Colombia, Montacargas, Pasillo angosto, Toma Pedido, Contrabalanceada, Contrabalanceado, Snorlift, Manlift, Lift, Combustion Interna, Diesel, Gas">
    <link rel="icon" href="../Favicon.ico" type="image/x-icon" >

    <!-- JavaScript -->
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <!-- CSS -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
    <!-- Default theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>



    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link rel= "stylesheet" href= "https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css" >
    <link href="../../App/Views/Resources/Lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="../../App/Views/Resources/Lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />
    <!-- Template Stylesheet -->
    <link href="../../App/Views/Resources/Css/Dashboard/style.css" rel="stylesheet">
</head>
<body>
    <style>
        body{
            font-family: Arial, Helvetica, sans-serif;
        }
        table{
            width: 100%;
        }

        #signature-pad {
            border: 2px solid #000;
            width: 100%;
            max-width: 500px; /* Ancho máximo del lienzo de firma */
            height: auto; /* Altura automática para ajustar proporcionalmente al ancho */
        }
    </style>
    <?php       
        if ($dataUltimaEntrega = $DotacionController->TraerUltimoRegistro($_SESSION['ID'])) {
            echo "<script>alertify.success('Producto Agregado correctamente. ".$dataUltimaEntrega['Codigo_Producto']." - ".$dataUltimaEntrega['Nombre_producto']."');</script>";
            $DotacionController->EilinarUltimoRegistro($_SESSION['ID']);
        }else{
            echo "<script>alertify.message('Por favor digite un codigo en el campo.');</script>";
        }
    ?>
    <table border="1">
        <thead>
            <tr>
                <th rowspan="3"><img src="../App/Views/Img/Outkargo.png" width="200px"></th>
                <th rowspan="3" class="Titulo" style="font-size: 20px;">ACTA ENTREGA DE DOTACIÓN</th>
                <th>CODIGO:</th>
                <td>F-16</td>
            </tr>
            <tr>
                <th>FECHA:</th>
                <td>17-05-2024</td>
            </tr>
            <tr>
                <th>VERSIÓN:</th>
                <td>2</td>
            </tr>
        </thead>
    </table>
    <p><b>Fecha: </b> <?= date("d-m-Y") ?></p>
    <p><b>Señor: </b> <?= $DataUsuario['NombreCompleto'] ?></p>
    <p>Con la presente acta <b>OUTKARGO LTDA</b> le hace entrega de la siguiente dotación:</p>
    <table border="1">
        <tbody>
            <tr>
                <th width="50px">#</th>
                <th width="50px">Cantidad</th>
                <th width="100px">Codigo</th>
                <?php
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        if ($_POST['Tipo'] == "1") {
                            $Codigo = $_POST['Codigo'];
                            $ID_Usuario = $_POST['Usuario'];
                            $DotacionController->InsertarEntregaTemp($Codigo,$ID_Usuario, $_SESSION['NoCentro'], $No_Documento);
                        }  
                        if ($_POST['Tipo'] == "2") {
                            $Codigo = $_POST['Codigo'];
                            $ID_Usuario = $_POST['Usuario'];
                            $DotacionController->RestarEntregaTemp($Codigo, $ID_Usuario, $No_Documento);
                        }    
                        if ($_POST['Tipo'] == "3") {
                            $Codigo = $_POST['Codigo'];
                            $ID_Usuario = $_POST['Usuario'];
                            $DotacionController->EliminarEntregaTemp($Codigo, $ID_Usuario, $No_Documento);
                        }                       
                    }
                ?>
                <form method="post">
                    <td><input type="number" name="Codigo" autofocus></td>
                    <input type="hidden" name="Usuario" value="<?= $_SESSION['ID'] ?>">
                    <input type="hidden" name="Tipo" value="1">
                </form>   
                <th>Acciones</th>             
            </tr>
            <?php
                $Numero = 0;
                if ($Filas) {
                    foreach ($Filas as $Fila) {
                        if ($Fila['Cantidad'] > 0) {
                            $Numero = $Numero + 1;
            ?>
                        <tr>
                            <th><?= $Numero ?></th>
                            <td style="text-align: center;"><?= $Fila['Cantidad'] ?></td>
                            <td><?= $Fila['Codigo_Producto'] ?></td>
                            <td><?= $Fila['Nombre_producto'] ?></td>
                            <td style="text-align: center;">
                            <form method="post" onsubmit="disableButton(this)" style="display: inline-block; margin: 0;">
                                <input type="hidden" name="Usuario" value="<?= $_SESSION['ID'] ?>">
                                <input type="hidden" name="Codigo" value="<?= $Fila['Codigo_Producto'] ?>">
                                <input type="hidden" name="Tipo" value="2">
                                <input type="submit" id="button2" style="background-color: #ffc700; color: black; border: none; padding: px; cursor: pointer; align-items: center; justify-content: center; width: 24px; height: 24px; border-radius: 10%; box-sizing: border-box; font-size: 14px; font-weight: bold;" value="-">
                            </form>
                            <form method="post" onsubmit="disableButton(this)" style="display: inline-block; margin: 0;">
                                <input type="hidden" name="Usuario" value="<?= $_SESSION['ID'] ?>">
                                <input type="hidden" name="Codigo" value="<?= $Fila['Codigo_Producto'] ?>">
                                <input type="hidden" name="Tipo" value="3">
                                <input type="submit" id="button3" style="background-color: #a60000; color: white; border: none; padding: 0; cursor: pointer; display: flex; align-items: center; justify-content: center; width: 24px; height: 24px; border-radius: 10%; box-sizing: border-box; font-size: 12px;" value="X">
                            </form>
                        </tr>
            <?php
                        }
                    }
                }
            ?>
        </tbody>
    </table>
    <p>La dotación que aqui se entrega es y será de la empresa en todo momento.</p>
    <ul>
        <li>En caso de daño o desgaste debe reportarse, para hacerle entrega de una nueva dotación.</li>
        <li>Cuando haya terminación del contrato de trabjo, debe hacer la devolución de forma inmediata de todo lo entregado.</li>
    </ul>
    <table border="1">
        <thead>
            <tr>
                <th>Entrega</th>
                <th>Recibe</th>
            </tr>
        </thead>
        <Tbody>
            <tr height="100px">
                <td style="width: 50vh;"></td>
                <td style="width: 50vh;"></td>
            </tr>
            <tr>
                <th><?= $_SESSION['NombreCompleto'] ?></th>
                <th><?= $DataUsuario['NombreCompleto'] ?></th>
            </tr>
            <tr>
                <th>Firma</th>
                <th>Firma</th>
            </tr>
        </Tbody>
        <tfoot>
            <tr>
                <td><b>Cedula: </b><?= $_SESSION['Documento'] ?></td>
                <td><b>Cedula:</b><?= $DataUsuario['Documento'] ?> </td>
            </tr>
        </tfoot>
    </table>
    <a id="dynamicLink" href="GuardarEntrega?Cedula=<?= $DataUsuario['ID'] ?>&Centro=<?= $DataUsuario['ID_Centro'] ?>">Guardar entrada</a>

    <script>
        function disableButton(form) {
            var submitButton = form.querySelector('input[type="submit"]');
            submitButton.disabled = true;
        }
    </script>
</body>
</html>

