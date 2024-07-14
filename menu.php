<?php

session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["user_id"] == null) {
    print "<script>alert(\"Acceso invalido!\");window.location='login.php';</script>";
}


$user_id = $_SESSION['user_id'];

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Titulo de la página -->
    <title>DATOS PERSONALES | IMSS</title>


    <!-- CSS -->
    <link href="https://framework-gb.cdn.gob.mx/gm/v4/image/favicon.ico" rel="shortcut icon">
    <link href="https://framework-gb.cdn.gob.mx/gm/v4/css/main.css" rel="stylesheet">

</head>

<body>
    <!-- Barra de Navegación-->
    <nav class="navbar navbar-expand-md navbar-dark bg-light sub-navbar navbar-fixed-top">
        <div class="container">
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#subNavBarDropdown" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand sub-navbar" href="#">IMSS</a>

            <div class="collapse navbar-collapse" id="subNavBarDropdown">
                <ul class="navbar-nav">

                    <li class="nav-item">
                        <a class="nav-link subnav-link" href="changepassword.php">Cambiar Contraseña</a>
                    </li>
                    <?php
                    include('conexion.php');
                    $user_id = $_SESSION['user_id']['id'];
                    //echo "user_id: $user_id<br>";
                    // Verificar si el user_id del usuario está en la tabla datos
                    $consulta = "SELECT * FROM datos WHERE user_id = '$user_id'";
                    //echo "consulta: $consulta<br>";
                    $resultado = mysqli_query($con, $consulta);

                    $num_filas = mysqli_num_rows($resultado);

                    //echo "Número de filas en el resultado: $num_filas<br>";

                    if (mysqli_num_rows($resultado) === 0) {
                        // El username está en la tabla datos, mostrar el enlace
                        echo '<li class="nav-item">
                    <a class="nav-link subnav-link" href="home.php">Datos primera vez</a>
                        </li>';
                    }
                    ?>

                    <li class="nav-item dropdown">
                        <a class="nav-link subnav-link dropdown-toggle" href="actualizar.php" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Actualizar datos
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="#">Acción</a>
                            <a class="dropdown-item" href="#">Otra acción</a>
                            <div class="dropdown-divider""></div>
                    <a class=" dropdown-item" href="#">Algo más aquí</a>
                            </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link subnav-link" href="formulario.php">Imprime Formato</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link subnav-link" href="php/logout.php">SALIR</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Termina barra de navegación-->

    <!-- Contenido -->
    <main class="page">
        <div class="row">
            <div class="col-12">
                <div style="background-color: #10312B; width: 100%; height: 70px; position: fixed; top:0;"></div>
            </div>
        </div>
        <div class="container">
            <br />
            <br />
            <ol class="breadcrumb"><!-- Guía de recorrido de navegación-->
                <li><a href="login.php"><span class="icon icon-home"></span><span class="sr-only">Inicio
                            SSa</span></a></li>
                <li><a href="login.php">IMSS</a></li>
                <li class="active">MENU</li>
            </ol><!-- Terminia Guía de recorrido de navegación-->

            <h3>SELECCIONA:</h3>
            <hr class="red">
            <!--fila row -->
            <div class="row vertical-buffer">
                <div class="col-md-12">
                    
                    <p><b>
                        Debes adjuntar tu ine, comprobante de domicilio actual (no mayor a 3 meses) y tu comprobante de último grado de estudios (título y cédula profesional en un solo archivo).<b style="color:#264ef8"> en formato .pdf.</b>
                </b>
                    </p>
                  
             
                </div>
            </div><!-- Termina div row -->

            <div class="row vertical-buffer">
                <div class="col-md-12">
                    <ul>
                        <li>Instrucciones para usuarios por primera vez
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <a href="index.php" class="btn btn-link">
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </li>
                        <?php
                        include('conexion.php');
                        $user_id = $_SESSION['user_id']['id'];
                        //echo "user_id: $user_id<br>";
                        // Verificar si el user_id del usuario está en la tabla datos
                        $consulta = "SELECT * FROM datos WHERE user_id = '$user_id'";
                        //echo "consulta: $consulta<br>";
                        $resultado = mysqli_query($con, $consulta);

                        $num_filas = mysqli_num_rows($resultado);


                        if (mysqli_num_rows($resultado) === 0) {

                            echo  '<li> <b>Registra tus datos por primera vez </b>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <a href="home.php" class="btn btn-link">
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </li>';
                        }
                        ?>
                        <li>Actualiza tu información, ya que debe coincidir con el ine y comprobante de domicilio que adjuntes.
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <a href="actualizar.php" class="btn btn-link">
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </li>
                        <li><b>Visualiza tu información, guarda en formato pdf o imprime tu formato.</b>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <a href="formulario.php" class="btn btn-link">
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </li>

                    </ul>
                </div>
            </div>


            <div class="row vertical-buffer">
                <div class="col-md-12">
                    <div class="alert alert-success" role="alert">
                        <strong>Datos personales</strong>
                        <br>
                        <br>
                        Primera actualización Marzo <br>
                        <b>Segunda actualización Septiembre</b>
                        <br>
                        <br>
                        <!--<button type="button"
                            onclick="window.location.href='#'"
                            class="btn btn-danger">Ver</button>-->
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div style="background-color: #10312B; width: 100%; height: 150px; "></div>
            </div>
        </div>
    </main>

    <!-- JS -->

</body>

</html>