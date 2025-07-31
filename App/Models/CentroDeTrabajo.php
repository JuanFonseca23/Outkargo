<?php
    class CentroDeTrabajo {
        // Atributos
        private $PDO;

        // Constructor
        public function __construct() {
            require_once "Conexion.php";
            $Conexion = new Conexion();
            $this->PDO = $Conexion->Conexion();        
        }

        // Métodos
        public function VerificarCentro($ID) {
            $sql = "SELECT Nombre FROM centrot WHERE ID = :ID";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID', $ID);
            $stmt->execute();
            $CentroTrabajo= $stmt->fetch(PDO::FETCH_ASSOC);
            return $CentroTrabajo;
        }

        public function ListaCargos(){
            $Estado = 1;
            $sql = "SELECT * FROM cargos WHERE Estado = :Estado";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':Estado', $Estado);
            $stmt->execute();
            $DataUsuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $DataUsuarios;
        }

        public function TraerCentrosDeTrabajo(){
            $Estado = 1;
            $sql = "SELECT * FROM centrot WHERE Estado = :Estado";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':Estado', $Estado);
            $stmt->execute();
            $DataCentrosDeTrabajo = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $DataCentrosDeTrabajo;
        }
    }
    
?>