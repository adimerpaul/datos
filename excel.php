<?php

header("Content-Type: application/xls");
header("Content-Disposition: attachment; filename=reporte.xls");


?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Reporte de Incidencias</title>
	<style>
      		body {
      		padding-top: 20px;
      		padding-bottom: 20px;
      			}
  		</style>



</head>
<body>
<style>
			#tabla{
				padding-top: 20px;
      			padding-bottom: 20px;
			}

			#tabla tr td, #tabla tr th{
				border: solid white 1px;
			}
			
			#tabla tr:nth-child(odd)
			{ 
				background-color: #eee;
			}
			#tabla tr:nth-child(even)
			{ 
				background-color: #fff;
			}

			
			#tabla tr.filaBlanca{
				border: solid white 1px !important; background-color: white; color: #000;
				text-align: center;	
			}

			#tabla tr.filaBlanca td{
				border: solid white 1px !important; background-color: white; color: #000;	
				text-align: center;
			}

			#tabla tr.filaBlanca td.firma{
				border-top: solid black 2px !important;
			}

		</style>
		
		<table id="tabla">
			<tr style="padding:10px; background-color:white;">
				<br> 
				<tr>
				<th colspan="5">
			<td><img src="http://11.254.27.174:8080/datos_personales/imss.png" class="alinear-izquierda"  alt="" height="5px"/></td>
			

				</th>
				</tr>
			

				<th colspan="4">
					Dirección Jurídica
					<br>
					Coordinación Administrativa
				</th>
				
						
				<th colspan="5">
				<td><img src="http://11.254.27.174:8080/datos_personales/fcov.jpg" class="alinear-derecha"  alt="" height="5px"/></td>
			

				</th>
		       
			


				<th colspan="4">
				<?php echo date("Y-m-d");?>
				</th>
			</tr>

			<tr style="background-color:#948A54; padding:10px;"
				<th colspan="14" style="text-align: center; color: #fff;">
					RELACIÓN DE DATOS PERSONALES
				</th>
			</tr>
			<tr style="background-color:white; padding:10px;">
				<th colspan="13">
					<br>
				</th>
			</tr>
			<tr style="background-color:#4F6228; color:white; padding:10px;">

	<th>No.</th>		
	<th>Nombre</th>
	<th>Categoria</th>
	<th>Matricula</th>
	<th>Email_Particular</th>
	<th>Email_Institucional</th>
	<th>Escolaridad</th>
	<th>Estado_Civil</th>
	<th>Pais</th>
	<th>Adscripcion</th>
	<th>Turno</th>
	<th>Calle</th>
	<th>Numero_exterior</th>
	<th>Numero_interior</th>
	<th>Colonia</th>
	<th>Municipio</th>
	<th>Estado</th>
	<th>Ciudad</th>
	<th>Poblacion</th>
	<th>Codigo_Postal</th>
	<th>Telefono</th>
	<th>UMF</th>
	<th>Consultorio</th>
	<th>En Caso de Accidente</th>
	<th>Parentesco</th>
	<th>Telefono en caso de accidente</th>


<?php

include('conexion.php');//CONEXION A LA BD



$sql= $con->query("SELECT nombre, categoria, matricula,email_particular, email_institucional, escolaridad,estado_civil,
pais, adscripcion, turno, calle, numero_ext, numero_int, colonia, municipio, estado, ciudad, poblacion, codigo_postal,
telefono, umf, num_consultorio, nombre_caso_accidente, parentesco, telefono_caso_accidente, fecha_de_alta
 FROM DATOS
WHERE  fecha_de_alta BETWEEN '{$_POST['fecha_de_busqueda']}'  and  '{$_POST['fecha_de_busqueda2']}' 
order by nombre, fecha_de_alta asc");

$consecutivo = 0;
while ($row =$sql->fetch_array()){
    //echo $row['matricula']."<br>".$row['folio']."<br>".$row['ocupante']."<br> ".$row['nombre_completo']."<br>";
$consecutivo=$consecutivo+1;

?>


	</tr>
	<td><?php echo $consecutivo?></td>
	<td><?php echo $row[0]?></td>
	<td><?php echo $row[1]?></td>
	<td><?php echo $row[2]?></td>
	<td><?php echo $row[3]?></td>
	<td><?php echo $row[4]?></td>
	<td><?php echo $row[5]?></td>
	<td><?php echo $row[6]?></td>
	<td><?php echo $row[7]?></td>
	<td><?php echo $row[8]?></td>
	<td><?php echo $row[9]?></td>
	<td><?php echo $row[10]?></td>
	<td><?php echo $row[11]?></td>
	<td><?php echo $row[12]?></td>
	<td><?php echo $row[13]?></td>
	<td><?php echo $row[14]?></td>
	<td><?php echo $row[15]?></td>
	<td><?php echo $row[16]?></td>
	<td><?php echo $row[17]?></td>
	<td><?php echo $row[18]?></td>
	<td><?php echo $row[19]?></td>
	<td><?php echo $row[20]?></td>
	<td><?php echo $row[21]?></td>
	<td><?php echo $row[22]?></td>
	<td><?php echo $row[23]?></td>
	<td><?php echo $row[24]?></td>

	
  

<?php
}
?>






</table>









</body>
</html>
