<!-- SE DEBE ASIGNAR UNA CLASE (CLASS) PARA MOSTRAR RESULTADOS EN AJAX -->
<div class="resultados">Aqui se mostraran los resultados</div>

<!-- AJAX ENVIANDO VARIABLES Y MOSTRANDO HTML -->
<script>
	function AJAX_RECIBIENDO_HTML() 
  {
    variable_1 = $("#id_campo1").val();
    variable_2 = $("#id_campo2").val();
    
    var parametros = 
    {
      "variable_x": "1",
      "variable_1" : variable_1,
      "variable_2" : variable_2
    };
    $.ajax(
    {
      data:  parametros,
      url:   'codigos_php_ajax.php',
      type:  'post',
      beforeSend: function() 
      {alert("enviando");}, 
      error: function()
      {alert("Error");},
      complete: function() 
      {alert("¡Listo!");},
      success:  function (mensaje) 
      {$('.resultados').html(mensaje);}
    }) 
  }
</script>

<!-------------------------------------------------------------------------------->

<!-- AJAX ENVIANDO Y RECIBIENDO VARIABLES -->

<!-- CODIGOS EN JavaScript -->
<script>
  function AJAX_RECIBIENDO_VARIABLES() 
  {
    variable_1 = $("#id_campo1").val();
    variable_2 = $("#id_campo2").val();
    
    var parametros = 
    {
      "variable_x": "1",
      "variable_1" : variable_1,
      "variable_2" : variable_2
    };
    $.ajax(
    {
      data:  parametros,
      dataType: 'json',
      url:   'codigos_php_ajax.php',
      type:  'post',
      beforeSend: function() 
      {alert("enviando");}, 
      error: function()
      {alert("Error");},
      complete: function() 
      {alert("¡Listo!");},
      success:  function (valores) 
      {
        alert(valores.variable_1);
        alert(valores.variable_2);
        alert(valores.variable_3);
      }
    }) 
  }
</script>

<!-- CODIGOS EN PHP -->
$mi_variable = array(); <!-- Creo el Array-->

$mi_variable = json_encode($mi_variable); <!-- Convierto el Array-->
echo $mi_variable; <!-- Envío el Array-->


<!-- ---------------------------------------------------------------------------- -->


<!-- EJECUTAR CODIGO AL INICIAR EL DOCUMENTO -->
  <script type="text/javascript">
    $(document).ready(function(){
        //Aqui el codigo
      });  
  </script>

<!-- ---------------------------------------------------------------------------- -->

<!-- CODIGO DE "CARGANDO" BOOTSTRAP -->
<div class="row">       
  <div class="d-flex justify-content-center">
    <div class="spinner-border text-primary" role="status">
      <span class="visually-hidden">Cargando...</span>
    </div>
  </div>
</div>

<!-- ---------------------------------------------------------------------------- -->
<script type="text/javascript">
$('.mi_clase').show('500'); //mostrar
$('.mi_clase').hide('500'); //ocultar
</script>