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
        <table id='tb_buscar_movimientos' class='table table-striped table-bordered' border='3' style='width: 100%'>
                                    <colgroup>
                                        <col style='width: 18%'/>
                                        <col style='width: 18%'/>
                                        <col style='width: 18%'/>
                                        <col style='width: 18%'/>
                                        <col style='width: 18%'/>
                                        <col style='width: 10%'/>
                                    </colgroup>
                                    <thead style='background-color:#024d85;color:white;'>
                                        <tr>
                                            <th style='display:none;'>Tipo</th>
                                            <th style='display:none;'>Concepto</th>
                                            <th style='display:none;'>Codigo Sucursal</th>
                                            <th>Numero de Cuenta</th>
                                            <th style='display:none;'>Digito Verificador</th>
                                            <th>Codigo de Moneda</th>
                                            <th>Usuario</th>
                                            <th style='display:none;'>Nombre Usuario</th>
                                            <th style='display:none;'>Fecha Valor</th>
                                            <th>Monto Origen</th>
                                            <th>Monto en Pesos</th>
                                            <th>Detalles</th>
                                        </tr>
            </thead>
        <tbody>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {

            $fechaValor = isset($row['fechaValor']) ? $row['fechaValor']->format('d/m/Y') : "";
            $print = $print . "
            <tr>
                <td style='display:none;'>{$row['tipo']}</td>
                <td style='display:none;'>{$row['concepto']}</td>
                <td style='display:none;'>{$row['codigoSucursal']}</td>
                <td>{$row['numeroCuenta']}</td>
                <td style='display:none;'>{$row['digitoVerificador']}</td>
                <td>{$row['codigoMoneda']}</td>
                <td>{$row['codigoUsuario']}</td>
                <td style='display:none;'>{$row['nombreUsuario']}</td>
                <td style='display:none;'>{$fechaValor}</td>
                <td>{$row['montoOrigen2']}</td>
                <td>{$row['montoPesos2']}</td>

                <td class='text-center' title='Ir a ver detalles de los Movimientos'>
                    <button class='btn btn-sm btn-outline-info'> 
                        <img src='/lib/img/SHOW.png' class='detallesMovimientos' name='{$row['id']}' width='18' height='18' > 
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
        <h3 class="text-center"><u>Movimientos Sin Depositantes</u></h3>
        <br>
        <div id="centro" class="container">
            <form id="formBuscarMovimientos" name="formBuscarMovimientos" method="POST">
                <div class="row">
                    <div class="col">
                        <label class="mr-sm-2">Sucursal:</label> 
                        <input type="number" class="form-control" 
                               id="sucursal" name="sucursal"
                               placeholder="sucursal" 
                               title="sucursal">
                    </div>
                    <div class="col">
                        <label class="mr-sm-2">Tipo de Movimiento:</label> 
                        <input type="text" class="form-control" 
                               id="movimiento" name="movimiento" 
                               pattern="[A-Za-zÁÉÍÚÓáéíúó ]{0,100}"
                               placeholder="Tipo de Movimientos"
                               title="Movimiento">
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
                            <input type="submit" class="btn btn-dark" id="btnBuscarMovimientos" name="btnBuscarMovimientos" value="Buscar" class="btn btn-bsc mt-4">
                            &nbsp;
                            <a href="buscarMovimientosSinDepositantes.php"><input type="button" class="btn btn-dark" id="" name="" value="Cancelar"></a>
                            &nbsp;
                            <a href="movimientosSinDepositantes.php"><input type="button" class="btn btn-dark" id="" name="" value="Volver"></a>
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
	
	$('#tb_buscar_movimientos').DataTable({
                    dom: 'Brtip',
                    responsive: true,
                    scrollX: true,
                    pageLength: 15,
                    buttons: [
                        {   extend: 'excelHtml5',
                            title: 'Movimientos Sin Depositantes'
                        },
                    ],
                    language: {url: "../../lib/js/Spanish.json"
                    }
                });
    /* CARGA EL RESULTADO DE LA BUSQUEDA EN EL CONTENIDO 2 */
    
    $("#contenido").on("click", "#btnBuscarMovimientos", function () {
        $.ajax({
            type: "POST",
            url: "procesarBuscarMovimientosSinDepositantes.php",
            data: $("#formBuscarMovimientos").serialize(),
			beforeSend: function() {
					$('#mdCargando').modal({show: true, backdrop: 'static'});
				},
            success: function (data) {
                $("#contenido2").html(data);
                $('#tb_buscar_movimientos').DataTable({
                    dom: 'Brtip',
                    responsive: true,
                    scrollX: true,
                    pageLength: 15,
                    buttons: [
                        {   extend: 'excelHtml5',
                            title: 'Movimientos Sin Depositantes'
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
    
    $("#contenido2").on("click", "img.detallesMovimientos", function () {
         var idcanje = $(this).attr('name');
         $.ajax({
            type: "POST",
            url: "formDetallesMovimientos.php",
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
    
    $("#contenido").on("click", "img.detallesMovimientos2", function () {
         var idcanje = $(this).attr('name');
         $.ajax({
            type: "POST",
            url: "formDetallesMovimientos.php",
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
	
	
	
});
</script>
</html>



