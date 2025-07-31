<?php

if ($_SERVER['HTTP_HOST'] == 'localhost') {
    $baseUrl = 'http://localhost/outkargo2/';
} else {
    $baseUrl = 'https://outkargo.com.co/';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>OUTKARGO - Administrador</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="description" content="OUTKARGO ofrece servicios de alquiler de montacargas con y sin operador en Colombia. Contamos con una amplia flota de montacargas para cubrir tus necesidades de carga y descarga.">
    <meta name="keywords" content="OUTKARGO, alquiler de montacargas, montacargas con operador, montacargas sin operador, Colombia, Montacargas, Pasillo angosto, Toma Pedido, Contrabalanceada, Contrabalanceado, Snorlift, Manlift, Lift, Combustion Interna, Diesel, Gas">
    <link rel="icon" href="../../App/Favicon.ico" type="image/x-icon">

    <!-- JavaScript -->
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <!-- CSS -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
    <!-- Default theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css" />
    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Libraries Stylesheet -->
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link href="../../App/Views/Resources/Lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="../../App/Views/Resources/Lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />
    <!-- Template Stylesheet -->
    <link href="../../App/Views/Resources/Css/Dashboard/style.css" rel="stylesheet">
</head>
<style>
    body {
        font-family: Arial, Helvetica, sans-serif;
    }
    table {
        width: 100%;
    }
    .anulada{
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translateX(-50%) translateY(-50%);
    }
    .tarjetas-contenedor {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: space-around;
        margin-top: 30px;
        font-size: 14px;
        font-family: Arial, sans-serif;
    }

    .tarjeta {
        background-color: #f7f9fc;
        border: 2px solid #000000; /* Borde azul oscuro */
        border-radius: 10px;
        padding: 15px 20px;
        width: 30%;
        min-width: 300px;
        box-shadow: 2px 2px 10px rgba(0,0,0,0.1);
    }

    .tarjeta h3 {
        display: flex;
        align-items: center;
        font-size: 18px;
        margin-bottom: 12px;
        color: #000020;
    }

    .tarjeta h3 img {
        margin-right: 10px;
    }

    .tarjeta ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .tarjeta ul li {
        display: flex;
        justify-content: space-between;
        border-bottom: 1px dashed #000;
        padding: 4px 0;
    }
</style>
<body>
    <table border="1">
        <thead>
            <tr>
                <th rowspan="3"><img src="<?= $baseUrl ?>App/Views/Img/Outkargo.png" width="200px"></th>
                <th rowspan="3" class="Titulo" style="font-size: 20px;">INFORME DIAGNOSTICO OVERHAULING INICIAL</th>
                <th>CODIGO:</th>
                <td>#####</td>
            </tr>
            <tr>
                <th>FECHA:</th>
                <td>24-06-2024</td>
            </tr>
            <tr>
                <th>VERSIÓN:</th>
                <td>1</td>
            </tr>
        </thead>
    </table>
    <table border="1">
        <thead>
            <tr>
                <th>Marca:</th>
                <td>-------</td>
                <th>Modelo:</th>
                <td>-------</td>
                <th>Serie:</th>
                <td>-------</td>
                <th>Número interno:</th>
                <td>------</td>                
                <th>Fecha:</th>
                <td>DD/MM/YYYY</td>
            </tr>  
            <tr>
                <th>Tipo de combustible</th>
                <td>-------</td>
                <th>Clase</th>
                <td>-------</td>
                <th>Capacidad de carga:</th>
                <td>------</td>
                <th>Horometro:</th>
                <td>------</td>
                <th>No.</th>
                <td style="color: red; text-align: center;">#######</td>
            </tr><tr>
                <th>Tecnico Encargado:</th>
                <td colspan="4">-------</td>

            </tr>            
        </thead>
    </table>
    <div class="tarjetas-contenedor">
        <!-- Tarjeta 1 -->
        <div class="tarjeta">
            <h3><img width="50" height="50" src="https://img.icons8.com/external-solidglyph-m-oki-orlando/64/000020/external-hydraulic-engineering-engineering-solid-solidglyph-m-oki-orlando.png" alt="external-hydraulic-engineering-engineering-solid-solidglyph-m-oki-orlando" />Sistema Hidraulico</h3>
            <ul>
                <li><span>Estado y nivel hidráulico</span><span>Bueno</span></li>
                <li><span>Motor de sistema hidráulico</span><span>Malo</span></li>
                <li><span>Escobillas</span><span>Bueno</span></li>
                <li><span>Caucho absorbedor de golpe</span><span>Bueno</span></li>
                <li><span>Bomba sistema hidráulico</span><span>Malo</span></li>
                <li><span>Filtro de retorno</span><span>Bueno</span></li>
                <li><span>Cuerpo de válvulas</span><span>Bueno</span></li>
                <li><span>Mangueras</span><span>Malo</span></li>
                <li><span>Micros de funciones hidráulicas</span><span>Bueno</span></li>
            </ul>
        </div>

        <!-- Tarjeta 2 -->
        <div class="tarjeta">
            <h3><img width="50" height="50" src="https://img.icons8.com/ios-filled/50/000020/abs.png" alt="abs" />Sistema De Frenos</h3>
            <ul>
                <li><span>Liquido de frenos</span><span>Bueno</span></li>
                <li><span>Bomba de freno principal</span><span>Malo</span></li>
                <li><span>Estado de bandas</span><span>Malo</span></li>
                <li><span>Rodamientos</span><span>Bueno</span></li>
                <li><span>Freno de estacionamiento</span><span>Malo</span></li>
                <li><span>Eficiencia de frenado</span><span>Malo</span></li>
                <li><span>Guayas de parqueo</span><span>Bueno</span></li>
                <li><span>Pedal de freno</span><span>Malo</span></li>
            </ul>
        </div>

        <!-- Tarjeta 3-->
        <div class="tarjeta">
            <h3><img width="50" height="50" src="https://img.icons8.com/ios-filled/50/000020/carbon-brush.png" alt="carbon-brush" />Sistema Eléctrico</h3>
            <ul>
                <li><span>Cables de potencia</span><span>Bueno</span></li>
                <li><span>Desconector de emergencia</span><span>Malo</span></li>
                <li><span>Cables de control</span><span>Bueno</span></li>
                <li><span>Conectores</span><span>Malo</span></li>
                <li><span>Fusibles</span><span>Bueno</span></li>
                <li><span>Controlador</span><span>Malo</span></li>
                <li><span>Display</span><span>Bueno</span></li>
                <li><span>Contactor linea</span><span>Malo</span></li>
                <li><span>Contactor direccion</span><span>Bueno</span></li>
                <li><span>Contactor elevacion</span><span>Malo</span></li>
                <li><span>Contactor marcha</span><span>Bueno</span></li>
                <li><span>Micros</span><span>Malo</span></li>
                <li><span>Switch de ignicion</span><span>Bueno</span></li>
                <li><span>Potenciometro de aceleracion</span><span>Malo</span></li>
            </ul>
        </div>

        <!-- Tarjeta 4 -->
        <div class="tarjeta">
            <h3><img width="50" height="50" src="https://img.icons8.com/deco-glyph/50/000028/fork-lift.png" alt="fork-lift" />Mastil</h3>
            <ul>
                <li><span>Ajuste mastil</span><span>Bueno</span></li>
                <li><span>Estado secciones</span><span>Malo</span></li>
                <li><span>Bujes</span><span>Bueno</span></li>
                <li><span>Rodamientos</span><span>Malo</span></li>
                <li><span>Cadenas</span><span>Bueno</span></li>
                <li><span>Pasadores cadenas</span><span>Malo</span></li>
                <li><span>Mangueras free lift</span><span>Bueno</span></li>
                <li><span>Mangueras side shift</span><span>Malo</span></li>
                <li><span>Mangueras fork positioner</span><span>Bueno</span></li>
                <li><span>Tuberías</span><span>Malo</span></li>
                <li><span>Racores</span><span>Bueno</span></li>
                <li><span>Cilindros de inclinacion</span><span>Malo</span></li>
                <li><span>Cilindro de free lift</span><span>Bueno</span></li>
                <li><span>Cilindros laterales</span><span>Malo</span></li>
                <li><span>Cilindro de side shift</span><span>Bueno</span></li>
                <li><span>Cilindros de fork positioner</span><span>Malo</span></li>
            </ul>
        </div>

        <!-- Tarjeta 5 -->
        <div class="tarjeta">
            <h3><img width="30" src="https://img.icons8.com/ios-filled/50/000020/charge-battery--v1.png"/>Batería</h3>
            <ul>
                <li><span>Estado de cables</span><span>Bueno</span></li>
                <li><span>Nivel de electrolito</span><span>Malo</span></li>
                <li><span>Conector anderson</span><span>Bueno</span></li>
                <li><span>Compartimiento batería</span><span>Malo</span></li>
                <li><span>Estado batería</span><span>Bueno</span></li>
                <li><span>Estado de puentes</span><span>Malo</span></li>
            </ul>
        </div>

        <!-- Tarjeta 6 -->
        <div class="tarjeta">
            <h3><img width="50" height="50" src="https://img.icons8.com/ios-glyphs/50/000020/wheel.png" alt="wheel" />Ruedas</h3>
            <ul>
                <li><span>Degaste de caucho de ruedas de carga</span><span>Bueno</span></li>
                <li><span>Degaste de caucho de ruedas de dirección</span><span>Malo</span></li>
                <li><span>Estado de rin de carga</span><span>Bueno</span></li>
                <li><span>Estado de rin de dirección</span><span>Malo</span></li>
                <li><span>Limpieza</span><span>Bueno</span></li>
            </ul>
        </div>

        <!-- Tarjeta 7 -->
        <div class="tarjeta">
            <h3><img width="50" height="50" src="https://img.icons8.com/ios-filled/50/000020/l.png" alt="l" />Horquillas</h3>
            <ul>
                <li><span>Seguros</span><span>Bueno</span></li>
                <li><span>Mordaza superior</span><span>Malo</span></li>
                <li><span>Mordaza inferior</span><span>Bueno</span></li>
                <li><span>Estado de horquillas (inspección visual ver F-206 como referencia)</span><span>Malo</span></li>
            </ul>
        </div>

        <!-- Tarjeta 8 -->
         <div class="tarjeta">
            <h3><img width="50" height="50" src="https://img.icons8.com/ios-glyphs/50/000020/gearbox-selector.png" alt="gearbox-selector"/>Aditamentos</h3>
            <ul>
                <li><span>Side shift</span><span>Bueno</span></li>
                <li><span>Fork positioner</span><span>Malo</span></li>
                <li><span>Clamp</span><span>Bueno</span></li>
                <li><span>Cascade Tubular</span><span>Malo</span></li>
            </ul>
        </div>

        <!-- Tarjeta 9 -->
        <div class="tarjeta">
            <h3><img width="50" height="50" src="https://img.icons8.com/ios-glyphs/50/000020/4x4-vehicle.png" alt="4x4-vehicle" />Chasis</h3>
            <ul>
                <li><span>Ajustes de conjunto</span><span>Bueno</span></li>
                <li><span>Chequear soportes</span><span>Malo</span></li>
                <li><span>Tornilleria</span><span>Bueno</span></li>
                <li><span>Estado pintura</span><span>Malo</span></li>
            </ul>
        </div>

        <!-- Tarjeta 10 -->
        <div class="tarjeta">
            <h3><img width="50" height="50" src="https://img.icons8.com/ios-filled/50/000020/engine-oil-level.png" alt="engine-oil-level" />Lubricacíon</h3>
            <ul>
                <li><span>Engrase puente trasero</span><span>Bueno</span></li>
                <li><span>Engrase mastil</span><span>Malo</span></li>
                <li><span>Lubricacíon cadenas y secciones mastil</span><span>Bueno</span></li>
            </ul>
        </div>

        <!-- Tarjeta 11 -->
        <div class="tarjeta">
            <h3><img width="50" height="50" src="https://img.icons8.com/ios-filled/50/000020/fork-lift.png" alt="fork-lift" />Revision De Equipo</h3>
            <ul>
                <li><span>Limpieza del equipo</span><span>Bueno</span></li>
                <li><span>Horómetro</span><span>Malo</span></li>
                <li><span>Etiquetas de seguridad</span><span>Bueno</span></li>
                <li><span>Tapas</span><span>Malo</span></li>
                <li><span>Capó y amortiguador</span><span>Bueno</span></li>
                <li><span>Silla</span><span>Malo</span></li>
                <li><span>Cinturon de seguridad</span><span>Bueno</span></li>
                <li><span>Extintor</span><span>Malo</span></li>
            </ul>
        </div>

        <!-- Tarjeta 12 -->
        <div class="tarjeta">
            <h3><img width="50" height="50" src="https://img.icons8.com/ios-filled/50/000020/steering-wheel.png" alt="steering-wheel"/>Sistema De Dirección</h3>
            <ul>
                <li><span>Motor de dirección</span><span>Bueno</span></li>
                <li><span>Escobillas</span><span>Malo</span></li>
                <li><span>Bomba de dirección</span><span>Bueno</span></li>
                <li><span>Mangueras</span><span>Malo</span></li>
                <li><span>Cilindro de dirección</span><span>Bueno</span></li>
                <li><span>Cauchos puente trasero</span><span>Malo</span></li>
                <li><span>Rótulas</span><span>Bueno</span></li>
                <li><span>Guarda polvo</span><span>Malo</span></li>
                <li><span>Rodamientos</span><span>Bueno</span></li>
                <li><span>Orbitrol</span><span>Malo</span></li>
                <li><span>Terminales de dirección</span><span>Bueno</span></li>
            </ul>
        </div>

        <!-- Tarjeta 13 -->
        <div class="tarjeta">
            <h3><img width="50" height="50" src="https://img.icons8.com/ios-filled/50/000020/headlight.png" alt="headlight" />Luces y Alarmas</h3>
            <ul>
                <li><span>Luces frontales</span><span>Bueno</span></li>
                <li><span>Luz estroboscopia</span><span>Malo</span></li>
                <li><span>Luz de freno</span><span>Bueno</span></li>
                <li><span>Blue light</span><span>Malo</span></li>
                <li><span>Pito bocina</span><span>Bueno</span></li>
                <li><span>Alarma reversa</span><span>Malo</span></li>
            </ul>
        </div>

        <!-- Tarjeta 14 -->
        <div class="tarjeta">
            <h3><img width="50" height="50" src="https://img.icons8.com/ios-filled/50/000020/traction-control.png" alt="traction-control" />Sistema De Tracción</h3>
            <ul>
                <li><span>Motor de tracción</span><span>Malo</span></li>
                <li><span>Escobillas</span><span>Bueno</span></li>
                <li><span>Micros de marchas</span><span>Malo</span></li>
                <li><span>Transmisión</span><span>Bueno</span></li>
                <li><span>Nivel de valvulina</span><span>Malo</span></li>
                <li><span>Tornilleria</span><span>Bueno</span></li>
            </ul>
        </div>

        <!-- Tarjeta 15 -->
        <div class="tarjeta">
            <h3><img width="50" height="50" src="https://img.icons8.com/sf-regular-filled/50/000020/mine-cart.png" alt="mine-cart" />Carro Porta Horquillas</h3>
            <ul>
                <li><span>Ajuste carro porta horquillas</span><span>Bueno</span></li>
                <li><span>Rodamientos</span><span>Malo</span></li>
                <li><span>Cadenas</span><span>Bueno</span></li>
                <li><span>Pasadores</span><span>Malo</span></li>
                <li><span>Parilla o Espejo</span><span>Bueno</span></li>
                <li><span>Mordazas</span><span>Malo</span></li>
                <li><span>Deslizadores</span><span>Bueno</span></li>
            </ul>
        </div>

    </div>
    <br>
    <table border="1">
    <thead>
        <tr>
            <th colspan="6">OBSERVACIONES</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="6" style="padding: 10px;">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae commodi minima dignissimos!
                Odit itaque excepturi tenetur asperiores libero unde amet, dolorum quaerat beatae esse a suscipit, 
                ipsum, dolorem rerum labore?Lorem ipsum dolor, sit amet consectetur adipisicing elit. Pariatur, 
                libero. Enim nihil at voluptate porro obcaecati optio placeat illum quae ducimus quo eum delectus, 
                debitis corrupti veritatis voluptatem aliquid exercitationem.
            </td>
        </tr>
    </tbody>
    </table>
    <table border="1">
    <thead>
        <tr>
            <th colspan="6">REGISTRO FOTOGRÁFICO</th>
        </tr>
    </thead>
    <tbody>
        <!-- Fila 1 - Sistema Hidraulico -->
        <tr>
            <td rowspan="3" style="writing-mode: vertical-rl; text-orientation: upright; background-color: #000020; color: white; font-weight: bold; width: 60px; font-size: 20px; vertical-align: middle; text-align: center;">
                Sistema Hidraulico
            </td>
        <!-- Primera fila de imágenes (4 imágenes) -->
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/1_1.png" width="190px" height="190px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Hidraulico 1</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/1_2.png" width="190px" height="190px"  style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Hidraulico 2</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/1_3.png" width="190px" height="190px"  style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Hidraulico 3</span>
                </div>
            </td>
        </tr>
        <tr>
        <!-- Segunda fila -->
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                <img src="../App/Views/Upload/Img/Montacargas/1_4.png" width="190px" height="190px"  style="object-fit: cover;">
                <br>
                <span style="font-size: 15px; font-weight: bold;">Hidraulico 4</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                <img src="../App/Views/Upload/Img/Montacargas/1_5.png" width="190px" height="190px" style="object-fit: cover;">
                <br>
                <span style="font-size: 15px; font-weight: bold;">Hidraulico 5</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                <img src="../App/Views/Upload/Img/Montacargas/1_6.png" width="190px" height="190px" style="object-fit: cover;">
                <br>
                <span style="font-size: 15px; font-weight: bold;">Hidraulico 6</span>
                </div>
            </td>
        </tr>
        <tr>
        <!-- Tervera fila -->
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                <img src="../App/Views/Upload/Img/Montacargas/1_7.png" width="190px" height="190px" style="object-fit: cover;">
                <br>
                <span style="font-size: 15px; font-weight: bold;">Hidraulico 7</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                <img src="../App/Views/Upload/Img/Montacargas/1_8.png" width="190px" height="190px"  style="object-fit: cover;">
                <br>
                <span style="font-size: 15px; font-weight: bold;">Hidraulico 8</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                <img src="../App/Views/Upload/Img/Montacargas/1_9.png" width="190px" height="190px"  style="object-fit: cover;">
                <br>
                <span style="font-size: 15px; font-weight: bold;">Hidraulico 9</span>
                </div>
            </td>
        </tr>

        <!-- Espacio entre filas -->
        <tr>
            <td colspan="6" style="height: 20px;"></td>
        </tr>

        <!-- Fila 2 - Sistema De Frenos-->
        <tr>
            <td rowspan="3" style="writing-mode: vertical-rl; text-orientation: upright; background-color: #000020; color: white; font-weight: bold; width: 60px; font-size: 20px; vertical-align: middle; text-align: center;">
                Sistema De Frenos
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/2_1.png" width="190px" height="190px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Frenos 1</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/2_2.png" width="190px" height="190px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Frenos 2</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/2_3.png" width="190px" height="190px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Frenos 3</span>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/2_4.png" width="190px" height="190px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Frenos 4</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/2_5.png" width="190px" height="190px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Frenos 5</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/2_6.png" width="190px" height="190px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Frenos 6</span>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/2_7.png" width="190px" height="190px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Frenos 7</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/2_8.png" width="190px" height="190px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Frenos 8</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/2_9.png" width="190px" height="190px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Frenos 9</span>
                </div>
            </td>
        </tr>

        <!-- Espacio entre filas -->
        <tr>
            <td colspan="6" style="height: 20px;"></td>
        </tr>

        <!-- Fila 3 - Sistema Eléctrico -->
        <tr>
            <td rowspan="4" style="writing-mode: vertical-rl; text-orientation: upright; background-color: #000020; color: white; font-weight: bold; width: 60px; font-size: 20px; vertical-align: middle; text-align: center;">
                Sistema Eléctrico
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/1_9.png" width="190px" height="190px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Eléctrico 1</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/2_8.png" width="190px" height="190px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Eléctrico 2</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/1_8.png" width="190px" height="190px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Eléctrico 3</span>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/1_7.png" width="190px" height="190px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Eléctrico 4</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/2_6.png" width="190px" height="190px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Eléctrico 5</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/1_6.png" width="190px" height="190px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Eléctrico 6</span>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/2_5.png" width="190px" height="190px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Eléctrico 7</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/2_2.png" width="190px" height="190px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Eléctrico 8</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/1_5.png" width="190px" height="190px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Eléctrico 9</span>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/1_1.png" width="190px" height="190px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Eléctrico 10</span>
                </div>
            </td>
        </tr>

        <!-- Espacio entre filas -->
        <tr>    
            <td colspan="6" style="height: 20px;"></td>                     
        </tr>

        <!-- Fila 4 - Mastil -->
        <tr>
            <td rowspan="3" style="writing-mode: vertical-rl; text-orientation: upright; background-color: #000020; color: white; font-weight: bold; width: 60px; font-size: 20px; vertical-align: middle; text-align: center;">
                Mastil
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/2_8.png" width="190px" height="190px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Mastil 1</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/2_9.png" width="190px" height="190px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Mastil 2</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/2_7.png" width="190px" height="190px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Mastil 3</span>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/2_6.png" width="190px" height="190px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Mastil 4</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/2_5.png" width="190px" height="190px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Mastil 5</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/2_4.png" width="190px" height="190px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Mastil 6</span>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/2_3.png" width="190px" height="190px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Mastil 7</span>
                </div>
            </td>
        </tr>
        
        <!-- Espacio entre filas -->
        <tr>
            <td colspan="6" style="height: 20px;"></td>
        </tr>   

        <!-- Fila 5 - Batería -->
        <tr>
           <td rowspan="4" style="writing-mode: vertical-rl; text-orientation: upright; background-color: #000020; color: white; font-weight: bold; width: 60px; font-size: 20px; vertical-align: middle; text-align: center;">
                Batería
            </td>
           <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/1_1.png" width="190px" height="190px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Batería 1</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/1_2.png" width="190px" height="190px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Batería 2</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/1_3.png" width="190px" height="190px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Batería 3</span>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/1_4.png" width="190px" height="190px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Batería 4</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/1_5.png" width="190px" height="190px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Batería 5</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/1_6.png" width="190px" height="190px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Batería 6</span>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/1_7.png" width="190px" height="190px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Batería 7</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/1_8.png" width="190px" height="190px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Batería 8</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/1_9.png" width="190px" height="190px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Batería 9</span>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/2_2.png" width="190px" height="190px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Batería 10</span>
                </div>
            </td>
        </tr>

        <!-- Espacio entre filas -->
        <tr>
            <td colspan="6" style="height: 20px;"></td>
        </tr>
        
        <!-- Fila 6 - Ruedas -->
        <!-- <tr>
            <td rowspan="2" style="writing-mode: vertical-rl; text-orientation: upright; background-color: #000020; color: white; font-weight: bold; width: 60px; font-size: 16px; vertical-align: middle; text-align: center;">
                Ruedas
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/2_1.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Ruedas 1</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/2_2.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Ruedas 2</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/2_3.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Ruedas 3</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/2_4.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Ruedas 4</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/2_5.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Ruedas 5</span>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/2_6.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Ruedas 6</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/2_7.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Ruedas 7</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/2_8.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Ruedas 8</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/2_9.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Ruedas 9</span>
                </div>
            </td>
        </tr> -->
        <!-- Fila 7 - Horquillas -->
        <!-- <tr>
            <td rowspan="2" style="writing-mode: vertical-rl; text-orientation: upright; background-color: #000020; color: white; font-weight: bold; width: 60px; font-size: 16px; vertical-align: middle; text-align: center;">
                Horquillas
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/1_2.png" width="150px" height="100px"style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Horquillas 1</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/1_4.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Horquillas 2</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/1_6.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Horquillas 3</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/1_8.png" width="150px" height="100px"style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Horquillas 4</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/2_1.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Horquillas 5</span>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/2_3.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Horquillas 6</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/2_5.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Horquillas 7</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/2_7.png" width="150px" height="100px"style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Horquillas 8</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/2_9.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Horquillas 9</span>
                </div>
            </td>
        </tr> -->
        <!-- Fila 8 - Aditamentos -->
        <!-- <tr>
            <td rowspan="2" style="writing-mode: vertical-rl; text-orientation: upright; background-color: #000020; color: white; font-weight: bold; width: 60px; font-size: 16px; vertical-align: middle; text-align: center;">
                Aditamentos
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/1_9.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Aditamentos 1</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/1_8.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Aditamentos 2</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/1_7.png" width="150px" height="100px"style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Aditamentos 3</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/1_6.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Aditamentos 4</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/1_5.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Aditamentos 5</span>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/1_4.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Aditamentos 6</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/1_3.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Aditamentos 7</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/1_2.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Aditamentos 8</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/1_1.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Aditamentos 9</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/1_5.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Aditamentos 5</span>
                </div>
            </td>
        </tr> -->
        <!-- Fila 9 - Chasis -->
        <!-- <tr>
            <td rowspan="2" style="writing-mode: vertical-rl; text-orientation: upright; background-color: #000020; color: white; font-weight: bold; width: 60px; font-size: 16px; vertical-align: middle; text-align: center;">
                Chasis
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/2_5.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Chasis 1</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/2_4.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Chasis 2</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/2_3.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Chasis 3</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/2_2.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Chasis 4</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/2_1.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Chasis 5</span>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/2_9.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Chasis 6</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/2_8.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Chasis 7</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/2_7.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Chasis 8</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/2_6.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Chasis 9</span>
                </div>
            </td>
        </tr> -->
        <!-- Fila 10 - Lubricacíon -->
        <!-- <tr>
            <td rowspan="2" style="writing-mode: vertical-rl; text-orientation: upright; background-color: #000020; color: white; font-weight: bold; width: 60px; font-size: 16px; vertical-align: middle; text-align: center;">
                Lubricacíon
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/1_1.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Lubricacíon 1</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/1_2.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Lubricacíon 2</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/1_3.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Lubricacíon 3</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/1_4.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Lubricacíon 4</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/1_5.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Lubricacíon 5</span>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/1_6.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Lubricacíon 6</span>
                </div>
            </td>
        </tr> -->
        <!-- Fila 11 - Revision De Equipo -->
        <!-- <tr>
            <td rowspan="2" style="writing-mode: vertical-rl; text-orientation: upright; background-color: #000020; color: white; font-weight: bold; width: 60px; font-size: 16px; vertical-align: middle; text-align: center;">
                Revision De Equipo
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/2_1.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Equipo 1</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/2_2.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Equipo 2</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/2_3.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Equipo 3</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/2_4.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Equipo 4</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/2_5.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Equipo 5</span>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/2_6.png" width="150px" height="100px"style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Equipo 6</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/2_7.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Equipo 7</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/2_8.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Equipo 8</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/2_9.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Equipo 9</span>
                </div>
            </td>
        </tr> -->
        <!-- Fila 12 - Sistema De Dirección -->
        <!-- <tr>
            <td rowspan="2" style="writing-mode: vertical-rl; text-orientation: upright; background-color: #000020; color: white; font-weight: bold; width: 60px; font-size: 16px; vertical-align: middle; text-align: center;">
                Sistema De Dirección
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/2_6.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Dirección 1</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/2_7.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Dirección 2</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/2_8.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Dirección 3</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/2_9.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Dirección 4</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/1_1.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Dirección 5</span>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/1_2.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Dirección 6</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/1_5.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Dirección 7</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/1_3.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Dirección 8</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/1_5.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Dirección 9</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/1_9.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Dirección 10</span>
                </div>
            </td>
        </tr> -->
        <!-- Fila 13 - Luces y Alarmas -->
        <!-- <tr>
            <td rowspan="2" style="writing-mode: vertical-rl; text-orientation: upright; background-color: #000020; color: white; font-weight: bold; width: 60px; font-size: 16px; vertical-align: middle; text-align: center;">
                Luces y Alarmas
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/2_9.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Luces 1</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/2_8.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Luces 2</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/2_7.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Luces 3</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/2_6.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Luces 4</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/2_5.png" width="150px" height="100px"style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Luces 5</span>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/1_4.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Luces 6</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/1_2.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Luces 7</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/1_8.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Luces 8</span>
                </div>
            </td>
        </tr> -->
        <!-- Fila 14 - Sistema De Tracción -->
        <!-- <tr>
            <td rowspan="2" style="writing-mode: vertical-rl; text-orientation: upright; background-color: #000020; color: white; font-weight: bold; width: 60px; font-size: 16px; vertical-align: middle; text-align: center;">
                Sistema De Tracción
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/2_4.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Tracción 1</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/2_3.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Tracción 2</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/2_2.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Tracción 3</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/2_8.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Tracción 4</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/1_9.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Tracción 5</span>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/1_1.png" width="150px" height="100px"style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Tracción 6</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/1_2.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Tracción 7</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/1_5.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Tracción 8</span>
                </div>
            </td>
        </tr> -->
        <!-- Fila 15 - Carro Porta Horquillas -->
        <!-- <tr>
            <td rowspan="2" style="writing-mode: vertical-rl; text-orientation: upright; background-color: #000020; color: white; font-weight: bold; width: 60px; font-size: 16px; vertical-align: middle; text-align: center;">
                Carro Porta Horquillas
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/2_1.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Porta_Horquillas 1</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/2_2.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Porta_Horquillas 2</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/2_3.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Porta_Horquillas 3</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/1_4.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Porta_Horquillas 4</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/1_8.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Porta_Horquillas 5</span>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/2_8.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Porta_Horquillas 6</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/2_6.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Porta_Horquillas 7</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/1_3.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Porta_Horquillas 8</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/1_6.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Porta_Horquillas 9</span>
                </div>
            </td>
            <td>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <img src="../App/Views/Upload/Img/Montacargas/1_9.png" width="150px" height="100px" style="object-fit: cover;">
                    <br>
                    <span style="font-size: 15px; font-weight: bold;">Porta_Horquillas 10</span>
                </div>
            </td>
        </tr> -->
    </tbody>
    </table>
    <table border="1">
        <thead>
            <tr>
                <th>TECNICO ENCARGADO</th>
                <th>SUPERVISOR</th>
            </tr>
        </thead>
        <tbody>
            <tr height="100px">
                <!-- Añadir width="50%" para que ambas firmas ocupen el 50% de la tabla -->
                <td width="50%" style="text-align: center;">
                    <img src="" style="max-width: 100%;">
                </td>
                <td width="50%" style="text-align: center;">
                    <img src="" style="max-width: 100%;">
                </td>
            </tr>
            <tr>
                <th style="text-align: center;"></th>
                <th style="text-align: center;"></th>
            </tr>
            <tr>
                <th>Firma</th>
                <th>Firma</th>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td><b>Fecha: </b></td>
                <td><b>Fecha:</b></td>
            </tr>
        </tfoot>
    </table>

</body>

</html>