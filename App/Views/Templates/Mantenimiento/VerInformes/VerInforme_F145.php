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
ob_start(); // Iniciar el almacenamiento en búfer de mantenimiento

include "VerInforme_F145_solo.php";

$html = ob_get_clean();

// Cargar el HTML en Dompdf
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream("Informe_F-145_".date("d")."_".date("m")."_".date("Y").".pdf", ["Attachment" => false]);
?>