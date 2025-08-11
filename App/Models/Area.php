<?php
    class Area {
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
                    area.*, 
                    centrot.Nombre AS Ubicacion
                FROM 
                    area
                INNER JOIN 
                    centrot 
                ON 
                    area.ID_Centro = centrot.ID
                WHERE 
                    area.Estado = :Estado 
                    AND area.ID_Centro = :ID_Centro
                    AND centrot.Estado = :Estado";
            
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':Estado', $Estado);
            $stmt->bindParam(':ID_Centro', $ID_Centro);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
    
?>