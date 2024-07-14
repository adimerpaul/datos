<?php

$conexion = mysqli_connect("localhost", "root", "", "datos_personales");
mysqli_set_charset($conexion, "utf8");

$el_mun = $_POST['municipio'];

$query = $conexion->query("SELECT id_mun,id_estado,municipio FROM cat_municipios WHERE id_estado = $el_mun");

while ($row = $query->fetch_assoc()) {
    echo '<option value="' . $row['id_mun'] . '">' . $row['municipio'] . '</option>' . "\n";
}

?>


