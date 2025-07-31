<?php
    class Comparendos {
        // Atributos
        private $PDO;
        // Constructor
        public function __construct() {
            require_once "Conexion.php";
            $Conexion = new Conexion();
            $this->PDO = $Conexion->Conexion();
        }
        
        // Métodos
        public function Mostrar($ID){
            $sql = "SELECT usuario.Nombre1 AS Nombre_usuario, usuario.Documento AS Documento_usuario, comparendos.* FROM comparendos JOIN usuario ON comparendos.ID_Usuario = usuario.ID WHERE comparendos.ID = :ID";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID', $ID);
            $stmt->execute();
            $DataComparendos = $stmt->fetch(PDO::FETCH_ASSOC);
            return $DataComparendos;
        }

        public function Comparendos($ID_Usuario){
            $sql = "SELECT * FROM comparendos WHERE ID_Usuario = :ID_Usuario ORDER BY ID DESC";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID_Usuario', $ID_Usuario);
            $stmt->execute();
            $DataComparendos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $DataComparendos;

        }
              
        public function IngresarComparendos($ID, $Nombre, $Fecha_Realizado, $Estado, $NombreDocumento, $Fecha_Creado, $Fecha_Pagado,) {
            $sql = "INSERT INTO comparendos (ID_Usuario, Nombre, Fecha_Realizado, Estado, Documento, Fecha_Creado, Fecha_Pagado) 
                    VALUES (:ID, :Nombre, :Fecha_Realizado, :Estado, :NombreDocumento, :Fecha_Creado, :Fecha_Pagado)";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID', $ID);
            $stmt->bindParam(':Nombre', $Nombre);
            $stmt->bindParam(':Fecha_Realizado', $Fecha_Realizado);
            $stmt->bindParam(':Estado', $Estado);
            $stmt->bindParam(':NombreDocumento', $NombreDocumento);
            $stmt->bindParam(':Fecha_Creado', $Fecha_Creado);
            $stmt->bindParam(':Fecha_Pagado', $Fecha_Pagado);
            $stmt->execute();
            return $this->PDO->lastInsertId();
        }

        public function Editar($ID, $Nombre, $Fecha_Realizado, $Estado, $NombreDocumento, $Fecha_Creado, $Fecha_Pagado) {
            $sql = "UPDATE comparendos SET Nombre= :Nombre, Fecha_Realizado = :Fecha_Realizado, Estado = :Estado, Documento = :NombreDocumento, Fecha_Creado = :Fecha_Creado, Fecha_Pagado = :Fecha_Pagado WHERE ID = :ID";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':Nombre', $Nombre);
            $stmt->bindParam(':Fecha_Realizado', $Fecha_Realizado);
            $stmt->bindParam(':Estado', $Estado);
            $stmt->bindParam(':NombreDocumento', $NombreDocumento);
            $stmt->bindParam(':Fecha_Creado', $Fecha_Creado);
            $stmt->bindParam(':Fecha_Pagado', $Fecha_Pagado);
            $stmt->bindParam(':ID', $ID);
            return $stmt->execute();
        }   

        public function ActualizarNombreDocumento($ID, $NombreDocumento) {
            $sql = "UPDATE comparendos SET Documento = :NombreDocumento WHERE ID = :ID";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':NombreDocumento', $NombreDocumento);
            $stmt->bindParam(':ID', $ID);
            return $stmt->execute();
        }
    }
?>