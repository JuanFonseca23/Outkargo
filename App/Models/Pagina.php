<?php
    class Pagina{
        //Atributos
        private $PDO;
        //Construtor
        public function __construct() {
            require_once "Conexion.php";
            $Conexion = new Conexion();
            $this->PDO = $Conexion->Conexion();
        }
        //Métodos
        public function ListarBlog($Cantidad){
            $Consulta = $this->PDO->prepare("SELECT * FROM blog ORDER BY id DESC LIMIT :Cantidad");
            $Consulta->bindParam(":Cantidad", $Cantidad, PDO::PARAM_INT);
            $Consulta->execute();
            return $Consulta->fetchAll(PDO::FETCH_ASSOC);
        }

        public function ObtenerNombrePersona($ID){
            $Consulta = $this->PDO->prepare("SELECT * FROM usuario WHERE id = :ID");
            $Consulta->bindParam(":ID", $ID, PDO::PARAM_INT);
            $Consulta->execute();
            return $Consulta->fetch(PDO::FETCH_ASSOC);
        }

        public function TraerInformacionBlog($ID){
            $Consulta = $this->PDO->prepare("SELECT * FROM blog WHERE id = :ID");
            $Consulta->bindParam(":ID", $ID, PDO::PARAM_INT);
            $Consulta->execute();
            return $Consulta->fetch(PDO::FETCH_ASSOC);
        }

        public function CrearComentario($ID_Blog, $Tipo_Comentario, $Nombre, $Correo, $Comentario, $Fecha, $Estado){
            $Consulta = $this->PDO->prepare("INSERT INTO comentarios_blog (ID_Blog, Tipo_Comentario, Nombre, Correo, Comentario, Fecha_Creado, Estado) VALUES (:ID_Blog, :Tipo_Comentario, :Nombre, :Correo, :Comentario, :Fecha, :Estado)");
            $Consulta->bindParam(":ID_Blog", $ID_Blog);
            $Consulta->bindParam(":Tipo_Comentario", $Tipo_Comentario);
            $Consulta->bindParam(":Nombre", $Nombre);
            $Consulta->bindParam(":Correo", $Correo);
            $Consulta->bindParam(":Comentario", $Comentario);
            $Consulta->bindParam(":Fecha", $Fecha);
            $Consulta->bindParam(":Estado", $Estado);
            return $Consulta->execute();
        }
    }
?>