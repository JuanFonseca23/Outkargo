<?php
    include_once  "App/Models/Trazabilidad.php";
    date_default_timezone_set('America/Bogota');
    class TrazabilidadController {
         // Atributos
        private $Modelo_Trazabilidad;

         // Constructor
        public function __construct() {
            $this->Modelo_Trazabilidad = new Trazabilidad();
        }

        public function RegistrarTrazabilidad($ID_Actividad,$NombreTabla,$ValorAntiguo,$ValorNuevo){
            $Fecha = date('Y-m-d');
            $Hora = date('H:i:s');
            if ($this->Modelo_Trazabilidad->RegistrarTrazabilidad($ID_Actividad,$NombreTabla,$ValorAntiguo,$ValorNuevo,$Fecha,$Hora)) {
                return true;
            } else {
                return false;
            }       
        }
    }
    
?>