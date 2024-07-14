<?php

include("conexion.php");

$id = $_POST['id'];

// Agrega la fecha actual en el formato DATETIME
$fecha_modificacion = date("Y-m-d H:i:s");

// Recopila los datos del formulario
$matricula = $_POST['matricula'];
$nombre = $_POST['nombre'];
$categoria = $_POST['categoria'];
$mail_particular = $_POST['mail_particular'];
$mail_institucional = $_POST['mail_institucional'];
$escolaridad = $_POST['escolaridad'];
$area_escolar = $_POST['area_escolar'];
$edo_civil = $_POST['edo_civil'];
$pais_nac = $_POST['pais_nac'];
$edo_nac = $_POST['edo_nac'];
$municipio = $_POST['municipio']; //ciudad en la bd
$adscripcion = $_POST['adscripcion'];
$turno = $_POST['turno'];
$curp = $_POST['curp'];
$calle = $_POST['calle'];
$num_ext = $_POST['num_ext'];
$num_int = $_POST['num_int'];
$colonia = $_POST['colonia'];
$municipio2 = $_POST['municipio2'];
$edo_dom = $_POST['edo_dom'];
$ciudad = $_POST['ciudad'];
$poblacion = $_POST['poblacion'];
$codigo_postal = $_POST['codigo_postal'];
$telefono = $_POST['telefono'];
$umf = $_POST['umf'];
$num_consultorio = $_POST['num_consultorio'];
$nombre_acc = $_POST['nombre_acc'];
$parentesco = $_POST['parentesco'];
$telefono_urg = $_POST['telefono_urg'];

//$fecha_de_alta=$_POST['fecha_de_alta'];

// Prepara la consulta SQL para actualizar los datos en la base de datos
$sql = "UPDATE datos SET  
        nombre='$nombre',
        categoria='$categoria', 
        email_particular='$mail_particular', 
        email_institucional='$mail_institucional', 
        escolaridad='$escolaridad',
        area_escolar='$area_escolar', 
        estado_civil='$edo_civil', 
        pais='$pais_nac', 
        estado_nac='$edo_nac', 
        ciudad_nac='$municipio',
        adscripcion='$adscripcion',
        turno='$turno',
        curp='$curp',
        calle='$calle',
        numero_ext='$num_ext', 
        numero_int='$num_int', 
        colonia='$colonia',
        municipio='$municipio2',
        estado='$edo_dom',
        ciudad='$ciudad', 
        poblacion='$poblacion',
        codigo_postal='$codigo_postal',
        telefono='$telefono',
        umf='$umf',
        num_consultorio='$num_consultorio',
        nombre_caso_accidente='$nombre_acc', 
        parentesco='$parentesco',
        telefono_caso_accidente='$telefono_urg',
        fecha_modificacion='$fecha_modificacion'	
        WHERE id ='$id'";

// Ejecuta la consulta SQL
$resultado = $con->query($sql);

// Verifica si se han cargado archivos para actualizar
if ($_FILES["ine"]["error"] == 0 || $_FILES["comp_domicilio"]["error"] == 0 || $_FILES["escolaridad"]["error"] == 0) {
    $ruta = 'files/' . $id . '/';

    // Verifica si la carpeta existe, si no, la crea
    if (!file_exists($ruta)) {
        mkdir($ruta);
    }

    // Actualiza los archivos si se han cargado
    if ($_FILES["ine"]["error"] == 0) {
        move_uploaded_file($_FILES["ine"]["tmp_name"], $ruta . 'ine.pdf');
    }
    if ($_FILES["comp_domicilio"]["error"] == 0) {
        move_uploaded_file($_FILES["comp_domicilio"]["tmp_name"], $ruta . 'domicilio.pdf');
    }
    if ($_FILES["escolaridad"]["error"] == 0) {
        move_uploaded_file($_FILES["escolaridad"]["tmp_name"], $ruta . 'escolaridad.pdf');
    }

    echo "<h3 class='text-center'>Archivos actualizados correctamente</h3>";
} else {
    echo "<h3 class='text-center'>No se han modificado los archivos PDF</h3>";
}

?>

<html lang="es">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-theme.css" rel="stylesheet">
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="row" style="text-align:center">
                <?php if ($resultado) { ?>
                    <h3>REGISTRO MODIFICADO</h3>
                <?php } else { ?>
                    <h3>ERROR AL MODIFICAR</h3>
                <?php } ?>

                <a href="menu.php" class="btn btn-primary">Regresar</a>

            </div>
        </div>
    </div>
</body>

</html>