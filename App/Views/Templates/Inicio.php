<?php
    $Año = date("Y");
    require_once "Logos.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <title>Outkargo</title>
    <meta name="keywords" content="Outkargo, outsourcing, montacargas, Colombia, servicios logísticos, alquiler de montacargas, mantenimiento de montacargas">
    <meta name="description" content="Outkargo es una empresa de outsourcing de montacargas en Colombia, especializada en servicios logísticos, alquiler y mantenimiento de montacargas.">
    <meta name="author" content="SOFTWOLF">
    <link rel="stylesheet" type="text/css" href="App/Views/Css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="App/Views/Css/style.css">
    <link rel="stylesheet" href="App/Views/Css/responsive.css">
    <link rel="icon" href="Favicon.ico" type="image/gif" />
    <link rel="stylesheet" href="App/Views/Css/jquery.mCustomScrollbar.min.css">
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;500;600;800&family=Sen:wght@400;700;800&display=swap" rel="stylesheet">
</head>

<body>
    <div class="header_top_section">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="header_top_main">
                        <div class="call_text"><a href="#"><i class="fa fa-phone" aria-hidden="true"></i> +57 3138591802 - 7265722</a></div>
                        <div class="call_text_2"><a href="#"><i class="fa fa-envelope" aria-hidden="true"></i> info@outkargoapp.com</a></div>
                        <div class="call_text_1"><a href="#"><i class="fa fa-map-marker" aria-hidden="true"></i> Bogota - Colombia</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header_section">
        <div class="container-fluid">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="logo"><a href="Inicio"><img src="App/Views/Img/LOGO-SIN-FONDO-BLANCO.png" width="250px"></a></div>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="Inicio">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="Servicios">Servicios</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="Nosotros">Nosotros</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="Actualizaciones">Actualizaciones</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="Contacto">Contacto</a>
                        </li>
                    </ul>
                    <form class="form-inline my-2 my-lg-0">
                        <div class="quote_btn"><a href="IniciarSesion">Iniciar Sesión</a></div>
                    </form>
                </div>
            </nav>
        </div>
        <div class="banner_section layout_padding">
            <div id="my_slider" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="container">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="banner_taital_main">
                                        <h1 class="banner_taital">Soluciones Integrales</h1>
                                        <p class="banner_text">En Outkargo ofrecemos soluciones completas en outsourcing de montacargas, garantizando eficiencia y productividad en tus operaciones logísticas.</p>
                                        <div class="btn_main">
                                            <div class="started_text active"><a href="Contacto">Contactanos</a></div>
                                            <div class="started_text"><a href="Nosotros">Nosotros</a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="container">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="banner_taital_main">
                                        <h1 class="banner_taital">Alquiler y Mantenimiento</h1>
                                        <p class="banner_text">Confía en Outkargo para el alquiler y mantenimiento de montacargas, asegurando equipos de calidad y un servicio excepcional en toda Colombia.</p>
                                        <div class="btn_main">
                                            <div class="started_text active"><a href="Contacto">Contactanos</a></div>
                                            <div class="started_text"><a href="Nosotros">Nosotros</a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="container">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="banner_taital_main">
                                        <h1 class="banner_taital">Expertos en montacargas</h1>
                                        <p class="banner_text">Outkargo, tu aliado estratégico en servicios logísticos con montacargas, proporcionando experiencia y confiabilidad en cada proyecto.</p>
                                        <div class="btn_main">
                                            <div class="started_text active"><a href="Contacto">Contactanos</a></div>
                                            <div class="started_text"><a href="Nosotros">Nosotros</a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#my_slider" role="button" data-slide="prev">
                    <i class="fa fa-angle-left"></i>
                </a>
                <a class="carousel-control-next" href="#my_slider" role="button" data-slide="next">
                    <i class="fa fa-angle-right"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="services_section layout_padding">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <h1 class="services_taital">Servicios</h1>
                    <p class="services_text_1">En Outkargo, ofrecemos una gama completa de servicios diseñados para optimizar tus operaciones logísticas y garantizar la máxima eficiencia.</p>
                </div>
            </div>
            <div class="services_section_2">
                <div class="row">
                    <div class="col-lg-3 col-sm-6">
                        <div class="box_main active">
                            <div class="service_img"><img src="App/Views/Img/icon-1.png"></div>
                            <h4 class="development_text">Alquiler de Montacargas</h4>
                            <p class="services_text">Proporcionamos montacargas de alta calidad para satisfacer todas tus necesidades de elevación y transporte.</p>
                            <div class="readmore_bt"><a href="Contacto">Saber Mas</a></div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="box_main">
                            <div class="service_img"><img src="App/Views/Img/icon-2.png"></div>
                            <h4 class="development_text">Mantenimiento Preventivo</h4>
                            <p class="services_text">Nuestros servicios de mantenimiento aseguran que tus equipos siempre funcionen en óptimas condiciones.</p>
                            <div class="readmore_bt"><a href="Contacto">Saber Mas</a></div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="box_main">
                            <div class="service_img"><img src="App/Views/Img/icon-3.png"></div>
                            <h4 class="development_text">Operadores Capacitados</h4>
                            <p class="services_text">Contamos con operadores altamente capacitados para manejar tus montacargas con seguridad y eficiencia.</p>
                            <div class="readmore_bt"><a href="Contacto">Saber Mas</a></div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="box_main">
                            <div class="service_img"><img src="App/Views/Img/icon-4.png"></div>
                            <h4 class="development_text">Servicio Técnico Especializado</h4>
                            <p class="services_text">Brindamos soporte técnico especializado para resolver cualquier inconveniente con tus montacargas de manera rápida y eficiente.</p>
                            <div class="readmore_bt"><a href="Contacto">Saber Mas</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="about_section layout_padding">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h1 class="about_taital">Nosotros</h1>
                    <p class="about_text">OUTKARGO LTDA, es una empresa especializada en el outsourcing de montacargas con una amplia experiencia en el mercado, destacada por ofrecer al cliente soluciones ajustadas a sus necesidades, cumpliendo con el suministro de maquinaria conforme con las especificaciones técnicasy con un equipo de trabajo competente y comprometido.</p>
                    <div class="read_bt_1"><a href="Contacto">Saber Mas</a></div>
                </div>
                <div class="col-md-6">
                    <div class="about_img">
                        <div class="video_bt">
                            <a href="https://youtu.be/QbnDJvuqO0k" target="_blank">
                                <div class="play_icon">
                                    <img src="App/Views/Img/play-icon.png">
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="projects_section layout_padding">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="projects_taital">Actualizaciones</h1>
                </div>
            </div>
        </div>
        <div class="projects_section_2 layout_padding">
            <div class="container">
                <div class="pets_section">
                    <div class="pets_section_2">
                        <div id="main_slider" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="container_main">
                                                <img src="App/Views/Img/img-1.png" alt="" class="image">
                                                <div class="overlay">
                                                    <div class="text">
                                                        <h4 class="some_text"><i class="fa fa-link" aria-hidden="true"></i></h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="project_main">
                                                <h2 class="work_text">Implementación de Listas de Chequeo Digitales</h2>
                                                <p class="dummy_text">Hemos modernizado nuestros procesos con listas de chequeo digitales, mejorando la precisión y eficiencia en el mantenimiento de montacargas.</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="container_main">
                                                <img src="App/Views/Img/img-2.png" alt="" class="image">
                                                <div class="overlay">
                                                    <div class="text">
                                                        <h4 class="some_text"><i class="fa fa-link" aria-hidden="true"></i></h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="project_main">
                                                <h2 class="work_text">Sistema de Inventario</h2>
                                                <p class="dummy_text">Nuestro nuevo sistema de inventario te permite gestionar y controlar tus recursos de manera más efectiva, reduciendo tiempos de inactividad.</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="container_main">
                                                <img src="App/Views/Img/img-3.png" alt="" class="image">
                                                <div class="overlay">
                                                    <div class="text">
                                                        <h4 class="some_text"><i class="fa fa-link" aria-hidden="true"></i></h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="project_main">
                                                <h2 class="work_text">Sistema de Dotación</h2>
                                                <p class="dummy_text">Con el nuevo sistema de dotación, garantizamos que todos nuestros operadores y técnicos cuenten con el equipo necesario para desempeñar sus labores con seguridad y eficiencia.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="contact_section layout_padding">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="contact_taital">Contactanos</h1>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="contact_section_2">
                <div class="row">
                    <div class="col-md-6">
                        <form action="">
                            <div class="mail_section_1">
                                <input type="text" class="mail_text" placeholder="Nombre" name="Name">
                                <input type="text" class="mail_text" placeholder="Numero De Telefono" name="Phone Number">
                                <input type="text" class="mail_text" placeholder="Correo" name="Email">
                                <textarea class="massage-bt" placeholder="Mensaje" rows="5" id="comment" name="Massage"></textarea>
                                <div class="send_bt"><a href="#">Enviar</a></div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6 padding_left_15">
                        <div class="contact_img"><img src="App/Views/Img/contact-img.png"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="map_main">
            <div class="map-responsive">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15907.789557752363!2d-74.15844518456214!3d4.603444054134375!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e3f9ec1724892c5%3A0xe9ef0ca92ab8af54!2sMONTACARGAS%20-%20OUTKARGO%20LTDA!5e0!3m2!1ses!2sco!4v1720191608279!5m2!1ses!2sco" width="600" height="600" frameborder="0" style="border:0; width: 100%;" allowfullscreen=""></iframe>
            </div>
        </div>
    </div>
    <div class="footer_section layout_padding">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="location_text">
                        <ul>
                            <li>
                                <a href="#"><span class="padding_15"><i class="fa fa-mobile" aria-hidden="true"></i></span> <br>Telefono +57 3138591802</a>
                            </li>
                            <li class="active">
                                <a href="#"><span class="padding_15"><i class="fa fa-envelope" aria-hidden="true"></i></span> <br>info@outkargoapp.com</a>
                            </li>
                            <li>
                                <a href="#"><span class="padding_15"><i class="fa fa-map-marker" aria-hidden="true"></i></span> <br>Direccion</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="footer_section_2">
                <div class="row">
                    <div class="col-md-4">
                        <h2 class="useful_text">Rutas</h2>
                        <div class="footer_menu">
                            <ul>
                                <li><a href="Inicio">Inicio</a></li>
                                <li><a href="Servicios">Servicios</a></li>
                                <li><a href="Nosotros">Nosotros</a></li>
                                <li><a href="Actualizaciones">Actualizaciones</a></li>
                                <li><a href="Contacto">Contacto</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <h2 class="useful_text">Quienes Somos</h2>
                        <p class="lorem_text">OUTKARGO LTDA, es una empresa especializada en el outsourcing de montacargas con una amplia experiencia en el mercado, destacada por ofrecer al cliente soluciones ajustadas a sus necesidades, cumpliendo con el suministro de maquinaria conforme con las especificaciones técnicasy con un equipo de trabajo competente y comprometido.</p>
                    </div>
                    <div class="col-md-4">
                        <h2 class="useful_text">Registrate para recibir actualizaciones</h2>
                        <div class="form-group">
                            <textarea class="update_mail" placeholder="Ingresa tu correo" rows="5" id="comment" name="Enter Your Email"></textarea>
                            <div class="subscribe_bt"><a href="#">Subscribe</a></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="social_icon">
                <ul>
                    <li>
                        <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="copyright_section">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <p class="copyright_text"><?= $Año ?> ©OUTKARGO - Derechos reservados. Diseñado por <a href="https://html.design" rel="nofollow">HTML.DESIGN</a> Desarrollador por <a href="https://softwolf.com.co/" class="active">SoftWolf</a></p>
                </div>
            </div>
        </div>
    </div>
    <script src="App/Views/Js/jquery.min.js"></script>
    <script src="App/Views/Js/popper.min.js"></script>
    <script src="App/Views/Js/bootstrap.bundle.min.js"></script>
    <script src="App/Views/Js/jquery-3.0.0.min.js"></script>
    <script src="App/Views/Js/plugin.js"></script>
</body>

</html>