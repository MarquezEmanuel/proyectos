<?php
include_once '../conf/BDConexion.php';

/* INICIALIZA LA SESION */
session_start();

function busca(){
	$consulta = $_SESSION['buscar'];
	if($consulta != null){
		$result = sqlsrv_query(BDConexion::getInstancia()->getConexion(), $consulta);
		
		if ($filas) {
        $print = "<br>
        <table id='tb_buscar_cobranzasTC' class='table table-striped table-bordered' border='3' style='width: 100%'>
                                    <colgroup>
                                        <col style='width: 15%'/>
                                        <col style='width: 15%'/>
                                        <col style='width: 15%'/>
                                        <col style='width: 15%'/>
                                        <col style='width: 15%'/>
                                        <col style='width: 15%'/>
                                        <col style='width: 10%'/>
                                    </colgroup>
                                    <thead style='background-color:#07385c;color:white;'>
                                        <tr>
                                            <th>Tipo</th>
                                            <th>Numero Cuenta</th>
                                            <th>Numero de Tarjeta</th>
                                            <th>Codigo de Cliente</th>
                                            <th>Saldo Actual</th>
                                            <th>Saldo Minimo</th>
											<th style='display:none;'>Capital</th>
											<th style='display:none;'>Prestamos</th>
                                            <th style='display:none;'>Capital a Pagar</th>
                                            <th style='display:none;'>Capital Solicitado</th>
											<th style='display:none;'>Sucursal</th>
                                            <th>Detalles</th>
                                        </tr>
            </thead>
        <tbody>";
		$fila = 0;
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $print = $print . "
            <tr id='{$fila}'>
                <td>{$row['TIPO']}</td>
                <td>{$row['TNUCUENTA']}</td>
                <td>{$row['TNU_TARJE']}</td>
                <td>{$row['SCO_IDENT']}</td>
                <td>{$row['SALDO_ACTUAL2']}</td>
                <td>{$row['SALDO_MINIMO2']}</td>
                <td style='display:none;'>{$row['CAPITAL2']}</td>
                <td style='display:none;'>{$row['PRESTAMOS']}</td>
                <td style='display:none;'>{$row['CAPITAL_A_PAGAR2']}</td>
                <td style='display:none;'>{$row['CAPITAL_SOLICITADO2']}</td>
				<td style='display:none;'>{$row['SUCURSAL']}</td>
                <td class='text-center' title='Ver detalles de la cobranza'>
                    <button class='btn btn-sm btn-outline-info detalleChequePagado' name='{$fila}'> 
                        <img src='/lib/img/SHOW.png' class='detallesCobranzasTC' name='' width='18' height='18' > 
                    </button>
                </td>
            </tr>";
			$fila++;
        }
        $print = $print . "</tbody></table>
        ";
    }
echo $print;
	}
}

date_default_timezone_set('America/Argentina/Buenos_Aires');
$actual = date("Y-m-d");
$primerDia = date('Y-m-d', mktime(0,0,0, date("m"), 1, date("Y")));
/* AGREGA LA CABECERA CON EL MENU */
require_once './header.php';
?>

<div class="card-header">
    <div id="contenido">
        <h3 class="text-center"><u>Clientes Con Tarjetas y Prestamos</u></h3>
		<br>
        <div id="centro" class="container">
            <form id="formBuscarCobranzasTC" name="formBuscarCobranzasTC" method="POST">
                <div class="row">
                    <div class="col">
                        <label class="mr-sm-2">Sucursal:</label> 
                        <input type="number" class="form-control" 
                               id="sucursal" name="sucursal"
                               placeholder="Sucursal">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Cantidad de Prestamos:</label> 
                        <input type="number" class="form-control" 
                               id="prestamos" name="prestamos"
                               placeholder="Prestamos">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Cantidad de Prestamos:</label> <br>
                        <input type="radio" name="signoPrestamos" value="<"> <label class="mr-sm-2">Menor</label>
                        <input type="radio" name="signoPrestamos" value=">"> <label class="mr-sm-2">Mayor</label>
                        <input type="radio" name="signoPrestamos" value="=" checked="checked"> <label class="mr-sm-2">Igual</label>
                    </div>
					<div class="col">
                        <label class="mr-sm-2">Tarjeta:</label> 
                        <input type="text" class="form-control" 
                               id="tarjeta" name="tarjeta"
                               placeholder="Visa/Master">
                    </div>
                </div>
				<hr />
                <br>
                <div class="row">
                    <div class="col">
                        <div class="text-center">
                            <input type="submit" class="btn btn-dark" id="btnBuscar" name="btnBuscar" value="Buscar" class="btn btn-bsc mt-4">
                            &nbsp;
                            <a href="prestamos.php"><input type="button" class="btn btn-dark" id="" name="" value="Cancelar"></a>
                             &nbsp;
                             <a href="inicio.php"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a>
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
<div class="modal fade" id="mdProcesando" tabindex="0" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" aria-hidden="false" style="center">
        <div class="modal-dialog modal-lg">
                <div class="text-center">
				<br><br><br><br><br><br><br><br><br><br><br><br>
					<img src="../../lib/img/ajax-loader.gif" class="img-fluid" alt="Responsive image" background="" width="250" height="250">
                </div>
        </div>
</div>



<div class="modal fade" id="mdDetalleChequePagado" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title text-center" id="myModalLabel">DETALLES</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Tipo:</label> 
                                <div class="col">
                                    <input class="form-control" id="suc" name="suc" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Numero de Cuenta: </label> 
                                <div class="col">
                                    <input class="form-control" id="prod" name="prod" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Numero de Tarjeta: </label> 
                                <div class="col">
                                    <input class="form-control" id="moneda" name="moneda" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Codigo de cliente: </label> 
                                <div class="col">
                                    <input class="form-control" id="nombreProd" name="nombreProd" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Saldo Actual: </label> 
                                <div class="col">
                                    <input class="form-control" id="est" name="est" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Saldo Minimo: </label> 
                                <div class="col">
                                    <input class="form-control" id="fechaAlta" name="fechaAlta" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Capital: </label> 
                                <div class="col">
                                    <input class="form-control" id="cuota" name="cuota" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Prestamos: </label> 
                                <div class="col">
                                    <input class="form-control" id="fechaMCP" name="fechaMCP" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Capital a Pagar: </label> 
                                <div class="col">
                                    <input class="form-control" id="fechaAplicacion" name="fechaAplicacion" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Capital Solicitado: </label> 
                                <div class="col">
                                    <input class="form-control" id="importe" name="importe" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Sucursal: </label> 
                                <div class="col">
                                    <input class="form-control" id="codigoTrans" name="codigoTrans" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" class="btn btn-outline-secondary" data-dismiss="modal" value="Aceptar">
                        </div>
                    </div>
                </div>
            </div>
</body>
<script type="text/javascript" charset="utf8">
$(document).ready(function () {
	
	$('#tb_buscar_cobranzasTC').DataTable({
                    dom: 'Brtip',
                    responsive: true,
                    scrollX: true,
                    pageLength: 15,
                    buttons: [
                        {   extend: 'excelHtml5',
                            title: 'Clientes Con Tarjeta y Prestamos'
                        },
                    ],
                    language: {url: "/lib/js/Spanish.json"
                    }
                });
    /* CARGA EL RESULTADO DE LA BUSQUEDA EN EL CONTENIDO 2 */
    
    $("#contenido").on("click", "#btnBuscar", function () {
        $.ajax({
            type: "POST",
            url: "procesarBuscarPrestamos.php",
            data: $("#formBuscarCobranzasTC").serialize(),
			beforeSend: function() {
					$('#mdProcesando').modal({show: true, backdrop: 'static'});
			},
            success: function (data) {
                $("#contenido2").html(data);
                $('#tb_buscar_cobranzasTC').DataTable({
                    dom: 'Brtip',
                    responsive: true,
                    scrollX: true,
                    pageLength: 15,
                    buttons: [
                        {   extend: 'excelHtml5',
                            title: 'Clientes Con Tarjeta y Prestamos'
                        },
                    ],
                    language: {url: "/lib/js/Spanish.json"
                    }
                });
            },
			complete: function() {
					setTimeout(function(){
						$('#mdProcesando').modal('hide');
					},1000)		
			},
            error: function () {
                $("#contenido2").html('<div class="alert alert-danger text-center" role="alert"> Error al procesar la petición </div>');
            }
        });
        return false;
    });
    $("#contenido2").on("click", ".detalleChequePagado", function (){
                        var fila = $(this).attr('name');
                        var columnas = $('tr#' + fila).find('td');
                        $('#suc').val(columnas.eq(0).text());
                        $('#prod').val(columnas.eq(1).text());
                        $('#moneda').val(columnas.eq(2).text());
                        $('#nombreProd').val(columnas.eq(3).text());
                        $('#est').val(columnas.eq(4).text());
                        $('#fechaAlta').val(columnas.eq(5).text());
                        $('#cuota').val(columnas.eq(6).text());
                        $('#fechaMCP').val(columnas.eq(7).text());
                        $('#fechaAplicacion').val(columnas.eq(8).text());
                        $('#importe').val(columnas.eq(9).text());
                        $('#codigoTrans').val(columnas.eq(10).text());
                        $('#mdDetalleChequePagado').modal({});
                        return false;
                    });
});

</script>
</html>

