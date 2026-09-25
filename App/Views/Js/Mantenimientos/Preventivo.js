/*Variables globales */
window.ID_Mantenimiento = null;
window.ID_Detalle = null;
window.ID_Montacargas = null;
window.Tipo_Mantenimiento = 'Preventivo';
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

function toggleObservacion(select) {
    const obsDiv = document.getElementById(select.dataset.obsTarget);
    if (!obsDiv) return;
    const necesita = !OPCIONES_SIN_TRABAJO.includes(select.value);
    obsDiv.classList.toggle('d-none', !necesita);
    const textarea = obsDiv.querySelector('textarea');
    if (textarea) {
        textarea.required = necesita;
        if (!necesita) textarea.value = '';
    }
    select.dataset.val = select.value;
    actualizarProgreso();
}

/* ════ TARJETAS DE SECCIÓN ════ */
function contarCompletadosSeccion(slug) {
    return Object.values(window._respuestasSeccion[slug] || {})
        .filter(v => v !== '').length;
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
    const imgs     = window._imagenesSeccion[slug] || [];
    const prevEl   = document.getElementById(`imgPreview_${imgSlug}`);
    const countEl  = document.getElementById(`imgCount_${imgSlug}`);
    imgs.forEach(img => prevEl.appendChild(crearThumb(img.src, imgSlug)));
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
function crearThumb(src, slug) {
    const thumb = document.createElement('div');
    thumb.className = 'img-thumb position-relative';
    thumb.style.cssText = 'width:64px;height:64px;border-radius:8px;overflow:hidden;border:1px solid #e8e8f0;flex-shrink:0;';
    thumb.innerHTML = `
        <img src="${src}" alt="img" style="width:100%;height:100%;object-fit:cover;"
            onclick="abrirLightbox('${src}')">
        <button type="button" onclick="eliminarThumb(this,'${slug}')"
            style="position:absolute;top:2px;right:2px;background:rgba(0,0,0,.55);border:none;
                   border-radius:50%;width:18px;height:18px;color:#fff;font-size:10px;
                   line-height:1;cursor:pointer;display:flex;align-items:center;justify-content:center;">✕</button>`;
    return thumb;
}

function previewImagenes(input) {
    const slug    = input.dataset.slug;
    const prevEl  = document.getElementById(`imgPreview_${slug}`);
    const countEl = document.getElementById(`imgCount_${slug}`);
    Array.from(input.files).forEach(file => {
        if (!file.type.startsWith('image/')) return;
        const reader = new FileReader();
        reader.onload = e => {
            prevEl.appendChild(crearThumb(e.target.result, slug));
            countEl.textContent = prevEl.querySelectorAll('.img-thumb').length;
        };
        reader.readAsDataURL(file);
    });
}

function eliminarThumb(btn, slug) {
    btn.closest('.img-thumb').remove();
    const countEl = document.getElementById(`imgCount_${slug}`);
    if (countEl) countEl.textContent =
        document.getElementById(`imgPreview_${slug}`).querySelectorAll('.img-thumb').length;
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
    if (e.target.classList.contains('criterio-select')) {
        e.target.dataset.val = e.target.value;
    }
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
        toggleBtn.querySelector('span:first-child').textContent =
            collapsed ? '📋 Ver información del equipo' : '📋 Ocultar información del equipo';
    });

    /* ── SWITCH OPERARIO ── */
    const switchOperario = document.getElementById('tipoOperarioSwitch');
    const selectOperario = document.getElementById('ID_Operario');
    const inputExterno   = document.getElementById('OperarioExterno');
    const labelInterno   = document.getElementById('labelInterno');
    const labelExterno   = document.getElementById('labelExterno');

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

    /* ── CARGA DINÁMICA ── */
    window.cargarMontacargas = function () {
        const ID_Centro = document.getElementById('ID_Centro1').value;
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
                        const bateriaVal = getDetalle(Detalles, ['NumeroB', 'Numero_Interno', 'N_Bateria', `${pref}N_Bateria`]);
                        const longitudVal = getDetalle(Detalles, ['LongitudH', 'Longitud_H', 'Longitud', `${pref}LongitudH`]);
                        window._respuestasSeccion = window._respuestasSeccion || {};
                        window._respuestasSeccion['bateria'] = window._respuestasSeccion['bateria'] || {};
                        window._respuestasSeccion['horquillas'] = window._respuestasSeccion['horquillas'] || {};
                        

                        window._respuestasSeccion['bateria'][`${pref}N_Bateria`] = bateriaVal;
                        window._respuestasSeccion['horquillas'][`${pref}LongitudH`] = longitudVal;
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

    /* ── VERIFICAR BORRADOR ── */
    document.getElementById('btnPreventivo').addEventListener('click', function () {
        fetch('VerificarBorrador')
            .then(res => res.json())
            .then(data => {
                if (data.existe) {
                    if (confirm('⚠️ Tienes un mantenimiento preventivo en progreso.\n¿Deseas continuar donde lo dejaste?')) {
                        fetch(`ObtenerDetalles?ID_Mantenimiento=${data.ID_Mantenimiento}`)
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
                    } else {
                        new bootstrap.Modal(document.getElementById('NumerDocumentoModal')).show();
                    }
                } else {
                    new bootstrap.Modal(document.getElementById('NumerDocumentoModal')).show();
                }
            })
            .catch(() => new bootstrap.Modal(document.getElementById('NumerDocumentoModal')).show());
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
    // ya funciona
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
                    Tipo_Mantenimiento: window.Tipo_Mantenimiento
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
    //Ya funciona
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
                Tipo_Mantenimiento: window.Tipo_Mantenimiento
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

                window._novedades = window._novedadesTemp.map(n => ({
                    ...n
                }));

                actualizarContadorNovedades();

                bootstrap.Modal.getInstance(
                    document.getElementById('modalNovedades')
                )?.hide();

            } else {
                alert(
                    'Error al guardar novedades: ' +
                    data.message
                );
            }
        })
        .catch(error => {
            console.error(
                'Error al guardar novedades:',
                error
            );
            alert('Error al guardar novedades');
        });
    };

    function renderTablaNovedades() {
        console.log("Renderizando tabla de novedades...");
        console.log("Novedades temporales:", window._novedadesTemp);
        console.log("Novedades en BD:", window._novedades);
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
        document.querySelectorAll('.criterio-select').forEach(sel => {
            const val = sel.value;
            if (!val || val === 'C' || val === 'N/A') return;
            const obsId  = sel.dataset.obsTarget;
            const obsEl  = obsId ? document.getElementById(obsId) : null;
            const obs    = obsEl ? (obsEl.querySelector('textarea')?.value?.trim() || '') : '';
            const label  = sel.closest('.criterio-row')?.querySelector('.criterio-label')?.textContent?.trim() || sel.name;
            filas.push({ label, val, obs });
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

    //ya funciona
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
                    Tipo_Mantenimiento: window.Tipo_Mantenimiento
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
    //ya funciona
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
                Tipo_Mantenimiento: window.Tipo_Mantenimiento
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

    // ya funciona 
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

}); 