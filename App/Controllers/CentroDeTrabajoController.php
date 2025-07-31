<?php
    include_once  "App/Models/CentroDeTrabajo.php";
    class CentroDeTrabajoController {
         // Atributos
        private $Modelo_CentroTrabajo;

         // Constructor
        public function __construct() {
            $this->Modelo_CentroTrabajo = new CentroDeTrabajo();
        }


        public function VerificarCentro($ID) {
            if ($this->Modelo_CentroTrabajo->VerificarCentro($ID)) {
                $Resultado = $this->Modelo_CentroTrabajo->VerificarCentro($ID);
                return $Resultado;
            }
            else {
                return false;
            }
        }

        public function ListaCargos(){
            $Resultado = $this->Modelo_CentroTrabajo->ListaCargos();
            return $Resultado;            
        }

        public function TraerCentrosDeTrabajo(){
            $Resultado = $this->Modelo_CentroTrabajo->TraerCentrosDeTrabajo();
            return $Resultado;
        }
    }
    
?>