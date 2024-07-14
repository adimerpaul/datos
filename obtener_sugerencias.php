<?php
// obtener_sugerencias.php
include("conexion.php");

if (isset($_POST['input'])) {
    $input = $_POST['input'];

    // Realiza una consulta a la base de datos para obtener las sugerencias
    // Por ejemplo, puedes utilizar un LIKE en tu consulta para buscar coincidencias
    $query = "SELECT municipio FROM cat_municipios WHERE municipio LIKE ? LIMIT 5";
    $stmt = $con->prepare($query);
    $search_input = $input . '%'; // Agrega el símbolo % para buscar coincidencias al principio
    $stmt->bind_param("s", $search_input);
    $stmt->execute();
    $stmt->bind_result($municipio);

    // Muestra las sugerencias clicables
    while ($stmt->fetch()) {
        echo '<div class="suggestion" onclick="selectSuggestion(\'' . $municipio . '\')">' . $municipio . '</div>';
    }

    $stmt->close();
}
?>
