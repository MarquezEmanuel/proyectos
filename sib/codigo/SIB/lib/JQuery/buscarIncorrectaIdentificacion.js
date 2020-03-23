/* 
 * CONTROLA LOS EVENTOS DEL FORMULARIO BUSCAR GARANTIA 
 */
$(document).ready(function () {

    /* CARGA EL RESULTADO DE LA BUSQUEDA DE GARANTIA EN EL CONTENIDO 2 */

    $("#contenido").on("click", "#btnBuscarIncorrectaIdentificacion", function () {
        $.ajax({
            type: "POST",
            url: "procesarBuscarIncorrectaIdentificacion.php",
            data: $("#formBuscarIncorrectaIdentificacion").serialize(),
            success: function (data) {
                $("#contenido2").html(data);
                $('#tb_buscar_incorrecta').DataTable({
                    dom: 'Brtip',
                    responsive: true,
                    scrollX: true,
                    pageLength: 15,
                    buttons: [
                        {extend: 'excelHtml5',
                            title: 'Incorrecta identificacion de clientes'
                        },
                        {extend: 'pdfHtml5',
                            title: 'Incorrecta identificacion de clientes',
                            orientation: 'landscape',
                            pageSize: 'LEGAL',
                            text: 'PDF',
                            exportOptions: {columns: [0, 2, 5, 6, 8, 9, 10, 11, 13, 15, 16, 17]}

                        },
                        {extend: 'print',
                            title: 'Incorrecta identificacion de clientes'
                        },
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

    /* CARGA EL FORMULARIO DE DETALLES DE GARANTIA EN EL DIV CONTENIDO */

    $("#contenido2").on("click", "img.detallesIncorrecta", function () {
        var idcuenta = $(this).attr('name');
        $.ajax({
            type: "POST",
            url: "formDetallesIncorrecta.php",
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

    $("#contenido").on("click", "img.detallesIncorrecta2", function () {
        var idcuenta = $(this).attr('name');
        $.ajax({
            type: "POST",
            url: "formDetallesIncorrecta.php",
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


    $("#formGIncorrectaIdentificacion").submit(function (e) {
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
                    data: $("#formGIncorrectaIdentificacion").serialize(),
                    async: false
                }).responseText;
                if (jsonData === 'null') {
                    $("#grafico").html('<div class="alert alert-warning text-center" role="alert"> No se obtuvieron resultados </div>');
                } else {
                    var obj = window.JSON.parse(jsonData);
                    var data = google.visualization.arrayToDataTable(obj);
                    var options = {
                        title: 'Cantidad de identificaciones incorrectas por usuario',
                        chartArea: {width: "60%", height: "60%"},
                        height: 500,
                        width: 700,
                        isStacked: true
                    };
                    var chart = new google.visualization.BarChart(document.getElementById('grafico'));
                    chart.draw(data, options);
                }
            }

        } else {
            $("#grafico").html('<div class="alert alert-warning text-center" role="alert"> Indique ambas fechas </div>');
        }

    });


    $("#btnGraficoIncorrecta").click(function () {
        $('#modalIncorrectaIdentificacion').modal({});
    });



});







