<?php
require_once "App/Views/Templates/Layouts/Header.php";
include_once "App/Controllers/CentroDeTrabajoController.php";
include_once "App/Controllers/MantenimientosController.php";

$CentrosDeTrabajo = new CentroDeTrabajoController;
$MantenimientosController = new MantenimientosController();
$ListaCentrosDeTrabajo = $CentrosDeTrabajo->TraerCentrosDeTrabajo();

date_default_timezone_set('America/Bogota'); 
$horaFormateada = date("H:i");

$ID_Centro = isset($_GET['centro']) ? $_GET['centro'] : $_SESSION['NoCentro'];
$DataSupervisores = $MantenimientosController->TraerSupervisores();
$Mantenimientos = $MantenimientosController->LeerMantenimientosC($ID_Centro);
$NoMantenimientos = $MantenimientosController->ContarMantenimientosC($ID_Centro);

if ($_SERVER['HTTP_HOST'] == 'localhost') {
    $baseUrl = 'http://localhost/OUTKARGO/';
} else {
    $baseUrl = 'https://outkargo.com.co/';
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['Tipo'] == "MantenimietoPreventivo") {
        $ID_Montacargas = $_POST['ID_Montacargas1'];
        $ID_Area = $_POST['ID_Area1'];
        $ID_Operario = $_POST['ID_Operario1'];
        $ID_Centro = $_POST['ID_Centro2'];
        $ID_Supervisor = $_POST['IDSupervisor'];
        $Correo_Supervisor = $_POST['CorreoSupervisor'];
        $Nombre_Supervisor = $_POST['NombreSupervisor'];
        $Horometro = $_POST['Horometro'];
        $HoraInicio = $_POST['HoraInicio'];
        $Falla = $_POST['DescripcionFalla'];
        $Reparacion = $_POST['ReparacionRealizada'];
        $Insumos = isset($_POST['insumos']) ? $_POST['insumos'] : [];
        $Observaciones = (!empty(trim($_POST['Observaciones']))) ? trim($_POST['Observaciones']) : null;
        $FallaC = isset($_POST['acepta']) ? $_POST['acepta'] : null;

        if ($FallaC === 'si') {
            $FechaCorrecion = NULL;
            $Pendiente = null; 
        } elseif ($FallaC === 'no') {
            $FechaCorrecion = date("d/m/Y");
            $Pendiente = $_POST['Pendiente'];
        } 
               
        // 🔹 Técnicos encargados 
        $Tecnicos = isset($_POST['tecnicoId']) ? $_POST['tecnicoId'] : [];
        // Imagenes Diagnostico
        $ImgFalla = $_FILES['imagenesDiagnosticoDescripcion'];
        $ImgReparacion = $_FILES['imagenesReparacion'];
        $ID_Usuario = $_SESSION['ID'];
        $NombreCreo = $_SESSION['Nombre1'];
        
        if($Resultado = $MantenimientosController->RegistrarMantenimientoCorrectivo($ID_Usuario, $NombreCreo, $ID_Montacargas,$ID_Area,$ID_Operario,$ID_Centro,$ID_Supervisor,$Correo_Supervisor,$Nombre_Supervisor,$Horometro, $HoraInicio,
                                                           $Falla,$Reparacion,$Insumos,$Observaciones,$FechaCorrecion,$FallaC, $Pendiente,$Tecnicos,$ImgFalla,$ImgReparacion)){
            
            $ID_Mantenimiento = $Resultado['ID_Mantenimiento'];
            $ID_Salida = $Resultado['ID_Salida'];            
            echo "
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                Swal.fire({
                    title: 'Mantenimiento Creado!',
                    text: 'El mantenimiento se ha creado exitosamente.',
                    icon: 'success',
                    showCancelButton: true,
                    confirmButtonText: 'Continuar',
                    cancelButtonText: 'Cancelar',
                    allowOutsideClick: false,
                    allowEscapeKey: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'FirmaMantenimientoC?ID={$ID_Mantenimiento}&ID_Salida={$ID_Salida}';
                    }
                });
            </script>";
        } else {
            echo "
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                Swal.fire({
                    title: 'Error!',
                    text: 'El mantenimiento no se pudo crear, por favor intente de nuevo.',
                    icon: 'error',
                    timer: 3000,
                    timerProgressBar: true
                });
            </script>";
        }

    }
    
}
?>

<!-- Tom Select: Librerías CSS y JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.bootstrap5.min.css">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
<style>
    /* Fondo del lightbox */
    .lightbox-bg {
        background: rgba(0, 0, 0, 0.90);
        z-index: 9999;
    }

    /* Imagen del lightbox */
    .lightbox-img {
        max-height: 95vh;
        max-width: 95vw;
        object-fit: contain;
        cursor: default;
    }

    /* Botones de navegación (prev y next) */
    .nav-btn {
        top: 50%;
        transform: translateY(-50%);
        background-color: black !important;
        color: white !important;
        width: 40px;
        height: 40px;
        font-size: 2rem;
        padding: 0;
        border-radius: 50%;

        display: flex;              
        align-items: center;      
        justify-content: center;
    }

    /* Botón cerrar */
    .close-btn {
        background-color: black !important;
        color: white !important;
        width: 40px;
        height: 40px;
        font-size: 1.2rem;
        padding: 0;
        border-radius: 50%;
    }

    .ts-dropdown {
        background-color: white !important;
        border: 1px solid #ced4da !important;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15) !important;
        border-radius: 8px !important;
        margin-top: 4px !important;
    }

    .ts-dropdown .option {
        padding: 10px 12px !important;
        color: #212529 !important;
        border-bottom: 1px solid #eee;
    }

    .ts-dropdown .option:hover,
    .ts-dropdown .option.active {
        background-color: #e3f2fd !important;
        color: #1976d2 !important;
    }

    .ts-control {
        border: none !important;
        border-bottom: 2px solid #adb5bd !important;
        border-radius: 0 !important;
        padding: 8px 0 !important;
        box-shadow: none !important;
    }

    .ts-control .placeholder {
        color: #6c757d !important;
        font-size: 1.1rem;
    }

    /* Adjuntos */
    .adjunto-box {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        background: #f8f9fa;
    }

    .adjunto-nombre {
        font-weight: 600;
    }

    .adjunto-desc {
        font-size: 0.85rem;
        color: #6c757d;
    }

</style>

<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-6 col-xl-3">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <img width="50" height="50" src="https://img.icons8.com/pastel-glyph/50/000020/hand-truck--v2.png" alt="hand-truck--v2"/>
                <div class="ms-3">
                    <p class="mb-2" style="color: #000020;">Correctivos Realizados</p>
                    <h6 class="mb-0" style="color: #000020;"><?= $NoMantenimientos['NoMantenimientos'] ?></h6>
                </div>
            </div>
        </div> 
        <a class="col-sm-6 col-xl-3" data-bs-toggle="modal" data-bs-target="#NumerDocumentoModal" >
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <img width="50" height="50" src="https://img.icons8.com/pastel-glyph/100/000020/hand-truck--v1.png" alt="hand-truck--v2" style="transform: scaleX(-1);" />
                <div class="ms-3">
                    <p class="mb-2" style="color: #000020;">Correctivo</p>
                </div>
            </div>
        </a>
        <a class="col-sm-6 col-xl-3" href="#"></a>
        <a class="col-sm-6 col-xl-3" href="#"></a>
    </div>
</div>

<div class="container-fluid pt-4 px-4">
    <div class="bg-light text-center rounded p-4">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2 mb-4">
            <form method="get" action="" class="mb-0">
                <div class="d-flex align-items-center flex-wrap gap-2">
                    <h6 class="mb-0">Correctivos Realizados |</h6>
                    <select name="centro" 
                            class="form-select form-select-sm w-auto"
                            onchange="this.form.submit()">
                        <?php
                            if (!empty($ListaCentrosDeTrabajo)) {
                                foreach ($ListaCentrosDeTrabajo as $centro) {
                                    $idCentro = $centro['ID'];
                                    $nombreCentro = htmlspecialchars($centro['Nombre']);
                                    $selected = ($idCentro == $ID_Centro) ? 'selected' : '';
                                    echo "<option value=\"$idCentro\" $selected>$nombreCentro</option>";
                                }
                            } else {
                                echo '<option>No hay centros</option>';
                            }
                        ?>
                    </select>
                </div>
            </form>

            <!-- Enlaces de acción -->
            <div class="text-md-end text-center mt-2 mt-md-0">
                <a href="InicioCorrectivoOrden" class="text-decoration-none me-2 text-primary fw-bold">Ver Mantenimiento Orden</a>
                <span class="text-muted">|</span>
                <a href="#" class="text-decoration-none ms-2 text-success fw-bold">Descargar Excel</a>
            </div>
        </div>

        <!-- Tabla -->
        <div class="table-responsive">
            <table class="table text-start align-middle table-bordered table-hover mb-0" id="myTable">
                <thead>
                    <tr class="text-dark">
                        <th scope="col" class="text-center">N°</th>
                        <th scope="col" class="text-center">Serie</th>
                        <th scope="col" class="text-center">Horometro </th>
                        <th scope="col" class="text-center">Operario Reporta</th>
                        <th scope="col" class="text-center">Fecha Realizado</th>
                        <th scope="col" class="text-center">Estado</th>
                        <th scope="col" class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($Mantenimientos) {
                        foreach ($Mantenimientos as $Mantenimiento) {
                            if ($Mantenimiento['Estado_Firma_Supervisor'] === 1) {
                                $progressBarClass = 'bg-success';
                                $estadoTexto = 'Verificado';
                            } else{
                                $progressBarClass = 'bg-warning';
                                $estadoTexto = 'Por Verificar';
                            }

                    ?>
                            <tr data-id="<?= htmlspecialchars($Mantenimiento['ID']) ?>">
                                <td width="100" class="text-center"><?= htmlspecialchars($Mantenimiento['NumeroM']) ?></td>
                                <td><?= htmlspecialchars($Mantenimiento['SerieM']) ?></td>
                                <td><?= htmlspecialchars($Mantenimiento['HorometroM']) ?></td>
                                <td><?= htmlspecialchars($Mantenimiento['NombreUsuario']) ?></td>
                                <td><?= htmlspecialchars($Mantenimiento['Fecha_Realizado']) ?></td>
                                <td>
                                    <div class="progress">
                                        <div id="progressStatus" class="progress-bar <?= $progressBarClass ?>" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                            <?=  $estadoTexto ?>
                                        </div>
                                    </div>
                                </td>
                                <td width="200" class="text-center">
                                    <a class="btn btn-sm btn-primary" target="_blank" href="VerMantenimientoCorrectivo?ID=<?= urlencode(htmlspecialchars($Mantenimiento['ID'])) ?>">
                                        <img width="20" height="20" src="https://img.icons8.com/material-outlined/24/ffffff/visible--v1.png" alt="Ver" />
                                    </a>
                                    <?php if ($Mantenimiento['Estado_Firma_Operario'] != 1) { ?>
                                        <a class="btn btn-sm btn-warning" target="_blank" href="FirmaOperarioC?ID=<?= urlencode(htmlspecialchars($Mantenimiento['ID'])) ?>">
                                            <img width="20" height="20" src="https://img.icons8.com/sf-regular-filled/24/ffffff/autograph.png" alt="autograph"/>
                                        </a>
                                    <?php } ?>
                                    <?php if ( $_SESSION['ID'] == $Mantenimiento['ID_Supervisor'] && $Mantenimiento['Estado_Firma_Supervisor'] != 1) { ?>
                                        <a class="btn btn-sm btn-dark" target="_blank" href="FirmaSupervisorC?ID=<?= urlencode(htmlspecialchars($Mantenimiento['ID'])) ?>">
                                            <img width="20" height="20" src="https://img.icons8.com/sf-regular-filled/24/ffffff/autograph.png" alt="autograph"/>
                                        </a>
                                    <?php } ?>
                                </td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Ingreso de datos -->
<div class="modal fade" id="NumerDocumentoModal" tabindex="-1" aria-labelledby="NumerDocumentoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">                
                <h5 class="modal-title text-white" id="NumerDocumentoModalLabel">Mantenimiento Correctivo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form id="documentFormIngreso" method="POST">
                    <div class="mb-3">
                        <label for="CentroTrabajo">Seleccione el centro de trabajo</label>
                        <select class="form-select" name="ID_Centro1" id="ID_Centro1" aria-label="Seleccione centro de trabajo" onchange="cargarMontacargas()" required>
                            <option value="" disabled selected>Centro de Trabajo</option>
                            <?php
                                if ($ListaCentrosDeTrabajo) {
                                    foreach ($ListaCentrosDeTrabajo as $ListaCentroDeTrabajo) {
                                        echo "<option value='{$ListaCentroDeTrabajo['ID']}'>{$ListaCentroDeTrabajo['Nombre']}</option>";
                                    }
                                }
                            ?>
                        </select>
                        <label for="floatingSelect">Seleccione el numeró de montacargas</label>
                        <select class="form-select" name="ID_Montacargas" id="ID_Montacargas" required>
                            <option value="" disabled selected>Seleccione un montacargas</option>
                        </select>
                        <label for="floatingSelect">Seleccione operario quien reporta</label>
                        <select class="form-select" name="ID_Operario" id="ID_Operario" required>
                            <option value="" disabled selected>Seleccione operario</option>
                        </select>
                        <label for="floatingSelect">Seleccione Sección o Area de trabajo</label>
                        <select class="form-select" name="ID_Area" id="ID_Area" required>
                            <option value="" disabled selected>Seleccione Seccion</option>
                        </select>
                        <input type="hidden" name="Tipo" value="DocumentoPreventivo">
                    </div>
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Ingreso de mantenimientos -->
<div class="modal fade" id="agregarMantenimiento" tabindex="-1" aria-labelledby="agregarMantenimientoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="agregarMantenimientoModalLabel">Mantenimiento Correctivo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="documentFormMantenimiento" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <!-- Informacion Montacaragas -->
                        <div class="col-md-4">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="numeroMontacargas">Montacargas</label>
                                    <input type="text" class="form-control" name="numeroMontacargas" id="numeroMontacargas"  readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="nombreSección">Sección</label>
                                    <input type="text" class="form-control" name="nombreSección" id="nombreSección"  readonly>
                                </div>
                                <div class="col-md-12">
                                    <label for="numeroSerie">Serie</label>
                                    <input type="text" class="form-control" name="numeroSerie" id="numeroSerie" readonly>
                                    <label for="numeroModelo">Modelo</label>
                                    <input type="text" class="form-control" name="numeroModelo" id="numeroModelo" readonly>
                                    <label for="nombreCentro">Centro de Trabajo</label>
                                    <input type="text" class="form-control" name="nombreCentro" id="nombreCentro" readonly>
                                    <label for="nombreOperario">Operario</label>
                                    <input type="text" class="form-control" name="nombreOperario" id="nombreOperario" readonly>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="Voltaje">Voltaje</label>
                                        <input type="text" class="form-control" name="Voltaje" id="Voltaje" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="Horometro">Horometro</label>
                                        <input type="text" class="form-control" name="Horometro" id="Horometro" >
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="HoraIncio">Hora Inicio</label>
                                        <input type="time" class="form-control" name="HoraInicio" id="HoraInicio" value="<?= date('H:i', strtotime($horaFormateada)) ?>">
                                    </div>
                                </div>
                                <!-- Campo de técnicos con botón -->
                                <div class="col-md-12">
                                    <label for="nombreTecnico" >Técnicos Encargados</label>
                                    
                                    <!-- Campo principal -->
                                    <div class="input-group mb-2">
                                    <input type="text" class="form-control" name="nombreTecnico[]" id="nombreTecnico" placeholder="<?= htmlspecialchars($_SESSION['NombreCompleto']) ?>" readonly>
                                    <button class="btn btn-success" type="button" id="btnAgregarTecnico" data-open-modal="#modalAgregarTecnico"> <i class="bi bi-plus-circle"></i></button>
                                    </div>
                                    <!-- Lista de técnicos adicionales -->
                                    <div id="listaTecnicos"></div>
                                </div>
                                <div class="col-md-12">
                                    <label for="Autoriza">Autoriza</label>
                                    <select class="form-select me-2" name="Autoriza" id="Autoriza" onchange="mostrarSupervisor()">
                                        <option value=""></option> 
                                        <?php
                                            if ($DataSupervisores) {
                                                foreach ($DataSupervisores as $Supervisor) {
                                        ?>
                                        <option value="<?= htmlspecialchars($Supervisor['ID'] . '|' . $Supervisor['Correo']) ?>">
                                            <?= htmlspecialchars($Supervisor['NombreCompleto']) ?>
                                        </option>
                                        <?php
                                                }
                                            }                                   
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- Formulario -->
                        <div class="col-md-8"> 
                            <div class="row mb-3">
                                <div class="col-md-5">
                                    <label for="Voltaje">Descripción de la falla:</label>
                                    <textarea class="form-control" id="DescripcionFalla" name="DescripcionFalla" rows="5" placeholder="Descripción de la falla" required></textarea>
                                </div>
                                <div class="col-md-7">
                                    <label class="form-label">Subir Imágenes de la falla</label>
                                    <input class="form-control d-none" type="file" id="imagenesDiagnosticoDescripcion" name="imagenesDiagnosticoDescripcion[]" accept="image/*" multiple>
                                    <div id="previewImagenesDescripcion" class="mt-3 d-flex flex-wrap gap-2"></div>
                                    <div class="d-flex gap-2">
                                        <button type="button" class="btn btn-outline-primary" id="btnTomarFoto1">Tomar Foto</button>
                                        <button type="button" class="btn btn-outline-secondary" id="btnCargarImagen1">Cargar Imágenes</button>
                                    </div>
                                </div>
                            </div>    
                            <div class="row mb-3">
                                <div class="col-md-5">
                                    <label for="Voltaje">Reparación realizada:</label>
                                    <textarea class="form-control" id="ReparacionRealizada" name="ReparacionRealizada" rows="5" placeholder="Reparación realizada" required></textarea>
                                </div>
                                <div class="col-md-7">
                                    <label class="form-label">Subir Imágenes de la reparación</label>
                                    <input class="form-control d-none" type="file" id="imagenesReparacion" name="imagenesReparacion[]" accept="image/*" multiple>
                                    <div id="previewImagenesReparacion" class="mt-3 d-flex flex-wrap gap-2"></div>
                                    <div class="d-flex gap-2">
                                        <button type="button" class="btn btn-outline-primary" id="btnTomarFoto2">Tomar Foto</button>
                                        <button type="button" class="btn btn-outline-secondary" id="btnCargarImagen2">Cargar Imágenes</button>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-3 mb-3">
                                <label for="nombreSolicita">Insumos y Repuestos Instalados:</label>
                                <div class="col-12 col-md-2">
                                    <input type="number" id="cantidad" class="form-control" placeholder="Cantidad" min="1" step="1" >
                                </div>
                                <div class="col-12 col-md-2">
                                    <select id="tipoMedida" name="tipoMedida" class="form-select">
                                        <option value="">medida</option>
                                        <option value="Und">Und</option>
                                        <option value="Gal">Gal</option>
                                        <option value="1/4">1/4</option>
                                        <option value="1/2">1/2</option>
                                        <option value="3/4">3/4</option>
                                        <option value="Kilo">Kilo</option>
                                        <option value="Bulto">Bulto</option> 
                                    </select>
                                </div>
                                <div class="col-12 col-md-5">
                                    <select  id="select-para" class="form-control" placeholder="Escribe nombre o codigo..."></select>
                                </div>
                                <div class="col-12 col-md-1 d-grid">
                                    <button type="button" class="btn btn-success" onclick="agregarFila()">Agregar</button>
                                </div>
                            </div>
                            <!-- Tabla dinámica -->
                            <div class="table-responsive">
                                <table class="table table-bordered" id="tablaSolicitud">
                                    <thead class="table-dark">
                                        <tr>
                                            <th style="width: 40px;">#</th>
                                            <th >Codigo</th>
                                            <th style="width: 50px;">Cantidad</th>
                                            <th style="width: 50px;"></th>
                                            <th>Nombre</th>
                                            <th>Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                            
                                    </tbody>
                                </table>
                            </div>
                            <br>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="FallaCorregida">Falla Corregida</label>
                                    <div>
                                        <input type="radio" id="si" name="acepta" value="si" class="radio-input" checked onclick="actualizarCampos()">
                                        <label for="si" class="radio-label" aria-labelledby="si">
                                            <span class="radio-circle"><span class="radio-dot"></span></span>
                                            <span>Sí</span>
                                        </label>
                                    </div>
                                    <div>
                                        <input type="radio" id="no" name="acepta" value="no" class="radio-input" onclick="actualizarCampos()">
                                        <label for="no" class="radio-label" aria-labelledby="no">
                                            <span class="radio-circle"><span class="radio-dot"></span></span>
                                            <span>No</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="Programar">Programar nuevamente para el dia</label>
                                    <input type="date" class="form-control" name="Programar" id="Programar">
                                </div>
                            </div>  
                            <label for="Pendiente">Pendiente por:</label>
                            <textarea class="form-control" id="Pendiente" name="Pendiente" rows="5" placeholder="Pendiente por"></textarea>      
                            <br>
                            <label for="Observaciones">Observaciones:</label>
                            <textarea class="form-control" id="Observaciones" name="Observaciones" rows="5" placeholder="Observaciones"></textarea>                                   
                        </div>
                    </div>
                    <input type="hidden" name="ID_MecanicoPrincipal" value="<?= $_SESSION['ID'] ?>">
                    <input type="hidden" name="ID_Montacargas1" id="hiddenIDMontacargas">
                    <input type="hidden" name="ID_Area1" id="hiddenIDArea">
                    <input type="hidden" name="ID_Operario1" id="hiddenIDOperario">
                    <input type="hidden" name="ID_Centro2" id="hiddenIDCentro">
                    <input type="hidden" name="IDSupervisor" id="formIDSupervisor">
                    <input type="hidden" name="CorreoSupervisor" id="formCorreoSupervisor">
                    <input type="hidden" name="NombreSupervisor" id="formNombreSupervisor">
                    <input type="hidden" name="Tipo" value="MantenimietoPreventivo">
                    <button type="submit" class="btn btn-primary mt-3">Agregar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para agregar técnico -->
<div class="modal fade" id="modalAgregarTecnico" tabindex="-1" aria-labelledby="modalAgregarTecnicoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #000020;">
                <h5 class="modal-title text-white" id="modalAgregarTecnicoLabel">Agregar Técnico Encargado</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="documentForm" method="POST">
                    <div class="mb-3">
                        <label for="Documento">Número de Identificación</label>
                        <input type="text" class="form-control" id="Documento" placeholder="Ingrese el número de identificación">
                    </div>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="guardarTecnico">Agregar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- LIGHTBOX DE FALLA -->
<div id="lightbox" class="d-none position-fixed top-0 start-0 w-100 h-100 lightbox-bg">

    <div class="d-flex justify-content-center align-items-center h-100 px-3 position-relative">
        <button id="btnPrev" class="btn nav-btn position-absolute start-0"> ‹ </button>
        <img id="lightboxImg" src="" class="img-fluid rounded shadow lightbox-img">
        <button id="btnNext" class="btn nav-btn position-absolute end-0"> › </button>
    </div>

    <!-- Botón cerrar -->
    <button id="close" type="button" class="btn close-btn position-absolute top-0 end-0 m-4"> × </button>
</div>

<!-- LIGHTBOX DE REPARACIÓN -->
<div id="lightbox1" class="d-none position-fixed top-0 start-0 w-100 h-100 lightbox-bg">

    <div class="d-flex justify-content-center align-items-center h-100 px-3 position-relative">
        <button id="btnPrev1" class="btn nav-btn position-absolute start-0"> ‹ </button>
        <img id="lightboxImg1" src="" class="img-fluid rounded shadow lightbox-img">
        <button id="btnNext1" class="btn nav-btn position-absolute end-0"> › </button>
    </div>

    <!-- Botón cerrar -->
    <button id="close1" type="button" class="btn close-btn position-absolute top-0 end-0 m-4"> × </button>
</div>

<!-- Script de Lightbox-->
<script>
document.addEventListener('DOMContentLoaded', () => {
    /*============= FUNCIÓN REUTILIZABLE PARA MANEJO DE GALERÍAS =============*/
    function crearGaleria(config) {
        const {input, preview, btnFoto, btnCargar, lightbox, lightboxImg, btnNext, btnPrev, btnClose} = config;

        let imagenes = [];           
        let dt = new DataTransfer(); 
        let indexActual = 0;

        /* Botón tomar foto */
        btnFoto.addEventListener("click", () => {
            input.removeAttribute('multiple');
            input.setAttribute("capture", "environment");
            input.click();
        });

        /* Botón cargar imágenes */
        btnCargar.addEventListener("click", () => {
            input.setAttribute('multiple', 'true');
            input.removeAttribute("capture");
            input.click();
        });

        /* Renderizar miniaturas */
        function renderMiniaturas() {
            preview.innerHTML = "";

            imagenes.forEach((src, i) => {
                const cont = document.createElement("div");
                cont.className = "position-relative d-inline-block me-2 mb-2";

                const img = document.createElement("img");
                img.src = src;
                img.className = "img-thumbnail";
                img.style.cssText = "height: 110px; cursor: zoom-in; object-fit: cover;";
                img.addEventListener("click", () => {
                    indexActual = i;
                    mostrarImagen();
                });

                /* Botón eliminar */
                const btnEliminar = document.createElement("button");
                btnEliminar.innerHTML = "×";
                btnEliminar.className = "btn close-btn position-absolute top-0 end-0";
                btnEliminar.style.cssText = `
                    border-radius: 50%;
                    width: 20px;
                    height: 20px;
                    padding: 0;
                    font-size: 14px;
                    line-height: 18px;
                `;

                btnEliminar.addEventListener("click", (ev) => {
                    ev.stopPropagation();

                    // ELIMINAR BASE64
                    imagenes.splice(i, 1);

                    // ELIMINAR ARCHIVO REAL
                    dt.items.remove(i);
                    input.files = dt.files;

                    // RECONSTRUIR MINIATURAS
                    renderMiniaturas();
                });

                cont.appendChild(img);
                cont.appendChild(btnEliminar);
                preview.appendChild(cont);
            });
        }

        /* Cargar imágenes */
        input.addEventListener("change", () => {
            Array.from(input.files).forEach(file => {

                dt.items.add(file); 

                const reader = new FileReader();
                reader.onload = e => {
                    imagenes.push(e.target.result);
                    renderMiniaturas();
                };
                reader.readAsDataURL(file);
            });

            input.files = dt.files; 
        });

        /* Función mostrar imagen */
        function mostrarImagen() {
            lightboxImg.src = imagenes[indexActual];
            lightbox.classList.remove("d-none");
            document.body.style.overflow = "hidden";
        }

        /* Navegación Lightbox */
        btnNext.addEventListener("click", (e) => {
            e.stopPropagation();
            indexActual = (indexActual + 1) % imagenes.length;
            mostrarImagen();
        });

        btnPrev.addEventListener("click", (e) => {
            e.stopPropagation();
            indexActual = (indexActual - 1 + imagenes.length) % imagenes.length;
            mostrarImagen();
        });

        btnClose.addEventListener("click", () => {
            lightbox.classList.add("d-none");
            document.body.style.overflow = "";
        });

        lightbox.addEventListener("click", e => {
            if (e.target === lightbox) btnClose.click();
        });

        document.addEventListener("keydown", (e) => {
            if (!lightbox.classList.contains("d-none")) {
                if (e.key === "ArrowRight") btnNext.click();
                if (e.key === "ArrowLeft") btnPrev.click();
                if (e.key === "Escape") btnClose.click();
            }
        });
    }

    /*=============== GALERÍA 1 – FALLA ===============*/
    crearGaleria({
        input: document.getElementById("imagenesDiagnosticoDescripcion"),
        preview: document.getElementById("previewImagenesDescripcion"),
        btnFoto: document.getElementById("btnTomarFoto1"),
        btnCargar: document.getElementById("btnCargarImagen1"),
        lightbox: document.getElementById("lightbox"),
        lightboxImg: document.getElementById("lightboxImg"),
        btnNext: document.getElementById("btnNext"),
        btnPrev: document.getElementById("btnPrev"),
        btnClose: document.getElementById("close")
    });

    /*========== GALERÍA 2 – REPARACIÓN ==========*/
    crearGaleria({
        input: document.getElementById("imagenesReparacion"),
        preview: document.getElementById("previewImagenesReparacion"),
        btnFoto: document.getElementById("btnTomarFoto2"),
        btnCargar: document.getElementById("btnCargarImagen2"),
        lightbox: document.getElementById("lightbox1"),
        lightboxImg: document.getElementById("lightboxImg1"),
        btnNext: document.getElementById("btnNext1"),
        btnPrev: document.getElementById("btnPrev1"),
        btnClose: document.getElementById("close1")
    });

    /*========== RADIO BUTTONS – PENDIENTE / FECHA ==========*/
    const radioSi = document.getElementById('si');
    const radioNo = document.getElementById('no');
    const fecha = document.getElementById('Programar');
    const campoPendiente = document.getElementById('Pendiente');

    function actualizarCampos() {
        if (radioNo.checked) {
            fecha.disabled = false;
            campoPendiente.disabled = false;
            fecha.setAttribute("required", "required");
            campoPendiente.setAttribute("required", "required");
        } else {
            fecha.disabled = true;
            campoPendiente.disabled = true;
            fecha.value = '';
            campoPendiente.value = '';
            fecha.removeAttribute("required");
            campoPendiente.removeAttribute("required");
        }
    }

    radioSi.addEventListener("change", actualizarCampos);
    radioNo.addEventListener("change", actualizarCampos);
    actualizarCampos();

    /*=============== BLOQUEAR FECHAS ANTERIORES ===============*/
    const hoy = new Date().toISOString().split('T')[0];
    fecha.setAttribute('min', hoy);

});
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        new TomSelect('#select-para', {
            plugins: ['remove_button'],
            placeholder: 'Escribe nombre o codigo...',
            maxItems: 1,
            valueField: 'id',
            labelField: 'nombre',
            searchField: ['nombre', 'codigo'],
            closeAfterSelect: true,
            hideSelected: true,
            create: false,

            load: function(query, callback) {
                if (query.length < 2) return callback();
                fetch(`<?= $baseUrl ?>OrdenesTrabajo/BuscarInsumos?q=${encodeURIComponent(query)}`)
                    .then(r => r.json())
                    .then(data => callback(data))
                    .catch(() => callback());
            },

            onItemAdd() {
                this.setTextboxValue('');
                this.refreshOptions(false);
            }
        });
    });
    let contadorFilas = 0;

    function agregarFila() {

        const cantidad = document.getElementById('cantidad').value;
        const medida   = document.getElementById('tipoMedida').value;
        const select   = document.getElementById('select-para');
        const tom      = select.tomselect;

        const idInsumo = tom.getValue();
        const data     = tom.options[idInsumo];

        // Validaciones básicas
        if (!cantidad || cantidad <= 0) {
            alert("Ingrese una cantidad válida");
            return;
        }

        if (!medida) {
            alert("Seleccione una medida");
            return;
        }

        if (!idInsumo) {
            alert("Seleccione un insumo");
            return;
        }

        contadorFilas++;

        const tabla = document.querySelector('#tablaSolicitud tbody');
        const fila  = document.createElement('tr');

        fila.innerHTML = `
            <td>${contadorFilas}</td>
            <td>${data.codigo ?? ''}</td>
            <td>
                ${cantidad} 
                <input type="hidden" name="insumos[${contadorFilas}][id]" value="${idInsumo}">
                <input type="hidden" name="insumos[${contadorFilas}][cantidad]" value="${cantidad}">
                <input type="hidden" name="insumos[${contadorFilas}][medida]" value="${medida}">
            </td>
            <td>${medida}</td>
            <td>${data.nombre ?? ''}</td>
            <td>
                <button type="button" class="btn btn-danger btn-sm" onclick="eliminarFila(this)">X</button>
            </td>
        `;

        tabla.appendChild(fila);

        // Limpiar campos
        document.getElementById('cantidad').value = '';
        document.getElementById('tipoMedida').value = '';
        tom.clear();
    }

    function eliminarFila(boton) {
        const fila = boton.closest('tr');
        fila.remove();
        reordenarFilas();
    }

    function reordenarFilas() {
        const filas = document.querySelectorAll('#tablaSolicitud tbody tr');
        contadorFilas = 0;

        filas.forEach((fila, index) => {
            contadorFilas = index + 1;
            fila.children[0].textContent = contadorFilas;
        });
    }
</script>

<script>
    function cargarMontacargas() {
        const ID_Centro = document.getElementById('ID_Centro1').value;
        console.log('ID_Centro enviado:', ID_Centro);
        if (!ID_Centro) return;
        // Realizamos la solicitud AJAX para obtener los montacargas
        $.get(`TraerMontacargas?ID_Centro=${ID_Centro}`, function(data) {
            try {
                const Montacargas = Array.isArray(data) ? data : JSON.parse(data);

                console.log('Montacargas recibido:', Montacargas);

                // Limpiamos el select
                $('#ID_Montacargas').empty().append('<option value="" disabled selected>Seleccione un montacargas</option>');

                if (Montacargas.length > 0) {
                    Montacargas.forEach(montacarga => {
                        $('#ID_Montacargas').append(
                            `<option value="${montacarga.ID}"data-modelo="${montacarga.Modelo}" data-voltaje="${montacarga.Voltaje}" data-horometro="${montacarga.Horometro}" data-longitudh="${montacarga.Horquillas}">
                            ${montacarga.Numero} - ${montacarga.Serie}</option>`
                        );
                    });
                }
            } catch (error) {
                console.error('Error al procesar los datos de montacargas:', error);
            }
        }).fail(function(xhr, status, error) {
            console.error('Error en la solicitud AJAX:', error);
        });

        // Realizamos la solicitud AJAX para obtener los operarios
        $.get(`TraerOperarios?ID_Centro=${ID_Centro}`, function(data) {
            try {
                const Operarios = Array.isArray(data) ? data : JSON.parse(data);

                console.log('Operarios recibido:', Operarios);

                $('#ID_Operario').empty().append('<option value="" disabled selected>Seleccione un operario</option>');

                if (Operarios.length > 0) {
                    Operarios.forEach(operario => {
                        $('#ID_Operario').append(
                            `<option value="${operario.ID}">${operario.NombreCompleto}</option>`
                        );
                    });
                }
            } catch (error) {
                console.error('Error al procesar los datos de operarios:', error);
            }
        }).fail(function(xhr, status, error) {
            console.error('Error en la solicitud AJAX:', error);
        });

        //Realizamos la solicitud AJAX para obtener las areas o secciones de trabajo
         $.get(`TraerAreas?ID_Centro=${ID_Centro}`, function(data) {
            try {
                const Areas = Array.isArray(data) ? data : JSON.parse(data);
                console.log('Áreas recibidas:', Areas);

                $('#ID_Area').empty().append('<option value="" disabled selected>Seleccione un área</option>');

                if (Areas.length > 0) {
                    Areas.forEach(area => {
                        $('#ID_Area').append(
                            `<option value="${area.ID}">${area.Nombre}</option>`
                        );
                    });
                }
            } catch (error) {
                console.error('Error al procesar los datos de áreas:', error);
            }
        }).fail(function(xhr, status, error) {
            console.error('Error en la solicitud AJAX:', error);
        });
    };
    
    document.addEventListener("DOMContentLoaded", function () {
        // Función para crear un helper de Bootstrap Modal compatible con varias versiones
        const getModalInstance = (el) => {
            if (!el) return null;
            return (bootstrap.Modal.getOrCreateInstance)
                ? bootstrap.Modal.getOrCreateInstance(el)
                : (bootstrap.Modal.getInstance(el) || new bootstrap.Modal(el));
        };


        // PARTE 1: FORMULARIO
        const formIngreso = document.getElementById("documentFormIngreso"); // <-- asegúrate en HTML
        if (formIngreso) {
            formIngreso.addEventListener("submit", function (e) {
                e.preventDefault(); 

                // Obtenemos valores seleccionados (usamos ? para evitar crash)
                const centroSelect = document.getElementById("ID_Centro1");
                const montacargasSelect = document.getElementById("ID_Montacargas");
                const operarioSelect = document.getElementById("ID_Operario");
                const areaSelect = document.getElementById("ID_Area");

                const centroTexto = centroSelect?.options[centroSelect.selectedIndex]?.text || "";
                const montacargasTexto = montacargasSelect?.options[montacargasSelect.selectedIndex]?.text || "";
                const operarioTexto = operarioSelect?.options[operarioSelect.selectedIndex]?.text || "";
                const areaTexto = areaSelect?.options[areaSelect.selectedIndex]?.text || "";

                // Evitar error si no hay valor seleccionado
                const selectedOption = montacargasSelect?.options[montacargasSelect.selectedIndex];

                const numeroMontacargas = selectedOption?.text.split(" - ")[0] || "";
                const numeroSerie = selectedOption?.text.split(" - ")[1] || "";
                const numeroModelo = selectedOption?.dataset.modelo || "";
                const voltaje = selectedOption?.dataset.voltaje || "";
                const horometro = selectedOption?.dataset.horometro || "";
                const longitudh = selectedOption?.dataset.longitudh || "";

                // ✅ Aquí llenamos los campos hidden con los IDs seleccionados
                document.getElementById("hiddenIDMontacargas").value = montacargasSelect?.value || "";
                document.getElementById("hiddenIDArea").value = areaSelect?.value || "";
                document.getElementById("hiddenIDOperario").value = operarioSelect?.value || "";
                document.getElementById("hiddenIDCentro").value = centroSelect?.value || "";

                Swal.fire({
                    title: 'Mantenimiento creado!',
                    text: `El Número de Montacargas es: ${numeroMontacargas || "N/A"}`,
                    icon: 'success',
                    showCancelButton: true,
                    confirmButtonText: 'Continuar',
                    cancelButtonText: 'Cancelar',
                    allowOutsideClick: false,
                    allowEscapeKey: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Rellenar campos en el modal agregarMantenimiento (verificamos existencia)
                        const setVal = (id, v) => { const el = document.getElementById(id); if (el) el.value = v; };
                        setVal("numeroMontacargas", numeroMontacargas);
                        setVal("numeroSerie", numeroSerie);
                        setVal("numeroModelo", numeroModelo); 
                        setVal("Voltaje", voltaje);           
                        setVal("Horometro", horometro);           
                        setVal("nombreCentro", centroTexto);
                        setVal("nombreOperario", operarioTexto);
                        setVal("nombreSección", areaTexto);
                        setVal("LongitudH", longitudh);

                        // Cerrar modal de ingreso y, cuando termine de cerrarse, abrir modal mantenimiento
                        const modalIngresoEl = document.getElementById('NumerDocumentoModal');
                        const modalIngresoInst = getModalInstance(modalIngresoEl);
                        const modalMantEl = document.getElementById('agregarMantenimiento');
                        const modalMantInst = getModalInstance(modalMantEl);

                        if (modalIngresoInst && modalMantInst && modalIngresoEl) {
                            const handler = function () {
                                modalIngresoEl.removeEventListener('hidden.bs.modal', handler);
                                // abrir mantenimiento
                                modalMantInst.show();
                            };
                            modalIngresoEl.addEventListener('hidden.bs.modal', handler);
                            modalIngresoInst.hide();
                        } else {
                            // Fallback: si no existe instancia, abrir mant directamente
                            if (modalMantInst) modalMantInst.show();
                        }
                    }
                });
            });
        } else {
            console.warn("documentFormIngreso no encontrado. Verifica id del form en tu HTML.");
        }

        // PARTE 2: BOTONES data-open-modal
        const modalPrincipalEl = document.getElementById('agregarMantenimiento');
        const modalPrincipalInst = getModalInstance(modalPrincipalEl);

        document.querySelectorAll('[data-open-modal]').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const selector = this.getAttribute('data-open-modal');
                const targetEl = document.querySelector(selector);
                if (!targetEl) return console.warn("target modal no encontrado para selector:", selector);

                const targetInst = getModalInstance(targetEl);
                if (!targetInst) return;

                // Si el modal principal está abierto (clase .show), lo cerramos y esperamos
                const principalIsOpen = modalPrincipalEl && modalPrincipalEl.classList.contains('show');

                if (principalIsOpen && modalPrincipalInst) {
                    const onHidden = function () {
                        modalPrincipalEl.removeEventListener('hidden.bs.modal', onHidden);
                        targetInst.show();

                        // Cuando cierre el secundario, reabrir el principal (una sola vez)
                        const onSecHidden = function () {
                            targetEl.removeEventListener('hidden.bs.modal', onSecHidden);
                            // reabrir principal si existe
                            const mp = getModalInstance(modalPrincipalEl);
                            if (mp) mp.show();
                        };
                        targetEl.addEventListener('hidden.bs.modal', onSecHidden);
                    };
                    modalPrincipalEl.addEventListener('hidden.bs.modal', onHidden);
                    modalPrincipalInst.hide();
                } else {
                    // Si principal no está abierto, abrimos directamente el secundario
                    targetInst.show();
                }
            });
        });
    });
    
    let Tecnicos = [];
    $(document).ready(function() {
        $("#btnAgregarTecnico").click(function() {
            $("#Documento").val("");
            $("#modalAgregarTecnico").modal("show");
        }); 
        
        $("#guardarTecnico").click(function(){
            agregarTecnico();
        });

        $(document).on("click", ".btnQuitarTecnico", function(){
            const id = $(this).siblings("input[type=hidden]").val();
            Tecnicos = Tecnicos.filter(t => t.ID != id);
            $(this).closest(".input-group").remove();
            console.log("Técnicos actuales:", Tecnicos);
        });
    });

    function agregarTecnico() {
        const identificacion = $("#Documento").val().trim();

        if (!identificacion) {
            alert("Por favor, ingrese un número de identificación");
            return;
        }

        $.get(`BuscarTecnico?Documento=${identificacion}`, function(data) {
            try {
                const tecnico = typeof data === "object" ? data : JSON.parse(data);

                if (tecnico && tecnico.ID && tecnico.NombreCompleto) {
                    if (Tecnicos.some(t => t.ID === tecnico.ID)) {
                        alert("Este técnico ya fue agregado");
                        return;
                    }

                    // Agregar al array
                    Tecnicos.push({
                        ID: tecnico.ID,
                        NombreCompleto: tecnico.NombreCompleto
                    });

                    // Mostrar en pantalla
                    $("#listaTecnicos").append(`
                        <div class="input-group mb-2">
                            <input type="hidden" name="tecnicoId[]" value="${tecnico.ID}">
                            <input type="text" class="form-control" value="${tecnico.NombreCompleto}" readonly>
                            <button class="btn btn-danger btnQuitarTecnico" type="button">&times;</button>
                        </div>
                    `);

                    console.log("Técnicos actuales:", Tecnicos);

                    $("#modalAgregarTecnico").modal("hide");
                } else {
                    alert("Técnico no encontrado");
                }
            } catch (error) {
                console.error("Error procesando técnico:", error);
            }
        }).fail(function(xhr, status, error) {
            console.error("Error en AJAX:", error);
        });
    }

    function mostrarSupervisor() {
        var select = document.getElementById("Autoriza");
        var selectedValue = select.value;
            
        if (!selectedValue) {
            document.getElementById("supervisorSeleccionado").innerText = '';
            return;
        }

        var supervisorSeleccionado = select.options[select.selectedIndex].text;
        var parts = selectedValue.split('|');
        var idSupervisor = parts[0];
        var correoSupervisor = parts[1];
        document.getElementById("formIDSupervisor").value = idSupervisor;
        document.getElementById("formCorreoSupervisor").value = correoSupervisor;
        document.getElementById("formNombreSupervisor").value = supervisorSeleccionado;

        document.getElementById("supervisorSeleccionado").innerText = supervisorSeleccionado;
    }

    //Validacion de formulario antes de enviar
    document.addEventListener("DOMContentLoaded", function () {
        const documentFormMantenimiento = document.getElementById("documentFormMantenimiento");
        const inputImagenes = document.getElementById("imagenesDiagnosticoDescripcion");
        const inputImagenes1 = document.getElementById("imagenesReparacion");

        if (documentFormMantenimiento) {
            documentFormMantenimiento.addEventListener("submit", function (e) {
                e.preventDefault(); 

                // Verificar si se seleccionó un supervisor
                var select = document.getElementById("Autoriza");
                if (select.value === "") {
                    alert("Por favor, selecciona un supervisor.");
                    return;
                }
                
                // Verificar si se subio al menos una imagen en cada input
                if (inputImagenes.files.length === 0) {
                    alert('Por favor, cargue al menos una imagen de la falla.');
                    event.preventDefault();
                    return;
                }

                if (inputImagenes1.files.length  === 0) {
                    alert('Por favor, cargue al menos una imagen de la reparación realizada.');
                    event.preventDefault();
                    return;
                }

                // Validar Datos del Formulario de los modales
                const hiddenInputs = documentFormMantenimiento.querySelectorAll("input[type=hidden]");
                let incompletos = [];

                hiddenInputs.forEach(input => {
                    if (!input.value || input.value.trim() === "") {
                        incompletos.push(input.name);
                    }
                });

                if (incompletos.length > 0) {
                    console.warn("⚠️ Faltan datos en:", incompletos);

                    Swal.fire({
                        icon: "warning",
                        title: "Información incompleta",
                        text: "Debes diligenciar todos los campos antes de continuar.",
                        confirmButtonText: "Ok"
                    });
                } else {
                    console.log("✅ Todos los hidden tienen valores, se envía el formulario.");
                    // 👉 Enviar formulario al controlador
                    documentFormMantenimiento.submit();
                }

            });
        } else {
            console.warn("documentFormMantenimiento no encontrado. Verifica id del form en tu HTML.");
        }
    });
</script>
<?php require "App/Views/Templates/Layouts/Footer.php"; ?>
