<?php
require_once "App/Views/Templates/Layouts/Header.php";
include_once "App/Controllers/CentroDeTrabajoController.php";
include_once "App/Controllers/OrdenesCompraController.php";
include_once "App/Controllers/OrdenesTrabajoController.php";

$CentrosDeTrabajo = new CentroDeTrabajoController;
$OrdenesCompraController = new OrdenesCompraController();
$OrdenesTrabajoController = new OrdenesTrabajoController();
$ListaCentrosDeTrabajo = $CentrosDeTrabajo->TraerCentrosDeTrabajo();

$ID_Centro = isset($_GET['centro']) ? $_GET['centro'] : $_SESSION['NoCentro'];
$No_Solicitudes = $OrdenesTrabajoController->ContarSolicitudesPorCentro($ID_Centro);
$Solicitudes = $OrdenesTrabajoController->leerSolicitudesTrabajo($ID_Centro);
$DataSupervisores = $OrdenesTrabajoController->TraerSupervisores();

if ($_SERVER['HTTP_HOST'] == 'localhost') {
    $baseUrl = 'http://localhost/OUTKARGO/';
} else {
    $baseUrl = 'https://outkargo.com.co/';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['Tipo']) && $_POST['Tipo'] === "GuardarSolicitud") {
        $ID_Centro = $_SESSION['NoCentro'];    
        $ID_Solicitante = $_SESSION['ID'];
        $ID_Supervisor = $_POST['IDSupervisor'];
        $Correo_Supervisor = $_POST['CorreoSupervisor'];
        $Nombre_Supervisor = $_POST['NombreSupervisor'];
        $Firma_Solicitante = $_POST['firma'];
        $NombreCreo = $_SESSION['Nombre1'];
        $TiposEquipo = $_POST['tipo_equipo'];
        $Cantidades = $_POST['cantidad'];
        $Productos = $_POST['producto_id'];
        $Descripciones = $_POST['descripcion'];
        if($ID_Solicitud = $OrdenesTrabajoController->RegistarSolicitud($ID_Solicitante, $ID_Centro, $ID_Supervisor, $Correo_Supervisor, $Nombre_Supervisor, $Firma_Solicitante, $NombreCreo, $TiposEquipo, $Cantidades, $Productos, $Descripciones)){
            echo "
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                Swal.fire({
                    title: 'Solicitud de Orden de Trabajo Creada!',
                    text: 'La solicitud de orden de trabajo se ha creado exitosamente.',
                    icon: 'success',
                    showCancelButton: true,
                    confirmButtonText: 'Continuar',
                    cancelButtonText: 'Cancelar',
                    allowOutsideClick: false,
                    allowEscapeKey: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'InicioSolicitud';
                    }
                });
            </script>";
        }else{
            echo "
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                Swal.fire({
                    title: 'Error!',
                    text: 'La solicitud de orden de trabajo no se pudo crear, por favor intente de nuevo.',
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

    #canvasFirma {
        width: 100%;
        height: 320px;         
        border: 2px solid #ccc;
        border-radius: 6px;
        background: #fff;
        touch-action: none;
    }

    @media screen and (max-width: 768px) {
        #canvasFirma {
            width: 100%;
            height: 150px;         
            border: 2px solid #ccc;
            border-radius: 6px;
            background: #fff;
            touch-action: none;
        }
    }

    /* ===== RESPONSIVE MOVIL MEDIO (371px – 414px) ===== */
    @media screen and (max-width: 414px) and (min-width: 371px) {
        #canvasFirma {
            width: 100%;
            height: 150px;         
            border: 2px solid #ccc;
            border-radius: 6px;
            background: #fff;
            touch-action: none;
        }
    }

    /* ===== RESPONSIVE EXTRA PEQUEÑO (320px – 370px) ===== */
    @media screen and (max-width: 370px) {
        #canvasFirma {
            width: 100%;
            height: 150px;         
            border: 2px solid #ccc;
            border-radius: 6px;
            background: #fff;
            touch-action: none;
        }
    }

</style>

<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-6 col-xl-3">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <img width="50" height="50" src="https://img.icons8.com/ink/50/000020/purchase-order.png" alt="purchase-order"/>
                <div class="ms-3">
                    <p class="mb-2" style="color: #000020;">Solicitudes Realizadas</p>
                    <h6 class="mb-0" style="color: #000020;"><?= $No_Solicitudes['Nosolicitudes'] ?></h6>
                </div>
            </div>
        </div>
        <a class="col-sm-6 col-xl-3" data-bs-toggle="modal" data-bs-target="#agregarSolicitud">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <img width="50" height="50" src="https://img.icons8.com/ios/50/000020/work.png" alt="work"/>
                <div class="ms-3">
                    <p class="mb-2" style="color: #000020;">Realizar Solicitud de Trabajo</p>
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
                    <h6 class="mb-0">Solicitudes Realizadas |</h6>
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
                        <th scope="col" class="text-center">Numero</th>
                        <th scope="col" class="text-center">Fecha Realizado</th>
                        <th scope="col" class="text-center">Solicita</th>
                        <th scope="col" class="text-center">Autoriza</th>
                        <th scope="col" class="text-center">Estado</th>
                        <th scope="col" class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($Solicitudes) {
                        foreach ($Solicitudes as $Solicitud) {
                            if ($Solicitud['Estado_Orden'] == 1) {
                                $progressBarClass = 'bg-success';
                                $estadoTexto = 'Revisado';
                            } elseif ($Solicitud['Estado_Orden'] == 0) {
                                $progressBarClass = 'bg-warning';
                                $estadoTexto = 'Pendiente';
                            }
                    ?>
                            <tr>
                                <td class="text-center"><?= htmlspecialchars($Solicitud['Numero']) ?></td>
                                <td class="text-center"><?= htmlspecialchars($Solicitud['Fecha_Solicitud']) ?></td>
                                <td class="text-center"><?= htmlspecialchars($Solicitud['NombreUsuario']) ?></td>
                                <td class="text-center"><?= htmlspecialchars($Solicitud['NombreAutoriza']) ?></td>
                                <td>
                                    <div class="progress">
                                        <div id="progressStatus" class="progress-bar <?= $progressBarClass ?>" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                            <?=  $estadoTexto ?>
                                        </div>
                                    </div>
                                </td>
                                <td width="200" class="text-center">
                                    <a class="btn btn-sm btn-primary" target="_blank" href="VerSolicitud?ID=<?= urlencode(htmlspecialchars($Solicitud['ID'])) ?>">
                                        <img width="20" height="20" src="https://img.icons8.com/material-outlined/24/ffffff/visible--v1.png" alt="Ver" />
                                    </a>
                                    <?php if ( $Solicitud['Estado_Orden'] != 1) { ?>
                                        <a class="btn btn-sm btn-dark" target="_blank" href="AutorizarSolicitudT?ID=<?= urlencode(htmlspecialchars($Solicitud['ID'])) ?>">
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

<div class="modal fade" id="agregarSolicitud" tabindex="-1" aria-labelledby="agregarSolicitudModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="agregarSolicitudModalLabel"> Solicitud de Orden de trabajo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="documentFormSolicitud" method="POST">
                    <div class="mb-3">
                            <div class="row g-3 mb-3">
                                <div class="col-12 col-md-4">
                                    <label for="nombreSolicita">Solicita</label>
                                    <input type="text" class="form-control" name="nombreSolicita" placeholder="<?= htmlspecialchars($_SESSION['NombreCompleto']) ?>" readonly>
                                </div>
                                <div class="col-12 col-md-4">
                                    <label for="nombreCentro">Centro de Trabajo</label>
                                    <input type="text" class="form-control" name="nombreCentro" placeholder="<?= htmlspecialchars($_SESSION['Centro']) ?>" readonly>
                                </div>
                                <div class="col-12 col-md-4">
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
                            <div class="row g-3 mb-3">
                                <label for="nombreSolicita">Agregar Ítem a la Solicitud</label>
                                <div class="col-12 col-md-2">
                                    <select id="tipoEquipo" name="tipoEquipo" class="form-select" >
                                        <option value="">Seleccione tipo</option>
                                        <option value="Montacargas">Montacargas</option>
                                        <option value="Bateria">Batería</option>
                                        <option value="Cargador">Cargador</option>
                                        <option value="Repuestos">Repuestos</option>
                                    </select>
                                </div>
                                <div class="col-12 col-md-2">
                                    <input type="number" id="cantidad" class="form-control" placeholder="Cantidad" min="1" step="1" >
                                </div>
                                <div class="col-12 col-md-3">
                                    <select  id="select-para" class="form-control" placeholder="Escribe nombre o codigo..."></select>
                                </div>
                                <div class="col-12 col-md-4">
                                    <input type="text" id="descripcion" class="form-control" placeholder="Descripción">
                                </div>
                                <div class="col-12 col-md-1 d-grid">
                                    <button type="button" class="btn btn-success" onclick="agregarFila()">Agregar</button>
                                </div>
                            </div>
                    </div>
                    <!-- Tabla dinámica -->
                    <div class="table-responsive">
                        <table class="table table-bordered" id="tablaSolicitud">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Codigo</th>
                                    <th>Cantidad</th>
                                    <th>Nombre</th>
                                    <th>Descripcion</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                     
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex gap-2 mt-3">
                        <button type="button" class="btn btn-warning mt-3" onclick="abrirModalFirma()">Firmar Solicitud</button>
                        <button type="submit" class="btn btn-primary mt-3"> Guardar Solicitud </button>
                    </div>

                    <input type="hidden" name="Tipo" value="GuardarSolicitud">
                    <input type="hidden" name="IDSupervisor" id="formIDSupervisor">
                    <input type="hidden" name="CorreoSupervisor" id="formCorreoSupervisor">
                    <input type="hidden" name="NombreSupervisor" id="formNombreSupervisor"> 
                    <input type="hidden" name="firma" id="firmaBase64">
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalFirma" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Firma del solicitante</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center">
                <canvas id="canvasFirma"></canvas>
                <div class="mt-3 d-flex justify-content-center gap-2">
                    <button type="button" class="btn btn-warning" onclick="limpiarFirma()">Limpiar</button>
                    <button type="button" class="btn btn-success" onclick="guardarFirma()">Guardar Firma</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let tom;
    let productoSeleccionado = null;
    let endpointBusqueda = null;
    let contador = 1;

    /* CONFIGURACIÓN DINÁMICA POR TIPO */
    const configuracionBusqueda = {
        Repuestos: {
            endpoint: "BuscarInsumos",
            labelField: "display",
            searchField: ["display"]
        },
        Montacargas: {
            endpoint: "BuscarMontacargas",
            labelField: "display",
            searchField: ["display"]
        },
        Bateria: {
            endpoint: "BuscarBateria",
            labelField: "display",
            searchField: ["display"]
        },
        Cargador: {
            endpoint: "BuscarCargador",
            labelField: "display",
            searchField: ["display"]
        }
    };

    /* CAMBIO DE TIPO DE EQUIPO */
    document.getElementById("tipoEquipo").addEventListener("change", function () {

        const tipo = this.value;
        if (!configuracionBusqueda[tipo]) {
            endpointBusqueda = null;
            return;
        }

        endpointBusqueda = configuracionBusqueda[tipo].endpoint;
        if (tom) {
            tom.settings.labelField  = configuracionBusqueda[tipo].labelField;
            tom.settings.searchField = configuracionBusqueda[tipo].searchField;
            tom.clear();
            tom.clearOptions();
        }

        productoSeleccionado = null;
    });

    /* INICIALIZACIÓN TOMSELECT */
    document.addEventListener('DOMContentLoaded', function () {

        tom = new TomSelect('#select-para', {
            maxItems: 1,
            valueField: 'id',
            labelField: 'display',
            searchField: ['display'],
            closeAfterSelect: true,
            hideSelected: true,
            create: false,

            load: function(query, callback) {
                const tipoSeleccionado = document.getElementById("tipoEquipo").value;
                if (!endpointBusqueda || !tipoSeleccionado) {
                    callback();
                    return;
                }
                if (query.length < 2) {
                    callback();
                    return;
                }

                const url = `<?= $baseUrl ?>OrdenesTrabajo/${endpointBusqueda}?q=${encodeURIComponent(query)}`;
                fetch(url)
                .then(r => r.json())
                .then(data => {
                    const normalizados = data.map(item => {
                        if (item.nombre) {
                            item.display = `${item.codigo} - ${item.nombre}`;
                        }
                        else if (item.modelo) {
                            item.display = `${item.numero} - ${item.serie} - ${item.modelo}`;
                        }
                        else if (item.marca) {
                            item.display = `${item.marca} - ${item.serie} - ${item.numero}`;
                        }
                        return item;
                    });
                    callback(normalizados);
                })
                .catch(() => callback());
            },

            onItemAdd: function(value) {
                productoSeleccionado = this.options[value];
            }
        });
        inicializarFirma();
    });

    /*  NUEVO — ABRIR MODAL FIRMA Y CERRAR PRINCIPAL */
    function abrirModalFirma() {
        const modalPrincipal = bootstrap.Modal.getInstance(
            document.getElementById('agregarSolicitud')
        );

        if (modalPrincipal) {
            modalPrincipal.hide();
        }

        // Espera breve para que termine la animación
        setTimeout(() => { const modalFirma = new bootstrap.Modal(document.getElementById('modalFirma'));modalFirma.show();}, 300);
    }

    /*  OPCIONAL — VOLVER AL MODAL PRINCIPAL AL CERRAR FIRMA */
    document.getElementById('modalFirma') .addEventListener('hidden.bs.modal', function () {
            const modalPrincipal = new bootstrap.Modal(document.getElementById('agregarSolicitud'));
            modalPrincipal.show();
    });

    /* VALIDACIÓN ANTES DE ENVIAR */
    document.getElementById("documentFormSolicitud").addEventListener("submit", function(e) {

        const firma = document.getElementById("firmaBase64").value;
        const filas = document.querySelectorAll("#tablaSolicitud tbody tr").length;

        if (!firma) {
            e.preventDefault();
            alert("Debe firmar la solicitud antes de guardar.");
            return;
        }

        if (filas === 0) {
            e.preventDefault();
            alert("Debe agregar al menos un ítem.");
            return;
        }
    });

    /* AGREGAR FILA */
    function agregarFila() {

        const cantidad    = document.getElementById("cantidad").value.trim();
        const descripcion = document.getElementById("descripcion").value.trim();
        const tipoEquipo  = document.getElementById("tipoEquipo").value;

        if (!tipoEquipo) {
            alert("Debe seleccionar el tipo de equipo.");
            return;
        }

        if (!productoSeleccionado) {
            alert("Debe seleccionar un producto.");
            return;
        }

        if (parseInt(cantidad) < 0) {
            alert("La cantidad debe ser mayor a 0.");
            return;
        }

        const { id, nombre, codigo, serie, numero, display } = productoSeleccionado;

        let codigoFinal = "";
        let nombreFinal = "";

        /* Lógica de presentación */
        if (tipoEquipo === "Montacargas") {
            nombreFinal = `#${numero ?? ''} / Serie: ${serie ?? ''}`.trim();
            codigoFinal = "";
        } 

        else {
            // Repuestos, Batería, Cargador → solo nombre (sin código)
            nombreFinal = nombre ?? display ?? "";
            codigoFinal = codigo ?? "";
        }

        if (!nombreFinal) {
            alert("No se pudo obtener el nombre del producto.");
            return;
        }

        const tabla = document.querySelector("#tablaSolicitud tbody");
        const fila  = document.createElement("tr");

        fila.innerHTML = `
            <td class="text-center">${contador}</td>

            <td>
                ${codigoFinal}
                <input type="hidden" name="codigo[]" value="${codigoFinal}">
            </td>

            <td>
                ${cantidad}
                <input type="hidden" name="cantidad[]" value="${cantidad}">
            </td>

            <td>
                ${nombreFinal}
                <input type="hidden" name="nombre[]" value="${nombreFinal}">
                <input type="hidden" name="producto_id[]" value="${id}">
                <input type="hidden" name="tipo_equipo[]" value="${tipoEquipo}">
            </td>

            <td>
                ${descripcion}
                <input type="hidden" name="descripcion[]" value="${descripcion}">
            </td>

            <td class="text-center">
                <button type="button" class="btn btn-danger btn-sm" onclick="eliminarFila(this)">
                    Eliminar
                </button>
            </td>
        `;

        tabla.appendChild(fila);
        contador++;

        // Limpiar campos
        document.getElementById("cantidad").value = "";
        document.getElementById("descripcion").value = "";
        tom.clear();
        productoSeleccionado = null;
    }
    
    /* ELIMINAR FILA */
    function eliminarFila(btn) {
        btn.closest("tr").remove();
    }

    /* FIRMA DIGITAL (SIN CAMBIOS) */
    let canvas, ctx;
    let dibujando = false;

    document.getElementById('modalFirma').addEventListener('shown.bs.modal', function () {
        inicializarFirma();
    });

    function inicializarFirma() {
        canvas = document.getElementById("canvasFirma");
        if (!canvas) return;

        ctx = canvas.getContext("2d");

        const rect = canvas.getBoundingClientRect();
        const ratio = window.devicePixelRatio || 1;

        canvas.width  = rect.width * ratio;
        canvas.height = rect.height * ratio;

        ctx.setTransform(ratio, 0, 0, ratio, 0, 0);

        ctx.lineWidth = 2;
        ctx.lineCap = "round";
        ctx.strokeStyle = "#000";

        canvas.onmousedown = null;
        canvas.onmousemove = null;
        canvas.onmouseup = null;
        canvas.onmouseleave = null;
        canvas.ontouchstart = null;
        canvas.ontouchmove = null;
        canvas.ontouchend = null;

        canvas.addEventListener("mousedown", iniciarDibujo);
        canvas.addEventListener("mousemove", dibujar);
        canvas.addEventListener("mouseup", detenerDibujo);
        canvas.addEventListener("mouseleave", detenerDibujo);

        canvas.addEventListener("touchstart", iniciarDibujo, { passive:false });
        canvas.addEventListener("touchmove", dibujar, { passive:false });
        canvas.addEventListener("touchend", detenerDibujo);
    }

    function obtenerPosicion(e) {
        const rect = canvas.getBoundingClientRect();
        let x, y;

        if (e.touches && e.touches.length > 0) {
            x = e.touches[0].clientX - rect.left;
            y = e.touches[0].clientY - rect.top;
        } else {
            x = e.clientX - rect.left;
            y = e.clientY - rect.top;
        }

        return { x, y };
    }

    function iniciarDibujo(e) {
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

    function detenerDibujo() {
        dibujando = false;
        ctx.beginPath();
    }

    function limpiarFirma() {
        if (!ctx) return;
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        document.getElementById("firmaBase64").value = "";
    }

    function guardarFirma() {
        const imagen = canvas.toDataURL("image/png");

        if (imagen.length < 2000) {
            alert("Debe realizar una firma válida.");
            return;
        }

        document.getElementById("firmaBase64").value = imagen;
        alert("Firma guardada correctamente.");

        const modal = bootstrap.Modal.getInstance(
            document.getElementById('modalFirma')
        );
        modal.hide();
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
</script>

<?php require "App/Views/Templates/Layouts/Footer.php"; ?>
