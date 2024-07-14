<?php
$conexion = mysqli_connect("localhost", "root", "", "datos_personales");
mysqli_set_charset($conexion, "utf8");

$query = $conexion->query("SELECT id_estado, estado FROM cat_estados");
?>

<!-- Agregar el select en tu formulario HTML -->
<select name="estado">
    <?php
    $selected = ''; // Variable para controlar la opción seleccionada

    // Verificar si se ha enviado un valor para el estado
    if (isset($_POST['estado'])) {
        $selected = $_POST['estado']; // Establecer la opción seleccionada
    }
    ?>

    <option value="" <?php echo $selected == '' ? 'selected' : ''; ?> disabled>Seleccione estado</option>
    
    <?php
    while ($row = $query->fetch_assoc()) {
        $estadoId = $row['id_estado'];
        $estadoNombre = $row['estado'];

        // Verificar si este estado está seleccionado
        $isSelected = $selected == $estadoId ? 'selected' : '';

        echo '<option value="' . $estadoId . '" ' . $isSelected . '>' . $estadoNombre . '</option>' . "\n";
    }
    ?>
</select>