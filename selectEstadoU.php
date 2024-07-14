<?php 
	include('conexion.php');

	$id_estado = $_GET['id_estado'];

	$sql = "SELECT id_estado,
					estado 
			FROM cat_estados 
			where id_estado=$id_estado
			ORDER BY estado";
	$result = mysqli_query($con, $sql);
 ?>
 	<label for="edo_nacU">Selecciona un estado</label>
 	<select id="edo_nacU" name="edo_nacU" class="form-control">
 	<?php 
 		while($ver = mysqli_fetch_row($result)): 
 			if ($ver[0] == $id_estado) {
 	?>
 			<option selected="" value="<?php echo $ver[0] ?>"><?php echo $ver[1]; ?></option>
 	<?php  
 			} else {
 	?>
 			<option value="<?php echo $ver[0] ?>"><?php echo $ver[1]; ?></option>
 	<?php  
 			}
 	?>	
 	<?php endwhile; ?>
 	</select>