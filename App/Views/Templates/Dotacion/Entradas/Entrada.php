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

    $entradaPendiente = $DotacionController->verificarEstadoEntrada($_SESSION['ID']); // Recibir el valor de retorno

    if ($entradaPendiente) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Atención',
                    text: 'Tienes una entrada pendiente por autorizar',
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
    
    $DataSupervisores = $UsuariosController->obtenerSupervisor();
    $Filas = $DotacionController->DetallesEntrada($_SESSION['ID']);

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
            max-width: 500px; /* Ancho máximo del lienzo de firma */
            height: auto; /* Altura automática para ajustar proporcionalmente al ancho */
        }
    </style>
    <?php       
        if ($dataUltimaEntrada = $DotacionController->TraerUltimoRegistroEntrada($_SESSION['ID'])) {
            echo "<script>alertify.success('Producto Agregado correctamente. ".$dataUltimaEntrada['Codigo_Producto']." - ".$dataUltimaEntrada['Nombre_producto']."');</script>";
            $DotacionController->EliminarUltimoRegistroEntrada($_SESSION['ID']);
        }
    ?>
    <table border="1">
        <thead>
            <tr>
                <th rowspan="3"><img src="../App/Views/Img/Outkargo.png" width="200px"></th>
                <th rowspan="3" class="Titulo" style="font-size: 20px;">FORMATO ENTRADA DE DOTACIÓN</th>
                <th>CODIGO:</th>
                <td>F-243</td>
            </tr>
            <tr>
                <th>FECHA:</th>
                <td>16-05-2024</td>
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
                <td>
                    <select name="Autoriza" id="Autoriza" onchange="mostrarSupervisor()">
                        <option value=""></option> 
                        <?php
                            if ($DataSupervisores) {
                                foreach ($DataSupervisores as $Supervisor) {
                        ?>
                        <option value="<?= htmlspecialchars($Supervisor['ID'] . '|' . $Supervisor['Correo']) ?>">
                            <?= htmlspecialchars($Supervisor['NombreCompleto']) ?>
                        </option>
                        <?php
                                }
                            }                                   
                        ?>
                    </select>
                </td>
                <th>No.</th>
                <td style="color: red; text-align: center;"><b> ------</b></td>
                <th>Fecha:</th>
                <td><?= $Dia ?></td>
                <td><?= $Mes ?></td>
                <td><?= $Ano ?></td>
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
                <th width="100px">Codigo</th>
                <?php
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        if ($_POST['Tipo'] == "1") {
                            $Codigo = $_POST['Codigo'];
                            $ID_Usuario = $_POST['Usuario'];
                            $DotacionController->InsertarEntradaTemp($Codigo,$ID_Usuario);
                        }  
                        if ($_POST['Tipo'] == "2") {
                            $Codigo = $_POST['Codigo'];
                            $ID_Usuario = $_POST['Usuario'];
                            $DotacionController->RestarEntradaTemp($Codigo, $ID_Usuario);
                        }    
                        if ($_POST['Tipo'] == "3") {
                            $Codigo = $_POST['Codigo'];
                            $ID_Usuario = $_POST['Usuario'];
                            $DotacionController->EliminarEntradaTemp($Codigo, $ID_Usuario);
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
                                <input type="submit" id="button2" style="background-color: #a20000; color: black; border: none; padding: px; cursor: pointer; align-items: center; justify-content: center; width: 24px; height: 24px; border-radius: 10%; box-sizing: border-box; font-size: 14px; font-weight: bold;" value="-">
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
    <table border="1">
        <thead>
            <tr>
                <th>Ingresa</th>
                <th>Supervisado</th>
            </tr>
        </thead>
        <Tbody>
            <tr height="100px">
                <td style="width: 50vh;"></td>
                <td style="width: 50vh;"></td>
            </tr>
            <tr>
                <th><?= $_SESSION['NombreCompleto'] ?></th>
                <th id="supervisorSeleccionado" style="width: 50vh;"></th>
                
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
        <form id="GuardarEntrada" action="FirmaEntrada" method="post">
            <input type="hidden" name="IDSupervisor" id="formIDSupervisor">
            <input type="hidden" name="CorreoSupervisor" id="formCorreoSupervisor">
            <input type="hidden" name="NombreSupervisor" id="formNombreSupervisor">
            <input type="hidden" name="SessionID" value="<?= $_SESSION['ID'] ?>">
            <input type="hidden" name="NombreIngresa" value="<?= $_SESSION['Nombre1'] ?>">
            <input type="hidden" name="SessionCentro" value="<?= $_SESSION['NoCentro'] ?>">
            <button type="button" style="margin-top: 20px;" onclick="Guardar()">Guardar</button>
        </form>

    <script>
        function disableButton(form) {
            var submitButton = form.querySelector('input[type="submit"]');
            submitButton.disabled = true;
        }
        function mostrarSupervisor() {
            var select = document.getElementById("Autoriza");
            var selectedValue = select.value;
            
            if (!selectedValue) {
                document.getElementById("supervisorSeleccionado").innerText = '';
                return;
            }

            var supervisorSeleccionado = select.options[select.selectedIndex].text;
            var parts = selectedValue.split('|');
            var idSupervisor = parts[0];
            var correoSupervisor = parts[1];
            document.getElementById("formIDSupervisor").value = idSupervisor;
            document.getElementById("formCorreoSupervisor").value = correoSupervisor;
            document.getElementById("formNombreSupervisor").value = supervisorSeleccionado;


            document.getElementById("supervisorSeleccionado").innerText = supervisorSeleccionado;
        }  
        
        function Guardar() {
            // Verificar productos en la tabla
            const productos = document.querySelectorAll('#tablaProductos tbody tr'); 
            if (productos.length <= 1) { 
                alert('No hay ningún producto agregado. Por favor, agrega productos antes de continuar.');
                return; 
            }

            // Verificar si se seleccionó un supervisor
            var select = document.getElementById("Autoriza");
            if (select.value === "") {
                alert("Por favor, selecciona un supervisor.");
                return;
            }
            document.getElementById("GuardarEntrada").submit();
        }
        
    </script>

</body>
</html>