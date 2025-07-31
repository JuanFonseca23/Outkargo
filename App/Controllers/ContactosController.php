<?php
    include_once  "App/Models/Contactos.php";
    include_once "App/Controllers/ActividadUsuarioController.php";     
    date_default_timezone_set('America/Bogota');
    class ContactosController {
         // Atributos
        private $Modelo_Contactos;
        private $Controller_ActivadadUsuario;
         // Constructor
        public function __construct() {
            $this->Modelo_Contactos = new Contactos();
            $this->Controller_ActivadadUsuario = new ActividadUsuarioController();
        }

        public function RegistrarContacto($ID_Usuario1, $NombreCreo, $Nombre1, $ID_Usuario, $NombreContacto, $TelefonoContacto, $EstadoContacto, $Fecha_Creado){
            if ($this->Modelo_Contactos->RegistrarContacto($ID_Usuario, $NombreContacto, $TelefonoContacto, $EstadoContacto, $Fecha_Creado)) {
                $Creo = 'registro';
                $Frase = $NombreCreo.' Registro un contacto de '.$Nombre1;
                $this->Controller_ActivadadUsuario->RegistrarActividadUsuario($ID_Usuario1,$ID_Usuario,$Creo,$Frase);
                return true;
            }else {
                return false;
            }
            
        }

        public function TraerContactos($ID){
            if ($DataContacto = $this->Modelo_Contactos->TraerContactos($ID)) {
                return $DataContacto;
            }else{
                return false;
            }
        }

        public function EliminarContacto($ID_Usuario1, $NombreCreo, $ID_Usuario, $Nombre1, $ID_Eliminado) {
            if ($Resultado = $this->Modelo_Contactos->EliminarContacto($ID_Usuario)) {
                $Creo = 'elimino';
                $Frase = $NombreCreo . ' eliminó el contacto de ' . $Nombre1;
                $this->Controller_ActivadadUsuario->RegistrarActividadUsuario($ID_Usuario1, $ID_Eliminado, $Creo, $Frase);
        
                echo "
                    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                    <script>
                        Swal.fire({
                            title: 'Éxito!',
                            text: 'Usuario eliminado exitosamente',
                            icon: 'success',
                            timer: 2000,
                            timerProgressBar: true,
                            didClose: () => {
                                window.location.href = 'Ver?ID=" . $ID_Usuario1 . "';
                            }
                        });
                    </script>
                ";
            } else {
                echo "
                    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                    <script>
                        Swal.fire({
                            title: 'Error!',
                            text: 'El usuario no pudo ser eliminado',
                            icon: 'error',
                            timer: 2000,
                            timerProgressBar: true,
                            didClose: () => {
                                window.location.href = 'Ver?ID=" . $ID_Usuario . "';
                            }
                        });
                    </script>
                ";
            }
        }        
    }
?>