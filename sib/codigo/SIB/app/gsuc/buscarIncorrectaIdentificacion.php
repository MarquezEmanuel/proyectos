<?php
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
        <table id='tb_buscar_incorrecta' class='table table-striped table-bordered' border='3' style='width: 100%'>
                                    <colgroup>
                                        <col style='width: 23%'/>
                                        <col style='width: 23%'/>
                                        <col style='width: 23%'/>
                                        <col style='width: 23%'/>
                                        <col style='width: 8%'/>
                                    </colgroup>
                                    <thead style='background-color:#024d85;color:white;'>
                                        <tr>
                                            <th style='display:none;'>Causal</th>
                                            <th style='display:none;'>Numero de transaccion</th>
                                            <th>Nombre Transaccion</th>
                                            <th style='display:none;'>Concepto</th>
                                            <th style='display:none;'>Producto</th>
                                            <th style='display:none;'>Sucursal</th>
                                            <th style='display:none;'>Cuenta</th>
                                            <th style='display:none;'>Digito</th>
                                            <th>Nombre Depositante</th>
                                            <th>CUIL Depositante</th>
                                            <th style='display:none;'>Ordenante</th>
                                            <th style='display:none;'>CUIL Ordenante</th>
                                            <th style='display:none;'>Sucursal operacion</th>
                                            <th style='display:none;'>Usuario</th>
                                            <th style='display:none;'>Fecha</th>
                                            <th style='display:none;'>Numero de operacion</th>
                                            <th style='display:none;'>Monto</th>
                                            <th>Nombre Usuario</th>
                                            <th>Detalles</th>
                                        </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $fecha = isset($row['fecha']) ? $row['fecha']->format('d/m/Y') : "";
            $depositante = utf8_encode($row['depositante']);
            $ordenante = utf8_encode($row['ordenante']);
            $nombreUsuario = utf8_encode($row['nombreUsuario']);
            $print = $print . "
            <tr>
                <td style='display:none;'>{$row['causal']}</td>
                <td style='display:none;'>{$row['transaccion']}</td>
                <td>{$row['nombreTransaccion']}</td>
                <td style='display:none;'>{$row['concepto']}</td>
                <td style='display:none;'>{$row['producto']}</td>
                <td style='display:none;'>{$row['sucursal']}</td>
                <td style='display:none;'>{$row['cuenta']}</td>
                <td style='display:none;'>{$row['digito']}</td>
                <td>{$depositante}</td>
                <td>{$row['documentoDepositante']}</td>
                <td style='display:none;'>{$ordenante}</td>
                <td style='display:none;'>{$row['documentoOrdenante']}</td>
                <td style='display:none;'>{$row['sucursalOperacion']}</td>
                <td style='display:none;'>{$row['usuario']}</td>
                <td style='display:none;'>{$fecha}</td>
                <td style='display:none;'>{$row['numeroOperacion']}</td>
                <td style='display:none;'>{$row['monto2']}</td>
                <td>{$nombreUsuario}</td>

                <td class='text-center' title='Ir a ver detalles de alta'>
                    <button class='btn btn-sm btn-outline-info'> 
                        <img src='/lib/img/SHOW.png' class='detallesIncorrecta' name='{$row['id']}' width='18' height='18' > 
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


/* AGREGA LA CABECERA CON EL MENU */
require_once './header.php';
?>

<div class="card-header">
    <div id="contenido">
        <h3 class="text-center"><u>Incorrecta identificacion de clientes</u></h3>
        <br>
        <div id="centro" class="container">
            <form id="formBuscarIncorrectaIdentificacion" name="formBuscarIncorrectaIdentificacion" method="POST">
                <div class="row">
                    <div class="col">
                        <label class="mr-sm-2">Transaccion:</label> 
                        <input type="text" class="form-control" 
                               id="transaccion" name="transaccion" 
                               pattern="[A-Za-zÁÉÍÚÓáéíúó ]{0,100}"
                               placeholder="Nombre de Transaccion"
                               title="Transaccion">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">CUIL Depositante:</label> 
                        <input type="number" class="form-control" 
                               id="depositante" name="depositante" 
                               placeholder="CUIL depositante"
                               title="Depositante">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Fecha Inicio:</label> 
                        <input type="date" class="form-control" 
                               id="fechaInicio" name="fechaInicio"
                               placeholder="DD/MM/AAAA" title="Fecha alta">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Fecha Fin:</label> 
                        <input type="date" class="form-control" 
                                   id="fechaFin" name="fechaFin" 
                               placeholder="DD/MM/AAAA" title="Fecha reporte">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col">
                        <div class="text-center">
                            <input type="submit" class="btn btn-dark" id="btnBuscarIncorrectaIdentificacion" name="btnBuscarIncorrectaIdentificacion" value="Buscar" class="btn btn-bsc mt-4">
                            &nbsp;
                            <a href="buscarIncorrectaIdentificacion.php"><input type="button" class="btn btn-dark" id="" name="" value="Cancelar"></a>
                             &nbsp;
                             <a href="incorrectaIdentificacion.php"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a>
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
	
	$('#tb_buscar_incorrecta').DataTable({
                    dom: 'Brtip',
                    responsive: true,
                    scrollX: true,
                    pageLength: 15,
                    buttons: [
                        {   extend: 'excelHtml5',
                            title: 'Incorrecta identificacion de clientes'
                        },
                    ],
                    language: {url: "../../lib/js/Spanish.json"
                    }
                });
    /* CARGA EL RESULTADO DE LA BUSQUEDA EN EL CONTENIDO 2 */
    
    $("#contenido").on("click", "#btnBuscarIncorrectaIdentificacion", function () {
        $.ajax({
            type: "POST",
            url: "procesarBuscarIncorrectaIdentificacion.php",
            data: $("#formBuscarIncorrectaIdentificacion").serialize(),
			beforeSend: function() {
					$('#mdCargando').modal({show: true, backdrop: 'static'});
				},
            success: function (data) {
                $("#contenido2").html(data);
                $('#tb_buscar_incorrecta').DataTable({
                    dom: 'Brtip',
                    responsive: true,
                    scrollX: true,
                    pageLength: 15,
                    buttons: [
                        {   extend: 'excelHtml5',
                            title: 'Incorrecta identificacion de clientes'
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
    
    $("#contenido2").on("click", "img.detallesIncorrecta", function () {
         var idcanje = $(this).attr('name');
         $.ajax({
            type: "POST",
            url: "formDetallesIncorrecta.php",
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
    
    $("#contenido").on("click", "img.detallesIncorrecta2", function () {
         var idcanje = $(this).attr('name');
         $.ajax({
            type: "POST",
            url: "formDetallesIncorrecta.php",
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
</script>
</html>


