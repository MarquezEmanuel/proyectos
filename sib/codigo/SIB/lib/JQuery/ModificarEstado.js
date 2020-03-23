/* 
 * CONTROLA LOS EVENTOS DEL FORMULARIO MODIFICAR ESTADO 
 */
$(document).ready(function () {

    /* LEE LOS CAMPOS ORIGINALES PARA VALIDAR */

    var nombre = $("#nombreEstado").val();
    var descripcion = $("#descripcion").val();

    /* REALIZA LAS VALIDACIONES, PROCESA LA PETICION Y MUESTRA EL RESULTADO */
    
    $('#btnModificarEstado').click(function (e) {
        e.preventDefault();
        var nuevoNombre = $("#nombreEstado").val();
        var nuevaDescripcion = $("#descripcion").val();
        if ((nombre === nuevoNombre) && (descripcion === nuevaDescripcion)) {
            $('<div class="alert alert-warning text-center" role="alert"> No hubo modificaciones </div>').insertBefore("#contenido");
            return false;
        } else {
            $.ajax({
                type: "POST",
                url: "procesarModificarEstado.php",
                data: $("#formModificarEstado").serialize(),
                success: function (data) {
                    $("#formulario").empty();
                    $("#formulario").html(data);
                },
                error: function () {
                    $("#formulario").empty();
                    $("#formulario").html('<div class="alert alert-danger text-center" role="alert"> Error al procesar la petición </div>');
                }
            });
            return false;
        }
    });

});