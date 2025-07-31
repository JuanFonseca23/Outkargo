<?php

    include_once  "App/Models/Educacion.php";
    date_default_timezone_set('America/Bogota');

    class EducacionController {
        // Atributos
        private $Modelo_Educacion;

        // Constructor
        public function __construct() {
            $this->Modelo_Educacion = new Educacion();
        }

        // Métodos
        public function Registrar($Educacion, $Documento, $ID, $Fecha_Creado) {
            $idRegistro = $this->Modelo_Educacion->Registrar($Educacion, $ID, $Fecha_Creado);
            if ($idRegistro) {
                $extension = pathinfo($Documento['name'], PATHINFO_EXTENSION);
                $NombreDocumento = $ID.'_'.$idRegistro . '_' . str_replace(' ', '_', $Educacion) . '.' . $extension;
                $uploadDir = 'App/Views/Upload/Documents/Educacion/';
                $uploadFile = $uploadDir . basename($NombreDocumento);
                if ($Documento['type'] == 'application/pdf' && move_uploaded_file($Documento['tmp_name'], $uploadFile)) {
                    if ($this->Modelo_Educacion->ActualizarDocumento($idRegistro, $NombreDocumento)) {
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

        public function Educacion($ID_Usuario){
            if ($DataEducacion = $this->Modelo_Educacion->Educacion($ID_Usuario)) {
                return $DataEducacion;
            }else{
                return false;
            }
        }        
    }
?>
