
/* 
 * CONTROLA LOS EVENTOS DEL FORMULARIO BUSCAR REPORTE 
 */
$(document).ready(function () {

    /* CARGA EL RESULTADO DE LA BUSQUEDA DE REPORTES EN EL CONTENIDO 2 */
    
    $("#contenido").on("click", "#btnBuscarCuentaComitente", function () {
        $.ajax({
            type: "POST",
            url: "procesarBuscarCuentaComitente.php",
            data: $("#formBuscarCuentaComitente").serialize(),
            success: function (data) {
                $("#contenido2").html(data);
                $('#tb_buscar_comitente').DataTable({
                    dom: 'Brtip',
                    responsive: true,
                    scrollX: true,
                    buttons: [
                        {   extend: 'excelHtml5',
                            title: 'Cuenta Comitente'
                        },
                        {   extend: 'pdfHtml5',
                            title: 'Cuenta Comitente',
                            orientation: 'landscape',
                            pageSize: 'LEGAL',
                            text: 'PDF',
                            exportOptions: {columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 15]}
                
                        }
                    ],
                    language: {url: "/lib/js/Spanish.json"
                    }
                });
            },
            error: function () {
                $("#contenido2").html('<div class="alert alert-danger text-center" role="alert"> Error al procesar la petición </div>');
            }
        });
        return false;
    });

    /* CARGA EL FORMULARIO DE MODIFICACION DE GARANTIA EN EL DIV CONTENIDO */

    $("#contenido2").on("click", "img.modificarCuentaComitente", function () {
         var idgtia = $(this).attr('name');
         $.ajax({
            type: "POST",
            url: "formModificarCuentaComitente.php",
            data: "seleccionado="+idgtia,
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
	
	/* ELIMINA EL REPORTE */

    $("#contenido2").on("click", "img.eliminarCuentaComitente", function () {
         var idgtia = $(this).attr('name');
         $.ajax({
            type: "POST",
            url: "procesarBorrarCuentaComitente.php",
            data: "seleccionado="+idgtia,
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
    
    $("#contenido2").on("click", "img.generarXML", function () {
         var idgtia = $(this).attr('name');
         $.ajax({
            type: "POST",
            url: "procesarGenerarCuentaComitente.php",
            data: "seleccionado="+idgtia,
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

