
<form class="formulario col-lg-4" action="ver.php" method="GET">
<div class="row">
<div class="col-lg-12">
<h3><i class="fas fa-car"></i> VISUALIZAR IMAGEN</h3> <p><p>
</div>
 
<?php
$mysqli = new mysqli('localhost', 'root', '', 'datos_personales');
?>
 
<div class="col-sm-5 col-lg-6">
<label><h5><i class="fas fa-image"></i> Imagenes : </h5></label> <br><br>
</div>
<div class="col-sm-5 col-lg-6">
 
<select class="form-control" name="id" required>
<option value="">Seleccione:</option>
<?php
$query = $mysqli -> query ("SELECT ine_nombre FROM datos");
while ($valores = mysqli_fetch_array($query)) {
 
echo '<option value="'.$valores['id'].'">'.$valores['ine_nombre'].'</option>';
echo '<option value="'.$valores['id'].'">'.$valores['comp_domicilio_nombre'].'</option>';
}
?>
</select>
 
</div>
 
 
</div>
 
<div class="btn col-lg-12">
 
<button class="btn btn-info" type="submit" value="Enviar formulario" target="_blank"><i class="fas fa-check-circle"></i> Ver</button><p>
</div>
</form>