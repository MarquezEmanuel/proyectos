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
                                            <th>Fecha de Alta</th>
                                            <th style='display:none;'>Sucursal</th>
                                            <th style='display:none;'>Cuenta</th>
                                            <th>Producto</th>
                                            <th style='display:none;'>Moneda</th>
                                            <th style='display:none;'>Nombre de Producto</th>
                                            <th>Estudio</th>
                                            <th style='display:none;'>Nombre</th>
                                            <th style='display:none;'>CUIL</th>
                                            <th>Saldo Capital</th>
                                            <th>Deuda Total</th>
                                            <th>Fecha Etapa</th>
                                            <th>Detalles</th>
                                        </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
			$fila = 0;
			$nombreProd = utf8_encode($row['NOMBRE_PROD']);
			$nombre = utf8_encode($row['NOMBRE']);
            $print = $print . "
            <tr>
                <td>{$row['ALTA_ESTUDIO']}</td>
                <td style='display:none;'>{$row['SUC']}</td>
                <td style='display:none;'>{$row['CUENTA']}</td>
                <td>{$row['PROD']}</td>
                <td style='display:none;'>{$row['MON']}</td>
                <td style='display:none;'>{$nombreProd}</td>
                <td>{$row['ESTUDIO']}</td>
                <td style='display:none;'>{$nombre}</td>
                <td style='display:none;'>{$row['CUIL']}</td>
                <td>{$row['SDO_CAP2']}</td>
                <td>{$row['DEUDA_TOTAL2']}</td>
                <td>{$row['FECHA_ETAPA']}</td>
                <td class='text-center' title='Ver detalles de la cobranza'>
                    <button class='btn btn-sm btn-outline-info'> 
                        <img src='/lib/img/SHOW.png' class='detallesCobranzasTC' name='{$fila}' width='18' height='18' > 
                    </button>
                </td>
            </tr>";
			$fila++;
        }
        $print = $print . "</tbody></table>
        ";
    } else {
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
        <h3 class="text-center"><u>Cuentas corrientes 153 recupero</u></h3>
		<br>
        <div id="centro" class="container">
            <form id="formBuscarCobranzasTC" name="formBuscarCobranzasTC" method="POST">
                <div class="row">
                    <div class="col">
                        <label class="mr-sm-2">Numero de cliente:</label> 
                        <input type="number" class="form-control" 
                               id="cliente" name="cliente"
                               placeholder="Numero de cliente">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Producto:</label> 
                        <input type="number" class="form-control" 
                               id="producto" name="producto"
                               placeholder="Producto">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Dias Deudor:</label> 
                        <input type="number" class="form-control" 
                               id="dias" name="dias"
                               placeholder="Dias de saldo deudor">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Dias Deudor:</label> <br>
                        <input type="radio" name="signoDias" value="<"> <label class="mr-sm-2">Menor</label>
                        <input type="radio" name="signoDias" value=">"> <label class="mr-sm-2">Mayor</label>
                        <input type="radio" name="signoDias" value="=" checked="checked"> <label class="mr-sm-2">Igual</label>
                    </div>
                </div>
				<hr />
                <br>
                <div class="row">
                    <div class="col">
                        <label class="mr-sm-2">Saldo Protegido:</label> 
                        <input type="number" class="form-control" 
                               id="protegido" name="protegido"
                               placeholder="Saldo protegido">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Saldo Protegido:</label> <br>
                        <input type="radio" name="signoProtegido" value="<"> <label class="mr-sm-2">Menor</label>
                        <input type="radio" name="signoProtegido" value=">"> <label class="mr-sm-2">Mayor</label>
                        <input type="radio" name="signoProtegido" value="=" checked="checked"> <label class="mr-sm-2">Igual</label>
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Saldo Disponible:</label> 
                        <input type="number" class="form-control" 
                               id="disponible" name="disponible"
                               placeholder="Saldo disponible">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Saldo Disponible:</label> <br>
                        <input type="radio" name="signoDisponible" value="<"> <label class="mr-sm-2">Menor</label>
                        <input type="radio" name="signoDisponible" value=">"> <label class="mr-sm-2">Mayor</label>
                        <input type="radio" name="signoDisponible" value="=" checked="checked"> <label class="mr-sm-2">Igual</label>
                    </div>
                </div>
				<hr />
                <br>
                <div class="row">
                    <div class="col">
                        <div class="text-center">
                            <input type="submit" class="btn btn-dark" id="btnBuscar" name="btnBuscar" value="Buscar" class="btn btn-bsc mt-4">
                            &nbsp;
                            <a href="cuentas153.php"><input type="button" class="btn btn-dark" id="" name="" value="Cancelar"></a>
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
                                <label class="col-sm-3 col-form-label">Cliente:</label> 
                                <div class="col">
                                    <input class="form-control" id="suc" name="suc" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Cuenta: </label> 
                                <div class="col">
                                    <input class="form-control" id="cuenta" name="cuenta" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Producto: </label> 
                                <div class="col">
                                    <input class="form-control" id="prod" name="prod" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Moneda: </label> 
                                <div class="col">
                                    <input class="form-control" id="moneda" name="moneda" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Estado: </label> 
                                <div class="col">
                                    <input class="form-control" id="nombreProducto" name="nombreProducto" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Nombre: </label> 
                                <div class="col">
                                    <input class="form-control" id="est" name="est" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Saldo Total Acuerdos: </label> 
                                <div class="col">
                                    <input class="form-control" id="fechaAlta" name="fechaAlta" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Saldo Contable: </label> 
                                <div class="col">
                                    <input class="form-control" id="cuota" name="cuota" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Saldo Protegido: </label> 
                                <div class="col">
                                    <input class="form-control" id="fechaMCP" name="fechaMCP" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Saldo Disponible: </label> 
                                <div class="col">
                                    <input class="form-control" id="fechaAplicacion" name="fechaAplicacion" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Dias Saldo Deudor: </label> 
                                <div class="col">
                                    <input class="form-control" id="importe" name="importe" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Motivo de bloqueo: </label> 
                                <div class="col">
                                    <input class="form-control" id="codigoTransaccion" name="codigoTransaccion" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Usuario: </label> 
                                <div class="col">
                                    <input class="form-control" id="causa" name="causa" readonly>
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
                            title: 'Informe Cuentas Corrientes 153 Recupero'
                        },
                    ],
                    language: {url: "/lib/js/Spanish.json"
                    }
                });
    /* CARGA EL RESULTADO DE LA BUSQUEDA EN EL CONTENIDO 2 */
    
    $("#contenido").on("click", "#btnBuscar", function () {
        $.ajax({
            type: "POST",
            url: "procesarBuscarCuentas153.php",
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
                            title: 'Informe Cuentas Corrientes 153 Recupero'
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
                        $('#cuenta').val(columnas.eq(1).text());
                        $('#prod').val(columnas.eq(2).text());
                        $('#moneda').val(columnas.eq(3).text());
                        $('#nombreProducto').val(columnas.eq(4).text());
                        $('#est').val(columnas.eq(5).text());
                        $('#fechaAlta').val(columnas.eq(6).text());
                        $('#cuota').val(columnas.eq(7).text());
                        $('#fechaMCP').val(columnas.eq(8).text());
                        $('#fechaAplicacion').val(columnas.eq(9).text());
                        $('#importe').val(columnas.eq(10).text());
                        $('#codigoTransaccion').val(columnas.eq(11).text());
                        $('#causa').val(columnas.eq(12).text());
                        $('#mdDetalleChequePagado').modal({});
                        return false;
                    });
});

</script>
</html>

