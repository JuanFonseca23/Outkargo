<?php
// Crear el HTML
require "vendor/autoload.php";
use Dompdf\Dompdf;
use Dompdf\Options;

// Configurar las opciones de Dompdf
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);

// Crear una instancia de Dompdf
$dompdf = new Dompdf($options);
ob_start(); // Iniciar el almacenamiento en búfer de salida

include "Diseño.php";

$html = ob_get_clean();
// Cargar el HTML en Dompdf
$dompdf->loadHtml($html);

// Establecer el tamaño de papel personalizado
$dompdf->setPaper([0, 0, 55, 85], 'mm'); // Ancho y largo en milímetros


// Renderizar el PDF
$dompdf->render();



// Enviar el PDF al navegador
$dompdf->stream('carnet.pdf', ['Attachment' => false]);
?>
