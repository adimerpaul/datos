<!DOCTYPE html>

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
							<th align="center" style='width:40px'>MATRICULA</th> 
							<th class='column100 column2' style='width:150px' data-column='column2'><center>NOMBRE</center></th>
							<th class='column100 column2' style='width:150px' data-column='column2'><center>CONCEPTO</center></th>
							<th class='column100 column5' data-column='column4'><center>ENE</center></th>
                            <th class='column100 column6' data-column='column'><center>FEB</center></th>
							<th class='column100 column7' data-column='column'><center>MAR</center></th>
							<th class='column100 column8' data-column='column'><center>ABR</center></th>
							<th class='column100 column9' data-column='column'><center>MAY</center></th>
							<th class='column100 column10' data-column='column'><center>JUN</center></th>
							<th class='column100 column11' data-column='column'><center>JUL</center></th>
							<th class='column100 column12' data-column='column'><center>AGOS</center></th>
							<th class='column100 column13' data-column='column'><center>SEPT</center></th>
							<th class='column100 column14' data-column='column'><center>OCT</center></th>
							<th class='column100 column15' data-column='column'><center>NOV</center></th>
							<th class='column100 column16' data-column='column'><center>DIC</center></th>
							
           					</tr>
							</thead>   
              <tbody>
				

<?php
require('conexion.php');
?>
						                      


<?php

//$sql = "SELECT * FROM empleados WHERE `{$_POST['DATO2']}` LIKE '%{$_POST['DATO1']}%' ORDER BY nombre"; 
//$sql = "SELECT mes, nombre, desc_concepto, tipo, COUNT(desc_concepto) AS total FROM empleados WHERE `{$_POST['DATO2']}` LIKE '%{$_POST['DATO1']}%'  GROUP BY desc_concepto
		//ORDER BY mes"; 
		$sql = "SELECT matricula, nombre, tipo_documento, 
		SUM( CASE WHEN MONTH(fecha_de_incidencia)=1 THEN 1 ELSE 0 END) 'enero',
		SUM( CASE WHEN MONTH(fecha_de_incidencia) = 2 THEN 1 ELSE 0 END)'febrero' ,
		SUM( CASE WHEN MONTH(fecha_de_incidencia) = 3 THEN  1 ELSE 0 END) 'marzo',
		SUM( CASE WHEN MONTH(fecha_de_incidencia) = 4 THEN 1 ELSE 0 END ) 'abril',
		SUM( CASE WHEN MONTH(fecha_de_incidencia) = 5 THEN 1 ELSE 0 END) 'mayo',
		SUM( CASE WHEN MONTH(fecha_de_incidencia) = 6 THEN 1 ELSE 0 END)'junio',
		SUM( CASE WHEN MONTH(fecha_de_incidencia) = 7 THEN 1 ELSE 0 END) 'julio',
		SUM( CASE WHEN MONTH(fecha_de_incidencia) = 8 THEN 1 ELSE 0 END) 'agosto',
		SUM( CASE WHEN MONTH(fecha_de_incidencia) = 9 THEN 1 ELSE 0 END)'septiembre',
		SUM( CASE WHEN MONTH(fecha_de_incidencia) = 10 THEN 1 ELSE 0 END)'octubre',
		SUM( CASE WHEN MONTH(fecha_de_incidencia) = 11 THEN 1 ELSE 0 END)'noviembre',
		SUM( CASE WHEN MONTH(fecha_de_incidencia) = 12 THEN 1 ELSE 0 END)'diciembre' 
		FROM datos_incidencia
		WHERE `{$_POST['DATO2']}` LIKE '%{$_POST['DATO1']}%'
		ORDER BY matricula, nombre,  tipo_documento"; 



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
<td> <center><?php echo $crow['nombre']; ?>  </center> </td>
<td> <center><?php echo $crow['tipo_documento']; ?>  </center> </td>
<td> <center><?php echo $crow['enero']; ?></center></td>
<td> <center><?php echo $crow['febrero']; ?></center></td>
<td> <center><?php echo $crow['marzo']; ?></center></td>
<td> <center><?php echo $crow['abril']; ?></center></td>
<td> <center><?php echo $crow['mayo']; ?></center></td>
<td> <center><?php echo $crow['junio']; ?></center></td>
<td> <center><?php echo $crow['julio']; ?></center></td>
<td> <center><?php echo $crow['agosto']; ?></center></td>
<td> <center><?php echo $crow['septiembre']; ?></center></td>
<td> <center><?php echo $crow['octubre']; ?></center></td>
<td> <center><?php echo $crow['noviembre']; ?></center></td>
<td> <center><?php echo $crow['diciembre']; ?></center></td>


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