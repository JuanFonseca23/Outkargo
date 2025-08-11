<?php
    require "App/Controllers/PaginaController.php";
    $Pagina = new PaginaController;
    $Fecha = $Pagina->Fecha();
    $Ubicacion = $Pagina->Ubicacion();
    $ValidarSession = $Pagina->ValidarSession();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>OUTKARGO - Panel de control</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <!-- Favicon -->
    <link href="../Favicon.ico" rel="icon">
    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Libraries Stylesheet -->
    <link href="../App/Views/Lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="../App/Views/Lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />
    <!-- Customized Bootstrap Stylesheet -->
    <link href="../App/Views/Css/bootstrap.min.dashboard.css" rel="stylesheet">
    <!-- Template Stylesheet -->
    <link href="../App/Views/Css/Dashboard.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Incluir CSS de DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <!-- Incluir jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Incluir DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <!-- Script para inicializar DataTables -->
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                // Opciones opcionales
                "paging": true,            // Paginación activada
                "searching": true,         // Búsqueda activada
                "ordering": true,          // Ordenamiento activado
                "info": true,              // Información sobre la tabla activada
                "lengthChange": true,     // Desactiva el cambio de número de registros por página
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/2.1.4/i18n/es-MX.json" // Archivo de idioma en español
                }
            });
        });
    </script>

</head>

<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        <!-- <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Cargando...</span>
            </div>
        </div> -->
        <!-- Spinner End -->
        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar navbar-light">
                <a href="../Panel/Menu" class="navbar-brand mx-3 mb-3">
                    <h3 class="text-primary"><img src="https://img.icons8.com/ios/50/ff5000/fork-lift.png" alt="fork-lift"/>OUTKARGO</h3>
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                        <img class="rounded-circle" src="../App/Views/Upload/Img/Perfil/<?= $_SESSION['Foto'] ?>" alt="" style="width: 40px; height: 40px;">
                        <div class="bg-success r ounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0 text-light"><?= $_SESSION['NombreCompleto'] ?></h6>
                        <span class="text-secondary"><?= $_SESSION['Cargo'] ?></span>
                    </div>
                </div>
                <div class="navbar-nav w-100">
                    <a href="../Panel/Menu" class="nav-item nav-link"><img width="20" height="20" src="https://img.icons8.com/ios/50/ff5000/dashboard.png" alt="dashboard"/> Panel de control</a>
                    <?php
                        switch ($_SESSION['IdCargo']) {
                            case '1': //Desarrollador de proyectos tecnologicos
                                require_once "Empleado.php";
                                require_once "Montacargas.php";
                                require_once "Baterias.php";
                                require_once "Cargadores.php";
                                require_once "Centros.php";
                                require_once "Dotacion.php";
                                require_once "Tickets.php";
                                require_once "Overhauling.php";
                                require_once "Huella.php";
                                require_once "Mantenimiento.php";
                                break;

                            case '2': //Practicante ingeniería software
                                require_once "Inventario.php";
                                require_once "Empleado.php";
                                require_once "Montacargas.php";
                                require_once "Baterias.php";
                                require_once "Cargadores.php";
                                require_once "Centros.php";
                                require_once "Dotacion.php";
                                require_once "Tickets.php";
                                require_once "Overhauling.php";
                                require_once "Huella.php";
                                break;

                            case '3': //Auxiliar HSEQ
                                require_once "Inventario.php";
                                require_once "OrdenesDeServicio.php";
                                require_once "Mantenimiento.php";
                                require_once "ListaDeChequeo.php";
                                require_once "Empleado.php";
                                require_once "Montacargas.php";
                                require_once "Baterias.php";
                                require_once "Cargadores.php";
                                require_once "Centros.php";
                                require_once "Dotacion.php";
                                require_once "Inspecciones.php";
                                break;

                            case '4': //Aprendiz Mecanico
                                require_once "Mantenimiento.php";
                                break;

                            case '5': //Supervisor
                                require_once "Inventario.php";
                                require_once "Mantenimiento.php";
                                require_once "ListaDeChequeo.php";
                                require_once "Empleado.php";
                                require_once "Montacargas.php";
                                require_once "Baterias.php";
                                require_once "Cargadores.php";
                                require_once "Inspecciones.php";
                                break;
                            
                            case '6': //Técnico Electromecánico
                                require_once "Mantenimiento.php";
                                break;

                            case '7': //Operador Montacargas
                                require_once "ListaDeChequeo.php";
                                break;
                            
                            case '8': //Director Tecnico
                                require_once "Inventario.php";
                                require_once "Mantenimiento.php";
                                require_once "ListaDeChequeo.php";
                                require_once "Montacargas.php";
                                require_once "Baterias.php";
                                require_once "Cargadores.php";
                                require_once "Centros.php";
                                require_once "Huella.php";
                                break;

                            case '9': //Contabilidad
                                require_once "Inventario.php";
                                require_once "Empleados.php";
                                require_once "Montacargas.php";
                                require_once "Huella.php";
                                break;

                            case '10': //Auxiliar Logistico
                                require_once "Inventario.php";
                                require_once "OrdenesDeServicio.php";
                                require_once "Mantenimiento.php";
                                require_once "ListaDeChequeo.php";
                                require_once "Empleado.php";
                                require_once "Montacargas.php";
                                require_once "Baterias.php";
                                require_once "Cargadores.php";
                                require_once "Centros.php";
                                require_once "Dotacion.php";
                                require_once "Inspecciones.php";
                                break;

                            case '11': //Director Operaciones y Control
                                require_once "Inventario.php";
                                require_once "OrdenesDeServicio.php";
                                require_once "Mantenimiento.php";
                                require_once "ListaDeChequeo.php";
                                require_once "Empleado.php";
                                require_once "Montacargas.php";
                                require_once "Baterias.php";
                                require_once "Cargadores.php";
                                require_once "Centros.php";
                                require_once "Dotacion.php";
                                require_once "Inspecciones.php";
                                require_once "Tickets.php";
                                require_once "Overhauling.php";
                                require_once "Blog.php";
                                require_once "Huella.php";
                                break;

                            case '12': //Director Administrativo y Financiero
                                require_once "Inventario.php";
                                require_once "OrdenesDeServicio.php";
                                require_once "Mantenimiento.php";
                                require_once "ListaDeChequeo.php";
                                require_once "Empleado.php";
                                require_once "Montacargas.php";
                                require_once "Baterias.php";
                                require_once "Cargadores.php";
                                require_once "Centros.php";
                                require_once "Dotacion.php";
                                require_once "Inspecciones.php";
                                require_once "Tickets.php";
                                require_once "Overhauling.php";
                                require_once "Blog.php";
                                require_once "Huella.php";
                                break;

                            case '13': //Jefe de Taller
                                require_once "Inventario.php";
                                require_once "Mantenimiento.php";
                                require_once "ListaDeChequeo.php";
                                require_once "Montacargas.php";
                                require_once "Baterias.php";
                                require_once "Cargadores.php";
                                require_once "Centros.php";
                                require_once "Huella.php";
                                break;
                            
                            case '14': //Líder HSEQ
                                require_once "Inventario.php";
                                require_once "OrdenesDeServicio.php";
                                require_once "Mantenimiento.php";
                                require_once "ListaDeChequeo.php";
                                require_once "Empleado.php";
                                require_once "Montacargas.php";
                                require_once "Baterias.php";
                                require_once "Cargadores.php";
                                require_once "Centros.php";
                                require_once "Dotacion.php";
                                require_once "Inspecciones.php";
                                require_once "Tickets.php";
                                require_once "Overhauling.php";
                                require_once "Blog.php";
                                require_once "Huella.php";
                                break;

                            case '15': //Auxiliar Multimedia
                                require_once "Blog.php";
                                break;

                            case '16': //Marketing
                                require_once "Blog.php";
                                break;
                                
                            default:
                                break;
                        }
                    ?>
                    <a href="../Panel/Salir" class="nav-item nav-link"><img width="20" height="20" src="https://img.icons8.com/ios/50/ff5000/exit--v1.png" alt="exit--v1"/> Salir</a>
                </div>
            </nav>
        </div>
        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0">
                <a href="index.html" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0"><img src="https://img.icons8.com/ios/50/ff5000/fork-lift.png" alt="fork-lift"/></h2>
                </a>
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>
                <div class="d-none d-md-flex ms-4">
                    <p><?= htmlspecialchars($Ubicacion['Ciudad']) ?> - <?= htmlspecialchars($Ubicacion['Pais']) ?> <?= htmlspecialchars($Fecha['Dia']) ?> de <?= htmlspecialchars($Fecha['Mes']) ?> del <?= htmlspecialchars($Fecha['Ano']) ?></p>
                </div>
                <div class="navbar-nav align-items-center ms-auto">
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fa fa-envelope me-lg-2"></i>
                            <span class="d-none d-lg-inline-flex">Mensajes</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                            <a href="#" class="dropdown-item">
                                <div class="d-flex align-items-center">
                                    <img class="rounded-circle" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                                    <div class="ms-2">
                                        <h6 class="fw-normal mb-0">Jhon send you a message</h6>
                                        <small>15 minutes ago</small>
                                    </div>
                                </div>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item">
                                <div class="d-flex align-items-center">
                                    <img class="rounded-circle" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                                    <div class="ms-2">
                                        <h6 class="fw-normal mb-0">Jhon send you a message</h6>
                                        <small>15 minutes ago</small>
                                    </div>
                                </div>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item">
                                <div class="d-flex align-items-center">
                                    <img class="rounded-circle" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                                    <div class="ms-2">
                                        <h6 class="fw-normal mb-0">Jhon send you a message</h6>
                                        <small>15 minutes ago</small>
                                    </div>
                                </div>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item text-center">See all message</a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fa fa-bell me-lg-2"></i>
                            <span class="d-none d-lg-inline-flex">Notificaciones</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                            <a href="#" class="dropdown-item">
                                <h6 class="fw-normal mb-0">Profile updated</h6>
                                <small>15 minutes ago</small>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item">
                                <h6 class="fw-normal mb-0">New user added</h6>
                                <small>15 minutes ago</small>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item">
                                <h6 class="fw-normal mb-0">Password changed</h6>
                                <small>15 minutes ago</small>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item text-center">See all notifications</a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <img class="rounded-circle me-lg-2" src="../App/Views/Upload/Img/Perfil/<?= $_SESSION['Foto'] ?>" alt="" style="width: 40px; height: 40px;">
                            <span class="d-none d-lg-inline-flex"><?= $_SESSION['Nombres'] ?><br><?= $_SESSION['Apellidos'] ?></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                            <a href="#" class="dropdown-item">Mi perfil</a>
                            <a href="#" class="dropdown-item">Configuraciones</a>
                            <a href="../Panel/Salir" class="dropdown-item">Salir</a>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- Navbar End -->