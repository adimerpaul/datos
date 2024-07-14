<?php
// Realiza la conexión a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "datos_personales");
$query = "SELECT * FROM cat_categorias order by desc_categoria asc ";
$result = mysqli_query($conexion, $query);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<option value="' . $row['id_ctg'] . '">' . $row['desc_categoria'] . '</option>';
    }
}
?>






