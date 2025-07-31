<?php
require_once "App/Views/Templates/Layouts/Header.php";
include_once "App/Controllers/UsuarioController.php";
include_once "App/Controllers/FamiliaController.php";
include_once "App/Controllers/Examenescontroller.php";
include_once "App/Controllers/PoligrafosController.php";
include_once "App/Controllers/ActividadUsuarioController.php";
include_once "App/Controllers/CertificadosMontacargasController.php";
include_once "App/Controllers/ComparendosController.php";
include_once "App/Controllers/EducacionController.php";
include_once "App/Controllers/ContactosController.php";
include_once "App/Controllers/HojaDeVidaController.php";
include_once "App/Controllers/AfiliacionesController.php";


$ID = $_GET['ID'];

$UsuarioController = new UsuarioController();
$FamiliaController = new FamiliaController();

$Examenescontroller = new Examenescontroller();
$PoligrafosController = new PoligrafosController();
$CertificadosMontacargascontroller = new CertificadosMontacargasController();
$ComparendosController = new ComparendosController();
$ActividadUsuarioController = new ActividadUsuarioController();
$ContactosController = new ContactosController();
$EducacionController = new EducacionController();
$HojaDeVidaController = new HojaDeVidaController();
$AfiliacionesController = new AfiliacionesController();




$DataActividad = $ActividadUsuarioController->TraerActividad($ID);
$DataContactos = $ContactosController->TraerContactos($ID);
$DataHijos = $FamiliaController->TraerHijos($ID);
$DataExamenes = $Examenescontroller->Examenes($ID);
$DataPoligrafos = $PoligrafosController->Poligrafos($ID);
$DataMontacargas = $CertificadosMontacargascontroller->Certificados_Montacargas($ID);
$DataComparendos = $ComparendosController->Comparendos($ID);
$DataEducacion = $EducacionController->Educacion($ID);
$DataHojaDeVida = $HojaDeVidaController->HojaDeVida($ID);
$DataAfiliciones = $AfiliacionesController->Afiliaciones($ID);
$Fecha = date('Y-m-d');
?>

<style>
    .card {
        border: none;
        margin-bottom: 20px;
        box-shadow: 10px 10px 15px rgba(0, 0, 0, 0.2);
    }

    .card-body {
        padding: 20px;
        position: relative;
        color: #696969;
    }

    .rounded-circle-2 {
        border-radius: 5%;
        width: 100px;
        height: 100px;
        margin-right: 15px;
        margin-top: -50px;
        border: 5px solid white;
        box-shadow: 10px 10px 15px rgba(0, 0, 0, 0.2);
    }

    .btn-primary-wa {
        background-color: #00bb2d;
        border-color: #00bb2d;
    }

    h3 {
        font-size: 24px;
        font-weight: bold;
        margin: 0;
    }

    p {
        font-size: 16px;
        margin: 0;
    }

    .ml-3 {
        margin-left: 1rem;
    }

    .ml-auto {
        margin-left: auto;
    }

    .card-header {
        background: #007BFF;
        color: #ffffff;
    }

    .timeline-item {
        color: #000020;
    }
</style>