<?php
    class CertificadosMontacargas {
        // Atributos
        private $PDO;
        // Constructor
        public function __construct() {
            require_once "Conexion.php";
            $Conexion = new Conexion();
            $this->PDO = $Conexion->Conexion();
        }
        
        // Métodos
        public function Certificados_Montacargas($ID_Usuario){
            $sql = "SELECT Nombre, Fecha_Realizado, Fecha_Vencimiento, Documento FROM certificados_montacargas WHERE ID_Usuario = :ID_Usuario ORDER BY ID DESC";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID_Usuario', $ID_Usuario);
            $stmt->execute();
            $DataMontacargas = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $DataMontacargas;

        }
              
        public function IngresarCertificados($ID, $Nombre, $Fecha_Realizado, $Fecha_Vencimiento, $NombreDocumento, $Fecha_Creado) {
            $sql = "INSERT INTO certificados_montacargas (ID_Usuario, Nombre, Fecha_Realizado, Fecha_Vencimiento, Documento, Fecha_Creado) 
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
            $sql = "UPDATE certificados_montacargas SET Documento = :NombreDocumento WHERE ID = :ID";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':NombreDocumento', $NombreDocumento);
            $stmt->bindParam(':ID', $ID);
            return $stmt->execute();
        }
    }
?>