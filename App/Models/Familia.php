<?php
    class Familia {
        // Atributos
        private $PDO;
        // Constructor
        public function __construct() {
            require_once "Conexion.php";
            $Conexion = new Conexion();
            $this->PDO = $Conexion->Conexion();
        }

        public function TraerHijos($ID_Usuario){
            $sql = "SELECT NombreCompleto, TIMESTAMPDIFF(YEAR, STR_TO_DATE(familia.Fecha_Nacimiento, '%Y-%m-%d'), CURDATE()) AS Edad FROM familia WHERE ID_Usuario = :ID_Usuario";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID_Usuario', $ID_Usuario);
            $stmt->execute();
            $DataHijos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $DataHijos;
        }

        public function RegistrarFamilia($ID, $NombreCompleto, $Fecha_Nacimiento, $Estado, $Fecha_Creado){
            $sql = "INSERT INTO familia (ID_Usuario, NombreCompleto, Fecha_Nacimiento, Estado, Fecha_Creado) 
                    VALUES (:ID, :NombreCompleto, :Fecha_Nacimiento, :Estado, :Fecha_Creado)";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(":ID", $ID);
            $stmt->bindParam(":NombreCompleto", $NombreCompleto);
            $stmt->bindParam(":Fecha_Nacimiento", $Fecha_Nacimiento);
            $stmt->bindParam(":Estado", $Estado);
            $stmt->bindParam(":Fecha_Creado", $Fecha_Creado);
            $stmt->execute();
            return $this->PDO->lastInsertId();
        }
    }
?>