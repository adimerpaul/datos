<?php
require_once 'libreria/dompdf/autoload.inc.php';

use Dompdf\Dompdf;

// Obtener el contenido del formulario HTML
$html = file_get_contents('http://localhost:84/datos_personales/formulario.php');

// Crear una instancia de Dompdf
$dompdf = new Dompdf();

// Cargar el contenido HTML en Dompdf
$dompdf->loadHtml($html);

// Renderizar el documento HTML como PDF
$dompdf->render();

// Guardar el PDF en un archivo
$output = $dompdf->output();
file_put_contents('ruta_al_archivo.pdf', $output);
?>