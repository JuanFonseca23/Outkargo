<div class="col-md-4">
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #000020; cursor: pointer; text-align: center;" data-bs-toggle="collapse" data-bs-target="#familiarCollapse" aria-expanded="false" aria-controls="educacionCollapse">
            <div>
                Familiar
            </div>
            <div>
                <a class="btn btn-sx btn-primary" onclick="handleButtonClick(event, <?= $ID ?>)">
                    <img width="20" height="20" src="https://img.icons8.com/windows/ffffff/32/add--v1.png" alt="add--v1" />
                </a>
            </div>
        </div>
        <div id="familiarCollapse" class="collapse">
            <div class="card-body text-white">
                <ul class="list-unstyled">
                    <?php
                    if ($DataContactos) {
                        foreach ($DataContactos as $DataContacto) {
                    ?>
                            <li class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                                <div>
                                    <h6 class="mb-1" style="color: #000020;"><?= $DataContacto['Nombre'] ?></h6>
                                    <small class="text-muted"><?= $DataContacto['Telefono'] ?></small>
                                </div>
                                <div>
                                    <a class="btn btn-xs btn-danger" onclick="confirmAction(<?= $DataContacto['ID'] ?>, <?= $ID ?>)">
                                        <img width="20" height="20" src="https://img.icons8.com/material-outlined/24/FFFFFF/filled-trash.png" alt="filled-trash" />
                                    </a>
                                </div>
                            </li>
                    <?php
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</div>