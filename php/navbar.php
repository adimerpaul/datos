<nav class="navbar navbar-default" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="./"><b>INSTRUCCIONES</b></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav">
                <?php if(!isset($_SESSION["user_id"])): ?>
                  <li><a href="menu.php">INICIO</a></li>
                  <li><a href="./registro.php">REGISTRO</a></li>
                    <li><a href="./login.php">LOGIN</a></li>
                    <li><a href="./contacto.html">CONTACTO</a></li>
                    <li><a href="php/logout.php">SALIR</a></li>
                <?php else: ?>
                   
                        <?php if(isset($_SESSION['role_id']) && $_SESSION['role_id'] == 1): ?>
             
                        <li><a href="reporte.php">REPORTE</a></li>
                        <li><a href="./php/logout.php">SALIR</a></li>
                
                        <?php elseif(isset($_SESSION['role_id']) && $_SESSION['role_id'] == 2): ?>
                       <li> <a href="menu.php">SELECCIONA LAS OPCIONES</a></li>
                       <!--<li><a href="home.php">POR PRIMERA VEZ</a></li>
                        <li><a href="actualizar.php">ACTUALIZACIÓN</a></li>
                        <li><a href="formulario.php">IMPRESIÓN | FORMATO</a></li>
                        <li><a href="./php/logout.php">SALIR</a></li>-->
                    <?php endif; ?>
                <?php endif; ?>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div>
</nav>
