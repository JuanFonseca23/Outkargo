<?php
    include_once  "App/Models/Usuario.php";
    include_once  "App/Models/Familia.php";
    date_default_timezone_set('America/Bogota');
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    include_once "vendor/autoload.php";
    include_once "App/Controllers/ActividadUsuarioController.php";
    include_once "App/Controllers/TrazabilidadController.php";   

    class FamiliaController {
        // Atributos
        private $Modelo_Familia;
        private $Controller_ActividadUsuarios;
        private $Controller_Trazabilidad;

        // Constructor
        public function __construct() {
            $this->Modelo_Familia = new Familia();
            $this->Controller_ActividadUsuarios = new ActividadUsuarioController();
            $this->Controller_Trazabilidad = new TrazabilidadController();
        }

        public function TraerHijos($ID_Usuario){
            if ($DataHijos = $this->Modelo_Familia->TraerHijos($ID_Usuario)) {
                return $DataHijos;
            }else{
                return false;
            }
        }

        public function RegistrarFamilia($ID_Usuario1, $NombreCreo, $ID, $NombreCompleto, $Fecha_Nacimiento, $NombreUsuario) {
            $Estado = 1;            
            $Fecha_Creado = date("Y-m-d");
            if ($this->Modelo_Familia->RegistrarFamilia($ID, $NombreCompleto, $Fecha_Nacimiento, $Estado, $Fecha_Creado)) {
                $ID_Usuario=$ID;
                $Creo = 'registro';
                $Frase = $NombreCreo.' Registro el hijo de '.$NombreUsuario;
                $this->Controller_ActividadUsuarios->RegistrarActividadUsuario($ID_Usuario1,$ID_Usuario,$Creo,$Frase);
                echo "
                <script>
                    Swal.fire({
                        title: 'Éxito!',
                        text: 'Hijo Registrado exitosamente',
                        icon: 'success',
                        timer: 2000,
                        timerProgressBar: true,
                        didClose: () => {
                            window.location.href = 'Ver?ID=".$ID."'; // Redirige a la página 'Inicio' después de 2 segundos
                        }
                    });
                </script>";
            } else {
                echo "
                <script>
                    Swal.fire({
                        title: 'Error!',
                        text: 'Error al registrar el hijo',
                        icon: 'error',
                        timer: 2000,
                        timerProgressBar: true
                    });
                </script>";
            }            
        }
    }
?>