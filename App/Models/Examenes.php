<?php
    class Examenes {
        // Atributos
        private $PDO;
        // Constructor
        public function __construct() {
            require_once "Conexion.php";
            $Conexion = new Conexion();
            $this->PDO = $Conexion->Conexion();
        }
        
        // Métodos
        public function Examenes($ID_Usuario){
            $sql = "SELECT Nombre, Fecha_Realizado, Fecha_Vencimiento, Documento FROM examenes_medicos WHERE ID_Usuario = :ID_Usuario ORDER BY ID DESC";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID_Usuario', $ID_Usuario);
            $stmt->execute();
            $DataExamenes = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $DataExamenes;

        }
              
        public function IngresarExamenes($ID, $Nombre, $Fecha_Realizado, $Fecha_Vencimiento, $NombreDocumento, $Fecha_Creado) {
            $sql = "INSERT INTO examenes_medicos (ID_Usuario, Nombre, Fecha_Realizado, Fecha_Vencimiento, Documento, Fecha_Creado) 
                    VALUES (:ID, :Nombre, :Fecha_Realizado, :Fecha_Vencimiento, :NombreDocumento, :Fecha_Creado)";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID', $ID);
            $stmt->bindParam(':Nombre', $Nombre);
            $stmt->bindParam(':Fecha_Realizado', $Fecha_Realizado);
            $stmt->bindParam(':Fecha_Vencimiento', $Fecha_Vencimiento);
            $stmt->bindParam(':NombreDocumento', $NombreDocumento);
            $stmt->bindParam(':Fecha_Creado', $Fecha_Creado);
            $stmt->execute();
            return $this->PDO->lastInsertId();
        }

        public function ActualizarNombreDocumento($ID, $NombreDocumento) {
            $sql = "UPDATE examenes_medicos SET Documento = :NombreDocumento WHERE ID = :ID";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':NombreDocumento', $NombreDocumento);
            $stmt->bindParam(':ID', $ID);
            return $stmt->execute();
        }
    }
?>