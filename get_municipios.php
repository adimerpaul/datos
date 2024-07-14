<?php
// Conexión a la base de datos
$con = new mysqli("localhost", "root", "", "datos_personales");

// Verificar la conexión
if ($con->connect_error) {
    die("Error de conexión: " . $con->connect_error);
}

// Verificar si se recibió el ID del estado
if (isset($_POST['estado_id'])) {
    $estado_id = $_POST['estado_id'];

    // Consulta para obtener los municipios correspondientes al estado proporcionado
    $sql = "SELECT id_mun, municipio FROM cat_municipios WHERE id_estado = $estado_id";
    $result = $con->query($sql);

    // Verificar si se encontraron municipios
    if ($result->num_rows > 0) {
        // Construir opciones de selección para los municipios
        $options = "<option value='0'>Selecciona Ciudad</option>";
        while ($row = $result->fetch_assoc()) {
            $options .= "<option value='" . $row['id_mun'] . "'>" . $row['municipio'] . "</option>";
        }
        // Devolver las opciones de municipios
        echo $options;
    } else {
        // Si no se encontraron municipios, devolver un mensaje o una opción vacía
        echo "<option value='0'>No se encontraron municipios</option>";
    }
} else {
    // Si no se recibió el ID del estado, devolver un mensaje de error o una opción vacía
    echo "<option value='0'>Error: No se proporcionó el ID del estado</option>";
}

// Cerrar la conexión a la base de datos
$con->close();
?>
