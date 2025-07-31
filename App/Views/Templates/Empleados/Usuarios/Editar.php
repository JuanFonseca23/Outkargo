<?php
include_once "App/Controllers/UsuarioController.php";
require_once "App/Views/Templates/Layouts/Header.php";
include_once "App/Controllers/CentroDeTrabajoController.php";

$CentrosDeTrabajo = new CentroDeTrabajoController;
$UsuarioController = new UsuarioController();
$ListaCentrosDeTrabajo = $CentrosDeTrabajo->TraerCentrosDeTrabajo();
$ListasCargos = $CentrosDeTrabajo->ListaCargos();
$ListaMunicipios = json_decode($UsuarioController->ListaMunicipios(), true);

if (!isset($_GET['ID'])) {
    echo "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
            Swal.fire({
                title: 'Error',
                text: 'ID no proporcionado',
                icon: 'error',
                timer: 2000,
                timerProgressBar: true,
                didClose: () => {
                    window.location.href = 'Inicio';
                }
            });
        </script>";
    exit();
}

$ID = $_GET['ID'];
$UsuarioRegistrado = $UsuarioController->Mostrar($ID);

if ($UsuarioRegistrado) {
?>
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-12 col-xl-12">
                <div class="bg-light rounded h-100 p-4">
                    <?php
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $ID_Centro = $_POST['ID_Centro'];
                        $ID_Cargo = $_POST['ID_Cargo'];
                        $Tipo_Documento = $_POST['Tipo_Documento'];
                        $Documento = $_POST['Documento'];
                        $Nombre1 = $_POST['Nombre1'];
                        $Nombre2 = $_POST['Nombre2'];
                        $Apellido1 = $_POST['Apellido1'];
                        $Apellido2 = $_POST['Apellido2'];
                        $Foto = $_FILES['Foto'];
                        $Telefono = $_POST['Telefono'];
                        $Correo = $_POST['Correo'];
                        $Direccion = $_POST['Direccion'];
                        $No_Carnet = $_POST['noCarnet'];
                        $Fecha_Nacimiento = $_POST['Fecha_Nacimiento'];
                        $RH = $_POST['RH'];
                        $EPS = $_POST['EPS'];
                        $AFP = $_POST['AFP'];
                        $ARL = $_POST['ARL'];
                        $Sexo = $_POST['Sexo'];
                        $Municipio = $_POST['Departamento'];
                        $Area = $_POST['Area'];
                        $Turno = $_POST['Turno'];

                        $UsuarioController->Editar($_SESSION['ID'], $_SESSION['Nombre1'], $ID, $ID_Centro, $ID_Cargo, $Tipo_Documento, $Documento, $Nombre1, $Nombre2, $Apellido1, $Apellido2, $Foto, $Telefono, $Correo, $Direccion, $No_Carnet, $Fecha_Nacimiento, $RH, $EPS, $AFP, $ARL, $Sexo, $Municipio, $Area, $Turno);
                    }
                    ?>

                    <form method="post" enctype="multipart/form-data">
                        <h6 class="mb-4">Editar Usuario</h6>

                        <!-- Centro de trabajo -->
                        <div class="form-floating mb-3">
                            <select class="form-select" name="ID_Centro" required>
                                <option disabled selected>Centros de trabajo</option>
                                <?php foreach ($ListaCentrosDeTrabajo as $ListaCentroDeTrabajo): ?>
                                    <option value="<?= $ListaCentroDeTrabajo['ID'] ?>" <?= $ListaCentroDeTrabajo['ID'] == $UsuarioRegistrado['ID_Centro'] ? 'selected' : '' ?>>
                                        <?= $ListaCentroDeTrabajo['Nombre'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <label>Seleccione el centro de trabajo</label>
                        </div>

                        <!-- Cargo -->
                        <div class="form-floating mb-3">
                            <select class="form-select" name="ID_Cargo" required>
                                <option disabled selected>Cargos</option>
                                <?php foreach ($ListasCargos as $ListaCargos): ?>
                                    <option value="<?= $ListaCargos['ID'] ?>" <?= $ListaCargos['ID'] == $UsuarioRegistrado['ID_Cargo'] ? 'selected' : '' ?>>
                                        <?= $ListaCargos['Cargo'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <label>Seleccione el cargo</label>
                        </div>

                        <!-- Tipo de Documento -->
                        <div class="form-floating mb-3">
                            <select class="form-select" name="Tipo_Documento" required>
                                <option disabled selected>Tipo Documento</option>
                                <option value="1" <?= $UsuarioRegistrado['Tipo_Documento'] == 1 ? 'selected' : '' ?>>Cédula</option>
                                <option value="2" <?= $UsuarioRegistrado['Tipo_Documento'] == 2 ? 'selected' : '' ?>>Tarjeta de identidad</option>
                                <option value="3" <?= $UsuarioRegistrado['Tipo_Documento'] == 3 ? 'selected' : '' ?>>Otro</option>
                            </select>
                            <label>Seleccione el tipo de documento</label>
                        </div>

                        <!-- Número de Documento -->
                        <div class="form-floating mb-3">
                            <input type="number" name="Documento" class="form-control" value="<?= $UsuarioRegistrado['Documento'] ?>" required>
                            <label>No. Documento</label>
                        </div>

                        <!-- Nombres y Apellidos -->
                        <div class="form-floating mb-3">
                            <input type="text" name="Nombre1" class="form-control" value="<?= $UsuarioRegistrado['Nombre1'] ?>" required>
                            <label>Primer Nombre</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" name="Nombre2" class="form-control" value="<?= $UsuarioRegistrado['Nombre2'] ?>">
                            <label>Segundo Nombre</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" name="Apellido1" class="form-control" value="<?= $UsuarioRegistrado['Apellido1'] ?>" required>
                            <label>Primer Apellido</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" name="Apellido2" class="form-control" value="<?= $UsuarioRegistrado['Apellido2'] ?>">
                            <label>Segundo Apellido</label>
                        </div>

                        <!-- Foto -->
                        <div class="mb-3">
                            <img id="preview" src="../App/Views/Upload/Img/Perfil/<?= $UsuarioRegistrado['Foto'] ?>" alt="Previsualización de la imagen" style="max-width: 150px;" />
                        </div>

                        <div class="mb-3">
                            <label for="formFile" class="form-label">Seleccione la foto de perfil</label>
                            <input class="form-control" type="file" name="Foto" id="formFile" accept="image/png, image/jpeg">
                        </div>

                        <!-- Teléfono y Correo -->
                        <div class="form-floating mb-3">
                            <input type="number" name="Telefono" class="form-control" value="<?= $UsuarioRegistrado['Telefono'] ?>" required>
                            <label>Teléfono</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="email" name="Correo" class="form-control" value="<?= $UsuarioRegistrado['Correo'] ?>" required>
                            <label>Correo</label>
                        </div>

                        <!-- Dirección -->
                        <div class="form-floating mb-3">
                            <input type="text" name="Direccion" class="form-control" value="<?= $UsuarioRegistrado['Direccion'] ?>" required>
                            <label>Dirección</label>
                        </div>

                        <!-- No_Carnet, Fecha de Nacimiento, RH, EPS, AFP, ARL -->
                        <div class="form-floating mb-3">
                            <input type="number" name="noCarnet" class="form-control" value="<?= $UsuarioRegistrado['No_Carnet'] ?>" required>
                            <label>No. Carnet</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="date" name="Fecha_Nacimiento" class="form-control" value="<?= $UsuarioRegistrado['Fecha_Nacimiento'] ?>" required>
                            <label>Fecha de Nacimiento</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" name="RH" class="form-control" value="<?= $UsuarioRegistrado['RH'] ?>" required>
                            <label>RH</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" name="EPS" class="form-control" value="<?= $UsuarioRegistrado['EPS'] ?>" required>
                            <label>EPS</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" name="AFP" class="form-control" value="<?= $UsuarioRegistrado['AFP'] ?>" required>
                            <label>AFP</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" name="ARL" class="form-control" value="<?= $UsuarioRegistrado['ARL'] ?>" required>
                            <label>ARL</label>
                        </div>

                        <!-- Sexo -->
                        <div class="form-floating mb-3">
                            <select class="form-select" name="Sexo" required>
                                <option disabled selected>Sexo</option>
                                <option value="1" <?= $UsuarioRegistrado['Sexo'] == '1' ? 'selected' : '' ?>>Masculino</option>
                                <option value="2" <?= $UsuarioRegistrado['Sexo'] == '2' ? 'selected' : '' ?>>Femenino</option>
                            </select>
                            <label>Sexo</label>
                        </div>

                        <!-- Municipio -->
                        <div class="form-floating mb-3">
                            <select class="form-select" name="Departamento" id="floatingSelect" aria-label="Floating label select example" required>
                                <?php
                                if ($ListaMunicipios) {
                                    foreach ($ListaMunicipios as $Departamento) {
                                        $selected = ($Departamento['name'] == $UsuarioRegistrado['Municipio']) ? 'selected' : '';
                                ?>
                                        <option value="<?= htmlspecialchars($Departamento['name']) ?>" <?= $selected ?>><?= htmlspecialchars($Departamento['name']) ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                            <label for="floatingSelect">Seleccione el departamento</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-select" name="Area" id="floatingSelectArea" aria-label="Seleccione el área" required>
                                <option value="1" <?= $UsuarioRegistrado['Area'] == 1 ? 'selected' : '' ?>>ADMINISTRATIVO</option>
                                <option value="2" <?= $UsuarioRegistrado['Area'] == 2 ? 'selected' : '' ?>>PLANTA</option>
                                <option value="3" <?= $UsuarioRegistrado['Area'] == 3 ? 'selected' : '' ?>>TALLER</option>
                            </select>
                            <label for="floatingSelectArea">Seleccione el área</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-select" name="Turno" id="floatingSelectTurno" aria-label="Seleccione el turno" required>
                                <option value="1" <?= $UsuarioRegistrado['Turno'] == 1 ? 'selected' : '' ?>>ORDINARIO</option>
                                <option value="2" <?= $UsuarioRegistrado['Turno'] == 2 ? 'selected' : '' ?>>ROTATIVO</option>
                            </select>
                            <label for="floatingSelectTurno">Seleccione el turno</label>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-end">
                            <a href="Inicio" class="btn btn-danger me-2">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        const fileInput = document.getElementById('formFile');
        const previewImage = document.getElementById('preview');
        fileInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
<?php
} else {
    echo "<script>window.location.href = 'Inicio';</script>";
}

require_once "App/Views/Templates/Layouts/Footer.php";
?>