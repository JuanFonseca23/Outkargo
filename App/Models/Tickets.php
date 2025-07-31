<?php
class Tickets {
    // Atributos
    private $PDO;
    
    // Constructor
    public function __construct() {
        require_once "Conexion.php";
        $Conexion = new Conexion();
        $this->PDO = $Conexion->Conexion();
    }

    public function Leer(){
        $sql = "SELECT usuario_solicita.NombreCompleto AS NombreUsuario, usuario_solicita.Correo AS CorreoUsuario, usuario_gestiona.NombreCompleto AS NombreGestiona, tickets.* 
                FROM tickets 
                LEFT JOIN usuario AS usuario_solicita ON tickets.ID_Solicitante = usuario_solicita.ID 
                LEFT JOIN usuario AS usuario_gestiona ON tickets.ID_Gestiona = usuario_gestiona.ID";
        $stmt = $this->PDO->prepare($sql);
        $stmt->execute();
        $DataUsuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $DataUsuarios;
    }

    public function LeerS($ID){
        $sql = "SELECT usuario_solicita.NombreCompleto AS NombreUsuario, usuario_gestiona.NombreCompleto AS NombreGestiona, tickets.* 
                FROM tickets 
                LEFT JOIN usuario AS usuario_solicita ON tickets.ID_Solicitante = usuario_solicita.ID 
                LEFT JOIN usuario AS usuario_gestiona ON tickets.ID_Gestiona = usuario_gestiona.ID
                WHERE ID_Solicitante = :ID";
        $stmt = $this->PDO->prepare($sql);
        $stmt->bindParam(':ID', $ID);
        $stmt->execute();
        $DataUsuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $DataUsuarios;
    }

    public function RegistrarTicket($ID_Solicitante, $Tipo, $Descripcion, $Estado, $Fecha_Creado, $Hora, $Estado_Aceptacion, $Estado_Encuesta) {
        $sql = "INSERT INTO tickets (ID_Solicitante, ID_Gestiona, Tipo, Descripcion, Estado, Fecha_Creado, Fecha_Finalizado, Hora, Estado_Aceptacion, Estado_Encuesta) 
                VALUES (:ID_Solicitante, NULL, :Tipo, :Descripcion, :Estado, :Fecha_Creado, NULL, :Hora, :Estado_Aceptacion, :Estado_Encuesta)";
        $stmt = $this->PDO->prepare($sql);
        
        $stmt->bindParam(':ID_Solicitante', $ID_Solicitante);
        $stmt->bindParam(':Tipo', $Tipo);
        $stmt->bindParam(':Descripcion', $Descripcion);
        $stmt->bindParam(':Estado', $Estado);
        $stmt->bindParam(':Fecha_Creado', $Fecha_Creado);
        $stmt->bindParam(':Hora', $Hora);
        $stmt->bindParam(':Estado_Aceptacion', $Estado_Aceptacion);
        $stmt->bindParam(':Estado_Encuesta', $Estado_Encuesta);
    
        try {
            $stmt->execute(); 
            return $this->PDO->lastInsertId();
        } catch (Exception $e) {
            echo "Error al registrar el ticket: " . $e->getMessage();
            return false;
        }
    }    
    
    public function RegistrarTicketEvidencia($ID_Ticket, $ID_Usuario, $ID_Detalle_Ticket, $Evidencia_Fotografica) {
        $sql = "INSERT INTO detalle_tickets_evidencia (ID_Ticket, ID_Detalle_Ticket, ID_Usuario, Evidencia_Fotografica) 
                VALUES (:ID_Ticket, :ID_Detalle_Ticket, :ID_Usuario, :Evidencia_Fotografica)";
        $stmt = $this->PDO->prepare($sql);
        $stmt->bindParam(':ID_Ticket', $ID_Ticket);
        $stmt->bindParam(':ID_Usuario', $ID_Usuario);
        $stmt->bindParam(':ID_Detalle_Ticket', $ID_Detalle_Ticket);
        $stmt->bindParam(':Evidencia_Fotografica', $Evidencia_Fotografica);
    
        try {
            $stmt->execute();
            return true;
        } catch (Exception $e) {
            echo "Error al registrar la evidencia de ticket: " . $e->getMessage();
            return false;
        }
    }   
    
    public function AceptarTicket($ID_Ticket, $ID_Gestiona, $Estado, $Estado_Aceptacion){
        $sql = "UPDATE tickets SET ID_Gestiona = :ID_Gestiona, Estado = :Estado, Estado_Aceptacion = :Estado_Aceptacion WHERE ID = :ID_Ticket";
        $stmt = $this->PDO->prepare($sql);
        $stmt->bindParam(':ID_Ticket', $ID_Ticket);
        $stmt->bindParam(':ID_Gestiona', $ID_Gestiona);
        $stmt->bindParam(':Estado', $Estado);
        $stmt->bindParam(':Estado_Aceptacion', $Estado_Aceptacion);
    
        try {
            $stmt->execute();
            return true;
        } catch (Exception $e) {
            echo "Error al aceptar el ticket: " . $e->getMessage();
            return false;
        }
    }

    public function FinalizarTicket($ID_Ticket,  $Estado, $Fecha_Finalizado){
        $sql = "UPDATE tickets SET Estado = :Estado, Fecha_Finalizado = :Fecha_Finalizado WHERE ID = :ID_Ticket";
        $stmt = $this->PDO->prepare($sql);
        $stmt->bindParam(':ID_Ticket', $ID_Ticket);
        $stmt->bindParam(':Estado', $Estado);
        $stmt->bindParam(':Fecha_Finalizado', $Fecha_Finalizado);
    
        try {
            $stmt->execute();
            return true;
        } catch (Exception $e) {
            echo "Error al finalizar el ticket: " . $e->getMessage();
            return false;
        }
    }

    public function RegistrarEncuesta($ID_Ticket, $ID_Evalua, $ID_Evaluado, $Respuesta_1, $Comentario_Respuesta_1, $Comentario) {
        $sql = "INSERT INTO resultados_encuesta (ID_Ticket, ID_Usuario, ID_Evaluado, Respuesta_1, Comentario_Respuesta1, Comentario) 
                VALUES (:ID_Ticket, :ID_Evalua, :ID_Evaluado, :Respuesta_1, :Comentario_Respuesta_1, :Comentario)";
        $stmt = $this->PDO->prepare($sql);
        $stmt->bindParam(':ID_Ticket', $ID_Ticket);
        $stmt->bindParam(':ID_Evalua', $ID_Evalua);
        $stmt->bindParam(':ID_Evaluado', $ID_Evaluado);
        $stmt->bindParam(':Respuesta_1', $Respuesta_1);
        $stmt->bindParam(':Comentario_Respuesta_1', $Comentario_Respuesta_1);
        $stmt->bindParam(':Comentario', $Comentario);
    
        try {
            $stmt->execute(); 
            return $this->PDO->lastInsertId();
        } catch (Exception $e) {
            echo "Error al registrar resultado de encuesta del ticket: " . $e->getMessage();
            return false;
        }
    }    

    public function ActualizarEstado_Encuesta($ID_Ticket, $Estado_Encuesta){
        $sql = "UPDATE tickets SET Estado_Encuesta = :Estado_Encuesta WHERE ID = :ID_Ticket";
        $stmt = $this->PDO->prepare($sql);
        $stmt->bindParam(':ID_Ticket', $ID_Ticket);
        $stmt->bindParam(':Estado_Encuesta', $Estado_Encuesta);   
        try {
            $stmt->execute();
            return true;
        } catch (Exception $e) {
            echo "Error al actualizar estado de encuesta del ticket: " . $e->getMessage();
            return false;
        }
    }

    public function TransferirTicket($ID_Ticket, $ID_Gestiona){
        $sql = "UPDATE tickets SET ID_Gestiona = :ID_Gestiona WHERE ID = :ID_Ticket";
        $stmt = $this->PDO->prepare($sql);
        $stmt->bindParam(':ID_Ticket', $ID_Ticket);
        $stmt->bindParam(':ID_Gestiona', $ID_Gestiona);   
        try {
            $stmt->execute();
            return true;
        } catch (Exception $e) {
            echo "Error al transferir el ticket: " . $e->getMessage();
            return false;
        }
    }

    public function ObtenerUsuarios($ID_Excluir){
        $sql = "SELECT * FROM usuario WHERE ID_Cargo IN (1, 2) AND ID != :ID_Excluir";
        $stmt = $this->PDO->prepare($sql);
        $stmt->bindParam(':ID_Excluir', $ID_Excluir);
        $stmt->execute();
        $DataUsuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $DataUsuarios;
    }

    public function ObtenerDescripcionTicket($ID_Ticket){
        $sql = "SELECT t.descripcion AS Descripcion, GROUP_CONCAT(dte.Evidencia_Fotografica ORDER BY dte.Evidencia_Fotografica SEPARATOR ', ') AS Evidencias
                FROM detalle_tickets_evidencia dte 
                JOIN tickets t ON t.id = dte.ID_Ticket 
                WHERE t.id = :ID_Ticket AND dte.ID_Detalle_Ticket IS NULL 
                GROUP BY t.id";
        $stmt = $this->PDO->prepare($sql);
        $stmt->bindParam(':ID_Ticket', $ID_Ticket);
        $stmt->execute();
        $DataDescripcion = $stmt->fetch(PDO::FETCH_ASSOC);
        return $DataDescripcion;
    }

    public function ObtenerTicket($ID_Ticket){
        $sql = "SELECT usuario_solicita.NombreCompleto AS NombreUsuario, usuario_gestiona.NombreCompleto AS NombreGestiona,
                       usuario_solicita.Nombre1 AS Nombre1, usuario_gestiona.Nombre1 AS Nombre1,
                       tickets.*,
                       GROUP_CONCAT(dte.Evidencia_Fotografica ORDER BY dte.Evidencia_Fotografica SEPARATOR ', ') AS Evidencias
                FROM 
                    tickets
                LEFT JOIN 
                    usuario AS usuario_solicita ON tickets.ID_Solicitante = usuario_solicita.ID
                LEFT JOIN 
                    usuario AS usuario_gestiona ON tickets.ID_Gestiona = usuario_gestiona.ID
                LEFT JOIN 
                    detalle_tickets_evidencia dte ON tickets.id = dte.ID_Ticket AND dte.ID_Detalle_Ticket IS NULL 
                WHERE 
                    tickets.id = :ID_Ticket GROUP BY tickets.id;";
        $stmt = $this->PDO->prepare($sql);
        $stmt->bindParam(':ID_Ticket', $ID_Ticket);
        $stmt->execute();
        $DataTicket = $stmt->fetch(PDO::FETCH_ASSOC);
        return $DataTicket;
    }

    public function Obtenermensajes($ID_Ticket){
        $sql = "SELECT usuario_envia.Nombre1 AS NombreUsuario,  usuario_recibe.Nombre1 AS NombreUsuario1, detalle_tickets.*, 
                       GROUP_CONCAT(dte.Evidencia_Fotografica ORDER BY dte.Evidencia_Fotografica SEPARATOR ', ') AS Evidencias
                FROM detalle_tickets 
                LEFT JOIN usuario AS usuario_envia ON detalle_tickets.ID_Remitente = usuario_envia.ID 
                LEFT JOIN usuario AS usuario_recibe ON detalle_tickets.ID_Destinatario = usuario_recibe.ID 
                LEFT JOIN detalle_tickets_evidencia dte ON detalle_tickets.ID = dte.ID_Detalle_Ticket 
                WHERE detalle_tickets.ID_Ticket = :ID_Ticket 
                GROUP BY detalle_tickets.ID
                ORDER BY detalle_tickets.Fecha_Enviado DESC, detalle_tickets.Hora";
        $stmt = $this->PDO->prepare($sql);
        $stmt->bindParam(':ID_Ticket', $ID_Ticket);
        $stmt->execute();
        $DataMensajes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $DataMensajes;
    }

    public function ObtenerDatos($ID_Ticket){
        $sql = "SELECT ID_Solicitante, ID_Gestiona FROM tickets  WHERE ID = :ID_Ticket";
        $stmt = $this->PDO->prepare($sql);
        $stmt->bindParam(':ID_Ticket', $ID_Ticket);
        $stmt->execute();
        $DataUsuarios = $stmt->fetch(PDO::FETCH_ASSOC);
        return $DataUsuarios;
    }

    public function ObetenerEstadoEncuesta($ID_Usuario){
        $Estado = 2;
        $sql = "SELECT * FROM tickets  WHERE ID_Solicitante = :ID_Usuario AND Estado = :Estado";
        $stmt = $this->PDO->prepare($sql);
        $stmt->bindParam(':ID_Usuario', $ID_Usuario);
        $stmt->bindParam(':Estado', $Estado);
        $stmt->execute();
        $DataEncuesta = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $DataEncuesta;
    }

    public function ObetenerResultadosEncuesta($ID_Ticket){
        $sql = "SELECT * FROM resultados_encuesta  WHERE ID_Ticket = :ID_Ticket";
        $stmt = $this->PDO->prepare($sql);
        $stmt->bindParam(':ID_Ticket', $ID_Ticket);
        $stmt->execute();
        $DataEncuesta = $stmt->fetch(PDO::FETCH_ASSOC);
        return $DataEncuesta;
    }
    
    public function sendMessage($id_ticket, $id_remitente, $id_destinatario, $mensaje) {
        date_default_timezone_set('America/Bogota');
        $Fecha = date('d/m/Y');
        try {
            // Prepara la consulta
            $stmt = $this->PDO->prepare("INSERT INTO detalle_tickets (ID_Ticket, ID_Remitente, ID_Destinatario, Mensaje, Estado, Fecha_Enviado, Hora) VALUES (?, ?, ?, ?, 1, ?, NOW())");
            
            // Asigna los parámetros
            $stmt->bindParam(1, $id_ticket, PDO::PARAM_INT);
            $stmt->bindParam(2, $id_remitente, PDO::PARAM_INT);
            $stmt->bindParam(3, $id_destinatario, PDO::PARAM_INT);
            $stmt->bindParam(4, $mensaje, PDO::PARAM_STR);
            $stmt->bindParam(5, $Fecha, PDO::PARAM_STR);
            $stmt->execute();
            
            // Recupera el último ID insertado
            $lastId = $this->PDO->lastInsertId();
            return $lastId; 
            
        } catch (Exception $e) {
            echo "Error al registrar el mensaje: " . $e->getMessage();
            return false; 
        }
    }

    public function getMessages($ID_Ticket) {
        $sql = "SELECT usuario_envia.Nombre1 AS NombreUsuario,  usuario_recibe.Nombre1 AS NombreUsuario1, detalle_tickets.*, 
                       GROUP_CONCAT(dte.Evidencia_Fotografica ORDER BY dte.Evidencia_Fotografica SEPARATOR ', ') AS Evidencias
                FROM detalle_tickets 
                LEFT JOIN usuario AS usuario_envia ON detalle_tickets.ID_Remitente = usuario_envia.ID 
                LEFT JOIN usuario AS usuario_recibe ON detalle_tickets.ID_Destinatario = usuario_recibe.ID 
                LEFT JOIN detalle_tickets_evidencia dte ON detalle_tickets.ID = dte.ID_Detalle_Ticket 
                WHERE detalle_tickets.ID_Ticket = :ID_Ticket 
                GROUP BY detalle_tickets.ID
                ORDER BY detalle_tickets.ID ASC"; 

        $stmt = $this->PDO->prepare($sql);
        $stmt->bindParam(':ID_Ticket', $ID_Ticket, PDO::PARAM_INT);
        $stmt->execute();        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
?>
