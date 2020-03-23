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
                                            <th style='display:none;'>Marca</th>
                                            <th style='display:none;'>Cuenta Tarjeta</th>
                                            <th style='display:none;'>Nombre</th>
                                            <th style='display:none;'>Cuenta Banco</th>
                                            <th>Sucursal</th>
                                            <th>Tipo de Cuenta</th>
                                            <th>Tipo de Debito</th>
                                            <th>Saldo en Pesos</th>
                                            <th>Minimo en Pesos</th>
                                            <th style='display:none;'>Saldo en Dolares</th>
                                            <th>Fecha de Vencimiento</th>
                                            <th style='display:none;'>Cobranzas So</th>
                                            <th style='display:none;'>Cobranzas Tanque SFB</th>
                                            <th style='display:none;'>Fecha de Pago Tanque SFB</th>
                                            <th style='display:none;'>Cobranzas Reafa</th>
                                            <th style='display:none;'>Fecha Pago Reafa</th>
                                            <th style='display:none;'>Cliente</th>
                                            <th style='display:none;'>Saldo Cuentas SFB</th>
                                            <th style='display:none;'>Bloqueo</th>
                                            <th>Detalles</th>
                                        </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $nombre = utf8_encode($row['nombre']);
            $fechaVencimiento = isset($row['fechaVencimiento2']) ? $row['fechaVencimiento2']->format('d/m/Y') : "";
            $print = $print . "
            <tr>
                <td style='display:none;'>{$row['marca']}</td>
                <td style='display:none;'>{$row['cuentaTarjeta']}</td>
                <td style='display:none;'>{$nombre}</td>
                <td style='display:none;'>{$row['cuentaBanco']}</td>
                <td>{$row['sucursalCuentaBanco']}</td>
                <td>{$row['tipoCuenta']}</td>
                <td>{$row['tipoDebito']}</td>
                <td>{$row['saldoPesos2']}</td>
                <td>{$row['minimoPesos2']}</td>
                <td style='display:none;'>{$row['saldoDolares2']}</td>
                <td>{$fechaVencimiento}</td>
                <td style='display:none;'>{$row['cobranzasSo2']}</td>
                <td style='display:none;'>{$row['cobranzasTanqueSFB2']}</td>
                <td style='display:none;'>{$row['fechaPagoTanqueSFB']}</td>
                <td style='display:none;'>{$row['cobranzasReafa2']}</td>
                <td style='display:none;'>{$row['fechaPagoReafa']}</td>
                <td style='display:none;'>{$row['cliente']}</td>
                <td style='display:none;'>{$row['saldoCuentaSFB2']}</td>
                <td style='display:none;'>{$row['bloqueo2']}</td>
                <td class='text-center' title='Ver detalles de la cobranza'>
                    <button class='btn btn-sm btn-outline-info'> 
                        <img src='/lib/img/SHOW.png' class='detallesCobranzasTC' name='{$row['id']}' width='18' height='18' > 
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
        <h3 class="text-center"><u>Cobranzas Tarjeta de Credito</u></h3>
        <div id="centro" class="container">
            <form id="formBuscarCobranzasTC" name="formBuscarCobranzasTC" method="POST">
                <div class="row">
                    <div class="col">
                        <label class="mr-sm-2">Cuenta Banco:</label> 
                        <input type="number" class="form-control" 
                               id="cuenta" name="cuenta"
                               placeholder="Numero de Cuenta">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Sucursal:</label> 
                        <input type="number" class="form-control" 
                               id="sucursal" name="sucursal"
                               placeholder="Numero de Sucursal">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Tipo Debito:</label> 
                        <input type="text" class="form-control" 
                               id="debito" name="debito"
                               placeholder="Tipo de Debito">
                    </div>
                </div>
				<hr />
                <br>
                <div class="row">
                    <div class="col">
                        <label class="mr-sm-2">Saldos en pesos:</label> 
                        <input type="number" class="form-control" 
                               id="saldo" name="saldo"
                               placeholder="Saldo en pesos">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Saldos en pesos:</label> <br>
                        <input type="radio" name="signoSaldo" value="<"> <label class="mr-sm-2">Menor</label>
                        <input type="radio" name="signoSaldo" value=">"> <label class="mr-sm-2">Mayor</label>
                        <input type="radio" name="signoSaldo" value="=" checked="checked"> <label class="mr-sm-2">Igual</label>
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Minimo:</label> 
                        <input type="number" class="form-control" 
                               id="minimo" name="minimo"
                               placeholder="Monto Minimo">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Minimo:</label> <br>
                        <input type="radio" name="signoMinimo" value="<"> <label class="mr-sm-2">Menor</label>
                        <input type="radio" name="signoMinimo" value=">"> <label class="mr-sm-2">Mayor</label>
                        <input type="radio" name="signoMinimo" value="=" checked="checked"> <label class="mr-sm-2">Igual</label>
                    </div>
                </div>
				<hr />
                <br>
				<div class="row">
				<div class="col">
					</div>
                    <div class="col">
                        <label class="mr-sm-2">Cobranzas Tanque SFB:</label> 
                        <input type="number" class="form-control" 
                               id="cobranzasReafa" name="cobranzasReafa"
                               placeholder="Cobranzas Tanque SFB">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Cobranzas Tanque SFB:</label> <br>
                        <input type="radio" name="signoCobranzasReafa" value="<"> <label class="mr-sm-2">Menor</label>
                        <input type="radio" name="signoCobranzasReafa" value=">"> <label class="mr-sm-2">Mayor</label>
                        <input type="radio" name="signoCobranzasReafa" value="=" checked="checked"> <label class="mr-sm-2">Igual</label>
                    </div>
					<div class="col">
					</div>
                </div>
				<hr />
                <div class="row">
                    <div class="col">
                        <div class="text-center">
                            <input type="submit" class="btn btn-dark" id="btnBuscarCobranzasTC" name="btnBuscarCobranzasTC" value="Buscar" class="btn btn-bsc mt-4">
                            &nbsp;
                            <a href="cobranzasTC.php"><input type="button" class="btn btn-dark" id="" name="" value="Cancelar"></a>
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
	
	$('#tb_buscar_cobranzasTC').DataTable({
                    dom: 'Brtip',
                    responsive: true,
                    scrollX: true,
                    pageLength: 15,
                    buttons: [
                        {   extend: 'excelHtml5',
                            title: 'Cobranzas Tarjeta de Credito'
                        },
                    ],
                    language: {url: "/lib/js/Spanish.json"
                    }
                });
    /* CARGA EL RESULTADO DE LA BUSQUEDA EN EL CONTENIDO 2 */
    
    $("#contenido").on("click", "#btnBuscarCobranzasTC", function () {
        $.ajax({
            type: "POST",
            url: "procesarBuscarCobranzasTC.php",
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
                            title: 'Cobranzas Tarjeta de Credito'
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
    
    /* CARGA EL FORMULARIO DE DETALLES EN EL DIV CONTENIDO2 */
    
    $("#contenido2").on("click", "img.detallesCobranzasTC", function () {
         var idcuotas = $(this).attr('name');
         $.ajax({
            type: "POST",
            url: "formDetallesCobranzasTC.php",
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

