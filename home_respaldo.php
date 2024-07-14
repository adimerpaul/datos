<?php

include('conexion.php');


session_start();
if(!isset($_SESSION["user_id"]) || $_SESSION["user_id"]==null){
	print "<script>alert(\"Acceso invalido!\");window.location='login.php';</script>";
}


?>
<html>


	<head>
		<title>.: HOME :.</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
		<script type="text/javascript" src="jquery-1.12.1.min.js"></script>
		<link rel="stylesheet" type="text/css" href="jquery-ui.css">
		<script type="text/javascript" src="jquery-ui.js"></script>
		<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
		<script src="functions.js"></script>
<!--******************************************************Para rellenar formulario************************************************************************-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>


    <!-- CSS -->
    <link href="https://framework-gb.cdn.gob.mx/gm/v4/image/favicon.ico" rel="shortcut icon">
    <link href="https://framework-gb.cdn.gob.mx/assets/styles/main.css" rel="stylesheet">

    <!-- Respond.js soporte de media queries para Internet Explorer 8 -->
    <!-- ie8.js EventTarget para cada nodo en Internet Explorer 8 -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/ie8/0.2.2/ie8.js"></script>
    <![endif]-->
    <style>
      #contenedorFormato_1{
        margin-top: 50px;
        margin-bottom: 50px;
        padding-top: 20px;
        border: solid #000 2px !important;
      }

      #logoIMSS{
        width: 120px;
      }

      .flexbox-container {
        display: flex;
        flex-wrap: nowrap;
        justify-content: center;
        align-items: center;
        align-content: center;
      }

      .flexbox-container input, .inputFormulario{
        width: 100%;
        border: none;
        border-bottom: solid black 1PX;
        margin-left: 5PX;
      }

      @media print {
          /*  reglas CSS específicas para imprimir */
          *{
            font-size: 6pt;
          }

          #logoIMSS{
            width: 10cm;
          }

          h4{
            font-size: 10pt;
          }

          .main-footer, header{
            visibility: hidden;
          }
          #contenedorFormato_1{
            margin-top: 1cm !important;
            margin-bottom: 1cm !important;
            top: 0cm !important;
            
          }

          .page{
            top: 0cm !important;
          }

          @page {
            margin:0.2cm;
            margin-top: 0cm;
            padding-top: 0cm;

          }
      } 


      small {
    font-size: 0.7em;
}

      
    </style>




	</head>
	<body>

	<?php include "php/navbar.php"; ?>
	<div class="container">
	<div class="row">
	<div class="col-md-6">





	  

	</form>

	<?php
$mysqli = new mysqli('localhost', 'root', '', 'datos_personales');
mysqli_set_charset($mysqli, "utf8");
?>



<fieldset>
<legend>HOJA DE DATOS PERSONALES</legend>

<div class="formulario row">

<form class="form-horizontal" method="POST" action="guardar.php " enctype="multipart/form-data" autocomplete="off">

	
<div class="form-group"> <!-- Matricula -->
        <label for="matricula" class="control-label">MATRICULA</label>

        <input type="text" class="form-control" id="matricula" onblur="buscar_datos();" name="matricula" step="any" onkeypress="return solonumeros(event)" maxlength="10" placeholder="MATRÍCULA" required>
</br>
			<center>
				<input type="button" value="BUSCAR" class="btn btn-success"  center name="btn_buscar" onclick="guardar();">
            </center>
   
			<br>


      <div class="row top-buffer">
          <div class="col-md-2 col-xs-2 text-left">
            <label>NOMBRE:</label>
          </div>
          <div class="col-md-9 col-xs-9 text-center">
            <input type="text" class="inputFormulario text-center" name="nombre" id="nombre" placeholder="" style="display: inline-block;" > 
              <div>
            <small style="display: inline-block; margin-left: 20PX;">
            <span>APELLIDO PATERNO</span></small><small style="display: inline-block; margin-left: 50PX;">
            <span>APELLIDO MATERNO</span></small><small style="display: inline-block; margin-left: 50PX;">
            <span>NOMBRE (S)</span></small>
              </div>
          </div>         
          <div class="col-md-1 col-xs-1">
            <!-- VACIO -->
          </div>
        </div>



 
      

			<div class="form-group"> <!-- nombre -->
        <label for="nombre" class="control-label">NOMBRE</label>
        <input type="text" style="color:#FF0000" class="form-control" id="nombre" name="nombre" step="any"  maxlength="70"  placeholder="apelllido paterno  apellido materno  nombre(s)">
    		</div> 

        <div class="form-group"> <!--categoria -->
        <label for="categoria" class="control-label">CATEGORIA</label>
        <input type="text" style="color:#FF0000" class="form-control" id="categoria" name="categoria" placeholder="categoria">
    		</div>  

			<div class="form-group"> <!-- email particular -->
        <label for="mail_particular" class="control-label">E-MAIL PARTICULAR</label>
        <input type="text" onKeyUp="this.value=this.value.toLowerCase();" class="form-control" id="mail_particular" name="mail_particular" placeholder="correo personal">
    </div>   

	<div class="form-group"> <!-- email institucional -->
        <label for="mail_institucional" class="control-label">E-MAIL INSTITUCIONAL</label>
        <input type="text" onKeyUp="this.value=this.value.toLowerCase();" class="form-control" id="mail_institucional" name="mail_institucional" placeholder="correo institucional">
    </div> 

	<div class="form-group"> <!-- escolaridad -->
        <label for="escolaridad" class="control-label">ESCOLARIDAD</label>
        <select class="form-control" onKeyUp="this.value=this.value.toUpperCase();" id="escolaridad" name="escolaridad">
        <option value="0">Selecciona Escolaridad</option>
        <?php 

$query = "SELECT id, escolaridad FROM cat_escolaridad ORDER BY id ASC";

$resultado = $mysqli->query($query);

WHILE ($row = $resultado->fetch_assoc()) 
{ ?>

<option value="<?php echo $row['escolaridad']; ?>"><?php echo $row['escolaridad']; ?></option>

<?php } ?>	
         
		</select>                    
    </div>	
			
	<div class="form-group"> <!-- estado civil -->
        <label for="edo_civil" class="control-label">ESTADO CIVIL</label>
        <select class="form-control" id="edo_civil" name="edo_civil">
        <option value="0">Selecciona Estado Civil</option>
        <?php 

$query = "SELECT id_edo_civil,desc_edocivil FROM cat_edo_civil ORDER BY id_edo_civil ASC";

$resultado = $mysqli->query($query);

WHILE ($row = $resultado->fetch_assoc()) 
{ ?>

<option value="<?php echo $row['desc_edocivil']; ?>"><?php echo $row['desc_edocivil']; ?></option>

<?php } ?>	
		</select>                    
    </div>	


	<div class="form-group"> <!-- lugar de nacimiento -->
        <label for="pais_nac" class="control-label">LUGAR DE NACIMIENTO</label>
       
		<select class="form-control" id="pais_nac" name="pais_nac">
		     <option value="0">Selecciona País</option>
            <option value="Mexico">México</option>
		</select>   
		<br>

		<select class="form-control" id="edo_nac" id="edo_nac" name="edo_nac">
							<option value="0">Selecciona Estado</option>
							<?php 

							$query = "SELECT id_estado, estado FROM cat_estados ORDER BY estado ASC";

							$resultado = $mysqli->query($query);

					WHILE ($row = $resultado->fetch_assoc()) 
						{ ?>

					<option value="<?php echo $row['estado']; ?>"><?php echo $row['estado']; ?></option>

					<?php } ?>	

					</select>

		<br>
		<select class="form-control" id="municipio" id="municipio" name="municipio">
							<option value="0">Selecciona Ciudad</option>
							<?php 

							$query = "SELECT id_mun, municipio FROM cat_municipios ORDER BY municipio ASC";

							$resultado = $mysqli->query($query);

					WHILE ($row = $resultado->fetch_assoc()) 
						{ ?>

					<option value="<?php echo $row['municipio']; ?>"><?php echo $row['municipio']; ?></option>

					<?php } ?>	

					</select>



    		</div> 


			
        <div class="form-group"> <!--adscripcion -->
        <label for="adscripcion" class="control-label">ADSCRIPCION</label>
        <input type="text" style="color:#FF0000" class="form-control" id="adscripcion" name="adscripcion" placeholder="adscripcion">
    </div>  

    <div class="form-group"> <!-- estado civil -->
        <label for="turno" class="control-label">TURNO</label>
        <select class="form-control" id="turno" name="turno">
        <option value="0">SELECCIONA TURNO</option>
            <option value="Matutino">Matutino</option>
            <option value="Vespertino">Vespertino</option>
		</select>                    
    </div>
		
    </fieldset>

    <fieldset>
<p><legend>DOMICILIO PARTICULAR:</legend></p> 
<div class="form-group"> 
<p> <label for="calle" class="control-label">CALLE:</label>    
      <input type="text" onKeyUp="this.value=this.value.toUpperCase();" class="form-control"  name="calle" placeholder="calle"/> 
     <label for="num_ext" class="control-label"> NUMERO EXT:</label>  
      <input type="text" class="form-control"  name="num_ext" size="4"/>
      <label for="num_int" class="control-label"> NUMERO INT:</label>  
       <input type="text" class="form-control"   name="num_int" size="4"/></p>
	
			
		<label for="colonia" class="control-label">COLONIA:</label>    
      <input type="text"  class="form-control" name="colonia" placeholder="colonia"/> 		
      <label for="municipio2" class="control-label">DELEGACIÓN o MUNICIPIO:</label>
      <select class="form-control" id="municipio2" id="municipio2" name="municipio2">
							<option value="0">SELECCIONA DELEGACION O MUNICIPIO</option>
							<?php 

							$query = "SELECT id_mun, municipio FROM cat_municipios ORDER BY municipio ASC";

							$resultado = $mysqli->query($query);

					WHILE ($row = $resultado->fetch_assoc()) 
						{ ?>

					<option value="<?php echo $row['municipio']; ?>"><?php echo $row['municipio']; ?></option>

					<?php } ?>	

					</select>

          <label for="edo_dom" class="control-label">ESTADO:</label>
          <select class="form-control" id="edo_dom" id="edo_nac" name="edo_dom">
							<option value="0">Selecciona Estado</option>
							<?php 

							$query = "SELECT id_estado, estado FROM cat_estados ORDER BY estado ASC";

							$resultado = $mysqli->query($query);

					WHILE ($row = $resultado->fetch_assoc()) 
						{ ?>

					<option value="<?php echo $row['estado']; ?>"><?php echo $row['estado']; ?></option>

					<?php } ?>	

					</select>



          <div class="form-group"> <!-- ciudad -->
        <label for="ciudad" class="control-label">CIUDAD</label>
        <input type="text" class="form-control" id="ciudad" name="ciudad" placeholder="ciudad">
    		</div> 

        
        <div class="form-group"> <!-- poblacion -->
        <label for="poblacion" class="control-label">POBLACIÓN</label>
        <input type="text" class="form-control" id="poblacion" name="poblacion" placeholder="poblacion">
    		</div> 

        <div class="form-group"> <!--codigo postal-->
        <label for="codigo_postal" class="control-label">CODIGO POSTAL</label>
        <input type="text" class="form-control" id="codigo_postal" name="codigo_postal" placeholder="código postal">
    		</div> 

        <div class="form-group"> <!--telefono-->
        <label for="telefono" class="control-label">TELEFONO</label>
        <input type="text" class="form-control" id="telefono" name="telefono" placeholder="telefono">
    		</div> 

        <div class="form-group"> <!--UMF-->
        <label for="umf" class="control-label">U.M.F</label>
        <input type="text" class="form-control" id="umf" name="umf" placeholder="donde recibe atención medica">
    		</div> 

        <div class="form-group"> <!--numero de consultorio-->
        <label for="num_consultorio" class="control-label">NUMERO DE CONSULTORIO</label>
        <input type="text" class="form-control" id="num_consultorio" name="num_consultorio" placeholder="número de consultorio">
    		</div> 

  
          </div> 

          </fieldset>


     
          <fieldset>     
          <p><legend>EN CASO DE ACCIDENTE FAVOR DE AVISAR A:</legend></p> 

          <div class="form-group"> <!-- nombre_accidente -->
        <label for="nombre_acc" class="control-label">NOMBRE (S)</label>
        <input type="text" class="form-control" id="nombre_acc" name="nombre_acc" placeholder="apelllido paterno  apellido materno  nombre(s)">
    		</div> 
        
        <div class="form-group"> <!--parentesco-->
        <label for="parentesco" class="control-label">PARENTESCO</label>
        <select class="form-control" id="parentescto" name="parentesco">
        <option value="0">Selecciona Parentesco</option>
        <?php 

$query = "SELECT id,parentesco FROM cat_parentesco ORDER BY parentesco ASC";

$resultado = $mysqli->query($query);

WHILE ($row = $resultado->fetch_assoc()) 
{ ?>

<option value="<?php echo $row['parentesco']; ?>"><?php echo $row['parentesco']; ?></option>

<?php } ?>	
        
		</select>   
    
    
    
    <div class="form-group"> <!--telefono-->
        <label for="telefono_urg" class="control-label">TELEFONO</label>
        <input type="text" class="form-control" id="telefono_urg" name="telefono_urg" placeholder="telefono">
    		</div> 
    </div>	





          
          </fieldset>




				<div class="form-group">
					<label for="fecha_de_alta" class="col-sm-2 control-label">Fecha de actualización</label>
					<div class="col-sm-10">

		
				
					<input readonly type="date" id="fecha_de_alta" name="fecha_de alta"  value="<?php echo date("Y-m-d");?>">
						<!--<input type="date" class="form-control" id="fecha_de_alta" name="fecha_de_alta">-->
					</div>
				</div>



			
<FORM enctype="multipart/form-data" method="post" action="guardar.php">


<BR>
<BR>



<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<a href="home.php" class="btn btn-default">Regresar</a>
						<button type="submit" class="btn btn-primary">Guardar</button>
		                
						<!--<input type="button" value="BUSCAR" class="btn btn-success" name="btn_buscar" onclick="guardar();">-->
          				<input type="button" value="CANCELAR" class="btn btn-danger" name="btn_cancelar" onclick="limpiar();">

					</div>
				</div>

    </P>



</form>
</FORM>
<div class="resultados"></div>

	</div>
 	</div>
	</div>
	</div>
  </div>






	</body>
</html>


<script type="text/javascript">
  $(document).ready(function(){
        $('.cargando').hide();
      });  

  function buscar_datos()
  {
    matricula = $("#matricula").val();
    
    
    var parametros = 
    {
      "buscar": "1",
      "matricula" : matricula
    };
    $.ajax(
    {
      data:  parametros,
      dataType: 'json',
      url:   'codigos_php.php',
      type:  'post',
      beforeSend: function() 
      {
        $('.formulario').hide();
        $('.cargando').show();
        
      }, 
      error: function()
      {alert("Error");},
      complete: function() 
      {
        $('.formulario').show();
        $('.cargando').hide();
       
      },
      success:  function (valores) 
      {
        if(valores.existe=="1") //Aqui usamos la variable que NO use en el vídeo
        {
        
          $("#nombre").val(valores.ocupante);
		    $("#categoria").val(valores.desc_categoria);
		    $("#adscripcion").val(valores.nom_ads);
  
        
        }
        else
        {
          alert("El empleado no existe, ¡Consulte al administrador!")
        }

      }
    }) 
  }

  function limpiar()
  {
    $("#matricula").val("");
    $("#nombre").val("");
    $("#categoria").val("");
    $("#mail_particular").val("");
	$("#mail_institucional").val("");
	$("#escolaridad").val("");
	$("#edo_civil").val("");
	$("#pais_nac").val("");
	$("#edo_nac").val("");
	$("#municipio").val("");
	$("#adscripcion").val("");
  $("#turno").val("");
  $("#calle").val("");
  $("#num_ext").val("");
  $("#num_int").val("");
  $("#colonia").val("");
  $("#municipio2").val("");
  $("#edo_dom").val("");
  $("#ciudad").val("");
  $("#poblacion").val("");
  $("#codigo_postal").val("");
  $("#telefono").val("");
  $("#umf").val("");
  $("#num_consultorio").val("");
  $("#nombre_acc").val("");
  $("#parentesco").val("");
  $("#telefono_urg").val("");

  
  


  }

  function guardar()
  {
    var parametros = 
    {
      "guardar": "1",
      "matricula" : $("#matricula").val(),
      "nombre" : $("#nombre").val(),
      "categoria" : $("#categoria").val(),
      "adscripcion" : $("#adscripcion").val()
    };
    $.ajax(
    {
      data:  parametros,
      url:   'codigos_php.php',
      type:  'post',
      beforeSend: function() 
      {
        $('.formulario').hide();
        $('.cargando').show();


















































































































































































































































































































		
        
      }, 
      error: function()
      {alert("Error");},
      complete: function() 
      {
        $('.formulario').show();
        $('.cargando').hide();
       
      },
      success:  function (mensaje) 
      {$('.resultados').html(mensaje);}
    }) 
    limpiar();
  }
</script>