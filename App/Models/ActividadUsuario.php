<?php
    class ActividadUsuario{
        //Atributos
        private $PDO;
        //Construtor
        public function __construct() {
            require_once "Conexion.php";
            $Conexion = new Conexion();
            $this->PDO = $Conexion->Conexion();
        }
        //Métodos
        public function TraerActividad($ID_Usuario){
            $Estado = 1;
            $sql = "SELECT * FROM actividad_usuarios WHERE ID_Usuario1 = :ID OR ID_Usuario2 = :ID ORDER BY ID DESC LIMIT 5";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID', $ID_Usuario);
            $stmt->execute();
            $DataActividad = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $DataActividad;
        }

        public function RegistrarActividadUsuario($ID_Usuario1,$ID_Usuario2,$Creo,$Frase,$Fecha,$Hora){
            $sql = 'INSERT INTO actividad_usuarios(ID_Usuario1,ID_Usuario2,Tipo,Frase,Fecha,Hora) VALUES(:ID_Usuario1,:ID_Usuario2,:Tipo,:Frase,:Fecha,:Hora)';
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID_Usuario1', $ID_Usuario1);
            $stmt->bindParam(':ID_Usuario2', $ID_Usuario2);
            $stmt->bindParam(':Tipo', $Creo);
            $stmt->bindParam(':Frase', $Frase);
            $stmt->bindParam(':Fecha', $Fecha);
            $stmt->bindParam(':Hora', $Hora);
            if ($stmt->execute()) {
                return $this->PDO->lastInsertId();
            }else {
                return false;
            }
        }
    }
?>