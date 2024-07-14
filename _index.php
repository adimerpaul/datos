<?php
session_start();
?>
<html>
	<head>
		<title>.: FUERZA DE TRABAJO :.</title>
		<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
	</head>
	<body>
	<?php include "php/navbar.php"; ?>
	<div class="container" clear="all">
	<div class="row">
	<div class="col-md-12">
			<h2>INSTITUTO MEXICANO DEL SEGURO SOCIAL</h2>
			<p class="lead">COORDINACIÓN DE GESTION DE RECURSOS HUMANOS</p>
			<p>División de <b>PLANEACIÓN DE FUERZA DE TRABAJO</b> </p>
			<p>Herramienta para la actualización de datos personales</p>
			<p><b>Por favor lee cuidadosamente los pasos a seguir:</b></p>
			<ol>
				<li>Registrate en la opcion de registro con tu matricula</li>
				<li>Inicie sesion en la opcion de login.</li>
				<li>Ingresar los datos solicitados en la sección de hoja de datos personales.</li>
				<li style="color:#FF0000">Debes agregar el ine y comprobante de domicilio en formato pdf con el nombre <b style="color:#264ef8">(ine.pdf)</b> y <b style="color:#264ef8">(dom.pdf)</b></li>
				<li>Al guardar los datos, debes dar click en la sección de <b>IMPRESION</b>, para verificación de la información.</li>
				<li>En caso de imprimir el formato, asegúrate que en la opción de Escala este en personalizado y con un valor de 80 <br> y que las opciones de Encabezado y pie de página
			        asi como Gráficos de fondo no estén seleccionados <br> Acontinuación se muestra ejemplo:<br> 
					<div align="center"><img src="http://localhost:84/datos_personales/impresion.png" class="alinear-izquierda"  alt="" height="400px"/></div> </li>
				
				<li style="color:#FF0000">Se hará una validación del ine y comprobante de domicilio, en caso de estar erroneo, te llegará notificacion al correo para que lo vuelvas a subir.</li>
				<li>Para finalizar la sesion, click en la opcion salir .</li>
			</ol>
			<br>
			<ul type="none">

		


			<!--<li><i class="glyphicon glyphicon-ok"></i> Facil de instalar y modificar</li>
			<li><i class="glyphicon glyphicon-ok"></i> Ideal para tu proximo proyecto web</li>-->
			</ul>

	</div>
	</div>
	</div>
	</body>
</html>