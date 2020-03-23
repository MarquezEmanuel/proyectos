/* 
 * CONTROLA LOS EVENTOS DEL FORMULARIO DE CONSULTA 
 */
$(document).ready(function () {

    /* CARGA EL RESULTADO DE LA CONSULTA DE GARANTIA EN EL CONTENIDO 2 */
    
    $("#contenido").on("click", "#btnConsultarGtia", function () {
        $.ajax({
            type: "POST",
            url: "procesarConsultarGarantia.php",
            data: $("#formConsultarGtia").serialize(),
            success: function (data) {
                $("#contenido2").html(data);
                $('#tb_buscar_gtia').DataTable({
                    dom: 'Bfrtip',
                    responsive: true,
                    scrollX: true,
                    buttons: [
                        'excel',
                        {extend: 'pdfHtml5',
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


});


