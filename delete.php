<?php

include("conexion.php");
//$con=conectar();

$id=$_GET['id'];

$sql="DELETE FROM datos WHERE id='$id'";


$query=mysqli_query($con,$sql);


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="row" style="text-align:center">
					<?php if($sql) { ?>
						<h3>REGISTRO ELIMINADO</h3>
						<?php } else { ?>
						<h3>ERROR AL INTENTAR ELIMINAR CONSULTE AL ADMINISTRADOR</h3>
					<?php } ?>
					
					<a href="reporte.php" class="btn btn-primary">Regresar</a>
					
				</div>

    
</body>
</html>