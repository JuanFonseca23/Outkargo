<?php
    class HojaDeVida {
        // Atributos
        private $PDO;
        // Constructor
        public function __construct() {
            require_once "Conexion.php";
            $Conexion = new Conexion();
            $this->PDO = $Conexion->Conexion();
        }
        // Métodos
        public function Registrar($hoja_de_vida, $ID, $Fecha_Creado) {
            $sql = "INSERT INTO hoja_de_vida (ID_Usuario, Nombre, Fecha_Creado) 
                    VALUES (:ID_Usuario, :Nombre, :Fecha_Creado)";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID_Usuario', $ID);
            $stmt->bindParam(':Nombre', $hoja_de_vida);
            $stmt->bindParam(':Fecha_Creado', $Fecha_Creado);        
            if ($stmt->execute()) {
                return $this->PDO->lastInsertId();
            } else {
                return false;
            }
        }  
        
        public function ActualizarDocumento($idRegistro, $NombreDocumento) {
            $sql = "UPDATE hoja_de_vida SET Documento = :Documento WHERE ID = :ID";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':Documento', $NombreDocumento);
            $stmt->bindParam(':ID', $idRegistro);
            return $stmt->execute();
        }     

        public function HojaDeVida($ID_Usuario){
            $sql = "SELECT * FROM hoja_de_vida WHERE ID_Usuario = :ID_Usuario ORDER BY ID DESC";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID_Usuario', $ID_Usuario);
            $stmt->execute();
            $DataComparendos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $DataComparendos;
        }      
    }
?>
