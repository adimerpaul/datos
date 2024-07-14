<?php
// No mostrar los errores de PHP
//error_reporting(0);
require 'master/index.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

function contenido()
{
?>


<?php
include("conexion.php");
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["user_id"] == null || !isset($_SESSION["role_id"])) {
  print "<script>alert(\"Acceso inválido!\");window.location='login.php';</script>";
  exit();
}

$user_id = $_SESSION['user_id']['id'];
$role_id = $_SESSION['role_id'];

if ($role_id == 2) {
  // Usuario con role 2 (employee), solo puede ver sus propios datos
  $sql = "SELECT a.nombre,a.matricula,a.categoria,a.email_particular,a.email_institucional,a.escolaridad,a.estado_civil,a.pais,
        a.adscripcion,a.turno,a.calle, a.numero_ext, a.numero_int, a.colonia,a.municipio, a.estado,a.ciudad, 
        a.poblacion, a.codigo_postal,a.telefono,a.umf, a.num_consultorio, a.nombre_caso_accidente,
        a.parentesco, a.telefono_caso_accidente, a.curp, a.fecha_de_alta,a.user_id,a.estado_nac, b.estado AS estadon, a.ciudad_nac,d.municipio AS municipion  
        FROM datos a
        LEFT JOIN cat_estados b ON a.estado_nac=b.id_estado 
        LEFT JOIN cat_municipios d ON a.ciudad_nac=d.id_mun
        WHERE a.user_id = ?"; // Cambiado de user_id a a.user_id

  // Preparar la sentencia SQL
  $stmt = $con->prepare($sql);
  $stmt->bind_param("i", $user_id);
} elseif ($role_id == 1) {
  // Usuario con role 1 (admin), puede ver datos basados en la matrícula seleccionada
  if (isset($_GET['matricula'])) {
    $matricula = $_GET['matricula'];

    $sql = "SELECT a.nombre,a.matricula,a.categoria,a.email_particular,a.email_institucional,a.escolaridad,a.estado_civil,a.pais,
    a.adscripcion,a.turno,a.calle, a.numero_ext, a.numero_int, a.colonia,a.municipio, a.estado,a.ciudad, 
    a.poblacion, a.codigo_postal,a.telefono,a.umf, a.num_consultorio, a.nombre_caso_accidente,
    a.parentesco, a.telefono_caso_accidente, a.curp, a.fecha_de_alta,a.user_id,a.estado_nac, b.estado AS estadon, a.ciudad_nac,d.municipio AS municipion  
    FROM datos a
    LEFT JOIN cat_estados b ON a.estado_nac=b.id_estado 
    LEFT JOIN cat_municipios d ON a.ciudad_nac=d.id_mun
    WHERE a.matricula = ?";

    // Preparar la sentencia SQL
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $matricula);
  } else {
    // No se proporcionó la matrícula
    print "<script>alert(\"Acceso inválido. No se proporcionó la matrícula.\");window.location='login.php';</script>";
    exit();
  }
} else {
  // Role inválido
  print "<script>alert(\"Role inválido\");</script>";
  print "<script>alert(\"Acceso inválido.\");window.location='login.php';</script>";
  exit();
}

// Ejecutar la consulta preparada
$stmt->execute();

// Obtener los resultados
$resultado = $stmt->get_result();
$numeroSql = $resultado->num_rows;



?>

<?php
while ($crow = $resultado->fetch_assoc()) {
  // Mostrar los datos
?>




  <!DOCTYPE html>
  <html lang="es">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Formato IMSS</title>
    

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
      #contenedorFormato_1 {
        margin-top: 5px;
        margin-bottom: 50px;
        padding-top: 20px;
        border: solid #000 2px !important;
      }

      #logoIMSS {
        width: 120px;
      }

      .flexbox-container {
        display: flex;
        flex-wrap: nowrap;
        justify-content: center;
        align-items: center;
        align-content: center;
      }

      .flexbox-container input,
      .inputFormulario {
        width: 110%;
        border: none;
        border-bottom: solid black 1PX;
        margin-left: 5PX;
      }

      @media print {

        /*  reglas CSS específicas para imprimir */
        * {
          font-size: 8pt;
        }

        #logoIMSS {
          width: 10cm;
        }

        h4 {
          font-size: 12pt;
        }

        .main-footer,
        header {
          visibility: hidden;
        }

        #contenedorFormato_1 {
          margin-top: 0cm !important;
          margin-bottom: 0cm !important;
          top: 0cm !important;

        }

        .page {
          top: 0cm !important;
        }

        @page {
          size: auto; /* Tamaño de página automático */
          margin: 10; /* Sin márgenes */
          page-break-before: always; /* Siempre rompe página antes del contenido */
          /*margin: 0.2cm;
          margin-top: 10cm; /* Ajusta este valor para cambiar el margen superior */
         /* padding-top: 0cm;
          margin-left: 20cm;
          margin-right: 20cm;*/

        }
      }

      small {
        font-size: 0.8em;
      }
    </style>

  </head>





  <body>


    <!-- Contenido -->
    <main class="page">
      <div id="contenedorFormato_1" class="container">

        <div class="row">
          <div class="col-md-1 col-xs-2">
             <img id="logoIMSS" src="https://1000marcas.net/wp-content/uploads/2022/01/IMSS-Logo.png" alt="">
          </div>
          <div class="col-md-8 col-xs-8">

            INSTITUTO MEXICANO DEL SEGURO SOCIAL<br>
            COORDINACION DE GESTION DE RECURSOS HUMANOS<br>
            DIVISION DE PLANEACION DE FUERZA DE TRABAJO

          </div>
          <div class="col-md-3  col-xs-2 text-center">
            <br>
            HOJA DE DATOS
            <br>
            PERSONALES
            </p>
          </div>

        </div>



        <div class="row  top-buffer">
          <div class="col-md-1 col-xs-1">
            <!-- VACIO -->
          </div>

          <div class="col-md-4 col-xs-4 flexbox-container">
            <label for="">DELEGACIÓN</label>
            <label name="delegacion" id="delegacion" class="text-center" style="display: inline-block; margin-left: 20PX; border-bottom: #000 solid 2PX;">NIVEL CENTRAL<br>DIRECCIÓN JURÍDICA</label>
          </div>

          <div class="col-md-2 col-xs-2">
            <!-- VACIO -->
          </div>

          <div class="col-md-4 col-xs-4 flexbox-container">
            <label>FECHA</label><input readonly type="date" class="inputFormulario text-center" id="fecha_de_alta" name="fecha_de alta" value="<?php echo date("Y-m-d"); ?>" />
          </div>

          <div class="col-md-1 col-xs-1">
            <!-- VACIO -->
          </div>
        </div>


        <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
        <div class="form-group">


          <div class="row top-buffer">
            <div class="col-md-2 col-xs-2 text-left">
              <label>NOMBRE:</label>
            </div>
            <div class="col-md-9 col-xs-9 text-center">
              <input type="text" class="inputFormulario text-center" name="nombre" id="nombre" placeholder="" style="display: inline-block;" value="<?php echo $crow['nombre'] ?>">

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




          <div class="row">
            <div class="col-md-2 col-xs-2 text-left">
              <label>MATRICULA:</label>
            </div>
            <div class="col-md-3 col-xs-3 text-center">
              <input type="text" class="inputFormulario text-center" name="matricula" id="matricula" placeholder="" style="display: inline-block;" value="<?php echo $crow['matricula'] ?>">
            </div>
            <div class="col-md-1 col-xs-1">

            </div>
            <div class="col-md-2 col-xs-2 text-center">
              <label>CATEGORIA:</label>
            </div>
            <div class="col-md-3 col-xs-3 text-center">
              <input type="text" class="inputFormulario text-center" name="categoria" id="categoria" placeholder="" style="display: inline-block;" value="<?php echo $crow['categoria'] ?>">
            </div>
            <div class="col-md-1 col-xs-1">
              <!-- VACIO -->
            </div>
          </div>

          <div class="row">
            <div class="col-md-3 col-xs-3 text-left">
              <label>E-MAIL PARTICULAR:</label>
            </div>
            <div class="col-md-8 col-xs-8 text-center">
              <input type="text" class="inputFormulario text-center" name="email_particular" id="email_particular" placeholder="" style="display: inline-block;" value="<?php echo $crow['email_particular'] ?>">
            </div>
            <div class="col-md-1 col-xs-1">
              <!-- VACIO -->
            </div>
          </div>

          <div class="row">
            <div class="col-md-3 col-xs-3 text-left">
              <label>E-MAIL INSTITUCIONAL:</label>
            </div>
            <div class="col-md-8 col-xs-8 text-center">
              <input type="text" class="inputFormulario text-center" name="email_institucioal" id="email_institucional" placeholder="" style="display: inline-block;" value="<?php echo $crow['email_institucional'] ?>">
            </div>
            <div class="col-md-1 col-xs-1">
              <!-- VACIO -->
            </div>
          </div>

          <div class="row">
            <div class="col-md-2 col-xs-2 text-left">
              <label>ESCOLARIDAD:</label>
            </div>
            <div class="col-md-4 col-xs-4 text-center">
              <input type="text" class="inputFormulario text-center" name="escolaridad" id="escolaridad" placeholder="" style="display: inline-block;" value="<?php echo $crow['escolaridad'] ?>">
            </div>
            <div class="col-md-1 col-xs-1">
              <!-- VACIO -->
            </div>
            <div class="col-md-2 col-xs-2 text-center">
              <label>ESTADO CIVIL:</label>
            </div>
            <div class="col-md-2 col-xs-2 text-center">
              <input type="text" class="inputFormulario text-center" name="estado_civil" id="estado_civil" placeholder="" style="display: inline-block;" value="<?php echo $crow['estado_civil'] ?>">
            </div>
            <div class="col-md-1 col-xs-2">
              <!-- VACIO -->
            </div>
          </div>

          <div class="row">
            <div class="col-md-2 col-xs-2 text-left">
              <label>LUGAR DE NACIMIENTO:</label>
            </div>
            <div class="col-md-3 col-xs-3 text-center">
              <input type="text" class="inputFormulario text-center" name="pais" id="pais" placeholder="PAIS" style="display: inline-block;" value="<?php echo $crow['pais'] ?>">
            </div>
            <div class="col-md-3 col-xs-3 text-center">
              <input type="text" class="inputFormulario text-center" name="estado_nac" id="estado_nac" placeholder="ESTADO" style="display: inline-block;" value="<?php echo $crow['estadon'] ?>">
            </div>
            <div class="col-md-3 col-xs-3 text-center">
              <input type="text" class="inputFormulario text-center" name="ciudad_nac" id="ciudad_nac" placeholder="CIUDAD" style="display: inline-block;" value="<?php echo $crow['municipion'] ?>">
            </div>
            <div class="col-md-1 col-xs-1 ">
              <!-- VACIO -->
            </div>
          </div>

          <div class="row">
            <div class="col-md-2 col-xs-2  text-left">
              <label>ADSCRIPCIÓN:</label>
            </div>
            <div class="col-md-5 col-xs-5 text-center">
              <input type="text" class="inputFormulario text-center" name="adscripcion" id="adscripcion" placeholder="" style="display: inline-block;" value="<?php echo $crow['adscripcion'] ?>">
            </div>
            <div class="col-md-2 col-xs-2 text-center">
              <label>TURNO:</label>
            </div>
            <div class="col-md-2 col-xs-2 text-center">
              <input type="text" class="inputFormulario text-center" name="turno" id="turno" placeholder="" style="display: inline-block;" value="<?php echo $crow['turno'] ?>">
            </div>
            <div class="col-md-1 col-xs-1">
              <!-- VACIO -->
            </div>
          </div>

          <div class="row top-buffer">
            <div class="col-md-5 col-xs-5 text-left">
              <h4>DOMICILIO PARTICULAR:</h4>
            </div>

            <div class="col-md-3 col-xs-3 text-center">
              <!-- VACIO -->
            </div>
            <div class="col-md-3 col-xs-3 text-center">
              <!-- VACIO -->
            </div>
            <div class="col-md-1 col-xs-1">
              <!-- VACIO -->
            </div>
          </div>


          <div class="row">
            <div class="col-md-1 col-xs-1 text-left">
              <label>CALLE:</label>
            </div>
            <div class="col-md-4 col-xs-4 text-center">
              <input type="text" class="inputFormulario text-center" name="calle" id="calle" placeholder="" style="display: inline-block;" value="<?php echo $crow['calle'] ?>">
            </div>
            <div class="col-md-2 col-xs-2 text-center">
              <label>NUMERO EXT.</label>
            </div>
            <div class="col-md-1 col-xs-1 text-center">
              <input type="text" class="inputFormulario text-center" name="numero_ext" id="numero_ext" placeholder="" style="display: inline-block;" value="<?php echo $crow['numero_ext'] ?>">
            </div>
            <div class="col-md-2 col-xs-2 text-center">
              <label>NUMERO INT.</label>
            </div>
            <div class="col-md-1 col-xs-1 text-center">
              <input type="text" class="inputFormulario text-center" name="numero_int" id="numero_int" placeholder="" style="display: inline-block;" value="<?php echo $crow['numero_int'] ?>">
            </div>
            <div class="col-md-1 col-xs-1">
              <!-- VACIO -->
            </div>
          </div>

          <div class="row">
            <div class="col-md-1 col-xs-1 text-left">
              <label>COLONIA</label>
            </div>
            <div class="col-md-4 col-xs-4 text-center">
              <input type="text" class="inputFormulario text-center" name="colonia" id="colonia" placeholder="" style="display: inline-block;" value="<?php echo $crow['colonia'] ?>">
            </div>
            <div class="col-md-3 col-xs-3 text-center">
              <label>DELEGACIÓN O MUNICIPIO:</label>
            </div>
            <div class="col-md-3 col-xs-3 text-center">
              <input type="text" class="inputFormulario text-center" name="municipio" id="municipio" placeholder="" style="display: inline-block;" value="<?php echo $crow['municipio'] ?>">
            </div>
            <div class="col-md-1 col-xs-1">
              <!-- VACIO -->
            </div>
          </div>

          <div class="row">
            <div class="col-md-1 col-xs-1 text-left">
              <label>ESTADO:</label>
            </div>
            <div class="col-md-3 col-xs-3 text-center">
              <input type="text" class="inputFormulario text-center" name="estado" id="estado" placeholder="" style="display: inline-block;" value="<?php echo $crow['estado'] ?>">
            </div>
            <div class="col-md-1 col-xs-1 text-center">
              <label>CIUDAD:</label>
            </div>
            <div class="col-md-2 col-xs-2 text-center">
              <input type="text" class="inputFormulario text-center" name="ciudad" id="ciudad" placeholder="" style="display: inline-block;" value="<?php echo $crow['ciudad'] ?>">
            </div>
            <div class="col-md-2 col-xs-2 text-center">
              <label>POBLACIÓN:</label>
            </div>
            <div class="col-md-2 col-xs-2 text-center">
              <input type="text" class="inputFormulario text-center" name="poblacion" id="poblacion" placeholder="" style="display: inline-block;" value="<?php echo $crow['poblacion'] ?>">
            </div>
            <div class="col-md-1 col-xs-1">
              <!-- VACIO -->
            </div>
          </div>

          <div class="row">
            <div class="col-md-2 col-xs-2 text-left">
              <label>C.P.:</label>
            </div>
            <div class="col-md-5 col-xs-5 text-center">
              <input type="text" class="inputFormulario text-center" name="codigo_postal" id="codigo_postal" placeholder="" style="display: inline-block;" value="<?php echo $crow['codigo_postal'] ?>">
            </div>
            <div class="col-md-2 col-xs-2 text-center">
              <label>TELÉFONO (S):</label>
            </div>
            <div class="col-md-2 col-xs-2 text-center">
              <input type="text" class="inputFormulario text-center" name="telefono" id="telefono" placeholder="" style="display: inline-block;" value="<?php echo $crow['telefono'] ?>">
            </div>
            <div class="col-md-1 col-xs-1">
              <!-- VACIO -->
            </div>
          </div>

          <div class="row">
            <div class="col-md-2 col-xs-2 text-left">
              <label>U.M.F.:</label>
            </div>
            <div class="col-md-5 col-xs-5 text-center">
              <input type="text" class="inputFormulario text-center" name="umf" id="umf" placeholder="" style="display: inline-block;" value="<?php echo $crow['umf'] ?>">
            </div>
            <div class="col-md-2 col-xs-2 text-center">
              <label>NÚMERO DE CONSULTORIO:</label>
            </div>
            <div class="col-md-2 col-xs-2 text-center">
              <input type="text" class="inputFormulario text-center" name="num_consultorio" id="num_consultorio" placeholder="" style="display: inline-block;" value="<?php echo $crow['num_consultorio'] ?>">
            </div>
            <div class="col-md-1 col-xs-1">
              <!-- VACIO -->
            </div>
          </div>

          <div class="row top-buffer">
            <div class="col-md-7 col-xs-7 text-left">
              <h4>EN CASO DE ACCIDENTE FAVOR DE AVISAR A:</h4>
            </div>

            <div class="col-md-1 col-xs-1 text-center">
              <!-- VACIO -->
            </div>
            <div class="col-md-2 col-xs-2 text-center">
              <!-- VACIO -->
            </div>
            <div class="col-md-1 col-xs-1">
              <!-- VACIO -->
            </div>
          </div>

          <div class="row">
            <div class="col-md-2 col-xs-2 text-left">
              <label>NOMBRE (S):</label>
            </div>

            <div class="col-md-9 col-xs-9 text-center">
              <input type="text" class="inputFormulario text-center" name="nombre_caso_accidente" id="nombre_caso_accidente" placeholder="" style="display: inline-block;" value="<?php echo $crow['nombre_caso_accidente'] ?>">
            </div>
            <div class="col-md-1 col-xs-1">
              <!-- VACIO -->
            </div>
          </div>


          <div class="row">
            <div class="col-md-2 col-xs-2 text-left">
              <label>PARENTESCO:</label>
            </div>
            <div class="col-md-5 col-xs-5 text-center">
              <input type="text" class="inputFormulario text-center" name="parentesco" id="parentesco" placeholder="" style="display: inline-block;" value="<?php echo $crow['parentesco'] ?>">
            </div>
            <div class="col-md-2 col-xs-2 text-center">
              <label>TELÉFONO (S):</label>
            </div>
            <div class="col-md-2 col-xs-2 text-center">
              <input type="text" class="inputFormulario text-center" name="telefono_caso_accidente" id="telefono_caso_accidente" placeholder="" style="display: inline-block;" value="<?php echo $crow['telefono_caso_accidente'] ?>">
            </div>
            <div class="col-md-1 col-xs-1">
              <!-- VACIO -->
            </div>
          </div>



          <div class="row top-buffer">
            <div class="col-md-1 col-xs-1">
              <!-- VACIO -->
            </div>

            <div class="col-md-10 col-xs-10 text-center">
              <small><small>
                  <label style="font-style:italic;">ME COMPROMETO A INFORMAR CUALQUIERCAMBIO DE LOS DATOS ANTES MENCIONADOS, ESTANDO DE ACUERDO QUE PUEDEN SER VERIFICADOS, CONOCIENDO LA SANCIÓN ADMINISTRATIVA EN CASO DE PROPORCIONAR DATOS FALSOS</label>
                </small></small>
            </div>

            <div class="col-md-1 col-xs-1">
              <!-- VACIO -->
            </div>
          </div>

          <br>

          <div class="row top-buffer">
            <div class="col-md-4 col-xs-4">
              <!-- VACIO -->
            </div>

            <div class="col-md-4 col-xs-4 text-center" style="border-top: #000 0PX SOLID;">
              <input type="text" class="inputFormulario text-center" name="firma" id="firma" placeholder="" style="display: inline-block;" value="<?php echo $crow['curp'] ?>">
              <label>FIRMA DEL TRABAJADOR</label>

            </div>

            <div class="col-md-4 col-xs-4">
              <!-- VACIO -->
            </div>
          </div>




          <div class="row" style="margin-top:50 px;">
            <div class="col-md-9 col-xs-9 text-left">
              <small>
                <label>NOTA: SE DEBE ADJUNTAR COPIA DE CREDENCIAL DE ELECTOR Y COMPROBANTE DE DOMICILIO</label>
              </small>
            </div>



            <div class="col-md-3 col-xs-3 text-right">
              <small><B>
                  <label style="position: relative; bottom:-40PX;">1A12-009-120</label>
                </B></small>
            </div>
          </div>


        </div>
      </div>
    </main>
   
    <!-- JS -->
        <!-- <script src="https://framework-gb.cdn.gob.mx/gobmx.js"></script>-->

  </body>


  </html>

  <?php
}
?>


 <!--
 <style>
        /* Estilos específicos para la impresión */
        @media print {
            /* Define la escala para imprimir al 96% */
            body {
                transform: scale(0.98);
                transform-origin: top left;
            }
            
            /* Evita que ciertos elementos se muestren en la impresión */
            .no-print {
                display: none;
            }
            
            /* Configura la impresión de la primera página */
            @page {
                size: auto; /* Tamaño de página automático */
                margin: 10; /* Sin márgenes */
                page-break-before: always; /* Siempre rompe página antes del contenido */
            }
        }
    </style>-->





<?php
}
?>
