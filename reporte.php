<?php
// No mostrar los errores de PHP
error_reporting(0);
?>

<?php include "php/navbar.php"; ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="Description" content="Buscador" />
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-theme.css" rel="stylesheet">
    <link href="css/jquery.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
    <link href="plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <title>Buscador</title>

    <!---------------------------------------PARA MENSAJE DE SEGURO DE ELIMINAR REGISTRO-------------------------- -->
    <script>
        function confirmDelete(matricula) {
            var confirmation = confirm("¿Estás seguro de que deseas eliminar este registro?");
            if (confirmation) {
                window.location.href = "delete.php?matricula=" + matricula;
            }
        }
    </script>
</head>

<body>

    <?php
    include("conexion.php");
    ?>

    <div class="container mt-5">
        <div class="col-12 row">
            <form method="POST" action="reporte.php">
                <!-- Formulario -->
                <!-- Aquí van los campos de búsqueda y filtros -->
                <div class="mb-3">
                    <label for="buscar" class="form-label">Buscar</label>
                    <input type="search" class="form-control" id="buscar" name="buscar" placeholder="matricula o nombre completo">
                </div>

                <h4 class="card-title">Filtro de búsqueda</h4>

                <div class="col-11">
                    <table class="table">
                        <thead>
                            <tr class="filters">
                                <th>
                                    Fecha de modificacion
                                    <input type="date" id="buscafechamodificacion" name="buscafechamodificacion" class="form-control mt-2" value="<?php echo isset($_POST["buscafechamodificacion"]) ? $_POST["buscafechamodificacion"] : ''; ?>" style="border: #bababa 1px solid; color:#000000;">
                                </th>
                                <!-- Puedes agregar más campos de filtro aquí según sea necesario -->
                            </tr>
                        </thead>
                    </table>
                </div>

                <h4 class="card-title">Ordenar por</h4>
                <div class="col-11">
                    <table class="table">
                        <thead>
                            <tr class="filters">
                                <th>
                                    Selecciona el orden
                                    <select id="orden" name="orden" class="form-control mt-2" style="border: #bababa 1px solid; color:#000000;">
                                        <option value="">Selecciona</option>
                                        <option value="1">Nombre</option>
                                        <option value="2">Adscripción</option>
                                        <option value="3">Escolaridad</option>
                                        <option value="4">Fecha de modificación</option>
                                        <option value="5">Fecha de alta</option>
                                    </select>
                                </th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="col-1">
                    <input type="submit" class="btn btn-success" value="Ver" style="margin-top: 30px;">
                </div>
            </form> <!-- Fin del formulario -->

            <?php

            // Contar el total de registros en la base de datos
            $totalRegistrosQuery = "SELECT COUNT(*) AS total FROM datos";
            $totalRegistrosResult = $con->query($totalRegistrosQuery);
            $totalRegistrosRow = $totalRegistrosResult->fetch_assoc();
            $totalRegistros = $totalRegistrosRow['total'];

            // Manejar la búsqueda cuando se envíe el formulario
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Construir la consulta SQL basada en los filtros seleccionados
                $query = "SELECT id, matricula,nombre, adscripcion, escolaridad, fecha_modificacion, fecha_de_alta FROM datos WHERE 1 = 1";

                if (!empty($_POST["buscar"])) {
                    $buscar = $_POST["buscar"];
                    $query .= " AND (nombre LIKE '%$buscar%' OR matricula LIKE '%$buscar%')";
                }

                if (!empty($_POST["buscafechamodificacion"])) {
                    $buscafechamodificacion = $_POST["buscafechamodificacion"];
                    $buscafechamodificacion = date("Y-m-d 00:00:00", strtotime($buscafechamodificacion));
                    $query .= " AND fecha_modificacion BETWEEN '$buscafechamodificacion' AND DATE_ADD('$buscafechamodificacion', INTERVAL 1 DAY)";
                }

                // Aplicar la ordenación
                if (!empty($_POST["orden"])) {
                    $orden = $_POST["orden"];
                    switch ($orden) {
                        case '1':
                            $query .= " ORDER BY nombre ASC";
                            break;
                        case '2':
                            $query .= " ORDER BY adscripcion ASC";
                            break;
                        case '3':
                            $query .= " ORDER BY escolaridad ASC";
                            break;
                        case '4':
                            $query .= " ORDER BY fecha_modificacion DESC";
                            break;
                        case '5':
                            $query .= " ORDER BY fecha_de_alta ASC";
                            break;
                        default:
                            $query .= " ORDER BY nombre ASC";
                            break;
                    }
                } else {
                    $query .= " ORDER BY nombre ASC"; // Orden por defecto
                }

                // Ejecutar la consulta SQL
                $sql = $con->query($query);

                // Contar el total de registros que corresponden a la fecha de modificación seleccionada
                $totalModificacionQuery = "SELECT COUNT(*) AS total_modificacion FROM datos WHERE 1 = 1";
                if (!empty($_POST["buscafechamodificacion"])) {
                    $buscafechamodificacion = $_POST["buscafechamodificacion"];
                    $buscafechamodificacion = date("Y-m-d 00:00:00", strtotime($buscafechamodificacion));
                    $totalModificacionQuery .= " AND fecha_modificacion BETWEEN '$buscafechamodificacion' AND DATE_ADD('$buscafechamodificacion', INTERVAL 1 DAY)";
                }
                $totalModificacionResult = $con->query($totalModificacionQuery);
                $totalModificacionRow = $totalModificacionResult->fetch_assoc();
                $totalModificacion = $totalModificacionRow['total_modificacion'];
            ?>

                <div class="col-12 row">
                    <?php
                    if (!empty($_POST["buscar"])) {
                        if ($sql->num_rows == 1) {
                            echo "<p style='font-weight: bold; color:green;'><i class='mdi mdi-file-document'></i> 1 Resultado encontrado</p>";
                        } else {
                            echo "<p style='font-weight: bold; color:green;'><i class='mdi mdi-file-document'></i> " . $sql->num_rows . " Resultados encontrados</p>";
                        }
                    } elseif ($totalModificacion > 0) {
                    ?>
                        <p style="font-weight: bold; color:green;">
                            <i class="mdi mdi-file-document"></i>
                            <?php echo $totalModificacion; ?> Resultados encontrados
                        </p>
                    <?php } else {
                        echo "<p style='font-weight: bold; color:green;'><i class='mdi mdi-file-document'></i> $totalRegistros Resultados encontrados</p>";
                    }
                    ?>

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr style="background-color:purple; color:#FFFFFF;">
                                    <th style=" text-align: center;"> Matricula </th>
                                    <th style=" text-align: center;"> Nombre </th>
                                    <th style=" text-align: center;"> Adscripción</th>
                                    <th style=" text-align: center;"> Escolaridad </th>
                                    <th style=" text-align: center;"> Fecha de modificacion </th>
                                    <th style=" text-align: center;"> Fecha de alta </th>
                                    <th style=" text-align: center;"> </th>
                                    <th style=" text-align: center;"> </th>
                                    <th style=" text-align: center;"> </th>
                                    <th style=" text-align: center;"> </th>
                                    <th style=" text-align: center;"> </th>
                                    <th style=" text-align: center;"> Datos </th>

                                </tr>


                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($rowSql = $sql->fetch_assoc()) { ?>
                                    <tr>
                                        <td style="text-align: center;"><?php echo $rowSql["matricula"]; ?></td>
                                        <td style="text-align: center;"><?php echo $rowSql["nombre"]; ?></td>
                                        <td style="text-align: center;"><?php echo $rowSql["adscripcion"]; ?></td>
                                        <td style="text-align: center;"><?php echo $rowSql["escolaridad"]; ?></td>
                                        <td style="text-align: center;">
                                            <?php
                                            if ($rowSql["fecha_modificacion"] !== null and $rowSql["fecha_modificacion"] !=='0000-00-00 00:00:00') {
                                                echo date('d/m/Y', strtotime($rowSql["fecha_modificacion"]));
                                            } else {
                                                echo "";
                                            }
                                            ?>
                                        </td>
                                        <td style="text-align: center;"><?php echo date('d/m/Y', strtotime($rowSql["fecha_de_alta"])); ?></td>
                                        <th><a title="editar" href="actualizar.php?matricula=<?php echo $rowSql['matricula'] ?>"><img src="http://11.254.27.130:84/datos_personales/edicion.jpg" alt="editar" /></a></th>
                                        <th>
                                            <a title="eliminar" href="delete.php?id=<?php echo $rowSql['id']; ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar este registro?');">
                                                <img src="http://11.254.27.130:84/datos_personales/eliminar.png" alt="eliminar" />
                                            </a>

                                        </th>
                                        <td style="text-align: center;"><a title="ine" href="ver_ine.php?id=<?php echo $rowSql['id'] ?>" target="_blank"><img src="http://11.254.27.130:84/datos_personales/ine.png" alt="ine" /></a></td>
                                        <td style="text-align: center;"><a title="comprobante de domicilio" href="ver_comp_domicilio.php?id=<?php echo $rowSql['id'] ?>" target="_blank"><img src="http://11.254.27.130:84/datos_personales/domicilio.jpg" alt="domicilio" /></a></td>
                                        <td style="text-align: center;"><a title="comprobante de estudios" href="ver_escolaridad.php?id=<?php echo $rowSql['id'] ?>" target="_blank"><img src="http://11.254.27.130:84/datos_personales/escolaridad.png" alt="Comprobante de estudios" /></a></td>
                                        <td style="text-align: center;"><a title="formato" href="formulario.php?matricula=<?php echo $rowSql['matricula'] ?>" target="_blank"><img src="http://11.254.27.130:84/datos_personales/formato.png" alt="formato" /></a></td>

                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/js/bootstrap.min.js"></script>
</body>

</html>