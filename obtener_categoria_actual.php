<?php
include("conexion.php");
session_start();

if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id']['id'])) {
    // La variable $_SESSION['user_id'] no es válida
    print "<script>alert(\"ID de usuario no válido\");</script>";
    exit();
}

$user_id = $_SESSION['user_id']['id'];

// Realiza la consulta para obtener la categoría actual
$query = "SELECT categoria FROM datos WHERE user_id = '$user_id'";
$result = mysqli_query($con, $query);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    echo $row['categoria'];
} else {
    echo "0"; // Si no se encuentra una categoría actual, puedes devolver un valor por defecto
}
?>