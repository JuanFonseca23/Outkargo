<?php
require_once "App/Views/Templates/Layouts/Header.php";
?>

<link rel="stylesheet" href="<?= $baseUrl ?>App/Views/Css/Mantenimientos/Preventivos.css">
<link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>

<!-- INDICADOR CONEXIÓN -->
<div id="conexionIndicador" class="online">
    <span class="dot"></span>
    <span id="conexionTexto">En línea</span>
</div>

<!-- STAT CARDS -->
<div class="container-fluid pt-3 pt-md-4 px-2 px-md-4">
    <div class="row g-2 g-md-3">
        <div class="col-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-icon bg-dark-soft">
                    <svg width="26" height="26" fill="none" viewBox="0 0 24 24">
                        <path d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" stroke="#000020" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div class="stat-text">
                    <div class="stat-label">Correctivos</div>
                    <div class="stat-value" id="contadorCorrectivos"><?= $NoMantenimientos['NoMantenimientos'] ?></div>
                </div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="stat-card clickable" id="btnCorrectivo" role="button" tabindex="0">
                <div class="stat-icon bg-orange-soft">
                    <svg width="26" height="26" fill="none" viewBox="0 0 24 24">
                        <path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" stroke="#ff5000" stroke-width="2"/>
                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke="#ff5000" stroke-width="2"/>
                    </svg>
                </div>
                <div class="stat-text">
                    <div class="stat-label">Acción</div>
                    <div class="stat-value" style="font-size:.95rem;color:var(--color-orange);">Correctivo</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="stat-card clickable" id="btnAbrirBuscarMantenimiento" role="button" tabindex="0" style="cursor:pointer;">
                <div class="stat-icon bg-dark-soft">
                    <svg width="26" height="26" fill="none" viewBox="0 0 24 24">
                        <path d="M21 21l-4.35-4.35M17 11A6 6 0 115 11a6 6 0 0112 0z" stroke="#000020" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </div>
                <div class="stat-text">
                    <div class="stat-label">Herramienta</div>
                    <div class="stat-value" style="font-size:.95rem;">
                        Buscar
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <a href="#" class="stat-card clickable" id="btnAbrirInformesMantenimiento" role="button" tabindex="0" style="cursor:pointer;">
                <div class="stat-icon bg-orange-soft">
                    <svg width="26" height="26" fill="none" viewBox="0 0 24 24">
                        <path d="M9 17v-2m3 2v-4m3 4v-6M4 5h16a1 1 0 011 1v12a1 1 0 01-1 1H4a1 1 0 01-1-1V6a1 1 0 011-1z" stroke="#ff5000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div class="stat-text">
                    <div class="stat-label">Reportes</div>
                    <div class="stat-value" style="font-size:.95rem;color:var(--color-orange);">Informe</div>
                </div>
            </a>
        </div>
    </div>
</div>

<!-- TABLA -->
<div class="container-fluid pt-4 px-2 px-md-4 mantenimiento-listado">
    <div class="mantenimiento-list-card rounded p-3 p-md-4">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2 mb-4">
            <div class="d-flex align-items-center flex-wrap gap-2">
                <h6 class="mb-0">Correctivos Realizados</h6>
            </div>
            <div class="text-md-end text-center mt-2 mt-md-0">
                <a href="ExportarExcelPreventivo" class="text-decoration-none ms-2 text-success fw-bold">Descargar Excel</a>
            </div>
        </div>

        <div id="contenedorMantenimientos"><!-- generado por JS --></div>
    </div>
</div>

<!-- MODAL BORRADOR CORRECTIVO -->
<div class="modal fade" id="modalBorradorCorrectivo" tabindex="-1" aria-labelledby="modalBorradorCorrectivoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:min(460px, calc(100vw - 1rem));">
        <div class="modal-content border-0 shadow">
            <div class="modal-header modal-header-custom">
                <div>
                    <h5 class="modal-title mb-0" id="modalBorradorCorrectivoLabel">⚠️ Mantenimiento en progreso </h5>
                    <small class="text-white-50" style="font-size:.72rem;">
                        Se encontró un mantenimiento correctivo pendiente
                    </small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"> </button>
            </div>
            <div class="modal-body p-3 p-md-4">
                <div class="text-center">
                    <div style="width:64px; height:64px; margin:0 auto 16px; border-radius:50%; background:#fff3cd; display:flex; align-items:center; justify-content:center; font-size:30px;"> 💾 </div>
                    <h6 style="color:var(--color-dark); font-weight:700; margin-bottom:8px;">
                        Tienes un mantenimiento guardado
                    </h6>
                    <p style="font-size:.84rem; color:#6c757d; margin-bottom:8px;">
                        Encontramos un mantenimiento correctivo que quedó en estado <strong>BORRADOR</strong>.
                    </p>
                    <p style="font-size:.82rem; color:#6c757d; margin-bottom:0;">
                        ¿Deseas continuar desde donde lo dejaste?
                    </p>
                </div>

            </div>

            <!-- FOOTER -->
            <div class="modal-footer p-2 p-md-3" style="background:#f8f9fc; border-top:1px solid #e8e8f0;">
                <div class="d-flex justify-content-center gap-2 w-100 flex-wrap">
                    <button type="button" class="btn-outline-custom btn btn-sm" id="btnRechazarBorrador">
                        No, iniciar nuevo
                    </button>

                    <button type="button" class="btn-primary-custom btn btn-sm" id="btnContinuarBorrador">
                        Sí, continuar
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- MODAL 1 — DATOS INICIALES  -->
<div class="modal fade" id="NumerDocumentoModal" tabindex="-1" aria-labelledby="NumerDocumentoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width:min(480px, calc(100vw - 1rem));">
        <div class="modal-content border-0 shadow">
            <div class="modal-header modal-header-custom">
                <h5 class="modal-title" id="NumerDocumentoModalLabel">🔧 Nuevo Mantenimiento Correctivo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body p-3 p-md-4">
                <form id="documentFormIngreso" method="POST" novalidate>
                    <div class="section-divider"><span>Centro de Trabajo y Area</span></div>
                    
                    <div class="mb-3">
                        <label class="form-label-sm">Centro de Trabajo</label>
                        <select class="form-select" name="ID_Centro1" id="ID_Centro1" onchange="cargarMontacargas()" required>
                            <option value="" disabled selected>Seleccione centro de trabajo</option>
                            <?php
                                if ($ListaCentrosDeTrabajo) {
                                    foreach ($ListaCentrosDeTrabajo as $c) {
                                        echo "<option value='{$c['ID']}'>{$c['Nombre']}</option>";
                                    }
                                }
                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label-sm">Sección / Área</label>
                        <select class="form-select" name="ID_Area" id="ID_Area" required>
                            <option value="" disabled selected>Seleccione área</option>
                        </select>
                    </div>

                    <div class="section-divider"><span>Operario ó Supervisor</span></div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap gap-1">
                            <label class="form-label-sm mb-0">Quien Reporta</label>
                            <div class="d-flex align-items-center gap-2">
                                <span id="labelInterno" class="label-active" style="font-size:.78rem;">Interno</span>
                                <div class="form-check form-switch m-0">
                                    <input class="form-check-input" type="checkbox" id="tipoOperarioSwitch">
                                </div>
                                <span id="labelExterno" class="label-inactive" style="font-size:.78rem;">Externo</span>
                            </div>
                        </div>
                        <select class="form-select" name="ID_Operario" id="ID_Operario" required>
                            <option value="" disabled selected>Seleccione operario</option>
                        </select>
                        <input type="text" class="form-control mt-2 d-none" id="OperarioExterno" name="OperarioExterno" placeholder="Nombre completo del operario externo">
                    </div>

                    <div class="section-divider"><span>Equipo</span></div>

                    <div class="row g-2 mb-3">
                        <div class="col-12 col-sm-6">
                            <label class="form-label-sm">Montacargas</label>
                            <select class="form-select" name="ID_Montacargas" id="ID_Montacargas" required>
                                <option value="" disabled selected>Seleccione montacargas</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-6">
                            <label class="form-label-sm">Clase de Montacargas</label>
                            <select class="form-select" id="tipoMontacargas" name="tipoMontacargas" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="combustion">Combustión</option>
                                <option value="contrabalanceada">Eléctrico Contrabalanceada</option>
                                <option value="pasillo">Pasillo Angosto</option>
                                <option value="manlift">Manlift</option>
                            </select>
                        </div>
                    </div>

                    <input type="hidden" name="Tipo" value="DocumentoCorrectivo">

                    <div class="d-flex justify-content-end gap-2 mt-3 modal-btns-footer">
                        <button type="button" class="btn-outline-custom btn" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn-primary-custom btn" id="btnEnviarForm">Continuar →</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<!-- MODAL 2 — FORMULARIO MANTENIMIENTO -->
<div class="modal fade" id="agregarMantenimiento" tabindex="-1" aria-labelledby="agregarMantenimientoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" style="max-width:min(1200px, calc(100vw - .5rem)); margin:.25rem auto;">
        <div class="modal-content border-0 shadow">
            <div class="modal-header modal-header-custom">
                <div style="min-width:0;">
                    <h5 class="modal-title mb-0" id="agregarMantenimientoModalLabel">Mantenimiento Correctivo</h5>
                    <small class="text-white-50" id="subtituloModal" style="font-size:.72rem;">—</small>
                </div>
                <div class="d-flex align-items-center gap-2 gap-md-3 flex-shrink-0">
                    <span id="estadoGuardado" class="text-white-50 d-none d-sm-inline" style="font-size:.7rem;">
                        <span id="iconoGuardado">💾</span> Sin cambios
                    </span>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <!-- Toggle info equipo (solo mobile) -->
            <button class="panel-info-toggle" id="toggleInfoEquipo">
                <span>📋 Ver información del equipo</span>
                <span class="arrow">▼</span>
            </button>

            <div class="modal-body p-0">
                <div class="modal-body-inner">
                    <!-- PANEL IZQUIERDO -->
                    <div class="panel-izquierdo col-md-3 col-lg-3">
                        <div class="panel-izquierdo-body" id="panelInfoBody">

                            <div class="section-divider"><span>Equipo</span></div>
                            <div class="info-panel mb-2">
                                <div class="row g-2">
                                    <div class="col-6">
                                        <div class="info-row">
                                            <span class="info-lbl">Montacargas</span>
                                            <input type="text" class="form-control" id="numeroMontacargas" name="numeroMontacargas" readonly>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="info-row">
                                            <span class="info-lbl">Sección</span>
                                            <input type="text" class="form-control" id="nombreSeccion" name="nombreSeccion" readonly>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="info-row">
                                            <span class="info-lbl">Serie</span>
                                            <input type="text" class="form-control" id="numeroSerie" name="numeroSerie" readonly>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="info-row">
                                            <span class="info-lbl">Modelo</span>
                                            <input type="text" class="form-control" id="numeroModelo" name="numeroModelo" readonly>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="info-row">
                                            <span class="info-lbl">Centro de Trabajo</span>
                                            <input type="text" class="form-control" id="nombreCentro" name="nombreCentro" readonly>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="info-row">
                                            <span class="info-lbl">Operario</span>
                                            <input type="text" class="form-control" id="nombreOperario" name="nombreOperario" readonly>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="info-row">
                                            <span class="info-lbl">Voltaje</span>
                                            <input type="text" class="form-control" id="Voltaje" name="Voltaje" readonly>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="info-row">
                                            <span class="info-lbl">Horómetro</span>
                                            <input type="text" class="form-control" id="Horometro" name="Horometro" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="section-divider"><span>Tiempo</span></div>
                            <div class="info-panel mb-2">
                                <div class="row g-2">
                                    <div class="col-6">
                                        <div class="info-row">
                                            <span class="info-lbl">Hora Inicio</span>
                                            <input type="time" class="form-control" id="HoraInicio" name="HoraInicio" value="<​​​​?= $horaFormateada ?>">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="info-row">
                                            <span class="info-lbl">Hora Final</span>
                                            <input type="time" class="form-control" id="HoraFinal" name="HoraFinal" value="<​​​​?= $horaFormateada ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="section-divider"><span>Personal</span></div>
                            <div class="info-panel">
                                <div class="info-row mb-2">
                                    <span class="info-lbl">Técnicos Encargados</span>
                                    <!-- Lista resumen visible en el panel -->
                                    <div id="listaTecnicos" class="mt-2" style="display:flex;flex-direction:column;gap:6px;"></div>
                                    <button type="button" id="btnAgregarTecnico"
                                        class="btn btn-sm mt-2 w-100"
                                        style="border:1.5px dashed var(--color-orange);color:var(--color-orange);
                                            border-radius:8px;font-size:.75rem;background:transparent;">
                                        + Agregar Técnico
                                    </button>
                                </div>
                                <div class="info-row">
                                    <span class="info-lbl">Autoriza</span>
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
                                <div class="info-row">
                                    <span class="info-lbl">Operedaro o Supervisor (Quien Recibe)</span>
                                    <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap gap-1">
                                        <div class="d-flex align-items-center gap-2">
                                            <span id="labelInterno1" class="label-active" style="font-size:.78rem;">Interno</span>
                                            <div class="form-check form-switch m-0">
                                                <input class="form-check-input" type="checkbox" id="tipoOperarioSwitch1">
                                            </div>
                                            <span id="labelExterno1" class="label-inactive" style="font-size:.78rem;">Externo</span>
                                        </div>
                                    </div>
                                    <select class="form-select" name="ID_Operario1" id="ID_Operario1" required>
                                        <option value="" disabled selected>Seleccione operario</option>
                                    </select>
                                    <input type="text" class="form-control mt-2 d-none" id="OperarioExterno1" name="OperarioExterno1" placeholder="Nombre completo del operario externo">
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- PANEL DERECHO -->
                    <div class="col-md-9 col-lg-9 panel-derecho p-3 p-md-4">
                        <!-- TABLA DESCRIPCIÓN FALLA -->
                        <div class="section-divider d-flex justify-content-between align-items-center">
                            <span>Descripción Falla</span>
                            <button type="button" class="btn btn-sm btn-primary-custom" id="btnAgregarFalla" style="width:32px; height:32px; padding:0; border-radius:8px; font-size:1.2rem; line-height:1;" title="Agregar falla">+</button>
                        </div>

                        <div class="table-responsive mb-4">
                            <table class="table table-hover align-middle mb-0">
                                <thead>
                                    <tr style="background:var(--color-dark); color:#fff;">
                                        <th style="font-size:.75rem; padding:.65rem .75rem; border:none; width:120px;">Código</th>
                                        <th style="font-size:.75rem; padding:.65rem .75rem; border:none; width:120px;">Sección</th>
                                        <th style="font-size:.75rem; padding:.65rem .75rem; border:none;">Descripción</th>
                                        <th style="font-size:.75rem; padding:.65rem .75rem; border:none; width:90px; text-align:center;">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="bodyFallos">
                                    <tr id="filaVaciaFallos">
                                        <td colspan="4" class="text-center text-muted py-4" style="font-size:.82rem;">No hay fallas registradas.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!--TABLA DESCRIPCIÓN CORRECCIÓN -->
                        <div class="section-divider">
                            <span>Descripción Corrección</span>
                        </div>
                        <div class="table-responsive mb-4">
                            <table class="table table-hover align-middle mb-0">
                                <thead>
                                    <tr style="background:var(--color-dark); color:#fff;">
                                        <th style="font-size:.75rem; padding:.65rem .75rem; border:none; width:120px;">Código</th>
                                        <th style="font-size:.75rem; padding:.65rem .75rem; border:none; width:120px;" >Sección</th>
                                        <th style="font-size:.75rem; padding:.65rem .75rem; border:none;">Descripción</th>
                                        <th style="font-size:.75rem; padding:.65rem .75rem; border:none; width:90px; text-align:center;">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="bodyCorrecciones">
                                    <tr id="filaVaciaCorrecciones">
                                        <td colspan="4" class="text-center text-muted py-4" style="font-size:.82rem;">No hay correcciones registradas. </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- TARJETAS ESPECIALES -->
                        <div class="row g-2 g-md-3 mt-1" id="tarjetasEspeciales" style="display:none;">
                            <!-- Novedades -->
                            <div class="col-12 col-sm-6 col-xl-4">
                                <div class="seccion-card" onclick="abrirNovedades()" role="button" tabindex="0" onkeydown="if(event.key==='Enter'||event.key===' '){abrirNovedades()}">
                                    <div class="seccion-card-icon" style="background:#fff3cd;">📋</div>
                                    <div class="seccion-card-body">
                                        <div class="seccion-card-title" id="titleNovedades">Novedades Pendientes</div>
                                        <div class="seccion-card-sub" id="subNovedades">0 novedades registradas</div>
                                    </div>
                                    <span class="seccion-card-arrow">›</span>
                                </div>
                            </div>

                            <!-- Observaciones -->
                            <div class="col-12 col-sm-6 col-xl-4">
                                <div class="seccion-card" onclick="abrirObservaciones()" role="button" tabindex="0" onkeydown="if(event.key==='Enter'||event.key===' '){abrirObservaciones()}">
                                    <div class="seccion-card-icon" style="background:#cfe2ff;">🔍</div>
                                    <div class="seccion-card-body">
                                        <div class="seccion-card-title"  id="titleObservaciones">Observaciones</div>
                                        <div class="seccion-card-sub" id="subObservaciones">0 observaciones generadas</div>
                                    </div>
                                    <span class="seccion-card-arrow">›</span>
                                </div>
                            </div>

                            <!-- Insumos -->
                            <div class="col-12 col-sm-6 col-xl-4">
                                <div class="seccion-card" onclick="abrirInsumos()" role="button" tabindex="0" onkeydown="if(event.key==='Enter'||event.key===' '){abrirInsumos()}">
                                    <div class="seccion-card-icon" style="background:#f7debc;">🛢</div>
                                    <div class="seccion-card-body">
                                        <div class="seccion-card-title" id="titleInsumos">Insumos y Repuestos</div>
                                        <div class="seccion-card-sub" id="subInsumos">0 insumos utilizados</div>
                                    </div>
                                    <span class="seccion-card-arrow">›</span>
                                </div>
                            </div>
                            <!-- Repuestos Retirados -->
                            <div class="col-12 col-sm-6 col-xl-4">
                                <div class="seccion-card" onclick="abrirRepuestos()" role="button" tabindex="0" onkeydown="if(event.key==='Enter'||event.key===' '){abrirRepuestos()}">
                                    <div class="seccion-card-icon" style="background:#f7debc;">🛢</div>
                                    <div class="seccion-card-body">
                                        <div class="seccion-card-title" id="titleRepuestos">Repuestos Retirados</div>
                                        <div class="seccion-card-sub" id="subRepuestos">0 repuestos retirados</div>
                                    </div>
                                    <span class="seccion-card-arrow">›</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="modal-footer p-2 p-md-3" style="border-top:1px solid #e8e8f0;background:#f8f9fc;">
                <div class="modal-footer-inner">
                    <div class="acciones-footer">
                        <button type="button" class="btn-outline-custom btn btn-sm" id="btnGuardarBorrador">
                            💾 Borrador
                        </button>
                        <button type="button" class="btn-primary-custom btn btn-sm" id="btnFinalizarMantenimiento">
                            Finalizar ✓
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL 3 — NOVEDADES PENDIENTES -->
<div class="modal fade" id="modalNovedades" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" style="max-width:min(700px, calc(100vw - .5rem)); margin:.25rem auto;">
        <div class="modal-content border-0 shadow">
            <div class="modal-header modal-header-custom">
                <div style="min-width:0;">
                    <h5 class="modal-title mb-0">📋 Novedades Pendientes</h5>
                    <small class="text-white-50" style="font-size:.72rem;">Trabajos y novedades adicionales</small>
                </div>
            </div>
            <div class="modal-body p-3 p-md-4">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle" style="min-width:400px;">
                        <thead>
                            <tr style="background:var(--color-dark);color:#fff;">
                                <th style="font-size:.75rem;padding:.6rem .75rem;border:none;width:40px;">#</th>
                                <th style="font-size:.75rem;padding:.6rem .75rem;border:none;">Descripción</th>
                                <th colspan="2" style="font-size:.75rem;padding:.6rem .75rem;border:none;width:60px;text-align:center;">Acción</th>
                            </tr>
                        </thead>
                        <tbody id="bodyNovedades">
                            <tr id="filaVaciaNovedades">
                                <td colspan="3" class="text-center text-muted py-4" style="font-size:.82rem;">
                                    No hay novedades. Usa el botón <strong>+</strong> para agregar.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="d-flex gap-2 mt-3 align-items-start">
                    <textarea id="textoNovedad" class="form-control form-control-sm" rows="2" placeholder="Describe el trabajo o novedad pendiente…" style="border-radius:8px;font-size:.83rem;resize:vertical;"></textarea>
                    <button type="button" onclick="agregarNovedad()"class="btn-primary-custom btn btn-sm flex-shrink-0" style="padding:.45rem .9rem;font-size:1.1rem;line-height:1;">+</button>
                </div>
            </div>
            <div class="modal-footer p-2 p-md-3" style="background:#f8f9fc;border-top:1px solid #e8e8f0;">
                <div class="d-flex justify-content-between align-items-center w-100 flex-wrap gap-2">
                    <span id="contadorNovedades" style="font-size:.72rem;color:#6c757d;">0 novedades</span>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn-outline-custom btn btn-sm" id="btnVolverNovedades">← Volver</button>
                        <button type="button" class="btn-primary-custom btn btn-sm" id="btnGuardarNovedades">Guardar ✓</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL 4 — OBSERVACIONES -->
<div class="modal fade" id="modalObservaciones" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" style="max-width:min(700px, calc(100vw - .5rem)); margin:.25rem auto;">
        <div class="modal-content border-0 shadow">
            <div class="modal-header modal-header-custom">
                <div style="min-width:0;">
                    <h5 class="modal-title mb-0">🔍 Observaciones</h5>
                </div>
            </div>
            <div class="modal-body p-3 p-md-4">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle" style="min-width:400px;">
                        <thead>
                            <tr style="background:var(--color-dark);color:#fff;">
                                <th style="font-size:.75rem;padding:.6rem .75rem;border:none;width:40px;">#</th>
                                <th style="font-size:.75rem;padding:.6rem .75rem;border:none;">Descripción</th>
                                <th colspan="2" style="font-size:.75rem;padding:.6rem .75rem;border:none;width:60px;text-align:center;">Acción</th>
                            </tr>
                        </thead>
                        <tbody id="bodyObservaciones">
                            <tr id="filaVaciaObservaciones">
                                <td colspan="3" class="text-center text-muted py-4" style="font-size:.82rem;">
                                    No hay observaciones. Usa el botón <strong>+</strong> para agregar.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="d-flex gap-2 mt-3 align-items-start">
                    <textarea id="textoObservaciones" class="form-control form-control-sm" rows="2" placeholder="Escribe la Observacion" style="border-radius:8px;font-size:.83rem;resize:vertical;"></textarea>
                    <button type="button" onclick="agregarObservaciones()" class="btn-primary-custom btn btn-sm flex-shrink-0" style="padding:.45rem .9rem;font-size:1.1rem;line-height:1;">+</button>
                </div>
            </div>
            <div class="modal-footer p-2 p-md-3" style="background:#f8f9fc;border-top:1px solid #e8e8f0;">
                <div class="d-flex justify-content-between align-items-center w-100 flex-wrap gap-2">
                    <span id="contadorObservaciones" style="font-size:.72rem;color:#6c757d;">0 Observaciones</span>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn-outline-custom btn btn-sm" id="btnVolverObservaciones">← Volver</button>
                        <button type="button" class="btn-primary-custom btn btn-sm" id="btnGuardarObservaciones">Guardar ✓</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL 5 — INSUMOS -->
<div class="modal fade" id="modalInsumos" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" style="max-width:min(700px, calc(100vw - .5rem)); margin:.25rem auto;">
        <div class="modal-content border-0 shadow">
            <div class="modal-header modal-header-custom">
                <div style="min-width:0;">
                    <h5 class="modal-title mb-0">🛢 Insumos</h5>
                    <small class="text-white-50" style="font-size:.72rem;">Insumos y repuestos utilizados en el mantenimiento</small>
                </div>
            </div>
            <div class="modal-body p-3 p-md-4">
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

            </div>
            <div class="modal-footer p-2 p-md-3" style="background:#f8f9fc;border-top:1px solid #e8e8f0;">
                <div class="d-flex justify-content-between align-items-center w-100 flex-wrap gap-2">
                    <span id="contadorInsumos" style="font-size:.72rem;color:#6c757d;">0 insumos</span>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn-outline-custom btn btn-sm" id="btnVolverInsumos">← Volver</button>
                        <button type="button" class="btn-primary-custom btn btn-sm" id="btnGuardarInsumos">Guardar ✓</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL 5 — REPUESTOS RETIRADOS -->
<div class="modal fade" id="modalRepuestos" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" style="max-width:min(1000px, calc(100vw - .5rem)); margin:.25rem auto;">
        <div class="modal-content border-0 shadow">
            <div class="modal-header modal-header-custom">
                <div style="min-width:0;">
                    <h5 class="modal-title mb-0">🛢 Repuestos retirados</h5>
                    <small class="text-white-50" style="font-size:.72rem;">Repuestos en el mantenimiento</small>
                </div>
            </div>
            <div class="modal-body p-3 p-md-4">
                <div class="row g-3 mb-3">
                    <label for="nombreSolicita1">Repuestos Retirados:</label>
                    <div class="col-12 col-md-2">
                        <input type="number" id="cantidad1" class="form-control" placeholder="Cantidad" min="1" step="1" >
                    </div>
                    <div class="col-12 col-md-2">
                        <select id="tipoMedida1" name="tipoMedida1" class="form-select">
                            <option value="">medida</option>
                            <option value="Und">Und</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-5">
                        <select  id="select-para1" class="form-control" placeholder="Escribe nombre o codigo..."></select>
                    </div>
                    <div class="col-12 col-md-2">
                        <input type="text" id="descripcion" class="form-control" placeholder="Descripcion falla">
                    </div>
                    <div class="col-12 col-md-1 d-grid">
                        <button type="button" class="btn btn-success" onclick="agregarFila1()">Agregar</button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered" id="tablaSolicitud1">
                        <thead class="table-dark">
                            <tr>
                                <th style="width: 40px;">#</th>
                                <th >Codigo</th>
                                <th style="width: 50px;">Cantidad</th>
                                <th style="width: 50px;"></th>
                                <th>Nombre</th>
                                <th>Descripcion</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="modal-footer p-2 p-md-3" style="background:#f8f9fc;border-top:1px solid #e8e8f0;">
                <div class="d-flex justify-content-between align-items-center w-100 flex-wrap gap-2">
                    <span id="contadorRepuestos" style="font-size:.72rem;color:#6c757d;">0 repuestos</span>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn-outline-custom btn btn-sm" id="btnVolverRepuestos">← Volver</button>
                        <button type="button" class="btn-primary-custom btn btn-sm" id="btnGuardarRepuestos">Guardar ✓</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL 6 TECNICOS-->
<div class="modal fade" id="modalTecnicos" tabindex="-1" aria-labelledby="tituloModalTecnicos" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:16px;border:none;">

            <div class="modal-header" style="border-bottom:1px solid #000020;padding:1rem 1.25rem;">
                <div>
                    <h6 class="modal-title fw-700 mb-0" id="tituloModalTecnicos">Técnicos Encargados</h6>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body" style="padding:1.25rem;">

                <!-- Buscador de técnicos -->
                <div class="mb-3">
                    <label class="form-label" style="font-size:.78rem;font-weight:600;color:#6c757d;text-transform:uppercase;">
                        Agregar técnico
                    </label>
                    <div class="d-flex gap-2">
                        <select id="selectTecnicoModal" class="form-select form-select-sm" style="flex:1;">
                            <option value="" disabled selected>— Seleccione técnico —</option>
                        </select>
                        <button type="button" id="btnConfirmarTecnico"
                            class="btn btn-sm"
                            style="background:var(--color-orange);color:#fff;border:none;border-radius:8px;
                                   padding:0 14px;font-size:.8rem;white-space:nowrap;">
                            + Agregar
                        </button>
                    </div>
                </div>

                <!-- Lista de técnicos actuales -->
                <div>
                    <label class="form-label" style="font-size:.78rem;font-weight:600;color:#6c757d;text-transform:uppercase;">
                        Equipo actual <span id="contadorTecnicos" class="badge bg-secondary ms-1">0</span>
                    </label>
                    <div id="listaTecnicosModal" style="display:flex;flex-direction:column;gap:8px;min-height:48px;">
                        <p class="text-muted text-center" id="sinTecnicos"
                            style="font-size:.8rem;padding:12px 0;">
                            No hay técnicos agregados aún
                        </p>
                    </div>
                </div>

            </div>

            <div class="modal-footer" style="border-top:1px solid #f0f0f5;padding:.75rem 1.25rem;gap:.5rem;">
                <button type="button" id="btnGuardarTecnicos" class="btn btn-sm"
                    style="background:var(--color-orange);color:#fff;border:none;
                           border-radius:8px;font-size:.8rem;padding:6px 18px;">
                    Guardar
                </button>
            </div>

        </div>
    </div>
</div>

<!-- MODAL 7 FIRMAS TECNICOS-->
<div class="modal fade" id="modalFirmasMantenimiento" tabindex="-1" aria-labelledby="modalFirmasMantenimientoLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" style="max-width:min(700px, calc(100vw - .5rem)); margin:.25rem auto;">
       <div class="modal-content border-0 shadow">
            <div class="modal-header modal-header-custom">
                <div style="min-width:0;">
                    <h5 class="modal-title mb-0">📋 Firmas de los mecánicos</h5>
                </div>
            </div>
            <div class="modal-body p-3 p-md-4">
                <div class="alert alert-info">
                    Cada mecánico que participó en el mantenimiento debe registrar su firma.
                </div>
                <div id="contenedorFirmasMecanicos">
                    <!-- Las firmas se generan aquí dinámicamente -->
                </div>

            </div>
            <div class="modal-footer p-2 p-md-3" style="background:#f8f9fc;border-top:1px solid #e8e8f0;">
                <button type="button" class="btn btn-primary" id="btnGuardarFirmas"> Guardar firmas</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL 8 FIRMAS SUPERVISOR/OPERARIO/TECNICOS-->
<div class="modal fade" id="modalFirma" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tituloModalFirma">Firmar mantenimiento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="ID_MantenimientoFirma">
                <input type="hidden" id="TipoFirma">
                <input type="hidden"  id="ID_MecanicoFirma">
                <div class="text-center mb-3">
                    <p id="textoModalFirma">Realice su firma</p>
                </div>
                <div class="border rounded p-2">
                    <canvas id="canvasFirma1" width="500" height="250" style="width:100%; height:250px; touch-action:none;"></canvas>
                </div>
                <div class="d-flex justify-content-end mt-2">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="limpiarFirma()">Limpiar</button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button"class="btn btn-primary" onclick="guardarFirma()">Firmar</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL 9 BUSCAR -->
<div class="modal fade" id="modalBuscarMantenimiento" tabindex="-1" aria-labelledby="modalBuscarMantenimientoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow">
            <div class="modal-header modal-header-custom">
                <div>
                    <h5 class="modal-title mb-0" id="modalBuscarMantenimientoLabel">
                        🔎 Buscar mantenimiento
                    </h5>
                    <small class="text-white-50" style="font-size:.72rem;">
                        Ingresa uno o varios parámetros de búsqueda
                    </small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body p-3 p-md-4">
                <form id="formBuscarMantenimiento">
                    <div class="section-divider">
                        <span>Parámetros de búsqueda</span>
                    </div>
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label class="form-label-sm"> Centro de trabajo</label>
                            <select class="form-select" id="buscarCentro">
                                <option value=""> Todos </option>
                                <?php
                                    if ($ListaCentrosDeTrabajo) {
                                        foreach ($ListaCentrosDeTrabajo as $ListaCentroDeTrabajo) {
                                            echo "
                                                <option value='{$ListaCentroDeTrabajo['Nombre']}'>
                                                    " . htmlspecialchars($ListaCentroDeTrabajo['Nombre']) . "
                                                </option>
                                            ";
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <!-- MONTACARGAS -->
                        <div class="col-12 col-md-6">
                            <label class="form-label-sm"> Montacargas</label>
                            <input type="text" class="form-control" id="buscarMontacargas" placeholder="Número, marca, modelo o serie">
                        </div>

                        <!-- TIPO MONTACARGAS -->
                        <div class="col-12 col-md-6">
                            <label class="form-label-sm">Tipo de montacargas</label>
                            <select class="form-select"id="buscarTipoMontacargas">
                                <option value=""> Todos </option>
                                <option value="combustion">Combustión</option>
                                <option value="contrabalanceada">Contrabalanceada</option>
                                <option value="pasillo">Pasillo</option>
                                <option value="manlift">Manlift</option>
                            </select>
                        </div>

                        <!-- FECHA DESDE -->
                        <div class="col-12 col-md-6">
                            <label class="form-label-sm">Fecha desde</label>
                            <input type="date" class="form-control" id="buscarFechaDesde">
                        </div>

                        <!-- FECHA HASTA -->
                        <div class="col-12 col-md-6">
                            <label class="form-label-sm"> Fecha hasta</label>
                            <input type="date" class="form-control" id="buscarFechaHasta">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <button type="button" class="btn-outline-custom btn" id="btnLimpiarBusqueda"> 
                            Limpiar
                        </button>
                        <button type="submit" class="btn-primary-custom btn">
                            🔎 Buscar
                        </button>

                    </div>
                </form>

                <!-- RESULTADOS -->
                <div id="resultadoBusquedaMantenimiento" class="mt-4" style="display:none;">
                    <div class="section-divider">
                        <span>Resultados</span>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead style="background:var(--color-dark);color:#fff;">
                                <tr>
                                    <th>#</th>
                                    <th>Mantenimiento</th>
                                    <th>Montacargas</th>
                                    <th>Centro</th>
                                    <th>Fecha</th>
                                    <th>Accion</th>
                                </tr>
                            </thead>
                            <tbody id="bodyResultadosBusqueda"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL 10 — INFORMES -->
<div class="modal fade" id="modalInformeMantenimiento" tabindex="-1" aria-labelledby="modalInformeMantenimientoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow">
            <div class="modal-header modal-header-custom">
                <div>
                    <h5 class="modal-title mb-0" id="modalInformeMantenimientoLabel">
                        📊 Informes de mantenimiento
                    </h5>
                    <small class="text-white-50" style="font-size:.72rem;">
                        Selecciona el informe y el formato de generación
                    </small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body p-3 p-md-4">
                <form id="formInformeMantenimiento">
                    <!-- TIPO DE INFORME -->
                    <div class="section-divider">
                        <span>Tipo de informe</span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label-sm">Informe</label>
                        <select class="form-select" id="tipoInforme" required>
                            <option value="">Seleccione un informe</option>
                            <option value="F_145">Matriz de seguimiento de mantenimientos preventivos</option>
                            <option value="F_144">Matriz de seguimiento de mantenimientos correctivos</option>
                        </select>
                    </div>
                    <!-- FORMATO -->
                    <div class="section-divider mt-4">
                        <span>Formato</span>
                    </div>
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <div class="form-check border rounded p-3">
                                <input class="form-check-input" type="radio" name="formatoInforme" id="formatoPDF" value="pdf" checked>
                                <label class="form-check-label" for="formatoPDF">
                                    <strong>📄 PDF</strong>
                                    <br>
                                    <small class="text-muted">Informe listo para imprimir o enviar</small>
                                </label>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-check border rounded p-3">
                                <input class="form-check-input" type="radio" name="formatoInforme" id="formatoExcel" value="excel">
                                <label class="form-check-label" for="formatoExcel">
                                    <strong>📊 Excel</strong>
                                    <br>
                                    <small class="text-muted">Datos para análisis y filtros</small>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- FILTROS -->
                    <div class="section-divider mt-4">
                        <span>Filtros</span>
                    </div>
                    <div class="row g-3">
                        <!-- CENTRO -->
                        <div class="col-12 col-md-6">
                            <label class="form-label-sm">Centro de trabajo</label>
                            <select class="form-select" id="informeCentro">
                                <option value="">Todos</option>
                                <?php
                                    if ($ListaCentrosDeTrabajo) {
                                        foreach ($ListaCentrosDeTrabajo as $centro) {
                                            echo "
                                                <option value='" . $centro['ID'] . "'>
                                                    " . htmlspecialchars($centro['Nombre']) . "
                                                </option>";
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <!-- MONTACARGAS -->
                        <div class="col-6">
                            <label class="form-label-sm">Montacargas</label>
                            <input type="text" class="form-control" id="informeMontacargas" placeholder="Número, serie, marca o modelo">
                        </div>
                        <!-- FECHA DESDE -->
                        <div class="col-12 col-md-6">
                            <label class="form-label-sm">Fecha desde</label>
                            <input type="date" class="form-control" id="informeFechaDesde">
                        </div>
                        <!-- FECHA HASTA -->
                        <div class="col-12 col-md-6">
                            <label class="form-label-sm">Fecha hasta</label>
                            <input type="date" class="form-control" id="informeFechaHasta">
                        </div>
                    </div>

                    <!-- BOTONES -->
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <button type="button" class="btn btn-outline-secondary" id="btnLimpiarInforme">
                            Limpiar
                        </button>
                        <button type="submit" class="btn-primary-custom btn">
                            📊 Generar informe
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--  MODAL 11 - REGISTRAR FALLA Y CORRECCIÓN -->
<div class="modal fade" id="modalFallaCorreccion" tabindex="-1" aria-labelledby="modalFallaCorreccionLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow">
            <div class="modal-header modal-header-custom">
                <div>
                    <h5 class="modal-title mb-0" id="modalFallaCorreccionLabel">🔧 Registrar Falla y Corrección</h5>
                    <small class="text-white-50" style="font-size:.72rem;">Registre la falla encontrada y la corrección realizada.</small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body p-3 p-md-4">
                <!-- FALLA -->
                <div class="section-divider">
                    <span>Falla</span>
                </div>
                <div class="mb-3">
                    <label class="form-label-sm">Seccion</label>
                    <select class="form-select" name="Seccion" id="Seccion" required>
                        <option value="" disabled selected>Seleccione seccion</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label-sm">Descripción de la falla</label>
                    <textarea class="form-control" id="descripcionFalla" rows="4" placeholder="Describa detalladamente la falla encontrada..."style="resize:vertical;"></textarea>
                </div>
                <!-- IMÁGENES FALLA -->
                <div class="img-uploader" id="uploaderFalla">
                    <div class="img-uploader-header">
                        <span style="font-size:.72rem;font-weight:700;color:#6c757d;text-transform:uppercase;letter-spacing:.4px;">
                            📷 Imágenes de falla <span class="badge bg-secondary ms-1" id="imgCountFalla">0</span>
                        </span>
                        <label for="imgInputFalla" class="btn btn-sm" style="border:1.5px dashed var(--color-orange);
                            color:var(--color-orange); border-radius:8px; font-size:.72rem; background:transparent; cursor:pointer; padding:3px 10px;">
                            + Agregar foto
                        </label>
                        <input type="file" id="imgInputFalla" name="imagenesFalla[]" accept="image/*"
                            multiple class="d-none img-file-input" data-slug="falla" onchange="previsualizarImagenes(this)">
                    </div>
                    <div class="img-preview-wrap d-flex flex-wrap gap-2 mt-2" id="imgPreviewFalla"></div>

                </div>
                <!-- CORRECCIÓN -->
                <div class="section-divider">
                    <span>Corrección</span>
                </div>
                <div class="mb-3">
                    <label class="form-label-sm">Descripción de la corrección</label>
                    <textarea class="form-control" id="descripcionCorreccion" rows="4" placeholder="Describa la corrección realizada..." style="resize:vertical;"></textarea>
                </div>
                <!-- IMÁGENES CORRECCIÓN -->
                <div class="img-uploader" id="uploaderCorreccion">
                        <div class="img-uploader-header">
                            <span style="font-size:.72rem;font-weight:700;color:#6c757d;text-transform:uppercase;letter-spacing:.4px;">📷 Imágenes de corrección 
                                <span class="badge bg-secondary ms-1" id="imgCountCorreccion"> 0 </span>
                            </span>
                            <label for="imgInputCorreccion" class="btn btn-sm" style="border:1.5px dashed var(--color-orange); color:var(--color-orange); border-radius:8px; font-size:.72rem; background:transparent; cursor:pointer; padding:3px 10px;">
                                + Agregar foto
                            </label>
                            <input type="file" id="imgInputCorreccion" name="imagenesCorreccion[]" accept="image/*" multiple
                                class="d-none img-file-input" data-slug="correccion" onchange="previsualizarImagenes(this)">
                        </div>
                        <div class="img-preview-wrap d-flex flex-wrap gap-2 mt-2" id="imgPreviewCorreccion"></div>
                </div>
            </div>

            <div class="modal-footer p-2 p-md-3" style=" background:#f8f9fc; border-top:1px solid #e8e8f0;">
                <button type="button" class="btn-outline-custom btn btn-sm" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn-primary-custom btn btn-sm" id="btnGuardarFallaCorreccion"> Guardar ✓</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL 12 - EDITAR FALLA / CORRECCIÓN -->
<div class="modal fade" id="modalEditarDetalle" tabindex="-1" aria-labelledby="modalEditarDetalleLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditarDetalleLabel">✏️ Editar detalle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="editarIDDetalle">
                <input type="hidden" id="editarCategoria">
                <!-- SECCION -->
                <div class="mb-3">
                    <label class="form-label-sm">Seccion</label>
                    <select class="form-select" name="Seccion" id="Seccion1" required>
                        <option value="" disabled selected>Seleccione seccion</option>
                    </select>
                </div>
                <!-- DESCRIPCIÓN -->
                <div class="mb-3">
                    <label for="editarDescripcionDetalle" class="form-label fw-bold" id="editarLabelDescripcion">Descripción </label>
                    <textarea id="editarDescripcionDetalle" class="form-control" rows="4" placeholder="Ingrese la descripción..."> </textarea>
                </div>
                <!-- IMÁGENES  EVIDENCIAS -->
                <div class="mb-3">
                    <label class="form-label fw-bold">📷 Evidencias</label>
                    <!-- Fotos existentes y fotos nuevas -->
                    <div id="editarImagenesDetalle" class="d-flex flex-wrap gap-2 mb-3" style="min-height:80px;"></div>
                    <div id="sinImagenesDetalle" class="text-muted text-center py-2" style="display:none;">No hay imágenes para este detalle.</div>
                    <!-- Botón para agregar fotos -->
                    <label for="editarNuevasImagenes" class="btn btn-outline-primary btn-sm"><i class="fas fa-camera"></i>Agregar fotos</label>
                    <input type="file" id="editarNuevasImagenes" accept="image/*" multiple hidden>
                    <small class="form-text text-muted d-block mt-2">Puedes agregar varias fotos al detalle.</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="guardarEdicionDetalle()">
                    <i class="fas fa-save"></i> Guardar cambios
                </button>
            </div>
        </div>
    </div>
</div>

<!-- LIGHTBOX — VER IMAGEN GRANDE -->
<div id="lightboxOverlay"
    style="display:none;position:fixed;inset:0;z-index:99999;background:rgba(0,0,0,.88);
           align-items:center;justify-content:center;cursor:zoom-out;"
    onclick="cerrarLightbox()">
    <button onclick="cerrarLightbox()" aria-label="Cerrar"
        style="position:absolute;top:1rem;right:1rem;background:rgba(255,255,255,.15);
               border:none;border-radius:50%;width:38px;height:38px;color:#fff;
               font-size:1.2rem;cursor:pointer;display:flex;align-items:center;justify-content:center;z-index:2;">✕</button>
    <img id="lightboxImg" src="" alt="Vista ampliada"
        style="max-width:92vw;max-height:88vh;border-radius:10px;
               box-shadow:0 8px 40px rgba(0,0,0,.6);object-fit:contain;cursor:default;"
        onclick="event.stopPropagation()">
</div>

<!-- Datos PHP → JS -->
<script>
    window.ID_Sesion = <?= $_SESSION['ID'] ?>;
    window.baseUrl = "<?= $baseUrl ?>";
    window.MANTENIMIENTOS_DATA = <?= json_encode($Mantenimientos ?: []) ?>;
</script>
<script src="<?= $baseUrl ?>App/Views/Js/Mantenimientos/Correctivos.js" defer></script>

<?php require "App/Views/Templates/Layouts/Footer.php"; ?>
