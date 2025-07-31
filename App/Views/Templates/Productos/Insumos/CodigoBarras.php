<?php
// Crear el HTML
require "vendor/autoload.php";
use Dompdf\Dompdf;
use Dompdf\Options;

// Configurar las opciones de Dompdf
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);


$dompdf = new Dompdf($options);
ob_start(); 

include "Diseño.php";

$html = ob_get_clean();

$dompdf->loadHtml($html);

$dompdf->setPaper([0, 0, 350, 103],'portrait');

$dompdf->render();

$dompdf->stream('CodigoBarra.pdf', ['Attachment' => false]);
?>

