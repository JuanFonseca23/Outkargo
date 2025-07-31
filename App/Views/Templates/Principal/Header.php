<?php
require "App/Controllers/PaginaController.php";
$PaginaController = new PaginaController();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>JHSKARGO - Montacargas a tu medida | Soluciones estratégicas para tu negocio</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="En JHSKARGO ofrecemos montacargas a medida, adaptados a las necesidades de tu negocio. Con soluciones estratégicas, somos tu mejor aliado para optimizar operaciones y mejorar la productividad." name="description">
    <meta name="keywords" content="Colombia, outsourcing de montacargas, venta de montacargas, montacargas contrabalanceados, montacargas eléctricos, montacargas diésel, montacargas a gas, montacargas pasillo angosto, montacargas toma pedidos, manlifts, baterías para montacargas, baterías industriales para montacargas, baterías 36V para montacargas, baterías 48V para montacargas, montacargas para almacenes en Colombia, soluciones logísticas Colombia, equipos industriales Colombia, carretillas elevadoras Colombia, alquiler de montacargas Colombia, equipos de carga Colombia, montacargas industriales Colombia, montacargas para manejo de carga pesada, carretillas elevadoras eléctricas Colombia, montacargas a medida Colombia, montacargas con motor diésel Colombia, soluciones para manipulación de carga Colombia, montacargas para zonas estrechas Colombia, manlifts Colombia, equipos de manipulación en altura Colombia, carretillas elevadoras para pasillo angosto, tecnología avanzada en montacargas Colombia, montacargas de última tecnología, montacargas para transporte Colombia, soluciones de carga y descarga Colombia, optimización de procesos logísticos, alquiler de manlifts Colombia, montacargas con baterías Colombia, montacargas con control remoto, montacargas industriales de alta capacidad, montacargas para industrias colombianas, montacargas para construcción Colombia, montacargas con alta maniobrabilidad, carretillas elevadoras para logística Colombia, montacargas para cadenas de suministro Colombia, montacargas con alta seguridad, equipos para manejo de materiales Colombia, diseño de montacargas Colombia, innovación en montacargas Colombia, soluciones personalizadas de carga Colombia, montacargas industriales para fábricas en Colombia, montacargas para manejo de materiales Colombia, montacargas ergonómicos Colombia, montacargas para grandes superficies Colombia, montacargas para sectores industriales Colombia, montacargas para manejo de productos, transporte y elevación Colombia, montacargas para trabajo en altura Colombia, equipos industriales para transporte Colombia, baterías de reemplazo para montacargas, mantenimiento de baterías para montacargas">
    <!-- Favicon -->
    <link href="Favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&family=Rubik:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="App/Views/Lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="App/Views/Lib/animate/animate.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="App/Views/Css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="App/Views/Css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner"></div>
    </div>
    <!-- Spinner End -->


    <!-- Topbar Start -->
    <div class="container-fluid bg-dark px-5 d-none d-lg-block">
        <div class="row gx-0">
            <div class="col-lg-8 text-center text-lg-start mb-2 mb-lg-0">
                <div class="d-inline-flex align-items-center" style="height: 45px;">
                    <small class="me-3 text-light"><i class="fa fa-map-marker-alt me-2"></i>Tv. 72f # 42C - 40 sur Bogotá, Colombia</small>
                    <small class="me-3 text-light"><i class="fa fa-phone-alt me-2"></i>(601) 7265722 </small>
                    <small class="text-light"><i class="fa fa-envelope-open me-2"></i>info@jhskargo.com</small>
                </div>
            </div>
            <div class="col-lg-4 text-center text-lg-end">
                <div class="d-inline-flex align-items-center" style="height: 45px;">
                    <a class="btn btn-sm btn-outline-light btn-sm-square rounded-circle me-2" href="https://www.facebook.com/profile.php?id=61574659535464"><i class="fab fa-facebook-f fw-normal"></i></a>
                    <a class="btn btn-sm btn-outline-light btn-sm-square rounded-circle me-2" href="https://www.linkedin.com/in/jhs-kargo-sas-70b972348"><i class="fab fa-linkedin-in fw-normal"></i></a>
                    <a class="btn btn-sm btn-outline-light btn-sm-square rounded-circle me-2" href="https://www.instagram.com/jhs.kargosas/"><i class="fab fa-instagram fw-normal"></i></a>
                    <a class="btn btn-sm btn-outline-light btn-sm-square rounded-circle" href="https://www.youtube.com/@JhsKargo"><i class="fab fa-youtube fw-normal"></i></a>
                </div>
            </div>
        </div>
    </div>
    <!-- Topbar End -->


    <!-- Navbar & Carousel Start -->
    <div class="container-fluid position-relative p-0">
        <nav class="navbar navbar-expand-lg navbar-dark px-5 py-3 py-lg-0">
            <a href="Inicio" class="navbar-brand p-0">
                <h1 class="m-0"><img src="App/Views/Img/Logos/JHSKargo.png" width="40%"></h1>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="fa fa-bars"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav ms-auto py-0">
                    <a href="Inicio" class="nav-item nav-link active">Inicio</a>
                    <a href="Nosotros" class="nav-item nav-link">Nosotros</a>
                    <a href="Servicios" class="nav-item nav-link">Servicios</a>
                    <a href="Blogs" class="nav-item nav-link">Blogs</a>
                    <div class="nav-item dropdown">
                        <a href="Baterias" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Baterias</a>
                        <div class="dropdown-menu m-0">
                            <a href="CatalogoBaterias" class="dropdown-item">Catalogo</a>
                            <a href="Contactanos" class="dropdown-item">Otras</a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="Montacargas" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Montacargas</a>
                        <div class="dropdown-menu m-0">
                            <a href="CatalogoMontacargas" class="dropdown-item">Montacargas</a>
                            <a href="MontacargasEC" class="dropdown-item">Electricas contrabalanceadas</a>
                            <a href="MontacargasEPA" class="dropdown-item">Electricas Pasillo Angosto</a>
                            <a href="MontacargasCI" class="dropdown-item">Contrabalanceadas Combustion</a>
                            <a href="MontacargasETP" class="dropdown-item">Electricas Toma Pedido</a>
                            <a href="MontacargasS" class="dropdown-item">Manlifts</a>
                            <a href="MontacargasOtras" class="dropdown-item">Otras</a>
                        </div>
                    </div>
                    <a href="Contacto" class="nav-item nav-link">Contacto</a>
                </div>
                <a href="IniciarSesion" class="btn btn-primary py-2 px-4 ms-3">Iniciar Sesión</a>
            </div>
        </nav>