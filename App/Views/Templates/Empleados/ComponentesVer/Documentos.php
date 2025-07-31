<div class="col-md-4">
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #000020; cursor: pointer; text-align: center;" data-bs-toggle="collapse" data-bs-target="#documentosCollapse" aria-expanded="false" aria-controls="documentosCollapse">
            <div>
                Documentos
            </div>
            <div>
                <a href="#" class="btn btn-sx btn-primary" data-toggle="modal" data-target="#DocumentosModal">
                    <img width="20" height="20" src="https://img.icons8.com/windows/ffffff/32/add--v1.png" alt="add--v1" />
                </a>
            </div>
        </div>
        <div id="documentosCollapse" class="collapse">
            <div class="card-body text-white">
                <ul class="list-unstyled">
                    <li class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                            <div>
                                <h6 class="mb-1" style="color: #000020;">Carnet</h6>
                                <small class="text-muted"><?= date("Y-m-d") ?></small>
                            </div>
                            <div>
                                <a href="Carnet?ID=<?= $ID ?>" class="btn btn-sm btn-primary" target="_blank">
                                    <img width="20" height="20" src="https://img.icons8.com/material-outlined/24/ffffff/visible--v1.png" alt="Ver" />
                                </a>
                            <div>
                        </li>
                    <?php                        
                        if ($DataHojaDeVida) {       
                            foreach($DataHojaDeVida as $HojaDeVida){  
                    ?>
                        <li class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                            <div>
                                <h6 class="mb-1" style="color: #000020;"><?= $HojaDeVida['Nombre'] ?></h6>
                                <small class="text-muted"><?= $HojaDeVida['Fecha_Creado'] ?></small>
                            </div>
                            <div>
                                <a target="_blank" class="btn btn-xs btn-primary" href="../App/Views/Upload/Documents/HojaDeVida/<?= $HojaDeVida['Documento'] ?>">
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
        if ($_POST['Tipo'] == "HojaDeVida") {
            $Documento = $_FILES['Documento'];
            $Educacion = $_POST['nivel_educacion'];
            $Fecha_Creado = date("Y-m-d");
            $HojaDeVidaController->Registrar($Educacion, $Documento, $ID, $Fecha_Creado);
        }
    }
?>
<div class="modal fade" id="DocumentosModal" tabindex="-1" role="dialog" aria-labelledby="DocumentosModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white" id="DocumentosModalLabel">Subir Hoja de vida 10-03</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="educationLevel">Seleccione el documento</label>
                        <select name="nivel_educacion" id="educationLevel" class="form-control">
                            <option value="" disabled selected>Seleccione el documento</option>
                            <option value="HOJA DE VIDA 10-03">HOJA DE VIDA</option>
                            <option value="CONTRATO">CONTRATO</option>
                            <option value="CEDULA">CEDULA</option>
                            <option value="LIBRETA MILITAR">LIBRETA MILITAR</option>
                            <option value="DIPLOMA Y ACTA DE GRADO">DIPLOMA Y ACTA DE GRADO</option>
                            <option value="LICENCIA DE CONDUCCION">LICENCIA DE CONDUCCION</option>
                            <option value="MANUAL DE FUNCIONES">MANUAL DE FUNCIONES</option>
                            <option value="APERTURA DE CUENTA">APERTURA DE CUENTA</option>
                        </select>
                    </div>     
                    <hr>
                    <div class="form-group">
                        <label for="fileInput">Selecciona un archivo PDF</label>
                        <input type="file" class="form-control-file" id="fileInput" name="Documento" accept=".pdf" onchange="previewPDFHojaDeVida(this)">
                    </div>            
                    <input type="hidden" name="Tipo" value="HojaDeVida">
                    <br>
                    <div id="previewPDFHojaDeVida" style="margin-top: 20px;"></div> <!-- Correcto ID -->
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
