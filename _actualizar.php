<?php include "php/navbar.php"; ?>
<?php
include("conexion.php");

session_start();
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id']['id'])) {
    // La variable $_SESSION['user_id'] no es válida
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

$query = mysqli_query($con, $sql);
$row = mysqli_fetch_array($query);
?>

<!-- Aquí continúa tu código HTML/PHP para mostrar los datos obtenidos -->



<!DOCTYPE html>
<html lang="es">

<head>
    <title>.: ACTUALIZAR | DATOS :.</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <script>
        var estado_previo = "<?php echo $row['estado_nac']; ?>";
        var municipio_previo = "<?php echo $row['ciudad_nac']; ?>";
        var estado_domicilio = "<?php echo trim($row['estado']); ?>";
        var municipio_domicilio = "<?php echo trim($row['municipio']); ?>";
    </script>

    <script src="functions.js"></script>
    <script type="text/javascript" src="jquery-1.12.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="jquery-ui.css">
    <script type="text/javascript" src="jquery-ui.js"></script>
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Para la selección del estado -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.js"></script>

    <script src="functions.js"></script>
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
    <div class="container mt-5">
        <form action="update.php" method="POST" enctype="multipart/form-data" autocomplete="off">

            <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
            <input type="hidden" id="id_mun" name="id_mun">

            <div class="form-group">
                <label for="matricula" class="col-sm-2 control-label">Matricula</label>
                <div class="col-sm-10">

                    <input readonly type="text" class="form-control mb-3" name="matricula" placeholder="Matrícula" value="<?php echo isset($row['matricula']) ? $row['matricula'] : ''; ?>">
                </div>
            </div>
            <br>


            <div class="form-group">
                <label for="nombre" class="col-sm-2 control-label">Nombre</label>
                <div class="col-sm-10">

                    <input readonly type="text" class="form-control mb-3" name="nombre" placeholder="Nombre" value="<?php echo isset($row['nombre']) ? $row['nombre'] : 'Nombre no disponible'; ?>">
                </div>
            </div>
            <br>


            <div class="form-group">
                <label for="categoria" class="col-sm-2 control-label">Categoria</label>
                <div class="col-sm-10">

                    <input type="text" class="form-control mb-3" name="categoria" placeholder="Categoría" value="<?php echo isset($row['categoria']) ? $row['categoria'] : 'Categoría no disponible'; ?>">
                </div>
            </div>
            <br>


            <div class="form-group">
                <label for="mail_particular" class="col-sm-2 control-label">E-mail particular</label>
                <div class="col-sm-10">
                    <input type="text" onKeyUp="this.value=this.value.toLowerCase();"" class=" form-control mb-3" name="mail_particular" placeholder="mail_particular" value="<?php echo isset($row['email_particular']) ? $row['email_particular'] : 'Mail no disponible'; ?>">
                </div>
            </div>


            <div class="form-group">
                <label for="mail_institucional" class="col-sm-2 control-label">E-mail institucional</label>
                <div class="col-sm-10">
                    <input type="text" onKeyUp="this.value=this.value.toLowerCase();" class="form-control mb-3" name="mail_institucional" placeholder="mail_institucional" value="<?php echo isset($row['email_institucional']) ? $row['email_institucional'] : 'Mail no disponible'; ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="escolaridad" class="col-sm-2 control-label">Escolaridad</label>
                <div class="col-sm-10">
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
            </div>

            <div class="form-group">
                <label for="area_escolar" class="col-sm-2 control-label">Profesión</label>
                <div class="col-sm-10">
                    <input type="text" onKeyUp="this.value=this.value.toUpperCase();" class="form-control mb-3" name="area_escolar" placeholder="Area de Escolaridad" value="<?php echo isset($row['area_escolar']) ? $row['area_escolar'] : 'Profesión no disponible'; ?>" required>
                </div>
            </div>


            <div class="form-group">
                <label for="edo_civil" class="col-sm-2 control-label">Estado Civil</label>
                <div class="col-sm-10">
                    <?php if (empty($row['estado_civil'])) { ?>
                        <p>No hay dato registrado</p>
                    <?php } else { ?>
                        <select class="form-control" id="edo_civil" name="edo_civil">

                            <option value="SOLTERO(A)" <?php if ($row['estado_civil'] == 'SOLTERO(A)') echo 'selected'; ?>>SOLTERO(A)</option>
                            <option value="CASADO(A)" <?php if ($row['estado_civil'] == 'CASADO(A)') echo 'selected'; ?>>CASADO(A)</option>
                            <option value="UNIÓN LIBRE" <?php if ($row['estado_civil'] == 'UNIÓN LIBRE') echo 'selected'; ?>>UNIÓN LIBRE</option>
                            <option value="VIUDO(A)" <?php if ($row['estado_civil'] == 'VIUDO(A)') echo 'selected'; ?>>VIUDO(A)</option>
                            <option value="SEPARADO(A)" <?php if ($row['estado_civil'] == 'SEPARADO(A)') echo 'selected'; ?>>SEPARADO(A)</option>
                        </select>
                    <?php } ?>
                </div>
            </div>

            <div class="form-group">
                <label for="pais_nac" class="col-sm-2 control-label">Lugar de nacimiento</label>
                <div class="col-sm-10">
                    <?php if (empty($row['pais'])) { ?>
                        <p>No hay dato registrado</p>
                    <?php } else { ?>
                        <select class="form-control mb-3" id="pais_nac" name="pais_nac">
                            <option value="0">Selecciona País</option>
                            <option value="Mexico" <?php if ($row['pais'] == 'Mexico') echo 'selected'; ?>>Mexico</option>
                        </select>
                    <?php } ?>
                </div>
            </div>

            <div class="form-group">
                <label for="edo_nac" class="col-sm-2 control-label">Estado</label>
                <div class="col-sm-10">
                    <select class="form-control" id="edo_nac" name="edo_nac" size="1" style="width: auto;">
                        <option value="0">Selecciona Estado</option>
                        <!-- Agrega aquí tus opciones de estados -->
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="municipio" class="col-sm-2 control-label">Ciudad</label>
                <div class="col-sm-10">
                    <select class="form-control" id="municipio" name="municipio" size="1" style="width: auto;">
                        <option value="0">Selecciona Ciudad</option>

                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="adscripcion" class="col-sm-2 control-label">Adscripción</label>
                <div class="col-sm-10">
                    <input readonly type="text" class="form-control mb-3" name="adscripcion" placeholder="Adscripción" value="<?php echo isset($row['adscripcion']) ? $row['adscripcion'] : 'Adscripción no disponible'; ?>">
                </div>
            </div>


            <div class="form-group">
                <label for="turno" class="col-sm-2 control-label">Turno</label>
                <div class="col-sm-10">
                    <select class="form-control mb-3" id="turno" name="turno">
                        <option value="0">Selecciona Turno</option>
                        <option value="Matutino" <?php if ($row['turno'] == 'Matutino') echo 'selected'; ?>>Matutino</option>
                        <option value="Vespertino" <?php if ($row['turno'] == 'Vespertino') echo 'selected'; ?>>Vespertino</option>
                    </select>

                </div>
            </div>

            <div class="form-group">
                <label for="curp" class="col-sm-2 control-label">CURP</label>
                <div class="col-sm-10">
                    <input type="text" onKeyUp="this.value=this.value.toUpperCase();" class="form-control mb-3" name="curp" placeholder="Clave Única de Registro de Población" value="<?php echo isset($row['curp']) ? $row['curp'] : 'Curp no disponible'; ?>">
                </div>
            </div>


            <!-------------------------------------------------------------------DOMICILIO PARTICULAR---------------------------------------------------------------------------------- -->

            <div class="form-group">
                <label for="comodin" class="col-sm-2 control-label"></label>
                <div class="col-sm-10">
                    <input type="text" class="form-control mb-3 centered-placeholder" placeholder="DOMICILIO PARTICULAR" readonly>
                </div>
            </div>

            <div class="form-group">
                <label for="calle" class="col-sm-2 control-label">Calle</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control mb-3" name="calle" placeholder="Calle" value="<?php echo isset($row['calle']) ? $row['calle'] : 'Calle no disponible'; ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="num_ext" class="col-sm-2 control-label">Número Ext</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control mb-3" name="num_ext" placeholder="Número exterior" value="<?php echo isset($row['numero_ext']) ? $row['numero_ext'] : 'No disponible'; ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="num_int" class="col-sm-2 control-label">Número Int</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control mb-3" name="num_int" placeholder="Número interior" value="<?php echo isset($row['numero_int']) ? $row['numero_int'] : 'No disponible'; ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="colonia" class="col-sm-2 control-label">Colonia</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control mb-3" name="colonia" placeholder="Colonia" value="<?php echo isset($row['colonia']) ? $row['colonia'] : ' Colonia no disponible'; ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="edo_nac" class="col-sm-2 control-label">Estado</label>
                <div class="col-sm-10">
                    <select class="form-control" id="edo_dom" name="edo_dom">
                        <option value="0">Selecciona Estado</option>
                        <option value="Aguascalientes">Aguascalientes</option>
                        <option value="Baja California">Baja California</option>
                        <option value="Baja California Sur">Baja California Sur</option>
                        <option value="Campeche">Campeche</option>
                        <option value="Coahuila De Zaragoza">Coahuila De Zaragoza</option>
                        <option value="Colima">Colima</option>
                        <option value="Chiapas">Chiapas</option>
                        <option value="Chihuahua">Chihuahua</option>
                        <option value="Ciudad de Mexico">Ciudad de Mexico</option>
                        <option value="Durango">Durango</option>
                        <option value="Guanajuato">Guanajuato</option>
                        <option value=Guerrero">Guerrero</option>
                        <option value="Hidalgo">Hidalgo</option>
                        <option value="Jalisco">Jalisco</option>
                        <option value="Mexico">Mexico</option>
                        <option value="Michoacan de Ocampo">Michoacan de Ocampo</option>
                        <option value="Morelos">Morelos</option>
                        <option value="Nayarit">Nayarit</option>
                        <option value="Nuevo Leon">Nuevo Leon</option>
                        <option value="Oaxaca">Oaxaca</option>
                        <option value="Puebla">Puebla</option>
                        <option value="Queretaro">Queretaro</option>
                        <option value="Quintana Roo">Quintana Roo</option>
                        <option value="San Luis Potosi">San Luis Potosi</option>
                        <option value="Sinaloa">Sinaloa</option>
                        <option value="Sonora">Sonora</option>
                        <option value="Tabasco">Tabasco</option>
                        <option value="Tamaulipas">Tamaulipas</option>
                        <option value="Tlaxcala">Tlaxcala</option>
                        <option value="Veracruz De Ignacio De La Llave">Veracruz De Ignacio De La Llave</option>
                        <option value="Yucatan">Yucatan</option>
                        <option value="Zacatecas">Zacatecas</option>
                    </select>
                </div>
            </div>


            <div class="form-group">
                <label for="municipio2" class="col-sm-2 control-label">Delegación o Municipio</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control mb-3" id="municipio2" name="municipio2" placeholder="Municipio">
                    <div id="suggestions"></div> <!-- Aquí se mostrarán las sugerencias de autocompletado -->
                </div>
            </div>


            <div class="form-group">
                <label for="ciudad" class="col-sm-2 control-label">Ciudad</label>
                <div class="col-sm-10">
                    <?php
                    $ciudadValue = isset($row['ciudad']) ? trim($row['ciudad']) : 'Ciudad no disponible';
                    ?>
                    <input type="text" class="form-control mb-3" name="ciudad" placeholder="Ciudad de residencia" value="<?php echo $ciudadValue; ?>">
                </div>
            </div>


            <div class="form-group">
                <label for="poblacion" class="col-sm-2 control-label">Poblacion</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control mb-3" name="poblacion" placeholder="Población" value="<?php echo isset($row['poblacion']) ? $row['poblacion'] : 'No disponible'; ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="codigo_postal" class="col-sm-2 control-label">Código Postal</label>
                <div class="col-sm-10">
                    <input type="text" pattern="[0-9]{5}" title="El código postal debe ser un número de 5 dígitos" class="form-control mb-3" name="codigo_postal" placeholder="Código Postal" value="<?php echo isset($row['codigo_postal']) ? $row['codigo_postal'] : 'No disponible'; ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="telefono" class="col-sm-2 control-label">Telefono</label>
                <div class="col-sm-10">
                    <input type="tel" name="telefono" pattern="\([0-9]{3}\)[0-9]{3}[0-9]{4}" title="Un número de teléfono válido consta de un código de 3 
        dígitos entre paréntesis, posterior los 7 digitos más" class="form-control mb-3" name="telefono" placeholder="(123)123456789" value="<?php echo isset($row['telefono']) ? $row['telefono'] : 'No disponible'; ?>">
                </div>
            </div>


            <div class="form-group">
                <label for="umf" class="col-sm-2 control-label">UMF</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control mb-3" name="umf" placeholder="Unidad Médica Familiar " value="<?php echo isset($row['umf']) ? $row['umf'] : 'No disponible'; ?>">
                </div>
            </div>


            <div class="form-group">
                <label for="num_consultorio" class="col-sm-2 control-label">Número de Consultorio</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control mb-3" name="num_consultorio" placeholder="Número de Consultorio" value="<?php echo isset($row['num_consultorio']) ? $row['num_consultorio'] : 'No disponible'; ?>">
                </div>
            </div>

            <!-------------------------------------------------EN CASO DE ACCIDENTE FAVOR DE AVISAR A ---------------------------------------------------------------------------------- -->

            <div class="form-group">
                <label for="comodin" class="col-sm-2 control-label"></label>
                <div class="col-sm-10">
                    <input type="text" class="form-control mb-3 centered-placeholder" placeholder="EN CASO DE ACCIDENTE FAVOR DE AVISAR A:" readonly>
                </div>
            </div>

            <div class="form-group">
                <label for="nombre_acc" class="col-sm-2 control-label">Nombre</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control mb-3" name="nombre_acc" placeholder="En caso de accidente avisar a:" value="<?php echo isset($row['nombre_caso_accidente']) ? $row['nombre_caso_accidente'] : 'No disponible'; ?>">
                </div>
            </div>


            <div class="form-group">
                <label for="parentesco" class="col-sm-2 control-label">Parentesco</label>
                <div class="col-sm-10">
                    <?php if (empty($row['parentesco'])) { ?>
                        <p>No hay dato registrado</p>
                    <?php } else { ?>
                        <select class="form-control" id="parentesco" name="parentesco">

                            <option value="Madre" <?php if ($row['parentesco'] == 'Madre') echo 'selected'; ?>>Madre</option>
                            <option value="Padre" <?php if ($row['parentesco'] == 'Padre') echo 'selected'; ?>>Padre</option>
                            <option value="Primo(a)" <?php if ($row['parentesco'] == 'Primo(a)') echo 'selected'; ?>>Primo(a)</option>
                            <option value="Hijo(a)" <?php if ($row['parentesco'] == 'Hijo(a)') echo 'selected'; ?>>Hijo(a)</option>
                            <option value="Hermano(a)" <?php if ($row['parentesco'] == 'Hermano(a)') echo 'selected'; ?>>Hermano(a)</option>
                            <option value="Concubino(a)" <?php if ($row['parentesco'] == 'Concubino(a)') echo 'selected'; ?>>Concubino(a)</option>
                            <option value="Esposo(a)" <?php if ($row['parentesco'] == 'Esposo(a)') echo 'selected'; ?>>Esposo(a)</option>
                            <option value="Amigo(a)" <?php if ($row['parentesco'] == 'Amigo(a)') echo 'selected'; ?>>Amigo(a)</option>
                            <option value="Tio(a)" <?php if ($row['parentesco'] == 'Tio(a)') echo 'selected'; ?>>Tio(a)</option>
                        </select>
                    <?php } ?>
                </div>
            </div>

            <div class="form-group">
                <label for="telefono_urg" class="col-sm-2 control-label">Telefono (s) (555)1234567 </label>
                <div class="col-sm-10">
                    <input type="text" pattern="\([0-9]{3}\)[0-9]{3}[0-9]{4}" title="Un número de teléfono válido consta de un código de 3 
        dígitos entre paréntesis, posterior los 7 digitos más" class="form-control mb-3" name="telefono_urg" placeholder="(3 digitos)9 digitos" value="<?php echo isset($row['telefono_caso_accidente']) ? $row['telefono_caso_accidente'] : 'No disponible'; ?>">
                </div>
            </div>
            <br>

            <!-------------------------------------------------COMPROBANTES EN PDF---------------------------------------------------------------------------------- -->

            <div class="form-group">
                <label for="comodin" class="col-sm-2 control-label"></label>
                <div class="col-sm-10">
                    <input type="text" class="form-control mb-3 centered-placeholder" placeholder="COMPROBANTES EN PDF" readonly>
                </div>
            </div>

            <div class="form-group">
                <span for="ine" class="col-sm-2 control-label">INE (ine.pdf)</span>
                <div class="col-sm-10">
                    <input type="file" title="El formato con el nombre: ine.pdf, de lo contrario no se guardará." class="form-control" id="ine" name="ine">

                    <?php

                    $path = "files/" . $user_id;
                    $ineFilename = "ine.pdf";

                    if (file_exists($path)) {
                        $directorio = opendir($path);
                        while ($ine = readdir($directorio)) {
                            if (!is_dir($ine) && $ine === $ineFilename) {
                                echo "<div data='" . $path . "/" . $ine . "'><a href='" . $path . "/" . $ine . "' title='Ver Archivo INE'><img src='images/pdf_f.jpg' width='17'></a>";
                                //echo "$ine <a href='#' class='delete' title='Ver Archivo Adjunto' ><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></a></div>";
                                echo "<img src='files/$user_id/$ine' width='10' />";
                            }
                        }
                    }

                    ?>

                </div>
            </div>


            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <div class="form-group">
                <span for="comp_domicilio" class="col-sm-2 control-label">COMPROBANTE DE DOMICILIO (domicilio.pdf)</span>
                <div class="col-sm-10">
                    <input type="file" title="El formato con el nombre: domicilio.pdf, de lo contrario no se guardará." class="form-control" id="comp_domicilio" name="comp_domicilio">

                    <?php

                    $path = "files/" . $user_id;
                    $domicilioFilename = "domicilio.pdf";

                    if (file_exists($path)) {
                        $directorio = opendir($path);
                        while ($comp_domicilio = readdir($directorio)) {
                            if (!is_dir($comp_domicilio) && $comp_domicilio === $domicilioFilename) {
                                echo "<div data='" . $path . "/" . $comp_domicilio . "'><a href='" . $path . "/" . $comp_domicilio . "' title='Ver Archivo Domicilio'><img src='images/pdf_f.jpg' width='17'></a>";
                                //echo "$comp_domicilio <a href='#' class='delete' title='Ver Archivo Adjunto' ><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></a></div>";
                                echo "<img src='files/$user_id/$comp_domicilio' width='10' />";
                            }
                        }
                    }

                    ?>

                </div>
            </div>



            <div class="form-group">
                <label for="comodin" class="col-sm-2 control-label"></label>
                <div class="col-sm-10">
                    <input type="text" class="form-control mb-3 centered-placeholder" placeholder="Es importante subir los dos documentos" readonly>
                </div>
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


    <!--<center><input type="submit" class="btn btn-primary btn-block" value="Actualizar"></center>-->



    </form>


</body>

</html>

<script type="text/javascript">
    function formatTitleCase(input) {
        var words = input.value.split(' ');

        for (var i = 0; i < words.length; i++) {
            var word = words[i];
            if (word.length > 0) {
                words[i] = word.charAt(0).toUpperCase() + word.slice(1);
            }
        }

        input.value = words.join(' ');
    }
</script>