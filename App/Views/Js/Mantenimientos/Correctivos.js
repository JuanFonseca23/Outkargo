/*Variables globales */
window.ID_Mantenimiento = null;
window.ID_Montacargas = null;
window.ID_Centro = null;
window.Mantenimiento = 'Correctivo';
window._tecnicos = [];
window._TecnicosTemp = [];
window.insumos = [];
window._insumosTemp = [];
window._novedades = [];
window._novedadesTemp = [];

/* ════ CARGAR CRITERIOS → TARJETAS ═══ */
function cargarCriterios() {
    // Mostrar tarjetas especiales
    const especiales = document.getElementById('tarjetasEspeciales');
    if (especiales) especiales.style.display = '';
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

    // renderTablasMantenimientos(); 

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

    const btnCorrectivo = document.getElementById('btnCorrectivo');
    const modalElement = document.getElementById('NumerDocumentoModal');

    if (btnCorrectivo && modalElement) {
        const modalCorrectivo = new bootstrap.Modal(modalElement);
        btnCorrectivo.addEventListener('click', function () {
            modalCorrectivo.show();
        });
        btnCorrectivo.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                modalCorrectivo.show();
            }
        });
    }

    /* ── SUBMIT MODAL 1 → abre Modal 2 ── */
    /*--Crear Mantenimiento correctivo borrador--*/
    /*--Abrir modal Agregar mantenimiento --*/
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
                                    enBD: true
                                });
                            });
                        }

                        // Renderizar novedades adicionales
                        renderTablaNovedades();
                        // Renderizar tecnicos adicionales
                        renderPanelTecnicos();
                    }        
                    const modalEl1 = document.getElementById('NumerDocumentoModal');
                    bootstrap.Modal.getInstance(modalEl1).hide();

                    modalEl1.addEventListener('hidden.bs.modal', function handler() {
                        this.removeEventListener('hidden.bs.modal', handler);
                        cargarCriterios();
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
        window._TecnicosTemp = []; // limpiar temp al cerrar sin guardar
        renderPanelTecnicos();

        const m2el = document.getElementById('agregarMantenimiento');
        if (!m2el.classList.contains('show')) new bootstrap.Modal(m2el).show();
    });

});