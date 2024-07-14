$(function () {
    // Obtener la categoría actual mediante AJAX
    $.post('obtener_categoria_actual.php', function (data) {
        console.log(data); 
        // Establecemos la categoría actual como el valor seleccionado en el select
        $('#categoria').val(data);

        // Emite el evento 'change' en el elemento #categoria
        $('#categoria').change();

        // Luego de obtener la categoría actual, cargar las opciones del catálogo
        cargarOpcionesCatalogo();
        
        // Si tienes una categoría previa, cárgala
        var categoria_previa = '<?php echo $categoria_previa; ?>'; // Asíncrono, por lo que PHP no puede proporcionar el valor
        if (categoria_previa !== '') {
            cargarCategoriaPrevio(categoria_previa);
        }
    });

    // Función para cargar las opciones del catálogo
    function cargarOpcionesCatalogo() {
        $.post('categorias.php').done(function (respuesta) {
            console.log(respuesta); 
            $('#categoria').html(respuesta);
        });
    }

    // Función para cargar una categoría previa
    function cargarCategoriaPrevio(categoria_previa) {
        // Seleccionar la categoría previa en el select
        $('#categoria').val(categoria_previa);

        // Emite el evento 'change' en el elemento #categoria
        $('#categoria').change();
    }

    // Manejar el evento 'change'
    $('#categoria').change(function () {
        var nuevaCategoria = $(this).val();
        // Realizar acciones según la nueva categoría seleccionada
        // Por ejemplo, puedes hacer una nueva petición AJAX para actualizar la categoría en la base de datos.
    });

    // Resto de tu código...
});



