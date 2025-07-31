<div class="col-md-4">
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #000020; cursor: pointer; text-align: center;" data-bs-toggle="collapse" data-bs-target="#educacionCollapse" aria-expanded="false" aria-controls="educacionCollapse">
            <div>
                Educación
            </div>
            <div>
                <a href="#" class="btn btn-sx btn-primary" data-toggle="modal" data-target="#EducacionModal">
                    <img width="20" height="20" src="https://img.icons8.com/windows/ffffff/32/add--v1.png" alt="add--v1" />
                </a>
            </div>
        </div>
        <div id="educacionCollapse" class="collapse">
            <div class="card-body text-white">
                <ul class="list-unstyled">
                    <?php
                        if ($DataEducacion) {       
                            foreach($DataEducacion as $Educacion){  
                    ?>
                        <li class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                            <div>
                                <h6 class="mb-1" style="color: #000020;"><?= $Educacion['Nombre'] ?></h6>
                                <small class="text-muted"><?= $Educacion['Fecha_Creado'] ?></small>
                            </div>
                            <div>
                                <a target="_blank" class="btn btn-xs btn-primary" href="../App/Views/Upload/Documents/Educacion/<?= $Educacion['Documento'] ?>">
                                    <img width="20" height="20" src="https://img.icons8.com/material-outlined/50/ffffff/visible--v1.png" alt="Ver" />
                                </a>
                            </div>
                        </li>
                    <?php          
                            }                  
                        }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if ($_POST['Tipo'] == "Educacion") {
            $Educacion = $_POST['nivel_educacion'];
            $Documento = $_FILES['Documento'];
            $Fecha_Creado = date("Y-m-d");
            $EducacionController->Registrar($Educacion, $Documento, $ID, $Fecha_Creado);
        }        
    }
?>
<div class="modal fade" id="EducacionModal" tabindex="-1" role="dialog" aria-labelledby="EducacionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white" id="EducacionModalLabel">Registrar Nivel Educación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="fileInput">Selecciona un archivo PDF</label>
                        <input type="file" class="form-control-file" id="fileInput" name="Documento" accept=".pdf" onchange="previewPDF(this)">
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="educationLevel">Nivel de Educación</label>
                        <select name="nivel_educacion" id="educationLevel" class="form-control">
                            <option value="" disabled selected>Seleccione un nivel educativo</option>
                            <option value="Preescolar">Preescolar</option>
                            <option value="Primaria">Primaria</option>
                            <option value="Bachiller/Academico">Bachiller Académico</option>
                            <option value="Tecnica/Tecnologica">Técnica/Tecnológica</option>
                            <option value="Profesional">Profesional</option>
                            <option value="Especializacion">Especialización</option>
                            <option value="Maestria">Maestría</option>
                            <option value="Doctorado">Doctorado</option>
                        </select>
                    </div>              
                    <input type="hidden" name="Tipo" value="Educacion">
                    <br>
                    <div id="pdfPreview" style="margin-top: 20px;">

                    </div>
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
