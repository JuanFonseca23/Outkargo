<?php
    include_once  "App/Models/Area.php";
    class AreaController {
        // Atributos
        private $Modelo_Area;

        // Constructor
        public function __construct() {
            $this->Modelo_Area = new Area();
        }

        public function Leer($ID) {
            if ($this->Modelo_Area->Leer($ID)) {
                $Resultado = $this->Modelo_Area->Leer($ID);
                return $Resultado;
            }
            else {
                return false;
            }
        }
    }
    
?>