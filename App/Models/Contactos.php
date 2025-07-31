<?php
    class Contactos {
        // Atributos
        private $PDO;

        // Constructor
        public function __construct() {
            require_once "Conexion.php";
            $Conexion = new Conexion();
            $this->PDO = $Conexion->Conexion();        
        }

        // Métodos
        public function RegistrarContacto($ID_Usuario, $NombreContacto, $TelefonoContacto, $EstadoContacto, $Fecha_Creado) {
            $sql = "INSERT INTO contactos (ID_Usuario, Nombre, Telefono, Estado, Fecha_Creado) VALUES (:ID_Usuario, :Nombre, :Telefono, :Estado, :Fecha_Creado)";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID_Usuario', $ID_Usuario);
            $stmt->bindParam(':Nombre', $NombreContacto);
            $stmt->bindParam(':Telefono', $TelefonoContacto);
            $stmt->bindParam(':Estado', $EstadoContacto);
            $stmt->bindParam(':Fecha_Creado', $Fecha_Creado);
            $stmt->execute();
            return $this->PDO->lastInsertId();
        }

        public function TraerContactos($ID){
            $Estado = 1;
            $sql = "SELECT * FROM contactos WHERE ID_Usuario = :ID AND Estado = :Estado";
            $stmt = $this->PDO->prepare($sql);            
            $stmt->bindParam(':ID', $ID);
            $stmt->bindParam(':Estado', $Estado);
            $stmt->execute();
            $DataContactos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $DataContactos;
        }

        public function EliminarContacto($ID) {
            $Fecha= date('Y-m-d');
            $Estado = 0;
            $sql = "UPDATE contactos SET Estado = :Estado, Fecha_Eliminado = :Fecha WHERE ID = :ID_Usuario";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID_Usuario', $ID);
            $stmt->bindParam(':Fecha', $Fecha);
            $stmt->bindParam(':Estado', $Estado);
            return $stmt->execute();
        }
        
    }
    
?>