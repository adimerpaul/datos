<?php

$conexion = mysqli_connect("localhost","root","","datos_personales");

$query = $conexion->query("SELECT * FROM cat_estados");


while ( $row = $query->fetch_assoc() )
{
	echo '<option value="' . $row['id_estado']. '">' . $row['estado'] . '</option>' . "\n";
}

?>
