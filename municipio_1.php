<?php

$conexion = mysqli_connect("localhost","root","","datos_personales");

$el_mun_1 = $_POST['municipio'];

$query = $conexion->query("SELECT * FROM cat_municipios WHERE id_estado = $el_mun_1");


while ( $row = $query->fetch_assoc() )
{
	echo '<option value="' . $row['id_mun']. '">' . $row['municipio'] . '</option>' . "\n";
}

?>