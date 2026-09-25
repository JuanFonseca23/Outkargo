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
$Tipo = 
$Mantenimientos = $MantenimientosController->LeerMantenimientos($ID_Centro);
$NoMantenimientos = $MantenimientosController->ContarMantenimientos($ID_Centro);
?>
<style>
    .select-Conforme {
        background-color: #d4edda !important;
        /* verde claro */
    }

    .select-Nivelacion {
        background-color: #fff3cd !important;
        /* amarillo claro */
    }

    .select-Ajuste {
        background-color: #ffe5b4 !important;
        /* naranja claro */
    }

    .select-Lubricacion {
        background-color: #cce5ff !important;
        /* azul claro */
    }

    .select-NoAplica {
        background-color: #e2e3e5 !important;
        /* gris claro */
    }

    .select-Reparar {
        background-color: #f8d7da !important;
        /* rojo claro */
    }

    .select-vacio {
        background-color: #f8d7da !important;
        /* rojo claro */
    }

    .bg-validado {
        background-color: #d4edda !important;
        /* Verde claro */
    }

    .is-invalid {
        border: 2px solid red !important;
    }

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

    #ModalTrabajos table {
        table-layout: fixed;
        width: 100%;
    }

    #ModalTrabajos td {
        word-wrap: break-word;
        word-break: break-word;
        white-space: normal;
    }

    /* Columna Descripción */
    #ModalTrabajos td.descripcion {
        max-width: 350px;   /* ajusta según lo necesites */
    }
</style>
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-6 col-xl-3">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <img width="50" height="50" src="https://img.icons8.com/ink/50/000020/purchase-order.png" alt="purchase-order"/>
                <div class="ms-3">
                    <p class="mb-2" style="color: #000020;">Preventivos Realizados</p>
                    <h6 class="mb-0" style="color: #000020;"><?= $NoMantenimientos['NoMantenimientos'] ?></h6>
                </div>
            </div>
        </div>
        <a class="col-sm-6 col-xl-3" data-bs-toggle="modal" data-bs-target="#NumerDocumentoModal">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <img width="50" height="50" src="https://img.icons8.com/ink/50/000020/purchase-order.png" alt="purchase-order"/>
                <div class="ms-3">
                    <p class="mb-2" style="color: #000020;">Realizar Mantenimiento Preventivo</p>
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
                    <h6 class="mb-0">Preventivos Realizados |</h6>
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
                <a href="#" class="text-decoration-none me-2 text-primary fw-bold">Ver Todas</a>
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
                        <th scope="col" class="text-center">Horometro Actual</th>
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
                            $HorometroA = $Mantenimiento['HorometroA']; 
                            $HorometroM = $Mantenimiento['HorometroM']; 
                            $diferencia = $HorometroA - $HorometroM;
                            if ($diferencia >= 250) {
                                $progressBarClass = 'bg-danger';
                                $estadoTexto = 'Vencido';
                            } elseif ($diferencia >= 200 && $diferencia < 250) {
                                $progressBarClass = 'bg-warning';
                                $estadoTexto = 'Mantenimiento';
                            }else{
                                $progressBarClass = 'bg-success';
                                $estadoTexto = 'Valido';
                            }

                    ?>
                            <tr data-id="<?= htmlspecialchars($Mantenimiento['ID']) ?>">
                                <td width="100" class="text-center"><?= htmlspecialchars($Mantenimiento['NumeroM']) ?></td>
                                <td><?= htmlspecialchars($Mantenimiento['SerieM']) ?></td>
                                <td><?= htmlspecialchars($Mantenimiento['HorometroM']) ?></td>
                                <td><?= htmlspecialchars($Mantenimiento['HorometroA']) ?></td>
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
                                    <a class="btn btn-sm btn-primary" target="_blank" href="VerMantenimientoPasillo?ID=<?= urlencode(htmlspecialchars($Mantenimiento['ID'])) ?>">
                                        <img width="20" height="20" src="https://img.icons8.com/material-outlined/24/ffffff/visible--v1.png" alt="Ver" />
                                    </a>
                                    <?php if ($Mantenimiento['Estado_Firma_Operario'] != 1) { ?>
                                        <a class="btn btn-sm btn-warning" target="_blank" href="FirmaOperario?ID=<?= urlencode(htmlspecialchars($Mantenimiento['ID'])) ?>">
                                            <img width="20" height="20" src="https://img.icons8.com/sf-regular-filled/24/ffffff/autograph.png" alt="autograph"/>
                                        </a>
                                    <?php } ?>
                                    <?php if ( $_SESSION['ID'] == $Mantenimiento['ID_Supervisor'] && $Mantenimiento['Estado_Firma_Supervisor'] != 1) { ?>
                                        <a class="btn btn-sm btn-dark" target="_blank" href="FirmaSupervisor?ID=<?= urlencode(htmlspecialchars($Mantenimiento['ID'])) ?>">
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
                <h5 class="modal-title text-white" id="NumerDocumentoModalLabel">Mantenimiento Preventivo</h5>
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
                        <label for="CentroTrabajo">Seleccione tipo de montacargas</label>
                        <select class="form-select" aria-label="Seleccione centro de trabajo" id="tipoMontacargas" name="tipoMontacargas" required>
                            <option value="" disabled selected>Tipo</option>
                            <option value="combustion">Combustion</option>
                            <option value="contrabalanceada">Eletrico Contrabalanceada</option>
                            <option value="pasillo">Pasillo angosto</option>
                            <option value="manlift">Manlift</option>
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
                <h5 class="modal-title text-white" id="agregarMantenimientoModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="documentFormMantenimiento" method="POST" enctype="multipart/form-data" onsubmit="return prepararEnvio();">
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
                                    <div class="col-md-6">
                                        <label for="HoraFinal">Hora Final</label>
                                        <input type="time" class="form-control" name="HoraFinal" id="HoraFinal" value="<?= date('H:i', strtotime($horaFormateada)) ?>">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Mantenimiento Mil Horas</label>

                                        <div class="form-check form-switch">
                                            <input type="hidden" name="MantenimientoMilHoras" value="0">
                                            <input class="form-check-input" type="checkbox" name="MantenimientoMilHoras" value="1">
                                            <label class="form-check-label" for="MantenimientoMilHoras">Sí / No</label>
                                        </div>
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
                            <p class="mb-2" style="color: #000020;"> Seleccione en el campo de condición alguna de las siguientes convenciones: </p>
                                <div>
                                    <span style="display:inline-block; background:#d4edda; color:#155724; padding:3px 5px; border-radius:5px; margin:2px;">
                                        <strong>C-Conforme</strong>
                                    </span>
                                    <span style="display:inline-block; background:#f8d7da; color:#721c24; padding:3px 5px; border-radius:5px; margin:2px;">
                                        <strong>R-Reparación</strong>
                                    </span>
                                    <span style="display:inline-block; background:#fff3cd; color:#856404; padding:3px 5px; border-radius:5px; margin:2px;">
                                        <strong>N-Nivelación</strong>
                                    </span>
                                    <span style="display:inline-block; background:#ffe5b4; color:#8b4513; padding:3px 5px; border-radius:5px; margin:2px;">
                                        <strong>A-Ajuste</strong>
                                    </span>
                                    <span style="display:inline-block; background:#cce5ff; color:#004085; padding:3px 5px; border-radius:5px; margin:2px;">
                                        <strong>L-Lubricación y Engrase</strong>
                                    </span>
                                    <span style="display:inline-block; background:#e2e3e5; color:#383d41; padding:3px 5px; border-radius:5px; margin:2px;">
                                        <strong>N/A-No aplica</strong>
                                    </span>
                                </div>
                            <p class="mb-2" style="color: #000020;"><strong>Nota:</strong> Durante el mantenimiento preventivo, se debe hacer la limpieza general del equipo.</p>
                            <div class="row">
                                <a id="btnFrenosCard" class="col-sm-6 col-xl-4" href="#" data-open-modal="#ModalFrenos">
                                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-3">
                                        <img width="50" height="50" src="https://img.icons8.com/ios-filled/50/000020/abs.png" alt="abs" />
                                        <div class="ms-3">
                                            <p class="mb-2" style="color: #000020;">Sistema De Frenos</p>
                                        </div>
                                    </div>
                                </a>
                                <a id="btnDireccionCard" class="col-sm-6 col-xl-4" href="#" data-open-modal="#ModalDireccion" style="display:none;">
                                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-3">
                                        <img width="50" height="50" src="https://img.icons8.com/ios-filled/50/000020/steering-wheel.png" alt="steering-wheel" />
                                        <div class="ms-3">
                                            <p class="mb-2" style="color: #000020;">Sistema De Dirección</p>
                                        </div>
                                    </div>
                                </a>
                                <a id="btnTraccionCard" class="col-sm-6 col-xl-4" href="#" data-open-modal="#ModalTraccion" style="display:none;">
                                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-3">
                                        <img width="50" height="50" src="https://img.icons8.com/ios-filled/50/000020/traction-control.png" alt="traction-control" />
                                        <div class="ms-3">
                                            <p class="mb-2" style="color: #000020;">Sistema De Tracción</p>
                                        </div>
                                    </div>
                                </a>
                                <a id="btnAuxiliaresCard" class="col-sm-6 col-xl-4" href="#" data-open-modal="#ModalAuxiliares" style="display:none;">
                                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-3">
                                        <img width="50" height="50" src="https://img.icons8.com/ios-filled/50/000020/steering-wheel.png" alt="steering-wheel" />
                                        <div class="ms-3">
                                            <p class="mb-2" style="color: #000020;">Sistema De Funciones Auxiliares</p>
                                        </div>
                                    </div>
                                </a>
                                <a id="btnCombustionCard" class="col-sm-6 col-xl-4" href="#" data-open-modal="#ModalCombustion" style="display:none;">
                                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-3">
                                        <img width="50" height="50" src="https://img.icons8.com/ios-filled/50/000020/spark-plug.png" alt="spark-plug"/>
                                        <div class="ms-3">
                                            <p class="mb-2" style="color: #000020;">Sistema De Combustion</p>
                                        </div>
                                    </div>
                                </a>
                                <a id="btnComponentesCard" class="col-sm-6 col-xl-4" href="#" data-open-modal="#ModalComponentes" style="display:none;">
                                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-3">
                                        <img width="50" height="50" src="https://img.icons8.com/ios-filled/50/000020/fork-lift.png" alt="fork-lift" />
                                        <div class="ms-3">
                                            <p class="mb-2" style="color: #000020;">Componentes Estructurales</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <br>
                            <div class="row">
                                <a id="btnBateriaCard" class="col-sm-6 col-xl-4" href="#" data-open-modal="#ModalBateria">
                                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-3">
                                        <img width="50" height="50" src="https://img.icons8.com/ios-filled/50/000020/charge-battery--v1.png" alt="charge-battery--v1" />
                                        <div class="ms-3">
                                            <p class="mb-2" style="color: #000020;">Batería</p>
                                        </div>
                                    </div>
                                </a>
                                <a id="btnElectricoCard" class="col-sm-6 col-xl-4" href="#" data-open-modal="#ModalElectrico">
                                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-3">
                                        <img width="50" height="50" src="https://img.icons8.com/ios-filled/50/000020/carbon-brush.png" alt="carbon-brush" />
                                        <div class="ms-3">
                                            <p class="mb-2" style="color: #000020;">Sistema Eléctrico</p>
                                        </div>
                                    </div>
                                </a>
                                <a id="btnMastilCard" class="col-sm-6 col-xl-4" href="#" data-open-modal="#ModalMastil" style="display:none;">
                                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-3">
                                        <img width="50" height="50" src="https://img.icons8.com/deco-glyph/50/000028/fork-lift.png" alt="fork-lift" />
                                        <div class="ms-3">
                                            <p class="mb-2" style="color: #000020;">Mastil</p>
                                        </div>
                                    </div>
                                </a>
                                <a id="btnFuncionamientoCard" class="col-sm-6 col-xl-4" href="#" data-open-modal="#ModalFuncionamiento" style="display:none;">
                                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-3">
                                        <img width="50" height="50" src="https://img.icons8.com/external-goofy-solid-kerismaker/50/000020/external-Ladder-Truck-airport-goofy-solid-kerismaker.png" alt="external-Ladder-Truck-airport-goofy-solid-kerismaker"/>
                                        <div class="ms-3">
                                            <p class="mb-2" style="color: #000020;">Funcionamiento General</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <br>
                            <div class="row">
                                <a id="btnLubricacionCard" class="col-sm-6 col-xl-4" href="#" data-open-modal="#ModalLubricacion">
                                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-3">
                                        <img width="50" height="50" src="https://img.icons8.com/ios-filled/50/000020/engine-oil-level.png" alt="engine-oil-level" />
                                        <div class="ms-3">
                                            <p class="mb-2" style="color: #000020;">Lubricacíon</p>
                                        </div>
                                    </div>
                                </a>
                                <a id="btnLucesCard" class="col-sm-6 col-xl-4" href="#" data-open-modal="#ModalLuces" style="display:none;">
                                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-3">
                                        <img width="50" height="50" src="https://img.icons8.com/ios-filled/50/000020/headlight.png" alt="headlight" />
                                        <div class="ms-3">
                                            <p class="mb-2" style="color: #000020;">Luces y Alarmas</p>
                                        </div>
                                    </div>
                                </a>
                                <a id="btnAditamentosCard"  class="col-sm-6 col-xl-4" href="#" data-open-modal="#ModalAditamentos" style="display:none;">
                                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-3">
                                        <img width="50" height="50" src="https://img.icons8.com/ios-glyphs/50/000020/gearbox-selector.png" alt="gearbox-selector" />
                                        <div class="ms-3">
                                            <p class="mb-2" style="color: #000020;">Aditamentos</p>
                                        </div>
                                    </div>
                                </a>
                                <a id="btnPantografoCard" class="col-sm-6 col-xl-4" href="#" data-open-modal="#ModalPantografo" style="display:none;">
                                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-3">
                                        <img width="50" height="50" src="https://img.icons8.com/sf-regular-filled/50/000020/mine-cart.png" alt="mine-cart" />
                                        <div class="ms-3">
                                            <p class="mb-2" style="color: #000020;">Pantógrafo</p>
                                        </div>
                                    </div>
                                </a>
                                <a id="btnMotorCard" class="col-sm-6 col-xl-4" href="#" data-open-modal="#ModalMotor" style="display:none;">
                                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-3">
                                        <img width="50" height="50" src="https://img.icons8.com/ios-filled/50/000020/engine.png" alt="engine"/>
                                        <div class="ms-3">
                                            <p class="mb-2" style="color: #000020;">Motor</p>
                                        </div>
                                    </div>
                                </a>
                                <a id="btnCorreasCard" class="col-sm-6 col-xl-4" href="#" data-open-modal="#ModalCorreas" style="display:none;">
                                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-3">
                                        <img width="50" height="50" src="https://img.icons8.com/external-flatart-icons-outline-flatarticons/50/000020/external-chain-jewellery-flatart-icons-outline-flatarticons.png" alt="external-chain-jewellery-flatart-icons-outline-flatarticons"/>
                                        <div class="ms-3">
                                            <p class="mb-2" style="color: #000020;">Correas Y Cadenas</p>
                                        </div>
                                    </div>
                                </a>
                                <a id="btnUnidadCard" class="col-sm-6 col-xl-4" href="#" data-open-modal="#ModalUnidad" style="display:none;">
                                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-3">
                                        <img width="50" height="50" src="https://img.icons8.com/ios-filled/50/000020/engine.png" alt="engine"/>
                                        <div class="ms-3">
                                            <p class="mb-2" style="color: #000020;">Unidad De Tracción</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <br>
                            <div class="row">
                                <a id="btnHorquillasCard" class="col-sm-6 col-xl-4" href="#" data-open-modal="#ModalHorquillas"style="display:none;">
                                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-3">
                                        <img width="50" height="50" src="https://img.icons8.com/ios-filled/50/000020/l.png" alt="l" />
                                        <div class="ms-3">
                                            <p class="mb-2" style="color: #000020;">Horquillas</p>
                                        </div>
                                    </div>
                                </a>
                                <a id="btnChasisCard" class="col-sm-6 col-xl-4" href="#" data-open-modal="#ModalChasis" style="display:none;">
                                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-3">
                                        <img width="50" height="50" src="https://img.icons8.com/ios-glyphs/50/000020/4x4-vehicle.png" alt="4x4-vehicle" />
                                        <div class="ms-3">
                                            <p class="mb-2" style="color: #000020;">Chasis</p>
                                        </div>
                                    </div>
                                </a>
                                <a id="btnRuedasCard" class="col-sm-6 col-xl-4" href="#" data-open-modal="#ModalRuedas">
                                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-3">
                                        <img width="50" height="50" src="https://img.icons8.com/ios-glyphs/50/000020/wheel.png" alt="wheel" />
                                        <div class="ms-3">
                                            <p class="mb-2" style="color: #000020;">Ruedas</p>
                                        </div>
                                    </div>
                                </a>
                                <a id="btnPintura1Card" class="col-sm-6 col-xl-4" href="#" data-open-modal="#ModalPintura1" style="display:none;">
                                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-3">
                                        <img width="50" height="50" src="https://img.icons8.com/external-flatart-icons-solid-flatarticons/64/000020/external-airbrush-fine-arts-flatart-icons-solid-flatarticons.png" alt="external-airbrush-fine-arts-flatart-icons-solid-flatarticons"/>
                                        <div class="ms-3">
                                            <p class="mb-2" style="color: #000020;">Estado De Pintura</p>
                                        </div>
                                    </div>
                                </a>
                                <a id="btnPanelCard" class="col-sm-6 col-xl-4" href="#" data-open-modal="#ModalPanel" style="display:none;">
                                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-3">
                                        <img width="50" height="50" src="https://img.icons8.com/wired/50/000020/control-panel.png" alt="control-panel"/>
                                        <div class="ms-3">
                                            <p class="mb-2" style="color: #000020;">Panel De Controles</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <br>
                            <div class="row">
                                <a id="btnHidraulicoCard" class="col-sm-6 col-xl-4" href="#" data-open-modal="#ModalHidraulico">
                                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-3">
                                        <img width="50" height="50" src="https://img.icons8.com/external-solidglyph-m-oki-orlando/64/000020/external-hydraulic-engineering-engineering-solid-solidglyph-m-oki-orlando.png" alt="external-hydraulic-engineering-engineering-solid-solidglyph-m-oki-orlando" />
                                        <div class="ms-3">
                                            <p class="mb-2" style="color: #000020;">Sistema Hidraulico</p>
                                        </div>
                                    </div>
                                </a>
                                <a id="btnCarroPortaCard" class="col-sm-6 col-xl-4" href="#" data-open-modal="#ModalCarroPorta" style="display:none;">
                                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-3">
                                        <img width="50" height="50" src="https://img.icons8.com/sf-regular-filled/50/000020/mine-cart.png" alt="mine-cart" />
                                        <div class="ms-3">
                                            <p class="mb-2" style="color: #000020;">Carro Porta Horquillas</p>
                                        </div>
                                    </div>
                                </a>
                                <a id="btnSuspensionCard"  class="col-sm-6 col-xl-4" href="#" data-open-modal="#ModalSuspension" style="display:none;">
                                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-3">
                                        <img width="50" height="50" src="https://img.icons8.com/external-prettycons-solid-prettycons/50/000020/external-suspension-car-parts-vehicles-prettycons-solid-prettycons.png" alt="external-suspension-car-parts-vehicles-prettycons-solid-prettycons"/>
                                        <div class="ms-3">
                                            <p class="mb-2" style="color: #000020;">Sistema De Suspensión</p>
                                        </div>
                                    </div>
                                </a>
                                <a id="btnRefrigeracionCard" class="col-sm-6 col-xl-4" href="#" data-open-modal="#ModalRefrigeracion" style="display:none;">
                                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-3">
                                        <img width="50" height="50" src="https://img.icons8.com/ios-glyphs/50/000020/car-radiator.png" alt="car-radiator"/>
                                        <div class="ms-3">
                                            <p class="mb-2" style="color: #000020;">Sistema De Refigeración</p>
                                        </div>
                                    </div>
                                </a>
                                <a id="btnRevisionCard" class="col-sm-6 col-xl-4" href="#" data-open-modal="#ModalRevision" style="display:none;">
                                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-3">
                                        <img width="50" height="50" src="https://img.icons8.com/ios-filled/50/000020/fork-lift.png" alt="fork-lift" />
                                        <div class="ms-3">
                                            <p class="mb-2" style="color: #000020;">Revision De Equipo</p>
                                        </div>
                                    </div>
                                </a>
                                <a id="btnRevisionesCard" class="col-sm-6 col-xl-4" href="#" data-open-modal="#ModalRevisiones" style="display:none;">
                                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-3">
                                        <img width="50" height="50" src="https://img.icons8.com/external-goofy-solid-kerismaker/50/000020//external-Revision-graphic-design-goofy-solid-kerismaker.png" alt="external-Revision-graphic-design-goofy-solid-kerismaker"/>
                                        <div class="ms-3">
                                            <p class="mb-2" style="color: #000020;">Revisiones De Operación</p>
                                        </div>
                                    </div>
                                </a>
                                <a id="btnAusenciaCard"  class="col-sm-6 col-xl-4" href="#" data-open-modal="#ModalAusencia" style="display:none;">
                                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-3">
                                        <img width="50" height="50" src="https://img.icons8.com/ios-filled/50/000020/administrative-tools.png" alt="administrative-tools"/>
                                        <div class="ms-3">
                                            <p class="mb-2" style="color: #000020;">Ausencia De Piezas O Componentes</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <br>
                            <div class="row">
                                <a id="btnCargadorCard" class="col-sm-6 col-xl-4" href="#" data-open-modal="#ModalCargador" style="display:none;">
                                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-3">
                                      <img width="50" height="50" src="https://img.icons8.com/external-yogi-aprelliyanto-glyph-yogi-aprelliyanto/50/000020/external-power-supply-computer-hardware-yogi-aprelliyanto-glyph-yogi-aprelliyanto.png" alt="external-power-supply-computer-hardware-yogi-aprelliyanto-glyph-yogi-aprelliyanto"/>
                                        <div class="ms-3">
                                            <p class="mb-2" style="color: #000020;">Cargador</p>
                                        </div>
                                    </div>
                                </a>
                                <a id="btnTransmisionCard" class="col-sm-6 col-xl-4" href="#" data-open-modal="#ModalTransmision" style="display:none;">
                                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-3">
                                    <img width="50" height="50" src="https://img.icons8.com/pulsar-line/50/000020/engine-coolant.png" alt="engine-coolant"/>    
                                        <div class="ms-3">
                                            <p class="mb-2" style="color: #000020;">Transmisión</p>
                                        </div>
                                    </div>
                                </a>
                                <a id="btnCajaCard" class="col-sm-6 col-xl-4" href="#" data-open-modal="#ModalCaja" style="display:none;">
                                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-3">
                                        <img width="50" height="50" src="https://img.icons8.com/ios-filled/50/000020/gear-stick.png" alt="gear-stick"/>
                                        <div class="ms-3">
                                            <p class="mb-2" style="color: #000020;">Caja Automática</p>
                                        </div>
                                    </div>
                                </a>
                                <a id="btnPinturaCard" class="col-sm-6 col-xl-4" href="#" data-open-modal="#ModalPintura" style="display:none;">
                                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-3">
                                        <img width="50" height="50" src="https://img.icons8.com/external-flatart-icons-solid-flatarticons/64/000020/external-airbrush-fine-arts-flatart-icons-solid-flatarticons.png" alt="external-airbrush-fine-arts-flatart-icons-solid-flatarticons"/>
                                        <div class="ms-3">
                                            <p class="mb-2" style="color: #000020;">Estado De Pintura</p>
                                        </div>
                                    </div>
                                </a>
                                <a id="btnTrabajosCard" class="col-sm-6 col-xl-4" href="#" data-open-modal="#ModalTrabajos" style="display:none;">
                                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-3">
                                        <img width="50" height="50" src="https://img.icons8.com/external-yogi-aprelliyanto-glyph-yogi-aprelliyanto/50/000020/external-work-list-creative-innovation-yogi-aprelliyanto-glyph-yogi-aprelliyanto.png" alt="external-work-list-creative-innovation-yogi-aprelliyanto-glyph-yogi-aprelliyanto"/>
                                        <div class="ms-3">
                                            <p class="mb-2" style="color: #000020;">Trabajos a realizar</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <br>
                            <div class="row">
                                <a id="btnTrabajosCard1" class="col-sm-6 col-xl-4" href="#" data-open-modal="#ModalTrabajos" style="display:none;">
                                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-3">
                                        <img width="50" height="50" src="https://img.icons8.com/external-yogi-aprelliyanto-glyph-yogi-aprelliyanto/50/000020/external-work-list-creative-innovation-yogi-aprelliyanto-glyph-yogi-aprelliyanto.png" alt="external-work-list-creative-innovation-yogi-aprelliyanto-glyph-yogi-aprelliyanto"/>
                                        <div class="ms-3">
                                            <p class="mb-2" style="color: #000020;">Trabajos a realizar</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="ID_MecanicoPrincipal" value="<?= $_SESSION['ID'] ?>">
                    <input type="hidden" name="tipoMontacargas" id="hiddentipoMontacargas">
                    <input type="hidden" name="ID_Centro2" id="hiddenIDCentro">
                    <input type="hidden" name="IDSupervisor" id="formIDSupervisor">
                    <input type="hidden" name="CorreoSupervisor" id="formCorreoSupervisor">
                    <input type="hidden" name="NombreSupervisor" id="formNombreSupervisor">
                    <input type="hidden" name="ID_Montacargas1" id="hiddenIDMontacargas">
                    <input type="hidden" name="ID_Area1" id="hiddenIDArea">
                    <input type="hidden" name="ID_Operario1" id="hiddenIDOperario">
                    <input type="hidden" name="N_Bateria" id="hiddenN_Bateria">
                    <input type="hidden" name="ClaseH" id="hiddenClaseH">
                    <input type="hidden" name="LongitudH" id="hiddenLongitudH">
                    <input type="hidden" name="Criterio_1" id="hiddenCriterio_1">
                    <input type="hidden" name="Criterio_2" id="hiddenCriterio_2">
                    <input type="hidden" name="Criterio_3" id="hiddenCriterio_3">
                    <input type="hidden" name="Criterio_4" id="hiddenCriterio_4">
                    <input type="hidden" name="Criterio_5" id="hiddenCriterio_5">
                    <input type="hidden" name="Criterio_6" id="hiddenCriterio_6">
                    <input type="hidden" name="Criterio_7" id="hiddenCriterio_7">
                    <input type="hidden" name="Criterio_8" id="hiddenCriterio_8">
                    <input type="hidden" name="Criterio_9" id="hiddenCriterio_9">
                    <input type="hidden" name="Criterio_10" id="hiddenCriterio_10">
                    <input type="hidden" name="Criterio_11" id="hiddenCriterio_11">
                    <input type="hidden" name="Criterio_12" id="hiddenCriterio_12">
                    <input type="hidden" name="Criterio_13" id="hiddenCriterio_13">
                    <input type="hidden" name="Criterio_14" id="hiddenCriterio_14">
                    <input type="hidden" name="Criterio_15" id="hiddenCriterio_15">
                    <input type="hidden" name="Criterio_16" id="hiddenCriterio_16">
                    <input type="hidden" name="Criterio_17" id="hiddenCriterio_17">
                    <input type="hidden" name="Criterio_18" id="hiddenCriterio_18">
                    <input type="hidden" name="Criterio_19" id="hiddenCriterio_19">
                    <input type="hidden" name="Criterio_20" id="hiddenCriterio_20">
                    <input type="hidden" name="Criterio_21" id="hiddenCriterio_21">
                    <input type="hidden" name="Criterio_22" id="hiddenCriterio_22">
                    <input type="hidden" name="Criterio_23" id="hiddenCriterio_23">
                    <input type="hidden" name="Criterio_24" id="hiddenCriterio_24">
                    <input type="hidden" name="Criterio_25" id="hiddenCriterio_25">
                    <input type="hidden" name="Criterio_26" id="hiddenCriterio_26">
                    <input type="hidden" name="Criterio_27" id="hiddenCriterio_27">
                    <input type="hidden" name="Criterio_28" id="hiddenCriterio_28">
                    <input type="hidden" name="Criterio_29" id="hiddenCriterio_29">
                    <input type="hidden" name="Criterio_30" id="hiddenCriterio_30">
                    <input type="hidden" name="Criterio_31" id="hiddenCriterio_31">
                    <input type="hidden" name="Criterio_32" id="hiddenCriterio_32">
                    <input type="hidden" name="Criterio_33" id="hiddenCriterio_33">
                    <input type="hidden" name="Criterio_34" id="hiddenCriterio_34">
                    <input type="hidden" name="Criterio_35" id="hiddenCriterio_35">
                    <input type="hidden" name="Criterio_36" id="hiddenCriterio_36">
                    <input type="hidden" name="Criterio_37" id="hiddenCriterio_37">
                    <input type="hidden" name="Criterio_38" id="hiddenCriterio_38">
                    <input type="hidden" name="Criterio_39" id="hiddenCriterio_39">
                    <input type="hidden" name="Criterio_40" id="hiddenCriterio_40">
                    <input type="hidden" name="Criterio_41" id="hiddenCriterio_41">
                    <input type="hidden" name="Criterio_42" id="hiddenCriterio_42">
                    <input type="hidden" name="Criterio_43" id="hiddenCriterio_43">
                    <input type="hidden" name="Criterio_44" id="hiddenCriterio_44">
                    <input type="hidden" name="Criterio_45" id="hiddenCriterio_45">
                    <input type="hidden" name="Criterio_46" id="hiddenCriterio_46">
                    <input type="hidden" name="Criterio_47" id="hiddenCriterio_47">
                    <input type="hidden" name="Criterio_48" id="hiddenCriterio_48">
                    <input type="hidden" name="Criterio_49" id="hiddenCriterio_49">
                    <input type="hidden" name="Criterio_50" id="hiddenCriterio_50">
                    <input type="hidden" name="Criterio_51" id="hiddenCriterio_51">
                    <input type="hidden" name="Criterio_52" id="hiddenCriterio_52">
                    <input type="hidden" name="Criterio_53" id="hiddenCriterio_53">
                    <input type="hidden" name="Criterio_54" id="hiddenCriterio_54">
                    <input type="hidden" name="Criterio_55" id="hiddenCriterio_55">
                    <input type="hidden" name="Criterio_56" id="hiddenCriterio_56">
                    <input type="hidden" name="Criterio_57" id="hiddenCriterio_57">
                    <input type="hidden" name="Criterio_58" id="hiddenCriterio_58">
                    <input type="hidden" name="Criterio_59" id="hiddenCriterio_59">
                    <input type="hidden" name="Criterio_60" id="hiddenCriterio_60">
                    <input type="hidden" name="Criterio_61" id="hiddenCriterio_61">
                    <input type="hidden" name="Criterio_62" id="hiddenCriterio_62">
                    <input type="hidden" name="Criterio_63" id="hiddenCriterio_63">
                    <input type="hidden" name="Criterio_64" id="hiddenCriterio_64">
                    <input type="hidden" name="Criterio_65" id="hiddenCriterio_65">
                    <input type="hidden" name="Criterio_66" id="hiddenCriterio_66">
                    <input type="hidden" name="Criterio_67" id="hiddenCriterio_67">
                    <input type="hidden" name="Criterio_68" id="hiddenCriterio_68">
                    <input type="hidden" name="Criterio_69" id="hiddenCriterio_69">
                    <input type="hidden" name="Criterio_70" id="hiddenCriterio_70">
                    <input type="hidden" name="Criterio_71" id="hiddenCriterio_71">
                    <input type="hidden" name="Criterio_72" id="hiddenCriterio_72">
                    <input type="hidden" name="Criterio_73" id="hiddenCriterio_73">
                    <input type="hidden" name="Criterio_74" id="hiddenCriterio_74">
                    <input type="hidden" name="Criterio_75" id="hiddenCriterio_75">
                    <input type="hidden" name="Criterio_76" id="hiddenCriterio_76">
                    <input type="hidden" name="Criterio_77" id="hiddenCriterio_77">
                    <input type="hidden" name="Criterio_78" id="hiddenCriterio_78">
                    <input type="hidden" name="Criterio_79" id="hiddenCriterio_79">
                    <input type="hidden" name="Criterio_80" id="hiddenCriterio_80">
                    <input type="hidden" name="Criterio_81" id="hiddenCriterio_81">
                    <input type="hidden" name="Criterio_82" id="hiddenCriterio_82">
                    <input type="hidden" name="Criterio_83" id="hiddenCriterio_83">
                    <input type="hidden" name="Criterio_84" id="hiddenCriterio_84">
                    <input type="hidden" name="Criterio_85" id="hiddenCriterio_85">
                    <input type="hidden" name="Criterio_86" id="hiddenCriterio_86">
                    <input type="hidden" name="Criterio_87" id="hiddenCriterio_87">
                    <input type="hidden" name="Criterio_88" id="hiddenCriterio_88">
                    <input type="hidden" name="Criterio_89" id="hiddenCriterio_89">
                    <input type="hidden" name="Criterio_90" id="hiddenCriterio_90">
                    <input type="hidden" name="Criterio_91" id="hiddenCriterio_91">
                    <input type="hidden" name="Criterio_92" id="hiddenCriterio_92">
                    <input type="hidden" name="Criterio_93" id="hiddenCriterio_93">
                    <input type="hidden" name="Criterio_94" id="hiddenCriterio_94">
                    <input type="hidden" name="Criterio_95" id="hiddenCriterio_95">
                    <input type="hidden" name="Criterio_96" id="hiddenCriterio_96">
                    <input type="hidden" name="Criterio_97" id="hiddenCriterio_97">
                    <input type="hidden" name="Criterio_98" id="hiddenCriterio_98">
                    <input type="hidden" name="Criterio_99" id="hiddenCriterio_99">
                    <input type="hidden" name="Criterio_100" id="hiddenCriterio_100">
                    <input type="hidden" name="Criterio_101" id="hiddenCriterio_101">
                    <input type="hidden" name="Criterio_102" id="hiddenCriterio_102">
                    <input type="hidden" name="Criterio_103" id="hiddenCriterio_103">
                    <input type="hidden" name="Criterio_104" id="hiddenCriterio_104">
                    <input type="hidden" name="Criterio_105" id="hiddenCriterio_105">
                    <input type="hidden" name="Criterio_106" id="hiddenCriterio_106">
                    <input type="hidden" name="Criterio_107" id="hiddenCriterio_107">
                    <input type="hidden" name="Criterio_108" id="hiddenCriterio_108">
                    <input type="hidden" name="Criterio_109" id="hiddenCriterio_109">
                    <input type="hidden" name="Criterio_110" id="hiddenCriterio_110">
                    <input type="hidden" name="Criterio_111" id="hiddenCriterio_111">
                    <input type="hidden" name="Criterio_112" id="hiddenCriterio_112">
                    <input type="hidden" name="Criterio_113" id="hiddenCriterio_113">
                    <input type="hidden" name="Criterio_114" id="hiddenCriterio_114">
                    <input type="hidden" name="Criterio_115" id="hiddenCriterio_115">
                    <input type="hidden" name="Criterio_116" id="hiddenCriterio_116">
                    <input type="hidden" name="Criterio_117" id="hiddenCriterio_117">
                    <input type="hidden" name="Criterio_118" id="hiddenCriterio_118">
                    <input type="hidden" name="Criterio_119" id="hiddenCriterio_119">
                    <input type="hidden" name="Criterio_120" id="hiddenCriterio_120">
                    <input type="hidden" name="Criterio_121" id="hiddenCriterio_121">
                    <input type="hidden" name="Criterio_122" id="hiddenCriterio_122">
                    <input type="hidden" name="Criterio_123" id="hiddenCriterio_123">
                    <input type="hidden" name="Criterio_124" id="hiddenCriterio_124">
                    <input type="hidden" name="Criterio_125" id="hiddenCriterio_125">
                    <input type="hidden" name="Criterio_126" id="hiddenCriterio_126">
                    <input type="hidden" name="Criterio_127" id="hiddenCriterio_127">
                    <input type="hidden" name="Criterio_128" id="hiddenCriterio_128">
                    <input type="hidden" name="Criterio_129" id="hiddenCriterio_129">
                    <input type="hidden" name="Criterio_130" id="hiddenCriterio_130">
                    <input type="hidden" name="Criterio_131" id="hiddenCriterio_131">
                    <input class="form-control d-none" type="file" id="imagenesDiagnosticoBateria" name="imagenesDiagnosticoBateria[]" accept="image/*" multiple>
                    <input class="form-control d-none" type="file" id="imagenesDiagnosticoElectrico" name="imagenesDiagnosticoElectrico[]" accept="image/*" multiple>
                    <input class="form-control d-none" type="file" id="imagenesDiagnosticoTraccion" name="imagenesDiagnosticoTraccion[]" accept="image/*" multiple>
                    <input class="form-control d-none" type="file" id="imagenesDiagnosticoFrenos" name="imagenesDiagnosticoFrenos[]" accept="image/*" multiple>
                    <input class="form-control d-none" type="file" id="imagenesDiagnosticoDireccion" name="imagenesDiagnosticoDireccion[]" accept="image/*" multiple>
                    <input class="form-control d-none" type="file" id="imagenesDiagnosticoHidraulico" name="imagenesDiagnosticoHidraulico[]" accept="image/*" multiple>
                    <input class="form-control d-none" type="file" id="imagenesDiagnosticoMastil" name="imagenesDiagnosticoMastil[]" accept="image/*" multiple>
                    <input class="form-control d-none" type="file" id="imagenesDiagnosticoCarroPorta" name="imagenesDiagnosticoCarroPorta[]" accept="image/*" multiple>
                    <input class="form-control d-none" type="file" id="imagenesDiagnosticoLubricacion" name="imagenesDiagnosticoLubricacion[]" accept="image/*" multiple>
                    <input class="form-control d-none" type="file" id="imagenesDiagnosticoHorquillas" name="imagenesDiagnosticoHorquillas[]" accept="image/*" multiple>
                    <input class="form-control d-none" type="file" id="imagenesDiagnosticoChasis" name="imagenesDiagnosticoChasis[]" accept="image/*" multiple>
                    <input class="form-control d-none" type="file" id="imagenesDiagnosticoRuedas" name="imagenesDiagnosticoRuedas[]" accept="image/*" multiple>
                    <input class="form-control d-none" type="file" id="imagenesDiagnosticoLuces" name="imagenesDiagnosticoLuces[]" accept="image/*" multiple>
                    <input class="form-control d-none" type="file" id="imagenesDiagnosticoAditamentos" name="imagenesDiagnosticoAditamentos[]" accept="image/*" multiple>
                    <input class="form-control d-none" type="file" id="imagenesDiagnosticoCargador" name="imagenesDiagnosticoCargador[]" accept="image/*" multiple>
                    <input class="form-control d-none" type="file" id="imagenesDiagnosticoRevision" name="imagenesDiagnosticoRevision[]" accept="image/*" multiple>
                    <input class="form-control d-none" type="file" id="imagenesDiagnosticoAuxiliares" name="imagenesDiagnosticoAuxiliares[]" accept="image/*" multiple>
                    <input class="form-control d-none" type="file" id="imagenesDiagnosticoSuspension" name="imagenesDiagnosticoSuspension[]" accept="image/*" multiple>
                    <input class="form-control d-none" type="file" id="imagenesDiagnosticoPantografo" name="imagenesDiagnosticoPantografo[]" accept="image/*" multiple>
                    <input class="form-control d-none" type="file" id="imagenesDiagnosticoMotor" name="imagenesDiagnosticoMotor[]" accept="image/*" multiple>
                    <input class="form-control d-none" type="file" id="imagenesDiagnosticoRefrigeracion" name="imagenesDiagnosticoRefrigeracion[]" accept="image/*" multiple>
                    <input class="form-control d-none" type="file" id="imagenesDiagnosticoCombustion" name="imagenesDiagnosticoCombustion[]" accept="image/*" multiple>
                    <input class="form-control d-none" type="file" id="imagenesDiagnosticoTransmision" name="imagenesDiagnosticoTransmision[]" accept="image/*" multiple>
                    <input class="form-control d-none" type="file" id="imagenesDiagnosticoCaja" name="imagenesDiagnosticoCaja[]" accept="image/*" multiple>
                    <input class="form-control d-none" type="file" id="imagenesDiagnosticoComponentes" name="imagenesDiagnosticoComponentes[]" accept="image/*" multiple>
                    <input class="form-control d-none" type="file" id="imagenesDiagnosticoAusencia" name="imagenesDiagnosticoAusencia[]" accept="image/*" multiple>
                    <input class="form-control d-none" type="file" id="imagenesDiagnosticoRevisiones" name="imagenesDiagnosticoRevisiones[]" accept="image/*" multiple>
                    <input class="form-control d-none" type="file" id="imagenesDiagnosticoFuncionamiento" name="imagenesDiagnosticoFuncionamiento[]" accept="image/*" multiple>
                    <input class="form-control d-none" type="file" id="imagenesDiagnosticoCorreas" name="imagenesDiagnosticoCorreas[]" accept="image/*" multiple>
                    <input class="form-control d-none" type="file" id="imagenesDiagnosticoUnidad" name="imagenesDiagnosticoUnidad[]" accept="image/*" multiple>
                    <input class="form-control d-none" type="file" id="imagenesDiagnosticoPanel" name="imagenesDiagnosticoPanel[]" accept="image/*" multiple>
                    <input class="form-control d-none" type="file" id="imagenesDiagnosticoPintura" name="imagenesDiagnosticoPintura[]" accept="image/*" multiple>
                    <input type="hidden" name="TrabajosRealizados" id="TrabajosRealizados">
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

<div class="modal fade" id="ModalBateria" tabindex="-1" aria-labelledby="ModalBateriaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #000020;">
                <h5 class="modal-title text-white" id="ModalBateriaLabel">Diagnóstico: Batería</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="contenidoBateria">
                <!-- Aquí se inyectará dinámicamente el formulario -->
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalElectrico" tabindex="-1" aria-labelledby="ModalElectricoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #000020;">
                <h5 class="modal-title text-white" id="ModalElectricoLabel">Diagnóstico: Sistema Eléctrico</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="contenidoElectrico">
                <!-- Aquí se inyectará dinámicamente el formulario -->
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalTraccion" tabindex="-1" aria-labelledby="ModalTraccionLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #000020;">
                <h5 class="modal-title text-white" id="ModalTraccionLabel">Diagnóstico: Sistema Tracción</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="contenidoTraccion">
                <!-- Aquí se inyectará dinámicamente el formulario -->
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalFrenos" tabindex="-1" aria-labelledby="ModalFrenosLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #000020;">
                <h5 class="modal-title text-white" id="ModalFrenosLabel">Diagnóstico: Sistema de Frenos</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="contenidoFrenos">
                <!-- Aquí se inyectará dinámicamente el formulario -->
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalDireccion" tabindex="-1" aria-labelledby="ModalDireccionLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #000020;">
                <h5 class="modal-title text-white" id="ModalDireccionLabel">Diagnóstico: Sistema De Dirección</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="contenidoDireccion">
                <!-- Aquí se inyectará dinámicamente el formulario -->
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalHidraulico" tabindex="-1" aria-labelledby="ModalHidraulicoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #000020;">
                <h5 class="modal-title text-white" id="ModalHidraulicoLabel">Diagnóstico: Sistema Hidráulico</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="contenidoHidraulico">
                <!-- Aquí se inyectará dinámicamente el formulario -->
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalMastil" tabindex="-1" aria-labelledby="ModalMastilLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #000020;">
                <h5 class="modal-title text-white" id="ModalMastilLabel">Diagnóstico: Mastil</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="contenidoMastil">
                <!-- Aquí se inyectará dinámicamente el formulario -->
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                </div>
            </div>  
        </div>
    </div>
</div>

<div class="modal fade" id="ModalCarroPorta" tabindex="-1" aria-labelledby="ModalCarroPortaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #000020;">
                <h5 class="modal-title text-white" id="ModalCarroPortaLabel">Diagnóstico: Carro Porta Horquillas</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="contenidoCarroPorta">
                <!-- Aquí se inyectará dinámicamente el formulario -->
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalLubricacion" tabindex="-1" aria-labelledby="ModalLubricacionLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #000020;">
                <h5 class="modal-title text-white" id="ModalLubricacionLabel">Diagnóstico: Lubricacíon</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="contenidoLubricacion">
                <!-- Aquí se inyectará dinámicamente el formulario -->
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalHorquillas" tabindex="-1" aria-labelledby="ModalHorquillasLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #000020;">
                <h5 class="modal-title text-white" id="ModalHorquillasLabel">Diagnóstico: Horquillas</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="contenidoHorquillas">
                <!-- Aquí se inyectará dinámicamente el formulario -->
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalChasis" tabindex="-1" aria-labelledby="ModalChasisLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #000020;">
                <h5 class="modal-title text-white" id="ModalChasisLabel">Diagnóstico: Chasis</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="contenidoChasis">
                <!-- Aquí se inyectará dinámicamente el formulario -->
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalRuedas" tabindex="-1" aria-labelledby="ModalRuedasLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #000020;">
                <h5 class="modal-title text-white" id="ModalRuedasLabel">Diagnóstico: Ruedas</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="contenidoRuedas">
                <!-- Aquí se inyectará dinámicamente el formulario -->
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalLuces" tabindex="-1" aria-labelledby="ModalLucesLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #000020;">
                <h5 class="modal-title text-white" id="ModalLucesLabel">Diagnóstico: Luces y Alarmas </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="contenidoLuces">
                <!-- Aquí se inyectará dinámicamente el formulario -->
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalAditamentos" tabindex="-1" aria-labelledby="ModalAditamentosLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #000020;">
                <h5 class="modal-title text-white" id="ModalAditamentosLabel">Diagnóstico: Aditamentos</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="contenidoAditamentos">
                <!-- Aquí se inyectará dinámicamente el formulario -->
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalCargador" tabindex="-1" aria-labelledby="ModalCargadorLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #000020;">
                <h5 class="modal-title text-white" id="ModalCargadorLabel">Diagnóstico: Cargador</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="contenidoCargador">
                <!-- Aquí se inyectará dinámicamente el formulario -->
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalRevision" tabindex="-1" aria-labelledby="ModalRevisionLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #000020;">
                <h5 class="modal-title text-white" id="ModalRevisionLabel">Diagnóstico: Revision de Equipo</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="contenidoRevision">
                <!-- Aquí se inyectará dinámicamente el formulario -->
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalAuxiliares" tabindex="-1" aria-labelledby="ModalAuxiliaresLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #000020;">
                <h5 class="modal-title text-white" id="ModalAuxiliaresLabel">Diagnóstico: Sistema De Funciones Auxiliares</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="contenidoAuxiliares">
                <!-- Aquí se inyectará dinámicamente el formulario -->
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalSuspension" tabindex="-1" aria-labelledby="ModalSuspensionLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #000020;">
                <h5 class="modal-title text-white" id="ModalSuspensionLabel">Diagnóstico: Sistema de Suspensión</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="contenidoSuspension">
                <!-- Aquí se inyectará dinámicamente el formulario -->
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalPantografo" tabindex="-1" aria-labelledby="ModalPantografoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #000020;">
                <h5 class="modal-title text-white" id="ModalPantografoLabel">Diagnóstico: Pantógrafo</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="contenidoPantografo">
                <!-- Aquí se inyectará dinámicamente el formulario -->
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalMotor" tabindex="-1" aria-labelledby="ModalMotorLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #000020;">
                <h5 class="modal-title text-white" id="ModalMotorLabel">Diagnóstico: Motor</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="contenidoMotor">
                <!-- Aquí se inyectará dinámicamente el formulario -->
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalRefrigeracion" tabindex="-1" aria-labelledby="ModalRefrigeracionLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #000020;">
                <h5 class="modal-title text-white" id="ModalRefrigeracionLabel">Diagnóstico: Sistema De Refrigeración</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="contenidoRefrigeracion">
                <!-- Aquí se inyectará dinámicamente el formulario -->
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalCombustion" tabindex="-1" aria-labelledby="ModalCombustionLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #000020;">
                <h5 class="modal-title text-white" id="ModalCombustionLabel">Diagnóstico: Sistema De Combustion</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="contenidoCombustion">
                <!-- Aquí se inyectará dinámicamente el formulario -->
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalTransmision" tabindex="-1" aria-labelledby="ModalTransmisionLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #000020;">
                <h5 class="modal-title text-white" id="ModalTransmisionLabel">Diagnóstico: Transmisión</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="contenidoTransmision">
                <!-- Aquí se inyectará dinámicamente el formulario -->
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalCaja" tabindex="-1" aria-labelledby="ModalCajaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #000020;">
                <h5 class="modal-title text-white" id="ModalCajaLabel">Diagnóstico: Caja Automática</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="contenidoCaja">
                <!-- Aquí se inyectará dinámicamente el formulario -->
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalComponentes" tabindex="-1" aria-labelledby="ModalComponentesLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #000020;">
                <h5 class="modal-title text-white" id="ModalComponentesLabel">Diagnóstico: Componentes Estructurales</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="contenidoComponentes">
                <!-- Aquí se inyectará dinámicamente el formulario -->
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalAusencia" tabindex="-1" aria-labelledby="ModalAusenciaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #000020;">
                <h5 class="modal-title text-white" id="ModalAusenciaLabel">Diagnóstico: Ausencia De Piezas O Componentes</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="contenidoAusencia">
                <!-- Aquí se inyectará dinámicamente el formulario -->
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalRevisiones" tabindex="-1" aria-labelledby="ModalAusenciaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #000020;">
                <h5 class="modal-title text-white" id="ModalRevisionesLabel">Diagnóstico: Revisiones De Operación</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="contenidoRevisiones">
                <!-- Aquí se inyectará dinámicamente el formulario -->
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalFuncionamiento" tabindex="-1" aria-labelledby="ModalFuncionamientoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #000020;">
                <h5 class="modal-title text-white" id="ModalFuncionamientoLabel">Diagnóstico: Funcionamiento General</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="contenidoFuncionamiento">
                <!-- Aquí se inyectará dinámicamente el formulario -->
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalCorreas" tabindex="-1" aria-labelledby="ModalCorreasLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #000020;">
                <h5 class="modal-title text-white" id="ModalCorreasLabel">Diagnóstico: Correas Y Cadenas</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="contenidoCorreas">
                <!-- Aquí se inyectará dinámicamente el formulario -->
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalUnidad" tabindex="-1" aria-labelledby="ModalUnidadLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #000020;">
                <h5 class="modal-title text-white" id="ModalUnidadLabel">Diagnóstico: Unidad De Tracción</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="contenidoUnidad">
                <!-- Aquí se inyectará dinámicamente el formulario -->
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalPanel" tabindex="-1" aria-labelledby="ModalPanelLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #000020;">
                <h5 class="modal-title text-white" id="ModalPanelLabel">Diagnóstico: Panel De Controles</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="contenidoPanel">
                <!-- Aquí se inyectará dinámicamente el formulario -->
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalPintura" tabindex="-1" aria-labelledby="ModalPinturaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #000020;">
                <h5 class="modal-title text-white" id="ModalPinturaLabel">Diagnóstico: Estado de pintura</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="contenidoPintura">
                <!-- Aquí se inyectará dinámicamente el formulario -->
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalPintura1" tabindex="-1" aria-labelledby="ModalPintura1Label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #000020;">
                <h5 class="modal-title text-white" id="ModalPintura1Label">Diagnóstico: Estado de pintura</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="contenidoPintura1">
                <!-- Aquí se inyectará dinámicamente el formulario -->
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL SECUNDARIO: TRABAJOS GUARDADOS -->
<div class="modal fade" id="ModalTrabajos" tabindex="-1" aria-labelledby="ModalTrabajosLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #000020;">
                <h5 class="modal-title text-white" id="ModalTrabajosLabel">Trabajos registrados</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Sección</th>
                            <th>Criterio</th>
                            <th>Tipo</th>
                            <th>Descripción</th>
                            <!-- <th>Eliminar</th> -->
                        </tr>
                    </thead>
                    <tbody id="tablaTrabajosBody">
                        <!-- JS inserta aquí -->
                    </tbody>
                    <!-- <thead class="table-light">
                        <tr>
                            <th>Sección</th>
                            <th>Criterio</th>
                            <th>Tipo</th>
                            <th>Descripción</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody id="tablaTrabajosBody">
                        JS inserta aquí
                    </tbody> -->
                </table>
            </div>
        </div>
    </div>
</div>

<!-- MODAL LIGHTBOX PARA IMÁGENES-->
<div id="lightbox" class="d-none position-fixed top-0 start-0 w-100 h-100 lightbox-bg">
    <div class="d-flex justify-content-center align-items-center h-100 px-3 position-relative">
        <button id="btnPrev" class="btn nav-btn position-absolute start-0"> ‹ </button>
        <img id="lightboxImg" class="img-fluid rounded shadow lightbox-img">
        <button id="btnNext" class="btn nav-btn position-absolute end-0"> › </button>
    </div>
    <button id="close" class="btn close-btn position-absolute top-0 end-0 m-4"> × </button>
</div>

<script>
    let Criterioscache = null; 
    let trabajosRealizados = []; 
    let imagenesPorSeccion = { 
        "Bateria": [], 
        "Electrico": [],
        "Traccion": [],
        "Frenos": [],
        "Direccion": [],
        "Hidraulico": [],
        "Mastil":[],
        "CarroPorta":[],
        "Lubricacion":[],
        "Horquillas":[],
        "Chasis":[],
        "Ruedas":[],
        "Luces":[],
        "Aditamentos":[],
        "Cargador":[],
        "Revision":[],
        "Auxiliares":[],
        "Suspension":[],
        "Pantografo":[],
        "Motor":[],
        "Refrigeracion":[],
        "Combustion":[],
        "Transmision":[],
        "Caja":[],
        "Componentes":[],
        "Ausencia":[],
        "Revisiones":[],
        "Funcionamiento":[],
        "Correas":[],
        "Unidad":[],
        "Panel":[],
        "Pintura":[]
    };

    // CARGAR CRITERIOS
    $('#agregarMantenimiento').on('show.bs.modal', function () { 
        if (!Criterioscache) cargarTodosLosCriterios(); 
    });

    function cargarTodosLosCriterios() { 
        $.ajax({ 
            url: "CriteriosMantenimientos", 
            dataType: "json", 
            success: function(data) { 
                Criterioscache = data; 
            } 
        }); 
    }

    // BOTÓNES DE CADA SECCIÓN
    $('#btnBateriaCard').on('click', function () { 
        const tipo = $('#hiddentipoMontacargas').val().trim().toLowerCase(); 
        cargarCriteriosBateria(tipo); 
    });

    $('#btnElectricoCard').on('click', function () { 
        const tipo = $('#hiddentipoMontacargas').val().trim().toLowerCase(); 
        cargarCriteriosElectrico(tipo); 
    });

    $('#btnTraccionCard').on('click', function () { 
        const tipo = $('#hiddentipoMontacargas').val().trim().toLowerCase(); 
        cargarCriteriosTraccion(tipo); 
    });

    $('#btnFrenosCard').on('click', function () { 
        const tipo = $('#hiddentipoMontacargas').val().trim().toLowerCase(); 
        cargarCriteriosFrenos(tipo); 
    });

    $('#btnDireccionCard').on('click', function () { 
        const tipo = $('#hiddentipoMontacargas').val().trim().toLowerCase(); 
        cargarCriteriosDireccion(tipo); 
    });

    $('#btnHidraulicoCard').on('click', function () { 
        const tipo = $('#hiddentipoMontacargas').val().trim().toLowerCase(); 
        cargarCriteriosHidraulico(tipo); 
    });

    $('#btnMastilCard').on('click', function () { 
        const tipo = $('#hiddentipoMontacargas').val().trim().toLowerCase(); 
        cargarCriteriosMastil(tipo); 
    });

    $('#btnCarroPortaCard').on('click', function () { 
        const tipo = $('#hiddentipoMontacargas').val().trim().toLowerCase(); 
        cargarCriteriosCarroPorta(tipo); 
    });

    $('#btnLubricacionCard').on('click', function () { 
        const tipo = $('#hiddentipoMontacargas').val().trim().toLowerCase(); 
        cargarCriteriosLubricacion(tipo); 
    });

    $('#btnHorquillasCard').on('click', function () { 
        const tipo = $('#hiddentipoMontacargas').val().trim().toLowerCase(); 
        cargarCriteriosHorquillas(tipo); 
    });

    $('#btnChasisCard').on('click', function () { 
        const tipo = $('#hiddentipoMontacargas').val().trim().toLowerCase(); 
        cargarCriteriosChasis(tipo); 
    });

    $('#btnRuedasCard').on('click', function () { 
        const tipo = $('#hiddentipoMontacargas').val().trim().toLowerCase(); 
        cargarCriteriosRuedas(tipo); 
    });

    $('#btnLucesCard').on('click', function () { 
        const tipo = $('#hiddentipoMontacargas').val().trim().toLowerCase(); 
        cargarCriteriosLuces(tipo); 
    });

    $('#btnAditamentosCard').on('click', function () { 
        const tipo = $('#hiddentipoMontacargas').val().trim().toLowerCase(); 
        cargarCriteriosAditamentos(tipo); 
    });

    $('#btnCargadorCard').on('click', function () { 
        const tipo = $('#hiddentipoMontacargas').val().trim().toLowerCase(); 
        cargarCriteriosCargador(tipo); 
    });

    $('#btnRevisionCard').on('click', function () { 
        const tipo = $('#hiddentipoMontacargas').val().trim().toLowerCase(); 
        cargarCriteriosRevision(tipo); 
    });

    $('#btnAuxiliaresCard').on('click', function () { 
        const tipo = $('#hiddentipoMontacargas').val().trim().toLowerCase(); 
        cargarCriteriosAuxiliares(tipo); 
    });

    $('#btnSuspensionCard').on('click', function () { 
        const tipo = $('#hiddentipoMontacargas').val().trim().toLowerCase(); 
        cargarCriteriosSuspension(tipo); 
    });

    $('#btnPantografoCard').on('click', function () { 
        const tipo = $('#hiddentipoMontacargas').val().trim().toLowerCase(); 
        cargarCriteriosPantografo(tipo); 
    });

    $('#btnMotorCard').on('click', function () { 
        const tipo = $('#hiddentipoMontacargas').val().trim().toLowerCase(); 
        cargarCriteriosMotor(tipo); 
    });

    $('#btnRefrigeracionCard').on('click', function () { 
        const tipo = $('#hiddentipoMontacargas').val().trim().toLowerCase(); 
        cargarCriteriosRefrigeracion(tipo); 
    });

    $('#btnCombustionCard').on('click', function () { 
        const tipo = $('#hiddentipoMontacargas').val().trim().toLowerCase(); 
        cargarCriteriosCombustion(tipo); 
    });

    $('#btnTransmisionCard').on('click', function () { 
        const tipo = $('#hiddentipoMontacargas').val().trim().toLowerCase(); 
        cargarCriteriosTransmision(tipo); 
    });

    $('#btnCajaCard').on('click', function () { 
        const tipo = $('#hiddentipoMontacargas').val().trim().toLowerCase(); 
        cargarCriteriosCaja(tipo); 
    });

    $('#btnComponentesCard').on('click', function () { 
        const tipo = $('#hiddentipoMontacargas').val().trim().toLowerCase(); 
        cargarCriteriosComponentes(tipo); 
    });

    $('#btnAusenciaCard').on('click', function () { 
        const tipo = $('#hiddentipoMontacargas').val().trim().toLowerCase(); 
        cargarCriteriosAusencia(tipo); 
    });

    $('#btnRevisionesCard').on('click', function () { 
        const tipo = $('#hiddentipoMontacargas').val().trim().toLowerCase(); 
        cargarCriteriosRevisiones(tipo); 
    });

    $('#btnFuncionamientoCard').on('click', function () { 
        const tipo = $('#hiddentipoMontacargas').val().trim().toLowerCase(); 
        cargarCriteriosFuncionamiento(tipo); 
    });

    $('#btnCorreasCard').on('click', function () { 
        const tipo = $('#hiddentipoMontacargas').val().trim().toLowerCase(); 
        cargarCriteriosCorreas(tipo); 
    });

    $('#btnUnidadCard').on('click', function () { 
        const tipo = $('#hiddentipoMontacargas').val().trim().toLowerCase(); 
        cargarCriteriosUnidad(tipo); 
    });

    $('#btnPanelCard').on('click', function () { 
        const tipo = $('#hiddentipoMontacargas').val().trim().toLowerCase(); 
        cargarCriteriosPanel(tipo); 
    });

    $('#btnPinturaCard').on('click', function () { 
        const tipo = $('#hiddentipoMontacargas').val().trim().toLowerCase(); 
        cargarCriteriosPintura(tipo); 
    });

    $('#btnPintura1Card').on('click', function () { 
        const tipo = $('#hiddentipoMontacargas').val().trim().toLowerCase(); 
        cargarCriteriosPintura1(tipo); 
    });

    // CARGAR FORMULARIO POR SECCIÓN
    function cargarCriteriosBateria(tipo) { 
        if (!Criterioscache) { 
            $('#contenidoBateria').html('<div class="text-center"><div class="spinner-border text-primary"></div><p>Cargando criterios...</p></div>'); 
            setTimeout(() => cargarCriteriosBateria(tipo), 400); 
            return; 
        }
        const criterios = Criterioscache.Bateria?.[tipo] || [];
        let html = "";

        criterios.forEach((item) => {
            const hiddenID = item.hidden;
            const num = hiddenID.split("_")[1];
            const tipoGuardado = $(`#hiddenCriterio_${num}`).val() || "";

            let descripcionGuardada = "";
            const trabajo = trabajosRealizados.find(t => t.criterio == num && t.seccion === "Bateria");
            if (trabajo) descripcionGuardada = trabajo.descripcion;

            if (item.id.includes("N_Bateria")) {
                const N_Bateria_Guardada = $("#hiddenN_Bateria").val() || "";

                html += `
                <div class="mb-3">
                    <label class="form-label">${item.label}</label>
                    <input type="text" class="form-control" id="input_N_Bateria"
                        placeholder="Ingrese # de bateria..."
                        value="${N_Bateria_Guardada}">
                </div>`;
            }else{
                // RESTO DE CRITERIOS: MANTIENE TODA LA LÓGICA ORIGINAL
                html += `
                <div class="mb-3">
                    <label class="form-label">${item.label}</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select me-2 criterio" data-num="${num}" required>
                            <option value="Seleccione">Seleccione</option>
                            <option value="Conforme"    ${tipoGuardado === "Conforme" ? "selected" : ""}>Conforme</option>
                            <option value="Nivelacion"  ${tipoGuardado === "Nivelacion" ? "selected" : ""}>Nivelación</option>
                            <option value="Ajuste"      ${tipoGuardado === "Ajuste" ? "selected" : ""}>Ajuste</option>
                            <option value="Reparar"     ${tipoGuardado === "Reparar" ? "selected" : ""}>Reparación</option>
                            <option value="Lubricacion" ${tipoGuardado === "Lubricacion" ? "selected" : ""}>Lubricación y Engrase</option>
                            <option value="NoAplica"    ${tipoGuardado === "NoAplica" ? "selected" : ""}>No aplica</option>
                        </select>
                        <span class="estado-icon"></span>
                    </div>

                    <input type="text" class="form-control mt-2 descripcionTrabajo"
                        placeholder="Describa el trabajo realizado..."
                        value="${descripcionGuardada}"
                        style="display: ${["Conforme","NoAplica","Seleccione"].includes(tipoGuardado) ? "none" : "block"};">
                </div>`;
            }  
        });

        html += `
        <div class="mt-3">
            <label class="form-label fw-bold">📷 Subir Imagenes de Diagnostico</label>
            
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-sm btn-primary" id="btnAgregarImagenBateria">
                    ➕ Tomar / Cargar Fotos
                </button>
            </div>

            <div id="galeriaBateria" class="mt-2 d-flex flex-wrap gap-2"></div>
        </div>`;

        html += `
        <div class="modal-footer">
            <button id="btnGuardarTrabajoBateria" type="button" 
                    class="btn text-white" style="background-color: #000020;">
                Guardar Diagnóstico
            </button>
        </div>`;

        $('#contenidoBateria').html(html);
        $(".criterio").trigger("change");
        renderGaleria("Bateria");
    }

    function cargarCriteriosElectrico(tipo) {
        if (!Criterioscache) {
            $('#contenidoElectrico').html('<div class="text-center"><div class="spinner-border text-primary"></div><p>Cargando criterios...</p></div>');
            setTimeout(() => cargarCriteriosElectrico(tipo), 400);
            return;
        }

        const criterios = Criterioscache.Electrico?.[tipo] || [];
        let html = "";

        criterios.forEach((item) => {
            const hiddenID = item.hidden;
            const num = hiddenID.split("_")[1];
            const tipoGuardado = $(`#hiddenCriterio_${num}`).val() || "";

            let descripcionGuardada = "";
            const trabajo = trabajosRealizados.find(t => t.criterio == num && t.seccion === "Electrico");
            if (trabajo) descripcionGuardada = trabajo.descripcion;

            html += `
            <div class="mb-3">
                <label class="form-label">${item.label}</label>
                <div class="d-flex align-items-center">
                    <select class="form-select me-2 criterio" data-num="${num}" required>
                        <option value="Seleccione">Seleccione</option>
                        <option value="Conforme"    ${tipoGuardado === "Conforme" ? "selected" : ""}>Conforme</option>
                        <option value="Nivelacion"  ${tipoGuardado === "Nivelacion" ? "selected" : ""}>Nivelación</option>
                        <option value="Ajuste"      ${tipoGuardado === "Ajuste" ? "selected" : ""}>Ajuste</option>
                        <option value="Reparar"     ${tipoGuardado === "Reparar" ? "selected" : ""}>Reparación</option>
                        <option value="Lubricacion" ${tipoGuardado === "Lubricacion" ? "selected" : ""}>Lubricación y Engrase</option>
                        <option value="NoAplica"    ${tipoGuardado === "NoAplica" ? "selected" : ""}>No aplica</option>
                    </select>
                    <span class="estado-icon"></span>
                </div>

                <input type="text" class="form-control mt-2 descripcionTrabajo"
                    placeholder="Describa el trabajo realizado..."
                    value="${descripcionGuardada}"
                    style="display: ${["Conforme","NoAplica","Seleccione"].includes(tipoGuardado) ? "none" : "block"};">
            </div>`;
        });

        html += `
        <div class="mt-3">
            <label class="form-label fw-bold">📷 Subir Imagenes de Diagnostico</label>
            
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-sm btn-primary" id="btnAgregarImagenElectrico">
                    ➕ Tomar / Cargar Fotos
                </button>
            </div>

            <div id="galeriaElectrico" class="mt-2 d-flex flex-wrap gap-2"></div>
        </div>`;

        html += `
        <div class="modal-footer">
            <button id="btnGuardarTrabajoElectrico" type="button" 
                    class="btn text-white" style="background-color: #000020;">
                Guardar Diagnóstico
            </button>
        </div>`;

        $('#contenidoElectrico').html(html);
        $(".criterio").trigger("change");
        renderGaleria("Electrico");
    }
    
    function cargarCriteriosTraccion(tipo) {
        if (!Criterioscache) {
            $('#contenidoTraccion').html('<div class="text-center"><div class="spinner-border text-primary"></div><p>Cargando criterios...</p></div>');
            setTimeout(() => cargarCriteriosTraccion(tipo), 400);
            return;
        }

        const criterios = Criterioscache.Traccion?.[tipo] || [];
        let html = "";

        criterios.forEach((item) => {
            const hiddenID = item.hidden;
            const num = hiddenID.split("_")[1];
            const tipoGuardado = $(`#hiddenCriterio_${num}`).val() || "";

            let descripcionGuardada = "";
            const trabajo = trabajosRealizados.find(t => t.criterio == num && t.seccion === "Traccion");
            if (trabajo) descripcionGuardada = trabajo.descripcion;

            html += `
            <div class="mb-3">
                <label class="form-label">${item.label}</label>
                <div class="d-flex align-items-center">
                    <select class="form-select me-2 criterio" data-num="${num}" required>
                        <option value="Seleccione">Seleccione</option>
                        <option value="Conforme"    ${tipoGuardado === "Conforme" ? "selected" : ""}>Conforme</option>
                        <option value="Nivelacion"  ${tipoGuardado === "Nivelacion" ? "selected" : ""}>Nivelación</option>
                        <option value="Ajuste"      ${tipoGuardado === "Ajuste" ? "selected" : ""}>Ajuste</option>
                        <option value="Reparar"     ${tipoGuardado === "Reparar" ? "selected" : ""}>Reparación</option>
                        <option value="Lubricacion" ${tipoGuardado === "Lubricacion" ? "selected" : ""}>Lubricación y Engrase</option>
                        <option value="NoAplica"    ${tipoGuardado === "NoAplica" ? "selected" : ""}>No aplica</option>
                    </select>
                    <span class="estado-icon"></span>
                </div>

                <input type="text" class="form-control mt-2 descripcionTrabajo"
                    placeholder="Describa el trabajo realizado..."
                    value="${descripcionGuardada}"
                    style="display: ${["Conforme","NoAplica","Seleccione"].includes(tipoGuardado) ? "none" : "block"};">
            </div>`;
        });

        html += `
        <div class="mt-3">
            <label class="form-label fw-bold">📷 Subir Imagenes de Diagnostico</label>
            
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-sm btn-primary" id="btnAgregarImagenTraccion">
                    ➕ Tomar / Cargar Fotos
                </button>
            </div>

            <div id="galeriaTraccion" class="mt-2 d-flex flex-wrap gap-2"></div>
        </div>`;

        html += `
        <div class="modal-footer">
            <button id="btnGuardarTrabajoTraccion" type="button" 
                    class="btn text-white" style="background-color: #000020;">
                Guardar Diagnóstico
            </button>
        </div>`;

        $('#contenidoTraccion').html(html);
        $(".criterio").trigger("change");
        renderGaleria("Traccion");
    }

    function cargarCriteriosFrenos(tipo) {
        if (!Criterioscache) {
            $('#contenidoFrenos').html('<div class="text-center"><div class="spinner-border text-primary"></div><p>Cargando criterios...</p></div>');
            setTimeout(() => cargarCriteriosFrenos(tipo), 400);
            return;
        }

        const criterios = Criterioscache.Frenos?.[tipo] || [];
        let html = "";

        criterios.forEach((item) => {
            const hiddenID = item.hidden;
            const num = hiddenID.split("_")[1];
            const tipoGuardado = $(`#hiddenCriterio_${num}`).val() || "";

            let descripcionGuardada = "";
            const trabajo = trabajosRealizados.find(t => t.criterio == num && t.seccion === "Frenos");
            if (trabajo) descripcionGuardada = trabajo.descripcion;

            html += `
            <div class="mb-3">
                <label class="form-label">${item.label}</label>
                <div class="d-flex align-items-center">
                    <select class="form-select me-2 criterio" data-num="${num}" required>
                        <option value="Seleccione">Seleccione</option>
                        <option value="Conforme"    ${tipoGuardado === "Conforme" ? "selected" : ""}>Conforme</option>
                        <option value="Nivelacion"  ${tipoGuardado === "Nivelacion" ? "selected" : ""}>Nivelación</option>
                        <option value="Ajuste"      ${tipoGuardado === "Ajuste" ? "selected" : ""}>Ajuste</option>
                        <option value="Reparar"     ${tipoGuardado === "Reparar" ? "selected" : ""}>Reparación</option>
                        <option value="Lubricacion" ${tipoGuardado === "Lubricacion" ? "selected" : ""}>Lubricación y Engrase</option>
                        <option value="NoAplica"    ${tipoGuardado === "NoAplica" ? "selected" : ""}>No aplica</option>
                    </select>
                    <span class="estado-icon"></span>
                </div>

                <input type="text" class="form-control mt-2 descripcionTrabajo"
                    placeholder="Describa el trabajo realizado..."
                    value="${descripcionGuardada}"
                    style="display: ${["Conforme","NoAplica","Seleccione"].includes(tipoGuardado) ? "none" : "block"};">
            </div>`;
        });

        html += `
        <div class="mt-3">
            <label class="form-label fw-bold">📷 Subir Imagenes de Diagnostico</label>
            
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-sm btn-primary" id="btnAgregarImagenFrenos">
                    ➕ Tomar / Cargar Fotos
                </button>
            </div>

            <div id="galeriaFrenos" class="mt-2 d-flex flex-wrap gap-2"></div>
        </div>`;

        html += `
        <div class="modal-footer">
            <button id="btnGuardarTrabajoFrenos" type="button" 
                    class="btn text-white" style="background-color: #000020;">
                Guardar Diagnóstico
            </button>
        </div>`;

        $('#contenidoFrenos').html(html);
        $(".criterio").trigger("change");
        renderGaleria("Frenos");
    }

    function cargarCriteriosDireccion(tipo) {
        if (!Criterioscache) {
            $('#contenidoDireccion').html('<div class="text-center"><div class="spinner-border text-primary"></div><p>Cargando criterios...</p></div>');
            setTimeout(() => cargarCriteriosDireccion(tipo), 400);
            return;
        }

        const criterios = Criterioscache.Direccion?.[tipo] || [];
        let html = "";

        criterios.forEach((item) => {
            const hiddenID = item.hidden;
            const num = hiddenID.split("_")[1];
            const tipoGuardado = $(`#hiddenCriterio_${num}`).val() || "";

            let descripcionGuardada = "";
            const trabajo = trabajosRealizados.find(t => t.criterio == num && t.seccion === "Direccion");
            if (trabajo) descripcionGuardada = trabajo.descripcion;

            html += `
            <div class="mb-3">
                <label class="form-label">${item.label}</label>
                <div class="d-flex align-items-center">
                    <select class="form-select me-2 criterio" data-num="${num}" required>
                        <option value="Seleccione">Seleccione</option>
                        <option value="Conforme"    ${tipoGuardado === "Conforme" ? "selected" : ""}>Conforme</option>
                        <option value="Nivelacion"  ${tipoGuardado === "Nivelacion" ? "selected" : ""}>Nivelación</option>
                        <option value="Ajuste"      ${tipoGuardado === "Ajuste" ? "selected" : ""}>Ajuste</option>
                        <option value="Reparar"     ${tipoGuardado === "Reparar" ? "selected" : ""}>Reparación</option>
                        <option value="Lubricacion" ${tipoGuardado === "Lubricacion" ? "selected" : ""}>Lubricación y Engrase</option>
                        <option value="NoAplica"    ${tipoGuardado === "NoAplica" ? "selected" : ""}>No aplica</option>
                    </select>
                    <span class="estado-icon"></span>
                </div>

                <input type="text" class="form-control mt-2 descripcionTrabajo"
                    placeholder="Describa el trabajo realizado..."
                    value="${descripcionGuardada}"
                    style="display: ${["Conforme","NoAplica","Seleccione"].includes(tipoGuardado) ? "none" : "block"};">
            </div>`;
        });

        html += `
        <div class="mt-3">
            <label class="form-label fw-bold">📷 Subir Imagenes de Diagnostico</label>
            
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-sm btn-primary" id="btnAgregarImagenDireccion">
                    ➕ Tomar / Cargar Fotos
                </button>
            </div>

            <div id="galeriaDireccion" class="mt-2 d-flex flex-wrap gap-2"></div>
        </div>`;

        html += `
        <div class="modal-footer">
            <button id="btnGuardarTrabajoDireccion" type="button" 
                    class="btn text-white" style="background-color: #000020;">
                Guardar Diagnóstico
            </button>
        </div>`;

        $('#contenidoDireccion').html(html);
        $(".criterio").trigger("change");
        renderGaleria("Direccion");
    }

    function cargarCriteriosHidraulico(tipo) {
        if (!Criterioscache) {
            $('#contenidoHidraulico').html('<div class="text-center"><div class="spinner-border text-primary"></div><p>Cargando criterios...</p></div>');
            setTimeout(() => cargarCriteriosHidraulico(tipo), 400);
            return;
        }

        const criterios = Criterioscache.Hidraulico?.[tipo] || [];
        let html = "";

        criterios.forEach((item) => {
            const hiddenID = item.hidden;
            const num = hiddenID.split("_")[1];
            const tipoGuardado = $(`#hiddenCriterio_${num}`).val() || "";

            let descripcionGuardada = "";
            const trabajo = trabajosRealizados.find(t => t.criterio == num && t.seccion === "Hidraulico");
            if (trabajo) descripcionGuardada = trabajo.descripcion;

            html += `
            <div class="mb-3">
                <label class="form-label">${item.label}</label>
                <div class="d-flex align-items-center">
                    <select class="form-select me-2 criterio" data-num="${num}" required>
                        <option value="Seleccione">Seleccione</option>
                        <option value="Conforme"    ${tipoGuardado === "Conforme" ? "selected" : ""}>Conforme</option>
                        <option value="Nivelacion"  ${tipoGuardado === "Nivelacion" ? "selected" : ""}>Nivelación</option>
                        <option value="Ajuste"      ${tipoGuardado === "Ajuste" ? "selected" : ""}>Ajuste</option>
                        <option value="Reparar"     ${tipoGuardado === "Reparar" ? "selected" : ""}>Reparación</option>
                        <option value="Lubricacion" ${tipoGuardado === "Lubricacion" ? "selected" : ""}>Lubricación y Engrase</option>
                        <option value="NoAplica"    ${tipoGuardado === "NoAplica" ? "selected" : ""}>No aplica</option>
                    </select>
                    <span class="estado-icon"></span>
                </div>

                <input type="text" class="form-control mt-2 descripcionTrabajo"
                    placeholder="Describa el trabajo realizado..."
                    value="${descripcionGuardada}"
                    style="display: ${["Conforme","NoAplica","Seleccione"].includes(tipoGuardado) ? "none" : "block"};">
            </div>`;
        });

        html += `
        <div class="mt-3">
            <label class="form-label fw-bold">📷 Subir Imagenes de Diagnostico</label>
            
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-sm btn-primary" id="btnAgregarImagenHidraulico">
                    ➕ Tomar / Cargar Fotos
                </button>
            </div>

            <div id="galeriaHidraulico" class="mt-2 d-flex flex-wrap gap-2"></div>
        </div>`;

        html += `
        <div class="modal-footer">
            <button id="btnGuardarTrabajoHidraulico" type="button" 
                    class="btn text-white" style="background-color: #000020;">
                Guardar Diagnóstico
            </button>
        </div>`;

        $('#contenidoHidraulico').html(html);
        $(".criterio").trigger("change");
        renderGaleria("Hidraulico");
    }

    function cargarCriteriosMastil(tipo) {
        if (!Criterioscache) {
            $('#contenidoMastil').html('<div class="text-center"><div class="spinner-border text-primary"></div><p>Cargando criterios...</p></div>');
            setTimeout(() => cargarCriteriosMastil(tipo), 400);
            return;
        }

        const criterios = Criterioscache.Mastil?.[tipo] || [];
        let html = "";

        criterios.forEach((item) => {
            const hiddenID = item.hidden;
            const num = hiddenID.split("_")[1];
            const tipoGuardado = $(`#hiddenCriterio_${num}`).val() || "";

            let descripcionGuardada = "";
            const trabajo = trabajosRealizados.find(t => t.criterio == num && t.seccion === "Mastil");
            if (trabajo) descripcionGuardada = trabajo.descripcion;

            html += `
            <div class="mb-3">
                <label class="form-label">${item.label}</label>
                <div class="d-flex align-items-center">
                    <select class="form-select me-2 criterio" data-num="${num}" required>
                        <option value="Seleccione">Seleccione</option>
                        <option value="Conforme"    ${tipoGuardado === "Conforme" ? "selected" : ""}>Conforme</option>
                        <option value="Nivelacion"  ${tipoGuardado === "Nivelacion" ? "selected" : ""}>Nivelación</option>
                        <option value="Ajuste"      ${tipoGuardado === "Ajuste" ? "selected" : ""}>Ajuste</option>
                        <option value="Reparar"     ${tipoGuardado === "Reparar" ? "selected" : ""}>Reparación</option>
                        <option value="Lubricacion" ${tipoGuardado === "Lubricacion" ? "selected" : ""}>Lubricación y Engrase</option>
                        <option value="NoAplica"    ${tipoGuardado === "NoAplica" ? "selected" : ""}>No aplica</option>
                    </select>
                    <span class="estado-icon"></span>
                </div>

                <input type="text" class="form-control mt-2 descripcionTrabajo"
                    placeholder="Describa el trabajo realizado..."
                    value="${descripcionGuardada}"
                    style="display: ${["Conforme","NoAplica","Seleccione"].includes(tipoGuardado) ? "none" : "block"};">
            </div>`;
        });

        html += `
        <div class="mt-3">
            <label class="form-label fw-bold">📷 Subir Imagenes de Diagnostico</label>
            
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-sm btn-primary" id="btnAgregarImagenMastil">
                    ➕ Tomar / Cargar Fotos
                </button>
            </div>

            <div id="galeriaMastil" class="mt-2 d-flex flex-wrap gap-2"></div>
        </div>`;

        html += `
        <div class="modal-footer">
            <button id="btnGuardarTrabajoMastil" type="button" 
                    class="btn text-white" style="background-color: #000020;">
                Guardar Diagnóstico
            </button>
        </div>`;

        $('#contenidoMastil').html(html);
        $(".criterio").trigger("change");
        renderGaleria("Mastil");
    }

    function cargarCriteriosCarroPorta(tipo) {
        if (!Criterioscache) {
            $('#contenidoCarroPorta').html('<div class="text-center"><div class="spinner-border text-primary"></div><p>Cargando criterios...</p></div>');
            setTimeout(() => cargarCriteriosCarroPorta(tipo), 400);
            return;
        }

        const criterios = Criterioscache.CarroPorta?.[tipo] || [];
        let html = "";

        criterios.forEach((item) => {
            const hiddenID = item.hidden;
            const num = hiddenID.split("_")[1];
            const tipoGuardado = $(`#hiddenCriterio_${num}`).val() || "";

            let descripcionGuardada = "";
            const trabajo = trabajosRealizados.find(t => t.criterio == num && t.seccion === "CarroPorta");
            if (trabajo) descripcionGuardada = trabajo.descripcion;

            html += `
            <div class="mb-3">
                <label class="form-label">${item.label}</label>
                <div class="d-flex align-items-center">
                    <select class="form-select me-2 criterio" data-num="${num}" required>
                        <option value="Seleccione">Seleccione</option>
                        <option value="Conforme"    ${tipoGuardado === "Conforme" ? "selected" : ""}>Conforme</option>
                        <option value="Nivelacion"  ${tipoGuardado === "Nivelacion" ? "selected" : ""}>Nivelación</option>
                        <option value="Ajuste"      ${tipoGuardado === "Ajuste" ? "selected" : ""}>Ajuste</option>
                        <option value="Reparar"     ${tipoGuardado === "Reparar" ? "selected" : ""}>Reparación</option>
                        <option value="Lubricacion" ${tipoGuardado === "Lubricacion" ? "selected" : ""}>Lubricación y Engrase</option>
                        <option value="NoAplica"    ${tipoGuardado === "NoAplica" ? "selected" : ""}>No aplica</option>
                    </select>
                    <span class="estado-icon"></span>
                </div>

                <input type="text" class="form-control mt-2 descripcionTrabajo"
                    placeholder="Describa el trabajo realizado..."
                    value="${descripcionGuardada}"
                    style="display: ${["Conforme","NoAplica","Seleccione"].includes(tipoGuardado) ? "none" : "block"};">
            </div>`;
        });

        html += `
        <div class="mt-3">
            <label class="form-label fw-bold">📷 Subir Imagenes de Diagnostico</label>
            
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-sm btn-primary" id="btnAgregarImagenCarroPorta">
                    ➕ Tomar / Cargar Fotos
                </button>
            </div>

            <div id="galeriaCarroPorta" class="mt-2 d-flex flex-wrap gap-2"></div>
        </div>`;

        html += `
        <div class="modal-footer">
            <button id="btnGuardarTrabajoCarroPorta" type="button" 
                    class="btn text-white" style="background-color: #000020;">
                Guardar Diagnóstico
            </button>
        </div>`;

        $('#contenidoCarroPorta').html(html);
        $(".criterio").trigger("change");
        renderGaleria("CarroPorta");
    }

    function cargarCriteriosLubricacion(tipo) {
        if (!Criterioscache) {
            $('#contenidoLubricacion').html('<div class="text-center"><div class="spinner-border text-primary"></div><p>Cargando criterios...</p></div>');
            setTimeout(() => cargarCriteriosLubricacion(tipo), 400);
            return;
        }

        const criterios = Criterioscache.Lubricacion?.[tipo] || [];
        let html = "";

        criterios.forEach((item) => {
            const hiddenID = item.hidden;
            const num = hiddenID.split("_")[1];
            const tipoGuardado = $(`#hiddenCriterio_${num}`).val() || "";

            let descripcionGuardada = "";
            const trabajo = trabajosRealizados.find(t => t.criterio == num && t.seccion === "Lubricacion");
            if (trabajo) descripcionGuardada = trabajo.descripcion;

            html += `
            <div class="mb-3">
                <label class="form-label">${item.label}</label>
                <div class="d-flex align-items-center">
                    <select class="form-select me-2 criterio" data-num="${num}" required>
                        <option value="Seleccione">Seleccione</option>
                        <option value="Conforme"    ${tipoGuardado === "Conforme" ? "selected" : ""}>Conforme</option>
                        <option value="Nivelacion"  ${tipoGuardado === "Nivelacion" ? "selected" : ""}>Nivelación</option>
                        <option value="Ajuste"      ${tipoGuardado === "Ajuste" ? "selected" : ""}>Ajuste</option>
                        <option value="Reparar"     ${tipoGuardado === "Reparar" ? "selected" : ""}>Reparación</option>
                        <option value="Lubricacion" ${tipoGuardado === "Lubricacion" ? "selected" : ""}>Lubricación y Engrase</option>
                        <option value="NoAplica"    ${tipoGuardado === "NoAplica" ? "selected" : ""}>No aplica</option>
                    </select>
                    <span class="estado-icon"></span>
                </div>

                <input type="text" class="form-control mt-2 descripcionTrabajo"
                    placeholder="Describa el trabajo realizado..."
                    value="${descripcionGuardada}"
                    style="display: ${["Conforme","NoAplica","Seleccione"].includes(tipoGuardado) ? "none" : "block"};">
            </div>`;
        });

        html += `
        <div class="mt-3">
            <label class="form-label fw-bold">📷 Subir Imagenes de Diagnostico</label>
            
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-sm btn-primary" id="btnAgregarImagenLubricacion">
                    ➕ Tomar / Cargar Fotos
                </button>
            </div>

            <div id="galeriaLubricacion" class="mt-2 d-flex flex-wrap gap-2"></div>
        </div>`;

        html += `
        <div class="modal-footer">
            <button id="btnGuardarTrabajoLubricacion" type="button" 
                    class="btn text-white" style="background-color: #000020;">
                Guardar Diagnóstico
            </button>
        </div>`;

        $('#contenidoLubricacion').html(html);
        $(".criterio").trigger("change");
        renderGaleria("Lubricacion");
    }

    function cargarCriteriosHorquillas(tipo) {
        if (!Criterioscache) {
            $('#contenidoHorquillas').html('<div class="text-center"><div class="spinner-border text-primary"></div><p>Cargando criterios...</p></div>');
            setTimeout(() => cargarCriteriosHorquillas(tipo), 400);
            return;
        }

        const criterios = Criterioscache.Horquillas?.[tipo] || [];
        let html = "";

        criterios.forEach((item) => {
            const hiddenID = item.hidden;
            const num = hiddenID.split("_")[1];
            const tipoGuardado = $(`#hiddenCriterio_${num}`).val() || "";

            let descripcionGuardada = "";
            const trabajo = trabajosRealizados.find(t => t.criterio == num && t.seccion === "Horquillas");
            if (trabajo) descripcionGuardada = trabajo.descripcion;

            // CASO ESPECIAL: CLASE DE HORQUILLAS
            if (item.id.includes("ClaseH")) {
                const claseGuardada = $("#hiddenClaseH").val() || "";

                html += `
                <div class="mb-3">
                    <label class="form-label">${item.label}</label>
                    <select class="form-select" id="selectClaseH">
                        <option value="">Seleccione</option>
                        <option value="Clase 2" ${claseGuardada === "Clase 2" ? "selected" : ""}>Clase 2</option>
                        <option value="Clase 3" ${claseGuardada === "Clase 3" ? "selected" : ""}>Clase 3</option>
                        <option value="Clase 4" ${claseGuardada === "Clase 4" ? "selected" : ""}>Clase 4</option>
                    </select>
                </div>`;

            // CASO ESPECIAL: LONGITUD DE HORQUILLAS
            } else if (item.id.includes("LongitudH")) {
                const longitudGuardada = $("#hiddenLongitudH").val() || "";

                html += `
                <div class="mb-3">
                    <label class="form-label">${item.label}</label>
                    <input type="text" class="form-control" id="${item.id}"
                        placeholder="Ingrese longitud en metros"
                        value="${longitudGuardada}">
                </div>`;
                // RESTO DE CRITERIOS: MANTIENE TODA LA LÓGICA ORIGINAL
            } else {
                html += `
                <div class="mb-3">
                    <label class="form-label">${item.label}</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select me-2 criterio" data-num="${num}" required>
                            <option value="Seleccione">Seleccione</option>
                            <option value="Conforme"    ${tipoGuardado === "Conforme" ? "selected" : ""}>Conforme</option>
                            <option value="Nivelacion"  ${tipoGuardado === "Nivelacion" ? "selected" : ""}>Nivelación</option>
                            <option value="Ajuste"      ${tipoGuardado === "Ajuste" ? "selected" : ""}>Ajuste</option>
                            <option value="Reparar"     ${tipoGuardado === "Reparar" ? "selected" : ""}>Reparación</option>
                            <option value="Lubricacion" ${tipoGuardado === "Lubricacion" ? "selected" : ""}>Lubricación y Engrase</option>
                            <option value="NoAplica"    ${tipoGuardado === "NoAplica" ? "selected" : ""}>No aplica</option>
                        </select>
                        <span class="estado-icon"></span>
                    </div>

                    <input type="text" class="form-control mt-2 descripcionTrabajo"
                        placeholder="Describa el trabajo realizado..."
                        value="${descripcionGuardada}"
                        style="display: ${["Conforme","NoAplica","Seleccione"].includes(tipoGuardado) ? "none" : "block"};">
                </div>`;
            }
        });

        // Imágenes y botón Guardar
        html += `
        <div class="mt-3">
            <label class="form-label fw-bold">📷 Subir Imagenes de Diagnóstico</label>
            
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-sm btn-primary" id="btnAgregarImagenHorquillas">
                    ➕ Tomar / Cargar Fotos
                </button>
            </div>

            <div id="galeriaHorquillas" class="mt-2 d-flex flex-wrap gap-2"></div>
        </div>

        <div class="modal-footer">
            <button id="btnGuardarTrabajoHorquillas" type="button" 
                    class="btn text-white" style="background-color: #000020;">
                Guardar Diagnóstico
            </button>
        </div>`;

        $('#contenidoHorquillas').html(html);

        $(".criterio").trigger("change");
        renderGaleria("Horquillas");
    }

    function cargarCriteriosChasis(tipo) {
        if (!Criterioscache) {
            $('#contenidoChasis').html('<div class="text-center"><div class="spinner-border text-primary"></div><p>Cargando criterios...</p></div>');
            setTimeout(() => cargarCriteriosChasis(tipo), 400);
            return;
        }

        const criterios = Criterioscache.Chasis?.[tipo] || [];
        let html = "";

        criterios.forEach((item) => {
            const hiddenID = item.hidden;
            const num = hiddenID.split("_")[1];
            const tipoGuardado = $(`#hiddenCriterio_${num}`).val() || "";

            let descripcionGuardada = "";
            const trabajo = trabajosRealizados.find(t => t.criterio == num && t.seccion === "Chasis");
            if (trabajo) descripcionGuardada = trabajo.descripcion;

            html += `
            <div class="mb-3">
                <label class="form-label">${item.label}</label>
                <div class="d-flex align-items-center">
                    <select class="form-select me-2 criterio" data-num="${num}" required>
                        <option value="Seleccione">Seleccione</option>
                        <option value="Conforme"    ${tipoGuardado === "Conforme" ? "selected" : ""}>Conforme</option>
                        <option value="Nivelacion"  ${tipoGuardado === "Nivelacion" ? "selected" : ""}>Nivelación</option>
                        <option value="Ajuste"      ${tipoGuardado === "Ajuste" ? "selected" : ""}>Ajuste</option>
                        <option value="Reparar"     ${tipoGuardado === "Reparar" ? "selected" : ""}>Reparación</option>
                        <option value="Lubricacion" ${tipoGuardado === "Lubricacion" ? "selected" : ""}>Lubricación y Engrase</option>
                        <option value="NoAplica"    ${tipoGuardado === "NoAplica" ? "selected" : ""}>No aplica</option>
                    </select>
                    <span class="estado-icon"></span>
                </div>

                <input type="text" class="form-control mt-2 descripcionTrabajo"
                    placeholder="Describa el trabajo realizado..."
                    value="${descripcionGuardada}"
                    style="display: ${["Conforme","NoAplica","Seleccione"].includes(tipoGuardado) ? "none" : "block"};">
            </div>`;
        });

        html += `
        <div class="mt-3">
            <label class="form-label fw-bold">📷 Subir Imagenes de Diagnostico</label>
            
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-sm btn-primary" id="btnAgregarImagenChasis">
                    ➕ Tomar / Cargar Fotos
                </button>
            </div>

            <div id="galeriaChasis" class="mt-2 d-flex flex-wrap gap-2"></div>
        </div>`;

        html += `
        <div class="modal-footer">
            <button id="btnGuardarTrabajoChasis" type="button" 
                    class="btn text-white" style="background-color: #000020;">
                Guardar Diagnóstico
            </button>
        </div>`;

        $('#contenidoChasis').html(html);
        $(".criterio").trigger("change");
        renderGaleria("Chasis");
    }

    function cargarCriteriosRuedas(tipo) {
        if (!Criterioscache) {
            $('#contenidoRuedas').html('<div class="text-center"><div class="spinner-border text-primary"></div><p>Cargando criterios...</p></div>');
            setTimeout(() => cargarCriteriosRuedas(tipo), 400);
            return;
        }

        const criterios = Criterioscache.Ruedas?.[tipo] || [];
        let html = "";

        criterios.forEach((item) => {
            const hiddenID = item.hidden;
            const num = hiddenID.split("_")[1];
            const tipoGuardado = $(`#hiddenCriterio_${num}`).val() || "";

            let descripcionGuardada = "";
            const trabajo = trabajosRealizados.find(t => t.criterio == num && t.seccion === "Ruedas");
            if (trabajo) descripcionGuardada = trabajo.descripcion;

            html += `
            <div class="mb-3">
                <label class="form-label">${item.label}</label>
                <div class="d-flex align-items-center">
                    <select class="form-select me-2 criterio" data-num="${num}" required>
                        <option value="Seleccione">Seleccione</option>
                        <option value="Conforme"    ${tipoGuardado === "Conforme" ? "selected" : ""}>Conforme</option>
                        <option value="Nivelacion"  ${tipoGuardado === "Nivelacion" ? "selected" : ""}>Nivelación</option>
                        <option value="Ajuste"      ${tipoGuardado === "Ajuste" ? "selected" : ""}>Ajuste</option>
                        <option value="Reparar"     ${tipoGuardado === "Reparar" ? "selected" : ""}>Reparación</option>
                        <option value="Lubricacion" ${tipoGuardado === "Lubricacion" ? "selected" : ""}>Lubricación y Engrase</option>
                        <option value="NoAplica"    ${tipoGuardado === "NoAplica" ? "selected" : ""}>No aplica</option>
                    </select>
                    <span class="estado-icon"></span>
                </div>

                <input type="text" class="form-control mt-2 descripcionTrabajo"
                    placeholder="Describa el trabajo realizado..."
                    value="${descripcionGuardada}"
                    style="display: ${["Conforme","NoAplica","Seleccione"].includes(tipoGuardado) ? "none" : "block"};">
            </div>`;
        });

        html += `
        <div class="mt-3">
            <label class="form-label fw-bold">📷 Subir Imagenes de Diagnostico</label>
            
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-sm btn-primary" id="btnAgregarImagenRuedas">
                    ➕ Tomar / Cargar Fotos
                </button>
            </div>

            <div id="galeriaRuedas" class="mt-2 d-flex flex-wrap gap-2"></div>
        </div>`;

        html += `
        <div class="modal-footer">
            <button id="btnGuardarTrabajoRuedas" type="button" 
                    class="btn text-white" style="background-color: #000020;">
                Guardar Diagnóstico
            </button>
        </div>`;

        $('#contenidoRuedas').html(html);
        $(".criterio").trigger("change");
        renderGaleria("Ruedas");
    }

    function cargarCriteriosLuces(tipo) {
        if (!Criterioscache) {
            $('#contenidoLuces').html('<div class="text-center"><div class="spinner-border text-primary"></div><p>Cargando criterios...</p></div>');
            setTimeout(() => cargarCriteriosLuces(tipo), 400);
            return;
        }

        const criterios = Criterioscache.Luces?.[tipo] || [];
        let html = "";

        criterios.forEach((item) => {
            const hiddenID = item.hidden;
            const num = hiddenID.split("_")[1];
            const tipoGuardado = $(`#hiddenCriterio_${num}`).val() || "";

            let descripcionGuardada = "";
            const trabajo = trabajosRealizados.find(t => t.criterio == num && t.seccion === "Luces");
            if (trabajo) descripcionGuardada = trabajo.descripcion;

            html += `
            <div class="mb-3">
                <label class="form-label">${item.label}</label>
                <div class="d-flex align-items-center">
                    <select class="form-select me-2 criterio" data-num="${num}" required>
                        <option value="Seleccione">Seleccione</option>
                        <option value="Conforme"    ${tipoGuardado === "Conforme" ? "selected" : ""}>Conforme</option>
                        <option value="Nivelacion"  ${tipoGuardado === "Nivelacion" ? "selected" : ""}>Nivelación</option>
                        <option value="Ajuste"      ${tipoGuardado === "Ajuste" ? "selected" : ""}>Ajuste</option>
                        <option value="Reparar"     ${tipoGuardado === "Reparar" ? "selected" : ""}>Reparación</option>
                        <option value="Lubricacion" ${tipoGuardado === "Lubricacion" ? "selected" : ""}>Lubricación y Engrase</option>
                        <option value="NoAplica"    ${tipoGuardado === "NoAplica" ? "selected" : ""}>No aplica</option>
                    </select>
                    <span class="estado-icon"></span>
                </div>

                <input type="text" class="form-control mt-2 descripcionTrabajo"
                    placeholder="Describa el trabajo realizado..."
                    value="${descripcionGuardada}"
                    style="display: ${["Conforme","NoAplica","Seleccione"].includes(tipoGuardado) ? "none" : "block"};">
            </div>`;
        });

        html += `
        <div class="mt-3">
            <label class="form-label fw-bold">📷 Subir Imagenes de Diagnostico</label>
            
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-sm btn-primary" id="btnAgregarImagenLuces">
                    ➕ Tomar / Cargar Fotos
                </button>
            </div>

            <div id="galeriaLuces" class="mt-2 d-flex flex-wrap gap-2"></div>
        </div>`;

        html += `
        <div class="modal-footer">
            <button id="btnGuardarTrabajoLuces" type="button" 
                    class="btn text-white" style="background-color: #000020;">
                Guardar Diagnóstico
            </button>
        </div>`;

        $('#contenidoLuces').html(html);
        $(".criterio").trigger("change");
        renderGaleria("Luces");
    }

    function cargarCriteriosAditamentos(tipo) {
        if (!Criterioscache) {
            $('#contenidoAditamentos').html('<div class="text-center"><div class="spinner-border text-primary"></div><p>Cargando criterios...</p></div>');
            setTimeout(() => cargarCriteriosAditamentos(tipo), 400);
            return;
        }

        const criterios = Criterioscache.Aditamentos?.[tipo] || [];
        let html = "";

        criterios.forEach((item) => {
            const hiddenID = item.hidden;
            const num = hiddenID.split("_")[1];
            const tipoGuardado = $(`#hiddenCriterio_${num}`).val() || "";

            let descripcionGuardada = "";
            const trabajo = trabajosRealizados.find(t => t.criterio == num && t.seccion === "Aditamentos");
            if (trabajo) descripcionGuardada = trabajo.descripcion;

            html += `
            <div class="mb-3">
                <label class="form-label">${item.label}</label>
                <div class="d-flex align-items-center">
                    <select class="form-select me-2 criterio" data-num="${num}" required>
                        <option value="Seleccione">Seleccione</option>
                        <option value="Conforme"    ${tipoGuardado === "Conforme" ? "selected" : ""}>Conforme</option>
                        <option value="Nivelacion"  ${tipoGuardado === "Nivelacion" ? "selected" : ""}>Nivelación</option>
                        <option value="Ajuste"      ${tipoGuardado === "Ajuste" ? "selected" : ""}>Ajuste</option>
                        <option value="Reparar"     ${tipoGuardado === "Reparar" ? "selected" : ""}>Reparación</option>
                        <option value="Lubricacion" ${tipoGuardado === "Lubricacion" ? "selected" : ""}>Lubricación y Engrase</option>
                        <option value="NoAplica"    ${tipoGuardado === "NoAplica" ? "selected" : ""}>No aplica</option>
                    </select>
                    <span class="estado-icon"></span>
                </div>

                <input type="text" class="form-control mt-2 descripcionTrabajo"
                    placeholder="Describa el trabajo realizado..."
                    value="${descripcionGuardada}"
                    style="display: ${["Conforme","NoAplica","Seleccione"].includes(tipoGuardado) ? "none" : "block"};">
            </div>`;
        });

        html += `
        <div class="mt-3">
            <label class="form-label fw-bold">📷 Subir Imagenes de Diagnostico</label>
            
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-sm btn-primary" id="btnAgregarImagenAditamentos">
                    ➕ Tomar / Cargar Fotos
                </button>
            </div>

            <div id="galeriaAditamentos" class="mt-2 d-flex flex-wrap gap-2"></div>
        </div>`;

        html += `
        <div class="modal-footer">
            <button id="btnGuardarTrabajoAditamentos" type="button" 
                    class="btn text-white" style="background-color: #000020;">
                Guardar Diagnóstico
            </button>
        </div>`;

        $('#contenidoAditamentos').html(html);
        $(".criterio").trigger("change");
        renderGaleria("Aditamentos");
    }

    function cargarCriteriosCargador(tipo) {
        if (!Criterioscache) {
            $('#contenidoCargador').html('<div class="text-center"><div class="spinner-border text-primary"></div><p>Cargando criterios...</p></div>');
            setTimeout(() => cargarCriteriosCargador(tipo), 400);
            return;
        }

        const criterios = Criterioscache.Cargador?.[tipo] || [];
        let html = "";

        criterios.forEach((item) => {
            const hiddenID = item.hidden;
            const num = hiddenID.split("_")[1];
            const tipoGuardado = $(`#hiddenCriterio_${num}`).val() || "";

            let descripcionGuardada = "";
            const trabajo = trabajosRealizados.find(t => t.criterio == num && t.seccion === "Cargador");
            if (trabajo) descripcionGuardada = trabajo.descripcion;

            html += `
            <div class="mb-3">
                <label class="form-label">${item.label}</label>
                <div class="d-flex align-items-center">
                    <select class="form-select me-2 criterio" data-num="${num}" required>
                        <option value="Seleccione">Seleccione</option>
                        <option value="Conforme"    ${tipoGuardado === "Conforme" ? "selected" : ""}>Conforme</option>
                        <option value="Nivelacion"  ${tipoGuardado === "Nivelacion" ? "selected" : ""}>Nivelación</option>
                        <option value="Ajuste"      ${tipoGuardado === "Ajuste" ? "selected" : ""}>Ajuste</option>
                        <option value="Reparar"     ${tipoGuardado === "Reparar" ? "selected" : ""}>Reparación</option>
                        <option value="Lubricacion" ${tipoGuardado === "Lubricacion" ? "selected" : ""}>Lubricación y Engrase</option>
                        <option value="NoAplica"    ${tipoGuardado === "NoAplica" ? "selected" : ""}>No aplica</option>
                    </select>
                    <span class="estado-icon"></span>
                </div>

                <input type="text" class="form-control mt-2 descripcionTrabajo"
                    placeholder="Describa el trabajo realizado..."
                    value="${descripcionGuardada}"
                    style="display: ${["Conforme","NoAplica","Seleccione"].includes(tipoGuardado) ? "none" : "block"};">
            </div>`;
        });

        html += `
        <div class="mt-3">
            <label class="form-label fw-bold">📷 Subir Imagenes de Diagnostico</label>
            
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-sm btn-primary" id="btnAgregarImagenCargador">
                    ➕ Tomar / Cargar Fotos
                </button>
            </div>

            <div id="galeriaCargador" class="mt-2 d-flex flex-wrap gap-2"></div>
        </div>`;

        html += `
        <div class="modal-footer">
            <button id="btnGuardarTrabajoCargador" type="button" 
                    class="btn text-white" style="background-color: #000020;">
                Guardar Diagnóstico
            </button>
        </div>`;

        $('#contenidoCargador').html(html);
        $(".criterio").trigger("change");
        renderGaleria("Cargador");
    }

    function cargarCriteriosRevision(tipo) {
        if (!Criterioscache) {
            $('#contenidoRevision').html('<div class="text-center"><div class="spinner-border text-primary"></div><p>Cargando criterios...</p></div>');
            setTimeout(() => cargarCriteriosRevision(tipo), 400);
            return;
        }

        const criterios = Criterioscache.Revision?.[tipo] || [];
        let html = "";

        criterios.forEach((item) => {
            const hiddenID = item.hidden;
            const num = hiddenID.split("_")[1];
            const tipoGuardado = $(`#hiddenCriterio_${num}`).val() || "";

            let descripcionGuardada = "";
            const trabajo = trabajosRealizados.find(t => t.criterio == num && t.seccion === "Revision");
            if (trabajo) descripcionGuardada = trabajo.descripcion;

            html += `
            <div class="mb-3">
                <label class="form-label">${item.label}</label>
                <div class="d-flex align-items-center">
                    <select class="form-select me-2 criterio" data-num="${num}" required>
                        <option value="Seleccione">Seleccione</option>
                        <option value="Conforme"    ${tipoGuardado === "Conforme" ? "selected" : ""}>Conforme</option>
                        <option value="Nivelacion"  ${tipoGuardado === "Nivelacion" ? "selected" : ""}>Nivelación</option>
                        <option value="Ajuste"      ${tipoGuardado === "Ajuste" ? "selected" : ""}>Ajuste</option>
                        <option value="Reparar"     ${tipoGuardado === "Reparar" ? "selected" : ""}>Reparación</option>
                        <option value="Lubricacion" ${tipoGuardado === "Lubricacion" ? "selected" : ""}>Lubricación y Engrase</option>
                        <option value="NoAplica"    ${tipoGuardado === "NoAplica" ? "selected" : ""}>No aplica</option>
                    </select>
                    <span class="estado-icon"></span>
                </div>

                <input type="text" class="form-control mt-2 descripcionTrabajo"
                    placeholder="Describa el trabajo realizado..."
                    value="${descripcionGuardada}"
                    style="display: ${["Conforme","NoAplica","Seleccione"].includes(tipoGuardado) ? "none" : "block"};">
            </div>`;
        });

        html += `
        <div class="mt-3">
            <label class="form-label fw-bold">📷 Subir Imagenes de Diagnostico</label>
            
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-sm btn-primary" id="btnAgregarImagenRevision">
                    ➕ Tomar / Cargar Fotos
                </button>
            </div>

            <div id="galeriaRevision" class="mt-2 d-flex flex-wrap gap-2"></div>
        </div>`;

        html += `
        <div class="modal-footer">
            <button id="btnGuardarTrabajoRevision" type="button" 
                    class="btn text-white" style="background-color: #000020;">
                Guardar Diagnóstico
            </button>
        </div>`;

        $('#contenidoRevision').html(html);
        $(".criterio").trigger("change");
        renderGaleria("Revision");
    }

    function cargarCriteriosAuxiliares(tipo) {
        if (!Criterioscache) {
            $('#contenidoAuxiliares').html('<div class="text-center"><div class="spinner-border text-primary"></div><p>Cargando criterios...</p></div>');
            setTimeout(() => cargarCriteriosAuxiliares(tipo), 400);
            return;
        }

        const criterios = Criterioscache.Auxiliares?.[tipo] || [];
        let html = "";

        criterios.forEach((item) => {
            const hiddenID = item.hidden;
            const num = hiddenID.split("_")[1];
            const tipoGuardado = $(`#hiddenCriterio_${num}`).val() || "";

            let descripcionGuardada = "";
            const trabajo = trabajosRealizados.find(t => t.criterio == num && t.seccion === "Auxiliares");
            if (trabajo) descripcionGuardada = trabajo.descripcion;

            html += `
            <div class="mb-3">
                <label class="form-label">${item.label}</label>
                <div class="d-flex align-items-center">
                    <select class="form-select me-2 criterio" data-num="${num}" required>
                        <option value="Seleccione">Seleccione</option>
                        <option value="Conforme"    ${tipoGuardado === "Conforme" ? "selected" : ""}>Conforme</option>
                        <option value="Nivelacion"  ${tipoGuardado === "Nivelacion" ? "selected" : ""}>Nivelación</option>
                        <option value="Ajuste"      ${tipoGuardado === "Ajuste" ? "selected" : ""}>Ajuste</option>
                        <option value="Reparar"     ${tipoGuardado === "Reparar" ? "selected" : ""}>Reparación</option>
                        <option value="Lubricacion" ${tipoGuardado === "Lubricacion" ? "selected" : ""}>Lubricación y Engrase</option>
                        <option value="NoAplica"    ${tipoGuardado === "NoAplica" ? "selected" : ""}>No aplica</option>
                    </select>
                    <span class="estado-icon"></span>
                </div>

                <input type="text" class="form-control mt-2 descripcionTrabajo"
                    placeholder="Describa el trabajo realizado..."
                    value="${descripcionGuardada}"
                    style="display: ${["Conforme","NoAplica","Seleccione"].includes(tipoGuardado) ? "none" : "block"};">
            </div>`;
        });

        html += `
        <div class="mt-3">
            <label class="form-label fw-bold">📷 Subir Imagenes de Diagnostico</label>
            
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-sm btn-primary" id="btnAgregarImagenAuxiliares">
                    ➕ Tomar / Cargar Fotos
                </button>
            </div>

            <div id="galeriaAuxiliares" class="mt-2 d-flex flex-wrap gap-2"></div>
        </div>`;

        html += `
        <div class="modal-footer">
            <button id="btnGuardarTrabajoAuxiliares" type="button" 
                    class="btn text-white" style="background-color: #000020;">
                Guardar Diagnóstico
            </button>
        </div>`;

        $('#contenidoAuxiliares').html(html);
        $(".criterio").trigger("change");
        renderGaleria("Auxiliares");
    }

    function cargarCriteriosSuspension(tipo) {
        if (!Criterioscache) {
            $('#contenidoSuspension').html('<div class="text-center"><div class="spinner-border text-primary"></div><p>Cargando criterios...</p></div>');
            setTimeout(() => cargarCriteriosSuspension(tipo), 400);
            return;
        }

        const criterios = Criterioscache.Suspension?.[tipo] || [];
        let html = "";

        criterios.forEach((item) => {
            const hiddenID = item.hidden;
            const num = hiddenID.split("_")[1];
            const tipoGuardado = $(`#hiddenCriterio_${num}`).val() || "";

            let descripcionGuardada = "";
            const trabajo = trabajosRealizados.find(t => t.criterio == num && t.seccion === "Suspension");
            if (trabajo) descripcionGuardada = trabajo.descripcion;

            html += `
            <div class="mb-3">
                <label class="form-label">${item.label}</label>
                <div class="d-flex align-items-center">
                    <select class="form-select me-2 criterio" data-num="${num}" required>
                        <option value="Seleccione">Seleccione</option>
                        <option value="Conforme"    ${tipoGuardado === "Conforme" ? "selected" : ""}>Conforme</option>
                        <option value="Nivelacion"  ${tipoGuardado === "Nivelacion" ? "selected" : ""}>Nivelación</option>
                        <option value="Ajuste"      ${tipoGuardado === "Ajuste" ? "selected" : ""}>Ajuste</option>
                        <option value="Reparar"     ${tipoGuardado === "Reparar" ? "selected" : ""}>Reparación</option>
                        <option value="Lubricacion" ${tipoGuardado === "Lubricacion" ? "selected" : ""}>Lubricación y Engrase</option>
                        <option value="NoAplica"    ${tipoGuardado === "NoAplica" ? "selected" : ""}>No aplica</option>
                    </select>
                    <span class="estado-icon"></span>
                </div>

                <input type="text" class="form-control mt-2 descripcionTrabajo"
                    placeholder="Describa el trabajo realizado..."
                    value="${descripcionGuardada}"
                    style="display: ${["Conforme","NoAplica","Seleccione"].includes(tipoGuardado) ? "none" : "block"};">
            </div>`;
        });

        html += `
        <div class="mt-3">
            <label class="form-label fw-bold">📷 Subir Imagenes de Diagnostico</label>
            
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-sm btn-primary" id="btnAgregarImagenSuspension">
                    ➕ Tomar / Cargar Fotos
                </button>
            </div>

            <div id="galeriaSuspension" class="mt-2 d-flex flex-wrap gap-2"></div>
        </div>`;

        html += `
        <div class="modal-footer">
            <button id="btnGuardarTrabajoSuspension" type="button" 
                    class="btn text-white" style="background-color: #000020;">
                Guardar Diagnóstico
            </button>
        </div>`;

        $('#contenidoSuspension').html(html);
        $(".criterio").trigger("change");
        renderGaleria("Suspension");
    }

    function cargarCriteriosPantografo(tipo) {
        if (!Criterioscache) {
            $('#contenidoPantografo').html('<div class="text-center"><div class="spinner-border text-primary"></div><p>Cargando criterios...</p></div>');
            setTimeout(() => cargarCriteriosPantografo(tipo), 400);
            return;
        }

        const criterios = Criterioscache.Pantografo?.[tipo] || [];
        let html = "";

        criterios.forEach((item) => {
            const hiddenID = item.hidden;
            const num = hiddenID.split("_")[1];
            const tipoGuardado = $(`#hiddenCriterio_${num}`).val() || "";

            let descripcionGuardada = "";
            const trabajo = trabajosRealizados.find(t => t.criterio == num && t.seccion === "Pantografo");
            if (trabajo) descripcionGuardada = trabajo.descripcion;

            html += `
            <div class="mb-3">
                <label class="form-label">${item.label}</label>
                <div class="d-flex align-items-center">
                    <select class="form-select me-2 criterio" data-num="${num}" required>
                        <option value="Seleccione">Seleccione</option>
                        <option value="Conforme"    ${tipoGuardado === "Conforme" ? "selected" : ""}>Conforme</option>
                        <option value="Nivelacion"  ${tipoGuardado === "Nivelacion" ? "selected" : ""}>Nivelación</option>
                        <option value="Ajuste"      ${tipoGuardado === "Ajuste" ? "selected" : ""}>Ajuste</option>
                        <option value="Reparar"     ${tipoGuardado === "Reparar" ? "selected" : ""}>Reparación</option>
                        <option value="Lubricacion" ${tipoGuardado === "Lubricacion" ? "selected" : ""}>Lubricación y Engrase</option>
                        <option value="NoAplica"    ${tipoGuardado === "NoAplica" ? "selected" : ""}>No aplica</option>
                    </select>
                    <span class="estado-icon"></span>
                </div>

                <input type="text" class="form-control mt-2 descripcionTrabajo"
                    placeholder="Describa el trabajo realizado..."
                    value="${descripcionGuardada}"
                    style="display: ${["Conforme","NoAplica","Seleccione"].includes(tipoGuardado) ? "none" : "block"};">
            </div>`;
        });

        html += `
        <div class="mt-3">
            <label class="form-label fw-bold">📷 Subir Imagenes de Diagnostico</label>
            
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-sm btn-primary" id="btnAgregarImagenPantografo">
                    ➕ Tomar / Cargar Fotos
                </button>
            </div>

            <div id="galeriaPantografo" class="mt-2 d-flex flex-wrap gap-2"></div>
        </div>`;

        html += `
        <div class="modal-footer">
            <button id="btnGuardarTrabajoPantografo" type="button" 
                    class="btn text-white" style="background-color: #000020;">
                Guardar Diagnóstico
            </button>
        </div>`;

        $('#contenidoPantografo').html(html);
        $(".criterio").trigger("change");
        renderGaleria("Pantografo");
    }

    function cargarCriteriosMotor(tipo) {
        if (!Criterioscache) {
            $('#contenidoMotor').html('<div class="text-center"><div class="spinner-border text-primary"></div><p>Cargando criterios...</p></div>');
            setTimeout(() => cargarCriteriosMotor(tipo), 400);
            return;
        }

        const criterios = Criterioscache.Motor?.[tipo] || [];
        let html = "";

        criterios.forEach((item) => {
            const hiddenID = item.hidden;
            const num = hiddenID.split("_")[1];
            const tipoGuardado = $(`#hiddenCriterio_${num}`).val() || "";

            let descripcionGuardada = "";
            const trabajo = trabajosRealizados.find(t => t.criterio == num && t.seccion === "Motor");
            if (trabajo) descripcionGuardada = trabajo.descripcion;

            html += `
            <div class="mb-3">
                <label class="form-label">${item.label}</label>
                <div class="d-flex align-items-center">
                    <select class="form-select me-2 criterio" data-num="${num}" required>
                        <option value="Seleccione">Seleccione</option>
                        <option value="Conforme"    ${tipoGuardado === "Conforme" ? "selected" : ""}>Conforme</option>
                        <option value="Nivelacion"  ${tipoGuardado === "Nivelacion" ? "selected" : ""}>Nivelación</option>
                        <option value="Ajuste"      ${tipoGuardado === "Ajuste" ? "selected" : ""}>Ajuste</option>
                        <option value="Reparar"     ${tipoGuardado === "Reparar" ? "selected" : ""}>Reparación</option>
                        <option value="Lubricacion" ${tipoGuardado === "Lubricacion" ? "selected" : ""}>Lubricación y Engrase</option>
                        <option value="NoAplica"    ${tipoGuardado === "NoAplica" ? "selected" : ""}>No aplica</option>
                    </select>
                    <span class="estado-icon"></span>
                </div>

                <input type="text" class="form-control mt-2 descripcionTrabajo"
                    placeholder="Describa el trabajo realizado..."
                    value="${descripcionGuardada}"
                    style="display: ${["Conforme","NoAplica","Seleccione"].includes(tipoGuardado) ? "none" : "block"};">
            </div>`;
        });

        html += `
        <div class="mt-3">
            <label class="form-label fw-bold">📷 Subir Imagenes de Diagnostico</label>
            
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-sm btn-primary" id="btnAgregarImagenMotor">
                    ➕ Tomar / Cargar Fotos
                </button>
            </div>

            <div id="galeriaMotor" class="mt-2 d-flex flex-wrap gap-2"></div>
        </div>`;

        html += `
        <div class="modal-footer">
            <button id="btnGuardarTrabajoMotor" type="button" 
                    class="btn text-white" style="background-color: #000020;">
                Guardar Diagnóstico
            </button>
        </div>`;

        $('#contenidoMotor').html(html);
        $(".criterio").trigger("change");
        renderGaleria("Motor");
    }

    function cargarCriteriosRefrigeracion(tipo) {
        if (!Criterioscache) {
            $('#contenidoRefrigeracion').html('<div class="text-center"><div class="spinner-border text-primary"></div><p>Cargando criterios...</p></div>');
            setTimeout(() => cargarCriteriosRefrigeracion(tipo), 400);
            return;
        }

        const criterios = Criterioscache.Refrigeracion?.[tipo] || [];
        let html = "";

        criterios.forEach((item) => {
            const hiddenID = item.hidden;
            const num = hiddenID.split("_")[1];
            const tipoGuardado = $(`#hiddenCriterio_${num}`).val() || "";

            let descripcionGuardada = "";
            const trabajo = trabajosRealizados.find(t => t.criterio == num && t.seccion === "Refrigeracion");
            if (trabajo) descripcionGuardada = trabajo.descripcion;

            html += `
            <div class="mb-3">
                <label class="form-label">${item.label}</label>
                <div class="d-flex align-items-center">
                    <select class="form-select me-2 criterio" data-num="${num}" required>
                        <option value="Seleccione">Seleccione</option>
                        <option value="Conforme"    ${tipoGuardado === "Conforme" ? "selected" : ""}>Conforme</option>
                        <option value="Nivelacion"  ${tipoGuardado === "Nivelacion" ? "selected" : ""}>Nivelación</option>
                        <option value="Ajuste"      ${tipoGuardado === "Ajuste" ? "selected" : ""}>Ajuste</option>
                        <option value="Reparar"     ${tipoGuardado === "Reparar" ? "selected" : ""}>Reparación</option>
                        <option value="Lubricacion" ${tipoGuardado === "Lubricacion" ? "selected" : ""}>Lubricación y Engrase</option>
                        <option value="NoAplica"    ${tipoGuardado === "NoAplica" ? "selected" : ""}>No aplica</option>
                    </select>
                    <span class="estado-icon"></span>
                </div>

                <input type="text" class="form-control mt-2 descripcionTrabajo"
                    placeholder="Describa el trabajo realizado..."
                    value="${descripcionGuardada}"
                    style="display: ${["Conforme","NoAplica","Seleccione"].includes(tipoGuardado) ? "none" : "block"};">
            </div>`;
        });

        html += `
        <div class="mt-3">
            <label class="form-label fw-bold">📷 Subir Imagenes de Diagnostico</label>
            
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-sm btn-primary" id="btnAgregarImagenRefrigeracion">
                    ➕ Tomar / Cargar Fotos
                </button>
            </div>

            <div id="galeriaRefrigeracion" class="mt-2 d-flex flex-wrap gap-2"></div>
        </div>`;

        html += `
        <div class="modal-footer">
            <button id="btnGuardarTrabajoRefrigeracion" type="button" 
                    class="btn text-white" style="background-color: #000020;">
                Guardar Diagnóstico
            </button>
        </div>`;

        $('#contenidoRefrigeracion').html(html);
        $(".criterio").trigger("change");
        renderGaleria("Refrigeracion");
    }

    function cargarCriteriosCombustion(tipo) {
        if (!Criterioscache) {
            $('#contenidoCombustion').html('<div class="text-center"><div class="spinner-border text-primary"></div><p>Cargando criterios...</p></div>');
            setTimeout(() => cargarCriteriosCombustion(tipo), 400);
            return;
        }

        const criterios = Criterioscache.Combustion?.[tipo] || [];
        let html = "";

        criterios.forEach((item) => {
            const hiddenID = item.hidden;
            const num = hiddenID.split("_")[1];
            const tipoGuardado = $(`#hiddenCriterio_${num}`).val() || "";

            let descripcionGuardada = "";
            const trabajo = trabajosRealizados.find(t => t.criterio == num && t.seccion === "Combustion");
            if (trabajo) descripcionGuardada = trabajo.descripcion;

            html += `
            <div class="mb-3">
                <label class="form-label">${item.label}</label>
                <div class="d-flex align-items-center">
                    <select class="form-select me-2 criterio" data-num="${num}" required>
                        <option value="Seleccione">Seleccione</option>
                        <option value="Conforme"    ${tipoGuardado === "Conforme" ? "selected" : ""}>Conforme</option>
                        <option value="Nivelacion"  ${tipoGuardado === "Nivelacion" ? "selected" : ""}>Nivelación</option>
                        <option value="Ajuste"      ${tipoGuardado === "Ajuste" ? "selected" : ""}>Ajuste</option>
                        <option value="Reparar"     ${tipoGuardado === "Reparar" ? "selected" : ""}>Reparación</option>
                        <option value="Lubricacion" ${tipoGuardado === "Lubricacion" ? "selected" : ""}>Lubricación y Engrase</option>
                        <option value="NoAplica"    ${tipoGuardado === "NoAplica" ? "selected" : ""}>No aplica</option>
                    </select>
                    <span class="estado-icon"></span>
                </div>

                <input type="text" class="form-control mt-2 descripcionTrabajo"
                    placeholder="Describa el trabajo realizado..."
                    value="${descripcionGuardada}"
                    style="display: ${["Conforme","NoAplica","Seleccione"].includes(tipoGuardado) ? "none" : "block"};">
            </div>`;
        });

        html += `
        <div class="mt-3">
            <label class="form-label fw-bold">📷 Subir Imagenes de Diagnostico</label>
            
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-sm btn-primary" id="btnAgregarImagenCombustion">
                    ➕ Tomar / Cargar Fotos
                </button>
            </div>

            <div id="galeriaCombustion" class="mt-2 d-flex flex-wrap gap-2"></div>
        </div>`;

        html += `
        <div class="modal-footer">
            <button id="btnGuardarTrabajoCombustion" type="button" 
                    class="btn text-white" style="background-color: #000020;">
                Guardar Diagnóstico
            </button>
        </div>`;

        $('#contenidoCombustion').html(html);
        $(".criterio").trigger("change");
        renderGaleria("Combustion");
    }

    function cargarCriteriosTransmision(tipo) {
        if (!Criterioscache) {
            $('#contenidoTransmision').html('<div class="text-center"><div class="spinner-border text-primary"></div><p>Cargando criterios...</p></div>');
            setTimeout(() => cargarCriteriosTransmision(tipo), 400);
            return;
        }

        const criterios = Criterioscache.Transmision?.[tipo] || [];
        let html = "";

        criterios.forEach((item) => {
            const hiddenID = item.hidden;
            const num = hiddenID.split("_")[1];
            const tipoGuardado = $(`#hiddenCriterio_${num}`).val() || "";

            let descripcionGuardada = "";
            const trabajo = trabajosRealizados.find(t => t.criterio == num && t.seccion === "Transmision");
            if (trabajo) descripcionGuardada = trabajo.descripcion;

            html += `
            <div class="mb-3">
                <label class="form-label">${item.label}</label>
                <div class="d-flex align-items-center">
                    <select class="form-select me-2 criterio" data-num="${num}" required>
                        <option value="Seleccione">Seleccione</option>
                        <option value="Conforme"    ${tipoGuardado === "Conforme" ? "selected" : ""}>Conforme</option>
                        <option value="Nivelacion"  ${tipoGuardado === "Nivelacion" ? "selected" : ""}>Nivelación</option>
                        <option value="Ajuste"      ${tipoGuardado === "Ajuste" ? "selected" : ""}>Ajuste</option>
                        <option value="Reparar"     ${tipoGuardado === "Reparar" ? "selected" : ""}>Reparación</option>
                        <option value="Lubricacion" ${tipoGuardado === "Lubricacion" ? "selected" : ""}>Lubricación y Engrase</option>
                        <option value="NoAplica"    ${tipoGuardado === "NoAplica" ? "selected" : ""}>No aplica</option>
                    </select>
                    <span class="estado-icon"></span>
                </div>

                <input type="text" class="form-control mt-2 descripcionTrabajo"
                    placeholder="Describa el trabajo realizado..."
                    value="${descripcionGuardada}"
                    style="display: ${["Conforme","NoAplica","Seleccione"].includes(tipoGuardado) ? "none" : "block"};">
            </div>`;
        });

        html += `
        <div class="mt-3">
            <label class="form-label fw-bold">📷 Subir Imagenes de Diagnostico</label>
            
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-sm btn-primary" id="btnAgregarImagenTransmision">
                    ➕ Tomar / Cargar Fotos
                </button>
            </div>

            <div id="galeriaTransmision" class="mt-2 d-flex flex-wrap gap-2"></div>
        </div>`;

        html += `
        <div class="modal-footer">
            <button id="btnGuardarTrabajoTransmision" type="button" 
                    class="btn text-white" style="background-color: #000020;">
                Guardar Diagnóstico
            </button>
        </div>`;

        $('#contenidoTransmision').html(html);
        $(".criterio").trigger("change");
        renderGaleria("Transmision");
    }

    function cargarCriteriosCaja(tipo) {
        if (!Criterioscache) {
            $('#contenidoCaja').html('<div class="text-center"><div class="spinner-border text-primary"></div><p>Cargando criterios...</p></div>');
            setTimeout(() => cargarCriteriosCaja(tipo), 400);
            return;
        }

        const criterios = Criterioscache.Caja?.[tipo] || [];
        let html = "";

        criterios.forEach((item) => {
            const hiddenID = item.hidden;
            const num = hiddenID.split("_")[1];
            const tipoGuardado = $(`#hiddenCriterio_${num}`).val() || "";

            let descripcionGuardada = "";
            const trabajo = trabajosRealizados.find(t => t.criterio == num && t.seccion === "Caja");
            if (trabajo) descripcionGuardada = trabajo.descripcion;

            html += `
            <div class="mb-3">
                <label class="form-label">${item.label}</label>
                <div class="d-flex align-items-center">
                    <select class="form-select me-2 criterio" data-num="${num}" required>
                        <option value="Seleccione">Seleccione</option>
                        <option value="Conforme"    ${tipoGuardado === "Conforme" ? "selected" : ""}>Conforme</option>
                        <option value="Nivelacion"  ${tipoGuardado === "Nivelacion" ? "selected" : ""}>Nivelación</option>
                        <option value="Ajuste"      ${tipoGuardado === "Ajuste" ? "selected" : ""}>Ajuste</option>
                        <option value="Reparar"     ${tipoGuardado === "Reparar" ? "selected" : ""}>Reparación</option>
                        <option value="Lubricacion" ${tipoGuardado === "Lubricacion" ? "selected" : ""}>Lubricación y Engrase</option>
                        <option value="NoAplica"    ${tipoGuardado === "NoAplica" ? "selected" : ""}>No aplica</option>
                    </select>
                    <span class="estado-icon"></span>
                </div>

                <input type="text" class="form-control mt-2 descripcionTrabajo"
                    placeholder="Describa el trabajo realizado..."
                    value="${descripcionGuardada}"
                    style="display: ${["Conforme","NoAplica","Seleccione"].includes(tipoGuardado) ? "none" : "block"};">
            </div>`;
        });

        html += `
        <div class="mt-3">
            <label class="form-label fw-bold">📷 Subir Imagenes de Diagnostico</label>
            
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-sm btn-primary" id="btnAgregarImagenCaja">
                    ➕ Tomar / Cargar Fotos
                </button>
            </div>

            <div id="galeriaCaja" class="mt-2 d-flex flex-wrap gap-2"></div>
        </div>`;

        html += `
        <div class="modal-footer">
            <button id="btnGuardarTrabajoCaja" type="button" 
                    class="btn text-white" style="background-color: #000020;">
                Guardar Diagnóstico
            </button>
        </div>`;

        $('#contenidoCaja').html(html);
        $(".criterio").trigger("change");
        renderGaleria("Caja");
    }

    function cargarCriteriosComponentes(tipo) {
        if (!Criterioscache) {
            $('#contenidoComponentes').html('<div class="text-center"><div class="spinner-border text-primary"></div><p>Cargando criterios...</p></div>');
            setTimeout(() => cargarCriteriosComponentes(tipo), 400);
            return;
        }

        const criterios = Criterioscache.Componentes?.[tipo] || [];
        let html = "";

        criterios.forEach((item) => {
            const hiddenID = item.hidden;
            const num = hiddenID.split("_")[1];
            const tipoGuardado = $(`#hiddenCriterio_${num}`).val() || "";

            let descripcionGuardada = "";
            const trabajo = trabajosRealizados.find(t => t.criterio == num && t.seccion === "Componentes");
            if (trabajo) descripcionGuardada = trabajo.descripcion;

            html += `
            <div class="mb-3">
                <label class="form-label">${item.label}</label>
                <div class="d-flex align-items-center">
                    <select class="form-select me-2 criterio" data-num="${num}" required>
                        <option value="Seleccione">Seleccione</option>
                        <option value="Conforme"    ${tipoGuardado === "Conforme" ? "selected" : ""}>Conforme</option>
                        <option value="Nivelacion"  ${tipoGuardado === "Nivelacion" ? "selected" : ""}>Nivelación</option>
                        <option value="Ajuste"      ${tipoGuardado === "Ajuste" ? "selected" : ""}>Ajuste</option>
                        <option value="Reparar"     ${tipoGuardado === "Reparar" ? "selected" : ""}>Reparación</option>
                        <option value="Lubricacion" ${tipoGuardado === "Lubricacion" ? "selected" : ""}>Lubricación y Engrase</option>
                        <option value="NoAplica"    ${tipoGuardado === "NoAplica" ? "selected" : ""}>No aplica</option>
                    </select>
                    <span class="estado-icon"></span>
                </div>

                <input type="text" class="form-control mt-2 descripcionTrabajo"
                    placeholder="Describa el trabajo realizado..."
                    value="${descripcionGuardada}"
                    style="display: ${["Conforme","NoAplica","Seleccione"].includes(tipoGuardado) ? "none" : "block"};">
            </div>`;
        });

        html += `
        <div class="mt-3">
            <label class="form-label fw-bold">📷 Subir Imagenes de Diagnostico</label>
            
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-sm btn-primary" id="btnAgregarImagenComponentes">
                    ➕ Tomar / Cargar Fotos
                </button>
            </div>

            <div id="galeriaComponentes" class="mt-2 d-flex flex-wrap gap-2"></div>
        </div>`;

        html += `
        <div class="modal-footer">
            <button id="btnGuardarTrabajoComponentes" type="button" 
                    class="btn text-white" style="background-color: #000020;">
                Guardar Diagnóstico
            </button>
        </div>`;

        $('#contenidoComponentes').html(html);
        $(".criterio").trigger("change");
        renderGaleria("Componentes");
    }

    function cargarCriteriosAusencia(tipo) {
        if (!Criterioscache) {
            $('#contenidoAusencia').html('<div class="text-center"><div class="spinner-border text-primary"></div><p>Cargando criterios...</p></div>');
            setTimeout(() => cargarCriteriosAusencia(tipo), 400);
            return;
        }

        const criterios = Criterioscache.Ausencia?.[tipo] || [];
        let html = "";

        criterios.forEach((item) => {
            const hiddenID = item.hidden;
            const num = hiddenID.split("_")[1];
            const tipoGuardado = $(`#hiddenCriterio_${num}`).val() || "";

            let descripcionGuardada = "";
            const trabajo = trabajosRealizados.find(t => t.criterio == num && t.seccion === "Ausencia");
            if (trabajo) descripcionGuardada = trabajo.descripcion;

            html += `
            <div class="mb-3">
                <label class="form-label">${item.label}</label>
                <div class="d-flex align-items-center">
                    <select class="form-select me-2 criterio" data-num="${num}" required>
                        <option value="Seleccione">Seleccione</option>
                        <option value="Conforme"    ${tipoGuardado === "Conforme" ? "selected" : ""}>Conforme</option>
                        <option value="Nivelacion"  ${tipoGuardado === "Nivelacion" ? "selected" : ""}>Nivelación</option>
                        <option value="Ajuste"      ${tipoGuardado === "Ajuste" ? "selected" : ""}>Ajuste</option>
                        <option value="Reparar"     ${tipoGuardado === "Reparar" ? "selected" : ""}>Reparación</option>
                        <option value="Lubricacion" ${tipoGuardado === "Lubricacion" ? "selected" : ""}>Lubricación y Engrase</option>
                        <option value="NoAplica"    ${tipoGuardado === "NoAplica" ? "selected" : ""}>No aplica</option>
                    </select>
                    <span class="estado-icon"></span>
                </div>

                <input type="text" class="form-control mt-2 descripcionTrabajo"
                    placeholder="Describa el trabajo realizado..."
                    value="${descripcionGuardada}"
                    style="display: ${["Conforme","NoAplica","Seleccione"].includes(tipoGuardado) ? "none" : "block"};">
            </div>`;
        });

        html += `
        <div class="mt-3">
            <label class="form-label fw-bold">📷 Subir Imagenes de Diagnostico</label>
            
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-sm btn-primary" id="btnAgregarImagenAusencia">
                    ➕ Tomar / Cargar Fotos
                </button>
            </div>

            <div id="galeriaAusencia" class="mt-2 d-flex flex-wrap gap-2"></div>
        </div>`;

        html += `
        <div class="modal-footer">
            <button id="btnGuardarTrabajoAusencia" type="button" 
                    class="btn text-white" style="background-color: #000020;">
                Guardar Diagnóstico
            </button>
        </div>`;

        $('#contenidoAusencia').html(html);
        $(".criterio").trigger("change");
        renderGaleria("Ausencia");
    }

    function cargarCriteriosRevisiones(tipo) {
        if (!Criterioscache) {
            $('#contenidoRevisiones').html('<div class="text-center"><div class="spinner-border text-primary"></div><p>Cargando criterios...</p></div>');
            setTimeout(() => cargarCriteriosRevisiones(tipo), 400);
            return;
        }

        const criterios = Criterioscache.Revisiones?.[tipo] || [];
        let html = "";

        criterios.forEach((item) => {
            const hiddenID = item.hidden;
            const num = hiddenID.split("_")[1];
            const tipoGuardado = $(`#hiddenCriterio_${num}`).val() || "";

            let descripcionGuardada = "";
            const trabajo = trabajosRealizados.find(t => t.criterio == num && t.seccion === "Revisiones");
            if (trabajo) descripcionGuardada = trabajo.descripcion;

            html += `
            <div class="mb-3">
                <label class="form-label">${item.label}</label>
                <div class="d-flex align-items-center">
                    <select class="form-select me-2 criterio" data-num="${num}" required>
                        <option value="Seleccione">Seleccione</option>
                        <option value="Conforme"    ${tipoGuardado === "Conforme" ? "selected" : ""}>Conforme</option>
                        <option value="Nivelacion"  ${tipoGuardado === "Nivelacion" ? "selected" : ""}>Nivelación</option>
                        <option value="Ajuste"      ${tipoGuardado === "Ajuste" ? "selected" : ""}>Ajuste</option>
                        <option value="Reparar"     ${tipoGuardado === "Reparar" ? "selected" : ""}>Reparación</option>
                        <option value="Lubricacion" ${tipoGuardado === "Lubricacion" ? "selected" : ""}>Lubricación y Engrase</option>
                        <option value="NoAplica"    ${tipoGuardado === "NoAplica" ? "selected" : ""}>No aplica</option>
                    </select>
                    <span class="estado-icon"></span>
                </div>

                <input type="text" class="form-control mt-2 descripcionTrabajo"
                    placeholder="Describa el trabajo realizado..."
                    value="${descripcionGuardada}"
                    style="display: ${["Conforme","NoAplica","Seleccione"].includes(tipoGuardado) ? "none" : "block"};">
            </div>`;
        });

        html += `
        <div class="mt-3">
            <label class="form-label fw-bold">📷 Subir Imagenes de Diagnostico</label>
            
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-sm btn-primary" id="btnAgregarImagenRevisiones">
                    ➕ Tomar / Cargar Fotos
                </button>
            </div>

            <div id="galeriaRevisiones" class="mt-2 d-flex flex-wrap gap-2"></div>
        </div>`;

        html += `
        <div class="modal-footer">
            <button id="btnGuardarTrabajoRevisiones" type="button" 
                    class="btn text-white" style="background-color: #000020;">
                Guardar Diagnóstico
            </button>
        </div>`;

        $('#contenidoRevisiones').html(html);
        $(".criterio").trigger("change");
        renderGaleria("Revisiones");
    }

    function cargarCriteriosFuncionamiento(tipo) {
        if (!Criterioscache) {
            $('#contenidoFuncionamiento').html('<div class="text-center"><div class="spinner-border text-primary"></div><p>Cargando criterios...</p></div>');
            setTimeout(() => cargarCriteriosFuncionamiento(tipo), 400);
            return;
        }

        const criterios = Criterioscache.Funcionamiento?.[tipo] || [];
        let html = "";

        criterios.forEach((item) => {
            const hiddenID = item.hidden;
            const num = hiddenID.split("_")[1];
            const tipoGuardado = $(`#hiddenCriterio_${num}`).val() || "";

            let descripcionGuardada = "";
            const trabajo = trabajosRealizados.find(t => t.criterio == num && t.seccion === "Funcionamiento");
            if (trabajo) descripcionGuardada = trabajo.descripcion;

            html += `
            <div class="mb-3">
                <label class="form-label">${item.label}</label>
                <div class="d-flex align-items-center">
                    <select class="form-select me-2 criterio" data-num="${num}" required>
                        <option value="Seleccione">Seleccione</option>
                        <option value="Conforme"    ${tipoGuardado === "Conforme" ? "selected" : ""}>Conforme</option>
                        <option value="Nivelacion"  ${tipoGuardado === "Nivelacion" ? "selected" : ""}>Nivelación</option>
                        <option value="Ajuste"      ${tipoGuardado === "Ajuste" ? "selected" : ""}>Ajuste</option>
                        <option value="Reparar"     ${tipoGuardado === "Reparar" ? "selected" : ""}>Reparación</option>
                        <option value="Lubricacion" ${tipoGuardado === "Lubricacion" ? "selected" : ""}>Lubricación y Engrase</option>
                        <option value="NoAplica"    ${tipoGuardado === "NoAplica" ? "selected" : ""}>No aplica</option>
                    </select>
                    <span class="estado-icon"></span>
                </div>

                <input type="text" class="form-control mt-2 descripcionTrabajo"
                    placeholder="Describa el trabajo realizado..."
                    value="${descripcionGuardada}"
                    style="display: ${["Conforme","NoAplica","Seleccione"].includes(tipoGuardado) ? "none" : "block"};">
            </div>`;
        });

        html += `
        <div class="mt-3">
            <label class="form-label fw-bold">📷 Subir Imagenes de Diagnostico</label>
            
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-sm btn-primary" id="btnAgregarImagenFuncionamiento">
                    ➕ Tomar / Cargar Fotos
                </button>
            </div>

            <div id="galeriaFuncionamiento" class="mt-2 d-flex flex-wrap gap-2"></div>
        </div>`;

        html += `
        <div class="modal-footer">
            <button id="btnGuardarTrabajoFuncionamiento" type="button" 
                    class="btn text-white" style="background-color: #000020;">
                Guardar Diagnóstico
            </button>
        </div>`;

        $('#contenidoFuncionamiento').html(html);
        $(".criterio").trigger("change");
        renderGaleria("Funcionamiento");
    }

    function cargarCriteriosCorreas(tipo) {
        if (!Criterioscache) {
            $('#contenidoCorreas').html('<div class="text-center"><div class="spinner-border text-primary"></div><p>Cargando criterios...</p></div>');
            setTimeout(() => cargarCriteriosCorreas(tipo), 400);
            return;
        }

        const criterios = Criterioscache.Correas?.[tipo] || [];
        let html = "";

        criterios.forEach((item) => {
            const hiddenID = item.hidden;
            const num = hiddenID.split("_")[1];
            const tipoGuardado = $(`#hiddenCriterio_${num}`).val() || "";

            let descripcionGuardada = "";
            const trabajo = trabajosRealizados.find(t => t.criterio == num && t.seccion === "Correas");
            if (trabajo) descripcionGuardada = trabajo.descripcion;

            html += `
            <div class="mb-3">
                <label class="form-label">${item.label}</label>
                <div class="d-flex align-items-center">
                    <select class="form-select me-2 criterio" data-num="${num}" required>
                        <option value="Seleccione">Seleccione</option>
                        <option value="Conforme"    ${tipoGuardado === "Conforme" ? "selected" : ""}>Conforme</option>
                        <option value="Nivelacion"  ${tipoGuardado === "Nivelacion" ? "selected" : ""}>Nivelación</option>
                        <option value="Ajuste"      ${tipoGuardado === "Ajuste" ? "selected" : ""}>Ajuste</option>
                        <option value="Reparar"     ${tipoGuardado === "Reparar" ? "selected" : ""}>Reparación</option>
                        <option value="Lubricacion" ${tipoGuardado === "Lubricacion" ? "selected" : ""}>Lubricación y Engrase</option>
                        <option value="NoAplica"    ${tipoGuardado === "NoAplica" ? "selected" : ""}>No aplica</option>
                    </select>
                    <span class="estado-icon"></span>
                </div>

                <input type="text" class="form-control mt-2 descripcionTrabajo"
                    placeholder="Describa el trabajo realizado..."
                    value="${descripcionGuardada}"
                    style="display: ${["Conforme","NoAplica","Seleccione"].includes(tipoGuardado) ? "none" : "block"};">
            </div>`;
        });

        html += `
        <div class="mt-3">
            <label class="form-label fw-bold">📷 Subir Imagenes de Diagnostico</label>
            
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-sm btn-primary" id="btnAgregarImagenCorreas">
                    ➕ Tomar / Cargar Fotos
                </button>
            </div>

            <div id="galeriaCorreas" class="mt-2 d-flex flex-wrap gap-2"></div>
        </div>`;

        html += `
        <div class="modal-footer">
            <button id="btnGuardarTrabajoCorreas" type="button" 
                    class="btn text-white" style="background-color: #000020;">
                Guardar Diagnóstico
            </button>
        </div>`;

        $('#contenidoCorreas').html(html);
        $(".criterio").trigger("change");
        renderGaleria("Correas");
    }

    function cargarCriteriosUnidad(tipo) {
        if (!Criterioscache) {
            $('#contenidoUnidad').html('<div class="text-center"><div class="spinner-border text-primary"></div><p>Cargando criterios...</p></div>');
            setTimeout(() => cargarCriteriosUnidad(tipo), 400);
            return;
        }

        const criterios = Criterioscache.Unidad?.[tipo] || [];
        let html = "";

        criterios.forEach((item) => {
            const hiddenID = item.hidden;
            const num = hiddenID.split("_")[1];
            const tipoGuardado = $(`#hiddenCriterio_${num}`).val() || "";

            let descripcionGuardada = "";
            const trabajo = trabajosRealizados.find(t => t.criterio == num && t.seccion === "Unidad");
            if (trabajo) descripcionGuardada = trabajo.descripcion;

            html += `
            <div class="mb-3">
                <label class="form-label">${item.label}</label>
                <div class="d-flex align-items-center">
                    <select class="form-select me-2 criterio" data-num="${num}" required>
                        <option value="Seleccione">Seleccione</option>
                        <option value="Conforme"    ${tipoGuardado === "Conforme" ? "selected" : ""}>Conforme</option>
                        <option value="Nivelacion"  ${tipoGuardado === "Nivelacion" ? "selected" : ""}>Nivelación</option>
                        <option value="Ajuste"      ${tipoGuardado === "Ajuste" ? "selected" : ""}>Ajuste</option>
                        <option value="Reparar"     ${tipoGuardado === "Reparar" ? "selected" : ""}>Reparación</option>
                        <option value="Lubricacion" ${tipoGuardado === "Lubricacion" ? "selected" : ""}>Lubricación y Engrase</option>
                        <option value="NoAplica"    ${tipoGuardado === "NoAplica" ? "selected" : ""}>No aplica</option>
                    </select>
                    <span class="estado-icon"></span>
                </div>

                <input type="text" class="form-control mt-2 descripcionTrabajo"
                    placeholder="Describa el trabajo realizado..."
                    value="${descripcionGuardada}"
                    style="display: ${["Conforme","NoAplica","Seleccione"].includes(tipoGuardado) ? "none" : "block"};">
            </div>`;
        });

        html += `
        <div class="mt-3">
            <label class="form-label fw-bold">📷 Subir Imagenes de Diagnostico</label>
            
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-sm btn-primary" id="btnAgregarImagenUnidad">
                    ➕ Tomar / Cargar Fotos
                </button>
            </div>

            <div id="galeriaUnidad" class="mt-2 d-flex flex-wrap gap-2"></div>
        </div>`;

        html += `
        <div class="modal-footer">
            <button id="btnGuardarTrabajoUnidad" type="button" 
                    class="btn text-white" style="background-color: #000020;">
                Guardar Diagnóstico
            </button>
        </div>`;

        $('#contenidoUnidad').html(html);
        $(".criterio").trigger("change");
        renderGaleria("Unidad");
    }

    function cargarCriteriosPanel(tipo) {
        if (!Criterioscache) {
            $('#contenidoPanel').html('<div class="text-center"><div class="spinner-border text-primary"></div><p>Cargando criterios...</p></div>');
            setTimeout(() => cargarCriteriosPanel(tipo), 400);
            return;
        }

        const criterios = Criterioscache.Panel?.[tipo] || [];
        let html = "";

        criterios.forEach((item) => {
            const hiddenID = item.hidden;
            const num = hiddenID.split("_")[1];
            const tipoGuardado = $(`#hiddenCriterio_${num}`).val() || "";

            let descripcionGuardada = "";
            const trabajo = trabajosRealizados.find(t => t.criterio == num && t.seccion === "Panel");
            if (trabajo) descripcionGuardada = trabajo.descripcion;

            html += `
            <div class="mb-3">
                <label class="form-label">${item.label}</label>
                <div class="d-flex align-items-center">
                    <select class="form-select me-2 criterio" data-num="${num}" required>
                        <option value="Seleccione">Seleccione</option>
                        <option value="Conforme"    ${tipoGuardado === "Conforme" ? "selected" : ""}>Conforme</option>
                        <option value="Nivelacion"  ${tipoGuardado === "Nivelacion" ? "selected" : ""}>Nivelación</option>
                        <option value="Ajuste"      ${tipoGuardado === "Ajuste" ? "selected" : ""}>Ajuste</option>
                        <option value="Reparar"     ${tipoGuardado === "Reparar" ? "selected" : ""}>Reparación</option>
                        <option value="Lubricacion" ${tipoGuardado === "Lubricacion" ? "selected" : ""}>Lubricación y Engrase</option>
                        <option value="NoAplica"    ${tipoGuardado === "NoAplica" ? "selected" : ""}>No aplica</option>
                    </select>
                    <span class="estado-icon"></span>
                </div>

                <input type="text" class="form-control mt-2 descripcionTrabajo"
                    placeholder="Describa el trabajo realizado..."
                    value="${descripcionGuardada}"
                    style="display: ${["Conforme","NoAplica","Seleccione"].includes(tipoGuardado) ? "none" : "block"};">
            </div>`;
        });

        html += `
        <div class="mt-3">
            <label class="form-label fw-bold">📷 Subir Imagenes de Diagnostico</label>
            
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-sm btn-primary" id="btnAgregarImagenPanel">
                    ➕ Tomar / Cargar Fotos
                </button>
            </div>

            <div id="galeriaPanel" class="mt-2 d-flex flex-wrap gap-2"></div>
        </div>`;

        html += `
        <div class="modal-footer">
            <button id="btnGuardarTrabajoPanel" type="button" 
                    class="btn text-white" style="background-color: #000020;">
                Guardar Diagnóstico
            </button>
        </div>`;

        $('#contenidoPanel').html(html);
        $(".criterio").trigger("change");
        renderGaleria("Panel");
    }

    function cargarCriteriosPintura(tipo) {
        if (!Criterioscache) {
            $('#contenidoPintura').html('<div class="text-center"><div class="spinner-border text-primary"></div><p>Cargando criterios...</p></div>');
            setTimeout(() => cargarCriteriosPintura(tipo), 400);
            return;
        }

        const criterios = Criterioscache.Pintura?.[tipo] || [];
        let html = "";

        criterios.forEach((item) => {
            const hiddenID = item.hidden;
            const num = hiddenID.split("_")[1];
            const tipoGuardado = $(`#hiddenCriterio_${num}`).val() || "";

            let descripcionGuardada = "";
            const trabajo = trabajosRealizados.find(t => t.criterio == num && t.seccion === "Pintura");
            if (trabajo) descripcionGuardada = trabajo.descripcion;

            html += `
            <div class="mb-3">
                <label class="form-label">${item.label}</label>
                <div class="d-flex align-items-center">
                    <select class="form-select me-2 criterio" data-num="${num}" required>
                        <option value="Seleccione">Seleccione</option>
                        <option value="Conforme"    ${tipoGuardado === "Conforme" ? "selected" : ""}>Conforme</option>
                        <option value="Nivelacion"  ${tipoGuardado === "Nivelacion" ? "selected" : ""}>Nivelación</option>
                        <option value="Ajuste"      ${tipoGuardado === "Ajuste" ? "selected" : ""}>Ajuste</option>
                        <option value="Reparar"     ${tipoGuardado === "Reparar" ? "selected" : ""}>Reparación</option>
                        <option value="Lubricacion" ${tipoGuardado === "Lubricacion" ? "selected" : ""}>Lubricación y Engrase</option>
                        <option value="NoAplica"    ${tipoGuardado === "NoAplica" ? "selected" : ""}>No aplica</option>
                    </select>
                    <span class="estado-icon"></span>
                </div>

                <input type="text" class="form-control mt-2 descripcionTrabajo"
                    placeholder="Describa el trabajo realizado..."
                    value="${descripcionGuardada}"
                    style="display: ${["Conforme","NoAplica","Seleccione"].includes(tipoGuardado) ? "none" : "block"};">
            </div>`;
        });

        html += `
        <div class="mt-3">
            <label class="form-label fw-bold">📷 Subir Imagenes de Diagnostico</label>
            
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-sm btn-primary" id="btnAgregarImagenPintura">
                    ➕ Tomar / Cargar Fotos
                </button>
            </div>

            <div id="galeriaPintura" class="mt-2 d-flex flex-wrap gap-2"></div>
        </div>`;

        html += `
        <div class="modal-footer">
            <button id="btnGuardarTrabajoPintura" type="button" 
                    class="btn text-white" style="background-color: #000020;">
                Guardar Diagnóstico
            </button>
        </div>`;

        $('#contenidoPintura').html(html);
        $(".criterio").trigger("change");
        renderGaleria("Pintura");
    }

    function cargarCriteriosPintura1(tipo) {
        if (!Criterioscache) {
            $('#contenidoPintura1').html('<div class="text-center"><div class="spinner-border text-primary"></div><p>Cargando criterios...</p></div>');
            setTimeout(() => cargarCriteriosPintura1(tipo), 400);
            return;
        }

        const criterios = Criterioscache.Pintura?.[tipo] || [];
        let html = "";

        criterios.forEach((item) => {
            const hiddenID = item.hidden;
            const num = hiddenID.split("_")[1];
            const tipoGuardado = $(`#hiddenCriterio_${num}`).val() || "";

            let descripcionGuardada = "";
            const trabajo = trabajosRealizados.find(t => t.criterio == num && t.seccion === "Pintura");
            if (trabajo) descripcionGuardada = trabajo.descripcion;

            html += `
            <div class="mb-3">
                <label class="form-label">${item.label}</label>
                <div class="d-flex align-items-center">
                    <select class="form-select me-2 criterio" data-num="${num}" required>
                        <option value="Seleccione">Seleccione</option>
                        <option value="Conforme"    ${tipoGuardado === "Conforme" ? "selected" : ""}>Conforme</option>
                        <option value="Nivelacion"  ${tipoGuardado === "Nivelacion" ? "selected" : ""}>Nivelación</option>
                        <option value="Ajuste"      ${tipoGuardado === "Ajuste" ? "selected" : ""}>Ajuste</option>
                        <option value="Reparar"     ${tipoGuardado === "Reparar" ? "selected" : ""}>Reparación</option>
                        <option value="Lubricacion" ${tipoGuardado === "Lubricacion" ? "selected" : ""}>Lubricación y Engrase</option>
                        <option value="NoAplica"    ${tipoGuardado === "NoAplica" ? "selected" : ""}>No aplica</option>
                    </select>
                    <span class="estado-icon"></span>
                </div>

                <input type="text" class="form-control mt-2 descripcionTrabajo"
                    placeholder="Describa el trabajo realizado..."
                    value="${descripcionGuardada}"
                    style="display: ${["Conforme","NoAplica","Seleccione"].includes(tipoGuardado) ? "none" : "block"};">
            </div>`;
        });

        html += `
        <div class="mt-3">
            <label class="form-label fw-bold">📷 Subir Imagenes de Diagnostico</label>
            
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-sm btn-primary" id="btnAgregarImagenPintura">
                    ➕ Tomar / Cargar Fotos
                </button>
            </div>

            <div id="galeriaPintura" class="mt-2 d-flex flex-wrap gap-2"></div>
        </div>`;

        html += `
        <div class="modal-footer">
            <button id="btnGuardarTrabajoPintura1" type="button" 
                    class="btn text-white" style="background-color: #000020;">
                Guardar Diagnóstico
            </button>
        </div>`;

        $('#contenidoPintura1').html(html);
        $(".criterio").trigger("change");
        renderGaleria("Pintura");
    }

    //Abrir input archivos batería
    $(document).on("click", "#btnAgregarImagenBateria", function () {
        $("#imagenesDiagnosticoBateria").click();
    });

    $(document).on("click", "#btnAgregarImagenElectrico", function () {
        $("#imagenesDiagnosticoElectrico").click();
    });

    $(document).on("click", "#btnAgregarImagenTraccion", function () {
        $("#imagenesDiagnosticoTraccion").click();
    });

    $(document).on("click", "#btnAgregarImagenFrenos", function () {
        $("#imagenesDiagnosticoFrenos").click();
    });

    $(document).on("click", "#btnAgregarImagenDireccion", function () {
        $("#imagenesDiagnosticoDireccion").click();
    });

    $(document).on("click", "#btnAgregarImagenHidraulico", function () {
        $("#imagenesDiagnosticoHidraulico").click();
    });

    $(document).on("click", "#btnAgregarImagenMastil", function () {
        $("#imagenesDiagnosticoMastil").click();
    });

    $(document).on("click", "#btnAgregarImagenCarroPorta", function () {
        $("#imagenesDiagnosticoCarroPorta").click();
    });

    $(document).on("click", "#btnAgregarImagenLubricacion", function () {
        $("#imagenesDiagnosticoLubricacion").click();
    });

    $(document).on("click", "#btnAgregarImagenHorquillas", function () {
        $("#imagenesDiagnosticoHorquillas").click();
    });

    $(document).on("click", "#btnAgregarImagenChasis", function () {
        $("#imagenesDiagnosticoChasis").click();
    });

    $(document).on("click", "#btnAgregarImagenRuedas", function () {
        $("#imagenesDiagnosticoRuedas").click();
    });

    $(document).on("click", "#btnAgregarImagenLuces", function () {
        $("#imagenesDiagnosticoLuces").click();
    });

    $(document).on("click", "#btnAgregarImagenAditamentos", function () {
        $("#imagenesDiagnosticoAditamentos").click();
    });

    $(document).on("click", "#btnAgregarImagenCargador", function () {
        $("#imagenesDiagnosticoCargador").click();
    });

    $(document).on("click", "#btnAgregarImagenRevision", function () {
        $("#imagenesDiagnosticoRevision").click();
    });

    $(document).on("click", "#btnAgregarImagenAuxiliares", function () {
        $("#imagenesDiagnosticoAuxiliares").click();
    });

    $(document).on("click", "#btnAgregarImagenSuspension", function () {
        $("#imagenesDiagnosticoSuspension").click();
    });

    $(document).on("click", "#btnAgregarImagenPantografo", function () {
        $("#imagenesDiagnosticoPantografo").click();
    });

    $(document).on("click", "#btnAgregarImagenMotor", function () {
        $("#imagenesDiagnosticoMotor").click();
    });

    $(document).on("click", "#btnAgregarImagenRefrigeracion", function () {
        $("#imagenesDiagnosticoRefrigeracion").click();
    });

    $(document).on("click", "#btnAgregarImagenCombustion", function () {
        $("#imagenesDiagnosticoCombustion").click();
    });

    $(document).on("click", "#btnAgregarImagenTransmision", function () {
        $("#imagenesDiagnosticoTransmision").click();
    });

    $(document).on("click", "#btnAgregarImagenCaja", function () {
        $("#imagenesDiagnosticoCaja").click();
    });

    $(document).on("click", "#btnAgregarImagenComponentes", function () {
        $("#imagenesDiagnosticoComponentes").click();
    });

    $(document).on("click", "#btnAgregarImagenAusencia", function () {
        $("#imagenesDiagnosticoAusencia").click();
    });

    $(document).on("click", "#btnAgregarImagenRevisiones", function () {
        $("#imagenesDiagnosticoRevisiones").click();
    });

    $(document).on("click", "#btnAgregarImagenFuncionamiento", function () {
        $("#imagenesDiagnosticoFuncionamiento").click();
    });

    $(document).on("click", "#btnAgregarImagenCorreas", function () {
        $("#imagenesDiagnosticoCorreas").click();
    });

    $(document).on("click", "#btnAgregarImagenUnidad", function () {
        $("#imagenesDiagnosticoUnidad").click();
    });

    $(document).on("click", "#btnAgregarImagenPanel", function () {
        $("#imagenesDiagnosticoPanel").click();
    });

    $(document).on("click", "#btnAgregarImagenPintura", function () {
        $("#imagenesDiagnosticoPintura").click();
    });

    // Selección de imágenes por secciones
    $("#imagenesDiagnosticoBateria").on("change", function () {
        const files = Array.from(this.files);
        files.forEach(file => {
            imagenesPorSeccion.Bateria.push({
                file,
                url: URL.createObjectURL(file)
            });
        });
        renderGaleria("Bateria");
        syncInputFile("Bateria");
    });

    $("#imagenesDiagnosticoElectrico").on("change", function () {
        const files = Array.from(this.files);
        files.forEach(file => {
            imagenesPorSeccion.Electrico.push({
                file,
                url: URL.createObjectURL(file)
            });
        });
        renderGaleria("Electrico");
        syncInputFile("Electrico");
    });

    $("#imagenesDiagnosticoTraccion").on("change", function () {
        const files = Array.from(this.files);
        files.forEach(file => {
            imagenesPorSeccion.Traccion.push({
                file,
                url: URL.createObjectURL(file)
            });
        });
        renderGaleria("Traccion");
        syncInputFile("Traccion");
    });

    $("#imagenesDiagnosticoFrenos").on("change", function () {
        const files = Array.from(this.files);
        files.forEach(file => {
            imagenesPorSeccion.Frenos.push({
                file,
                url: URL.createObjectURL(file)
            });
        });
        renderGaleria("Frenos");
        syncInputFile("Frenos");
    });

    $("#imagenesDiagnosticoDireccion").on("change", function () {
        const files = Array.from(this.files);
        files.forEach(file => {
            imagenesPorSeccion.Direccion.push({
                file,
                url: URL.createObjectURL(file)
            });
        });
        renderGaleria("Direccion");
        syncInputFile("Direccion");
    });

    $("#imagenesDiagnosticoHidraulico").on("change", function () {
        const files = Array.from(this.files);
        files.forEach(file => {
            imagenesPorSeccion.Hidraulico.push({
                file,
                url: URL.createObjectURL(file)
            });
        });
        renderGaleria("Hidraulico");
        syncInputFile("Hidraulico");
    });

    $("#imagenesDiagnosticoMastil").on("change", function () {
        const files = Array.from(this.files);
        files.forEach(file => {
            imagenesPorSeccion.Mastil.push({
                file,
                url: URL.createObjectURL(file)
            });
        });
        renderGaleria("Mastil");
        syncInputFile("Mastil");
    });

    $("#imagenesDiagnosticoCarroPorta").on("change", function () {
        const files = Array.from(this.files);
        files.forEach(file => {
            imagenesPorSeccion.CarroPorta.push({
                file,
                url: URL.createObjectURL(file)
            });
        });
        renderGaleria("CarroPorta");
        syncInputFile("CarroPorta");
    });

    $("#imagenesDiagnosticoLubricacion").on("change", function () {
        const files = Array.from(this.files);
        files.forEach(file => {
            imagenesPorSeccion.Lubricacion.push({
                file,
                url: URL.createObjectURL(file)
            });
        });
        renderGaleria("Lubricacion");
        syncInputFile("Lubricacion");
    });

    $("#imagenesDiagnosticoHorquillas").on("change", function () {
        const files = Array.from(this.files);
        files.forEach(file => {
            imagenesPorSeccion.Horquillas.push({
                file,
                url: URL.createObjectURL(file)
            });
        });
        renderGaleria("Horquillas");
        syncInputFile("Horquillas");
    });

    $("#imagenesDiagnosticoChasis").on("change", function () {
        const files = Array.from(this.files);
        files.forEach(file => {
            imagenesPorSeccion.Chasis.push({
                file,
                url: URL.createObjectURL(file)
            });
        });
        renderGaleria("Chasis");
        syncInputFile("Chasis");
    });

    $("#imagenesDiagnosticoRuedas").on("change", function () {
        const files = Array.from(this.files);
        files.forEach(file => {
            imagenesPorSeccion.Ruedas.push({
                file,
                url: URL.createObjectURL(file)
            });
        });
        renderGaleria("Ruedas");
        syncInputFile("Ruedas");
    });

    $("#imagenesDiagnosticoLuces").on("change", function () {
        const files = Array.from(this.files);
        files.forEach(file => {
            imagenesPorSeccion.Luces.push({
                file,
                url: URL.createObjectURL(file)
            });
        });
        renderGaleria("Luces");
        syncInputFile("Luces");
    });

    $("#imagenesDiagnosticoAditamentos").on("change", function () {
        const files = Array.from(this.files);
        files.forEach(file => {
            imagenesPorSeccion.Aditamentos.push({
                file,
                url: URL.createObjectURL(file)
            });
        });
        renderGaleria("Aditamentos");
        syncInputFile("Aditamentos");
    });

    $("#imagenesDiagnosticoCargador").on("change", function () {
        const files = Array.from(this.files);
        files.forEach(file => {
            imagenesPorSeccion.Cargador.push({
                file,
                url: URL.createObjectURL(file)
            });
        });
        renderGaleria("Cargador");
        syncInputFile("Cargador");
    });

    $("#imagenesDiagnosticoRevision").on("change", function () {
        const files = Array.from(this.files);
        files.forEach(file => {
            imagenesPorSeccion.Revision.push({
                file,
                url: URL.createObjectURL(file)
            });
        });
        renderGaleria("Revision");
        syncInputFile("Revision");
    });

    $("#imagenesDiagnosticoAuxiliares").on("change", function () {
        const files = Array.from(this.files);
        files.forEach(file => {
            imagenesPorSeccion.Auxiliares.push({
                file,
                url: URL.createObjectURL(file)
            });
        });
        renderGaleria("Auxiliares");
        syncInputFile("Auxiliares");
    });

    $("#imagenesDiagnosticoSuspension").on("change", function () {
        const files = Array.from(this.files);
        files.forEach(file => {
            imagenesPorSeccion.Suspension.push({
                file,
                url: URL.createObjectURL(file)
            });
        });
        renderGaleria("Suspension");
        syncInputFile("Suspension");
    });

    $("#imagenesDiagnosticoPantografo").on("change", function () {
        const files = Array.from(this.files);
        files.forEach(file => {
            imagenesPorSeccion.Pantografo.push({
                file,
                url: URL.createObjectURL(file)
            });
        });
        renderGaleria("Pantografo");
        syncInputFile("Pantografo");
    });

    $("#imagenesDiagnosticoMotor").on("change", function () {
        const files = Array.from(this.files);
        files.forEach(file => {
            imagenesPorSeccion.Motor.push({
                file,
                url: URL.createObjectURL(file)
            });
        });
        renderGaleria("Motor");
        syncInputFile("Motor");
    });

    $("#imagenesDiagnosticoRefrigeracion").on("change", function () {
        const files = Array.from(this.files);
        files.forEach(file => {
            imagenesPorSeccion.Refrigeracion.push({
                file,
                url: URL.createObjectURL(file)
            });
        });
        renderGaleria("Refrigeracion");
        syncInputFile("Refrigeracion");
    });

    $("#imagenesDiagnosticoCombustion").on("change", function () {
        const files = Array.from(this.files);
        files.forEach(file => {
            imagenesPorSeccion.Combustion.push({
                file,
                url: URL.createObjectURL(file)
            });
        });
        renderGaleria("Combustion");
        syncInputFile("Combustion");
    });

    $("#imagenesDiagnosticoTransmision").on("change", function () {
        const files = Array.from(this.files);
        files.forEach(file => {
            imagenesPorSeccion.Transmision.push({
                file,
                url: URL.createObjectURL(file)
            });
        });
        renderGaleria("Transmision");
        syncInputFile("Transmision");
    });

    $("#imagenesDiagnosticoCaja").on("change", function () {
        const files = Array.from(this.files);
        files.forEach(file => {
            imagenesPorSeccion.Caja.push({
                file,
                url: URL.createObjectURL(file)
            });
        });
        renderGaleria("Caja");
        syncInputFile("Caja");
    });

    $("#imagenesDiagnosticoComponentes").on("change", function () {
        const files = Array.from(this.files);
        files.forEach(file => {
            imagenesPorSeccion.Componentes.push({
                file,
                url: URL.createObjectURL(file)
            });
        });
        renderGaleria("Componentes");
        syncInputFile("Componentes");
    });

    $("#imagenesDiagnosticoAusencia").on("change", function () {
        const files = Array.from(this.files);
        files.forEach(file => {
            imagenesPorSeccion.Ausencia.push({
                file,
                url: URL.createObjectURL(file)
            });
        });
        renderGaleria("Ausencia");
        syncInputFile("Ausencia");
    });

    $("#imagenesDiagnosticoRevisiones").on("change", function () {
        const files = Array.from(this.files);
        files.forEach(file => {
            imagenesPorSeccion.Revisiones.push({
                file,
                url: URL.createObjectURL(file)
            });
        });
        renderGaleria("Revisiones");
        syncInputFile("Revisiones");
    });

    $("#imagenesDiagnosticoFuncionamiento").on("change", function () {
        const files = Array.from(this.files);
        files.forEach(file => {
            imagenesPorSeccion.Funcionamiento.push({
                file,
                url: URL.createObjectURL(file)
            });
        });
        renderGaleria("Funcionamiento");
        syncInputFile("Funcionamiento");
    });

    $("#imagenesDiagnosticoCorreas").on("change", function () {
        const files = Array.from(this.files);
        files.forEach(file => {
            imagenesPorSeccion.Correas.push({
                file,
                url: URL.createObjectURL(file)
            });
        });
        renderGaleria("Correas");
        syncInputFile("Correas");
    });

    $("#imagenesDiagnosticoUnidad").on("change", function () {
        const files = Array.from(this.files);
        files.forEach(file => {
            imagenesPorSeccion.Unidad.push({
                file,
                url: URL.createObjectURL(file)
            });
        });
        renderGaleria("Unidad");
        syncInputFile("Unidad");
    });

    $("#imagenesDiagnosticoPanel").on("change", function () {
        const files = Array.from(this.files);
        files.forEach(file => {
            imagenesPorSeccion.Panel.push({
                file,
                url: URL.createObjectURL(file)
            });
        });
        renderGaleria("Panel");
        syncInputFile("Panel");
    });

    $("#imagenesDiagnosticoPintura").on("change", function () {
        const files = Array.from(this.files);
        files.forEach(file => {
            imagenesPorSeccion.Pintura.push({
                file,
                url: URL.createObjectURL(file)
            });
        });
        renderGaleria("Pintura");
        syncInputFile("Pintura");
    });

    // Thumbnails para cada sección
    function renderGaleria(seccion) {
        const cont = $(`#galeria${seccion}`);
        const imagenes = imagenesPorSeccion[seccion];

        cont.html("");

        imagenes.forEach((img, index) => {
            cont.append(`
            <div class="position-relative">
                <img src="${img.url}" class="img-thumbnail"
                    style="width:90px;height:90px;object-fit:cover;cursor:pointer;"
                    onclick="openLightbox('${seccion}', ${index})">
                <button class="btn btn-sm btn-danger position-absolute top-0 end-0 btnEliminarImg"
                    data-seccion="${seccion}" data-index="${index}">✖</button>
            </div>
            `);
        });
    }

    // Eliminar imagen de la sección correcta
    $(document).on("click", ".btnEliminarImg", function (e) {
        e.stopPropagation();
        const seccion = $(this).data("seccion");
        const index = $(this).data("index");

        imagenesPorSeccion[seccion].splice(index, 1);
        renderGaleria(seccion);
        syncInputFile(seccion);
    });

    function syncInputFile(seccion) {
        const inputHidden = document.getElementById(`imagenesDiagnostico${seccion}`);
        const dt = new DataTransfer();
        imagenesPorSeccion[seccion].forEach(img => dt.items.add(img.file));
        
        inputHidden.files = dt.files;
    }

    // ⭐ NUEVO - LIGHTBOX
    let currentImgIndex = 0;
    let currentSeccion = "";

    // Abrir Lightbox por cada sección
    function openLightbox(seccion, index) {
        currentSeccion = seccion;
        currentImgIndex = index;

        updateLightboxImage();

        $("#lightbox").removeClass("d-none");
        document.body.style.overflow = "hidden";
    }

    function updateLightboxImage() {
        const listaImgs = imagenesPorSeccion[currentSeccion];
        $("#lightboxImg").attr("src", listaImgs[currentImgIndex].url);
    }

    // Botón Siguiente
    $("#btnNext").on("click", () => {
        const listaImgs = imagenesPorSeccion[currentSeccion];
        currentImgIndex = (currentImgIndex + 1) % listaImgs.length;
        updateLightboxImage();
    });

    // Botón Anterior
    $("#btnPrev").on("click", () => {
        const listaImgs = imagenesPorSeccion[currentSeccion];
        currentImgIndex = (currentImgIndex - 1 + listaImgs.length) % listaImgs.length;
        updateLightboxImage();
    });

    // Botón Cerrar
    $("#close, #lightbox").on("click", function (e) {
        if (e.target.id === "close" || e.target.id === "lightbox") {
            $("#lightbox").addClass("d-none");
            document.body.style.overflow = "";
        }
    });

    // Navegación con teclado
    document.addEventListener("keydown", (e) => {
        if ($("#lightbox").hasClass("d-none")) return;
        
        if (e.key === "ArrowRight") $("#btnNext").click();
        if (e.key === "ArrowLeft") $("#btnPrev").click();
        if (e.key === "Escape") $("#close").click();
    });

    // GUARDAR DIAGNÓSTICO PARA CADA SECCIÓN
    $(document).on("click", "#btnGuardarTrabajoBateria", () => guardarDiagnostico("Bateria"));
    $(document).on("click", "#btnGuardarTrabajoElectrico", () => guardarDiagnostico("Electrico"));
    $(document).on("click", "#btnGuardarTrabajoTraccion", () => guardarDiagnostico("Traccion"));
    $(document).on("click", "#btnGuardarTrabajoFrenos", () => guardarDiagnostico("Frenos"));
    $(document).on("click", "#btnGuardarTrabajoDireccion", () => guardarDiagnostico("Direccion"));
    $(document).on("click", "#btnGuardarTrabajoHidraulico", () => guardarDiagnostico("Hidraulico"));
    $(document).on("click", "#btnGuardarTrabajoMastil", () => guardarDiagnostico("Mastil"));
    $(document).on("click", "#btnGuardarTrabajoCarroPorta", () => guardarDiagnostico("CarroPorta"));
    $(document).on("click", "#btnGuardarTrabajoLubricacion", () => guardarDiagnostico("Lubricacion"));
    $(document).on("click", "#btnGuardarTrabajoHorquillas", function () {
        const clase = $("#selectClaseH").val() || "";
        const longitud = $("#inputLongitudH").val() || "";

        $("#hiddenClaseH").val(clase);
        $("#hiddenLongitudH").val(longitud);

        guardarDiagnostico("Horquillas");
    });
    $(document).on("click", "#btnGuardarTrabajoChasis", () => guardarDiagnostico("Chasis"));
    $(document).on("click", "#btnGuardarTrabajoRuedas", () => guardarDiagnostico("Ruedas"));
    $(document).on("click", "#btnGuardarTrabajoLuces", () => guardarDiagnostico("Luces"));
    $(document).on("click", "#btnGuardarTrabajoAditamentos", () => guardarDiagnostico("Aditamentos"));
    $(document).on("click", "#btnGuardarTrabajoCargador", () => guardarDiagnostico("Cargador"));
    $(document).on("click", "#btnGuardarTrabajoRevision", () => guardarDiagnostico("Revision"));
    $(document).on("click", "#btnGuardarTrabajoAuxiliares", () => guardarDiagnostico("Auxiliares"));
    $(document).on("click", "#btnGuardarTrabajoSuspension", () => guardarDiagnostico("Suspension"));
    $(document).on("click", "#btnGuardarTrabajoPantografo", () => guardarDiagnostico("Pantografo"));
    $(document).on("click", "#btnGuardarTrabajoMotor", () => guardarDiagnostico("Motor"));
    $(document).on("click", "#btnGuardarTrabajoRefrigeracion", () => guardarDiagnostico("Refrigeracion"));
    $(document).on("click", "#btnGuardarTrabajoCombustion", () => guardarDiagnostico("Combustion"));
    $(document).on("click", "#btnGuardarTrabajoTransmision", () => guardarDiagnostico("Transmision"));
    $(document).on("click", "#btnGuardarTrabajoCaja", () => guardarDiagnostico("Caja"));
    $(document).on("click", "#btnGuardarTrabajoComponentes", () => guardarDiagnostico("Componentes"));
    $(document).on("click", "#btnGuardarTrabajoAusencia", () => guardarDiagnostico("Ausencia"));
    $(document).on("click", "#btnGuardarTrabajoRevisiones", () => guardarDiagnostico("Revisiones"));
    $(document).on("click", "#btnGuardarTrabajoFuncionamiento", () => guardarDiagnostico("Funcionamiento"));
    $(document).on("click", "#btnGuardarTrabajoCorreas", () => guardarDiagnostico("Correas"));
    $(document).on("click", "#btnGuardarTrabajoUnidad", () => guardarDiagnostico("Unidad"));
    $(document).on("click", "#btnGuardarTrabajoPanel", () => guardarDiagnostico("Panel"));
    $(document).on("click", "#btnGuardarTrabajoPintura", () => guardarDiagnostico("Pintura"));
    $(document).on("click", "#btnGuardarTrabajoPintura1", () => guardarDiagnostico("Pintura1"));

    function guardarDiagnostico(seccion) {
        let faltanSelect = false;
        let faltanDescripciones = false;

        $(`#contenido${seccion} .criterio`).each(function () {
            const select = $(this);
            const num = select.data("num");
            const tipo = select.val();
            const cont = select.closest(".mb-3");
            const inputDesc = cont.find(".descripcionTrabajo");

            select.removeClass("is-invalid");
            inputDesc.removeClass("is-invalid");

            if (!tipo || tipo === "Seleccione") {
                faltanSelect = true;
                select.addClass("is-invalid");
            }

            if (!["Conforme", "NoAplica", "Seleccione"].includes(tipo) && !inputDesc.val().trim()) {
                faltanDescripciones = true;
                inputDesc.addClass("is-invalid");
            }

            $(`#hiddenCriterio_${num}`).val(tipo);
        });

        if (faltanSelect || faltanDescripciones) {
            Swal.fire({
                icon: "warning",
                title: faltanSelect ? "Faltan criterios" : "Faltan descripciones",
                text: faltanSelect 
                    ? "Todos los criterios deben tener un estado seleccionado." 
                    : "Debe completar la descripción en todos los trabajos que no sean Conforme o No Aplica."
            });
            return;
        }

        // Eliminar trabajos anteriores de esta sección
        trabajosRealizados = trabajosRealizados.filter(t => t.seccion !== seccion);

        // Insertar trabajos actualizados
        $(`#contenido${seccion} .criterio`).each(function () {
            const select = $(this);
            const num = select.data("num");
            const tipo = select.val();
            const label = select.closest(".mb-3").find("label").text();
            const descripcion = select.closest(".mb-3").find(".descripcionTrabajo").val() || "";

            if (!["Conforme", "NoAplica", "Seleccione"].includes(tipo)) {
                trabajosRealizados.push({
                    seccion,
                    criterio: num,
                    criterioLabel: label,
                    tipo,
                    descripcion
                });
            }
        });

        actualizarTablaTrabajos();

        Swal.fire({
            icon: "success",
            title: "Guardado",
            text: `Diagnóstico de ${seccion} guardado correctamente.`,
            timer: 1200,
            showConfirmButton: false
        }).then(() => {
            $(`#Modal${seccion}`).modal("hide");
            // Selección del enlace (padre del div)
            const cardLink = document.getElementById(`btn${seccion}Card`);
            const card = cardLink.querySelector('div');

            // Cambiar estilo de validado
            card.classList.remove('bg-light');
            card.classList.add('bg-validado');

            // BLOQUEO COMPLETO DEL CARD
            cardLink.classList.add("disabled");
            cardLink.style.pointerEvents = "none";
            cardLink.style.opacity = "0.5";
            cardLink.removeAttribute("data-open-modal");
        });
    }

    $(document).on("change", ".criterio", function () {
        const select = $(this);
        const tipo = select.val();
        const num = select.data("num");
        const descInput = select.closest(".mb-3").find(".descripcionTrabajo");
        const hidden = $(`#hiddenCriterio_${num}`);

        // Iconos
        const icon = $(this).next(".estado-icon");
        const iconos = {
            "Conforme": "✔️",
            "Nivelacion": "📏",
            "Ajuste": "⚙️",
            "Reparar": "⚠️",
            "Lubricacion": "🛢️",
            "NoAplica": "—"
        };
        icon.html(iconos[tipo] || "");

        // Estilos del select
        const clases = [
            "select-Conforme", "select-Nivelacion", "select-Ajuste",
            "select-Reparar", "select-Lubricacion", "select-NoAplica",
            "select-vacio"
        ];
        select.removeClass(clases.join(" "));
        select.addClass("select-" + (tipo || "vacio"));

        // Mostrar u ocultar descripción
        if (!["Conforme", "NoAplica", "Seleccione"].includes(tipo)) {
            descInput.show();
            const desc = descInput.val()?.trim() || "";
            hidden.val(`${tipo}|${desc}`);
        } else {
            descInput.hide().val("");
            hidden.val(tipo);
        }
    });

    $(document).on("input", ".descripcionTrabajo", function () {
        const input = $(this);
        const num = input.data("num");
        const tipo = $(`#selectCriterio_${num}`).val();
        const desc = input.val()?.trim() || "";
        
        if (!["Conforme", "NoAplica"].includes(tipo)) {
            $(`#hiddenCriterio_${num}`).val(`${tipo}|${desc}`);
        }
    });

    function restaurarDiagnostico(seccion) {
        $(`#contenido${seccion} .criterio`).each(function () {
            const select = $(this);
            const num = select.data("num");
            const hiddenValue = $(`#hiddenCriterio_${num}`).val() || "";
            const descripcionInput = select.closest(".mb-3").find(".descripcionTrabajo");

            if (hiddenValue.includes("|")) {
                const [tipo, desc] = hiddenValue.split("|");
                select.val(tipo);
                descripcionInput.val(desc).show();
            } else {
                select.val(hiddenValue);
                descripcionInput.hide().val("");
            }
        });

        // Muy importante: actualizar iconos u otros estilos si los tienes
        actualizarColoresIconos(seccion);
    }
    
    // TABLA DE TRABAJOS A REALIZAR
    function actualizarTablaTrabajos() {
        let html = trabajosRealizados.length === 0
            ? `<tr><td colspan="5" class="text-center">No hay trabajos registrados.</td></tr>`
            : "";

        trabajosRealizados.forEach((t, index) => {
          html += `
            <tr>
                <td>${t.seccion === "Pintura1" ? "Pintura" : t.seccion}</td>
                <td>${t.criterioLabel}</td>
                <td>${t.tipo}</td>
                <td class="descripcion">${t.descripcion}</td>
            </tr>`;
        });
        
        //trabajosRealizados.forEach((t, index) => {
        //    html += `
        //    <tr>
        //        <td>${t.seccion === "Pintura1" ? "Pintura" : t.seccion}</td>
        //        <td>${t.criterioLabel}</td>
        //        <td>${t.tipo}</td>
        //         <td class="descripcion">${t.descripcion}</td>
        //        <td>
        //            <button class="btn btn-danger btn-sm btnEliminarTrabajo" data-id="${index}">
        //                Eliminar
        //            </button>
        //        </td>
        //    </tr>`;
        //});

        $("#tablaTrabajosBody").html(html);
    }

    $(document).on("click", ".btnEliminarTrabajo", function () {
        const index = $(this).data("id");
        trabajosRealizados.splice(index, 1);
        actualizarTablaTrabajos();
    });

    function prepararEnvio() {
        document.getElementById("TrabajosRealizados").value = JSON.stringify(trabajosRealizados);
        return true;
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
        const Ingreso = document.getElementById("documentFormIngreso"); 
        if (Ingreso) {
            Ingreso.addEventListener("submit", function (e) {
                e.preventDefault(); 

                // Obtenemos valores seleccionados (usamos ? para evitar crash)
                const CentroSeleccionado = document.getElementById("ID_Centro1");
                const tipoMontacargas = document.getElementById("tipoMontacargas");
                const montacargasSelect = document.getElementById("ID_Montacargas");
                const operarioSelect = document.getElementById("ID_Operario");
                const areaSelect = document.getElementById("ID_Area");
                
                
                const centroTexto = CentroSeleccionado?.options[CentroSeleccionado.selectedIndex]?.text || "";
                const tipoMontacargasTexto = tipoMontacargas?.options[tipoMontacargas.selectedIndex]?.text || "";
                const montacargasTexto = montacargasSelect?.options[montacargasSelect.selectedIndex]?.text || "";
                const operarioTexto = operarioSelect?.options[operarioSelect.selectedIndex]?.text || "";
                const areaTexto = areaSelect?.options[areaSelect.selectedIndex]?.text || "";


                // Evitar error si no hay valor seleccionado
                const selectedOption = tipoMontacargas?.options[tipoMontacargas.selectedIndex];
                const selectedOption1 = montacargasSelect?.options[montacargasSelect.selectedIndex];

                const numeroMontacargas = selectedOption1?.text.split(" - ")[0] || "";
                const numeroSerie = selectedOption1?.text.split(" - ")[1] || "";
                const numeroModelo = selectedOption1?.dataset.modelo || "";
                const voltaje = selectedOption1?.dataset.voltaje || "";
                const horometro = selectedOption1?.dataset.horometro || "";
                const longitudh = selectedOption1?.dataset.longitudh || "";

                // ✅ Aquí llenamos los campos hidden con los IDs seleccionados
                document.getElementById("hiddenIDMontacargas").value = montacargasSelect?.value || "";
                document.getElementById("hiddenIDArea").value = areaSelect?.value || "";
                document.getElementById("hiddenIDOperario").value = operarioSelect?.value || "";
                document.getElementById("hiddentipoMontacargas").value = tipoMontacargas?.value || "";
                document.getElementById("hiddenIDCentro").value = CentroSeleccionado?.value || "";
                document.getElementById("hiddenLongitudH").value = longitudh || "";

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

                        validarTipoMontacargas();

                        const tituloModal = document.getElementById("agregarMantenimientoModalLabel");

                        if (tituloModal) {
                            let nuevoTitulo = "";
                            switch (tipoMontacargas?.value) {
                                case "combustion":
                                    nuevoTitulo = "Mantenimiento Preventivo Combustión";
                                    break;
                                case "pasillo":
                                    nuevoTitulo = "Mantenimiento Preventivo Pasillo Angosto";
                                    break;
                                case "contrabalanceada":
                                    nuevoTitulo = "Mantenimiento Preventivo Eléctrico Contrabalanceada";
                                    break;
                                case "manlift":
                                    nuevoTitulo = "Mantenimiento Preventivo Manlift";
                                    break;
                                default:
                                    nuevoTitulo = "Mantenimiento Preventivo";
                            }
                            tituloModal.textContent = nuevoTitulo;
                        }

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

        function validarTipoMontacargas() {
            const tipo = document.getElementById("hiddentipoMontacargas")?.value || "";
            const cardTrabajos1 = document.getElementById("btnTrabajosCard");
            const cardTrabajos2 = document.getElementById("btnTrabajosCard1");
            const cardTraccion = document.getElementById("btnTraccionCard");
            const cardDireccion = document.getElementById("btnDireccionCard");
            const cardMastil = document.getElementById("btnMastilCard");
            const cardCarroPorta = document.getElementById("btnCarroPortaCard");
            const cardHorquillas = document.getElementById("btnHorquillasCard");
            const cardChasis = document.getElementById("btnChasisCard");
            const cardLuces = document.getElementById("btnLucesCard");
            const cardAditamentos = document.getElementById("btnAditamentosCard");
            const cardCargador = document.getElementById("btnCargadorCard");
            const cardRevision = document.getElementById("btnRevisionCard");
            const cardAuxiliares = document.getElementById("btnAuxiliaresCard");
            const cardSuspension = document.getElementById("btnSuspensionCard");
            const cardPantografo = document.getElementById("btnPantografoCard");
            const cardMotor = document.getElementById("btnMotorCard");
            const cardRefrigeracion = document.getElementById("btnRefrigeracionCard");
            const cardCombustion = document.getElementById("btnCombustionCard");
            const cardTransmision = document.getElementById("btnTransmisionCard");
            const cardCaja = document.getElementById("btnCajaCard");
            const cardComponentes = document.getElementById("btnComponentesCard");
            const cardAusencia = document.getElementById("btnAusenciaCard");
            const cardRevisiones = document.getElementById("btnRevisionesCard");
            const cardFuncionamiento = document.getElementById("btnFuncionamientoCard");
            const cardCorreas = document.getElementById("btnCorreasCard");
            const cardUnidad = document.getElementById("btnUnidadCard");
            const cardPanel = document.getElementById("btnPanelCard");
            const cardPintura = document.getElementById("btnPinturaCard");
            const cardPintura1 = document.getElementById("btnPintura1Card");

            if (!cardTraccion) return;
            if (!cardDireccion) return;
            if (!cardMastil) return;
            if (!cardCarroPorta) return;
            if (!cardHorquillas) return;
            if (!cardChasis) return;
            if (!cardLuces) return;
            if (!cardCargador) return;
            if (!cardRevision) return;
            if (!cardAuxiliares) return;
            if (!cardSuspension) return;
            if (!cardPantografo) return;
            if (!cardMotor) return;
            if (!cardCombustion) return;
            if (!cardTransmision) return;
            if (!cardCaja) return;
            if (!cardTrabajos1) return;
            if (!cardTrabajos2) return;
            if (!cardComponentes) return;
            if (!cardAusencia) return;
            if (!cardRevisiones) return;
            if (!cardFuncionamiento) return;
            if (!cardCorreas) return;
            if (!cardUnidad) return;
            if (!cardPanel) return;
            if (!cardPintura) return;
            if (!cardPintura1) return;
            
            if (tipo === "pasillo" || tipo === "contrabalanceada") {
                cardTraccion.style.display = "block";
                cardLuces.style.display = "block";
            } else {
                cardTraccion.style.display = "none";
                cardLuces.style.display = "none";
            }

            if (tipo === "manlift" || tipo === "contrabalanceada" || tipo === "combustion") {
                cardDireccion.style.display = "block";
            } else {
                cardDireccion.style.display = "none";
            }

            if (tipo === "pasillo" || tipo === "contrabalanceada" || tipo === "combustion") {
                cardMastil.style.display = "block";
                cardHorquillas.style.display = "block";
                cardChasis.style.display = "block";
                cardRevision.style.display = "block";
                cardPintura.style.display = "block";
            } else {
                cardMastil.style.display = "none";
                cardHorquillas.style.display = "none";
                cardChasis.style.display = "none";
                cardRevision.style.display = "none";
                cardPintura.style.display = "none";
            }

            if (tipo === "pasillo" || tipo === "contrabalanceada" || tipo === "manlift") {
                cardCargador.style.display = "block";
                cardTrabajos1.style.display = "block";
            } else {
                cardCargador.style.display = "none";
                cardTrabajos1.style.display = "none";
            }

            if (tipo === "contrabalanceada") {
                cardCarroPorta.style.display = "block";
            } else {
                cardCarroPorta.style.display = "none";
            }

            if (tipo === "contrabalanceada" || tipo === "combustion") {
                cardAditamentos.style.display = "block";
            } else {
                cardAditamentos.style.display = "none";
            }

            if (tipo === "pasillo") {
                cardAuxiliares.style.display = "block";
                cardSuspension.style.display = "block";
                cardPantografo.style.display = "block";
            } else {
                cardAuxiliares.style.display = "none";
                cardSuspension.style.display = "none";
                cardPantografo.style.display = "none";
            }

            if (tipo === "combustion") {
                cardMotor.style.display = "block";
                cardRefrigeracion.style.display = "block";
                cardCombustion.style.display = "block";
                cardTransmision.style.display = "block";
                cardCaja.style.display = "block";
                cardTrabajos2.style.display = "block";
            } else {
                cardMotor.style.display = "none";
                cardRefrigeracion.style.display = "none";
                cardCombustion.style.display = "none";
                cardTransmision.style.display = "none";
                cardCaja.style.display = "none";
                cardTrabajos2.style.display = "none";
            }

            if (tipo === "manlift") {
                cardComponentes.style.display = "block";
                cardAusencia.style.display = "block";
                cardRevisiones.style.display = "block";
                cardFuncionamiento.style.display = "block";
                cardCorreas.style.display = "block";
                cardUnidad.style.display = "block";
                cardPanel.style.display = "block";
                cardPintura1.style.display = "block";
            } else {
                cardComponentes.style.display = "none";
                cardAusencia.style.display = "none";
                cardRevisiones.style.display = "none";
                cardFuncionamiento.style.display = "none";
                cardCorreas.style.display = "none";
                cardUnidad.style.display = "none";
                cardPanel.style.display = "none";
                cardPintura1.style.display = "none";
            }
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

    // Validacion de formulario antes de enviar
    document.addEventListener("DOMContentLoaded", function () {
        const documentFormMantenimiento = document.getElementById("documentFormMantenimiento");

        if (documentFormMantenimiento) {
            documentFormMantenimiento.addEventListener("submit", function (e) {
                e.preventDefault(); 

                // Validar supervisor
                const select = document.getElementById("Autoriza");
                if (select.value === "") {
                    alert("Por favor, selecciona un supervisor.");
                    return;
                }

                // 🔹 Normalizar criterios ocultos (1 al 131)
                for (let i = 1; i <= 131; i++) {
                    const hidden = document.getElementById(`hiddenCriterio_${i}`);
                    if (!hidden || !hidden.value) continue;

                    // Si contiene "|", conservar solo lo anterior
                    if (hidden.value.includes("|")) {
                        hidden.value = hidden.value.split("|")[0].trim();
                    }
                }

                // 👉 Enviar formulario al controlador
                documentFormMantenimiento.submit();
            });
        } else {
            console.warn("documentFormMantenimiento no encontrado. Verifica id del form en tu HTML.");
        }
    });
</script>
<?php require "App/Views/Templates/Layouts/Footer.php"; ?>
