<?php
    include_once  "App/Models/Productos.php";
    date_default_timezone_set('America/Bogota');
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    include_once "vendor/autoload.php";
    include_once "App/Controllers/ActividadUsuarioController.php";
    include_once "App/Controllers/TrazabilidadController.php";
    include_once "App/Controllers/UsuarioController.php";     

    class MantenimientosController {
        // Atributos
        private $Modelo_Mantenimientos;
        private $Controller_ActividadUsuarios;
        private $Controller_Trazabilidad;

        // Constructor
        public function __construct() {
            $this->Modelo_Mantenimientos = new Mantenimientos();
            $this->Controller_ActividadUsuarios = new ActividadUsuarioController();
            $this->Controller_Trazabilidad = new TrazabilidadController();
        }

        // Métodos

        public function TraerMontacargas($ID_Centro) {

        }
       
    }
?>
