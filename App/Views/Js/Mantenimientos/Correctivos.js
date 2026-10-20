/*Variables globales */
window.ID_Mantenimiento = null;
window.ID_Montacargas = null;
window.ID_Centro = null;
window.Mantenimiento = 'Correctivo';
window.Tipo_Montacargas= null;
window._tecnicos = [];
window._TecnicosTemp = [];
window.insumos = [];
window._insumosTemp = [];
window.Repuestos = [];
window._RepuestosTemp = [];
window._novedades = [];
window._novedadesTemp = [];
window.observaciones = [];
window._observacionesTemp = [];
window.Detalles = [];
window.Imagenes = [];
window._novedadSeleccionada = null;
window._origenModalFalla = null;
window.FallaTemp = [];
window.CorreccionesTemp = [];

window.secciones = {
    "pasillo":[
        "Bateria",
        "Sistema Eléctrico",
        "Sistema de Tracción",
        "Sistema de Frenos",
        "Sistema Hidraulico",
        "Mastil",
        "Horquillas",
        "Ruedas",
        "Chasis",
        "Luces y Alarmas",
        "Lubricación",
        "Cargador",
        "Estado de Pintura",
        "Revision de Equipo",
        "Sistema de Funciones Auxiliares",
        "Suspension y Caster",
        "Pantografo"
    ],
    "contrabalanceada":[
        "Bateria",
        "Sistema Eléctrico",
        "Sistema de Tracción",
        "Sistema de Frenos",
        "Sistema de Dirección",
        "Sistema Hidraulico",
        "Mastil",
        "Horquillas",
        "Ruedas",
        "Chasis",
        "Luces y Alarmas",
        "Lubricación",
        "Cargador",
        "Estado de Pintura",
        "Revision de Equipo",
        "Aditamentos",
        "Carro Porta Horquillas"
    ],
    "combustion":[
        "Bateria",
        "Sistema Eléctrico",
        "Sistema de Frenos",
        "Sistema Hidraulico",
        "Mastil",
        "Horquillas",
        "Ruedas",
        "Chasis",
        "Lubricación",
        "Estado de Pintura",
        "Revision de Equipo",
        "Aditamentos",
        "Motor",
        "Sistema de refrigeracíon",
        "Sistema de Combustión",
        "Transmisión",
        "Direccion",
        "Caja Automatica"
    ],
    "manlift":[
        "Bateria",
        "Sistema Eléctrico",
        "Sistema de Frenos",
        "Sistema de Dirección",
        "Sistema Hidraulico",
        "Ruedas",
        "Lubricación",
        "Cargador",
        "Estado de Pintura",
        "Componentes Estructurales",
        "Ausencia de Piezas o Componentes",
        "Revisiones de Operacion",
        "Correas y Cadenas",
        "Unidad de Tracción",
        "Panel de Controles",
        "Funcionamiento General del Equipo"
    ]
};

// CARGAR CRITERIOS SEGÚN TIPO DE MONTACARGAS
function cargarCriterios(tipoMontacargas) {
    /* MOSTRAR TARJETAS ESPECIALES */
    const especiales = document.getElementById('tarjetasEspeciales');
    if (especiales) {
        especiales.style.display = '';
    }

    /* SELECT SECCION */
    const selectSeccion = document.getElementById('Seccion');
    if (!selectSeccion) {
        console.warn('No existe el select #Seccion');
        return;
    }
    /* LIMPIAR SELECT */
    selectSeccion.innerHTML = `<option value="" disabled selected> Seleccione sección </option>`;

    /* VALIDAR TIPO DE MONTACARGAS */
    if (!tipoMontacargas) {
        console.warn('No se recibió el tipo de montacargas');
        return;
    }
    /* OBTENER SECCIONES SEGÚN EL TIPO */
    const listaSecciones = window.secciones[tipoMontacargas];
    if (!listaSecciones) {
        console.warn('No existen secciones para el tipo:', tipoMontacargas);
        return;
    }
    /* CREAR OPCIONES */
    listaSecciones.forEach(seccion => {
        const option = document.createElement('option');
        option.value = seccion;
        option.textContent = seccion;
        selectSeccion.appendChild(option);
    });
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
    const fechaFormateada = formatearFecha(m.Fecha_Realizado);
 
    let botonAccion = '';
 
    if (contexto === 'supervisor') {
        // Solo lo ve el supervisor asignado
        const nombreSupervisor =
        (m.NombreSupervisor ?? '').replace(/'/g, "\\'");
        botonAccion = (window.ID_Sesion == m.ID_Supervisor)
            ? `
                <button type="button" class="btn btn-sm btn-dark" onclick="abrirModalFirma(${m.ID}, 'supervisor', ${m.ID_Supervisor}, '${nombreSupervisor}', '${m.TipoMontacargas}')">
                    <img width="20" height="20" src="https://img.icons8.com/sf-regular-filled/24/ffffff/autograph.png" alt="autograph"/>
                </button>
            `
            : '';

    } else if (contexto === 'operario') {
            const nombreOperario = m.ID_Recibe !== null && m.ID_Recibe !== '' && Number(m.ID_Recibe) > 0 ? (m.NombreRecibe ?? '') : (m.Nombre_Externo ?? '');
            const nombreOperarioSeguro = nombreOperario.replace(/'/g, "\\'");
            botonAccion = `
                <button type="button" class="btn btn-sm btn-warning" onclick="abrirModalFirma(${m.ID}, 'operario', ${m.ID_Recibe ?? 'null'}, '${nombreOperarioSeguro}','${m.TipoMontacargas}')">
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
                <button type="button"class="btn btn-sm btn-info" onclick="abrirModalFirma(${m.ID}, 'mecanico', ${mecanicoPendiente.ID_Mecanico}, '${nombreMecanico}', '${m.TipoMontacargas}')">
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
        <td>${fechaFormateada}</td>
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
            <a class="btn btn-sm btn-primary" target="_blank" href="VerMantenimientoCorrectivo?ID=${encodeURIComponent(m.ID)}">
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
        const campos = [m.NumeroM, m.MarcaM, m.ModeloM, m.SerieM, m.Centrot, m.Fecha_Realizado];
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

/* MODAL FALLA / CORRECCIÓN */
function abrirModalFallaCorreccion({ origen, novedad = null }) {
    const modalFalla = document.getElementById('modalFallaCorreccion');
    if (!modalFalla) {
        console.error('No existe el modal #modalFallaCorreccion');
        return;
    }
    window._origenModalFalla = origen;
    if (origen === 'novedad' && novedad) {
        window._novedadSeleccionada = novedad;
    } else {
        window._novedadSeleccionada = null;
    }
    /* NUEVA FALLA */
    window.Falla = [];
    window.Correcciones = [];
    /* Limpiar previews */

    const previewFalla = document.getElementById('imgPreviewFalla');
    const previewCorreccion = document.getElementById('imgPreviewCorreccion');
    if (previewFalla) {
        previewFalla.innerHTML = '';
    }
    if (previewCorreccion) {
        previewCorreccion.innerHTML = '';
    }

    /* Reiniciar contadores */
    const countFalla = document.getElementById('imgCountFalla');
    const countCorreccion = document.getElementById('imgCountCorreccion');
    if (countFalla) {
        countFalla.textContent = '0';
    }
    if (countCorreccion) {
        countCorreccion.textContent = '0';
    }

    /* Limpiar inputs de archivos */
    const inputFalla = document.getElementById('imgInputFalla');
    const inputCorreccion = document.getElementById('imgInputCorreccion');

    if (inputFalla) {
        inputFalla.value = '';
    }
    if (inputCorreccion) {
        inputCorreccion.value = '';
    }


    /* CAMPOS */

    const descripcionFalla = document.getElementById('descripcionFalla');
    const descripcionCorreccion = document.getElementById('descripcionCorreccion');
    const titulo = document.getElementById('modalFallaCorreccionLabel');

    if (origen === 'novedad' && novedad) {
        if (descripcionFalla) {
            descripcionFalla.value = novedad.txt || '';
        }
        if (titulo) {
            titulo.textContent = '🔧 Corregir Novedad';
        }
    } else {
        if (descripcionFalla) {
            descripcionFalla.value = '';
        }
        if (descripcionCorreccion) {
            descripcionCorreccion.value = '';
        }
        if (titulo) {
            titulo.textContent = '🔧 Registrar Falla y Corrección';
        }
    }

    /* ABRIR MODAL */

    let instanciaModalFalla = bootstrap.Modal.getInstance(modalFalla);

    if (!instanciaModalFalla) {
        instanciaModalFalla = new bootstrap.Modal(modalFalla);
    }
    instanciaModalFalla.show();
}

/* CREAR THUMB */
function crearThumb(src, slug, id = null) {
    const thumb = document.createElement('div');
    thumb.className = 'img-thumb position-relative';
    thumb.dataset.id = id ?? ''; thumb.style.cssText = 'width:64px;' + 'height:64px;' + 'border-radius:8px;' + 'overflow:hidden;' + 'border:1px solid #e8e8f0;' + 'flex-shrink:0;';
    thumb.innerHTML = `
        <img src="${src}" alt="img" style="width:100%;height:100%;object-fit:cover;cursor:pointer;" onclick="abrirLightbox('${src}')">
        <button type="button" onclick="eliminarThumb(this, '${slug}', ${id})"
            style=" position:absolute; top:2px; right:2px; background:rgba(0,0,0,.55); border:none; border-radius:50%; width:18px;
                height:18px; color:#fff; font-size:10px; line-height:1; cursor:pointer; display:flex; align-items:center; justify-content:center;">✕</button>`;
    return thumb;
}

/* PREVISUALIZAR IMÁGENES */
function previsualizarImagenes(input) {
    const slug = input.dataset.slug;
    let preview;
    let contador;
    let arrayImagenes;
    if (slug === 'falla') {
        preview = document.getElementById('imgPreviewFalla');
        contador = document.getElementById('imgCountFalla');
        arrayImagenes = window.FallaTemp;

    } else if (slug === 'correccion') {
        preview = document.getElementById('imgPreviewCorreccion');
        contador = document.getElementById('imgCountCorreccion');
        arrayImagenes = window.CorreccionesTemp;
    } else {
        console.error('Slug de imagen no válido:', slug);
        return;
    }
    if (!preview || !contador) {
        console.error(
            'No se encontró el contenedor de imágenes:',
            slug
        );
        return;
    }
    const archivos = Array.from(input.files);
    archivos.forEach((archivo) => {
        if (!archivo.type.startsWith('image/')) {
            return;
        }
        const reader = new FileReader();
        reader.onload = function (e) {
            const imagen = {
                id: Date.now() + Math.random(),
                file: archivo,
                src: e.target.result
            };

            arrayImagenes.push(imagen);
            const thumb = crearThumb(
                imagen.src,
                slug,
                imagen.id
            );
            /* Guardamos también el id en el thumb */
            thumb.dataset.id = imagen.id;
            preview.appendChild(thumb);
            actualizarContadorImagenes(slug);
        };
        reader.readAsDataURL(archivo);
    });
    input.value = '';
}

/* ELIMINAR IMAGEN */
function eliminarThumb(boton, slug, id) {
    let arrayImagenes;
    if (slug === 'falla') {
        arrayImagenes = window.FallaTemp;
    } else if (slug === 'correccion') {
        arrayImagenes = window.CorreccionesTemp;
    } else {
        return;
    }

    /* Eliminar del array */
    const posicion = arrayImagenes.findIndex(
        imagen => imagen.id === id
    );
    if (posicion !== -1) {
        arrayImagenes.splice(posicion, 1);
    }
    /* Eliminar visualmente el thumbnail */
    const thumb = boton.closest('.img-thumb');
    if (thumb) {
        thumb.remove();
    }

    /* Actualizar contador  */
    actualizarContadorImagenes(slug);
}
/* ACTUALIZAR CONTADOR */
function actualizarContadorImagenes(slug) {
    let contador;
    let cantidad;
    if (slug === 'falla') {
        contador = document.getElementById('imgCountFalla');
        cantidad = window.FallaTemp.length;
    } else if (slug === 'correccion') {
        contador = document.getElementById('imgCountCorreccion');
        cantidad = window.CorreccionesTemp.length;
    }
    if (contador) {
        contador.textContent = cantidad;
    }
}

/* LIGHTBOX */
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
function _lightboxEsc(e) {
    if (e.key === 'Escape') {
        cerrarLightbox();
    }
}

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

    /* ── CARGA DINÁMICA ── */
    let solicitudCentro = 0;
    window.cargarMontacargas = function () {
        const ID_Centro = document.getElementById('ID_Centro1').value;
        window.ID_Centro = ID_Centro || null;
        // Nueva solicitud
        solicitudCentro++;
        const solicitudActual = solicitudCentro;
        // Referencias
        const $montacargas = $('#ID_Montacargas');
        const $operario = $('#ID_Operario');
        const $operario1 = $('#ID_Operario1');
        const $area = $('#ID_Area');

        // LIMPIAR INMEDIATAMENTE LOS SELECTS
        $montacargas.empty().append('<option value="" disabled selected>Seleccione montacargas</option>');
        $operario.empty().append('<option value="" disabled selected>Seleccione operario</option>');
        $operario1.empty().append('<option value="" disabled selected>Seleccione operario</option>');
        $area.empty().append('<option value="" disabled selected>Seleccione área</option>');

        // Si no hay centro, terminamos
        if (!ID_Centro) {
            return;
        }
        // MONTACARGAS
        $.get(`TraerMontacargas?ID_Centro=${encodeURIComponent(ID_Centro)}`, function(data) {
            // Si esta respuesta pertenece a un centro anterior,
            // NO hacemos nada.
            if (solicitudActual !== solicitudCentro) {
                return;
            }
            try {
                const lista = Array.isArray(data) ? data : JSON.parse(data);
                lista.forEach(m => {
                    $montacargas.append(`
                        <option value="${m.ID}" data-modelo="${m.Modelo}" data-voltaje="${m.Voltaje}"
                            data-horometro="${m.Horometro}"
                            data-longitudh="${m.Horquillas}">
                            ${m.Numero} — ${m.Serie}
                        </option>`
                    );
                });
            } catch(e) {
                console.error('Montacargas:', e);
            }
        }).fail(function(xhr) {
            if (solicitudActual !== solicitudCentro) {
                return;
            }
            console.error('Error cargando montacargas:', xhr.status, xhr.responseText);
        });
        // OPERARIOS
        $.get(`TraerOperarios?ID_Centro=${encodeURIComponent(ID_Centro)}`, function(data) {
            if (solicitudActual !== solicitudCentro) {
                return;
            }
            try {
                const lista = Array.isArray(data) ? data : JSON.parse(data);
                lista.forEach(o => {
                    const opcion = `<option value="${o.ID}"> ${o.NombreCompleto} </option>`;
                    $operario.append(opcion);
                    $operario1.append(opcion);
                });
            } catch(e) {
                console.error('Operarios:', e);
            }
        }).fail(function(xhr) {
            if (solicitudActual !== solicitudCentro) {
                return;
            }
            console.error('Error cargando operarios:', xhr.status, xhr.responseText);
        });
        //  ÁREAS
        $.get(`TraerAreas?ID_Centro=${encodeURIComponent(ID_Centro)}`, function(data) {
            if (solicitudActual !== solicitudCentro) {
                return;
            }
            try {
                const lista = Array.isArray(data)? data : JSON.parse(data);
                lista.forEach(a => {
                    $area.append(`<option value="${a.ID}"> ${a.Nombre} </option>`);
                });
            } catch(e) {
                console.error('Áreas:', e);
            }

        }).fail(function(xhr) {
            if (solicitudActual !== solicitudCentro) {
                return;
            }
            console.error('Error cargando áreas:', xhr.status,  xhr.responseText);
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
        fetch('CrearMantenimientoCorrectivo', { method: 'POST', body: formData })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    window.ID_Mantenimiento = data.ID_Mantenimiento;  
                    window.ID_Montacargas = data.ID_Montacargas;
                    window.ID_Centro = data.ID_Centro;
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

                        if (data.Novedades && Array.isArray(data.Novedades)) {
                            data.Novedades.forEach((novedad) => {
                                window._novedadesTemp.push({
                                    id: parseInt(novedad.ID),
                                    txt: (novedad.Descripcion || '').trim(),
                                    estado: (novedad.Estado_Novedad || '').trim(),
                                    enBD: true
                                });
                            });
                        }

                        // Renderizar novedades adicionales
                        renderTablaNovedades();
                        actualizarContadorNovedades();
                        // Renderizar tecnicos adicionales
                        renderPanelTecnicos();
                    }        
                    const modalEl1 = document.getElementById('NumerDocumentoModal');
                    bootstrap.Modal.getInstance(modalEl1).hide();

                    modalEl1.addEventListener('hidden.bs.modal', function handler() {
                        this.removeEventListener('hidden.bs.modal', handler);
                        const selClase = document.getElementById('tipoMontacargas');
                        document.getElementById('subtituloModal').textContent =`${selClase.options[selClase.selectedIndex]?.text || ''}`;
                        const tipoMont = selClase.value;
                        cargarCriterios(tipoMont);
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
        fetch('VerificarBorradorCorrectivo')
            .then(res => res.json())
            .then(data => {
                if (data.existe) {
                    window._borradorPendienteID = data.ID_Mantenimiento;
                    new bootstrap.Modal(document.getElementById('modalBorradorCorrectivo')).show();
                } else if (!autoArranque) {
                    new bootstrap.Modal(document.getElementById('NumerDocumentoModal')).show();
                }
            })
            .catch(() => { if (!autoArranque) new bootstrap.Modal(document.getElementById('NumerDocumentoModal')).show(); });
    }

    document.getElementById('btnCorrectivo').addEventListener('click', function () {
        verificarBorrador(false);
    });

    // Al recargar la página: si hay un mantenimiento en estado BORRADOR, avisar automáticamente
    verificarBorrador(true);

    /* ── Botones del modal de borrador ── */
    document.getElementById('btnContinuarBorrador')?.addEventListener('click', function () {
        const id = window._borradorPendienteID;
        bootstrap.Modal.getInstance(document.getElementById('modalBorradorCorrectivo'))?.hide();
        if (!id) return;
        fetch(`ObtenerDetallesCorrectivo?ID_Mantenimiento=${id}`)
            .then(res => res.json())
            .then(detalle => {
                if (detalle.success) {
                    LlenarModalMantenimiento(detalle);
                    // Cerrar el modal del borrador correctivo
                    const modalBorrador = document.getElementById('modalBorradorCorrectivo');   
                    bootstrap.Modal.getInstance(modalBorrador)?.hide();
                    // Abrir el modal del número de documento
                    const modalDocumento = document.getElementById('agregarMantenimiento');
                    const instanciaDocumento = bootstrap.Modal.getInstance(modalDocumento) || new bootstrap.Modal(modalDocumento);
                    instanciaDocumento.show();
                    // Limpiar el ID del borrador
                    window._borradorPendienteID = null;
                } else {
                    alert('No se pudieron cargar los detalles. Intente nuevamente.');
                }
            })
        .catch(() => alert('Error de conexión al cargar el borrador.'));
    });

    document.getElementById('btnRechazarBorrador')?.addEventListener('click', function () {
        const id = window._borradorPendienteID;
        if (!id) return;
        fetch('EliminarBorradorCorrectivo', {
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
                // Cerrar el modal del borrador correctivo
                const modalBorrador = document.getElementById('modalBorradorCorrectivo');
                bootstrap.Modal.getInstance(modalBorrador)?.hide();
                // Abrir el modal del número de documento
                const modalDocumento = document.getElementById('NumerDocumentoModal');
                const instanciaDocumento = bootstrap.Modal.getInstance(modalDocumento) || new bootstrap.Modal(modalDocumento);
                instanciaDocumento.show();
                // Limpiar el ID del borrador
                window._borradorPendienteID = null;
            } else {
                alert(detalle.message || 'No se pudo eliminar el mantenimiento.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error de conexión al eliminar el borrador.');
        });
    });

    /* ── Accesibilidad teclado btnCorrectivo ── */
    document.getElementById('btnCorrectivo').addEventListener('keydown', function(e) {
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
            estado: 'Pendiente',
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
            fetch(window.baseUrl + 'Mantenimiento/EliminarNovedadCorrectivo', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({ID_Novedad: novedad.id,})
            })
            .then(r => r.json())
            .then(resp => {
                if (resp.success) {
                    window._novedades = (window._novedades || []) .filter(n => n.id != novedad.id);
                    window._novedadesTemp = (window._novedadesTemp || []) .filter(n => n.id != novedad.id);
                    renderTablaNovedades();
                    actualizarContadorNovedades();
                } else {
                    alert(resp.message || 'Error al eliminar la novedad');
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
        // Solo mostrar novedades con estado Pendiente
        const novedadesPendientes = window._novedadesTemp.filter(item => item.estado === 'Pendiente');
        if (novedadesPendientes.length === 0) {
            vacia.style.display = '';
        } else {
            vacia.style.display = 'none';
            novedadesPendientes.forEach((item, i) => {
                const tr = document.createElement('tr');
                tr.className = 'nov-row';
                tr.innerHTML = `
                    <td style="font-size:.78rem;color:#6c757d;padding:.5rem .75rem;"> ${i + 1}</td>
                    <td style="font-size:.83rem;padding:.5rem .75rem;">${item.txt}</td>
                    <td class="text-center" style="padding:.5rem .75rem;">
                        <button type="button" onclick="corregirNovedad(${i})"
                            style="background:#fff3cd;border:none;border-radius:6px; color:#856404;font-size:.75rem;padding:3px 8px; cursor:pointer;"> 🔧 Corregir Novedad
                        </button>
                    </td>
                    <td class="text-center" style="padding:.5rem .75rem;">
                        <button type="button" onclick="eliminarNovedad(${i})"
                            style="background:#f8d7da;border:none;border-radius:6px; color:#842029;font-size:.75rem;padding:3px 8px; cursor:pointer;"> ✕ Eliminar
                        </button>
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
        document.getElementById('btnGuardarNovedades') ?.addEventListener('click', function() {window.guardarNovedades(); });
        document.getElementById('btnVolverNovedades') ?.addEventListener('click', () => bootstrap.Modal.getInstance(modalNov)?.hide());
        modalNov.addEventListener('hidden.bs.modal', function () {
            /* SI SE VA A CORREGIR UNA NOVEDAD */
            if (window._origenModalFalla === 'novedad' && window._novedadSeleccionada) {
                const novedad = window._novedadSeleccionada;
                abrirModalFallaCorreccion({
                    origen: 'novedad',
                    novedad: novedad
                });
                return;
            }
            /* CIERRE NORMAL → VOLVER A MODAL 2 */
            const m2el = document.getElementById('agregarMantenimiento');
            let m2 = bootstrap.Modal.getInstance(m2el);
            if (!m2) {
                m2 = new bootstrap.Modal(m2el);
            }
            m2.show();
        });
    }

    /* ═══════════════ Observaciones ═════════ */   
    let contadorObservaciones1 = 0;
    let contadorObservaciones2 = 0;
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

    window.agregarObservaciones = function () {
        const txt = document.getElementById('textoObservaciones').value.trim();
        if (!txt) return;

        window._observacionesTemp.push({
            txt,
            enBD: false
        })
        document.getElementById('textoObservaciones').value = '';
        renderTablaObservaciones();
        actualizarContadorObservaciones();
    };

    //Eliminar novedad (temporal o en BD)
    window.eliminarObservaciones = function (index) {
        const observacionesTemp = window._observacionesTemp || [];
        const observacion = observacionesTemp[index];
        if (!observacion) {
            console.warn('No se encontró la observación en el índice:', index);
            return;
        }

        // Si todavía no está guardada, eliminarla solo del arreglo temporal
        if (!observacion.enBD) {
            observacionesTemp.splice(index, 1);
            renderTablaObservaciones();
            actualizarContadorObservaciones();
            return;
        }

        // Si ya está guardada, solicitar su eliminación en la base de datos
        fetch(`${window.baseUrl}Mantenimiento/EliminarObservaciones`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                ID_Mantenimiento: window.ID_Mantenimiento,
                indice: index
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`Error HTTP ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                observacionesTemp.splice(index, 1);

                window._observacionesTemp = observacionesTemp;
                window.observaciones = observacionesTemp.map(item => ({ ...item }));

                renderTablaObservaciones();
                actualizarContadorObservaciones();
            } else {
                alert(data.message || 'Error al eliminar la observación');
            }
        })
        .catch(error => {
            console.error('Error al eliminar la observación:', error);
            alert('Error al eliminar la observación');
        });
    };

    //Guardar novedades (solo las nuevas)
    window.guardarObservaciones = function () {
        const observacionesTemp = window._observacionesTemp || [];
        // Obtener únicamente los textos
        const textosObservaciones = observacionesTemp.map(item => item.txt.trim()).filter(txt => txt !== '');
        fetch(`${window.baseUrl}Mantenimiento/GuardarObservaciones`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                Observaciones: textosObservaciones,
                ID_Mantenimiento: window.ID_Mantenimiento
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`Error HTTP ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Marcar todas las observaciones como guardadas
                window._observacionesTemp = observacionesTemp.map(item => ({...item, enBD: true}));
                window.observaciones = window._observacionesTemp.map(item => ({...item}));
                actualizarContadorObservaciones();
                bootstrap.Modal.getInstance(document.getElementById('modalObservaciones'))?.hide();
            } else {
                alert(data.message || 'Error al guardar las observaciones');
            }
        })
        .catch(error => {
            console.error('Error al guardar las observaciones:', error);
            alert('Error al guardar las observaciones');
        });
    };

    function renderTablaObservaciones() {
        const tbody = document.getElementById('bodyObservaciones');
        const vacia = document.getElementById('filaVaciaObservaciones');

        if (!tbody || !vacia) {
            console.warn('No se encontraron los elementos de la tabla de observaciones.');
            return;
        }
        // Eliminar las filas generadas anteriormente
        tbody.querySelectorAll('tr.nov-row').forEach(r => r.remove());
        // Obtener las observaciones
        const observaciones = window._observacionesTemp || [];
        // Mostrar mensaje si no hay observaciones
        if (observaciones.length === 0) {
            vacia.style.display = '';
            return;
        }
        vacia.style.display = 'none';
        // Crear una fila por cada observación
        observaciones.forEach((item, i) => {
            const tr = document.createElement('tr');
            tr.className = 'nov-row';
            tr.innerHTML = `
                <td style="font-size:.78rem;color:#6c757d;padding:.5rem .75rem;">${i + 1}</td>
                <td style="font-size:.83rem;padding:.5rem .75rem;">${item.txt}</td>
                <td class="text-center" style="padding:.5rem .75rem;">
                    <button type="button" onclick="eliminarObservaciones(${i})" style="background:#f8d7da;border:none;border-radius:6px;color:#842029;font-size:.75rem;padding:3px 8px;cursor:pointer;">✕ Eliminar</button>
                </td>`;

            tbody.appendChild(tr);
        });
    }

    function actualizarContadorObservaciones() {
        const contadorObservaciones = document.getElementById('contadorObservaciones');
        const subObservaciones = document.getElementById('subObservaciones');

        // Actualiza el span pequeño
        if (contadorObservaciones) {
            const contadorObservaciones1 = window._observacionesTemp.length;
            const textoN = `${contadorObservaciones1} Observacion${contadorObservaciones1 !== 1 ? 'es' : ''}`;
            contadorObservaciones.textContent = textoN;
        }

        // Actualiza el div grande
        if (subObservaciones) {
            const contadorObservaciones2 = window.observaciones.length;
            const textoN1 = `${contadorObservaciones2} Observacion${contadorObservaciones2 !== 1 ? 'es' : ''}`;
            subObservaciones.textContent = textoN1;
        }
    }

    /* ── Botones Modal 4: Novedades ── */
    const modalObs = document.getElementById('modalObservaciones');
    if (modalObs) {
        document.getElementById('btnGuardarObservaciones') ?.addEventListener('click', function() {window.guardarObservaciones(); });
        document.getElementById('btnVolverObservaciones') ?.addEventListener('click', () => bootstrap.Modal.getInstance(modalObs)?.hide());
        modalObs.addEventListener('hidden.bs.modal', function () {
            /* CIERRE NORMAL → VOLVER A MODAL 2 */
            const m2el = document.getElementById('agregarMantenimiento');
            let m2 = bootstrap.Modal.getInstance(m2el);
            if (!m2) {
                m2 = new bootstrap.Modal(m2el);
            }
            m2.show();
        });
    }

    /* ═══════════════ INSUMOS MANTENIMIENTO  ═════════ */
    /*--Funciones para agregar, eliminar, renderizar la tabla de insumos --*/
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
                                fetch(`${baseUrl}OrdenesTrabajo/BuscarInsumosConStock?q=${encodeURIComponent(query)}&ID_Centro=${encodeURIComponent(window.ID_Centro || '')}`)
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
                </td>`;
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
        const fuente = (window._insumosTemp && window._insumosTemp.length) ? window._insumosTemp : (window._insumos || []);
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
                bootstrap.Modal.getInstance(document.getElementById('modalInsumos'))?.hide();
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
    /* ═══════════════ Repuestos MANTENIMIENTO  ═════════ */
    /*--Funciones para agregar, eliminar, renderizar la tabla de repuestos --*/
    let tomSelectInstance1 = null;
    let contadorRepuestos = 0;
    let contadorRepuestos1 = 0;
    window.abrirRepuestos = function () {
        const m2el = document.getElementById('agregarMantenimiento');
        const m2 = bootstrap.Modal.getInstance(m2el);
        if (m2) m2.hide();

        m2el.addEventListener('hidden.bs.modal', function handler() {
            m2el.removeEventListener('hidden.bs.modal', handler);
            
            window._RepuestosTemp = window.Repuestos.map(i => ({ ...i, enBD: true}));
            renderTablaRepuestos();
            // Inicializar TomSelect solo si no existe
            setTimeout(() => {
                if (!tomSelectInstance1) {
                    const selectElement = document.getElementById('select-para1');
                    if (selectElement) {
                        tomSelectInstance1 = new TomSelect(selectElement, {
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
                                        // Los repuestos retirados pueden ser el mismo producto
                                        // que se instaló. Mostrar todo el catálogo sin filtrar por
                                        // stock ni por la lista de insumos utilizados.
                                        callback(Array.isArray(data) ? data : []);
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
            new bootstrap.Modal(document.getElementById('modalRepuestos')).show();
        });
    };
    function renderTablaRepuestos() {
        const tbody = document.querySelector('#tablaSolicitud1 tbody');
        if (!tbody) return;
        tbody.innerHTML = '';

        window._RepuestosTemp.forEach((repuesto, index) => {
            const tr = document.createElement('tr');

            tr.innerHTML = `
                <td>${index+1}</td>
                <td>${repuesto.codigo}</td>
                <td>${repuesto.cantidad}</td>
                <td>${repuesto.medida}</td>
                <td>${repuesto.nombre}</td>
                <td>${repuesto.descripcion}</td>
                <td>
                    <button type="button" onclick="eliminarRepuestos(${repuesto.id})"class="btn btn-danger btn-sm">X</button>
                </td>`;
            tbody.appendChild(tr);

        });
    }
    window.agregarFila1 = function() {
        
        const cantidad1 = document.getElementById('cantidad1').value;
        const medida1 = document.getElementById('tipoMedida1').value;
        const selectElement1 = document.getElementById('select-para1');
        const descripcion = document.getElementById('descripcion').value;     
        // Obtener valor y datos de TomSelect
        let idInsumo1 = null;
        let data1 = null;
        
        if (tomSelectInstance1) {
            idInsumo1 = tomSelectInstance1.getValue();
            if (idInsumo1) {
                data1 = tomSelectInstance1.options[idInsumo1];
            }
        }

        // Validaciones básicas
        if (!cantidad1 || cantidad1 <= 0) return alert("Ingrese una cantidad válida");
        if (!medida1) return alert("Seleccione una medida");
        if (!idInsumo1) return alert("Seleccione un insumo");
        if (!data1) return alert("Datos de insumo no disponibles");
        if (!descripcion) return alert("Ingrese la descripcion de la falla");

        window._RepuestosTemp.push({
            id: idInsumo1,
            nombre: data1.nombre,
            codigo: data1.codigo,
            cantidad: cantidad1,
            medida: medida1,
            descripcion,
            enBD: false
        })

        renderTablaRepuestos();
        actualizarContadorRepuestos();

        // Limpiar campos correctamente
        document.getElementById('cantidad1').value = '';
        document.getElementById('descripcion').value = '';
        // Resetear select (tipoMedida)
        const selectMedida1 = document.getElementById('tipoMedida1');
        if (selectMedida1) {
            selectMedida1.selectedIndex = 0; 
        }

        // Limpiar TomSelect correctamente
        if (tomSelectInstance1) {
            tomSelectInstance1.clear();
            tomSelectInstance1.setValue(null);
            tomSelectInstance1.clearOptions(); 
        }
        document.getElementById('cantidad1').focus();
    };
    window.eliminarRepuestos = function(id) {
        const fuente1 = (window._RepuestosTemp && window._RepuestosTemp.length) ? window._RepuestosTemp : (window._Repuestos || []);
        const insumo1 = fuente1.find(i => i.id == id);
        if (!insumo1) return;
        if (insumo1.enBD) {
            fetch(window.baseUrl + 'Mantenimiento/EliminarRepuestos', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ 
                    ID_Mantenimiento: window.ID_Mantenimiento,
                    ID_Repuesto: id,
                    Tipo_Mantenimiento: window.Mantenimiento
                })
            })
            .then(r => r.json())
            .then(resp => {
                if (resp.success) {
                    // 🔥 eliminar de ambos estados SI existen
                    window.Repuestos = (window.Repuestos || []).filter(i => i.id != id);
                    window._RepuestosTemp = (window._RepuestosTemp || []).filter(i => i.id != id);
                    renderTablaRepuestos();
                    actualizarContadorRepuestos();
                } else {
                    alert(resp.message || 'Error al eliminar repuesto');
                }
            })
            .catch(err => {
                console.error("ERROR FETCH:", err);
                alert("Error en la petición");
            });

        } else {
            // 🔥 solo temporal
            window._RepuestosTemp = (window._RepuestosTemp || []).filter(i => i.id != id);
            renderTablaRepuestos();
            actualizarContadorRepuestos();
        }
    }; 
    // Función para guardar los repuestos (enviar al controlador)
    window.guardarRepuestos = function() {
        const actuales1 = new Set((window.Repuestos || []).map(i => String(i.id)));
        const nuevos1 = (window._RepuestosTemp || [])
            .filter(i => !actuales1.has(String(i.id)))
            .map(i => ({
                id: i.id,
                cantidad: i.cantidad ?? i.cantidad1,
                medida: i.medida ?? i.medida1,
                descripcion: i.descripcion
            }));
        if (nuevos1.length === 0) {
            bootstrap.Modal.getInstance(document.getElementById('modalRepuestos'))?.hide();
            return;
        }
        
        // Aquí enviar los insumos al controlador usando fetch o AJAX
        fetch(`${window.baseUrl}Mantenimiento/GuardarRepuestos`,{
            method: 'POST',
            headers: {'Content-Type': 'application/json'}, 
            body: JSON.stringify({
                Repuestos: nuevos1,
                ID_Montacargas: window.ID_Montacargas,
                ID_Mantenimiento: window.ID_Mantenimiento,
                Tipo_Mantenimiento: window.Mantenimiento
            })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success){
                // 🔥 CLAVE: sincronizar estado
                window.Repuestos = window._RepuestosTemp.map(i => ({ ...i, enBD: true }));
                actualizarContadorRepuestos();
                alert('Repuestos guardados correctamente');
                bootstrap.Modal.getInstance(document.getElementById('modalRepuestos'))?.hide();
            } else {
                alert('Error al guardar repuestos: ' + data.message);
            }
        })
        .catch(() => alert('Error al guardar repuestos'));
    };
    function actualizarContadorRepuestos() {
        const repuestosElement = document.getElementById('contadorRepuestos');
        const subRepuestosElement = document.getElementById('subRepuestos');

        // Actualiza el span pequeño
        if (repuestosElement) {
            const contadorRepuestos = window._RepuestosTemp.length;
            const texto2 = `${contadorRepuestos} repuestos${contadorRepuestos !== 1 ? 's' : ''}`;
            repuestosElement.textContent = texto2;
        }

        // Actualiza el div grande
        if (subRepuestosElement) {
            const contadorRepuestos1 = window.Repuestos.length;
            const texto3 = `${contadorRepuestos1} repuestos${contadorRepuestos1 !== 1 ? 's' : ''}`;
            subRepuestosElement.textContent = texto3;
        }
    }
    /*-- Botones Modal 6: Insumos --*/
    const modalRepuestos = document.getElementById('modalRepuestos');
    if (modalRepuestos) {
        document.getElementById('btnGuardarRepuestos')
            ?.addEventListener('click', function() { window.guardarRepuestos(); });
        document.getElementById('btnVolverRepuestos')
            ?.addEventListener('click', () => bootstrap.Modal.getInstance(modalRepuestos)?.hide());
        modalRepuestos.addEventListener('hidden.bs.modal', function () {
            const m2el = document.getElementById('agregarMantenimiento');
            if (!m2el.classList.contains('show')) new bootstrap.Modal(m2el).show();
        });
    }
    // funciones tecnicos
    // guardar, eliminar en bases de datos de tecnicos
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

            fetch(window.baseUrl + 'Mantenimiento/EliminarTecnicoCorrectivo', {
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

        fetch(window.baseUrl + 'Mantenimiento/GuardarTecnicosCorrectivos', {
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
        window._TecnicosTemp = []; 
        renderPanelTecnicos();
        const m2el = document.getElementById('agregarMantenimiento');
        if (!m2el.classList.contains('show')) new bootstrap.Modal(m2el).show();
    });
    //--- agregar falla o correcciones 
    document.getElementById('btnAgregarFalla') ?.addEventListener('click', function () {
        const modal2 = document.getElementById('agregarMantenimiento');
        if (!modal2) {
            return;
        }
        /* Indicar que el Modal 11 viene directamente del Modal 2. */
        window._origenModalFalla = 'modal2';
        window._novedadSeleccionada = null;
        const instanciaModal2 = bootstrap.Modal.getInstance(modal2);
        if (instanciaModal2) {
            modal2.addEventListener('hidden.bs.modal',function handler() {
                modal2.removeEventListener('hidden.bs.modal', handler);
                    abrirModalFallaCorreccion({origen: 'modal2'});
                }
            );
            instanciaModal2.hide();
        } else {
            abrirModalFallaCorreccion({origen: 'modal2'});
        }
    });
    window.corregirNovedad = function(index) {
        const novedades = window._novedadesTemp || [];
        const novedad = novedades[index];
        if (!novedad) {
            console.warn('No se encontró la novedad:', index);
            return;
        }
        window._origenModalFalla = 'novedad';
        window._novedadSeleccionada = {
            index: index,
            id: novedad.id ?? null,
            txt: novedad.txt ?? ''
        };
        const modalNovedades = document.getElementById( 'modalNovedades');
        if (!modalNovedades) {
            return;
        }
        const instanciaNovedades = bootstrap.Modal.getInstance(modalNovedades);
        if (instanciaNovedades) {
            instanciaNovedades.hide();
        } else {
            abrirModalFallaCorreccion({
                origen: 'novedad',
                novedad: window._novedadSeleccionada
            });
        }
    };
    document.getElementById('modalFallaCorreccion') ?.addEventListener('hidden.bs.modal', function () {
        const modal2 = document.getElementById('agregarMantenimiento');
        if (!modal2) {
            console.error('No existe el modal #agregarMantenimiento');
            return;
        }
        let instanciaModal2 = bootstrap.Modal.getInstance(modal2);
        if (!instanciaModal2) {
            instanciaModal2 = new bootstrap.Modal(modal2);
        }
        instanciaModal2.show();
    });

    //Guardar detalle de la falla o corrección
    document.getElementById('btnGuardarFallaCorreccion') ?.addEventListener('click', function () { window.guardarDetalle();});
    window.guardarDetalle = function() {
        const descripcionFalla = document.getElementById('descripcionFalla').value.trim();
        const descripcionCorreccion = document.getElementById('descripcionCorreccion').value.trim();
        const seccion = document.getElementById('Seccion').value.trim();
        const ID_Novedad = window._novedadSeleccionada?.id ?? null;

        /* VALIDACIONES */
        if (!descripcionFalla) {
            alert('Ingrese la descripción de la falla.');
            return;
        }
        if (!descripcionCorreccion) {
            alert('Ingrese la descripción de la corrección.');
            return;
        }
        if (!seccion) {
            alert('Ingrese la sección.');
            return;
        }
        if (!window.FallaTemp || window.FallaTemp.length === 0) {
            alert('Coloque al menos una imagen de la falla.');
            return;
        }
        if (!window.CorreccionesTemp || window.CorreccionesTemp.length === 0) {
            alert('Coloque al menos una imagen de la corrección.');
            return;
        }
        /* CREAR FORMDATA */
        const formData = new FormData();
        /* DATOS DEL DETALLE */
        formData.append('ID_Mantenimiento', window.ID_Mantenimiento);
        formData.append('DescripcionFalla', descripcionFalla);
        formData.append('DescripcionCorreccion', descripcionCorreccion);
        formData.append('Seccion', seccion);
        formData.append( 'ID_Novedad', ID_Novedad ?? '');
        /*  IMÁGENES DE FALLA */
        window.FallaTemp.forEach((imagen) => {
            if (imagen.file) {
                formData.append('Falla[]', imagen.file);
            }
        });
        /* IMÁGENES DE CORRECCIÓN */
        window.CorreccionesTemp.forEach((imagen) => {
            if (imagen.file) {
                formData.append('Correcciones[]', imagen.file);
            }
        });
        /* ENVIAR */
        fetch(`${window.baseUrl}Mantenimiento/GuardarDetalleCorrectivos`, {
            method: 'POST',
            body: formData
        }).then(r => {
            if (!r.ok) {throw new Error(`Error HTTP ${r.status}`);}
            return r.json();
        }).then(data => {
            if (data.success) {
                /* ACTUALIZAR ESTADO DE LA NOVEDAD */
                if (window._novedadSeleccionada) {
                    const idNovedad = window._novedadSeleccionada.id;
                    const novedad = window._novedadesTemp.find(item => item.id == idNovedad);
                    if (novedad) {
                        novedad.estado = 'Realizado';
                    }
                }
                /* LIMPIAR ARRAYS TEMPORALES */
                window.FallaTemp = [];
                window.CorreccionesTemp = [];
                /* LIMPIAR INPUTS DE IMÁGENES */
                const inputFalla = document.getElementById('imgInputFalla');
                const inputCorreccion = document.getElementById('imgInputCorreccion');
                if (inputFalla) {
                    inputFalla.value = '';
                }
                if (inputCorreccion) {
                    inputCorreccion.value = '';
                }
                /* LIMPIAR PREVISUALIZACIONES DE IMÁGENES */
                const previewFalla = document.getElementById('imgPreviewFalla');
                const previewCorreccion = document.getElementById('imgPreviewCorreccion');
                if (previewFalla) {
                    previewFalla.innerHTML = '';
                }
                if (previewCorreccion) {
                    previewCorreccion.innerHTML = '';
                }
                /* REINICIAR CONTADORES */
                const countFalla = document.getElementById('imgCountFalla');
                const countCorreccion = document.getElementById('imgCountCorreccion');
                if (countFalla) {
                    countFalla.textContent = '0';
                }
                if (countCorreccion) {
                    countCorreccion.textContent = '0';
                }
                /*  LIMPIAR CAMPOS DE TEXTO */
                const descripcionFalla = document.getElementById('descripcionFalla');
                const descripcionCorreccion = document.getElementById('descripcionCorreccion');
                if (descripcionFalla) {
                    descripcionFalla.value = '';
                }
                if (descripcionCorreccion) {
                    descripcionCorreccion.value = '';
                }
                /* LIMPIAR SECCIÓN */
                const seccion = document.getElementById('Seccion');
                if (seccion) {
                    seccion.value = '';
                }

                /* CERRAR MODAL 11 */
                const modalFallaCorreccion = document.getElementById('modalFallaCorreccion');
                if (modalFallaCorreccion) {
                    const modalInstance =bootstrap.Modal.getInstance(modalFallaCorreccion);
                    if (modalInstance) {
                        modalInstance.hide();
                    }
                }

                /* ACTUALIZAR TABLAS */
                renderTablaNovedades();
                actualizarContadorNovedades();
                renderTablaCorrecciones();
            }else {
                alert(
                    'Error al guardar detalles correctivos: ' +
                    data.message
                );
            }
        })
        .catch(error => {
            console.error('Error al guardar los detalles correctivos:',error);
            alert('Error al guardar detalles correctivos');
        });
    };

    function renderTablaCorrecciones() {
        fetch(`${window.baseUrl}Mantenimiento/TraerDetallesCorrectivos`, {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({
                ID_Mantenimiento: window.ID_Mantenimiento,
            })
        }).then(r => r.json())
        .then(data => {
            if (data.success) {
                const detalles = data.detalles || [];
                const imagenes = data.imagenes || [];

                window.Detalles = detalles;
                window.Imagenes = imagenes;

                /* Llenar tabla de fallas */
                const TablaFallas = document.getElementById('bodyFallos');
                if (TablaFallas) {
                    TablaFallas.innerHTML = '';
                    detalles.forEach(detalle=>{
                        const fila =  document.createElement('tr');
                        fila.innerHTML = `
                            <td>DT${detalle.ID ?? ''}</td>
                            <td>${detalle.Seccion ?? ''}</td>
                            <td>${detalle.Descripcion_Falla ?? ''}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary" onclick="editarDetalleCorrectivo(${detalle.ID}, 'falla')">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger" onclick="eliminarDetalleCorrectivo(${detalle.ID}, ${detalle.ID_Detalle})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>`;
                        TablaFallas.appendChild(fila);
                    });
                }
                /* Llenar tabla de correcciones */
                const TablaCorrecciones = document.getElementById('bodyCorrecciones');
                if (TablaCorrecciones) {
                    TablaCorrecciones.innerHTML = '';
                    detalles.forEach(detalle=>{
                        const fila =  document.createElement('tr');
                        fila.innerHTML = `
                            <td>DT${detalle.ID ?? ''}</td>
                            <td>${detalle.Seccion ?? ''}</td>
                            <td>${detalle.Reparacion_Realizada ?? ''}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary" onclick="editarDetalleCorrectivo(${detalle.ID}, 'reparacion')">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger" onclick="eliminarDetalleCorrectivo(${detalle.ID}, ${detalle.ID_Detalle})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>`;
                        TablaCorrecciones.appendChild(fila);   
                    });
                }
            } else {
                alert('Error al traer detalles correctivos: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error al traer detalles correctivos:',error);
            alert('Error al traer detalles correctivos');
        });
    }
    /* Funciones para modificar y eliminar los detalles */
    window.eliminarDetalleCorrectivo = function(ID, ID_Detalle) {
        fetch(`${window.baseUrl}Mantenimiento/EliminarDetalle`, {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({
                ID_Detalle: ID,
                ID_Novedad: ID_Detalle,
            })
        }).then(r => r.json())
        .then(resp => {
            if (resp.success) {
                if (ID_Detalle) {
                    const idNovedad = ID_Detalle;
                    const novedad = window._novedadesTemp.find(item => item.id == idNovedad);
                    if (novedad) {
                        novedad.estado = 'Pendiente';
                    }
                }
                renderTablaNovedades();
                actualizarContadorNovedades();
                renderTablaCorrecciones();
            } else {
                alert(resp.message || 'Error al eliminar el detalle');
            }
        }).catch(err => {
            console.error("ERROR FETCH:", err);
            alert("Error en la petición");
        });
    }
    window.editarDetalleCorrectivo = function (ID_Detalle, categoria) {
        // BUSCAR DETALLE
        const detalle = (window.Detalles || []).find(item => Number(item.ID) === Number(ID_Detalle));
        if (!detalle) {
            alert('No se encontró la información del detalle');
            return;
        }
        // BUSCAR IMÁGENES
        const categoriaNormalizada = String(categoria || '').toLowerCase();
        const imagenes = (window.Imagenes || []).filter(imagen => Number(imagen.ID_Detalle) === Number(ID_Detalle) && String(imagen.Categoria || '').toLowerCase() === categoriaNormalizada);
        // MARCAR LAS IMÁGENES EXISTENTES DE LA BASE DE DATOS
        imagenes.forEach(imagen => {
            imagen.enBD = true;
            if (imagen.eliminada === undefined) {
                imagen.eliminada = false;
            }
        });
        
        // OBTENER MODAL 12
        const modal = document.getElementById('modalEditarDetalle');
        if (!modal) {
            console.error('No existe el modal #modalEditarDetalle');
            return;
        }
        // GUARDAR ID Y CATEGORÍA
        const inputID = document.getElementById('editarIDDetalle');
        const inputCategoria = document.getElementById('editarCategoria');
        if (inputID) {
            inputID.value = ID_Detalle;
        }
        if (inputCategoria) {
            inputCategoria.value = categoria;
        }
        // TÍTULO
        const titulo = document.getElementById('modalEditarDetalleLabel');
        if (titulo) {
            if (categoriaNormalizada === 'falla') {
                titulo.innerHTML = '🔧 Editar Falla';
            } else {
                titulo.innerHTML = '🔧 Editar Corrección';
            }
        }
        // LABEL
        const label = document.getElementById('editarLabelDescripcion');
        if (label) {
            if (categoriaNormalizada === 'falla') {
                label.innerHTML = 'Descripción de la Falla';
            } else {
                label.innerHTML = 'Descripción de la Corrección';
            }
        }
        // CARGAR SECCIÓN
        cargarSeccionesModal12(window.Tipo_Montacargas, detalle.Seccion || '');

        // CARGAR DESCRIPCIÓN
        const textarea = document.getElementById( 'editarDescripcionDetalle');
        if (!textarea) {
            console.error('No existe #editarDescripcionDetalle');
            return;
        }
        if (categoriaNormalizada === 'falla') {
            textarea.value = detalle.Descripcion_Falla || '';
        } else {
            textarea.value = detalle.Reparacion_Realizada || '';
        }
        // LIMPIAR EL SELECTOR DE ARCHIVOS
        const inputFotos = document.getElementById('editarNuevasImagenes');
        if (inputFotos) {
            inputFotos.value = '';
        }
        // CARGAR LAS IMÁGENES EXISTENTES Y SUS MINIATURAS
        cargarImagenesModal12(imagenes);
        modal.dataset.volverAgregarMantenimiento = 'true';
        // FUNCIÓN PARA ABRIR MODAL 12
        const abrirModal12 = function () {
            let modalBootstrap = bootstrap.Modal.getInstance(modal);
            if (!modalBootstrap) {
                modalBootstrap = new bootstrap.Modal(modal);
            }
            modalBootstrap.show();
        };
        // OBTENER agregarMantenimiento
        const modalMantenimiento = document.getElementById('agregarMantenimiento');
        // SI NO EXISTE agregarMantenimiento
        if (!modalMantenimiento) {
            abrirModal12();
            return;
        }
        // OBTENER INSTANCIA
        let instanciaMantenimiento = bootstrap.Modal.getInstance(modalMantenimiento);
        if (!instanciaMantenimiento) {
            instanciaMantenimiento = new bootstrap.Modal(modalMantenimiento);
        }
        // VERIFICAR SI ESTÁ ABIERTO
        const estaAbierto = modalMantenimiento.classList.contains('show');
        if (estaAbierto) {
            modalMantenimiento.addEventListener('hidden.bs.modal',function () {
                abrirModal12();
            },{
                once: true
            });
            // Cerrar modal principal
            instanciaMantenimiento.hide();
        } else {
            abrirModal12();
        }
    };
    // GUARDAR EDICIÓN DEL DETALLE
    window.guardarEdicionDetalle = function () {
        // OBTENER CAMPOS
        const inputID = document.getElementById('editarIDDetalle');
        const inputCategoria = document.getElementById('editarCategoria');
        const textarea = document.getElementById('editarDescripcionDetalle');
        const selectSeccion = document.getElementById('Seccion1');
        
        // VALIDAR CAMPOS
        if (!inputID || !inputID.value) {
            alert('No se encontró el ID del detalle');
            return;
        }
        if (!inputCategoria || !inputCategoria.value) {
            alert('No se encontró la categoría');
            return;
        }
        if (!textarea) {
            alert('No se encontró el campo de descripción');
            return;
        }
        if (!selectSeccion) {
            alert('No se encontró el campo de sección');
            return;
        }
        const ID_Detalle = inputID.value;
        const categoria = inputCategoria.value;
        const descripcion = textarea.value.trim();
        const seccion = selectSeccion.value.trim();
        // VALIDAR DESCRIPCIÓN
        if (!descripcion) {
            alert('Ingrese una descripción');
            textarea.focus();
            return;
        }
        // VALIDAR SECCIÓN
        if (!seccion) {
            alert('Seleccione una sección');
            selectSeccion.focus();
            return;
        }
        // CREAR FORMDATA
        const formData = new FormData();
        formData.append('ID_Mantenimiento', window.ID_Mantenimiento);
        formData.append('ID_Detalle', ID_Detalle);
        formData.append('Categoria', categoria);
        formData.append('Descripcion', descripcion);
        formData.append('Seccion', seccion);
        // OBTENER LAS IMÁGENES DEL DETALLE ACTUAL
        const imagenesDetalle = (window.Imagenes || []).filter(imagen => Number(imagen.ID_Detalle) === Number(ID_Detalle) && String(imagen.Categoria || '').toLowerCase() === String(categoria).toLowerCase());
        // OBTENER LAS IMÁGENES NUEVAS QUE SE VAN A SUBIR
        const imagenesNuevas = imagenesDetalle.filter(imagen => imagen.enBD === false && !imagen.eliminada && imagen.archivo);
        // OBTENER LAS IMÁGENES EXISTENTES QUE SE CONSERVARÁN
        const imagenesConservadas = imagenesDetalle.filter(imagen => imagen.enBD === true && !imagen.eliminada);
        // VALIDAR QUE QUEDE AL MENOS UNA IMAGEN
        if (imagenesConservadas.length === 0 && imagenesNuevas.length === 0) {
            alert('Debe conservar al menos una imagen o subir una nueva.');
            return; // Evita continuar y ejecutar el fetch
        }

        // AGREGAR LAS IMÁGENES NUEVAS AL FORMDATA
        imagenesNuevas.forEach(imagen => {formData.append('nuevasImagenes[]', imagen.archivo);});
        // ENVIAR LOS ID DE LAS IMÁGENES EXISTENTES QUE SE ELIMINARÁN
        const imagenesEliminar = imagenesDetalle.filter(imagen => imagen.enBD === true && imagen.eliminada === true).map(imagen => imagen.ID);
        formData.append('imagenesEliminar', JSON.stringify(imagenesEliminar));
        // ENVIAR
        fetch(`${window.baseUrl}Mantenimiento/ActualizarDetalleCorrectivos`,{
            method: 'POST',
            body: formData
        }).then(response => {
            if (!response.ok) {
                throw new Error(`Error HTTP ${response.status}`);
            }
            return response.json();
        }).then(data => {
            // RESPUESTA EXITOSA
            if (data.success) {
                // ACTUALIZAR EL DETALLE EN MEMORIA
                const detalle =(window.Detalles || []).find(item => Number(item.ID) === Number(ID_Detalle));
                if (detalle) {
                    detalle.Seccion = seccion;
                    if (String(categoria).toLowerCase() === 'falla') {
                        detalle.Descripcion_Falla = descripcion;
                    } else {
                        detalle.Reparacion_Realizada = descripcion;
                    }
                }
                // LIMPIAR CAMPOS
                inputID.value = '';
                inputCategoria.value = '';
                textarea.value = '';
                selectSeccion.value = '';
                // ACTUALIZAR EL ARREGLO DE IMÁGENES DESPUÉS DE GUARDAR
                window.Imagenes = (window.Imagenes || []).filter(imagen => {
                    const perteneceAlDetalle = Number(imagen.ID_Detalle) === Number(ID_Detalle) && String(imagen.Categoria || '').toLowerCase() === String(categoria).toLowerCase();
                    // Quitar las imágenes que se eliminaron
                    if (perteneceAlDetalle && imagen.enBD === true && imagen.eliminada) {
                        return false;
                    }
                    // Quitar las imágenes nuevas ya enviadas
                    if (perteneceAlDetalle && imagen.enBD === false && !imagen.eliminada) {
                        return false;
                    }
                    return true;
                });

                const inputFotos = document.getElementById('editarNuevasImagenes');

                if (inputFotos) {
                    inputFotos.value = '';
                }

                // CERRAR MODAL 12
                const modalEditarDetalle = document.getElementById('modalEditarDetalle');
                if (modalEditarDetalle) {
                    const modalInstance = bootstrap.Modal.getInstance( modalEditarDetalle);
                    if (modalInstance) {
                        modalInstance.hide();
                    }
                }
                // ACTUALIZAR TABLAS
                renderTablaCorrecciones();
            } else {
                alert('Error al guardar detalles correctivos: ' + (data.message || 'Error desconocido'));
            }
        })
        .catch(error => {
            console.error('Error al guardar los detalles correctivos:', error);
            alert('Error al guardar detalles correctivos');
        });
    };

    // MODAL 12 AL CERRAR → VOLVER A agregarMantenimiento
    const modalEditarDetalle = document.getElementById('modalEditarDetalle');
    if (modalEditarDetalle) {
        modalEditarDetalle.addEventListener('hidden.bs.modal',function () {
            // VERIFICAR SI DEBEMOS VOLVER
            if (modalEditarDetalle.dataset.volverAgregarMantenimiento !=='true'){
                return;
            }            
            // LIMPIAR MARCA
            modalEditarDetalle.dataset.volverAgregarMantenimiento = 'false';
            // OBTENER agregarMantenimiento
            const modalMantenimiento = document.getElementById('agregarMantenimiento');
            if (!modalMantenimiento) {
                console.error('No existe #agregarMantenimiento');
                return;
            }
            // CREAR/OBTENER INSTANCIA
            let instanciaMantenimiento = bootstrap.Modal.getInstance(modalMantenimiento);
            if (!instanciaMantenimiento) {
                instanciaMantenimiento = new bootstrap.Modal(modalMantenimiento);
            }
            // ABRIR
            instanciaMantenimiento.show();
        });
    }
    // CARGAR IMÁGENES Y SECCIONES EN MODAL 12      
    function cargarSeccionesModal12(tipoMontacargas, seccionSeleccionada = '') {
        const selectSeccion = document.getElementById('Seccion1');
        if (!selectSeccion) {
            console.warn('No existe el select #Seccion1');
            return;
        }
        // Limpiar select
        selectSeccion.innerHTML = '';
        // Crear opción inicial
        const opcionInicial = document.createElement('option');
        opcionInicial.value = '';
        opcionInicial.textContent = 'Seleccione sección';
        opcionInicial.disabled = true;
        selectSeccion.appendChild(opcionInicial);
        // Validar tipo de montacargas
        if (!tipoMontacargas) {
            console.warn('No se recibió el tipo de montacargas');
            return;
        }

        // Obtener secciones según el tipo de montacargas
        const listaSecciones = window.secciones[tipoMontacargas];

        if (!listaSecciones) {
            console.warn('No existen secciones para el tipo:', tipoMontacargas);
            return;
        }
        // Normalizar la sección guardada
        const seccionGuardada = String(seccionSeleccionada || '').trim();
        // Crear opciones
        listaSecciones.forEach(seccion => {
            const option = document.createElement('option');
            option.value = seccion;
            option.textContent = seccion;
            // Seleccionar la sección almacenada
            if (
                String(seccion).trim().toLowerCase() ===
                seccionGuardada.toLowerCase()
            ) {
                option.selected = true;
            }
            selectSeccion.appendChild(option);
        });

        // Si no coincide ninguna sección, mostrar la opción inicial
        if (!seccionGuardada || !listaSecciones.some(seccion => String(seccion).trim().toLowerCase() === seccionGuardada.toLowerCase())) {
            selectSeccion.value = '';
            opcionInicial.selected = true;
        }
    }
    function cargarImagenesModal12(imagenes) {
        const contenedor = document.getElementById('editarImagenesDetalle');
        const sinImagenes = document.getElementById('sinImagenesDetalle');

        if (!contenedor || !sinImagenes) {
            console.error('No se encontraron los elementos del modal 12');
            return;
        }

        // LIMPIAR MINIATURAS ANTERIORES
        contenedor.innerHTML = '';

        // MOSTRAR SOLO LAS IMÁGENES ACTIVAS
        const imagenesVisibles = (imagenes || []).filter(imagen => !imagen.eliminada);
        if (imagenesVisibles.length === 0) {
            sinImagenes.style.display = '';
            return;
        }

        sinImagenes.style.display = 'none';
        imagenesVisibles.forEach(imagen => {
            const div = document.createElement('div');
            div.style.cssText ='position:relative;width:120px;height:100px;';
            // DETERMINAR LA URL SEGÚN EL ORIGEN DE LA IMAGEN
            let urlImagen;
            if (imagen.enBD === false) {
                // IMAGEN NUEVA: PREVISUALIZACIÓN TEMPORAL
                urlImagen = imagen.urlTemporal;
            } else {
                // IMAGEN EXISTENTE EN LA BASE DE DATOS
                urlImagen = window.baseUrl.replace(/\/+$/, '/') + String(imagen.Evidencia_Fotografica || '').replace(/^\/+/, '');
            }
            if (!urlImagen) {
                console.warn('La imagen no tiene una URL válida:', imagen);
                return;
            }
            // MINIATURA
            const img = document.createElement('img');
            img.src = urlImagen;
            img.alt = 'Evidencia';
            img.style.cssText ='width:100%;height:100%;object-fit:cover;' + 'border-radius:8px;border:1px solid #ddd;cursor:pointer;';
            img.addEventListener('click', function () {
                abrirLightbox(urlImagen);
            });
            // BOTÓN ELIMINAR
            const botonEliminar = document.createElement('button');
            botonEliminar.type = 'button';
            botonEliminar.textContent = '✕';
            botonEliminar.title = 'Quitar imagen';
            botonEliminar.style.cssText ='position:absolute;top:3px;right:3px;' + 'background:rgba(0,0,0,.65);color:white;border:none;' + 'border-radius:50%;width:22px;height:22px;' + 'cursor:pointer;z-index:2;';
            botonEliminar.addEventListener('click', function (e) {
                e.stopPropagation();
                if (imagen.enBD === true) {
                    // LA IMAGEN EXISTE EN BD: MARCAR PARA ELIMINAR
                    imagen.eliminada = true;
                } else {
                    // LA IMAGEN ES NUEVA: QUITARLA DEL ARREGLO
                    window.Imagenes = (window.Imagenes || []).filter(item => item !== imagen);
                }
                // ACTUALIZAR LA VISTA
                cargarImagenesModal12((window.Imagenes || []).filter( item => Number(item.ID_Detalle) === Number(imagen.ID_Detalle) && String(item.Categoria || '').toLowerCase() === String(imagen.Categoria || '').toLowerCase()));
            });
            div.appendChild(img);
            div.appendChild(botonEliminar);
            contenedor.appendChild(div);
        });

        // ACTUALIZAR MENSAJE DE ESTADO
        sinImagenes.style.display = contenedor.children.length === 0 ? '' : 'none';
    }
    function configurarNuevasImagenesModal12() {
        const input = document.getElementById('editarNuevasImagenes');
        if (!input || input.dataset.configurado === 'true') {
            return;
        }
        input.dataset.configurado = 'true';
        input.addEventListener('change', function () {
            const archivos = Array.from(input.files || []);
            const inputID = document.getElementById('editarIDDetalle');
            const inputCategoria = document.getElementById('editarCategoria');
            if (!inputID || !inputID.value ||
                !inputCategoria || !inputCategoria.value) {
                alert('No se pudo identificar el detalle que estás editando.');
                input.value = '';
                return;
            }
            const ID_Detalle = Number(inputID.value);
            const categoria = inputCategoria.value;
            window.Imagenes = window.Imagenes || [];
            archivos.forEach(archivo => {
                if (!archivo.type.startsWith('image/')) {
                    return;
                }
                // CREAR REGISTRO DE LA NUEVA IMAGEN
                const nuevaImagen = {ID: null, ID_Detalle: ID_Detalle, Categoria: categoria, Evidencia_Fotografica: null, archivo: archivo, urlTemporal: null, enBD: false, eliminada: false};
                // AGREGAR AL ARREGLO PRINCIPAL
                window.Imagenes.push(nuevaImagen);
                const reader = new FileReader();
                reader.onload = function (e) {
                    nuevaImagen.urlTemporal = e.target.result;
                    // EVITAR MOSTRAR FOTOS DE OTRO DETALLE O CATEGORÍA
                    const imagenesActuales = window.Imagenes.filter(imagen => Number(imagen.ID_Detalle) === ID_Detalle && String(imagen.Categoria || '').toLowerCase() === String(categoria).toLowerCase());
                    cargarImagenesModal12(imagenesActuales);
                };
                reader.onerror = function () {
                    window.Imagenes = window.Imagenes.filter( item => item !== nuevaImagen);
                    console.error('No se pudo leer el archivo:', archivo.name);
                };
                reader.readAsDataURL(archivo);
            });
            // PERMITIR SELECCIONAR NUEVAMENTE EL MISMO ARCHIVO
            input.value = '';
        });
    }
    // REGISTRAR EL EVENTO CUANDO EL DOM ESTÉ DISPONIBLE
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', configurarNuevasImagenesModal12, { once: true });
    } else {
        configurarNuevasImagenesModal12();
    }

    /* ═══════════════ RECUPERAR BORRADOR ═════════════
       Rellena el modal 2 (agregarMantenimiento) y todo el estado global
       con lo que ya está guardado en BD para un mantenimiento en estado
       BORRADOR. Recibe la respuesta cruda de ObtenerDetalles.php:
       { success: true, data: { mantenimiento, detalle, insumos, imagenes, tecnicos, novedades } }
    */
    window.LlenarModalMantenimiento = function (detalleResponse) {
        const data = detalleResponse.data;
        const m    = data.mantenimiento;

        /* Variables globales */
        window.ID_Mantenimiento  = m.ID;
        window.ID_Centro = m.ID_Centro;
        window.ID_Montacargas = m.ID_Montacargas;
        window.Tipo_Montacargas = m.Tipo_Montacargas;
        window.Detalles = data.detalles;

        /* Panel izquierdo (mismos campos que en CrearMantenimiento) */
        const setVal = (id, val) => { const el = document.getElementById(id); if (el) el.value = val || ''; };
        setVal('numeroMontacargas', m.NumeroM);
        setVal('nombreSeccion',     m.NombreArea);
        setVal('numeroSerie',       m.SerieM);
        setVal('numeroModelo',      m.ModeloM);
        setVal('nombreCentro',      m.NombreCentro);
        setVal('Voltaje',           m.VoltajeM);
        setVal('nombreOperario',    m.NombreOperario);

        cargarCriterios(m.Tipo_Montacargas);

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

        // /* Insumos
        //    ⚠️ detalles_insumos_mantenimientos solo guarda ID_Insumo/Cantidad/Medida.
        //    Codigo y Nombre quedan vacíos hasta agregar el JOIN con la tabla catálogo
        //    en ObtenerMantenimientoCompleto (pendiente de confirmar el nombre de esa tabla). */
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

        // /* Repuestos
        //    ⚠️ detalles_repuestos_mantenimientos solo guarda ID_Insumo/Cantidad/Medida.
        //    Codigo y Nombre quedan vacíos hasta agregar el JOIN con la tabla catálogo
        //    en ObtenerMantenimientoCompleto (pendiente de confirmar el nombre de esa tabla). */
        window.Repuestos = (data.repuestos || []).map(i => ({
            id: String(i.ID_Insumo),
            codigo: i.Codigo || '',
            nombre: i.Nombre || '',
            cantidad: i.Cantidad,
            medida: i.Medida,
            descripcion: i.Descripcion,
            enBD: true
        }));
        window._RepuestosTemp = window.Repuestos.map(i => ({ ...i }));
        actualizarContadorRepuestos();

        /* Novedades del mantenimiento recuperado */
        window._novedades = (data.novedades || []).map(n => ({
            id: n.ID,
            txt: n.Descripcion || '',
            estado: n.Estado_Novedad || 'Pendiente',
            enBD: true
        }));
        // Crear una copia para manejar la tabla
        window._novedadesTemp = window._novedades.map(n => ({ ...n }));

        // Actualizar tabla y contadores
        renderTablaNovedades();
        actualizarContadorNovedades();

        // Recuperar observaciones del borrador
        let observacionesGuardadas = m.Observaciones ?? [];

        if (typeof observacionesGuardadas === 'string') {
            try {
                observacionesGuardadas = JSON.parse(observacionesGuardadas);
            } catch (error) {
                console.error('Error al convertir las observaciones:', error);
                observacionesGuardadas = [];
            }
        }

        if (!Array.isArray(observacionesGuardadas)) {
            observacionesGuardadas = [];
        }

        window.observaciones = observacionesGuardadas.map((n, i) => ({
            id: i,
            txt: typeof n === 'string' ? n : (n.Descripcion ?? ''),
            enBD: true
        }));

        window._observacionesTemp = window.observaciones.map(n => ({ ...n }));

        actualizarContadorObservaciones();

        // /* Subtítulo del modal 2 (mismo formato que en CrearMantenimiento) */
        const subtitulo = document.getElementById('subtituloModal');
        if (subtitulo) subtitulo.textContent = `${m.Tipo_Montacargas || ''}`;
        
        // /*Traer Operarios Recibe*/
        TraerOperioRecibe();
        // /* Cargar tabla de fallas y correcciones */
        renderTablaCorrecciones();
    }

    /* ── Botón "Finalizar ✓": valida que todo esté completo y envía los datos de cierre  */
    document.getElementById('btnFinalizarMantenimiento')?.addEventListener('click', function () {
        // 1.  Validar que exista al menos un detalle
        if (!Array.isArray(window.Detalles) || window.Detalles.length === 0) {
            alert('Debe registrar al menos un detalle de falla o corrección antes de finalizar el mantenimiento.');
            return;
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

        fetch(`${window.baseUrl}Mantenimiento/FinalizarMantenimientoCorrectivo`, {
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
                const modalAgregar = document.getElementById('agregarMantenimiento');
                const modalFirmas = document.getElementById('modalFirmasMantenimiento');
                if (!modalAgregar || !modalFirmas) {
                    console.error('No se encontró uno de los modales.');
                    return;
                }
                // Obtener o crear la instancia de Bootstrap
                const instanciaAgregar = bootstrap.Modal.getInstance(modalAgregar) || new bootstrap.Modal(modalAgregar);
                const instanciaFirmas = bootstrap.Modal.getInstance(modalFirmas) || new bootstrap.Modal(modalFirmas);
                // Esperar a que termine de cerrarse el modal actual
                modalAgregar.addEventListener('hidden.bs.modal', function alCerrar() {
                    modalAgregar.removeEventListener('hidden.bs.modal', alCerrar);

                    // Cargar las firmas y después abrir el modal
                    Promise.resolve(cargarFirmasMecanicos())
                        .then(() => {
                            instanciaFirmas.show();
                        })
                        .catch(error => {
                            console.error('Error al cargar las firmas:', error);
                            instanciaFirmas.show();
                        });
                }, { once: true });
                instanciaAgregar.hide();
            } else {
                alert(data.message || 'No se pudo finalizar el mantenimiento.');
            }
        })
        .catch(error => {
            console.error('Error al finalizar:', error);
            alert('Error de conexión al finalizar el mantenimiento.');
        })
        .finally(() => {
            btn.disabled = false;
            btn.innerHTML = 'Finalizar ✓';
        });
    });

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
            contenedor.innerHTML = `<div class="alert alert-warning"> No hay mecánicos asociados a este mantenimiento. </div>`;
            return;
        }

        tecnicos.forEach((tecnico, index) => {
            contenedor.insertAdjacentHTML('beforeend', `<div class="card mb-4">
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
                </div>`);
        });
        // Inicializar los canvas después de crearlos
        tecnicos.forEach(tecnico => {inicializarCanvasFirma(tecnico.id);});
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

    document.getElementById('btnGuardarFirmas')?.addEventListener('click', function (event) {
        const botonGuardar = event.currentTarget;
        if (botonGuardar.disabled) return;
        if (!validarFirmasMecanicos()) {
            return;
        }
        const textoOriginal = botonGuardar.textContent;
        botonGuardar.disabled = true;
        botonGuardar.textContent = 'Guardando...';
        // Obtener firmas
        const firmas = [];
        window._tecnicos.forEach(tecnico => {
            const canvas = document.getElementById(`canvasFirma_${tecnico.id}`);
            firmas.push({
                ID_Tecnico: tecnico.id,
                Nombre: tecnico.nombre,
                Firma: canvas.toDataURL('image/png')
            });

        });

        // AQUÍ irá el fetch para guardar las firmas
        fetch(`${window.baseUrl}Mantenimiento/FirmarMantenimientoCorrectivosTecnicos`, {
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
                        confirmButtonText: 'Entendido',
                        showConfirmButton: true,
                        allowOutsideClick: false
                    }).then(() => {
                        location.reload();
                    });
                } else if (data.estado_revertido) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Salida no creada',
                        text: data.message,
                        confirmButtonText: 'Entendido',
                        allowOutsideClick: false
                    }).then(() => location.reload());
                } else {
                    alert('Error al guardar firmas: ' + data.message);
                    botonGuardar.disabled = false;
                    botonGuardar.textContent = textoOriginal;
                }
            })
            .catch(error => {
                console.error('Error al guardar firmas:',error);
                alert('Error al guardar firmas');
                botonGuardar.disabled = false;
                botonGuardar.textContent = textoOriginal;
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

    //Mirar si funciona
    window.abrirModalFirma = function (ID_Mantenimiento, contexto, ID_Mecanico = null, NombrePersona = '', TipoMontacargas, TipoMantenimiento) {
        document.getElementById('ID_MantenimientoFirma').value = ID_Mantenimiento;
        document.getElementById('TipoFirma').value = contexto;

        const url = `${window.baseUrl}Mantenimiento/VerMantenimientoCorrectivo` + `?ID=${encodeURIComponent(ID_Mantenimiento)}`;
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

    //mirar si funciona
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


        // AQUÍ irá el fetch para guardar las firmas
        fetch(`${window.baseUrl}Mantenimiento/FirmarMantenimientoCorrectivo`, {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
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

    //BUSCAR mirar esta fallando
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
                <td>${index + 1}</td>
                <td><strong>${m.Numero ?? m.ID ?? ''}</strong></td>
                <td><strong>${m.NumeroM ?? ''}</strong> <br>
                    <small class="text-muted">
                        ${m.MarcaM ?? ''}
                        ${m.ModeloM ? ' - ' + m.ModeloM : ''}
                        ${m.SerieM ? '<br>Serie: ' + m.SerieM : ''}
                    </small>
                </td>
                <td>${m.Centrot ?? ''}</td>
                <td>${formatearFecha(m.Fecha_Realizado)}</td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-primary" onclick="verMantenimientoBuscado(${m.ID})">Ver</button>
                </td> `;
            tbody.appendChild(tr);
        });
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
        const url =`${window.baseUrl}Mantenimiento/VerMantenimientoCorrectivo` +`?ID=${encodeURIComponent(mantenimiento.ID)}`;
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
        // ABRIR INFORME
        window.open(url, '_blank');

    });
    //LIMPIAR MODAL INFORME
    document.getElementById('btnLimpiarInforme')?.addEventListener('click', function () {
        document.getElementById('formInformeMantenimiento') ?.reset();
    });

});
