<?php
    include_once "App/Controllers/UsuarioController.php";
    require_once "App/Views/Templates/Layouts/Header.php";
    include_once "App/Controllers/CentroDeTrabajoController.php";
    $CentrosDeTrabajo = new CentroDeTrabajoController;
    $UsuarioController = new UsuarioController();
    $ListaCentrosDeTrabajo = $CentrosDeTrabajo->TraerCentrosDeTrabajo();
    $ListasCargos = $CentrosDeTrabajo->ListaCargos();
    $ListaMunicipios = json_decode($UsuarioController->ListaMunicipios(), true);
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
                        $NombreContacto = $_POST['NombreContacto'];
                        $TelefonoContacto = $_POST['TelefonoContacto'];          
                        $UsuarioController->RegistrarUsuario($_SESSION['ID'], $_SESSION['Nombre1'], $ID_Centro, $ID_Cargo, $Tipo_Documento, $Documento, $Nombre1, $Nombre2, $Apellido1, $Apellido2, $Foto, $Telefono, $Correo, $Direccion, $No_Carnet ,$Fecha_Nacimiento , $RH, $EPS, $AFP, $ARL, $Sexo, $Municipio, $Area, $Turno, $NombreContacto, $TelefonoContacto);
                    }
                ?>
                <form method="post" enctype="multipart/form-data">
                    <h6 class="mb-4">Registrar Nuevo Usuario</h6>
                    <div class="form-floating mb-3">
                        <select class="form-select" name="ID_Centro" id="floatingSelect" aria-label="Floating label select example" required>
                            <option disabled selected>Centros de trabajo</option>
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
                        <label for="floatingSelect">Seleccione el centro de trabajo</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" name="ID_Cargo" id="floatingSelect" aria-label="Floating label select example" required>
                            <option disabled selected>Cargos</option>
                            <?php
                            if ($ListaCentrosDeTrabajo) {
                                foreach ($ListasCargos as $ListaCargos) {
                            ?>
                                    <option value="<?= $ListaCargos['ID'] ?>"><?= $ListaCargos['Cargo'] ?></option>
                            <?php
                                }
                            }
                            ?>
                        </select>
                        <label for="floatingSelect">Seleccione el cargo</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" name="Tipo_Documento" id="floatingSelect" aria-label="Floating label select example" required>
                            <option disabled selected>Tipo Documento</option>
                            <option value="1">Cedula</option>
                            <option value="2">Tarjeta de identidad</option>
                            <option value="3">Otro</option>
                        </select>
                        <label for="floatingSelect">Seleccione el tipo de documento</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="number" name="Documento" class="form-control" id="floatingInput" placeholder="No. Documento" required>
                        <label for="floatingInput">No. Documento</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" name="Nombre1" class="form-control" id="floatingInput" placeholder="Primer Nombre" required>
                        <label for="floatingInput">Primer Nombre</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" name="Nombre2" class="form-control" id="floatingInput" placeholder="Segundo Nombre">
                        <label for="floatingPassword">Segundo Nombre</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" name="Apellido1" class="form-control" id="floatingInput" placeholder="Primer Apellido" required>
                        <label for="floatingInput">Primer Apellido</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" name="Apellido2" class="form-control" id="floatingInput" placeholder="Segundo Apellido">
                        <label for="floatingInput">Segundo Apellido</label>
                    </div>
                    <div class="mb-3">
                        <img id="preview" src="../App/Views/Img/UsuarioImagen.png" alt="Previsualización de la imagen" style="max-width: 150px;" />
                    </div>
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Seleccione la foto de perfil</label>
                        <input class="form-control" type="file" name="Foto" id="formFile" accept="image/png" required>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="number" name="Telefono" class="form-control" id="floatingInput" placeholder="Telefono" required>
                        <label for="floatingInput">Telefono</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" name="Correo" class="form-control" id="floatingInput" placeholder="Correo" required>
                        <label for="floatingInput">Correo</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" name="Direccion" class="form-control" id="floatingInput" placeholder="Direccion" required>
                        <label for="floatingInput">Dirección</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="number" name="noCarnet" class="form-control" id="floatingInput" placeholder="No. Carnet" required>
                        <label for="floatingInput">No_Carnet</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="date" name="Fecha_Nacimiento" class="form-control" id="floatingInput" required>
                        <label for="floatingInput">Fecha de Nacimiento</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" name="RH" class="form-control" id="floatingInput" placeholder="RH" required>
                        <label for="floatingInput">RH</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" name="EPS" class="form-control" id="floatingInput" placeholder="EPS" required>
                        <label for="floatingInput">EPS</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" name="AFP" class="form-control" id="floatingInput" placeholder="AFP" required>
                        <label for="floatingInput">AFP</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" name="ARL" class="form-control" id="floatingInput" placeholder="ARL" required>
                        <label for="floatingInput">ARL</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" name="Sexo" id="floatingSelect" aria-label="Floating label select example" required>
                            <option value="1">Hombre</option>
                            <option value="2">Mujer</option>
                            <option value="3">Otro</option>
                        </select>
                        <label for="floatingSelect">Seleccione el genero</label>
                    </div>                            
                    <div class="form-floating mb-3">
                        <select class="form-select" name="Departamento" id="floatingSelect" aria-label="Floating label select example" required>
                            <?php
                                if ($ListaMunicipios) {
                                    foreach($ListaMunicipios as $Departamento) {                                            
                                        echo '<option value="' . htmlspecialchars($Departamento['name']) . '">' . htmlspecialchars($Departamento['name']) . '</option>';
                                    }
                                }
                            ?>
                        </select>
                        <label for="floatingSelect">Seleccione el departamento</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" name="Area" id="floatingSelect" aria-label="Floating label select example" required>
                            <option value="1">ADMINISTRATIVO</option>
                            <option value="2">PLANTA</option>
                            <option value="3">TALLER</option>
                        </select>
                        <label for="floatingSelect">Seleccione el Area</label>
                    </div>      
                    <div class="form-floating mb-3">
                        <select class="form-select" name="Turno" id="floatingSelect" aria-label="Floating label select example" required>
                            <option value="1">ORDINARIO</option>
                            <option value="2">ROTATIVO</option>>
                        </select>
                        <label for="floatingSelect">Seleccione el Turno</label>
                    </div>   
                    <hr>             
                    <h6 class="mb-4">Registrar datos contacto de emergencia</h6>
                    <div class="form-floating mb-3">
                        <input type="text" name="NombreContacto" class="form-control" id="floatingInput" placeholder="Primer Apellido" required>
                        <label for="floatingInput">Nombre Contacto</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" name="TelefonoContacto" class="form-control" id="floatingInput" placeholder="Segundo Apellido">
                        <label for="floatingInput">Telefono Contacto</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Registrar</button>
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
<?php require "App/Views/Templates/Layouts/Footer.php"; ?>