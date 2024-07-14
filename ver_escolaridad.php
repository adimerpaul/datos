<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Construye la ruta completa al archivo PDF
    $pdfFilePath = 'files/' . $id . '/escolaridad.pdf'; // Cambia 'ine.pdf' por el nombre real del archivo

    if (file_exists($pdfFilePath)) {
        header('Content-type: application/pdf');
        header('Content-Disposition: inline; filename="escolaridad.pdf"'); // Cambia el nombre del archivo según lo que desees mostrar al usuario

        readfile($pdfFilePath);
        exit;
    } else {
        echo "El archivo no existe.";
    }
} else {
    echo "ID de registro no proporcionado.";
}
?>
