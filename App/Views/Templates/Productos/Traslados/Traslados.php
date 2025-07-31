<?php
    session_start();
    if (empty($_SESSION['ID'])) {
        header("location:../IniciarSesion");
        exit;
    }
    include_once "App/Controllers/UsuarioController.php";
    include_once "App/Controllers/ProductosController.php";
    include_once "App/Controllers/CentroDeTrabajoController.php";
    include_once "App/Controllers/DotacionController.php";

    $CentrosDeTrabajo = new CentroDeTrabajoController;
    $UsuariosController = new UsuarioController();
    $ProductosController = new ProductosController;
    $DotacionController = new DotacionController;
    $No_Documento = $_GET['Documento'];
    $CentroTrabajo = $_GET['Centro'];
    $DataUsuario = $DotacionController->BuscarPersona($No_Documento);
    $trasladosPendiente = $ProductosController->verificarEstadoTraslado($_SESSION['ID']); 
    $Centro = $ProductosController->ObtenerCentro($_GET['Centro']);

    if ($trasladosPendiente) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Atención',
                    text: 'Tienes una salida pendiente por autorizar',
                    icon: 'warning',
                    confirmButtonText: 'Aceptar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'Inicio'; 
                    }
                });
            });
        </script>";
        exit;
    }
    $ListaCentrosDeTrabajo = $CentrosDeTrabajo->TraerCentrosDeTrabajo();
    $DataSupervisores = $UsuariosController->obtenerSupervisor();
    $Filas = $ProductosController->DetallesTraslado($_SESSION['ID']);

    date_default_timezone_set('America/Bogota');
    $Fecha = date("d/m/Y");
    $Dia = date("d");
    $Mes = date("m");
    $Ano = date("Y");
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
        if ($dataUltimaTraslado = $ProductosController->TraerUltimoRegistroTraslado($_SESSION['ID'])) {
            echo "<script>alertify.success('Producto Agregado correctamente. ".$dataUltimaTraslado['Codigo_Producto']." - ".$dataUltimaTraslado['Nombre_producto']."');</script>";
            $ProductosController->EliminarUltimoRegistroTraslado($_SESSION['ID']);
        }
    ?>
    <table border="1">
        <thead>
            <tr>
                <th rowspan="3"><img src="../App/Views/Img/Outkargo.png" width="200px"></th>
                <th rowspan="3" class="Titulo" style="font-size: 20px;">FORMATO TRASLADO DE PRODUCTOS</th>
                <th>CODIGO:</th>
                <td>F-251</td>
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
                <th>Recibe:</th>
                <td><?= $DataUsuario['NombreCompleto'] ?></td>
                <th>No.</th>
                <td style="color: red; text-align: center;"><b> ------</b></td>
                <th>Fecha:</th>
                <td><?= $Dia ?></td>
                <td><?= $Mes ?></td>
                <td><?= $Ano ?></td>
            </tr>   
            <tr>
                <th>Centro Salida:</th>
                <td><?= htmlspecialchars($_SESSION['Centro']) ?></td>
                <th>Centro Destinado:</th>
                <td><?= htmlspecialchars($Centro['Nombre']) ?></td>      
                <td colspan="5"></td>  
            <tr>       
           
        </thead>
        <tbody>
            <tr>

            </tr>
        </tbody>
    </table>
    <table border="1">
        <tbody>
            <tr>
                <?php
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        if ($_POST['Tipo'] == "1") {
                            $Codigo = $_POST['Codigo'];
                            $ID_Usuario = $_POST['Usuario'];
                            $ValorCantidad = $_POST['Cantidad'];
                            $Medida = $_POST['tipoMedida'];
                            $ID_Centro = $_SESSION['NoCentro'];
                            $ProductosController->InsertarTrasladoTemp($Codigo, $ValorCantidad, $Medida, $No_Documento, $ID_Centro, $CentroTrabajo, $ID_Usuario);
                        }  
                    }
                ?>
                <form method="post">
                    <th width="60px">Cantidad</th>
                    <td width="50px"><input name="Cantidad" required></td>
                    <td width="50px"> <select id="tipoMedida" name="tipoMedida">
                            <option value="Und">Und</option>
                            <option value="Gal">Gal</option>
                            <option value="1/4">1/4</option>
                            <option value="1/2">1/2</option>
                            <option value="3/4">3/4</option>
                            <option value="Kilo">Kilo</option>
                            <option value="Bulto">Bulto</option> 
                        </select>
                    </td>
                    <th width="60px">Codigo</th>
                    <td width="50px"><input name="Codigo" required></td>
                    <input type="hidden" name="Usuario" value="<?= $_SESSION['ID'] ?>">
                    <input type="hidden" name="Tipo" value="1">
                    <td width="100px" style="text-align: center;"><input type="submit" id="button1" style="background-color:rgb(0, 162, 49); color: white; border: none; padding: px; cursor: pointer; align-items: center; justify-content: center; border-radius: 10%; box-sizing: border-box; font-size: 14px; font-weight: bold;" value="Agregar"></td>
                </form> 
            </tr>

            </tr>
        </tbody>
    </table>
    <table id="tablaProductos" border="1" >
        <tbody>
            <tr>
                <th width="50px">#</th>
                <th width="50px">Cantidad</th>
                <th width="100px">Codigo</th>
                <?php
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        
                        if ($_POST['Tipo'] == "2") {
                            $Codigo = $_POST['Codigo'];
                            $ID_Usuario = $_POST['Usuario'];
                            $ID = $_POST['ID'];
                            $ProductosController->RestarTrasladoTemp($Codigo, $ID_Usuario, $ID, $No_Documento, $CentroTrabajo);
                        }    
                        if ($_POST['Tipo'] == "3") {
                            $Codigo = $_POST['Codigo'];
                            $ID_Usuario = $_POST['Usuario'];
                            $ID = $_POST['ID'];
                            $ProductosController->EliminarTrasladoTemp($Codigo, $ID_Usuario, $ID, $No_Documento, $CentroTrabajo);
                        }                       
                    }
                ?>
                <th width="500px">Descripción</th>
                <th>Número de Factura</th>              
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
                            <th><?= $Numero ?></th>
                            <td style="text-align: center;"><?= $Fila['Cantidad'] ?></td>
                            <td style="text-align: center;"><?= $Fila['Codigo_Producto'] ?></td>
                            <td><?= $Fila['Nombre_producto'] ?></td>
                            <td style="text-align: center;"><?= $Fila['Factura'] ?? '' ?></td>
                            <td style="text-align: center;">
                            <form method="post" onsubmit="disableButton(this)" style="display: inline-block; margin: 0;">
                                <input type="hidden" name="Usuario" value="<?= $_SESSION['ID'] ?>">
                                <input type="hidden" name="Codigo" value="<?= $Fila['Codigo_Producto'] ?>">
                                <input type="hidden" name="ID" value="<?= $Fila['ID'] ?>">
                                <input type="hidden" name="Tipo" value="2">
                                <input type="submit" id="button2" style="background-color: #a20000; color: white; border: none; padding: px; cursor: pointer; align-items: center; justify-content: center; width: 24px; height: 24px; border-radius: 10%; box-sizing: border-box; font-size: 14px; font-weight: bold;" value="-">
                            </form>
                            <form method="post" onsubmit="disableButton(this)" style="display: inline-block; margin: 0;">
                                <input type="hidden" name="Usuario" value="<?= $_SESSION['ID'] ?>">
                                <input type="hidden" name="Codigo" value="<?= $Fila['Codigo_Producto'] ?>">
                                <input type="hidden" name="ID" value="<?= $Fila['ID'] ?>">
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
    
    <form id="GuardarEntrada" action="FirmaTraslado?Documento=<?= $No_Documento ?>" method="post">
        <table border="1">
            <thead>
                <tr>
                    <th>Observaciónes</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td >
                        <textarea name="observaciones" id="Observaciones" rows="5" cols="170" placeholder="Escribe tus observaciones aquí..."></textarea>
                    </td>
                </tr>
            </tbody>
        </table>
        <table border="1">
            <thead>
                <tr>
                    <th>Traslada</th>
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
                    <td><b>Fecha: </b><?= $Fecha ?></td>
                    <td><b>Fecha:</b> </td>
                </tr>
            </tfoot>
        </table>

        <input type="hidden" name="ID_Recibe" value = "<?= $DataUsuario['ID'] ?>">
        <input type="hidden" name="SessionID" value="<?= $_SESSION['ID'] ?>">
        <input type="hidden" name="NombreIngresa" value="<?= $_SESSION['Nombre1'] ?>">
        <input type="hidden" name="SessionCentro" value="<?= $_SESSION['NoCentro'] ?>">
        <input type="hidden" name="No_Documento" value="<?=$_GET['Documento']?>">
        <input type="hidden" name="ID_Centro" value="<?=$_GET['Centro']?>">
        <button type="button" style="margin-top: 20px;" onclick="Guardar()">Guardar</button>
    </form>

    <script>
        function disableButton(form) {
            var submitButton = form.querySelector('input[type="submit"]');
            submitButton.disabled = true;
        } 
        
        function Guardar() {
            // Verificar productos en la tabla
            const observaciones = document.getElementById('Observaciones');
            if (observaciones.value.trim() === "") {
                observaciones.value = "NULL"; 
            }
            const productos = document.querySelectorAll('#tablaProductos tbody tr'); 
            if (productos.length <= 1) { 
                alert('No hay ningún producto agregado. Por favor, agrega productos antes de continuar.');
                return; 
            }
            
            document.getElementById("GuardarEntrada").submit();
        }
        
    </script>
</body>
</html>