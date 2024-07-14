<?php

include_once('conexion.php');



// Array para almacenar los empid con carpeta generada y sus datos
$archivosEncontrados = array();

// Consulta SQL para obtener empid únicos en la tabla "employee"
$query = mysqli_query($con, "SELECT id, matricula, nombre, email_institucional, adscripcion FROM datos
                                WHERE fecha_modificacion >= '2023-09-01 00:00:00'");

// Iterar por los empid para verificar si tienen la carpeta generada
while ($row = mysqli_fetch_assoc($query)) {
    $id = $row['id'];
    $matricula = $row['matricula'];
    $nombre = $row['nombre'];
    $email_institucional = $row['email_institucional'];
    $adscripcion = $row['adscripcion'];


    $path = "files/" . $id;
 
    // Escanea el directorio y verifica si solo hay 2 elementos (., ..)
    if (is_dir($path)) {
        // Escanea el directorio y verifica si solo hay 2 elementos (., ..)
        $files = scandir($path);
        if (count($files) === 2) {
            echo "Directorio: $path, Archivos: " . implode(', ', $files) . "<br>";
            // La carpeta está vacía, agrega el registro a la lista de archivos no encontrados.
            $archivosEncontrados[] = array(
                'id' => $id,
                'matricula' => $matricula,
                'nombre' => $nombre,
                'email_institucional' => $email_institucional,
                'adscripcion' => $adscripcion
            );
        }
    }
}


// Set the response headers to force a download
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="carpeta_files_vacia_datos_personales.xls"');
header('Cache-Control: max-age=0');

// Create the Excel file content manually
echo "id,Matricula,Nombre,email_institucional,adscripcion\n";

foreach ($archivosEncontrados as $data) {
    echo "{$data['id']},{$data['matricula']},{$data['nombre']},{$data['email_institucional']},{$data['adscripcion']}\n";

}

// Exit to prevent any other output in the response
exit;
?>