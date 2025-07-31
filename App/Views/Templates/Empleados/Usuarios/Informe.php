<?php
require 'vendor/autoload.php'; // Cargar el autoload de Composer si usas Composer

use Dompdf\Dompdf;
use Dompdf\Options;

// Crear una nueva instancia de Dompdf
$options = new Options();
$options->set('defaultFont', 'Arial');
$options->set('isHtml5ParserEnabled', true);
$options->set('isPhpEnabled', true);
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);


// Crear el contenido HTML para el PDF
ob_start(); // Iniciar el almacenamiento en búfer de salida

include "InformeActivos.php";

$html = ob_get_clean();
// Cargar el contenido HTML en Dompdf
$dompdf->loadHtml($html);

// Configurar el tamaño y la orientación del papel
$dompdf->setPaper('letter', 'portrait');

// Renderizar el HTML como PDF
$dompdf->render();

// Enviar el PDF al navegador para su descarga
$dompdf->stream("Exportacion_Usuarios_Activos_" . date('Ymd') . ".pdf", array("Attachment" => 1));
?>
