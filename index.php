<?php
require 'vendor/autoload.php';
use Dompdf\Dompdf;
$html = "<h1>hola</h1>";
$dompdf = new Dompdf();

// Cargar el contenido HTML en Dompdf
$dompdf->loadHtml($html);

// Configurar el tamaño de papel y la orientación
$dompdf->setPaper('A4', 'portrait'); // Opciones: 'portrait' o 'landscape'

// Renderizar el contenido como PDF
$dompdf->render();

// Enviar el PDF al navegador para su descarga
$dompdf->stream("reporte.pdf", ["Attachment" => false]);
?>