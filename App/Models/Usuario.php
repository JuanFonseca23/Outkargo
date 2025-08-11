<?php
    class Usuario {
        // Atributos
        private $PDO;
        // Constructor
        public function __construct() {
            require_once "Conexion.php";
            $Conexion = new Conexion();
            $this->PDO = $Conexion->Conexion();
        }
        // Métodos
        public function VerificarCredenciales($Documento, $Clave) {
            try {
                $sql = "SELECT centrot.Nombre AS Nombre_Centro, cargos.Cargo AS Nombre_Cargo, usuario.* FROM usuario 
                        JOIN cargos ON usuario.ID_Cargo = cargos.ID JOIN centrot ON usuario.ID_Centro = centrot.ID WHERE usuario.Documento = :documento";
                $stmt = $this->PDO->prepare($sql);
                $stmt->bindParam(':documento', $Documento);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
                    $hash = $usuario['Clave'];
                    if (password_verify($Clave, $hash)) {                        
                        session_start();
                        $_SESSION['ID'] = $usuario['ID'];
                        $_SESSION['NombreCompleto'] = $usuario['NombreCompleto'];
                        $_SESSION['Nombres'] = $usuario['Nombre1']." ".$usuario['Nombre2'];
                        $_SESSION['Apellidos'] = $usuario['Apellido1']." ".$usuario['Apellido2'];
                        $_SESSION['Foto'] = $usuario['Foto'];
                        $_SESSION['Cargo'] = $usuario['Nombre_Cargo'];
                        $_SESSION['Documento'] = $usuario['Documento'];
                        $_SESSION['Telefono'] = $usuario['Telefono'];
                        $_SESSION['Correo'] = $usuario['Correo'];
                        $_SESSION['NoCargo'] = $usuario['Cargo'];
                        $_SESSION['Nombre1'] = $usuario['Nombre1'];
                        $_SESSION['NoCentro'] = $usuario['ID_Centro'];
                        $_SESSION['Centro'] = $usuario['Nombre_Centro'];
                        $_SESSION['IdCargo'] = $usuario['ID_Cargo'];
                        return $usuario;
                    }else {
                        return false;
                    }
                }                
                return false;
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
                return false;
            }
        }

        public function Leer(){
            $Estado = 1;
            $sql = "SELECT cargos.Cargo AS Nombre_Cargo, centrot.Nombre AS Nombre_Centro, usuario.* FROM usuario JOIN centrot ON usuario.ID_Centro = centrot.ID JOIN cargos ON usuario.ID_Cargo = cargos.ID  WHERE usuario.Estado = :Estado";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':Estado', $Estado);
            $stmt->execute();
            $DataUsuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $DataUsuarios;
        }
        
        public function LeerHuella($Huella){
            $Estado = 1;
            $sql = "SELECT * FROM usuario WHERE ID_Huella = :Estado";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':Estado', $Huella);
            $stmt->execute();
            $DataUsuarios = $stmt->fetch(PDO::FETCH_ASSOC);
            return $DataUsuarios;
        }

        public function Informe(){
            $Estado = 1;
            $sql= "SELECT cargos.Cargo AS Nombre_Cargo, centrot.Nombre AS Nombre_Centro, usuario.ID, usuario.Tipo_Documento, Usuario.Documento, usuario.Apellido1, usuario.Apellido2, usuario.Nombre1, usuario.Nombre2, usuario.NombreCompleto, TIMESTAMPDIFF(YEAR, STR_TO_DATE(usuario.Fecha_Nacimiento, '%Y-%m-%d'), CURDATE()) AS Edad,  usuario.Telefono, usuario.Correo, usuario.Foto FROM usuario JOIN centrot ON usuario.ID_Centro = centrot.ID JOIN cargos ON usuario.ID_Cargo = cargos.ID WHERE usuario.Estado = :Estado";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':Estado', $Estado);
            $stmt->execute();
            $DataUsuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $DataUsuarios;
        }

        public function InformeInactivos(){
            $Estado = 0;
            $sql= "SELECT cargos.Cargo AS Nombre_Cargo, centrot.Nombre AS Nombre_Centro, usuario.ID, usuario.Tipo_Documento, Usuario.Documento, usuario.Apellido1, usuario.Apellido2, usuario.Nombre1, usuario.Nombre2, usuario.NombreCompleto, TIMESTAMPDIFF(YEAR, STR_TO_DATE(usuario.Fecha_Nacimiento, '%Y-%m-%d'), CURDATE()) AS Edad,  usuario.Telefono, usuario.Correo, usuario.Foto FROM usuario JOIN centrot ON usuario.ID_Centro = centrot.ID JOIN cargos ON usuario.ID_Cargo = cargos.ID WHERE usuario.Estado = :Estado";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':Estado', $Estado);
            $stmt->execute();
            $DataUsuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $DataUsuarios;
        }

        public function ContarUsuariosActivos(){
            $Estado = 1;
            $sql = "SELECT Count(*) as NoUsuarios FROM usuario WHERE Estado = :Estado";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':Estado', $Estado);
            $stmt->execute();
            $DataUsuarios = $stmt->fetch(PDO::FETCH_ASSOC);
            return $DataUsuarios;
        }

        public function RegistrarUsuario($ID_Centro, $ID_Cargo, $Tipo_Documento, $Documento, $ClaveEncriptada, $Nombre1, $Nombre2, $Apellido1, $Apellido2, $NombreCompleto, $NombreFoto, $Telefono, $Correo, $Direccion, $Estado, $No_Carnet, $Fecha_Creado, $Fecha_Nacimiento, $RH, $EPS, $AFP, $ARL, $Sexo, $Municipio, $Area, $Turno) {
            $sql = "INSERT INTO usuario (ID_Centro, ID_Cargo, Tipo_Documento, Documento, Clave, Nombre1, Nombre2, Apellido1, Apellido2, NombreCompleto, Foto, Telefono, Correo, Direccion, Estado, No_Carnet, Fecha_Creado, Fecha_Nacimiento, RH, EPS, AFP, ARL, Sexo, Municipio, Area, Turno) VALUES (:ID_Centro, :ID_Cargo, :Tipo_Documento, :Documento, :ClaveEncriptada, :Nombre1, :Nombre2, :Apellido1, :Apellido2, :NombreCompleto, :NombreFoto, :Telefono, :Correo, :Direccion, :Estado, :No_Carnet, :Fecha_Creado, :Fecha_Nacimiento, :RH, :EPS, :AFP, :ARL, :Sexo, :Municipio, :Area, :Turno)";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID_Centro', $ID_Centro);
            $stmt->bindParam(':ID_Cargo', $ID_Cargo);
            $stmt->bindParam(':Tipo_Documento', $Tipo_Documento);
            $stmt->bindParam(':Documento', $Documento);
            $stmt->bindParam(':ClaveEncriptada', $ClaveEncriptada);
            $stmt->bindParam(':Nombre1', $Nombre1);
            $stmt->bindParam(':Nombre2', $Nombre2);
            $stmt->bindParam(':Apellido1', $Apellido1);
            $stmt->bindParam(':Apellido2', $Apellido2);
            $stmt->bindParam(':NombreCompleto', $NombreCompleto);
            $stmt->bindParam(':NombreFoto', $NombreFoto);
            $stmt->bindParam(':Telefono', $Telefono);
            $stmt->bindParam(':Correo', $Correo);
            $stmt->bindParam(':Direccion', $Direccion);
            $stmt->bindParam(':Estado', $Estado);
            $stmt->bindParam(':No_Carnet', $No_Carnet);
            $stmt->bindParam(':Fecha_Creado', $Fecha_Creado);
            $stmt->bindParam(':Fecha_Nacimiento', $Fecha_Nacimiento);
            $stmt->bindParam(':RH', $RH);
            $stmt->bindParam(':EPS', $EPS);
            $stmt->bindParam(':AFP', $AFP);
            $stmt->bindParam(':ARL', $ARL);
            $stmt->bindParam(':Sexo', $Sexo);
            $stmt->bindParam(':Municipio', $Municipio);
            $stmt->bindParam(':Area', $Area);
            $stmt->bindParam(':Turno', $Turno);
            $stmt->execute();
            return $this->PDO->lastInsertId();
        }
        
        public function ActivacionCuenta($Estado, $ID_Usuario){
            $sql = "UPDATE usuario SET Estado = :Estado WHERE ID = :ID_Usuario";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':Estado', $Estado);
            $stmt->bindParam(':ID_Usuario', $ID_Usuario);
            return $stmt->execute(); 
        }

        public function DesactivarUsuario($ID_Usuario) {
            $Fecha= date('Y-m-d');
            $Estado = 0;
            $sql = "UPDATE usuario SET Estado = :Estado, Fecha_Eliminado = :Fecha WHERE ID = :ID_Usuario";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID_Usuario', $ID_Usuario);
            $stmt->bindParam(':Fecha', $Fecha);
            $stmt->bindParam(':Estado', $Estado);
            return $stmt->execute();
        }

        public function Mostrar($ID){
            $sql = "SELECT cargos.Cargo AS Nombre_Cargo, centrot.Nombre AS Nombre_Centro, usuario.* FROM usuario JOIN centrot ON usuario.ID_Centro = centrot.ID JOIN cargos ON usuario.ID_Cargo = cargos.ID  WHERE usuario.ID = :ID";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID', $ID);
            $stmt->execute();
            $DataUsuarios = $stmt->fetch(PDO::FETCH_ASSOC);
            return $DataUsuarios;
        }

        public function Editar($ID, $ID_Centro, $ID_Cargo, $Tipo_Documento, $Documento, $Nombre1, $Nombre2, $Apellido1, $Apellido2, $NombreCompleto, $NombreFoto, $Telefono, $Correo, $Direccion, $No_Carnet, $Fecha_Nacimiento, $Fecha_Editado, $RH, $EPS, $AFP, $ARL, $Sexo, $Municipio, $Area, $Turno) {
            $sql = "UPDATE usuario SET ID_Centro = :ID_Centro, ID_Cargo = :ID_Cargo, Tipo_Documento = :Tipo_Documento, Documento = :Documento, Nombre1 = :Nombre1, Nombre2 = :Nombre2, Apellido1 = :Apellido1, Apellido2 = :Apellido2, NombreCompleto = :NombreCompleto, Foto = :NombreFoto, Telefono = :Telefono, Correo = :Correo, Direccion = :Direccion, No_Carnet = :No_Carnet, Fecha_Nacimiento = :Fecha_Nacimiento, Fecha_Editado = :Fecha_Editado, RH = :RH, EPS = :EPS, AFP = :AFP, ARL = :ARL, Sexo = :Sexo, Municipio = :Municipio, Area = :Area, Turno = :Turno WHERE ID = :ID";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID_Centro', $ID_Centro);
            $stmt->bindParam(':ID_Cargo', $ID_Cargo);
            $stmt->bindParam(':Tipo_Documento', $Tipo_Documento);
            $stmt->bindParam(':Documento', $Documento);
            $stmt->bindParam(':Nombre1', $Nombre1);
            $stmt->bindParam(':Nombre2', $Nombre2);
            $stmt->bindParam(':Apellido1', $Apellido1);
            $stmt->bindParam(':Apellido2', $Apellido2);
            $stmt->bindParam(':NombreCompleto', $NombreCompleto);
            $stmt->bindParam(':NombreFoto', $NombreFoto);
            $stmt->bindParam(':Telefono', $Telefono);
            $stmt->bindParam(':Correo', $Correo);
            $stmt->bindParam(':Direccion', $Direccion);
            $stmt->bindParam(':No_Carnet', $No_Carnet);
            $stmt->bindParam(':Fecha_Nacimiento', $Fecha_Nacimiento);
            $stmt->bindParam(':Fecha_Editado', $Fecha_Editado);
            $stmt->bindParam(':RH', $RH);
            $stmt->bindParam(':EPS', $EPS);
            $stmt->bindParam(':AFP', $AFP);
            $stmt->bindParam(':ARL', $ARL);
            $stmt->bindParam(':Sexo', $Sexo);
            $stmt->bindParam(':Municipio', $Municipio);
            $stmt->bindParam(':Area', $Area);
            $stmt->bindParam(':Turno', $Turno);
            $stmt->bindParam(':ID', $ID);
            return $stmt->execute();
        }        

        public function EditarC($ID, $RH, $EPS, $ARL){
            $sql = 'UPDATE usuario Set RH = :RH, EPS = :EPS, ARL = :ARL WHERE ID = :ID';
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':RH', $RH);
            $stmt->bindParam(':EPS', $EPS);
            $stmt->bindParam(':ARL', $ARL);
            $stmt->bindParam(':ID', $ID);  
            return $stmt->execute();
        }

        public function LeerE(){
            $Estado = 0;
            $sql = "SELECT cargos.Cargo AS Nombre_Cargo, centrot.Nombre AS Nombre_Centro, usuario.* FROM usuario JOIN centrot ON usuario.ID_Centro = centrot.ID JOIN cargos ON usuario.ID_Cargo = cargos.ID  WHERE usuario.Estado = :Estado";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':Estado', $Estado);
            $stmt->execute();
            $DataUsuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $DataUsuarios;
        }

        public function ContarUsuariosInactivos(){
            $Estado = 0;
            $sql = "SELECT Count(*) as NoUsuarios FROM usuario WHERE Estado = :Estado";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':Estado', $Estado);
            $stmt->execute();
            $DataUsuarios = $stmt->fetch(PDO::FETCH_ASSOC);
            return $DataUsuarios;
        }

        public function ActivarUsuario($ID_Usuario) {
            $Fecha= date('Y-m-d');
            $Estado = 1;
            $sql = "UPDATE usuario SET Estado = :Estado, Fecha_Editado = :Fecha WHERE ID = :ID_Usuario";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':ID_Usuario', $ID_Usuario);
            $stmt->bindParam(':Fecha', $Fecha);
            $stmt->bindParam(':Estado', $Estado);
            return $stmt->execute();
        }

        public function obtenerSupervisor() {
            $sql = "SELECT * FROM usuario WHERE ID_Cargo = 11 ";
            $stmt = $this->PDO->prepare($sql);
            $stmt->execute();
            $DataSupervisores =  $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $DataSupervisores;
        }

        public function obtenerSistemas() {
            $sql = "SELECT Correo FROM usuario WHERE ID_Cargo = 1";
            $stmt = $this->PDO->prepare($sql);
            $stmt->execute();
            $DataSistemas=  $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $DataSistemas;
        }

        public function BuscarPersonaDocumento($No_Documento){
            $sql = "SELECT cargos.Cargo AS Nombre_Cargo, centrot.Nombre AS Nombre_Centro, usuario.* FROM usuario JOIN centrot ON usuario.ID_Centro = centrot.ID JOIN cargos ON usuario.ID_Cargo = cargos.ID  WHERE usuario.Documento = :Documento";
            $stmt = $this->PDO->prepare($sql);
            $stmt->bindParam(':Documento', $No_Documento);
            $stmt->execute();
            $DataUsuarios = $stmt->fetch(PDO::FETCH_ASSOC);
            return $DataUsuarios;
        }
    }
?>
