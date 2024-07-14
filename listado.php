<?php

include_once('conexion.php');



// Array para almacenar los empid con carpeta generada y sus datos
$archivosEncontrados = array();

// Consulta SQL para obtener empid únicos en la tabla "employee"
$query = mysqli_query($con, "SELECT id, matricula, nombre, email_institucional, adscripcion, fecha_de_alta, fecha_modificacion FROM datos
                                WHERE fecha_modificacion >= '2023-09-01 00:00:00'");

// Iterar por los empid para verificar si tienen la carpeta generada
while ($row = mysqli_fetch_assoc($query)) {
    $id = $row['id'];
    $matricula = $row['matricula'];
    $nombre = $row['nombre'];
    $email_institucional = $row['email_institucional'];
    $adscripcion = $row['adscripcion'];
    $fecha_de_alta = $row['fecha_de_alta'];
    $fecha_modificacion = $row['fecha_modificacion'];


    $path = "files/" . $id;
 

    if (!is_dir($path) || count(glob("$path/*.pdf")) === 0) {
        // No se encontraron archivos PDF en la carpeta o la carpeta no existe.
        // Agrega el registro a la lista de archivos no encontrados.
        $archivosEncontrados[] = array(
            'id' => $id,
            'matricula' => $matricula,
            'nombre' => $nombre,
            'email_institucional' => $email_institucional,
            'adscripcion' => $adscripcion,
            'fecha_de_alta' => $fecha_de_alta,
            'fecha_modificacion' => $fecha_modificacion
        );
    }
    
}

// Set the response headers to force a download
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="personal_falta_documento_datos_personales.xls"');
header('Cache-Control: max-age=0');

// Create the Excel file content manually
echo "id,Matricula,Nombre,email_institucional,adscripcion,fecha_de_alta, fecha_modificacion\n";

foreach ($archivosEncontrados as $data) {
    echo "{$data['id']},{$data['matricula']},{$data['nombre']},{$data['email_institucional']},{$data['adscripcion']},{$data['fecha_de_alta']},{$data['fecha_modificacion']}\n";

}

// Exit to prevent any other output in the response
exit;
?>