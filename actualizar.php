<?php include "php/navbar.php"; ?>

<?php
include("conexion.php");

session_start();
if (!isset($_SESSION['user_id']['id']) || empty($_SESSION['user_id']['id'])) {
    // La variable $_SESSION['user_id']['id'] no es válida
    print "<script>alert(\"ID de usuario no válido\");</script>";
    exit();
}

$user_id = $_SESSION['user_id']['id'];
$role_id = $_SESSION['role_id'];

if ($role_id == 2) {
    // Usuario con role_id 2 (employee), solo puede ver su propia información
    $sql = "SELECT * FROM datos WHERE user_id = '$user_id'";
} elseif ($role_id == 1) {
    // Usuario con role_id 1 (admin), puede consultar cualquier registro
    if (isset($_GET['matricula']) && !empty($_GET['matricula'])) {
        $matricula = $_GET['matricula'];
    } else {
        // No se proporcionó una matrícula válida
        print "<script>alert(\"No se proporcionó una matrícula válida\");</script>";
        exit();
    }
    $sql = "SELECT * FROM datos WHERE matricula = '$matricula'";
} else {
    // Role inválido
    print "<script>alert(\"Rol inválido\");</script>";
    print "<script>window.location='../login.php';</script>";
    exit(); // Salir para evitar que se siga ejecutando
}

// Resto del código...

$query = mysqli_query($con, $sql);
$row = mysqli_fetch_array($query);



// Obtener el ID del estado y municipio desde la tabla 'datos'
$id_estado = $row['estado_nac'];
$id_municipio = $row['ciudad_nac'];

// Consulta para obtener el estado correspondiente
$sql_estado = "SELECT * FROM cat_estados WHERE id_estado = $id_estado";
$result_estado = $con->query($sql_estado);
$row_estado = $result_estado->fetch_assoc();

// Consulta para obtener el municipio correspondiente
$sql_municipio = "SELECT * FROM cat_municipios WHERE id_mun = $id_municipio";
$result_municipio = $con->query($sql_municipio);
$row_municipio = $result_municipio->fetch_assoc();


?>

<!-- Aquí continúa tu código HTML/PHP para mostrar los datos obtenidos -->



<!DOCTYPE html>
<html lang="es">

<head>
    <title>.: ACTUALIZAR | DATOS :.</title>
    <!--Estilos para que funcione de manera horizontal-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>


    <!-- Para que funcione el functions.js -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



    <script type="text/javascript" src="jquery-1.12.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="jquery-ui.css">
    <script type="text/javascript" src="jquery-ui.js"></script>
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">


    <!-- Para la selección del estado -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>


    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.js"></script>





    <script type="text/javascript">
        $(document).ready(function() {
            $('.delete').click(function() {
                var parent = $(this).parent().attr('user_id');
                var service = $(this).parent().attr('data');
                var dataString = 'id=' + service;

                $.ajax({
                    type: "POST",
                    url: "del_file.php",
                    data: dataString,
                    success: function() {
                        location.reload();
                    }
                });
            });
        });
    </script>



    <style>
        .centered-placeholder::placeholder {
            text-align: center;
            color: #220328;
        }
    </style>


</head>

<body>
    <div class="container">
        <form action="update.php" method="POST" enctype="multipart/form-data" autocomplete="off">

            <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
            <input type="hidden" id="id_mun" name="id_mun">

            <div class="form-group">
                <label for="matricula">Matricula</label>
                <input readonly type="text" class="form-control mb-3" name="matricula" placeholder="Matrícula" value="<?php echo isset($row['matricula']) ? $row['matricula'] : ''; ?>">
            </div>

            <div class="form-group">
                <label for="nombre" ">Nombre</label>
                    <input readonly type=" text" class="form-control mb-3" name="nombre" placeholder="Nombre" value="<?php echo isset($row['nombre']) ? $row['nombre'] : 'Nombre no disponible'; ?>">
            </div>

            <div class="form-group">
                <label for="categoria">Categoria</label>
                <input onKeyUp="this.value=this.value.toUpperCase();" type="text" class="form-control mb-3" name="categoria" placeholder="Categoría" value="<?php echo isset($row['categoria']) ? $row['categoria'] : 'Categoría no disponible'; ?>">
            </div>

            <div class="form-group">
                <label for="mail_particular">E-mail particular</label>
                <input type="text" onKeyUp="this.value=this.value.toLowerCase();"" class=" form-control mb-3" name="mail_particular" placeholder="mail_particular" value="<?php echo isset($row['email_particular']) ? $row['email_particular'] : 'Mail no disponible'; ?>">
            </div>


            <div class="form-group">
                <label for="mail_institucional">E-mail institucional</label>

                <input type="text" onKeyUp="this.value=this.value.toLowerCase();" class="form-control mb-3" name="mail_institucional" placeholder="mail_institucional" value="<?php echo isset($row['email_institucional']) ? $row['email_institucional'] : 'Mail no disponible'; ?>">

            </div>

            <div class="form-group">
                <label for="escolaridad">Escolaridad</label>

                <?php if (empty($row['escolaridad'])) { ?>
                    <p>No hay dato registrado</p>
                <?php } else { ?>
                    <select class="form-control" id="escolaridad" name="escolaridad">
                        <option value="PRIMARIA" <?php if ($row['escolaridad'] == 'PRIMARIA') echo 'selected'; ?>>PRIMARIA</option>
                        <option value="SECUNDARIA" <?php if ($row['escolaridad'] == 'SECUNDARIA') echo 'selected'; ?>>SECUNDARIA</option>
                        <option value="PREPARATORIA" <?php if ($row['escolaridad'] == 'PREPARATORIA') echo 'selected'; ?>>PREPARATORIA</option>
                        <option value="CARRERA TECNICA" <?php if ($row['escolaridad'] == 'CARRERA TECNICA') echo 'selected'; ?>>CARRERA TECNICA</option>
                        <option value="LICENCIATURA" <?php if ($row['escolaridad'] == 'LICENCIATURA') echo 'selected'; ?>>LICENCIATURA</option>
                        <option value="POSGRADO" <?php if ($row['escolaridad'] == 'POSGRADO') echo 'selected'; ?>>POSGRADO</option>
                    </select>
                <?php } ?>

            </div>

            <div class="form-group">
                <label for="area_escolar" class="col-sm-2 control-label">Profesión</label>

                <input type="text" onKeyUp="this.value=this.value.toUpperCase();" class="form-control mb-3" name="area_escolar" placeholder="Area de Escolaridad" value="<?php echo isset($row['area_escolar']) ? $row['area_escolar'] : 'Profesión no disponible'; ?>" required>

            </div>


            <div class="form-group">
                <label for="edo_civil">Estado Civil</label>
                <?php if (empty($row['estado_civil'])) { ?>
                    <p>No hay dato registrado</p>
                <?php } else { ?>
                    <select class="form-control" id="edo_civil" name="edo_civil" required>
                        <option value="SOLTERO(A)" <?php if ($row['estado_civil'] == 'SOLTERO(A)') echo 'selected'; ?>>SOLTERO(A)</option>
                        <option value="CASADO(A)" <?php if ($row['estado_civil'] == 'CASADO(A)') echo 'selected'; ?>>CASADO(A)</option>
                        <option value="UNIÓN LIBRE" <?php if ($row['estado_civil'] == 'UNIÓN LIBRE') echo 'selected'; ?>>UNIÓN LIBRE</option>
                        <option value="VIUDO(A)" <?php if ($row['estado_civil'] == 'VIUDO(A)') echo 'selected'; ?>>VIUDO(A)</option>
                        <option value="SEPARADO(A)" <?php if ($row['estado_civil'] == 'SEPARADO(A)') echo 'selected'; ?>>SEPARADO(A)</option>
                    </select>
                <?php } ?>
            </div>

            <div class="form-group">
                <label for="pais_nac">Lugar de nacimiento</label>

                <?php if (empty($row['pais'])) { ?>
                    <p>No hay dato registrado</p>
                <?php } else { ?>
                    <select class="form-control mb-3" id="pais_nac" name="pais_nac" required>>
                        <option value="0">Selecciona País</option>
                        <option value="Mexico" <?php if ($row['pais'] == 'Mexico') echo 'selected'; ?>>Mexico</option>
                    </select>
                <?php } ?>

            </div>
            <div class="form-group">
                <label for="edo_nac">Estado</label>
                <select class="form-control" id="edo_nac" name="edo_nac" size="1" style="width: auto;" required>
                    <option value="0">Selecciona Estado</option>
                    <!-- Mostrar el estado precargado -->
                    <option value="<?php echo $row_estado['id_estado']; ?>" selected><?php echo $row_estado['estado']; ?></option>
                    <!-- Agrega aquí tus opciones de estados -->

                    <?php
                    // Realizar una consulta SQL para obtener los estados
                    $sql_estados = "SELECT id_estado, estado FROM cat_estados";
                    $result_estados = $con->query($sql_estados);

                    // Verificar si se encontraron estados
                    if ($result_estados->num_rows > 0) {
                        // Iterar sobre los resultados y generar las opciones
                        while ($row = $result_estados->fetch_assoc()) {
                            // Imprimir una opción para cada estado
                            echo "<option value='" . $row['id_estado'] . "'>" . $row['estado'] . "</option>";
                        }
                    } else {
                        // En caso de que no se encuentren estados, puedes mostrar un mensaje o simplemente dejar el campo vacío
                        echo "<option value='0'>No se encontraron estados</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="municipio">Ciudad</label>
                <select class="form-control" id="municipio" name="municipio" size="1" style="width: auto;" required>
                    <option value="0">Selecciona Ciudad</option>
                    <!-- Mostrar el municipio precargado -->
                    <option value="<?php echo $row_municipio['id_mun']; ?>" selected><?php echo $row_municipio['municipio']; ?></option>
                </select>
            </div>

            <?php
            $query = mysqli_query($con, $sql);
            $row = mysqli_fetch_array($query);
            ?>

            <div class="form-group">
                <label for="adscripcion">Adscripción</label>
                <input readonly type="text" class="form-control mb-3" name="adscripcion" placeholder="Adscripción" value="<?php echo isset($row['adscripcion']) ? $row['adscripcion'] : 'Adscripción no disponible'; ?>">
            </div>



            <div class="form-group">
                <label for="turno">Turno</label>
                <select class="form-control mb-3" id="turno" name="turno">
                    <option value="0">Selecciona Turno</option>
                    <option value="Matutino" <?php if ($row['turno'] == 'Matutino') echo 'selected'; ?>>Matutino</option>
                    <option value="Vespertino" <?php if ($row['turno'] == 'Vespertino') echo 'selected'; ?>>Vespertino</option>
                </select>
            </div>

            <div class="form-group">
                <label for="curp">CURP</label>

                <input type="text" onKeyUp="this.value=this.value.toUpperCase();" class="form-control mb-3" name="curp" placeholder="Clave Única de Registro de Población" value="<?php echo isset($row['curp']) ? $row['curp'] : 'Curp no disponible'; ?>">

            </div>


            <!-------------------------------------------------------------------DOMICILIO PARTICULAR---------------------------------------------------------------------------------- -->

            <div class="form-group">
                <label for="comodin" class="col-sm-2 control-label"></label>

                <input type="text" class="form-control mb-3 centered-placeholder" placeholder="DOMICILIO PARTICULAR" readonly>

            </div>

            <div class="form-group">
                <label for="calle">Calle</label>

                <input type="text" class="form-control mb-3" name="calle" placeholder="Calle" value="<?php echo isset($row['calle']) ? $row['calle'] : 'Calle no disponible'; ?>">

            </div>

            <div class="form-group">
                <label for="num_ext">Número Ext</label>

                <input type="text" class="form-control mb-3" name="num_ext" placeholder="Número exterior" value="<?php echo isset($row['numero_ext']) ? $row['numero_ext'] : 'No disponible'; ?>">

            </div>

            <div class="form-group">
                <label for="num_int">Número Int</label>

                <input type="text" class="form-control mb-3" name="num_int" placeholder="Número interior" value="<?php echo isset($row['numero_int']) ? $row['numero_int'] : 'No disponible'; ?>">

            </div>

            <div class="form-group">
                <label for="colonia">Colonia</label>

                <input type="text" class="form-control mb-3" name="colonia" placeholder="Colonia" value="<?php echo isset($row['colonia']) ? $row['colonia'] : ' Colonia no disponible'; ?>">

            </div>

            <div class="form-group">
                <label for="edo_dom">Estado</label>

                <select class="form-control" id="edo_dom" name="edo_dom" required>
                    <option value="0">Selecciona Estado</option>
                    <option value="Aguascalientes" <?php if (trim($row['estado']) == 'Aguascalientes') echo 'selected'; ?>>Aguascalientes</option>
                    <option value="Baja California" <?php if (trim($row['estado']) == 'Baja California') echo 'selected'; ?>>Baja California</option>
                    <option value="Baja California Sur" <?php if (trim($row['estado']) == 'Baja California Sur') echo 'selected'; ?>>Baja California Sur</option>
                    <option value="Campeche" <?php if (trim($row['estado']) == 'Campeche') echo 'selected'; ?>>Campeche</option>
                    <option value="Coahuila De Zaragoza"" <?php if (trim($row['estado']) == 'Coahuila De Zaragoza"') echo 'selected'; ?>>Coahuila De Zaragoza" </option>
                    <option value="Colima" <?php if (trim($row['estado']) == 'Colima') echo 'selected'; ?>>Colima</option>
                    <option value="Chiapas" <?php if (trim($row['estado']) == 'Chiapas') echo 'selected'; ?>>Chiapas</option>
                    <option value="Chihuahua" <?php if (trim($row['estado']) == 'Chihuahua') echo 'selected'; ?>>Chihuahua</option>
                    <option value="Ciudad de Mexico" <?php if (trim($row['estado']) == 'Ciudad de Mexico') echo 'selected'; ?>>Ciudad de Mexico</option>
                    <option value="Durango" <?php if (trim($row['estado']) == 'Durango') echo 'selected'; ?>>Durango</option>
                    <option value="Guanajuato" <?php if (trim($row['estado']) == 'Guanajuato') echo 'selected'; ?>>Guanajuato</option>
                    <option value="Guerrero" <?php if (trim($row['estado']) == 'Guerrero') echo 'selected'; ?>>Guerrero</option>
                    <option value="Hidalgo" <?php if (trim($row['estado']) == 'Hidalgo') echo 'selected'; ?>>Hidalgo</option>
                    <option value="Jalisco" <?php if (trim($row['estado']) == 'Jalisco') echo 'selected'; ?>>Jalisco</option>
                    <option value="Mexico" <?php if (trim($row['estado']) == 'Mexico') echo 'selected'; ?>>Mexico</option>
                    <option value="Michoacán de Ocampo" <?php if (trim($row['estado']) == 'Michoacán de Ocampo') echo 'selected'; ?>>Michoacán de Ocampo</option>
                    <option value="Morelos" <?php if (trim($row['estado']) == 'Morelos') echo 'selected'; ?>>Morelos</option>
                    <option value="Nayarit" <?php if (trim($row['estado']) == 'Nayarit') echo 'selected'; ?>>Nayarit</option>
                    <option value="Nuevo Leon" <?php if (trim($row['estado']) == 'Nuevo Leon') echo 'selected'; ?>>Nuevo Leon</option>
                    <option value="Oaxaca" <?php if (trim($row['estado']) == 'Oaxaca') echo 'selected'; ?>>Oaxaca</option>
                    <option value="Puebla" <?php if (trim($row['estado']) == 'Puebla') echo 'selected'; ?>>Puebla</option>
                    <option value="Queretaro" <?php if (trim($row['estado']) == 'Queretaro') echo 'selected'; ?>>Queretaro</option>
                    <option value="Quintana Roo" <?php if (trim($row['estado']) == 'Quintana Roo') echo 'selected'; ?>>Quintana Roo</option>
                    <option value="San Luis Potosi" <?php if (trim($row['estado']) == 'San Luis Potosi') echo 'selected'; ?>>San Luis Potosi</option>
                    <option value="Sinaloa" <?php if (trim($row['estado']) == 'Sinaloa') echo 'selected'; ?>>Sinaloa</option>
                    <option value="Sonora" <?php if (trim($row['estado']) == 'Sonora') echo 'selected'; ?>>Sonora</option>
                    <option value="Tabasco" <?php if (trim($row['estado']) == 'Tabasco') echo 'selected'; ?>>Tabasco</option>
                    <option value="Tamaulipas" <?php if (trim($row['estado']) == 'Tamaulipas') echo 'selected'; ?>>Tamaulipas</option>
                    <option value="Tlaxcala" <?php if (trim($row['estado']) == 'Tlaxcala') echo 'selected'; ?>>Tlaxcala</option>
                    <option value="Veracruz De Ignacio De La Llave" <?php if (trim($row['estado']) == 'Veracruz De Ignacio De La Llave') echo 'selected'; ?>>Veracruz De Ignacio De La Llave</option>
                    <option value="Yucatan" <?php if (trim($row['estado']) == 'Yucatan') echo 'selected'; ?>>Yucatan</option>
                    <option value="Zacatecas" <?php if (trim($row['estado']) == 'Zacatecas') echo 'selected'; ?>>Zacatecas</option>
                </select>

            </div>


            <div class="form-group">
                <label for="municipio2">Delegación o Municipio</label>

                <input type="text" class="form-control mb-3" name="municipio2" placeholder="municipio2" value="<?php echo isset($row['ciudad']) ? trim($row['ciudad']) : 'Municipio no disponible'; ?>">

                <div id="suggestions"></div> <!-- Aquí se mostrarán las sugerencias de autocompletado -->

            </div>


            <div class="form-group">
                <label for="ciudad">Ciudad</label>

                <?php
                $ciudadValue = isset($row['ciudad']) ? trim($row['ciudad']) : 'Ciudad no disponible';
                ?>
                <input type="text" class="form-control mb-3" name="ciudad" placeholder="Ciudad de residencia" value="<?php echo $ciudadValue; ?>" required>

            </div>


            <div class="form-group">
                <label for="poblacion">Poblacion</label>

                <input type="text" class="form-control mb-3" name="poblacion" placeholder="Población" value="<?php echo isset($row['poblacion']) ? $row['poblacion'] : 'No disponible'; ?>">

            </div>

            <div class="form-group">
                <label for="codigo_postal">Código Postal</label>

                <input type="text" pattern="[0-9]{5}" title="El código postal debe ser un número de 5 dígitos" class="form-control mb-3" name="codigo_postal" placeholder="Código Postal" value="<?php echo isset($row['codigo_postal']) ? $row['codigo_postal'] : 'No disponible'; ?>" required>

            </div>

            <div class="form-group">
                <label for="telefono">Telefono</label>
                <input type="tel" name="telefono" pattern="\([0-9]{3}\)[0-9]{3}[0-9]{4}" title="Un número de teléfono válido consta de un código de 3 
        dígitos entre paréntesis, posterior los 7 digitos más" class="form-control mb-3" name="telefono" placeholder="(123)123456789" value="<?php echo isset($row['telefono']) ? $row['telefono'] : 'No disponible'; ?>">
            </div>


            <div class="form-group">
                <label for="umf">UMF</label>

                <input type="text" class="form-control mb-3" name="umf" placeholder="Unidad Médica Familiar " value="<?php echo isset($row['umf']) ? $row['umf'] : 'No disponible'; ?>">

            </div>


            <div class="form-group">
                <label for="num_consultorio">Número de Consultorio</label>

                <input type="text" class="form-control mb-3" name="num_consultorio" placeholder="Número de Consultorio" value="<?php echo isset($row['num_consultorio']) ? $row['num_consultorio'] : 'No disponible'; ?>">

            </div>

            <!-------------------------------------------------EN CASO DE ACCIDENTE FAVOR DE AVISAR A ---------------------------------------------------------------------------------- -->

            <div class="form-group">
                <label for="comodin"></label>

                <input type="text" class="form-control mb-3 centered-placeholder" placeholder="EN CASO DE ACCIDENTE FAVOR DE AVISAR A:" readonly>

            </div>

            <div class="form-group">
                <label for="nombre_acc">Nombre</label>

                <input type="text" class="form-control mb-3" name="nombre_acc" placeholder="En caso de accidente avisar a:" value="<?php echo isset($row['nombre_caso_accidente']) ? $row['nombre_caso_accidente'] : 'No disponible'; ?>">

            </div>


            <div class="form-group">
                <label for="parentesco">Parentesco</label>

                <?php if (empty($row['parentesco'])) { ?>
                    <p>No hay dato registrado</p>
                <?php } else { ?>
                    <select class="form-control" id="parentesco" name="parentesco" required>

                        <option value="Madre" <?php if ($row['parentesco'] == 'Madre') echo 'selected'; ?>>Madre</option>
                        <option value="Padre" <?php if ($row['parentesco'] == 'Padre') echo 'selected'; ?>>Padre</option>
                        <option value="Primo(a)" <?php if ($row['parentesco'] == 'Primo(a)') echo 'selected'; ?>>Primo(a)</option>
                        <option value="Hijo(a)" <?php if ($row['parentesco'] == 'Hijo(a)') echo 'selected'; ?>>Hijo(a)</option>
                        <option value="Hermano(a)" <?php if ($row['parentesco'] == 'Hermano(a)') echo 'selected'; ?>>Hermano(a)</option>
                        <option value="Esposo(a)" <?php if ($row['parentesco'] == 'Esposo(a)') echo 'selected'; ?>>Esposo(a)</option>
                        <option value="Concubino(a)" <?php if ($row['parentesco'] == 'Concubino(a)') echo 'selected'; ?>>Concubino(a)</option>
                        <option value="Amigo(a)" <?php if ($row['parentesco'] == 'Amigo(a)') echo 'selected'; ?>>Amigo(a)</option>
                        <option value="Tio(a)" <?php if ($row['parentesco'] == 'Tio(a)') echo 'selected'; ?>>Tio(a)</option>
                    </select>

                <?php } ?>

            </div>

            <div class="form-group">
                <label for="telefono_urg">Telefono (s) (555)1234567 </label>

                <input type="text" pattern="\([0-9]{3}\)[0-9]{3}[0-9]{4}" title="Un número de teléfono válido consta de un código de 3 
        dígitos entre paréntesis, posterior los 7 digitos más" class="form-control mb-3" name="telefono_urg" placeholder="(3 digitos)9 digitos" value="<?php echo isset($row['telefono_caso_accidente']) ? $row['telefono_caso_accidente'] : 'No disponible'; ?>" required>

            </div>
            <br>

            <!-------------------------------------------------COMPROBANTES EN PDF---------------------------------------------------------------------------------- -->

            <div class="form-group">
                <label for="comodin"></label>

                <input type="text" class="form-control mb-3 centered-placeholder" placeholder="COMPROBANTES EN FORMATO PDF" readonly>

            </div>

            <div class="form-group">
                <span for="ine">INE (ine en formato pdf)</span>
                <input type="file" title="El formato con el nombre: ine.pdf, de lo contrario no se guardará." class="form-control" id="ine" name="ine">

                <?php
                $query2 = "SELECT id FROM datos WHERE user_id = $user_id";
                $result = $con->query($query2);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $datos_id = $row["id"];
                    }
                }

                $path = "files/" . $datos_id; // Cambiado a $datos_id
                $ineFilename = "ine.pdf";
                //echo "ID de usuario actual: " . $datos_id;

                if (file_exists($path)) {
                    $directorio = opendir($path);
                    while ($ine = readdir($directorio)) {
                        if (!is_dir($ine) && $ine === $ineFilename) {

                            echo "<div data='" . $path . "/" . $ine . "'><a href='" . $path . "/" . $ine . "' title='Ver Archivo INE' target='_blank'><img src='images/pdf_f.jpg' width='17'></a>";
                            //echo "$comp_domicilio <a href='#' class='delete' title='Ver Archivo Adjunto' ><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></a></div>";
                            echo "<img src='files/$datos_id/$ine' width='10' />";
                        }
                    }
                }
                ?>
            </div>




            <div class="form-group">
                <span for="comp_domicilio">COMPROBANTE DE DOMICILIO (domicilio en formato pdf)</span>

                <input type="file" title="El formato con el nombre: domicilio.pdf, de lo contrario no se guardará." class="form-control" id="comp_domicilio" name="comp_domicilio">

                <?php
                $query2 = "SELECT id FROM datos WHERE user_id = $user_id";
                $result = $con->query($query2);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $datos_id = $row["id"];
                    }
                }

                $path = "files/" . $datos_id; // Cambiado a $datos_id
                $domicilioFilename = "domicilio.pdf";
                //echo "ID de usuario actual: " . $datos_id;

                if (file_exists($path)) {
                    $directorio = opendir($path);
                    while ($comp_domicilio = readdir($directorio)) {
                        if (!is_dir($comp_domicilio) && $comp_domicilio === $domicilioFilename) {

                            echo "<div data='" . $path . "/" . $comp_domicilio . "'><a href='" . $path . "/" . $comp_domicilio . "' title='Ver Archivo Domicilio' target='_blank'><img src='images/pdf_f.jpg' width='17'></a>";
                            //echo "$comp_domicilio <a href='#' class='delete' title='Ver Archivo Adjunto' ><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></a></div>";
                            echo "<img src='files/$datos_id/$comp_domicilio' width='10' />";
                        }
                    }
                }
                ?>
            </div>


            

            <div class="form-group">
                <span for="escolaridad">COMPROBANTE DE GRADO DE ESTUDOS (escolaridad en formato pdf)</span>

                <input type="file" title="El formato con el nombre: escolaridad.pdf, de lo contrario no se guardará." class="form-control" id="escolaridad" name="escolaridad">

                <?php
                $query2 = "SELECT id FROM datos WHERE user_id = $user_id";
                $result = $con->query($query2);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $datos_id = $row["id"];
                    }
                }

                $path = "files/" . $datos_id; // Cambiado a $datos_id
                $escolaridadFilename = "escolaridad.pdf";
                //echo "ID de usuario actual: " . $datos_id;

                if (file_exists($path)) {
                    $directorio = opendir($path);
                    while ($escolaridad = readdir($directorio)) {
                        if (!is_dir($escolaridad) && $escolaridad === $escolaridadFilename) {

                            echo "<div data='" . $path . "/" . $escolaridad . "'><a href='" . $path . "/" . $escolaridad . "' title='Ver Archivo Grado Escolar' target='_blank'><img src='images/pdf_f.jpg' width='17'></a>";
                            //echo "$comp_domicilio <a href='#' class='delete' title='Ver Archivo Adjunto' ><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></a></div>";
                            echo "<img src='files/$datos_id/$escolaridad' width='10' />";
                        }
                    }
                }
                ?>
            </div>

            <div class="form-group">
                <label for="comodin"></label>

                <input type="text" class="form-control mb-3 centered-placeholder" placeholder="Es importante subir la actualización de los documentos" readonly>

            </div>

    </div>

    <br>
    <div style="display: flex; justify-content: center;">
        <div class="row">
            <div class="col-md-3 form-group">
                <button type="submit" name="enviar" title="Enviar" class="btn btn-primary">Enviar información</button>
            </div>
        </div>
    </div>
    </form>

    <!--<center><input type="submit" class="btn btn-primary btn-block" value="Actualizar"></center>-->


</body>

</html>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#edo_nac').change(function() {
            var estadoID = $(this).val();
            $.ajax({
                type: 'POST',
                url: 'get_municipios.php', // Archivo PHP que procesará la solicitud
                data: {
                    estado_id: estadoID
                },
                success: function(response) {
                    $('#municipio').html(response);
                }
            });
        });
    });
</script>