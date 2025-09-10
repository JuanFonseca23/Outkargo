<?php
require_once "App/Views/Templates/Layouts/Header.php";
include_once "App/Controllers/CentroDeTrabajoController.php";
include_once "App/Controllers/MantenimientosController.php";

$CentrosDeTrabajo = new CentroDeTrabajoController;
$MantenimientosController = new MantenimientosController();
$ListaCentrosDeTrabajo = $CentrosDeTrabajo->TraerCentrosDeTrabajo();

$ID_Centro = isset($_GET['centro']) ? $_GET['centro'] : $_SESSION['NoCentro'];
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

    .select-Aplica {
        background-color: #e2e3e5 !important;
        /* gris claro */
    }

    .select-malo {
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
</style>
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-6 col-xl-3">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <img width="50" height="50" src="https://img.icons8.com/pastel-glyph/50/000020/hand-truck--v2.png" alt="hand-truck--v2"/>
                <div class="ms-3">
                    <p class="mb-2" style="color: #000020;">Preventivos Realizados</p>
                    <h6 class="mb-0" style="color: #000020;"></h6>
                </div>
            </div>
        </div>
        <a class="col-sm-6 col-xl-3" data-bs-toggle="modal" data-bs-target="#agregarMantenimiento">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <img width="50" height="50" src="https://img.icons8.com/pastel-glyph/100/000020/hand-truck--v1.png" alt="hand-truck--v2" style="transform: scaleX(-1);" />
                <div class="ms-3">
                    <p class="mb-2" style="color: #000020;">Preventivo</p>
                </div>
            </div>
        </a>
        <a class="col-sm-6 col-xl-3" href="#"></a>
        <a class="col-sm-6 col-xl-3" href="#"></a>
    </div>
</div>

<div class="container-fluid pt-4 px-4">
    <div class="bg-light text-center rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <form method="get" action="" class="mb-0">
                <h6 class="mb-0 d-flex align-items-center">
                    Preventivos Realizados |
                    <select name="centro" class="form-select form-select-sm d-inline w-auto ms-2" onchange="this.form.submit()">
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
                </h6>
            </form>

            <div>
                <a href="#">Ver Todas</a>
                <a>|</a>
                <a href="#">Descargar Excel</a>
            </div>
        </div>

        <!-- Tabla -->
        <div class="table-responsive">
            <table class="table text-start align-middle table-bordered table-hover mb-0" id="myTable">
                <thead>
                    <tr class="text-dark">
                        <th scope="col" class="text-center">N°</th>
                        <th scope="col" class="text-center">Nombre Ingresa</th>
                        <th scope="col">Nombre Supervisor</th>
                        <th scope="col" class="text-center">Estado</th>
                        <th scope="col" class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Aquí irían los datos -->
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
                <form id="documentForm" method="POST">
                    <div class="mb-3">
                        <label for="floatingSelect">Sección</label>
                        <input type="text" class="form-control" name= "Seccion" id="Seccion" placeholder="Sección" required>
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
                        <select class="form-select" name="ID_Montacargas" id="ID_Montacargas">
                            <option value="" disabled selected>Seleccione un montacargas</option>
                        </select>
                        <label for="floatingSelect">Seleccione operario quien reporta</label>
                        <select class="form-select" name="ID_Operario" id="ID_Operario">
                            <option value="" disabled selected>Seleccione operario</option>
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
                <h5 class="modal-title text-white" id="agregarMantenimientoModalLabel">Mantenimiento Preventivo Electrica Contrabalanceada</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="documentForm" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <!-- Informacion Montacaragas -->
                        <div class="col-md-4">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="numeroMontacargas">Montacargas</label>
                                    <input type="text" class="form-control" name="numeroMontacargas" id="numeroMontacargas" placeholder="22" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="nombreSección">Sección</label>
                                    <input type="text" class="form-control" name="nombreSección" id="nombreSección" placeholder="Dragueo" readonly>
                                </div>
                                <div class="col-md-12">
                                    <label for="numeroSerie">Serie</label>
                                    <input type="text" class="form-control" name="numeroSerie" id="numeroSerie" placeholder="<?= htmlspecialchars($_SESSION['NombreCompleto']) ?>" readonly>
                                    <label for="numeroModelo">Modelo</label>
                                    <input type="text" class="form-control" name="numeroModelo" id="numeroModelo" placeholder="<?= htmlspecialchars($_SESSION['NombreCompleto']) ?>" readonly>
                                    <label for="nombreCentro">Centro de Trabajo</label>
                                    <input type="text" class="form-control" name="nombreCentro" id="nombreCentro" placeholder="<?= htmlspecialchars($_SESSION['Centro']) ?>" readonly>
                                    <label for="nombreOperario">Operario</label>
                                    <input type="text" class="form-control" name="nombreOperario" id="nombreOperario" placeholder="<?= htmlspecialchars($_SESSION['NombreCompleto']) ?>" readonly>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="Voltaje">Voltaje</label>
                                        <input type="text" class="form-control" name="Voltaje" id="Voltaje" placeholder="36 V" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="Horometro">Horometro</label>
                                        <input type="text" class="form-control" name="Horometro" id="Horometro" placeholder="18000" readonly>
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
                                <a id="btnDireccionCard" class="col-sm-6 col-xl-4" href="#" data-open-modal="#ModalDireccion">
                                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-3">
                                        <img width="50" height="50" src="https://img.icons8.com/ios-filled/50/000020/steering-wheel.png" alt="steering-wheel" />
                                        <div class="ms-3">
                                            <p class="mb-2" style="color: #000020;">Sistema De Dirección</p>
                                        </div>
                                    </div>
                                </a>
                                <a id="btnTraccionCard" class="col-sm-6 col-xl-4" href="#" data-open-modal="#ModalTraccion">
                                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-3">
                                        <img width="50" height="50" src="https://img.icons8.com/ios-filled/50/000020/traction-control.png" alt="traction-control" />
                                        <div class="ms-3">
                                            <p class="mb-2" style="color: #000020;">Sistema De Tracción</p>
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
                                <a id="btnMastilCard" class="col-sm-6 col-xl-4" href="#" data-open-modal="#ModalMastil">
                                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-3">
                                        <img width="50" height="50" src="https://img.icons8.com/deco-glyph/50/000028/fork-lift.png" alt="fork-lift" />
                                        <div class="ms-3">
                                            <p class="mb-2" style="color: #000020;">Mastil</p>
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
                                <a id="btnLucesCard" class="col-sm-6 col-xl-4" href="#" data-open-modal="#ModalLuces">
                                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-3">
                                        <img width="50" height="50" src="https://img.icons8.com/ios-filled/50/000020/headlight.png" alt="headlight" />
                                        <div class="ms-3">
                                            <p class="mb-2" style="color: #000020;">Luces y Alarmas</p>
                                        </div>
                                    </div>
                                </a>
                                <a id="btnAditamentosCard"  class="col-sm-6 col-xl-4" href="#" data-open-modal="#ModalAditamientos">
                                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-3">
                                        <img width="50" height="50" src="https://img.icons8.com/ios-glyphs/50/000020/gearbox-selector.png" alt="gearbox-selector" />
                                        <div class="ms-3">
                                            <p class="mb-2" style="color: #000020;">Aditamentos</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <br>
                            <div class="row">
                                <a id="btnHorquillasCard" class="col-sm-6 col-xl-4" href="#" data-open-modal="#ModalHorquillas">
                                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-3">
                                        <img width="50" height="50" src="https://img.icons8.com/ios-filled/50/000020/l.png" alt="l" />
                                        <div class="ms-3">
                                            <p class="mb-2" style="color: #000020;">Horquillas</p>
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
                                <a id="btnChasisCard" class="col-sm-6 col-xl-4" href="#" data-open-modal="#ModalChasis">
                                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-3">
                                        <img width="50" height="50" src="https://img.icons8.com/ios-glyphs/50/000020/4x4-vehicle.png" alt="4x4-vehicle" />
                                        <div class="ms-3">
                                            <p class="mb-2" style="color: #000020;">Chasis</p>
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
                                <a id="btnCarroPortaCard" class="col-sm-6 col-xl-4" href="#" data-open-modal="#ModalCarroPorta">
                                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-3">
                                        <img width="50" height="50" src="https://img.icons8.com/sf-regular-filled/50/000020/mine-cart.png" alt="mine-cart" />
                                        <div class="ms-3">
                                            <p class="mb-2" style="color: #000020;">Carro Porta Horquillas</p>
                                        </div>
                                    </div>
                                </a>
                                <a id="btnRevisionCard" class="col-sm-6 col-xl-4" href="#" data-open-modal="#ModalRevision">
                                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-3">
                                        <img width="50" height="50" src="https://img.icons8.com/ios-filled/50/000020/fork-lift.png" alt="fork-lift" />
                                        <div class="ms-3">
                                            <p class="mb-2" style="color: #000020;">Revision De Equipo</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <br>
                            <div class="row">
                                <a id="btnCargadorCard" class="col-sm-6 col-xl-4" href="#" data-open-modal="#ModalCargador">
                                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-3">
                                      <img width="50" height="50" src="https://img.icons8.com/external-yogi-aprelliyanto-glyph-yogi-aprelliyanto/50/000020/external-power-supply-computer-hardware-yogi-aprelliyanto-glyph-yogi-aprelliyanto.png" alt="external-power-supply-computer-hardware-yogi-aprelliyanto-glyph-yogi-aprelliyanto"/>
                                        <div class="ms-3">
                                            <p class="mb-2" style="color: #000020;">Cargador</p>
                                        </div>
                                    </div>
                                </a>
                                <a id="btnInsumosCard" class="col-sm-6 col-xl-4" href="#" data-open-modal="#ModalInsumos">
                                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-3">
                                        <img width="50" height="50" src="https://img.icons8.com/fluency-systems-filled/50/000020/oil-industry.png" alt="oil-industry"/>
                                        <div class="ms-3">
                                            <p class="mb-2" style="color: #000020;">Insumos</p>
                                        </div>
                                    </div>
                                </a>
                                <a id="btnObservacionesCard" class="col-sm-6 col-xl-4" href="#" data-open-modal="#ModalObservaciones">
                                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-3">
                                        <img width="50" height="50" src="https://img.icons8.com/glyph-neue/50/000020/comments.png" alt="comments"/>
                                        <div class="ms-3">
                                            <p class="mb-2" style="color: #000020;">Observaciónes</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
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

<!-- Modal Batería -->
<div class="modal fade" id="ModalBateria" tabindex="-1" aria-labelledby="ModalBateriaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #000020;">
                <h5 class="modal-title text-white" id="ModalBateriaLabel">Diagnóstico: Batería</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <!-- Reutiliza este bloque para cada campo -->
                <div class="mb-3">
                    <label for="NumeroBateria" class="form-label">N° de Batería</label>
                    <input type="text" class="form-control" name="NumeroBateria" id="NumeroBateria" placeholder="# de batería" >
                </div>
                <div class="mb-3">
                    <label for="estadoCables" class="form-label">Estado de cables</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select me-2" id="estadoCables" name="Criterio_1" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoCables"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoElectrolito" class="form-label">Nivel de electrolito</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select me-2" id="estadoElectrolito" name="Criterio_2" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoElectrolito"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoConector" class="form-label">Conector Anderson</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select me-2" id="estadoConector" name="Criterio_3" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoConector"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoComportartimiento" class="form-label">Comportartimiento de la batería</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select me-2" id="estadoComportartimiento" name="Criterio_4" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoComportartimiento"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoBateria" class="form-label">Estado de batería</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select me-2" id="estadoBateria" name="Criterio_5" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoBateria"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoPuentes" class="form-label">Estado de los puentes</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select me-2" id="estadoPuentes" name="Criterio_6" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoPuentes"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Subir Imágenes del Diagnóstico</label>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-primary" id="btnTomarFoto">Tomar Foto</button>
                        <button type="button" class="btn btn-outline-secondary" id="btnCargarImagen">Cargar Imágenes</button>
                    </div>
                    <input class="form-control mt-2 d-none" type="file" id="imagenesDiagnosticoBateria" name="imagenesDiagnosticoBateria[]" accept="image/*" multiple capture="environment">
                </div>
                <button id="btnGuardarBateria" type="button" class="btn text-white" style="background-color: #000020;">Guardar Diagnóstico</button>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const selects = document.querySelectorAll('#ModalBateria select.form-select');
        const fileInput = document.getElementById('imagenesDiagnosticoBateria');
        const boton = document.getElementById('btnGuardarBateria');
        const btnTomarFoto = document.getElementById('btnTomarFoto');
        const btnCargarImagen = document.getElementById('btnCargarImagen');

    function actualizarEstado(select) {
        const icon = document.getElementById(`icon-${select.id}`);
        select.classList.remove('select-Conforme', 'select-Nivelacion', 'select-Ajuste', 'select-Lubricacion', 'select-malo', 'select-vacio', 'select-Aplica');

            if (select.value === 'Conforme') {
                icon.textContent = '✔️';
                icon.style.color = 'green';
                select.classList.add('select-Conforme');
            } else if (select.value === 'Reparación') {
                icon.textContent = '⚠️';
                icon.style.color = 'red';
                select.classList.add('select-malo');
            }else if (select.value === 'Nivelacion') {
                icon.textContent = '📏';
                icon.style.color = 'yellow';
                select.classList.add('select-Nivelacion');
            }else if (select.value === 'Ajuste') {
                icon.textContent = '⚙️';
                icon.style.color = 'Orange';
                select.classList.add('select-Ajuste'); 
            }else if (select.value === 'Lubricación') {
                icon.textContent = '🛢️';
                icon.style.color = 'Blue';
                select.classList.add('select-Lubricacion');
            }else if (select.value === 'NoAplica') {
                icon.textContent = '➖';
                icon.style.color = 'Gray';
                select.classList.add('select-Aplica'); 
            }else {
                icon.textContent = '❌';
                icon.style.color = 'red';
                select.classList.add('select-vacio');
            }
        } 

        selects.forEach(select => {
            select.addEventListener('change', () => actualizarEstado(select));
        });

        // Botón para tomar foto (cámara)
        btnTomarFoto.addEventListener('click', () => {
            fileInput.removeAttribute('multiple');
            fileInput.setAttribute('capture', 'environment');
            fileInput.click();
        });

        // Botón para cargar imágenes (galería/archivos)
        btnCargarImagen.addEventListener('click', () => {
            fileInput.setAttribute('multiple', 'true');
            fileInput.removeAttribute('capture');
            fileInput.click();
        });

        boton.addEventListener('click', () => {
            let valido = true;

            selects.forEach(select => {
                if (!select.value) {
                    actualizarEstado(select);
                    valido = false;
                }
            });

            if (fileInput.files.length === 0) {
                alert('Debe subir al menos una imagen del diagnóstico.');
                valido = false;
            }

            if (!valido) return;

            // ✅ Cambiar color del card
            const card = document.getElementById('btnBateriaCard').querySelector('div');
            card.classList.remove('bg-light');
            card.classList.add('bg-validado');

            // ❌ Cerrar modal actual
            const modalBateria = bootstrap.Modal.getInstance(document.getElementById('ModalBateria'));
            modalBateria.hide();

            // ✅ Abrir siguiente modal
            const modalAgregar = new bootstrap.Modal(document.getElementById('AgregarDiagnostico'));
            modalAgregar.show();
        });
    });
</script>

<!-- Sistema electrico -->
<div class="modal fade" id="ModalElectrico" tabindex="-1" aria-labelledby="ModalElectricoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #000020;">
                <h5 class="modal-title text-white" id="ModalElectricoLabel">Diagnóstico: Sistema Eléctrico</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="estadoPotencia" class="form-label">Cables de potencia</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoPotencia" name="Criterio_7" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoPotencia"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoDesconector" class="form-label">Desconector de emergencia</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoDesconector" name="Criterio_8" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoDesconector"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoControl" class="form-label">Cables de control</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoControl" name="Criterio_9" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoControl"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoConectores" class="form-label">Conectores</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoConectores" name="Criterio_10" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoConectores"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoFusibles" class="form-label">Fusibles</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoFusibles" name="Criterio_11" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoFusibles"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="NumeroControlador" class="form-label">N° de Controlador</label>
                    <input type="text" class="form-control" name="NumeroControlador" id="NumeroControlador" placeholder="# de Controlador" >
                </div>
                <div class="mb-3">
                    <label for="estadoControlador" class="form-label">Controlador</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoControlador" name="Criterio_12" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoControlador"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoDisplay" class="form-label">Display</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoDisplay" name="Criterio_13" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoDisplay"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoContactor" class="form-label">Contactor linea</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoContactor" name="Criterio_14" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoContactor"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoDireccion" class="form-label">Contactor direccion</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoDireccion" name="Criterio_15" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoDireccion"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoElevacion" class="form-label">Contactor elevacion</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoElevacion" name="Criterio_16" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoElevacion"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoMarcha" class="form-label">Contactor marcha</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoMarcha" name="Criterio_17" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoMarcha"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoMicros" class="form-label">Micros</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoMicros" name="Criterio_18" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoMicros"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoSwitch" class="form-label">Switch de ignicion</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoSwitch" name="Criterio_19" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoSwitch"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoPotenciometro" class="form-label">Potenciometro de aceleracion</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoPotenciometro" name="Criterio_20" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoPotenciometro"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Subir Imágenes del Diagnóstico</label>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-primary" id="btnTomarFotoElectrico">Tomar Foto</button>
                        <button type="button" class="btn btn-outline-secondary" id="btnCargarImagenElectrico">Cargar Imágenes</button>
                    </div>
                    <input class="form-control mt-2 d-none" type="file" id="imagenesDiagnosticoEletrico" name="imagenesDiagnosticoEletrico[]" accept="image/*" multiple capture="environment">
                </div>
                <button id="btnGuardarElectrico" type="button" class="btn text-white" style="background-color: #000020;">Guardar Diagnóstico</button>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const selectsElectrico = document.querySelectorAll('#ModalElectrico select.form-select');
        const fileInputElectrico = document.getElementById('imagenesDiagnosticoEletrico');
        const botonElectrico = document.getElementById('btnGuardarElectrico');
        const btnTomarFotoElectrico = document.getElementById('btnTomarFotoElectrico');
        const btnCargarImagenElectrico = document.getElementById('btnCargarImagenElectrico');

        function actualizarEstadoElectrico(selectElectrico) {
            const iconElectrico = document.getElementById(`icon-${selectElectrico.id}`);
            selectElectrico.classList.remove('select-Conforme', 'select-Nivelacion', 'select-Ajuste', 'select-Lubricacion', 'select-malo', 'select-vacio', 'select-Aplica');

            if (selectElectrico.value === 'Conforme') {
                iconElectrico.textContent = '✔️';
                iconElectrico.style.color = 'green';
                selectElectrico.classList.add('select-Conforme');
            } else if (selectElectrico.value === 'Reparación') {
                iconElectrico.textContent = '⚠️';
                iconElectrico.style.color = 'red';
                selectElectrico.classList.add('select-malo');
            }else if (selectElectrico.value === 'Nivelacion') {
                iconElectrico.textContent = '📏';
                iconElectrico.style.color = 'yellow';
                selectElectrico.classList.add('select-Nivelacion');
            }else if (selectElectrico.value === 'Ajuste') {
                iconElectrico.textContent = '⚙️';
                iconElectrico.style.color = 'Orange';
                selectElectrico.classList.add('select-Ajuste'); 
            }else if (selectElectrico.value === 'Lubricación') {
                iconElectrico.textContent = '🛢️';
                iconElectrico.style.color = 'Blue';
                selectElectrico.classList.add('select-Lubricacion');
            }else if (selectElectrico.value === 'NoAplica') {
                iconElectrico.textContent = '➖';
                iconElectrico.style.color = 'Gray';
                selectElectrico.classList.add('select-Aplica'); 
            }else {
                iconElectrico.textContent = '❌';
                iconElectrico.style.color = 'red';
                selectElectrico.classList.add('select-vacio');
            }
        }

        selectsElectrico.forEach(selectElectrico => {
            selectElectrico.addEventListener('change', () => actualizarEstadoElectrico(selectElectrico));
        });

        botonElectrico.addEventListener('click', () => {
            let valido = true;

            selectsElectrico.forEach(selectElectrico => {
                if (!selectElectrico.value) {
                    actualizarEstadoElectrico(selectElectrico);
                    valido = false;
                }
            });

            if (fileInputElectrico.files.length === 0) {
                alert('Debe subir al menos una imagen del diagnóstico.');
                valido = false;
            }

            if (!valido) return;

            // ✅ Cambiar color del card
            const card = document.getElementById('btnElectricoCard').querySelector('div');
            card.classList.remove('bg-light');
            card.classList.add('bg-validado');

            // ❌ Cerrar modal actual
            const ModalElectrico = bootstrap.Modal.getInstance(document.getElementById('ModalElectrico'));
            ModalElectrico.hide();

            // ✅ Abrir siguiente modal
            const modalAgregar = new bootstrap.Modal(document.getElementById('AgregarDiagnostico'));
            modalAgregar.show();
        });
    });
</script>

<!-- Sistema Traccion -->
<div class="modal fade" id="ModalTraccion" tabindex="-1" aria-labelledby="ModalTraccionLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #000020;">
                <h5 class="modal-title text-white" id="ModalTraccionLabel">Diagnóstico: Sistema Tracción</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="estadoMotor" class="form-label">Motor de tracción</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoMotor" name="estadoMotor" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoMotor"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoEscobillas" class="form-label">Escobillas</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoEscobillas" name="estadoEscobillas" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoEscobillas"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoMicros" class="form-label">Micros de marchas</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoMicros" name="estadoMicros" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoMicros"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoTransmision" class="form-label">Transmisión</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoTransmision" name="estadoTransmision" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoTransmision"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoValvulina" class="form-label">Nivel de valvulina</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoValvulina" name="estadoValvulina" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoValvulina"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoTornilleria" class="form-label">Tornilleria</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoTornilleria" name="estadoTornilleria" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoTornilleria"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Subir Imágenes del Diagnóstico</label>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-primary" id="btnTomarFotoTraccion">Tomar Foto</button>
                        <button type="button" class="btn btn-outline-secondary" id="btnCargarImagenTraccion">Cargar Imágenes</button>
                    </div>
                    <input class="form-control mt-2 d-none" type="file" id="imagenesDiagnosticoTraccion" name="imagenesDiagnosticoTraccion[]" accept="image/*" multiple capture="environment">
                </div>
                <button id="btnGuardarTraccion" type="button" class="btn text-white" style="background-color: #000020;">Guardar Diagnóstico</button>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const selectsTraccion = document.querySelectorAll('#ModalTraccion select.form-select');
        const fileInputTraccion = document.getElementById('imagenesDiagnosticoTraccion');
        const botonTraccion = document.getElementById('btnGuardarTraccion');
        const btnTomarFotoTraccion = document.getElementById('btnTomarFotoTraccion');
        const btnCargarImagenTraccion = document.getElementById('btnCargarImagenTraccion');

        function actualizarEstadoTraccion(selectTraccion) {
            const iconTraccion = document.getElementById(`icon-${selectTraccion.id}`);
            selectTraccion.classList.remove('select-Conforme', 'select-Nivelacion', 'select-Ajuste', 'select-Lubricacion', 'select-malo', 'select-vacio', 'select-Aplica');

            if (selectTraccion.value === 'Conforme') {
                iconTraccion.textContent = '✔️';
                iconTraccion.style.color = 'green';
                selectTraccion.classList.add('select-Conforme');
            } else if (selectTraccion.value === 'Reparación') {
                iconTraccion.textContent = '⚠️';
                iconTraccion.style.color = 'red';
                selectTraccion.classList.add('select-malo');
            }else if (selectTraccion.value === 'Nivelacion') {
                iconTraccion.textContent = '📏';
                iconTraccion.style.color = 'yellow';
                selectTraccion.classList.add('select-Nivelacion');
            }else if (selectTraccion.value === 'Ajuste') {
                iconTraccion.textContent = '⚙️';
                iconTraccion.style.color = 'Orange';
                selectTraccion.classList.add('select-Ajuste'); 
            }else if (selectTraccion.value === 'Lubricación') {
                iconTraccion.textContent = '🛢️';
                iconTraccion.style.color = 'Blue';
                selectTraccion.classList.add('select-Lubricacion');
            }else if (selectTraccion.value === 'NoAplica') {
                iconTraccion.textContent = '➖';
                iconTraccion.style.color = 'Gray';
                selectTraccion.classList.add('select-Aplica'); 
            }else {
                iconTraccion.textContent = '❌';
                iconTraccion.style.color = 'red';
                selectTraccion.classList.add('select-vacio');
            }
        }

        selectsTraccion.forEach(selectTraccion => {
            selectTraccion.addEventListener('change', () => actualizarEstadoTraccion(selectTraccion));
        });

        botonTraccion.addEventListener('click', () => {
            let valido = true;

            selectTraccion.forEach(selectTraccion => {
                if (!selectTraccion.value) {
                    actualizarEstadoTraccion(selectTraccion);
                    valido = false;
                }
            });

            if (fileInputTraccion.files.length === 0) {
                alert('Debe subir al menos una imagen del diagnóstico.');
                valido = false;
            }

            if (!valido) return;

            // ✅ Cambiar color del card
            const card = document.getElementById('btnTraccionCard').querySelector('div');
            card.classList.remove('bg-light');
            card.classList.add('bg-validado');

            // ❌ Cerrar modal actual
            const ModalTraccion = bootstrap.Modal.getInstance(document.getElementById('ModalTraccion'));
            ModalTraccion.hide();

            // ✅ Abrir siguiente modal
            const modalAgregar = new bootstrap.Modal(document.getElementById('AgregarDiagnostico'));
            modalAgregar.show();
        });
    });
</script>

<!-- Sistema de Frenos -->
<div class="modal fade" id="ModalFrenos" tabindex="-1" aria-labelledby="ModalFrenosLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #000020;">
                <h5 class="modal-title text-white" id="ModalFrenosLabel">Diagnóstico: Sistema de frenos</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="estadoLiquido" class="form-label">Liquido de frenos</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoLiquido" name="Criterio_30" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoLiquido"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoBomba2" class="form-label">Bomba de freno principal</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoBomba2" name="Criterio_31" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoBomba2"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoBandas" class="form-label">Estado de bandas</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoBandas" name="Criterio_32" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoBandas"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoRodamientos" class="form-label">Rodamientos</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoRodamientos" name="Criterio_33" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoRodamientos"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoFreno" class="form-label">Freno de estacionamiento</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoFreno" name="Criterio_34" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoFreno"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoFrenado" class="form-label">Eficiencia de frenado</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoFrenado" name="Criterio_35" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoFrenado"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoGuayas" class="form-label">Guayas de parqueo</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoGuayas" name="Criterio_36" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoGuayas"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoPedal" class="form-label">Pedal de freno</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoPedal" name="Criterio_37" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoPedal"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Subir Imágenes del Diagnóstico</label>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-primary" id="btnTomarFotoFrenos">Tomar Foto</button>
                        <button type="button" class="btn btn-outline-secondary" id="btnCargarImagenFrenos">Cargar Imágenes</button>
                    </div>
                    <input class="form-control mt-2 d-none" type="file" id="imagenesDiagnosticoFrenos" name="imagenesDiagnosticoFrenos[]" accept="image/*" multiple capture="environment">
                </div>
                <button id="btnGuardarFreno" type="button" class="btn text-white" style="background-color: #000020;">Guardar Diagnóstico</button>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const selectsFreno = document.querySelectorAll('#ModalFrenos select.form-select');
        const fileInputFreno = document.getElementById('imagenesDiagnosticoFrenos');
        const botonFreno = document.getElementById('btnGuardarFreno');
        const btnTomarFotoTraccion = document.getElementById('btnTomarFotoFrenos');
        const btnCargarImagenTraccion = document.getElementById('btnCargarImagenFrenos');

        function actualizarEstadoFreno(selectFreno) {
            const iconFreno = document.getElementById(`icon-${selectFreno.id}`);
            selectFreno.classList.remove('select-Conforme', 'select-Nivelacion', 'select-Ajuste', 'select-Lubricacion', 'select-malo', 'select-vacio', 'select-Aplica');

            if (selectFreno.value === 'Conforme') {
                iconFreno.textContent = '✔️';
                iconFreno.style.color = 'green';
                selectFreno.classList.add('select-Conforme');
            } else if (selectFreno.value === 'Reparación') {
                iconFreno.textContent = '⚠️';
                iconFreno.style.color = 'red';
                selectFreno.classList.add('select-malo');
            }else if (selectFreno.value === 'Nivelacion') {
                iconFreno.textContent = '📏';
                iconFreno.style.color = 'yellow';
                selectFreno.classList.add('select-Nivelacion');
            }else if (selectFreno.value === 'Ajuste') {
                iconFreno.textContent = '⚙️';
                iconFreno.style.color = 'Orange';
                selectFreno.classList.add('select-Ajuste'); 
            }else if (selectFreno.value === 'Lubricación') {
                iconFreno.textContent = '🛢️';
                iconFreno.style.color = 'Blue';
                selectFreno.classList.add('select-Lubricacion');
            }else if (selectFreno.value === 'NoAplica') {
                iconFreno.textContent = '➖';
                iconFreno.style.color = 'Gray';
                selectFreno.classList.add('select-Aplica'); 
            }else {
                iconFreno.textContent = '❌';
                iconFreno.style.color = 'red';
                selectFreno.classList.add('select-vacio');
            }
        }

        selectsFreno.forEach(selectFreno => {
            selectFreno.addEventListener('change', () => actualizarEstadoFreno(selectFreno));
        });

        botonFreno.addEventListener('click', () => {
            let valido = true;

            selectsFreno.forEach(selectFreno => {
                if (!selectFreno.value) {
                    actualizarEstadoFreno(selectFreno);
                    valido = false;
                }
            });

            if (fileInputFreno.files.length === 0) {
                alert('Debe subir al menos una imagen del diagnóstico.');
                valido = false;
            }

            if (!valido) return;

            // ✅ Cambiar color del card
            const card = document.getElementById('btnFrenosCard').querySelector('div');
            card.classList.remove('bg-light');
            card.classList.add('bg-validado');

            // ❌ Cerrar modal actual
            const ModalFreno = bootstrap.Modal.getInstance(document.getElementById('ModalFreno'));
            ModalFreno.hide();

            // ✅ Abrir siguiente modal
            const modalAgregar = new bootstrap.Modal(document.getElementById('AgregarDiagnostico'));
            modalAgregar.show();
        });
    });
</script>

<!-- Sistema de Dirección -->
<div class="modal fade" id="ModalDireccion" tabindex="-1" aria-labelledby="ModalDireccionLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #000020;">
                <h5 class="modal-title text-white" id="ModalDireccionLabel">Diagnóstico: Sistema Dirección</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="estadoMotor" class="form-label">Motor de dirección</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoMotorD" name="estadoMotor" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoMotorD"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoEscobillas" class="form-label">Escobillas</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoEscobillasD" name="estadoEscobillas" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoEscobillasD"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoBomba" class="form-label">Bomba de dirección</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoBomba" name="estadoBomba" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoBomba"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoMangueras" class="form-label">Mangueras</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoMangueras" name="estadoMangueras" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoMangueras"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoCilindro" class="form-label">Cilindro de dirección</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoCilindro" name="estadoCilindro" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoCilindro"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoCauchos" class="form-label">Cauchos puente trasero</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoCauchos" name="estadoCauchos" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoCauchos"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoRotulas" class="form-label">Rótulas</label>
                        <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoRotulas" name="estadoRotulas" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoRotulas"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoGuarda" class="form-label">Guarda polvo</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoGuarda" name="estadoGuarda" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoGuarda"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoRodamientos" class="form-label">Rodamientos</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoRodamientos" name="estadoRodamientos" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoRodamientos"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoOrbitrol" class="form-label">Orbitrol</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoOrbitrol" name="estadoOrbitrol" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoOrbitrol"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoTerminales" class="form-label">Terminales de dirección</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoTerminales" name="estadoTerminales" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoTerminales"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Subir Imágenes del Diagnóstico</label>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-primary" id="btnTomarFotoDireccion">Tomar Foto</button>
                        <button type="button" class="btn btn-outline-secondary" id="btnCargarImagenDireccion">Cargar Imágenes</button>
                    </div>
                    <input class="form-control mt-2 d-none" type="file" id="imagenesDiagnosticoDireccion" name="imagenesDiagnosticoDireccion[]" accept="image/*" multiple capture="environment">
                </div>
                <button id="btnGuardarDireccion" type="button" class="btn text-white" style="background-color: #000020;">Guardar Diagnóstico</button>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const selectsDireccion = document.querySelectorAll('#ModalDireccion select.form-select');
        const fileInputFreno = document.getElementById('imagenesDiagnosticoDireccion');
        const botonFreno = document.getElementById('btnGuardarDireccion');
        const btnTomarFotoTraccion = document.getElementById('btnTomarFotoDireccion');
        const btnCargarImagenTraccion = document.getElementById('btnCargarImagenDireccion');

        function actualizarEstadoDireccion(selectDireccion) {
            const iconDireccion = document.getElementById(`icon-${selectDireccion.id}`);
            selectDireccion.classList.remove('select-Conforme', 'select-Nivelacion', 'select-Ajuste', 'select-Lubricacion', 'select-malo', 'select-vacio', 'select-Aplica');

            if (selectDireccion.value === 'Conforme') {
                iconDireccion.textContent = '✔️';
                iconDireccion.style.color = 'green';
                selectDireccion.classList.add('select-Conforme');
            } else if (selectDireccion.value === 'Reparación') {
                iconDireccion.textContent = '⚠️';
                iconDireccion.style.color = 'red';
                selectDireccion.classList.add('select-malo');
            }else if (selectDireccion.value === 'Nivelacion') {
                iconDireccion.textContent = '📏';
                iconDireccion.style.color = 'yellow';
                selectDireccion.classList.add('select-Nivelacion');
            }else if (selectDireccion.value === 'Ajuste') {
                iconDireccion.textContent = '⚙️';
                iconDireccion.style.color = 'Orange';
                selectDireccion.classList.add('select-Ajuste'); 
            }else if (selectDireccion.value === 'Lubricación') {
                iconDireccion.textContent = '🛢️';
                iconDireccion.style.color = 'Blue';
                selectDireccion.classList.add('select-Lubricacion');
            }else if (selectDireccion.value === 'NoAplica') {
                iconDireccion.textContent = '➖';
                iconDireccion.style.color = 'Gray';
                selectDireccion.classList.add('select-Aplica'); 
            }else {
                iconDireccion.textContent = '❌';
                iconDireccion.style.color = 'red';
                selectDireccion.classList.add('select-vacio');
            }
        }

        selectsDireccion.forEach(selectDireccion => {
            selectDireccion.addEventListener('change', () => actualizarEstadoDireccion(selectDireccion));
        });

        botonFreno.addEventListener('click', () => {
            let valido = true;

            selectsDireccion.forEach(selectDireccion => {
                if (!selectDireccion.value) {
                    actualizarEstadoDireccion(selectDireccion);
                    valido = false;
                }
            });

            if (fileInputFreno.files.length === 0) {
                alert('Debe subir al menos una imagen del diagnóstico.');
                valido = false;
            }

            if (!valido) return;

            // ✅ Cambiar color del card
            const card = document.getElementById('btnDireccionCard').querySelector('div');
            card.classList.remove('bg-light');
            card.classList.add('bg-validado');

            // ❌ Cerrar modal actual
            const ModalDireccion = bootstrap.Modal.getInstance(document.getElementById('ModalDireccion'));
            ModalDireccion.hide();

            // ✅ Abrir siguiente modal
            const modalAgregar = new bootstrap.Modal(document.getElementById('AgregarDiagnostico'));
            modalAgregar.show();
        });
    });
</script>

<!-- Sistema de Hidraulico -->
<div class="modal fade" id="ModalHidraulico" tabindex="-1" aria-labelledby="ModalHidraulicoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #000020;">
                <h5 class="modal-title text-white" id="ModalHidraulicoLabel">Diagnóstico: Sistema Hidráulico</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="estadoHidraulico" class="form-label">Estado y nivel hidráulico</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoHidraulico" name="Criterio_21" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoHidraulico"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoMotor" class="form-label">Motor de sistema hidráulico</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoMotorH" name="Criterio_22" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoMotorH"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoEscobillas" class="form-label">Escobillas</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoEscobillasH" name="Criterio_23" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoEscobillasH"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoCaucho" class="form-label">Caucho absorbedor de golpe</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoCaucho" name="Criterio_24" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoCaucho"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoBomba" class="form-label">Bomba sistema hidráulico</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoBombaH" name="Criterio_25" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoBombaH"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoFiltro" class="form-label">Filtro de retorno</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoFiltro" name="Criterio_26" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoFiltro"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoValvulas" class="form-label">Cuerpo de válvulas</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoValvulas" name="Criterio_27" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoValvulas"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoMangueras" class="form-label">Mangueras</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoManguerasH" name="Criterio_28" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoManguerasH"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoMicros" class="form-label">Micros de funciones hidráulicas</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoMicros" name="Criterio_29" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoMicros"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Subir Imágenes del Diagnóstico</label>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-primary" id="btnTomarFotoHidraulico">Tomar Foto</button>
                        <button type="button" class="btn btn-outline-secondary" id="btnCargarImagenHidraulico">Cargar Imágenes</button>
                    </div>
                    <input class="form-control mt-2 d-none" type="file" id="imagenesDiagnosticoHidraulico" name="imagenesDiagnosticoHidraulico[]" accept="image/*" multiple capture="environment">
                </div>
                <button id="btnGuardarHidraulico" type="button" class="btn text-white" style="background-color: #000020;">Guardar Diagnóstico</button>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const selectsHidraulico = document.querySelectorAll('#ModalHidraulico select.form-select');
        const fileInputHidraulico = document.getElementById('imagenesDiagnosticoHidraulico');
        const botonHidraulico = document.getElementById('btnGuardarHidraulico');
        const btnTomarFotoTraccion = document.getElementById('btnTomarFotoHidraulico');
        const btnCargarImagenTraccion = document.getElementById('btnCargarImagenHidraulico');

        function actualizarEstadoHidraulico(selectHidraulico) {
            const iconHidraulico = document.getElementById(`icon-${selectHidraulico.id}`);
            selectHidraulico.classList.remove('select-Conforme', 'select-Nivelacion', 'select-Ajuste', 'select-Lubricacion', 'select-malo', 'select-vacio', 'select-Aplica');

            if (selectHidraulico.value === 'Conforme') {
                iconHidraulico.textContent = '✔️';
                iconHidraulico.style.color = 'green';
                selectHidraulico.classList.add('select-Conforme');
            } else if (selectHidraulico.value === 'Reparación') {
                iconHidraulico.textContent = '⚠️';
                iconHidraulico.style.color = 'red';
                selectHidraulico.classList.add('select-malo');
            }else if (selectHidraulico.value === 'Nivelacion') {
                iconHidraulico.textContent = '📏';
                iconHidraulico.style.color = 'yellow';
                selectHidraulico.classList.add('select-Nivelacion');
            }else if (selectHidraulico.value === 'Ajuste') {
                iconHidraulico.textContent = '⚙️';
                iconHidraulico.style.color = 'Orange';
                selectHidraulico.classList.add('select-Ajuste'); 
            }else if (selectHidraulico.value === 'Lubricación') {
                iconHidraulico.textContent = '🛢️';
                iconHidraulico.style.color = 'Blue';
                selectHidraulico.classList.add('select-Lubricacion');
            }else if (selectHidraulico.value === 'NoAplica') {
                iconHidraulico.textContent = '➖';
                iconHidraulico.style.color = 'Gray';
                selectHidraulico.classList.add('select-Aplica'); 
            }else {
                iconHidraulico.textContent = '❌';
                iconHidraulico.style.color = 'red';
                selectHidraulico.classList.add('select-vacio');
            }
        }

        selectsHidraulico.forEach(selectHidraulico => {
            selectHidraulico.addEventListener('change', () => actualizarEstadoHidraulico(selectHidraulico));
        });

        botonHidraulico.addEventListener('click', () => {
            let valido = true;

            selectsHidraulico.forEach(selectHidraulico => {
                if (!selectHidraulico.value) {
                    actualizarEstadoHidraulico(selectHidraulico);
                    valido = false;
                }
            });

            if (fileInputHidraulico.files.length === 0) {
                alert('Debe subir al menos una imagen del diagnóstico.');
                valido = false;
            }

            if (!valido) return;

            // ✅ Cambiar color del card
            const card = document.getElementById('btnHidraulicoCard').querySelector('div');
            card.classList.remove('bg-light');
            card.classList.add('bg-validado');

            // ❌ Cerrar modal actual
            const ModalHidraulico = bootstrap.Modal.getInstance(document.getElementById('ModalHidraulico'));
            ModalHidraulico.hide();

            // ✅ Abrir siguiente modal
            const modalAgregar = new bootstrap.Modal(document.getElementById('AgregarDiagnostico'));
            modalAgregar.show();
        });
    });
</script>

<!-- Sistema de Mastil -->
<div class="modal fade" id="ModalMastil" tabindex="-1" aria-labelledby="ModalMastilLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #000020;">
                <h5 class="modal-title text-white" id="ModalMastilLabel">Diagnóstico: Mastil</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="estadoMastil" class="form-label">Ajuste mastil</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoMastil" name="estadoMastil" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoMastil"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoSecciones" class="form-label">Estado secciones</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoSecciones" name="estadoSecciones" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoSecciones"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoBujes" class="form-label">Bujes</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoBujes" name="estadoBujes" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoBujes"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoRodamientos" class="form-label">Rodamientos</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoRodamientosM" name="estadoRodamientosM" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoRodamientosM"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoCadenas" class="form-label">Cadenas</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoCadenas" name="estadoCadenas" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoCadenas"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoPoleas" class="form-label">Poleas</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoPoleas" name="estadoPoleas" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoPoleas"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoPasadores" class="form-label">Pasadores cadenas</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoPasadores" name="estadoPasadores" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoPasadores"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoManguerasF" class="form-label">Mangueras free lift</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoManguerasF" name="estadoManguerasF" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoManguerasF"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoManguerasS" class="form-label">Mangueras side shift</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoManguerasS" name="estadoManguerasS" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoManguerasS"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoManguerasP" class="form-label">Mangueras fork positioner</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoManguerasP" name="estadoManguerasP" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoManguerasP"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoTuberias" class="form-label">Tuberías</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoTuberias" name="estadoTuberias" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoTuberias"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoRacores" class="form-label">Racores</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoRacores" name="estadoRacores" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoRacores"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoCilindrosI" class="form-label">Cilindros de inclinacion</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoCilindrosI" name="estadoCilindrosI" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoCilindrosI"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoCilindrosF" class="form-label">Cilindro de free lift</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoCilindrosF" name="estadoCilindrosF" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoCilindrosF"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoCilindrosL" class="form-label">Cilindros laterales</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoCilindrosL" name="estadoCilindrosL" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoCilindrosL"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoCilindrosS" class="form-label">Cilindro de side shift</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoCilindrosS" name="estadoCilindrosS" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoCilindrosS"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoCilindrosP" class="form-label">Cilindros de fork positioner</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoCilindrosP" name="estadoCilindrosP" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoCilindrosP"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Subir Imágenes del Diagnóstico</label>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-primary" id="btnTomarFotoMastil">Tomar Foto</button>
                        <button type="button" class="btn btn-outline-secondary" id="btnCargarImagenMastil">Cargar Imágenes</button>
                    </div>
                    <input class="form-control mt-2 d-none" type="file" id="imagenesDiagnosticoMastil" name="imagenesDiagnosticoMastil[]" accept="image/*" multiple capture="environment">
                </div>
                <button id="btnGuardarMastil" type="button" class="btn text-white" style="background-color: #000020;">Guardar Diagnóstico</button>
            </div>    
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const selectsMastil = document.querySelectorAll('#ModalMastil select.form-select');
        const fileInputMastil = document.getElementById('imagenesDiagnosticoMastil');
        const botonMastil = document.getElementById('btnGuardarMastil');
        const btnTomarFotoMastil = document.getElementById('btnTomarFotoMastil');
        const btnCargarImagenMastil = document.getElementById('btnCargarImagenMastil');

        function actualizarEstadoMastil(selectMastil) {
            const iconMastil = document.getElementById(`icon-${selectMastil.id}`);
            selectMastil.classList.remove('select-Conforme', 'select-Nivelacion', 'select-Ajuste', 'select-Lubricacion', 'select-malo', 'select-vacio', 'select-Aplica');

            if (selectMastil.value === 'Conforme') {
                iconMastil.textContent = '✔️';
                iconMastil.style.color = 'green';
                selectMastil.classList.add('select-Conforme');
            } else if (selectMastil.value === 'Reparación') {
                iconMastil.textContent = '⚠️';
                iconMastil.style.color = 'red';
                selectMastil.classList.add('select-malo');
            }else if (selectMastil.value === 'Nivelacion') {
                iconMastil.textContent = '📏';
                iconMastil.style.color = 'yellow';
                selectMastil.classList.add('select-Nivelacion');
            }else if (selectMastil.value === 'Ajuste') {
                iconMastil.textContent = '⚙️';
                iconMastil.style.color = 'Orange';
                selectMastil.classList.add('select-Ajuste'); 
            }else if (selectMastil.value === 'Lubricación') {
                iconMastil.textContent = '🛢️';
                iconMastil.style.color = 'Blue';
                selectMastil.classList.add('select-Lubricacion');
            }else if (selectMastil.value === 'NoAplica') {
                iconMastil.textContent = '➖';
                iconMastil.style.color = 'Gray';
                selectMastil.classList.add('select-Aplica'); 
            }else {
                iconMastil.textContent = '❌';
                iconMastil.style.color = 'red';
                selectMastil.classList.add('select-vacio');
            }
        }

        selectsMastil.forEach(selectMastil => {
            selectMastil.addEventListener('change', () => actualizarEstadoMastil(selectMastil));
        });

        botonMastil.addEventListener('click', () => {
            let valido = true;

            selectsMastil.forEach(selectMastil => {
                if (!selectMastil.value) {
                    actualizarEstadoMastil(selectMastil);
                    valido = false;
                }
            });

            if (fileInputMastil.files.length === 0) {
                alert('Debe subir al menos una imagen del diagnóstico.');
                valido = false;
            }

            if (!valido) return;

            // ✅ Cambiar color del card
            const card = document.getElementById('btnHidraulicoCard').querySelector('div');
            card.classList.remove('bg-light');
            card.classList.add('bg-validado');

            // ❌ Cerrar modal actual
            const ModalMastil = bootstrap.Modal.getInstance(document.getElementById('ModalMastil'));
            ModalMastil.hide();

            // ✅ Abrir siguiente modal
            const modalAgregar = new bootstrap.Modal(document.getElementById('AgregarDiagnostico'));
            modalAgregar.show();
        });
    });
</script>

<!-- Modal Carro Porta Horquillas -->
<div class="modal fade" id="ModalCarroPorta" tabindex="-1" aria-labelledby="ModalCarroPortaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #000020;">
                <h5 class="modal-title text-white" id="ModalCarroPortaLabel">Diagnóstico: Carro Porta Horquillas</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="estadoAjuste" class="form-label">Ajuste carro porta horquillas</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoAjusteC" name="estadoAjusteC" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoAjusteC"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoRodamientos" class="form-label">Rodamientos</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoRodamientosC" name="estadoRodamientosC" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoRodamientosC"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoCadenas" class="form-label">Cadenas</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoCadenasC" name="estadoCadenasC" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoCadenasC"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoPasadores" class="form-label">Pasadores</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoPasadoresC" name="estadoPasadoresC" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoPasadoresC"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoParilla" class="form-label">Parilla o Espejo</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoParilla" name="estadoParilla" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoParilla"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoMordazas" class="form-label">Mordazas</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoMordazas" name="estadoMordazas" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoMordazas"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoDeslizadores" class="form-label">Deslizadores</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoDeslizadores" name="estadoDeslizadores" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoDeslizadores"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Subir Imágenes del Diagnóstico</label>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-primary" id="btnTomarFotoCarroPorta">Tomar Foto</button>
                        <button type="button" class="btn btn-outline-secondary" id="btnCargarImagenCarroPorta">Cargar Imágenes</button>
                    </div>
                    <input class="form-control mt-2 d-none" type="file" id="imagenesDiagnosticoCarroPorta" name="imagenesDiagnosticoCarroPorta[]" accept="image/*" multiple capture="environment">
                </div>
                <button id="btnGuardarCarroPorta"  type="button" class="btn text-white" style="background-color: #000020;">Guardar Diagnóstico</button>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const selectsCarroPorta= document.querySelectorAll('#ModalCarroPorta select.form-select');
        const fileInputCarroPorta = document.getElementById('imagenesDiagnosticoCarroPorta');
        const botonCarroPorta = document.getElementById('btnGuardarCarroPorta');
        const btnTomarFotoCarroPorta = document.getElementById('btnTomarFotoCarroPorta');
        const btnCargarImagenCarroPorta = document.getElementById('btnCargarImagenCarroPorta');

        function actualizarEstadoCarroPorta(selectCarroPorta) {
            const iconCarroPorta = document.getElementById(`icon-${selectCarroPorta.id}`);
            selectCarroPorta.classList.remove('select-Conforme', 'select-Nivelacion', 'select-Ajuste', 'select-Lubricacion', 'select-malo', 'select-vacio', 'select-Aplica');

            if (selectCarroPorta.value === 'Conforme') {
                iconCarroPorta.textContent = '✔️';
                iconCarroPorta.style.color = 'green';
                selectCarroPorta.classList.add('select-Conforme');
            } else if (selectCarroPorta.value === 'Reparación') {
                iconCarroPorta.textContent = '⚠️';
                iconCarroPorta.style.color = 'red';
                selectCarroPorta.classList.add('select-malo');
            }else if (selectCarroPorta.value === 'Nivelacion') {
                iconCarroPorta.textContent = '📏';
                iconCarroPorta.style.color = 'yellow';
                selectCarroPorta.classList.add('select-Nivelacion');
            }else if (selectCarroPorta.value === 'Ajuste') {
                iconCarroPorta.textContent = '⚙️';
                iconCarroPorta.style.color = 'Orange';
                selectCarroPorta.classList.add('select-Ajuste'); 
            }else if (selectCarroPorta.value === 'Lubricación') {
                iconCarroPorta.textContent = '🛢️';
                iconCarroPorta.style.color = 'Blue';
                selectCarroPorta.classList.add('select-Lubricacion');
            }else if (selectCarroPorta.value === 'NoAplica') {
                iconCarroPorta.textContent = '➖';
                iconCarroPorta.style.color = 'Gray';
                selectCarroPorta.classList.add('select-Aplica'); 
            }else {
                iconCarroPorta.textContent = '❌';
                iconCarroPorta.style.color = 'red';
                selectCarroPorta.classList.add('select-vacio');
            }
        }

        selectsCarroPorta.forEach(selectCarroPorta => {
            selectCarroPorta.addEventListener('change', () => actualizarEstadoCarroPorta(selectCarroPorta));
        });

        botonCarroPorta.addEventListener('click', () => {
            let valido = true;

            selectsCarroPorta.forEach(selectCarroPorta => {
                if (!selectCarroPorta.value) {
                    actualizarEstadoCarroPorta(selectCarroPorta);
                    valido = false;
                }
            });

            if (fileInputCarroPorta.files.length === 0) {
                alert('Debe subir al menos una imagen del diagnóstico.');
                valido = false;
            }

            if (!valido) return;

            // ✅ Cambiar color del card
            const card = document.getElementById('btnCarroPortaCard').querySelector('div');
            card.classList.remove('bg-light');
            card.classList.add('bg-validado');

            // ❌ Cerrar modal actual
            const ModalCarroPorta = bootstrap.Modal.getInstance(document.getElementById('ModalCarroPorta'));
            ModalCarroPorta.hide();

            // ✅ Abrir siguiente modal
            const modalAgregar = new bootstrap.Modal(document.getElementById('AgregarDiagnostico'));
            modalAgregar.show();
        });
    });
</script>

<!-- Modal Aditamentos -->
<div class="modal fade" id="ModalAditamientos" tabindex="-1" aria-labelledby="ModalAditamientosLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #000020;">
                <h5 class="modal-title text-white" id="ModalAditamientosLabel">Diagnóstico: Aditamientos</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="estadoSideShift" class="form-label">Side shift</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoSideShift" name="estadoSideShift" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoSideShift"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoForkPositioner" class="form-label">Fork positioner</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoForkPositioner" name="estadoForkPositioner" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoForkPositioner"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoClamp" class="form-label">Clamp</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoClamp" name="estadoClamp" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoClamp"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoTubular" class="form-label">Cascade Tubular</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoTubular" name="estadoTubular" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoTubular"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Subir Imágenes del Diagnóstico</label>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-primary" id="btnTomarFotoAditamientos">Tomar Foto</button>
                        <button type="button" class="btn btn-outline-secondary" id="btnCargarImagenAditamientos">Cargar Imágenes</button>
                    </div>
                    <input class="form-control mt-2 d-none" type="file" id="imagenesDiagnosticoAditamientos" name="imagenesDiagnosticoAditamientos[]" accept="image/*" multiple capture="environment">
                </div>
                <button id="btnGuardarAditamientos" type="button" class="btn text-white" style="background-color: #000020;">Guardar Diagnóstico</button>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const selectsAditamientos= document.querySelectorAll('#ModalAditamientos select.form-select');
        const fileInputAditamientos = document.getElementById('imagenesDiagnosticoAditamientos');
        const botonAditamientos = document.getElementById('btnGuardarAditamientos');
        const btnTomarFotoAditamientos = document.getElementById('btnTomarFotoAditamientos');
        const btnCargarImagenAditamientos = document.getElementById('btnCargarImagenAditamientos');

        function actualizarEstadoAditamientos(selectAditamientos) {
            const iconAditamientos = document.getElementById(`icon-${selectAditamientos.id}`);
            selectAditamientos.classList.remove('select-Conforme', 'select-Nivelacion', 'select-Ajuste', 'select-Lubricacion', 'select-malo', 'select-vacio', 'select-Aplica');

            if (selectAditamientos.value === 'Conforme') {
                iconAditamientos.textContent = '✔️';
                iconAditamientos.style.color = 'green';
                selectAditamientos.classList.add('select-Conforme');
            } else if (selectAditamientos.value === 'Reparación') {
                iconAditamientos.textContent = '⚠️';
                iconAditamientos.style.color = 'red';
                selectAditamientos.classList.add('select-malo');
            }else if (selectAditamientos.value === 'Nivelacion') {
                iconAditamientos.textContent = '📏';
                iconAditamientos.style.color = 'yellow';
                selectAditamientos.classList.add('select-Nivelacion');
            }else if (selectAditamientos.value === 'Ajuste') {
                iconAditamientos.textContent = '⚙️';
                iconAditamientos.style.color = 'Orange';
                selectAditamientos.classList.add('select-Ajuste'); 
            }else if (selectAditamientos.value === 'Lubricación') {
                iconAditamientos.textContent = '🛢️';
                iconAditamientos.style.color = 'Blue';
                selectAditamientos.classList.add('select-Lubricacion');
            }else if (selectAditamientos.value === 'NoAplica') {
                iconAditamientos.textContent = '➖';
                iconAditamientos.style.color = 'Gray';
                selectAditamientos.classList.add('select-Aplica'); 
            }else {
                iconAditamientos.textContent = '❌';
                iconAditamientos.style.color = 'red';
                selectAditamientos.classList.add('select-vacio');
            }
        }

        selectsAditamientos.forEach(selectAditamientos => {
            selectAditamientos.addEventListener('change', () => actualizarEstadoAditamientos(selectAditamientos));
        });

        botonCarroPorta.addEventListener('click', () => {
            let valido = true;

            selectsAditamientos.forEach(selectAditamientos => {
                if (!selectAditamientos.value) {
                    actualizarEstadoAditamientos(selectAditamientos);
                    valido = false;
                }
            });

            if (fileInputAditamientos.files.length === 0) {
                alert('Debe subir al menos una imagen del diagnóstico.');
                valido = false;
            }

            if (!valido) return;

            // ✅ Cambiar color del card
            const card = document.getElementById('btnAditamentosCard').querySelector('div');
            card.classList.remove('bg-light');
            card.classList.add('bg-validado');

            // ❌ Cerrar modal actual
            const ModalAditamientos = bootstrap.Modal.getInstance(document.getElementById('ModalAditamientos'));
            ModalAditamientos.hide();

            // ✅ Abrir siguiente modal
            const modalAgregar = new bootstrap.Modal(document.getElementById('AgregarDiagnostico'));
            modalAgregar.show();
        });
    });
</script>

<!-- Modal Horquillas -->
<div class="modal fade" id="ModalHorquillas" tabindex="-1" aria-labelledby="ModalHorquillasLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #000020;">
                <h5 class="modal-title text-white" id="ModalHorquillasLabel">Diagnóstico: Horquillas</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="estadoSeguros" class="form-label">Seguros</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoSeguros" name="estadoSeguros" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoSeguros"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoMordazaS" class="form-label">Mordaza superior</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoMordazaS" name="estadoMordazaS" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoMordazaS"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoMordazaI" class="form-label">Mordaza inferior</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoMordazaI" name="estadoMordazaI" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoMordazaI"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="claseHorquilllas" class="form-label">Clase de horquillas</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="claseHorquilllas" name="claseHorquilllas" required>
                            <option value="Tipo2" disabled selected>Clase 2</option>
                            <option value="Tipo3">Clase 3</option>
                            <option value="Tipo4">Clase 4</option>
                        </select>
                        <span class="estado-icon" id="icon-claseHorquilllas"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Longitud" class="form-label">Longitud (m)</label>
                    <input type="text" class="form-control" name="Longitud" id="Longitud" placeholder="Longitud" >
                </div>
                <div class="mb-3">
                    <label for="estadoHorquillas" class="form-label">Estado de horquillas (inspección visual ver F-206 como referencia)</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoHorquillas" name="estadoHorquillas" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoHorquillas"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Subir Imágenes del Diagnóstico</label>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-primary" id="btnTomarFotoHorquillas">Tomar Foto</button>
                        <button type="button" class="btn btn-outline-secondary" id="btnCargarImagenHorquillas">Cargar Imágenes</button>
                    </div>
                    <input class="form-control mt-2 d-none" type="file" id="imagenesDiagnosticoHorquillas" name="imagenesDiagnosticoHorquillas[]" accept="image/*" multiple capture="environment">
                </div>
                <button id="btnGuardarHorquillas" type="button" class="btn text-white" style="background-color: #000020;">Guardar Diagnóstico</button>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const selectsHorquillas= document.querySelectorAll('#ModalHorquillas select.form-select');
        const fileInputHorquillas = document.getElementById('imagenesDiagnosticoHorquillas');
        const botonHorquillas = document.getElementById('btnGuardarHorquillas');
        const btnTomarFotoHorquillas = document.getElementById('btnTomarFotoHorquillas');
        const btnCargarImagenHorquillas = document.getElementById('btnCargarImagenHorquillas');

        function actualizarEstadoHorquillas(selectHorquillas) {
            const iconHorquillas = document.getElementById(`icon-${selectHorquillas.id}`);
            selectHorquillas.classList.remove('select-Conforme', 'select-Nivelacion', 'select-Ajuste', 'select-Lubricacion', 'select-malo', 'select-vacio', 'select-Aplica');

            if (selectHorquillas.value === 'Conforme') {
                iconHorquillas.textContent = '✔️';
                iconHorquillas.style.color = 'green';
                selectHorquillas.classList.add('select-Conforme');
            } else if (selectHorquillas.value === 'Reparación') {
                iconHorquillas.textContent = '⚠️';
                iconHorquillas.style.color = 'red';
                selectHorquillas.classList.add('select-malo');
            }else if (selectHorquillas.value === 'Nivelacion') {
                iconHorquillas.textContent = '📏';
                iconHorquillas.style.color = 'yellow';
                selectHorquillas.classList.add('select-Nivelacion');
            }else if (selectHorquillas.value === 'Ajuste') {
                iconHorquillas.textContent = '⚙️';
                iconHorquillas.style.color = 'Orange';
                selectHorquillas.classList.add('select-Ajuste'); 
            }else if (selectHorquillas.value === 'Lubricación') {
                iconHorquillas.textContent = '🛢️';
                iconHorquillas.style.color = 'Blue';
                selectHorquillas.classList.add('select-Lubricacion');
            }else if (selectHorquillas.value === 'NoAplica') {
                iconHorquillas.textContent = '➖';
                iconHorquillas.style.color = 'Gray';
                selectHorquillas.classList.add('select-Aplica'); 
            }else if (selectHorquillas.value === 'Tipo2' || selectHorquillas.value === 'Tipo3' || selectHorquillas.value === 'Tipo4') {
                iconHorquillas.textContent = '✔️';
                iconHorquillas.style.color = 'green';
            }else {
                iconHorquillas.textContent = '❌';
                iconHorquillas.style.color = 'red';
                selectHorquillas.classList.add('select-vacio');
            }
        }

        selectsHorquillas.forEach(selectHorquillas => {
            selectHorquillas.addEventListener('change', () => actualizarEstadoHorquillas(selectHorquillas));
        });

        botonHorquillas.addEventListener('click', () => {
            let valido = true;

            selectsHorquillas.forEach(selectHorquillas => {
                if (!selectHorquillas.value) {
                    actualizarEstadoHorquillas(selectHorquillas);
                    valido = false;
                }
            });

            if (fileInputHorquillas.files.length === 0) {
                alert('Debe subir al menos una imagen del diagnóstico.');
                valido = false;
            }

            if (!valido) return;

            // ✅ Cambiar color del card
            const card = document.getElementById('btnHorquillasCard').querySelector('div');
            card.classList.remove('bg-light');
            card.classList.add('bg-validado');

            // ❌ Cerrar modal actual
            const ModalHorquillas = bootstrap.Modal.getInstance(document.getElementById('ModalHorquillas'));
            ModalHorquillas.hide();

            // ✅ Abrir siguiente modal
            const modalAgregar = new bootstrap.Modal(document.getElementById('AgregarDiagnostico'));
            modalAgregar.show();
        });
    });
</script>

<!-- Modal Ruedas -->
<div class="modal fade" id="ModalRuedas" tabindex="-1" aria-labelledby="ModalRuedasLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #000020;">
                <h5 class="modal-title text-white" id="ModalRuedasLabel">Diagnóstico: Ruedas</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="estadoRuedasC" class="form-label">Degaste de caucho de ruedas de carga</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoRuedasC" name="estadoRuedasC" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoRuedasC"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoRuedasD" class="form-label">Degaste de caucho de ruedas de dirección</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoRuedasD" name="estadoRuedasD" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoRuedasD"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoRinC" class="form-label">Estado de rin de carga</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoRinC" name="estadoRinC" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoRinC"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoRinD" class="form-label">Estado de rin de dirección</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoRinD" name="estadoRinD" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoRinD"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoLimpieza" class="form-label">Limpieza</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoLimpieza" name="estadoLimpieza" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoLimpieza"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Subir Imágenes del Diagnóstico</label>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-primary" id="btnTomarFotoRuedas">Tomar Foto</button>
                        <button type="button" class="btn btn-outline-secondary" id="btnCargarImagenRuedas">Cargar Imágenes</button>
                    </div>
                    <input class="form-control mt-2 d-none" type="file" id="imagenesDiagnosticoRuedas" name="imagenesDiagnosticoRuedas[]" accept="image/*" multiple capture="environment">
                </div>
                <button id="btnGuardarRuedas" type="button" class="btn text-white" style="background-color: #000020;">Guardar Diagnóstico</button>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const selectsRuedas= document.querySelectorAll('#ModalRuedas select.form-select');
        const fileInputRuedas = document.getElementById('imagenesDiagnosticoRuedas');
        const botonRuedas = document.getElementById('btnGuardarRuedas');
        const btnTomarFotoRuedas = document.getElementById('btnTomarFotoRuedas');
        const btnCargarImagenRuedas = document.getElementById('btnCargarImagenRuedas');

        function actualizarEstadoRuedas(selectRuedas) {
            const iconRuedas = document.getElementById(`icon-${selectRuedas.id}`);
            selectRuedas.classList.remove('select-Conforme', 'select-Nivelacion', 'select-Ajuste', 'select-Lubricacion', 'select-malo', 'select-vacio', 'select-Aplica');

            if (selectRuedas.value === 'Conforme') {
                iconRuedas.textContent = '✔️';
                iconRuedas.style.color = 'green';
                selectRuedas.classList.add('select-Conforme');
            } else if (selectRuedas.value === 'Reparación') {
                iconRuedas.textContent = '⚠️';
                iconRuedas.style.color = 'red';
                selectRuedas.classList.add('select-malo');
            }else if (selectRuedas.value === 'Nivelacion') {
                iconRuedas.textContent = '📏';
                iconRuedas.style.color = 'yellow';
                selectRuedas.classList.add('select-Nivelacion');
            }else if (selectRuedas.value === 'Ajuste') {
                iconRuedas.textContent = '⚙️';
                iconRuedas.style.color = 'Orange';
                selectRuedas.classList.add('select-Ajuste'); 
            }else if (selectRuedas.value === 'Lubricación') {
                iconRuedas.textContent = '🛢️';
                iconRuedas.style.color = 'Blue';
                selectRuedas.classList.add('select-Lubricacion');
            }else if (selectRuedas.value === 'NoAplica') {
                iconRuedas.textContent = '➖';
                iconRuedas.style.color = 'Gray';
                selectRuedas.classList.add('select-Aplica'); 
            }else {
                iconRuedas.textContent = '❌';
                iconRuedas.style.color = 'red';
                selectRuedas.classList.add('select-vacio');
            }
        }

        selectsRuedas.forEach(selectRuedas => {
            selectRuedas.addEventListener('change', () => actualizarEstadoRuedas(selectRuedas));
        });

        botonRuedas.addEventListener('click', () => {
            let valido = true;

            selectsRuedas.forEach(selectRuedas => {
                if (!selectRuedas.value) {
                    actualizarEstadoRuedas(selectRuedas);
                    valido = false;
                }
            });

            if (fileInputRuedas.files.length === 0) {
                alert('Debe subir al menos una imagen del diagnóstico.');
                valido = false;
            }

            if (!valido) return;

            // ✅ Cambiar color del card
            const card = document.getElementById('btnRuedasCard').querySelector('div');
            card.classList.remove('bg-light');
            card.classList.add('bg-validado');

            // ❌ Cerrar modal actual
            const ModalRuedas = bootstrap.Modal.getInstance(document.getElementById('ModalRuedas'));
            ModalRuedas.hide();

            // ✅ Abrir siguiente modal
            const modalAgregar = new bootstrap.Modal(document.getElementById('AgregarDiagnostico'));
            modalAgregar.show();
        });
    });
</script>

<!-- Modal Chasis -->
<div class="modal fade" id="ModalChasis" tabindex="-1" aria-labelledby="ModalChasisLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #000020;">
                <h5 class="modal-title text-white" id="ModalChasisLabel">Diagnóstico: Chasis</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="estadoConjunto" class="form-label">Ajustes de conjunto</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoConjunto" name="estadoConjunto" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoConjunto"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoSoportes" class="form-label">Chequear soportes</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoSoportes" name="estadoSoportes" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoSoportes"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoTornilleria" class="form-label">Tornilleria</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoTornilleria" name="estadoTornilleria" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoTornilleria"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoPintura" class="form-label">Estado pintura</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoPintura" name="estadoPintura" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoPintura"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Subir Imágenes del Diagnóstico</label>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-primary" id="btnTomarFotoChasis">Tomar Foto</button>
                        <button type="button" class="btn btn-outline-secondary" id="btnCargarImagenChasis">Cargar Imágenes</button>
                    </div>
                    <input class="form-control mt-2 d-none" type="file" id="imagenesDiagnosticoChasis" name="imagenesDiagnosticoChasis[]" accept="image/*" multiple capture="environment">
                </div>
                <button id="btnGuardarChasis" type="button" class="btn text-white" style="background-color: #000020;">Guardar Diagnóstico</button>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const selectsChasis = document.querySelectorAll('#ModalChasis select.form-select');
        const fileInputChasis = document.getElementById('imagenesDiagnosticoChasis');
        const botonChasis = document.getElementById('btnGuardarChasis');
        const btnTomarFotoChasis = document.getElementById('btnTomarFotoChasis');
        const btnCargarImagenChasis = document.getElementById('btnCargarImagenChasis');

        function actualizarEstadoChasis(selectChasis) {
            const iconChasis = document.getElementById(`icon-${selectChasis.id}`);
            selectChasis.classList.remove('select-Conforme', 'select-Nivelacion', 'select-Ajuste', 'select-Lubricacion', 'select-malo', 'select-vacio', 'select-Aplica');

            if (selectChasis.value === 'Conforme') {
                iconChasis.textContent = '✔️';
                iconChasis.style.color = 'green';
                selectChasis.classList.add('select-Conforme');
            } else if (selectChasis.value === 'Reparación') {
                iconChasis.textContent = '⚠️';
                iconChasis.style.color = 'red';
                selectChasis.classList.add('select-malo');
            }else if (selectChasis.value === 'Nivelacion') {
                iconChasis.textContent = '📏';
                iconChasis.style.color = 'yellow';
                selectChasis.classList.add('select-Nivelacion');
            }else if (selectChasis.value === 'Ajuste') {
                iconChasis.textContent = '⚙️';
                iconChasis.style.color = 'Orange';
                selectChasis.classList.add('select-Ajuste'); 
            }else if (selectChasis.value === 'Lubricación') {
                iconChasis.textContent = '🛢️';
                iconChasis.style.color = 'Blue';
                selectChasis.classList.add('select-Lubricacion');
            }else if (selectChasis.value === 'NoAplica') {
                iconChasis.textContent = '➖';
                iconChasis.style.color = 'Gray';
                selectChasis.classList.add('select-Aplica'); 
            }else {
                iconChasis.textContent = '❌';
                iconChasis.style.color = 'red';
                selectChasis.classList.add('select-vacio');
            }
        }

        selectsChasis.forEach(selectChasis => {
            selectChasis.addEventListener('change', () => actualizarEstadoChasis(selectChasis));
        });

        botonChasis.addEventListener('click', () => {
            let valido = true;

            selectsChasis.forEach(selectChasis => {
                if (!selectChasis.value) {
                    actualizarEstadoChasis(selectChasis);
                    valido = false;
                }
            });

            if (fileInputChasis.files.length === 0) {
                alert('Debe subir al menos una imagen del diagnóstico.');
                valido = false;
            }

            if (!valido) return;

            // ✅ Cambiar color del card
            const card = document.getElementById('btnChasisCard').querySelector('div');
            card.classList.remove('bg-light');
            card.classList.add('bg-validado');

            // ❌ Cerrar modal actual
            const ModalChasis = bootstrap.Modal.getInstance(document.getElementById('ModalChasis'));
            ModalChasis.hide();

            // ✅ Abrir siguiente modal
            const modalAgregar = new bootstrap.Modal(document.getElementById('AgregarDiagnostico'));
            modalAgregar.show();
        });
    });
</script>

<!-- Modal Luces y Alarmas -->
<div class="modal fade" id="ModalLuces" tabindex="-1" aria-labelledby="ModalLucesLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #000020;">
                <h5 class="modal-title text-white" id="ModalLucesLabel">Diagnóstico: Luces y alarmas </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="estadoLucesF" class="form-label">Luces frontales</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoLucesF" name="estadoLucesF" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoLucesF"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoLuzE" class="form-label">Luz estroboscopia</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoLuzE" name="estadoLuzE" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoLuzE"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoLuzF" class="form-label">Luz de freno</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoLuzF" name="estadoLuzF" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoLuzF"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoBlue" class="form-label">Blue light</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoTapas" name="estadoTapas" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoTapas"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoPito" class="form-label">Pito bocina</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoPito" name="estadoPito" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoPito"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoAlarma" class="form-label">Alarma reversa</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoAlarma" name="estadoAlarma" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoAlarma"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Subir Imágenes del Diagnóstico</label>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-primary" id="btnTomarFotoLuces">Tomar Foto</button>
                        <button type="button" class="btn btn-outline-secondary" id="btnCargarImagenLuces">Cargar Imágenes</button>
                    </div>
                    <input class="form-control mt-2 d-none" type="file" id="imagenesDiagnosticoLuces" name="imagenesDiagnosticoLuces[]" accept="image/*" multiple capture="environment">
                </div>
                <button id="btnGuardarLuces" type="button" class="btn text-white" style="background-color: #000020;">Guardar Diagnóstico</button>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const selectsLuces = document.querySelectorAll('#ModalLuces select.form-select');
        const fileInputLuces = document.getElementById('imagenesDiagnosticoLuces');
        const botonLuces = document.getElementById('btnGuardarLuces');
        const btnTomarFotoLuces = document.getElementById('btnTomarFotoLuces');
        const btnCargarImagenLuces = document.getElementById('btnCargarImagenLuces');

        function actualizarEstadoLuces(selectLuces) {
            const iconLuces = document.getElementById(`icon-${selectLuces.id}`);
            selectLuces.classList.remove('select-Conforme', 'select-Nivelacion', 'select-Ajuste', 'select-Lubricacion', 'select-malo', 'select-vacio', 'select-Aplica');

            if (selectLuces.value === 'Conforme') {
                iconLuces.textContent = '✔️';
                iconLuces.style.color = 'green';
                selectLuces.classList.add('select-Conforme');
            } else if (selectLuces.value === 'Reparación') {
                iconLuces.textContent = '⚠️';
                iconLuces.style.color = 'red';
                selectLuces.classList.add('select-malo');
            }else if (selectLuces.value === 'Nivelacion') {
                iconLuces.textContent = '📏';
                iconLuces.style.color = 'yellow';
                selectLuces.classList.add('select-Nivelacion');
            }else if (selectLuces.value === 'Ajuste') {
                iconLuces.textContent = '⚙️';
                iconLuces.style.color = 'Orange';
                selectLuces.classList.add('select-Ajuste'); 
            }else if (selectLuces.value === 'Lubricación') {
                iconLuces.textContent = '🛢️';
                iconLuces.style.color = 'Blue';
                selectLuces.classList.add('select-Lubricacion');
            }else if (selectLuces.value === 'NoAplica') {
                iconLuces.textContent = '➖';
                iconLuces.style.color = 'Gray';
                selectLuces.classList.add('select-Aplica'); 
            }else {
                iconLuces.textContent = '❌';
                iconLuces.style.color = 'red';
                selectLuces.classList.add('select-vacio');
            }
        }

        selectsLuces.forEach(selectLuces => {
            selectLuces.addEventListener('change', () => actualizarEstadoLuces(selectLuces));
        });

        botonLuces.addEventListener('click', () => {
            let valido = true;

            selectsLuces.forEach(selectLuces => {
                if (!selectLuces.value) {
                    actualizarEstadoLuces(selectLuces);
                    valido = false;
                }
            });

            if (fileInputLuces.files.length === 0) {
                alert('Debe subir al menos una imagen del diagnóstico.');
                valido = false;
            }

            if (!valido) return;

            // ✅ Cambiar color del card
            const card = document.getElementById('btnLucesCard').querySelector('div');
            card.classList.remove('bg-light');
            card.classList.add('bg-validado');

            // ❌ Cerrar modal actual
            const ModalLuces = bootstrap.Modal.getInstance(document.getElementById('ModalLuces'));
            ModalLuces.hide();

            // ✅ Abrir siguiente modal
            const modalAgregar = new bootstrap.Modal(document.getElementById('AgregarDiagnostico'));
            modalAgregar.show();
        });
    });
</script>

<!-- Modal Lubricacion-->
<div class="modal fade" id="ModalLubricacion" tabindex="-1" aria-labelledby="ModalLubricacionLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #000020;">
                <h5 class="modal-title text-white" id="ModalLubricacionLabel">Diagnóstico: Lubricacíon</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="estadoEngraseP" class="form-label">Engrase puente trasero</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoEngraseP" name="estadoEngraseP" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoEngraseP"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoEngraseM" class="form-label">Engrase mastil</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoEngraseM" name="estadoEngraseM" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoEngraseM"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoLubricacion" class="form-label">Lubricacíon cadenas y secciones mastil</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoLubricacion" name="estadoLubricacion" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoLubricacion"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Subir Imágenes del Diagnóstico</label>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-primary" id="btnTomarFotoLubricacion">Tomar Foto</button>
                        <button type="button" class="btn btn-outline-secondary" id="btnCargarImagenLubricacion">Cargar Imágenes</button>
                    </div>
                    <input class="form-control mt-2 d-none" type="file" id="imagenesDiagnosticoLubricacion" name="imagenesDiagnosticoLubricacion[]" accept="image/*" multiple capture="environment">
                </div>
                <button id="btnGuardarLubricacion" type="button" class="btn text-white" style="background-color: #000020;">Guardar Diagnóstico</button>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const selectsLubricacion = document.querySelectorAll('#ModalLubricacion select.form-select');
        const fileInputLubricacion = document.getElementById('imagenesDiagnosticoLuces');
        const botonLubricacion = document.getElementById('btnGuardarLuces');
        const btnTomarFotoLubricacion = document.getElementById('btnTomarFotoLubricacion');
        const btnCargarImagenLubricacion = document.getElementById('btnCargarImagenLubricacion');

        function actualizarEstadoLubricacion(selectLubricacion) {
            const iconLubricacion = document.getElementById(`icon-${selectLubricacion.id}`);
            selectLubricacion.classList.remove('select-Conforme', 'select-Nivelacion', 'select-Ajuste', 'select-Lubricacion', 'select-malo', 'select-vacio', 'select-Aplica');

            if (selectLubricacion.value === 'Conforme') {
                iconLubricacion.textContent = '✔️';
                iconLubricacion.style.color = 'green';
                selectLubricacion.classList.add('select-Conforme');
            } else if (selectLubricacion.value === 'Reparación') {
                iconLubricacion.textContent = '⚠️';
                iconLubricacion.style.color = 'red';
                selectLubricacion.classList.add('select-malo');
            }else if (selectLubricacion.value === 'Nivelacion') {
                iconLubricacion.textContent = '📏';
                iconLubricacion.style.color = 'yellow';
                selectLubricacion.classList.add('select-Nivelacion');
            }else if (selectLubricacion.value === 'Ajuste') {
                iconLubricacion.textContent = '⚙️';
                iconLubricacion.style.color = 'Orange';
                selectLubricacion.classList.add('select-Ajuste'); 
            }else if (selectLubricacion.value === 'Lubricación') {
                iconLubricacion.textContent = '🛢️';
                iconLubricacion.style.color = 'Blue';
                selectLubricacion.classList.add('select-Lubricacion');
            }else if (selectLubricacion.value === 'NoAplica') {
                iconLubricacion.textContent = '➖';
                iconLubricacion.style.color = 'Gray';
                selectLubricacion.classList.add('select-Aplica'); 
            }else {
                iconLubricacion.textContent = '❌';
                iconLubricacion.style.color = 'red';
                selectLubricacion.classList.add('select-vacio');
            }
        }

        selectsLubricacion.forEach(selectLubricacion => {
            selectLubricacion.addEventListener('change', () => actualizarEstadoLubricacion(selectLubricacion));
        });

        botonLuces.addEventListener('click', () => {
            let valido = true;

            selectsLubricacion.forEach(selectLubricacion => {
                if (!selectLubricacion.value) {
                    actualizarEstadoLubricacion(selectLubricacion);
                    valido = false;
                }
            });

            if (fileInputLubricacion.files.length === 0) {
                alert('Debe subir al menos una imagen del diagnóstico.');
                valido = false;
            }

            if (!valido) return;

            // ✅ Cambiar color del card
            const card = document.getElementById('btnLubricacionCard').querySelector('div');
            card.classList.remove('bg-light');
            card.classList.add('bg-validado');

            // ❌ Cerrar modal actual
            const ModalLubricacion = bootstrap.Modal.getInstance(document.getElementById('ModalLubricacion'));
            ModalLubricacion.hide();

            // ✅ Abrir siguiente modal
            const modalAgregar = new bootstrap.Modal(document.getElementById('AgregarDiagnostico'));
            modalAgregar.show();
        });
    });
</script>

<!-- Modal Cargador-->
<div class="modal fade" id="ModalCargador" tabindex="-1" aria-labelledby="ModalCargadorLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #000020;">
                <h5 class="modal-title text-white" id="ModalCargadorLabel">Diagnóstico: Cargador</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="NumeroCargador" class="form-label">N° Cargador</label>
                    <input type="text" class="form-control" name="NumeroCargador" id="NumeroCargador" placeholder="# de cargador" >
                </div>
                <div class="mb-3">
                    <label for="estadoInspeccionC" class="form-label">Inspeccion visual</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoInspeccionC" name="estadoInspeccionC" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoInspeccionC"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoCablesP" class="form-label">Cables de potencia</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoCablesP" name="estadoCablesP" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoCablesP"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoConectorA" class="form-label">Conector Anderson</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoConectorA" name="estadoConectorA" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoConectorA"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoVoltajeB" class="form-label">Voltaje</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoVoltajeB" name="estadoVoltajeB" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoVoltajeB"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoAmperaje" class="form-label">Amperaje</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoAmperaje" name="estadoAmperaje" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoAmperaje"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoFusible" class="form-label">Fusible</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoFusible" name="estadoFusible" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoFusible"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Subir Imágenes del Diagnóstico</label>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-primary" id="btnTomarFotoCargador">Tomar Foto</button>
                        <button type="button" class="btn btn-outline-secondary" id="btnCargarImagenCargador">Cargar Imágenes</button>
                    </div>
                    <input class="form-control mt-2 d-none" type="file" id="imagenesDiagnosticoCargador" name="imagenesDiagnosticoLubricacion[]" accept="image/*" multiple capture="environment">
                </div>
                <button id="btnGuardarCargador" type="button" class="btn text-white" style="background-color: #000020;">Guardar Diagnóstico</button>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const selectsCargador = document.querySelectorAll('#ModalCargador select.form-select');
        const fileInputCargador = document.getElementById('imagenesDiagnosticoCargador');
        const botonCargador = document.getElementById('btnGuardarCargador');
        const btnTomarFotoCargador = document.getElementById('btnTomarFotoCargador');
        const btnCargarImagenCargador = document.getElementById('btnCargarImagenCargador');

        function actualizarEstadoCargador(selectCargador) {
            const iconCargador = document.getElementById(`icon-${selectCargador.id}`);
            selectCargador.classList.remove('select-Conforme', 'select-Nivelacion', 'select-Ajuste', 'select-Lubricacion', 'select-malo', 'select-vacio', 'select-Aplica');

            if (selectCargador.value === 'Conforme') {
                iconCargador.textContent = '✔️';
                iconCargador.style.color = 'green';
                selectCargador.classList.add('select-Conforme');
            } else if (selectCargador.value === 'Reparación') {
                iconCargador.textContent = '⚠️';
                iconCargador.style.color = 'red';
                selectCargador.classList.add('select-malo');
            }else if (selectCargador.value === 'Nivelacion') {
                iconCargador.textContent = '📏';
                iconCargador.style.color = 'yellow';
                selectCargador.classList.add('select-Nivelacion');
            }else if (selectCargador.value === 'Ajuste') {
                iconCargador.textContent = '⚙️';
                iconCargador.style.color = 'Orange';
                selectCargador.classList.add('select-Ajuste'); 
            }else if (selectCargador.value === 'Lubricación') {
                iconCargador.textContent = '🛢️';
                iconCargador.style.color = 'Blue';
                selectCargador.classList.add('select-Lubricacion');
            }else if (selectCargador.value === 'NoAplica') {
                iconCargador.textContent = '➖';
                iconCargador.style.color = 'Gray';
                selectCargador.classList.add('select-Aplica'); 
            }else {
                iconCargador.textContent = '❌';
                iconCargador.style.color = 'red';
                selectCargador.classList.add('select-vacio');
            }
        }

        selectsCargador.forEach(selectCargador => {
            selectCargador.addEventListener('change', () => actualizarEstadoCargador(selectCargador));
        });

        botonCargador.addEventListener('click', () => {
            let valido = true;

            selectsCargador.forEach(selectCargador => {
                if (!selectCargador.value) {
                    actualizarEstadoCargador(selectCargador);
                    valido = false;
                }
            });

            if (fileInputCargador.files.length === 0) {
                alert('Debe subir al menos una imagen del diagnóstico.');
                valido = false;
            }

            if (!valido) return;

            // ✅ Cambiar color del card
            const card = document.getElementById('btnCargadorCard').querySelector('div');
            card.classList.remove('bg-light');
            card.classList.add('bg-validado');

            // ❌ Cerrar modal actual
            const ModalCargador = bootstrap.Modal.getInstance(document.getElementById('ModalCargador'));
            ModalCargador.hide();

            // ✅ Abrir siguiente modal
            const modalAgregar = new bootstrap.Modal(document.getElementById('AgregarDiagnostico'));
            modalAgregar.show();
        });
    });
</script>

<!-- Modal Revision de equipo-->
<div class="modal fade" id="ModalRevision" tabindex="-1" aria-labelledby="ModalRevisionLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #000020;">
                <h5 class="modal-title text-white" id="ModalRevisionLabel">Diagnóstico: Revision de Equipo</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="estadoLimpiezaE" class="form-label">Limpieza del equipo</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoLimpiezaE" name="estadoLimpiezaE" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoLimpiezaE"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoHorometro" class="form-label">Horómetro</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoHorometro" name="estadoHorometro" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoHorometro"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoEtiquetas" class="form-label">Etiquetas de seguridad</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoEtiquetas" name="estadoEtiquetas" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoEtiquetas"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoLimpiezaA" class="form-label">Limpieza área de trabajo</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoLimpiezaA" name="estadoLimpiezaA" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoLimpiezaA"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoManual" class="form-label">Manual de operaciones</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoManual" name="estadoManual" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoManual"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoTapas" class="form-label">Tapas</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoTapas" name="estadoTapas" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoTapas"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoCapo" class="form-label">Capó y amortiguador</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoCapo" name="estadoCapo" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoCapo"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoSilla" class="form-label">Silla</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoSilla" name="estadoSilla" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoSilla"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoCinturon" class="form-label">Cinturon de seguridad</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoCinturon" name="estadoCinturon" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoCinturon"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="estadoExtintor" class="form-label">Extintor</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="estadoExtintor" name="estadoExtintor" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-estadoExtintor"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Subir Imágenes del Diagnóstico</label>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-primary" id="btnTomarFotoRevision">Tomar Foto</button>
                        <button type="button" class="btn btn-outline-secondary" id="btnCargarImagenRevision">Cargar Imágenes</button>
                    </div>
                    <input class="form-control mt-2 d-none" type="file" id="imagenesDiagnosticoRevision" name="imagenesDiagnosticoRevision[]" accept="image/*" multiple capture="environment">
                </div>
                <button id="btnGuardarRevision" type="button" class="btn text-white" style="background-color: #000020;">Guardar Diagnóstico</button>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const selectsRevision = document.querySelectorAll('#ModalRevision select.form-select');
        const fileInputRevision = document.getElementById('imagenesDiagnosticoRevision');
        const botonRevision = document.getElementById('btnGuardarRevision');
        const btnTomarFotoRevision = document.getElementById('btnTomarFotoRevision');
        const btnCargarImagenRevision = document.getElementById('btnCargarImagenRevision');

        function actualizarEstadoRevision(selectRevision) {
            const iconRevision = document.getElementById(`icon-${selectRevision.id}`);
            selectRevision.classList.remove('select-Conforme', 'select-Nivelacion', 'select-Ajuste', 'select-Lubricacion', 'select-malo', 'select-vacio', 'select-Aplica');

            if (selectRevision.value === 'Conforme') {
                iconRevision.textContent = '✔️';
                iconRevision.style.color = 'green';
                selectRevision.classList.add('select-Conforme');
            } else if (selectRevision.value === 'Reparación') {
                iconRevision.textContent = '⚠️';
                iconRevision.style.color = 'red';
                selectRevision.classList.add('select-malo');
            }else if (selectRevision.value === 'Nivelacion') {
                iconRevision.textContent = '📏';
                iconRevision.style.color = 'yellow';
                selectRevision.classList.add('select-Nivelacion');
            }else if (selectRevision.value === 'Ajuste') {
                iconRevision.textContent = '⚙️';
                iconRevision.style.color = 'Orange';
                selectRevision.classList.add('select-Ajuste'); 
            }else if (selectRevision.value === 'Lubricación') {
                iconRevision.textContent = '🛢️';
                iconRevision.style.color = 'Blue';
                selectRevision.classList.add('select-Lubricacion');
            }else if (selectRevision.value === 'NoAplica') {
                iconRevision.textContent = '➖';
                iconRevision.style.color = 'Gray';
                selectRevision.classList.add('select-Aplica'); 
            }else {
                iconRevision.textContent = '❌';
                iconRevision.style.color = 'red';
                selectRevision.classList.add('select-vacio');
            }
        }

        selectsRevision.forEach(selectRevision => {
            selectRevision.addEventListener('change', () => actualizarEstadoRevision(selectRevision));
        });

        botonRevision.addEventListener('click', () => {
            let valido = true;

            selectsRevision.forEach(selectRevision => {
                if (!selectRevision.value) {
                    actualizarEstadoRevision(selectRevision);
                    valido = false;
                }
            });

            if (fileInputRevision.files.length === 0) {
                alert('Debe subir al menos una imagen del diagnóstico.');
                valido = false;
            }

            if (!valido) return;

            // ✅ Cambiar color del card
            const card = document.getElementById('btnRevisionCard').querySelector('div');
            card.classList.remove('bg-light');
            card.classList.add('bg-validado');

            // ❌ Cerrar modal actual
            const ModalRevision = bootstrap.Modal.getInstance(document.getElementById('ModalRevision'));
            ModalRevision.hide();

            // ✅ Abrir siguiente modal
            const modalAgregar = new bootstrap.Modal(document.getElementById('AgregarDiagnostico'));
            modalAgregar.show();
        });
    });
</script>

<!-- Modal Observaciónes de mantenimiento-->
<div class="modal fade" id="ModalObservaciones" tabindex="-1" aria-labelledby="ModalObservacionesLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #000020;">
                <h5 class="modal-title text-white" id="ModalObservacionesLabel">Observaciones de Mantenimiento</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="diagnostico" class="form-label">Diagnóstico</label>
                    <textarea class="form-control" id="diagnostico" name="diagnostico" rows="5" placeholder="Pendientes proximo mantenimiento..."></textarea>
                </div>

                <button id="btnGuardarInsumos" type="button" class="btn text-white" style="background-color: #000020;">Guardar Diagnóstico</button>
            </div>
        </div>
    </div>
</div>
<script>
    document.querySelectorAll('.no-aplica').forEach(toggle => {
        toggle.addEventListener('change', function() {
            const targetIds = this.getAttribute('data-target').split(',');
            targetIds.forEach(id => {
                const element = document.getElementById(id);
                if (element) {
                    element.disabled = this.checked; 
                    if (this.checked) {
                        element.value = ""; 
                    }
                }
            });
        });
    });
</script>

<!-- Modal Insumos de mantenimiento-->


<script>
    function cargarMontacargas() {
        const ID_Centro = document.getElementById('ID_Centro1').value;
        console.log('ID_Centro enviado:', ID_Centro);
        if (!ID_Centro) return;
        // Realizamos la solicitud AJAX para obtener los montacargas
        $.get('TraerMontacargas?ID_Centro=${ID_Centro}', function(data) {
            try{
                const Montacargas= Array.isArray(data) ? data :JSON.parse(data);
                const MontacargasSelect = document.getElementById('ID_Montacargas');

                console.log('Montacargas recibido:', Montacargas);

                // Limpiamos el select de montacargas
                $('#ID_Montacargas').empty();

                // Agregamos las opciones al select
                if(Montacargas.length > 0) {
                    //Llenamos el select con los montacargas
                    Montacargas.forEach(montacarga => {
                        $('#ID_Montacargas').append('<option value="${montacarga.ID}">${montacarga.Numero}-${montacarga.Serie}</option>');
                    });
                }
            }catch (error) {
                console.error('Error al procesar los datos de montacargas:', error);
            }
        }).fail(function(xhr, status, error) {
            console.error('Error en la solicitud AJAX:', error);
        })
        // Realizamos la solicitud AJAX para obtener los operarios
        $.get('TraerOperarios?ID_Centro=${ID_Centro}', function(data) {
            try{
                const Operarios= Array.isArray(data) ? data :JSON.parse(data);
                const OperariosSelect = document.getElementById('ID_Operario');

                console.log('Operarios recibido:', Operarios);

                // Limpiamos el select de montacargas
                $('#ID_Operario').empty();

                // Agregamos las opciones al select
                if(Operarios.length > 0) {
                    //Llenamos el select con los operarios
                    Operarios.forEach(operario => {
                        $('#ID_Operario').append('<option value="${operario.ID}">${operario.NombreCompleto}</option>');
                    });
                }
            }catch (error) {
                console.error('Error al procesar los datos de operarios:', error);
            }
        }).fail(function(xhr, status, error) {
            console.error('Error en la solicitud AJAX:', error);
        })
    };

    document.addEventListener('DOMContentLoaded', function() {
        const modalPrincipal = new bootstrap.Modal(document.getElementById('agregarMantenimiento'));

        // Detectar cualquier botón que tenga el atributo [data-open-modal]
        document.querySelectorAll('[data-open-modal]').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const targetModalSelector = this.getAttribute('data-open-modal');
                const targetModalElement = document.querySelector(targetModalSelector);

                if (!targetModalElement) return;

                const targetModal = new bootstrap.Modal(targetModalElement);

                modalPrincipal.hide();

                setTimeout(() => {
                    targetModal.show();
                }, 500);

                // Al cerrar el modal secundario, reabrimos el modal principal
                targetModalElement.addEventListener('hidden.bs.modal', function() {
                    modalPrincipal.show();
                }, {
                    once: true
                }); // Solo una vez, para evitar múltiples registros
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
</script>
<?php require "App/Views/Templates/Layouts/Footer.php"; ?>
