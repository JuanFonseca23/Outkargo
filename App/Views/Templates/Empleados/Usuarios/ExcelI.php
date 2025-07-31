<?php
// Definir el nombre del archivo y la cabecera
$filename = "Exportacion_Usuarios_Inactivos" . date('Ymd') . ".xls";

// Establecer las cabeceras necesarias para la descarga
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Pragma: no-cache");
header("Expires: 0");

include_once "App/Controllers/UsuarioController.php";
$Empleados = new UsuarioController;
$Listas = $Empleados->LeerE();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OUTKARGO</title>
</head>

<body>
    <table class="table text-start align-middle table-bordered table-hover mb-0" id="myTable">
        <thead>
            <tr class="text-dark">
                <th scope="col">ID</th>
                <th scope="col">Tipo de Documento</th>
                <th scope="col">Cédula</th>
                <th scope="col">Centro de trabajo</th>
                <th scope="col">Cargo</th>
                <th scope="col">Primer Nombre</th>
                <th scope="col">Segundo Nombre</th>
                <th scope="col">Primer Apellido</th>
                <th scope="col">Segundo Apellido</th>
                <th scope="col">Nombre Completo</th>
                <th scope="col">Fecha de Nacimiento</th>
                <th scope="col">Telefono</th>
                <th scope="col">Correo</th>
                <th scope="col">Foto</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($Listas) {
                foreach ($Listas as $Lista) {
            ?>
                    <tr>
                        <td><?= htmlspecialchars($Lista['ID']) ?></td>
                        <td>
                            <?php
                                if ($Lista['Tipo_Documento'] == 1) {
                                    echo "C.C";
                                }
                                if ($Lista['Tipo_Documento'] == 2) {
                                    echo "T.I";
                                }
                                if ($Lista['Tipo_Documento'] == 3) {
                                    echo "Otro";
                                }
                            ?>
                        </td>
                        <td><?= htmlspecialchars($Lista['Documento']) ?></td>
                        <td><?= htmlspecialchars($Lista['Nombre_Centro']) ?></td>
                        <td><?= htmlspecialchars($Lista['Nombre_Cargo']) ?></td>
                        <td><?= htmlspecialchars($Lista['Nombre1']) ?></td>
                        <td><?= htmlspecialchars($Lista['Nombre2']) ?></td>
                        <td><?= htmlspecialchars($Lista['Apellido1']) ?></td>
                        <td><?= htmlspecialchars($Lista['Apellido2']) ?></td>
                        <td><?= htmlspecialchars($Lista['NombreCompleto']) ?></td>
                        <td><?= htmlspecialchars($Lista['Fecha_Nacimiento']) ?></td>
                        <td><?= htmlspecialchars($Lista['Telefono']) ?></td>
                        <td><?= htmlspecialchars($Lista['Correo']) ?></td>
                        <td><?= htmlspecialchars($Lista['Foto']) ?></td>
                    </tr>
            <?php
                }
            }
            ?>
        </tbody>
    </table>
</body>

</html>