<?php
include 'conexion.php';



$query ="SELECT ine_nombre,ine_binario,ine_tipo,ine_peso,comp_domicilio_nombre  FROM datos WHERE id='".$_GET['id']."'";
$resul = $con->query($query) or die(mysql_error());


if ($row = $resul->fetch_array()) {
$contenido = $row['ine_binario'];
$binario_comp_domicilio=$row['comp_domicilio_nombre'];
$tipo = $row['ine_tipo'];
}
 
header("Content-type: $tipo");
header("Content-type: application/pdf");

echo $contenido;
?>