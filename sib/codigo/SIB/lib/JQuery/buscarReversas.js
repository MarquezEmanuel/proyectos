/* 
 * CONTROLA LOS EVENTOS DEL FORMULARIO BUSCAR GARANTIA 
 */
$(document).ready(function () {

    /* CARGA EL RESULTADO DE LA BUSQUEDA DE GARANTIA EN EL CONTENIDO 2 */

    $("#contenido").on("click", "#btnBuscarReversas", function () {
        $.ajax({
            type: "POST",
            url: "procesarBuscarReversas.php",
            data: $("#formBuscarReversas").serialize(),
            success: function (data) {
                $("#contenido2").html(data);
                $('#tb_buscar_reversas').DataTable({
                    dom: 'Brtip',
                    responsive: true,
                    scrollX: true,
                    pageLength: 15,
                    buttons: [
                        {extend: 'excelHtml5',
                            title: 'Reversas'
                        },
                        {extend: 'pdfHtml5',
                            title: 'Reversas',
                            orientation: 'landscape',
                            pageSize: 'LEGAL',
                            text: 'PDF',
                            exportOptions: {columns: [0, 1, 2, 3, 5, 7, 9, 12, 13, 14, 15]}

                        },
                        {extend: 'print',
                            title: 'Reversas'
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

    $("#contenido2").on("click", "img.detallesReversas", function () {
        var idcuenta = $(this).attr('name');
        $.ajax({
            type: "POST",
            url: "formDetallesReversas.php",
            data: "seleccionado=" + idcuenta,
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

    $("#contenido").on("click", "img.detallesReversas2", function () {
        var idcuenta = $(this).attr('name');
        $.ajax({
            type: "POST",
            url: "formDetallesReversas.php",
            data: "seleccionado=" + idcuenta,
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

    $("#formGReversas").submit(function (e) {
        e.preventDefault();
        var inicio = $("#fechaInicioInforme").val();
        var fin = $("#fechaFinInforme").val();
        if (inicio !== '' && fin !== '') {
            google.charts.load('current', {'packages': ['corechart']});
            google.charts.setOnLoadCallback(drawChart);
            function drawChart() {
                var jsonData = $.ajax({
                    type: "POST",
                    url: "informacionEstadistica.php",
                    dataType: "json",
                    data: $("#formGReversas").serialize(),
                    async: false
                }).responseText;
                if (jsonData === 'null') {
                    $("#grafico").html('<div class="alert alert-warning text-center" role="alert"> No se obtuvieron resultados </div>');
                } else {
                    var obj = window.JSON.parse(jsonData);
                    var data = google.visualization.arrayToDataTable(obj);
                    var options = {
                        title: 'Cantidad de reversas por usuario',
                        chartArea: {width: "60%", height: "60%"},
                        height: 500,
                        width: 700,
                        isStacked: true
                    };
                    var chart = new google.visualization.BarChart(document.getElementById('grafico'));
                    chart.draw(data, options);
                    $('#modalReversas').modal({});
                }
            }

        } else {
            $("#grafico").html('<div class="alert alert-warning text-center" role="alert"> Indique ambas fechas </div>');
        }
    });

    $("#btnGReversas").click(function () {
        $('#modalReversas').modal({});
    });


});



