$(function(){

	// Lista de Continentes
	$.post( 'estado_1.php' ).done( function(respuesta)
	{
		$( '#edo_dom' ).html( respuesta );
	});

	// lista de estados	
	$('#edo_dom').change(function()
	{
		var el_mun_1 = $(this).val();
		
		// Lista de Paises
		$.post( 'municipio_1.php', { municipio: el_mun_1} ).done( function( respuesta )
		{
			$( '#municipio2' ).html( respuesta );
		});
	});
	
	// Lista de Ciudades
	$( '#municipio2' ).change( function()
	{
		var valida = $(this).children('option:selected').html();
		//alert( 'Lista de municipios ' + valida );
	});

})
