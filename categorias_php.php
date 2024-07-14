<?php
	include("conexion.php");
	
	 
     if(isset($_POST['buscar'])) { 
    	$matricula = $_POST['matricula'];
    	$valores = array();
    	$valores['existe'] = "0";

    	// CONSULTAR
		$resultados = mysqli_query($conexion, "SELECT * FROM datos WHERE matricula = '$matricula'");
		while($consulta = mysqli_fetch_array($resultados)) {
		  	$valores['existe'] = "1"; 
		  	$valores['categoria'] = $consulta['categoria']; // Agregar la categoría a los valores
		}

		sleep(1);
		$valores = json_encode($valores);
		echo $valores;
	}

?>

