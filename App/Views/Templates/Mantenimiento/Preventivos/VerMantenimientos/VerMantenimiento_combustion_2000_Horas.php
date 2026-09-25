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

include "VerMantenimiento_combustion_2000_Horas_solo.php";

$html = ob_get_clean();

// Cargar el HTML en Dompdf
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("formato_mantenimientoPreventivo_".date("d")."_".date("m")."_".date("Y").".pdf", ["Attachment" => false]);
?>