<html>
   
	<head>
    
	<link rel="stylesheet" type="text/css" href="total/css_table/main.css">
    <style>
	.content {
  	max-width: auto;
  	margin: auto;
			 }


	</style>
           
	</head>   

<center>
		<body style = "margin-top:0; background-color:powderblue">
	
        <div class="content"> 
		<div class="container">
        <div class='wrap-table100'>  
        <div class='table100 ver1 m-b-110'>    
        <table data-vertable='ver1'>
          					<br>
              				<h2 >INFORME DE ASISTENCIA, PUNTUALIDAD Y SUSTITUCIONES</h2>
          					<br>
                        	<thead>
							<tr class='row100 head'>
							<th align="center" style='width:50px'>Matricula</th> 
							<th class='column100 column2' data-column='column2'><center>Folio</center></th>
							<th class='column100 column3' data-column='column3'><center>Nombre</center></th>
							<th class='column100 column4' data-column='column4'><center>Asunto</center></th>
                            <th class='column100 column5' data-column='column5'><center>Horario</center></th>
							<th class='column100 column5' data-column='column5'><center>Tipo de Documento</center></th>
							<th class='column100 column5' data-column='column5'><center>Micro</center></th>
							<th class='column100 column5' data-column='column5'><center>Fecha_de_incidencia</center></th>
							<th class='column100 column5' data-column='column5'><center>Adscripcion</center></th>
							<th class='column100 column5' data-column='column5'><center>Usuario de captura</center></th>
							
           					</tr>
							</thead>   
              <tbody>
				

<?php
include('conexion.php');
?>



<?php

$sql ="SELECT a.matricula, a.folio,a.nombre,a.asunto, a.horario, a.tipo_documento, a.micro, 
a.fecha_de_incidencia, a.adscripcion, b.fullname AS usuario_de_captura FROM datos_incidencia a
INNER JOIN USER b ON a.username= b.id
ORDER BY a.matricula";
$result = mysqli_query($con, $sql);
$numeroSql = mysqli_num_rows($result);
?>

<p style="font-weight: bold; color:purple;"><i class="mdi mdi-file-document"></i> <?php echo $numeroSql; ?> Resultados encontrados</p>
<?php
while($crow = mysqli_fetch_assoc($result))
            			{	
?>

<tr class='row100'>
<td style='width:10px'><center> <?php echo $crow['matricula'];?> </center></td>
<td> <center><?php echo $crow['folio']; ?>  </center> </td>
<td> <center><?php echo $crow['nombre']; ?></center></td>
<td> <center><?php echo $crow['asunto']; ?></center></td>
<td> <center><?php echo $crow['horario']; ?></center></td>
<td> <center><?php echo $crow['tipo_documento']; ?></center></td>
<td> <center><?php echo $crow['micro']; ?></center></td>
<td> <center><?php echo $crow['fecha_de_incidencia']; ?></center></td>
<td> <center><?php echo $crow['adscripcion']; ?></center></td>
<td> <center><?php echo $crow['usuario_de_captura']; ?></center></td>


</tr>
<?php
  	    	}		
?>

          	</tbody>
	    	</table>             
			
	</div>

	</div>
	<div>
	</div>
	</div>
	</div>
	
  </body>
  
  	</center>
	</html>