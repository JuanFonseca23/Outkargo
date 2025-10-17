<?php
require_once "App/Views/Templates/Layouts/Header.php";
include_once "App/Controllers/CentroDeTrabajoController.php";
include_once "App/Controllers/MantenimientosController.php";

$CentrosDeTrabajo = new CentroDeTrabajoController;
$MantenimientosController = new MantenimientosController();
$ListaCentrosDeTrabajo = $CentrosDeTrabajo->TraerCentrosDeTrabajo();

date_default_timezone_set('America/Bogota'); 
$horaFormateada = date("H:i");

$ID_Centro = isset($_GET['centro']) ? $_GET['centro'] : $_SESSION['NoCentro'];
$Tipo = 2;
$DataSupervisores = $MantenimientosController->TraerSupervisores();
$Mantenimientos = $MantenimientosController->LeerMantenimientos($ID_Centro, $Tipo);
$NoMantenimientos = $MantenimientosController->ContarMantenimientos($ID_Centro, $Tipo);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['Tipo'] == "MantenimietoPreventivo") {
        $ID_Montacargas = $_POST['ID_Montacargas1'];
        $ID_Area = $_POST['ID_Area1'];
        $ID_Operario = $_POST['ID_Operario1'];
        $ID_Centro = $_POST['ID_Centro2'];
        $ID_Supervisor = $_POST['IDSupervisor'];
        $Correo_Supervisor = $_POST['CorreoSupervisor'];
        $Nombre_Supervisor = $_POST['NombreSupervisor'];
        $NumeroBateria = $_POST['NumeroBateria'];
        $NumeroControlador = NULL;
        $NumeroCargador = $_POST['NumeroCargador'];
        $Observaciones = $_POST['diagnostico'];
        $Longitudh = $_POST['LongitudH'];
        $Horometro = $_POST['Horometro'];
        $HoraInicio = $_POST['HoraInicio'];
        $Criterio_1 = $_POST['Criterio_1'];
        $Criterio_2 = $_POST['Criterio_2'];
        $Criterio_3 = $_POST['Criterio_3'];
        $Criterio_4 = $_POST['Criterio_4'];
        $Criterio_5 = $_POST['Criterio_5'];
        $Criterio_6 = $_POST['Criterio_6'];
        $Criterio_7 = $_POST['Criterio_7'];
        $Criterio_8 = $_POST['Criterio_8'];
        $Criterio_9 = $_POST['Criterio_9'];
        $Criterio_10 = $_POST['Criterio_10'];
        $Criterio_11 = $_POST['Criterio_11'];
        $Criterio_12 = $_POST['Criterio_12'];
        $Criterio_13 = $_POST['Criterio_13'];
        $Criterio_14 = $_POST['Criterio_14'];
        $Criterio_15 = $_POST['Criterio_15'];
        $Criterio_16 = $_POST['Criterio_16'];
        $Criterio_17 = $_POST['Criterio_17'];
        $Criterio_18 = $_POST['Criterio_18'];
        $Criterio_19 = $_POST['Criterio_19'];
        $Criterio_20 = $_POST['Criterio_20'];
        $Criterio_21 = $_POST['Criterio_21'];
        $Criterio_22 = $_POST['Criterio_22'];
        $Criterio_23 = $_POST['Criterio_23'];
        $Criterio_24 = $_POST['Criterio_24'];
        $Criterio_25 = $_POST['Criterio_25'];
        $Criterio_26 = $_POST['Criterio_26'];
        $Criterio_27 = $_POST['Criterio_27'];
        $Criterio_28 = $_POST['Criterio_28'];
        $Criterio_29 = $_POST['Criterio_29'];
        $Criterio_30 = $_POST['Criterio_30'];
        $Criterio_31 = $_POST['Criterio_31'];
        $Criterio_32 = $_POST['Criterio_32'];
        $Criterio_33 = $_POST['Criterio_33'];
        $Criterio_34 = $_POST['Criterio_34'];
        $Criterio_35 = $_POST['Criterio_35'];
        $Criterio_36 = $_POST['Criterio_36'];
        $Criterio_37 = $_POST['Criterio_37'];
        $Criterio_38 = $_POST['Criterio_38'];
        $Criterio_39 = $_POST['Criterio_39'];
        $Criterio_40 = $_POST['Criterio_40'];
        $Criterio_41 = $_POST['Criterio_41'];
        $Criterio_42 = $_POST['Criterio_42'];
        $Criterio_43 = $_POST['Criterio_43'];
        $Criterio_44 = $_POST['Criterio_44'];
        $Criterio_45 = $_POST['Criterio_45'];
        $Criterio_46 = $_POST['Criterio_46'];
        $Criterio_47 = $_POST['Criterio_47'];
        $Criterio_48 = $_POST['Criterio_48'];
        $Criterio_49 = $_POST['Criterio_49'];
        $Criterio_50 = $_POST['Criterio_50'];
        $Criterio_51 = $_POST['Criterio_51'];
        $Criterio_52 = $_POST['Criterio_52'];
        $Criterio_53 = $_POST['Criterio_53'];
        $Criterio_54 = $_POST['Criterio_54'];
        $Criterio_55 = $_POST['Criterio_55'];
        $Criterio_56 = $_POST['Criterio_56'];
        $Criterio_57 = $_POST['Criterio_57'];
        $Criterio_58 = $_POST['Criterio_58'];
        $Criterio_59 = $_POST['Criterio_59'];
        $Criterio_60 = $_POST['Criterio_60'];
        $Criterio_61 = $_POST['Criterio_61'];
        $Criterio_62 = $_POST['Criterio_62'];
        $Criterio_63 = $_POST['Criterio_63'];
        $Criterio_64 = $_POST['Criterio_64'];
        $Criterio_65 = $_POST['Criterio_65'];
        $Criterio_66 = $_POST['Criterio_66'];
        $Criterio_67 = $_POST['Criterio_67'];
        $Criterio_68 = $_POST['Criterio_68'];
        $Criterio_69 = $_POST['Criterio_69'];
        $Criterio_70 = $_POST['Criterio_70'];
        $Criterio_71 = $_POST['Criterio_71'];
        $Criterio_72 = $_POST['Criterio_72'];
        $Criterio_73 = $_POST['Criterio_73'];
        $Criterio_74 = $_POST['Criterio_74'];
        $Criterio_75 = $_POST['Criterio_75'];
        $Criterio_76 = $_POST['Criterio_76'];
        $Criterio_77 = $_POST['Criterio_77'];
        $Criterio_78 = $_POST['Criterio_78'];
        $Criterio_79 = $_POST['Criterio_79'];
        $Criterio_80 = $_POST['Criterio_80'];
        $Criterio_81 = $_POST['Criterio_81'];
        $Criterio_82 = $_POST['Criterio_82'];
        $Criterio_83 = $_POST['Criterio_83'];
        $Criterio_84 = $_POST['Criterio_84'];
        $Criterio_85 = $_POST['Criterio_85'];
        $Criterio_86 = $_POST['Criterio_86'];
        $Criterio_87 = $_POST['Criterio_87'];
        $Criterio_88 = $_POST['Criterio_88'];
        $Criterio_89 = $_POST['Criterio_89'];
        $Criterio_90 = $_POST['Criterio_90'];
        $Criterio_91 = $_POST['Criterio_91'];
        $Criterio_92 = $_POST['Criterio_92'];
        $Criterio_93 = $_POST['Criterio_93'];
        $Criterio_94 = $_POST['Criterio_94'];
        $Criterio_95 = $_POST['Criterio_95'];
        $Criterio_96 = $_POST['Criterio_96'];
        $Criterio_97 = $_POST['Criterio_97'];
        $Criterio_98 = $_POST['Criterio_98'];
        $Criterio_99 = $_POST['Criterio_99'];
        $Criterio_100 = $_POST['Criterio_100'];
        $Criterio_101 = $_POST['Criterio_101'];
        $Criterio_102 = $_POST['Criterio_102'];
        $Criterio_103 = $_POST['Criterio_103'];
        $Criterio_104 = $_POST['Criterio_104'];
        $Criterio_105 = $_POST['Criterio_105'];
        $Criterio_106 = $_POST['Criterio_106'];
        $Criterio_107 = $_POST['Criterio_107'];
        $Criterio_108 = $_POST['Criterio_108'];
        $Criterio_109 = $_POST['Criterio_109'];
        $Criterio_110 = $_POST['Criterio_110'];
        $Criterio_111 = $_POST['Criterio_111'];
        $Criterio_112 = $_POST['Criterio_112'];
        $Criterio_113 = $_POST['Criterio_113'];
        $Criterio_114 = $_POST['Criterio_114'];
        $Criterio_115 = $_POST['Criterio_115'];
        $Criterio_116 = $_POST['Criterio_116'];
        $Criterio_117 = $_POST['Criterio_117'];
        $Criterio_118 = $_POST['Criterio_118'];
        $Criterio_119 = $_POST['Criterio_119'];
        $Criterio_120 = $_POST['Criterio_120'];
        $Criterio_121 = $_POST['Criterio_121'];
        $Criterio_122 = $_POST['Criterio_122'];
        $Criterio_123 = $_POST['Criterio_123'];
        $Criterio_124 = $_POST['Criterio_124'];
        $Criterio_125 = $_POST['Criterio_125'];
        $Criterio_126 = $_POST['Criterio_126'];
        $Criterio_127 = $_POST['Criterio_127'];
        $Criterio_128 = $_POST['Criterio_128'];
        $Criterio_129 = $_POST['Criterio_129'];
        $Criterio_130 = $_POST['Criterio_130'];
        $Criterio_131 = $_POST['Criterio_131'];
        $Criterio_132 = $_POST['Criterio_132'];
        $Criterio_133 = $_POST['Criterio_133'];
        $Criterio_134 = $_POST['Criterio_134'];
        $Criterio_135 = $_POST['Criterio_135'];
        $Criterio_136 = $_POST['Criterio_136'];
        $Criterio_137 = $_POST['Criterio_137'];
        $Criterio_138 = $_POST['Criterio_138'];
        $Criterio_139 = $_POST['Criterio_139'];
        // 🔹 Técnicos encargados 
        $Tecnicos = isset($_POST['tecnicoId']) ? $_POST['tecnicoId'] : [];
        // Imagenes Diagnostico
        $Baterias = $_FILES['imagenesDiagnosticoBateria'];
        $Electricos = $_FILES['imagenesDiagnosticoEletrico'];
        $Tracciones = $_FILES['imagenesDiagnosticoTraccion'];
        $Frenos = $_FILES['imagenesDiagnosticoFrenos'];
        $Direcciones = $_FILES['imagenesDiagnosticoDireccion'];
        $Hidraulicos = $_FILES['imagenesDiagnosticoHidraulico'];
        $Mastiles = $_FILES['imagenesDiagnosticoMastil'];
        $Carros = $_FILES['imagenesDiagnosticoCarroPorta'];
        $Aditamientos = $_FILES['imagenesDiagnosticoAditamientos'];
        $Horquillas = $_FILES['imagenesDiagnosticoHorquillas'];
        $Ruedas = $_FILES['imagenesDiagnosticoRuedas'];
        $Chasis = $_FILES['imagenesDiagnosticoChasis'];
        $Luces = $_FILES['imagenesDiagnosticoLuces'];
        $Lubricaciones = $_FILES['imagenesDiagnosticoLubricacion'];
        $Cargadores = $_FILES['imagenesDiagnosticoCargador'];
        $Revisiones = $_FILES['imagenesDiagnosticoRevision'];
        $ID_Usuario = $_SESSION['ID'];
        $NombreCreo = $_SESSION['Nombre1'];
        
        if($ID_Mantenimiento = $MantenimientosController->RegistrarMantenimiento($ID_Usuario, $NombreCreo, $ID_Montacargas,$ID_Area,$ID_Operario,$ID_Centro,$ID_Supervisor,$Correo_Supervisor,$Nombre_Supervisor,$NumeroBateria,$NumeroControlador,$NumeroCargador,$Observaciones,$Longitudh,$Horometro,$HoraInicio,
                                                          $Criterio_1,$Criterio_2,$Criterio_3,$Criterio_4,$Criterio_5,$Criterio_6,$Criterio_7,$Criterio_8,$Criterio_9,$Criterio_10,
                                                          $Criterio_11,$Criterio_12,$Criterio_13,$Criterio_14,$Criterio_15,$Criterio_16,$Criterio_17,$Criterio_18,$Criterio_19,$Criterio_20,
                                                          $Criterio_21,$Criterio_22,$Criterio_23,$Criterio_24,$Criterio_25,$Criterio_26,$Criterio_27,$Criterio_28,$Criterio_29,$Criterio_30,
                                                          $Criterio_31,$Criterio_32,$Criterio_33,$Criterio_34,$Criterio_35,$Criterio_36,$Criterio_37,$Criterio_38,$Criterio_39,$Criterio_40,
                                                          $Criterio_41,$Criterio_42,$Criterio_43,$Criterio_44,$Criterio_45,$Criterio_46,$Criterio_47,$Criterio_48,$Criterio_49,$Criterio_50,
                                                          $Criterio_51,$Criterio_52,$Criterio_53,$Criterio_54,$Criterio_55,$Criterio_56,$Criterio_57,$Criterio_58,$Criterio_59,$Criterio_60,
                                                          $Criterio_61,$Criterio_62,$Criterio_63,$Criterio_64,$Criterio_65,$Criterio_66,$Criterio_67,$Criterio_68,$Criterio_69,$Criterio_70,
                                                          $Criterio_71,$Criterio_72,$Criterio_73,$Criterio_74,$Criterio_75,$Criterio_76,$Criterio_77,$Criterio_78,$Criterio_79,$Criterio_80,
                                                          $Criterio_81,$Criterio_82,$Criterio_83,$Criterio_84,$Criterio_85,$Criterio_86,$Criterio_87,$Criterio_88,$Criterio_89,$Criterio_90,
                                                          $Criterio_91,$Criterio_92,$Criterio_93,$Criterio_94,$Criterio_95,$Criterio_96,$Criterio_97,$Criterio_98,$Criterio_99,$Criterio_100,
                                                          $Criterio_101,$Criterio_102,$Criterio_103,$Criterio_104,$Criterio_105,$Criterio_106,$Criterio_107,$Criterio_108,$Criterio_109,$Criterio_110,
                                                          $Criterio_111,$Criterio_112,$Criterio_113,$Criterio_114,$Criterio_115,$Criterio_116,$Criterio_117,$Criterio_118,$Criterio_119,$Criterio_120,
                                                          $Criterio_121,$Criterio_122,$Criterio_123,$Criterio_124,$Criterio_125,$Criterio_126,$Criterio_127,$Criterio_128,$Criterio_129,$Criterio_130,
                                                          $Criterio_131,$Criterio_132,$Criterio_133,$Criterio_134,$Criterio_135,$Criterio_136,$Criterio_137,$Criterio_138,$Criterio_139,
                                                          $Tecnicos,$Baterias,$Electricos,$Tracciones,$Frenos,$Direcciones,$Hidraulicos,$Mastiles,$Carros,$Aditamientos,$Horquillas,$Ruedas,$Chasis,$Luces,$Lubricaciones,$Cargadores,$Revisiones, $Tipo)){
            echo "
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                Swal.fire({
                    title: 'Mantenimiento Creado!',
                    text: 'El mantenimiento se ha creado exitosamente.',
                    icon: 'success',
                    showCancelButton: true,
                    confirmButtonText: 'Continuar',
                    cancelButtonText: 'Cancelar',
                    allowOutsideClick: false,
                    allowEscapeKey: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'FirmaMantenimiento?ID=' + " . $ID_Mantenimiento . ";
                    }
                });
            </script>";
        } else {
            echo "
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                Swal.fire({
                    title: 'Error!',
                    text: 'El mantenimiento no se pudo crear, por favor intente de nuevo.',
                    icon: 'error',
                    timer: 3000,
                    timerProgressBar: true
                });
            </script>";
        }
    }
    
}
?>
<style>
    .select-Conforme {
        background-color: #d4edda !important;
        /* verde claro */
    }

    .select-Nivelacion {
        background-color: #fff3cd !important;
        /* amarillo claro */
    }

    .select-Ajuste {
        background-color: #ffe5b4 !important;
        /* naranja claro */
    }

    .select-Lubricacion {
        background-color: #cce5ff !important;
        /* azul claro */
    }

    .select-Aplica {
        background-color: #e2e3e5 !important;
        /* gris claro */
    }

    .select-malo {
        background-color: #f8d7da !important;
        /* rojo claro */
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
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-6 col-xl-3">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <img width="50" height="50" src="https://img.icons8.com/pastel-glyph/50/000020/hand-truck--v2.png" alt="hand-truck--v2"/>
                <div class="ms-3">
                    <p class="mb-2" style="color: #000020;">Preventivos Realizados</p>
                    <h6 class="mb-0" style="color: #000020;"><?= $NoMantenimientos['NoMantenimientos'] ?></h6>
                </div>
            </div>
        </div>
        <a class="col-sm-6 col-xl-3" data-bs-toggle="modal" data-bs-target="#NumerDocumentoModal">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <img width="50" height="50" src="https://img.icons8.com/pastel-glyph/100/000020/hand-truck--v1.png" alt="hand-truck--v2" style="transform: scaleX(-1);" />
                <div class="ms-3">
                    <p class="mb-2" style="color: #000020;">Preventivo</p>
                </div>
            </div>
        </a>
        <a class="col-sm-6 col-xl-3" href="#"></a>
        <a class="col-sm-6 col-xl-3" href="#"></a>
    </div>
</div>

<div class="container-fluid pt-4 px-4">
    <div class="bg-light text-center rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <form method="get" action="" class="mb-0">
                <h6 class="mb-0 d-flex align-items-center">
                    Preventivos Realizados |
                    <select name="centro" class="form-select form-select-sm d-inline w-auto ms-2" onchange="this.form.submit()">
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
                </h6>
            </form>

            <div>
                <a href="#">Ver Todas</a>
                <a>|</a>
                <a href="#">Descargar Excel</a>
            </div>
        </div>

        <!-- Tabla -->
        <div class="table-responsive">
            <table class="table text-start align-middle table-bordered table-hover mb-0" id="myTable">
                <thead>
                    <tr class="text-dark">
                        <th scope="col" class="text-center">N°</th>
                        <th scope="col" class="text-center">Serie</th>
                        <th scope="col" class="text-center">Horometro </th>
                        <th scope="col" class="text-center">Horometro Actual</th>
                        <th scope="col" class="text-center">Operario Reporta</th>
                        <th scope="col" class="text-center">Fecha Realizado</th>
                        <th scope="col" class="text-center">Estado</th>
                        <th scope="col" class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($Mantenimientos) {
                        foreach ($Mantenimientos as $Mantenimiento) {
                            $HorometroA = $Mantenimiento['HorometroA']; 
                            $HorometroM = $Mantenimiento['HorometroM']; 
                            $diferencia = $HorometroA - $HorometroM;
                            if ($diferencia >= 250) {
                                $progressBarClass = 'bg-danger';
                                $estadoTexto = 'Vencido';
                            } elseif ($diferencia >= 200 && $diferencia < 250) {
                                $progressBarClass = 'bg-warning';
                                $estadoTexto = 'Mantenimiento';
                            }else{
                                $progressBarClass = 'bg-success';
                                $estadoTexto = 'Valido';
                            }

                    ?>
                            <tr data-id="<?= htmlspecialchars($Mantenimiento['ID']) ?>">
                                <td width="100" class="text-center"><?= htmlspecialchars($Mantenimiento['NumeroM']) ?></td>
                                <td><?= htmlspecialchars($Mantenimiento['SerieM']) ?></td>
                                <td><?= htmlspecialchars($Mantenimiento['HorometroM']) ?></td>
                                <td><?= htmlspecialchars($Mantenimiento['HorometroA']) ?></td>
                                <td><?= htmlspecialchars($Mantenimiento['NombreUsuario']) ?></td>
                                <td><?= htmlspecialchars($Mantenimiento['Fecha_Realizado']) ?></td>
                                <td>
                                    <div class="progress">
                                        <div id="progressStatus" class="progress-bar <?= $progressBarClass ?>" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                            <?=  $estadoTexto ?>
                                        </div>
                                    </div>
                                </td>
                                <td width="200" class="text-center">
                                    <a class="btn btn-sm btn-primary" target="_blank" href="VerMantenimientoPasillo?ID=<?= urlencode(htmlspecialchars($Mantenimiento['ID'])) ?>">
                                        <img width="20" height="20" src="https://img.icons8.com/material-outlined/24/ffffff/visible--v1.png" alt="Ver" />
                                    </a>
                                    <?php if ($Mantenimiento['Estado_Firma_Operario'] != 1) { ?>
                                        <a class="btn btn-sm btn-warning" target="_blank" href="FirmaOperario?ID=<?= urlencode(htmlspecialchars($Mantenimiento['ID'])) ?>">
                                            <img width="20" height="20" src="https://img.icons8.com/sf-regular-filled/24/ffffff/autograph.png" alt="autograph"/>
                                        </a>
                                    <?php } ?>
                                    <?php if ( $_SESSION['ID'] == $Mantenimiento['ID_Supervisor'] && $Mantenimiento['Estado_Firma_Supervisor'] != 1) { ?>
                                        <a class="btn btn-sm btn-dark" target="_blank" href="FirmaSupervisor?ID=<?= urlencode(htmlspecialchars($Mantenimiento['ID'])) ?>">
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

<!-- Modal Ingreso de datos -->
<div class="modal fade" id="NumerDocumentoModal" tabindex="-1" aria-labelledby="NumerDocumentoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">                
                <h5 class="modal-title text-white" id="NumerDocumentoModalLabel">Mantenimiento Preventivo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form id="documentFormIngreso" method="POST">
                    <div class="mb-3">
                        <label for="CentroTrabajo">Seleccione el centro de trabajo</label>
                        <select class="form-select" name="ID_Centro1" id="ID_Centro1" aria-label="Seleccione centro de trabajo" onchange="cargarMontacargas()" required>
                            <option value="" disabled selected>Centro de Trabajo</option>
                            <?php
                                if ($ListaCentrosDeTrabajo) {
                                    foreach ($ListaCentrosDeTrabajo as $ListaCentroDeTrabajo) {
                                        echo "<option value='{$ListaCentroDeTrabajo['ID']}'>{$ListaCentroDeTrabajo['Nombre']}</option>";
                                    }
                                }
                            ?>
                        </select>
                        <label for="floatingSelect">Seleccione el numeró de montacargas</label>
                        <select class="form-select" name="ID_Montacargas" id="ID_Montacargas" required>
                            <option value="" disabled selected>Seleccione un montacargas</option>
                        </select>
                        <label for="floatingSelect">Seleccione operario quien reporta</label>
                        <select class="form-select" name="ID_Operario" id="ID_Operario" required>
                            <option value="" disabled selected>Seleccione operario</option>
                        </select>
                        <label for="floatingSelect">Seleccione Sección o Area de trabajo</label>
                        <select class="form-select" name="ID_Area" id="ID_Area" required>
                            <option value="" disabled selected>Seleccione Seccion</option>
                        </select>
                        <input type="hidden" name="Tipo" value="DocumentoPreventivo">
                    </div>
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Ingreso de mantenimientos -->
<div class="modal fade" id="agregarMantenimiento" tabindex="-1" aria-labelledby="agregarMantenimientoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="agregarMantenimientoModalLabel">Mantenimiento Preventivo Electrica Pasillo Angosto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="documentFormMantenimiento" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <!-- Informacion Montacaragas -->
                        <div class="col-md-4">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="numeroMontacargas">Montacargas</label>
                                    <input type="text" class="form-control" name="numeroMontacargas" id="numeroMontacargas"  readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="nombreSección">Sección</label>
                                    <input type="text" class="form-control" name="nombreSección" id="nombreSección"  readonly>
                                </div>
                                <div class="col-md-12">
                                    <label for="numeroSerie">Serie</label>
                                    <input type="text" class="form-control" name="numeroSerie" id="numeroSerie" readonly>
                                    <label for="numeroModelo">Modelo</label>
                                    <input type="text" class="form-control" name="numeroModelo" id="numeroModelo" readonly>
                                    <label for="nombreCentro">Centro de Trabajo</label>
                                    <input type="text" class="form-control" name="nombreCentro" id="nombreCentro" readonly>
                                    <label for="nombreOperario">Operario</label>
                                    <input type="text" class="form-control" name="nombreOperario" id="nombreOperario" readonly>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="Voltaje">Voltaje</label>
                                        <input type="text" class="form-control" name="Voltaje" id="Voltaje" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="Horometro">Horometro</label>
                                        <input type="text" class="form-control" name="Horometro" id="Horometro" >
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="HoraIncio">Hora Inicio</label>
                                        <input type="time" class="form-control" name="HoraInicio" id="HoraInicio" value="<?= date('H:i', strtotime($horaFormateada)) ?>">
                                    </div>
                                </div>
                                <!-- Campo de técnicos con botón -->
                                <div class="col-md-12">
                                    <label for="nombreTecnico" >Técnicos Encargados</label>
                                    
                                    <!-- Campo principal -->
                                    <div class="input-group mb-2">
                                    <input type="text" class="form-control" name="nombreTecnico[]" id="nombreTecnico" placeholder="<?= htmlspecialchars($_SESSION['NombreCompleto']) ?>" readonly>
                                    <button class="btn btn-success" type="button" id="btnAgregarTecnico" data-open-modal="#modalAgregarTecnico"> <i class="bi bi-plus-circle"></i></button>
                                    </div>
                                    <!-- Lista de técnicos adicionales -->
                                    <div id="listaTecnicos"></div>
                                </div>
                                <div class="col-md-12">
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
                        </div>
                        <!-- Formulario -->
                        <div class="col-md-8">                            
                            <p class="mb-2" style="color: #000020;"> Seleccione en el campo de condición alguna de las siguientes convenciones: </p>
                                <div>
                                    <span style="display:inline-block; background:#d4edda; color:#155724; padding:3px 5px; border-radius:5px; margin:2px;">
                                        <strong>C-Conforme</strong>
                                    </span>
                                    <span style="display:inline-block; background:#f8d7da; color:#721c24; padding:3px 5px; border-radius:5px; margin:2px;">
                                        <strong>R-Reparación</strong>
                                    </span>
                                    <span style="display:inline-block; background:#fff3cd; color:#856404; padding:3px 5px; border-radius:5px; margin:2px;">
                                        <strong>N-Nivelación</strong>
                                    </span>
                                    <span style="display:inline-block; background:#ffe5b4; color:#8b4513; padding:3px 5px; border-radius:5px; margin:2px;">
                                        <strong>A-Ajuste</strong>
                                    </span>
                                    <span style="display:inline-block; background:#cce5ff; color:#004085; padding:3px 5px; border-radius:5px; margin:2px;">
                                        <strong>L-Lubricación y Engrase</strong>
                                    </span>
                                    <span style="display:inline-block; background:#e2e3e5; color:#383d41; padding:3px 5px; border-radius:5px; margin:2px;">
                                        <strong>N/A-No aplica</strong>
                                    </span>
                                </div>
                            <p class="mb-2" style="color: #000020;"><strong>Nota:</strong> Durante el mantenimiento preventivo, se debe hacer la limpieza general del equipo.</p>
                            <div class="row">
                                <a id="btnFrenosCard" class="col-sm-6 col-xl-4" href="#" data-open-modal="#ModalFrenos">
                                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-3">
                                        <img width="50" height="50" src="https://img.icons8.com/ios-filled/50/000020/abs.png" alt="abs" />
                                        <div class="ms-3">
                                            <p class="mb-2" style="color: #000020;">Sistema De Frenos</p>
                                        </div>
                                    </div>
                                </a>
                                <a id="btnDireccionCard" class="col-sm-6 col-xl-4" href="#" data-open-modal="#ModalDireccion">
                                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-3">
                                        <img width="50" height="50" src="https://img.icons8.com/ios-filled/50/000020/steering-wheel.png" alt="steering-wheel" />
                                        <div class="ms-3">
                                            <p class="mb-2" style="color: #000020;">Sistema De Funciones Auxiliares</p>
                                        </div>
                                    </div>
                                </a>
                                <a id="btnTraccionCard" class="col-sm-6 col-xl-4" href="#" data-open-modal="#ModalTraccion">
                                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-3">
                                        <img width="50" height="50" src="https://img.icons8.com/ios-filled/50/000020/traction-control.png" alt="traction-control" />
                                        <div class="ms-3">
                                            <p class="mb-2" style="color: #000020;">Sistema De Tracción</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <br>
                            <div class="row">
                                <a id="btnBateriaCard" class="col-sm-6 col-xl-4" href="#" data-open-modal="#ModalBateria">
                                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-3">
                                        <img width="50" height="50" src="https://img.icons8.com/ios-filled/50/000020/charge-battery--v1.png" alt="charge-battery--v1" />
                                        <div class="ms-3">
                                            <p class="mb-2" style="color: #000020;">Batería</p>
                                        </div>
                                    </div>
                                </a>
                                <a id="btnElectricoCard" class="col-sm-6 col-xl-4" href="#" data-open-modal="#ModalElectrico">
                                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-3">
                                        <img width="50" height="50" src="https://img.icons8.com/ios-filled/50/000020/carbon-brush.png" alt="carbon-brush" />
                                        <div class="ms-3">
                                            <p class="mb-2" style="color: #000020;">Sistema Eléctrico</p>
                                        </div>
                                    </div>
                                </a>
                                <a id="btnMastilCard" class="col-sm-6 col-xl-4" href="#" data-open-modal="#ModalMastil">
                                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-3">
                                        <img width="50" height="50" src="https://img.icons8.com/deco-glyph/50/000028/fork-lift.png" alt="fork-lift" />
                                        <div class="ms-3">
                                            <p class="mb-2" style="color: #000020;">Mastil</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <br>
                            <div class="row">
                                <a id="btnLubricacionCard" class="col-sm-6 col-xl-4" href="#" data-open-modal="#ModalLubricacion">
                                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-3">
                                        <img width="50" height="50" src="https://img.icons8.com/ios-filled/50/000020/engine-oil-level.png" alt="engine-oil-level" />
                                        <div class="ms-3">
                                            <p class="mb-2" style="color: #000020;">Lubricacíon</p>
                                        </div>
                                    </div>
                                </a>
                                <a id="btnLucesCard" class="col-sm-6 col-xl-4" href="#" data-open-modal="#ModalLuces">
                                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-3">
                                        <img width="50" height="50" src="https://img.icons8.com/ios-filled/50/000020/headlight.png" alt="headlight" />
                                        <div class="ms-3">
                                            <p class="mb-2" style="color: #000020;">Luces y Alarmas</p>
                                        </div>
                                    </div>
                                </a>
                                <a id="btnCargadorCard" class="col-sm-6 col-xl-4" href="#" data-open-modal="#ModalCargador">
                                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-3">
                                      <img width="50" height="50" src="https://img.icons8.com/external-yogi-aprelliyanto-glyph-yogi-aprelliyanto/50/000020/external-power-supply-computer-hardware-yogi-aprelliyanto-glyph-yogi-aprelliyanto.png" alt="external-power-supply-computer-hardware-yogi-aprelliyanto-glyph-yogi-aprelliyanto"/>
                                        <div class="ms-3">
                                            <p class="mb-2" style="color: #000020;">Cargador</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <br>
                            <div class="row">
                                <a id="btnHorquillasCard" class="col-sm-6 col-xl-4" href="#" data-open-modal="#ModalHorquillas">
                                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-3">
                                        <img width="50" height="50" src="https://img.icons8.com/ios-filled/50/000020/l.png" alt="l" />
                                        <div class="ms-3">
                                            <p class="mb-2" style="color: #000020;">Horquillas</p>
                                        </div>
                                    </div>
                                </a>
                                <a id="btnRuedasCard" class="col-sm-6 col-xl-4" href="#" data-open-modal="#ModalRuedas">
                                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-3">
                                        <img width="50" height="50" src="https://img.icons8.com/ios-glyphs/50/000020/wheel.png" alt="wheel" />
                                        <div class="ms-3">
                                            <p class="mb-2" style="color: #000020;">Ruedas</p>
                                        </div>
                                    </div>
                                </a>
                                <a id="btnChasisCard" class="col-sm-6 col-xl-4" href="#" data-open-modal="#ModalChasis">
                                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-3">
                                        <img width="50" height="50" src="https://img.icons8.com/ios-glyphs/50/000020/4x4-vehicle.png" alt="4x4-vehicle" />
                                        <div class="ms-3">
                                            <p class="mb-2" style="color: #000020;">Chasis</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <br>
                            <div class="row">
                                <a id="btnHidraulicoCard" class="col-sm-6 col-xl-4" href="#" data-open-modal="#ModalHidraulico">
                                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-3">
                                        <img width="50" height="50" src="https://img.icons8.com/external-solidglyph-m-oki-orlando/64/000020/external-hydraulic-engineering-engineering-solid-solidglyph-m-oki-orlando.png" alt="external-hydraulic-engineering-engineering-solid-solidglyph-m-oki-orlando" />
                                        <div class="ms-3">
                                            <p class="mb-2" style="color: #000020;">Sistema Hidraulico</p>
                                        </div>
                                    </div>
                                </a>
                                <a id="btnAditamentosCard"  class="col-sm-6 col-xl-4" href="#" data-open-modal="#ModalAditamientos">
                                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-3">
                                        <img width="50" height="50" src="https://img.icons8.com/external-prettycons-solid-prettycons/50/000020/external-suspension-car-parts-vehicles-prettycons-solid-prettycons.png" alt="external-suspension-car-parts-vehicles-prettycons-solid-prettycons"/>
                                        <div class="ms-3">
                                            <p class="mb-2" style="color: #000020;">Sistema De Suspensión</p>
                                        </div>
                                    </div>
                                </a>
                                <a id="btnRevisionCard" class="col-sm-6 col-xl-4" href="#" data-open-modal="#ModalRevision">
                                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-3">
                                        <img width="50" height="50" src="https://img.icons8.com/ios-filled/50/000020/fork-lift.png" alt="fork-lift" />
                                        <div class="ms-3">
                                            <p class="mb-2" style="color: #000020;">Revision De Equipo</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <br>
                            <div class="row">
                                <a id="btnCarroPortaCard" class="col-sm-6 col-xl-4" href="#" data-open-modal="#ModalCarroPorta">
                                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-3">
                                        <img width="50" height="50" src="https://img.icons8.com/sf-regular-filled/50/000020/mine-cart.png" alt="mine-cart" />
                                        <div class="ms-3">
                                            <p class="mb-2" style="color: #000020;">Pantógrafo</p>
                                        </div>
                                    </div>
                                </a>
                                <a id="btnInsumosCard" class="col-sm-6 col-xl-4" href="#" data-open-modal="#ModalInsumos">
                                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-3">
                                        <img width="50" height="50" src="https://img.icons8.com/fluency-systems-filled/50/000020/oil-industry.png" alt="oil-industry"/>
                                        <div class="ms-3">
                                            <p class="mb-2" style="color: #000020;">Insumos</p>
                                        </div>
                                    </div>
                                </a>
                                <a id="btnObservacionesCard" class="col-sm-6 col-xl-4" href="#" data-open-modal="#ModalObservaciones">
                                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-3">
                                        <img width="50" height="50" src="https://img.icons8.com/glyph-neue/50/000020/comments.png" alt="comments"/>
                                        <div class="ms-3">
                                            <p class="mb-2" style="color: #000020;">Observaciónes</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="ID_MecanicoPrincipal" value="<?= $_SESSION['ID'] ?>">
                    <input type="hidden" name="ID_Montacargas1" id="hiddenIDMontacargas">
                    <input type="hidden" name="ID_Area1" id="hiddenIDArea">
                    <input type="hidden" name="ID_Operario1" id="hiddenIDOperario">
                    <input type="hidden" name="ID_Centro2" id="hiddenIDCentro">
                    <input type="hidden" name="IDSupervisor" id="formIDSupervisor">
                    <input type="hidden" name="CorreoSupervisor" id="formCorreoSupervisor">
                    <input type="hidden" name="NombreSupervisor" id="formNombreSupervisor">
                    <input type="hidden" name="NumeroBateria" id="hiddenNumeroBateria">
                    <input type="hidden" name="NumeroCargador" id="hiddenNumeroCargador">
                    <input type="hidden" name="diagnostico" id="hiddendiagnostico">
                    <input type="hidden" name="LongitudH" id="hiddenLongitudH">
                    <input type="hidden" name="Criterio_1" id="hiddenCriterio_1">
                    <input type="hidden" name="Criterio_2" id="hiddenCriterio_2">
                    <input type="hidden" name="Criterio_3" id="hiddenCriterio_3">
                    <input type="hidden" name="Criterio_4" id="hiddenCriterio_4">
                    <input type="hidden" name="Criterio_5" id="hiddenCriterio_5">
                    <input type="hidden" name="Criterio_6" id="hiddenCriterio_6">
                    <input type="hidden" name="Criterio_7" id="hiddenCriterio_7">
                    <input type="hidden" name="Criterio_8" id="hiddenCriterio_8">
                    <input type="hidden" name="Criterio_9" id="hiddenCriterio_9">
                    <input type="hidden" name="Criterio_10" id="hiddenCriterio_10">
                    <input type="hidden" name="Criterio_11" id="hiddenCriterio_11">
                    <input type="hidden" name="Criterio_12" id="hiddenCriterio_12">
                    <input type="hidden" name="Criterio_13" id="hiddenCriterio_13">
                    <input type="hidden" name="Criterio_14" id="hiddenCriterio_14">
                    <input type="hidden" name="Criterio_15" id="hiddenCriterio_15">
                    <input type="hidden" name="Criterio_16" id="hiddenCriterio_16">
                    <input type="hidden" name="Criterio_17" id="hiddenCriterio_17">
                    <input type="hidden" name="Criterio_18" id="hiddenCriterio_18">
                    <input type="hidden" name="Criterio_19" id="hiddenCriterio_19">
                    <input type="hidden" name="Criterio_20" id="hiddenCriterio_20">
                    <input type="hidden" name="Criterio_21" id="hiddenCriterio_21">
                    <input type="hidden" name="Criterio_22" id="hiddenCriterio_22">
                    <input type="hidden" name="Criterio_23" id="hiddenCriterio_23">
                    <input type="hidden" name="Criterio_24" id="hiddenCriterio_24">
                    <input type="hidden" name="Criterio_25" id="hiddenCriterio_25">
                    <input type="hidden" name="Criterio_26" id="hiddenCriterio_26">
                    <input type="hidden" name="Criterio_27" id="hiddenCriterio_27">
                    <input type="hidden" name="Criterio_28" id="hiddenCriterio_28">
                    <input type="hidden" name="Criterio_29" id="hiddenCriterio_29">
                    <input type="hidden" name="Criterio_30" id="hiddenCriterio_30">
                    <input type="hidden" name="Criterio_31" id="hiddenCriterio_31">
                    <input type="hidden" name="Criterio_32" id="hiddenCriterio_32">
                    <input type="hidden" name="Criterio_33" id="hiddenCriterio_33">
                    <input type="hidden" name="Criterio_34" id="hiddenCriterio_34">
                    <input type="hidden" name="Criterio_35" id="hiddenCriterio_35">
                    <input type="hidden" name="Criterio_36" id="hiddenCriterio_36">
                    <input type="hidden" name="Criterio_37" id="hiddenCriterio_37">
                    <input type="hidden" name="Criterio_38" id="hiddenCriterio_38">
                    <input type="hidden" name="Criterio_39" id="hiddenCriterio_39">
                    <input type="hidden" name="Criterio_40" id="hiddenCriterio_40">
                    <input type="hidden" name="Criterio_41" id="hiddenCriterio_41">
                    <input type="hidden" name="Criterio_42" id="hiddenCriterio_42">
                    <input type="hidden" name="Criterio_43" id="hiddenCriterio_43">
                    <input type="hidden" name="Criterio_44" id="hiddenCriterio_44">
                    <input type="hidden" name="Criterio_45" id="hiddenCriterio_45">
                    <input type="hidden" name="Criterio_46" id="hiddenCriterio_46">
                    <input type="hidden" name="Criterio_47" id="hiddenCriterio_47">
                    <input type="hidden" name="Criterio_48" id="hiddenCriterio_48">
                    <input type="hidden" name="Criterio_49" id="hiddenCriterio_49">
                    <input type="hidden" name="Criterio_50" id="hiddenCriterio_50">
                    <input type="hidden" name="Criterio_51" id="hiddenCriterio_51">
                    <input type="hidden" name="Criterio_52" id="hiddenCriterio_52">
                    <input type="hidden" name="Criterio_53" id="hiddenCriterio_53">
                    <input type="hidden" name="Criterio_54" id="hiddenCriterio_54">
                    <input type="hidden" name="Criterio_55" id="hiddenCriterio_55">
                    <input type="hidden" name="Criterio_56" id="hiddenCriterio_56">
                    <input type="hidden" name="Criterio_57" id="hiddenCriterio_57">
                    <input type="hidden" name="Criterio_58" id="hiddenCriterio_58">
                    <input type="hidden" name="Criterio_59" id="hiddenCriterio_59">
                    <input type="hidden" name="Criterio_60" id="hiddenCriterio_60">
                    <input type="hidden" name="Criterio_61" id="hiddenCriterio_61">
                    <input type="hidden" name="Criterio_62" id="hiddenCriterio_62">
                    <input type="hidden" name="Criterio_63" id="hiddenCriterio_63">
                    <input type="hidden" name="Criterio_64" id="hiddenCriterio_64">
                    <input type="hidden" name="Criterio_65" id="hiddenCriterio_65">
                    <input type="hidden" name="Criterio_66" id="hiddenCriterio_66">
                    <input type="hidden" name="Criterio_67" id="hiddenCriterio_67">
                    <input type="hidden" name="Criterio_68" id="hiddenCriterio_68">
                    <input type="hidden" name="Criterio_69" id="hiddenCriterio_69">
                    <input type="hidden" name="Criterio_70" id="hiddenCriterio_70">
                    <input type="hidden" name="Criterio_71" id="hiddenCriterio_71">
                    <input type="hidden" name="Criterio_72" id="hiddenCriterio_72">
                    <input type="hidden" name="Criterio_73" id="hiddenCriterio_73">
                    <input type="hidden" name="Criterio_74" id="hiddenCriterio_74">
                    <input type="hidden" name="Criterio_75" id="hiddenCriterio_75">
                    <input type="hidden" name="Criterio_76" id="hiddenCriterio_76">
                    <input type="hidden" name="Criterio_77" id="hiddenCriterio_77">
                    <input type="hidden" name="Criterio_78" id="hiddenCriterio_78">
                    <input type="hidden" name="Criterio_79" id="hiddenCriterio_79">
                    <input type="hidden" name="Criterio_80" id="hiddenCriterio_80">
                    <input type="hidden" name="Criterio_81" id="hiddenCriterio_81">
                    <input type="hidden" name="Criterio_82" id="hiddenCriterio_82">
                    <input type="hidden" name="Criterio_83" id="hiddenCriterio_83">
                    <input type="hidden" name="Criterio_84" id="hiddenCriterio_84">
                    <input type="hidden" name="Criterio_85" id="hiddenCriterio_85">
                    <input type="hidden" name="Criterio_86" id="hiddenCriterio_86">
                    <input type="hidden" name="Criterio_87" id="hiddenCriterio_87">
                    <input type="hidden" name="Criterio_88" id="hiddenCriterio_88">
                    <input type="hidden" name="Criterio_89" id="hiddenCriterio_89">
                    <input type="hidden" name="Criterio_90" id="hiddenCriterio_90">
                    <input type="hidden" name="Criterio_91" id="hiddenCriterio_91">
                    <input type="hidden" name="Criterio_92" id="hiddenCriterio_92">
                    <input type="hidden" name="Criterio_93" id="hiddenCriterio_93">
                    <input type="hidden" name="Criterio_94" id="hiddenCriterio_94">
                    <input type="hidden" name="Criterio_95" id="hiddenCriterio_95">
                    <input type="hidden" name="Criterio_96" id="hiddenCriterio_96">
                    <input type="hidden" name="Criterio_97" id="hiddenCriterio_97">
                    <input type="hidden" name="Criterio_98" id="hiddenCriterio_98">
                    <input type="hidden" name="Criterio_99" id="hiddenCriterio_99">
                    <input type="hidden" name="Criterio_100" id="hiddenCriterio_100">
                    <input type="hidden" name="Criterio_101" id="hiddenCriterio_101">
                    <input type="hidden" name="Criterio_102" id="hiddenCriterio_102">
                    <input type="hidden" name="Criterio_103" id="hiddenCriterio_103">
                    <input type="hidden" name="Criterio_104" id="hiddenCriterio_104">
                    <input type="hidden" name="Criterio_105" id="hiddenCriterio_105">
                    <input type="hidden" name="Criterio_106" id="hiddenCriterio_106">
                    <input type="hidden" name="Criterio_107" id="hiddenCriterio_107">
                    <input type="hidden" name="Criterio_108" id="hiddenCriterio_108">
                    <input type="hidden" name="Criterio_109" id="hiddenCriterio_109">
                    <input type="hidden" name="Criterio_110" id="hiddenCriterio_110">
                    <input type="hidden" name="Criterio_111" id="hiddenCriterio_111">
                    <input type="hidden" name="Criterio_112" id="hiddenCriterio_112">
                    <input type="hidden" name="Criterio_113" id="hiddenCriterio_113">
                    <input type="hidden" name="Criterio_114" id="hiddenCriterio_114">
                    <input type="hidden" name="Criterio_115" id="hiddenCriterio_115">
                    <input type="hidden" name="Criterio_116" id="hiddenCriterio_116">
                    <input type="hidden" name="Criterio_117" id="hiddenCriterio_117">
                    <input type="hidden" name="Criterio_118" id="hiddenCriterio_118">
                    <input type="hidden" name="Criterio_119" id="hiddenCriterio_119">
                    <input type="hidden" name="Criterio_120" id="hiddenCriterio_120">
                    <input type="hidden" name="Criterio_121" id="hiddenCriterio_121">
                    <input type="hidden" name="Criterio_131" id="hiddenCriterio_131">
                    <input type="hidden" name="Criterio_132" id="hiddenCriterio_132">
                    <input type="hidden" name="Criterio_133" id="hiddenCriterio_133">
                    <input type="hidden" name="Criterio_134" id="hiddenCriterio_134">
                    <input type="hidden" name="Criterio_135" id="hiddenCriterio_135">
                    <input type="hidden" name="Criterio_136" id="hiddenCriterio_136">
                    <input type="hidden" name="Criterio_137" id="hiddenCriterio_137">
                    <input type="hidden" name="Criterio_138" id="hiddenCriterio_138">
                    <input type="hidden" name="Criterio_139" id="hiddenCriterio_139">
                    <input type="hidden" name="Criterio_122" id="hiddenCriterio_122">
                    <input type="hidden" name="Criterio_123" id="hiddenCriterio_123">
                    <input type="hidden" name="Criterio_124" id="hiddenCriterio_124">
                    <input type="hidden" name="Criterio_125" id="hiddenCriterio_125">
                    <input type="hidden" name="Criterio_126" id="hiddenCriterio_126">
                    <input type="hidden" name="Criterio_127" id="hiddenCriterio_127">
                    <input type="hidden" name="Criterio_128" id="hiddenCriterio_128">
                    <input type="hidden" name="Criterio_129" id="hiddenCriterio_129">
                    <input type="hidden" name="Criterio_130" id="hiddenCriterio_130">
                    <input class="form-control d-none" type="file" id="imagenesDiagnosticoBateria" name="imagenesDiagnosticoBateria[]" accept="image/*" multiple>
                    <input class="form-control d-none" type="file" id="imagenesDiagnosticoEletrico" name="imagenesDiagnosticoEletrico[]" accept="image/*" multiple>
                    <input class="form-control d-none" type="file" id="imagenesDiagnosticoTraccion" name="imagenesDiagnosticoTraccion[]" accept="image/*" multiple>
                    <input class="form-control d-none" type="file" id="imagenesDiagnosticoFrenos" name="imagenesDiagnosticoFrenos[]" accept="image/*" multiple>
                    <input class="form-control d-none" type="file" id="imagenesDiagnosticoDireccion" name="imagenesDiagnosticoDireccion[]" accept="image/*" multiple>
                    <input class="form-control d-none" type="file" id="imagenesDiagnosticoHidraulico" name="imagenesDiagnosticoHidraulico[]" accept="image/*" multiple>
                    <input class="form-control d-none" type="file" id="imagenesDiagnosticoMastil" name="imagenesDiagnosticoMastil[]" accept="image/*" multiple>
                    <input class="form-control d-none" type="file" id="imagenesDiagnosticoCarroPorta" name="imagenesDiagnosticoCarroPorta[]" accept="image/*" multiple>
                    <input class="form-control d-none" type="file" id="imagenesDiagnosticoAditamientos" name="imagenesDiagnosticoAditamientos[]" accept="image/*" multiple>
                    <input class="form-control d-none" type="file" id="imagenesDiagnosticoHorquillas" name="imagenesDiagnosticoHorquillas[]" accept="image/*" multiple>
                    <input class="form-control d-none" type="file" id="imagenesDiagnosticoRuedas" name="imagenesDiagnosticoRuedas[]" accept="image/*" multiple>
                    <input class="form-control d-none" type="file" id="imagenesDiagnosticoChasis" name="imagenesDiagnosticoChasis[]" accept="image/*" multiple>
                    <input class="form-control d-none" type="file" id="imagenesDiagnosticoLuces" name="imagenesDiagnosticoLuces[]" accept="image/*" multiple>
                    <input class="form-control d-none" type="file" id="imagenesDiagnosticoLubricacion" name="imagenesDiagnosticoLubricacion[]" accept="image/*" multiple>
                    <input class="form-control d-none" type="file" id="imagenesDiagnosticoCargador" name="imagenesDiagnosticoCargador[]" accept="image/*" multiple>
                    <input class="form-control d-none" type="file" id="imagenesDiagnosticoRevision" name="imagenesDiagnosticoRevision[]" accept="image/*" multiple>                   
                    <input type="hidden" name="Tipo" value="MantenimietoPreventivo">
                    <button type="submit" class="btn btn-primary mt-3">Agregar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para agregar técnico -->
<div class="modal fade" id="modalAgregarTecnico" tabindex="-1" aria-labelledby="modalAgregarTecnicoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #000020;">
                <h5 class="modal-title text-white" id="modalAgregarTecnicoLabel">Agregar Técnico Encargado</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="documentForm" method="POST">
                    <div class="mb-3">
                        <label for="Documento">Número de Identificación</label>
                        <input type="text" class="form-control" id="Documento" placeholder="Ingrese el número de identificación">
                    </div>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="guardarTecnico">Agregar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Batería -->
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
                    <label for="NumeroBateria" class="form-label">N° de Batería</label>
                    <input type="text" class="form-control" name="NumeroBateria" id="NumeroBateria" placeholder="# de batería" required>
                </div>
                <div class="mb-3">
                    <label for="Criterio_1" class="form-label">Estado de cables</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select me-2" id="Criterio_1" name="Criterio_1" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_1"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_2" class="form-label">Nivel de electrolito</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select me-2" id="Criterio_2" name="Criterio_2" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_2"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_3" class="form-label">Conector Anderson</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select me-2" id="Criterio_3" name="Criterio_3" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_3"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_4" class="form-label">Comportartimiento de la batería</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select me-2" id="Criterio_4" name="Criterio_4" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_4"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_5" class="form-label">Estado de batería</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select me-2" id="Criterio_5" name="Criterio_5" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_5"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_6" class="form-label">Estado de los puentes</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select me-2" id="Criterio_6" name="Criterio_6" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_6"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Subir Imágenes del Diagnóstico</label>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-primary" id="btnTomarFoto1">Tomar Foto</button>
                        <button type="button" class="btn btn-outline-secondary" id="btnCargarImagen1">Cargar Imágenes</button>
                    </div>
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
        const btnTomarFoto = document.getElementById('btnTomarFoto1');
        const btnCargarImagen = document.getElementById('btnCargarImagen1');

    function actualizarEstado(select) {
        const icon = document.getElementById(`icon-${select.id}`);
        select.classList.remove('select-Conforme', 'select-Nivelacion', 'select-Ajuste', 'select-Lubricacion', 'select-malo', 'select-vacio', 'select-Aplica');

            if (select.value === 'Conforme') {
                icon.textContent = '✔️';
                icon.style.color = 'green';
                select.classList.add('select-Conforme');
            } else if (select.value === 'Reparación') {
                icon.textContent = '⚠️';
                icon.style.color = 'red';
                select.classList.add('select-malo');
            }else if (select.value === 'Nivelacion') {
                icon.textContent = '📏';
                icon.style.color = 'yellow';
                select.classList.add('select-Nivelacion');
            }else if (select.value === 'Ajuste') {
                icon.textContent = '⚙️';
                icon.style.color = 'Orange';
                select.classList.add('select-Ajuste'); 
            }else if (select.value === 'Lubricación') {
                icon.textContent = '🛢️';
                icon.style.color = 'Blue';
                select.classList.add('select-Lubricacion');
            }else if (select.value === 'NoAplica') {
                icon.textContent = '➖';
                icon.style.color = 'Gray';
                select.classList.add('select-Aplica'); 
            }else {
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

            // ✅ Validar que el número de batería no esté vacío
            const numeroBateria = document.getElementById('NumeroBateria').value.trim();
            if (numeroBateria === "") {
                alert("Debe ingresar el número de batería.");
                document.getElementById('NumeroBateria').focus();
                valido = false;
            }

            if (!valido) return;

            // ✅ Guardar valores en campos ocultos del formulario principal
            document.getElementById('hiddenNumeroBateria').value = numeroBateria;
            document.getElementById('hiddenCriterio_1').value = document.getElementById('Criterio_1').value;
            document.getElementById('hiddenCriterio_2').value = document.getElementById('Criterio_2').value;
            document.getElementById('hiddenCriterio_3').value = document.getElementById('Criterio_3').value;
            document.getElementById('hiddenCriterio_4').value = document.getElementById('Criterio_4').value;
            document.getElementById('hiddenCriterio_5').value = document.getElementById('Criterio_5').value;
            document.getElementById('hiddenCriterio_6').value = document.getElementById('Criterio_6').value;

            // ✅ También puedes mostrar los archivos seleccionados
            let archivos = [];
            for (let i = 0; i < fileInput.files.length; i++) {
                archivos.push(fileInput.files[i].name);
            }
            console.log("Imágenes cargadas:", archivos);

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
                    <label for="Criterio_7" class="form-label">Controlador tracción</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_7" name="Criterio_7" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_7"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_8" class="form-label">Controlador elevación</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_8" name="Criterio_8" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_8"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_9" class="form-label">Tarjeta tracción</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_9" name="Criterio_9" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_9"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_10" class="form-label">Tarjeta elevación</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_10" name="Criterio_10" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_10"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_11" class="form-label">ECU</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_11" name="Criterio_11" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_11"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_12" class="form-label">MIB</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_12" name="Criterio_12" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_12"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_13" class="form-label">Displey</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_13" name="Criterio_13" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_13"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_14" class="form-label">Joystick</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_14" name="Criterio_14" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_14"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_15" class="form-label">Cables de potencia</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_15" name="Criterio_15" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_15"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_16" class="form-label">Desconector de emergencia</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_16" name="Criterio_16" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_16"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_17" class="form-label">Cables de control</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_17" name="Criterio_17" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_17"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_18" class="form-label">Conectores</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_18" name="Criterio_18" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_18"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_19" class="form-label">Fusibles</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_19" name="Criterio_19" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_19"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_20" class="form-label">Contactor de linea</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_20" name="Criterio_20" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_20"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_21" class="form-label">Contactor funciones auxiliares</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_21" name="Criterio_21" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_21"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_22" class="form-label">Contactor de elevación</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_22" name="Criterio_22" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_22"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_23" class="form-label">Micros</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_23" name="Criterio_23" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_23"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_24" class="form-label">Switch de ignicion</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_24" name="Criterio_24" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_24"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_25" class="form-label">Cable de autoSostenido</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_25" name="Criterio_25" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_25"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_26" class="form-label">Ventiladores</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_26" name="Criterio_26" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_26"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_27" class="form-label">Conversor de luces (VMC)</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_27" name="Criterio_27" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_27"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Subir Imágenes del Diagnóstico</label>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-primary" id="btnTomarFotoElectrico">Tomar Foto</button>
                        <button type="button" class="btn btn-outline-secondary" id="btnCargarImagenElectrico">Cargar Imágenes</button>
                    </div>
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
        const btnTomarFotoElectrico = document.getElementById('btnTomarFotoElectrico');
        const btnCargarImagenElectrico = document.getElementById('btnCargarImagenElectrico');

        function actualizarEstadoElectrico(selectElectrico) {
            const iconElectrico = document.getElementById(`icon-${selectElectrico.id}`);
            selectElectrico.classList.remove('select-Conforme', 'select-Nivelacion', 'select-Ajuste', 'select-Lubricacion', 'select-malo', 'select-vacio', 'select-Aplica');

            if (selectElectrico.value === 'Conforme') {
                iconElectrico.textContent = '✔️';
                iconElectrico.style.color = 'green';
                selectElectrico.classList.add('select-Conforme');
            } else if (selectElectrico.value === 'Reparación') {
                iconElectrico.textContent = '⚠️';
                iconElectrico.style.color = 'red';
                selectElectrico.classList.add('select-malo');
            }else if (selectElectrico.value === 'Nivelacion') {
                iconElectrico.textContent = '📏';
                iconElectrico.style.color = 'yellow';
                selectElectrico.classList.add('select-Nivelacion');
            }else if (selectElectrico.value === 'Ajuste') {
                iconElectrico.textContent = '⚙️';
                iconElectrico.style.color = 'Orange';
                selectElectrico.classList.add('select-Ajuste'); 
            }else if (selectElectrico.value === 'Lubricación') {
                iconElectrico.textContent = '🛢️';
                iconElectrico.style.color = 'Blue';
                selectElectrico.classList.add('select-Lubricacion');
            }else if (selectElectrico.value === 'NoAplica') {
                iconElectrico.textContent = '➖';
                iconElectrico.style.color = 'Gray';
                selectElectrico.classList.add('select-Aplica'); 
            }else {
                iconElectrico.textContent = '❌';
                iconElectrico.style.color = 'red';
                selectElectrico.classList.add('select-vacio');
            }
        }

        selectsElectrico.forEach(selectElectrico => {
            selectElectrico.addEventListener('change', () => actualizarEstadoElectrico(selectElectrico));
        });

        // Botón para tomar foto (cámara)
        btnTomarFotoElectrico.addEventListener('click', () => {
            fileInputElectrico.removeAttribute('multiple');
            fileInputElectrico.setAttribute('capture', 'environment');
            fileInputElectrico.click();
        });

        // Botón para cargar imágenes (galería/archivos)
        btnCargarImagenElectrico.addEventListener('click', () => {
            fileInputElectrico.setAttribute('multiple', 'true');
            fileInputElectrico.removeAttribute('capture');
            fileInputElectrico.click();
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

            // ✅ Guardar valores en campos ocultos del formulario principal
            document.getElementById('hiddenCriterio_7').value = document.getElementById('Criterio_7').value;
            document.getElementById('hiddenCriterio_8').value = document.getElementById('Criterio_8').value;
            document.getElementById('hiddenCriterio_9').value = document.getElementById('Criterio_9').value;
            document.getElementById('hiddenCriterio_10').value = document.getElementById('Criterio_10').value;
            document.getElementById('hiddenCriterio_11').value = document.getElementById('Criterio_11').value;
            document.getElementById('hiddenCriterio_12').value = document.getElementById('Criterio_12').value;
            document.getElementById('hiddenCriterio_13').value = document.getElementById('Criterio_13').value;
            document.getElementById('hiddenCriterio_14').value = document.getElementById('Criterio_14').value;
            document.getElementById('hiddenCriterio_15').value = document.getElementById('Criterio_15').value;
            document.getElementById('hiddenCriterio_16').value = document.getElementById('Criterio_16').value;
            document.getElementById('hiddenCriterio_17').value = document.getElementById('Criterio_17').value;
            document.getElementById('hiddenCriterio_18').value = document.getElementById('Criterio_18').value;
            document.getElementById('hiddenCriterio_19').value = document.getElementById('Criterio_19').value;
            document.getElementById('hiddenCriterio_20').value = document.getElementById('Criterio_20').value;
            document.getElementById('hiddenCriterio_21').value = document.getElementById('Criterio_21').value;
            document.getElementById('hiddenCriterio_22').value = document.getElementById('Criterio_22').value;
            document.getElementById('hiddenCriterio_23').value = document.getElementById('Criterio_23').value;
            document.getElementById('hiddenCriterio_24').value = document.getElementById('Criterio_24').value;
            document.getElementById('hiddenCriterio_25').value = document.getElementById('Criterio_25').value;
            document.getElementById('hiddenCriterio_26').value = document.getElementById('Criterio_26').value;
            document.getElementById('hiddenCriterio_27').value = document.getElementById('Criterio_27').value;

            // ✅ También puedes mostrar los archivos seleccionados
            let archivos = [];
            for (let i = 0; i < fileInputElectrico.files.length; i++) {
                archivos.push(fileInputElectrico.files[i].name);
            }
            console.log("Imágenes cargadas:", archivos);

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

<!-- Sistema Traccion -->
<div class="modal fade" id="ModalTraccion" tabindex="-1" aria-labelledby="ModalTraccionLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #000020;">
                <h5 class="modal-title text-white" id="ModalTraccionLabel">Diagnóstico: Sistema Tracción</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="Criterio_28" class="form-label">Motor de tracción</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_28" name="Criterio_28" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_28"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_29" class="form-label">Escobillas</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_29" name="Criterio_29" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_29"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_30" class="form-label">Cremallera</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_30" name="Criterio_30" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_30"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_31" class="form-label">Rodamiento tornamesa</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_31" name="Criterio_31" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_31"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_32" class="form-label">Transmisión</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_32" name="Criterio_32" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_32"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_33" class="form-label">Nivel de valvulina</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_33" name="Criterio_33" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_33"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_34" class="form-label">Tornillería</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_34" name="Criterio_34" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_34"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Subir Imágenes del Diagnóstico</label>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-primary" id="btnTomarFotoTraccion">Tomar Foto</button>
                        <button type="button" class="btn btn-outline-secondary" id="btnCargarImagenTraccion">Cargar Imágenes</button>
                    </div>
                </div>
                <button id="btnGuardarTraccion" type="button" class="btn text-white" style="background-color: #000020;">Guardar Diagnóstico</button>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const selectsTraccion = document.querySelectorAll('#ModalTraccion select.form-select');
        const fileInputTraccion = document.getElementById('imagenesDiagnosticoTraccion');
        const botonTraccion = document.getElementById('btnGuardarTraccion');
        const btnTomarFotoTraccion = document.getElementById('btnTomarFotoTraccion');
        const btnCargarImagenTraccion = document.getElementById('btnCargarImagenTraccion');

        function actualizarEstadoTraccion(selectTraccion) {
            const iconTraccion = document.getElementById(`icon-${selectTraccion.id}`);
            selectTraccion.classList.remove('select-Conforme', 'select-Nivelacion', 'select-Ajuste', 'select-Lubricacion', 'select-malo', 'select-vacio', 'select-Aplica');

            if (selectTraccion.value === 'Conforme') {
                iconTraccion.textContent = '✔️';
                iconTraccion.style.color = 'green';
                selectTraccion.classList.add('select-Conforme');
            } else if (selectTraccion.value === 'Reparación') {
                iconTraccion.textContent = '⚠️';
                iconTraccion.style.color = 'red';
                selectTraccion.classList.add('select-malo');
            }else if (selectTraccion.value === 'Nivelacion') {
                iconTraccion.textContent = '📏';
                iconTraccion.style.color = 'yellow';
                selectTraccion.classList.add('select-Nivelacion');
            }else if (selectTraccion.value === 'Ajuste') {
                iconTraccion.textContent = '⚙️';
                iconTraccion.style.color = 'Orange';
                selectTraccion.classList.add('select-Ajuste'); 
            }else if (selectTraccion.value === 'Lubricación') {
                iconTraccion.textContent = '🛢️';
                iconTraccion.style.color = 'Blue';
                selectTraccion.classList.add('select-Lubricacion');
            }else if (selectTraccion.value === 'NoAplica') {
                iconTraccion.textContent = '➖';
                iconTraccion.style.color = 'Gray';
                selectTraccion.classList.add('select-Aplica'); 
            }else {
                iconTraccion.textContent = '❌';
                iconTraccion.style.color = 'red';
                selectTraccion.classList.add('select-vacio');
            }
        }

        selectsTraccion.forEach(selectTraccion => {
            selectTraccion.addEventListener('change', () => actualizarEstadoTraccion(selectTraccion));
        });

        // Botón para tomar foto (cámara)
        btnTomarFotoTraccion.addEventListener('click', () => {
            fileInputTraccion.removeAttribute('multiple');
            fileInputTraccion.setAttribute('capture', 'environment');
            fileInputTraccion.click();
        });

        // Botón para cargar imágenes (galería/archivos)
        btnCargarImagenTraccion.addEventListener('click', () => {
            fileInputTraccion.setAttribute('multiple', 'true');
            fileInputTraccion.removeAttribute('capture');
            fileInputTraccion.click();
        });

        botonTraccion.addEventListener('click', () => {
            let valido = true;

            selectsTraccion.forEach(selectTraccion => {
                if (!selectTraccion.value) {
                    actualizarEstadoTraccion(selectTraccion);
                    valido = false;
                }
            });

            if (fileInputTraccion.files.length === 0) {
                alert('Debe subir al menos una imagen del diagnóstico.');
                valido = false;
            }

            if (!valido) return;

            // ✅ Guardar valores en campos ocultos del formulario principal
            document.getElementById('hiddenCriterio_28').value = document.getElementById('Criterio_28').value;
            document.getElementById('hiddenCriterio_29').value = document.getElementById('Criterio_29').value;
            document.getElementById('hiddenCriterio_30').value = document.getElementById('Criterio_30').value;
            document.getElementById('hiddenCriterio_31').value = document.getElementById('Criterio_31').value;
            document.getElementById('hiddenCriterio_32').value = document.getElementById('Criterio_32').value;
            document.getElementById('hiddenCriterio_33').value = document.getElementById('Criterio_33').value;
            document.getElementById('hiddenCriterio_34').value = document.getElementById('Criterio_34').value;


            // ✅ También puedes mostrar los archivos seleccionados
            let archivos = [];
            for (let i = 0; i < fileInputTraccion.files.length; i++) {
                archivos.push(fileInputTraccion.files[i].name);
            }
            console.log("Imágenes cargadas:", archivos);

            // ✅ Cambiar color del card
            const card = document.getElementById('btnTraccionCard').querySelector('div');
            card.classList.remove('bg-light');
            card.classList.add('bg-validado');

            // ❌ Cerrar modal actual
            const ModalTraccion = bootstrap.Modal.getInstance(document.getElementById('ModalTraccion'));
            ModalTraccion.hide();

            // ✅ Abrir siguiente modal
            const modalAgregar = new bootstrap.Modal(document.getElementById('AgregarDiagnostico'));
            modalAgregar.show();
        });
    });
</script>

<!-- Sistema de Frenos -->
<div class="modal fade" id="ModalFrenos" tabindex="-1" aria-labelledby="ModalFrenosLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #000020;">
                <h5 class="modal-title text-white" id="ModalFrenosLabel">Diagnóstico: Sistema de frenos</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="Criterio_35" class="form-label">Liquido de frenos</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_35" name="Criterio_35" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_35"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_36" class="form-label">Bomba de freno principal</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_36" name="Criterio_36" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_36"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_37" class="form-label">Bomba de freno auxiliar</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_37" name="Criterio_37" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_37"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_38" class="form-label">Estado de bandas</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_38" name="Criterio_38" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_38"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_39" class="form-label">Electrofreno</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_39" name="Criterio_39" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_39"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_40" class="form-label">Estado pastillas</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_40" name="Criterio_40" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_40"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_41" class="form-label">Eficiencia de frenado</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_41" name="Criterio_41" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_41"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Subir Imágenes del Diagnóstico</label>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-primary" id="btnTomarFotoFrenos">Tomar Foto</button>
                        <button type="button" class="btn btn-outline-secondary" id="btnCargarImagenFrenos">Cargar Imágenes</button>
                    </div>
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
        const btnTomarFotoFrenos = document.getElementById('btnTomarFotoFrenos');
        const btnCargarImagenFrenos = document.getElementById('btnCargarImagenFrenos');

        function actualizarEstadoFreno(selectFreno) {
            const iconFreno = document.getElementById(`icon-${selectFreno.id}`);
            selectFreno.classList.remove('select-Conforme', 'select-Nivelacion', 'select-Ajuste', 'select-Lubricacion', 'select-malo', 'select-vacio', 'select-Aplica');

            if (selectFreno.value === 'Conforme') {
                iconFreno.textContent = '✔️';
                iconFreno.style.color = 'green';
                selectFreno.classList.add('select-Conforme');
            } else if (selectFreno.value === 'Reparación') {
                iconFreno.textContent = '⚠️';
                iconFreno.style.color = 'red';
                selectFreno.classList.add('select-malo');
            }else if (selectFreno.value === 'Nivelacion') {
                iconFreno.textContent = '📏';
                iconFreno.style.color = 'yellow';
                selectFreno.classList.add('select-Nivelacion');
            }else if (selectFreno.value === 'Ajuste') {
                iconFreno.textContent = '⚙️';
                iconFreno.style.color = 'Orange';
                selectFreno.classList.add('select-Ajuste'); 
            }else if (selectFreno.value === 'Lubricación') {
                iconFreno.textContent = '🛢️';
                iconFreno.style.color = 'Blue';
                selectFreno.classList.add('select-Lubricacion');
            }else if (selectFreno.value === 'NoAplica') {
                iconFreno.textContent = '➖';
                iconFreno.style.color = 'Gray';
                selectFreno.classList.add('select-Aplica'); 
            }else {
                iconFreno.textContent = '❌';
                iconFreno.style.color = 'red';
                selectFreno.classList.add('select-vacio');
            }
        }

        selectsFreno.forEach(selectFreno => {
            selectFreno.addEventListener('change', () => actualizarEstadoFreno(selectFreno));
        });

        // Botón para tomar foto (cámara)
        btnTomarFotoFrenos.addEventListener('click', () => {
            fileInputFreno.removeAttribute('multiple');
            fileInputFreno.setAttribute('capture', 'environment');
            fileInputFreno.click();
        });

        // Botón para cargar imágenes (galería/archivos)
        btnCargarImagenFrenos.addEventListener('click', () => {
            fileInputFreno.setAttribute('multiple', 'true');
            fileInputFreno.removeAttribute('capture');
            fileInputFreno.click();
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

            // ✅ Guardar valores en campos ocultos del formulario principal
            document.getElementById('hiddenCriterio_35').value = document.getElementById('Criterio_35').value;
            document.getElementById('hiddenCriterio_36').value = document.getElementById('Criterio_36').value;
            document.getElementById('hiddenCriterio_37').value = document.getElementById('Criterio_37').value;
            document.getElementById('hiddenCriterio_38').value = document.getElementById('Criterio_38').value;
            document.getElementById('hiddenCriterio_39').value = document.getElementById('Criterio_39').value;
            document.getElementById('hiddenCriterio_40').value = document.getElementById('Criterio_40').value;
            document.getElementById('hiddenCriterio_41').value = document.getElementById('Criterio_41').value;

            // ✅ También puedes mostrar los archivos seleccionados
            let archivos = [];
            for (let i = 0; i < fileInputFreno.files.length; i++) {
                archivos.push(fileInputFreno.files[i].name);
            }
            console.log("Imágenes cargadas:", archivos);

            // ✅ Cambiar color del card
            const card = document.getElementById('btnFrenosCard').querySelector('div');
            card.classList.remove('bg-light');
            card.classList.add('bg-validado');

            // ❌ Cerrar modal actual
            const ModalFrenos = bootstrap.Modal.getInstance(document.getElementById('ModalFrenos'));
            ModalFrenos.hide();

            // ✅ Abrir siguiente modal
            const modalAgregar = new bootstrap.Modal(document.getElementById('AgregarDiagnostico'));
            modalAgregar.show();
        });
    });
</script>

<!-- Sistema de Sistema de funciones auxiliares -->
<div class="modal fade" id="ModalDireccion" tabindex="-1" aria-labelledby="ModalDireccionLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #000020;">
                <h5 class="modal-title text-white" id="ModalDireccionLabel">Diagnóstico: Sistema De Funciones Auxiliares</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="Criterio_42" class="form-label">Motor de funciones auxiliares</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_42" name="Criterio_42" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_42"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_43" class="form-label">Escobillas</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_43" name="Criterio_43" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_43"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_44" class="form-label">Bomba de funciones auxiliares</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_44" name="Criterio_44" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_44"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_45" class="form-label">Generador de torque</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_45" name="Criterio_45" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_45"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_46" class="form-label">Orbitrol</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_46" name="Criterio_46" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_46"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_47" class="form-label">Mangueras</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_47" name="Criterio_47" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_47"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Subir Imágenes del Diagnóstico</label>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-primary" id="btnTomarFotoDireccion">Tomar Foto</button>
                        <button type="button" class="btn btn-outline-secondary" id="btnCargarImagenDireccion">Cargar Imágenes</button>
                    </div>
                </div>
                <button id="btnGuardarDireccion" type="button" class="btn text-white" style="background-color: #000020;">Guardar Diagnóstico</button>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const selectsDireccion = document.querySelectorAll('#ModalDireccion select.form-select');
        const fileInputDireccion = document.getElementById('imagenesDiagnosticoDireccion');
        const botonFreno = document.getElementById('btnGuardarDireccion');
        const btnTomarFotoDireccion = document.getElementById('btnTomarFotoDireccion');
        const btnCargarImagenDireccion = document.getElementById('btnCargarImagenDireccion');

        function actualizarEstadoDireccion(selectDireccion) {
            const iconDireccion = document.getElementById(`icon-${selectDireccion.id}`);
            selectDireccion.classList.remove('select-Conforme', 'select-Nivelacion', 'select-Ajuste', 'select-Lubricacion', 'select-malo', 'select-vacio', 'select-Aplica');

            if (selectDireccion.value === 'Conforme') {
                iconDireccion.textContent = '✔️';
                iconDireccion.style.color = 'green';
                selectDireccion.classList.add('select-Conforme');
            } else if (selectDireccion.value === 'Reparación') {
                iconDireccion.textContent = '⚠️';
                iconDireccion.style.color = 'red';
                selectDireccion.classList.add('select-malo');
            }else if (selectDireccion.value === 'Nivelacion') {
                iconDireccion.textContent = '📏';
                iconDireccion.style.color = 'yellow';
                selectDireccion.classList.add('select-Nivelacion');
            }else if (selectDireccion.value === 'Ajuste') {
                iconDireccion.textContent = '⚙️';
                iconDireccion.style.color = 'Orange';
                selectDireccion.classList.add('select-Ajuste'); 
            }else if (selectDireccion.value === 'Lubricación') {
                iconDireccion.textContent = '🛢️';
                iconDireccion.style.color = 'Blue';
                selectDireccion.classList.add('select-Lubricacion');
            }else if (selectDireccion.value === 'NoAplica') {
                iconDireccion.textContent = '➖';
                iconDireccion.style.color = 'Gray';
                selectDireccion.classList.add('select-Aplica'); 
            }else {
                iconDireccion.textContent = '❌';
                iconDireccion.style.color = 'red';
                selectDireccion.classList.add('select-vacio');
            }
        }

        selectsDireccion.forEach(selectDireccion => {
            selectDireccion.addEventListener('change', () => actualizarEstadoDireccion(selectDireccion));
        });

        // Botón para tomar foto (cámara)
        btnTomarFotoDireccion.addEventListener('click', () => {
            fileInputDireccion.removeAttribute('multiple');
            fileInputDireccion.setAttribute('capture', 'environment');
            fileInputDireccion.click();
        });

        // Botón para cargar imágenes (galería/archivos)
        btnCargarImagenDireccion.addEventListener('click', () => {
            fileInputDireccion.setAttribute('multiple', 'true');
            fileInputDireccion.removeAttribute('capture');
            fileInputDireccion.click();
        });

        botonFreno.addEventListener('click', () => {
            let valido = true;

            selectsDireccion.forEach(selectDireccion => {
                if (!selectDireccion.value) {
                    actualizarEstadoDireccion(selectDireccion);
                    valido = false;
                }
            });

            if (fileInputDireccion.files.length === 0) {
                alert('Debe subir al menos una imagen del diagnóstico.');
                valido = false;
            }

            if (!valido) return;

            // ✅ Guardar valores en campos ocultos del formulario principal
            document.getElementById('hiddenCriterio_42').value = document.getElementById('Criterio_42').value;
            document.getElementById('hiddenCriterio_43').value = document.getElementById('Criterio_43').value;
            document.getElementById('hiddenCriterio_44').value = document.getElementById('Criterio_44').value;
            document.getElementById('hiddenCriterio_45').value = document.getElementById('Criterio_45').value;
            document.getElementById('hiddenCriterio_46').value = document.getElementById('Criterio_46').value;
            document.getElementById('hiddenCriterio_47').value = document.getElementById('Criterio_47').value;

            // ✅ También puedes mostrar los archivos seleccionados
            let archivos = [];
            for (let i = 0; i < fileInputDireccion.files.length; i++) {
                archivos.push(fileInputDireccion.files[i].name);
            }
            console.log("Imágenes cargadas:", archivos);

            // ✅ Cambiar color del card
            const card = document.getElementById('btnDireccionCard').querySelector('div');
            card.classList.remove('bg-light');
            card.classList.add('bg-validado');

            // ❌ Cerrar modal actual
            const ModalDireccion = bootstrap.Modal.getInstance(document.getElementById('ModalDireccion'));
            ModalDireccion.hide();

            // ✅ Abrir siguiente modal
            const modalAgregar = new bootstrap.Modal(document.getElementById('AgregarDiagnostico'));
            modalAgregar.show();
        });
    });
</script>

<!-- Sistema de Hidraulico -->
<div class="modal fade" id="ModalHidraulico" tabindex="-1" aria-labelledby="ModalHidraulicoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #000020;">
                <h5 class="modal-title text-white" id="ModalHidraulicoLabel">Diagnóstico: Sistema Hidráulico</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="Criterio_48" class="form-label">Estado aceite hidráulico</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_48" name="Criterio_48" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_48"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_49" class="form-label">Motor de sistema hidráulico</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_49" name="Criterio_49" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_49"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_50" class="form-label">Escobillas</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_50" name="Criterio_50" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_50"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_51" class="form-label">Bomba sistema hidráulico</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_51" name="Criterio_51" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_51"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_52" class="form-label">Filtro de retorno</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_52" name="Criterio_52" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_52"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_53" class="form-label">Cuerpo de válvulas</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_53" name="Criterio_53" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_53"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_54" class="form-label">Electro válvulas</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_54" name="Criterio_54" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_54"></span>
                    </div>
                </div>                
                <div class="mb-3">
                    <label for="Criterio_55" class="form-label">Mangueras</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_55" name="Criterio_55" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_55"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_56" class="form-label">Micros de funciones hidráulicas</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_56" name="Criterio_56" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_56"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Subir Imágenes del Diagnóstico</label>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-primary" id="btnTomarFotoHidraulico">Tomar Foto</button>
                        <button type="button" class="btn btn-outline-secondary" id="btnCargarImagenHidraulico">Cargar Imágenes</button>
                    </div>
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
        const btnTomarFotoHidraulico = document.getElementById('btnTomarFotoHidraulico');
        const btnCargarImagenHidraulico = document.getElementById('btnCargarImagenHidraulico');

        function actualizarEstadoHidraulico(selectHidraulico) {
            const iconHidraulico = document.getElementById(`icon-${selectHidraulico.id}`);
            selectHidraulico.classList.remove('select-Conforme', 'select-Nivelacion', 'select-Ajuste', 'select-Lubricacion', 'select-malo', 'select-vacio', 'select-Aplica');

            if (selectHidraulico.value === 'Conforme') {
                iconHidraulico.textContent = '✔️';
                iconHidraulico.style.color = 'green';
                selectHidraulico.classList.add('select-Conforme');
            } else if (selectHidraulico.value === 'Reparación') {
                iconHidraulico.textContent = '⚠️';
                iconHidraulico.style.color = 'red';
                selectHidraulico.classList.add('select-malo');
            }else if (selectHidraulico.value === 'Nivelacion') {
                iconHidraulico.textContent = '📏';
                iconHidraulico.style.color = 'yellow';
                selectHidraulico.classList.add('select-Nivelacion');
            }else if (selectHidraulico.value === 'Ajuste') {
                iconHidraulico.textContent = '⚙️';
                iconHidraulico.style.color = 'Orange';
                selectHidraulico.classList.add('select-Ajuste'); 
            }else if (selectHidraulico.value === 'Lubricación') {
                iconHidraulico.textContent = '🛢️';
                iconHidraulico.style.color = 'Blue';
                selectHidraulico.classList.add('select-Lubricacion');
            }else if (selectHidraulico.value === 'NoAplica') {
                iconHidraulico.textContent = '➖';
                iconHidraulico.style.color = 'Gray';
                selectHidraulico.classList.add('select-Aplica'); 
            }else {
                iconHidraulico.textContent = '❌';
                iconHidraulico.style.color = 'red';
                selectHidraulico.classList.add('select-vacio');
            }
        }

        selectsHidraulico.forEach(selectHidraulico => {
            selectHidraulico.addEventListener('change', () => actualizarEstadoHidraulico(selectHidraulico));
        });

        // Botón para tomar foto (cámara)
        btnTomarFotoHidraulico.addEventListener('click', () => {
            fileInputHidraulico.removeAttribute('multiple');
            fileInputHidraulico.setAttribute('capture', 'environment');
            fileInputHidraulico.click();
        });

        // Botón para cargar imágenes (galería/archivos)
        btnCargarImagenHidraulico.addEventListener('click', () => {
            fileInputHidraulico.setAttribute('multiple', 'true');
            fileInputHidraulico.removeAttribute('capture');
            fileInputHidraulico.click();
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

            // ✅ Guardar valores en campos ocultos del formulario principal
            document.getElementById('hiddenCriterio_48').value = document.getElementById('Criterio_48').value;
            document.getElementById('hiddenCriterio_49').value = document.getElementById('Criterio_49').value;
            document.getElementById('hiddenCriterio_50').value = document.getElementById('Criterio_50').value;
            document.getElementById('hiddenCriterio_51').value = document.getElementById('Criterio_51').value;
            document.getElementById('hiddenCriterio_52').value = document.getElementById('Criterio_52').value;
            document.getElementById('hiddenCriterio_53').value = document.getElementById('Criterio_53').value;
            document.getElementById('hiddenCriterio_54').value = document.getElementById('Criterio_54').value;
            document.getElementById('hiddenCriterio_55').value = document.getElementById('Criterio_55').value;
            document.getElementById('hiddenCriterio_56').value = document.getElementById('Criterio_56').value;

            // ✅ También puedes mostrar los archivos seleccionados
            let archivos = [];
            for (let i = 0; i < fileInputHidraulico.files.length; i++) {
                archivos.push(fileInputHidraulico.files[i].name);
            }
            console.log("Imágenes cargadas:", archivos);

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

<!-- Sistema de Mastil -->
<div class="modal fade" id="ModalMastil" tabindex="-1" aria-labelledby="ModalMastilLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #000020;">
                <h5 class="modal-title text-white" id="ModalMastilLabel">Diagnóstico: Mastil</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="Criterio_63" class="form-label">Ajuste mastil</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_63" name="Criterio_63" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_63"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_64" class="form-label">Estado secciones</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_64" name="Criterio_64" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_64"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_65" class="form-label">Bujes</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_65" name="Criterio_65" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_65"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_66" class="form-label">Rodamientos</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_66" name="Criterio_66" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_66"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_67" class="form-label">Cadenas</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_67" name="Criterio_67" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_67"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_68" class="form-label">Poleas</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_68" name="Criterio_68" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_68"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_69" class="form-label">Pasadores cadenas</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_69" name="Criterio_69" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_69"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_70" class="form-label">Mangueras free lift</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_70" name="Criterio_70" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_70"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_71" class="form-label">Mangueras side shift</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_71" name="Criterio_71" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_71"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_72" class="form-label">Mangueras pantógrafo</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_72" name="Criterio_72" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_72"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_73" class="form-label">Tuberías</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_73" name="Criterio_73" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_73"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_74" class="form-label">Racores</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_74" name="Criterio_74" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_74"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_75" class="form-label">Cilindro de free lift</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_75" name="Criterio_75" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_75"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_76" class="form-label">Cilindro laterales</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_76" name="Criterio_76" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_76"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_77" class="form-label">Cilindros de side shift</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_77" name="Criterio_77" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_77"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_78" class="form-label">Cilindro de pantógrafo</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_78" name="Criterio_78" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_78"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_79" class="form-label">Bloque de válvulas funciones auxiliares</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_79" name="Criterio_79" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_79"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Subir Imágenes del Diagnóstico</label>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-primary" id="btnTomarFotoMastil">Tomar Foto</button>
                        <button type="button" class="btn btn-outline-secondary" id="btnCargarImagenMastil">Cargar Imágenes</button>
                    </div>
                </div>
                <button id="btnGuardarMastil" type="button" class="btn text-white" style="background-color: #000020;">Guardar Diagnóstico</button>
            </div>    
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const selectsMastil = document.querySelectorAll('#ModalMastil select.form-select');
        const fileInputMastil = document.getElementById('imagenesDiagnosticoMastil');
        const botonMastil = document.getElementById('btnGuardarMastil');
        const btnTomarFotoMastil = document.getElementById('btnTomarFotoMastil');
        const btnCargarImagenMastil = document.getElementById('btnCargarImagenMastil');

        function actualizarEstadoMastil(selectMastil) {
            const iconMastil = document.getElementById(`icon-${selectMastil.id}`);
            selectMastil.classList.remove('select-Conforme', 'select-Nivelacion', 'select-Ajuste', 'select-Lubricacion', 'select-malo', 'select-vacio', 'select-Aplica');

            if (selectMastil.value === 'Conforme') {
                iconMastil.textContent = '✔️';
                iconMastil.style.color = 'green';
                selectMastil.classList.add('select-Conforme');
            } else if (selectMastil.value === 'Reparación') {
                iconMastil.textContent = '⚠️';
                iconMastil.style.color = 'red';
                selectMastil.classList.add('select-malo');
            }else if (selectMastil.value === 'Nivelacion') {
                iconMastil.textContent = '📏';
                iconMastil.style.color = 'yellow';
                selectMastil.classList.add('select-Nivelacion');
            }else if (selectMastil.value === 'Ajuste') {
                iconMastil.textContent = '⚙️';
                iconMastil.style.color = 'Orange';
                selectMastil.classList.add('select-Ajuste'); 
            }else if (selectMastil.value === 'Lubricación') {
                iconMastil.textContent = '🛢️';
                iconMastil.style.color = 'Blue';
                selectMastil.classList.add('select-Lubricacion');
            }else if (selectMastil.value === 'NoAplica') {
                iconMastil.textContent = '➖';
                iconMastil.style.color = 'Gray';
                selectMastil.classList.add('select-Aplica'); 
            }else {
                iconMastil.textContent = '❌';
                iconMastil.style.color = 'red';
                selectMastil.classList.add('select-vacio');
            }
        }

        selectsMastil.forEach(selectMastil => {
            selectMastil.addEventListener('change', () => actualizarEstadoMastil(selectMastil));
        });

        // Botón para tomar foto (cámara)
        btnTomarFotoMastil.addEventListener('click', () => {
            fileInputMastil.removeAttribute('multiple');
            fileInputMastil.setAttribute('capture', 'environment');
            fileInputMastil.click();
        });

        // Botón para cargar imágenes (galería/archivos)
        btnCargarImagenMastil.addEventListener('click', () => {
            fileInputMastil.setAttribute('multiple', 'true');
            fileInputMastil.removeAttribute('capture');
            fileInputMastil.click();
        });

        botonMastil.addEventListener('click', () => {
            let valido = true;

            selectsMastil.forEach(selectMastil => {
                if (!selectMastil.value) {
                    actualizarEstadoMastil(selectMastil);
                    valido = false;
                }
            });

            if (fileInputMastil.files.length === 0) {
                alert('Debe subir al menos una imagen del diagnóstico.');
                valido = false;
            }

            if (!valido) return;

            // ✅ Guardar valores en campos ocultos del formulario principal
            document.getElementById('hiddenCriterio_63').value = document.getElementById('Criterio_63').value;
            document.getElementById('hiddenCriterio_64').value = document.getElementById('Criterio_64').value;
            document.getElementById('hiddenCriterio_65').value = document.getElementById('Criterio_65').value;
            document.getElementById('hiddenCriterio_66').value = document.getElementById('Criterio_66').value;
            document.getElementById('hiddenCriterio_67').value = document.getElementById('Criterio_67').value;
            document.getElementById('hiddenCriterio_68').value = document.getElementById('Criterio_68').value;
            document.getElementById('hiddenCriterio_69').value = document.getElementById('Criterio_69').value;
            document.getElementById('hiddenCriterio_70').value = document.getElementById('Criterio_70').value;
            document.getElementById('hiddenCriterio_71').value = document.getElementById('Criterio_71').value;
            document.getElementById('hiddenCriterio_72').value = document.getElementById('Criterio_72').value;
            document.getElementById('hiddenCriterio_73').value = document.getElementById('Criterio_73').value;
            document.getElementById('hiddenCriterio_74').value = document.getElementById('Criterio_74').value;
            document.getElementById('hiddenCriterio_75').value = document.getElementById('Criterio_75').value;
            document.getElementById('hiddenCriterio_76').value = document.getElementById('Criterio_76').value;
            document.getElementById('hiddenCriterio_77').value = document.getElementById('Criterio_77').value;
            document.getElementById('hiddenCriterio_78').value = document.getElementById('Criterio_78').value;
            document.getElementById('hiddenCriterio_79').value = document.getElementById('Criterio_79').value;

            
             // ✅ También puedes mostrar los archivos seleccionad57
            let archivos = [];
            for (let i = 0; i < fileInputMastil.files.length; i++) {
                archivos.push(fileInputMastil.files[i].name);
            }
            console.log("Imágenes cargadas:", archivos);

            // ✅ Cambiar color del card
            const card = document.getElementById('btnMastilCard').querySelector('div');
            card.classList.remove('bg-light');
            card.classList.add('bg-validado');

            // ❌ Cerrar modal actual
            const ModalMastil = bootstrap.Modal.getInstance(document.getElementById('ModalMastil'));
            ModalMastil.hide();

            // ✅ Abrir siguiente modal
            const modalAgregar = new bootstrap.Modal(document.getElementById('AgregarDiagnostico'));
            modalAgregar.show();
        });
    });
</script>

<!-- Modal Pantografo -->
<div class="modal fade" id="ModalCarroPorta" tabindex="-1" aria-labelledby="ModalCarroPortaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #000020;">
                <h5 class="modal-title text-white" id="ModalCarroPortaLabel">Diagnóstico: Pantógrafo</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="Criterio_80" class="form-label">Ajuste de pantógrafo</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_80" name="Criterio_80" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_80"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_81" class="form-label">Rodamientos</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_81" name="Criterio_81" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_81"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_82" class="form-label">Cadenas</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_82" name="Criterio_82" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_82"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_83" class="form-label">Pasadores</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_83" name="Criterio_83" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_83"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_84" class="form-label">Parilla (Espejo)</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_84" name="Criterio_84" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_84"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_85" class="form-label">Mordazas</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_85" name="Criterio_85" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_85"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_86" class="form-label">Deslizadores</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_86" name="Criterio_86" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_86"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_87" class="form-label">Bloque de tilt down</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_87" name="Criterio_87" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_87"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_88" class="form-label">Mangueras</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_88" name="Criterio_88" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_88"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_89" class="form-label">Topes de reach (caucho)</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_89" name="Criterio_89" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_89"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Subir Imágenes del Diagnóstico</label>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-primary" id="btnTomarFotoCarroPorta">Tomar Foto</button>
                        <button type="button" class="btn btn-outline-secondary" id="btnCargarImagenCarroPorta">Cargar Imágenes</button>
                    </div>
                </div>
                <button id="btnGuardarCarroPorta"  type="button" class="btn text-white" style="background-color: #000020;">Guardar Diagnóstico</button>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const selectsCarroPorta= document.querySelectorAll('#ModalCarroPorta select.form-select');
        const fileInputCarroPorta = document.getElementById('imagenesDiagnosticoCarroPorta');
        const botonCarroPorta = document.getElementById('btnGuardarCarroPorta');
        const btnTomarFotoCarroPorta = document.getElementById('btnTomarFotoCarroPorta');
        const btnCargarImagenCarroPorta = document.getElementById('btnCargarImagenCarroPorta');

        function actualizarEstadoCarroPorta(selectCarroPorta) {
            const iconCarroPorta = document.getElementById(`icon-${selectCarroPorta.id}`);
            selectCarroPorta.classList.remove('select-Conforme', 'select-Nivelacion', 'select-Ajuste', 'select-Lubricacion', 'select-malo', 'select-vacio', 'select-Aplica');

            if (selectCarroPorta.value === 'Conforme') {
                iconCarroPorta.textContent = '✔️';
                iconCarroPorta.style.color = 'green';
                selectCarroPorta.classList.add('select-Conforme');
            } else if (selectCarroPorta.value === 'Reparación') {
                iconCarroPorta.textContent = '⚠️';
                iconCarroPorta.style.color = 'red';
                selectCarroPorta.classList.add('select-malo');
            }else if (selectCarroPorta.value === 'Nivelacion') {
                iconCarroPorta.textContent = '📏';
                iconCarroPorta.style.color = 'yellow';
                selectCarroPorta.classList.add('select-Nivelacion');
            }else if (selectCarroPorta.value === 'Ajuste') {
                iconCarroPorta.textContent = '⚙️';
                iconCarroPorta.style.color = 'Orange';
                selectCarroPorta.classList.add('select-Ajuste'); 
            }else if (selectCarroPorta.value === 'Lubricación') {
                iconCarroPorta.textContent = '🛢️';
                iconCarroPorta.style.color = 'Blue';
                selectCarroPorta.classList.add('select-Lubricacion');
            }else if (selectCarroPorta.value === 'NoAplica') {
                iconCarroPorta.textContent = '➖';
                iconCarroPorta.style.color = 'Gray';
                selectCarroPorta.classList.add('select-Aplica'); 
            }else {
                iconCarroPorta.textContent = '❌';
                iconCarroPorta.style.color = 'red';
                selectCarroPorta.classList.add('select-vacio');
            }
        }

        selectsCarroPorta.forEach(selectCarroPorta => {
            selectCarroPorta.addEventListener('change', () => actualizarEstadoCarroPorta(selectCarroPorta));
        });

        // Botón para tomar foto (cámara)
        btnTomarFotoCarroPorta.addEventListener('click', () => {
            fileInputCarroPorta.removeAttribute('multiple');
            fileInputCarroPorta.setAttribute('capture', 'environment');
            fileInputCarroPorta.click();
        });

        // Botón para cargar imágenes (galería/archivos)
        btnCargarImagenCarroPorta.addEventListener('click', () => {
            fileInputCarroPorta.setAttribute('multiple', 'true');
            fileInputCarroPorta.removeAttribute('capture');
            fileInputCarroPorta.click();
        });

        botonCarroPorta.addEventListener('click', () => {
            let valido = true;

            selectsCarroPorta.forEach(selectCarroPorta => {
                if (!selectCarroPorta.value) {
                    actualizarEstadoCarroPorta(selectCarroPorta);
                    valido = false;
                }
            });

            if (fileInputCarroPorta.files.length === 0) {
                alert('Debe subir al menos una imagen del diagnóstico.');
                valido = false;
            }

            if (!valido) return;

            // ✅ Guardar valores en campos ocultos del formulario principal
            document.getElementById('hiddenCriterio_80').value = document.getElementById('Criterio_80').value;
            document.getElementById('hiddenCriterio_81').value = document.getElementById('Criterio_81').value;
            document.getElementById('hiddenCriterio_82').value = document.getElementById('Criterio_82').value;
            document.getElementById('hiddenCriterio_83').value = document.getElementById('Criterio_83').value;
            document.getElementById('hiddenCriterio_84').value = document.getElementById('Criterio_84').value;
            document.getElementById('hiddenCriterio_85').value = document.getElementById('Criterio_85').value;
            document.getElementById('hiddenCriterio_86').value = document.getElementById('Criterio_86').value;
            document.getElementById('hiddenCriterio_87').value = document.getElementById('Criterio_87').value;
            document.getElementById('hiddenCriterio_88').value = document.getElementById('Criterio_88').value;
            document.getElementById('hiddenCriterio_89').value = document.getElementById('Criterio_89').value;

            // ✅ También puedes mostrar los archivos seleccionad57
            let archivos = [];
            for (let i = 0; i < fileInputCarroPorta.files.length; i++) {
                archivos.push(fileInputCarroPorta.files[i].name);
            }
            console.log("Imágenes cargadas:", archivos);

            // ✅ Cambiar color del card
            const card = document.getElementById('btnCarroPortaCard').querySelector('div');
            card.classList.remove('bg-light');
            card.classList.add('bg-validado');

            // ❌ Cerrar modal actual
            const ModalCarroPorta = bootstrap.Modal.getInstance(document.getElementById('ModalCarroPorta'));
            ModalCarroPorta.hide();

            // ✅ Abrir siguiente modal
            const modalAgregar = new bootstrap.Modal(document.getElementById('AgregarDiagnostico'));
            modalAgregar.show();
        });
    });
</script>

<!-- Modal Suspensión -->
<div class="modal fade" id="ModalAditamientos" tabindex="-1" aria-labelledby="ModalAditamientosLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #000020;">
                <h5 class="modal-title text-white" id="ModalAditamientosLabel">Diagnóstico: Sistema de Suspensión</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="Criterio_57" class="form-label">Pasador</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_57" name="Criterio_57" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_57"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_58" class="form-label">Rodamientos</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_58" name="Criterio_58" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_58"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_59" class="form-label">Tornilleria</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_59" name="Criterio_59" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_59"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_60" class="form-label">Suspensión</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_60" name="Criterio_60" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_60"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_61" class="form-label">Pines</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_61" name="Criterio_61" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_61"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_62" class="form-label">Amortiguador</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_62" name="Criterio_62" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_62"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Subir Imágenes del Diagnóstico</label>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-primary" id="btnTomarFotoAditamientos">Tomar Foto</button>
                        <button type="button" class="btn btn-outline-secondary" id="btnCargarImagenAditamientos">Cargar Imágenes</button>
                    </div>
                </div>
                <button id="btnGuardarAditamientos" type="button" class="btn text-white" style="background-color: #000020;">Guardar Diagnóstico</button>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const selectsAditamientos= document.querySelectorAll('#ModalAditamientos select.form-select');
        const fileInputAditamientos = document.getElementById('imagenesDiagnosticoAditamientos');
        const botonAditamientos = document.getElementById('btnGuardarAditamientos');
        const btnTomarFotoAditamientos = document.getElementById('btnTomarFotoAditamientos');
        const btnCargarImagenAditamientos = document.getElementById('btnCargarImagenAditamientos');

        function actualizarEstadoAditamientos(selectAditamientos) {
            const iconAditamientos = document.getElementById(`icon-${selectAditamientos.id}`);
            selectAditamientos.classList.remove('select-Conforme', 'select-Nivelacion', 'select-Ajuste', 'select-Lubricacion', 'select-malo', 'select-vacio', 'select-Aplica');

            if (selectAditamientos.value === 'Conforme') {
                iconAditamientos.textContent = '✔️';
                iconAditamientos.style.color = 'green';
                selectAditamientos.classList.add('select-Conforme');
            } else if (selectAditamientos.value === 'Reparación') {
                iconAditamientos.textContent = '⚠️';
                iconAditamientos.style.color = 'red';
                selectAditamientos.classList.add('select-malo');
            }else if (selectAditamientos.value === 'Nivelacion') {
                iconAditamientos.textContent = '📏';
                iconAditamientos.style.color = 'yellow';
                selectAditamientos.classList.add('select-Nivelacion');
            }else if (selectAditamientos.value === 'Ajuste') {
                iconAditamientos.textContent = '⚙️';
                iconAditamientos.style.color = 'Orange';
                selectAditamientos.classList.add('select-Ajuste'); 
            }else if (selectAditamientos.value === 'Lubricación') {
                iconAditamientos.textContent = '🛢️';
                iconAditamientos.style.color = 'Blue';
                selectAditamientos.classList.add('select-Lubricacion');
            }else if (selectAditamientos.value === 'NoAplica') {
                iconAditamientos.textContent = '➖';
                iconAditamientos.style.color = 'Gray';
                selectAditamientos.classList.add('select-Aplica'); 
            }else {
                iconAditamientos.textContent = '❌';
                iconAditamientos.style.color = 'red';
                selectAditamientos.classList.add('select-vacio');
            }
        }

        selectsAditamientos.forEach(selectAditamientos => {
            selectAditamientos.addEventListener('change', () => actualizarEstadoAditamientos(selectAditamientos));
        });

        // Botón para tomar foto (cámara)
        btnTomarFotoAditamientos.addEventListener('click', () => {
            fileInputAditamientos.removeAttribute('multiple');
            fileInputAditamientos.setAttribute('capture', 'environment');
            fileInputAditamientos.click();
        });

        // Botón para cargar imágenes (galería/archivos)
        btnCargarImagenAditamientos.addEventListener('click', () => {
            fileInputAditamientos.setAttribute('multiple', 'true');
            fileInputAditamientos.removeAttribute('capture');
            fileInputAditamientos.click();
        });

        botonAditamientos.addEventListener('click', () => {
            let valido = true;

            selectsAditamientos.forEach(selectAditamientos => {
                if (!selectAditamientos.value) {
                    actualizarEstadoAditamientos(selectAditamientos);
                    valido = false;
                }
            });

            if (fileInputAditamientos.files.length === 0) {
                alert('Debe subir al menos una imagen del diagnóstico.');
                valido = false;
            }

            if (!valido) return;

            // ✅ Guardar valores en campos ocultos del formulario principal
            document.getElementById('hiddenCriterio_57').value = document.getElementById('Criterio_57').value;
            document.getElementById('hiddenCriterio_58').value = document.getElementById('Criterio_58').value;
            document.getElementById('hiddenCriterio_59').value = document.getElementById('Criterio_59').value;
            document.getElementById('hiddenCriterio_60').value = document.getElementById('Criterio_60').value;
            document.getElementById('hiddenCriterio_61').value = document.getElementById('Criterio_61').value;
            document.getElementById('hiddenCriterio_62').value = document.getElementById('Criterio_62').value;

             // ✅ También puedes mostrar los archivos seleccionad57
            let archivos = [];
            for (let i = 0; i < fileInputAditamientos.files.length; i++) {
                archivos.push(fileInputAditamientos.files[i].name);
            }
            console.log("Imágenes cargadas:", archivos);

            // ✅ Cambiar color del card
            const card = document.getElementById('btnAditamentosCard').querySelector('div');
            card.classList.remove('bg-light');
            card.classList.add('bg-validado');

            // ❌ Cerrar modal actual
            const ModalAditamientos = bootstrap.Modal.getInstance(document.getElementById('ModalAditamientos'));
            ModalAditamientos.hide();

            // ✅ Abrir siguiente modal
            const modalAgregar = new bootstrap.Modal(document.getElementById('AgregarDiagnostico'));
            modalAgregar.show();
        });
    });
</script>

<!-- Modal Horquillas -->
<div class="modal fade" id="ModalHorquillas" tabindex="-1" aria-labelledby="ModalHorquillasLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #000020;">
                <h5 class="modal-title text-white" id="ModalHorquillasLabel">Diagnóstico: Horquillas</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="Criterio_90" class="form-label">Seguros</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_90" name="Criterio_90" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_90"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_91" class="form-label">Mordaza superior</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_91" name="Criterio_91" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_91"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_92" class="form-label">Mordaza inferior</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_92" name="Criterio_92" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_92"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_93" class="form-label">Clase de horquillas</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_93" name="Criterio_93" required>
                            <option value="" disabled selected>Seleccione clase</option>
                            <option value="Tipo2">Clase 2</option>
                            <option value="Tipo3">Clase 3</option>
                            <option value="Tipo4">Clase 4</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_93"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="LongitudH" class="form-label">Longitud (m)</label>
                    <input type="text" class="form-control" name="LongitudH" id="LongitudH" placeholder="Longitud" >
                </div>
                <div class="mb-3">
                    <label for="Criterio_94" class="form-label">Estado de horquillas (inspección visual ver F-208 como referencia)</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_94" name="Criterio_94" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_94"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Subir Imágenes del Diagnóstico</label>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-primary" id="btnTomarFotoHorquillas">Tomar Foto</button>
                        <button type="button" class="btn btn-outline-secondary" id="btnCargarImagenHorquillas">Cargar Imágenes</button>
                    </div>
                </div>
                <button id="btnGuardarHorquillas" type="button" class="btn text-white" style="background-color: #000020;">Guardar Diagnóstico</button>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const selectsHorquillas= document.querySelectorAll('#ModalHorquillas select.form-select');
        const fileInputHorquillas = document.getElementById('imagenesDiagnosticoHorquillas');
        const botonHorquillas = document.getElementById('btnGuardarHorquillas');
        const btnTomarFotoHorquillas = document.getElementById('btnTomarFotoHorquillas');
        const btnCargarImagenHorquillas = document.getElementById('btnCargarImagenHorquillas');

        function actualizarEstadoHorquillas(selectHorquillas) {
            const iconHorquillas = document.getElementById(`icon-${selectHorquillas.id}`);
            selectHorquillas.classList.remove('select-Conforme', 'select-Nivelacion', 'select-Ajuste', 'select-Lubricacion', 'select-malo', 'select-vacio', 'select-Aplica');

            if (selectHorquillas.value === 'Conforme') {
                iconHorquillas.textContent = '✔️';
                iconHorquillas.style.color = 'green';
                selectHorquillas.classList.add('select-Conforme');
            } else if (selectHorquillas.value === 'Reparación') {
                iconHorquillas.textContent = '⚠️';
                iconHorquillas.style.color = 'red';
                selectHorquillas.classList.add('select-malo');
            }else if (selectHorquillas.value === 'Nivelacion') {
                iconHorquillas.textContent = '📏';
                iconHorquillas.style.color = 'yellow';
                selectHorquillas.classList.add('select-Nivelacion');
            }else if (selectHorquillas.value === 'Ajuste') {
                iconHorquillas.textContent = '⚙️';
                iconHorquillas.style.color = 'Orange';
                selectHorquillas.classList.add('select-Ajuste'); 
            }else if (selectHorquillas.value === 'Lubricación') {
                iconHorquillas.textContent = '🛢️';
                iconHorquillas.style.color = 'Blue';
                selectHorquillas.classList.add('select-Lubricacion');
            }else if (selectHorquillas.value === 'NoAplica') {
                iconHorquillas.textContent = '➖';
                iconHorquillas.style.color = 'Gray';
                selectHorquillas.classList.add('select-Aplica'); 
            }else if (selectHorquillas.value === 'Tipo2' || selectHorquillas.value === 'Tipo3' || selectHorquillas.value === 'Tipo4') {
                iconHorquillas.textContent = '✔️';
                iconHorquillas.style.color = 'green';
            }else {
                iconHorquillas.textContent = '❌';
                iconHorquillas.style.color = 'red';
                selectHorquillas.classList.add('select-vacio');
            }
        }

        selectsHorquillas.forEach(selectHorquillas => {
            selectHorquillas.addEventListener('change', () => actualizarEstadoHorquillas(selectHorquillas));
        });

        // Botón para tomar foto (cámara)
        btnTomarFotoHorquillas.addEventListener('click', () => {
            fileInputHorquillas.removeAttribute('multiple');
            fileInputHorquillas.setAttribute('capture', 'environment');
            fileInputHorquillas.click();
        });

        // Botón para cargar imágenes (galería/archivos)
        btnCargarImagenHorquillas.addEventListener('click', () => {
            fileInputHorquillas.setAttribute('multiple', 'true');
            fileInputHorquillas.removeAttribute('capture');
            fileInputHorquillas.click();
        });

        botonHorquillas.addEventListener('click', () => {
            let valido = true;

            selectsHorquillas.forEach(selectHorquillas => {
                if (!selectHorquillas.value) {
                    actualizarEstadoHorquillas(selectHorquillas);
                    valido = false;
                }
            });

            if (fileInputHorquillas.files.length === 0) {
                alert('Debe subir al menos una imagen del diagnóstico.');
                valido = false;
            }

            if (!valido) return;

            // ✅ Guardar valores en campos ocultos del formulario principal
            document.getElementById('hiddenLongitudH').value = document.getElementById('LongitudH').value;
            document.getElementById('hiddenCriterio_90').value = document.getElementById('Criterio_90').value;
            document.getElementById('hiddenCriterio_91').value = document.getElementById('Criterio_91').value;
            document.getElementById('hiddenCriterio_92').value = document.getElementById('Criterio_92').value;
            document.getElementById('hiddenCriterio_93').value = document.getElementById('Criterio_93').value;
            document.getElementById('hiddenCriterio_94').value = document.getElementById('Criterio_94').value;

             // ✅ También puedes mostrar los archivos seleccionados
            let archivos = [];
            for (let i = 0; i < fileInputHorquillas.files.length; i++) {
                archivos.push(fileInputHorquillas.files[i].name);
            }
            console.log("Imágenes cargadas:", archivos);

            // ✅ Cambiar color del card
            const card = document.getElementById('btnHorquillasCard').querySelector('div');
            card.classList.remove('bg-light');
            card.classList.add('bg-validado');

            // ❌ Cerrar modal actual
            const ModalHorquillas = bootstrap.Modal.getInstance(document.getElementById('ModalHorquillas'));
            ModalHorquillas.hide();

            // ✅ Abrir siguiente modal
            const modalAgregar = new bootstrap.Modal(document.getElementById('AgregarDiagnostico'));
            modalAgregar.show();
        });
    });
</script>

<!-- Modal Ruedas -->
<div class="modal fade" id="ModalRuedas" tabindex="-1" aria-labelledby="ModalRuedasLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #000020;">
                <h5 class="modal-title text-white" id="ModalRuedasLabel">Diagnóstico: Ruedas</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="Criterio_95" class="form-label">Degaste de ruedas de tracción</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_95" name="Criterio_95" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_95"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_96" class="form-label">Degaste ruedas de caster</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_96" name="Criterio_96" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_96"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_97" class="form-label">Degaste ruedas de cargas</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_97" name="Criterio_97" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_97"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_98" class="form-label">Estado de rines de tracción</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_98" name="Criterio_98" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_98"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_99" class="form-label">Estado de rines de caster</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_99" name="Criterio_99" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_99"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_100" class="form-label">Estado de rines de carga</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_100" name="Criterio_100" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_100"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_101" class="form-label">Balancines</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_101" name="Criterio_101" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_101"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_102" class="form-label">Tornillos</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_102" name="Criterio_102" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_102"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_103" class="form-label">Bujes</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_103" name="Criterio_103" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_103"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Subir Imágenes del Diagnóstico</label>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-primary" id="btnTomarFotoRuedas">Tomar Foto</button>
                        <button type="button" class="btn btn-outline-secondary" id="btnCargarImagenRuedas">Cargar Imágenes</button>
                    </div>
                </div>
                <button id="btnGuardarRuedas" type="button" class="btn text-white" style="background-color: #000020;">Guardar Diagnóstico</button>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const selectsRuedas= document.querySelectorAll('#ModalRuedas select.form-select');
        const fileInputRuedas = document.getElementById('imagenesDiagnosticoRuedas');
        const botonRuedas = document.getElementById('btnGuardarRuedas');
        const btnTomarFotoRuedas = document.getElementById('btnTomarFotoRuedas');
        const btnCargarImagenRuedas = document.getElementById('btnCargarImagenRuedas');

        function actualizarEstadoRuedas(selectRuedas) {
            const iconRuedas = document.getElementById(`icon-${selectRuedas.id}`);
            selectRuedas.classList.remove('select-Conforme', 'select-Nivelacion', 'select-Ajuste', 'select-Lubricacion', 'select-malo', 'select-vacio', 'select-Aplica');

            if (selectRuedas.value === 'Conforme') {
                iconRuedas.textContent = '✔️';
                iconRuedas.style.color = 'green';
                selectRuedas.classList.add('select-Conforme');
            } else if (selectRuedas.value === 'Reparación') {
                iconRuedas.textContent = '⚠️';
                iconRuedas.style.color = 'red';
                selectRuedas.classList.add('select-malo');
            }else if (selectRuedas.value === 'Nivelacion') {
                iconRuedas.textContent = '📏';
                iconRuedas.style.color = 'yellow';
                selectRuedas.classList.add('select-Nivelacion');
            }else if (selectRuedas.value === 'Ajuste') {
                iconRuedas.textContent = '⚙️';
                iconRuedas.style.color = 'Orange';
                selectRuedas.classList.add('select-Ajuste'); 
            }else if (selectRuedas.value === 'Lubricación') {
                iconRuedas.textContent = '🛢️';
                iconRuedas.style.color = 'Blue';
                selectRuedas.classList.add('select-Lubricacion');
            }else if (selectRuedas.value === 'NoAplica') {
                iconRuedas.textContent = '➖';
                iconRuedas.style.color = 'Gray';
                selectRuedas.classList.add('select-Aplica'); 
            }else {
                iconRuedas.textContent = '❌';
                iconRuedas.style.color = 'red';
                selectRuedas.classList.add('select-vacio');
            }
        }

        selectsRuedas.forEach(selectRuedas => {
            selectRuedas.addEventListener('change', () => actualizarEstadoRuedas(selectRuedas));
        });

        // Botón para tomar foto (cámara)
        btnTomarFotoRuedas.addEventListener('click', () => {
            fileInputRuedas.removeAttribute('multiple');
            fileInputRuedas.setAttribute('capture', 'environment');
            fileInputRuedas.click();
        });

        // Botón para cargar imágenes (galería/archivos)
        btnCargarImagenRuedas.addEventListener('click', () => {
            fileInputRuedas.setAttribute('multiple', 'true');
            fileInputRuedas.removeAttribute('capture');
            fileInputRuedas.click();
        });

        botonRuedas.addEventListener('click', () => {
            let valido = true;

            selectsRuedas.forEach(selectRuedas => {
                if (!selectRuedas.value) {
                    actualizarEstadoRuedas(selectRuedas);
                    valido = false;
                }
            });

            if (fileInputRuedas.files.length === 0) {
                alert('Debe subir al menos una imagen del diagnóstico.');
                valido = false;
            }

            if (!valido) return;

            // ✅ Guardar valores en campos ocultos del formulario principal
            document.getElementById('hiddenCriterio_95').value = document.getElementById('Criterio_95').value;
            document.getElementById('hiddenCriterio_96').value = document.getElementById('Criterio_96').value;
            document.getElementById('hiddenCriterio_97').value = document.getElementById('Criterio_97').value;
            document.getElementById('hiddenCriterio_98').value = document.getElementById('Criterio_98').value;
            document.getElementById('hiddenCriterio_99').value = document.getElementById('Criterio_99').value;
            document.getElementById('hiddenCriterio_100').value = document.getElementById('Criterio_100').value;
            document.getElementById('hiddenCriterio_101').value = document.getElementById('Criterio_101').value;
            document.getElementById('hiddenCriterio_102').value = document.getElementById('Criterio_102').value;
            document.getElementById('hiddenCriterio_103').value = document.getElementById('Criterio_103').value;

            // ✅ También puedes mostrar los archivos seleccionados
            let archivos = [];
            for (let i = 0; i < fileInputRuedas.files.length; i++) {
                archivos.push(fileInputRuedas.files[i].name);
            }
            console.log("Imágenes cargadas:", archivos);

            // ✅ Cambiar color del card
            const card = document.getElementById('btnRuedasCard').querySelector('div');
            card.classList.remove('bg-light');
            card.classList.add('bg-validado');

            // ❌ Cerrar modal actual
            const ModalRuedas = bootstrap.Modal.getInstance(document.getElementById('ModalRuedas'));
            ModalRuedas.hide();

            // ✅ Abrir siguiente modal
            const modalAgregar = new bootstrap.Modal(document.getElementById('AgregarDiagnostico'));
            modalAgregar.show();
        });
    });
</script>

<!-- Modal Chasis -->
<div class="modal fade" id="ModalChasis" tabindex="-1" aria-labelledby="ModalChasisLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #000020;">
                <h5 class="modal-title text-white" id="ModalChasisLabel">Diagnóstico: Chasis</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="Criterio_104" class="form-label">Ajustes de conjunto</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_104" name="Criterio_104" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_104"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_105" class="form-label">Chequear soportes</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_105" name="Criterio_105" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_105"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_106" class="form-label">Tornilleria</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_106" name="Criterio_106" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_106"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_107" class="form-label">Estado pintura</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_107" name="Criterio_107" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_107"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Subir Imágenes del Diagnóstico</label>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-primary" id="btnTomarFotoChasis">Tomar Foto</button>
                        <button type="button" class="btn btn-outline-secondary" id="btnCargarImagenChasis">Cargar Imágenes</button>
                    </div>
                </div>
                <button id="btnGuardarChasis" type="button" class="btn text-white" style="background-color: #000020;">Guardar Diagnóstico</button>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const selectsChasis = document.querySelectorAll('#ModalChasis select.form-select');
        const fileInputChasis = document.getElementById('imagenesDiagnosticoChasis');
        const botonChasis = document.getElementById('btnGuardarChasis');
        const btnTomarFotoChasis = document.getElementById('btnTomarFotoChasis');
        const btnCargarImagenChasis = document.getElementById('btnCargarImagenChasis');

        function actualizarEstadoChasis(selectChasis) {
            const iconChasis = document.getElementById(`icon-${selectChasis.id}`);
            selectChasis.classList.remove('select-Conforme', 'select-Nivelacion', 'select-Ajuste', 'select-Lubricacion', 'select-malo', 'select-vacio', 'select-Aplica');

            if (selectChasis.value === 'Conforme') {
                iconChasis.textContent = '✔️';
                iconChasis.style.color = 'green';
                selectChasis.classList.add('select-Conforme');
            } else if (selectChasis.value === 'Reparación') {
                iconChasis.textContent = '⚠️';
                iconChasis.style.color = 'red';
                selectChasis.classList.add('select-malo');
            }else if (selectChasis.value === 'Nivelacion') {
                iconChasis.textContent = '📏';
                iconChasis.style.color = 'yellow';
                selectChasis.classList.add('select-Nivelacion');
            }else if (selectChasis.value === 'Ajuste') {
                iconChasis.textContent = '⚙️';
                iconChasis.style.color = 'Orange';
                selectChasis.classList.add('select-Ajuste'); 
            }else if (selectChasis.value === 'Lubricación') {
                iconChasis.textContent = '🛢️';
                iconChasis.style.color = 'Blue';
                selectChasis.classList.add('select-Lubricacion');
            }else if (selectChasis.value === 'NoAplica') {
                iconChasis.textContent = '➖';
                iconChasis.style.color = 'Gray';
                selectChasis.classList.add('select-Aplica'); 
            }else {
                iconChasis.textContent = '❌';
                iconChasis.style.color = 'red';
                selectChasis.classList.add('select-vacio');
            }
        }

        selectsChasis.forEach(selectChasis => {
            selectChasis.addEventListener('change', () => actualizarEstadoChasis(selectChasis));
        });

        // Botón para tomar foto (cámara)
        btnTomarFotoChasis.addEventListener('click', () => {
            fileInputChasis.removeAttribute('multiple');
            fileInputChasis.setAttribute('capture', 'environment');
            fileInputChasis.click();
        });

        // Botón para cargar imágenes (galería/archivos)
        btnCargarImagenChasis.addEventListener('click', () => {
            fileInputChasis.setAttribute('multiple', 'true');
            fileInputChasis.removeAttribute('capture');
            fileInputChasis.click();
        });

        botonChasis.addEventListener('click', () => {
            let valido = true;

            selectsChasis.forEach(selectChasis => {
                if (!selectChasis.value) {
                    actualizarEstadoChasis(selectChasis);
                    valido = false;
                }
            });

            if (fileInputChasis.files.length === 0) {
                alert('Debe subir al menos una imagen del diagnóstico.');
                valido = false;
            }

            if (!valido) return;

            // ✅ Guardar valores en campos ocultos del formulario principal
            document.getElementById('hiddenCriterio_104').value = document.getElementById('Criterio_104').value;
            document.getElementById('hiddenCriterio_105').value = document.getElementById('Criterio_105').value;
            document.getElementById('hiddenCriterio_106').value = document.getElementById('Criterio_106').value;
            document.getElementById('hiddenCriterio_107').value = document.getElementById('Criterio_107').value;


            // ✅ También puedes mostrar los archivos seleccionados
            let archivos = [];
            for (let i = 0; i < fileInputChasis.files.length; i++) {
                archivos.push(fileInputChasis.files[i].name);
            }
            console.log("Imágenes cargadas:", archivos);

            // ✅ Cambiar color del card
            const card = document.getElementById('btnChasisCard').querySelector('div');
            card.classList.remove('bg-light');
            card.classList.add('bg-validado');

            // ❌ Cerrar modal actual
            const ModalChasis = bootstrap.Modal.getInstance(document.getElementById('ModalChasis'));
            ModalChasis.hide();

            // ✅ Abrir siguiente modal
            const modalAgregar = new bootstrap.Modal(document.getElementById('AgregarDiagnostico'));
            modalAgregar.show();
        });
    });
</script>

<!-- Modal Luces y Alarmas -->
<div class="modal fade" id="ModalLuces" tabindex="-1" aria-labelledby="ModalLucesLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #000020;">
                <h5 class="modal-title text-white" id="ModalLucesLabel">Diagnóstico: Luces y alarmas </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="Criterio_108" class="form-label">Luces frontales</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_108" name="Criterio_108" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_108"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_109" class="form-label">Luz estroboscopia</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_109" name="Criterio_109" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_109"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_110" class="form-label">Blue light</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_110" name="Criterio_110" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_110"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_111" class="form-label">Pito bocina</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_111" name="Criterio_111" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_111"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_112" class="form-label">Alarma reversa</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_112" name="Criterio_112" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_112"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Subir Imágenes del Diagnóstico</label>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-primary" id="btnTomarFotoLuces">Tomar Foto</button>
                        <button type="button" class="btn btn-outline-secondary" id="btnCargarImagenLuces">Cargar Imágenes</button>
                    </div>
                </div>
                <button id="btnGuardarLuces" type="button" class="btn text-white" style="background-color: #000020;">Guardar Diagnóstico</button>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const selectsLuces = document.querySelectorAll('#ModalLuces select.form-select');
        const fileInputLuces = document.getElementById('imagenesDiagnosticoLuces');
        const botonLuces = document.getElementById('btnGuardarLuces');
        const btnTomarFotoLuces = document.getElementById('btnTomarFotoLuces');
        const btnCargarImagenLuces = document.getElementById('btnCargarImagenLuces');

        function actualizarEstadoLuces(selectLuces) {
            const iconLuces = document.getElementById(`icon-${selectLuces.id}`);
            selectLuces.classList.remove('select-Conforme', 'select-Nivelacion', 'select-Ajuste', 'select-Lubricacion', 'select-malo', 'select-vacio', 'select-Aplica');

            if (selectLuces.value === 'Conforme') {
                iconLuces.textContent = '✔️';
                iconLuces.style.color = 'green';
                selectLuces.classList.add('select-Conforme');
            } else if (selectLuces.value === 'Reparación') {
                iconLuces.textContent = '⚠️';
                iconLuces.style.color = 'red';
                selectLuces.classList.add('select-malo');
            }else if (selectLuces.value === 'Nivelacion') {
                iconLuces.textContent = '📏';
                iconLuces.style.color = 'yellow';
                selectLuces.classList.add('select-Nivelacion');
            }else if (selectLuces.value === 'Ajuste') {
                iconLuces.textContent = '⚙️';
                iconLuces.style.color = 'Orange';
                selectLuces.classList.add('select-Ajuste'); 
            }else if (selectLuces.value === 'Lubricación') {
                iconLuces.textContent = '🛢️';
                iconLuces.style.color = 'Blue';
                selectLuces.classList.add('select-Lubricacion');
            }else if (selectLuces.value === 'NoAplica') {
                iconLuces.textContent = '➖';
                iconLuces.style.color = 'Gray';
                selectLuces.classList.add('select-Aplica'); 
            }else {
                iconLuces.textContent = '❌';
                iconLuces.style.color = 'red';
                selectLuces.classList.add('select-vacio');
            }
        }

        selectsLuces.forEach(selectLuces => {
            selectLuces.addEventListener('change', () => actualizarEstadoLuces(selectLuces));
        });

        // Botón para tomar foto (cámara)
        btnTomarFotoLuces.addEventListener('click', () => {
            fileInputLuces.removeAttribute('multiple');
            fileInputLuces.setAttribute('capture', 'environment');
            fileInputLuces.click();
        });

        // Botón para cargar imágenes (galería/archivos)
        btnCargarImagenLuces.addEventListener('click', () => {
            fileInputLuces.setAttribute('multiple', 'true');
            fileInputLuces.removeAttribute('capture');
            fileInputLuces.click();
        });

        botonLuces.addEventListener('click', () => {
            let valido = true;

            selectsLuces.forEach(selectLuces => {
                if (!selectLuces.value) {
                    actualizarEstadoLuces(selectLuces);
                    valido = false;
                }
            });

            if (fileInputLuces.files.length === 0) {
                alert('Debe subir al menos una imagen del diagnóstico.');
                valido = false;
            }

            if (!valido) return;

            // ✅ Guardar valores en campos ocultos del formulario principal
            document.getElementById('hiddenCriterio_108').value = document.getElementById('Criterio_108').value;
            document.getElementById('hiddenCriterio_109').value = document.getElementById('Criterio_109').value;
            document.getElementById('hiddenCriterio_110').value = document.getElementById('Criterio_110').value;
            document.getElementById('hiddenCriterio_111').value = document.getElementById('Criterio_111').value;
            document.getElementById('hiddenCriterio_112').value = document.getElementById('Criterio_112').value;

            // ✅ También puedes mostrar los archivos seleccionados
            let archivos = [];
            for (let i = 0; i < fileInputLuces.files.length; i++) {
                archivos.push(fileInputLuces.files[i].name);
            }
            console.log("Imágenes cargadas:", archivos);

            // ✅ Cambiar color del card
            const card = document.getElementById('btnLucesCard').querySelector('div');
            card.classList.remove('bg-light');
            card.classList.add('bg-validado');

            // ❌ Cerrar modal actual
            const ModalLuces = bootstrap.Modal.getInstance(document.getElementById('ModalLuces'));
            ModalLuces.hide();

            // ✅ Abrir siguiente modal
            const modalAgregar = new bootstrap.Modal(document.getElementById('AgregarDiagnostico'));
            modalAgregar.show();
        });
    });
</script>

<!-- Modal Lubricacion-->
<div class="modal fade" id="ModalLubricacion" tabindex="-1" aria-labelledby="ModalLubricacionLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #000020;">
                <h5 class="modal-title text-white" id="ModalLubricacionLabel">Diagnóstico: Lubricacíon</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="Criterio_113" class="form-label">Engrase de caster</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_113" name="Criterio_113" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_113"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_114" class="form-label">Engrase de tande</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_114" name="Criterio_114" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_114"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_115" class="form-label">Engrase de pantógrafo</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_115" name="Criterio_115" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_115"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_116" class="form-label">Lubricacíon cadenas y secciones mastil</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_116" name="Criterio_116" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_116"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Subir Imágenes del Diagnóstico</label>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-primary" id="btnTomarFotoLubricacion">Tomar Foto</button>
                        <button type="button" class="btn btn-outline-secondary" id="btnCargarImagenLubricacion">Cargar Imágenes</button>
                    </div>
                </div>
                <button id="btnGuardarLubricacion" type="button" class="btn text-white" style="background-color: #000020;">Guardar Diagnóstico</button>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const selectsLubricacion = document.querySelectorAll('#ModalLubricacion select.form-select');
        const fileInputLubricacion = document.getElementById('imagenesDiagnosticoLubricacion');
        const botonLubricacion = document.getElementById('btnGuardarLubricacion');
        const btnTomarFotoLubricacion = document.getElementById('btnTomarFotoLubricacion');
        const btnCargarImagenLubricacion = document.getElementById('btnCargarImagenLubricacion');

        function actualizarEstadoLubricacion(selectLubricacion) {
            const iconLubricacion = document.getElementById(`icon-${selectLubricacion.id}`);
            selectLubricacion.classList.remove('select-Conforme', 'select-Nivelacion', 'select-Ajuste', 'select-Lubricacion', 'select-malo', 'select-vacio', 'select-Aplica');

            if (selectLubricacion.value === 'Conforme') {
                iconLubricacion.textContent = '✔️';
                iconLubricacion.style.color = 'green';
                selectLubricacion.classList.add('select-Conforme');
            } else if (selectLubricacion.value === 'Reparación') {
                iconLubricacion.textContent = '⚠️';
                iconLubricacion.style.color = 'red';
                selectLubricacion.classList.add('select-malo');
            }else if (selectLubricacion.value === 'Nivelacion') {
                iconLubricacion.textContent = '📏';
                iconLubricacion.style.color = 'yellow';
                selectLubricacion.classList.add('select-Nivelacion');
            }else if (selectLubricacion.value === 'Ajuste') {
                iconLubricacion.textContent = '⚙️';
                iconLubricacion.style.color = 'Orange';
                selectLubricacion.classList.add('select-Ajuste'); 
            }else if (selectLubricacion.value === 'Lubricación') {
                iconLubricacion.textContent = '🛢️';
                iconLubricacion.style.color = 'Blue';
                selectLubricacion.classList.add('select-Lubricacion');
            }else if (selectLubricacion.value === 'NoAplica') {
                iconLubricacion.textContent = '➖';
                iconLubricacion.style.color = 'Gray';
                selectLubricacion.classList.add('select-Aplica'); 
            }else {
                iconLubricacion.textContent = '❌';
                iconLubricacion.style.color = 'red';
                selectLubricacion.classList.add('select-vacio');
            }
        }
        
        selectsLubricacion.forEach(selectLubricacion => {
            selectLubricacion.addEventListener('change', () => actualizarEstadoLubricacion(selectLubricacion));
        });

        // Botón para tomar foto (cámara)
        btnTomarFotoLubricacion.addEventListener('click', () => {
            fileInputLubricacion.removeAttribute('multiple');
            fileInputLubricacion.setAttribute('capture', 'environment');
            fileInputLubricacion.click();
        });

        // Botón para cargar imágenes (galería/archivos)
        btnCargarImagenLubricacion.addEventListener('click', () => {
            fileInputLubricacion.setAttribute('multiple', 'true');
            fileInputLubricacion.removeAttribute('capture');
            fileInputLubricacion.click();
        });

        botonLubricacion.addEventListener('click', () => {
            let valido = true;

            selectsLubricacion.forEach(selectLubricacion => {
                if (!selectLubricacion.value) {
                    actualizarEstadoLubricacion(selectLubricacion);
                    valido = false;
                }
            });

            if (fileInputLubricacion.files.length === 0) {
                alert('Debe subir al menos una imagen del diagnóstico.');
                valido = false;
            }

            if (!valido) return;

            // ✅ Guardar valores en campos ocultos del formulario principal
            document.getElementById('hiddenCriterio_113').value = document.getElementById('Criterio_113').value;
            document.getElementById('hiddenCriterio_114').value = document.getElementById('Criterio_114').value;
            document.getElementById('hiddenCriterio_115').value = document.getElementById('Criterio_115').value;
            document.getElementById('hiddenCriterio_116').value = document.getElementById('Criterio_116').value;

            // ✅ También puedes mostrar los archivos seleccionados
            let archivos = [];
            for (let i = 0; i < fileInputLubricacion.files.length; i++) {
                archivos.push(fileInputLubricacion.files[i].name);
            }
            console.log("Imágenes cargadas:", archivos);

            // ✅ Cambiar color del card
            const card = document.getElementById('btnLubricacionCard').querySelector('div');
            card.classList.remove('bg-light');
            card.classList.add('bg-validado');

            // ❌ Cerrar modal actual
            const ModalLubricacion = bootstrap.Modal.getInstance(document.getElementById('ModalLubricacion'));
            ModalLubricacion.hide();

            // ✅ Abrir siguiente modal
            const modalAgregar = new bootstrap.Modal(document.getElementById('AgregarDiagnostico'));
            modalAgregar.show();
        });
    });
</script>

<!-- Modal Cargador-->
<div class="modal fade" id="ModalCargador" tabindex="-1" aria-labelledby="ModalCargadorLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #000020;">
                <h5 class="modal-title text-white" id="ModalCargadorLabel">Diagnóstico: Cargador</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="NumeroCargador" class="form-label">N° Cargador</label>
                    <input type="text" class="form-control" name="NumeroCargador" id="NumeroCargador" placeholder="# de cargador" requerid>
                </div>
                <div class="mb-3">
                    <label for="Criterio_117" class="form-label">Inspeccion visual</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_117" name="Criterio_117" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_117"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_118" class="form-label">Cables de potencia</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_118" name="Criterio_118" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_118"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_119" class="form-label">Conector Anderson</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_119" name="Criterio_119" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_119"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_120" class="form-label">Voltaje</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_120" name="Criterio_120" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_120"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_121" class="form-label">Amperaje</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_121" name="Criterio_121" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_121"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Subir Imágenes del Diagnóstico</label>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-primary" id="btnTomarFotoCargador">Tomar Foto</button>
                        <button type="button" class="btn btn-outline-secondary" id="btnCargarImagenCargador">Cargar Imágenes</button>
                    </div>
                </div>
                <button id="btnGuardarCargador" type="button" class="btn text-white" style="background-color: #000020;">Guardar Diagnóstico</button>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const selectsCargador = document.querySelectorAll('#ModalCargador select.form-select');
        const fileInputCargador = document.getElementById('imagenesDiagnosticoCargador');
        const botonCargador = document.getElementById('btnGuardarCargador');
        const btnTomarFotoCargador = document.getElementById('btnTomarFotoCargador');
        const btnCargarImagenCargador = document.getElementById('btnCargarImagenCargador');

        function actualizarEstadoCargador(selectCargador) {
            const iconCargador = document.getElementById(`icon-${selectCargador.id}`);
            selectCargador.classList.remove('select-Conforme', 'select-Nivelacion', 'select-Ajuste', 'select-Lubricacion', 'select-malo', 'select-vacio', 'select-Aplica');

            if (selectCargador.value === 'Conforme') {
                iconCargador.textContent = '✔️';
                iconCargador.style.color = 'green';
                selectCargador.classList.add('select-Conforme');
            } else if (selectCargador.value === 'Reparación') {
                iconCargador.textContent = '⚠️';
                iconCargador.style.color = 'red';
                selectCargador.classList.add('select-malo');
            }else if (selectCargador.value === 'Nivelacion') {
                iconCargador.textContent = '📏';
                iconCargador.style.color = 'yellow';
                selectCargador.classList.add('select-Nivelacion');
            }else if (selectCargador.value === 'Ajuste') {
                iconCargador.textContent = '⚙️';
                iconCargador.style.color = 'Orange';
                selectCargador.classList.add('select-Ajuste'); 
            }else if (selectCargador.value === 'Lubricación') {
                iconCargador.textContent = '🛢️';
                iconCargador.style.color = 'Blue';
                selectCargador.classList.add('select-Lubricacion');
            }else if (selectCargador.value === 'NoAplica') {
                iconCargador.textContent = '➖';
                iconCargador.style.color = 'Gray';
                selectCargador.classList.add('select-Aplica'); 
            }else {
                iconCargador.textContent = '❌';
                iconCargador.style.color = 'red';
                selectCargador.classList.add('select-vacio');
            }
        }

        selectsCargador.forEach(selectCargador => {
            selectCargador.addEventListener('change', () => actualizarEstadoCargador(selectCargador));
        });

        // Botón para tomar foto (cámara)
        btnTomarFotoCargador.addEventListener('click', () => {
            fileInputCargador.removeAttribute('multiple');
            fileInputCargador.setAttribute('capture', 'environment');
            fileInputCargador.click();
        });

        // Botón para cargar imágenes (galería/archivos)
        btnCargarImagenCargador.addEventListener('click', () => {
            fileInputCargador.setAttribute('multiple', 'true');
            fileInputCargador.removeAttribute('capture');
            fileInputCargador.click();
        });

        botonCargador.addEventListener('click', () => {
            let valido = true;

            selectsCargador.forEach(selectCargador => {
                if (!selectCargador.value) {
                    actualizarEstadoCargador(selectCargador);
                    valido = false;
                }
            });

            if (fileInputCargador.files.length === 0) {
                alert('Debe subir al menos una imagen del diagnóstico.');
                valido = false;
            }

            // ✅ Validar que el número de controlador no esté vacío
            const numeroCargador = document.getElementById('NumeroCargador').value.trim();
            if (numeroCargador === "") {
                alert("Debe ingresar el número de controlador.");
                document.getElementById('NumeroCargador').focus();
                valido = false;
            }

            if (!valido) return;

            // ✅ Guardar valores en campos ocultos del formulario principal
            document.getElementById('hiddenNumeroCargador').value = numeroCargador;
            document.getElementById('hiddenCriterio_117').value = document.getElementById('Criterio_117').value;
            document.getElementById('hiddenCriterio_118').value = document.getElementById('Criterio_118').value;
            document.getElementById('hiddenCriterio_119').value = document.getElementById('Criterio_119').value;
            document.getElementById('hiddenCriterio_120').value = document.getElementById('Criterio_120').value;
            document.getElementById('hiddenCriterio_121').value = document.getElementById('Criterio_121').value;

            // ✅ También puedes mostrar los archivos seleccionados
            let archivos = [];
            for (let i = 0; i < fileInputCargador.files.length; i++) {
                archivos.push(fileInputCargador.files[i].name);
            }
            console.log("Imágenes cargadas:", archivos);

            // ✅ Cambiar color del card
            const card = document.getElementById('btnCargadorCard').querySelector('div');
            card.classList.remove('bg-light');
            card.classList.add('bg-validado');

            // ❌ Cerrar modal actual
            const ModalCargador = bootstrap.Modal.getInstance(document.getElementById('ModalCargador'));
            ModalCargador.hide();

            // ✅ Abrir siguiente modal
            const modalAgregar = new bootstrap.Modal(document.getElementById('AgregarDiagnostico'));
            modalAgregar.show();
        });
    });
</script>

<!-- Modal Revision de equipo-->
<div class="modal fade" id="ModalRevision" tabindex="-1" aria-labelledby="ModalRevisionLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #000020;">
                <h5 class="modal-title text-white" id="ModalRevisionLabel">Diagnóstico: Revision de Equipo</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="Criterio_131" class="form-label">Limpieza del equipo</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_131" name="Criterio_131" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_131"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_132" class="form-label">Horómetro</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_132" name="Criterio_132" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_132"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_133" class="form-label">Etiquetas de seguridad</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_133" name="Criterio_133" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_133"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_134" class="form-label">Limpieza área de trabajo</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_134" name="Criterio_134" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_134"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_135" class="form-label">Manual de operaciones</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_135" name="Criterio_135" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_135"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_136" class="form-label">Tapas</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_136" name="Criterio_136" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_136"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_137" class="form-label">Silla</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_137" name="Criterio_137" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_137"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_138" class="form-label">Cinturon de seguridad</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_138" name="Criterio_138" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_138"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Criterio_139" class="form-label">Extintor</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select" id="Criterio_139" name="Criterio_139" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="Conforme">Conforme</option>
                            <option value="Nivelacion">Nivelación</option>
                            <option value="Ajuste">Ajuste</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Lubricación">Lubricación y engrase</option>
                            <option value="NoAplica">No aplica</option>
                        </select>
                        <span class="estado-icon" id="icon-Criterio_139"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Subir Imágenes del Diagnóstico</label>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-primary" id="btnTomarFotoRevision">Tomar Foto</button>
                        <button type="button" class="btn btn-outline-secondary" id="btnCargarImagenRevision">Cargar Imágenes</button>
                    </div>
                </div>
                <button id="btnGuardarRevision" type="button" class="btn text-white" style="background-color: #000020;">Guardar Diagnóstico</button>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const selectsRevision = document.querySelectorAll('#ModalRevision select.form-select');
        const fileInputRevision = document.getElementById('imagenesDiagnosticoRevision');
        const botonRevision = document.getElementById('btnGuardarRevision');
        const btnTomarFotoRevision = document.getElementById('btnTomarFotoRevision');
        const btnCargarImagenRevision = document.getElementById('btnCargarImagenRevision');

        function actualizarEstadoRevision(selectRevision) {
            const iconRevision = document.getElementById(`icon-${selectRevision.id}`);
            selectRevision.classList.remove('select-Conforme', 'select-Nivelacion', 'select-Ajuste', 'select-Lubricacion', 'select-malo', 'select-vacio', 'select-Aplica');

            if (selectRevision.value === 'Conforme') {
                iconRevision.textContent = '✔️';
                iconRevision.style.color = 'green';
                selectRevision.classList.add('select-Conforme');
            } else if (selectRevision.value === 'Reparación') {
                iconRevision.textContent = '⚠️';
                iconRevision.style.color = 'red';
                selectRevision.classList.add('select-malo');
            }else if (selectRevision.value === 'Nivelacion') {
                iconRevision.textContent = '📏';
                iconRevision.style.color = 'yellow';
                selectRevision.classList.add('select-Nivelacion');
            }else if (selectRevision.value === 'Ajuste') {
                iconRevision.textContent = '⚙️';
                iconRevision.style.color = 'Orange';
                selectRevision.classList.add('select-Ajuste'); 
            }else if (selectRevision.value === 'Lubricación') {
                iconRevision.textContent = '🛢️';
                iconRevision.style.color = 'Blue';
                selectRevision.classList.add('select-Lubricacion');
            }else if (selectRevision.value === 'NoAplica') {
                iconRevision.textContent = '➖';
                iconRevision.style.color = 'Gray';
                selectRevision.classList.add('select-Aplica'); 
            }else {
                iconRevision.textContent = '❌';
                iconRevision.style.color = 'red';
                selectRevision.classList.add('select-vacio');
            }
        }

        selectsRevision.forEach(selectRevision => {
            selectRevision.addEventListener('change', () => actualizarEstadoRevision(selectRevision));
        });

        // Botón para tomar foto (cámara)
        btnTomarFotoRevision.addEventListener('click', () => {
            fileInputRevision.removeAttribute('multiple');
            fileInputRevision.setAttribute('capture', 'environment');
            fileInputRevision.click();
        });

        // Botón para cargar imágenes (galería/archivos)
        btnCargarImagenRevision.addEventListener('click', () => {
            fileInputRevision.setAttribute('multiple', 'true');
            fileInputRevision.removeAttribute('capture');
            fileInputRevision.click();
        });

        botonRevision.addEventListener('click', () => {
            let valido = true;

            selectsRevision.forEach(selectRevision => {
                if (!selectRevision.value) {
                    actualizarEstadoRevision(selectRevision);
                    valido = false;
                }
            });

            if (fileInputRevision.files.length === 0) {
                alert('Debe subir al menos una imagen del diagnóstico.');
                valido = false;
            }

            if (!valido) return;

            // ✅ Guardar valores en campos ocultos del formulario principal
            document.getElementById('hiddenCriterio_131').value = document.getElementById('Criterio_131').value;
            document.getElementById('hiddenCriterio_132').value = document.getElementById('Criterio_132').value;
            document.getElementById('hiddenCriterio_133').value = document.getElementById('Criterio_133').value;
            document.getElementById('hiddenCriterio_134').value = document.getElementById('Criterio_134').value;
            document.getElementById('hiddenCriterio_135').value = document.getElementById('Criterio_135').value;
            document.getElementById('hiddenCriterio_136').value = document.getElementById('Criterio_136').value;
            document.getElementById('hiddenCriterio_137').value = document.getElementById('Criterio_137').value;
            document.getElementById('hiddenCriterio_138').value = document.getElementById('Criterio_138').value;
            document.getElementById('hiddenCriterio_139').value = document.getElementById('Criterio_139').value;

            // ✅ También puedes mostrar los archivos seleccionados
            let archivos = [];
            for (let i = 0; i < fileInputRevision.files.length; i++) {
                archivos.push(fileInputRevision.files[i].name);
            }
            console.log("Imágenes cargadas:", archivos);

            // ✅ Cambiar color del card
            const card = document.getElementById('btnRevisionCard').querySelector('div');
            card.classList.remove('bg-light');
            card.classList.add('bg-validado');

            // ❌ Cerrar modal actual
            const ModalRevision = bootstrap.Modal.getInstance(document.getElementById('ModalRevision'));
            ModalRevision.hide();

            // ✅ Abrir siguiente modal
            const modalAgregar = new bootstrap.Modal(document.getElementById('AgregarDiagnostico'));
            modalAgregar.show();
        });
    });
</script>

<!-- Modal Observaciónes de mantenimiento-->
<div class="modal fade" id="ModalObservaciones" tabindex="-1" aria-labelledby="ModalObservacionesLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #000020;">
                <h5 class="modal-title text-white" id="ModalObservacionesLabel">Observaciones de Mantenimiento</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="diagnostico" class="form-label">Diagnóstico</label>
                    <textarea class="form-control" id="diagnostico" name="diagnostico" rows="5" placeholder="Pendientes proximo mantenimiento..."></textarea>
                </div>

                <button id="btnGuardarObservaciones" type="button" class="btn text-white" style="background-color: #000020;">Guardar Diagnóstico</button>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const botonObservaciones = document.getElementById('btnGuardarObservaciones');
        botonObservaciones.addEventListener('click', () => {
            let valido = true;

            // ✅ Guardar valores en campos ocultos del formulario principal
            const diagnosticoTextarea = document.getElementById('diagnostico');
            const diagnosticoHidden = document.getElementById('hiddendiagnostico');
            let valorDiagnostico = diagnosticoTextarea.value.trim();

            // ✅ Si está vacío, guardar como NULL
            if (valorDiagnostico === "") {
                diagnosticoHidden.value = "NULL";
            } else {
                diagnosticoHidden.value = valorDiagnostico;
            }

            // ✅ Mostrar en consola los datos guardados
            console.log("Datos guardados en hidden:");
            console.log("diagnostico:", document.getElementById('hiddendiagnostico').value);


            // ✅ Cambiar color del card
            const card = document.getElementById('btnObservacionesCard').querySelector('div');
            card.classList.remove('bg-light');
            card.classList.add('bg-validado');

            // ❌ Cerrar modal actual
            const ModalObservaciones = bootstrap.Modal.getInstance(document.getElementById('ModalObservaciones'));
            ModalObservaciones.hide();

            // ✅ Abrir siguiente modal
            const modalAgregar = new bootstrap.Modal(document.getElementById('AgregarDiagnostico'));
            modalAgregar.show();
        });

    });
</script>

<!-- Modal Insumos de mantenimiento-->
<div class="modal fade" id="ModalInsumos" tabindex="-1" aria-labelledby="ModalInsumosLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #000020;">
                <h5 class="modal-title text-white" id="ModalInsumosLabel">Insumos Mantenimiento</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Agua para batería</label>
                    <input type="hidden" id="codigoCriterio_122" value="P-000119">
                    <div class="d-flex gap-2 align-items-center">
                        <div class="input-group">
                            <input type="text" class="form-control" name="Criterio_122" id="Criterio_122" placeholder="Cantidad">
                            <select class="form-select w-auto" id="tipoMedidaCriterio_122" name="tipoMedidaCriterio_122" style="max-width: 100px;">
                                <option value="Und">Und</option>
                                <option value="Gal">Gal</option>
                                <option value="1/4">1/4</option>
                                <option value="1/2">1/2</option>
                                <option value="3/4">3/4</option>
                            </select>
                        </div>
                        <!-- Switch No Aplica -->
                        <div class="form-check form-switch">
                            <input class="form-check-input no-aplica" type="checkbox" id="noAplicaCriterio_122" data-target="Criterio_122,tipoMedidaCriterio_122">
                            <label class="form-check-label" for="noAplicaCriterio_122">No Aplica</label>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Grasa Wurth</label>
                    <input type="hidden" id="codigoCriterio_123" value="P-000054">
                    <div class="d-flex gap-2 align-items-center">
                        <div class="input-group">
                            <input type="text" class="form-control" name="Criterio_123" id="Criterio_123" placeholder="Cantidad">
                            <select class="form-select w-auto" id="tipoMedidaCriterio_123" name="tipoMedidaCriterio_123" style="max-width: 100px;">
                                <option value="Und">Und</option>
                                <option value="Gal">Gal</option>
                                <option value="1/4">1/4</option>
                                <option value="1/2">1/2</option>
                                <option value="3/4">3/4</option>
                            </select>
                        </div>
                        <!-- Switch No Aplica -->
                        <div class="form-check form-switch">
                            <input class="form-check-input no-aplica" type="checkbox" id="noAplicaCriterio_123" data-target="Criterio_123,tipoMedidaCriterio_123">
                            <label class="form-check-label" for="noAplicaCriterio_123">No Aplica</label>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Aceite Hidráulico</label>
                    <input type="hidden" id="codigoCriterio_124" value="P-000120">
                    <div class="d-flex gap-2 align-items-center">
                        <div class="input-group">
                            <input type="text" class="form-control" name="Criterio_124" id="Criterio_124" placeholder="Cantidad">
                            <select class="form-select w-auto" id="tipoMedidaCriterio_124" name="tipoMedidaCriterio_124" style="max-width: 100px;">
                                <option value="Und">Und</option>
                                <option value="Gal">Gal</option>
                                <option value="1/4">1/4</option>
                                <option value="1/2">1/2</option>
                                <option value="3/4">3/4</option>
                            </select>
                        </div>
                        <!-- Switch No Aplica -->
                        <div class="form-check form-switch">
                            <input class="form-check-input no-aplica" type="checkbox" id="noAplicaCriterio_124" data-target="Criterio_124,tipoMedidaCriterio_124">
                            <label class="form-check-label" for="noAplicaCriterio_124">No Aplica</label>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Valvulina</label>
                    <input type="hidden" id="codigoCriterio_125" value="P-000210">
                    <div class="d-flex gap-2 align-items-center">
                        <div class="input-group">
                            <input type="text" class="form-control" name="Criterio_125" id="Criterio_125" placeholder="Cantidad">
                            <select class="form-select w-auto" id="tipoMedidaCriterio_125" name="tipoMedidaCriterio_125" style="max-width: 100px;">
                                <option value="Und">Und</option>
                                <option value="Gal">Gal</option>
                                <option value="1/4">1/4</option>
                                <option value="1/2">1/2</option>
                                <option value="3/4">3/4</option>
                            </select>
                        </div>
                        <!-- Switch No Aplica -->
                        <div class="form-check form-switch">
                            <input class="form-check-input no-aplica" type="checkbox" id="noAplicaCriterio_125" data-target="Criterio_125,tipoMedidaCriterio_125">
                            <label class="form-check-label" for="noAplicaCriterio_125">No Aplica</label>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Gasolina</label>
                    <input type="hidden" id="codigoCriterio_126" value="P-000207">
                    <div class="d-flex gap-2 align-items-center">
                        <div class="input-group">
                            <input type="text" class="form-control" name="Criterio_126" id="Criterio_126" placeholder="Cantidad">
                            <select class="form-select w-auto" id="tipoMedidaCriterio_126" name="tipoMedidaCriterio_126" style="max-width: 100px;">
                                <option value="Und">Und</option>
                                <option value="Gal">Gal</option>
                                <option value="1/4">1/4</option>
                                <option value="1/2">1/2</option>
                                <option value="3/4">3/4</option>
                            </select>
                        </div>
                        <!-- Switch No Aplica -->
                        <div class="form-check form-switch">
                            <input class="form-check-input no-aplica" type="checkbox" id="noAplicaCriterio_126" data-target="Criterio_126,tipoMedidaCriterio_126">
                            <label class="form-check-label" for="noAplicaCriterio_126">No Aplica</label>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Lubricante Wurth</label>
                    <input type="hidden" id="codigoCriterio_127" value="P-000053">
                    <div class="d-flex gap-2 align-items-center">
                        <div class="input-group">
                            <input type="text" class="form-control" name="Criterio_127" id="Criterio_127" placeholder="Cantidad">
                            <select class="form-select w-auto" id="tipoMedidaCriterio_127" name="tipoMedidaCriterio_127" style="max-width: 100px;">
                                <option value="Und">Und</option>
                                <option value="Gal">Gal</option>
                                <option value="1/4">1/4</option>
                                <option value="1/2">1/2</option>
                                <option value="3/4">3/4</option>
                            </select>
                        </div>
                        <!-- Switch No Aplica -->
                        <div class="form-check form-switch">
                            <input class="form-check-input no-aplica" type="checkbox" id="noAplicaCriterio_127" data-target="Criterio_127,tipoMedidaCriterio_127">
                            <label class="form-check-label" for="noAplicaCriterio_127">No Aplica</label>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Limpiador Wurth</label>
                    <input type="hidden" id="codigoCriterio_128" value="P-000905">
                    <div class="d-flex gap-2 align-items-center">
                        <div class="input-group">
                            <input type="text" class="form-control" name="Criterio_128" id="Criterio_128" placeholder="Cantidad">
                            <select class="form-select w-auto" id="tipoMedidaCriterio_128" name="tipoMedidaCriterio_128" style="max-width: 100px;">
                                <option value="Und">Und</option>
                                <option value="Gal">Gal</option>
                                <option value="1/4">1/4</option>
                                <option value="1/2">1/2</option>
                                <option value="3/4">3/4</option>
                            </select>
                        </div>
                        <!-- Switch No Aplica -->
                        <div class="form-check form-switch">
                            <input class="form-check-input no-aplica" type="checkbox" id="noAplicaCriterio_128" data-target="Criterio_128,tipoMedidaCriterio_128">
                            <label class="form-check-label" for="noAplicaCriterio_128">No Aplica</label>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Limpiador Eletrico</label>
                    <input type="hidden" id="codigoCriterio_129" value="P-000994">
                    <div class="d-flex gap-2 align-items-center">
                        <div class="input-group">
                            <input type="text" class="form-control" name="Criterio_129" id="Criterio_129" placeholder="Cantidad">
                            <select class="form-select w-auto" id="tipoMedidaCriterio_129" name="tipoMedidaCriterio_129" style="max-width: 100px;">
                                <option value="Und">Und</option>
                                <option value="Gal">Gal</option>
                                <option value="1/4">1/4</option>
                                <option value="1/2">1/2</option>
                                <option value="3/4">3/4</option>
                            </select>
                        </div>
                        <!-- Switch No Aplica -->
                        <div class="form-check form-switch">
                            <input class="form-check-input no-aplica" type="checkbox" id="noAplicaCriterio_129" data-target="Criterio_129,tipoMedidaCriterio_129">
                            <label class="form-check-label" for="noAplicaCriterio_129">No Aplica</label>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Liquido de Frenos</label>
                    <input type="hidden" id="codigoCriterio_130" value="P-000021">
                    <div class="d-flex gap-2 align-items-center">
                        <div class="input-group">
                            <input type="text" class="form-control" name="Criterio_130" id="Criterio_130" placeholder="Cantidad">
                            <select class="form-select w-auto" id="tipoMedidaCriterio_130" name="tipoMedidaCriterio_130" style="max-width: 100px;">
                                <option value="Und">Und</option>
                                <option value="Gal">Gal</option>
                                <option value="1/4">1/4</option>
                                <option value="1/2">1/2</option>
                                <option value="3/4">3/4</option>
                            </select>
                        </div>
                        <!-- Switch No Aplica -->
                        <div class="form-check form-switch">
                            <input class="form-check-input no-aplica" type="checkbox" id="noAplicaCriterio_130" data-target="Criterio_130,tipoMedidaCriterio_130">
                            <label class="form-check-label" for="noAplicaCriterio_130">No Aplica</label>
                        </div>
                    </div>
                </div>
                <button id="btnGuardarInsumos" type="button" class="btn text-white" style="background-color: #000020;">Guardar Diagnóstico</button>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const selectsInsumos = document.querySelectorAll('#ModalInsumos select.form-select');
        const botonInsumos = document.getElementById('btnGuardarInsumos');

        botonInsumos.addEventListener('click', () => {
            let valido = true;

            // Lista de criterios a procesar
            const criterios = [122,123,124,125,126,127,128,129,130];

            criterios.forEach(num => {
                const codigo = document.getElementById(`codigoCriterio_${num}`).value;
                const cantidad = document.getElementById(`Criterio_${num}`);
                const tipoMedida = document.getElementById(`tipoMedidaCriterio_${num}`);
                const noAplica = document.getElementById(`noAplicaCriterio_${num}`);

                let valorfinal;

                if (noAplica.checked) {
                    valorfinal = "null|null|null";
                } else {
                    const cantidadVal = cantidad.value.trim() || "null";
                    const tipoMedidaVal = tipoMedida.value.trim() || "null";
                    valorfinal = `${codigo}|${cantidadVal}|${tipoMedidaVal}`;
                }

                // Guardar en hidden del modal principal
                const hidden = document.getElementById(`hiddenCriterio_${num}`);
                if (hidden) {
                    hidden.value = valorfinal;
                    // Mostrar en consola el valor guardado
                    console.log(`Criterio ${num}:`, hidden.value);
                }

            });

            // ✅ Cambiar color del card
            const card = document.getElementById('btnInsumosCard').querySelector('div');
            card.classList.remove('bg-light');
            card.classList.add('bg-validado');

            // ❌ Cerrar modal actual
            const ModalInsumos = bootstrap.Modal.getInstance(document.getElementById('ModalInsumos'));
            ModalInsumos.hide();

            // ✅ Abrir siguiente modal
            const modalAgregar = new bootstrap.Modal(document.getElementById('AgregarDiagnostico'));
            modalAgregar.show();
        });

    });
    document.querySelectorAll('.no-aplica').forEach(toggle => {
        toggle.addEventListener('change', function() {
            const targetIds = this.getAttribute('data-target').split(',');
            targetIds.forEach(id => {
                const element = document.getElementById(id);
                if (element) {
                    element.disabled = this.checked; // ✅ si está marcado, deshabilita
                    if (this.checked) {
                        element.value = ""; // opcional: limpiar valor
                    }
                }
            });
        });
    });
</script>

<script>
    function cargarMontacargas() {
        const ID_Centro = document.getElementById('ID_Centro1').value;
        console.log('ID_Centro enviado:', ID_Centro);
        if (!ID_Centro) return;
        // Realizamos la solicitud AJAX para obtener los montacargas
        $.get(`TraerMontacargas?ID_Centro=${ID_Centro}`, function(data) {
            try {
                const Montacargas = Array.isArray(data) ? data : JSON.parse(data);

                console.log('Montacargas recibido:', Montacargas);

                // Limpiamos el select
                $('#ID_Montacargas').empty().append('<option value="" disabled selected>Seleccione un montacargas</option>');

                if (Montacargas.length > 0) {
                    Montacargas.forEach(montacarga => {
                        $('#ID_Montacargas').append(
                            `<option value="${montacarga.ID}"data-modelo="${montacarga.Modelo}" data-voltaje="${montacarga.Voltaje}" data-horometro="${montacarga.Horometro}" data-longitudh="${montacarga.Horquillas}">
                            ${montacarga.Numero} - ${montacarga.Serie}</option>`
                        );
                    });
                }
            } catch (error) {
                console.error('Error al procesar los datos de montacargas:', error);
            }
        }).fail(function(xhr, status, error) {
            console.error('Error en la solicitud AJAX:', error);
        });

        // Realizamos la solicitud AJAX para obtener los operarios
        $.get(`TraerOperarios?ID_Centro=${ID_Centro}`, function(data) {
            try {
                const Operarios = Array.isArray(data) ? data : JSON.parse(data);

                console.log('Operarios recibido:', Operarios);

                $('#ID_Operario').empty().append('<option value="" disabled selected>Seleccione un operario</option>');

                if (Operarios.length > 0) {
                    Operarios.forEach(operario => {
                        $('#ID_Operario').append(
                            `<option value="${operario.ID}">${operario.NombreCompleto}</option>`
                        );
                    });
                }
            } catch (error) {
                console.error('Error al procesar los datos de operarios:', error);
            }
        }).fail(function(xhr, status, error) {
            console.error('Error en la solicitud AJAX:', error);
        });

        //Realizamos la solicitud AJAX para obtener las areas o secciones de trabajo
         $.get(`TraerAreas?ID_Centro=${ID_Centro}`, function(data) {
            try {
                const Areas = Array.isArray(data) ? data : JSON.parse(data);
                console.log('Áreas recibidas:', Areas);

                $('#ID_Area').empty().append('<option value="" disabled selected>Seleccione un área</option>');

                if (Areas.length > 0) {
                    Areas.forEach(area => {
                        $('#ID_Area').append(
                            `<option value="${area.ID}">${area.Nombre}</option>`
                        );
                    });
                }
            } catch (error) {
                console.error('Error al procesar los datos de áreas:', error);
            }
        }).fail(function(xhr, status, error) {
            console.error('Error en la solicitud AJAX:', error);
        });
    };
    
    document.addEventListener("DOMContentLoaded", function () {
        // Función para crear un helper de Bootstrap Modal compatible con varias versiones
        const getModalInstance = (el) => {
            if (!el) return null;
            return (bootstrap.Modal.getOrCreateInstance)
                ? bootstrap.Modal.getOrCreateInstance(el)
                : (bootstrap.Modal.getInstance(el) || new bootstrap.Modal(el));
        };


        // PARTE 1: FORMULARIO
        const formIngreso = document.getElementById("documentFormIngreso"); // <-- asegúrate en HTML
        if (formIngreso) {
            formIngreso.addEventListener("submit", function (e) {
                e.preventDefault(); 

                // Obtenemos valores seleccionados (usamos ? para evitar crash)
                const centroSelect = document.getElementById("ID_Centro1");
                const montacargasSelect = document.getElementById("ID_Montacargas");
                const operarioSelect = document.getElementById("ID_Operario");
                const areaSelect = document.getElementById("ID_Area");

                const centroTexto = centroSelect?.options[centroSelect.selectedIndex]?.text || "";
                const montacargasTexto = montacargasSelect?.options[montacargasSelect.selectedIndex]?.text || "";
                const operarioTexto = operarioSelect?.options[operarioSelect.selectedIndex]?.text || "";
                const areaTexto = areaSelect?.options[areaSelect.selectedIndex]?.text || "";

                // Evitar error si no hay valor seleccionado
                const selectedOption = montacargasSelect?.options[montacargasSelect.selectedIndex];

                const numeroMontacargas = selectedOption?.text.split(" - ")[0] || "";
                const numeroSerie = selectedOption?.text.split(" - ")[1] || "";
                const numeroModelo = selectedOption?.dataset.modelo || "";
                const voltaje = selectedOption?.dataset.voltaje || "";
                const horometro = selectedOption?.dataset.horometro || "";
                const longitudh = selectedOption?.dataset.longitudh || "";

                // ✅ Aquí llenamos los campos hidden con los IDs seleccionados
                document.getElementById("hiddenIDMontacargas").value = montacargasSelect?.value || "";
                document.getElementById("hiddenIDArea").value = areaSelect?.value || "";
                document.getElementById("hiddenIDOperario").value = operarioSelect?.value || "";
                document.getElementById("hiddenIDCentro").value = centroSelect?.value || "";

                Swal.fire({
                    title: 'Mantenimiento creado!',
                    text: `El Número de Montacargas es: ${numeroMontacargas || "N/A"}`,
                    icon: 'success',
                    showCancelButton: true,
                    confirmButtonText: 'Continuar',
                    cancelButtonText: 'Cancelar',
                    allowOutsideClick: false,
                    allowEscapeKey: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Rellenar campos en el modal agregarMantenimiento (verificamos existencia)
                        const setVal = (id, v) => { const el = document.getElementById(id); if (el) el.value = v; };
                        setVal("numeroMontacargas", numeroMontacargas);
                        setVal("numeroSerie", numeroSerie);
                        setVal("numeroModelo", numeroModelo); 
                        setVal("Voltaje", voltaje);           
                        setVal("Horometro", horometro);           
                        setVal("nombreCentro", centroTexto);
                        setVal("nombreOperario", operarioTexto);
                        setVal("nombreSección", areaTexto);
                        setVal("LongitudH", longitudh);

                        // Cerrar modal de ingreso y, cuando termine de cerrarse, abrir modal mantenimiento
                        const modalIngresoEl = document.getElementById('NumerDocumentoModal');
                        const modalIngresoInst = getModalInstance(modalIngresoEl);
                        const modalMantEl = document.getElementById('agregarMantenimiento');
                        const modalMantInst = getModalInstance(modalMantEl);

                        if (modalIngresoInst && modalMantInst && modalIngresoEl) {
                            const handler = function () {
                                modalIngresoEl.removeEventListener('hidden.bs.modal', handler);
                                // abrir mantenimiento
                                modalMantInst.show();
                            };
                            modalIngresoEl.addEventListener('hidden.bs.modal', handler);
                            modalIngresoInst.hide();
                        } else {
                            // Fallback: si no existe instancia, abrir mant directamente
                            if (modalMantInst) modalMantInst.show();
                        }
                    }
                });
            });
        } else {
            console.warn("documentFormIngreso no encontrado. Verifica id del form en tu HTML.");
        }

        // PARTE 2: BOTONES data-open-modal
        const modalPrincipalEl = document.getElementById('agregarMantenimiento');
        const modalPrincipalInst = getModalInstance(modalPrincipalEl);

        document.querySelectorAll('[data-open-modal]').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const selector = this.getAttribute('data-open-modal');
                const targetEl = document.querySelector(selector);
                if (!targetEl) return console.warn("target modal no encontrado para selector:", selector);

                const targetInst = getModalInstance(targetEl);
                if (!targetInst) return;

                // Si el modal principal está abierto (clase .show), lo cerramos y esperamos
                const principalIsOpen = modalPrincipalEl && modalPrincipalEl.classList.contains('show');

                if (principalIsOpen && modalPrincipalInst) {
                    const onHidden = function () {
                        modalPrincipalEl.removeEventListener('hidden.bs.modal', onHidden);
                        targetInst.show();

                        // Cuando cierre el secundario, reabrir el principal (una sola vez)
                        const onSecHidden = function () {
                            targetEl.removeEventListener('hidden.bs.modal', onSecHidden);
                            // reabrir principal si existe
                            const mp = getModalInstance(modalPrincipalEl);
                            if (mp) mp.show();
                        };
                        targetEl.addEventListener('hidden.bs.modal', onSecHidden);
                    };
                    modalPrincipalEl.addEventListener('hidden.bs.modal', onHidden);
                    modalPrincipalInst.hide();
                } else {
                    // Si principal no está abierto, abrimos directamente el secundario
                    targetInst.show();
                }
            });
        });
    });
    
    let Tecnicos = [];
    $(document).ready(function() {
        $("#btnAgregarTecnico").click(function() {
            $("#Documento").val("");
            $("#modalAgregarTecnico").modal("show");
        }); 
        
        $("#guardarTecnico").click(function(){
            agregarTecnico();
        });

        $(document).on("click", ".btnQuitarTecnico", function(){
            const id = $(this).siblings("input[type=hidden]").val();
            Tecnicos = Tecnicos.filter(t => t.ID != id);
            $(this).closest(".input-group").remove();
            console.log("Técnicos actuales:", Tecnicos);
        });
    });

    function agregarTecnico() {
        const identificacion = $("#Documento").val().trim();

        if (!identificacion) {
            alert("Por favor, ingrese un número de identificación");
            return;
        }

        $.get(`BuscarTecnico?Documento=${identificacion}`, function(data) {
            try {
                const tecnico = typeof data === "object" ? data : JSON.parse(data);

                if (tecnico && tecnico.ID && tecnico.NombreCompleto) {
                    if (Tecnicos.some(t => t.ID === tecnico.ID)) {
                        alert("Este técnico ya fue agregado");
                        return;
                    }

                    // Agregar al array
                    Tecnicos.push({
                        ID: tecnico.ID,
                        NombreCompleto: tecnico.NombreCompleto
                    });

                    // Mostrar en pantalla
                    $("#listaTecnicos").append(`
                        <div class="input-group mb-2">
                            <input type="hidden" name="tecnicoId[]" value="${tecnico.ID}">
                            <input type="text" class="form-control" value="${tecnico.NombreCompleto}" readonly>
                            <button class="btn btn-danger btnQuitarTecnico" type="button">&times;</button>
                        </div>
                    `);

                    console.log("Técnicos actuales:", Tecnicos);

                    $("#modalAgregarTecnico").modal("hide");
                } else {
                    alert("Técnico no encontrado");
                }
            } catch (error) {
                console.error("Error procesando técnico:", error);
            }
        }).fail(function(xhr, status, error) {
            console.error("Error en AJAX:", error);
        });
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

    //Validacion de formulario antes de enviar
    document.addEventListener("DOMContentLoaded", function () {
        const documentFormMantenimiento = document.getElementById("documentFormMantenimiento");
        if (documentFormMantenimiento) {
            documentFormMantenimiento.addEventListener("submit", function (e) {
                e.preventDefault(); 

                // Verificar si se seleccionó un supervisor
                var select = document.getElementById("Autoriza");
                if (select.value === "") {
                    alert("Por favor, selecciona un supervisor.");
                    return;
                }

                // Validar Datos del Formulario de los modales
                const hiddenInputs = documentFormMantenimiento.querySelectorAll("input[type=hidden]");
                let incompletos = [];

                hiddenInputs.forEach(input => {
                    if (!input.value || input.value.trim() === "") {
                        incompletos.push(input.name);
                    }
                });

                if (incompletos.length > 0) {
                    console.warn("⚠️ Faltan datos en:", incompletos);

                    Swal.fire({
                        icon: "warning",
                        title: "Información incompleta",
                        text: "Debes diligenciar todos los campos antes de continuar.",
                        confirmButtonText: "Ok"
                    });
                } else {
                    console.log("✅ Todos los hidden tienen valores, se envía el formulario.");
                    // 👉 Enviar formulario al controlador
                    documentFormMantenimiento.submit();
                }

            });
        } else {
            console.warn("documentFormMantenimiento no encontrado. Verifica id del form en tu HTML.");
        }
    });
</script>
<?php require "App/Views/Templates/Layouts/Footer.php"; ?>
