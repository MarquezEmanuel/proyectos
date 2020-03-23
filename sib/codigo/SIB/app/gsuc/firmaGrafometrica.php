<?php
//session_start();
//if (!isset($_SESSION['user'])) {
//    header('Location: index.php');
//}
include_once '../conf/BDConexion.php';

//Central de cuentacorrentistas inhabilitados ( Cuenta Correntistas o firmantes inhabilitados que deben ser notificados y proceder según corresponda, desvinculación en cuenta o cierre de la misma.) 

function saldos() {
    $sql = "SELECT  [nombreTramite] ,count(nombreTramite) cantidad FROM [bd_sib].[dbo].[3tramitesFirmaGrafometrica] GROUP BY nombreTramite ORDER BY cantidad desc";
    $result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $sql);
    $print = '';
    if ($result) {
        $filas = sqlsrv_has_rows($result);
        if ($filas) {
        $print = "<br>
        <table id='tb_buscar_cobranzasTC' class='table table-striped table-bordered' border='3' style='width: 100%'>
                                    <colgroup>
                                        <col style='width: 75%'/>
                                        <col style='width: 25%'/>
                                    </colgroup>
                                    <thead style='background-color:#07385c;color:white;'>
                                        <tr>
                                            <th>Nombre de Tramite</th>
                                            <th>Cantidad</th>
                                        </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $nombre = utf8_encode($row['nombreTramite']);
            $print = $print . "
            <tr id='{$fila}'>
                <td>{$nombre}</td>
                <td>{$row['cantidad']}</td>
            </tr>";
        }
        $print = $print . "</tbody></table>
        ";
    } else {
            $print = $print . "<tr> <td COLSPAN=2>No hay firmas grafometricas en la fecha</td></tr>";
        }
    } else {
        $print = $print . "<tr> <td COLSPAN=2>No hay firmas grafometricas en la fecha</td></tr>";
    }
    return $print;
}
date_default_timezone_set('America/Argentina/Buenos_Aires');
$actual = date("Y-m-d");

require_once './header.php';
?>

<div class="card-header">
    <div id="contenido">
        <h3 class="text-center"><u>Reporte de Firmas Grafometricas</u></h3>
        <br>
        <div id="centro" class="container">
            <form id="formBuscarCuotas" name="formBuscarCuotas" method="POST">
                <div class="row">
                    <div class="col">
                        <label class="mr-sm-2">Fecha Desde:</label> 
                        <input type="date" class="form-control" 
                               id="desde" name="desde" 
                               placeholder="DD/MM/AAAA" title="Fecha reporte">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Fecha Hasta:</label> 
                        <input type="date" class="form-control" 
                               id="hasta" name="hasta" value ="<?php echo $actual;?>"
                               placeholder="DD/MM/AAAA" title="Fecha reporte">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col">
                        <div class="text-center">
                            <input type="submit" class="btn btn-dark" id="btnBuscar" name="btnBuscar" value="Buscar" class="btn btn-bsc mt-4">
                            &nbsp;
                            <input type="button" class="btn btn-dark" id="btnGraficoIncorrecta" name="btnGraficoIncorrecta" value="Grafico">
                             &nbsp;
                             <a href="reportesTablas.php"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div id="contenido2" name="contenido2">
	<?php
        echo saldos();
	?>
	</div>
	<div class="modal fade" id="modalIncorrectaIdentificacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-center" id="myModalLabel">Firmas Grafometricas</h4>
            </div>
            <div class="modal-body">
                <div class="container" id="formulario">
                    <form id="formGIncorrectaIdentificacion" name="formGIncorrectaIdentificacion" method="POST">
                        <div class="form-row">
                            <div class="col">
                                <input type="date" class="form-control" name="fechaInicioInforme" id="fechaInicioInforme" title="Fecha de inicio">
                            </div>
                            <div class="col">
                                <input type="date" class="form-control" name="fechaFinInforme" id="fechaFinInforme" title="Fecha de fin" value ="<?php echo $actual;?>">
                            </div>
                            <input type="hidden" id="opcion" name="opcion" value="6">
                            <button type="submit" class="btn btn-outline-success" title="Generear gráfico estadístico">Generar</button>
                        </div>
                    </form>
                </div>
                <div id="grafico" class="text-center"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
</div>
</body>
<script type="text/javascript" charset="utf8" src="/lib/JQuery/diarios.js"></script>
<script type="text/javascript" charset="utf8">
$(document).ready(function () {
	
	$('#tb_buscar_cobranzasTC').DataTable({
                    dom: 'Brtip',
                    responsive: true,
                    scrollX: true,
					pageLength: 40,
                    buttons: [
                        {   extend: 'excelHtml5',
                            title: 'Reporte Tramites Firmas Grafometricas'
                        },
                    ],
                    language: {url: "/lib/js/Spanish.json"
                    }
                });
    /* CARGA EL RESULTADO DE LA BUSQUEDA EN EL CONTENIDO 2 */
    
    $("#contenido").on("click", "#btnBuscar", function () {
        $.ajax({
            type: "POST",
            url: "procesarBuscarFirmas.php",
            data: $("#formBuscarCuotas").serialize(),
            success: function (data) {
                $("#contenido2").html(data);
                $('#tb_buscar_cobranzasTC').DataTable({
                    dom: 'Brtip',
                    responsive: true,
                    scrollX: true,
					pageLength: 40,
                    buttons: [
                        {   extend: 'excelHtml5',
                            title: 'Reporte Tramites Firmas Grafometricas'
                        },
                    ],
                    language: {url: "/lib/js/Spanish.json"
                    }
                });
            },
            error: function () {
                $("#contenido2").html('<div class="alert alert-danger text-center" role="alert"> Error al procesar la peticiĂ³n </div>');
            }
        });
        return false;
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
                        title: '',
                        chartArea: {width: "80%", height: "80%"},
                        height: 800,
                        width: 750,
                        isStacked: true
                    };
                    var chart = new google.visualization.PieChart(document.getElementById('grafico'));
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

</script>
</html>



