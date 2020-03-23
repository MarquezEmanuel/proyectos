/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {



    $(".card").click(function () {
        var modulo = $(this).attr("id");
        var reporte = $(this).attr("name");
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: "./PGestor.php",
            data: "modulo=" + modulo + "&reporte=" + reporte,
            beforeSend: function () {
                $('#ModalCargando').modal({show: true, backdrop: 'static'});
            },
            success: function (data) {
                $("#resultado" + modulo).html(data);
                ocultarResultados(modulo);

                $('#tbReportes').dataTable({
                    dom: 'Bfrtip',
                    lengthChange: false,
                    ordering: false,
                    buttons: [{
                            extend: 'excelHtml5',
                            title: 'REVALIDA_REPORTES'
                        }
                    ],
                    language: {url: "../../../lib/JQuery/Spanish.json"}
                });

                google.charts.load('current', {'packages': ['corechart']});
                google.charts.setOnLoadCallback(dibujarGraficoBarras);

                google.charts.load('current', {'packages': ['corechart']});
                google.charts.setOnLoadCallback(dibujarGraficoTorta);
            },
            error: function (data) {
                console.log(data);
                var men = '<b>No se procesó la petición (Informe al administrador)</b>';
                var div = '<div class="alert alert-danger text-center" role="alert">' + men + '</div>';
                $("#resultado" + modulo).html(div);
            },
            complete: function () {
                setTimeout(function () {
                    $('#ModalCargando').modal('hide');
                }, 1000);
            }
        });

    });

    $('.resultado').on('click', '#eyeInformacionDetallada', function () {
        if ($('#informacionDetallada').is(':visible')) {
            $('#informacionDetallada').hide();
        } else {
            $('#informacionDetallada').show();
        }
    });

    function ocultarResultados(modulo) {
        $(".resultado").each(function () {
            var nombre = $(this).attr("id");
            if (nombre !== "resultado" + modulo) {
                $("#" + nombre).empty();
            }
        });
    }

    function generarDatos() {
        var longitud = ($("#tbReportes tbody tr").length > 15) ? 15 : $("#tbReportes tbody tr").length;
        var registros = [];
        registros.push(["Campo", "Total", {role: "style"}]);
        for (var i = 0; i < longitud; i++) {
            var nombre = $("#tbReportes tbody tr:eq(" + i + ")").find('td:eq(0)').text();
            var total = $("#tbReportes tbody tr:eq(" + i + ")").find('td:eq(1)').text();
            registros.push([nombre, parseInt(total, 10), "color: #1B4F72"]);
        }
        return registros;
    }

    function dibujarGraficoBarras() {
        registros = generarDatos();
        if (registros.length > 1) {
            var data = google.visualization.arrayToDataTable(registros);
            var view = new google.visualization.DataView(data);
            var options = {
                title: 'Grafico de barras',
                legend: {position: "none"},
                hAxis: {slantedText: true, slantedTextAngle: 90}
            };
            var chart = new google.visualization.ColumnChart(document.getElementById("graficoBarras"));
            chart.draw(view, options);
        } else {
            $("#informacionDetallada").hide();
            var men = '<b>No se encontraron resultados para graficar</b>';
            var div = '<div class="alert alert-warning text-center" role="alert">' + men + '</div>';
            $("#graficoBarras").html(div);
        }
    }

    function dibujarGraficoTorta() {
        registros = generarDatos();
        if (registros.length > 1) {
            var data = google.visualization.arrayToDataTable(registros);
            var view = new google.visualization.DataView(data);
            var options = {
                title: 'Grafico de torta',
                legend: {position: "none"},
                hAxis: {slantedText: true, slantedTextAngle: 90}
            };
            var chart = new google.visualization.PieChart(document.getElementById("graficoTorta"));
            chart.draw(view, options);
        } else {
            $("#informacionDetallada").hide();
            var men = '<b>No se encontraron resultados para graficar</b>';
            var div = '<div class="alert alert-warning text-center" role="alert">' + men + '</div>';
            $("#graficoTorta").html(div);
        }
    }


    $(window).resize(function () {
        dibujarGraficoBarras();
        dibujarGraficoTorta();
    });
});
