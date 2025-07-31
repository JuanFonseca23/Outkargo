<div class="card">
    <div class="card-header" style="background-color: #000020;" data-bs-toggle="collapse" data-bs-target="#usuarioInfoCollapse" aria-expanded="false" aria-controls="actividadCollapse" style="cursor: pointer; text-align: center;">
        Informacion Personal
    </div>
    <div id="usuarioInfoCollapse" class="collapse">
        <div class="card-body text-white">
            <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex justify-content-between">
                    <strong>Documento:</strong><span><?= $UsuarioRegistrado['Documento'] ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <strong>Nombre:</strong><span><?= $UsuarioRegistrado['NombreCompleto'] ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <strong>Fecha de Ingreso:</strong><span><?= $UsuarioRegistrado['Fecha_Creado'] ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <strong>Centro de trabajo:</strong><span><?= $UsuarioRegistrado['Nombre_Centro'] ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <strong>Fecha de nacimiento:</strong><span><?= $UsuarioRegistrado['Fecha_Nacimiento'] ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <strong>Edad:</strong><span><?= $UsuarioController->CalcularEdad($UsuarioRegistrado['Fecha_Nacimiento']) ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <strong>Sexo :</strong>
                    <span>
                        <?php
                        switch ($UsuarioRegistrado['Sexo']) {
                            case '1':
                                echo "Hombre";
                                break;
                            case '2':
                                echo "Mujer";
                                break;
                            default:
                                echo "Otro";
                                break;
                        }
                        ?>
                    </span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <strong>RH:</strong><span><?= $UsuarioRegistrado['RH'] ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <strong>EPS:</strong><span><?= $UsuarioRegistrado['EPS'] ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <strong>AFP:</strong><span><?= $UsuarioRegistrado['AFP'] ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <strong>ARL:</strong><span><?= $UsuarioRegistrado['ARL'] ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <strong>Municipio:</strong><span><?= $UsuarioRegistrado['Municipio'] ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <strong>Area:</strong>
                    <span>
                        <?php
                        switch ($UsuarioRegistrado['Area']) {
                            case '1':
                                echo "ADMINISTRATIVO";
                                break;
                            case '2':
                                echo "PLANTA";
                                break;
                            case '3':
                                echo "TALLER";
                                break;
                        }
                        ?>
                    </span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <strong>Turno:</strong>
                    <span>
                        <?php
                        switch ($UsuarioRegistrado['Turno']) {
                            case '1':
                                echo "ORDINARIO";
                                break;
                            case '2':
                                echo "ROTATIVO";
                                break;
                        }
                        ?>
                    </span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <strong>Cargo:</strong><span><?= $UsuarioRegistrado['Nombre_Cargo'] ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <strong>Correo:</strong><span><?= $UsuarioRegistrado['Correo'] ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <strong>Telefono:</strong><span><?= $UsuarioRegistrado['Telefono'] ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <strong>Dirección:</strong><span><?= $UsuarioRegistrado['Direccion'] ?></span>
                </li>
            </ul>
        </div>
    </div>
</div>