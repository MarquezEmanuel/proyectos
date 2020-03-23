<?php

/* AGREGA LA CABECERA CON EL MENU */
include_once '../conf/BDConexion.php';

/* INICIALIZA LA SESION */
session_start();

function busca(){
	$consulta = $_SESSION['buscar'];
	if($consulta != null){
		$result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $consulta);
		
		if ($result) {
    $filas = sqlsrv_has_rows($result);
    if ($filas) {
        $print = "<br>
        <table id='tb_buscar_reversas' class='table table-striped table-bordered' border='3' style='width: 100%'>
                                    <colgroup>
                                        <col style='width: 23%'/>
                                        <col style='width: 23%'/>
                                        <col style='width: 23%'/>
                                        <col style='width: 23%'/>
                                        <col style='width: 8%'/>
                                    </colgroup>
                                    <thead style='background-color:#024d85;color:white;'>
                                        <tr>
                                            <th style='display:none;'>Sucursal cuenta</th>
                                            <th style='display:none;'>Numero cuenta</th>
                                            <th style='display:none;'>Numero sucursal origen</th>
                                            <th style='display:none;'>Numero comprobante</th>
                                            <th style='display:none;'>Moneda</th>
                                            <th style='display:none;'>Supervisor</th>
                                            <th style='display:none;'>Concepto</th>
                                            <th style='display:none;'>Numero secuencia</th>
                                            <th style='display:none;'>Categoria transaccion</th>
                                            <th style='display:none;'>Estado transaccion</th>
                                            <th style='display:none;'>Tipo transaccion</th>
                                            <th style='display:none;'>Hora del sistema</th>
                                            <th>Usuario</th>
                                            <th>Fecha Transaccion</th>
                                            <th>Monto Transaccion</th>
                                            <th>Nombre Transaccion</th>
                                            <th>Detalles</th>
                                        </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {

            $fechaTransaccion = isset($row['fechaTransaccion']) ? $row['fechaTransaccion']->format('d/m/Y') : "";
            $print = $print . "
            <tr>
                <td style='display:none;'>{$row['sucursalCuenta']}</td>
                <td style='display:none;'>{$row['numeroCuenta']}</td>
                <td style='display:none;'>{$row['numeroSucursalOrigen']}</td>
                <td style='display:none;'>{$row['numeroComprobante']}</td>
                <td style='display:none;'>{$row['moneda']}</td>
                <td style='display:none;'>{$row['supervisor']}</td>
                <td style='display:none;'>{$row['concepto']}</td>
                <td style='display:none;'>{$row['numeroSecuencia']}</td>
                <td style='display:none;'>{$row['categoriaTransaccion']}</td>
                <td style='display:none;'>{$row['estadoTransaccion']}</td>
                <td style='display:none;'>{$row['tipoTransaccion']}</td>
                <td style='display:none;'>{$row['horaSistema']}</td>
                <td>{$row['usuario']}</td>
                <td>{$fechaTransaccion}</td>
                <td>{$row['montoTransaccion2']}</td>
                <td>{$row['nombreTransaccion']}</td>

                <td class='text-center' title='Ir a ver detalles de la Reversa'>
                    <button class='btn btn-sm btn-outline-info'> 
                        <img src='/lib/img/SHOW.png' class='detallesReversas' name='{$row['id']}' width='18' height='18' > 
                    </button>
                </td>
            </tr>";
        }
        $print = $print . "</tbody></table>
        ";
    }  else {
        // SE EJECUTO LA CONSULTA Y NO SE ENCONTRARON RESULTADOS
        $print = '<br><div class="alert alert-warning text-center" role="alert"> No se encontraron resultados para el filtro ingresado</div>';
    }
}
echo $print;
	}
}

require_once './menuSucursal.php';
?>

<div class="card-header">
    <div id="contenido">
        <h3 class="text-center"><u>Reversas</u></h3>
        <br>
        <div id="centro" class="container">
            <form id="formBuscarReversas" name="formBuscarReversas" method="POST">
                <div class="row">
                    <div class="col">
                        <label class="mr-sm-2">Usuario:</label> 
                        <input type="text" class="form-control" 
                               id="usuario" name="usuario" 
                               pattern="[A-Za-zÁÉÍÚÓáéíúó ]{0,100}"
                               placeholder="Usuario"
                               title="Usuario">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Nombre Transaccion:</label> 
                        <input type="text" class="form-control" 
                               id="nombre" name="nombre" 
                               pattern="[A-Za-zÁÉÍÚÓáéíúó ]{0,100}"
                               placeholder="Nombre de Transaccion"
                               title="Nombre">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Fecha Inicio:</label> 
                        <input type="date" class="form-control" 
                               id="fechaInicio" name="fechaInicio"
                               title="Fecha de Inicio">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Fecha Fin:</label> 
                        <input type="date" class="form-control" 
                               id="fechaFin" name="fechaFin" 
                               placeholder="DD/MM/AAAA" title="Fecha Fin">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col">
                        <div class="text-center">
                            <input type="submit" class="btn btn-dark" id="btnBuscarReversas" name="btnBuscarReversas" value="Buscar" class="btn btn-bsc mt-4">
                            &nbsp;
                            <a href="inicioSucursal.php"><input type="button" class="btn btn-dark" id="" name="" value="Cancelar"></a>
                            &nbsp;
                            <a href="formReversas.php"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div id="contenido2" name="contenido2">
	<?php
        echo busca();
	?>
	</div>
</div>
<div class="modal fade" id="mdCargando" tabindex="0" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" aria-hidden="false" style="center">
        <div class="modal-dialog modal-lg">
                <div class="text-center">
				<br><br><br><br><br><br><br><br><br><br><br><br>
					<img src="../../lib/img/cargandoGSUC.gif" class="img-fluid" alt="Responsive image" background="" width="250" height="250">
                </div>
        </div>
</div>
</body>
<script>
$(document).ready(function () {
	
	$('#tb_buscar_reversas').DataTable({
                    dom: 'Brtip',
                    responsive: true,
                    scrollX: true,
                    pageLength: 15,
                    buttons: [
                        {   extend: 'excelHtml5',
                            title: 'Reversas'
                        },
                    ],
                    language: {url: "../../lib/js/Spanish.json"
                    }
                });
    /* CARGA EL RESULTADO DE LA BUSQUEDA EN EL CONTENIDO 2 */
    
    $("#contenido").on("click", "#btnBuscarReversas", function () {
        $.ajax({
            type: "POST",
            url: "procesarBuscarReversas.php",
            data: $("#formBuscarReversas").serialize(),
			beforeSend: function() {
					$('#mdCargando').modal({show: true, backdrop: 'static'});
				},
            success: function (data) {
                $("#contenido2").html(data);
                $('#tb_buscar_reversas').DataTable({
                    dom: 'Brtip',
                    responsive: true,
                    scrollX: true,
                    pageLength: 15,
                    buttons: [
                        {   extend: 'excelHtml5',
                            title: 'Reversas'
                        },
                    ],
                    language: {url: "/lib/js/Spanish.json"
                    }
                });
            },
			complete: function() {
					setTimeout(function(){
						$('#mdCargando').modal('hide');
					},1000)		
				},
            error: function () {
                $("#contenido2").html('<div class="alert alert-danger text-center" role="alert"> Error al procesar la petición </div>');
            }
        });
        return false;
    });
    
    /* CARGA EL FORMULARIO DE DETALLES EN EL DIV CONTENIDO2 */
    
    $("#contenido2").on("click", "img.detallesReversas", function () {
         var idcanje = $(this).attr('name');
         $.ajax({
            type: "POST",
            url: "formDetallesReversas.php",
            data: "seleccionado="+idcanje,
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
         var idcanje = $(this).attr('name');
         $.ajax({
            type: "POST",
            url: "formDetallesReversas.php",
            data: "seleccionado="+idcanje,
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
</script>
</html>

