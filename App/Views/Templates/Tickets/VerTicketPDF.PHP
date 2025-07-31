<?php
include_once "App/Controllers/TicketsController.php";
$TicketsController = new TicketsController;
$ID_Ticket = $_GET['ID'];
$DataTicket = $TicketsController->ObtenerTicket($ID_Ticket);
$DataMensajes = $TicketsController->Obtenermensajes($ID_Ticket);
$Evidencias = $DataTicket['Evidencias'] ? explode(', ', $DataTicket['Evidencias']) : [];
$DataEncuesta = $TicketsController->ObetenerResultadosEncuesta($ID_Ticket);

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

<body>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 0;
            height: 100%;
        }

        table {
            width: 100%;
            page-break-inside: avoid; 
        }

        .message-container {
            border-radius: 15px;
            padding: 10px 15px;
            margin: 5px 0;
            max-width: 70%;
            word-wrap: break-word;
            overflow-wrap: break-word;
            page-break-inside: avoid; 
            display: flex;
            flex-direction: column;
        }

        .message-container-left {
            background-color: #f1f1f1;
            align-self: flex-start;
        }

        .message-container-right {
            background-color: #e0f7fa;
            align-self: flex-end;
            margin-left: auto;
        }

        .message-container span.user-name {
            font-weight: bold;
            display: block;
        }

        .message-container span.time {
            color: #888;
            font-size: 0.85em;
            margin-top: 5px;
            display: block;
        }

        .message-container:last-child {
            page-break-after: auto; 
        }

        .chat-container {
            page-break-before: always; 
        }

        
        .page-break {
            page-break-before: always;
        }
    </style>
    <table border="1">
        <thead>
            <tr>
                <th rowspan="3"><img src="<?= $baseUrl ?>App/Views/Img/Outkargo.png" width="200px"></th>
                <th rowspan="3" class="Titulo" style="font-size: 20px;">FORMATO TICKET</th>
                <th>CODIGO:</th>
                <td>Por Definir</td>
            </tr>
            <tr>
                <th>FECHA:</th>
                <td>Por Definir</td>
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
                <th>No:</th>
                <td style="color: red; text-align: center;"><?= $DataTicket['ID'] ?></td>
                <th>Solicitante:</th>
                <td><?= $DataTicket['NombreUsuario'] ?></td>
                <th>Fecha:</th>
                <td><?= $DataTicket['Fecha_Creado'] ?></td>
            </tr>   
            <tr>
                <th>Estado:</th>
                <td>
                    <?php
                    if ($DataTicket['Estado'] == 0) {
                        echo 'Pendiente';
                    } elseif ($DataTicket['Estado'] == 1) {
                        echo 'En proceso';
                    } elseif ($DataTicket['Estado'] == 2) {
                        echo 'Finalizado';
                    }
                    ?>
                </td> 
                <th>Responsable:</th>
                <td><?= $DataTicket['NombreGestiona'] ?></td>
                <th>Fecha Finalizacion:</th>
                <td><?= $DataTicket['Fecha_Finalizado'] ?></td>
            </tr>          
        </thead>
    </table>

    <p><b>Tipo:</b> <?= $DataTicket['Tipo'] ?></p>
    <p><b>Descripcion: </b><?= $DataTicket['Descripcion'] ?></p>
    
    <!-- Tabla para mostrar las evidencias -->
    <table border="1">
        <thead>
            <tr>
                <th colspan="4">Evidencias</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <?php foreach ($Evidencias as $index => $evidencia): ?>
                    <td style="text-align: center;">
                        <img src="<?= $baseUrl . htmlspecialchars($evidencia) ?>" alt="Evidencia <?= $index + 1 ?>" width="100px" height="100px">
                    </td>
                    <?php if (($index + 1) % 4 == 0): ?>
                        </tr><tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tr>
        </tbody>
    </table>
    <table border="1">
        <thead>
            <tr>
                <th colspan="4">Historial Chat</th>
            </tr>
        </thead>
    </table>
    <?php
        if ($DataMensajes) {
            foreach ($DataMensajes as $Mensaje):
                // Verificamos si el mensaje es del solicitante comparando el nombre del usuario
                $isSolicitante = $Mensaje['NombreUsuario'] == $DataTicket['Nombre1']; 
                $messageClass = $isSolicitante ? 'message-container-right' : 'message-container-left';
                ?>
                <div class="message-container <?= $messageClass ?>">
                    <span class="user-name" style="color: #ff5000"><?= htmlspecialchars($Mensaje['NombreUsuario']) ?>:</span>
                    <span><?= htmlspecialchars($Mensaje['Mensaje']) ?></span>
                    
                    <?php
                    // Verificar si hay imágenes asociadas al mensaje
                    if (!empty($Mensaje['Evidencias'])) {
                        $imagenes = explode(',', $Mensaje['Evidencias']); // Suponiendo que las imágenes están separadas por comas
                        foreach ($imagenes as $imagen) {
                            $imagen = trim($imagen); 
                            // Asegurarse de que las imágenes se comporten como bloques
                            echo '<div style="margin-top: 10px; margin-bottom: 10px;">'; // Contenedor para la imagen
                            echo '<img src="' . $baseUrl . htmlspecialchars($imagen) . '" alt="Evidencia" style="max-width: 100px; height: 90px; display: block; margin: 0 auto;"/>'; // Centrar la imagen
                            echo '</div>';
                        }
                    }
                    ?>
                    <span class="time"><?= htmlspecialchars($Mensaje['Fecha_Enviado']) ?> - <?= htmlspecialchars($Mensaje['Hora']) ?></span>
                </div>
            <?php endforeach;
        } else {
            echo "<p>No hay mensajes para este ticket.</p>";
        }
        ?>

    <table border="1">
        <thead>
            <tr>
                <th colspan="4">Encuesta</th>
            </tr>
        </thead>
        <tbody>
            <?php
                if ($DataEncuesta) {
                    // Muestra la descripción de la respuesta
                    $respuestaDescripcion = '';
                    switch ($DataEncuesta['Respuesta_1']) {
                        case 1:
                            $respuestaDescripcion = 'Muy Malo';
                            break;
                        case 2:
                            $respuestaDescripcion = 'Malo';
                            break;
                        case 3:
                            $respuestaDescripcion = 'Regular';
                            break;
                        case 4:
                            $respuestaDescripcion = 'Bueno';
                            break;
                        case 5:
                            $respuestaDescripcion = 'Excelente';
                            break;
                        default:
                            $respuestaDescripcion = 'No disponible';
                    }
                    ?>
                    <tr>
                        <td>
                            <label for="satisfaccion" class="form-label">
                                ¿Cómo calificarías la atención prestada? (1 es malo, 5 es excelente)
                            </label>
                        </td>
                        <td>
                            <?= htmlspecialchars($DataEncuesta['Respuesta_1']) ?> - <?= $respuestaDescripcion ?>
                        </td>
                    </tr>

                    <?php
                    // Mostrar comentarios adicionales solo si la respuesta es 3 o menor
                    if ($DataEncuesta['Respuesta_1'] <= 3) {
                        ?>
                        <tr>
                            <td>Comentario adicional:</td>
                            <td>
                                <?= !empty($DataEncuesta['Comentario_Respuesta1']) ? htmlspecialchars($DataEncuesta['Comentario_Respuesta1']) : 'No hay ningún comentario disponible.' ?>
                            </td>
                        </tr>
                        <?php
                    }
                    
                    // Mostrar los comentarios generales
                    ?>
                    <tr>
                        <td>Comentarios generales:</td>
                        <td>
                            <?= !empty($DataEncuesta['Comentario']) ? htmlspecialchars($DataEncuesta['Comentario']) : 'No hay ningún comentario disponible.' ?>
                        </td>
                    </tr>
                    <?php
                } else {
                    echo "<p>No hay resultados de encuesta para este ticket.</p>";
                }
            ?>
        </tbody>
    </table>


</body>

</html>