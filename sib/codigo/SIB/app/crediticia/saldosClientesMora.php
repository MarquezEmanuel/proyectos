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
        <table id='tb_buscar_saldosMora' class='table table-striped table-bordered' border='3' style='width: 100%'>
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
                                            <th style='display:none;'>Numero de Cliente</th>
                                            <th style='display:none;'>CUIT</th>
                                            <th style='display:none;'>Documento</th>
                                            <th style='display:none;'>Nombre de Cliente</th>
                                            <th>Sucursal</th>
                                            <th style='display:none;'>Cartera</th>
                                            <th>Dias de Atraso</th>
                                            <th>Producto Mayor Atraso</th>
                                            <th>Monto Total</th>
                                            <th style='display:none;'>Deuda Vencida Total</th>
                                            <th style='display:none;'>Monto Exigible</th>
                                            <th>MME</th>
                                            <th style='display:none;'>Fallecido</th>
                                            <th style='display:none;'>Confidencial</th>
                                            <th style='display:none;'>Agencia</th>
                                            <th style='display:none;'>Etapa</th>
                                            <th style='display:none;'>Fecha Alta Etapa</th>
                                            <th style='display:none;'>Situacion BCRA</th>
                                            <th style='display:none;'>Conyuge</th>
                                            <th style='display:none;'>Organismo</th>
                                            <th style='display:none;'>Empresa Haberes</th>
                                            <th>Tipo de Gestion</th>
                                            <th style='display:none;'>Cantidad de Cuentas</th>
                                            <th style='display:none;'>Saldo de Cuentas</th>
                                            <th>Detalles</th>
                                        </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $nombre = utf8_encode($row['nombre']);
            $conyuge = utf8_encode($row['conyuge']);
            $fechaAltaEtapa = isset($row['fechaAltaEtapa']) ? $row['fechaAltaEtapa']->format('d/m/Y') : "";
            $print = $print . "
            <tr>
                <td style='display:none;'>{$row['numeroCliente']}</td>
                <td style='display:none;'>{$row['numeroCuit']}</td>
                <td style='display:none;'>{$row['numeroDocumento']}</td>
                <td style='display:none;'>{$nombre}</td>
                <td>{$row['sucursal']}</td>
                <td style='display:none;'>{$row['cartera']}</td>
                <td>{$row['diasAtraso']}</td>
                <td>{$row['productoMayorAtraso']}</td>
                <td>{$row['montoTotal2']}</td>
                <td style='display:none;'>{$row['deudaVencidaTotal2']}</td>
                <td style='display:none;'>{$row['montoExigible2']}</td>
                <td>{$row['mme2']}</td>
                <td style='display:none;'>{$row['fallecido']}</td>
                <td style='display:none;'>{$row['confidencial']}</td>
                <td style='display:none;'>{$row['agencia']}</td>
                <td style='display:none;'>{$row['etapa']}</td>
                <td style='display:none;'>{$fechaAltaEtapa}</td>
                <td style='display:none;'>{$row['situacionBCRA']}</td>
                <td style='display:none;'>{$conyuge}</td>
                <td style='display:none;'>{$row['organismo']}</td>
                <td style='display:none;'>{$row['empresaHaberes']}</td>
                <td>{$row['tipoGestion']}</td>
                <td style='display:none;'>{$row['cantidadCuentas']}</td>
                <td style='display:none;'>{$row['saldoCuentas2']}</td>
                <td class='text-center' title='Ver detalles de el saldo en mora'>
                    <button class='btn btn-sm btn-outline-info'> 
                        <img src='/lib/img/SHOW.png' class='detallesSaldosMora' name='{$row['id']}' width='18' height='18' > 
                    </button>
                </td>
            </tr>";
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
        <h3 class="text-center"><u>Saldos de Clientes en Mora</u></h3>
        <br>
        <div id="centro" class="container">
            <form id="formBuscarSaldosMora" name="formBuscarSaldosMora" method="POST">
                <div class="row">
                    <div class="col">
                        <label class="mr-sm-2">Documento:</label> 
                        <input type="number" class="form-control" 
                               id="documento" name="documento"
                               placeholder="Numero de Documento">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Sucursal:</label> 
                        <input type="number" class="form-control" 
                               id="sucursal" name="sucursal"
                               placeholder="Numero de Sucursal">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Cartera:</label> 
                        <input type="number" class="form-control" 
                               id="cartera" name="cartera"
                               placeholder="Numero de Cartera">
                    </div>
                </div>
                <hr />
                <div class="row">
                    <div class="col">
                        <label class="mr-sm-2">Dias de Atraso:</label> 
                        <input type="number" class="form-control" 
                               id="atraso" name="atraso"
                               placeholder="Dias de Atraso">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Dias de Atraso:</label> <br>
                        <input type="radio" name="signoAtraso" value="<"> <label class="mr-sm-2">Menor</label>
                        <input type="radio" name="signoAtraso" value=">"> <label class="mr-sm-2">Mayor</label>
                        <input type="radio" name="signoAtraso" value="=" checked="checked"> <label class="mr-sm-2">Igual</label>
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Monto Total:</label> 
                        <input type="number" class="form-control" 
                               id="monto" name="monto"
                               placeholder="Monto">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Monto Total:</label> <br>
                        <input type="radio" name="signoMonto" value="<"> <label class="mr-sm-2">Menor</label>
                        <input type="radio" name="signoMonto" value=">"> <label class="mr-sm-2">Mayor</label>
                        <input type="radio" name="signoMonto" value="=" checked="checked"> <label class="mr-sm-2">Igual</label>
                    </div>
                </div>
                <hr />
				<div class="row">
				    <div class="col">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Saldo en cuenta:</label> 
                        <input type="number" class="form-control" 
                               id="saldo" name="saldo"
                               placeholder="Saldo en la cuenta">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Saldo en cuenta:</label> <br>
                        <input type="radio" name="signoSaldo" value="<"> <label class="mr-sm-2">Menor</label>
                        <input type="radio" name="signoSaldo" value=">"> <label class="mr-sm-2">Mayor</label>
                        <input type="radio" name="signoSaldo" value="=" checked="checked"> <label class="mr-sm-2">Igual</label>
                    </div>
                    <div class="col">
                    </div>
                </div>
                <hr />
                <div class="row">
                    <div class="col">
                        <div class="text-center">
                            <input type="submit" class="btn btn-dark" id="btnBuscarSaldosMora" name="btnBuscarSaldosMora" value="Buscar" class="btn btn-bsc mt-4">
                            &nbsp;
                            <a href="saldosClientesMora.php"><input type="button" class="btn btn-dark" id="" name="" value="Cancelar"></a>
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
</body>
<script type="text/javascript" charset="utf8">
$(document).ready(function () {
	
	$('#tb_buscar_saldosMora').DataTable({
                    dom: 'Brtip',
                    responsive: true,
                    scrollX: true,
                    pageLength: 15,
                    buttons: [
                        {   extend: 'excelHtml5',
                            title: 'Saldos de Clientes en Mora'
                        },
                    ],
                    language: {url: "/lib/js/Spanish.json"
                    }
                });
    /* CARGA EL RESULTADO DE LA BUSQUEDA EN EL CONTENIDO 2 */
    
    $("#contenido").on("click", "#btnBuscarSaldosMora", function () {
        $.ajax({
            type: "POST",
            url: "procesarBuscarSaldosMora.php",
            data: $("#formBuscarSaldosMora").serialize(),
			beforeSend: function() {
					$('#mdProcesando').modal({show: true, backdrop: 'static'});
				},
            success: function (data) {
                $("#contenido2").html(data);
                $('#tb_buscar_saldosMora').DataTable({
                    dom: 'Brtip',
                    responsive: true,
                    scrollX: true,
                    pageLength: 15,
                    buttons: [
                        {   extend: 'excelHtml5',
                            title: 'Saldos de Clientes en Mora'
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
            error: function (data) {
				console.log(data);
                $("#contenido2").html('<div class="alert alert-danger text-center" role="alert"> Error al procesar la petición </div>');
            }
        });
        return false;
    });
    
    /* CARGA EL FORMULARIO DE DETALLES EN EL DIV CONTENIDO2 */
    
    $("#contenido2").on("click", "img.detallesSaldosMora", function () {
         var idcuotas = $(this).attr('name');
         $.ajax({
            type: "POST",
            url: "formDetallesSaldosMora.php",
            data: "seleccionado="+idcuotas,
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

</script>
</html>

