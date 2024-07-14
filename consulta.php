<?php
include('conexion.php');

$consulta="select * from principal where matricula='".$_GET['matricula']."'";
$resultado = mysqli_query($con, $consulta);
$numeroSql = mysqli_num_rows($resultado);


if (mysqli_num_rows($resultado) == 1) 
{ 

//echo '<script language="javascript">alert("Registro correcto, continua con el proceso de incidencia");</script>';
echo '<script language="javascript">alert("Registro correcto, continua con el proceso de incidencia");window.location.href="home.php"</script>';

}

if (mysqli_num_rows($resultado) == 0) 
{ 
  //  echo "No existe registro en la base de datos."; 

echo '<script language="javascript">alert("No existe registro en la base de datos.");window.location.href="home.php"</script>';

}



?>

