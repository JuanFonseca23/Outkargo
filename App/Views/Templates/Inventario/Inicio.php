<?php
require_once "App/Views/Templates/Layouts/Header.php";
if (empty($_SESSION['ID'])) {
    header("location:../IniciarSesion");
    exit;
}
?>
<!-- Sale & Revenue Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-6 col-xl-3">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <img width="50" height="50" src="https://img.icons8.com/ios/50/000020/warehouse-1.png" alt="warehouse-1" />
                <div class="ms-3">
                    <p class="mb-2" style="color: #000020;">Productos</p>
                    <h6 class="mb-0" style="color: #000020;">25</h6>
                </div>
            </div>
        </div>
        <a class="col-sm-6 col-xl-3" href="Registrar">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <img width="50" height="50" src="https://img.icons8.com/ios/50/000020/new--v1.png" alt="new--v1" />
                <div class="ms-3">
                    <p class="mb-2" style="color: #000020;">Registrar producto</p>
                </div>
            </div>
        </a>
        <a class="col-sm-6 col-xl-3" data-bs-toggle="modal" data-bs-target="#NumerDocumentoModal">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <img width="50" height="50" src="https://img.icons8.com/ios/50/000020/truck.png" alt="truck" />
                <div class="ms-3">
                    <p class="mb-2" style="color: #000020;">Registrar Entrega</p>
                </div>
            </div>
        </a>
        <a class="col-sm-6 col-xl-3" href="Entrada">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <img width="50" height="50" src="https://img.icons8.com/pastel-glyph/100/000020/hand-truck--v1.png" alt="hand-truck--v2" style="transform: scaleX(-1);" />
                <div class="ms-3">
                    <p class="mb-2" style="color: #000020;">Entradas</p>
                </div>
            </div>
        </a>

        <a class="col-sm-6 col-xl-3" href="#">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <img width="50" height="50" src="https://img.icons8.com/pastel-glyph/100/000020/hand-truck--v1.png" alt="hand-truck--v1" />
                <div class="ms-3">
                    <p class="mb-2" style="color: #000020;">Salidas</p>
                </div>
            </div>
        </a>
        <a class="col-sm-6 col-xl-3" href="#">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <img width="50" height="50" src="https://img.icons8.com/pastel-glyph/64/000020/create-new--v2.png" alt="create-new--v2" />
                <div class="ms-3">
                    <p class="mb-2" style="color: #000020;">Ajustes</p>
                </div>
            </div>
        </a>
        <a class="col-sm-6 col-xl-3" href="#">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <img width="50" height="50" src="https://img.icons8.com/pastel-glyph/64/000020/delivery-tracking--v2.png" alt="delivery-tracking--v2" />
                <div class="ms-3">
                    <p class="mb-2" style="color: #000020;">Traslados</p>
                </div>
            </div>
        </a>
        <a class="col-sm-6 col-xl-3" href="#">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <img width="50" height="50" src="https://img.icons8.com/ios/50/000020/document-1.png" alt="document-1" />
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
            <a href="#">Descargar Excel</a>
        </div>
        <div class="table-responsive">
            <table class="table text-start align-middle table-bordered table-hover mb-0" id="myTable">
                <thead>
                    <tr class="text-dark">
                        <th scope="col" class="text-center">Codigo</th>
                        <th scope="col" class="text-center">Cantidad</th>
                        <th scope="col">Nombre</th>
                        <th scope="col" class="text-center">Codigo de barras</th>
                    </tr>
                </thead>
                <tbody>
                    <th scope="col" class="text-center">Codigo</th>
                        <th scope="col" class="text-center">Cantidad</th>
                        <th scope="col">Nombre</th>
                        <th scope="col" class="text-center">Codigo de barras</th>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require "App/Views/Templates/Layouts/Footer.php"; ?>