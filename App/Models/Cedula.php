<?php
    class Cedula {
        // Atributos
        private $PDO;
        // Constructor
        public function __construct() {
            require_once "Conexion.php";
            $Conexion = new Conexion();
            $this->PDO = $Conexion->Conexion();
        }
        // Métodos
        public function Registrar($cedula, $ID, $Fecha_Creado) {
            $sql = "INSERT INTO cedula (ID_Usuario, Nombre, Fecha_Creado) 
                    VALUES (:ID_Usuario, :Nombre, :Fecha_Creado)";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID_Usuario', $ID);
            $stmt->bindParam(':Nombre', $cedula);
            $stmt->bindParam(':Fecha_Creado', $Fecha_Creado);        
            if ($stmt->execute()) {
                return $this->PDO->lastInsertId();
            } else {
                return false;
            }
        }  
        
        public function ActualizarDocumento($idRegistro, $NombreDocumento) {
            $sql = "UPDATE cedula SET Documento = :Documento WHERE ID = :ID";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':Documento', $NombreDocumento);
            $stmt->bindParam(':ID', $idRegistro);
            return $stmt->execute();
        }     

        public function cedula($ID_Usuario){
            $sql = "SELECT * FROM cedula WHERE ID_Usuario = :ID_Usuario ORDER BY ID DESC";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID_Usuario', $ID_Usuario);
            $stmt->execute();
            $DataComparendos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $DataComparendos;
        }      
    }
?>
