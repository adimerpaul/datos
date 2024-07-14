<?php
ob_start();
require "../formulario.php";
$html = ob_get_clean();

// Leer el contenido de los archivos CSS
$css_main = file_get_contents('https://framework-gb.cdn.gob.mx/assets/styles/main.css');

// URL del logo del IMSS
$logo_url = 'https://1000marcas.net/wp-content/uploads/2022/01/IMSS-Logo.png';



// Ruta y nombre de archivo de la imagen del logo descargada en tu servidor
$logo_path = 'http://localhost:84/datos_personales/img/IMSS-Logo.png';


// Descargar la imagen del logo desde la URL remota
file_put_contents($logo_path, file_get_contents($logo_url));

// Actualizar la URL del logo para que apunte a la ubicación local
$logo_url = $logo_path;

// Enlazar los estilos CSS en el contenido HTML
$html = '
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Formato</title>
  <style>
    ' . $css_main . '
    #contenedorFormato_1 {
      margin-top: 5px;
      margin-bottom: 50px;
      padding-top: 20px;
      border: solid #000 2px !important;
    }

    #logoIMSS {
      width: 80px;
    }

    .flexbox-container {
      display: flex;
      flex-wrap: nowrap;
      justify-content: center;
      align-items: center;
      align-content: center;
    }

    .flexbox-container input,
    .inputFormulario {
      width: 110%;
      border: none;
      border-bottom: solid black 1px;
      margin-left: 5px;
    }

    @media print {
      /*  reglas CSS específicas para imprimir */
      * {
        font-size: 5pt;
      }

      #logoIMSS {
        width: 10cm;
      }

      h4 {
        font-size: 14pt;
      }

      .main-footer,
      header {
        visibility: hidden;
      }

      #contenedorFormato_1 {
        margin-top: 0cm !important;
        margin-bottom: 0cm !important;
        top: 0cm !important;
      }

      .page {
        top: 0cm !important;
      }

      @page {
        margin: 2cm;
        margin-top: 0cm;
        padding-top: 0cm;
        margin-left: 20cm;
        margin-right: 20cm;
      }
    }

    small {
      font-size: 0.8em;
    }
  </style>
</head>
<body>
<div id="contenedorFormato_1">
  <div class="flexbox-container">
    <img id="logoIMSS" src="' . $logo_url . '" alt="Logo IMSS">
  </div>
  ' . $html . '
</div>
</body>
</html>
';

// Incluir la biblioteca Dompdf
require_once 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;

// Crear una instancia de Dompdf
$dompdf = new Dompdf();

// Cargar el contenido HTML
$dompdf->loadHtml($html);

// (Opcional) Configurar el tamaño de papel y la orientación
$dompdf->setPaper('A4', 'portrait');

// Renderizar el HTML como PDF
$dompdf->render();

// Obtener el PDF generado
$output = $dompdf->output();

// Guardar el PDF en un archivo (opcional)
// file_put_contents('ruta/del/archivo.pdf', $output);

// Enviar el PDF al navegador para su descarga
header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="Formato_IMSS.pdf"');
header('Content-Length: ' . strlen($output));
header('Accept-Ranges: bytes');
echo $output;
?>
