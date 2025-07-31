<?php
include_once 'App/Models/Blog.php';
class BlogController
{
    // Atributos
    private $Modelo_Blog;
    //Conatructor
    public function __construct() {
        $this->Modelo_Blog = new Blog();
    }
    // Métodos
    public function ListarBlog(){
        $Cantidad = 5;
        $DataBlog = $this->Modelo_Blog->ListarBlog($Cantidad);
        if ($DataBlog) {
            return $DataBlog;
        } else {
            return false;
        }
    }

    public function LimitarContenido($Texto, $Limite = 50){
        if (strlen($Texto) > $Limite) {
            return substr($Texto, 0, $Limite) . "...";
        } else {
            return $Texto;
        }
    }

    public function ObtenerNombrePersona($ID){
        $DataPersona = $this->Modelo_Blog->ObtenerNombrePersona($ID);
        if ($DataPersona) {
            $NombrePersona = $DataPersona['Nombre1'] . " " . $DataPersona['Apellido1'];
            return$NombrePersona;
        } else {
            return false;
        }
    }

    public function CrearBlog($ID_Usuario, $Titulo, $Foto, $Tema, $Contenido, $Fecha_Creacion, $Estado){
        $Foto = $_FILES['Imagen_Portada'];
    $nuevoCodigo = uniqid(); // Generar nombre único
    $uploadDir = 'App/Views/Upload/Img/Blog/';
    $NombreFoto = $nuevoCodigo . '.png';
    $uploadFile = $uploadDir . $NombreFoto;

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    if (isset($Foto) && $Foto['error'] == UPLOAD_ERR_OK) {
        $fileTmpPath = $Foto['tmp_name'];
        $fileName = $Foto['name'];
        $fileType = $Foto['type'];
        $allowedTypes = ['image/png', 'image/jpeg', 'image/gif'];

        if (in_array($fileType, $allowedTypes)) {
            move_uploaded_file($fileTmpPath, $uploadFile);
        } else {
            echo "
            <script>
                Swal.fire({
                    title: 'Error!',
                    text: 'Tipo de archivo no permitido. Solo se aceptan imágenes PNG, JPEG o GIF.',
                    icon: 'error',
                    timer: 3000,
                    timerProgressBar: true
                });
                window.history.back();
            </script>";
            exit;
        }
    }
        $DataBlog = $this->Modelo_Blog->SubirBlog($ID_Usuario, $Titulo, $NombreFoto, $Tema, $Contenido, $Fecha_Creacion, $Estado);
        if ($DataBlog) {
            return true;
        } else {
            return false;
        }
    }

    
}
