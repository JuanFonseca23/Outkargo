<?php
    include_once  "App/Models/Mantenimientos.php";
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
        private $Controller_Usuarios;

        // Constructor
        public function __construct() {
            $this->Modelo_Mantenimientos = new Mantenimientos();
            $this->Controller_ActividadUsuarios = new ActividadUsuarioController();
            $this->Controller_Usuarios = new UsuarioController();
            $this->Controller_Trazabilidad = new TrazabilidadController();
        }

        // Métodos

        public function TraerMontacargas($ID_Centro) {
            $Resultado = $this->Modelo_Mantenimientos->TraerMontacargas($ID_Centro);
            return $Resultado;
        }

        public function TraerOperarios($ID_Centro) {
            $Resultado = $this->Modelo_Mantenimientos->TraerOperarios($ID_Centro);
            return $Resultado;
        }

        public function BuscarPersona($No_Documento) {
            $datausuario = $this->Controller_Usuarios->BuscarPersonaDocumento($No_Documento);     
            if ($datausuario) {               
                return $datausuario;   
            }else {
                return false;
            }
        }

       
    }
?>
