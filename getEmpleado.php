<?php 
	$seudonimo = $_GET['empleado'];
	$connection = mysql_connect("localhost", "root", "");
	mysql_select_db("ligamx", $connection);
	mysql_set_charset("utf8");
	$sql = "SELECT * FROM principal WHERE matricula LIKE '$matricula' LIMIT 1";
	$result = mysql_query($sql, $connection);
	if (mysql_num_rows($result) > 0) {
		$equipo = mysql_fetch_object($result);
		$equipo->status = 200;
		echo json_encode($empleado);
	}else{
		$error = array('status' => 400);
		echo json_encode((object)$error);
	}

?>
