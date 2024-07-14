<?php session_start();
include('conexion.php');

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Formulario de Registro</title>
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">

	<script src="https://kit.fontawesome.com/9904a0625c.js" crossorigin="anonymous"></script>
</head>

<body>
	<?php include "php/navbar.php"; ?>
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<h2>Login</h2>

				<form role="form" name="login" action="php/login.php" method="post">
					<div class="form-group">
						<label for="username">Número de matrícula</label>
						<input type="text" class="form-control" id="username" name="username" placeholder="Matricula">
					</div>
					<div class="form-group">
						<label for="password">Contrase&ntilde;a</label>
						<div class="input-group">
							<input type="password" class="form-control" id="password" name="password" placeholder="Contrase&ntilde;a">
							<span class="input-group-addon" id="showPasswordToggle">
								<i class="fa fa-eye"></i>
							</span>
						</div>
					</div>

					<button type="submit" class="btn btn-primary">Acceder</button>
					<br>
					<br>
					<a href="forgot_password.php">¿Olvidaste tu contraseña?</a>
				</form>
			</div>
		</div>
	</div>
	<script src="js/valida_login.js"></script>

	<script>
		var passwordInput = document.getElementById("password");
		var showPasswordToggle = document.getElementById("showPasswordToggle");

		showPasswordToggle.addEventListener("click", function() {
			if (passwordInput.type === "password") {
				passwordInput.type = "text";
			} else {
				passwordInput.type = "password";
			}
		});
	</script>


</body>

</html>
