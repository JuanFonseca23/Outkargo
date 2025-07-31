<div class="container-fluid">
    <div class="card">
        <div class="card-body d-flex align-items-center" style="background-image: url('../App/Views/Img/Ver.png'); background-size: cover; background-position: center; padding: 80px;"></div>
        <div class="card-body d-flex align-items-center">
            <img src="../App/Views/Upload/Img/Perfil/<?= $UsuarioRegistrado['Foto'] ?>" class="rounded-circle-2 border border-light" alt="Foto de perfil">
            <div class="ml-3">
                <h3><?= $UsuarioRegistrado['NombreCompleto'] ?></h3>
                <p class="mb-0"><i class="fa fa-briefcase"></i> <?= $UsuarioRegistrado['Nombre_Cargo'] ?> &nbsp;&nbsp;<i class="fa fa-map-marker"></i> <?= $UsuarioRegistrado['Nombre_Centro'] ?> &nbsp;&nbsp;<i class="fa fa-calendar"></i> Registrado <?= $UsuarioRegistrado['Fecha_Creado'] ?></p>
            </div>
            <a class="btn btn-primary btn-primary-wa ml-auto" target="_blank" href="https://api.whatsapp.com/send?phone=57<?= $UsuarioRegistrado['Telefono'] ?>"><img width="20" height="20" src="https://img.icons8.com/ios/50/ffffff/whatsapp--v1.png" alt="whatsapp--v1" /> Contactar</a>
        </div>
    </div>
</div>
<div class="card mt-3">
    <div class="card-body">
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a class="nav-link active" href="Ver?ID=<?= $ID ?>">Ver</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" onclick="confirmarEditar(<?= htmlspecialchars($UsuarioRegistrado['ID']) ?>)">Editar</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" onclick="confirmarDesactivacion(<?= htmlspecialchars($UsuarioRegistrado['ID']) ?>)">Eliminar</a>
            </li>
            <!-- <li class="nav-item">
                        <a class="nav-link" href="Descargar?ID=<?= $ID ?>">Descargar</a>
                    </li> -->
            <li class="nav-item">
                <a class="nav-link" href="Carnet?ID=<?= $ID ?>" target="_blank">Carnet</a>
            </li>
        </ul>
    </div>
</div>