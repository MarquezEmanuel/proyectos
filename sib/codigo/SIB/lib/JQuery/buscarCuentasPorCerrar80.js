/* 
 * CONTROLA LOS EVENTOS DEL FORMULARIO BUSCAR GARANTIA 
 */
$(document).ready(function () {

    /* CARGA EL RESULTADO DE LA BUSQUEDA DE GARANTIA EN EL CONTENIDO 2 */
    
    $("#contenido").on("click", "#btnBuscarCuentasPorCerrar", function () {
        $.ajax({
            type: "POST",
            url: "procesarBuscarCuentasPorCerrar80.php",
            data: $("#formBuscarCuentasPorCerrar").serialize(),
            success: function (data) {
                $("#contenido2").html(data);
                $('#tb_buscar_cuentas').DataTable({
                    dom: 'Brtip',
                    responsive: true,
                    scrollX: true,
                    pageLength: 15,
                    buttons: [
                        {   extend: 'excelHtml5',
                            title: 'Cuentas por cerrar'
                        },
                        {   extend: 'pdfHtml5',
                            title: 'Cuentas por cerrar',
                            orientation: 'landscape',
                            pageSize: 'LEGAL',
                            text: 'PDF',
                            exportOptions: {columns: [0, 1, 2, 3, 4, 5, 6, 7]}
                
                        },
                        {   extend: 'print',
                            title: 'Cuentas por cerrar'
                        },
                    ],
                    language: {url: "../../lib/js/Spanish.json"
                    }
                });
            },
            error: function () {
                $("#contenido2").html('<div class="alert alert-danger text-center" role="alert"> Error al procesar la petición </div>');
            }
        });
        return false;
    });
    
    /* CARGA EL FORMULARIO DE DETALLES DE GARANTIA EN EL DIV CONTENIDO */
    
    $("#contenido2").on("click", "img.detallesCuentasPorCerrar", function () {
         var idcuenta = $(this).attr('name');
         $.ajax({
            type: "POST",
            url: "formDetallesCuentasPorCerrar80.php",
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
    
    $("#contenido").on("click", "img.detallesCuentasPorCerrar2", function () {
         var idcuenta = $(this).attr('name');
         $.ajax({
            type: "POST",
            url: "formDetallesCuentasPorCerrar80.php",
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



