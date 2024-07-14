$(function() {

	// Lista de Estados
	$.post( 'estado.php' ).done( function(respuesta)
	{
		$( '#edo_nac' ).html( respuesta );
	});

	// lista de estados	
	$('#edo_nac').change(function()
	{
		var el_mun_1 = $(this).val();
		
		// Lista de Paises
		$.post( 'municipio.php', { municipio: el_mun_1} ).done( function( respuesta )
		{
			$( '#municipio' ).html( respuesta );
		});
	});
	
	// Lista de Municipios
	$( '#municipio' ).change( function()
	{
		var valida = $(this).children('option:selected').html();
		//alert( 'Lista de municipios ' + valida );
	});



//PARA ACTUALIZAR ESTADO Y MUNICIPIO DE NACIMIENTO

    // Cargar estados al cargar la página
    cargarEstados();

    if (typeof estado_previo !== 'undefined') {
        cargarEstados();
        if (estado_previo !== '') {
            cargarMunicipios(estado_previo, municipio_previo);
        }
    }


    // Cambio en el select de estado
    $('#edo_nac').change(function() {
        var el_mun = $(this).val();
        cargarMunicipios(el_mun);
    });

    function cargarEstados() {
        $.post('estado.php').done(function(respuesta) {
            $('#edo_nac').html(respuesta);
            $('#edo_nac').val(estado_previo);
        });
    }

    function cargarMunicipios(id_estado, municipio_seleccionado) {
        // Lista de municipios
        $.post('municipio.php', { municipio: id_estado }).done(function(respuesta) {
            $('#municipio').html(respuesta);
            $('#municipio').val(municipio_seleccionado);
        
        });
    }



    $(function() {
        // Obtén el valor previamente registrado en el atributo data
        // Seleccionar el estado previo
        $('#edo_dom').val(estado_domicilio);
        $('#municipio2').val(municipio_domicilio);
        //alert("Municipio previo: " + municipio_domicilio);

        //alert("Estado previo: " + estado_domicilio);
    });


});
