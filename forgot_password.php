<?php
 require 'master/barra.php';
 function contenido(){


?>



<h2>Recuperación de Contraseña</h2>
<form action="reset_password.php" method="post">
    <div class="form-group">
        <label for="email">Correo electrónico registrado:</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="Correo electrónico" required>
    </div>
    <button type="submit" class="btn btn-primary">Enviar</button>
</form>



<?php
    }
?>