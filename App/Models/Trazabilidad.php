<?php
    class Trazabilidad {
        // Atributos
        private $PDO;

        // Constructor
        public function __construct() {
            require_once "Conexion.php";
            $Conexion = new Conexion();
            $this->PDO = $Conexion->Conexion();        
        }

        // Métodos
        public function RegistrarTrazabilidad($ID_Actividad,$NombreTabla,$ValorAntiguo,$ValorNuevo,$Fecha,$Hora){
            $sql = "INSERT INTO trazabilidad (ID_Actividad,Detalle,ValorAntiguo,ValorNuevo,Fecha,Hora) VALUES (:ID_Actividad,:NombreTabla,:ValorAntiguo,:ValorNuevo,:Fecha,:Hora)";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID_Actividad', $ID_Actividad);
            $stmt->bindParam(':NombreTabla', $NombreTabla);
            $stmt->bindParam(':ValorAntiguo', $ValorAntiguo);
            $stmt->bindParam(':ValorNuevo', $ValorNuevo);
            $stmt->bindParam(':Fecha', $Fecha);
            $stmt->bindParam(':Hora', $Hora);
            $stmt->execute();
            $DataUsuarios = $stmt->fetch(PDO::FETCH_ASSOC);
            return $DataUsuarios;
        }
    }
    
?>