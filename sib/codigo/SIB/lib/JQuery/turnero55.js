/* 
 * CONTROLA LOS EVENTOS DEL FORMULARIO BUSCAR GARANTIA 
 */
$(document).ready(function () {
    
    /* CARGA EL FORMULARIO DE DETALLES DE GARANTIA EN EL DIV CONTENIDO */
    
    $("#contenido").on("click", "img.atencion", function () {
         var idcuenta = $(this).attr('name');
         $.ajax({
            type: "POST",
            url: "formDetallesAtencion55.php",
            data: "seleccionado="+idcuenta,
            success: function (data) {
                $("#contenido").empty();
                $("#contenido2").empty();
                $("#contenido").html(data);
            },
            error: function () {
                $("#contenido").empty();
                $("#contenido2").html('<div class="alert alert-danger text-center" role="alert"> Error al procesar la petición </div>');
            }
        });
    });
    
    /* CARGA EL FORMULARIO DE DETALLES DE GARANTIA EN EL DIV CONTENIDO */
    
    $("#contenido").on("click", "img.espera", function () {
         var idcuenta = $(this).attr('name');
         $.ajax({
            type: "POST",
            url: "formDetallesEspera55.php",
            data: "seleccionado="+idcuenta,
            success: function (data) {
                $("#contenido").empty();
                $("#contenido2").empty();
                $("#contenido").html(data);
            },
            error: function () {
                $("#contenido").empty();
                $("#contenido2").html('<div class="alert alert-danger text-center" role="alert"> Error al procesar la petición </div>');
            }
        });
    });
});