<?php
session_start();
$user_id = $_SESSION['user_id']['id'];
$role_id = $_SESSION['role_id'];
include("conexion.php");
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

?>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

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
                  <button class="navbar-brand sub-navbar" id="btnPrint">Descargar</button>

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
<iframe src="a.pdf" frameborder="0" style="height: 500px;width: 50%" id="iframe"></iframe>

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
      window.onload = function() {

          const json = <?php echo json_encode($resultado->fetch_assoc()); ?>;
          // console.log(JSON.stringify(json));
          // {
          //     adscripcion
          //         :
          //         "Direccion Juridica"
          //     calle
          //         :
          //         "Flores"
          //     categoria
          //         :
          //         "COORD PROYECTO E1"
          //     ciudad
          //         :
          //         "Alvaro Obregon"
          //     ciudad_nac
          //         :
          //         "909"
          //     codigo_postal
          //         :
          //         "01020"
          //     colonia
          //         :
          //         "Bugambilias"
          //     curp
          //         :
          //         "LICO750713MMFZZD05"
          //     email_institucional
          //         :
          //         "jaime.licona@gmail.com"
          //     email_particular
          //         :
          //         "jaime.licona@gmail.com"
          //     escolaridad
          //         :
          //         "LICENCIATURA"
          //     estado
          //         :
          //         "Ciudad de Mexico"
          //     estado_civil
          //         :
          //         "SOLTERO(A)"
          //     estado_nac
          //         :
          //         "17"
          //     estadon
          //         :
          //         "Morelos"
          //     fecha_de_alta
          //         :
          //         "2024-07-13"
          //     matricula
          //         :
          //         123456789
          //     municipio
          //         :
          //         "Alvaro Obregon"
          //     municipion
          //         :
          //         "Amacuzac"
          //     nombre
          //         :
          //         "LICONA FLORES JAIME"
          //     nombre_caso_accidente
          //         :
          //         "Diaz Rodriguez Jazmin"
          //     num_consultorio
          //         :
          //         9
          //     numero_ext
          //         :
          //         "23"
          //     numero_int
          //         :
          //         ""
          //     pais
          //         :
          //         "Mexico"
          //     parentesco
          //         :
          //         "Amigo(a)"
          //     poblacion
          //         :
          //         "Alvaro Obregon"
          //     telefono
          //         :
          //         "(555)1234567"
          //     telefono_caso_accidente
          //         :
          //         "(123)1234567"
          //     turno
          //         :
          //         "Matutino"
          //     umf
          //         :
          //         "22"
          //     user_id
          //         :
          //         1
          // }


          const iframe = document.getElementById('iframe');

          const { jsPDF } = window.jspdf;

          const doc = new jsPDF('p', 'mm', 'letter');

          doc.rect(10, 10, 196, 250)
          const img = new Image()
          img.src = 'img/b.jpg'
          doc.addImage(img, 'JPEG', 17, 12, 17, 17)
          subtitle('DIRECCIÓN DE ADMINITRACION', 40, 18)
          subtitle('ODAD', 40, 25)

          title('HOJAS DE DATOS PERSONALES', 160, 23)

          subtitle('NOMBRE', 15, 40)
          underline(`                                                     ${json.nombre}                                                `, 45, 40)
          textCenterMinus('APELLIDO PATERNO', 60, 44)
          textCenterMinus('APELLIDO MATERNO', 120, 44)
          textCenterMinus('NOMBRE(S)', 180, 44)

          subtitle('MATRICULA', 15, 50)
          underline(`        ${json.matricula}            `, 45, 50)
          subtitle('CATEGORIA', 90, 50)
            underline(`   ${json.categoria}    `, 120, 50)
            subtitle('E-MAIL PARTICULAR', 15, 60)
            underline(`             ${json.email_particular}             `, 70, 60)
            subtitle('E-MAIL INSTITUCIONAL', 15, 70)
            underline(`             ${json.email_institucional}             `, 70, 70)
            subtitle('ESCOLARIDAD', 15, 80)
            underline(`             ${json.escolaridad}             `, 50, 80)
            subtitle('ESTADO CIVIL', 110, 80)
            underline(`             ${json.estado_civil}             `, 140, 80)

            subtitle('LUGAR DE NACIMIENTO', 15, 90)
          textCenterMinus('PAIS', 90, 93)
            textCenterMinus('ESTADO', 130, 93)
            textCenterMinus('CIUDAD', 180, 93)
            underline(`             ${json.pais}             `, 70, 90)
            underline(`             ${json.estadon}             `, 110, 90)
            underline(`             ${json.municipion}             `, 160, 90)

            subtitle('ADSRCIPCION', 15, 100)
            underline(`             ${json.adscripcion}             `, 50, 100)
            subtitle('TURNO', 110, 100)
            underline(`             ${json.turno}             `, 140, 100)

            subtitle('DOMICILIO PARTICULAR:', 15, 110)
            subtitle('CALLE', 15, 120)
            underline(`             ${json.calle}             `, 30, 120)
            subtitle('NUMERO EXTERIOR', 70, 120)
            underline(`             ${json.numero_ext}             `, 110, 120)
            subtitle('NUMERO INTERIOR', 140, 120)
            underline(`             ${json.numero_int}             `, 175, 120)

            subtitle('COLONIA', 15, 130)
            underline(`             ${json.colonia}             `, 40, 130)
            subtitle('ALCALDIA', 110, 130)
            underline(`             ${json.municipio}             `, 140, 130)

            subtitle('ESTADO', 15, 140)
            underline(`         ${json.estado}         `, 30, 140)
            subtitle('CIUDAD', 80, 140)
            underline(`        ${json.ciudad}          `, 95, 140)
            subtitle('POBLACION', 140, 140)
            underline(`        ${json.poblacion}       `, 165, 140)

            subtitle('C. P.', 15, 150)
            underline(`        ${json.codigo_postal}        `, 30, 150)
            subtitle('TELEFONO', 70, 150)
            underline(`        ${json.telefono}        `, 100, 150)

            subtitle('UMF', 15, 160)
            underline(`        ${json.umf}        `, 30, 160)
            subtitle('NUMERO DE CONSULTORIO', 70, 160)
            underline(`        ${json.num_consultorio}        `, 120, 160)

            subtitle('EN CASO DE ACCIDENTE FAVOR DE AVISAR A:', 15, 170)

            subtitle('NOMBRE(S)', 15, 180)
            underline(`                                              ${json.nombre_caso_accidente}                                              `, 40, 180)
            subtitle('PARENTESCO', 15, 190)
            underline(`       ${json.parentesco}                `, 40, 190)
            subtitle('TELEFONO', 90, 190)
            underline(`       ${json.telefono_caso_accidente}                `, 120, 190)

          titleFoot('ME COMPROMETO A INFORMAR CUALQUIERCAMBIO DE LOS DATOS ANTES MENCIONADOS, ESTANDO DE ACUERDO QUE PUEDEN SER VERIFICADOS, CONOCIENDO LA SANCIÓN ADMINISTRATIVA EN CASO DE PROPORCIONAR DATOS FALSOS', 110, 200)

            text(`                  ${json.curp}                      `, 75, 235)
          titleFoot('________________________________________', 110, 235)
            titleFoot('FIRMA DE LA TRABAJADORA/TRABAJADOR', 110, 240)
          textMinusWithAuto('NOTA: SE DEBE ADJUNTAR COPIA DE CREDENCIAL DE ELECTOR Y COMPROBANTE DE DOMICILIO', 15, 255)
          text('Clave: 1A74-009-120', 170, 265)


          iframe.src = doc.output('datauristring');


          // Agrega un listener al botón para detectar el clic
          document.getElementById("btnPrint").addEventListener("click", function() {
              // window.print();
              const { jsPDF } = window.jspdf;

              const doc = new jsPDF('p', 'mm', 'letter');

              doc.rect(10, 10, 196, 115)
              const img = new Image()
              img.src = 'img/b.jpg'
              doc.addImage(img, 'JPEG', 5, 12, 17, 17)

              doc.save("direccion.pdf");
              // iframe

          });
          function titleFoot(text,x,y) {
              doc.setFontSize(10)
              doc.setFont('helvetica', 'bold')
              doc.text(x, y, text, {maxWidth: 190, align: 'center'})
          }
          function title(text,x,y) {
              doc.setFontSize(10)
              doc.setFont('helvetica', 'bold')
              doc.text(x, y, text, {maxWidth: 60, align: 'center'})
          }
          function subtitle(text,x,y) {
              doc.setFontSize(10)
              doc.setFont('helvetica', 'bold')
              doc.text(x, y, text)
          }
          function text(text,x,y) {
              doc.setFontSize(10)
              doc.setFont('helvetica', 'normal')
              doc.text(x, y, text, {maxWidth: 190})
          }
          function textCenter(text,x,y) {
              doc.setFontSize(10)
              doc.setFont('helvetica', 'normal')
              doc.text(x, y, text, null, null, 'center')
          }
          function textCenterMinus(text,x,y) {
              doc.setFontSize(7)
              doc.setFont('helvetica', 'normal')
              doc.text(x, y, text, null, null, 'center')
          }
          function underline(text,x,y) {

              doc.setFontSize(10)
              doc.setFont('helvetica', 'normal')
              const levelCentralText = text
              const levelCentralX = x
              const levelCentralY = y
              doc.text(levelCentralX, levelCentralY, levelCentralText)
              const textWidth = doc.getTextWidth(levelCentralText)
              doc.setLineWidth(0.2)
              doc.line(levelCentralX, levelCentralY + 1, levelCentralX + textWidth, levelCentralY + 1)
          }
          function textMinusWithAuto(text,x,y) {
              doc.setFontSize(7)
              doc.setFont('helvetica', 'normal')
              doc.text(x, y, text, {maxWidth: 190})
          }
          function underlineBold(text,x,y) {
              doc.setFontSize(10)
              doc.setFont('helvetica', 'bold')
              const levelCentralText = text
              const levelCentralX = x
              const levelCentralY = y
              doc.text(levelCentralX, levelCentralY, levelCentralText)
              const textWidth = doc.getTextWidth(levelCentralText)
              doc.setLineWidth(0.2)
              doc.line(levelCentralX, levelCentralY + 1, levelCentralX + textWidth, levelCentralY + 1)
          }
      }
    </script>
<script>
        // Función que se ejecuta antes de imprimir
        window.onbeforeprint = function() {
            alert("No olvides firmar con tinta azul en el apartado donde aparece tu CURP y entregar a la Coordinación Administrativa.");
        };
    </script>
