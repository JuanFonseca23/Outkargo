<?php
    class Router {
        private $routes;

        public function __construct(array $routes) {
            $this->routes = $routes;
        }

        public function handleRequest() {
            $url = $this->sanitizeUrl($_GET['url'] ?? '/');

            if ($this->isValidUrl($url)) {
                $this->routeRequest($url);
            } else {
                $this->showError('Invalid URL');
            }
        }

        private function sanitizeUrl($url) {
            return htmlspecialchars($url);
        }

        private function isValidUrl($url) {
            return preg_match('/^[a-zA-Z0-9\/]+$/', $url);
        }

        private function routeRequest($url) {
            if (array_key_exists($url, $this->routes)) {
                list($folder, $file) = array_map('htmlspecialchars', explode('/', $this->routes[$url], 2));
                $filePath = 'App/' . $folder . '/' . $file;

                $this->includeFile($filePath);
            } else {
                $this->showError('404 Not Found');
            }
        }

        private function includeFile($filePath) {
            if (file_exists($filePath)) {
                include $filePath;
            } else {
                $this->showError('404 Not Found');
            }
        }

        private function showError($message) {
            echo "<h1>Error:</h1> <p>{$message}</p>";
            exit;
        }
    }

    // Cargando todas las rutas
    $PrincipalesRoutes = include 'App/Routes/Principales_Routes.php';
    $UsuarioRoutes = include 'App/Routes/Usuario_Routes.php';
    $EmpleadosRoutes = include 'App/Routes/Empleados_Routes.php';
    $Inventario_Routes = include 'App/Routes/Inventario_Routes.php';
    $DotacionRoutes = include 'App/Routes/Dotacion_Routes.php';
    $TicketsRoutes = include 'App/Routes/Tickets_Routes.php';
    $InspeccionesRoutes = include 'App/Routes/Inspecciones_Routes.php';
    $ProductosRoutes = include 'App/Routes/Productos_Routes.php';
    $MontacargasRoutes = include 'App/Routes/Montacargas_Routes.php';
    $MantenimientoRoutes = include 'App/Routes/Mantenimiento_Routes.php';
    $BlogRoutes = include 'App/Routes/Blog_Routes.php';
    $OverallRoutes = include 'App/Routes/Overhauling_Routes.php';


    // Merge de todas las rutas
    $routes = array_merge(
        $PrincipalesRoutes, 
        $UsuarioRoutes, 
        $Inventario_Routes, 
        $EmpleadosRoutes, 
        $DotacionRoutes, 
        $TicketsRoutes, 
        $InspeccionesRoutes, 
        $ProductosRoutes,
        $MontacargasRoutes,
        $MantenimientoRoutes,
        $BlogRoutes,
        $OverallRoutes,
        [
            '' => 'Views/Templates/Principal/Inicio.php',
            '/' => 'Views/Templates/Principal/Index.php',
            'Inicio' => 'Views/Templates/Principal/Index.php',
            'Servicios' => 'Views/Templates/Servicios.php',
            'Nosotros' => 'Views/Templates/Nosotros.php',
            'Actualizaciones' => 'Views/Templates/Actualizaciones.php',
            'Contacto' => 'Views/Templates/Contacto.php',
            'IniciarSesion' => 'Views/Templates/IniciarSesion.php',
            'ActivarCuenta' => 'Views/Templates/ActivarCuenta.php',
            'Huella/Inicio' => 'Views/Templates/Huella/Inicio.php',
        ]
    );

    // Instanciar el router y manejar la solicitud
    $router = new Router($routes);
    $router->handleRequest();
?>
