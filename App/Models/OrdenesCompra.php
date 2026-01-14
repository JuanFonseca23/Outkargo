<?php
    class OrdenesCompra {
        // Atributos
        private $PDO;

        // Constructor
        public function __construct() {
            require_once "Conexion.php";
            $Conexion = new Conexion();
            $this->PDO = $Conexion->Conexion();        
        }

        // Métodos
       public function BuscarDestinatarios($q){
        $sql = "SELECT 
                    ID AS id,
                    NombreCompleto AS nombre,
                    Correo AS email
                FROM usuario
                WHERE NombreCompleto LIKE :q
                OR Correo LIKE :q
                ORDER BY NombreCompleto";

        $stmt = $this->PDO->prepare($sql);
        $stmt->bindValue(':q', "%$q%", PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

        public function DetallesSolicitusCompra($ID_Solicitud) {
            $sql = "SELECT t.ID_Usuario, t.Cantidad, t.Descripcion, t.Medidas, t.Precio_Unitario, t.Precio_Total
                    FROM detalles_temp_solicitud_compra t
                    JOIN solicitud_compra s ON t.ID_Usuario = s.ID_Usuario
                    WHERE s.ID = :ID_Solicitud";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID_Solicitud', $ID_Solicitud);
            $stmt->execute();
            $Solicitudes = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($Solicitudes){
                $this->PDO->beginTransaction();
                try{
                    foreach ($Solicitudes as $Solicitud) {
                        $ID_Usuario = $Solicitud['ID_Usuario'];
                        $Cantidad = $Solicitud['Cantidad'];
                        $Descripcion = $Solicitud['Descripcion'];
                        $Medidas = $Solicitud['Medidas'];
                        $Precio_Unitario = $Solicitud['Precio_Unitario'];
                        $Precio_Total = $Solicitud['Precio_Total'];
                        $Estado = "PENDIENTE";
                        $stmt = $this->PDO->prepare("INSERT INTO detalles_solicitud_compra (ID_Solicitud, ID_Usuario, Cantidad, Descripcion, Medidas, Precio_Unitario, Precio_Total, Estado) 
                                                    VALUES (:ID_Solicitud, :ID_Usuario, :Cantidad, :Descripcion, :Medidas, :Precio_Unitario, :Precio_Total, :Estado)");
                        $stmt->bindParam(':ID_Solicitud', $ID_Solicitud);
                        $stmt->bindParam(':ID_Usuario', $ID_Usuario);
                        $stmt->bindParam(':Cantidad', $Cantidad);
                        $stmt->bindParam(':Descripcion', $Descripcion);
                        $stmt->bindParam(':Medidas', $Medidas);
                        $stmt->bindParam(':Precio_Unitario', $Precio_Unitario);
                        $stmt->bindParam(':Precio_Total', $Precio_Total);
                        $stmt->bindParam(':Estado', $Estado);
                        $stmt->execute();
                        // Eliminar los detalles de la tabla temporal
                        $stmt = $this->PDO->prepare("DELETE FROM detalles_temp_solicitud_compra WHERE ID_Usuario = :ID_Usuario ");
                        $stmt->bindParam(':ID_Usuario', $ID_Usuario);
                        $stmt->execute();
                    }
                    $this->PDO->commit();
                    return true;
                } catch (Exception $e) {
                    $this->PDO->rollBack();
                    return false;
                }
            }
            else {
                return false; 
            }   
        }

        public function DetallesTempSolicitudCompra($ID_Usuario) {
            $sql = "SELECT * FROM detalles_temp_solicitud_compra WHERE ID_Usuario = :ID_Usuario";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID_Usuario', $ID_Usuario);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function EliminarSolicitudTemp($ID_Usuario, $ID) {
            $sql = "DELETE FROM detalles_temp_solicitud_compra WHERE ID_Usuario = :ID_Usuario AND ID = :ID ";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID_Usuario', $ID_Usuario);
            $stmt->bindParam(':ID', $ID);
            return $stmt->execute();
        }

        public function InsertarSolicitudCompra($Numero, $ID_Usuario, $ID_Centro, $Firma_Solicita, $Fecha_Solicitud, $Descripcion, $Estado) {
            $sql = "INSERT INTO solicitud_compra (Numero, ID_Usuario, ID_Autoriza, ID_Centro, Firma_Solicita, Firma_Autoriza, Fecha_Solicitud, Fecha_Autoriza, Descripcion, Estado) 
                    VALUES (:Numero, :ID_Usuario, NULL, :ID_Centro, :Firma_Solicita, NULL, :Fecha_Solicitud, NULL, :Descripcion, :Estado)";

            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':Numero', $Numero);
            $stmt->bindParam(':ID_Usuario', $ID_Usuario);
            $stmt->bindParam(':ID_Centro', $ID_Centro);
            $stmt->bindParam(':Fecha_Solicitud', $Fecha_Solicitud);
            $stmt->bindParam(':Firma_Solicita', $Firma_Solicita);
            $stmt->bindParam(':Descripcion', $Descripcion);
            $stmt->bindParam(':Estado', $Estado);
            if($stmt->execute()) {
                return $this->PDO->lastInsertId(); 
            } else {
                return false; 
            }
        }

        public function InsertarSolicitudTemp($Cantidad, $Descripcion, $Medidas, $Precio_Unitario, $Precio_Total, $ID_Usuario) {
            $sql = "INSERT INTO detalles_temp_solicitud_compra 
                    (ID_Usuario, Cantidad, Descripcion, Medidas, Precio_Unitario, Precio_Total) 
                    VALUES (:ID_Usuario, :Cantidad, :Descripcion, :Medidas, :Precio_Unitario, :Precio_Total)";

            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID_Usuario', $ID_Usuario);
            $stmt->bindParam(':Cantidad', $Cantidad);
            $stmt->bindParam(':Descripcion', $Descripcion);
            $stmt->bindParam(':Medidas', $Medidas);
            $stmt->bindParam(':Precio_Unitario', $Precio_Unitario);
            $stmt->bindParam(':Precio_Total', $Precio_Total);
            return $stmt->execute();
        }

        public function MostrarDetallesSolicitud($ID){
            $sql = "SELECT * FROM detalles_solicitud_compra WHERE ID_Solicitud = :ID";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID', $ID, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC); 
        }

        public function ObtenerCorreos(array $ID_Correos){
            if (empty($ID_Correos)) {
                return [];
            }

            $placeholders = implode(',', array_fill(0, count($ID_Correos), '?'));

            $sql = "SELECT NombreCompleto, Correo
                    FROM usuario
                    WHERE ID IN ($placeholders)";

            $stmt = $this->PDO->prepare($sql);

            foreach ($ID_Correos as $i => $id) {
                $stmt->bindValue($i + 1, (int)$id, PDO::PARAM_INT);
            }

            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }


        public function ObtenerNumeroFormularioSolicitud(){
            $sql = "SELECT `Numero` FROM solicitud_compra ORDER BY ID DESC LIMIT 1";
            $stmt = $this->PDO->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? $result['Numero'] : null;
        }

        public function TraerOverhauling() {
            $sql = "SELECT ID, Numero FROM overhauling_inicial";
            $stmt = $this->PDO->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function VerSolicitud($ID){
            $sql = "SELECT usuario_Solicita.NombreCompleto AS NombreSolicita,
                           usuario_Supervisor.NombreCompleto AS NombreSupervisor, 
                           centro_solicita.Nombre AS CentroSolicita, 
                           solicitud_compra.*
                    FROM solicitud_compra
                    LEFT JOIN usuario AS usuario_Solicita ON solicitud_compra.ID_Usuario = usuario_Solicita.ID
                    LEFT JOIN usuario AS usuario_Supervisor ON solicitud_compra.ID_Autoriza  = usuario_Supervisor.ID
                    LEFT JOIN centrot AS centro_solicita ON solicitud_compra.ID_Centro = centro_solicita.ID
                    WHERE solicitud_compra.ID = :ID";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID', $ID);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }
?>