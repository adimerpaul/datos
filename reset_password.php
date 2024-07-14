<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperacion de Contraseña</title>
</head>

<body>





    <?php
    session_start();
    require 'master/barra.php';
    function contenido()
    {
        include('conexion.php');
        include('config.php');
        header('Content-Type: text/html; charset=utf8_encode()');




        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        function generarNuevaContrasena($longitud = 8)
        {
            $caracteres = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            $nueva_contrasena = '';

            $num_caracteres = strlen($caracteres);
            for ($i = 0; $i < $longitud; $i++) {
                $indice_aleatorio = rand(0, $num_caracteres - 1);
                $nueva_contrasena .= $caracteres[$indice_aleatorio];
            }

            return $nueva_contrasena;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
        
            // Verificar la existencia del correo en la base de datos
            $consulta = "SELECT * FROM user WHERE email = '$email'";
            $resultado = mysqli_query($con, $consulta);
        
            if (mysqli_num_rows($resultado) > 0) {
                // El correo existe en la base de datos, generar nueva contraseña
                $nueva_contrasena = generarNuevaContrasena();
        
                // Actualizar la contraseña en la base de datos
                $actualizar_contrasena = "UPDATE user SET password = '$nueva_contrasena', change_password = 1, modified_date_psw = NOW() WHERE email = '$email'";
                mysqli_query($con, $actualizar_contrasena);

                // Enviar el correo electrónico de recuperación de contraseña
                $mensaje = 'Tu nueva contrasena es: ' . $nueva_contrasena;
                $asunto = 'Recuperacion de contrasena para herramienta de Datos Personales';
                $cabeceras = 'From: coordinacion_administrativa' . "\r\n";

                $result = mail($email,$asunto,$mensaje,$cabeceras);
                if ($result) {
                    echo '<span style="font-size: larger; font-weight: bold;">El correo ha sido enviado correctamente, por favor verifica tu bandeja de entrada.</span>';
                } else {
                    echo 'Error al enviar el correo. Detalles: ' . print_r(error_get_last(), true);
                }
            } else {
                echo '<span style="font-size: larger; font-weight: bold;">El correo no existe en la base de datos.</span>';
            }
        }

        echo "<br>"; // Agregar un salto de línea
        echo "<br>";

        echo "<a href=\"login.php\" class=\"btn btn-primary\">Regresar</a>";
    }



    ?>


</body>

</html>