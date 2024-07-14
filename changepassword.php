<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/font-awesome.css" rel="stylesheet">
	<link rel="stylesheet" href="css/jquery-ui.css">

    <script src="https://kit.fontawesome.com/f19570f5db.js" crossorigin="anonymous"></script>

    <title>Recuperacion de Contraseña</title>
</head>

<body>

    <?php
    session_start();

    include 'conexion.php';
    require 'master/barra.php';

    function contenido()
    {
        if (!isset($_SESSION["user_id"]) || empty($_SESSION["user_id"]["id"])) {
            $_SESSION['message'] = "Acceso inválido!";
            header("Location: login.php");
            exit();
        }

        $user_id = $_SESSION['user_id']['id'];
        //echo "User ID: $user_id";

        global $con;

        if (isset($_POST['save'])) {
            $oldpass = $_POST['oldpass'];
            $newpass = $_POST['npassword'];
            $cpassword = $_POST['cpassword'];
        
            if (empty($oldpass) || empty($newpass) || empty($cpassword)) {
                echo '<h4 style="color: #F1C40F;">Por favor, complete todos los campos.</h4>';
            } else {
                $query = "SELECT Password FROM user WHERE id = $user_id";
                $result = mysqli_query($con, $query);
        
                if (!$result) {
                    echo "Error en la consulta: " . mysqli_error($con);
                } else {
                    $row = mysqli_fetch_assoc($result);
                    $currentPassword = $row['Password'];
        
                    if ($oldpass === $currentPassword) {
                        if ($newpass === $cpassword) {
                            $updateQuery = "UPDATE user SET Password = '$newpass', change_password = 2, modified_date_psw = NOW() WHERE id = '$user_id'";
                            $updateResult = mysqli_query($con, $updateQuery);
        
                            if ($updateResult) {
                                echo '<h4 style="color: #FF0000;">Contraseña actualizada con éxito.</h4>';
                            } else {
                                echo '<h4 style="color: #F1C40F;">Error al actualizar la contraseña.</h4>';
                            }
                        } else {
                            echo '<h4 style="color: #F1C40F;">La nueva contraseña y la confirmación no coinciden.</h4>';
                        }
                    } else {
                        echo '<h4 style="color: #F1C40F;">Contraseña actual incorrecta.</h4>';
                    }
                }
            }
        }
        

    ?>

        <!-- Your HTML form here -->

        <form method="POST" action="changepassword.php" enctype="multipart/form-data" autocomplete="off">

            <div class="container-fluid" style="margin-bottom: 30px;margin-top: 10px; background: white;">
                <div class="row">
                    <h2 style="color: #1abc9c;">Cambiar Contraseña</h2>
                    <hr>  

                    <div class="clearfix"> </div>
                </div>

                <div class="row">
                    <div class="col-md-5 control-label">
                        <label class="control-label">Contraseña Actual</label>
                        <div class="input-group">
                            <span class="input-group-addon" id="showPasswordToggle">
								<i class="fa fa-eye"></i>
							</span>
                            <input type="password" name="oldpass" title="Old Password" placeholder="Contraseña Actual" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-5 control-label">
                        <label class="control-label">Nueva Contraseña</label>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-pencil" aria-hidden="true"></i>
                            </span>
                            <input type="password" title="New Password" name="npassword" placeholder="Nueva Contraseña" class="form-control">
                        </div>
                    </div>
                    <div class="clearfix"> </div>
                </div>

                <div class="row">
                    <div class="col-md-5 control-label">
                        <label class="control-label">Confirmar Contraseña</label>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-pencil" aria-hidden="true"></i>
                            </span>
                            <input type="password" name="cpassword" title="Confirm Password" placeholder="Confirmar Contraseña" class="form-control">
                        </div>
                    </div>
                    <div class="clearfix"> </div>
                </div>
                <h4 style="color: #F1C40F;"><?php  ?></h4>
                <div class="row">
                    <div class="col-md-3 form-group">
                        <button type="submit" name="save" title="Save" class="btn btn-primary">Guardar</button>
                     
                    </div>
                    <div class="clearfix"> </div>
                </div>

                <div class="row">
                    <div class="col-md-3 form-group">
                        <button type="reset" title="Inicio" class="btn btn-primary" onclick="login()">Ingresar</button>
              
                    </div>
                    <div class="clearfix"> </div>
                </div>


            </div>
        </form>

</body>


</html>

<script>
function login() {
    // Tu código para limpiar los valores del formulario si es necesario

    // Redireccionar a la página deseada
    window.location.href = "php/logout.php";
}
</script>

<script src="js/valida_login.js"></script>

<script>
    var passwordInput = document.getElementById("oldpass");
    var showPasswordToggle = document.getElementById("showPasswordToggle");

    showPasswordToggle.addEventListener("click", function() {
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
        } else {
            passwordInput.type = "password";
        }
    });
</script>



<?php
    }
?>