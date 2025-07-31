<?php
include_once "App/Controllers/DotacionController.php";
include_once "App/Controllers/TicketsController.php";
require_once "App/Views/Templates/Layouts/Header.php";

if (empty($_SESSION['ID'])) {
    header("location:../IniciarSesion");
    exit;
}
$TicketsController = new TicketsController;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ID_Ticket = $_GET['ID'];
    $ID_Evalua = $_SESSION['ID'];
    $Nombre1 = $_SESSION['Nombre1'];
    $ID_Evaluado = $_GET['ID_Gestiona'];
    $Respuesta_1 = $_POST['atencion'];
    $Comentario_Respuesta_1 = !empty($_POST['comentariosatencion']) ? $_POST['comentariosatencion'] : Null;
    $Comentario = !empty($_POST['comentarios']) ? $_POST['comentarios'] : Null;
    $TicketsController->RegistrarEncuesta($ID_Ticket, $ID_Evalua, $ID_Evaluado, $Respuesta_1, $Comentario_Respuesta_1, $Comentario, $Nombre1);
}
?>

<style>
    .radio-option {
        margin-left: 15px; 
    }
</style>

<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-12 col-xl-12">
            <h5 class="mb-4">Encuesta de satisfacción de servicio</h5>

            <form method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="satisfaccion" class="form-label">¿Cómo calificarías la atención prestada? (1 es muy malo, 5 es excelente)</label>
                    <div>
                        <input type="radio" id="atencionChoice1" name="atencion" value="1" class="radio-option" onchange="toggleComentarioVisibility('atencion')" required/>
                        <label for="atencionChoice1">1 - Malo</label>

                        <input type="radio" id="atencionChoice2" name="atencion" value="2" class="radio-option" onchange="toggleComentarioVisibility('atencion')" required/>
                        <label for="atencionChoice2">2</label>

                        <input type="radio" id="atencionChoice3" name="atencion" value="3" class="radio-option" onchange="toggleComentarioVisibility('atencion')" required/>
                        <label for="atencionChoice3">3</label>

                        <input type="radio" id="atencionChoice4" name="atencion" value="4" class="radio-option" onchange="toggleComentarioVisibility('atencion')" required/>
                        <label for="atencionChoice4">4</label>

                        <input type="radio" id="atencionChoice5" name="atencion" value="5" class="radio-option" onchange="toggleComentarioVisibility('atencion')" required/>
                        <label for="atencionChoice5">5 - Excelente</label>
                    </div>
                    <div class="mb-3" id="comentariosAtencionDiv" style="display:none;">
                        <label for="comentariosatencion" class="form-label">En caso de que su respuesta sea 3 o inferior, por favor, explíquenos el motivo</label>
                        <textarea id="comentariosatencion" name="comentariosatencion" class="form-control" rows="2" placeholder="Escribe aquí tus comentarios"></textarea>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="comentarios" class="form-label">Comentarios</label>
                    <textarea id="comentarios" name="comentarios" class="form-control" rows="4" placeholder="Escribe aquí tus comentarios"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Enviar Encuesta</button>
            </form>
        </div>
    </div>
</div>

<script>
    function toggleComentarioVisibility(type) {
        comentarioDiv = document.getElementById("comentariosAtencionDiv");
        comentarioField = document.getElementById("comentariosatencion");

        const seleccion = document.querySelector(`input[name="${type}"]:checked`);
        if (seleccion && parseInt(seleccion.value) <= 3) {
            comentarioDiv.style.display = "block"; 
            comentarioField.setAttribute("true"); 
        } else {
            comentarioDiv.style.display = "none"; 
            comentarioField.removeAttribute("required"); 
        }
    }
</script>

<?php require "App/Views/Templates/Layouts/Footer.php"; ?>
