<?php
	include("bd/abrir_conexion.php");
	 
	 	if(isset($_POST['buscar']))
    { 
    	$matricula = $_POST['matricula'];
    	$valores = array();
    	$valores['existe'] = "0";

    	//CONSULTAR
		  $resultados = mysqli_query($conexion,"SELECT * FROM $tabla_db1 WHERE matricula = '$matricula'");
		  while($consulta = mysqli_fetch_array($resultados))
		  {
		  	$valores['existe'] = "1"; //Esta variable no la usamos en el vídeo (se me olvido, lo siento xD). Aqui la uso en la linea 97 de registro.php
		  	$valores['ocupante'] = $consulta['ocupante'];
		  	$valores['desc_categoria'] = $consulta['desc_categoria'];
		  	$valores['nom_ads'] = $consulta['nom_ads'];		    
		  }
		  sleep(1);
		  $valores = json_encode($valores);
			echo $valores;
    }

    if(isset($_POST['guardar']))
    { 
    	$matricula = $_POST['matricula'];
    	$nombre = $_POST['nombre'];
    	$categoria = $_POST['categoria'];
    	$adscripcion = $_POST['adscripcion'];
    	$existe = "0";

    	//CONSULTAR
		  $resultados = mysqli_query($conexion,"SELECT * FROM $tabla_db1 WHERE matricula = '$matricula'");
		  while($consulta = mysqli_fetch_array($resultados))
		  {
		    $existe = "1";
		  }

		  if($existe=="1")
		  {
		  	//actualizar
		  	  $_UPDATE_SQL="UPDATE $tabla_db2 Set 
				  ocupante='$nombre'
				  WHERE matricula='$matricula'"; 
				  mysqli_query($conexion,$_UPDATE_SQL); 
				  echo "<b>Dato Actualizado</b>";
		  }
		  else
		  {
		  	//crear uno nuevo
		  	mysqli_query($conexion, "INSERT INTO $tabla_db2 
			  (matricula,ocupante) 
			    values 
			  ('$matricula','$nombre')");
			  echo "Empleado Agregado";
		  }

    }
	
  include("bd/cerrar_conexion.php");
?>

