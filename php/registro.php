<?php

if (!empty($_POST)) {
    if (isset($_POST["username"]) && isset($_POST["fullname"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["confirm_password"])) {
        if ($_POST["username"] != "" && $_POST["fullname"] != "" && $_POST["email"] != "" && $_POST["password"] != "" && $_POST["password"] == $_POST["confirm_password"]) {
            include "conexion.php";

            $found = false;
            $sql1 = "SELECT * FROM user WHERE username=\"$_POST[username]\" OR email=\"$_POST[email]\"";
            $query = $con->query($sql1);
            while ($r = $query->fetch_array()) {
                $found = true;
                break;
            }
            if ($found) {
                print "<script>alert(\"Nombre de usuario o email ya están registrados.\");window.location='../registro.php';</script>";
            } else {
                // Insert the new user with change_password set to 0 and modified_date_psw set to NOW()
                $sql = "INSERT INTO user (username, fullname, email, password, created_at, RoleId, change_password, modified_date_psw) VALUES (\"$_POST[username]\",\"$_POST[fullname]\",\"$_POST[email]\",\"$_POST[password]\",NOW(), 2, 0, NOW())";
                $query = $con->query($sql);
                if ($query != null) {
                    print "<script>alert(\"Registro exitoso. Proceda a logearse\");window.location='../login.php';</script>";
                }
            }
        }
    }
}
?>
