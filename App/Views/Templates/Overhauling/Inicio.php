<?php
require_once "App/Views/Templates/Layouts/Header.php";
include_once "App/Controllers/CentroDeTrabajoController.php";
include_once "App/Controllers/ProductosController.php";

if (empty($_SESSION['ID'])) {
    header("location:../IniciarSesion");
    exit;
}

$ProductosController = new ProductosController;
$CentrosDeTrabajo = new CentroDeTrabajoController;

$ListaCentrosDeTrabajo = $CentrosDeTrabajo->TraerCentrosDeTrabajo();
$ListaMontacargas = $ProductosController->ListaMontacargas($_GET['ID_Centro']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['Tipo'] == "DocumentoEntrega") {
        $ID_Montacarga = $_POST['ID_Montacarga'];
        $ID_Centro = $_POST['ID_Centro'];
        echo "
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                Swal.fire({
                    title: 'Montacargas Encontrado!',
                    text: 'El Numeró de Montacargas es: " . htmlspecialchars($ID_Montacarga) . "',
                    icon: 'success',
                    showCancelButton: true,
                    confirmButtonText: 'Continuar',
                    cancelButtonText: 'Cancelar',
                    allowOutsideClick: false,
                    allowEscapeKey: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        const modalDiagnostico = new bootstrap.Modal(document.getElementById('AgregarDiagnostico'));
                        modalDiagnostico.show();
                    }
                });
            </script>";
    }
}
?>
<!-- Sale & Revenue Start -->
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-6 col-xl-3">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <img width="50" height="50" src="https://img.icons8.com/ios/50/000020/add-rule.png" alt="add-rule" />
                <div class="ms-3">
                    <p class="mb-2" style="color: #000020;">Realizadas</p>
                    <h6 class="mb-0" style="color: #000020;">00000</h6>
                </div>
            </div>
        </div>
        <a class="col-sm-6 col-xl-3" data-bs-toggle="modal" data-bs-target="#NumerDocumentoModal">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <img width="50" height="50" src="https://img.icons8.com/ios/50/000020/new--v1.png" alt="new--v1" />
                <div class="ms-3">
                    <p class="mb-2" style="color: #000020;">Registrar Inspeccion</p>
                </div>
            </div>
        </a>
        <a class="col-sm-6 col-xl-3" href="#">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <img width="50" height="50" src="https://img.icons8.com/pastel-glyph/50/000020/search--v2.png" alt="search--v2" />
                <div class="ms-3">
                    <p class="mb-2" style="color: #000020;">Buscar</p>
                </div>
            </div>
        </a>
        <a class="col-sm-6 col-xl-3" href="#">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <img width="50" height="50" src="https://img.icons8.com/ios/50/000020/document-1.png" alt="document-1" />
                <div class="ms-3">
                    <p class="mb-2" style="color: #000020;">Realizar Informe</p>
                </div>
            </div>
        </a>
    </div>
</div>
<div class="container-fluid pt-4 px-4">
    <div class="bg-light text-center rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <?php
            if (!empty($Centro)) {
                echo '<h6 class="mb-0">Inspecciones Realizadas | ' . htmlspecialchars($Centro) . '</h6>';
            } else {
                echo '<h6 class="mb-0">Inspecciones Realizadas | No disponible</h6>';
            }
            ?>
            <div>
                <a href="#">Ver Todas</a>
                <a> | </a>
                <a href="#">Descargar Excel</a>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table text-start align-middle table-bordered table-hover mb-0" id="myTable">
            <thead>
                <tr class="text-dark">
                    <th scope="col" class="text-center">N°</th>
                    <th scope="col" class="text-center">Fecha</th>
                    <th scope="col" class="text-center">Nombre Realiza</th>
                    <th scope="col" class="text-center"># Montacargas</th>
                    <th scope="col" class="text-center">Serial</th>
                    <th scope="col" class="text-center">Acciones</th>
                </tr><div class="."></div>
            </thead>
            <tbody>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td width="200" class="text-center">
                    <a class="btn btn-sm btn-primary" target="_blank" href="InformeD">
                        <img width="20" height="20" src="https://img.icons8.com/material-outlined/24/ffffff/visible--v1.png" alt="Ver" />
                    </a>
                </td>
            </tbody>
        </table>
    </div>
</div>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $criterios = [];
    for ($i = 1; $i <= 104; $i++) {
        $key = "Criterio_$i";
        $criterios[$key] = isset($_POST[$key]) ? $_POST[$key] : null;
    }

    // Mostrar los criterios que llegaron
    echo "<pre>";
    foreach ($criterios as $nombre => $valor) {
        if ($valor !== null) {
            echo htmlspecialchars($nombre) . ": " . htmlspecialchars($valor) . "\n";
        }
    }
    echo "</pre>";
}
?>
<!-- Modal para Ingresar Usuario -->
<div class="modal fade" id="NumerDocumentoModal" tabindex="-1" aria-labelledby="NumerDocumentoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="NumerDocumentoModalLabel">Ingrese su Número de Documento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form id="documentForm" method="POST">
                    <div class="mb-3">
                        <label for="floatingSelect">Seleccione el centro de trabajo</label>
                        <select class="form-select" name="ID_Centro" id="floatingSelect" aria-label="Floating label select example" required>
                            <option value="" disabled selected>Centro de Trabajo</option>
                            <?php
                            if ($ListaCentrosDeTrabajo) {
                                foreach ($ListaCentrosDeTrabajo as $ListaCentroDeTrabajo) {
                            ?>
                                    <option value="<?= $ListaCentroDeTrabajo['ID'] ?>"><?= $ListaCentroDeTrabajo['Nombre'] ?></option>
                            <?php
                                }
                            }
                            ?>
                        </select>
                        <label for="floatingSelect">Seleccione el numeró de montacargas</label>
                        <select class="form-select" name="ID_Montacarga" id="floatingSelect" aria-label="Floating label select example" required>
                            <option value="" disabled selected># de Montacargas</option>
                            <?php
                            if ($ListaMontacargas) {
                                foreach ($ListaMontacargas as $ListaMontacarga) {
                            ?>
                                    <option value="<?= $ListaMontacarga['ID'] ?>"><?= $ListaMontacarga['Numero'] ?></option>
                            <?php
                                }
                            }
                            ?>
                        </select>
                        <input type="hidden" name="Tipo" value="DocumentoEntrega">
                    </div>
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<form method="POST" enctype="multipart/form-data">
    <!-- Modal para Agregar Diagnostico -->
    <div class="modal fade" id="AgregarDiagnostico" tabindex="-1" aria-labelledby="agregarProductoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white" id="agregarProductoModalLabel">Agregar Diagnostico | Tecnico Encargado: <?= htmlspecialchars($_SESSION['NombreCompleto']) ?> </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <a id="btnBateriaCard" class="col-sm-6 col-xl-3" href="#" data-open-modal="#ModalBateria">
                            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                                <img width="50" height="50" src="https://img.icons8.com/ios-filled/50/000020/charge-battery--v1.png" alt="charge-battery--v1" />
                                <div class="ms-3">
                                    <p class="mb-2" style="color: #000020;">Batería</p>
                                </div>
                            </div>
                        </a>

                        <a id="btnElectricoCard" class="col-sm-6 col-xl-3" href="#" data-open-modal="#ModalElectrico">
                            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                                <img width="50" height="50" src="https://img.icons8.com/ios-filled/50/000020/carbon-brush.png" alt="carbon-brush" />
                                <div class="ms-3">
                                    <p class="mb-2" style="color: #000020;">Sistema Eléctrico</p>
                                </div>
                            </div>
                        </a>
                        <a id="btnHidraulicoCard" class="col-sm-6 col-xl-3" href="#" data-open-modal="#ModalHidraulico">
                            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                                <img width="50" height="50" src="https://img.icons8.com/external-solidglyph-m-oki-orlando/64/000020/external-hydraulic-engineering-engineering-solid-solidglyph-m-oki-orlando.png" alt="external-hydraulic-engineering-engineering-solid-solidglyph-m-oki-orlando" />
                                <div class="ms-3">
                                    <p class="mb-2" style="color: #000020;">Sistema Hidraulico</p>
                                </div>
                            </div>
                        </a>
                        <a id="btnFrenosCard" class="col-sm-6 col-xl-3" href="#" data-open-modal="#ModalFrenos">
                            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                                <img width="50" height="50" src="https://img.icons8.com/ios-filled/50/000020/abs.png" alt="abs" />
                                <div class="ms-3">
                                    <p class="mb-2" style="color: #000020;">Sistema De Frenos</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <br>
                    <div class="row">
                        <a class="col-sm-6 col-xl-3" href="#" data-open-modal="#ModalMastil">
                            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                                <img width="50" height="50" src="https://img.icons8.com/deco-glyph/50/000028/fork-lift.png" alt="fork-lift" />
                                <div class="ms-3">
                                    <p class="mb-2" style="color: #000020;">Mastil</p>
                                </div>
                            </div>
                        </a>
                        <a class="col-sm-6 col-xl-3" href="#" data-open-modal="#ModalAditamientos">
                            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                                <img width="50" height="50" src="https://img.icons8.com/ios-glyphs/50/000020/gearbox-selector.png" alt="gearbox-selector" />
                                <div class="ms-3">
                                    <p class="mb-2" style="color: #000020;">Aditamentos</p>
                                </div>
                            </div>
                        </a>
                        <a class="col-sm-6 col-xl-3" href="#" data-open-modal="#ModalHorquillas">
                            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                                <img width="50" height="50" src="https://img.icons8.com/ios-filled/50/000020/l.png" alt="l" />
                                <div class="ms-3">
                                    <p class="mb-2" style="color: #000020;">Horquillas</p>
                                </div>
                            </div>
                        </a>
                        <a class="col-sm-6 col-xl-3" href="#" data-open-modal="#ModalRuedas">
                            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                                <img width="50" height="50" src="https://img.icons8.com/ios-glyphs/50/000020/wheel.png" alt="wheel" />
                                <div class="ms-3">
                                    <p class="mb-2" style="color: #000020;">Ruedas</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <br>
                    <div class="row">
                        <a class="col-sm-6 col-xl-3" href="#" data-open-modal="#ModalChasis">
                            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                                <img width="50" height="50" src="https://img.icons8.com/ios-glyphs/50/000020/4x4-vehicle.png" alt="4x4-vehicle" />
                                <div class="ms-3">
                                    <p class="mb-2" style="color: #000020;">Chasis</p>
                                </div>
                            </div>
                        </a>
                        <a class="col-sm-6 col-xl-3" href="#" data-open-modal="#ModalLubricacion">
                            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                                <img width="50" height="50" src="https://img.icons8.com/ios-filled/50/000020/engine-oil-level.png" alt="engine-oil-level" />
                                <div class="ms-3">
                                    <p class="mb-2" style="color: #000020;">Lubricacíon</p>
                                </div>
                            </div>
                        </a>
                        <a class="col-sm-6 col-xl-3" href="#" data-open-modal="#ModalRevision">
                            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                                <img width="50" height="50" src="https://img.icons8.com/ios-filled/50/000020/fork-lift.png" alt="fork-lift" />
                                <div class="ms-3">
                                    <p class="mb-2" style="color: #000020;">Revision De Equipo</p>
                                </div>
                            </div>
                        </a>
                        <a class="col-sm-6 col-xl-3" href="#" data-open-modal="#ModalLuces">
                            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                                <img width="50" height="50" src="https://img.icons8.com/ios-filled/50/000020/headlight.png" alt="headlight" />
                                <div class="ms-3">
                                    <p class="mb-2" style="color: #000020;">Luces y Alarmas</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <br>
                    <div class="row">
                        <a class="col-sm-6 col-xl-3" href="#" data-open-modal="#ModalDireccion">
                            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                                <img width="50" height="50" src="https://img.icons8.com/ios-filled/50/000020/steering-wheel.png" alt="steering-wheel" />
                                <div class="ms-3">
                                    <p class="mb-2" style="color: #000020;">Sistema De Dirección</p>
                                </div>
                            </div>
                        </a>
                        <a class="col-sm-6 col-xl-3" href="#" data-open-modal="#ModalTraccion">
                            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                                <img width="50" height="50" src="https://img.icons8.com/ios-filled/50/000020/traction-control.png" alt="traction-control" />
                                <div class="ms-3">
                                    <p class="mb-2" style="color: #000020;">Sistema De Tracción</p>
                                </div>
                            </div>
                        </a>
                        <a class="col-sm-6 col-xl-3" href="#" data-open-modal="#ModalCarroPorta">
                            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                                <img width="50" height="50" src="https://img.icons8.com/sf-regular-filled/50/000020/mine-cart.png" alt="mine-cart" />
                                <div class="ms-3">
                                    <p class="mb-2" style="color: #000020;">Carro Porta Horquillas</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary mt-3">Agregar</button>
                </div>
            </div>
        </div>
    </div>
    <style>
        .select-bueno {
            background-color: #d4edda !important;
            /* verde claro */
        }

        .select-malo {
            background-color: #fff3cd !important;
            /* amarillo claro */
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

    <!-- Bateria -->
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
                        <label for="estadoCables" class="form-label">Estado de cables</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select me-2" id="estadoCables" name="Criterio_1" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoCables"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoElectrolito" class="form-label">Nivel de electrolito</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select me-2" id="estadoElectrolito" name="Criterio_2" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoConector" class="form-label">Conector anderson</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select me-2" id="estadoConector" name="Criterio_3" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoConector"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoComportartimiento" class="form-label">Comportartimiento de la batería</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select me-2" id="estadoComportartimiento" name="Criterio_4" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoComportartimiento"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoBateria" class="form-label">Estado de batería</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select me-2" id="estadoBateria" name="Criterio_5" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoBateria"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoPuentes" class="form-label">Estado de los puentes</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select me-2" id="estadoPuentes" name="Criterio_6" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
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
                select.classList.remove('select-bueno', 'select-malo', 'select-vacio');

                if (select.value === 'Buena') {
                    icon.textContent = '✔️';
                    icon.style.color = 'green';
                    select.classList.add('select-bueno');
                } else if (select.value === 'Mala') {
                    icon.textContent = '⚠️';
                    icon.style.color = 'orange';
                    select.classList.add('select-malo');
                } else {
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
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoPotencia"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoDesconector" class="form-label">Desconector de emergencia</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoDesconector" name="Criterio_8" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoDesconector"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoControl" class="form-label">Cables de control</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoControl" name="Criterio_9" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoControl"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoConectores" class="form-label">Conectores</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoConectores" name="Criterio_10" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoConectores"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoFusibles" class="form-label">Fusibles</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoFusibles" name="Criterio_11" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoFusibles"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoControlador" class="form-label">Controlador</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoControlador" name="Criterio_12" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoControlador"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoDisplay" class="form-label">Display</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoDisplay" name="Criterio_13" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoDisplay"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoContactor" class="form-label">Contactor linea</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoContactor" name="Criterio_14" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoContactor"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoDireccion" class="form-label">Contactor direccion</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoDireccion" name="Criterio_15" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoDireccion"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoElevacion" class="form-label">Contactor elevacion</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoElevacion" name="Criterio_16" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElevacion"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoMarcha" class="form-label">Contactor marcha</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoMarcha" name="Criterio_17" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoMarcha"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoMicros" class="form-label">Micros</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoMicros" name="Criterio_18" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoMicros"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoSwitch" class="form-label">Switch de ignicion</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoSwitch" name="Criterio_19" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoSwitch"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoPotenciometro" class="form-label">Potenciometro de aceleracion</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoPotenciometro" name="Criterio_20" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoPotenciometro"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="imagenesDiagnosticoEletrico" class="form-label">Subir Imágenes del Diagnóstico</label>
                        <input class="form-control" type="file" id="imagenesDiagnosticoEletrico" name="imagenesDiagnosticoEletrico[]" accept="image/*" multiple>
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

            function actualizarEstadoElectrico(selectElectrico) {
                const iconElectrico = document.getElementById(`icon-${selectElectrico.id}`);
                selectElectrico.classList.remove('select-bueno', 'select-malo', 'select-vacio');

                if (selectElectrico.value === 'Buena') {
                    console.log(iconElectrico);
                    iconElectrico.textContent = '✔️';
                    iconElectrico.style.color = 'green';
                    selectElectrico.classList.add('select-bueno');
                } else if (selectElectrico.value === 'Mala') {
                    iconElectrico.textContent = '⚠️';
                    iconElectrico.style.color = 'orange';
                    selectElectrico.classList.add('select-malo');
                } else {
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

    <!-- Sistema Hidraulico -->
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
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoHidraulico"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoMotor" class="form-label">Motor de sistema hidráulico</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoMotor" name="Criterio_22" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoMotor"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoEscobillas" class="form-label">Escobillas</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoEscobillas" name="Criterio_23" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoEscobillas"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoCaucho" class="form-label">Caucho absorbedor de golpe</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoCaucho" name="Criterio_24" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoCaucho"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoBomba" class="form-label">Bomba sistema hidráulico</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoBomba" name="Criterio_25" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoBomba"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoFiltro" class="form-label">Filtro de retorno</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoFiltro" name="Criterio_26" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoFiltro"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoValvulas" class="form-label">Cuerpo de válvulas</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoValvulas" name="Criterio_27" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoValvulas"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoMangueras" class="form-label">Mangueras</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoMangueras" name="Criterio_28" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoMangueras"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoMicros" class="form-label">Micros de funciones hidráulicas</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoMicros" name="Criterio_29" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoMicros"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="imagenesDiagnosticoHidraulico" class="form-label">Subir Imágenes del Diagnóstico</label>
                        <input class="form-control" type="file" id="imagenesDiagnosticoHidraulico" name="imagenesDiagnosticoHidraulico[]" accept="image/*" multiple>
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

            function actualizarEstadoHidraulico(selectHidraulico) {
                const iconHidraulico = document.getElementById(`icon-${selectHidraulico.id}`);
                selectHidraulico.classList.remove('select-bueno', 'select-malo', 'select-vacio');

                if (selectHidraulico.value === 'Buena') {
                    console.log(iconHidraulico);
                    iconHidraulico.textContent = '✔️';
                    iconHidraulico.style.color = 'green';
                    selectHidraulico.classList.add('select-bueno');
                } else if (selectHidraulico.value === 'Mala') {
                    iconHidraulico.textContent = '⚠️';
                    iconHidraulico.style.color = 'orange';
                    selectHidraulico.classList.add('select-malo');
                } else {
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

    <!-- Sistema de frenos -->
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
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoLiquido"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoBomba2" class="form-label">Bomba de freno principal</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoBomba2" name="Criterio_31" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoBomba2"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoBandas" class="form-label">Estado de bandas</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoBandas" name="Criterio_32" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoBandas"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoRodamientos" class="form-label">Rodamientos</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoRodamientos" name="Criterio_33" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoRodamientos"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoFreno" class="form-label">Freno de estacionamiento</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoFreno" name="Criterio_34" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoFreno"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoFrenado" class="form-label">Eficiencia de frenado</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoFrenado" name="Criterio_35" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoFrenado"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoGuayas" class="form-label">Guayas de parqueo</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoGuayas" name="Criterio_36" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoGuayas"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoPedal" class="form-label">Pedal de freno</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoPedal" name="Criterio_37" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoPedal"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="imagenesDiagnosticoFrenos" class="form-label">Subir Imágenes del Diagnóstico</label>
                        <input class="form-control" type="file" id="imagenesDiagnosticoFrenos" name="imagenesDiagnosticoFrenos[]" accept="image/*" multiple>
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

            function actualizarEstadoFreno(selectFreno) {
                const iconFreno = document.getElementById(`icon-${selectFreno.id}`);
                selectFreno.classList.remove('select-bueno', 'select-malo', 'select-vacio');

                if (selectFreno.value === 'Buena') {
                    console.log(iconFreno);
                    iconFreno.textContent = '✔️';
                    iconFreno.style.color = 'green';
                    selectFreno.classList.add('select-bueno');
                } else if (selectFreno.value === 'Mala') {
                    iconFreno.textContent = '⚠️';
                    iconFreno.style.color = 'orange';
                    selectFreno.classList.add('select-malo');
                } else {
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
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoSecciones" class="form-label">Estado secciones</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoSecciones" name="estadoSecciones" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoBujes" class="form-label">Bujes</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoBujes" name="estadoBujes" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoRodamientos" class="form-label">Rodamientos</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoRodamientos" name="estadoRodamientos" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoCadenas" class="form-label">Cadenas</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoCadenas" name="estadoCadenas" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoPasadores" class="form-label">Pasadores cadenas</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoPasadores" name="estadoPasadores" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoManguerasF" class="form-label">Mangueras free lift</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoManguerasF" name="estadoManguerasF" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoManguerasS" class="form-label">Mangueras side shift</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoManguerasS" name="estadoManguerasS" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoManguerasP" class="form-label">Mangueras fork positioner</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoManguerasP" name="estadoManguerasP" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoTuberias" class="form-label">Tuberías</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoTuberias" name="estadoTuberias" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoRacores" class="form-label">Racores</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoRacores" name="estadoRacores" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoCilindrosI" class="form-label">Cilindros de inclinacion</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoCilindrosI" name="estadoCilindrosI" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoCilindrosF" class="form-label">Cilindro de free lift</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoCilindrosF" name="estadoCilindrosF" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoCilindrosL" class="form-label">Cilindros laterales</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoCilindrosL" name="estadoCilindrosL" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoCilindrosS" class="form-label">Cilindro de side shift</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoCilindrosS" name="estadoCilindrosS" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoCilindrosP" class="form-label">Cilindros de fork positioner</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoCilindrosP" name="estadoCilindrosP" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="imagenesDiagnosticoMastil" class="form-label">Subir Imágenes del Diagnóstico</label>
                        <input class="form-control" type="file" id="imagenesDiagnosticoMastil" name="imagenesDiagnosticoMastil[]" accept="image/*" multiple>
                    </div>
                    <button type="button" class="btn text-white" style="background-color: #000020;">Guardar Diagnóstico</button>

                </div>
            </div>
        </div>
    </div>

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
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoForkPositioner" class="form-label">Fork positioner</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoForkPositioner" name="estadoForkPositioner" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoClamp" class="form-label">Clamp</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoClamp" name="estadoClamp" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoTubular" class="form-label">Cascade Tubular</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoTubular" name="estadoTubular" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="imagenesDiagnosticoAditamientos" class="form-label">Subir Imágenes del Diagnóstico</label>
                        <input class="form-control" type="file" id="imagenesDiagnosticoAditamientos" name="imagenesDiagnosticoAditamientos[]" accept="image/*" multiple>
                    </div>
                    <button type="button" class="btn text-white" style="background-color: #000020;">Guardar Diagnóstico</button>

                </div>
            </div>
        </div>
    </div>

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
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoMordazaS" class="form-label">Mordaza superior</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoMordazaS" name="estadoMordazaS" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoMordazaI" class="form-label">Mordaza inferior</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoMordazaI" name="estadoMordazaI" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoHorquillas" class="form-label">Estado de horquillas (inspección visual ver F-206 como referencia)</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoHorquillas" name="estadoHorquillas" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="imagenesDiagnosticoHorquillas" class="form-label">Subir Imágenes del Diagnóstico</label>
                        <input class="form-control" type="file" id="imagenesDiagnosticoHorquillas" name="imagenesDiagnosticoHorquillas[]" accept="image/*" multiple>
                    </div>
                    <button type="button" class="btn text-white" style="background-color: #000020;">Guardar Diagnóstico</button>

                </div>
            </div>
        </div>
    </div>

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
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoRuedasD" class="form-label">Degaste de caucho de ruedas de dirección</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoRuedasD" name="estadoRuedasD" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoRinC" class="form-label">Estado de rin de carga</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoRinC" name="estadoRinC" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoRinD" class="form-label">Estado de rin de dirección</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoRinD" name="estadoRinD" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoLimpieza" class="form-label">Limpieza</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoLimpieza" name="estadoLimpieza" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="imagenesDiagnosticoRuedas" class="form-label">Subir Imágenes del Diagnóstico</label>
                        <input class="form-control" type="file" id="imagenesDiagnosticoRuedas" name="imagenesDiagnosticoRuedas[]" accept="image/*" multiple>
                    </div>
                    <button type="button" class="btn text-white" style="background-color: #000020;">Guardar Diagnóstico</button>

                </div>
            </div>
        </div>
    </div>

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
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoSoportes" class="form-label">Chequear soportes</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoSoportes" name="estadoSoportes" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoTornilleria" class="form-label">Tornilleria</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoTornilleria" name="estadoTornilleria" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoPintura" class="form-label">Estado pintura</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoPintura" name="estadoPintura" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="imagenesDiagnosticoChasis" class="form-label">Subir Imágenes del Diagnóstico</label>
                        <input class="form-control" type="file" id="imagenesDiagnosticoChasis" name="imagenesDiagnosticoChasis[]" accept="image/*" multiple>
                    </div>
                    <button type="button" class="btn text-white" style="background-color: #000020;">Guardar Diagnóstico</button>

                </div>
            </div>
        </div>
    </div>

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
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoEngraseM" class="form-label">Engrase mastil</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoEngraseM" name="estadoEngraseM" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoLubricacion" class="form-label">Lubricacíon cadenas y secciones mastil</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoLubricacion" name="estadoLubricacion" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="imagenesDiagnosticoLubricacion" class="form-label">Subir Imágenes del Diagnóstico</label>
                        <input class="form-control" type="file" id="imagenesDiagnosticoLubricacion" name="imagenesDiagnosticoLubricacion[]" accept="image/*" multiple>
                    </div>
                    <button type="button" class="btn text-white" style="background-color: #000020;">Guardar Diagnóstico</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ModalRevision" tabindex="-1" aria-labelledby="ModalRevisionLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #000020;">
                    <h5 class="modal-title text-white" id="ModalRevisionLabel">Diagnóstico: Revision de Equipo</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="estadoLimpieza" class="form-label">Limpieza del equipo</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoLimpieza" name="estadoLimpieza" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoHorometro" class="form-label">Horómetro</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoHorometro" name="estadoHorometro" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoEtiquetas" class="form-label">Etiquetas de seguridad</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoEtiquetas" name="estadoEtiquetas" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoTapas" class="form-label">Tapas</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoTapas" name="estadoTapas" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoCapo" class="form-label">Capó y amortiguador</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoCapo" name="estadoCapo" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoSilla" class="form-label">Silla</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoSilla" name="estadoSilla" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoCinturon" class="form-label">Cinturon de seguridad</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoCinturon" name="estadoCinturon" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoExtintor" class="form-label">Extintor</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoExtintor" name="estadoExtintor" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="imagenesDiagnosticoRevision" class="form-label">Subir Imágenes del Diagnóstico</label>
                        <input class="form-control" type="file" id="imagenesDiagnosticoRevision" name="imagenesDiagnosticoRevision[]" accept="image/*" multiple>
                    </div>
                    <button type="button" class="btn text-white" style="background-color: #000020;">Guardar Diagnóstico</button>

                </div>
            </div>
        </div>
    </div>

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
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoLuzE" class="form-label">Luz estroboscopia</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoLuzE" name="estadoLuzE" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoLuzF" class="form-label">Luz de freno</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoLuzF" name="estadoLuzF" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoBlue" class="form-label">Blue light</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoTapas" name="estadoTapas" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoPito" class="form-label">Pito bocina</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoPito" name="estadoPito" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoAlarma" class="form-label">Alarma reversa</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoAlarma" name="estadoAlarma" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="imagenesDiagnosticoLuces" class="form-label">Subir Imágenes del Diagnóstico</label>
                        <input class="form-control" type="file" id="imagenesDiagnosticoLuces" name="imagenesDiagnosticoLuces[]" accept="image/*" multiple>
                    </div>
                    <button type="button" class="btn text-white" style="background-color: #000020;">Guardar Diagnóstico</button>

                </div>
            </div>
        </div>
    </div>

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
                            <select class="form-select" id="estadoMotor" name="estadoMotor" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoEscobillas" class="form-label">Escobillas</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoEscobillas" name="estadoEscobillas" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoBomba" class="form-label">Bomba de dirección</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoBomba" name="estadoBomba" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoMangueras" class="form-label">Mangueras</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoMangueras" name="estadoMangueras" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoCilindro" class="form-label">Cilindro de dirección</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoCilindro" name="estadoCilindro" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoCauchos" class="form-label">Cauchos puente trasero</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoCauchos" name="estadoCauchos" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoRotulas" class="form-label">Rótulas</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoRotulas" name="estadoRotulas" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoGuarda" class="form-label">Guarda polvo</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoGuarda" name="estadoGuarda" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoRodamientos" class="form-label">Rodamientos</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoRodamientos" name="estadoRodamientos" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoOrbitrol" class="form-label">Orbitrol</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoOrbitrol" name="estadoOrbitrol" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoTerminales" class="form-label">Terminales de dirección</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoTerminales" name="estadoTerminales" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="imagenesDiagnosticoDireccion" class="form-label">Subir Imágenes del Diagnóstico</label>
                        <input class="form-control" type="file" id="imagenesDiagnosticoDireccion" name="imagenesDiagnosticoDireccion[]" accept="image/*" multiple>
                    </div>
                    <button type="button" class="btn text-white" style="background-color: #000020;">Guardar Diagnóstico</button>

                </div>
            </div>
        </div>
    </div>

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
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoEscobillas" class="form-label">Escobillas</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoEscobillas" name="estadoEscobillas" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoMicros" class="form-label">Micros de marchas</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoMicros" name="estadoMicros" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoTransmision" class="form-label">Transmisión</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoTransmision" name="estadoTransmision" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoValvulina" class="form-label">Nivel de valvulina</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoValvulina" name="estadoValvulina" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoTornilleria" class="form-label">Tornilleria</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoTornilleria" name="estadoTornilleria" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="imagenesDiagnosticoTraccion" class="form-label">Subir Imágenes del Diagnóstico</label>
                        <input class="form-control" type="file" id="imagenesDiagnosticoTraccion" name="imagenesDiagnosticoTraccion[]" accept="image/*" multiple>
                    </div>
                    <button type="button" class="btn text-white" style="background-color: #000020;">Guardar Diagnóstico</button>

                </div>
            </div>
        </div>
    </div>

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
                            <select class="form-select" id="estadoAjuste" name="estadoAjuste" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoRodamientos" class="form-label">Rodamientos</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoRodamientos" name="estadoRodamientos" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoCadenas" class="form-label">Cadenas</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoCadenas" name="estadoCadenas" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoPasadores" class="form-label">Pasadores</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoPasadores" name="estadoPasadores" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoParilla" class="form-label">Parilla o Espejo</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoParilla" name="estadoParilla" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoMordazas" class="form-label">Mordazas</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoMordazas" name="estadoMordazas" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="estadoDeslizadores" class="form-label">Deslizadores</label>
                        <div class="d-flex align-items-center">
                            <select class="form-select" id="estadoDeslizadores" name="estadoDeslizadores" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Buena">Bueno</option>
                                <option value="Mala">Malo</option>
                            </select>
                            <span class="estado-icon" id="icon-estadoElectrolito"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="imagenesDiagnosticoCarroPorta" class="form-label">Subir Imágenes del Diagnóstico</label>
                        <input class="form-control" type="file" id="imagenesDiagnosticoCarroPorta" name="imagenesDiagnosticoCarroPorta[]" accept="image/*" multiple>
                    </div>
                    <button type="button" class="btn text-white" style="background-color: #000020;">Guardar Diagnóstico</button>

                </div>
            </div>
        </div>
    </div>
</form>
<!-- Validación con colores de fondo -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modalPrincipal = new bootstrap.Modal(document.getElementById('AgregarDiagnostico'));

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
</script>
<?php require "App/Views/Templates/Layouts/Footer.php"; ?>