<?php

include('conexion.php');


session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["user_id"] == null) {
    print "<script>alert(\"Acceso invalido!\");window.location='login.php';</script>";
}


$user_id = $_SESSION['user_id'];
//echo $user_id;

?>
<html>


<head>
    <title>.: DATOS | IMSS :.</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script type="text/javascript" src="jquery-1.12.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="jquery-ui.css">
    <script type="text/javascript" src="jquery-ui.js"></script>
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
    <script src="functions.js"></script>


    <!--******************************************************Para rellenar formulario************************************************************************-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous">
    </script>
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
        #resultadoc {
            background-color: red;
            color: white;
            font-weight: bold;
        }

        #resultadoc.ok {
            background-color: green;
        }
    </style>


    <script>
        //Función para validar una CURP
        function curpValida(curp) {
            var re =
                /^([A-Z][AEIOUX][A-Z]{2}\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])[HM](?:AS|B[CS]|C[CLMSH]|D[FG]|G[TR]|HG|JC|M[CNS]|N[ETL]|OC|PL|Q[TR]|S[PLR]|T[CSL]|VZ|YN|ZS)[B-DF-HJ-NP-TV-Z]{3}[A-Z\d])(\d)$/,
                validado = curp.match(re);

            if (!validado) //Coincide con el formato general?
                return false;

            //Validar que coincida el dígito verificador
            function digitoVerificador(curp17) {
                //Fuente https://consultas.curp.gob.mx/CurpSP/
                var diccionario = "0123456789ABCDEFGHIJKLMNÑOPQRSTUVWXYZ",
                    lngSuma = 0.0,
                    lngDigito = 0.0;
                for (var i = 0; i < 17; i++)
                    lngSuma = lngSuma + diccionario.indexOf(curp17.charAt(i)) * (18 - i);
                lngDigito = 10 - lngSuma % 10;
                if (lngDigito == 10) return 0;
                return lngDigito;
            }

            if (validado[2] != digitoVerificador(validado[1]))
                return false;

            return true; //Validado
        }


        //Handler para el evento cuando cambia el input
        //Lleva la CURP a mayúsculas para validarlo
        function validarInput(input) {
            var curp = input.value.toUpperCase(),
                resultadoc = document.getElementById("resultadoc"),
                valido = "No válido";

            if (curpValida(curp)) { // ⬅️ Acá se comprueba
                valido = "Válido";
                resultadoc.classList.add("ok");
            } else {
                resultadoc.classList.remove("ok");
            }

            resultadoc.innerText = "CURP: " + curp + "\nFormato: " + valido;
        }
    </script>







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

                <?php
                // Asegúrate de que la sesión esté iniciada antes de acceder a $_SESSION['user_id']
                //session_start();

                if (isset($_SESSION['user_id']['id'])) {
                    $user_id = $_SESSION['user_id']['id'];

                    $sql = "SELECT * FROM principal a
            INNER JOIN USER b ON a.matricula = b.username
            WHERE id = ?";

                    $stmt = $mysqli->prepare($sql);
                    $stmt->bind_param("s", $user_id);
                    $stmt->execute();

                    $resultado = $stmt->get_result();
                    $numeroSql = mysqli_num_rows($resultado);

                    // Resto de tu código para mostrar los resultados obtenidos
                } else {
                    // No se ha iniciado sesión o el ID de usuario no está disponible en $_SESSION['user_id']
                    print "<script>alert(\"Acceso inválido.\");window.location='../login.php';</script>";
                    exit();
                }

                //Si el usuario no esta en la tabla Principal
                if ($numeroSql === 0) {
                    $_SESSION['datos_faltantes'] = true;
                }

                ?>

                <!--Para el mensaje en caso de no estar en tabla Principal-->
                <?php
                if (isset($_SESSION['datos_faltantes']) && $_SESSION['datos_faltantes'] === true) {
                    echo '<div class="alert alert-warning" role="alert">Por favor, informa en la sección "CONTACTO" si no aparece tu nombre para que puedas continuar con el proceso.</div>';
                    unset($_SESSION['datos_faltantes']); // Limpia la variable de sesión después de mostrar el mensaje
                }
                ?>



                <fieldset>
                    <legend style="color:#000000">HOJA DE DATOS PERSONALES</legend>

                    <div class="formulario row">
                        <div class="container">
                            <form class="form-horizontal" method="POST" action="guardar.php " enctype="multipart/form-data" autocomplete="off">


                                <?php
                                while ($qrow = mysqli_fetch_assoc($resultado)) {
                                ?>



                                    <div class="form-group">
                                        <!-- Matricula -->
                                        <label for="matricula" class="control-label">MATRICULA</label>

                                        <input readonly type="text" style="color:#FF0000" class="form-control" id="matricula" onblur="buscar_datos();" name="matricula" step="any" onkeypress="return solonumeros(event)" maxlength="10" placeholder="MATRÍCULA" value="<?php echo $qrow['matricula'] ?>" required>
                                    </div>



                                    <div class="form-group">
                                        <label for="nombre" class="control-label">NOMBRE</label>
                                        <input readonly type="text" style="color:#FF0000" class="form-control" id="nombre" name="nombre" step="any" onkeypress="return solonumeros(event)" maxlength="70" value="<?php echo $qrow['ocupante'] ?>" placeholder="NOMBRE" required>
                                    </div>


                                    <div class="form-group">
                                        <!--categoria -->
                                        <label for="categoria" class="control-label">CATEGORÍA</label>
                                        <input readonly type="text" style="color:#FF0000" onKeyUp="this.value=this.value.toLowerCase();" class="form-control" id="categoria" name="categoria" value="<?php echo $qrow['desc_categoria'] ?>" placeholder="categoria" required>
                                    </div>


                                    <div class="form-group">
                                        <!-- email particular -->
                                        <label for="mail_particular" class="control-label">E-MAIL PARTICULAR</label>
                                        <input type="text" onKeyUp="this.value=this.value.toLowerCase();" class="form-control" id="mail_particular" name="mail_particular" placeholder="correo personal" required>
                                    </div>

                                    <div class="form-group">
                                        <!-- email institucional -->
                                        <label for="mail_institucional" class="control-label">E-MAIL INSTITUCIONAL</label>

                                        <input type="text" onKeyUp="this.value=this.value.toLowerCase();" class="form-control" id="mail_institucional" name="mail_institucional" placeholder="correo institucional" required>

                                    </div>

                                    <div class="form-group">
                                        <!-- escolaridad -->
                                        <label for="escolaridad" class="control-label">ESCOLARIDAD</label>
                                        <select class="form-control" onKeyUp="this.value=this.value.toUpperCase();" id="escolaridad" name="escolaridad">
                                            <option value="0">Selecciona Escolaridad</option>
                                            <?php

                                            $query = "SELECT id, escolaridad FROM cat_escolaridad ORDER BY id ASC";

                                            $resultado = $mysqli->query($query);

                                            while ($row = $resultado->fetch_assoc()) { ?>

                                                <option value="<?php echo $row['escolaridad']; ?>">
                                                    <?php echo $row['escolaridad']; ?></option>

                                            <?php } ?>

                                        </select>
                                    </div>


                                    <label for="area_escolar" class="control-label">PROFESIÓN</label>
                                    <input type="text" oninput="formatTitleCase(this)" class="form-control" name="area_escolar" placeholder="Area de escolaridad" required>



                                    <div class="form-group">
                                        <!-- estado civil -->
                                        <label for="edo_civil" class="control-label">ESTADO CIVIL</label>
                                        <select class="form-control" id="edo_civil" name="edo_civil">
                                            <option value="0">Selecciona Estado Civil</option>
                                            <?php

                                            $query = "SELECT id_edo_civil,desc_edocivil FROM cat_edo_civil ORDER BY id_edo_civil ASC";

                                            $resultado = $mysqli->query($query);

                                            while ($row = $resultado->fetch_assoc()) { ?>

                                                <option value="<?php echo $row['desc_edocivil']; ?>">
                                                    <?php echo $row['desc_edocivil']; ?></option>

                                            <?php } ?>
                                        </select>
                                    </div>


                                    <div class="form-group">
                                        <!-- lugar de nacimiento -->
                                        <label for="pais_nac" class="control-label">LUGAR DE NACIMIENTO</label>

                                        <select class="form-control" id="pais_nac" name="pais_nac">
                                            <option value="0">Selecciona País</option>
                                            <option value="Mexico">México</option>
                                        </select>
                                        <br>

                                        <select class="form-control" id="edo_nac" id="edo_nac" name="edo_nac">
                                            <option value="0">Selecciona Estado</option>
                                        </select>

                                        <br>
                                        <select class="form-control" id="municipio" id="municipio" name="municipio">
                                            <option value="0">Selecciona Ciudad</option>
                                        </select>

                                    </div>


                                    <div class="form-group">
                                        <!--adscripcion -->
                                        <label for="adscripcion" class="control-label">ADSCRIPCION</label>
                                        <input readonly type="text" style="color:#FF0000" class="form-control" id="adscripcion" name="adscripcion" placeholder="adscripcion" value="<?php echo $qrow['nom_ads'] ?>">
                                    </div>

                                <?php } ?>

                                <div class="form-group">
                                    <!-- estado civil -->
                                    <label for="turno" class="control-label">TURNO</label>
                                    <select class="form-control" id="turno" name="turno">
                                        <option value="0">SELECCIONA TURNO</option>
                                        <option value="Matutino">Matutino</option>
                                        <option value="Vespertino">Vespertino</option>
                                    </select>
                                </div>

                </fieldset>
                <!-------------------------------------------------------DOMICILIO PARTICULAR---------------------------------------------------------------------------------- -->


                <fieldset>
                    <p>
                        <legend style="color:#8B0000">DOMICILIO PARTICULAR:</legend>
                    </p>
                    <div class="form-group">


                        <div class="container">
                            <p> <label for="calle" class="control-label">CALLE:</label>
                                <input type="text" oninput="formatTitleCase(this)" class="form-control" name="calle" placeholder="calle" />
                                <label for="num_ext" class="control-label"> NUMERO EXT:</label>
                                <input type="text" class="form-control" name="num_ext" size="4" />
                                <label for="num_int" class="control-label"> NUMERO INT:</label>
                                <input type="text" class="form-control" name="num_int" size="4" />
                            </p>


                            <label for="colonia" class="control-label">COLONIA:</label>
                            <input type="text" oninput="formatTitleCase(this)" class="form-control" name="colonia" placeholder="colonia" />
                            <br>
                            <div class="form-group">

                                <!--estado domicilio-->
                                <label for="edo_dom" class="control-label">ESTADO</label>
                                <select class="form-control" id="edo_dom" name="edo_dom" required>
                                    <option value="0">Selecciona Estado</option>
                                    <?php

                                    $query = "SELECT id_estado,estado FROM cat_estados ORDER BY estado ASC";

                                    $resultado = $mysqli->query($query);

                                    while ($row = $resultado->fetch_assoc()) { ?>

                                        <option value="<?php echo $row['estado']; ?>"><?php echo $row['estado']; ?>
                                        </option>

                                    <?php } ?>

                                </select>

                                <br>
                                <label for="municipio2" class="control-label">DELEGACIÓN O MUNICIPIO</label>
                                <input type="text" oninput="formatTitleCase(this)" class="form-control" name="municipio2" placeholder="Delegación o Municipio" />

                                <br>


                                <div class="form-group">
                                    <!-- ciudad -->
                                    <label for="ciudad" class="control-label">CIUDAD</label>
                                    <input type="text" oninput="formatTitleCase(this)" class="form-control" id="ciudad" name="ciudad" placeholder="ciudad">
                                </div>


                                <div class="form-group">
                                    <!-- poblacion -->
                                    <label for="poblacion" class="control-label">POBLACIÓN</label>
                                    <input type="text" oninput="formatTitleCase(this)" class="form-control" id="poblacion" name="poblacion" placeholder="poblacion">
                                </div>

                                <div class="form-group">
                                    <label for="codigo_postal" class="control-label">CODIGO POSTAL</label>
                                    <input type="text" class="form-control" id="codigo_postal" name="codigo_postal" placeholder="código postal" pattern="[0-9]{5}" title="El código postal debe ser un número de 5 dígitos">
                                </div>


                                <div class="form-group">
                                    <!--telefono-->
                                    <label for="telefono" class="control-label">TELEFONO A 10 DIGITOS (LOS 3 PRIMEROS ENTRE
                                        PARÉNTESIS)</label>
                                    <input type="tel" name="telefono" pattern="\([0-9]{3}\)[0-9]{3}[0-9]{4}" title="Un número de teléfono válido consta de un código de 3 dígitos entre paréntesis, posterior los 7 digitos más" placeholder="(555)1234567" required>
                                </div>

                                <div class="form-group">
                                    <!--UMF-->
                                    <label for="umf" class="control-label">NÚMERO DE U.M.F</label>
                                    <input type="text" class="form-control" id="umf" name="umf" placeholder="donde recibe atención medica" onkeypress='return event.charCode >= 48 && event.charCode <= 57' />
                                </div>

                                <div class="form-group">
                                    <!--numero de consultorio-->
                                    <label for="num_consultorio" class="control-label">NUMERO DE CONSULTORIO</label>
                                    <input type="number" class="form-control" id="num_consultorio" name="num_consultorio" placeholder="número de consultorio" onkeypress='return event.charCode >= 48 && event.charCode <= 57' />
                                </div>


                            </div>

                </fieldset>

                <!-------------------------------------------------EN CASO DE ACCIDENTE FAVOR DE AVISAR A ---------------------------------------------------------------------------------- -->


                <fieldset>
                    <div class="container">
                        <p>
                            <legend style="color:#8B0000">EN CASO DE ACCIDENTE FAVOR DE AVISAR A:</legend>
                        </p>


                        <div class="form-group">
                            <!-- nombre_accidente -->
                            <label for="nombre_acc" class="control-label">NOMBRE (S)</label>
                            <input type="text" oninput="formatTitleCase(this)" class="form-control" id="nombre_acc" name="nombre_acc" placeholder="apelllido paterno  apellido materno  nombre(s)">
                        </div>

                        <div class="form-group">
                            <!--parentesco-->
                            <label for="parentesco" class="control-label">PARENTESCO</label>
                            <select class="form-control" id="parentescto" name="parentesco" required>
                                <option value="0">Selecciona Parentesco</option>
                                <?php

                                $query = "SELECT id,parentesco FROM cat_parentesco ORDER BY parentesco ASC";

                                $resultado = $mysqli->query($query);

                                while ($row = $resultado->fetch_assoc()) { ?>

                                    <option value="<?php echo $row['parentesco']; ?>"><?php echo $row['parentesco']; ?>
                                    </option>

                                <?php } ?>

                            </select>



                            <div class="form-group">
                                <!--telefono-->
                                <label for="telefono_urg" class="control-label">TELEFONO TELEFONO A 10 DIGITOS (LOS 3
                                    PRIMEROS ENTRE PARÉNTESIS)</label>
                                <input type="tel" name="telefono_urg" pattern="\([0-9]{3}\)[0-9]{3}[0-9]{4}" title="Un número de teléfono válido consta de un código de 3 
        dígitos entre paréntesis, posterior los 7 digitos más" placeholder="(555)1234567" required>
                            </div>
                        </div>



                        <div class="form-group">
                            <label for="fecha_de_alta" class="control-label">FECHA DE ACTUALIZACIÓN</label>
                            <input readonly type="date" class="form-control" id="fecha_de_alta" name="fecha_de alta" value="<?php echo date("Y-m-d"); ?>">
                            <!--<input type="date" class="form-control" id="fecha_de_alta" name="fecha_de_alta">-->
                        </div>

                    </div>
                    <BR>
                    <form class="form-horizontal" method="POST" action="guardar.php " enctype="multipart/form-data" autocomplete="off">


                        <fieldset>
                            <div class="container">
                                <p>
                                    <legend style="color:#8B0000">EN FORMATO PDF </legend>
                                </p>
                                <div class="form-group">
                                    <!--INE-->
                                    <label for="ine" style="color:#0833a2" class="control-label">AGREGA INE(ine.pdf)</label>
                                    <input type="file" size="30" title="El formato con el nombre: ine.pdf, de lo contrario no se guardará." class="form-control" id="ine" name="ine" placeholder="INE" required>
                                </div>
                                <BR>
                                <div class="form-group">
                                    <!--COMPROBANTE DE DOMICILIO-->
                                    <label for="comp_domicilio" style="color:#0833a2" class="control-label">AGREGA COMPROBANTE DE DOMICILIO (domicilio.pdf)</label>
                                    <input type="file" title="El formato con el nombre: domicilio.pdf, de lo contrario no se guardará." size="30" class="form-control" id="comp_domicilio" name="comp_domicilio" placeholder="COMPROBANTES DE DOMICILIO" required>
                                </div>

                                <BR>
                                <div class="form-group">
                                    <!--COMPROBANTE DE ESTUDIOS-->
                                    <label for="escolaridad" style="color:#4F6228" class="control-label">AGREGA ULTIMO GRADO DE ESCOLARIDAD (escolaridad.pdf)</label>
                                    <input type="file" title="El formato con el nombre: escolaridad.pdf, de lo contrario no se guardará." size="30" class="form-control" id="escolaridad" name="escolaridad" placeholder="GRADO ESCOLAR" required>

                                </div>

                                <div class="form-group">
                                    <!-- firma -->
                                    <label for="curp" class="control-label">FIRMA CON TU CURP</label>
                                    <input type="text" onKeyUp="this.value=this.value.toUpperCase();" class="form-control" id="curp_input" name="curp_input" oninput="validarInput(this)" style="width:100%;" placeholder="Ingrese su CURP">
                                    <pre id="resultadoc"></pre>
                                </div>


                            </div>
            </div>


            <BR>
            <BR>



            </fieldset>
            </fieldset>

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

    </div>




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