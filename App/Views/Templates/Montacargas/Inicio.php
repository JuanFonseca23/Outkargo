<?php require_once "App/Views/Templates/Layouts/Header.php"; ?>
<style>
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
    .card:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3); 
    }
</style>
<div class="container-fluid pt-4 px-4">
    <div class="row">
        <div class="col-md-4 mb-4">
            <a href="Todas" class="card text-center" style="width: 100%; background-color: #f8f9fa;">
                <img src="https://img.icons8.com/ios/500/ff5000/warehouse-1.png" alt="warehouse-1" class="card-img-top" style="width: 40%; margin: auto; padding: 5px;">
                <div class="card-body" style="padding: 5px;">
                    <h5 class="card-title" style="font-size: 1rem;">Equipos</h5>
                </div>
            </a>
        </div>
        <div class="col-md-4 mb-4">
            <a href="EC" class="card text-center" style="width: 100%; background-color: #f8f9fa;">
                <img src="https://img.icons8.com/external-nawicon-detailed-outline-nawicon/500/ff5000/external-forklift-construction-nawicon-detailed-outline-nawicon.png" class="card-img-top" alt="Contrabalanceada Electrica" style="width: 40%; margin: auto; padding: 5px;">
                <div class="card-body" style="padding: 5px;">
                    <h5 class="card-title" style="font-size: 1rem;">Contrabalanceada Electrica</h5>
                </div>
            </a>
        </div>
        <div class="col-md-4 mb-4">
            <a href="CI" class="card text-center" style="width: 100%; background-color: #f8f9fa;">
                <img src="https://img.icons8.com/wired/500/ff5000/fork-lift.png" class="card-img-top" alt="Contrabalanceada Combustion" style="width: 40%; margin: auto; padding: 5px;">
                <div class="card-body" style="padding: 5px;">
                    <h5 class="card-title" style="font-size: 1rem;">Contrabalanceada Combustion</h5>
                </div>
            </a>
        </div>
        <div class="col-md-4 mb-4">
            <a href="ETP" class="card text-center" style="width: 100%; background-color: #f8f9fa;">
                <img src="https://img.icons8.com/external-others-cattaleeya-thongsriphong/500/ff5000/external-cargo-logistic-outline-others-cattaleeya-thongsriphong-15.png" class="card-img-top" alt="Electrica Toma pedido" style="width: 40%; margin: auto; padding: 5px;">
                <div class="card-body" style="padding: 5px;">
                    <h5 class="card-title" style="font-size: 1rem;">Electrica Toma pedido</h5>
                </div>
            </a>
        </div>
        <div class="col-md-4 mb-4">
            <a href="EPA" class="card text-center" style="width: 100%; background-color: #f8f9fa;">
                <img src="https://img.icons8.com/external-others-phat-plus/500/ff5000/external-forklift-shipping-outline-others-phat-plus.png" class="card-img-top" alt="Electrica Pasillo Angosto" style="width: 40%; margin: auto; padding: 5px;">
                <div class="card-body" style="padding: 5px;">
                    <h5 class="card-title" style="font-size: 1rem;">Electrica Pasillo Angosto</h5>
                </div>
            </a>
        </div>
        <div class="col-md-4 mb-4">
            <a href="S" class="card text-center" style="width: 100%; background-color: #f8f9fa;">
                <img src="https://img.icons8.com/external-xnimrodx-lineal-xnimrodx/500/ff5000/external-lift-export-and-delivery-xnimrodx-lineal-xnimrodx.png" class="card-img-top" alt="Manlift" style="width: 40%; margin: auto; padding: 5px;">
                <div class="card-body" style="padding: 5px;">
                    <h5 class="card-title" style="font-size: 1rem;">Manlift</h5>
                </div>
            </a>
        </div>
    </div>
</div>
<?php require "App/Views/Templates/Layouts/Footer.php"; ?>