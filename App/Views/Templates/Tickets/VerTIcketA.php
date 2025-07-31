<?php
include_once "App/Controllers/DotacionController.php";
include_once "App/Controllers/TicketsController.php";
require_once "App/Views/Templates/Layouts/Header.php";

if (empty($_SESSION['ID'])) {
    header("location:../IniciarSesion");
    exit;
}
$TicketsController = new TicketsController;
$Listas = $TicketsController->Leer();

$ID_Excluir = $_SESSION['ID'];
$DataUsuarios = $TicketsController->ObtenerUsuarios($ID_Excluir);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['Aceptar'])) {
        $ID_Ticket = intval($_POST['Aceptar']);  
        $ID_Gestiona = $_SESSION['ID'];
        $Nombre1 = $_SESSION['Nombre1'];
        $TicketsController->AceptarTicket($ID_Ticket, $ID_Gestiona, $Nombre1);
    }

    if (isset($_POST['Finalizar'])) {
        $ID_Ticket = intval($_POST['Finalizar']);  
        $ID_Gestiona = $_SESSION['ID'];
        $Nombre1 = $_SESSION['Nombre1'];
        $NombreCompleto = $_POST['Nombre'];
        $Correo = $_POST['Correo'];
        
        $TicketsController->FinalizarTicket($ID_Ticket, $ID_Gestiona, $Nombre1, $Correo, $NombreCompleto);
    }

    // Procesar la transferencia del ticket
    if (isset($_POST['ID_Ticket'], $_POST['ID_Gestiona'])) {

        $ID_Transfiere = $_SESSION['ID'];
        $Nombre = $_SESSION['Nombre1'];
        $ID_Ticket = intval($_POST['ID_Ticket']);
        $ID_Gestiona = $_POST['ID_Gestiona'];
        $Nombre1 = $_POST['Nombre1'];
        $TicketsController->TransferirTicket($ID_Ticket, $ID_Gestiona, $ID_Transfiere, $Nombre, $Nombre1);
    }
}

?>
<!-- Sale & Revenue Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
    <a class="col-sm-6 col-xl-3" href="?estado=0">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <img width="50" height="50" src="https://img.icons8.com/dotty/80/000020/data-pending.png" alt="data-pending"/>
                <div class="ms-3">
                    <p class="mb-2" style="color: #000020;">Tickets Pendientes</p>
                </div>
            </div>
        </a>
        <a class="col-sm-6 col-xl-3" href="?estado=1">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <img width="50" height="50" src="https://img.icons8.com/dotty/80/000020/data-pending.png" alt="data-pending"/>
                <div class="ms-3">
                    <p class="mb-2" style="color: #000020;">Tickets En Progreso</p>
                </div>
            </div>
        </a>
        <a class="col-sm-6 col-xl-3" href="?estado=2">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <img width="50" height="50" src="https://img.icons8.com/ios/50/000020/ticket-confirmed.png" alt="ticket-confirmed"/>
                <div class="ms-3">
                    <p class="mb-2" style="color: #000020;">Tickets Finalizados</p>
                </div>
            </div>
        </a>
        <a class="col-sm-6 col-xl-3" href="#">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
            <img width="50" height="50" src="https://img.icons8.com/pastel-glyph/50/000020/search--v2.png" alt="search--v2"/>
                <div class="ms-3">
                    <p class="mb-2" style="color: #000020;">Buscar</p>
                </div>
            </div>
        </a>
    </div>
</div>
<div class="container-fluid pt-4 px-4">
    <div class="bg-light text-center rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <a href="VerTicketA">Ver Todas</a>
                <a> | </a>
                <a href="#">Descargar Excel</a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table text-start align-middle table-bordered table-hover mb-0" id="myTable">
                <thead>
                    <tr class="text-dark">
                        <th scope="col">Codigo</th>
                        <th scope="col">Solicitante</th>
                        <th scope="col">Gestiona</th>
                        <th scope="col">Tipo</th>        
                        <th scope="col">Estado</th>                               
                        <th scope="col">Acciones</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                        if ($Listas) {
                            // Obtener el parámetro "estado" de la URL, si está presente
                            $estadoFiltrar = isset($_GET['estado']) ? intval($_GET['estado']) : null;

                            foreach ($Listas as $Lista) {
                                // Filtrar según el estado pasado en la URL
                                if ($estadoFiltrar !== null && $Lista['Estado'] != $estadoFiltrar) {
                                    continue; // Saltamos a la siguiente iteración si el estado no coincide con el filtro
                                }
                                ?>
                                <tr data-id="<?= htmlspecialchars($Lista['ID']) ?>">
                                    <td><?= htmlspecialchars($Lista['ID']) ?></td>
                                    <td><?= htmlspecialchars($Lista['NombreUsuario']) ?></td>
                                    <td><?= htmlspecialchars($Lista['NombreGestiona']) ?></td>
                                    <td><?= htmlspecialchars($Lista['Tipo']) ?></td>
                                    <td>
                                        <?php
                                        if ($Lista['Estado'] == 0) {
                                            echo '<div class="progress">
                                                    <div class="progress-bar bg-danger" role="progressbar" style="width: 100%;">Pendiente</div>
                                                </div>';
                                        } elseif ($Lista['Estado'] == 1) {
                                            echo '<div class="progress">
                                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 100%;">En Progreso</div>
                                                </div>';
                                        } elseif ($Lista['Estado'] == 2) {
                                            echo '<div class="progress">
                                                    <div class="progress-bar bg-success" role="progressbar" style="width: 100%;">Realizado</div>
                                                </div>';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        // Mostrar "Aceptar Ticket" si el estado es 0 o 1
                                        if ($Lista['Estado'] == 0 || $Lista['Estado'] == 1) {
                                             // Abrir el chat
                                            if ($Lista['ID_Gestiona'] !== null && $Lista['ID_Gestiona'] == $_SESSION['ID']) {
                                                echo '<a href="TicketChat?ID=' . htmlspecialchars($Lista['ID']) . '" class="btn btn-sm btn-primary ms-3">
                                                            <img width="20" height="20" src="https://img.icons8.com/ios-glyphs/ffffff/30/chat.png" alt="chat"/> 
                                                        </a>';
                                            }
                                            // Cambiar Estado
                                            if ($Lista['ID_Gestiona'] !== null && $Lista['ID_Gestiona'] == $_SESSION['ID']) {
                                                echo '<form method="POST" style="display:inline;">
                                                            <input type="hidden" name="Finalizar" value="' . htmlspecialchars($Lista['ID']) . '">
                                                            <input type="hidden" name="Nombre" value="' . htmlspecialchars($Lista['NombreUsuario']) . '">
                                                            <input type="hidden" name="Correo" value="' . htmlspecialchars($Lista['CorreoUsuario']) . '">
                                                            <button type="submit" class="btn btn-sm btn-success ms-3">
                                                                <img width="20" height="20" src="https://img.icons8.com/windows/32/ffffff/check-document.png" alt="check-document"/>
                                                            </button>
                                                        </form>';
                                            }

                                            // Mostrar "Transferir" solo si ID_Gestiona no es null y si el ID de la sesión coincide con ID_Gestiona
                                            if ($Lista['ID_Gestiona'] !== null && $Lista['ID_Gestiona'] == $_SESSION['ID']) {
                                                echo '<a href="#" class="btn btn-sm btn-info ms-3" data-bs-toggle="modal" data-bs-target="#transferModal" data-ticket-id="' . htmlspecialchars($Lista['ID']) . '">
                                                            <img width="20" height="20" src="https://img.icons8.com/ios-filled/50/ffffff/data-in-both-directions.png" alt="data-in-both-directions"/>
                                                        </a>';
                                            }
                                            // Solo mostrar el botón de "Aceptar Ticket" si Estado_Aceptacion es 0
                                            if ($Lista['Estado_Aceptacion'] == 0) {
                                                echo '<form method="POST" style="display:inline;">
                                                        <input type="hidden" name="Aceptar" value="' . htmlspecialchars($Lista['ID']) . '">
                                                        <button type="submit" class="btn btn-sm btn-primary ms-3">
                                                            <img width="20" height="20" src="https://img.icons8.com/ios-filled/ffffff/50/service.png" alt="service"/>
                                                        </button>
                                                </form>';
                                            }
                                        }
                                        // Mostrar "Ver" si el estado es 2
                                        elseif ($Lista['Estado'] == 2) {
                                            echo '<a class="btn btn-sm btn-success" target="_blank" href="Ticket?ID=' . urlencode(htmlspecialchars($Lista['ID'])) . '">
                                                    <img width="20" height="20" src="https://img.icons8.com/material-outlined/24/ffffff/visible--v1.png" alt="Ver" /> 
                                                </a>';
                                        }
                                        ?>
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

<!-- Modal para Transferir Ticket -->
<div class="modal fade" id="transferModal" tabindex="-1" aria-labelledby="transferModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="transferModalLabel">Seleccionar Usuario para Transferir</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="transferForm">
                    <input type="hidden" name="ID_Ticket" id="ID_Ticket">
                    <input type="hidden" name="ID_Gestiona" id="ID">
                    <input type="hidden" name="Nombre1" id="Nombre1">
                    <div class="mb-3">
                        <label for="userSelect" class="form-label">Usuarios Disponibles</label>
                        <select name="Usuarios" id="Usuarios" onchange="mostrarUsuario()" required>
                            <option value=""></option> 
                            <?php
                                if ($DataUsuarios) {
                                    foreach ($DataUsuarios as $Usuario) {
                            ?>
                            <option value="<?= htmlspecialchars($Usuario['ID'] . '|' . $Usuario['Nombre1']) ?>">
                                <?= htmlspecialchars($Usuario['NombreCompleto']) ?>
                            </option>
                            <?php
                                    }
                                }                                   
                            ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Transferir</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    
    document.addEventListener('DOMContentLoaded', function() {
        var transferModal = document.getElementById('transferModal');
        transferModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget; 
            var ticketId = button.getAttribute('data-ticket-id'); 
            document.getElementById('ID_Ticket').value = ticketId; 
        });
    });


    function mostrarUsuario() {
            var select = document.getElementById("Usuarios");
            var selectedValue = select.value;
            
            if (!selectedValue) {
                document.getElementById("UsuarioSeleccionado").innerText = '';
                return;
            }

            var UsuarioSeleccionado = select.options[select.selectedIndex].text;
            var parts = selectedValue.split('|');
            var ID_Gestiona = parts[0];
            var Nombre1 = parts[1];
            document.getElementById("ID").value = ID_Gestiona;
            document.getElementById("Nombre1").value = Nombre1;

            document.getElementById("UsuarioSeleccionado").innerText = UsuarioSeleccionado;
    }  

</script>




<?php require "App/Views/Templates/Layouts/Footer.php"; ?>