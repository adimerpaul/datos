<?php
/*
* Script: Cargar datos de lado del servidor con PHP y MySQL
* Autor: Marco Robles
* Team: Códigos de Programación
*/


include 'config.php';

/* Un arreglo de las columnas a mostrar en la tabla */
$columns = ['id_trabajador','cve_ads', 'nom_ads', 'localidad', 'desc_contratacion','matricula','ocupante','cve_ctg', 'desc_categoria','plaza', 'desc_plaza','desc_marca_ocupacion',
            'fecha_ocupacion','desc_horario','ant_anos','ant_qnas','salario_mens', 'rfc','curp','numafil','micro'];

/* Nombre de la tabla */
$table = "empleados";

$campo = isset($_POST['campo']) ? $mysqli->real_escape_string($_POST['campo']) : null;


/* Filtrado */
$where = '';

if ($campo != null) {
    $where = "WHERE (";

    $cont = count($columns);
    for ($i = 0; $i < $cont; $i++) {
        $where .= $columns[$i] . " LIKE '%" . $campo . "%' OR ";
    }
    $where = substr_replace($where, "", -3);
    $where .= ")";
}


/* Consulta */
$sql = "SELECT " . implode(", ", $columns) . "
FROM $table
$where ";
$resultado = $mysqli->query($sql);
$num_rows = $resultado->num_rows;


/* Mostrado resultados */
$html = '';

if ($num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        $html .= '<tr>';
        $html .= '<td>' . $row['id_trabajador'] . '</td>';
        $html .= '<td>' . $row['cve_ads'] . '</td>';
        $html .= '<td>' . $row['nom_ads'] . '</td>';
        $html .= '<td>' . $row['localidad'] . '</td>';
        $html .= '<td>' . $row['desc_contratacion'] . '</td>';
        $html .= '<td>' . $row['matricula'] . '</td>';
        $html .= '<td>' . $row['ocupante'] . '</td>';
        $html .= '<td>' . $row['cve_ctg'] . '</td>';
        $html .= '<td>' . $row['desc_categoria'] . '</td>';
        $html .= '<td>' . $row['plaza'] . '</td>';
        $html .= '<td>' . $row['desc_plaza'] . '</td>';
        $html .= '<td>' . $row['desc_marca_ocupacion'] . '</td>';
        $html .= '<td>' . $row['fecha_ocupacion'] . '</td>';
        $html .= '<td>' . $row['desc_horario'] . '</td>';
        $html .= '<td>' . $row['ant_anos'] . '</td>';
        $html .= '<td>' . $row['ant_qnas'] . '</td>';
        $html .= '<td>' . $row['salario_mens'] . '</td>';
        $html .= '<td>' . $row['rfc'] . '</td>';
        $html .= '<td>' . $row['curp'] . '</td>';
        $html .= '<td>' . $row['numafil'] . '</td>';
        $html .= '<td>' . $row['micro'] . '</td>';
      
        $html .= '</tr>';
    }
} else {
    $html .= '<tr>';
    $html .= '<td colspan="7">Sin resultados</td>';
    $html .= '</tr>';
}

echo json_encode($html, JSON_UNESCAPED_UNICODE);
