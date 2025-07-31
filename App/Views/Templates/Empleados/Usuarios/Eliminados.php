<?php 
    include_once "App/Controllers/UsuarioController.php";
    require_once "App/Views/Templates/Layouts/Header.php"; 
    $Empleados = new UsuarioController;
    $Listas = $Empleados->LeerE();
    $NoUsuario = $Empleados->ContarUsuariosInactivos();
?>
<!-- Sale & Revenue Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-6 col-xl-3">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
            <img width="50" height="50" src="https://img.icons8.com/ios/50/000020/groups.png" alt="groups"/>
                <div class="ms-3">
                    <p class="mb-2" style="color: #000020;">Usuarios</p>
                    <h6 class="mb-0" style="color: #000020;"><?= $NoUsuario['NoUsuarios'] ?></h6>
                </div>
            </div>
        </div>
        <a class="col-sm-6 col-xl-3" href="../Empleados/Registrar">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <img width="50" height="50" src="https://img.icons8.com/ios/50/000020/new--v1.png" alt="new--v1"/>
                <div class="ms-3">
                    <p class="mb-2" style="color: #000020;">Registrar usuario</p>
                </div>
            </div>
        </a>
        <a class="col-sm-6 col-xl-3" href="../Empleados/Inicio">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
            <img width="50" height="50" src="https://img.icons8.com/windows/50/000020/key.png" alt="key"/>
                <div class="ms-3">
                    <p class="mb-2" style="color: #000020;">Trabajadores</p>
                </div>
            </div>
        </a>
        <a class="col-sm-6 col-xl-3" href="../Empleados/InformeI">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <img width="50" height="50" src="https://img.icons8.com/ios/50/000020/document-1.png" alt="document-1"/>
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
            <h6 class="mb-0">Ultimos registros</h6>
            <a href="ExcelI">Descargar Excel</a>
        </div>
        <div class="table-responsive">
            <table class="table text-start align-middle table-bordered table-hover mb-0" id="myTable">
                <thead>
                    <tr class="text-dark">
                        <th scope="col">ID</th>
                        <th scope="col">Cédula</th>
                        <th scope="col">Nombre Completo</th>
                        <th scope="col">Centro de trabajo</th>                                    
                        <th scope="col">Cargo</th>
                        <th scope="col">Acciónes</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if ($Listas) {
                            foreach ($Listas as $Lista) {
                    ?>
                        <tr data-id="<?= htmlspecialchars($Lista['ID']) ?>">
                            <td><?= htmlspecialchars($Lista['ID']) ?></td>
                            <td><?= htmlspecialchars($Lista['Documento']) ?></td>
                            <td><?= htmlspecialchars($Lista['NombreCompleto']) ?></td>
                            <td><?= htmlspecialchars($Lista['Nombre_Centro']) ?></td>
                            <td><?= htmlspecialchars($Lista['Nombre_Cargo']) ?></td>
                            <td><a class="btn btn-sm btn-primary" href="Ver?ID=<?= htmlspecialchars($Lista['ID']) ?>">Ver</a></td>
                            <td><a class="btn btn-sm btn-warning" onclick="confirmarEditar(<?= htmlspecialchars($Lista['ID']) ?>)">Editar</a></td>
                            <td><a class="btn btn-sm btn-success" onclick="confirmarDesactivacion(<?= htmlspecialchars($Lista['ID']) ?>)">Activar</a></td>
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

<!-- WebSocket Script -->
<script>
    function confirmarDesactivacion(ID_Usuario) {
        Swal.fire({
            title: "<strong>Confirmación de Activar</strong>",
            icon: "warning",
            html: `¿Estás seguro de que quieres activar este usuario?`,
            showCloseButton: true,
            showCancelButton: true,
            focusConfirm: false,
            confirmButtonText: `<i class="fa fa-thumbs-up"></i> Si, Activar`,
            confirmButtonAriaLabel: "Activar usuario",
            cancelButtonText: `<i class="fa fa-thumbs-down"></i> No, Cancelar`,
            cancelButtonAriaLabel: "Cancelar"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'Activar?ID=' + ID_Usuario;
            }
        });
    }

    function confirmarEditar(ID_Usuario) {
        Swal.fire({
            title: "<strong>Confirmación de Editar</strong>",
            icon: "warning",
            html: `¿Estás seguro de que quieres Editar este usuario?`,
            showCloseButton: true,
            showCancelButton: true,
            focusConfirm: false,
            confirmButtonText: `<i class="fa fa-thumbs-up"></i> Si, Editar`,
            confirmButtonAriaLabel: "Editar usuario",
            cancelButtonText: `<i class="fa fa-thumbs-down"></i> No, Cancelar`,
            cancelButtonAriaLabel: "Cancelar"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'Editar?ID=' + ID_Usuario;
            }
        });
    }
</script>
