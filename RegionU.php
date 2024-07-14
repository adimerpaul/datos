<?php
include('conexion.php');

$idregion = $_GET['idregion'];

$sql = "SELECT id_region, id_estado, region 
        FROM cat_regiones
        WHERE id_estado = $idregion";

$result = mysqli_query($conexion, $sql);
?>

<label for="regionesIdU">Selecciona Región</label>
<select id="regionesIdU" name="regionesIdU" class="form-control">
    <?php
    while ($ver = mysqli_fetch_array($result)) :
        if ($ver['id_region'] == $idregion) {
    ?>
            <option selected value="<?php echo $ver['id_region']; ?>"><?php echo $ver['region']; ?></option>
        <?php
        } else {
        ?>
            <option value="<?php echo $ver['id_region']; ?>"><?php echo $ver['region']; ?></option>
        <?php
        }
    endwhile;
    ?>
</select>
