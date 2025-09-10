<?php
    class Mantenimientos {
        // Atributos
        private $PDO;

        // Constructor
        public function __construct() {
            require_once "Conexion.php";
            $Conexion = new Conexion();
            $this->PDO = $Conexion->Conexion();        
        }

        // Métodos
        public function TraerMontacargas($ID_Centro){
            $sql = "SELECT * FROM montacargas WHERE ID_Centro = :ID_Centro";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID_Centro', $ID_Centro);
            $stmt->execute();
            $DataMontacargas = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $DataMontacargas;
        }

        public function TraerOperarios($ID_Centro){
            $sql = "SELECT * FROM usuario WHERE ID_Centro = :ID_Centro";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID_Centro', $ID_Centro);
            $stmt->execute();
            $DataOperarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $DataOperarios;
        }
    }
    
?>