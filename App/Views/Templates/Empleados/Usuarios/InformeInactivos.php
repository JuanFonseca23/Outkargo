<?php
    include_once "App/Controllers/UsuarioController.php";
    $Empleados = new UsuarioController;
    $Listas = $Empleados->InformeInactivos();
    date_default_timezone_set('America/Bogota');
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>INFORME USUARIOS ACTIVOS</title>
</head>
<body>
<style>
@import url("fonts/BrixSansRegular.css");
@import url("fonts/BrixSansBlack.css");

*{
	margin: 0;
	padding: 0;
	box-sizing: border-box;
}
p, label, span, table{
	font-family: "BrixSansRegular";
	font-size: 6pt;
}
.h2{
	font-family: "BrixSansBlack";
	font-size: 16pt;
}
.h3{
	font-family: "BrixSansBlack";
	font-size: 6pt;
	display: block;
	background: #000020;
	color: #FFF;
	text-align: center;
	padding: 3px;
	margin-bottom: 5px;
}
#page_pdf{
	width: 95%;
	margin: 15px auto 10px auto;
}

#factura_head, #factura_cliente, #factura_detalle{
	width: 100%;
	margin-bottom: 10px;
}
.logo_factura{
	width: 25%;
}
.info_empresa{
	width: 50%;
	text-align: center;
}
.info_factura{
	width: 25%;
}
.info_cliente{
	width: 100%;
}
.datos_cliente{
	width: 100%;
}
.datos_cliente tr td{
	width: 50%;
}
.datos_cliente{
	padding: 10px 10px 0 10px;
}
.datos_cliente label{
	width: 75px;
	display: inline-block;
}
.datos_cliente p{
	display: inline-block;
}

.textright{
	text-align: right;
}
.textleft{
	text-align: left;
}
.textcenter{
	text-align: center;
}
.round{
	border-radius: 10px;
	border: 1px solid #000020;
	overflow: hidden;
	padding-bottom: 15px;
}
.round p{
	padding: 0 15px;
}

#factura_detalle{
	border-collapse: collapse;
}
#factura_detalle thead th{
	background: #000020;
	color: #FFF;
	padding: 5px;
}
#detalle_productos tr:nth-child(even) {
    background: #ededed;
}
#detalle_totales span{
	font-family: "BrixSansBlack";
}
.nota{
	font-size: 8pt;
}
.label_gracias{
	font-family: verdana;
	font-weight: bold;
	font-style: italic;
	text-align: center;
	margin-top: 20px;
}
</style>
<div id="page_pdf">
	<table id="factura_head">
		<tr>
            <td class="logo_factura">
				<div>
                    <?php
                        $host = $_SERVER['HTTP_HOST'];
                        if ($host === 'localhost') {
                            echo '<img src="http://localhost/Outkargo2/App/Views/Img/Outkargo.png" width="100%" />';  
                        } else {
                            // Estás en un servidor remoto
                            echo '<img src="https://'.$host.'/App/Views/Img/Outkargo.png"/> width="100%"'; 
                        }
                    ?>
				</div>
			</td>
			<td class="info_empresa">
				<div>
					<span class="h2">OUTKARGO APP</span>
					<p>Transv 72F No. 42C-40</p>
					<p>Email: info@outkargoapp.com</p>
				</div>
			</td>
			<td class="info_factura">
				<div class="round">
					<span class="h3">Tipo informe</span>
					<p>Fecha: <?=date('Y-m-d')?></p>
					<p>Hora: <?=date('H:i:s')?></p>
					<p>Informe: Usuarios Inactivos OUTKARGOAPP</p>
				</div>
			</td>
		</tr>
	</table>
	<table id="factura_cliente">
		<tr>
			<td class="info_cliente">
				<div class="round">
					<span class="h3">Generado</span>
					<table class="datos_cliente">
						<tr>
							<td><label>Documento:</label><p><?= $_SESSION['Documento']?></p></td>
							<td><label>Teléfono:</label> <p><?=$_SESSION['Telefono']?></p></td>
						</tr>
						<tr>
							<td><label>Nombre:</label> <p><?=$_SESSION['NombreCompleto']?></p></td>
							<td><label>Correo:</label> <p><?=$_SESSION['Correo']?></p></td>
						</tr>
					</table>
				</div>
			</td>

		</tr>
	</table>

	<table id="factura_detalle">
			<thead>
				<tr>
                    <th width="20px">ID</th>
                    <th width="20px">T.D</th>
                    <th class="textleft">Cédula</th>
                    <th class="textleft">Apellidos</th>
                    <th class="textleft">Nombres</th>
                    <th class="textleft">Nombre Completo</th>
                    <th class="textleft">Sede</th>
                    <th class="textleft">Cargo</th>
                    <th class="textleft">Edad</th>
                    <th class="textleft">Teléfono</th>
                    <th class="textleft">Correo</th>
                    <th class="textleft">Foto</th>
				</tr>
			</thead>
			<tbody id="detalle_productos">
            <?php
                if ($Listas) {
                    foreach ($Listas as $Lista) {
            ?>
                        <tr>
                            <td class="textcenter"><?=htmlspecialchars($Lista['ID'])?></td>
                            <td class="textcenter">
                                <?php
                                    if ($Lista['Tipo_Documento'] == 1) {
                                        echo  'C.C';
                                    } elseif ($Lista['Tipo_Documento'] == 2) {
                                        echo  'T.I';
                                    } elseif ($Lista['Tipo_Documento'] == 3) {
                                        echo  'Otro';
                                    }
                                ?>
                            </td>
                            <td><?=htmlspecialchars($Lista['Documento'])?></td>
                            <td><?=htmlspecialchars($Lista['Apellido1']." ".$Lista['Apellido2'])?></td>
                            <td><?=htmlspecialchars($Lista['Nombre1']." ".$Lista['Nombre2'])?></td>
                            <td><?=htmlspecialchars($Lista['NombreCompleto'])?></td>
                            <td><?=htmlspecialchars($Lista['Nombre_Centro'])?></td>
                            <td><?=htmlspecialchars($Lista['Nombre_Cargo'])?></td>                            
                            <td class="textcenter"><?=htmlspecialchars($Lista['Edad'])?></td>
                            <td><?=htmlspecialchars($Lista['Telefono'])?></td>
                            <td><?=htmlspecialchars($Lista['Correo'])?></td>
                            <td><?=htmlspecialchars($Lista['Foto'])?></td>
                        </tr>
            <?php
                    }
                }
            ?>
</tbody>
	</table>
	<div>
		<p class="nota">Si usted tiene preguntas sobre este informe, pongase en contacto con nombre, teléfono y Email</p>
		<h4 class="label_gracias">¡Este es un reporte confidencial generado automáticamente en OUTKARGOAPP!</h4>
	</div>

</div>

</body>
</html>