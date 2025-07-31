<?php
    class Blog{
        //Atributos
        private $PDO;
        //Construtor
        public function __construct() {
            require_once "Conexion.php";
            $Conexion = new Conexion();
            $this->PDO = $Conexion->Conexion();
        }
        //Métodos
        public function ListarBlog(){
            $Consulta = $this->PDO->prepare("SELECT * FROM blog ORDER BY id DESC ");
            $Consulta->execute();
            return $Consulta->fetchAll(PDO::FETCH_ASSOC);
        }

        public function ObtenerNombrePersona($ID){
            $Consulta = $this->PDO->prepare("SELECT * FROM usuario WHERE id = :ID");
            $Consulta->bindParam(":ID", $ID, PDO::PARAM_INT);
            $Consulta->execute();
            return $Consulta->fetch(PDO::FETCH_ASSOC);
        }

        public function SubirBlog($ID_Usuario, $Titulo, $NombreFoto, $Tema, $Contenido, $Fecha_Creacion, $Estado){
            $Consulta = $this->PDO->prepare("
                INSERT INTO blog (ID_Usuario, Titulo, Tema, Imagen_Portada, Contenido, Fecha_Creacion, Estado)
                VALUES (:ID_Usuario, :Titulo, :Tema, :Imagen, :Contenido, :Fecha_Creacion, :Estado)
            ");
            $Consulta->bindParam(":ID_Usuario", $ID_Usuario);
            $Consulta->bindParam(":Titulo", $Titulo);
            $Consulta->bindParam(":Tema", $Tema);
            $Consulta->bindParam(":Imagen", $NombreFoto);
            $Consulta->bindParam(":Contenido", $Contenido);
            $Consulta->bindParam(":Fecha_Creacion", $Fecha_Creacion);
            $Consulta->bindParam(":Estado", $Estado);
            return $Consulta->execute();
        }
        
    }
?>