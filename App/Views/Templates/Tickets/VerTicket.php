<?php
include_once "App/Controllers/DotacionController.php";
include_once "App/Controllers/TicketsController.php";
require_once "App/Views/Templates/Layouts/Header.php";
if (empty($_SESSION['ID'])) {
    header("location:../IniciarSesion");
    exit;
}
$ID = $_SESSION['ID'];
$TicketsController = new TicketsController;
$Listas = $TicketsController->LeerS($ID);

?>
<!-- Sale & Revenue Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <a class="col-sm-6 col-xl-3" href="NuevoTicket">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
            <img width="50" height="50" src="https://img.icons8.com/dotty/80/000020/add-ticket.png" alt="add-ticket"/>
                <div class="ms-3">
                    <p class="mb-2" style="color: #000020;">Nuevo Tickets</p>
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
                <a href="VerTicket">Ver Todas</a>
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
                                        // Mostrar "Chat" si el estado es 0 o 1
                                        if ($Lista['Estado'] == 0 || $Lista['Estado'] == 1) {
                                            echo '<a href="TicketChat?ID=' . htmlspecialchars($Lista['ID']) . '" class="btn btn-sm btn-primary ms-3">
                                                            <img width="20" height="20" src="https://img.icons8.com/ios-glyphs/ffffff/30/chat.png" alt="chat"/> 
                                                        </a>';
                                        }
                                        // Mostrar "Ver" si el estado es 2
                                        elseif ($Lista['Estado'] == 2) {
                                            echo '<a class="btn btn-sm btn-success" target="_blank" href="Ticket?ID=' . urlencode(htmlspecialchars($Lista['ID'])) . '">
                                                    <img width="20" height="20" src="https://img.icons8.com/material-outlined/24/ffffff/visible--v1.png" alt="Ver" /> 
                                                </a>';
                                            
                                            if ($Lista['Estado_Encuesta'] == 0) {
                                                echo '<a href="Encuesta?ID=' . htmlspecialchars($Lista['ID']) . '&ID_Gestiona=' . htmlspecialchars($Lista['ID_Gestiona']) . '" class="btn btn-sm btn-primary ms-3">
                                                        <img width="20" height="20" src="https://img.icons8.com/ios/20/ffffff/survey.png" alt="survey"/> 
                                                    </a>';
                                            }
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

<?php require "App/Views/Templates/Layouts/Footer.php"; ?>