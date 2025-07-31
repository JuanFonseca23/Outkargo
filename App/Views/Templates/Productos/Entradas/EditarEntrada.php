<?php
    session_start();
    if (empty($_SESSION['ID'])) {
        header("location:../IniciarSesion");
        exit;
    }
    include_once "App/Controllers/UsuarioController.php";
    include_once "App/Controllers/ProductosController.php";
    $UsuariosController = new UsuarioController();
    $ProductosController = new ProductosController;
    $DataEntrada = $ProductosController->VerEntrada($_GET['ID'], $_SESSION['NoCentro']);
    $Filas = $ProductosController->DetallesEntrada($_SESSION['ID']);
    $NombreEdita = $_SESSION['Nombre1'];

    date_default_timezone_set('America/Bogota');
    $Fecha = date("d/m/Y");
    $Dia = date("d");
    $Mes = date("m");
    $Ano = date("Y");

    if ($DataEntrada){
        if($DataEntrada['Estado'] == 1){
            $Filas = $ProductosController->MostrarDetallesProductosEntrada($_GET['ID']);
        }
        else if ($DataEntrada['Estado'] == 2){
            $Filas = $ProductosController->MostrarDetallesProductosEntradaTemp($_GET['ID']);
        }
        else if ($DataEntrada['Estado'] == 3){
            $Filas = NULL;
        }
    }
    $Estado = $DataEntrada['Estado'];
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        
        if ($_POST['Tipo'] == "1") {
            $Codigo = $_POST['Codigo'];
            $ID_Usuario = $_POST['Usuario'];
            $Cantidad = $_POST['Cantidad'];
            $N_Factura = $_POST['N_Factura'];
            $valor_unitario = str_replace('.', '', $_POST['valor_unitario']);
            $Numero = $_POST['Numero'];
            $ID_Entrada = $_GET['ID'];
            $Centro = $_SESSION['NoCentro'];
            $ProductosController->EditarEntrada($Codigo, $ID_Usuario, $Cantidad, $N_Factura, $valor_unitario, $Numero, $NombreEdita, $ID_Entrada, $Centro, $Estado);
        }     
        if ($_POST['Tipo'] == "2") {
            $ID_Usuario = $_POST['Usuario'];
            $Numero = $_POST['Numero'];
            $Observaciones =$_POST['observaciones'];
            $ID_Entrada = $_GET['ID'];
            $Centro = $_SESSION['NoCentro'];
            $ProductosController->EditarEntradaObservaciones($ID_Usuario,  $Numero, $Centro, $Observaciones, $NombreEdita, $ID_Entrada);
        }                      
    }
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
            max-width: 500px; 
            height: auto; 
        }
    </style>
    <?php       
        if ($dataUltimaEntrada = $ProductosController->TraerUltimoRegistroEntrada($_SESSION['ID'])) {
            echo "<script>alertify.success('Producto Agregado correctamente. ".$dataUltimaEntrada['Codigo_Producto']." - ".$dataUltimaEntrada['Nombre_producto']."');</script>";
            $ProductosController->EliminarUltimoRegistroEntrada($_SESSION['ID']);
        }
    ?>
    <table border="1">
        <thead>
            <tr>
                <th rowspan="3"><img src="../App/Views/Img/Outkargo.png" width="200px"></th>
                <th rowspan="3" class="Titulo" style="font-size: 20px;">FORMATO ENTRADA DE PRODUCTOS</th>
                <th>CODIGO:</th>
                <td>F-249</td>
            </tr>
            <tr>
                <th>FECHA:</th>
                <td>28-01-2025</td>
            </tr>
            <tr>
                <th>VERSIÓN:</th>
                <td>1</td>
            </tr>
        </thead>
    </table>
    <table border="1">
        <thead>
            <tr>
                <th>Supervisado por:</th>
                <td><?= $DataEntrada['NombreSupervisor'] ?></td>
                <th>No.</th>
                <td style="color: red; text-align: center;"><?= $DataEntrada['Numero'] ?></td>
                <th>Fecha:</th>
                <td><?= $DataEntrada['Fecha_Realizado'] ?></td>
            </tr>               
        </thead>
        <tbody>
            <tr>
                
            </tr>
        </tbody>
    </table>
    <table id="tablaProductos" border="1" >
        <tbody>
            <tr>
                <th width="50px">#</th>
                <th width="50px">Cantidad</th>
                <th width="50px"></th>
                <th width="100px">Codigo</th>
                <th width="500px">Descripción</th>
                <th>Número de Factura</th>     
                <th>Valor Unitario</th>     
                <th>Valor Total</th>       
                <th>Acciones</th>             
            </tr>
            <?php
                $Numero = 0;
                $SumaTotal = 0;
                if ($Filas) {
                    foreach ($Filas as $Fila) {
                        if ($Fila['Cantidad'] > 0) {
                            $Numero = $Numero + 1;
                            $SumaTotal += $Fila['valor_total']; 
            ?>
                        <tr>
                            <form method="post" onsubmit="disableButton(this)" style="display: inline-block; margin: 0;">
                                <th><?= $Numero ?></th>
                                <td style="text-align: center;"><?= $Fila['Cantidad'] ?></td>
                                <td style="text-align: center;"><?= $Fila['Medida'] ?></td>
                                <td style="text-align: center;"><?= $Fila['Codigo'] ?></td>
                                <td><?= $Fila['Nombre'] ?></td>
                                <td><input name="N_Factura" value="<?= $Fila['N_Factura'] ?>"></td>
                                <td><input name="valor_unitario" value="<?= number_format($Fila['valor_unitario'], 0, ',', '.') ?>"></td>
                                <td style="text-align: center;">$<?= number_format($Fila['valor_total'], 0, ',', '.') ?></td>
                                <td style="text-align: center;">
                                <input type="hidden" name="Usuario" value="<?= $_SESSION['ID'] ?>">
                                <input type="hidden" name="Codigo" value="<?= $Fila['Codigo'] ?>">
                                <input type="hidden" name="Cantidad" value="<?= $Fila['Cantidad'] ?>">
                                <input type="hidden" name="Numero" value="<?= $DataEntrada['Numero'] ?>">
                                <input type="hidden" name="Tipo" value="1">
                                <input type="submit" id="button1" style="background-color: #007bff; color: white; border: none; padding: 0 px; cursor: pointer; display: flex; align-items: center; justify-content: center; width: 70px; height: 28px; border-radius: 10%; box-sizing: border-box; font-size: 12px;" value="Guardar">
                            </form>
                        </tr>
            <?php
                        }
                    }
                }
            ?>
            <tr>
                <th colspan="7">Total</th>
                <th style="text-align: center;">$<?= number_format($SumaTotal, 0, ',', '.') ?></th>
                <th colspan="1"></th>
            </tr>
        </tbody>
    </table>    
    
    <table border="1">
        <thead>
            <tr>
                <th colspan="4">Observaciónes</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <form method="post" onsubmit="disableButton(this)" style="display: inline-block; margin: 0;">
                    <td colspan="3">
                    <textarea name="observaciones" id="Observaciones" rows="5" cols="160"placeholder="Escribe tus observaciones aquí..."><?= htmlspecialchars($DataEntrada['Observaciones']) ?></textarea>
                    </td>
                    <td style="text-align: center;">
                        <input type="hidden" name="Usuario" value="<?= $_SESSION['ID'] ?>">
                        <input type="hidden" name="Numero" value="<?= $DataEntrada['Numero'] ?>">
                        <input type="hidden" name="Tipo" value="2">
                        <input type="submit" id="button2" style="background-color: #007bff; color: white; border: none; padding: 0 px; cursor: pointer; display: flex; align-items: center; justify-content: center; width: 70px; height: 28px; border-radius: 10%; box-sizing: border-box; font-size: 12px;" value="Guardar">
                    </td>
                </form>
            </tr>
        </tbody>
    </table>

    <table border="1">
        <thead>
            <tr>
                <th>INGRESA</th>
                <th>SUPERVISADO</th>
            </tr>
        </thead>
        <tbody>
            <tr height="100px">
                <!-- Añadir width="50%" para que ambas firmas ocupen el 50% de la tabla -->
                <td width="50%" style="text-align: center;">
                    <img src="<?= $DataEntrada['Firma_Ingresa'] ?>" style="max-width: 100%;">
                </td>
                <td width="50%" style="text-align: center;">
                    <img src="<?= $DataEntrada['Firma_supervisor'] ?>" style="max-width: 100%;">
                </td>
            </tr>
            <tr>
                <th style="text-align: center;"><?= $DataEntrada['NombreUsuario'] ?></th>
                <th style="text-align: center;"><?= $DataEntrada['NombreSupervisor'] ?></th>
            </tr>
            <tr>
                <th>Firma</th>
                <th>Firma</th>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td><b>Fecha: </b><?= $DataEntrada['Fecha_Realizado'] ?></td>
                <td><b>Fecha:</b><?= $DataEntrada['Fecha_Firma_Supervisor'] ?></td>
            </tr>
        </tfoot>
    </table>
   

    <script>
        function disableButton(form) {
            var submitButton = form.querySelector('input[type="submit"]');
            submitButton.disabled = true;
        }
        
    </script>
</body>
</html>