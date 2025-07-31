<?php
    include_once  "App/Models/Usuario.php";
    include_once  "App/Models/Poligrafos.php";
    date_default_timezone_set('America/Bogota');
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    include_once "vendor/autoload.php";
    include_once "App/Controllers/ActividadUsuarioController.php";
    include_once "App/Controllers/TrazabilidadController.php";    

    class PoligrafosController {
        // Atributos
        private $Modelo_Poligrafos;
        private $Controller_ActividadUsuarios;
        private $Controller_Trazabilidad;

        // Constructor
        public function __construct() {
            $this->Modelo_Poligrafos = new Poligrafos();
            $this->Controller_ActividadUsuarios = new ActividadUsuarioController();
            $this->Controller_Trazabilidad = new TrazabilidadController();
        }

        public function Poligrafos($ID_Usuario){
            if ($DataPoligrafos = $this->Modelo_Poligrafos->Poligrafos($ID_Usuario)) {
                return $DataPoligrafos;
            }else{
                return false;
            }
        }

        public function IngresarPoligrafos($ID_Usuario1, $NombreCreo, $ID, $Nombre, $Fecha_Realizado, $Documento, $NombreUsuario, $DocumentoUsuario) {
            $uploadDir = 'App/Views/Upload/Documents/Poligrafos/';
            $Fecha_Creado = date("Y-m-d");
            $ID_Generado = $this->Modelo_Poligrafos->IngresarPoligrafos($ID, $Nombre, $Fecha_Realizado, '', $Fecha_Creado);
        
            // Renombra el documento usando el DocumentoUsuario y el ID generado
            $NombreDocumento = trim($DocumentoUsuario . "_" . $ID_Generado) . '.pdf'; 
            $uploadFile = $uploadDir . $NombreDocumento;
        
            // Crear el directorio si no existe
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
        
            if (isset($Documento) && $Documento['error'] == UPLOAD_ERR_OK) {
                $fileTmpPath = $Documento['tmp_name'];
                $fileType = $Documento['type'];
                
                if ($fileType === 'application/pdf') {
                    if (move_uploaded_file($fileTmpPath, $uploadFile)) {
                        if ($this->Modelo_Poligrafos->ActualizarNombreDocumento($ID_Generado, $NombreDocumento)) {
                            // Registra la actividad del usuario
                            $ID_Usuario = $ID;
                            $Creo = 'ingreso';
                            $Frase = $NombreCreo . ' ingresó el Poligrafo de ' . $NombreUsuario;
                            $this->Controller_ActividadUsuarios->RegistrarActividadUsuario($ID_Usuario1, $ID_Usuario, $Creo, $Frase);
                            echo "
                            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                            <script>
                                Swal.fire({
                                    title: 'Éxito!',
                                    text: 'Poligrafo ingresado correctamente',
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
                            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                            <script>
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Error al Ingresar el poligrafo',
                                    icon: 'error',
                                    timer: 2000,
                                    timerProgressBar: true
                                });
                            </script>";
                        }
                    } 
                } 
            }
        }        
    }
?>