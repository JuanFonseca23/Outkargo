/*Variables globales */
window.ID_Mantenimiento = null;
window.ID_Detalle = null;
window.ID_Montacargas = null;
window.ID_Centro = null;
window.Tipo_Mantenimiento=null;
window.Tipo_Montacargas=null;
window.Mantenimiento = 'Preventivo';
window._tecnicos = [];
window._TecnicosTemp = [];
window.insumos = [];
window._insumosTemp = [];
window._novedades = [];
window._novedadesTemp = [];

/* CONSTANTES Y HELPERS  */
const OPCIONES_SIN_TRABAJO  = ['C', 'N/A', ''];
const CAMPOS_TEXTO_HIDDEN   = ['N_Bateria', 'ClaseH', 'LongitudH'];

const ICONOS_SECCION = {
    'bateria':'https://img.icons8.com/ios-filled/50/000020/battery.png',
    'electrico':'https://img.icons8.com/ios-filled/50/000020/carbon-brush.png',
    'hidraulico':'https://img.icons8.com/external-solidglyph-m-oki-orlando/64/000020/external-hydraulic-engineering-engineering-solid-solidglyph-m-oki-orlando.png',
    'motor':'https://img.icons8.com/ios-filled/50/000020/engine.png',
    'frenos':'https://img.icons8.com/ios-filled/50/000020/abs.png',
    'direccion':'https://img.icons8.com/ios-filled/50/000020/steering-wheel.png',
    'horquillas':'https://img.icons8.com/ios-filled/50/000020/l.png',
    'mastil':'https://img.icons8.com/deco-glyph/50/000028/fork-lift.png',
    'chasis':'https://img.icons8.com/ios-glyphs/50/000020/4x4-vehicle.png',
    'lubricacion':'https://img.icons8.com/ios-filled/50/000020/engine-oil-level.png',
    'ruedas':'https://img.icons8.com/ios-glyphs/50/000020/wheel.png',
    'transmision':'https://img.icons8.com/pulsar-line/50/000020/engine-coolant.png',
    'aditamentos':'https://img.icons8.com/ios-glyphs/50/000020/gearbox-selector.png',
    'luces':'https://img.icons8.com/ios-filled/50/000020/headlight.png',
    'combustion':'https://img.icons8.com/ios-filled/50/000020/spark-plug.png',
    'caja':'https://img.icons8.com/ios-filled/50/000020/gear-stick.png',
    'refrigeracion':'https://img.icons8.com/ios-glyphs/50/000020/car-radiator.png',
    'revision':'https://img.icons8.com/ios-filled/50/000020/checklist.png',
    'pintura' : 'https://img.icons8.com/external-flatart-icons-solid-flatarticons/64/000020/external-airbrush-fine-arts-flatart-icons-solid-flatarticons.png',
    'traccion' : 'https://img.icons8.com/ios-filled/50/000020/traction-control.png',
    'cargador' : 'https://img.icons8.com/external-yogi-aprelliyanto-glyph-yogi-aprelliyanto/50/000020/external-power-supply-computer-hardware-yogi-aprelliyanto-glyph-yogi-aprelliyanto.png',
    'suspension' : 'https://img.icons8.com/external-prettycons-solid-prettycons/50/000020/external-suspension-car-parts-vehicles-prettycons-solid-prettycons.png',
    'auxiliares' : 'https://img.icons8.com/ios-filled/50/000020/steering-wheel.png',
    'pantografo' : 'https://img.icons8.com/sf-regular-filled/50/000020/mine-cart.png',
    'ausencia' : 'https://img.icons8.com/ios-filled/50/000020/administrative-tools.png',
    'funcionamiento' : 'https://img.icons8.com/external-goofy-solid-kerismaker/50/000020/external-Ladder-Truck-airport-goofy-solid-kerismaker.png',
    'panel' : 'https://img.icons8.com/wired/50/000020/control-panel.png',
    'revisiones' : 'https://img.icons8.com/ios-filled/50/000020/checklist.png',
    'correas' : 'https://img.icons8.com/external-flatart-icons-outline-flatarticons/50/000020/external-chain-jewellery-flatart-icons-outline-flatarticons.png',
    'componentes' : 'https://img.icons8.com/ios-filled/50/000020/fork-lift.png',

};

function esCampoTexto(hidden) {
    return CAMPOS_TEXTO_HIDDEN.some(f => hidden.includes(f));
}

function slugSeccion(nombre) {
    return nombre.toLowerCase()
        .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
        .replace(/[^a-z0-9]+/g, '_')
        .replace(/^_|_$/g, '');
}

function iconoSeccion(nombre) {
    const k = nombre.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '');
    for (const [key, val] of Object.entries(ICONOS_SECCION)) {
        if (k.includes(key)){
            // Si es URL → renderiza imagen
            if (val.startsWith('http')){
                return `<img src="${val}" alt="${key}" style="width:24px;height:24px;">`;
            }
            return val;
        } 
    }
    return '🔧';
}

/* ════ STORE GLOBAL ════ */
window._seccionesData     = {};
window._respuestasSeccion = {};
window._imagenesSeccion   = {};
let _slugSeccionActual    = null;

/* ════    RENDER CRITERIOS ════ */
function renderCriterio(criterio, idx) {
    const esTexto = esCampoTexto(criterio.hidden);
    const inputId = `inp_${criterio.id}`;
    const obsId   = `obs_${criterio.id}`;

    if (esTexto) {
        return `
        <div class="criterio-row criterio-texto" data-idx="${idx}">
            <div class="criterio-label">${criterio.label}</div>
            <div class="criterio-control">
                <input type="text"
                    class="form-control form-control-sm"
                    id="${inputId}" name="${criterio.name}"
                    data-hidden="${criterio.hidden}"
                    placeholder="Ingrese valor">
            </div>
        </div>`;
    }

    return `
    <div class="criterio-row" data-idx="${idx}">
        <div class="criterio-label">${criterio.label}</div>
        <div class="criterio-control">
            <select class="form-select form-select-sm criterio-select"
                id="${inputId}" name="${criterio.name}"
                data-hidden="${criterio.hidden}"
                data-obs-target="${obsId}"
                onchange="toggleObservacion(this)">
                <option value="">— Seleccione —</option>
                <option value="C">✔ C — Conforme</option>
                <option value="R">🔧 R — Reparación</option>
                <option value="N">⚖ N — Nivelación</option>
                <option value="A">🔩 A — Ajuste</option>
                <option value="L">🛢 L — Lubricación</option>
                <option value="N/A">— N/A</option>
            </select>
            <div class="obs-wrapper d-none" id="${obsId}">
                <textarea class="form-control form-control-sm mt-1 obs-textarea"
                    name="obs_${criterio.name}" rows="2"
                    placeholder="Describa el trabajo a realizar…"></textarea>
            </div>
        </div>
    </div>`;
}

//Parte para autoguardado de informacion

function toggleObservacion(select) {

    const obsDiv = document.getElementById(select.dataset.obsTarget);

    if (!obsDiv) return;

    const necesita = !OPCIONES_SIN_TRABAJO.includes(select.value);

    // Obtener criterio desde el principio
    const criterio = select.dataset.hidden;

    // Obtener slug actual
    const slug = _slugSeccionActual;
    obsDiv.classList.toggle('d-none', !necesita);
    const textarea = obsDiv.querySelector('textarea');

    if (textarea) {

        textarea.required = necesita;
        if (!necesita) {

            // Limpiar textarea
            textarea.value = '';

            if (slug && window._respuestasSeccion[slug] && criterio) {
                delete window._respuestasSeccion[slug][
                    'obs_' + criterio
                ];
            }
            if (criterio) {
                autoguardarObservacion( criterio, '');
            }

        }

    }

    select.dataset.val = select.value;

    actualizarProgreso();
}

async function autoguardarCriterio(elemento) {

    if (!window.ID_Detalle) {
        console.warn('No hay ID_Detalle definido. No se puede autoguardar.');
        return;
    }

    const campo = elemento.dataset.hidden;
    const valor = elemento.value;

    if (!campo) {
        console.warn('El elemento no tiene data-hidden definido. No se puede autoguardar.');
        return;
    }

    try {

        await fetch(
            `${window.baseUrl}Mantenimiento/AutoguardarCriterio`,
            {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    ID_Detalle: window.ID_Detalle,
                    campo: campo,
                    valor: valor
                })
            }
        );
    } catch (error) {
        console.error('Error al autoguardar criterio:', error);
    }
}

async function autoguardarObservacion(criterio, observacion) {
    if (!window.ID_Detalle) {
        console.warn('No hay ID_Detalle definido. No se puede autoguardar la observación.');
        return;
    }

    try{
        await fetch(
            `${window.baseUrl}Mantenimiento/AutoguardarObservaciones`,
            {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    ID_Detalle: window.ID_Detalle,
                    criterio: criterio,
                    observacion: observacion
                })
            }
        );
    } catch (error) {
        console.error( 'Error de conexión al guardar observación:', error);
    }
}

/* ════ TARJETAS DE SECCIÓN ════ */
function contarCompletadosSeccion(slug) {
    const seccion = window._seccionesData[slug];
    const resp = window._respuestasSeccion[slug] || {};
    if (!seccion) return 0;
    // Solo cuentan los criterios tipo select (no los de texto libre como N_Bateria/LongitudH,
    // que se guardan en el mismo objeto de respuestas pero no forman parte del "total" mostrado).
    return seccion.criterios.filter(c =>
        !esCampoTexto(c.hidden) && resp[c.name] !== undefined && resp[c.name] !== ''
    ).length;
}

function renderTarjetasSecciones() {
    const contenedor = document.getElementById('contenedorCriterios');
    let html = '<div class="row g-2 g-md-3">';

    for (const [slug, data] of Object.entries(window._seccionesData)) {
        const total       = data.criterios.filter(c => !esCampoTexto(c.hidden)).length;
        const completados = contarCompletadosSeccion(slug);
        const pct         = total > 0 ? Math.round((completados / total) * 100) : 0;
        const estado      = pct === 100 ? 'completada' : pct > 0 ? 'parcial' : '';
        const icono       = iconoSeccion(data.nombre);
        const check       = pct === 100 ? ' ✅' : '';

        html += `
        <div class="col-12 col-sm-6 col-xl-4">
            <div class="seccion-card ${estado}" onclick="abrirSeccion('${slug}')"
                role="button" tabindex="0"
                onkeydown="if(event.key==='Enter'||event.key===' '){abrirSeccion('${slug}')}">
                <div class="seccion-card-icon">${icono}</div>
                <div class="seccion-card-body">
                    <div class="seccion-card-title" id="title_${slug}">${data.nombre}${check}</div>
                    <div class="seccion-card-sub" id="sub_${slug}">
                        ${completados} / ${total} criterios
                        ${pct > 0 ? `· <strong style="color:${pct===100?'#198754':'#856404'}">${pct}%</strong>` : ''}
                    </div>
                </div>
                <span class="seccion-card-arrow">›</span>
                <div class="seccion-progress-bar" id="bar_${slug}" style="width:${pct}%"></div>
            </div>
        </div>`;
    }

    html += '</div>';
    contenedor.innerHTML = html;
}

function actualizarTarjeta(slug) {
    const data = window._seccionesData[slug];
    if (!data) return;
    const total       = data.criterios.filter(c => !esCampoTexto(c.hidden)).length;
    const completados = contarCompletadosSeccion(slug);
    const pct         = total > 0 ? Math.round((completados / total) * 100) : 0;
    const estado      = pct === 100 ? 'completada' : pct > 0 ? 'parcial' : '';

    const card = document.querySelector(`.seccion-card[onclick="abrirSeccion('${slug}')"]`);
    if (card) {
        card.className = `seccion-card ${estado}`;
        document.getElementById(`title_${slug}`).textContent =
            data.nombre + (pct === 100 ? ' ✅' : '');
        document.getElementById(`sub_${slug}`).innerHTML =
            `${completados} / ${total} criterios` +
            (pct > 0 ? ` · <strong style="color:${pct===100?'#198754':'#856404'}">${pct}%</strong>` : '');
        document.getElementById(`bar_${slug}`).style.width = pct + '%';
    }
    actualizarProgreso();
}

/* ════ CARGAR CRITERIOS → TARJETAS ═══ */
function cargarCriterios(tipoMantenimiento, tipoMontacargas) {
    const contenedor = document.getElementById('contenedorCriterios');
    if (!contenedor) return;

    if (!window.CRITERIOS_DATA) {
        contenedor.innerHTML = `<div class="alert alert-warning m-3">No se pudieron cargar los criterios.</div>`;
        return;
    }
    const dataTipo = window.CRITERIOS_DATA[tipoMantenimiento];
    if (!dataTipo) {
        contenedor.innerHTML = `<div class="alert alert-warning m-3">Tipo no encontrado: <strong>${tipoMantenimiento}</strong></div>`;
        return;
    }

    window._seccionesData     = {};
    window._respuestasSeccion = {};
    window._imagenesSeccion   = {};
    let totalGlobal = 0;

    for (const [nombreSeccion, tiposEquipo] of Object.entries(dataTipo)) {
        const criterios = tiposEquipo[tipoMontacargas];
        if (!criterios || criterios.length === 0) continue;
        const slug = slugSeccion(nombreSeccion);
        window._seccionesData[slug] = { nombre: nombreSeccion, criterios, slug };
        totalGlobal += criterios.filter(c => !esCampoTexto(c.hidden)).length;
    }

    window._totalCriterios = totalGlobal;

    if (!Object.keys(window._seccionesData).length) {
        contenedor.innerHTML = `<div class="text-center py-4 text-muted"><p style="font-size:.82rem;">No hay criterios para esta combinación.</p></div>`;
        return;
    }

    // Mostrar tarjetas especiales
    const especiales = document.getElementById('tarjetasEspeciales');
    if (especiales) especiales.style.display = '';

    renderTarjetasSecciones();
    actualizarProgreso();
}

function actualizarProgreso() {
    const total = window._totalCriterios || 0;
    let completados = 0;
    for (const slug of Object.keys(window._seccionesData)) {
        completados += contarCompletadosSeccion(slug);
    }
    const el = document.getElementById('progresoTexto');
    if (el) {
        el.textContent = `${completados} de ${total} criterios completados`;
        const pct = total > 0 ? completados / total : 0;
        el.style.color = pct === 1 ? '#198754' : pct > 0.5 ? '#856404' : '#6c757d';
    }
}

function mostrarSupervisor() {
    var select = document.getElementById("Autoriza");
    var selectedValue = select.value;
    if (!selectedValue) {
        window.ID_Supervisor1 = null;
        window.Correo_Supervisor1 = null;
        window.Nombre_Supervisor1 = null;
        return;
    }

    var supervisorSeleccionado =select.options[select.selectedIndex].text.trim();
    var parts = selectedValue.split('|');
    var idSupervisor = parts[0];
    var correoSupervisor = parts[1];

    // Guardar en variables globales
    window.ID_Supervisor1 = idSupervisor;
    window.Correo_Supervisor1 = correoSupervisor;
    window.Nombre_Supervisor1 = supervisorSeleccionado;
}
/* ═══════════════ TABLA DE MANTENIMIENTOS (pestañas por firma pendiente) ═════════ */
function obtenerMecanicos1(m) {
    if (!m.Mecanicos) {
        return [];
    }
    return m.Mecanicos
        .split(',')
        .filter(item => item.trim() !== '')
        .map(item => {
            const partes = item.split(':');
            return {
                ID_Mecanico: Number(partes[0]),
                Nombre_Mecanico: partes[1] || '',
                Estado_Firma_Mecanico: Number(partes[2])
            };
        });
}

function agruparMantenimientos(lista) {
    const agrupados = {};
    (lista || []).forEach(fila => {
        const id = fila.ID;
        if (!agrupados[id]) {
            agrupados[id] = { ...fila, TieneMecanicos: false, TodosMecanicosFirmaron: true };
        }
        if (fila.ID_Mecanico) {
            agrupados[id].TieneMecanicos = true;
            if (!fila.Estado_Firma_Mecanico || Number(fila.Estado_Firma_Mecanico) === 0) {
                agrupados[id].TodosMecanicosFirmaron = false;
            }
        }
    });
    return Object.values(agrupados);
}
 
function clasificarMantenimientos(lista) {

    const t = {
        faltaSupervisor: [],
        faltaOperario: [],
        faltaMecanico: [],
        completos: []
    };

    lista.forEach(m => {
        const faltaSupervisor = Number(m.Estado_Firma_Supervisor) === 0;
        const faltaOperario = Number(m.Estado_Firma_Operario) === 0;
        const mecanicos = obtenerMecanicos1(m);
        const tieneMecanicos = mecanicos.length > 0;
        // Existe al menos un mecánico que todavía no ha firmado
        const mecanicosPendientes = mecanicos.filter(mecanico => Number(mecanico.Estado_Firma_Mecanico) === 0);
        const faltaMecanico = tieneMecanicos && mecanicosPendientes.length > 0;
        // Guardamos información calculada
        m.TieneMecanicos = tieneMecanicos;
        m.MecanicosPendientes = mecanicosPendientes;
        m.TodosMecanicosFirmaron = tieneMecanicos && mecanicosPendientes.length === 0;
        if (faltaSupervisor){
            t.faltaSupervisor.push(m);
        }
        if (faltaOperario){
            t.faltaOperario.push(m);
        }
        if (faltaMecanico){
            t.faltaMecanico.push(m);
        }
        if (!faltaSupervisor && !faltaOperario && !faltaMecanico){
            t.completos.push(m);
        }
    });
    return t;
}

function formatearFecha(fecha) {
    if (!fecha) return '';
    const partes = String(fecha).split('-');
    if (partes.length !== 3) {
        return fecha;
    }
     return `${partes[2]}/${partes[1]}/${partes[0]}`;
}
 
function filaMantenimientoHTML(m, contexto) {
    const verificado = Number(m.Estado_Firma_Supervisor) === 1;
    const progressBarClass = verificado ? 'bg-success' : 'bg-warning';
    const estadoTexto = verificado ? 'Verificado' : 'Por Verificar';
    const TipoMantenimiento = (m.Tipo_Mantenimiento ?? '').replace(/_/g, '');
    const fechaFormateada = formatearFecha(m.Fecha_Realizado);
 
    let botonAccion = '';
 
    if (contexto === 'supervisor') {
        // Solo lo ve el supervisor asignado
        const nombreSupervisor =
        (m.NombreSupervisor ?? '').replace(/'/g, "\\'");
        botonAccion = (window.ID_Sesion == m.ID_Supervisor)
            ? `
                <button type="button" class="btn btn-sm btn-dark" onclick="abrirModalFirma(${m.ID}, 'supervisor', ${m.ID_Supervisor}, '${nombreSupervisor}', '${m.TipoMontacargas}', '${TipoMantenimiento}')">
                    <img width="20" height="20" src="https://img.icons8.com/sf-regular-filled/24/ffffff/autograph.png" alt="autograph"/>
                </button>
            `
            : '';

    } else if (contexto === 'operario') {
            const nombreOperario = m.ID_Recibe !== null && m.ID_Recibe !== '' && Number(m.ID_Recibe) > 0 ? (m.NombreRecibe ?? '') : (m.Nombre_Externo ?? '');
            const nombreOperarioSeguro = nombreOperario.replace(/'/g, "\\'");
            botonAccion = `
                <button type="button" class="btn btn-sm btn-warning" onclick="abrirModalFirma(${m.ID}, 'operario', ${m.ID_Recibe ?? 'null'}, '${nombreOperarioSeguro}','${m.TipoMontacargas}', '${TipoMantenimiento}')">
                    <img width="20" height="20" src="https://img.icons8.com/sf-regular-filled/24/ffffff/autograph.png" alt="autograph"/>
                </button>
            `;
    }else if (contexto === 'mecanico') {
        const mecanicos = obtenerMecanicos1(m);
        const mecanicoPendiente = mecanicos.find(
            mecanico => Number(mecanico.ID_Mecanico) === Number(window.ID_Sesion) && Number(mecanico.Estado_Firma_Mecanico) === 0
        );

        if (mecanicoPendiente) {

            const nombreMecanico =(mecanicoPendiente.Nombre_Mecanico ?? '').replace(/'/g, "\\'");
            botonAccion = `
                <button type="button"class="btn btn-sm btn-info" onclick="abrirModalFirma(${m.ID}, 'mecanico', ${mecanicoPendiente.ID_Mecanico}, '${nombreMecanico}', '${m.TipoMontacargas}', '${TipoMantenimiento}')">
                    <img width="20" height="20" src="https://img.icons8.com/sf-regular-filled/24/ffffff/autograph.png" alt="autograph"/>
                </button>
            `;
        }
    }
    // contexto === 'completos' → sin botón de firma
 
    return `
    <tr data-id="${m.ID}">
        <td width="100" class="text-center">${m.NumeroM ?? ''}</td>
        <td>${m.MarcaM ?? ''}</td>
        <td>${m.ModeloM ?? ''}</td>
        <td>${m.SerieM ?? ''}</td>
        <td> ${fechaFormateada}</td>
        <td>${m.Tipo_Mantenimiento ?? ''}</td>
        <td>${m.Centrot ?? ''}</td>
        <td>${m.HorometroM ?? ''}</td>
        <td>
            <div class="progress">
                <div class="progress-bar ${progressBarClass}" role="progressbar" style="width:100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                    ${estadoTexto}
                </div>
            </div>
        </td>
        <td width="200" class="text-center">
            <a class="btn btn-sm btn-primary" target="_blank" href="VerMantenimientoPreventivo${encodeURIComponent(m.TipoMontacargas)}${encodeURIComponent(TipoMantenimiento)}?ID=${encodeURIComponent(m.ID)}">
                <img width="20" height="20" src="https://img.icons8.com/material-outlined/24/ffffff/visible--v1.png" alt="Ver" />
            </a>
            ${botonAccion}
        </td>
    </tr>`;
}
 
/* ── Estado de tabla: página, búsqueda y entradas por página, por pestaña ── */
window.paginasMantenimientos     = { supervisor: 1, operario: 1, mecanico: 1, completos: 1 };
window.busquedaMantenimientos    = { supervisor: '', operario: '', mecanico: '', completos: '' };
window.entradasPorPaginaMant     = { supervisor: 10, operario: 10, mecanico: 10, completos: 10 };
window.pestanaActivaMantenimientos = null;

function cambiarPaginaMantenimientos(contexto, pagina) {
    window.paginasMantenimientos[contexto] = pagina;
    window.pestanaActivaMantenimientos = 'tab' + contexto.charAt(0).toUpperCase() + contexto.slice(1);
    renderTablasMantenimientos();
}
 
function cambiarEntradasMantenimientos(contexto, valor) {
    window.entradasPorPaginaMant[contexto] = parseInt(valor, 10) || 10;
    window.paginasMantenimientos[contexto] = 1;
    renderTablasMantenimientos();
}
 
function buscarMantenimientos(contexto, valor) {
    window.busquedaMantenimientos[contexto] = valor;
    window.paginasMantenimientos[contexto] = 1;
    renderTablasMantenimientos();
 
    // Re-enfocar el buscador de esta pestaña (el render reconstruye el input)
    const input = document.getElementById(`buscador_${contexto}`);
    if (input) {
        input.focus();
        const pos = input.value.length;
        input.setSelectionRange(pos, pos);
    }
}
 
function filtrarMantenimientos(lista, contexto) {
    const q = (window.busquedaMantenimientos[contexto] || '').toLowerCase().trim();
    if (!q) return lista;
    return lista.filter(m => {
        const campos = [m.NumeroM, m.MarcaM, m.ModeloM, m.SerieM, m.Centrot, m.Tipo_Mantenimiento, m.Fecha_Realizado];
        return campos.some(c => String(c ?? '').toLowerCase().includes(q));
    });
}
 
function generarPaginacionMantenimientos(totalRegistros, contexto) {
    const entradas = window.entradasPorPaginaMant[contexto] || 10;
    const totalPaginas = Math.ceil(totalRegistros / entradas);
    const paginaActual = window.paginasMantenimientos[contexto] || 1;
 
    const inicio = totalRegistros === 0 ? 0 : (paginaActual - 1) * entradas + 1;
    const fin = Math.min(paginaActual * entradas, totalRegistros);
    const infoTexto = totalRegistros === 0
        ? 'No hay datos para mostrar'
        : `Mostrando ${inicio} a ${fin} de ${totalRegistros} registros`;
 
    const puedeAnterior = paginaActual > 1;
    const puedeSiguiente = paginaActual < totalPaginas;
 
    return `
    <div class="d-flex justify-content-between align-items-center px-1 pt-3 flex-wrap gap-2" style="font-size:.82rem;">
        <span class="text-muted">${infoTexto}</span>
        <div class="d-flex gap-3">
            <a href="#" class="text-decoration-none ${puedeAnterior ? '' : 'text-muted pe-none'}"
               onclick="event.preventDefault(); ${puedeAnterior ? `cambiarPaginaMantenimientos('${contexto}', ${paginaActual - 1})` : ''}">
                Anterior
            </a>
            <a href="#" class="text-decoration-none ${puedeSiguiente ? '' : 'text-muted pe-none'}"
               onclick="event.preventDefault(); ${puedeSiguiente ? `cambiarPaginaMantenimientos('${contexto}', ${paginaActual + 1})` : ''}">
                Siguiente
            </a>
        </div>
    </div>`;
}
 
function tablaMantenimientoHTML(listaCompleta, contexto) {
    const entradas = window.entradasPorPaginaMant[contexto] || 10;
    const busqueda = window.busquedaMantenimientos[contexto] || '';
 
    const listaFiltrada = filtrarMantenimientos(listaCompleta, contexto);
 
    const paginaActual = window.paginasMantenimientos[contexto] || 1;
    const inicio = (paginaActual - 1) * entradas;
    const listaPagina = listaFiltrada.slice(inicio, inicio + entradas);
 
    const filas = listaPagina.length
        ? listaPagina.map(m => filaMantenimientoHTML(m, contexto)).join('')
        : `<tr><td colspan="10" class="text-center text-muted py-4" style="font-size:.82rem;">No hay datos disponibles en la tabla</td></tr>`;
 
    return `
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-2 px-1" style="font-size:.85rem;">
            <div class="d-flex align-items-center gap-2">
                Mostrar
                <select class="form-select form-select-sm d-inline-block w-auto"
                        onchange="cambiarEntradasMantenimientos('${contexto}', this.value)">
                    ${[10, 25, 50, 100].map(n =>
                        `<option value="${n}" ${n === entradas ? 'selected' : ''}>${n}</option>`
                    ).join('')}
                </select>
                entradas
            </div>
            <div class="d-flex align-items-center gap-2">
                Buscar:
                <input type="text" id="buscador_${contexto}" class="form-control form-control-sm" style="width:200px;"
                       value="${busqueda.replace(/"/g, '&quot;')}"
                       oninput="buscarMantenimientos('${contexto}', this.value)">
            </div>
        </div>
 
        <div class="table-responsive">
            <table class="table text-start align-middle table-bordered table-hover mb-0">
                <thead>
                    <tr>
                        <th class="text-center" style="width:40px;">N°</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Serie</th>
                        <th>Fecha Realizado</th>
                        <th>Tipo Mantenimiento</th>
                        <th>Centro de Trabajo</th><th>Horometro</th>
                        <th class="text-center">Estado</th>
                        <th class="text-center" style="width:90px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>${filas}</tbody>
            </table>
        </div>
 
        ${generarPaginacionMantenimientos(listaFiltrada.length, contexto)}
    `;
}
 
function renderTablasMantenimientos() {
    const contenedor = document.getElementById('contenedorMantenimientos');
    if (!contenedor) return;
 
    const agrupados = agruparMantenimientos(window.MANTENIMIENTOS_DATA);
    const t = clasificarMantenimientos(agrupados);
 
    const tabs = [
        { id: 'tabFaltaSupervisor', label: 'Por Verificar',        badgeClass: 'bg-warning text-dark', lista: t.faltaSupervisor, contexto: 'supervisor' },
        { id: 'tabFaltaOperario',   label: 'Falta Firma Operario', badgeClass: 'bg-warning text-dark', lista: t.faltaOperario,   contexto: 'operario' },
        { id: 'tabFaltaMecanico',   label: 'Falta Firma Mecánico', badgeClass: 'bg-warning text-dark', lista: t.faltaMecanico,   contexto: 'mecanico' },
        { id: 'tabCompletos',       label: 'Completos',            badgeClass: 'bg-success',           lista: t.completos,       contexto: 'completos' },
    ].filter(tab => tab.lista.length > 0);
 
    if (tabs.length === 0) {
        contenedor.innerHTML = `<div class="text-center text-muted py-5" style="font-size:.85rem;">No hay mantenimientos preventivos registrados.</div>`;
        return;
    }
 
    // Mantener la pestaña activa entre renders (por ejemplo, mientras se escribe en el buscador)
    let indiceActivo = tabs.findIndex(tab => tab.id === window.pestanaActivaMantenimientos);
    if (indiceActivo === -1) indiceActivo = 0;
    window.pestanaActivaMantenimientos = tabs[indiceActivo].id;
 
    const navHTML = tabs.map((tab, i) => `
        <li class="nav-item" role="presentation">
            <button class="nav-link${i === indiceActivo ? ' active' : ''}"
                    data-bs-toggle="tab" data-bs-target="#${tab.id}" type="button"
                    onclick="window.pestanaActivaMantenimientos = '${tab.id}'">
                ${tab.label} <span class="badge ${tab.badgeClass} ms-1">${tab.lista.length}</span>
            </button>
        </li>`).join('');
 
    const panesHTML = tabs.map((tab, i) => `
        <div class="tab-pane fade${i === indiceActivo ? ' show active' : ''}" id="${tab.id}" role="tabpanel">
            ${tablaMantenimientoHTML(tab.lista, tab.contexto)}
        </div>`).join('');
 
    contenedor.innerHTML = `
        <ul class="nav nav-tabs px-1 pt-2" id="tabsMantenimientos" role="tablist">${navHTML}</ul>
        <div class="tab-content p-0 pt-3">${panesHTML}</div>`;
}

/* ═══ MODAL 3 — ABRIR SECCIÓN ════ */
function abrirSeccion(slug) {
    const data = window._seccionesData[slug];
    if (!data) return;
    _slugSeccionActual = slug;

    const totalSel = data.criterios.filter(c => !esCampoTexto(c.hidden)).length;
    document.getElementById('tituloModalSeccion').textContent    = data.nombre;
    document.getElementById('subtituloModalSeccion').textContent = `${totalSel} criterios`;

    /* Ocultar Modal 2 */
    const modal2El = document.getElementById('agregarMantenimiento');
    const modal2   = bootstrap.Modal.getInstance(modal2El);
    if (modal2) modal2.hide();

    /* Construir body del Modal 3 */
    const imgSlug = 'modal3_' + slug;
    document.getElementById('bodyModalSeccion').innerHTML = `
        <div class="criterios-lista mb-3">
            ${data.criterios.map((c, i) => renderCriterio(c, i)).join('')}
        </div>
        <div class="img-uploader" id="uploader_${imgSlug}">
            <div class="img-uploader-header">
                <span style="font-size:.72rem;font-weight:700;color:#6c757d;text-transform:uppercase;letter-spacing:.4px;">
                    📷 Imágenes de evidencia
                    <span class="badge bg-secondary ms-1" id="imgCount_${imgSlug}">0</span>
                </span>
                <label for="imgInput_${imgSlug}" class="btn btn-sm"
                    style="border:1.5px dashed var(--color-orange);color:var(--color-orange);
                           border-radius:8px;font-size:.72rem;background:transparent;
                           cursor:pointer;padding:3px 10px;">
                    + Agregar foto
                </label>
                <input type="file" id="imgInput_${imgSlug}" accept="image/*" multiple
                    class="d-none img-file-input" data-slug="${imgSlug}"
                    onchange="previewImagenes(this)">
            </div>
            <div class="img-preview-wrap d-flex flex-wrap gap-2 mt-2" id="imgPreview_${imgSlug}"></div>
        </div>`;

    /* Restaurar respuestas */
    const resp = window._respuestasSeccion[slug] || {};
    data.criterios.forEach(c => {
        const el = document.getElementById(`inp_${c.id}`);
        if (!el) return;
        const val = resp[c.name] || '';
        el.value = val;
        if (el.tagName === 'SELECT') {
            el.dataset.val = val;
            toggleObservacion(el);
            const obsEl = document.querySelector(`#obs_${c.id} textarea`);
            if (obsEl && resp['obs_' + c.name]) obsEl.value = resp['obs_' + c.name];
        }
    });

    /* Restaurar imágenes */
    const imgs = window._imagenesSeccion[slug] || [];
    const prevEl = document.getElementById(`imgPreview_${imgSlug}`);
    const countEl = document.getElementById(`imgCount_${imgSlug}`);
    imgs.forEach(img => {
        prevEl.appendChild(
            crearThumb(
                img.src,
                imgSlug,
                img.id
            )
        );
    });

    countEl.textContent = imgs.length;

    actualizarProgresoSeccion();
    new bootstrap.Modal(document.getElementById('modalSeccionCriterios')).show();
}

function actualizarProgresoSeccion() {
    const slug = _slugSeccionActual;
    if (!slug) return;
    const data  = window._seccionesData[slug];
    const total = data ? data.criterios.filter(c => !esCampoTexto(c.hidden)).length : 0;
    const completados = [...document.querySelectorAll('#bodyModalSeccion .criterio-select')]
        .filter(s => s.value !== '').length;
    const el = document.getElementById('progresoSeccion');
    if (el) el.textContent = `${completados} de ${total} completados`;
}

/* ════ IMÁGENES — THUMB Y PREVIEW ════ */
function crearThumb(src, slug, id = null) {

    const thumb = document.createElement('div');
    thumb.className = 'img-thumb position-relative';

    thumb.dataset.id = id || '';
    thumb.style.cssText ='width:64px;height:64px;border-radius:8px;overflow:hidden;' + 'border:1px solid #e8e8f0;flex-shrink:0;';
    thumb.innerHTML = `
        <img src="${src}"
             alt="img"
             style="width:100%;height:100%;object-fit:cover;"
             onclick="abrirLightbox('${src}')">

        <button
            type="button"
            onclick="eliminarThumb(this,'${slug}')"
            style="position:absolute;top:2px;right:2px;
                   background:rgba(0,0,0,.55);border:none;
                   border-radius:50%;width:18px;height:18px;
                   color:#fff;font-size:10px;line-height:1;
                   cursor:pointer;display:flex;
                   align-items:center;justify-content:center;">
            ✕
        </button>
    `;

    return thumb;
}

async function previewImagenes(input) {

    const slug = input.dataset.slug;

    const prevEl = document.getElementById(`imgPreview_${slug}`);
    const countEl = document.getElementById(`imgCount_${slug}`);

    if (!prevEl || !countEl) {
        console.warn('No se encontró el contenedor de imágenes:', slug);
        return;
    }

    // Obtener slug real
    const slugSeccion = slug.replace('modal3_', '');

    // Obtener datos de la sección
    const dataSeccion = window._seccionesData[slugSeccion];

    if (!dataSeccion) {
        console.warn('No se encontró la sección:', slugSeccion);    
        return;
    }

    const categoria = dataSeccion.nombre;

    // Procesar cada imagen
    for (const file of Array.from(input.files)) {

        if (!file.type.startsWith('image/')) {
            continue;
        }

        // 1. MOSTRAR PREVIEW INMEDIATAMENTE
        const previewSrc = await new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.onload = e => resolve(e.target.result);
            reader.onerror = reject;
            reader.readAsDataURL(file);
        });

        // Crear thumbnail SIN ID inicialmente
        const thumb = crearThumb(previewSrc, slug);
        prevEl.appendChild(thumb);
        countEl.textContent = prevEl.querySelectorAll('.img-thumb').length;

        // 2. GUARDAR EN BD

        const resultado = await subirImagen(file, categoria);

        if (!resultado) {
            console.error( 'No se pudo guardar la imagen:', file.name);
            thumb.remove();
            countEl.textContent = prevEl.querySelectorAll('.img-thumb').length;
            continue;
        }

        // 3. ASIGNAR ID DE BD AL THUMB

        thumb.dataset.id = resultado.id;

        // 4. GUARDAR ESTADO LOCAL

        window._imagenesSeccion[slugSeccion] = window._imagenesSeccion[slugSeccion] || [];
        window._imagenesSeccion[slugSeccion].push({
            id: resultado.id,
            // preview local para mostrar
            src: previewSrc,
            // ruta física/URL guardada en servidor
            ruta: resultado.ruta,
            categoria: categoria,
            enBD: true

        });
    }
    input.value = '';
}

async function subirImagen(file, categoria) {

    const formData = new FormData();

    formData.append('ID_Mantenimiento', window.ID_Mantenimiento);
    formData.append('Categoria', categoria);
    formData.append('imagen', file);

    try {
        const response = await fetch(
            `${window.baseUrl}Mantenimiento/GuardarImagen`,
            {
                method: 'POST',
                body: formData
            }
        );

        const data = await response.json();
        if (!data.success) {
            console.error('Error al subir imagen:', data.message);
            return null;
        }

        return {
            id: data.id,
            ruta: data.ruta
        };

    } catch (error) {
        console.error('Error subiendo imagen:', error);
        return null;
    }
}

async function eliminarThumb(btn, slug) {

    const thumb = btn.closest('.img-thumb');
    if (!thumb) {
        return;
    }

    const id = thumb.dataset.id;

    // Si no tiene ID, solo quitar visualmente
    if (!id) {
        thumb.remove();
        actualizarContadorImagenes(slug);
        return;
    }

    try {

        const response = await fetch(
            `${window.baseUrl}Mantenimiento/EliminarImagen`,
            {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    ID: id
                })
            }
        );

        const data = await response.json();

        if (!data.success) {
            console.error('Error eliminando imagen:',data.message);
            return;
        }

        // Eliminar visualmente
        thumb.remove();

        // Actualizar estado local
        const slugReal = slug.replace('modal3_', '');

        window._imagenesSeccion[slugReal] = (window._imagenesSeccion[slugReal] || []) .filter(img => String(img.id) !== String(id));
        actualizarContadorImagenes(slug);
    } catch (error) {
        console.error('Error de conexión eliminando imagen:',error);
    }
}

function actualizarContadorImagenes(slug) {

    const countEl = document.getElementById(`imgCount_${slug}`);
    const prevEl = document.getElementById(`imgPreview_${slug}`);
    if (!countEl || !prevEl) {
        return;
    }
    countEl.textContent = prevEl.querySelectorAll('.img-thumb').length;
}

/* ════ LIGHTBOX ════ */
function abrirLightbox(src) {
    document.getElementById('lightboxImg').src = src;
    document.getElementById('lightboxOverlay').style.display = 'flex';
    document.addEventListener('keydown', _lightboxEsc);
}
function cerrarLightbox() {
    document.getElementById('lightboxOverlay').style.display = 'none';
    document.getElementById('lightboxImg').src = '';
    document.removeEventListener('keydown', _lightboxEsc);
}
function _lightboxEsc(e) { if (e.key === 'Escape') cerrarLightbox(); }

/* ════ COLOREAR SELECT (global) ════ */
document.addEventListener('change', function(e) {
    
    if (!e.target.classList.contains('criterio-select')) {
        return;
    }

    const elemento = e.target;

    // Mantener valor actual
    elemento.dataset.val = elemento.value;

    // Actualizar memoria local
    const slug = _slugSeccionActual;

    if (slug) {

        window._respuestasSeccion[slug] =
            window._respuestasSeccion[slug] || {};

        window._respuestasSeccion[slug][elemento.name] =
            elemento.value;

        actualizarTarjeta(slug);
    }

    // AUTOGUARDAR EN BASE DE DATOS
    autoguardarCriterio(elemento);
});

// Cambios Realizados para el autoguardado de los criterios
document.addEventListener('input', function(e) {
    if (!e.target.matches('.criterio-texto input')) {
        return;
    }

    const elemento = e.target;
    const slug = _slugSeccionActual;

    if (slug) {
        window._respuestasSeccion[slug] = window._respuestasSeccion[slug] || {};
        window._respuestasSeccion[slug][elemento.name] = elemento.value;
        actualizarTarjeta(slug);
    }

    // Evitar guardar en cada tecla
    clearTimeout(elemento._autoSaveTimer);
    elemento._autoSaveTimer = setTimeout(function() {autoguardarCriterio(elemento);}, 1000);
});

document.addEventListener('input', function(e){
    // Cambios Para las observaciones
    if (!e.target.classList.contains('obs-textarea')) {
        return;
    }

    const textarea = e.target;

    //Buscar el campo de select asociado a esta observacion
    const criterioRow = textarea.closest('.criterio-row');
    if (!criterioRow){
        return;
    }

    // Buscar el select asociado
    const select = criterioRow.querySelector('.criterio-select');
    if(!select){
        return;
    }

    // Obtener criterio asociado al select
    const criterio = select.dataset.hidden;
    if(!criterio){
        console.warn('No se encontró el campo del criterio.');
        return;
    }

    //Guardar tambien la observacion en la memoria local
    const slug = _slugSeccionActual;
    if (slug) {
        window._respuestasSeccion[slug] = window._respuestasSeccion[slug] || {};
        window._respuestasSeccion[slug]['obs_' + select.name] = textarea.value;
    }

    // Evitar guardar en cada tecla
    clearTimeout(textarea._autoSaveTimer);
    textarea._autoSaveTimer = setTimeout(function() {
        autoguardarObservacion(
            criterio,
            textarea.value
        ); }, 1000);
});

/* ════ DOMContentLoaded ════ */
document.addEventListener('DOMContentLoaded', function () {

    /* ── INDICADOR CONEXIÓN ── */
    const indicador     = document.getElementById('conexionIndicador');
    const textoConexion = document.getElementById('conexionTexto');
    let timerConexion;

    function actualizarConexion() {

        clearTimeout(timerConexion);
        if (navigator.onLine) {
            indicador.className = 'online';
            textoConexion.textContent = 'En línea';
            indicador.style.display = 'flex';
            timerConexion = setTimeout(() => { indicador.style.display = 'none'; }, 3000);
        } else {
            indicador.className = 'offline';
            textoConexion.textContent = 'Sin conexión — guardando localmente';
            indicador.style.display = 'flex';
        }
    }
    window.addEventListener('online',  actualizarConexion);
    window.addEventListener('offline', actualizarConexion);
    actualizarConexion();

    renderTablasMantenimientos(); 

    /* ── TOGGLE PANEL INFO (mobile) ── */
    const toggleBtn = document.getElementById('toggleInfoEquipo');
    const panelBody = document.getElementById('panelInfoBody');

    function initPanelHeight() {
        panelBody.style.maxHeight = window.innerWidth < 768
            ? panelBody.scrollHeight + 'px' : 'none';
    }
    initPanelHeight();
    window.addEventListener('resize', initPanelHeight);

    toggleBtn.addEventListener('click', function () {
        const collapsed = panelBody.classList.toggle('collapsed');
        toggleBtn.classList.toggle('collapsed', collapsed);
        panelBody.style.maxHeight = collapsed ? '0' : panelBody.scrollHeight + 'px';
        toggleBtn.querySelector('span:first-child').textContent = collapsed ? '📋 Ver información del equipo' : '📋 Ocultar información del equipo';
    });

    /* ── SWITCH OPERARIO ── */
    const switchOperario = document.getElementById('tipoOperarioSwitch');
    const selectOperario = document.getElementById('ID_Operario');
    const inputExterno   = document.getElementById('OperarioExterno');
    const labelInterno   = document.getElementById('labelInterno');
    const labelExterno   = document.getElementById('labelExterno');

    const switchOperario1 = document.getElementById('tipoOperarioSwitch1');
    const selectOperario1 = document.getElementById('ID_Operario1');
    const inputExterno1   = document.getElementById('OperarioExterno1');
    const labelInterno1   = document.getElementById('labelInterno1');
    const labelExterno1   = document.getElementById('labelExterno1');

    function cambiarTipoOperario() {
        const esExterno = switchOperario.checked;
        labelInterno.className = esExterno ? 'label-inactive' : 'label-active';
        labelExterno.className = esExterno ? 'label-active'   : 'label-inactive';
        selectOperario.classList.toggle('d-none', esExterno);
        inputExterno.classList.toggle('d-none', !esExterno);
        selectOperario.required = !esExterno;
        inputExterno.required   = esExterno;
        if (!esExterno) inputExterno.value = '';
    }
    switchOperario.addEventListener('change', cambiarTipoOperario);
    cambiarTipoOperario();

    function cambiarTipoOperario1() {
        const esExterno1 = switchOperario1.checked;
        labelInterno1.className = esExterno1 ? 'label-inactive' : 'label-active';
        labelExterno1.className = esExterno1 ? 'label-active'   : 'label-inactive';
        selectOperario1.classList.toggle('d-none', esExterno1);
        inputExterno1.classList.toggle('d-none', !esExterno1);
        selectOperario1.required = !esExterno1;
        inputExterno1.required   = esExterno1;
        if (!esExterno1) inputExterno1.value = '';
    }
    switchOperario1.addEventListener('change', cambiarTipoOperario1);
    cambiarTipoOperario1();

    document.getElementById('btnGuardarBorrador')?.addEventListener('click', function () {
        bootstrap.Modal.getInstance(document.getElementById('agregarMantenimiento'))?.hide();
    });

    /* ── Botón "Finalizar ✓": valida que todo esté completo y envía los datos de cierre  */
    document.getElementById('btnFinalizarMantenimiento')?.addEventListener('click', function () {
        const totalCriterios = window._totalCriterios || 0;
        let completadosCriterios = 0;
        const seccionesIncompletas = [];
        Object.entries(window._seccionesData || {}).forEach(([slug, seccion]) => {
            const total = seccion.criterios.filter(c => !esCampoTexto(c.hidden)).length;
            const completados = contarCompletadosSeccion(slug);
            completadosCriterios += completados;
            if (completados < total) seccionesIncompletas.push(seccion.nombre);
        });
        if (totalCriterios > 0 && completadosCriterios < totalCriterios) {
            return alert('Faltan criterios por completar en: ' + seccionesIncompletas.join(', '));
        }

        // 2. Campos de cierre del panel izquierdo
        const horaInicio  = document.getElementById('HoraInicio')?.value;
        const horaFinal   = document.getElementById('HoraFinal')?.value;
        const horometro   = document.getElementById('Horometro')?.value;
        const autorizaVal = document.getElementById('Autoriza')?.value;

        if (!horaInicio)  return alert('Ingrese la hora de inicio');
        if (!horaFinal)   return alert('Ingrese la hora final');
        if (!horometro)   return alert('Ingrese el horómetro');
        if (!autorizaVal) return alert('Seleccione quién autoriza (supervisor)');

        const esExternoRecibe = switchOperario1.checked;
        let ID_Recibe = null;
        let Nombre_Recibe = null;

        if (esExternoRecibe) {
            Nombre_Recibe = inputExterno1.value.trim();
            if (!Nombre_Recibe) return alert('Ingrese el nombre completo de quien recibe');
        } else {
            ID_Recibe = selectOperario1.value;
            if (!ID_Recibe) return alert('Seleccione quién recibe el mantenimiento');
        }

        const ID_Supervisor = autorizaVal.split('|')[0];

        const btn = this;
        btn.disabled  = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Finalizando...';

        fetch(`${window.baseUrl}Mantenimiento/FinalizarMantenimiento`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                ID_Mantenimiento: window.ID_Mantenimiento,
                ID_Montacargas: window.ID_Montacargas,
                ID_Supervisor: ID_Supervisor,
                HoraInicio: horaInicio,
                HoraFinal: horaFinal,
                Horometro: horometro,
                Externo_Recibe: esExternoRecibe ? 1 : 0,
                ID_Recibe: ID_Recibe,
                Nombre_Recibe: Nombre_Recibe
            })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {

                // Cerrar modal actual
                bootstrap.Modal.getInstance(
                    document.getElementById('agregarMantenimiento')
                )?.hide();

                // Generar las firmas de los técnicos
                cargarFirmasMecanicos();

                // Abrir modal de firmas
                const modalFirmas = new bootstrap.Modal(
                    document.getElementById('modalFirmasMantenimiento')
                );

                modalFirmas.show();

            }
        })
        .catch(() => alert('Error de conexión al finalizar el mantenimiento'))
        .finally(() => {
            btn.disabled  = false;
            btn.innerHTML = 'Finalizar ✓';
        });
    });

    /* ── CARGA DINÁMICA ── */
    window.cargarMontacargas = function () {
        const ID_Centro = document.getElementById('ID_Centro1').value
        if (!ID_Centro) return;

        $.get(`TraerMontacargas?ID_Centro=${ID_Centro}`, function(data) {
            try {
                const lista = Array.isArray(data) ? data : JSON.parse(data);
                const sel = $('#ID_Montacargas').empty()
                    .append('<option value="" disabled selected>Seleccione montacargas</option>');
                lista.forEach(m => sel.append(
                    `<option value="${m.ID}" data-modelo="${m.Modelo}" data-voltaje="${m.Voltaje}"
                     data-horometro="${m.Horometro}" data-longitudh="${m.Horquillas}">
                     ${m.Numero} — ${m.Serie}</option>`
                ));
            } catch(e) { console.error('Montacargas:', e); }
        });

        $.get(`TraerOperarios?ID_Centro=${ID_Centro}`, function(data) {
            try {
                const lista = Array.isArray(data) ? data : JSON.parse(data);
                const sel = $('#ID_Operario').empty()
                    .append('<option value="" disabled selected>Seleccione operario</option>');
                lista.forEach(o => sel.append(`<option value="${o.ID}">${o.NombreCompleto}</option>`));
            } catch(e) { console.error('Operarios:', e); }
        });

        $.get(`TraerOperarios?ID_Centro=${ID_Centro}`, function(data) {
            try {
                const lista = Array.isArray(data) ? data : JSON.parse(data);
                const sel = $('#ID_Operario1').empty()
                    .append('<option value="" disabled selected>Seleccione operario</option>');
                lista.forEach(o => sel.append(`<option value="${o.ID}">${o.NombreCompleto}</option>`));
            } catch(e) { console.error('Operarios:', e); }
        });

        $.get(`TraerAreas?ID_Centro=${ID_Centro}`, function(data) {
            try {
                const lista = Array.isArray(data) ? data : JSON.parse(data);
                const sel = $('#ID_Area').empty()
                    .append('<option value="" disabled selected>Seleccione área</option>');
                lista.forEach(a => sel.append(`<option value="${a.ID}">${a.Nombre}</option>`));
            } catch(e) { console.error('Áreas:', e); }
        });
    };

    /* ── SUBMIT MODAL 1 → abre Modal 2 ── */
    document.getElementById('documentFormIngreso').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const btn      = document.getElementById('btnEnviarForm');

        formData.set(switchOperario.checked ? 'ID_Operario' : 'OperarioExterno', '');
        btn.disabled  = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Guardando...';

        fetch('CrearMantenimiento', { method: 'POST', body: formData })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    window.ID_Mantenimiento = data.ID_Mantenimiento;  
                    window.ID_Detalle = data.ID_Detalle;
                    window.ID_Montacargas = data.ID_Montacargas;
                    window.ID_Centro = data.ID_Centro;
                    // cambios mirar si funciona si no funciona colocar window.Tipo_Montacargas = tipoMont;
                    window.Tipo_Montacargas = document.getElementById('tipoMontacargas')?.value || '';
                    if (data.Detalles){
                        // Llenar campos del lado izquierdo
                        document.getElementById('numeroMontacargas').value = data.Detalles.NumeroM || '';
                        document.getElementById('nombreSeccion').value = data.Detalles.NombreArea || '';
                        document.getElementById('numeroSerie').value = data.Detalles.SerieM || '';
                        document.getElementById('numeroModelo').value = data.Detalles.ModeloM || '';
                        document.getElementById('nombreCentro').value = data.Detalles.NombreCentro || '';
                        document.getElementById('Voltaje').value = data.Detalles.VoltajeM || '';
                        document.getElementById('nombreOperario').value = data.Detalles.NombreOperario || '';
                        
                        if (data.Detalles.ID_Tecnicos && data.Detalles.NombreTecnicos){
                            const ids = data.Detalles.ID_Tecnicos.split(',');
                            const nombres = data.Detalles.NombreTecnicos.split(',');
                            ids.forEach((id, index) => {
                                window._tecnicos.push({
                                    id: parseInt(id),
                                    nombre: (nombres[index] || '').trim(),
                                    esPrincipal: false,
                                    enBD: true
                                });
                            });
                        }

                        // Renderizar tecnicos adicionales
                        renderPanelTecnicos();
                    }        

                    function getDetalle(detObj, keys){
                        for (const k of keys){
                            if (detObj && detObj[k] !== undefined && detObj[k] !==null && detObj[k] !== '') return detObj[k];
                        }
                        return '';
                    }

                    const prefMap = {
                        'pasillo' : 'pasillo_',
                        'contrabalanceada' : 'contra_',
                        'manlift' : 'manlift_',
                        'combustion' : 'comb_',
                    };

                    function prefilCriteriosFromDetalles(Detalles, tipoMont){
                        const pref = prefMap[tipoMont || 'pasillo_'];
                        // Desavilictado por el momento, ya que no se esta usando en ningun lado 
                        // Esto es para cargar los valores de la bateria y longitud de horquillas en el modal 3, pero no se esta usando actualmente
                        // No se guardando en la base de datos, solo se esta usando para mostrar en el modal 3
                        // const bateriaVal = getDetalle(Detalles, ['NumeroB', 'Numero_Interno', 'N_Bateria', `${pref}N_Bateria`]);
                        // const longitudVal = getDetalle(Detalles, ['LongitudH', 'Longitud_H', 'Longitud', `${pref}LongitudH`]);
                        window._respuestasSeccion = window._respuestasSeccion || {};
                        // window._respuestasSeccion['bateria'] = window._respuestasSeccion['bateria'] || {};
                        // window._respuestasSeccion['horquillas'] = window._respuestasSeccion['horquillas'] || {};
                        

                        // window._respuestasSeccion['bateria'][`${pref}N_Bateria`] = bateriaVal;
                        // window._respuestasSeccion['horquillas'][`${pref}LongitudH`] = longitudVal;
                    }
                    const modalEl1 = document.getElementById('NumerDocumentoModal');
                    bootstrap.Modal.getInstance(modalEl1).hide();

                    modalEl1.addEventListener('hidden.bs.modal', function handler() {
                        this.removeEventListener('hidden.bs.modal', handler);

                        const selTipo  = document.getElementById('tipoMantenimiento');
                        const selClase = document.getElementById('tipoMontacargas');
                        document.getElementById('subtituloModal').textContent =
                            `${selTipo.options[selTipo.selectedIndex]?.text || ''} · ${selClase.options[selClase.selectedIndex]?.text || ''}`;

                        const tipoMant = selTipo.value;
                        const tipoMont = selClase.value;

                        function intentarCargar() {
                            if (window.CRITERIOS_DATA !== undefined) {
                                cargarCriterios(tipoMant, tipoMont);
                                prefilCriteriosFromDetalles(data.Detalles, tipoMont);
                            } else {
                                const iv = setInterval(() => {
                                    if (window.CRITERIOS_DATA !== undefined) {
                                        clearInterval(iv);
                                        cargarCriterios(tipoMant, tipoMont);
                                        prefilCriteriosFromDetalles(data.Detalles, tipoMont);
                                    }
                                }, 100);
                            }
                        }
                        intentarCargar();
                        new bootstrap.Modal(document.getElementById('agregarMantenimiento')).show();
                    });
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(() => alert('Error de conexión. Intente nuevamente.'))
            .finally(() => {
                btn.disabled  = false;
                btn.innerHTML = 'Continuar →';
            });
    });

    /* ── GUARDAR SECCIÓN (Modal 3) ── */
    document.getElementById('btnGuardarSeccion').addEventListener('click', function () {
        const slug = _slugSeccionActual;
        if (!slug) return;
        const data = window._seccionesData[slug];
        if (!data) return;

        const resp = {};
        data.criterios.forEach(c => {
            const el = document.getElementById(`inp_${c.id}`);
            if (!el) return;
            resp[c.name] = el.value;
            if (el.tagName === 'SELECT') {
                const obsEl = document.querySelector(`#obs_${c.id} textarea`);
                if (obsEl) resp['obs_' + c.name] = obsEl.value;
            }
        });
        window._respuestasSeccion[slug] = resp;

        const imgSlug = 'modal3_' + slug;
        const prevEl  = document.getElementById(`imgPreview_${imgSlug}`);
        if (prevEl) {
            window._imagenesSeccion[slug] = [...prevEl.querySelectorAll('.img-thumb img')]
                .map(img => ({ src: img.src }));
        }

        bootstrap.Modal.getInstance(document.getElementById('modalSeccionCriterios')).hide();
        actualizarTarjeta(slug);
    });

    /* ── PROGRESO MODAL 3 al cambiar selects ── */
    document.getElementById('modalSeccionCriterios').addEventListener('change', function(e) {
        if (e.target.classList.contains('criterio-select')) actualizarProgresoSeccion();
    });

    /* ── Al cerrar Modal 3 → volver a Modal 2 ── */
    document.getElementById('modalSeccionCriterios').addEventListener('hidden.bs.modal', function () {
        const modal2El = document.getElementById('agregarMantenimiento');
        if (!modal2El.classList.contains('show')) {
            new bootstrap.Modal(modal2El).show();
        }
    });

    /*Cargar Operarios quien recibe*/
    window.TraerOperioRecibe = function () {
        const ID_Centro1 = window.ID_Centro;
        if (!ID_Centro1) return;
        $.get(`TraerOperarios?ID_Centro=${ID_Centro1}`, function(data) {
            try {
                const lista = Array.isArray(data) ? data : JSON.parse(data);
                const sel = $('#ID_Operario1').empty()
                    .append('<option value="" disabled selected>Seleccione operario</option>');
                lista.forEach(o => sel.append(`<option value="${o.ID}">${o.NombreCompleto}</option>`));
            } catch(e) { console.error('Operarios:', e); }
        });
    }

    /* ── VERIFICAR BORRADOR ──
       Se llama al cargar la página (autoArranque=true) y también al hacer
       clic en btnPreventivo (autoArranque=false). Si existe un borrador,
       se muestra el modal #modalBorradorPreventivo (ya definido en el HTML)
       para que el usuario decida si continúa o inicia uno nuevo.
       Si NO existe borrador y venimos del auto-arranque (carga de página),
       no hacemos nada — no tiene sentido abrir "Nuevo Mantenimiento" solo.
    */
    function verificarBorrador(autoArranque) {
        fetch('VerificarBorrador')
            .then(res => res.json())
            .then(data => {
                if (data.existe) {
                    window._borradorPendienteID = data.ID_Mantenimiento;
                    new bootstrap.Modal(document.getElementById('modalBorradorPreventivo')).show();
                } else if (!autoArranque) {
                    new bootstrap.Modal(document.getElementById('NumerDocumentoModal')).show();
                }
            })
            .catch(() => { if (!autoArranque) new bootstrap.Modal(document.getElementById('NumerDocumentoModal')).show(); });
    }

    document.getElementById('btnPreventivo').addEventListener('click', function () {
        verificarBorrador(false);
    });

    // Al recargar la página: si hay un mantenimiento en estado BORRADOR, avisar automáticamente
    verificarBorrador(true);

    /* ── Botones del modal de borrador ── */
    document.getElementById('btnContinuarBorrador')?.addEventListener('click', function () {
        const id = window._borradorPendienteID;
        bootstrap.Modal.getInstance(document.getElementById('modalBorradorPreventivo'))?.hide();
        if (!id) return;

        fetch(`ObtenerDetalles?ID_Mantenimiento=${id}`)
            .then(res => res.json())
            .then(detalle => {
                if (detalle.success) {
                    LlenarModalMantenimiento(detalle);
                    new bootstrap.Modal(document.getElementById('agregarMantenimiento')).show();
                } else {
                    alert('No se pudieron cargar los detalles. Intente nuevamente.');
                }
            })
            .catch(() => alert('Error de conexión al cargar el borrador.'));
    });

    document.getElementById('btnRechazarBorrador')?.addEventListener('click', function () {
        const id = window._borradorPendienteID;
        bootstrap.Modal
            .getInstance(document.getElementById('modalBorradorPreventivo'))
            ?.hide();
        if (!id) return;

        fetch('EliminarBorrador', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                ID_Mantenimiento: id,
                Tipo_Mantenimiento: window.Mantenimiento
            })
        })
        .then(res => res.json())
        .then(detalle => {
            if (detalle.success) {

                new bootstrap.Modal(
                    document.getElementById('NumerDocumentoModal')
                ).show();

            } else {

                alert(detalle.message || 'No se pudo eliminar el mantenimiento.');

            }

        })
        .catch(error => {

            console.error('Error:', error);

            alert('Error de conexión al eliminar el borrador.');

        });

    });

    /* ── Accesibilidad teclado btnPreventivo ── */
    document.getElementById('btnPreventivo').addEventListener('keydown', function(e) {
        if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); this.click(); }
    });

    /* ═══════════════ NOVEDADES PENDIENTES   ═════════ */   
    let contadorNovedades1 = 0;
    let contadorNovedades2 = 0;
    window.abrirNovedades = function () {
        const m2el = document.getElementById('agregarMantenimiento');
        const m2   = bootstrap.Modal.getInstance(m2el);
        if (m2) m2.hide();

        m2el.addEventListener('hidden.bs.modal', function handler() {
            m2el.removeEventListener('hidden.bs.modal', handler);
            renderTablaNovedades();
            new bootstrap.Modal(document.getElementById('modalNovedades')).show();
        });
    };

    window.agregarNovedad = function () {
        const txt = document.getElementById('textoNovedad').value.trim();
        if (!txt) return;

        window._novedadesTemp.push({
            txt,
            enBD: false
        })

        document.getElementById('textoNovedad').value = '';
        renderTablaNovedades();
        actualizarContadorNovedades();
    };

    //Eliminar novedad (temporal o en BD)
    window.eliminarNovedad = function (index) {

        const novedadesTemp = window._novedadesTemp || [];

        // Buscar la novedad utilizando el índice
        const novedad = novedadesTemp[index];

        if (!novedad) {
            console.warn("No se encontró la novedad en el índice:", index);
            return;
        }

        if (novedad.enBD) {
            fetch(window.baseUrl + 'Mantenimiento/EliminarNovedad', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    ID_Mantenimiento: window.ID_Mantenimiento,
                    ID_Novedad: novedad.id,
                    Tipo_Mantenimiento: window.Mantenimiento
                })
            })
            .then(r => r.json())
            .then(resp => {
                if (resp.success) {
                    window._novedades =
                        (window._novedades || [])
                        .filter(n => n.id != novedad.id);
                    window._novedadesTemp =
                        (window._novedadesTemp || [])
                        .filter(n => n.id != novedad.id);
                    renderTablaNovedades();
                    actualizarContadorNovedades();
                } else {
                    alert(
                        resp.message ||
                        'Error al eliminar la novedad'
                    );
                }

            })
            .catch(err => {

                console.error("ERROR FETCH:", err);
                alert("Error en la petición");

            });

        } 
        else {
            window._novedadesTemp.splice(index, 1);
            renderTablaNovedades();
            actualizarContadorNovedades();
        }
    };

    //Guardar novedades (solo las nuevas)
    window.guardarNovedades = function () {

        const nuevasNovedades = window._novedadesTemp.filter(
            n => n.enBD === false
        );

        // No hay nada nuevo que guardar
        if (nuevasNovedades.length === 0) {
            bootstrap.Modal.getInstance(
                document.getElementById('modalNovedades')
            )?.hide();
            return;
        }

        fetch(`${window.baseUrl}Mantenimiento/GuardarNovedades`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                Novedades: nuevasNovedades,
                ID_Mantenimiento: window.ID_Mantenimiento,
                ID_Montacargas: window.ID_Montacargas,
                Tipo_Mantenimiento: window.Mantenimiento
            })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                const novedadesGuardadas = data.novedades || [];

                // Actualizar las novedades temporales
                nuevasNovedades.forEach((novedadTemp, index) => {
                    const novedadGuardada = novedadesGuardadas[index];
                    if (!novedadGuardada) return;
                    novedadTemp.id = novedadGuardada.id;
                    novedadTemp.enBD = true;
                });

                window._novedades = window._novedadesTemp.map(n => ({...n}));

                actualizarContadorNovedades();
                bootstrap.Modal.getInstance(document.getElementById('modalNovedades'))?.hide();
            } else {
                alert('Error al guardar novedades: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error al guardar novedades:',error);
            alert('Error al guardar novedades');
        });
    };

    function renderTablaNovedades() {
        const tbody = document.getElementById('bodyNovedades');
        const vacia = document.getElementById('filaVaciaNovedades');
        tbody.querySelectorAll('tr.nov-row').forEach(r => r.remove());

        if (window._novedadesTemp.length === 0) {
            vacia.style.display = '';
        } else {
            vacia.style.display = 'none';
            window._novedadesTemp.forEach((item, i) => {
                const tr = document.createElement('tr');
                tr.className = 'nov-row';
                tr.innerHTML = `
                    <td style="font-size:.78rem;color:#6c757d;padding:.5rem .75rem;">${i + 1}</td>
                    <td style="font-size:.83rem;padding:.5rem .75rem;">${item.txt}</td>
                    <td class="text-center" style="padding:.5rem .75rem;">
                        <button type="button" onclick="eliminarNovedad(${i})"
                            style="background:#f8d7da;border:none;border-radius:6px;color:#842029;
                                font-size:.75rem;padding:3px 8px;cursor:pointer;">✕</button>
                    </td>`;
                tbody.appendChild(tr);
            });
        }
    }

    function actualizarContadorNovedades() {
        const contadorNovedades = document.getElementById('contadorNovedades');
        const subNovedades = document.getElementById('subNovedades');

        // Actualiza el span pequeño
        if (contadorNovedades) {
            const contadorNovedades1 = window._novedadesTemp.length;
            const textoN = `${contadorNovedades1} novedad${contadorNovedades1 !== 1 ? 'es' : ''}`;
            contadorNovedades.textContent = textoN;
        }

        // Actualiza el div grande
        if (subNovedades) {
            const contadorNovedades2 = window._novedades.length;
            const textoN1 = `${contadorNovedades2} novedad${contadorNovedades2 !== 1 ? 'es' : ''}`;
            subNovedades.textContent = textoN1;
        }
    }

    /* ── Botones Modal 4: Novedades ── */
    const modalNov = document.getElementById('modalNovedades');
    if (modalNov) {
        document.getElementById('btnGuardarNovedades')
            ?.addEventListener('click', function() {window.guardarNovedades(); });
        document.getElementById('btnVolverNovedades')
            ?.addEventListener('click', () => bootstrap.Modal.getInstance(modalNov)?.hide());
        modalNov.addEventListener('hidden.bs.modal', function () {
            const m2el = document.getElementById('agregarMantenimiento');
            if (!m2el.classList.contains('show')) new bootstrap.Modal(m2el).show();
        });
    }

    /* ═══════ OBSERVACIONES (solo lectura) ════ */
    window.abrirObservaciones = function () {
        const m2el = document.getElementById('agregarMantenimiento');
        const m2   = bootstrap.Modal.getInstance(m2el);
        if (m2) m2.hide();

        m2el.addEventListener('hidden.bs.modal', function handler() {
            m2el.removeEventListener('hidden.bs.modal', handler);
            renderTablaObservaciones();
            new bootstrap.Modal(document.getElementById('modalObservaciones')).show();
        });
    };

    function renderTablaObservaciones() {
        const tbody = document.getElementById('bodyObservaciones');
        const vacia = document.getElementById('filaVaciaObservaciones');
        tbody.querySelectorAll('tr.obs-row').forEach(r => r.remove());

        const COLORES = {
            'R': { bg: '#f8d7da', color: '#842029', label: 'Reparación' },
            'N': { bg: '#fff3cd', color: '#856404', label: 'Nivelación' },
            'A': { bg: '#ffe5b4', color: '#8b4513', label: 'Ajuste' },
            'L': { bg: '#cfe2ff', color: '#084298', label: 'Lubricación' },
        };

        const filas = [];
        Object.entries(window._seccionesData || {}).forEach(([slug, seccion]) => {
            const resp = window._respuestasSeccion[slug] || {};
            seccion.criterios.forEach(c => {
                if (esCampoTexto(c.hidden)) return; // los de texto libre (N_Bateria, etc.) no aplican
                const val = resp[c.name];
                if (!val || val === 'C' || val === 'N/A') return;
                const obs = resp['obs_' + c.name] || '';
                filas.push({ label: c.label, val, obs });
            });
        });

        if (filas.length === 0) {
            vacia.style.display = '';
        } else {
            vacia.style.display = 'none';
            filas.forEach((f, i) => {
                const col = COLORES[f.val] || { bg: '#e9ecef', color: '#495057', label: f.val };
                const tr  = document.createElement('tr');
                tr.className = 'obs-row';
                tr.innerHTML = `
                    <td style="font-size:.78rem;color:#6c757d;padding:.5rem .75rem;">${i + 1}</td>
                    <td style="font-size:.82rem;padding:.5rem .75rem;">${f.label}</td>
                    <td class="text-center" style="padding:.5rem .75rem;">
                        <span style="background:${col.bg};color:${col.color};padding:2px 8px;
                                    border-radius:20px;font-size:.7rem;font-weight:600;">${col.label}</span>
                    </td>
                    <td style="font-size:.82rem;padding:.5rem .75rem;">${f.obs || '<em style="color:#adb5bd">Sin descripción</em>'}</td>`;
                tbody.appendChild(tr);
            });
        }

        const n = filas.length;
        document.getElementById('contadorObservaciones').textContent = `${n} observación${n !== 1 ? 'es' : ''}`;
        const sub = document.getElementById('subObservaciones');
        if (sub) sub.textContent = `${n} observación${n !== 1 ? 'es' : ''} generada${n !== 1 ? 's' : ''}`;
    }

    /* ── Botones Modal 5: Observaciones ── */
    const modalObs = document.getElementById('modalObservaciones');
    if (modalObs) {
        document.getElementById('btnVolverObservaciones')
            ?.addEventListener('click', () => bootstrap.Modal.getInstance(modalObs)?.hide());
        modalObs.addEventListener('hidden.bs.modal', function () {
            const m2el = document.getElementById('agregarMantenimiento');
            if (!m2el.classList.contains('show')) new bootstrap.Modal(m2el).show();
        });
    }

    // /* ═══════════════ INSUMOS MANTENIMIENTO  ═════════ */
    let tomSelectInstance = null;
    let contadorFilas = 0;
    let contadorFilas1 = 0;

    window.abrirInsumos = function () {
        const m2el = document.getElementById('agregarMantenimiento');
        const m2 = bootstrap.Modal.getInstance(m2el);
        if (m2) m2.hide();

        m2el.addEventListener('hidden.bs.modal', function handler() {
            m2el.removeEventListener('hidden.bs.modal', handler);
            
            window._insumosTemp = window.insumos.map(i => ({ ...i, enBD: true}));
            renderTablaInsumos();
            // Inicializar TomSelect solo si no existe
            setTimeout(() => {
                if (!tomSelectInstance) {
                    const selectElement = document.getElementById('select-para');
                    if (selectElement) {
                        tomSelectInstance = new TomSelect(selectElement, {
                            plugins: ['remove_button'],
                            placeholder: 'Escribe nombre o código...',
                            maxItems: 1,
                            valueField: 'id',
                            labelField: 'nombre',
                            searchField: ['nombre', 'codigo'],
                            closeAfterSelect: true,
                            hideSelected: true,
                            create: false,
                            load: function(query, callback) {
                                if (query.length < 2) return callback();
                                const baseUrl = window.baseUrl || '';
                                fetch(`${baseUrl}OrdenesTrabajo/BuscarInsumos?q=${encodeURIComponent(query)}`)
                                    .then(r => r.json())
                                    .then(data => {

                                        // 🔥 1. Obtener IDs ya usados
                                        const usados = new Set([
                                            ...window._insumosTemp.map(i => String(i.id)),
                                            ...window.insumos.map(i => String(i.id))
                                        ]);

                                        // 🔥 2. Filtrar resultados
                                        const filtrados = data.filter(item => !usados.has(String(item.id)));

                                        callback(filtrados);
                                    })
                                    .catch(() => callback());
                            },
                            onItemAdd() {
                                this.setTextboxValue('');
                                this.refreshOptions(false);
                            }
                        });
                    }
                }
            }, 100);
            new bootstrap.Modal(document.getElementById('modalInsumos')).show();
        });
    };

    function renderTablaInsumos() {
        const tbody = document.querySelector('#tablaSolicitud tbody');
        if (!tbody) return;
        tbody.innerHTML = '';

        window._insumosTemp.forEach((insumo, index) => {
            const tr = document.createElement('tr');

            tr.innerHTML = `
                <td>${index+1}</td>
                <td>${insumo.codigo}</td>
                <td>${insumo.cantidad}</td>
                <td>${insumo.medida}</td>
                <td>${insumo.nombre}</td>
                <td>
                    <button type="button" onclick="eliminarInsumo(${insumo.id})"class="btn btn-danger btn-sm">X</button>
                </td>
            `;
            tbody.appendChild(tr);

        });
    }

    window.agregarFila = function() {
        
        const cantidad = document.getElementById('cantidad').value;
        const medida = document.getElementById('tipoMedida').value;
        const selectElement = document.getElementById('select-para');        
        // Obtener valor y datos de TomSelect
        let idInsumo = null;
        let data = null;
        
        if (tomSelectInstance) {
            idInsumo = tomSelectInstance.getValue();
            if (idInsumo) {
                data = tomSelectInstance.options[idInsumo];
            }
        }

        // Validaciones básicas
        if (!cantidad || cantidad <= 0) return alert("Ingrese una cantidad válida");
        if (!medida) return alert("Seleccione una medida");
        if (!idInsumo) return alert("Seleccione un insumo");
        if (!data) return alert("Datos de insumo no disponibles");

        window._insumosTemp.push({
            id: idInsumo,
            nombre: data.nombre,
            codigo: data.codigo,
            cantidad,
            medida,
            enBD: false
        })

        renderTablaInsumos();
        actualizarContadorInsumos();

        // Limpiar campos correctamente
        document.getElementById('cantidad').value = '';

        // Resetear select (tipoMedida)
        const selectMedida = document.getElementById('tipoMedida');
        if (selectMedida) {
            selectMedida.selectedIndex = 0; 
        }

        // Limpiar TomSelect correctamente
        if (tomSelectInstance) {
            tomSelectInstance.clear();
            tomSelectInstance.setValue(null);
            tomSelectInstance.clearOptions(); 
        }
        document.getElementById('cantidad').focus();
    };

    window.eliminarInsumo = function(id) {

        // 🔥 detectar contexto (igual que técnicos)
        const fuente = (window._insumosTemp && window._insumosTemp.length)
            ? window._insumosTemp
            : (window._insumos || []);

        const insumo = fuente.find(i => i.id == id);
        if (!insumo) return;

        if (insumo.enBD) {

            fetch(window.baseUrl + 'Mantenimiento/EliminarInsumo', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ 
                    ID_Mantenimiento: window.ID_Mantenimiento,
                    ID_Insumo: id,
                    Tipo_Mantenimiento: window.Mantenimiento
                })
            })
            .then(r => r.json())
            .then(resp => {

                if (resp.success) {

                    // 🔥 eliminar de ambos estados SI existen
                    window.insumos = (window.insumos || []).filter(i => i.id != id);
                    window._insumosTemp = (window._insumosTemp || []).filter(i => i.id != id);
                    renderTablaInsumos();
                    actualizarContadorInsumos();
                } else {
                    alert(resp.message || 'Error al eliminar insumo');

                }

            })
            .catch(err => {
                console.error("ERROR FETCH:", err);
                alert("Error en la petición");
            });

        } else {

            // 🔥 solo temporal
            window._insumosTemp = (window._insumosTemp || []).filter(i => i.id != id);

            renderTablaInsumos();
            actualizarContadorInsumos();
        }
    }; 

    // Función para guardar los insumos (enviar al controlador)
    window.guardarInsumos = function() {
        const actuales = window.insumos.map(i => i.id);
        const nuevos = window._insumosTemp.filter(i => !actuales.includes(i.id));
        if (nuevos.length === 0) {
            bootstrap.Modal.getInstance(document.getElementById('modalInsumos'))?.hide();
            return;
        }
        
        // Aquí enviar los insumos al controlador usando fetch o AJAX
        fetch(`${window.baseUrl}Mantenimiento/GuardarInsumos`,{
            method: 'POST',
            headers: {'Content-Type': 'application/json'}, 
            body: JSON.stringify({
                Insumos: nuevos,
                ID_Mantenimiento: window.ID_Mantenimiento,
                Tipo_Mantenimiento: window.Mantenimiento
            })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success){

                // 🔥 CLAVE: sincronizar estado
                window.insumos = window._insumosTemp.map(i => ({ ...i, enBD: true }));
                actualizarContadorInsumos();
                alert('Insumos guardados correctamente');
                bootstrap.Modal.getInstance(
                    document.getElementById('modalInsumos')
                )?.hide();

            } else {
                alert('Error al guardar insumos: ' + data.message);
            }
        })
        .catch(() => alert('Error al guardar insumos'));
    };

    function actualizarContadorInsumos() {
        const contadorElement = document.getElementById('contadorInsumos');
        const subInsumosElement = document.getElementById('subInsumos');

        // Actualiza el span pequeño
        if (contadorElement) {
            const contadorFilas = window._insumosTemp.length;
            const texto = `${contadorFilas} insumo${contadorFilas !== 1 ? 's' : ''}`;
            contadorElement.textContent = texto;
        }

        // Actualiza el div grande
        if (subInsumosElement) {
            const contadorFilas1 = window.insumos.length;
            const texto1 = `${contadorFilas1} insumo${contadorFilas1 !== 1 ? 's' : ''}`;
            subInsumosElement.textContent = texto1;
        }
    }

    /*-- Botones Modal 6: Insumos --*/
    const modalInsumos = document.getElementById('modalInsumos');
    if (modalInsumos) {
        document.getElementById('btnGuardarInsumos')
            ?.addEventListener('click', function() { window.guardarInsumos(); });
        document.getElementById('btnVolverInsumos')
            ?.addEventListener('click', () => bootstrap.Modal.getInstance(modalInsumos)?.hide());
        modalInsumos.addEventListener('hidden.bs.modal', function () {
            const m2el = document.getElementById('agregarMantenimiento');
            if (!m2el.classList.contains('show')) new bootstrap.Modal(m2el).show();
        });
    }
    
    // tecnicos
    function renderPanelTecnicos() {
        const lista = document.getElementById('listaTecnicos');
        if (!lista) return;

        if (window._tecnicos.length === 0) {
            lista.innerHTML = '';
            return;
        }

        lista.innerHTML = window._tecnicos.map(t => {
            const badge = t.esPrincipal
                ? '<span style="font-size:.65rem;background:#fff3cd;color:#856404;border-radius:20px;padding:1px 7px;margin-right:5px;font-weight:600;">Principal</span>'
                : '';

            const accion = t.id == window.ID_Sesion
                ? '<span style="font-size:.7rem;color:#6c757d;font-style:italic;">Tú</span>'
                : '<button type="button" onclick="eliminarTecnico(' + t.id + ')" style="background:#f8d7da;border:none;border-radius:6px;color:#842029;font-size:.7rem;padding:2px 8px;cursor:pointer;">✕</button>';

            return '<div style="display:flex;align-items:center;justify-content:space-between;background:#f8f9fa;border-radius:8px;padding:6px 10px;font-size:.8rem;margin-bottom:4px;">'
                + '<span>' + badge + t.nombre + '</span>'
                + accion + '</div>';
        }).join('');
    }

    function renderModalTecnicos() {
        const listaMod = document.getElementById('listaTecnicosModal');
        const sinTec   = document.getElementById('sinTecnicos');
        const contador = document.getElementById('contadorTecnicos');
        if (!listaMod) return;

        listaMod.innerHTML = '';

        if (sinTec) sinTec.style.display = window._TecnicosTemp.length === 0 ? '' : 'none';

        window._TecnicosTemp.forEach(t => {
            const div = document.createElement('div');
            div.style.cssText = 'display:flex;align-items:center;justify-content:space-between;background:#f8f9fa;border-radius:8px;padding:8px 12px;font-size:.83rem;margin-bottom:6px;';

            const badge = t.esPrincipal
                ? '<span style="font-size:.65rem;background:#fff3cd;color:#856404;border-radius:20px;padding:1px 7px;margin-right:6px;font-weight:600;">Principal</span>'
                : '';

            const accion = t.id == window.ID_Sesion
                ? '<span style="font-size:.7rem;color:#6c757d;font-style:italic;">Tú</span>'
                : '<button type="button" onclick="eliminarTecnico(' + t.id + ')" style="background:#f8d7da;border:none;border-radius:6px;color:#842029;font-size:.7rem;padding:2px 8px;cursor:pointer;">✕ Quitar</button>';

            div.innerHTML = '<span>' + badge + t.nombre + '</span>' + accion;
            listaMod.appendChild(div);
        });

        if (contador) contador.textContent = window._TecnicosTemp.length;
    }

    function cargarSelectTecnicos() {
        const sel = document.getElementById('selectTecnicoModal');
        if (!sel) return;

        fetch('TraerTecnicos')
            .then(r => r.json())
            .then(data => {
                const lista = Array.isArray(data) ? data : JSON.parse(data);
                sel.innerHTML = '<option value="" disabled selected>— Seleccione técnico —</option>';
                lista.forEach(t => {
                    if (!window._TecnicosTemp.find(x => x.id == t.ID)) {
                        const opt = document.createElement('option');
                        opt.value       = t.ID;
                        opt.textContent = t.NombreCompleto;
                        sel.appendChild(opt);
                    }
                });
            })
            .catch(() => console.warn('No se pudo cargar técnicos'));
    }

    window.eliminarTecnico = function(id) {
        if (id == window.ID_Sesion) return;

        // detectar contexto
        const fuente = window._TecnicosTemp.length ? window._TecnicosTemp : window._tecnicos;

        const tecnico = fuente.find(t => t.id == id);
        if (!tecnico) return;

        if (tecnico.enBD) {

            fetch(window.baseUrl + 'Mantenimiento/EliminarTecnico', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    ID_Mantenimiento: window.ID_Mantenimiento,
                    ID_Tecnico: id
                })
            })
            .then(r => r.json())
            .then(resp => {
                if (resp.success) {

                    // eliminar de ambos estados SI existen
                    window._tecnicos = window._tecnicos.filter(t => t.id != id);
                    window._TecnicosTemp = window._TecnicosTemp.filter(t => t.id != id);

                    renderPanelTecnicos();
                    renderModalTecnicos();
                    cargarSelectTecnicos();
                }
            });

        } else {
            // solo en temp
            window._TecnicosTemp = window._TecnicosTemp.filter(t => t.id != id);
            renderModalTecnicos();
            cargarSelectTecnicos();
        }
    };

    // ── Abrir modal ──
    document.getElementById('btnAgregarTecnico')?.addEventListener('click', function () {
        const m2el = document.getElementById('agregarMantenimiento');
        const m2   = bootstrap.Modal.getInstance(m2el);
        if (m2) m2.hide();

        m2el.addEventListener('hidden.bs.modal', function handler() {
            m2el.removeEventListener('hidden.bs.modal', handler);

            // Clonar _tecnicos → Temp (estado limpio para editar)
            window._TecnicosTemp = window._tecnicos.map(t => Object.assign({}, t));

            cargarSelectTecnicos();
            renderModalTecnicos();

            new bootstrap.Modal(document.getElementById('modalTecnicos')).show();
        });
    });

    // ── Confirmar agregar ──
    document.getElementById('btnConfirmarTecnico')?.addEventListener('click', function () {
        const sel = document.getElementById('selectTecnicoModal');
        const id  = sel?.value;
        if (!id) { alert('Seleccione un técnico'); return; }

        const nombre = sel.options[sel.selectedIndex].text;

        if (window._TecnicosTemp.find(t => t.id == id)) {
            alert('Este técnico ya fue agregado'); return;
        }

        window._TecnicosTemp.push({ id: Number(id), nombre, esPrincipal: false, enBD: false });
        sel.value = '';

        renderModalTecnicos();
        cargarSelectTecnicos();
    });

    // ── Guardar → confirma en _tecnicos y llama al servidor ──
    document.getElementById('btnGuardarTecnicos')?.addEventListener('click', function () {
        if (!window.ID_Mantenimiento) { alert('No hay mantenimiento activo'); return; }

        const actuales = window._tecnicos.map(t => Number(t.id));
        const nuevos = window._TecnicosTemp.map(t => Number(t.id)).filter(id => !actuales.includes(id));

        if (nuevos.length === 0) {
            bootstrap.Modal.getInstance(document.getElementById('modalTecnicos'))?.hide();
            return;
        }
        
        const btn = document.getElementById('btnGuardarTecnicos');
        btn.disabled  = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Guardando...';

        fetch(window.baseUrl + 'Mantenimiento/GuardarTecnicos', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                ID_Mantenimiento: window.ID_Mantenimiento,
                ID_Tecnicos: nuevos
            })
        })
        .then(r => r.json())
        .then(resp => {
            if (resp.success) {
                // Confirmar: Temp pasa a ser el estado oficial
                window._tecnicos = window._TecnicosTemp.map(t => ({...t,
                    enBD: true
                }));
                renderPanelTecnicos();
                bootstrap.Modal.getInstance(document.getElementById('modalTecnicos'))?.hide();
            } else {
                alert('Error: ' + (resp.message || 'intente de nuevo'));
            }
        })
        .catch(() => alert('Error de conexión'))
        .finally(() => {
            btn.disabled  = false;
            btn.innerHTML = 'Guardar';
        });
    });

    // ── Cerrar sin guardar → descarta Temp ──
    document.getElementById('modalTecnicos')?.addEventListener('hidden.bs.modal', function () {
        window._TecnicosTemp = []; // limpiar temp al cerrar sin guardar
        renderPanelTecnicos();

        const m2el = document.getElementById('agregarMantenimiento');
        if (!m2el.classList.contains('show')) new bootstrap.Modal(m2el).show();
    });

    /* ═══════════════ RECUPERAR BORRADOR ═════════════
       Rellena el modal 2 (agregarMantenimiento) y todo el estado global
       con lo que ya está guardado en BD para un mantenimiento en estado
       BORRADOR. Recibe la respuesta cruda de ObtenerDetalles.php:
       { success: true, data: { mantenimiento, detalle, insumos, imagenes, tecnicos, novedades } }
    */
    window.LlenarModalMantenimiento = function (detalleResponse) {
        const data = detalleResponse.data;
        const m    = data.mantenimiento;
        const det  = data.detalle;

        /* Variables globales */
        window.ID_Mantenimiento  = m.ID;
        window.ID_Centro = m.ID_Centro;
        window.ID_Detalle        = det.ID;
        window.ID_Montacargas    = m.ID_Montacargas;
        window.Tipo_Mantenimiento = m.Tipo_Mantenimiento;
        window.Tipo_Montacargas = m.Tipo;


        /* Panel izquierdo (mismos campos que en CrearMantenimiento) */
        const setVal = (id, val) => { const el = document.getElementById(id); if (el) el.value = val || ''; };
        setVal('numeroMontacargas', m.NumeroM);
        setVal('nombreSeccion',     m.NombreArea);
        setVal('numeroSerie',       m.SerieM);
        setVal('numeroModelo',      m.ModeloM);
        setVal('nombreCentro',      m.NombreCentro);
        setVal('Voltaje',           m.VoltajeM);
        setVal('nombreOperario',    m.NombreOperario);

        /* Técnicos: vienen concatenados en el registro principal (GROUP_CONCAT) */
        window._tecnicos = [];
        if (m.ID_Tecnicos && m.NombreTecnicos) {
            const ids     = m.ID_Tecnicos.split(',');
            const nombres = m.NombreTecnicos.split(',');
            ids.forEach((id, i) => {
                window._tecnicos.push({
                    id: parseInt(id),
                    nombre: (nombres[i] || '').trim(),
                    esPrincipal: false,
                    enBD: true
                });
            });
        }
        renderPanelTecnicos();

        /* Insumos
           ⚠️ detalles_insumos_mantenimientos solo guarda ID_Insumo/Cantidad/Medida.
           Codigo y Nombre quedan vacíos hasta agregar el JOIN con la tabla catálogo
           en ObtenerMantenimientoCompleto (pendiente de confirmar el nombre de esa tabla). */
        window.insumos = (data.insumos || []).map(i => ({
            id: String(i.ID_Insumo),
            codigo: i.Codigo || '',
            nombre: i.Nombre || '',
            cantidad: i.Cantidad,
            medida: i.Medida,
            enBD: true
        }));
        window._insumosTemp = window.insumos.map(i => ({ ...i }));
        actualizarContadorInsumos();

        /* Novedades */
        window._novedades = (data.novedades || []).map(n => ({
            id: n.ID,
            txt: n.Descripcion,
            enBD: true
        }));
        window._novedadesTemp = window._novedades.map(n => ({ ...n }));
        actualizarContadorNovedades();

        /* Criterios de sección: reconstruir tarjetas y restaurar respuestas guardadas.
           m.Tipo_Mantenimiento = duración (250h/1000h/2000h), m.Tipo = clase de montacargas —
           mismo par de valores que arma cargarCriterios(tipoMant, tipoMont) en el flujo normal. */
        if (m.Tipo_Mantenimiento && m.Tipo && window.CRITERIOS_DATA) {
            cargarCriterios(m.Tipo_Mantenimiento, m.Tipo);

            // Observaciones vienen en UNA sola columna JSON:
            // [{"criterio":"Criterio_2","observacion":"Pruebas"}, ...]
            let observaciones = [];
            try {
                observaciones = det.Observaciones ? JSON.parse(det.Observaciones) : [];
            } catch (e) {
                observaciones = [];
            }
            const mapaObs = {};
            observaciones.forEach(o => { if (o && o.criterio) mapaObs[o.criterio] = o.observacion; });

            window._respuestasSeccion = {};
            Object.entries(window._seccionesData).forEach(([slug, seccion]) => {
                const resp = {};
                seccion.criterios.forEach(c => {
                    const val = det[c.hidden];
                    if (val !== undefined && val !== null && val !== '') {
                        resp[c.name] = val;
                    }
                    if (mapaObs[c.hidden] !== undefined) {
                        resp['obs_' + c.name] = mapaObs[c.hidden];
                    }
                });
                window._respuestasSeccion[slug] = resp;
            });

            // Imágenes de evidencia: Categoria coincide con el nombre de la sección
            // (ej. "Bateria" → slug "bateria"), Evidencia_Fotografica es la ruta relativa.
            window._imagenesSeccion = {};
            (data.imagenes || []).forEach(img => {
                const slug = slugSeccion(img.Categoria || '');
                if (!slug) return;
                if (!window._imagenesSeccion[slug]) window._imagenesSeccion[slug] = [];
                window._imagenesSeccion[slug].push({
                    id: img.ID,
                    src: window.baseUrl + img.Evidencia_Fotografica,
                    ruta: img.Evidencia_Fotografica,
                    categoria: img.Categoria,
                    enBD: true
                });
            });

            renderTarjetasSecciones();
            actualizarProgreso();
        }

        /* Subtítulo del modal 2 (mismo formato que en CrearMantenimiento) */
        const subtitulo = document.getElementById('subtituloModal');
        if (subtitulo) subtitulo.textContent = `${m.Tipo_Mantenimiento || ''} · ${m.Tipo || ''}`;

        /*Traer Operarios Recibe*/
        TraerOperioRecibe();
    };

    /* Firmar Tecnicos */
    function cargarFirmasMecanicos() {

        const contenedor = document.getElementById('contenedorFirmasMecanicos');
        if (!contenedor) {
            console.error('No existe contenedorFirmasMecanicos');
            return;
        }

        contenedor.innerHTML = '';
        const tecnicos = window._tecnicos || [];
        if (tecnicos.length === 0) {
            contenedor.innerHTML = `
                <div class="alert alert-warning">
                    No hay mecánicos asociados a este mantenimiento.
                </div>
            `;
            return;
        }

        tecnicos.forEach((tecnico, index) => {
            contenedor.innerHTML += `
                <div class="card mb-4">
                    <div class="card-header">
                        <strong> Mecánico ${index + 1} </strong>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label"> Nombre del mecánico </label>
                            <input type="text" class="form-control" value="${tecnico.nombre}" readonly>
                        </div>

                        <div class="mb-2">
                            <label class="form-label"> Firma </label>
                            <canvas
                                id="canvasFirma_${tecnico.id}"
                                class="border rounded w-100"
                                height="200"
                                style="touch-action: none;">
                            </canvas>
                        </div>
                        <button
                            type="button"
                            class="btn btn-sm btn-outline-secondary"
                            onclick="limpiarFirmaTecnico(${tecnico.id})">
                            Limpiar firma
                        </button>
                    </div>
                </div>
            `;
        });

        // Inicializar los canvas después de crearlos
        tecnicos.forEach(tecnico => {
            inicializarCanvasFirma(tecnico.id);
        });
    }

    const canvasFirmas = {};
    function inicializarCanvasFirma(idTecnico) {
        const canvas = document.getElementById(`canvasFirma_${idTecnico}`);

        if (!canvas) return;

        const ctx = canvas.getContext('2d');

        ctx.lineWidth = 2;
        ctx.lineCap = 'round';
        ctx.lineJoin = 'round';

        let dibujando = false;

        function obtenerPosicion(e) {

            const rect = canvas.getBoundingClientRect();

            let clientX;
            let clientY;

            if (e.touches && e.touches.length > 0) {

                clientX = e.touches[0].clientX;
                clientY = e.touches[0].clientY;

            } else {

                clientX = e.clientX;
                clientY = e.clientY;
            }

            // Escala entre el tamaño interno y el tamaño visual
            const escalaX = canvas.width / rect.width;
            const escalaY = canvas.height / rect.height;

            return {
                x: (clientX - rect.left) * escalaX,
                y: (clientY - rect.top) * escalaY
            };
        }

        function comenzar(e) {

            e.preventDefault();

            dibujando = true;

            const pos = obtenerPosicion(e);

            ctx.beginPath();
            ctx.moveTo(pos.x, pos.y);
        }

        function dibujar(e) {

            if (!dibujando) return;

            e.preventDefault();

            const pos = obtenerPosicion(e);

            ctx.lineTo(pos.x, pos.y);
            ctx.stroke();
        }

        function terminar(e) {

            if (!dibujando) return;

            e.preventDefault();

            dibujando = false;

            ctx.closePath();
        }

        // Mouse
        canvas.addEventListener('mousedown', comenzar);
        canvas.addEventListener('mousemove', dibujar);
        canvas.addEventListener('mouseup', terminar);
        canvas.addEventListener('mouseleave', terminar);

        // Touch
        canvas.addEventListener('touchstart', comenzar, {
            passive: false
        });

        canvas.addEventListener('touchmove', dibujar, {
            passive: false
        });

        canvas.addEventListener('touchend', terminar, {
            passive: false
        });
        canvasFirmas[idTecnico] = canvas;
    }

    window.limpiarFirmaTecnico = function(idTecnico) {
        const canvas = document.getElementById(`canvasFirma_${idTecnico}`);
        if (!canvas) return;
        const ctx = canvas.getContext('2d');
        ctx.clearRect(0,0,canvas.width, canvas.height);
    };

    function validarFirmasMecanicos() {
        const tecnicos = window._tecnicos || [];
        if (tecnicos.length === 0) {
            alert('No hay mecánicos asociados al mantenimiento.');
            return false;
        }

        for (const tecnico of tecnicos) {
            const canvas = document.getElementById(`canvasFirma_${tecnico.id}`);
            
            if (!canvas) {
                console.error(`No existe canvas para el técnico ${tecnico.id}`);
                alert(`No se encontró el área de firma de ${tecnico.nombre}.`);
                return false;
            }

            const ctx = canvas.getContext('2d');
            const imagen = ctx.getImageData(0,0,canvas.width,canvas.height);
            let tieneFirma = false;

            for (let i = 3; i < imagen.data.length; i += 4) {
                if (imagen.data[i] !== 0) {
                    tieneFirma = true;
                    break;
                }
            }

            if (!tieneFirma) {
                alert(`El mecánico ${tecnico.nombre} debe registrar su firma.`);
                return false;
            }
        }
        return true;
    }

    document.getElementById('btnGuardarFirmas')?.addEventListener('click', function () {

        if (!validarFirmasMecanicos()) {
            return;
        }

        // Obtener firmas
        const firmas = [];

        window._tecnicos.forEach(tecnico => {

            const canvas = document.getElementById(
                `canvasFirma_${tecnico.id}`
            );

            firmas.push({
                ID_Tecnico: tecnico.id,
                Nombre: tecnico.nombre,
                Firma: canvas.toDataURL('image/png')
            });

        });

        // AQUÍ irá el fetch para guardar las firmas
        fetch(`${window.baseUrl}Mantenimiento/FirmarMantenimientoPreventivoTecnicos`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    Firmas: firmas,
                    ID_Mantenimiento: window.ID_Mantenimiento,
                    ID_Supervisor1: window.ID_Supervisor1,
                    Correo_Supervisor1: window.Correo_Supervisor1,
                    Nombre_Supervisor1: window.Nombre_Supervisor1,
                    Tipo_Mantenimiento : window.Tipo_Mantenimiento,
                    Tipo_Montacargas : window.Tipo_Montacargas,
                    ID_Centro : window.ID_Centro,
                    Insumos : window.insumos,
                })
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    bootstrap.Modal.getInstance(document.getElementById('modalFirmasMantenimiento'))?.hide();
                     Swal.fire({
                        icon: 'success',
                        title: '¡Correcto!',
                        text: data.message || 'Firmas guardadas correctamente.',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    alert('Error al guardar firmas: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error al guardar firmas:',error);
                alert('Error al guardar firmas');
            });
    });

    /* ── Abrir modal firmas ── */
    let canvasFirma1;
    let ctxFirma;
    let dibujandoFirma = false;

    window.inicializarCanvasFirma = function () {
        canvasFirma1 = document.getElementById('canvasFirma1');
        if (!canvasFirma1) {
            console.error('No se encontró el canvasFirma1');
            return;
        }

        ctxFirma = canvasFirma1.getContext('2d');
        ctxFirma.lineWidth = 2;
        ctxFirma.lineCap = 'round';
        ctxFirma.lineJoin = 'round';

        // Mouse
        canvasFirma1.addEventListener('mousedown', iniciarFirma);
        canvasFirma1.addEventListener('mousemove', dibujarFirma);
        canvasFirma1.addEventListener('mouseup', terminarFirma);
        canvasFirma1.addEventListener('mouseleave', terminarFirma);

        // Touch
        canvasFirma1.addEventListener('touchstart', iniciarFirmaTouch, { passive: false });
        canvasFirma1.addEventListener('touchmove', dibujarFirmaTouch, { passive: false });
        canvasFirma1.addEventListener('touchend', terminarFirma);
        limpiarFirma();
    }

    function obtenerPosicionCanvas(e) {
        const rect = canvasFirma1.getBoundingClientRect();
        return {
            x: (e.clientX - rect.left) * (canvasFirma1.width / rect.width),
            y: (e.clientY - rect.top) * (canvasFirma1.height / rect.height)
        };
    }

    function iniciarFirma(e) {
        dibujandoFirma = true;
        const posicion = obtenerPosicionCanvas(e);
        ctxFirma.beginPath();
        ctxFirma.moveTo(posicion.x, posicion.y);
    }

    function dibujarFirma(e) {
        if (!dibujandoFirma) return;
        const posicion = obtenerPosicionCanvas(e);
        ctxFirma.lineTo(posicion.x, posicion.y);
        ctxFirma.stroke();
    }

    function terminarFirma() {
        if (ctxFirma) {
            ctxFirma.closePath();
        }
        dibujandoFirma = false;
    }

    function iniciarFirmaTouch(e) {
        e.preventDefault();
        const touch = e.touches[0];
        iniciarFirma({
            clientX: touch.clientX,
            clientY: touch.clientY
        });
    }

    function dibujarFirmaTouch(e) {
        e.preventDefault();
        if (!dibujandoFirma) return;
        const touch = e.touches[0];
        dibujarFirma({
            clientX: touch.clientX,
            clientY: touch.clientY
        });
    }

    window.abrirModalFirma = function (ID_Mantenimiento, contexto, ID_Mecanico = null, NombrePersona = '', TipoMontacargas, TipoMantenimiento) {
        document.getElementById('ID_MantenimientoFirma').value = ID_Mantenimiento;
        document.getElementById('TipoFirma').value = contexto;

        const url =
                `${window.baseUrl}Mantenimiento/VerMantenimientoPreventivo` +
                `${encodeURIComponent(TipoMontacargas)}` +
                `${encodeURIComponent(TipoMantenimiento)}` +
                `?ID=${encodeURIComponent(ID_Mantenimiento)}`;

            console.log('URL del mantenimiento:', url);

            window.open(url, '_blank');
        const inputMecanico = document.getElementById('ID_MecanicoFirma');
        if (inputMecanico) {
            inputMecanico.value = contexto === 'mecanico' ? (ID_Mecanico ?? '') : '';
        }

        const titulo = document.getElementById('tituloModalFirma');
        const texto = document.getElementById('textoModalFirma');
        if (contexto === 'supervisor') {
            titulo.textContent ='Firma del Supervisor';
            texto.textContent =`Realice la firma del supervisor: ${NombrePersona}`;
        } else if (contexto === 'operario') {
            titulo.textContent ='Firma del Operario';
            texto.textContent =`Realice la firma del operario: ${NombrePersona}`;
        } else if (contexto === 'mecanico') {
            titulo.textContent = 'Firma del Mecánico';
            texto.textContent =`Realice la firma del mecánico: ${NombrePersona}`;
        }
        const modalElement =document.getElementById('modalFirma');
        if (!modalElement) {
            console.error('No existe el modal #modalFirma');
            return;
        }

        $('#modalFirma').modal('show');
        $('#modalFirma').one('shown.bs.modal', function () {
            if (typeof window.inicializarCanvasFirma ==='function') {
                window.inicializarCanvasFirma();
            } else {
                console.error('inicializarCanvasFirma no está definida');
            }
        });
    };

    window.guardarFirma = function () {

        const ID_Mantenimiento2 = document.getElementById('ID_MantenimientoFirma').value;
        const tipo = document.getElementById('TipoFirma').value;
        const ID_Mecanico2 = document.getElementById('ID_MecanicoFirma').value;

        // Verificar canvas
        if (!canvasFirma1) {
            canvasFirma1 = document.getElementById('canvasFirma1');
        }

        if (!canvasFirma1) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se encontró el área de firma.'
            });
            return;
        }

        // Verificar que exista una firma
        const imagenCanvas = canvasFirma1.toDataURL('image/png');

        console.log('================================');
        console.log('Guardando firma...');
        console.log('ID Mantenimiento:', ID_Mantenimiento2);
        console.log('Tipo:', tipo);
        console.log('ID Mecánico:', ID_Mecanico2);
        console.log('Firma:', imagenCanvas);
        console.log('================================');

        // AQUÍ irá el fetch para guardar las firmas
        fetch(`${window.baseUrl}Mantenimiento/FirmarMantenimientoPreventivo`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    ID_Mantenimiento: ID_Mantenimiento2,
                    Tipo: tipo,
                    ID_Mecanico2: ID_Mecanico2,
                    Firma: imagenCanvas,
                })
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Firma Guardada',
                        text: `Firma de ${tipo} guardada correctamente.`,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    alert('Error al guardar firmas: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error al guardar firmas:',error);
                alert('Error al guardar firmas');
            });
    };

    window.limpiarFirma = function () {

        if (!canvasFirma1) {
            canvasFirma1 = document.getElementById('canvasFirma1');
        }
        if (!canvasFirma1) {
            return;
        }
        if (!ctxFirma) {
            ctxFirma = canvasFirma1.getContext('2d');
        }
        ctxFirma.clearRect(0, 0, canvasFirma1.width, canvasFirma1.height);
    };

    //BUSCAR
    const btnBuscar = document.getElementById('btnAbrirBuscarMantenimiento');

    if (btnBuscar) {
        btnBuscar.addEventListener('click', function () {

            const modalElement = document.getElementById('modalBuscarMantenimiento');
            if (!modalElement) return;
            const modal = new bootstrap.Modal(modalElement);
            modal.show();
        });

        btnBuscar.addEventListener('keydown', function (event) {
            if (event.key === 'Enter' || event.key === ' ') {
                event.preventDefault();
                const modalElement = document.getElementById('modalBuscarMantenimiento');
                if (!modalElement) return;
                const modal = new bootstrap.Modal(modalElement);
                modal.show();
            }
        });
    }

    // EJECUTAR BÚSQUEDA
    document.getElementById('formBuscarMantenimiento') ?.addEventListener('submit', function (e) {
        e.preventDefault();

            const centro = document.getElementById('buscarCentro') ?.value || '';
            const montacargas = document.getElementById('buscarMontacargas') ?.value .trim().toLowerCase() || '';
            const tipoMantenimiento = document.getElementById('buscarTipoMantenimiento') ?.value || '';
            const tipoMontacargas = document.getElementById('buscarTipoMontacargas') ?.value || '';
            const fechaDesde = document.getElementById('buscarFechaDesde') ?.value || '';
            const fechaHasta = document.getElementById('buscarFechaHasta') ?.value || '';

            const mantenimientos = Array.isArray(window.MANTENIMIENTOS_DATA) ? window.MANTENIMIENTOS_DATA : [];
            const resultados = mantenimientos.filter(m => {
                // CENTRO
                if (centro) {
                    if (String(m.Centrot ?? '') !== centro) {
                        return false;
                    }
                }

                // MONTACARGAS
                // Número / Marca / Modelo / Serie
                if (montacargas) {
                    const numero = String(m.NumeroM ?? '').toLowerCase();
                    const marca = String(m.MarcaM ?? '').toLowerCase();
                    const modelo = String(m.ModeloM ?? '').toLowerCase();
                    const serie = String(m.SerieM ?? '').toLowerCase();
                    const coincide = numero.includes(montacargas) || marca.includes(montacargas) || modelo.includes(montacargas) || serie.includes(montacargas);
                    if (!coincide) {
                        return false;
                    }
                }

                // TIPO MANTENIMIENTO
                if (tipoMantenimiento) {
                    if (String(m.Tipo_Mantenimiento ?? '') !== tipoMantenimiento) {
                        return false;
                    }
                }

                // TIPO MONTACARGAS
                if (tipoMontacargas) {
                    if (String(m.TipoMontacargas ?? '') !== tipoMontacargas){
                        return false;
                    }
                }

                // FECHA DESDE
                if (fechaDesde && m.Fecha_Realizado) {
                    if (String(m.Fecha_Realizado) < fechaDesde) {
                        return false;
                    }
                }

                // FECHA HASTA
                if (fechaHasta && m.Fecha_Realizado) {
                    if (String(m.Fecha_Realizado) > fechaHasta) {
                        return false;
                    }
                }
                return true;
            });

            mostrarResultadosBusqueda(resultados);
     });

    // MOSTRAR RESULTADOS   
    function mostrarResultadosBusqueda(resultados) {

        const contenedor =document.getElementById('resultadoBusquedaMantenimiento');
        const tbody = document.getElementById('bodyResultadosBusqueda');
        if (!contenedor || !tbody) return;
        contenedor.style.display = 'block';
        tbody.innerHTML = '';
        if (!resultados.length) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">
                        🔎 No se encontraron mantenimientos.
                    </td>
                </tr>
            `;
            return;
        }

        resultados.forEach((m, index) => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>
                    ${index + 1}
                </td>
                <td>
                    <strong> ${m.Numero ?? m.ID ?? ''} </strong>
                </td>
                <td>
                    <strong> ${m.NumeroM ?? ''} </strong>
                    <br>
                    <small class="text-muted">
                        ${m.MarcaM ?? ''}
                        ${m.ModeloM ? ' - ' + m.ModeloM : ''}
                        ${m.SerieM ? '<br>Serie: ' + m.SerieM : ''}
                    </small>
                </td>
                <td>
                    ${m.Centrot ?? ''}
                </td>
                <td>
                    ${formatearTipoMantenimiento( m.Tipo_Mantenimiento)}
                </td>
                <td>
                    ${formatearFecha(m.Fecha_Realizado)}
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-primary" onclick="verMantenimientoBuscado(${m.ID})">
                        Ver
                    </button>
                </td> `;
            tbody.appendChild(tr);
        });
    }

    // FORMATEAR TIPO
    function formatearTipoMantenimiento(tipo) {
        switch (tipo) {
            case '250_Horas': return '250 Horas';
            case '1000_Horas': return '1000 Horas';
            case '2000_Horas': return '2000 Horas';
            default: return tipo || '';
        }
    }

    // LIMPIAR
    document.getElementById('btnLimpiarBusqueda')?.addEventListener('click', function () {
        document.getElementById('formBuscarMantenimiento') ?.reset();
        const contenedor = document.getElementById( 'resultadoBusquedaMantenimiento');
        const tbody = document.getElementById('bodyResultadosBusqueda');
        if (contenedor) {
            contenedor.style.display = 'none';
        }
        if (tbody) {
            tbody.innerHTML = '';
        }
    });

    window.verMantenimientoBuscado = function (ID) {
        const mantenimiento = (window.MANTENIMIENTOS_DATA || []).find(m => String(m.ID) === String(ID));
        if (!mantenimiento) {
            console.error( 'No se encontró el mantenimiento:',ID);
            return;
        }
        const TipoMantenimiento =(mantenimiento.Tipo_Mantenimiento ?? '').replace(/_/g, '');
        const url =`${window.baseUrl}Mantenimiento/VerMantenimientoPreventivo` + `${encodeURIComponent(mantenimiento.TipoMontacargas)}` + `${encodeURIComponent(TipoMantenimiento)}` + `?ID=${encodeURIComponent(mantenimiento.ID)}`;
        window.open(url, '_blank');
    };

    //INFORMES
    const btnInforme = document.getElementById('btnAbrirInformesMantenimiento');

    if (btnInforme) {
        btnInforme.addEventListener('click', function () {

            const modalElement = document.getElementById('modalInformeMantenimiento');
            if (!modalElement) return;
            const modal = new bootstrap.Modal(modalElement);
            modal.show();
        });

        btnInforme.addEventListener('keydown', function (event) {
            if (event.key === 'Enter' || event.key === ' ') {
                event.preventDefault();
                const modalElement = document.getElementById('modalInformeMantenimiento');
                if (!modalElement) return;
                const modal = new bootstrap.Modal(modalElement);
                modal.show();
            }
        });
    }

    // GENERAR INFORME
    document.getElementById('formInformeMantenimiento')?.addEventListener('submit', function (e) {

        e.preventDefault();

        const tipoInforme = document.getElementById('tipoInforme')?.value || '';
        const formato = document.querySelector('input[name="formatoInforme"]:checked')?.value || '';
        const centro = document.getElementById('informeCentro')?.value || '';
        const fechaDesde = document.getElementById('informeFechaDesde')?.value || '';
        const fechaHasta = document.getElementById('informeFechaHasta')?.value || '';
        const montacargas = document.getElementById('informeMontacargas') ?.value .trim() || '';
        const tipoMantenimiento = document.getElementById('informeTipo') ?.value .trim() || '';
        const NombreGenera = document.getElementById('informeNombre') ?.value .trim() || '';

        // VALIDAR INFORME
        if (!tipoInforme) {
            Swal.fire({
                icon: 'warning',
                title: 'Seleccione un informe',
                text: 'Debe seleccionar el tipo de informe.'
            });

            return;
        }

        // VALIDAR FORMATO
        if (!formato) {
            Swal.fire({
                icon: 'warning',
                title: 'Seleccione un formato',
                text: 'Seleccione PDF o Excel.'
            });
            return;
        }

        // PARÁMETROS

        const parametros = new URLSearchParams({
            tipoInforme: tipoInforme,
            centro: centro,
            fechaDesde: fechaDesde,
            fechaHasta: fechaHasta,
            montacargas: montacargas,
            tipoMantenimiento: tipoMantenimiento,
            NombreGenera: NombreGenera,
        });


        let url = '';

        // INFORME F-145
        if (tipoInforme === 'F_145') {
            if (formato === 'pdf') {
                url = `${window.baseUrl}Mantenimiento/VerInformeF145?` + parametros.toString();
            }
            else if (formato === 'excel') {
                url = `${window.baseUrl}Mantenimiento/VerInformeF145Excel?` + parametros.toString();
            }

        }

        // INFORME NO CONFIGURADO
        else {
            Swal.fire({
                icon: 'error',
                title: 'Informe no disponible',
                text: 'El informe seleccionado aún no está configurado.'
            });
            return;
        }

        // VALIDAR URL
        if (!url) {
            Swal.fire({
                icon: 'error',
                title: 'Formato no disponible',
                text: 'El formato seleccionado no está configurado para este informe.'
            });
            return;
        }

        console.log('Informe:', tipoInforme);
        console.log('Formato:', formato);
        console.log('URL:', url);

        // ABRIR INFORME
        window.open(url, '_blank');

    });

    //LIMPIAR MODAL INFORME
    document.getElementById('btnLimpiarInforme')?.addEventListener('click', function () {
        document.getElementById('formInformeMantenimiento') ?.reset();
    });
});