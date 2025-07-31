<?php
    include_once  "App/Models/HojaDeVida.php";
    include_once "App/Controllers/ActividadUsuarioController.php";  
    include_once "App/Controllers/UsuarioController.php"; 
    date_default_timezone_set('America/Bogota');

    class HojaDeVidaController {
        // Atributos
        private $Modelo_HojaDeVida;
        private $Controller_ActividadUsuarios;
        private $Controller_Usuario;

        // Constructor
        public function __construct() {
            $this->Modelo_HojaDeVida = new HojaDeVida();
            $this->Controller_ActividadUsuarios = new ActividadUsuarioController();
            $this->Controller_Usuario = new UsuarioController();
        }

        // Métodos
        public function Registrar($HojaDeVida, $Documento, $ID, $Fecha_Creado) {
            $idRegistro = $this->Modelo_HojaDeVida->Registrar($HojaDeVida, $ID, $Fecha_Creado);
            if ($idRegistro) {
                $Creo = 'subio';
                $DataUsuario = $this->Controller_Usuario->Mostrar($ID);     
                $Nombre1 = $DataUsuario["Nombre1"];
                $Frase = $_SESSION['Nombre1'].' Subio el documento '.$HojaDeVida. ' De '.$Nombre1;
                $ID_Usuario2 = $ID;
                $ID_Usuario1 = $_SESSION['ID'];
                $this->Controller_ActividadUsuarios->RegistrarActividadUsuario($ID_Usuario1,$ID_Usuario2,$Creo,$Frase);
                
                $extension = pathinfo($Documento['name'], PATHINFO_EXTENSION);
                $NombreDocumento = $ID.'_'.$idRegistro . '_' . str_replace(' ', '_', $HojaDeVida) . '.' . $extension;
                $uploadDir = 'App/Views/Upload/Documents/HojaDeVida/';
                $uploadFile = $uploadDir . basename($NombreDocumento);
                if ($Documento['type'] == 'application/pdf' && move_uploaded_file($Documento['tmp_name'], $uploadFile)) {
                    if ($this->Modelo_HojaDeVida->ActualizarDocumento($idRegistro, $NombreDocumento)) {
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

        public function HojaDeVida($ID_Usuario){
            if ($DataHojaDeVida = $this->Modelo_HojaDeVida->HojaDeVida($ID_Usuario)) {
                return $DataHojaDeVida;
            }else{
                return false;
            }
        }        
    }
?>
