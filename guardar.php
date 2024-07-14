<?php
// Asegúrate de incluir tu archivo de conexión a la base de datos
include('conexion.php');

// Establece el manejo de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Inicia la sesión
session_start();

// Verifica si hay una sesión activa
if (!isset($_SESSION["user_id"]) || $_SESSION["user_id"] == null) {
    // Si no hay sesión, redirecciona al usuario a la página de inicio de sesión
    print "<script>alert(\"Acceso inválido!\");window.location='login.php';</script>";
}

// Obtiene el ID de usuario de la sesión
$user_id = $_SESSION['user_id']['id'];

// Incluye el archivo de conexión a la base de datos (ya lo has incluido previamente)

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
$municipio = $_POST['municipio'];
$adscripcion = $_POST['adscripcion'];
$turno = $_POST['turno'];
$calle = $_POST['calle'];
$num_ext = $_POST['num_ext'];
$num_int = $_POST['num_int'];
$colonia = $_POST['colonia'];
$municipio2 = $_POST['municipio2'];
$edo_dom = trim($_POST['edo_dom']);
$ciudad = $_POST['ciudad'];
$poblacion = $_POST['poblacion'];
$codigo_postal = $_POST['codigo_postal'];
$telefono = $_POST['telefono'];
$umf = $_POST['umf'];
$num_consultorio = $_POST['num_consultorio'];
$nombre_acc = $_POST['nombre_acc'];
$parentesco = $_POST['parentesco'];
$telefono_urg = $_POST['telefono_urg'];
$curp_input = $_POST['curp_input'];
$fecha_de_alta = $_POST['fecha_de_alta'];

// Preparar la consulta para verificar si la matrícula ya existe en la base de datos
$validar = "SELECT * FROM datos where matricula='$matricula'";
$validando = $con->query($validar);

// Verificar si la matrícula ya existe en la base de datos
if ($validando->num_rows > 0) {
    // Si la matrícula ya existe, muestra un mensaje de error y proporciona un enlace para regresar
    echo '<div class="row" style="text-align:center">
            <h2>La matrícula ya fue actualizada con anterioridad, consulte al administrador</h2>
            <a href="home.php" class="btn btn-primary">Regresar</a>
          </div>';
} else {
    // Si la matrícula no existe, procede con la inserción de los datos en la base de datos

    // Preparar la consulta para insertar los datos del formulario en la base de datos
    $consulta = "INSERT INTO datos (nombre,matricula,categoria,email_particular,email_institucional,escolaridad,area_escolar,estado_civil,pais,estado_nac,ciudad_nac,
    adscripcion,turno,calle, numero_ext, numero_int, colonia,municipio, estado,ciudad, poblacion, codigo_postal,telefono,umf, num_consultorio, nombre_caso_accidente,
    parentesco, telefono_caso_accidente, curp, fecha_de_alta,fecha_modificacion, user_id) 
    VALUES 
    ('$nombre','$matricula','$categoria','$mail_particular','$mail_institucional','$escolaridad','$area_escolar','$edo_civil','$pais_nac','$edo_nac','$municipio',
    '$adscripcion','$turno', '$calle','$num_ext','$num_int','$colonia','$municipio2','$edo_dom','$ciudad','$poblacion','$codigo_postal',
    '$telefono','$umf','$num_consultorio','$nombre_acc','$parentesco','$telefono_urg','$curp_input','$fecha_de_alta',NULL,'$user_id')";

    // Ejecutar la consulta para insertar los datos en la base de datos
    $resultado = $con->query($consulta);

    // Obtener el ID insertado
    $id_insert = $con->insert_id;

    // Verificar la subida de archivos
    if ($_FILES["ine"]["error"] > 0 && $_FILES["comp_domicilio"]["error"] > 0 && $_FILES["escolaridad"]["error"] > 0) {
        echo "Error al cargar archivo";
    } else {
        $permitidos = array("image/gif", "image/png", "application/pdf");
        $limite_kb = 10240;

        if (
            in_array($_FILES["ine"]["type"], $permitidos) && in_array($_FILES["comp_domicilio"]["type"], $permitidos)
            && in_array($_FILES["escolaridad"]["type"], $permitidos)
            && $_FILES["ine"]["size"] <= ($limite_kb * 10240) && $_FILES["comp_domicilio"]["size"] <= ($limite_kb * 20480)
            && $_FILES["escolaridad"]["size"] <= ($limite_kb * 20480)
        ) {

            $ruta = 'files/' . $id_insert . '/';
            $archivoINE = $ruta . 'ine.pdf';
            $archivoCOMP = $ruta . 'domicilio.pdf';
            $archivoESC = $ruta . 'escolaridad.pdf';

            if (!file_exists($ruta)) {
                mkdir($ruta);
            }

            // Mover los archivos subidos al directorio de destino
            $resultadoA = move_uploaded_file($_FILES["ine"]["tmp_name"], $archivoINE);
            $resultadoB = move_uploaded_file($_FILES["comp_domicilio"]["tmp_name"], $archivoCOMP);
            $resultadoC = move_uploaded_file($_FILES["escolaridad"]["tmp_name"], $archivoESC);

            // Verificar si la subida de archivos fue exitosa
            if ($resultadoA && $resultadoB && $resultadoC) {
                echo "<h3 style='color:#ff0000' class='text-center'>COMPROBANTES INE, DOMICILIO y GRADO ESCOLAR CORRECTOS </h3>";
            } else {
                echo "Error al guardar archivo";
            }
        } else {
            echo "Archivo no permitido o excede el tamaño";
        }
    }
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
                    <h3>REGISTRO GUARDADO</h3>
                <?php } else { ?>
                    <h3>ERROR AL GUARDAR</h3>
                    <?php
                    $error_message = "Error al ejecutar la consulta: " . $con->error;
                    echo "<script>console.error('$error_message');</script>";
                    ?>

                <?php } ?>

                <a href="home.php" class="btn btn-primary">Regresar</a>

            </div>
        </div>
    </div>
</body>

</html>
