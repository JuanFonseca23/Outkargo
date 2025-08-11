<?php
include_once "App/Controllers/DotacionController.php";
include_once "App/Controllers/UsuarioController.php";
require_once "App/Views/Templates/Layouts/Header.php";
if (empty($_SESSION['ID'])) {
    header("location:../IniciarSesion");
    exit;
}
$DotacionController = new DotacionController;
$Empleados = new UsuarioController;
$ID_Centro = $_SESSION['NoCentro'];
$Listas = $DotacionController->LeerHuella($ID_Centro);

?>

<!-- Sale & Revenue Start -->
<div class="container-fluid pt-4 px-4">
    <div class="bg-light text-center rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <a href="#">Descargar Excel</a>
        </div>
        <div class="table-responsive">
            <table class="table text-start align-middle table-bordered table-hover mb-0" id="myTable">
                <thead>
                    <tr class="text-dark">
                        <th scope="col" class="text-center">Código</th>
                        <th scope="col" class="text-center">Persona</th>
                        <th scope="col">Hora</th>
                        <th scope="col" class="text-center">Fecha</th>
                        <th scope="col" class="text-center">Tipo</th> 
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($Listas as $item): ?>
                        <tr>
                            <td class="text-center"><?= $item['ID'] ?></td>
                            <td class="text-center"><?php
                                $Persona = $Empleados->LeerHuella($item['ID_Persona']);
                                echo $Persona['NombreCompleto'];
                            ?></td>
                            <td><?= $item['Hora'] ?></td>
                            <td class="text-center"><?= $item['Fecha'] ?></td>
                            <td class="text-center"><?= $item['Tipo'] ?></td> 
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require "App/Views/Templates/Layouts/Footer.php"; ?>
