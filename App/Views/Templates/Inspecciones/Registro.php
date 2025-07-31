<?php
date_default_timezone_set('America/Bogota');
session_start();
include_once "App/Controllers/InspeccionesController.php";
$InspeccionesController = new InspeccionesController();
if (empty($_SESSION['ID'])) {
    header("location:../IniciarSesion");
    exit;
}
$FechaHoy = date("d/m/Y");
$HoraActual = date("H:i:s");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>OUTKARGO - Administrador</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="description" content="OUTKARGO ofrece servicios de alquiler de montacargas con y sin operador en Colombia.">
    <meta name="keywords" content="OUTKARGO, alquiler de montacargas, montacargas, Colombia, Toma Pedido, Lift, Diesel, Gas">
    <link rel="icon" href="../Favicon.ico" type="image/x-icon">

    <!-- JavaScript -->
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- CSS -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css" />
    <!-- Google Web Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        table {
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
    $TipoInspeccion = $_GET['Area'];
    switch ($TipoInspeccion) {
        case 'Puesto de trabajo':
            include_once "PuestoDeTrabajo.php";
            break;
        case 'Cargue Contenedores':
            include_once "CargueContenedores.php";
            break;
        case 'Almacen PT':
            include_once "AlmacenPT.php";
            break;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $TipoInspeccionRegistrar = $_POST['Tipo'];
        switch ($TipoInspeccionRegistrar) {
            case 'Puesto de trabajo':
                $idCentro = $_POST['ID_Centro'];
                $fecha = $_POST['Fecha'];
                $idMontacargas = $_POST['ID_Montacargas'];
                $idPersonaRegistra = $_POST['ID_PersonaRegistra'];
                $idPersonaEvaluada = $_POST['ID_PersonaEvaluada'];
                $recomendacionesMedicas = $_POST['RecomendacionesMedicasDeLaPersonaEvaluada'];
                $observaciones = $_POST['ObservacionesSeCumplenLasRecomendacionesMedicasPorParteDelTrabajador'];
                $usoCorrectoEPP = $_POST['UsoCorrectoDeLosElementosDeProteccionPersonal'];
                $criterios = [];
                for ($i = 1; $i <= 34; $i++) {
                    $criterios["criterio$i"] = isset($_POST["criterio$i"]) ? $_POST["criterio$i"] : 'No';
                }
                $condiciones = [];
                $contador = 1;
                while (isset($_POST["DescripcionCondicion$contador"])) {
                    $condiciones[] = [
                        'consecutivo' => $contador,
                        'descripcion' => $_POST["DescripcionCondicion$contador"]
                    ];
                    $contador++;
                }
                $InspeccionesController->RegistrarInspeccionPuestoDeTrabajo($idCentro, $fecha, $idMontacargas, $idPersonaRegistra, $idPersonaEvaluada, $recomendacionesMedicas, $observaciones, $usoCorrectoEPP, $criterios, $condiciones);
                break;
            case 'Cargue Contenedores':

                break;
            default:
                # code...
                break;
        }
    }
    ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>