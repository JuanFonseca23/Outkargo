<?php
    include_once  "App/Models/Montacargas.php";
    class MontacargasController {
        // Atributos
        private $Modelo_Montacargas;

        // Constructor
        public function __construct() {
            $this->Modelo_Montacargas = new Montacargas();
        }

        public function Leer($ID) {
            if ($this->Modelo_Montacargas->Leer($ID)) {
                $Resultado = $this->Modelo_Montacargas->Leer($ID);
                return $Resultado;
            }
            else {
                return false;
            }
        }

        public function TraerMarca(){
            if ($this->Modelo_Montacargas->TraerMarca()) {
                $Resultado = $this->Modelo_Montacargas->TraerMarca();
                return $Resultado;
            }
            else {
                return false;
            }
        }
    }
    
?>