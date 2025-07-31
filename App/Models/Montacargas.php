<?php
    class Montacargas {
        // Atributos
        private $PDO;

        // Constructor
        public function __construct() {
            require_once "Conexion.php";
            $Conexion = new Conexion();
            $this->PDO = $Conexion->Conexion();        
        }

        // Métodos
        public function Leer($ID_Centro) {
            $Estado = 1;
            $sql = "
                SELECT 
                    montacargas.*, 
                    centrot.Nombre AS Ubicacion
                FROM 
                    montacargas
                INNER JOIN 
                    centrot 
                ON 
                    montacargas.ID_Centro = centrot.ID
                WHERE 
                    montacargas.Estado = :Estado 
                    AND montacargas.ID_Centro = :ID_Centro
                    AND centrot.Estado = :Estado";
            
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':Estado', $Estado);
            $stmt->bindParam(':ID_Centro', $ID_Centro);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }        
    }
    
?>