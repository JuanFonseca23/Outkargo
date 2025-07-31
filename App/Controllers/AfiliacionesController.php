<?php
    include_once  "App/Models/Afiliaciones.php";
    include_once "App/Controllers/ActividadUsuarioController.php";  
    include_once "App/Controllers/UsuarioController.php"; 
    date_default_timezone_set('America/Bogota');

    class AfiliacionesController {
        // Atributos
        private $Modelo_Afiliaciones;
        private $Controller_ActividadUsuarios;
        private $Controller_Usuario;

        // Constructor
        public function __construct() {
            $this->Modelo_Afiliaciones = new Afiliaciones();
            $this->Controller_ActividadUsuarios = new ActividadUsuarioController();
            $this->Controller_Usuario = new UsuarioController();
        }

        // Métodos
        public function Registrar($Afiliaciones, $Documento, $ID, $Fecha_Creado) {
            $idRegistro = $this->Modelo_Afiliaciones->Registrar($Afiliaciones, $ID, $Fecha_Creado);
            $Creo = 'subio';
                $DataUsuario = $this->Controller_Usuario->Mostrar($ID);     
                $Nombre1 = $DataUsuario["Nombre1"];
                $Frase = $_SESSION['Nombre1'].' Subio el documento '.$Afiliaciones. ' De '.$Nombre1;
                $ID_Usuario2 = $ID;
                $ID_Usuario1 = $_SESSION['ID'];
                $this->Controller_ActividadUsuarios->RegistrarActividadUsuario($ID_Usuario1,$ID_Usuario2,$Creo,$Frase);
                
            if ($idRegistro) {
                $extension = pathinfo($Documento['name'], PATHINFO_EXTENSION);
                $NombreDocumento = $ID.'_'.$idRegistro . '_' . str_replace(' ', '_', $Afiliaciones) . '.' . $extension;
                $uploadDir = 'App/Views/Upload/Documents/Afiliaciones/';
                $uploadFile = $uploadDir . basename($NombreDocumento);
                if ($Documento['type'] == 'application/pdf' && move_uploaded_file($Documento['tmp_name'], $uploadFile)) {
                    if ($this->Modelo_Afiliaciones->ActualizarDocumento($idRegistro, $NombreDocumento)) {
                        echo "<script>Swal.fire('Éxito', 'Registro y archivo subido correctamente', 'success');</script>";
                    } else {
                        echo "<script>Swal.fire('Error', 'Error al actualizar el documento en el registro', 'error');</script>";
                    }
                } else {
                    echo "<script>Swal.fire('Error', 'Error al subir el archivo. Asegúrese de que sea un archivo PDF.', 'error');</script>";
                }
            } else {
                echo "<script>Swal.fire('Error', 'Error al registrar la información', 'error');</script>";
            }
        }

        public function Afiliaciones($ID_Usuario){
            if ($DataAfiliaciones = $this->Modelo_Afiliaciones->Afiliaciones($ID_Usuario)) {
                return $DataAfiliaciones;
            }else{
                return false;
            }
        }        
    }
?>
