<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Titulo de la página -->
    <title> Formato | IMSS</title>

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script>
    
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="shortcut icon">
    <link href="https://framework-gb.cdn.gob.mx/gm/v4/image/favicon.ico" rel="shortcut icon">
    <link href="https://framework-gb.cdn.gob.mx/gm/v4/css/main.css" rel="stylesheet">

<style>       
 *{
margin:0;
padding:0;
}
#columna1 {

top:0px;
left:0px;
width:200px;
margin-top:10px;
background-color:#ffff55;
}
#columna2 {

margin-left:220px;
margin-right:20px;
margin-top:-100px;
background-color:#ffffbb;
}


div 
#imagen
{
   
  border: 2px solid #CCC;
  padding: 1em;
  margin: 1em 0 1em 4em;
  width: 10px;
}

div #imagen {
  position: absolute;
  top:  10px; 
  left: 10px;
}

.sub-navbar {
   top: -30px  !important;
 }



</style> 




</head>

<body>
<header>
        <!-- Inicia barra de navegación -->
          <nav class="navbar navbar-expand-md navbar-dark bg-light sub-navbar navbar-fixed-top">
              <div class="container">
                  <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#subNavBarDropdown" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                  </button>
                  <!--<a class="navbar-brand sub-navbar" href="https://www.gob.mx/salud">Imprimir</a>-->
                  <button class="navbar-brand sub-navbar" id="btnPrint">Imprimir</button>
 
                <div class="collapse navbar-collapse" id="subNavBarDropdown">
                  <ul class="navbar-nav">
 
                    <li class="nav-item">
                      <a class="nav-link subnav-link" href="php/logout.php" target="_parent">Salir</a>
                    </li>
 
                    <li class="nav-item">
                      <!-- <a class="nav-link subnav-link" href="#">Enlace</a> -->
                    </li>
 
                    <li class="nav-item dropdown">
                      <a class="nav-link subnav-link dropdown-toggle" href="menu.php" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Menu
                      </a>
                      <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">                        
                          <a class="dropdown-item" href="menu.php" target="_blank">Contacto</a>                    
                        
                        <div class="dropdown-divider"></div>
                      
                          <a class="dropdown-item" href="#" target="_blank">Plataforma<br>informativa</a>
                      </div>
                    </li>
                    
                  </ul>
                </div>
              </div>
          </nav>     
        
        <!-- finaliza barra de navegación -->   
    </header>

    <main class="page">
    <!-- Contenido -->
        
        <div class="container">
            <br />

            <?php
                contenido();
            ?>

        </div>
        <div class="row" style='bottom:0px;'>
            <div class="col-12">
                <div style="background-color: #10312B; width: 100%; height: 150px; "></div>
            </div>
        </div>






    <!-- JS -->
    </main>
</body>

</html>

  <!--PARA EL BOTON DE IMPRIMIR -->
  <script>
        // Agrega un listener al botón para detectar el clic
        document.getElementById("btnPrint").addEventListener("click", function() {
            // Abre el cuadro de diálogo de impresión del navegador
            window.print();
        });
    </script>
<script>
        // Función que se ejecuta antes de imprimir
        window.onbeforeprint = function() {
            alert("No olvides firmar con tinta azul en el apartado donde aparece tu CURP y entregar a la Coordinación Administrativa.");
        };
    </script>