<?php 
    include_once "App/Views/Templates/Empleados/ComponentesVer/Header.php";
    $UsuarioRegistrado = $UsuarioController->Mostrar($ID);
    if ($UsuarioRegistrado) {
?>
    <div class="container-fluid pt-4 px-4">        
        <?php include_once "App/Views/Templates/Empleados/ComponentesVer/BarraSuperior.php" ?>
        <div class="row">
            <div class="col-md-12">
                <?php include_once "App/Views/Templates/Empleados/ComponentesVer/InformacionPersonal.php"; ?>
            </div>
            <div class="col-md-12">
                <div class="row">    
                    <?php include_once "App/Views/Templates/Empleados/ComponentesVer/Familiar.php"; ?>
                    <?php include_once "App/Views/Templates/Empleados/ComponentesVer/Educacion.php"; ?>              
                    <?php include_once "App/Views/Templates/Empleados/ComponentesVer/Documentos.php"; ?>   
                    <?php include_once "App/Views/Templates/Empleados/ComponentesVer/Afiliaciones.php"; ?>        
                </div>

                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #000020; cursor: pointer; text-align: center;" data-bs-toggle="collapse" data-bs-target="#ExamenesCollapse" aria-expanded="false" aria-controls="ExamenesCollapse">
                        <div>
                            Examenes Médicos
                        </div>
                        <a href="../Empleados/ExamenesRegistrar?ID=<?= $ID ?>" class="btn btn-sm btn-primary">
                            <img width="20" height="20" src="https://img.icons8.com/windows/ffffff/32/add--v1.png" alt="add--v1" />
                        </a>
                    </div>
                    <div id="ExamenesCollapse" class="collapse">
                        <div class="card-body text-white">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th style="color: #000020;">Nombre</th>
                                            <th style="color: #000020;">Fecha Realizado</th>
                                            <th style="color: #000020;">Fecha Vencimiento</th>
                                            <th style="color: #000020;">Estado</th>
                                            <th style="color: #000020;"> </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($DataExamenes) {
                                            foreach ($DataExamenes as $DataExamen) {
                                                $fechaVencimiento = DateTime::createFromFormat('Y-m-d', $DataExamen['Fecha_Vencimiento']);
                                                $fechaActual = new DateTime($Fecha);
                                                $interval = $fechaActual->diff($fechaVencimiento);
                                                if ($fechaActual > $fechaVencimiento) {
                                                    $estado = 'Vencido';
                                                    $tipoBoton = 'bg-danger';
                                                } elseif ($interval->days <= 30) {
                                                    $estado = 'Por Vencer';
                                                    $tipoBoton = 'bg-warning';
                                                } else {
                                                    $estado = 'Activo';
                                                    $tipoBoton = 'bg-success';
                                                } ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($DataExamen['Nombre']) ?></td>
                                                    <td><?= htmlspecialchars($DataExamen['Fecha_Realizado']) ?></td>
                                                    <td><?= htmlspecialchars($DataExamen['Fecha_Vencimiento']) ?></td>
                                                    <td>
                                                        <div class="progress">
                                                            <div class="progress-bar <?= $tipoBoton ?>" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"><?= htmlspecialchars($estado) ?></div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <a href="../App/Views/Upload/Documents/Examenes/<?= $DataExamen['Documento'] ?>" class="btn btn-sm btn-primary" target="_blank">
                                                            <img width="20" height="20" src="https://img.icons8.com/material-outlined/24/ffffff/visible--v1.png" alt="Ver" />
                                                        </a>
                                                    </td>
                                                </tr>
                                        <?php }
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
        
                <div class="row">
                    <div class="col-md-7">
                        <div class="card mb-7">
                            <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #000020; cursor: pointer; text-align: center;" data-bs-toggle="collapse" data-bs-target="#comparendosCollapse" aria-expanded="false" aria-controls="comparendosCollapse">
                                <div>
                                    Comparendos
                                </div>
                                <div>
                                    <a href="../Empleados/ComparendosRegistrar?ID=<?= $ID ?>" class="btn btn-sm btn-primary">
                                        <img width="20" height="20" src="https://img.icons8.com/windows/ffffff/32/add--v1.png" alt="add--v1" />
                                    </a>
                                </div>
                            </div>
                            <div id="comparendosCollapse" class="collapse">
                            <div class="card-body text-white">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th style="color: #000020;">Nombre</th>
                                                    <th style="color: #000020;">Fecha Realizado</th>
                                                    <th style="color: #000020;">Estado</th>
                                                    <th Style="color: #000020;" colspan="2">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if ($DataComparendos) {
                                                    foreach ($DataComparendos as $DataComparendo) {
                                                        if (htmlspecialchars($DataComparendo['Estado']) === 'Por Pagar') {
                                                            $tipoBoton = 'bg-danger';
                                                        }else{
                                                            $tipoBoton = 'bg-success';
                                                        }
                                                ?>
                                                    <tr>
                                                        <td><?= htmlspecialchars($DataComparendo['Nombre']) ?></td>
                                                        <td><?= htmlspecialchars($DataComparendo['Fecha_Realizado']) ?></td>
                                                        <td>
                                                            <div class="progress">
                                                                <div class="progress-bar <?= $tipoBoton ?>" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"><?= htmlspecialchars($DataComparendo['Estado']) ?></div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="progress">
                                                                <div class="progress-bar bg-primary" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                                    <a href="../App/Views/Upload/Documents/Comparendos/<?= $DataComparendo['Documento'] ?>" target="_blank" style="color: white; text-decoration: none;">
                                                                        Ver
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="progress">
                                                                <div class="progress-bar bg-warning" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                                    <a href="../Empleados/ComparendosEditar?ID=<?= $DataComparendo['ID'] ?>"  target="_blank" style="color: white; text-decoration: none;">
                                                                        Editar
                                                                    </a>
                                                                </div>
                                                            </div>
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
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="card mb-5">
                            <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #000020; cursor: pointer; text-align: center;" data-bs-toggle="collapse" data-bs-target="#poligrafosCollapse" aria-expanded="false" aria-controls="poligrafosCollapse">
                                <div>
                                    Polígrafos
                                </div>
                                <div>
                                    <a href="../Empleados/PoligrafosRegistrar?ID=<?= $ID ?>" class="btn btn-sm btn-primary">
                                        <img width="20" height="20" src="https://img.icons8.com/windows/ffffff/32/add--v1.png" alt="add--v1" />
                                    </a>
                                </div>
                            </div>
                            <div id="poligrafosCollapse" class="collapse">
                                <div class="card-body text-white">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th style="color: #000020;">Nombre</th>
                                                    <th style="color: #000020;">Fecha Realizado</th>
                                                    <th style="color: #000020;">Estado</th>
                                                    <th style="color: #000020;"> </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if ($DataPoligrafos) {
                                                    foreach ($DataPoligrafos as $DataPoligrafo) {
                                                ?>
                                                        <tr>
                                                            <td><?= htmlspecialchars($DataPoligrafo['Nombre']) ?></td>
                                                            <td><?= htmlspecialchars($DataPoligrafo['Fecha_Realizado']) ?></td>
                                                            <td>
                                                                <div class="progress">
                                                                    <div class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">Activo</div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <a href="../App/Views/Upload/Documents/Poligrafos/<?= $DataPoligrafo['Documento'] ?>" class="btn btn-sm btn-primary" target="_blank">
                                                                    <img width="20" height="20" src="https://img.icons8.com/material-outlined/24/ffffff/visible--v1.png" alt="Ver" />
                                                                </a>
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
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="card mb-5">
                            <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #000020; cursor: pointer; text-align: center;" data-bs-toggle="collapse" data-bs-target="#hijosCollapse" aria-expanded="false" aria-controls="hijosCollapse">
                                <div>
                                    Hijos
                                </div>
                                <a href="../Empleados/FamiliaRegistrar?ID=<?= $ID ?>" class="btn btn-sm btn-primary">
                                    <img width="20" height="20" src="https://img.icons8.com/windows/ffffff/32/add--v1.png" alt="add--v1" />
                                </a>
                            </div>
                            <div id="hijosCollapse" class="collapse">
                                <div class="card-body text-white">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th style="color: #000020;">Nombre Completo</th>
                                                <th style="color: #000020;">Edad</th>
                                                <th style="color: #000020;">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($DataHijos) {
                                                foreach ($DataHijos as $DataHijo) {
                                                    $progressBarClass = $DataHijo['Edad'] > 10 ? 'bg-danger' : 'bg-success';
                                            ?>
                                                    <tr>
                                                        <td><?= htmlspecialchars($DataHijo['NombreCompleto']) ?></td>
                                                        <td>
                                                            <div class="progress">
                                                                <div id="progressStatus" class="progress-bar <?= $progressBarClass ?>" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                                    <?= htmlspecialchars($DataHijo['Edad']) ?>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <!-- Aquí irían los botones de acciones -->
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
                    </div>
                    <div class="col-md-7">
                        <div class="card mb-7">
                            <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #000020; cursor: pointer; text-align: center;" data-bs-toggle="collapse" data-bs-target="#compromisosCollapse" aria-expanded="false" aria-controls="compromisosCollapse">
                                <div>
                                    Compromisos
                                </div>
                                <div>
                                    <a href="#" class="btn btn-sm btn-primary">
                                        <img width="20" height="20" src="https://img.icons8.com/windows/ffffff/32/add--v1.png" alt="add--v1" />
                                    </a>
                                </div>
                            </div>
                            <div id="compromisosCollapse" class="collapse">
                                <div class="card-body text-white">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th style="color: #000020;">Fecha Realizado</th>
                                                <th style="color: #000020;">Estado</th>
                                                <th style="color: #000020;"> </th>
                                                <th style="color: #000020;"> </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>29/08/2024</td>
                                                <td>
                                                    <div class="progress">
                                                        <div class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">Activo</div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="progress">
                                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                            <a href="Carnet?ID=<?= $ID ?>" target="_blank" style="color: white; text-decoration: none;">
                                                                Ver
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #000020; cursor: pointer; text-align: center;" data-bs-toggle="collapse" data-bs-target="#CertificacionesCollapse" aria-expanded="false" aria-controls="CertificacionesCollapse">
                        <div>
                            Certificaciones Montacargistas
                        </div>
                        <div>
                            <a href="../Empleados/CertificadosMontacargasRegistrar?ID=<?= $ID ?>" class="btn btn-sm btn-primary">
                                <img width="20" height="20" src="https://img.icons8.com/windows/ffffff/32/add--v1.png" alt="add--v1" />
                            </a>
                        </div>
                    </div>
                    <div id="CertificacionesCollapse" class="collapse">
                        <div class="card-body text-white">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th style="color: #000020;">Nombre</th>
                                            <th style="color: #000020;">Fecha Realizado</th>
                                            <th style="color: #000020;">Fecha Vencimiento</th>
                                            <th style="color: #000020;">Estado</th>
                                            <th style="color: #000020;"> </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($DataMontacargas) {
                                            foreach ($DataMontacargas as $DataMontacarga) {
                                                $fechaVencimiento = DateTime::createFromFormat('Y-m-d', $DataMontacarga['Fecha_Vencimiento']);
                                                $fechaActual = new DateTime($Fecha);
                                                $interval = $fechaActual->diff($fechaVencimiento);
                                                if ($fechaActual > $fechaVencimiento) {
                                                    $estado = 'Vencido';
                                                    $tipoBoton = 'bg-danger';
                                                } elseif ($interval->days <= 30) {
                                                    $estado = 'Por Vencer';
                                                    $tipoBoton = 'bg-warning';
                                                } else {
                                                    $estado = 'Activo';
                                                    $tipoBoton = 'bg-success';
                                                } ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($DataMontacarga['Nombre']) ?></td>
                                                    <td><?= htmlspecialchars($DataMontacarga['Fecha_Realizado']) ?></td>
                                                    <td><?= htmlspecialchars($DataMontacarga['Fecha_Vencimiento']) ?></td>
                                                    <td>
                                                        <div class="progress">
                                                            <div class="progress-bar <?= $tipoBoton ?>" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"><?= htmlspecialchars($estado) ?></div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <a href="../App/Views/Upload/Documents/CertificadosMontacargas/<?= $DataMontacarga['Documento'] ?>" class="btn btn-sm btn-primary" target="_blank">
                                                            <img width="20" height="20" src="https://img.icons8.com/material-outlined/24/ffffff/visible--v1.png" alt="Ver" />
                                                        </a>
                                                    </td>
                                                </tr>
                                        <?php }
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-header" style="background-color: #000020;" data-bs-toggle="collapse" data-bs-target="#actividadCollapse" aria-expanded="false" aria-controls="actividadCollapse" style="cursor: pointer; text-align: center;">
                        Actividad
                    </div>
                    <div id="actividadCollapse" class="collapse">
                        <div class="card-body">
                            <ul class="timeline">
                                <?php
                                if ($DataActividad) {
                                    foreach ($DataActividad as $Actividades) {
                                        $FechaActividad = $Actividades['Fecha'] . " " . $Actividades['Hora'];
                                ?>
                                        <li class="timeline-item">
                                            <p><?= $Actividades['Frase'] ?>. <span class="text-muted"><?php $ActividadUsuarioController->CalcularFechaActivad($FechaActividad); ?></span></p>
                                        </li>
                                <?php
                                    }
                                }
                                ?>
                            </ul>
                            <a href="#">Ver toda la actividad</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
}
?>
<script src="../App/Views/Js/Alertas_Ver.js"></script>
<?php require "App/Views/Templates/Layouts/Footer.php"; ?>