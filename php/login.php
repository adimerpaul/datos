<?php

if (!empty($_POST)) {
    if (isset($_POST["username"]) && isset($_POST["password"])) {
        if ($_POST["username"] != "" && $_POST["password"] != "") {
            include "conexion.php";

            $user_id = null;
            $role_id = null;
            $change_password = null;

            // Realiza la consulta para obtener información del usuario
            $sql1 = "SELECT u.id, u.RoleId, u.change_password, r.desc_rol FROM user u 
            INNER JOIN Role r ON u.RoleId = r.RoleId 
            WHERE (u.username = '$_POST[username]' OR u.email = '$_POST[username]') AND u.password = '$_POST[password]'";
            $query = $con->query($sql1);
            while ($r = $query->fetch_array()) {
                $user_id = $r["id"];
                $role_id = $r["RoleId"];
                $change_password = $r["change_password"];
                break;
            }

            if ($user_id == null) {
                print "<script>alert(\"Acceso inválido.\");window.location='../login.php';</script>";
            } else {
                session_start();
                $_SESSION["user_id"] = array("id" => $user_id);
                $_SESSION["role_id"] = $role_id;

                if ($role_id == 1) {
                    // User is an admin
                    //print "<script>alert(\"User role: admin\");</script>";
                    print "<script>window.location='../reporte.php';</script>";
                } elseif ($role_id == 2) {
                    // User is an employee
                    //print "<script>alert(\"User role: employee\");</script>";

                    // Aquí verificas si el usuario tiene que cambiar la contraseña
                    if ($change_password == 1) {
                        // Redirige al usuario a la página de cambio de contraseña
                        print "<script>window.location='../changepassword.php';</script>";
                    } else {
                        print "<script>window.location='../menu.php';</script>";
                    }
                } else {
                    // Invalid role
                    print "<script>alert(\"Invalid role\");</script>";
                    print "<script>alert(\"Acceso inválido.\");window.location='../login.php';</script>";
                }
            }
        }
    }
}


?>
